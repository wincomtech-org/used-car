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

        /*获取免费登记卖车信息相关数据 cache('?regCarInfo')*/
        $regCarInfo = cache('regCarInfo');
        if (empty($regCarInfo)) {
            // $brandId = $this->request->param('brandId',0,'intval');
            $provId = $this->request->param('provId',1,'intval');
            // $cityId = $this->request->param('cityId',0,'intval');
            $Brands = model('usual/UsualBrand')->getBrands(0,0,false);
            // $Series = $serieModel->SeriesTree($brandId,false);
            $Models = model('usual/UsualModels')->getModels(0,0,false);
            $Provinces = model('admin/District')->getDistricts(0,$provId);
            // $Citys = model('admin/District')->getDistricts($cityId,$provId);

            $regCarInfo = [
                'brand'=>$Brands,
                // 'serie'=>$Series,
                'model'=>$Models,
                'prov'=>$Provinces,
            ];
            cache('regCarInfo',$regCarInfo,3600);
        }



        /*
        * 车辆买卖 筛选
        *
            url美化：
            条件筛选先用a标签试试 占位符 效果(string类型：00000000)。
            001：车品牌、车系
            01：其它参数
        */
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
        $typeId = $this->request->param('typeId','new');
        $brandId = $this->request->param('brandId/d',0,'intval');// 2大众 4福特
        $serieId = $this->request->param('serieId/d',0,'intval');
        $modelId = $this->request->param('modelId/d',0,'intval');
        $priceId = $this->request->param('priceId/d',0,'intval');

        // 获取筛选相关数据
        // 车源类别
        // $Types = model('usual/UsualCar')->getCarType();// option
        $Types = config('usual_car_type');
        // $Types = array_merge($Types,['new'=>'最新上架','rec'=>'新车推荐']);
        // $Types['new'] = '最新上架';
        // $Types['rec'] = '新车推荐';
        $Types = ['new'=>'最新上架','rec'=>'新车推荐'] + $Types;
        // 品牌
        $Brands = model('usual/UsualBrand')->getBrands($brandId,0,false);
        // 系列
        $serieModel = new UsualSeriesModel();
        if (empty($brandId)) {
            $Series = $serieModel->recSeries();
        } else {
            $recSeries = $serieModel->recSeries($brandId);
            $Series = $serieModel->SeriesTree($brandId,false);
            $this->assign('recSeries',$recSeries);
        }
        // 车型
        $Models = model('usual/UsualModels')->getModels($modelId,0,false);
        // 。。。
        // $Provinces = model('admin/District')->getDistricts(0,1);
        $Prices = model('usual/UsualItem')->getItems(0,21,false);
        // 其它
        $moreTree = model('usual/UsualItem')->getItemTable(['code'=>['IN','car_age,car_mileage,car_displacement,car_effluent,car_color,car_gearbox,car_seating,car_fuel']]);
        // dump($moreTree);die;

        // 筛选机制
        $filter = $where = $order = $carlist = [];
        $url = $jumpurl = $jumpext = '';
        $limit = 20;

        $filter['sell_status'] = 1;

        if (isset($typeId)) {
            if (is_numeric($typeId)) {
                $filter['typeId'] = (int)$typeId;
            } elseif ($typeId=='new') {
                $order = ['a.published_time'=>'DESC'];
            } elseif ($typeId=='rec') {
                $order = ['a.is_rec'=>'DESC'];
            }
        }

        $jumpext = '&param1='.$param1 . '&param2='.$param2;



        /*车辆买卖 车辆数据*/

        // 列表 数据库查询
        $carlist = $carModel->getLists($filter, $order, $limit);



        // 模板赋值
        $this->assign('jumpext',$jumpext);
        $this->assign('typeId',$typeId);
        $this->assign('Types',$Types);
        $this->assign('brandId',$brandId);
        $this->assign('Brands',$Brands);
        $this->assign('serieId',$serieId);
        $this->assign('Series',$Series);
        $this->assign('modelId',$modelId);
        $this->assign('Models',$Models);
        // $this->assign('provId',$provId);
        // $this->assign('Provinces',$Provinces);
        $this->assign('priceId',$priceId);
        $this->assign('Prices',$Prices);
        $this->assign('moreTree',$moreTree);
        $this->assign('regCarInfo',$regCarInfo);

        // 数据分页
        $this->assign('carlist', $carlist->items());// 获取查询数据并赋到模板
        $carlist->appends($param);//添加URL参数,跟分页有关系
        $this->assign('pager', $carlist->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }
}