<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use think\Db;

class PostController extends HomeBaseController
{
    public function index()
    {
        $id = $this->request->param('id',0,'intval');

        $companyInfo = Db::name('usual_company')->where('id',$id)->value('name');
        $services = model('service/ServiceCategory')->fromCateList();
        $crumbs = $this->getCrumbs();

        // $this->assign('crumbs',$crumbs);
        $this->assign('companyInfo',$companyInfo);
        $this->assign('services',$services);
        return $this->fetch();
    }

    public function appoint()
    {
        $id = $this->request->param('id',0,'intval');

        $serviceInfo = model('service/ServiceCategory')->getPost($id);
        if (!empty($serviceInfo['define_data'])) {
            # code...
        }

        $this->assign('serviceInfo',$serviceInfo);
        return $this->fetch();
    }
}