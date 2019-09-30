<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WEDatabaseImportForm extends Model {
    public $dbname;
    public $sqlFile;
    public function rules() {
        return array(
            array(array("dbname", "sqlFile"), "required"),
        );
    }
}