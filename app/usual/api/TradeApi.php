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
        // $carModel = new UsualCarModel();
        // $where = ['sell_status'=>1];
        // $categories = $carModel->field('id,name')->where($where)->select();
        $categories = [
            ['id'=>1,'name'=>'新车'],
            ['id'=>2,'name'=>'二手车'],
            ['id'=>3,'name'=>'服务商城'],
        ];

        $return = [
            'rule'  => [
                'action' => 'trade/Index/platform',
                'param'  => [
                    'plat' => 'id'
                ]
            ],//url规则
            'items' => $categories //每个子项item里必须包括id,name,如果想表示层级关系请加上 parent_id
        ];
        return $return;
    }

}