
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
                    <table class="layui-table layui-form" id="<?php echo $dbname;?>-<?php echo $tablename;?>-columns" lay-filter="<?php echo $dbname;?>-<?php echo $tablename;?>-columns">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/html">
    <!-- <button class="layui-btn" lay-event="edit">编辑</button>
    <button class="layui-btn" lay-event="delete">删除</button>
    <button class="layui-btn" lay-event="pk">主键</button>
    <button class="layui-btn" lay-event="unique">唯一</button>
    <button class="layui-btn" lay-event="index">索引</button>
    <button class="layui-btn" lay-event="space">空间</button>
    <button class="layui-btn" lay-event="full-text-search">全文搜索</button>
    <button class="layui-btn" lay-event="distinct">非重复值(DISTINCT)</button> -->
</script>
<script>
    layui.use(["table", "jquery", "layer"], function() {
        var $ = layui.jquery, table = layui.table, layer = layui.layer;
        table.render({
            elem: "#<?php echo $dbname?>-<?php echo $tablename?>-columns",
            method: "post",
            url: "/wedatabase/db/tabledesc?dbname=<?php echo $dbname?>&tablename=<?php echo $tablename?>",
            page: false,
            where: {
                _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
            },
            cols: [[
                {title:"ID",type:"numbers"},
                {title:"名称",field:"column_name"},
                {title:"类型",field:"column_type"},
                {title:"排序规则",field:"collation_name"},
                {title:"空",field:"is_nullable"},
                {title:"默认",field:"column_default"},
                {title:"额外",field:"extra"},
            ]],
            parseData: function(resp) {
                return {
                    total: resp.result.list.length,
                    data: resp.result.list,
                    code: resp.code,
                    msg: resp.message,
                };
            }
        });
    })
</script>

