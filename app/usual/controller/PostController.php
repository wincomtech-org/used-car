<?php
namespace app\usual\controller;

use cmf\controller\HomeBaseController;
use think\Db;

/**
* 前台处理车辆信息  详情页
*/
class PostController extends HomeBaseController
{

    public function regCar()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Car.add');
        if ($result !== true) {
            $this->error($result);
        }

        // 验证验证码
        cmf_captcha_check($value, 5);


        // 提交
        // $result = model('Trade')->adminAddArticle($post);
        // if ($result) {
        //     $this->success('提交成功',url('user/Profile/center'));
        // }
        // $this->error('提交失败');
    }
}