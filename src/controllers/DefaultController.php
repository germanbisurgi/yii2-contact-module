<?php

namespace dmstr\modules\contact\controllers;

use dmstr\modules\contact\events\MessageEvent;
use dmstr\modules\contact\models\ContactForm;
use dmstr\modules\contact\models\ContactLog;
use dmstr\modules\contact\models\ContactTemplate;
use dmstr\modules\contact\Module;
use yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * @property mixed $settings
 * @property Module $module
 */
class DefaultController extends Controller
{
    const CONTACT_FORM_ID_KEY = 'contact:formId';

    public function init()
    {
        $this->layout = $this->module->frontendLayout;
        parent::init();
    }

    /**
     * Renders the index view for the module
     *
     * @param $schema
     *
     * @return string
     * @throws HttpException
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     */
    public function actionIndex($schema)
    {
        $contactSchema = ContactTemplate::findOne(['name' => $schema]);

        if ($contactSchema === null) {
            throw new NotFoundHttpException('Page not found.');
        }

        $contactForm = new ContactForm([
            'contact_template_id' => $contactSchema->id
        ]);

        if ($contactForm->load(Yii::$app->request->post()) && $contactForm->validate()) {

            $contactLog = new ContactLog([
                'contact_template_id' => $contactSchema->id,
                'json' => $contactForm->json,
            ]);

            if (!$contactLog->save()) {
                throw new HttpException(500, 'Your message could not be sent.');
            }

            Yii::$app->session->set(self::CONTACT_FORM_ID_KEY, $contactLog->id);

            $event = new MessageEvent();
            $event->model = $contactLog;
            $this->trigger(MessageEvent::EVENT_BEFORE_MESSAGE_SENT, $event);

            if ($contactLog->sendMessage()) {
                Yii::$app->session->addFlash('success', Yii::t('contact', 'Your message was successfully sent.'));
                $this->redirect(['done', 'schema' => $schema]);

                $this->trigger(MessageEvent::EVENT_AFTER_MESSAGE_SENT, $event);
            } else {
                Yii::$app->session->addFlash('error', Yii::t('contact', 'Your message could not be sent.'));
                $this->redirect(['index', 'schema' => $schema]);

                $this->trigger(MessageEvent::EVENT_SENT_MESSAGE_ERROR, $event);
            }
        }

        return $this->render(
            'index',
            [
                'model' => $contactForm,
                'schema' => $schema,
                'schemaData' => Json::decode($contactForm->schema)
            ]
        );
    }

    public function actionDone($schema)
    {
        $model = ContactLog::findOne(Yii::$app->session->get(self::CONTACT_FORM_ID_KEY));

        if ($model === null) {
            throw new ForbiddenHttpException(Yii::t('contact', 'You are not allowed to access this page directly.'));
        }

        Yii::$app->session->remove(self::CONTACT_FORM_ID_KEY);

        return $this->render(
            'done',
            [
                'schema' => $schema,
                'model' => Json::decode($model->json, false),
            ]
        );

    }

}
