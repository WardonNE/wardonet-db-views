
<div class="x-nav">
    <span class="layui-breadcrumb">
    <!-- <a href="">首页</a> -->
    <a href="#">database: <?php echo $dbname;?></a>
    <a>
        <cite>table: <?php echo $tablename;?></cite>
    </a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <!-- <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div> -->
                <!-- <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    <button class="layui-btn" onclick="xadmin.open('添加用户','./admin-add.html',600,400)"><i class="layui-icon"></i>添加</button>
                </div> -->
                <div class="layui-card-body ">
                    <table class="layui-table layui-form" id="<?php echo $dbname;?>-<?php echo $tablename;?>-data" lay-filter="<?php echo $dbname;?>-<?php echo $tablename;?>-data">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    layui.use(["table", "jquery", "layer"], function() {
        var $ = layui.jquery, table = layui.table, layer = layui.layer;
        table.render({
            elem: "#<?php echo $dbname?>-<?php echo $tablename?>-data",
            method: "post",
            url: "/wedatabase/db/datalist?dbname=<?php echo $dbname?>&tablename=<?php echo $tablename?>",
            page: false,
            cols: [[]],
            where: {_csrf: "<?php echo \Yii::$app->request->csrfToken;?>"},
            done: function(resp, pageno, limit) {
                var cols = new Array();
                for (var field in resp.data[0]) {
                    if(field == "LAY_TABLE_INDEX") {
                        continue;
                    }
                    cols.push({
                        field: field,
                        title: field,
                        sort: true,
                    });
                }
                table.init("<?php echo $dbname?>-<?php echo $tablename?>-data", {
                    cols: [cols],
                    data: resp.data,
                    count: resp.count,
                    page: true,
                    limit: 10,
                })
            },
            parseData: function(resp) {
                return {
                    code: resp.code,
                    msg: resp.message,
                    count: resp.result.total,
                    data: resp.result.list,
                };
            }
        });
    })
</script>

