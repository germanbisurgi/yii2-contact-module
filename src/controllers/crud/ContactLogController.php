<?php
/**
 * /app/src/../runtime/giiant/49eb2de82346bc30092f584268252ed2
 *
 * @package default
 */


namespace dmstr\modules\contact\controllers\crud;

use dmstr\web\traits\AccessBehaviorTrait;

/**
 * This is the class for controller "ContactLogController".
 */
class ContactLogController extends \dmstr\modules\contact\controllers\crud\base\ContactLogController
{
    use AccessBehaviorTrait;

    public function init()
    {
        parent::init();
        $this->layout = $this->module->backendLayout;
    }
}
