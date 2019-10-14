<?php

namespace app\modules\weserver;

use app\modules\weserver\controllers\WEServerController;

/**
 * weserver module definition class
 */
class WEServerModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\weserver\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'server' => [
                'class' => WEServerController::className(),
            ],
        ];
        // custom initialization code goes here
    }
}
