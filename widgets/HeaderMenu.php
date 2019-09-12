<?php 
namespace app\widgets;

use yii\base\Widget;

class HeaderMenu extends Widget {

    public $databaseMenus = array(
        array(
            "label" => "结构" ,
            "url" => "#",
            "event" => "desc",
            "icon" => "layui-icon-senior",
        ),
        array(
            "label" => "SQL",
            "url" => "#",
            "event" => "sql",
            "icon" => "layui-icon-fonts-code",
        ),
        array(
            "label" => "搜索",
            "url" => "#",
            "event" => "search",
            "icon" => "layui-icon-search",
        ),
        array(
            "label" => "导出",
            "url" => "#",
            "event" => "dump",
            "icon" => "layui-icon-shrink-right",
        ),
        array(
            "label" => "导入",
            "url" => "#",
            "event" => "import",
            "icon" => "layui-icon-spread-left",
        ),
        array(
            "label" => "操作",
            "url" => "#",
            "event" => "operation",
        ),
        array(
            "label" => "程序",
            "url" => "#",
            "event" => "program",
        ),
        array(
            "label" => "事件",
            "url" => "#",
            "event" => "event",
            "icon" => "layui-icon-util",
        ),
        array(
            "label" => "触发器",
            "url" => "#",
            "event" => "trigger",
            "icon" => "layui-icon-engine",
        ),
    );

    public $tableMenus = array(
        array(
            "label" => "浏览",
            "url" => "#",
            "event" => "view",
            "icon" => "layui-icon-list"
        ),
        array(
            "label" => "结构" ,
            "url" => "#",
            "event" => "desc",
            "icon" => "layui-icon-senior",
        ),
        array(
            "label" => "SQL",
            "url" => "#",
            "event" => "sql",
            "icon" => "layui-icon-fonts-code",
        ),
        array(
            "label" => "搜索",
            "url" => "#",
            "event" => "search",
            "icon" => "layui-icon-search",
        ),
        array(
            "label" => "导出",
            "url" => "#",
            "event" => "dump",
            "icon" => "layui-icon-shrink-right",
        ),
        array(
            "label" => "导入",
            "url" => "#",
            "event" => "import",
            "icon" => "layui-icon-spread-left",
        ),
        array(
            "label" => "事件",
            "url" => "#",
            "event" => "event",
            "icon" => "layui-icon-util",
        ),
        array(
            "label" => "触发器",
            "url" => "#",
            "event" => "trigger",
            "icon" => "layui-icon-engine",
        ),
    );
    public function run() {
        foreach($this->tableMenus as $key => $menu) {
            $activeClassName = $menu["event"] == $_GET["event"]?"layui-this":"";
            echo <<<HTMLBLOCK
        <li class="home {$activeClassName}"
            <a href="{$menu["url"]}">
                <i class="layui-icon {$menu["icon"]}"></i>
                <span>{$menu["label"]}</span>
            </a>
        </li>
HTMLBLOCK;
        }
    }

}