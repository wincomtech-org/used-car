<?php
namespace app\usual\api;

use app\service\model\ServiceCategoryModel;

class ServiceApi
{
    /**
     * 分类列表 用于导航选择
     * @return array
     */
    public function nav()
    {
        $scModel = new ServiceCategoryModel();
        $where = ['status'=>1];
        $categories = $scModel->field('id,name')->where($where)->select();

        $return = [
            'rule'  => [
                'action' => 'service/Index/index',
                'param'  => [
                    'servId' => 'id'
                ]
            ],//url规则
            'items' => $categories //每个子项item里必须包括id,name,如果想表示层级关系请加上 parent_id
        ];
        return $return;
    }

}