<?php
namespace app\shop\model;

use app\usual\model\UsualCategoryModel;

class ShopBrandModel extends UsualCategoryModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'id,name,thumbnail,is_rec,status,list_order';
        $where = ['delete_time' => 0];

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'] ;
        if (!empty($keyword)) {
            $where['name'] = ['like',"%$keyword%"];
        }
        
        // 数据量
        $limit = $this->limitCom($limit);

        // $categories = $this->field('id,name,description,list_order')->order("list_order ASC")->where($where)->select()->toArray();

        $categories = $this->field($field)
            ->order('list_order ASC,id DESC')
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

    public function addBrand($data)
    {
        if (!empty($data['thumbnail'])) {
            $data['thumbnail'] = cmf_asset_relative_url($data['thumbnail']);
        }

        $this->allowField(true)->save($data);
        $id = $this->id;
        dump($id);die;
        return $this->id;
    }

    public function editBrand($data)
    {
        $id = intval($data['id']);
        if (!empty($data['thumbnail'])) {
            $data['thumbnail'] = cmf_asset_relative_url($data['thumbnail']);
        }
        $this->isUpdate(true)->allowField(true)->save($data, ['id' => $id]);
        dump($this);die;
        return $this;
    }
}