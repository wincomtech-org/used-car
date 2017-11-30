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
        // $page = model('usual/UsualCar')->getPost($id);
        $page = model('usual/UsualCar')->getPostRelate($id);
        if (empty($page)) {
            abort(404,'数据不存在！');
        }
        // $company = DB::name('UsualCompany')->where(['user_id'=>$page['user_id']])->find();
        // 查找相关属性值 id
        // $item_exchange_var = 'car_color,car_effluent,car_displacement,car_gearbox';
        // $item_exchange = '';
        // dump($page);die;

        $this->assign('page',$page);
        return $this->fetch();
    }

    public function seeCar()
    {
        $id = $this->request->param('id',0,'intval');
        $carInfo = Db::name('usual_car')->field('name,bargain_money')->where('id',$id)->find();

        $this->assign('carInfo',$carInfo);
        return $this->fetch();
    }

    public function deposit()
    {
        return $this->fetch();
    }


// 提交无页面的 function
    public function depositPost()
    {
        # \app\funds\controller\PayController.php
    }

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

        // 获取数据
        // $data = $this->request->param();
        // $data = $_POST;
// var_dump($data);die;
        // $post = [
        //     'brand_id' => $data['brandId'],
        //     'serie_id' => $data['serieId'],
        //     'model_id' => $data['modelId'],
        //     'province_id' => $data['province'],
        //     'city_id' => $data['city'],
        //     'user_id' => $userId,
        //     'identi'   => ['contact'=>'手机：'.$data['tel']],
        // ];
// var_dump($post);die;

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

        // 是否第一次登记 如果是交保证金 deposit
        $rcount = Db::name('user_score_log')->where(['user_id'=>$userId,'action'=>'regCar'])->count();
        if (empty($rcount)) {
            // session('deposit_'.$userInfo['id'], $post);
            // $this->redirect(url('deposit'));
            echo lothar_toJson(0,'系统检测到您还未交保证金',url('deposit'));exit();
        }

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
                'title' => '免费登记卖车信息',
                'object'=> 'usual_car:'.$id,
                'content'=>'客户ID：'.$userInfo['id'].'，车子ID：'.$id
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