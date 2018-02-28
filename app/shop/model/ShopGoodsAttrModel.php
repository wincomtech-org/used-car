<?php
namespace app\shop\model;

use think\Model;

/**
* 商品属性模型 cmf_shop_goods_attr
*/
class ShopGoodsAttrModel extends Model
{

    /*添加属性*/
    public function addAttr($data)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();
 
        return $this;
    }

    /*编辑属性*/
    public function editAttr($data)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();
 
        return $this;
    }

    /*得到所有属性*/
    public function getAttrs($status=null, $order='list_order,id desc', $extra=[])
    {
        $where = [];
        if(!empty($status)){
            $where = ['status'=>$status];
        }
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        $list = $this->field('id,name')->where($where)->order($order)->select();

        return $list;
    }

    /*删除属性*/
    public function deleteAttr($data)
    {
        # code...
    }
     
}