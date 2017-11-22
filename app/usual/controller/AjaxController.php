<?php
namespace app\usual\controller;

use cmf\controller\BaseController;
// use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;
// use think\Db;

/**
* Ajax 集中营
*/
class AjaxController extends BaseController
{
    // public function _initialize()
    // {
    //     parent::_initialize();
    // }

    /*
    * 地区 获取城市数据 city
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function getCitys()
    {
        // if ($this->request->isAjax()) {
        // if ($this->request->isPost()) {
            $parentId = $this->request->param('parentId',0,'intval');
            $ajax = model('admin/District')->getDistricts(0,$parentId,'请选择城市');
            // $ajax_encode = json_encode($ajax);

            // echo $ajax;exit();
            return $ajax;
        // }


        // $parentId = request();
        // $parentId = $this->request->param();
        // return $parentId['parentId'];
        // return request('parentId',0,'intval');
        // return $this->request->param('parentId',0,'intval');
        // echo "kill2";die;
        // echo $this->request->param('parentId');die;
    }

    /*
    * 地区 获取坐标数据 coordinate
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function coordinate()
    {
        // if ($this->request->isPjax()) {
        if ($this->request->isPost()) {
            $compId = $this->request->param('compId',0,'intval');
            $provId = $this->request->param('provId',0,'intval');
            $cityId = $this->request->param('cityId',0,'intval');
            if (!empty($cityId)) {
                return model('UsualCoordinate')->getCoordinates(0, ['company_id'=>$compId,'city_id'=>$cityId], '请选择服务点');
            } elseif (!empty($provId)) {
                return model('UsualCoordinate')->getCoordinates(0, ['company_id'=>$compId,'province_id'=>$provId], '请选择服务点');
            }
            return '<option>--暂无该区数据--</option>';
        }
        return '<option>--数据错误--</option>';
    }

    /*
    * 点击品牌 获取车系数据 series
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function serieByBrand()
    {
        // if ($this->request->isPjax()) {
        if ($this->request->isPost()) {
            $brandId = $this->request->param('brandId',0,'intval');

            $serieModel = new UsualSeriesModel();
            $series = $serieModel->SeriesTree($brandId,false);

            $tpl = '';
            foreach ($series as $v) {
                $tpl .= '<li data-val="'. $v['id'] .'"><input value="'. $v['name'] .'" readonly /></li>';
            }
            return $tpl;
        }
        return '<li><input value="--数据错误--"></li>';
    }
}
