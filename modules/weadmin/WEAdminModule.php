<?php

namespace app\modules\weadmin;

/**
 * weadmin module definition class
 */
class WEAdminModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\weadmin\controllers';

    public $defaultRoute = '/adminuser/index';
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'adminuser' => [
                'class' => 'app\modules\weadmin\controllers\WEAdminUserController',
            ],
        ];
        // custom initialization code goes here
    }
}
