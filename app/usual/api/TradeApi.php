<?php
namespace app\usual\api;

use app\usual\model\UsualCarModel;

class TradeApi
{
    /**
     * 分类列表 用于导航选择
     * @return array
     */
    public function nav()
    {
        $carModel = new UsualCarModel();
        $where = [];
        $categories = $carModel->field('id,name')->where($where)->select();

        $return = [
            'rule'  => [
                'action' => 'trade/List/index',
                'param'  => [
                    'id' => 'id'
                ]
            ],//url规则
            'items' => $categories //每个子项item里必须包括id,name,如果想表示层级关系请加上 parent_id
        ];
        return $return;
    }

}