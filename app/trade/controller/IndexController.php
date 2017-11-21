<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;
use app\usual\model\UsualCarModel;

/**
* 车辆买卖 列表
*/
class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        // 实例化
        $serieModel = new UsualSeriesModel();

        // 获取免费登记卖车信息相关数据
        if (cache('?regCarInfo')) {
            $regCarInfo = cache('regCarInfo');
        } else {
            $provId = $this->request->param('provId',1,'intval');
            // $cityId = $this->request->param('cityId',0,'intval');
            $Brands = model('usual/UsualBrand')->getBrands(0,0,false);
            $Series = $serieModel->SeriesTree();
            $Models = model('usual/UsualModels')->getModels(0,0,false);
            $Provinces = model('admin/District')->getDistricts(0,$provId);
            // $Citys = model('admin/District')->getDistricts($cityId,$provId);

            $regCarInfo = [
                'brand'=>$Brands,
                'serie'=>$Series,
                'model'=>$Models,
                'prov'=>$Provinces,
            ];
            cache('regCarInfo',$regCarInfo,3600);
        }



        /*车辆买卖 列表*/
        $carModel = new UsualCarModel();
        // 处理请求
        $param = $this->request->param();

        $param1 = $this->request->param('param1/s','','strval');
        $param2 = $this->request->param('param2/s','','strval');
        if (!empty($param1)) {
            $var_param1 = str_split($param1,3);
        }
        if (!empty($param2)) {
            $var_param2 = str_split($param2,2);
        }
        // $brandId = $this->request->param('brandId/d',2,'intval');// 2大众 4福特
        // $serieId = $this->request->param('serieId/d',0,'intval');
        // $modelId = $this->request->param('modelId/d',0,'intval');



        // 获取相关数据
        // $Brands = model('usual/UsualBrand')->getBrands($brandId,0,false);
        // $serieModel = new UsualSeriesModel();
        // $Series = $serieModel->SeriesTree($brandId);
        // $Models = model('usual/UsualModels')->getModels($modelId,0,false);
        // $Provinces = model('admin/District')->getDistricts(0,1);
        // 车源类别
        // $Types = model('usual/UsualCar')->getCarType();



        // 筛选机制
        $filter = $where = $carlist = [];
        $url = $jumpur = $jumpext = '';

        if (isset($var)) {
            $filter[$var] = '';
        }

        $filter = array_merge($filter,['pagesize'=>20]);
        $jumpext = '&param1='.$param1 . '&param2='.$param2;



        // 数据库查询
        $carlist = $carModel->getLists($filter);
        // 数据分页



        // 模板赋值
        $this->assign('jumpext',$jumpext);
        // $this->assign('Brands',$Brands);
        // $this->assign('recSeries',$recSeries);
        // $this->assign('Series',$Series);
        // $this->assign('Models',$Models);
        $this->assign('regCarInfo',$regCarInfo);

        $this->assign('carlist', $carlist->items());// 获取查询数据并赋到模板
        $carlist->appends($param);//添加URL参数,跟分页有关系
        $this->assign('pager', $carlist->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }
}