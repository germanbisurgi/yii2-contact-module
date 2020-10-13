<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace dmstr\modules\contact\models\base;

use Yii;

/**
 * This is the base-model class for table "app_dmstr_contact_template".
 *
 * @property integer $id
 * @property string $name
 * @property string $from_email
 * @property string $reply_to_email
 * @property string $to_email
 * @property string $email_subject
 * @property integer $captcha
 * @property string $form_schema
 * @property string $created_at
 * @property string $updated_at
 * @property string $aliasModel
 */
abstract class ContactTemplate extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_dmstr_contact_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'from_email', 'to_email'], 'required'],
            [['captcha'], 'integer'],
            [['form_schema'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'from_email', 'reply_to_email', 'to_email', 'email_subject'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'name' => Yii::t('models', 'Name'),
            'from_email' => Yii::t('models', 'From Email'),
            'reply_to_email' => Yii::t('models', 'Reply To Email'),
            'to_email' => Yii::t('models', 'To Email'),
            'email_subject' => Yii::t('models', 'Email Subject'),
            'captcha' => Yii::t('models', 'Captcha'),
            'form_schema' => Yii::t('models', 'Form Schema'),
            'created_at' => Yii::t('models', 'Created At'),
            'updated_at' => Yii::t('models', 'Updated At'),
        ];
    }


    
    /**
     * @inheritdoc
     * @return \dmstr\modules\contact\models\query\ContactTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \dmstr\modules\contact\models\query\ContactTemplateQuery(get_called_class());
    }


}
