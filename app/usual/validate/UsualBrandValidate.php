<?php
namespace app\usual\validate;

use app\admin\model\RouteModel;
use think\Validate;
// use think\Db;

class UsualBrandValidate extends Validate
{
    protected $rule = [
        'name'  => 'require',
        'parent_id'  => 'checkParentId',
        'alias' => 'checkAlias',
    ];
    protected $message = [
        'name.require'  => '名称不能为空',
        'parent_id'     => '超过了2级',
    ];

    // 场景验证 ， 指定场景需要验证的字段
    protected $scene = [
       // 'add'  => ['name,parent_id,alias'],
       // 'edit' => ['parent_id,alias'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('UsualBrand')->where(["id" => $value])->value('parent_id');
        if ($find) {
            return false;
            // $find2 = Db::name('UsualBrand')->where(["id" => $find])->value('parent_id');
            // if ($find2) {
            //     $find3 = Db::name('UsualBrand')->where(["id" => $find2])->value('parent_id');
            //     if ($find3) {
            //         return false;
            //     }
            // }
        }
        return true;
    }

    protected function checkAlias($value, $rule, $data)
    {
        if (empty($value)) {
            return true;
        }

        $routeModel = new RouteModel();
        if (isset($data['id']) && $data['id'] > 0){
            $fullUrl    = $routeModel->buildFullUrl('portal/List/index', ['id' => $data['id']]);
        }else{
            $fullUrl    = $routeModel->getFullUrlByUrl($data['alias']);
        }
        if (!$routeModel->exists($value, $fullUrl)) {
            return true;
        } else {
            return "别名已经存在!";
        }

        return true;
    }
}