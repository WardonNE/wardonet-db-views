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
            "icon" => "layui-icon-survey",
        ),
        array(
            "label" => "程序",
            "url" => "#",
            "event" => "program",
            "icon" => "layui-icon-app",
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
            "icon" => "layui-icon-list",
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

    public $is_db = 0;

    public $tablename;

    public $dbname;

    public function run() {
        if(!$this->dbname) {
            echo "";exit();
        }
        if($this->is_db) {
            foreach($this->databaseMenus as $key => $menu) {
                $activeClassName = ($menu["event"] == $_GET["event"])?"layui-this":"";
                echo <<<HTMLBLOCK
            <li class="home {$activeClassName}">
                <a href="/wedatabase/db/db{$menu["event"]}?dbname={$this->dbname}&tablename={$this->tablename}&is_db=0&event={$menu["event"]}">
                    <i class="layui-icon {$menu["icon"]}"></i>
                    <span>{$menu["label"]}</span>
                </a>
            </li>
HTMLBLOCK;
            }
        } else {
            foreach($this->tableMenus as $key => $menu) {
                $activeClassName = ($menu["event"] == $_GET["event"])?"layui-this":"";
                echo <<<HTMLBLOCK
            <li class="home {$activeClassName}">
                <a href="/wedatabase/db/table{$menu["event"]}?dbname={$this->dbname}&tablename={$this->tablename}&is_db=0&event={$menu["event"]}">
                    <i class="layui-icon {$menu["icon"]}"></i>
                    <span>{$menu["label"]}</span>
                </a>
            </li>
HTMLBLOCK;
            }
        }
    }

}