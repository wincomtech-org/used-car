<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use app\portal\service\PostService;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $companys = model('usual/UsualCompany')->getPostList();
        $noobInfo = model('service/ServiceCategory')->getPost(1);
        $postService = new PostService();
        $articles = $postService->fromCateList(9,5);

        $this->assign('companys',$companys);
        $this->assign('noobInfo',$noobInfo);
        $this->assign('articles',$articles);
        return $this->fetch();
    }
}