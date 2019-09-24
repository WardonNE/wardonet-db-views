<div class="x-nav">
    <span class="layui-breadcrumb">
    <!-- <a href="">é¦–é¡µ</a> -->
    <a href="#">database: <?php echo $dbname;?></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="åˆ·æ–°">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <table class="layui-table layui-form" id="<?php echo $dbname;?>-tables" lay-filter="<?php echo $dbname;?>-tables">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/html" id="<?php echo $dbname?>-toolbar">
    <button class="layui-btn" lay-event="view">浏览</button>
    <button class="layui-btn" lay-event="desc">结构</button>
    <button class="layui-btn" lay-event="search">搜索</button>
    <button class="layui-btn" lay-event="insert">插入</button>
    <button class="layui-btn layui-btn-danger" lay-event="deleteall">清空</button>
    <button class="layui-btn layui-btn-danger" lay-event="drop">删除</button>
</script>
<script>
    layui.use(["table", "jquery", "layer"], function() {
        var $ = layui.jquery, table = layui.table, layer = layui.layer;
        table.render({
            elem: "#<?php echo $dbname?>-tables",
            method: "post",
            url: "/wedatabase/db/tablelist?dbname=<?php echo $dbname?>",
            page: false,
            cols: [[
                {title:"表",field:"table_name"},
                {title:"操作",toolbar:"#<?php echo $dbname;?>-toolbar",width:"22.5%"},
                {title:"行数",field:"table_rows"},
                {title:"类型",field:"engine"},
                {title:"排序规则",field:"table_collection"},
                {title:"大小",field:"index_length"},
            ]],
            where: {_csrf: "<?php echo \Yii::$app->request->csrfToken;?>"},
            parseData: function(resp) {
                return {
                    count: resp.result.list.length,
                    code: resp.code,
                    msg: resp.message,
                    data: resp.result.list,
                };
            }
        });
    })
</script>

