<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 服务商城
*/
class ShopController extends UserBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function orders()
    {
        return $this->fetch();
    }

    public function order_table()
    {
        return $this->fetch();
    }
    public function confimReceipt()
    {
        return $this->fetch();
    }
    public function evaluate()
    {
        return $this->fetch();
    }
    public function logistics()
    {
        return $this->fetch();
    }
    public function shop_cart()
    {
        return $this->fetch();
    }
    public function returns()
    {
        return $this->fetch();
    }
    public function returns_detail()
    {
        return $this->fetch();
    }
}
