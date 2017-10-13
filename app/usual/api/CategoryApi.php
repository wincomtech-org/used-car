<?php
namespace app\usual\api;

use app\portal\model\PortalCategoryModel;

class CategoryApi
{
    /**
     * 分类列表 用于导航选择
     * @return array
     */
    public function nav()
    {
        $portalCategoryModel = new PortalCategoryModel();
        $where = [];
        $categories = $portalCategoryModel->where($where)->select();

        $return = [
            'rule'  => [
                'action' => 'portal/List/index',
                'param'  => [
                    'id' => 'id'
                ]
            ],//url规则
            'items' => $categories //每个子项item里必须包括id,name,如果想表示层级关系请加上 parent_id
        ];
        return $return;
    }

}