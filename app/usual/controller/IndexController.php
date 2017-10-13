<?php
namespace app\usual\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        echo "Usual index!";
        return $this->fetch();
    }
}