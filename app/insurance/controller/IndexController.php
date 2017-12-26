<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\portal\service\PostService;
use app\usual\model\UsualCompanyModel;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        // 保险公司
        $where = [
            'delete_time'   => 0,
            'identi_status' => 1,
            'status'        => 1,
            'is_rec'        => 1,
            'is_baoxian'    => 1,
        ];
        $uModel = new UsualCompanyModel();
        $companys = $uModel->field('id,name')->where($where)->select()->toArray();
        // $companys = $uModel->createOptions(0, 0, $companys);

        // 获取用户资料 cmf_verify
        $verifyinfo = lothar_verify(null,'openshop',true);

        $postService = new PostService();
        // 投保流程
        // 理赔指引
        $claim_guidance = $postService->fromCateList(8);

        $this->assign('companys',$companys);
        $this->assign('claim_guidance',$claim_guidance);
        return $this->fetch();
    }
}