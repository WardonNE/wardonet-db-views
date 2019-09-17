<?php 
namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;
use app\utils\WEHttpClient;
use app\utils\WEStringBuilder;
use app\utils\WEParamsUtil;
use yii\helpers\Json;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\utils\WECacheHelper;

class DatabaseList extends Widget {
    
    public $dbname = null;

    public $tablename = null;

    public function run() {

        echo (new WECacheHelper())->get("database-list", function() {
            $builder = (new WEStringBuilder(WEParamsUtil::get("serviceHost")))
                ->append(WEParamsUtil::get("serviceDbListApi"));
            $client = new WEHttpClient($builder->toString());
            $response = $client->get();
            if($response === false) {
                echo $client->getError();
                return false;
            }
            if($client->getStatusCode() != 200) {
                echo "请求服务接口出现错误, StatusCode: {$client->getStatusCode()}";
                return false;
            }
            $response = Json::decode($response);
            if($response["code"] == 0) {
                return Html::dropDownList("dbname", null, ArrayHelper::map($response["result"], "schema_name", "schema_name"), $options = array(
                    "lay-search" => "",
                    "lay-verify" => "",
                    "lay-filter" => "database-select",
                    "prompt" => "请选择数据库",
                ));
            }
        });
        
    }
}