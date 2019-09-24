<?php 
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use app\modules\wedatabase\forms\WEDatabaseSqlForm;
use app\utils\WEHttpClient;
use app\utils\WEJSONResponser;
use app\utils\WEParamsUtil;
use app\utils\WEStringBuilder;
use yii\web\NotFoundHttpException;

class WEDatabaseSqlAction extends Action {
    public function run() {
        $form = new WEDatabaseSqlForm();
        if(Yii::$app->request->isGet) {
            $form->setAttributes($_GET);
            if($form->dbname) {
                return $this->controller->render("dbsql", array(
                    "dbname" => $form->dbname,
                ));
            } else {
                throw new NotFoundHttpException();
            }
        } else {
            if($form->validate()) {

            } else {
                return WEJSONResponser::response(422, "表单验证未通过", $form->errors);
            }
        }
    }
}