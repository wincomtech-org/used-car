<?php
namespace app\trade\controller;

use cmf\controller\AdminBaseController;

class AdminIndexController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }
}