<?php

namespace app\modules\wedatabase;

/**
 * wedatabase module definition class
 */
class WEDatabaseModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\wedatabase\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap["db"] = "app\modules\wedatabase\controllers\WEDatabaseController";
    }
}
