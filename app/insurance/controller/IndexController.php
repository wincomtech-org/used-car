<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        echo "Insurance index!";
        return $this->fetch(':index');
    }
}