<?php
namespace app\modules\wedatabase\actions;

use yii\base\Action;
use app\utils\WEHttpClient;
use app\utils\WEStringBuilder;
use app\utils\WEParamsUtil;

class WETableDataListAction extends Action {

    public function run() {
        $builder = new WEStringBuilder(WEParamsUtil::get("serviceHost"));
        $builder->append(WEParamsUtil::get("serviceTableDataList"));
        $builder->replaceSubString("{:dbname}", $form->dbname);
    }

}