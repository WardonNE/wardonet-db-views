<div class="x-nav">
    <span class="layui-breadcrumb">
    <!-- <a href="">首页</a> -->
    <a href="#">database: <?php echo $dbname;?></a>
    <a>
        <cite>导入</cite>
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
                    <table class="layui-table layui-form" id="<?php echo $dbname;?>-backup-files" lay-filter="<?php echo $dbname;?>-backup-files">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/html" id="toolbar">
    <button class="layui-btn" lay-event="import">导入备份</button>
    <button class="layui-btn layui-btn-danger" lay-event="delete">删除备份</button>
</script>
<script>
layui.use(["jquery", "layer", "table"], function() {
    var $ = layui.jquery, layer = layui.layer, table = layui.table;
    var tableObj = table.render({
        elem: "#<?php echo $dbname;?>-backup-files",
        method: "post",
        url: "/wedatabase/db/backupfile?dbname=<?php echo $dbname;?>",
        page: false,
        cols: [[
            {title:"文件名",field:"filename",sort:true},
            {title:"最后修改时间",field:"last_modify_time",sort:true},
            {title:"大小(B)",field:"size",sort:true},
            {title:"操作",toolbar:"#toolbar",align:"center"}
        ]],
        where: {_csrf: "<?php echo \Yii::$app->request->csrfToken;?>"},
        parseData: function(resp) {
            return {
                count: resp.result.length,
                code: resp.code,
                msg: resp.message,
                data: resp.result,
            };
        }
    });
    table.on("tool(<?php echo $dbname;?>-backup-files)", function(obj) {
        var data = obj.data, event = obj.event;
        switch(event) {
            case "import":
                layer.confirm("确定导入该备份文件?", function(index, layerno) {
                    $.post("/wedatabase/db/dbimport?dbname=<?php echo $dbname?>&sqlFile=" + data.filename, {
                        _csrf: "<?php echo \Yii::$app->request->csrfToken; ?>",
                    }, function(resp) {
                        if(resp.code == 0) {
                            layer.alert("导入成功");
                        } else {
                            layer.alert("导入失败");
                        }
                    })     
                });
            break;
            case "delete":
                layer.confirm("确定删除该备份文件?", function(index, layerno) {
                    $.post("/wedatabase/db/removefile", {
                        _csrf: "<?php echo \Yii::$app->request->csrfToken; ?>",
                        sqlfile: data.filename,
                        dbname: "<?php echo $dbname;?>",
                    }, function(resp) {
                        if(resp.code == 0) {
                            layer.alert("删除成功");
                            tableObj.reload();
                        } else {
                            layer.alert("删除失败");
                        }
                    });
                });
            break;
        }
    })
});
</script>