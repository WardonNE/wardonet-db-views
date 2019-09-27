
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
            url: "/wedatabase/db/tableview?dbname=<?php echo $dbname?>&tablename=<?php echo $tablename?>",
            page: true,
            cols: [[]],
            where: {_csrf: "<?php echo \Yii::$app->request->csrfToken;?>"},
            done: function(resp, pageno, limit) {
                var cols = new Array();
                $.post("/wedatabase/db/tabledesc?dbname=<?php echo $dbname?>&tablename=<?php echo $tablename?>", {
                    _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
                }, function(response) {
                    if(response.code == 0) {
                        for(i = 0; i < response.result.length; i++) {
                            cols.push({
                                field: response.result[i].column_name,
                                title: response.result[i].column_name,
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
                    }
                })                
            },
            parseData: function(resp) {
                var data = new Array();
                if(resp.result.list != null) {
                    for(i = 0; i < resp.result.list.length; i++) {
                        var indata = new Object();
                        for(var field in resp.result.list[i]) {
                            indata[field] = resp.result.list[i][field] != null ? htmlEscape(resp.result.list[i][field]) : resp.result.list[i][field];
                        }
                        data.push(indata);
                    }
                }
                return {
                    code: resp.code,
                    msg: resp.message,
                    count: resp.result.total,
                    data: data,
                };
            }
        });
    })
</script>

