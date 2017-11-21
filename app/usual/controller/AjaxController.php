<?php
namespace app\usual\controller;

use cmf\controller\HomeBaseController;
use think\Db;

/**
* 前台地区管理
*/
class AjaxController extends HomeBaseController
{

    // 获取城市数据
    public function getCitys()
    {
        $parentId = $this->request->param('parentId',0,'intval');
        return $this->CityData($parentId,'请选择城市');
    }

    // coordinate ajax
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
}
