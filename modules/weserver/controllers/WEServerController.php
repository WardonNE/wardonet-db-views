<?php

namespace app\modules\weserver\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\weserver\actions\WEStatusQueriesAction;
use app\modules\weserver\actions\WEStatusVariableAction;

/**
 * Default controller for the `weserver` module
 */
class WEServerController extends Controller {
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actions() {
        return array(
            "statusqueries" => array(
                "class" => WEStatusQueriesAction::className(),
            ),
            "statusvariable" => array(
                "class" => WEStatusVariableAction::className(),
            ),
        );
    }

    public function behaviors() {
        return array(
            "access" => array(
                "class" => AccessControl::className(),
                "rules" => array(
                    array("allow" => true, "actions" => array(
                        "statusqueries",
                        "statusvariable", 
                    ), "roles" => array())
                ),
            ),
        );
    }
}
