<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;

class AdminIndexController extends AdminBaseController
{
    public function index()
    {
        echo "Usual index!";
        return $this->fetch();
    }

    public function config()
    {
        echo "Usual Config!";
        return $this->fetch();
    }
}