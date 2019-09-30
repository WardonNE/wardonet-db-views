<?php

namespace app\modules\weadmin\controllers;

use Yii;
use yii\web\Controller;
use app\utils\WEJSONResponser;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedException;
use app\modules\weadmin\forms\WEAdminLoginForm;
use app\modules\weadmin\models\WEAdminUserModel;


/**
 * Default controller for the `weadmin` module
 */
class WEAdminUserController extends Controller {

    public $viewData = array();

    public function behaviors() {
        return array(
            "access" => array(
                "class" => AccessControl::className(),
                "only" => array("login", "index", "logout"),
                "rules" => array(
                    array("allow" => true, "actions" => array("login")),
                    array("allow" => true, "actions" => array("index","logout"), "roles" => array("@")),
                ),
            ),
        );
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $this->layout = '@app/views/layouts/adminLayout';
        return $this->render('index');
    }

    public function actionLogin() {
        $form = new WEAdminLoginForm();
        if(Yii::$app->request->isGet) {
            return $this->renderPartial('login', [
                "model" => $form,
            ]);
        } elseif(Yii::$app->request->isPost) {
            if($form->load(Yii::$app->request->post()) && $form->validate()) {
                $this->viewData["activeUser"] = $user = WEAdminUserModel::findByUsername(hash("sha512", $form["username"]));
                if(Yii::$app->user->login($user, 0)) {
                   $this->redirect("/weadmin/adminuser/index");
                } else {
                    return $this->renderPartial('login', [
                        "model" => $form,
                    ]);
                }
            } else {
                return $this->renderPartial('login', [
                    "model" => $form,
                ]);
            }
        } 
    }

    public function actionLogout() {
        if(Yii::$app->request->isPost) {
            if(Yii::$app->user->logout()) {
                return WEJSONResponser::response(0, "ok", true);
            } else {
                return WEJSONResponser::response(1001, "登出失败", false);
            }
        } else {
            throw new MethodNotAllowedException();
        }
    }
}
