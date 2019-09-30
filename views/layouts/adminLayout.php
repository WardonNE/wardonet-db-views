<?php 
use app\widgets\DatabaseList;
use app\utils\WEParamsUtil;
use app\widgets\HeaderMenu;
?>
<!doctype html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台登录-X-admin2.2</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="<?php echo \Yii::$app->request->baseUrl;?>/skin/css/font.css">
        <link rel="stylesheet" href="<?php echo \Yii::$app->request->baseUrl;?>/skin/css/xadmin.css">
        <!-- <link rel="stylesheet" href="./css/theme5.css"> -->
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo \Yii::$app->request->baseUrl;?>/skin/js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            // 是否开启刷新记忆tab功能
            // var is_remember = false;
        </script>

        <link rel="stylesheet" href="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/lib/codemirror.css"/>
        <link rel="stylesheet" href="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/hint/show-hint.css">
        <link rel="stylesheet" href="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/theme/idea.css"/>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/lib/codemirror.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/hint/show-hint.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/hint/sql-hint.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/mode/sql/sql.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/mode/clike/clike.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/display/autorefresh.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/edit/matchbrackets.js"></script>
        <script src="<?php echo \Yii::$app->request->baseUrl;?>/skin/lib/codemirror-5.49.0/addon/display/fullscreen.js"></script>
    </head>
    <style>::-webkit-scrollbar{/** display: none; */}</style>
    <body class="index">
        <!-- 顶部开始 -->
        <div class="container">
            <div class="logo">
                <a href="/weadmin">WardonET-Db</a>
            </div>
            <ul class="layui-nav right" lay-filter="">
                <li class="layui-nav-item">
                    <a href="javascript:;">admin</a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a href="#" class="logout">退出</a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <script>
            function htmlEscape(text){ 
                return text.replace(/[<>"&]/g, function(match, pos, originalText) {
                        switch(match){
                        case "<": return "&lt;"; 
                        case ">":return "&gt;";
                        case "&":return "&amp;"; 
                        case "\"":return "&quot;"; 
                    } 
                }); 
            }
        </script>
        <script>
            layui.use(["form", "jquery", "layer"], function() {
                var form = layui.form, $ = layui.jquery, layer = layui.layer;
                $.ajaxSetup({
                    layerIndex: -1,
                    beforeSend: function(jqXHR, settings) {
                        this.layerIndex = layer.load(0, {shade: [0.5, "#393D49"]});
                    },
                    complete: function() {
                        layer.close(this.layerIndex);
                    },
                    error: function() {
                        layer.alert("数据加载出现错误,请刷新页面重试", {
                            skin: "layui-layer-molv",
                            closeBtn: 0,
                            shift: 4
                        });
                    },
                });
                var initLeftNav = function() {
                    var defaultDbname = "<?php echo isset($_GET["dbname"])?$_GET["dbname"]:""?>", defaultTableName = "<?php echo isset($_GET["tablename"])?$_GET["tablename"]:""?>";
                    if(defaultDbname != "") {
                        form.val("database-select-form", {
                            dbname: defaultDbname,
                        });
                        form.render("select", "datanse-select-form");
                        $.post("/wedatabase/db/dbdesc?dbname=" + defaultDbname, {
                            _csrf: "<?php echo \Yii::$app->request->csrfToken;?>"
                        }, function(resp) {
                            if(resp.code == "0") {
                                var html = "";
                                for(i = 0; i < resp.result.list.length; i++) {
                                    html += "<li>\
                                        <a class=\"" + resp.result.list[i].table_name + "\" href=\"/wedatabase/db/tableview?dbname=" + resp.result.list[i].table_schema + "&tablename=" + resp.result.list[i].table_name + "&is_db=0&event=view\">\
                                            <cite><i class=\"iconfont left-nav-li layui-icon layui-icon-table\" lay-tips=\"" + resp.result.list[i].table_name + "\"></i>" + resp.result.list[i].table_name + "</cite>\
                                        </a>\
                                    </li>";
                                }
                                $("#nav").html("");
                                $("#nav").html(html);
                                if(defaultTableName != "") {
                                    $("#nav ." + defaultTableName).addClass("active");
                                }
                            } else {
                                layer.open({
                                    content: resp.message,
                                });
                            }
                        });
                    }
                }
                initLeftNav();
                form.on('select(database-select)', function(data){
                    var dbname = data.value;
                    if(!dbname) {
                        location.href = "/weadmin";    
                    } else {
                        location.href = "/wedatabase/db/dbdesc?dbname=" + dbname + "&is_db=1&event=desc";
                    }
                })
                function popup(message) {
                    layer.open({
                        type: 1,
                        content: message,
                    });
                }
                $(".logout").on("click", function() {
                    $.post("/weadmin/adminuser/logout", {
                        _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
                    },function(resp) {
                        if(resp.code == 0) {
                            location.href = "/";
                        } else {
                            layer.alert("登出失败");
                        }
                    });
                })
            })
        </script>
        <div class="left-nav" style="overflow: scroll">
            <div id="side-nav">
                <div id="database-select">
                    <div class="layui-form" style="width: 90%; margin: auto;" lay-filter="database-select-form">
                        <div class="layui-form-item" >
                            <?php
                                echo DatabaseList::widget();
                            ?>
                        </div>
                    </div>
                </div>
                <ul id="nav">              
                </ul>
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
        <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <ul class="layui-tab-title">
                    <li class="home">
                        <i class="layui-icon">&#xe68e;</i>
                        <span>我的桌面</span>
                    </li>
                    <?php echo HeaderMenu::Widget(array(
                        "is_db" => isset($_GET["is_db"])?$_GET["is_db"]:0,
                        "dbname" => isset($_GET["dbname"])?$_GET["dbname"]:"",
                        "tablename" => isset($_GET["tablename"])?$_GET["tablename"]:"",
                    ));?>
                </ul>
                <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                    <dl>
                        <dd data-type="this">关闭当前</dd>
                        <dd data-type="other">关闭其它</dd>
                        <dd data-type="all">关闭全部</dd>
                    </dl>
                </div>
                <div class="layui-tab-content" style="overflow: scroll;">
                    <div class="layui-tab-item layui-show">
                        <?php echo $content;?>
                    </div>
                </div>
                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>
    </body>

</html>