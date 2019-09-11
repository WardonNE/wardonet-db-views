<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WETableListForm extends Model {

    public $dbname;

    public function rules() {
        return array(
            array("dbname", "required"),
        );
    }
}