<?php
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WEDatabaseBackUpForm extends Model {
    public $dbname;
    public function rules() {
        return array(
            array(array("dbname"), "required"),
        );
    }
}