<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        echo "Service index!";
        return $this->fetch();
    }
}