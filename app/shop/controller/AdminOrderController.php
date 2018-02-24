<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use express\WorkPlugin;

/**
* 服务商城 独立模块
* 订单
*/
class AdminOrderController extends AdminBaseController
{
    public function index()
    {
        $typeCom = 'rrs';
        $typeNu = '6080943656';

        // $typeCom = 'zhongtong';
        // $typeNu = '474184190064';
        // $typeNu = '471791993640';

        // $typeCom = 'yuantong';
        // $typeNu = '888017949354264875';
        // $typeNu = '888017061034034049';

        // $typeCom = 'yunda';
        // $typeNu = '3912633749099';

        // $typeCom = 'huitongkuaidi';
        // $typeNu = '70523393645614';

        // $typeCom = 'youzhengguonei';
        // $typeNu = '9891835741800';

        $express = new WorkPlugin($typeCom,$typeNu);

        $result = $express->workOrder();

        echo "$result";
        // dump($result);
        return $this->fetch();
    }

    
}