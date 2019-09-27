<?php 
namespace app\utils;

class WESelectBuilder extends WEStringBuilder {

    public $dbname;

    public $tablename;

    public $columns = "*";

    public function __construct($str = "SELECT") {
        parent::__construct($str);
    }

    public function setDbname($dbname) {
        
    }

    public function setTableName($tablename) {

    }

    public function setColumns($columns) {

    }

    public function toString() {
        
    }
}