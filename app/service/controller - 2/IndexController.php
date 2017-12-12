<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use app\portal\service\PostService;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $servId = $this->request->param('servId',null);
        
        $extra = ['a.status'=>1,'a.is_yewu'=>1];
        $companys = model('usual/UsualCompany')->getPostList('','','',$extra);
        $noobInfo = model('service/ServiceCategory')->getPost(1);
        $postService = new PostService();
        $articles = $postService->fromCateList(9,5);


        $this->assign('servId',$servId);
        $this->assign('companys',$companys);
        $this->assign('noobInfo',$noobInfo);
        $this->assign('articles',$articles);
        return $this->fetch();
    }
}