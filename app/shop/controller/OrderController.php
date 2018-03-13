<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
use app\shop\model\ShopCartModel;

/**
* 商品订单类
* 不需要登录的，需要登录的放 user/Shop/*
*/
class OrderController extends HomeBaseController
{
    // 购物车元素 - 查看购物车
    public function cartList()
    {
        $userId = cmf_get_current_user_id();

        $cartModel = new ShopCartModel;

        $filter['a.user_id'] = $userId;
        $carts = $cartModel->getCartList($filter);
// dump($carts->toArray());

        $this->assign('carts',$carts->items());
        // $carts->appends();
        $this->assign('pager',$carts->render());
        return $this->fetch();
    }

    // 加入购物车 
    public function cartAdd()
    {
        $data = $this->request->param();
        $userId = cmf_get_current_user_id();
// echo "cart";
// dump($data);die;

        // 防止表单重复提交
        if ($data['timestamp']==session('timestamp')) {
            session('timestamp',null);
        } else {
            $this->redirect('details',['id'=>$data['id']]);
        }

        // 数据验证
        // validate()

        // 检查已添加的 
        $where = [
            'user_id' => $userId,
            'spec_id' => $data['spec_id']
        ];
        $find = Db::name('shop_cart')->where($where)->value('id');
        if ($find>0) {
            $result = Db::name('shop_cart')->where('id',$find)->setInc('number',$data['number']);
        } else {
            $post = [
                'user_id'   => cmf_get_current_user_id(),
                'goods_id'  => $data['id'],
                'spec_vars' => $data['spec_vars'],
                'number' => $data['number'],
                'price' => $data['price'],
                'market_price' => $data['market_price'],
            ];
            $result = Db::name('shop_cart')->insert($post);
        }

        if ($result>0) {
            $this->success('添加成功',url('Order/cart'));
        }
        $this->error('添加失败');
        // $this->success('前往购物车……',url('Order/cart',['id'=>6]));
    }

}