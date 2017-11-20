<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use think\Db;

class PostController extends HomeBaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->compId = $this->request->param('compId',0,'intval');
        if (!empty($this->compId)) {
            $companyInfo = Db::name('usual_company')->where('id',$this->compId)->value('name');
            $this->assign('compId',$this->compId);
            $this->assign('companyInfo',$companyInfo);
        }
        // $crumbs = $this->getCrumbs();
        // $this->assign('crumbs',$crumbs);
    }

    public function index()
    {
        $services = model('service/ServiceCategory')->fromCateList();

        $this->assign('services',$services);
        return $this->fetch();
    }

    public function appoint()
    {
        $servId = $this->request->param('servId',0,'intval');
        if (!empty($servId)) {
            $servInfo = model('service/ServiceCategory')->getPost($servId);
            if (!empty($servInfo['define_data'])) {
                $define_data = $servInfo['define_data'];
                $define_data_conf = config('service_define_data');
                $new_data = [];
                foreach ($define_data as $d) {
                    $new_data[] = [
                        'title' => $define_data_conf[$d],
                        'name' => $d
                    ];
                }
                if (!empty(in_array('service_point',$define_data))) {
                    $Provinces = model('admin/District')->getDistricts(0,1);
                    $this->assign('Provinces', $Provinces);
                }
                $this->assign('new_data',$new_data);
            }
            $this->assign('servInfo',$servInfo);
        }
        $servicePoint = model('usual/UsualCoordinate')->getCoordinates(0, ['company_id'=>$this->compId], '请选择服务点');

        $this->assign('servId',$servId);
        $this->assign('servicePoint',$servicePoint);
        return $this->fetch();
    }

    public function appointPost()
    {
        $data = $this->request->param();
        $more = $data['more'];
    }
}