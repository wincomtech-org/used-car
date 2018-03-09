<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
// use app\shop\model\ShopGoodsModel;
use think\Db;

/**
* 服务商城 独立模块
* 列表之后的
*/
class PostController extends HomeBaseController
{
    public function details()
    {
        $id = $this->request->param('id',0,'intval');
        $star = $this->request->param('star',0,'intval');

        // $goods = Db::name('shop_goods')->where('id',$id)->find();
        // $more = json_decode($goods['more'],true);
        $goods = model('ShopGoods')->getPost($id);

        // 评价专区
        // 统计
        $eval['amount'] = Db::name('shop_evaluate')->count();
        $eval['good'] = Db::name('shop_evaluate')->where('star',1)->count();
        // 用户评价
        $where = [
            'goods_id' => $id,
            'star'     => $star
        ];
        $evaluate = DB::name('shop_evaluate')->alias('a')
            ->field('a.id,a.user_id,a.goods_id,a.description,b.user_nickname,b.user_login,b.mobile')
            ->join('user b','a.user_id=b.id')
            ->where($where)
            ->paginate(1);

        // 商品属性
        $attrs = '';

        // 推荐商品
        $goodsRec = Db::name('shop_goods')->where('')->select();
        // $goodsRec = Db::name('shop_goods')->where('cate_id',$goods['cate_id'])->select();

// dump($goodsRec);
// dump($more);
// dump($goods);
// die;
        $evaluate->appends('id='.$id.'&star='.$star);
        $this->assign('goods',$goods);
        $this->assign('eval',$eval);
        $this->assign('evaluate',$evaluate);
        $this->assign('pager',$evaluate->render());
        $this->assign('attrs',$attrs);
        $this->assign('goodsRec',$goodsRec);
        return $this->fetch();
    }

    // 购物车元素 
    public function cart()
    {
        $data = $this->request->param();

        // dump($data);
        $this->success('前往购物车……',url('Order/cart',['id'=>5]));
    }

    // 立即购买
    public function buy()
    {
        $data = $this->request->param();

        // dump($data);
        $this->success('前往支付页面……',url('user/Shop/buy',$data));
    }

    // 积分兑换
    public function score()
    {
        $data = $this->request->param();

        // dump($data);
        $this->success('前往积分兑换页……',url('details',['id'=>5]));
    }

}