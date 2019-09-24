<?php
namespace app\utils; 

use app\utils\WEParamsUtil;
class WESignatureHelper {

    private function getTimeStamp() {
        return time();
    }

    private function getState() {
        return uniqid("wardonet-db-");
    }

    private function getAppId() {
        return (new WEParamsUtil())->get("appid");
    }

    private function getAppSecret() {
        return (new WEParamsUtil())->get("appsecret");
    }

    private function getSignature($src) {
        return md5($src);
    }

    public function getSdk() {
        $params = array(
            "appid" => $this->getAppId(),
            "appsecret" => $this->getAppSecret(),
            "state" => $this->getState(),
            "timestamp" => $this->getTimeStamp(),
        );
        \ksort($params);
        $signature = $this->getSignature(http_build_query($params));
        $params["signature"] = $signature;
        return http_build_query($params);
    }
}