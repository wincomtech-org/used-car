<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use app\portal\model\PortalCategoryModel;
use app\portal\service\PostService;

class ListController extends HomeBaseController
{
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $id    = $this->request->param('id', 0, 'intval');
        $childId = $this->request->param('sid', 0, 'intval');

        $portalCategoryModel = new PortalCategoryModel();
        $category = $portalCategoryModel->where('id', $id)->where('status', 1)->find();
        $cateMenu = $portalCategoryModel->getCateMenu($id);

        $postService = new PostService();
        $articles = $postService->adminArticleList(['category'=>$id]);

        $this->assign('cateId', $id);
        $this->assign('childId', $childId);
        $this->assign('category', $category);
        $this->assign('cateMenu', $cateMenu);
        $this->assign('articles', $articles->items());// 获取查询数据并赋到模板
        $articles->appends($param);//添加URL参数,跟分页有关系？
        $this->assign('pager', $articles->render());// 获取分页代码并赋到模板

        $listTpl = empty($category['list_tpl']) ? 'list' : $category['list_tpl'];
        return $this->fetch('/' . $listTpl);
    }

}
