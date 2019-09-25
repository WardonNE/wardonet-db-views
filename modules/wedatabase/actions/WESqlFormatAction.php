<?php 
namespace app\modules\wedatabase\actions;

use Yii;
use yii\base\Action;
use app\utils\WEJSONResponser;
use app\utils\WESqlParser;
use app\modules\wedatabase\forms\WESqlFormatForm;

class WESqlFormatAction extends Action {
    public function run() {
        $form = new WESqlFormatForm();
        $form->setAttributes(Yii::$app->request->post());
        if($form->validate()) {
            $parser = new WESqlParser($form->sql);
            $formattedSQL = $parser->formatSql;
            return WEJSONResponser::response(0, "ok", array(
                "originalSQL" => $form->sql,
                "formattedSQL" => $formattedSQL,
            ));
        } else {
            return WEJSONResponser::response(422, "表单验证未通过", $form->errors);
        }
    }
}