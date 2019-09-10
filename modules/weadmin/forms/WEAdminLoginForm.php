<?php 

namespace app\modules\weadmin\forms;

use Yii;
use yii\base\Model;

class WEAdminLoginForm extends Model {
    public $username;
    public $password;

    private $_user = false;

    public function rules() {
        return [
            [["username", "password"], "required"],
            ["password", "validatePassword"],
        ];
    }

    public function validatePassword($attribute, $params) {
        if($this->hasErrors()) {
            return;
        }
        if(Yii::$app->params["adminAccount"] != hash("sha512", $this->username) || Yii::$app->params["adminPassword"] != hash("sha512", $this->password)) {
            $this->addError($attribute, "invalid password");
        }
    }
}