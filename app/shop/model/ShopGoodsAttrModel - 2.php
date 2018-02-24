<?php
namespace app\shop\model;

use think\Model;

/**
* 商品属性模型 cmf_shop_goods_attr
*/
class ShopGoodsAttrModel extends Model
{
    protected $type = [
        'more' => 'array',
    ];
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    // protected $hidden = ['delete_time', 'update_time'];
    // 关联商品表 cmf_shop_goods
    public function attrGoods()
    {
        return $this->belongsToMany('ShopGoodsModel', 'shop_gav', 'goods_id', 'attr_id');
    }
    // 关联分类表 cmf_shop_category_attr
    public function attrCates()
    {
        return $this->belongsToMany('ShopGoodsCategoryModel', 'shop_category_attr', 'category_id', 'attr_id');
    }

    /*添加属性*/
    public function addAttr($data,$categories)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();

        if (isset($categories)) {
            if (is_string($categories)) {
                $categories = explode(',', $categories);
            }
            $this->attrCates()->save($categories);
        }

        return $this;
    }

    /*编辑属性*/
    public function editAttr($data, $categories)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();

        if (isset($categories)) {
            if (is_string($categories)) {
                $categories = explode(',', $categories);
            }
            // 去重
            $oldCategoryIds        = $this->categories()->column('category_id');
            $sameCategoryIds       = array_intersect($categories, $oldCategoryIds);
            $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
            $newCategoryIds        = array_diff($categories, $sameCategoryIds);
            // 更新
            if (!empty($needDeleteCategoryIds)) {
                $this->categories()->detach($needDeleteCategoryIds);
            }
            if (!empty($newCategoryIds)) {
                $this->categories()->attach(array_values($newCategoryIds));
            }
        }

        return $this;
    }

    /*删除属性*/
    public function deleteAttr($data)
    {
        # code...
    }
}