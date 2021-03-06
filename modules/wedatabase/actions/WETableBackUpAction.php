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
use app\modules\wedatabase\forms\WETableBackUpForm;

class WETableBackUpAction extends Action {
    public function run() {
        $form = new WETableBackUpForm();
        $form->setAttributes(Yii::$app->request->get());
        if(Yii::$app->request->isGet) {
            if($form->validate()) {
                return $this->controller->render("tablebackup", array(
                    "dbname" => $form->dbname,
                    "tablename" => $form->tablename,
                ));
            } else {
                throw new NotFoundHttpException();
            }
        } elseif(Yii::$app->request->isPost) {
            if($form->validate()) {
                $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
                $builder->append(WEParamsUtil::get("serviceTableDumpApi"));
                $builder->replaceSubString("{:dbname}", $form->dbname);
                $builder->replaceSubString("{:tablename}", $form->tablename);
                $builder->append("?");
                $builder->append((new WESignatureHelper())->getSdk());
                $client = new WEHttpClient($builder->toString());
                $response = $client->post(array());
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