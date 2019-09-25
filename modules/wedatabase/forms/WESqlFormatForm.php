<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WESqlFormatForm extends Model {
    public $sql;
    public function rules() {
        return array(
            array("sql", "safe"),
        );
    }
}