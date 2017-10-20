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
        echo "Trade index!";
        return $this->fetch();
    }
}