<?php
namespace app\modules\weserver\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\utils\WEHttpClient;
use app\utils\WEParamsUtil;
use yii\helpers\ArrayHelper;
use app\utils\WEJSONResponser;
use app\utils\WEStringBuilder;
use app\utils\WESignatureHelper;
use yii\web\NotFoundHttpException;

class WEStatusQueriesAction extends Action {
    public function run() {
        if(Yii::$app->request->isPost) {
            $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
            $builder->append(WEParamsUtil::get("serviceStatusQueriesApi"));
            $builder->append("?");
            $builder->append((new WESignatureHelper())->getSdk());
            $client = new WEHttpClient($builder->toString());
            $response = $client->post(array());
            if (false === $response) {
                return WEJSONResponser::response(1001, $client->getError(), $response);
            }
            $response = Json::decode($response);
            if ($client->getStatusCode() == 200) {
                switch ($response["code"]) {
                case 0:
                    return WEJSONResponser::response(0, "ok", $this->sortQueries(ArrayHelper::map($response["result"]["list"], "variable_name", "value")));
                    break;
                case 1002:
                    return WEJSONResponser::response(1002, "远程服务返回错误", $response["result"]);
                    break;
                case 422:
                    return WEJSONResponser::response(1003, "远程服务表单验证未通过", $response["result"]);
                    break;
                }
            } else {
                return new NotFoundHttpException();
            }
        } else {
            return $this->controller->render("statusqueries");
        }
    }

    public function cleanDeprecated($data) {
        $deprecated = array(
            'Com_prepare_sql' => 'Com_stmt_prepare',
            'Com_execute_sql' => 'Com_stmt_execute',
            'Com_dealloc_sql' => 'Com_stmt_close',
        );
        foreach($deprecated as $old => $new) {
            if (isset($data[$old]) && isset($data[$new])) {
                unset($data[$old]);
            }
        }
        return $data;
    }

    public function sortQueries($data) {
        $used_queries = array();
        foreach($this->cleanDeprecated($data) as $name => $value) {
            foreach(WEParamsUtil::get("allocations") as $filter => $section) {
                if(mb_strpos($name, $filter) !== false) {
                    if($section == 'com' && $value > 0) {
                        $used_queries[$name] = $value;
                    }
                    break;
                }
            }
        }
        unset($used_queries["Com_admin_commands"]);
        return array(
            "totalQueries" => array_sum($used_queries), 
            "list" => $used_queries
        );
    }
}