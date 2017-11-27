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

        $extra = [
            'buyer_uid' => $userId,
        ];

        $list = model('trade/TradeOrder')->getLists([],'','',$extra);
dump($list);

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
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
dump($list);

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    // 填写车子信息
    public function sellerCar()
    {
        $id = $this->request->param('id/d');

        $page = model('usual/UsualCar')->getPost($id);
        if (empty($page)) {
            $this->error('数据丢失！');
            // abort(404,'数据丢失！');
        }

        $this->assign('page',$page);
        return $this->fetch('seller_car');
    }

    public function sellerCarPost()
    {
        $userId = cmf_get_current_user_id();

        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['user_id'] = $userId;

            if (!empty($id)) {
                $post['update_time'] = $post['create_time'] = time();
                $valid = 'add';
            } else {
                $post['update_time'] = time();
                $valid = 'edit';
            }

            $result = $this->validate($post,'usual/Car.'.$valid);
            if ($result!==true) {
                $this->error($result->getError());
            }

            if (!empty($id)) {
                $result = model('usual/UsualCar')->adminAddArticle($post);
                $id = $result->id;
            } else {
                $result = model('usual/UsualCar')->adminEditArticle($post);
            }

            $this->success('提交成功',url('Trade/sellerCar',['id'=>$id]));

        }
    }

    // 订单
    public function sellerOrder()
    {
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = [
            'seller_uid' => $userId,
        ];

        $list = model('trade/TradeOrder')->getLists([],'','',$extra);

        dump($list);

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
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
        // $id = $this->request->param('id/d');
        parent::dels(Db::name('trade_order'));
        $this->success("刪除成功！", '');
    }

    public function more()
    {
        $id = $this->request->param('id/d');
        return $this->fetch();
    }
}