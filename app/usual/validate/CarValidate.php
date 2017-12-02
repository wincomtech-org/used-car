<?php
namespace app\usual\validate;

use think\Validate;
use think\Db;

class CarValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName',
        'brand_id' => 'require',
        'serie_id' => 'require',
        'model_id' => 'require',
        'user_id' => 'require',
        'car_vin' => 'checkVin',
        'plateNo' => 'require|checkPlateNo',
        'car_mileage' => 'require',
        'car_license_time' => 'require',
        'city_id' => 'require',
        'identi.telephone' => 'require|checkTel',
    ];

    protected $message = [
        'name.require'  => '标题不能为空',
        'name.checkName'  => '车标题已存在！',
        'brand_id' => '请选择所属品牌',
        'serie_id' => '请选择所属车系',
        'model_id' => '请选择车型',
        'user_id' => '车主数据丢失',
        'car_vin.checkVin' => '车架号已存在！',
        'plateNo.require' => '请输入车牌号',
        'plateNo.checkPlateNo' => '车牌号码已存在！',
        'car_mileage' => '请输入里程数',
        'car_license_time' => '请输入上牌时间',
        'city_id' => '请输入所在城市',
    ];

    protected $scene = [
        'add'   => ['name','brand_id','serie_id','model_id','car_vin','plateNo','car_mileage','car_license_time','city_id'],
        'edit'  => ['name'=>'require','brand_id','serie_id','model_id','plateNo'=>'require','car_mileage','car_license_time','city_id'],
        'seller'   => ['brand_id','serie_id','model_id','city_id'],
        'insurance' => ['user_id','plateNo'=>'require'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = Db::name('usual_car')->where('name',$value)->count();
        if ($find>0) return false; return true;
    }
    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('usual_car')->where(['id'=>['neq',$data['id']],'name'=>$value])->count();
        if ($find==0) return true; return false;
    }

    protected function checkVin($value)
    {
        $find = Db::name('usual_car')->where('car_vin',$value)->count();
        if ($find>0) return false;return true;
    }

    protected function isPlateNo($value)
    {
        $regular = "/^[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新使]{1}[A-Z]{1}[0-9a-zA-Z]{5}$/u";
        if (preg_match($regular, $value)) {
            return true;
        }
        return false;
    }
    protected function checkPlateNo($value)
    {
        $find = Db::name('usual_car')->where('plateNo',$value)->count();
        if ($find>0) return false;return true;
    }
    protected function checkTel($value)
    {
        $pattern = '/^1[34578]\d{9}$/';
        if (preg_match($pattern,$value)) {
            return true;
        }
        return false;
    }
}