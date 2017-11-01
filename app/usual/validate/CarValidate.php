<?php
namespace app\usual\validate;

use think\Validate;

class CarValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName',
        'brand_id' => 'require',
        'serie_id' => 'require',
        'model_id' => 'require',
        'user_id' => 'require',
        'car_vin' => 'require',
        'car_plate_number' => 'require',
        'car_mileage' => 'require',
        'car_license' => 'require',
        'city_id' => 'require',
    ];

    protected $message = [
        'name.require'  => '标题不能为空',
        'name.checkName'  => '车标题已存在！',
        'brand_id' => '请选择所属品牌',
        'serie_id' => '请选择所属车系',
        'model_id' => '请选择车型',
        'user_id' => '车主丢失',
        'car_vin' => '请输入车架号',
        'car_plate_number' => '请输入车牌号',
        'car_mileage' => '请输入里程数',
        'car_license' => '请输入上牌时间',
        'city_id' => '请输入所在城市',
    ];

    protected $scene = [
        'add' => ['name','brand_id','serie_id','model_id','user_id','car_vin','car_plate_number','car_mileage','car_license','city_id'],
        'edit' => ['name'=>'require','brand_id','serie_id','model_id','user_id','car_vin','car_plate_number','car_mileage','car_license','city_id']
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('UsualCar')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }
    protected function checkNameEdit($value)
    {
        $find = model('UsualCar')->where('name',$value)->value('id');
        if ($find) {return true;}
        return false;
    }
}