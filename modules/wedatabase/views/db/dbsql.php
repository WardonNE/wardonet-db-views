


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
    </div>
</div>
<script>
layui.use(["jquery", "layer"], function() {
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
            tables: {
                "t_test_login": [ "col_a", "col_B", "col_C" ],
                "t_test_employee": [ "other_columns1", "other_columns2" ]
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
                if(resp.result.length == 0) {
                    $(".CodeMirror-code .CodeMirror-linenumber .error-info").remove();
                } else {
                    for(var i = 0;i < resp.result.length;i++) {
                        $(".CodeMirror-code .CodeMirror-linenumber").eq(resp.result[i].fromLine).html("<i class='layui-icon-tips layui-icon error-info' style='color:red'></i> " + (resp.result[i].fromLine + 1));
                    }
                }
            }
        });
    })

    $(".error-info").parent().on("click", function(event) {
        var that = this;
        layer.tips("error", that);
    });
})
</script>