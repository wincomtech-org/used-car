<?php
namespace app\shop\service;

use app\shop\model\ShopGoodsAttrModel;
use app\shop\model\ShopGoodsCategoryModel;

class AttrService
{
    // 获取属性列表
    public function adminAttrList($filter=[], $order='', $limit='', $extra=[], $field='*')
    {
        $field = 'a.*';
        $join = [];
        $where = [
            'a.delete_time' => 0
        ];
        // 查找分类
        $category = empty($filter['category']) ? 0 : intval($filter['category']);
        if (!empty($category)) {
            $where['b.category_id'] = ['eq', $category];
            array_push($join, ['__SHOP_CATEGORY_ATTR__ b', 'a.id = b.attr_id']);
            $field .= 'b.id AS attr_category_id,b.list_order,b.category_id';
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }
        // 其它项
        $order = empty($order) ? 'a.id DESC' : $order;
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        $attrModel = new ShopGoodsAttrModel();
        $series = $attrModel->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $series;

    }

    // 获取文章
    public function publishedArticle($postId, $categoryId = 0)
    {
        $attrModel = new ShopGoodsAttrModel();

        if (empty($categoryId)) {

            $where = [
                'post.post_type'      => 1,
                'post.published_time' => [['< time', time()], ['> time', 0]],
                'post.post_status'    => 1,
                'post.delete_time'    => 0,
                'post.id'             => $postId
            ];

            $article = $attrModel->alias('post')->field('post.*')
                ->where($where)
                ->find();
        } else {
            $where = [
                'post.post_type'       => 1,
                'post.published_time'  => [['< time', time()], ['> time', 0]],
                'post.post_status'     => 1,
                'post.delete_time'     => 0,
                'relation.category_id' => $categoryId,
                'relation.post_id'     => $postId
            ];

            $join    = [
                ['__PORTAL_CATEGORY_POST__ relation', 'post.id = relation.post_id']
            ];
            $article = $attrModel->alias('post')->field('post.*')
                ->join($join)
                ->where($where)
                ->find();
        }

        return $article;
    }

}