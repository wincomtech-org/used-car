<?php
namespace app\usual\model;

use think\Model;
use app\usual\model\UsualCategoryModel;

class UsualModelsModel extends UsualCategoryModel
{
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }
}