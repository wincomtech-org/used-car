<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsAttrModel;
use app\shop\model\ShopGoodsAvModel;
use app\shop\service\AttrService;
use think\Db;

/**
* 服务商城 独立模块
* 属性
* 属性值
* 产品属性关系
*/
class AdminAttrController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $categoryId = $this->request->param('category', 0, 'intval');

        $postService = new AttrService();
        $list = $postService->adminAttrList($param);

        $cateModel = new ShopGoodsCategoryModel();
        $categoryTree = $cateModel->adminCategoryTree($categoryId);

        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('category_tree', $categoryTree);
        $this->assign('category', $categoryId);
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $categories = $data['categories'];
            // 验证
            $result = $this->validate($post, 'Attr');
            if ($result !== true) {
                $this->error($result);
            }

            $attrModel = new ShopGoodsAttrModel();
            $attrModel->addAttr($post, $categories);

            $this->success('添加成功!', url('AdminAttr/edit', ['id' => $attrModel->id]));
        }

    }
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $attrModel = new ShopGoodsAttrModel();
        $post = $attrModel->where('id', $id)->find();
        // ???
        $postCategories  = $post->attrCates()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds = implode(',', array_keys($postCategories));

        $this->assign('post', $post);
        $this->assign('post_categories', $postCategories);
        $this->assign('post_category_ids', $postCategoryIds);

        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $categories = $data['categories'];
            // 验证
            $result = $this->validate($post, 'Attr');
            if ($result !== true) {
                $this->error($result);
            }

            $attrModel = new ShopGoodsAttrModel();
            $attrModel->editAttr($post, $categories);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();
        $attrModel = new ShopGoodsAttrModel();


        // 软删除操作
        // $transStatus = true;
        // try{
        //     $goodsCate->where('id', $id)->update(['delete_time'=>time()]);
        //     Db::name('recycleBin')->insert($data);
        // }catch(\Exception $e){
        //     Db::rollback();
        //     $transStatus = false;
        // }



        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $attrModel->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'portal_post',
                'name'        => $result['post_title']
            ];
            $resultPortal = $attrModel
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                Db::name('portal_category_post')->where(['post_id'=>$id])->update(['status'=>0]);
                Db::name('portal_tag_post')->where(['post_id'=>$id])->update(['status'=>0]);

                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');

        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $attrModel->where(['id' => ['in', $ids]])->select();
            $result  = $attrModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'portal_post',
                        'name'        => $value['post_title']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    // 显示隐藏、置顶、推荐
    public function changeStatus()
    {
        $data = $this->request->param();
        $attrModel = new ShopGoodsAttrModel();
dump($data);die;
        if (isset($data['ids']) && isset($data["yes"])) {
            $ids = $this->request->param('ids/a');

            $attrModel->where(['id' => ['in', $ids]])->update(['recommended' => 1]);

            $this->success("推荐成功！", '');

        }
        if (isset($data['ids']) && isset($data["no"])) {
            $ids = $this->request->param('ids/a');

            $attrModel->where(['id' => ['in', $ids]])->update(['recommended' => 0]);

            $this->success("取消推荐成功！", '');

        }
    }

    // 排序
    public function listOrder()
    {
        parent::listOrders(Db::name('portal_category_post'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }






/*属性值*/
    // 列表
    public function listav()
    {
        $filter = $this->request->param();
        
        return $this->fetch();
    }
    public function addav()
    {
        return $this->fetch();
    }
    public function addavPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }
    public function editav()
    {
        return $this->fetch();
    }
    public function editavPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }
    
}