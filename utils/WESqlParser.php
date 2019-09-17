<?php 
namespace app\utils;

use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Utils\Error;
use PhpMyAdmin\SqlParser\Utils\Formatter;

class WESqlParser {

    public $sql;

    public $parser;

    public $errors;

    public $formatErrors;

    public $formatSql;

    public function __construct($sql) {
        $this->sql = $sql;
        $this->parser = new Parser($this->sql);
        $this->errors = Error::get(array($this->parser));
        $this->formatErrors = Error::format($this->errors);
        $this->formatSql = Formatter::format($this->sql);
    }

    public function hasErrors() {
        return count($this->errors) > 0;
    }
}