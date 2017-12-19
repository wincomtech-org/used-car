<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualCompanyModel;
use app\usual\model\UsualItemModel;
use think\Db;

/**
* 前台处理车辆信息  详情页
*/
class PostController extends HomeBaseController
{
    public function details()
    {
        $id = $this->request->param('id',0,'intval');

        $carModel = new UsualCarModel();
        // $page = $carModel->getPost($id);
        $page = $carModel->getPostRelate($id);
        if (empty($page)) {
            abort(404,'数据不存在！');
        }

        // $company = Db::name('UsualCompany')->where(['user_id'=>$page['user_id']])->find();

        $itModel = new UsualItemModel();
        // 查找相关属性值 id
        $page2 = $itModel->getItemFilterVar($id);
        $page = array_merge($page,$page2);
        // dump($page['more']);die;

        $allItems = $itModel->getItemShow($page['more']);
        // dump($allItems);die;

        // 获取推荐车辆
        $carTuis = $carModel->getLists([],'',12,['a.is_rec'=>1]);
        // dump($carTuis);

        $this->assign('page',$page);
        $this->assign('allItems',$allItems);
        $this->assign('carTuis',$carTuis);
        return $this->fetch();
    }

    /*预约看车*/
    public function seeCar()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        $id = $this->request->param('id',0,'intval');
        $where['id'] = $id;

        $carInfo = Db::name('usual_car')->field('name,bargain_money,price,car_license_time,car_mileage,car_displacement')->where($where)->find();
        if (empty($carInfo)) {
            abort(404,'数据不存在！');
        }

