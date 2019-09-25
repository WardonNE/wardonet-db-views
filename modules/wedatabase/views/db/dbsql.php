<div class="x-nav">
    <span class="layui-breadcrumb">
    <a href="#">database: <?php echo $dbname; ?></a>
    <a>
        <cite>sql</cite>
    </a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="åˆ·æ–°">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <textarea name="sql" id="<?php echo $dbname; ?>-sql" style="width: 100%"></textarea>
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
<style>
.CodeMirror{border: 1px #999 solid;}
.CodeMirror-linenumbers{width: 50px;}
.btn-group-content .btn-group{float: right;margin-right: 20px;}
</style>
<script>
layui.use(["jquery", "layer"], function() {
    var tables = new Object;
    var $ = layui.jquery, layer = layui.layer;
    function ignoreInputCode(code) {
        for(var i = 0;i < code.length;i++) {
            if(code[i] != " " || !code[i]) {
                return false;
            }
        }
        return true;
    }
    var sqlCodeMirror = CodeMirror.fromTextArea($("#<?php echo $dbname; ?>-sql")[0], {
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
            tables: tables,
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
            _csrf: "<?php echo \Yii::$app->request->csrfToken; ?>",
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
    function loadTables() {
        $.post("/wedatabase/db/tablelist?dbname=<?php echo $dbname;?>", {
            _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
        }, function(resp) {
            if(resp.code == 0) {
                for(var i = 0; i < resp.result.list.length; i++) {
                    tables[resp.result.list[i].table_name] = new Array();
                    $.post("/wedatabase/db/tabledesc?dbname=<?php echo $dbname;?>&tablename=" + resp.result.list[i].table_name, {
                        _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
                    }, function(response) {
                        console.log(response);
                    }) 
                }
            }
        })
    }
})
</script>