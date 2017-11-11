<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\insurance\model\InsuranceModel;

class ListController extends HomeBaseController
{
    public function index()
    {
        $id                  = $this->request->param('id', 0, 'intval');
        $InsuranceModel = new InsuranceModel();

        $category = $InsuranceModel->where('id', $id)->where('status', 1)->find();

        $this->assign('category', $category);

        $listTpl = empty($category['list_tpl']) ? 'list' : $category['list_tpl'];

        return $this->fetch('/' . $listTpl);
    }

}