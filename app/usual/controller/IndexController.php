<?php
namespace app\usual\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        return 'usual前台Index';
        return $this->fetch();
    }
}