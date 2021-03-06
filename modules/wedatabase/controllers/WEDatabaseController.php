<?php

namespace app\modules\wedatabase\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\wedatabase\actions\WESqlLintAction;
use app\modules\wedatabase\actions\WETableSqlAction;
use app\modules\wedatabase\actions\WESqlFormatAction;
use app\modules\wedatabase\actions\WETableListAction;
use app\modules\wedatabase\actions\WEDatabaseSqlAction;
use app\modules\wedatabase\actions\WETableBackUpAction;
use app\modules\wedatabase\actions\WETableColumnsAction;
use app\modules\wedatabase\actions\WETableDataListAction;
use app\modules\wedatabase\actions\WEBackUpFileListAction;
use app\modules\wedatabase\actions\WEDatabaseBackUpAction;
use app\modules\wedatabase\actions\WEDatabaseImportAction;
use app\modules\wedatabase\actions\WEBackUpFileRemoveAction;

/**
 * Default controller for the `wedatabase` module
 */
class WEDatabaseController extends Controller {

    public function actions() {
        return array(
            "dbdesc" => array(
                "class" => WETableListAction::className(),
            ),
            "tableview" => array(
                "class" => WETableDataListAction::className(),
            ),
            "tabledesc" => array(
                "class" => WETableColumnsAction::className(),
            ),
            "dbsql" => array(
                "class" => WEDatabaseSqlAction::className(),
            ),
            "lint" => array(
                "class" => WESqlLintAction::className(),
            ),
            "sqlfmt" => array(
                "class" => WESqlFormatAction::className(),
            ),
            "tablesql" => array(
                "class" => WETableSqlAction::className(),
            ),
            "dbdump" => array(
                "class" => WEDatabaseBackUpAction::className(),
            ), 
            "dbimport" => array(
                "class" => WEDatabaseImportAction::className(),
            ),
            "backupfile" => array(
                "class" => WEBackUpFileListAction::className(),
            ),
            "removefile" => array(
                "class" => WEBackUpFileRemoveAction::className(),
            ),
        );
    }

    public function behaviors() {
        return array(
            "access" => array(
                "class" => AccessControl::className(),
                "only" => array(
                    "tablelist",
                    "tableview",
                    "tabledesc",
                    "dbsql",
                    "lint",
                    "sqlfmt",
                    "tablesql",
                    "dbdump",
                    "dbimport",
                    "backupfile",
                    "removefile"
                ),
                "rules" => array(
                    array(
                        "allow" => true, 
                        "actions" => array(
                            "tablelist",
                            "tableview",
                            "tabledesc",
                            "dbsql",
                            "lint",
                            "sqlfmt",
                            "tablesql",
                            "dbdump",
                            "dbimport",
                            "backupfile",
                            "removefile"
                        ), 
                        "roles" => array("@")
                    ),
                ),
            ),
        );
    }
}
