<?php 
namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;
use app\utils\WEHttpClient;
use app\utils\WEStringBuilder;
use app\utils\WEParamsUtil;
use yii\helpers\Json;

class DatabaseList extends Widget {
    
    public function run() {
        $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
        $builder->append(WEParamsUtil::get("serviceDbListApi"));
        $client = new WEHttpClient($builder->toString());

        $result = Json::decode($client->get(), true);
        if($result["code"] == 0) {
            foreach($result["result"] as $key => $database) {
                echo <<<HTMLBLOCK
<li>
    <a href="javascript:;">
        <i class="iconfont left-nav-li" lay-tips="{$database["schema_name"]}">&#xe6b8;</i>
        <cite>{$database["schema_name"]}</cite>
        <i class="iconfont nav_right">&#xe697;</i>
    </a>
</li>
HTMLBLOCK;
            }
        }
    }

}