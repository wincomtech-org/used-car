<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        // echo "Trade index!";
        $Brands = model('usual/UsualBrand')->getBrands(0,0,false);
// dump($Brands);


        $this->assign('Brands',$Brands);
        return $this->fetch();
    }
}