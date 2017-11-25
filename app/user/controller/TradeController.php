<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\usual\model\UsualCarModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class TradeController extends UserBaseController
{
    function _initialize()
    {
        parent::_initialize();
        // $this->userId = cmf_get_current_user_id();
    }

    // 买家订单列表页
    public function buyer()
    {
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        return $this->fetch();
    }


    /*
    * 卖家数据
    */
    // 车子列表
    public function seller()
    {
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = ['a.user_id'=>$userId];

        $list = model('usual/UsualCar')->getLists([],'','',$extra);

        $this->assign('list',$list);
        return $this->fetch();
    }

    // 填写车子信息
    public function sellerCar()
    {
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        return $this->fetch('seller_car');
    }

    // 订单
    public function sellerOrder()
    {
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = [
            'user_id' => $userId;
        ];

        $list = model('trade/TradeOrder')->getLists([],'','',$extra);

        dump($list);

        $this->assign('list',$list);
        return $this->fetch('seller_order');
    }



    /*
    * 共用
    */
    // 订单详情
    public function orderDetail()
    {
        $id = $this->request->param('id/d');
        // $userId = cmf_get_current_user_id();

        $where = [
            // 'user_id'=>$userId,
        ];

        $order = model('usual/UsualCar')->getPostRelate($id, $where);
        if (empty($order)) {
            $this->error('数据消失在二次元了');
            // abort(404,'数据消失在二次元了');
        }

        $this->assign('order',$order);
        $this->fetch();
    }

    public function cancel()
    {
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        return $this->fetch();
    }

    public function del()
    {
        $id = $this->request->param('id/d');
        return $this->fetch();
    }

    public function more()
    {
        $id = $this->request->param('id/d');
        return $this->fetch();
    }
}