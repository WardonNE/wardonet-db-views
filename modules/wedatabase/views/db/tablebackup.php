<div class="x-nav">
    <span class="layui-breadcrumb">
    <!-- <a href="">首页</a> -->
    <a href="#">database: <?php echo $dbname;?></a>
    <a href="#">table: <?php echo $tablename;?></a>
    <a>
        <cite>备份</cite>
    </a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <h3>正在备份数据表"<?php echo $tablename?>"中的数据</h3></br>
            <button class="layui-btn run">执行</button>
        </div>
    </div>
</div>
<script>
layui.use(["jquery", "layer"], function() {
    var $ = layui.jquery, layer = layui.layer;
    function backup() {
        $.post("/wedatabase/db/tabledump?dbname=<?php echo $dbname;?>&tablename=<?php echo $tablename;?>", {
            _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
        }, function(resp) {
            if(resp.code == 0) {
                layer.open({
                    content: "备份数据表\"<?php echo $tablename;?>\"成功",
                });
            } else {
                layer.open({
                    content: "备份数据表\"<?php echo $tablename;?>\"失败",
                });               
            }
        }); 
    }
    $(".run").on("click", backup);
})

</script>