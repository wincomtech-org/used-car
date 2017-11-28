<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualBrandModel;
use app\usual\model\UsualSeriesModel;
use app\usual\model\UsualModelsModel;
use app\usual\model\UsualItemModel;
use app\admin\model\DistrictModel;
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
        // $param = $this->request->param();
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = [
            'buyer_uid' => $userId,
        ];

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


    /*
    * 卖家数据
    */
    // 车子列表
    public function seller()
    {
        // $param = $this->request->param();
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = ['a.user_id'=>$userId];

        $list = model('usual/UsualCar')->getLists([],'','',$extra);
// dump($list);die;

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    // 填写车子信息
    public function sellerCar()
    {
        $id = $this->request->param('id/d',0,'intval');
        error_reporting(E_ALL^(E_WARNING|E_NOTICE));


        $carModel = new UsualCarModel();
        $page = $carModel->getPost($id);

        $itemModel = new UsualItemModel();
        $districtModel = new DistrictModel();

        if (!empty($page)) {

            $Brands = model('usual/UsualBrand')->getBrands($page['brand_id']);
            $Models = model('usual/UsualModels')->getModels($page['model_id']);
            $Series = model('usual/UsualSeries')->getSeries($page['serie_id']);
            $Series2 = model('usual/UsualSeries')->getSeries($page['serie_id'],0,2);
            $Provinces = $districtModel->getDistricts($page['province_id']);
            $Citys = $districtModel->getDistricts($page['city_id'],$page['province_id']);
            // 车源类别
            $Types = $carModel->getCarType($page['type']);

            // 用于前台车辆条件筛选且与属性表name同值的字段码
            $searchCode = $itemModel->getItemSearch();
            // 从属性表里被推荐的
            $recItems = $itemModel->getItemTable('is_rec',1);
            // 属性表里所有属性（不包含推荐的）
            $allItems = $itemModel->getItemTable('','',true);

            $this->assign('Series2', $Series2);
            $this->assign('Citys', $Citys);

        } else {

            $Brands = model('usual/UsualBrand')->getBrands();
            $Models = model('usual/UsualModels')->getModels();
            $Series = model('usual/UsualSeries')->getSeries();
            $provId = $this->request->param('provId',1,'intval');
            $Provinces = $districtModel->getDistricts(0,$provId);
            // 车源类别
            $Types = $carModel->getCarType();

            // 用于前台车辆条件筛选且与属性表name同值的字段码
            $searchCode = $itemModel->getItemSearch();
            // dump($searchCode);die;
            // 从属性表里被推荐的
            $recItems = $itemModel->getItemTable('is_rec',1);
            // 属性表里所有属性（不包含推荐的）
            $allItems = $itemModel->getItemTable('','',true);
        }

        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('Provinces', $Provinces);
        $this->assign('Types', $Types);

        $this->assign('searchCode', $searchCode);
        $this->assign('recItems', $recItems);
        $this->assign('allItems', $allItems);

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
        // $param = $this->request->param();
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra = [
            'seller_uid' => $userId,
            // 'seller_uid' => 1,
        ];

        $list = model('trade/TradeOrder')->getLists([],'','',$extra);

        // dump($list);die;

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch('seller_order');
    }

    public function sellerCancel()
    {
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $orderInfo = Db::name('trade_order')->field('buyer_uid,bargain_money')->where('id',$id)->find();
        $bargain_money = floatval($orderInfo['bargain_money']);

        if (!empty($bargain_money)) {
            Db::startTrans();
            $TransStatus = false;
            try{
                Db::name('trade_order')->where('id',$id)->setField('status',-2);
                Db::name('user')->where('id',$userId)->dec('coin',$bargain_money);
                Db::name('user')->where('id',$orderInfo['buyer_uid'])->setInc('coin', $bargain_money);
                Db::name('user_score_log')->insert([
                    'user_id'     => $orderInfo['buyer_uid'],
                    'create_time' => time(),
                    'action'      => 'trade_sellerCancel',
                    'coin'        => $bargain_money,
                ]);

                $TransStatus = true;
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                // throw $e;
            }
        }

        if ($TransStatus) {
            $this->success('取消成功');
        }
        $this->error('取消失败');
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

    public function del()
    {
        // $id = $this->request->param('id/d');
        $table = $this->request->param('table/s');
        if (empty($table)) {
            $table = 'trade_order';
        }
        parent::dels(Db::name($table));
        $this->success("刪除成功！", '');
    }

    // 赎回资金 cancel中处理
    public function backfund()
    {$this->success('请耐心等待工作人员操作');
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        return $this->fetch();
    }

    public function more()
    {
        $id = $this->request->param('id/d');
        return $this->fetch();
    }
}