<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use think\Db;

/**
* 前台处理车辆信息  详情页
*/
class PostController extends HomeBaseController
{

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