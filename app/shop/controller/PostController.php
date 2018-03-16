<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
// use app\shop\model\ShopGoodsModel;
// use app\shop\model\ShopGoodsSpecModel;
use app\shop\model\ShopEvaluateModel;
use think\Db;

/**
* 服务商城 独立模块
* 列表之后的
*/
class PostController extends HomeBaseController
{
    public function details()
    {
        $id = $this->request->param('id',0,'intval');//用于获取商品数据
        $star = $this->request->param('star');//用于评论

        // 获取商品数据
        // $goods = Db::name('shop_goods')->where('id',$id)->find();
        // $more = json_decode($goods['more'],true);
        // $goods = model('ShopGoods')->getPost($id);
        $goods = model('ShopGoods')->alias('a')
            ->field('a.*,b.name as catename,c.name as brandname')
            ->join([
                ['shop_goods_category b','a.cate_id=b.id'],
                ['shop_brand c','a.brand_id=c.id'],
            ])
            ->where('a.id',$id)
            ->find();
// dump($goods->toArray());die;

        // 商品规格
        // $cate_specs = model('ShopGoodsCategory')->getSpecByCate($goods['cate_id']);//不使用多种规格
        $specs = Db::name('shop_goods_spec')->field('id,spec_vars')->where('goods_id',$id)->select()->toArray();

        // 商品属性
        $attrs = Db::name('shop_goods_item')->alias('a')
            ->field('b.name as attr,c.name as av')
            ->join('shop_goods_attr b','a.attr_id=b.id')
            ->join('shop_goods_av c','a.av_id=c.id')
            ->where('a.goods_id',$id)
            ->order('b.list_order')
            ->select();


// $subSql = Db::name('shop_category_spec')->field('spec_id')->where('cate_id',0)->buildSql();
// // dump($subSql);

// dump($specs);
// dump($attrs);
// die;

        // 评价专区
        $eModel = new ShopEvaluateModel;
        $filter['goods_id'] = $id;
        // 统计
        $ecount = $eModel->Ecount($filter);
        // 用户评价
        if ($star!==NULL) {
            $filter['star'] = $star;
        }
        $eList = $eModel->getEvalList($filter);

        // 推荐商品 条件：
        $goodsRec = Db::name('shop_goods')->where('')->select();
        // $goodsRec = Db::name('shop_goods')->where('cate_id',$goods['cate_id'])->select();

// dump($ecount);
// dump($eList->toArray());
// dump($goodsRec);
// die;
        // 防止重复
        session('timestamp',time());

        // 模板赋值
        $this->assign('goods',$goods);
        $this->assign('specs',$specs);
        $this->assign('attrs',$attrs);

        // $this->assign('star',$star);
        $this->assign('eval_per',$ecount['per']);
        $this->assign('eval_counts',$ecount['eval']);
        $this->assign('evaluateList',$eList->items());
        $eList->appends(['id'=>$id,'star'=>$star]);
        $eList->fragment('AAA');
        $this->assign('pager',$eList->render());

        $this->assign('goodsRec',$goodsRec);

        return $this->fetch();
    }

    // 规格切换
    public function ajaxSpec()
    {
        $id = $this->request->post('id/d');
        if (empty($id)) {
            return 0;
        }
        $gs = Db::name('shop_goods_spec')->field('spec_vars,market_price,price,stock')->where('id',$id)->find();
        return $gs;
    }


    public function overdue(){
        return $this->fetch();
    }
}