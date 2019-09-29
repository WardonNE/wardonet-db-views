<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WETableSqlForm extends Model {
    public $dbname;
    public $tablename;
    public $sql;
    public function rules() {
        return array(
            array(array("dbname", "tablename", "sql"), "required"),
        );
    }
}