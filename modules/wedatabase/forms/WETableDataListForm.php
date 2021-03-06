<?php
namespace app\modules\wedatabase\forms;

use yii\base\Model;

class WETableDataListForm extends Model {
    public $dbname;
    public $tablename;
    public $page;
    public $limit;
    public function rules() {
        return array(
            array(array("dbname", "tablename", "page", "limit"), "required"),
        );
    }
}