<?php

namespace dmstr\modules\contact\models;

use Yii;
use \dmstr\modules\contact\models\base\ContactLog as BaseContactLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "core_dmstr_contact_log".
 */
class ContactLog extends BaseContactLog
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }
}
