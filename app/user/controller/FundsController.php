<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class FundsController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 列表页
    public function index()
    {
        return $this->fetch();
    }

    public function withdraw()
    {
        return $this->fetch();
    }

    public function recharge()
    {
        return $this->fetch();
    }

    public function apply()
    {
        return $this->fetch();
    }

    public function cancel()
    {
        return $this->fetch();
    }

    public function del()
    {
        return $this->fetch();
    }

    public function more()
    {
        return $this->fetch();
    }
}