<?php 
namespace app\utils;

use Yii;

class WEParamsUtil {

    public static function get($key) {
        return self::hasPropertity($key) ? Yii::$app->params[$key] : null;
    }

    public static function set($key, $value) {
        Yii::$app->params[$key] = $value;
    }

    public static function unPropertity($key) {
        if(self::hasPropertity($key)) {
            unset(Yii::$app->params[$key]);
        }
    }

    public static function destroy() {
        Yii::$app->params = array();
    }

    public static function hasPropertity($key) {
        return isset(Yii::$app->params[$key]);
    }
}