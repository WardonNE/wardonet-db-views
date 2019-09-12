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

class DatabaseList extends Widget {
    
    public $dbname = null;

    public $tablename = null;

    public function run() {

        $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
        $builder->append(WEParamsUtil::get("serviceDbListApi"));
        $client = new WEHttpClient($builder->toString());

        $result = Json::decode($client->get(), true);
        if($result["code"] == 0) {
            echo Html::dropDownList("dbname", null, ArrayHelper::map($result["result"], "schema_name", "schema_name"), $options = array(
                "lay-search" => "",
                "lay-verify" => "",
                "lay-filter" => "database-select",
                "prompt" => "请选择数据库",
            ));
        }
    }
}