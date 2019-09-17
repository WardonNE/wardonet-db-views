<?php 
namespace app\modules\weadmin\models;

use yii\web\IdentityInterface;
use yii\base\BaseObject;
use Yii;

class WEAdminUserModel extends BaseObject implements IdentityInterface {

    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $adminUser = array(
        "1" => array(
            "id" => "1",
            "username" => "",
            "password" => "",
            "authKey" => "",
            "accessToken" => "",
        )
    );

    public static function initAdminUser() {
        self::$adminUser[1]["username"] = Yii::$app->params["adminAccount"];
        self::$adminUser[1]["password"] = Yii::$app->params["adminPassword"];
    }

    public static function findIdentity($id) {
        self::initAdminUser();
        return isset(self::$adminUser[$id]) ? new static(self::$adminUser[$id]) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        self::initAdminUser();
        foreach (self::$adminUser as $admin) {
            if ($user['accessToken'] === $token) {
                return new static($admin);
            }
        }
        return null;
    }

    public static function findByUsername($username) {
        self::initAdminUser();
        foreach (self::$adminUser as $admin) {
            if (strcasecmp($admin['username'], $username) === 0) {
                return new static($admin);
            }
        }
        return null;
    }

    public function getId() {
        self::initAdminUser();
        return $this->id;
    }

    public function getAuthKey() {
        self::initAdminUser();
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        self::initAdminUser();
        return $this->authKey === $authKey;
    }

    public function validatePassword($password) {
        self::initAdminUser();
        return $this->password === $password;
    }
}