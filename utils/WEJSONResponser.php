<?php
namespace app\utils;

class WEJSONResponser {

    public static function response($code, $message, $result) {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return array(
            "code" => $code,
            "message" => $message,
            "result" => $result,
        );
    }
}