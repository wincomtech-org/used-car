<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\portal\service\PostService;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
// $this->success('提交完成','','',100000);
// $this->error('提交失败','','',100000);
        // 保险推荐
        $recommend = model('Insurance')->getPostList();

        $PostService = new PostService();
        // 投保流程
        // 理赔指引
        $claim_guidance = $PostService->fromCateList(8);
// dump($claim_guidance);die;
        $this->assign('recommend',$recommend);
        $this->assign('claim_guidance',$claim_guidance);
        return $this->fetch();
    }
}