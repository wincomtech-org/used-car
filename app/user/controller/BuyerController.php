<?php
namespace app\user\controller;

use app\user\controller\TradeController;
// use app\trade\model\TradeOrderModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class BuyerController extends TradeController
{
    // 买家订单列表页
    public function index()
    {
        // $param = $this->request->param();
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra['a.buyer_uid'] = $userId;
        if (!empty($id)) {
            $extra['a.id'] = $id;
        }

        $list = model('trade/TradeOrder')->getLists([],'','',$extra);

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    public function cancel()
    {
        $id = $this->request->param('id/d');
        // $userId = cmf_get_current_user_id();

        $result = Db::name('trade_order')->where('id',$id)->setField('status',-1);
        if ($result) {
            $this->success('取消成功');
        }
        $this->error('取消失败');

    }
}