<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WETableColumnsForm extends Model {
    public $dbname;
    public $tablename;
    public function rules() {
        return array(
            array(array("dbname", "tablename"), "required"),
        );
    }
}