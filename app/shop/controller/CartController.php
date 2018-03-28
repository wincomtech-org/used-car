<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
use app\shop\model\ShopCartModel;

/**
 * 不需要登录的，需要登录的放 shop/Order/*
 * 购物车
*/
class CartController extends HomeBaseController
{
    // 购物车元素 - 查看购物车
    public function cartList()
    {
        // $userId = cmf_get_current_user_id();
        // $cartModel = new ShopCartModel;
        // $filter['a.user_id'] = $userId;
        // $carts = $cartModel->getCartList($filter);
        // $this->assign('carts', $carts->items());
        // $carts->appends('');
        // $this->assign('pager', $carts->render());

        $carts = session('user_cart');
// dump($carts);

        // 购物车列表不分页
        $this->assign('carts',$carts);
        return $this->fetch();
    }

    // 加入购物车
    public function cartAdd()
    {
        $data      = $this->request->param();
        $userId    = cmf_get_current_user_id();
        $cartModel = new ShopCartModel;

        if (empty($data['goods_id'])) {
            $this->error('数据不合法');
        }
// dump($data);die;

        // 防止表单重复提交
        if ($data['timestamp'] == session('timestamp')) {
            session('timestamp', null);
        } else {
            $this->redirect('Post/details', ['id' => $data['goods_id']]);
        }

        // 数据验证
        // validate()

        // 检查已添加的， 没有规格时 spec_id=0
        $where = [
            'user_id'  => $userId,
        ];
        if (empty($data['spec_id'])) {
            $where['goods_id'] = $data['goods_id'];
        } else {
            $where['spec_id'] = $data['spec_id'];
        }
        
        $find = $cartModel->where($where)->value('id');
// dump($find);die;
        if ($find > 0) {
            $result = $cartModel->where('id', $find)->setInc('number', $data['number']);
        } else {
            $post = [
                'user_id'      => cmf_get_current_user_id(),
                'goods_id'     => $data['goods_id'],
                'spec_id'      => $data['spec_id'],
                'spec_vars'    => $data['spec_vars'],
                'number'       => $data['number'],
                'price'        => $data['price'],
                'market_price' => $data['market_price'],
            ];
            $result = $cartModel->data($post)->save();
        }

        if ($result > 0) {
            session('user_cart', null);
            $this->success('增加成功', url('cartList'));
        }
        $this->error('增加失败');
    }

    // 删除购物车
    public function cartDel()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('数据非法！');
        }

        $result = ShopCartModel::destroy($id);
        if ($result==1) {
            $this->success('删除成功');
        }
        $this->error('删除失败');
    }
}