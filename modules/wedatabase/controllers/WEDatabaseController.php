<?php

namespace app\modules\wedatabase\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\wedatabase\actions\WETableListAction;


/**
 * Default controller for the `wedatabase` module
 */
class WEDatabaseController extends Controller {

    public function actions() {
        return array(
            "tablelist" => array(
                "class" => WETableListAction::className(),
            ),
        );
    }

    public function behaviors() {
        return array(
            "access" => array(
                "class" => AccessControl::className(),
                "only" => array(
                    "tablelist",
                ),
                "rules" => array(
                    array("allow" => true, "actions" => array("tablelist"), "roles" => array("@")),
                ),
            ),
        );
    }
}
