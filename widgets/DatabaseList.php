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
use app\utils\WESignatureHelper;

class DatabaseList extends Widget {
    
    public $dbname = null;

    public $tablename = null;

    public function run() {
        $cache = new WECacheHelper();
        $dbs = $cache->get("database-list");
        if(!$dbs) {
            $builder = (new WEStringBuilder(WEParamsUtil::get("serviceHost")))
                ->append(WEParamsUtil::get("serviceDbListApi"));
            $getParams = (new WESignatureHelper())->getSdk();
            $builder->append("?")->append($getParams);
            $client = new WEHttpClient($builder->toString());
            $response = $client->get();
            if($response === false) {
                echo $this->popup("cURL请求出现错误, ErrorInfo: {$client->getError()}");
                return false;
            }
            if($client->getStatusCode() != 200) {
                echo $this->popup("请求服务接口出现错误, StatusCode: {$client->getStatusCode()}");
                return false;
            }
            $response = Json::decode($response);
            if($response["code"] == 0) {
                $cache->set("database-list", Html::dropDownList("dbname", null, ArrayHelper::map($response["result"]["list"], "schema_name", "schema_name"), $options = array(
                    "lay-search" => "",
                    "lay-verify" => "",
                    "lay-filter" => "database-select",
                    "prompt" => "请选择数据库",
                )));
                return $cache->get("database-list");
            } elseif($response["code"] == 1002) {
                echo $this->popup("{$response["message"]},\r\nQuerySQL: {$response["result"]["querysql"]},\r\nError: {$response["result"]["errorinfo"]}");
                return false;
            }
        }   
        echo (new WECacheHelper())->get("database-list", function() {
            
        });
        
    }

    public function popup($message) {
        return <<<POPUP
<script>
    layui.use("layer", function() {
        var layer = layui.layer;
        layer.alert("$message", {
            skin: "layui-layer-molv",
            closeBtn: 0,
            shift: 4
        });
    })
</script>
POPUP;
    }
}