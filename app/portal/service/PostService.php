<?php
namespace app\portal\service;

use app\portal\model\PortalPostModel;
use app\portal\model\PortalCategoryModel;
// use app\portal\service\ApiService;

class PostService
{
    public function adminArticleList($filter)
    {
        return $this->adminPostList($filter);
    }

    public function adminPageList($filter)
    {
        return $this->adminPostList($filter, true);
    }

    // 获取文章列表
    public function adminPostList($filter, $isPage = false)
    {
        $where = [
            'a.create_time' => ['>=', 0],
            'a.delete_time' => 0
        ];

        $join = [
            ['__USER__ u', 'a.user_id = u.id']
        ];

        $field = 'a.*,u.user_login,u.user_nickname,u.user_email,u.mobile';

        $category = empty($filter['category']) ? 0 : intval($filter['category']);
        if (!empty($category)) {
            $where['b.category_id'] = ['eq', $category];
            array_push($join, ['__PORTAL_CATEGORY_POST__ b', 'a.id = b.post_id']);
            $field = 'a.*,b.id AS post_category_id,b.list_order,b.category_id,u.user_login,u.user_nickname,u.user_email,u.mobile';
        }

        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.published_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.published_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.published_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.post_title'] = ['like', "%$keyword%"];
        }

        if ($isPage) {
            $where['a.post_type'] = 2;
        } else {
            $where['a.post_type'] = 1;
        }

        $portalPostModel = new PortalPostModel();
        $articles        = $portalPostModel->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('update_time', 'DESC')
            ->paginate(12);

        return $articles;

    }

    // 获取文章
    public function publishedArticle($postId, $categoryId = 0)
    {
        $portalPostModel = new PortalPostModel();

        if (empty($categoryId)) {

            $where = [
                'post.post_type'      => 1,
                'post.published_time' => [['< time', time()], ['> time', 0]],
                'post.post_status'    => 1,
                'post.delete_time'    => 0,
                'post.id'             => $postId
            ];

            $article = $portalPostModel->alias('post')->field('post.*')
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
            $article = $portalPostModel->alias('post')->field('post.*')
                ->join($join)
                ->where($where)
                ->find();
        }

        return $article;
    }

    //上一篇文章
    public function publishedPrevArticle($postId, $categoryId = 0)
    {
        $portalPostModel = new PortalPostModel();

        if (empty($categoryId)) {
            $where = [
                'post.post_type'      => 1,
                'post.published_time' => [['< time', time()], ['> time', 0]],
                'post.post_status'    => 1,
                'post.delete_time'    => 0,
                'post.id '            => ['<', $postId]
            ];

            $article = $portalPostModel->alias('post')->field('post.*')
                ->where($where)
                ->order('id', 'DESC')
                ->find();

        } else {
            $where = [
                'post.post_type'       => 1,
                'post.published_time'  => [['< time', time()], ['> time', 0]],
                'post.post_status'     => 1,
                'post.delete_time'     => 0,
                'relation.category_id' => $categoryId,
                'relation.post_id'     => ['<', $postId]
            ];

            $join    = [
                ['__PORTAL_CATEGORY_POST__ relation', 'post.id = relation.post_id']
            ];
            $article = $portalPostModel->alias('post')->field('post.*')
                ->join($join)
                ->where($where)
                ->order('id', 'DESC')
                ->find();
        }

        return $article;
    }

    //下一篇文章
    public function publishedNextArticle($postId, $categoryId = 0)
    {
        $portalPostModel = new PortalPostModel();
        if (empty($categoryId)) {

            $where = [
                'post.post_type'      => 1,
                'post.published_time' => [['< time', time()], ['> time', 0]],
                'post.post_status'    => 1,
                'post.delete_time'    => 0,
                'post.id'             => ['>', $postId]
            ];

            $article = $portalPostModel->alias('post')->field('post.*')
                ->where($where)
                ->order('id', 'ASC')
                ->find();
        } else {
            $where = [
                'post.post_type'       => 1,
                'post.published_time'  => [['< time', time()], ['> time', 0]],
                'post.post_status'     => 1,
                'post.delete_time'     => 0,
                'relation.category_id' => $categoryId,
                'relation.post_id'     => ['>', $postId]
            ];

            $join    = [
                ['__PORTAL_CATEGORY_POST__ relation', 'post.id = relation.post_id']
            ];
            $article = $portalPostModel->alias('post')->field('post.*')
                ->join($join)
                ->where($where)
                ->order('id', 'ASC')
                ->find();
        }

        return $article;
    }

    public function publishedPage($pageId)
    {
        $where = [
            'post_type'      => 2,
            'published_time' => [['< time', time()], ['> time', 0]],
            'post_status'    => 1,
            'delete_time'    => 0,
            'id'             => $pageId
        ];

        $portalPostModel = new PortalPostModel();
        $page = $portalPostModel
            ->where($where)
            ->find();

        return $page;
    }



