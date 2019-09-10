<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "WardonET-DB Login";
$this->params["breadcrumbs"][] = $this->title;
?>
<!doctype html>
<html class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title><?php echo Html::encode($this->title);?></title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl;?>/skin/css/font.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl;?>/skin/css/login.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl;?>/skin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl?>/skin/lib/layui/layui.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="message"><?php echo Html::encode($this->title);?></div>
        <div id="darkbannerwrap"></div>
        <?php $form = ActiveForm::begin([
            "class" => "layui-form",
            "method" => "post",
            "id" => "login",
            "fieldConfig" => [
                "template" => "{input}\n<div class=\"col-lg-8\">{error}</div>",
            ],
        ])?>
        <?php echo $form->field($model, "username")->textInput(["autofocus" => true, "placeholder" => "用户名", "class" => "layui-input"])?>
        <hr class="hr15">
        <?php echo $form->field($model, "password")->passwordInput(["autofocus" => true, "placeholder" => "密码", "class" => "layui-input"])?>
        <hr class="hr15">
        <?php echo Html::input("submit", "submit", "登录", [
            "lay-filter" => "login",
            "lay-submit" => "",
            "style" => "width:100%",
        ]) ?>
        <hr class="hr20" >
        <?php $form->end();?>
    </div>
</body>
</html>