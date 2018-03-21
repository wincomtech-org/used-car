<?php
namespace app\service\controller;

use cmf\controller\UserBaseController;

/**
* 车辆业务订单
*/
class OrderController extends UserBaseController
{

// 新增的 20180321
    // 支付
    public function pay()
    {
        // 模型 name,price
        $data = $this->request->param();
        $user = cmf_get_current_user();
        $username = model('Service')->getUsername($user);

        $this->assign('order',$data);
        $this->assign('username',$username);
        $this->assign('paysign', 'service_pay');
        $this->assign('orderId', $data['id']);
        return $this->fetch();
    }
}