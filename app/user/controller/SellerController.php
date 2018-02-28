<?php
namespace app\user\controller;

use app\admin\model\DistrictModel;
// use app\user\model\UserModel;
use app\portal\model\PortalPostModel;
use app\user\controller\TradeController;
use app\usual\model\UsualBrandModel;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualItemModel;
use app\usual\model\UsualModelsModel;
use app\usual\model\UsualSeriesModel;
// use think\Validate;
use think\Db;

/**
 * 个人中心 卖家中心
 */
class SellerController extends TradeController
{
    public function _initialize()
    {
        parent::_initialize();
        $u_s_nav = $this->request->action();
        // dump($u_s_nav);
        $this->assign('u_s_nav', $u_s_nav);
    }

    // 订单
    public function index()
    {
        // $param = $this->request->param();
        // $id = $this->request->param('id/d');
        $userId = $this->user['id'];

        $extra = [
            'seller_uid' => $userId,
            // 'seller_uid' => 1,
        ];

        $list = model('trade/TradeOrder')->getLists([], '', '', $extra);

        // dump($list);die;

        $this->assign('list', $list->items()); // 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render()); // 获取分页代码并赋到模板
        return $this->fetch();
    }

    // 取消订单 如果有订金则退还订金
    public function cancel()
    {
        $id     = $this->request->param('id/d');
        $userId = $this->user['id'];
        bcscale(2);
        $orderInfo     = Db::name('trade_order')->field('buyer_uid,bargain_money')->where('id', $id)->find();
        $bargain_money = floatval($orderInfo['bargain_money']);
        $buyer_uid     = $orderInfo['buyer_uid'];
        $buyer_coin    = DB::name('user')->where('id', $buyer_uid)->value('coin');

        if (empty($bargain_money)) {
            Db::name('trade_order')->where('id', $id)->setField('status', -2);
        } else {
            Db::startTrans();
            $transStatus = false;
            try {
                Db::name('trade_order')->where('id', $id)->setField('status', -2);
                Db::name('user')->where('id', $userId)->dec('coin', $bargain_money);
                Db::name('user')->where('id', $buyer_uid)->setInc('coin', $bargain_money);
                lothar_put_funds_log($buyer_uid, -6, $bargain_money, bcadd($buyer_coin, $bargain_money), 'user', $userId);
                $transStatus = true;
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                // throw $e;
            }
            if ($transStatus === false) {
                $this->error('取消失败');
            }
        }
        $this->success('取消成功');
    }

    // 车子列表
    public function car()
    {
        // $param = $this->request->param();
        $id     = $this->request->param('id/d');
        $userId = $this->user['id'];
        // $userId = 1;

        $extra = ['a.user_id' => $userId];
        if (!empty($id)) {
            $extra = ['a.id' => $id];
        }

        $list = model('usual/UsualCar')->getLists([], 'a.id DESC', '', $extra);

        $this->assign('list', $list->items()); // 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render()); // 获取分页代码并赋到模板
        return $this->fetch();
    }

