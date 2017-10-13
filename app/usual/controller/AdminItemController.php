<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;

class AdminItemController extends AdminBaseController
{
    public function index()
    {
        echo "Usual Item!";
        // return $this->fetch();
    }

    public function config()
    {
        echo "Usual Config!";
        // return $this->fetch();
    }
}