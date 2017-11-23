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
            'name'      => $uname .'的车子',
            'user_id'   => $userInfo['id'],
            'identi'    => ['username'=>'','contact'=>'手机：'.$tel],
        ];

        $result = $this->validate($post, 'usual/Car.reg');
        if ($result !== true) {
            return $result;
        }

        // 验证验证码
        if (!cmf_captcha_check($code, 5)) {
            return '验证码错误';
        }


        // 提交
        $result = model('usual/UsualCar')->adminAddArticle($post);
        if ($result) {
            return '提交成功';
        }
        // $this->error('提交失败');
        return '提交失败';
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