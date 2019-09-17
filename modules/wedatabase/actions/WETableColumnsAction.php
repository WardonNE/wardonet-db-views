<?php
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use app\utils\WEParamsUtil;
use app\utils\WEHttpClient;
use app\utils\WEStringBuilder;
use app\utils\WEJSONResponser;
use app\modules\wedatabase\forms\WETableColumnsForm;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use app\utils\WECacheHelper;

class WETableColumnsAction extends Action {
    public function run() {
        $form = new WETableColumnsForm();
        $form->setAttributes(Yii::$app->request->get());
        if(Yii::$app->request->isGet) {
            if($form->validate()) {
                return $this->controller->render("columns", array(
                    "dbname" => $form->dbname,
                    "tablename" => $form->tablename,
                ));
            } else {
                throw new NotFoundHttpException();
            }
        } elseif(Yii::$app->request->isPost) {
            if(!$form->validate()) {
                return WEJSONResponer::response(422, "表单验证未通过", $form->errors);
            }
            $cache = new WECacheHelper();
            $data = $cache->get("{$form->dbname}-{$form->tablename}-columns");
            if($data !== false) {
                return WEJSONResponser::response(0, "ok(data form cache)", $data);
            }
            $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
            $builder->append(WEParamsUtil::get("serviceTableColumnsApi"));
            $builder->replaceSubString("{:dbname}", $form->dbname);
            $builder->replaceSubString("{:tablename}", $form->tablename);
            $client = new WEHttpClient($builder->toString());
            $response = $client->get();
            if($response === false) {
                return WEJSONResponser::response(1001, $client->getError(), $response);
            } 
            if($statusCode = $client->getStatusCode() == 200) {
                $response = Json::decode($response);
                if($response["code"] == 0) {
                    $cache->set("{$form->dbname}-{$form->tablename}-columns", $response["result"]);
                    return WEJSONResponser::response(0, "ok", $response["result"]);
                } else {
                    return WEJSONResponser::response(1002, "远程服务返回错误", $response["result"]);
                }
            } else {
                throw new NotFoundHttpException();
            }
        }
    }
}