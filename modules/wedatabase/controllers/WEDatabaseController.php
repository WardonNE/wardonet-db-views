<?php

namespace app\modules\wedatabase\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\wedatabase\actions\WETableListAction;
use app\modules\wedatabase\actions\WETableDataListAction;
use app\modules\wedatabase\actions\WETableColumnsAction;
use app\modules\wedatabase\actions\WEDatabaseSqlAction;
use app\modules\wedatabase\actions\WESqlLintAction;

/**
 * Default controller for the `wedatabase` module
 */
class WEDatabaseController extends Controller {

    public function actions() {
        return array(
            "tablelist" => array(
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
                ),
                "rules" => array(
                    array(
                        "allow" => true, 
                        "actions" => array(
                            "tablelist",
                            "tableview",
                            "tabledesc",
                            "dbsql",
                        ), 
                        "roles" => array("@")
                    ),
                ),
            ),
        );
    }
}
