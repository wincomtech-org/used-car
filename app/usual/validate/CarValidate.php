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
        'car_vin' => 'checkVin',
        'plateNo' => 'require|checkPlateNum',
        'car_mileage' => 'require',
        'car_license_time' => 'require',
        'city_id' => 'require',
    ];

    protected $message = [
        'name.require'  => '标题不能为空',
        'name.checkName'  => '车标题已存在！',
        'brand_id' => '请选择所属品牌',
        'serie_id' => '请选择所属车系',
        'model_id' => '请选择车型',
        'car_vin.checkVin' => '车架号已存在！',
        'plateNo.require' => '请输入车牌号',
        'plateNo.checkPlateNum' => '车牌号码已存在！',
        'car_mileage' => '请输入里程数',
        'car_license_time' => '请输入上牌时间',
        'city_id' => '请输入所在城市',
    ];

    protected $scene = [
        'add'   => ['name','brand_id','serie_id','model_id','car_vin','plateNo','car_mileage','car_license_time','city_id'],
        'edit'  => ['name'=>'require','brand_id','serie_id','model_id','plateNo'=>'require','car_mileage','car_license_time','city_id'],
        'order' => ['plateNo'=>'require'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('UsualCar')->where('name',$value)->count();
        if ($find>0) {return false;}
        return true;
    }
    protected function checkNameEdit($value)
    {
        $find = model('UsualCar')->where('name',$value)->count();
        if ($find>0) {return true;}
        return false;
    }
    protected function checkVin($value)
    {
        $find = model('UsualCar')->where('car_vin',$value)->count();
        if ($find>0) {
            return false;
        }
        return true;
    }
    protected function checkPlateNum($value)
    {
        $find = model('UsualCar')->where('plateNo',$value)->count();
        if ($find>0) {
            return false;
        }
        return true;
    }
}