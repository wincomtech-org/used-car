<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;

class UsualBrandModel extends UsualCategoryModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $where = ['delete_time' => 0];
        $field = 'id,name,description,list_order';
        // 数据量
        $limit = model('usual/Usual')->limitCom($limit);

        // $categories = $this->field('id,name,description,list_order')->order("list_order ASC")->where($where)->select()->toArray();

        $categories = $this->field($field)
            ->order("list_order ASC,id DESC")
            ->where($where)
            ->paginate($limit);

        return $categories;
    }

    public function getBrands($selectId=0, $parentId=0, $option='请选择')
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);

        return $options;
    }
}