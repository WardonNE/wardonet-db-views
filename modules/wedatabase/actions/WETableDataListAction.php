<?php
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\utils\WEHttpClient;
use app\utils\WEParamsUtil;
use app\utils\WECacheHelper;
use app\utils\WEJSONResponser;
use app\utils\WEStringBuilder;
use app\utils\WESignatureHelper;
use yii\web\NotFoundHttpException;
use app\modules\wedatabase\forms\WETableDataListForm;

class WETableDataListAction extends Action {

    public function run() {
        $form = new WETableDataListForm();
        if(Yii::$app->request->isGet) {
            $form->setAttributes(Yii::$app->request->get());
            if($form->dbname and $form->tablename) {
                return $this->controller->render("datalist", array(
                    "dbname" => $form->dbname,
                    "tablename" => $form->tablename,
                ));
            } else {
                throw new yii\web\HttpException(404);
            }
        } elseif(Yii::$app->request->isPost) {
            if($form->validate()) {
                $cache = new WECacheHelper();
                $data = $cache->get("{$form->dbname}-{$form->tablename}-data");
                if($data !== false) {
                    return WEJSONResponser::response(0, "ok(data from cache)", $data);
                }
                $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
                $builder->append(WEParamsUtil::get("serviceTableDataListApi"));
                $builder->replaceSubString("{:dbname}", $form->dbname);
                $builder->replaceSubString("{:tablename}", $form->tablename);
                $builder->append("?")->append((new WESignatureHelper())->getSdk());
                $client = new WEHttpClient($builder->toString());
                $response = $client->post(array(
                ));
                if($response === false) {
                    return WEJSONResponser::response(1001, $client->getError(), $response["result"]);
                } else {
                    if($statusCode = $client->getStatusCode() == 200) {
                        $response = Json::decode($response);
                        if($response["code"] == 0) {
                            $cache->set("{$form->dbname}-{$form->tablename}-data", $response["result"]);
                            return WEJSONResponser::response(0, "ok", $response["result"]);
                        } else {
                            return WEJSONResponser::response(1002, "远程服务返回错误信息", $response["result"]);
                        }
                    } else {
                        throw new NotFoundHttpException();
                    }
                }
            } else {
                return WEJSONResponser::response(422, "表单验证未通过", $form->errors);
            }
        }
    }
}