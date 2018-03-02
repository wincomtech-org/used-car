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

    /**
     * 新增品牌
     * @param [array] $data [要保存的数据]
     * @param [bool] $return_id [是否返回ID]
     * if ($return_id===true) {
            $result = $this->id;
        }
     * @return [number]       [description]
     */
    public function addBrand($data,$return_id=false)
    {
        if (!empty($data['thumbnail'])) {
            $data['thumbnail'] = cmf_asset_relative_url($data['thumbnail']);
        }

        $result = $this->allowField(true)->save($data);
        
        return ($return_id===true) ? $result : $this ;
    }

    /**
     * 修改品牌
     * @param  [array] $data [要更新的数据]
     * @param  [object] [是否返回$this]
     * @return []       [description]
     */
    public function editBrand($data,$obj=false)
    {
        $id = intval($data['id']);
        if (!empty($data['thumbnail'])) {
            $data['thumbnail'] = cmf_asset_relative_url($data['thumbnail']);
        }
        $result = $this->isUpdate(true)->allowField(true)->save($data, ['id' => $id]);
        return $result;
    }
}