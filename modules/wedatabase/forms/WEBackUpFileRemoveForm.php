<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WEBackUpFileRemoveForm extends Model {
    public $sqlfile;
    public $dbname;
    public function rules() {
        return array(
            array(array("sqlfile","dbname"), "required"),
        );
    }
}