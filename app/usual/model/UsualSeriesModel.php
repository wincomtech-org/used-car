<?php
namespace app\usual\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class UsualSeriesModel extends UsualModel
{
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

    public function getBrandName($id)
    {
        // $series = $this->where('id',$id)->value('name');
        $series = DB::name('usual_brand')->field('name,parent_id')->where('id',$id)->find();
        $brand = DB::name('usual_brand')->where('id',$series['parent_id'])->value('name');

        return ($brand?$brand .'：':''). $series['name'];
    }
}