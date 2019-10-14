<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <blockquote class="layui-elem-quote">欢迎管理员：
                        <span class="x-red">wardonet-db</span>！当前时间:<span id="active-time"></span>
                    </blockquote>
                </div>
            </div>
        </div>
        <script>
            function getActiveTime() {
                var date = new Date();
                var currentDate = (date.getFullYear()<10?"0"+date.getFullYear():date.getFullYear()) + "-" + ((date.getMonth()+1)<10?"0"+(date.getMonth()+1):(date.getMonth()+1)) + "-" + (date.getDate()<10?"0"+date.getDate():date.getDate()) + " " + (date.getHours()<10?"0"+date.getHours():date.getHours()) + ":" + (date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes()) + ":" + (date.getSeconds()<10?"0"+date.getSeconds():date.getSeconds())
                layui.use("jquery", function() {
                    var $ = layui.jquery
                    $("#active-time").text(" " + currentDate)
                })
            }
            getActiveTime();
            setInterval(function() {
                getActiveTime();
            }, 1000)
        </script>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">数据统计</div>
                <div class="layui-card-body ">
                    <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                        <li class="layui-col-md2 layui-col-xs6" id="query-number">
                            <a href="/weserver/server/statusqueries" class="x-admin-backlog-body">
                                <h3>查询数量</h3>
                                <p>
                                    <cite>0</cite>
                                </p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>会员数</h3>
                                <p>
                                    <cite>12</cite>
                                </p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>回复数</h3>
                                <p>
                                    <cite>99</cite>
                                </p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>商品数</h3>
                                <p>
                                    <cite>67</cite>
                                </p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>67</cite>
                                </p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6 ">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>6766</cite>
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                            <tr>
                                <th>服务器地址</th>
                                <td><?php echo $_SERVER["HTTP_HOST"]; ?></td>
                            </tr>
                            <tr>
                                <th>操作系统</th>
                                <td><?php echo php_uname("s"); ?></td>
                            </tr>
                            <tr>
                                <th>PHP版本</th>
                                <td><?php echo PHP_VERSION;?></td>
                            </tr>
                            <tr>
                                <th>PHP运行方式</th>
                                <td><?php echo php_sapi_name();?></td>
                            </tr>
                            <tr>
                                <th>Yii</th>
                                <td><?php echo \Yii::getVersion();?></td>
                            </tr>
                            <tr>
                                <th>剩余空间</th>
                                <td><?php echo intval(disk_free_space("/") / 1024 / 1024) . "M";?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">开发团队</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                            <tr>
                                <th>开发者</th>
                                    <td>Wardon Wang(1730314864@qq.com)</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <style id="welcome_style"></style>
    </div>
</div>

<script>
    layui.use(["jquery", "layer", "table", "element"], function() {
        var $ = layui.jquery, layer = layui.layer, table = layui.table, element = layui.element;
        $.post("/weserver/server/statusqueries", {
                _csrf: "<?php echo \Yii::$app->request->csrfToken;?>", 
            },
            function (resp, textStatus, jqXHR) {
                if(resp.code == 0) {
                    $("#query-number cite").html(resp.result.totalQueries);
                }
            },
            "json"
        );
    });
</script>