<?php 
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use app\modules\wedatabase\forms\WETableListForm;
use app\utils\WEJSONResponser;
use app\utils\WEStringBuilder;
use app\utils\WEHttpClient;
use app\utils\WEParamsUtil;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class WETableListAction extends Action {
    public function run() {
        $form = new WETableListForm();
        $form->setAttributes(Yii::$app->request->get());
        if(Yii::$app->request->isGet) {
            if($form->validate()) {
                return $this->render("tablelist", array(
                    "dbname" => $form->dbname,
                ));
            } else {
                throw new NotFoundHttpException();
            }
        } elseif(Yii::$app->request->isPost) {
            if($form->validate()) {
                $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
                $builder->append(WEParamsUtil::get("serviceTableListApi"))->replaceSubString("{:dbname}", $form->dbname);
                $client = new WEHttpClient($builder->toString());
                $response = $client->get();
                if($response === false) return WEJSONResponser::response(1001, $client->getError($ch), $result);
                $response = Json::decode($response);
                if($response["code"] == 0) {
                    return WEJSONResponser::response(0, "ok", $response["result"]);
                } else {
                    return WEJSONResponser::response(1002, "远程服务返回错误信息", $response["result"]);
                }
            } else {
                return WEJSONResponser::response(422, "表单验证未通过", $form->errors);
            }
        }
        
    }
}