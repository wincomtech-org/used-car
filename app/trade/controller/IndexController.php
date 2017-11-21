<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        // echo "Trade index!";
        $brandId = $this->request->param('brandId',2,'intval');// 2大众 4福特
        $serieId = $this->request->param('serieId',0,'intval');
        $modelId = $this->request->param('modelId',0,'intval');



        $Brands = model('usual/UsualBrand')->getBrands($brandId,0,false);
// dump($Brands);
        $serieModel = new UsualSeriesModel();
        $recSeries = $serieModel->recSeries($brandId);
        $Series = $serieModel->SeriesTree($brandId);
// dump($recSeries);
// dump($Series);
// die;
        $Models = model('usual/UsualModels')->getModels($modelId,0,false);

        $this->assign('Brands',$Brands);
        $this->assign('recSeries',$recSeries);
        $this->assign('Series',$Series);
        $this->assign('Models',$Models);
        return $this->fetch();
    }
}