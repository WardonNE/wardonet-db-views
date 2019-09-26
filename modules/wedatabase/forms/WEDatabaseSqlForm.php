<?php 
namespace app\modules\wedatabase\forms;

use yii\base\Model;
use app\utils\WESqlParser;

class WEDatabaseSqlForm extends Model {
    public $dbname;
    public $sql;
    public function rules() {
        return array(
            array(["dbname", "sql"], "required"),
            array("sql", "sqlParse"),
        );
    }

    public function sqlParse($attribute, $params) {
        if($this->hasErrors()) return;
        $parser = new WESqlParser($this->sql);
        if($parser->hasErrors()) {
            $this->addError("sql", $parser->errors);
        }
    }
}