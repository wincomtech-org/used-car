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
        $serviceModel = new ServiceCategoryModel();
        $where = [];
        $categories = $serviceModel->where($where)->select();

        $return = [
            'rule'  => [
                'action' => 'service/List/index',
                'param'  => [
                    'id' => 'id'
                ]
            ],//url规则
            'items' => $categories //每个子项item里必须包括id,name,如果想表示层级关系请加上 parent_id
        ];
        return $return;
    }

}