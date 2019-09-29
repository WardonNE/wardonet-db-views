<div class="x-nav">
    <span class="layui-breadcrumb">
    <a href="#">database: <?php echo $dbname; ?></a>
    <a href="#">table: <?php echo $tablename; ?></a>
    <a>
        <cite>sql</cite>
    </a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <textarea name="sql" id="<?php echo $dbname;?>-<?php echo $tablename;?>-sql" style="width: 100%"></textarea>
                </div>
            </div>
        </div>
        <div class="layui-form-item btn-group-content">
            <div class="btn-group">
                <button class="layui-btn sql-clean">清除</button>
                <button class="layui-btn sql-fmt">格式</button>
                <button class="layui-btn sql-run">执行</button>
            </div>
        </div>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <h3>SQL语句</h3></br>
            <div class="layui-card">
                <div class="layui-card-body" id="<?php echo $dbname;?>-<?php echo $tablename;?>-query-sql"></div>
            </div>
        </div>
    </div>
</div>
<div class="layui-fluid">     
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <h3>错误信息</h3></br>
            <div class="layui-card">
                <div class="layui-card-body" id="<?php echo $dbname;?>-<?php echo $tablename;?>-query-sql-errors"></div>
            </div>
        </div>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <h3>执行结果</h3></br>
            <div class="layui-card">
                <div class="layui-card-body" id="<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list"></div>
            </div>
        </div>
    </div>