/*自定义的*/
    /**
     * [获取指定分类树以及子类的所有文章]
     * 多分类需要去重
     * @param  integer $categoryId [指定ID]
     * @param  string  $filter     [过滤ID]
     * @return [type]              [description]
     */
    public function allFromCateList($categoryId=0, $filterIds='')
    {
        // $postM = new PortalPostModel;
        // $cateM = new PortalCategoryModel;
        // $apiM = new ApiService;
        // 获取所有子类ID
        // $cateSubIds = $api->allSubCategories($categoryId,'key');
    }

    // 获取指定分类下的所有文章
    // subCategories()
    public function fromCateList($categoryId=0, $limit=20, $order='a.id desc', $field='a.id,a.post_title,a.post_keywords,a.post_excerpt,a.post_source,a.post_content')
    {
        $portalPostModel = new PortalPostModel();

        $join    = [
            ['__PORTAL_CATEGORY_POST__ relation', 'a.id = relation.post_id']
        ];
        $where = [
            'a.post_type'       => 1,
            'a.published_time'  => [['< time', time()], ['> time', 0]],
            'a.post_status'     => 1,
            'a.delete_time'     => 0,
            'relation.category_id' => $categoryId
        ];
        $list = $portalPostModel->alias('a')
            ->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select()->toArray();

        return $list;
    }

    // 获取同级的分类文章
    public function vis_a_vis($cateId=12,$limit=5,$order='a.recommended desc',$field='a.id,a.post_title,a.post_keywords,a.post_excerpt,a.post_source,a.post_content')
    {
        if (empty($cateId)) return [];

        $scModel = new PortalCategoryModel();
        // 普通查询
        $pid = $scModel->where('id',$cateId)->value('parent_id');
        // $peerIds = $scModel->where('parent_id',$pid)->column('id');
        $peers = $scModel->field('id,name')->where('parent_id',$pid)->select()->toArray();
        // 使用子查询
        // $subSql = $scModel->where('id',$cateId)->fetchSql(true)->value('parent_id');
        // $subSql = $scModel->field('parent_id')->where('id',$cateId)->buildSql();
        // $peers = $scModel->field('id,name')->where('parent_id','('.$subSql.')')->select()->toArray();
        // $peers = $scModel->field('id,name')->where('parent_id','eq',$subSql)->fetchSql(true)->select();

        $visList = [];
        foreach ($peers as $vo) {
            $vo['list'] = $this->fromCateList($vo['id'], $limit, $order, $field);
            $visList[] = $vo;
        }

        return $visList;
    }

    public function getPageList($type='')
    {
        $where = [
            'post_type'      => 2,
            'published_time' => [['< time', time()], ['> time', 0]],
            'post_status'    => 1,
            'delete_time'    => 0,
        ];
        $portalPostModel = new PortalPostModel();
        $list = $portalPostModel->field('id,post_title,post_alias')->where($where)->select();
        return $list;
    }

}