        $this->assign('carInfo',$carInfo);
        $this->assign('formurl',url('Post/seeCarPost', $where));
        return $this->fetch();
    }
    // 提交预约看车 paytype,action,order_sn,coin
    public function seeCarPost()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 前置数据
        $data = $this->request->param();
        $data['action'] = 'seecar';

        // 获取用户数据
        $user = cmf_get_current_user();
        $username = empty($user['user_nickname']) ? (empty($user['mobile'])?$user['user_login']:$user['mobile']) : $user['user_nickname'];

        $id = $this->request->param('id',0,'intval');
        $jumpurl = url('trade/Post/seeCar',['id'=>$id]);
        // 查重
        $oId = Db::name('trade_order')->where(['buyer_uid'=>$user['id'],'car_id'=>$id])->value('id');
        if (!empty($oId)) {
            $this->error('请勿重复提交',url('user/Buyer/index',['id'=>$oId]));
        }

        // 获取车辆表数据
        $where['a.id'] = $id;
        $carInfo = Db::name('usual_car')->alias('a')
                 ->join('user b','a.user_id=b.id')
                 ->field('a.user_id,a.name,a.bargain_money,b.mobile,b.user_nickname,b.user_login')
                 ->where($where)->find();
        if (empty($carInfo)) {
            $this->error('数据不存在！',url('trade/Index/index'));
        }
        $seller_username = empty($carInfo['user_nickname']) ? (empty($carInfo['mobile'])?$carInfo['user_login']:$carInfo['mobile']) : $carInfo['user_nickname'];

        // 生成车单
        $post = [
            'car_id'            => $id,
            'order_sn'          => cmf_get_order_sn($data['action'].'_'),
            'buyer_uid'         => $user['id'],
            'buyer_username'    => $username,
            'buyer_contact'     => $user['mobile'],
            'seller_uid'        => $carInfo['user_id'],
            'seller_username'   => $seller_username,
            // 'pay_id'            => $data['paytype'],
            'bargain_money'     => $carInfo['bargain_money'],
            'description'       => $carInfo['name'],
            'create_time'       => time(),
        ];
        $intId = Db::name('trade_order')->insertGetId($post);
        if (empty($intId)) {
            $this->error('预约失败,请检查',$jumpurl);
        } else {
            $data['order_sn'] = $post['order_sn'];
            $data['coin']     = $post['bargain_money'];
            unset($data['id']);
            $this->success('前往支付中心……',cmf_url('funds/Pay/callback',$data));
        }
    }

    /*
    * 第一次开店，
    * 开店资料审核 config('verify_define_data');
    */
    public function deposit()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        $setting = cmf_get_option('usual_settings');

        $this->assign('deposit',$setting['deposit']);
        $this->assign('formurl',url('Post/depositPost'));
        return $this->fetch();
    }
    // 提交开店押金 paytype,action,coin
    public function depositPost()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        # \app\funds\controller\PayController.php
        $data = $this->request->param();
        $data['action'] = 'openshop';
        $setting = cmf_get_option('usual_settings');
        $data['coin'] = $setting['deposit'];

        $userId = cmf_get_current_user_id();

        // 检查是否已有记录
        if (Db::name('funds_apply')->where(['user_id'=>$userId,'type'=>$data['action']])->count()>0) {
            $this->error('开店申请记录已存在',url('user/Funds/apply'));
        }

        // 开店申请
        $post = [
            'type'      => 'openshop',
            'user_id'   => $userId,
            'order_sn'  => cmf_get_order_sn($data['action'].'_'),
            'coin'      => $data['coin'],
            'payment'   => $data['paytype'],
            'create_time' => time(),
        ];
        $id = Db::name('funds_apply')->insertGetId($post);

        if (empty($id)) {
            $this->error('开店申请失败');
        }
        $data['order_sn'] = $post['order_sn'];
        $this->success('前往支付中心……',cmf_url('funds/Pay/pay',$data));
    }

    // 登记卖车信息
    public function regCar()
    {
        // 是否登录
        $userId = cmf_get_current_user_id();
        if (empty($userId)) {
            echo lothar_toJson(0,'您尚未登录',url("user/Login/index"));exit();
        }
        // 是否认证
        $identify = lothar_verify();
        if (empty($identify)) {
            echo lothar_toJson(0,'您未进行实名认证，请上传身份证',url('user/Profile/center'));exit();
        }

        // 是否第一次申请登记 如果是交保证金 deposit
        $count = Db::name('user_funds_log')->where(['user_id'=>$userId,'type'=>5])->count();
        if (empty($rcount)) {
            // session('deposit_'.$userInfo['id'], $post);
            // $this->redirect('deposit');
            echo lothar_toJson(0,'系统检测到您还未交保证金',url('deposit'));exit();
        }

        // 获取数据 直接获取不到数据？
        // $data = $this->request->param();
        // $data = $_POST;
// var_dump($data);die;

        $brandId = $this->request->param('brandId');
        $serieId = $this->request->param('serieId');
        $modelId = $this->request->param('modelId');
        $province = $this->request->param('province');
        $city = $this->request->param('city');
        $tel = $this->request->param('tel');
        $code = $this->request->param('code');
        $userInfo = cmf_get_current_user();

        // 验证验证码
        // $isMob = cmf_is_mobile();
        // if (!(cmf_captcha_check($code,1) || cmf_captcha_check($code,2))) {
        if (!cmf_captcha_check($code,1) && !cmf_captcha_check($code,2)) {
            echo lothar_toJson(0,'验证码错误');exit();
        }

        $uname = $userInfo['user_nickname'] ? $userInfo['user_nickname'] : ($userInfo['user_login']?$userInfo['user_login']:$userInfo['user_email']);

        $post = [
            'brand_id' => $brandId,
            'serie_id' => $serieId,
            'model_id' => $modelId,
            'province_id' => $province,
            'city_id'   => $city,
            'name'      => $uname .'的车子-'.rand(100,9999),
            'sell_status' => 0,
            // 'sell_status' => -1,
            'user_id'   => $userInfo['id'],
            'identi'    => ['username'=>'','contact'=>'手机：'.$tel],
        ];

        $result = $this->validate($post, 'usual/Car.seller');
        if ($result !== true) {
            echo lothar_toJson(0,$result);exit();
        }

        // 提交
        Db::startTrans();
        $sta = false;
        try{
            // $id = Db::name('usual_car')->insertGetId($post);
            // identi 需要被序列化，用模型处理
            $result = model('usual/UsualCar')->adminAddArticle($post);
            $id = $result->id;
            $data = [
                'title'     => '免费登记卖车信息',
                'user_id'   => $userInfo['id'],
                'object'    => 'usual_car:'.$id,
                'content'   => '客户ID：'.$userInfo['id'].'，车子ID：'.$id,
                'adminurl'  => 1,
            ];
            lothar_put_news($data);
            // session('deposit_'.$userInfo['id'], null);
            $sta = true;
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }

        if ($sta===true) {
            $result = lothar_toJson(1, '提交成功', url('user/Trade/sellerCar'), ['id'=>$id]);
        } else {
            $result = lothar_toJson(0,'提交失败');
        }
        echo $result;exit();
    }

    public function order()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Trade');
        if ($result !== true) {
            $this->error($result);
        }

        // 提交
        // $result = model('Trade')->adminAddArticle($post);
        // if ($result) {
        //     $this->success('提交成功',url('user/Profile/center'));
        // }
        // $this->error('提交失败');
    }

    public function collect()
    {
        // 是否登录
        $userInfo = cmf_get_current_user();
        if (empty($userInfo)) {
            $this->error('您尚未登录',url("user/Login/index"));
        }
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('请求出错');
        }
        $scount = Db::name('user_favorite')->where(['user_id'=>$userInfo['id'],'table_name'=>'usual_car','object_id'=>$id])->count();
        if ($scount>0) {
            $this->error('您已收藏过');
        }

        $info = Db::name('usual_car')->where('id',$id)->value('name');
        $url = [
            'action' => 'trade/Post/details',
            'param'  => ['id'=>$id]
        ];
        $url = json_encode($url);

        $data = [
            'title'       => $info,
            'url'         => $url,
            'description' => '操作用户['.$userInfo['id'].']'.($userInfo['user_nickname']?$userInfo['user_nickname']:$userInfo['user_login']),
            'table_name'  => 'usual_car',
            'object_id'   => $id,
            'user_id'     => $userInfo['id'],
            'create_time' => time(),
        ];

        $res = Db::name('user_favorite')->insertGetId($data);
        if (!empty($res)) {
            $this->success('收藏成功',url('user/Collect/index'));
        }
        $this->error('收藏失败');
    }
}