</div>
<style>
.CodeMirror{border: 1px #999 solid;}
.CodeMirror-linenumbers{width: 50px;}
.btn-group-content .btn-group{float: right;margin-right: 20px;}
</style>
<script>
layui.use(["jquery", "layer", "table"], function() {
    var $ = layui.jquery, layer = layui.layer, table = layui.table;
    function ignoreInputCode(code) {
        for(var i = 0;i < code.length;i++) {
            if(code[i] != " " || !code[i]) {
                return false;
            }
        }
        return true;
    }
    var sqlCodeMirror = CodeMirror.fromTextArea($("#<?php echo $dbname;?>-<?php echo $tablename;?>-sql")[0], {
        mode: "text/x-mysql", //模式
        themes: "idea", //主题
        indentUnit: 4, //缩进单位
        smartIndent: true, //是否智能缩进,
        tabSize: 4, //tab缩进单位
        showCursorWhenSelecting: false,
        lineNumbers: true, //显示行号
        lineWrapping: false,
        lineWiseCopyCut: true,
        indentWithTabs: true, //tab缩进
        matchBrackets: true, //括号匹配
        hint: CodeMirror.hint.sql,
        autoRefresh: true,
        hintOptions: {
            completeSingle: false,
            tables: {
                <?php echo $tablename;?>: loadColumns(),
            },
        },
        extraKeys: {
        }
    });
    sqlCodeMirror.on("change", function(editor, change) {
        if (change.origin == "+input"){
            var textArray = change.text;
            if(!ignoreInputCode(textArray)) {
                setTimeout(function() { editor.execCommand("autocomplete"); }, 100);
            }
        }
    });
    $(".CodeMirror").eq(0).on("keyup", function(event) {
        $.ajax({
            type: "POST",
            url: "/wedatabase/db/lint",
            data: {
                _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
                sql: sqlCodeMirror.getValue(),
            },
            dataType: "json",
            beforeSend: function() {},
            success: function (resp) {
                $(".CodeMirror-code .CodeMirror-linenumber .layui-icon").remove();
                for(var key in resp.result) {
                    if(resp.result[key].length > 0) {
                        var str = "<i class='layui-icon' style='color: red;' onclick='layer.open({type: 4, content: [\"";
                        for(var j = 0; j < resp.result[key].length; j++) {
                            str += resp.result[key][j].message + "</br>";
                        }
                        str += "\", $(this)], tips:[3, \"#666\"]})'>&#xe702;</i>";
                        $(".CodeMirror-code .CodeMirror-linenumber").eq(parseInt(key)).html(str + " " + (parseInt(key) + 1));
                    }
                }
            }
        });
    })
    $(".sql-clean").on("click", function() {
        sqlCodeMirror.setValue("");
    })
    $(".sql-fmt").on("click", function() {
        $.post("/wedatabase/db/sqlfmt", {
            _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
            sql: sqlCodeMirror.getValue(),
        }, function(resp) {
            if(resp.code == 0) {
                if(resp.result.formattedSQL != null) {
                    sqlCodeMirror.setValue(resp.result.formattedSQL);
                }
            } else if(resp.code == 422) {
                var errorInfo = new Array();
                for(var i = 0; i < resp.result.length; i++) {
                    for(var j = 0; j < resp.result[i].length; j++) {
                        errorInfo.append(resp.result[i][j]);
                    }
                }
                popup(errorInfo.Join("</br>"));
            }
        });
    })
    $(".sql-run").on("click", function() {
        $.post("/wedatabase/db/tablesql", {
            _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
            sql: sqlCodeMirror.getValue(),
            dbname: "<?php echo $dbname;?>",
            tablename: "<?php echo $tablename;?>",
        }, function(resp) {
            if(resp.code == 0) {
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql").text(resp.result.querysql);
                if(resp.result.list != null) {
                    $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list").html("<table id='<?php echo $dbname?>-<?php echo $tablename?>-query-sql-list-table' class='layui-table' lay-filter='<?php echo $dbname?>-<?php echo $tablename?>-query-sql-list-table'></table>")
                    var cols = new Array();
                    for(var field in resp.result.list[0]) {
                        cols.push({
                            field: field,
                            title: field,
                            sort: true,
                        });
                    }
                    var data = new Array();
                    for(i = 0; i < resp.result.list.length; i++) {
                        var indata = new Object();
                        for(var field in resp.result.list[i]) {
                            indata[field] = resp.result.list[i][field] != null ? htmlEscape(resp.result.list[i][field]) : resp.result.list[i][field];
                        }
                        data.push(indata);
                    }
                    console.log(cols);
                    table.init("<?php echo $dbname?>-<?php echo $tablename?>-query-sql-list-table", {
                        cols: [cols],
                        data: data,
                        page: true,
                        limit: 10, 
                    })
                } else {
                    $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list").html("影响了" + resp.result.affectrows + "行</br>SQL语句: " + resp.result.querysql);
                }
            } else if(resp.code == 422) {
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list").text();
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql").text(sqlCodeMirror.getValue());
                var errInfo = "";
                for(var field in resp.result) {
                    for(var i = 0; i < resp.result[field].length; i++) {
                        for(var j = 0; j < resp.result[field][i].length; j++) {
                            errInfo += resp.result[field][i][j][0] + "(near '" + resp.result[field][i][j][2] + "')</br>";
                        }
                    }
                }
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-errors").html(errInfo);
            } else if(resp.code == 1002) {
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list").text();
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql").text(resp.result.querysql);                
                var errInfo = "";
                errInfo += resp.result.errorinfo;
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-errors").text(errInfo);
            } else if(resp.code == 1001 || resp.code == 1003) {
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql-list").text();
                $("#<?php echo $dbname;?>-<?php echo $tablename?>-query-sql").text(resp.result.querysql);
                popup(resp.message);
            }
        });
    })
    function loadColumns() {
        var columns = new Array();
        $.ajax({
            type: "POST",
            url: "/wedatabase/db/tabledesc?dbname=<?php echo $dbname;?>&tablename=<?php echo $tablename?>",
            data: {
                _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
            },
            dataType: "json",
            async: false,
            success: function (response) {
                if(response.code == 0) {
                    for(var j = 0; j < response.result.list.length; j++) {
                        columns.push(response.result.list[j].column_name);
                    }
                }
                return;
            }
        });
        return columns;
    }
})
</script>