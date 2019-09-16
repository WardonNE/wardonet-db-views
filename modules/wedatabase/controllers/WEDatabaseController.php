<?php

namespace app\modules\wedatabase\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\wedatabase\actions\WETableListAction;
use app\modules\wedatabase\actions\WETableDataListAction;
use app\modules\wedatabase\actions\WETableColumnsAction;

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
                ),
                "rules" => array(
                    array(
                        "allow" => true, 
                        "actions" => array(
                            "tablelist",
                            "tableview",
                            "tabledesc",
                        ), 
                        "roles" => array("@")
                    ),
                ),
            ),
        );
    }
}
