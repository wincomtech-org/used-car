<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        echo "Insurance index!";
        return $this->fetch(':index');
    }
}