<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;
use app\usual\model\UsualCarModel;
use think\Db;

/**
* 公司企业模块
*/
class ServiceshopController extends HomeBaseController
{

    public function details()
    {
        return $this->fetch();
    }
}