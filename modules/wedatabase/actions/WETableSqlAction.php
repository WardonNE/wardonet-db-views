<?php 
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\utils\WEHttpClient;
use app\utils\WEParamsUtil;
use app\utils\WEJSONResponser;
use app\utils\WEStringBuilder;
use app\utils\WESignatureHelper;
use yii\web\NotFoundHttpException;
use app\modules\wedatabase\forms\WETableSqlForm;

class WETableSqlAction extends Action {
    public function run() {
        $form = new WETableSqlForm();
        if(Yii::$app->request->isGet) {
            $form->setAttributes(Yii::$app->request->get());
            if($form->dbname && $form->tablename) {
                return $this->controller->render("tablesql", array(
                    "dbname" => $form->dbname,
                    "tablename" => $form->tablename,
                ));
            } else {
                throw new NotFoundHttpException();
            }
        } elseif(Yii::$app->request->isPost) {  
            $form->setAttributes(Yii::$app->request->post());
            if($form->validate()) {
                $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
                $builder->append(WEParamsUtil::get("serviceQuerySQLApi"));
                $builder->replaceSubString("{:dbname}", $form->dbname);
                $builder->append("?")->append((new WESignatureHelper())->getSdk());
                $client = new WEHttpClient($builder->toString());
                $response = $client->post(array(
                    "sql" => $form->sql,
                ), false);
                if($response === false) return WEJSONResponser::response(1001, $client->getError(), $response);
                $response = Json::decode($response);
                if($client->getStatusCode() == 200) {
                    if($response["code"] == 0) {
                        return WEJSONResponser::response(0, "ok", $response["result"]);
                    } elseif($response["code"] == 1002) {
                        return WEJSONResponser::response(1002, "远程服务返回错误", $response["result"]);
                    } elseif($response["code"] == 422) {
                        return WEJSONResponser::response(1003, "远程服务表单验证未通过", $response["result"]);
                    }
                } else {
                    return new NotFoundHttpException();
                }
            } else {
                return WEJSONResponser::response(422, "表单验证未通过", $form->errors);
            }
        }
    }
}