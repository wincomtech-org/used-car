<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualCompanyModel;
use think\Db;

/**
* 前台处理车辆信息  详情页
*/
class PostController extends HomeBaseController
{

    public function details()
    {
        $id = $this->request->param('id',0,'intval');
        $page = model('usual/UsualCar')->getPost($id);
        // $company = DB::name('UsualCompany')->where(['car_id'=>$page['id']])->find();

        // dump($page);

        $this->assign('page',$page);
        return $this->fetch();
    }

    public function seeCar()
    {
        return $this->fetch();
    }

    public function regCar()
    {
        // return 'bp';
        // $data = $this->request->param();
        // $data = $_POST;
// var_dump($data);die;
        // $post = [
        //     'brand_id' => $data['brandId'],
        //     'serie_id' => $data['serieId'],
        //     'model_id' => $data['modelId'],
        //     'province_id' => $data['province'],
        //     'city_id' => $data['city'],
        //     'user_id' => cmf_get_current_user_id(),
        //     'identi'   => ['contact'=>'手机：'.$data['tel']],
        // ];

        // 是否登录
        $userId = cmf_get_current_user_id();
        if (empty($userId)) {
            return json_encode([
                'code' => 0,
                "msg"  => '用户尚未登录',
                "data" => "",
                "url"  => url("user/login/index")
            ]);
        }
        // 是否认证
        

        $brandId = $this->request->param('brandId');
        $serieId = $this->request->param('serieId');
        $modelId = $this->request->param('modelId');
        $province = $this->request->param('province');
        $city = $this->request->param('city');
        $tel = $this->request->param('tel');
        $code = $this->request->param('code');
        $userInfo = cmf_get_current_user();

        $uname = $userInfo['user_nickname'] ? $userInfo['user_nickname'] : ($userInfo['user_login']?$userInfo['user_login']:$userInfo['user_email']);

        $post = [
            'brand_id' => $brandId,
            'serie_id' => $serieId,
            'model_id' => $modelId,
            'province_id' => $province,
            'city_id'   => $city,
            'name'      => $uname .'的车子-'.rand(100,9999),
            'sell_status' => -1,
            'user_id'   => $userInfo['id'],
            'identi'    => ['username'=>'','contact'=>'手机：'.$tel],
        ];

        $result = $this->validate($post, 'usual/Car.seller');
        if ($result !== true) {
            return lothar_toJson(0,$result);
        }
        // 验证验证码
        // $isMob = cmf_is_mobile();
        // if (!(cmf_captcha_check($code,1) || cmf_captcha_check($code,2))) {
        if (!cmf_captcha_check($code,1) && !cmf_captcha_check($code,2)) {
            return lothar_toJson(0,'验证码错误');
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
                'title' => '免费登记卖车信息',
                'object'=> 'usual_car:'.$id,
                'content'=>'客户ID：'.$userInfo['id'].'，车子ID：'.$id
            ];
            lothar_put_news($data);
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
        return $result;
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
}