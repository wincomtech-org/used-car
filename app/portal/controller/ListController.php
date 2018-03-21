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
use think\Db;

class ListController extends HomeBaseController
{
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $id    = $this->request->param('id', 0, 'intval');
        $childId = $this->request->param('sid', 0, 'intval');

        $curId = $childId ? $childId : ($id?$id:5);
        $portalCategoryModel = new PortalCategoryModel();

        // 当前分类信息
        $category = $portalCategoryModel->where('id', $curId)->where('status', 1)->find();
        // 分类菜单
        $cateMenu = $portalCategoryModel->getCateMenu($id);
        // 当前分类下的文章
        $postService = new PostService();
        $articles = $postService->adminArticleList(['category'=>$curId]);
        // 面包屑
        $crumbs = $this->getCrumbs($curId);

        $this->assign('crumbs', $crumbs);
        $this->assign('cateId', $id);
        $this->assign('childId', $childId);
        $this->assign('category', $category);
        $this->assign('cateMenu', $cateMenu);
        $this->assign('articles', $articles->items());// 获取查询数据并赋到模板
        $articles->appends($param);//添加分页URL参数
        $this->assign('pager', $articles->render());// 获取分页代码并赋到模板

        $listTpl = empty($category['list_tpl']) ? 'list' : $category['list_tpl'];
        return $this->fetch('/' . $listTpl);
    }

}