    public function carInfoBefore()
    {
        // 卖车资质证明
        $rs = model('trade/Trade')->check_sell($this->user['id']);
        if (!empty($rs)) {
            $this->error($rs[1], $rs[2], '', 5);
        } else {
            $this->success('进入卖车资料填写页……', url('user/Seller/carInfo'));
        }
    }
    // 填写车子信息
    public function carInfo()
    {
        error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));

        $id     = $this->request->param('id/d', 0, 'intval');
        $srcol  = $this->request->param('srcol/s', 'base', 'strval');
        $userId = $this->user['id'];
        // 用户实名认证状态
        $identify = lothar_verify($userId);
        // 开店资料审核 config('verify_define_data');
        $verifyinfo = lothar_verify($userId, 'openshop', 'all');

        // 实例化
        $carModel   = new UsualCarModel();
        $brandModel = new UsualBrandModel();
        $serieModel = new UsualSeriesModel();
        $moModel    = new UsualModelsModel();
        $itemModel  = new UsualItemModel();
        $zoneModel  = new DistrictModel();

        if (empty($id)) {
            $Brands    = $brandModel->getBrands();
            $Models    = $moModel->getModels();
            $Series    = $serieModel->getSeries();
            $provId    = $this->request->param('provId', 1, 'intval');
            $Provinces = $zoneModel->getDistricts(0, $provId);
            // 车源类别
            $Types = $carModel->getCarType();
        } else {
            $post      = $carModel->getPost($id);
            $Brands    = $brandModel->getBrands($post['brand_id']);
            $Models    = $moModel->getModels($post['model_id']);
            $Series    = $serieModel->getSeries($post['serie_id']);
            $Series2   = $serieModel->getSeries($post['serie_id'], 0, 2);
            $Provinces = $zoneModel->getDistricts($post['province_id']);
            $Citys     = $zoneModel->getDistricts($post['city_id'], $post['province_id']);
            // 车源类别
            $Types = $carModel->getCarType($post['type']);
            $this->assign('Series2', $Series2);
            $this->assign('Citys', $Citys);
            $this->assign('post', $post);
        }

        // 用于前台车辆条件筛选且与属性表name同值的字段码
        $searchCode = $itemModel->getItemSearch();
        // 从属性表里被推荐的
        $recItems = $itemModel->getItemTable('is_rec', 1);
        // 属性表里所有属性（不包含推荐的）
        // $where['code'] = where('id','not in','1,5,8');
        $item_rec      = Db::name('usual_item_cate')->where('is_rec', 1)->column('code');
        $item_rec      = implode(',', $item_rec);
        $filter_var    = config('usual_car_filter_var02') . ',' . $item_rec . ',' . config('usual_car_filter_var');
        $where['code'] = ['not in', $filter_var];
        $allItems      = $itemModel->getItemTable($where, '', true);

        // 新手帮助
        $portalM   = new PortalPostModel();
        $noobCate  = Db::name('portal_category')->field('name,description')->where(['id' => 9, 'status' => 1])->find();
        $noobHelps = $portalM->getIndexPortalList(9, 'ASC', 7, 'a.id,a.post_title');

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

        $this->assign('identify', $identify);
        $this->assign('verifyinfo', $verifyinfo);
        $this->assign('srcol', $srcol);
        return $this->fetch('car_info');
    }

    public function carInfoPost()
    {
        $userId = $this->user['id'];

        if ($this->request->isPost()) {
            $data      = $this->request->post();
            $carModel  = new UsualCarModel();
            $itemModel = new UsualItemModel();

            // 处理请求数据
            $post = $data['post'];
            if (empty($post['serie_id'])) {
                $post['serie_id'] = $post['serie_pid'];
            }
            $more = $data['post']['more'];
            // $filter_var02 = config('usual_car_filter_var02');
            $filter_var = config('usual_car_filter_var');
            // $filter_var = $filter_var02.','.$filter_var;
            $filter = explode(',', $filter_var);
            foreach ($filter as $var) {
                $more2[$var] = '';
            }
            $more = array_merge($more2, $more);
            $post = $itemModel->ItemMulti($post, $more);
            $post = $carModel->identiStatus($post);

            // 预设值
            $id                  = intval($post['id']);
            $post['platform']    = 2; //二手车。新车平台自己发布
            $post['update_time'] = time();
            if (empty($id)) {
                $post['create_time'] = time();
                $post['user_id']     = $userId;
                $valid               = 'add';
            } else {
                $valid = 'edit';
            }

            // 验证
            $result = $this->validate($post, 'usual/Car.' . $valid);
            if ($result !== true) {
                $this->error($result, null, '', 5);
            }

            /*处理图片*/
            // 直接拿官版的
            if (!empty($data['photo'])) {
                $post['more']['photos'] = $carModel->dealFiles($data['photo']);
            }
            if (!empty($data['file'])) {
                $post['more']['files'] = $carModel->dealFiles($data['file']);
            }

            if (empty($id)) {
                // 二维数组 需要被序列化，用模型处理
                $result = $carModel->adminAddArticle($post);
                $id     = $result->id;
            } else {
                $result = $carModel->adminEditArticle($post);
            }

            $this->success('提交成功', url('Seller/car', ['id' => $id]));
        }
    }

    // 检测项目
    public function report()
    {

        return $this->fetch();
    }
    public function reportPost()
    {
        $data = $this->request->param();
        $post = $data['post'];

        // 图集处理

        $carModel = new UsualCarModel();
        $carModel->adminEditArticle($post);
        dump($carModel->id);die;
        $this->success('提交成功', url('Seller/car', ['id' => $carModel->id]));
    }

    /**
     * 店铺 个人审核资料填写
     * 审核资料重新审核时？
     */
    public function audit()
    {
        $userId     = $this->user['id'];
        $verifyinfo = lothar_verify($userId, 'openshop', 'all');
        // 如果审核通过，不予再审核

        $this->assign('verifyinfo', $verifyinfo);
        return $this->fetch();
    }

    public function auditPost()
    {
        $userId = $this->user['id'];
        $data   = $this->request->param();
        $post   = $data['verify'];

        $post['auth_code'] = 'openshop';
        $post['user_id']   = $userId;

        // 不做车牌号唯一性检测，会省去很多不必要的麻烦。 cmf_verify,cmf_usual_car
        // $this->more();

        // 直接拿官版的
        if (!empty($data['identity_card'])) {
            $post['more']['identity_card'] = model('usual/Usual')->dealFiles($data['identity_card']);
        }
        // 验证数据的完备性
        $result = $this->validate($post, 'usual/Verify.openshop');
        if ($result !== true) {
            $this->error($result);
        }

        // 事务处理
        $transStatus = true;
        Db::startTrans();
        try {
            if (empty($post['id'])) {
                $result = model('usual/Verify')->adminAddArticle($post);
            } else {
                $post['auth_status'] = 2;
                $result              = model('usual/Verify')->adminEditArticle($post);
            }
            // $vid = $result->id;
            // $log = [
            //     'title'     => '店铺认证',
            //     'object'    => 'verify:'.$vid,
            //     'content'   => '客户ID：'.$userId,
            //     'adminurl'  => 7,
            // ];
            // $log = model('usual/News')->newsObject('audit', $vid, $userId);
            // lothar_put_news($log);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus === false) {
            $this->error('提交失败');
        }
        $this->success('提交成功，请耐心等待后台审核……', url('Seller/audit'));
    }

    // 更多……  保留代码
    public function more()
    {
        $userId = $this->user['id'];
        // 车牌号查重 verify、usual_car
        $plateNo    = $post['more']['plateNo'];
        $verifyinfo = DB::name('verify')->where('plateNo', $plateNo)->value('user_id');
        if (!empty($verifyinfo) && $verifyinfo != $userId) {
            $this->error('该车牌号已被用户【ID】：' . $verifyinfo . '用于开店资料审核，请联系管理员');
        }
        if (empty($post['id'])) {
            $post = array_merge([
                'user_id'     => $userId,
                'auth_code'   => 'openshop',
                'create_time' => time(),
            ], $post);
        } else {
        }
        $post['plateNo'] = $plateNo;
    }

}
