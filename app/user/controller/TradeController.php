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

    // public function index()
    // {
    //     $this->seller();
    // }

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
    public function sellerCar()
    {
        error_reporting(E_ALL^(E_WARNING|E_NOTICE));
        $id = $this->request->param('id/d',0,'intval');
        $srcol = $this->request->param('srcol/s','base','strval');
        $userId = cmf_get_current_user_id();
        // 用户认证状态
        $identify = lothar_verify($userId);
        $identify = 1;


        $carModel = new UsualCarModel();
        $post = $carModel->getPost($id);
// dump($post);die;
        $itemModel = new UsualItemModel();
        $districtModel = new DistrictModel();

        if (!empty($post)) {

            $Brands = model('usual/UsualBrand')->getBrands($post['brand_id']);
            $Models = model('usual/UsualModels')->getModels($post['model_id']);
            $Series = model('usual/UsualSeries')->getSeries($post['serie_id']);
            $Series2 = model('usual/UsualSeries')->getSeries($post['serie_id'],0,2);
            $Provinces = $districtModel->getDistricts($post['province_id']);
            $Citys = $districtModel->getDistricts($post['city_id'],$post['province_id']);
            // 车源类别
            $Types = $carModel->getCarType($post['type']);

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
        }

        // 用于前台车辆条件筛选且与属性表name同值的字段码
        $searchCode = $itemModel->getItemSearch();
        // 从属性表里被推荐的
        $recItems = $itemModel->getItemTable('is_rec',1);
        // 属性表里所有属性（不包含推荐的）
        // $where['code'] = where('id','not in','1,5,8');
        $item_rec = Db::name('usual_item_cate')->where('is_rec',1)->column('code');
        $item_rec = implode(',',$item_rec);
        $filter_var = 'car_age,car_mileage,car_displacement,'. $item_rec .','.config('usual_car_filter_var');
        $where['code'] = ['not in',$filter_var];
        $allItems = $itemModel->getItemTable($where,'',true);

        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('Provinces', $Provinces);
        $this->assign('Types', $Types);

        $this->assign('searchCode', $searchCode);
        $this->assign('recItems', $recItems);
        $this->assign('allItems', $allItems);

        $this->assign('post',$post);
        $this->assign('identify',$identify);
        $this->assign('srcol',$srcol);
        return $this->fetch('seller_car');
    }

    public function sellerCarPost()
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

// dump($post);
// die;

            if (!empty($id)) {
                $result = $carModel->adminAddArticle($post);
                $id = $result->id;
            } else {
                $result = $carModel->adminEditArticle($post);
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

    // 取消订单 如果有订金则退还订金
    public function sellerCancel()
    {
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $orderInfo = Db::name('trade_order')->field('buyer_uid,bargain_money')->where('id',$id)->find();
        $bargain_money = floatval($orderInfo['bargain_money']);

        if (empty($bargain_money)) {
            Db::name('trade_order')->where('id',$id)->setField('status',-2);
        } else {
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

    // 订单 客户详情
    public function ajaxBuyer()
    {
        $id = $this->request->param('id/d');
        $buyerInfo = Db::name('trade_order')
            ->field('buyer_uid,buyer_username,buyer_contact,buyer_address')
            ->where('id',$id)->find();
        $identify = lothar_verify($buyerInfo['buyer_uid']);
        $pop = ($identify==1)?'已认证':'未认证';

        // $data = lothar_toJson($data);
        $data = json_encode([
                'name'  => $buyerInfo['buyer_username'],
                'mobile'=> $buyerInfo['buyer_contact'],
                'pop'   => $pop,
                'addr'  => $buyerInfo['buyer_address'],
            ]);

        echo $data;exit();
        // return $data;
    }

    public function more()
    {
        $id = $this->request->param('id/d');
        return $this->fetch();
    }
}