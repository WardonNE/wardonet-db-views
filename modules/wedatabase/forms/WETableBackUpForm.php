<?php
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WETableBackUpForm extends Model {
    public $tablename;
    public $dbname;
    public function rules() {
        return array(
            array(array("tablename", "dbname"), "required"),
        );
    }
}