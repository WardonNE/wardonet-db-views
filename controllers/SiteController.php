<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\weadmin\forms\WEAdminLoginForm;

class SiteController extends Controller {

    public $layout = '@app/views/layouts/adminLayout';

    public function actions() {
        return [
            "error" => [
                "class" => yii\web\ErrorAction::className(),
            ]
        ];
    }
    
    public function actionWelcome() {
        return $this->render('welcome');
    }
}
