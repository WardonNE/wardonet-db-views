<?php 
namespace app\modules\wedatabase\actions;

use \Yii;
use yii\base\Action;
use app\utils\WEJSONResponser;
use app\utils\WESqlLinter;
class WESqlLintAction extends Action {
    public function run() {
        $sql = Yii::$app->request->post("sql");
        $response = (new WESqlLinter())->lint($sql);
        return WEJSONResponser::response(0, "ok", $response);
    }
}