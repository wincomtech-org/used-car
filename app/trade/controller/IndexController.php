<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        echo "Trade index!";
        return $this->fetch();
    }
}