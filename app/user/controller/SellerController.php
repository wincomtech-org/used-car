<?php
namespace app\user\controller;

use app\user\controller\TradeController;
// use app\user\model\UserModel;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualBrandModel;
use app\usual\model\UsualSeriesModel;
use app\usual\model\UsualModelsModel;
use app\usual\model\UsualItemModel;
use app\admin\model\DistrictModel;
use app\portal\model\PortalPostModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 卖家中心
*/
class SellerController extends TradeController
{
    function _initialize()
    {
        parent::_initialize();
        $u_s_nav = $this->request->action();
        // dump($u_s_nav);
        $this->assign('u_s_nav',$u_s_nav);
    }

    // 订单
    public function index()
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
        return $this->fetch();
    }

    // 取消订单 如果有订金则退还订金
    public function cancel()
    {
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();
        bcscale(6);
        $orderInfo = Db::name('trade_order')->field('buyer_uid,bargain_money')->where('id',$id)->find();
        $bargain_money = floatval($orderInfo['bargain_money']);
        $buyer_uid = $orderInfo['buyer_uid'];
        $buyer_coin = DB::name('user')->where('id',$buyer_uid)->value('coin');

        if (empty($bargain_money)) {
            Db::name('trade_order')->where('id',$id)->setField('status',-2);
        } else {
            Db::startTrans();
            $TransStatus = false;
            try{
                Db::name('trade_order')->where('id',$id)->setField('status',-2);
                Db::name('user')->where('id',$userId)->dec('coin',$bargain_money);
                Db::name('user')->where('id',$buyer_uid)->setInc('coin', $bargain_money);
                lothar_put_funds_log($buyer_uid, -6, $bargain_money, bcadd($buyer_coin,$bargain_money), 'user', $userId, false);
                $TransStatus = true;
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                // throw $e;
            }
            if ($TransStatus===false) {
                $this->error('取消失败');
            }
        }
        $this->success('取消成功');
    }



    // 车子列表
    public function car()
    {
        // $param = $this->request->param();
        // $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();
        // $userId = 1;

        $extra = ['a.user_id'=>$userId];

        $list = model('usual/UsualCar')->getLists([],'','',$extra);
// dump($list);die;

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    // 填写车子信息
    public function carInfo()
    {
        error_reporting(E_ALL^(E_WARNING|E_NOTICE));
        $id = $this->request->param('id/d',0,'intval');
        $srcol = $this->request->param('srcol/s','base','strval');
        $userId = cmf_get_current_user_id();
        // 用户认证状态
        $identify = lothar_verify($userId);
        // $identify = 1;

        // 实例化
        $carModel = new UsualCarModel();
        $brandModel = new UsualBrandModel();
        $serieModel = new UsualSeriesModel();
        $moModel = new UsualModelsModel();
        $itemModel = new UsualItemModel();
        $zoneModel = new DistrictModel();

        $post = $carModel->getPost($id);
// dump($post);die;

        if (empty($post)) {
            $Brands = $brandModel->getBrands();
            $Models = $moModel->getModels();
            $Series = $serieModel->getSeries();
            $provId = $this->request->param('provId',1,'intval');
            $Provinces = $zoneModel->getDistricts(0,$provId);
            // 车源类别
            $Types = $carModel->getCarType();
        } else {
            $Brands = $brandModel->getBrands($post['brand_id']);
            $Models = $moModel->getModels($post['model_id']);
            $Series = $serieModel->getSeries($post['serie_id']);
            $Series2 = $serieModel->getSeries($post['serie_id'],0,2);
            $Provinces = $zoneModel->getDistricts($post['province_id']);
            $Citys = $zoneModel->getDistricts($post['city_id'],$post['province_id']);
            // 车源类别
            $Types = $carModel->getCarType($post['type']);
            $this->assign('Series2', $Series2);
            $this->assign('Citys', $Citys);
        }

        // 用于前台车辆条件筛选且与属性表name同值的字段码
        $searchCode = $itemModel->getItemSearch();
        // 从属性表里被推荐的
        $recItems = $itemModel->getItemTable('is_rec',1);
        // 属性表里所有属性（不包含推荐的）
        // $where['code'] = where('id','not in','1,5,8');
        $item_rec = Db::name('usual_item_cate')->where('is_rec',1)->column('code');
        $item_rec = implode(',',$item_rec);
        $filter_var = config('usual_car_filter_var0') .','. $item_rec .','.config('usual_car_filter_var');
        $where['code'] = ['not in',$filter_var];
        $allItems = $itemModel->getItemTable($where,'',true);

        // 新手帮助
        $portalM = new PortalPostModel();
        $noobCate = Db::name('portal_category')->field('name,description')->where(['id'=>9,'status'=>1])->find();
        $noobHelps = $portalM->getIndexPortalList(9,'ASC',7,'a.id,a.post_title');

        // 模板赋值
        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('Provinces', $Provinces);
        $this->assign('Types', $Types);

        $this->assign('searchCode', $searchCode);
        $this->assign('recItems', $recItems);
        $this->assign('allItems', $allItems);
        $this->assign('noobCate', $noobCate);
        $this->assign('noobHelps', $noobHelps);

        $this->assign('post',$post);
        $this->assign('identify',$identify);
        $this->assign('srcol',$srcol);
        return $this->fetch('car_info');
    }

    public function carInfoPost()
    {
        $userId = cmf_get_current_user_id();

        if ($this->request->isPost()) {
            $data = $this->request->post();
            $post = $data['post'];
            $id = intval($post['id']);

            // $more = !empty($data['post']['more'])?$data['post']['more']:'';
            // $post   = model('usual/UsualItem')->ItemMulti($post,$more);

            if (empty($post['serie_id'])) {
                $post['serie_id'] = $post['serie_pid'];
            }
            $post['platform'] = 2;//新车平台自己发布
            $post['user_id'] = !empty($post['user_id'])?$post['user_id']:$userId;
            $post['update_time'] = time();

            $carModel = new UsualCarModel();

            if (empty($post['sell_status'])) {
                $valid = 'seller';
            } else {
                if (empty($id)) {
                    $post['create_time'] = time();
                    $valid = 'add';
                } else {
                    $valid = 'edit';
                }
            }
            $result = $this->validate($post,'usual/Car.'.$valid);
            if ($result !== true) {
                $this->error($result);
            }

            /*处理图片*/
            // 直接拿官版的
            if (!empty($data['photo'])) {
                $post['more']['photos'] = $carModel->dealFiles($data['photo']);
            }
            if (!empty($data['identity_card'])) {
                $post['identi']['identity_card'] = $carModel->dealFiles($data['identity_card']);
            }
            if (!empty($data['file'])) {
                $post['more']['files'] = $carModel->dealFiles($data['file']);
            }

            if (!empty($id)) {
                $result = $carModel->adminAddArticle($post);
                $id = $result->id;
            } else {
                $result = $carModel->adminEditArticle($post);
            }

            $this->success('提交成功',url('Trade/carInfo',['id'=>$id]));
        }
    }



    public function more()
    {
        // 多字段图片处理
        // $file_var = ['driving_license','identity_card1','identity_card2'];
        // // $file_var = ['driving_license','identity_card1','identity_card2','thumbnail'];
        // $files = model('service/Service')->uploadPhotos($file_var);
        // foreach ($files as $key => $it) {
        //     if (!empty($it['err'])) {
        //         // $this->error($it['err']);
        //     }
        //     if (!empty($it['data'])) {
        //         if ($key=='identity_card1') {
        //             $post['identi']['identity_card'][] = ['url'=>$it['data'],'name'=>''];
        //         } elseif ($key=='identity_card2') {
        //             $post['identi']['identity_card'][] = ['url'=>$it['data'],'name'=>''];
        //         } elseif ($key=='driving_license') {
        //             $post['identi']['driving_license'] = $it['data'];
        //         } else {
        //             $post['more'][$key] = $it['data'];
        //         }
        //     }
        // }
        // 多图上传 photos
        // $pdata = model('service/Service')->uploadPhotoMulti('photos');
        // $post['more']['photos'][] = [];



        // $id = $this->request->param('id/d');
        // return $this->fetch();
    }
}