<?php 
use app\widgets\DatabaseList;
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
    </head>
    <style>::-webkit-scrollbar{display: none;}</style>
    <body class="index">
        <!-- 顶部开始 -->
        <div class="container">
            <div class="logo">
                <a href="./index.html">X-admin v2.2</a></div>
            <div class="left_open">
                <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
            </div>
            <ul class="layui-nav left fast-add" lay-filter="">
                <li class="layui-nav-item">
                    <a href="javascript:;">+新增</a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a onclick="xadmin.open('最大化','http://www.baidu.com','','',true)">
                                <i class="iconfont">&#xe6a2;</i>弹出最大化</a></dd>
                        <dd>
                            <a onclick="xadmin.open('弹出自动宽高','http://www.baidu.com')">
                                <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a></dd>
                        <dd>
                            <a onclick="xadmin.open('弹出指定宽高','http://www.baidu.com',500,300)">
                                <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a></dd>
                        <dd>
                            <a onclick="xadmin.add_tab('在tab打开','member-list.html')">
                                <i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                        <dd>
                            <a onclick="xadmin.add_tab('在tab打开刷新','member-del.html',true)">
                                <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a></dd>
                    </dl>
                </li>
            </ul>
            <ul class="layui-nav right" lay-filter="">
                <li class="layui-nav-item">
                    <a href="javascript:;">admin</a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a onclick="xadmin.open('个人信息','http://www.baidu.com')">个人信息</a></dd>
                        <dd>
                            <a onclick="xadmin.open('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
                        <dd>
                            <a href="./login.html">退出</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item to-index">
                    <a href="/">前台首页</a></li>
            </ul>
        </div>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <script>
            layui.use(["form", "jquery", "layer"], function() {
                var form = layui.form, $ = layui.jquery, layer = layui.layer;
                $.ajaxSetup({
                    layerIndex: -1,
                    beforeSend: function() {
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
                form.on('select(database-select)', function(data){
                    var dbname = data.value;
                    $.post("/wedatabase/db/tablelist?dbname=" + dbname, {
                        _csrf: "<?php echo \Yii::$app->request->csrfToken;?>"
                    }, function(resp) {
                        if(resp.code == "0") {
                            var html = "";
                            for(i = 0; i < resp.result.length; i++) {
                                html += "<li>\
                                    <a href=\"javascript:;\">\
                                        <cite><i class=\"iconfont left-nav-li layui-icon layui-icon-table\" lay-tips=\"" + resp.result[i].table_name + "\"></i>" + resp.result[i].table_name + "</cite>\
                                    </a>\
                                </li>";
                            }
                            $("#nav").html("");
                            $("#nav").html(html);
                        } else {
                            layer.open({
                                content: resp.message,
                            });
                        }
                    });
                })
            })
        </script>
        <div class="left-nav" style="overflow: scroll">
            <div id="side-nav">
                <div id="database-select">
                    <div class="layui-form" style="width: 90%; margin: auto;">
                        <div class="layui-form-item" >
                            <?php echo DatabaseList::widget();?>
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
                        <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
                <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                    <dl>
                        <dd data-type="this">关闭当前</dd>
                        <dd data-type="other">关闭其它</dd>
                        <dd data-type="all">关闭全部</dd></dl>
                </div>
                <div class="layui-tab-content">
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