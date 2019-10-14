<div class="x-nav">
    <span class="layui-breadcrumb">
    <a href="/weadmin">首页</a>
    <a>
        <cite>查询统计</cite>
    </a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid" id="query-list-page">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-row">
                <div class="layui-col-xs6">
                    <div><h2>查询统计(表格)</h2></div>
                    <table class="layui-table" id="query-table" lay-filter="query-table"></table>
                </div>
                <div class="layui-col-xs6">
                    <div><h2>查询统计(图表)</h2></div>
                    <div id="query-echart" style=""></div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    layui.use(["table", "jquery", "layer", "element"], function() {
        var table = layui.table, $ = layui.jquery, layer = layui.layer, element = layui.element;
        table.render({
            elem: "#query-table",
            url: "/weserver/server/statusqueries",
            page: false,
            method: "post",
            where: {
                _csrf: "<?php echo \Yii::$app->request->csrfToken;?>",
            },
            cols: [[
                {title:"说明", field:"variable_name", sort:true},
                {title:"查询数量", field:"value",sort:true},
                {title:"%", field:"percent", sort:true},
            ]],
            parseData: function(resp) {
                var data = new Array();
                for(var key in resp.result.list) {
                    data.push({
                        variable_name: key.replace("Com_", ""),
                        value: resp.result.list[key],
                        percent: (resp.result.list[key] / resp.result.totalQueries * 100).toFixed(3) + "%",
                    });
                }
                return {
                    code: resp.code,
                    msg: resp.message,
                    count: resp.result.totalQueries,
                    data: data,
                }
            },
            done: function(resp, curr, count) {
                var labels = ["set_option", "select", "show_status", "change_db", "show_master_status", "show_slave_status", "show_processlist"];
                console.log(resp)
                var dom = $("#query-echart");
                dom.css("height", $("div[lay-id=query-table]").height());
                var myChart = echarts.init(dom[0]);
                var other = 0
                echartData = new Array();
                legendData = new Array();
                for(var i = 0; i < resp.data.length; i++) {
                    if($.inArray(resp.data[i].variable_name, labels) !== -1) {
                        echartData.push({
                            value: Number(resp.data[i].value),
                            name: resp.data[i].variable_name.replace("_", " "),
                        });
                        if($.inArray(resp.data[i].variable_name, legendData) === -1) {
                            legendData.push(resp.data[i].variable_name.replace("_", " "));
                        }
                    } else {
                        other += Number(resp.data[i].value);
                    }
                }
                echartData.push({
                    value: other,
                    name: "other",
                })
                legendData.push("other");
                console.log(echartData);
                var option = {
                    title: {
                        text: '',
                        left: 'center',
                        top: 20,
                        textStyle: {
                            color: '#333'
                        }
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        type: 'scroll',
                        orient: 'vertical',
                        right: 10,
                        top: 20,
                        bottom: 20,
                        data: echartData.legendData,
                        selected: echartData.selected
                    },
                    series : [
                        {
                            name:"查询统计",
                            type:'pie',
                            radius : '55%',
                            center: ['50%', '50%'],
                            data: echartData.sort(function (a, b) { return a.value - b.value; }),
                            label: {
                                normal: {
                                    textStyle: {
                                        color: 'rgba(255, 255, 255, 0.3)'
                                    }
                                }
                            },
                            labelLine: {
                                normal: {
                                    lineStyle: {
                                        color: 'rgba(255, 255, 255, 0.3)'
                                    },
                                    smooth: 0.2,
                                    length: 10,
                                    length2: 20
                                }
                            },
                            itemStyle: {
                                normal: {
                                    color: '#c23531',
                                    shadowBlur: 200,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            },
                            animationType: 'scale',
                            animationEasing: 'elasticOut',
                            animationDelay: function (idx) {
                                return Math.random() * 200;
                            }
                        }
                    ]
                };
                myChart.setOption(option);
            }
        });
    })
</script>