<?php
namespace app\shop\controller;

use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsModel;
use cmf\controller\AdminBaseController;
use think\Db;

/**
 * 服务商城 独立模块
 * 商品
 */
class AdminGoodsController extends AdminBaseController
{
    private $m;
    private $order;

    public function _initialize()
    {
        parent::_initialize();

        $this->scModel = new ShopGoodsModel();
        // $this->m = Db::name('shop_goods');

        $this->order = '';

        $this->assign('flag', '商品');
    }

    /**
     * 商品管理
     * @adminMenu(
     *     'name'   => '商品管理',
     *     'parent' => 'shop/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $filter = $this->request->param();

        $list = $this->scModel->getLists($filter);

        $this->assign('list', $list->items());
        $list->appends($filter);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }

    /**
     * 商品添加_选分类
     * @adminMenu(
     *     'name'   => '商品添加_选分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品添加_选分类',
     *     'param'  => ''
     * )
     */
    public function addpre()
    {
        $id     = $this->request->param('id/d');
        $cateId = $this->request->param('cate_id', 0, 'intval');

        if (empty($id)) {
            $jumpUrl = url('add');
        } else {
            $jumpUrl = url('edit', ['id' => $id]);
        }

        $cateModel = new ShopGoodsCategoryModel;
        $categorys = $cateModel->adminCategoryTree($cateId);

        $this->assign('jumpUrl', $jumpUrl);
        $this->assign('categorys_tree', $categorys);
        return $this->fetch();
    }
    /**
     * 商品添加
     * @adminMenu(
     *     'name'   => '商品添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品添加',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $cateId = $this->request->param('cate_id/d');
        if (empty($cateId)) {
            $this->error('请选择分类！');
        }
        // 获取分类面包屑
        $cateCrumbs = model('ShopGoodsCategory')->cateCrumbs($cateId);
        // 品牌
        $brands = model('ShopBrand')->getBrands();

        $this->assign('brands', $brands);
        $this->assign('cateCrumbs', $cateCrumbs);
        $this->assign('cateId', $cateId);
        $this->assign('post', ['id'=>0]);
        return $this->fetch();
    }
    /**
     * 商品添加_执行
     * @adminMenu(
     *     'name'   => '商品添加_执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品添加_执行',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $data = $this->request->param();
        $post = $data['post'];

        // 验证
        $result = $this->validate($post, 'Goods.add');
        if ($result !== true) {
            $this->error($result);
        }
        // 处理文件图片
        if (!empty($data['photo'])) {
            $post['more']['photos'] = $this->scModel->dealFiles($data['photo']);
        }
        if (!empty($data['file'])) {
            $post['more']['files'] = $this->scModel->dealFiles($data['file']);
        }
        if (!empty($post['thumbnail'])) {
            $post['thumbnail'] = cmf_asset_relative_url($post['thumbnail']);
        }
        $post['create_time'] = time();
// dump($post);die;
        $result = $this->scModel->allowField(true)->save($post);

        if ($result === 1) {
            lothar_admin_log('添加商品-id:' . $result . '-name:' . $post['name']);
            $this->success('添加成功', url('index'));
        } else {
            $this->error('添加失败');
        }

    }

    /**
     * 商品编辑
     * @adminMenu(
     *     'name'   => '商品编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品编辑',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id     = $this->request->param('id', 0, 'intval');
        $cateId = $this->request->param('cate_id/d');

        if (empty($id)) {
            $this->error('数据非法！');
        }

        $post = $this->scModel->getPost($id);

        // 获取分类面包屑
        $cateId = empty($cateId) ? $post['cate_id'] : $cateId;
        if (empty($cateId)) {
            $this->error('请选择分类！');
        }
        $cateCrumbs = model('ShopGoodsCategory')->cateCrumbs($cateId);
        // 品牌
        $brands = model('ShopBrand')->getBrands($post['brand_id']);

        $this->assign('brands', $brands);
        $this->assign('cateCrumbs', $cateCrumbs);
        $this->assign('cateId', $cateId);
        $this->assign('post', $post);
        return $this->fetch();
    }
    /**
     * 商品编辑_执行
     * @adminMenu(
     *     'name'   => '商品编辑_执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品编辑_执行',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $post = $data['post'];
        $id   = intval($post['id']);
        if (empty($id)) {
            $this->error('数据错误');
        }

        // 验证
        $result = $this->validate($post, 'Goods.edit');
        if ($result !== true) {
            $this->error($result);
        }
        // 处理文件图片
        if (!empty($data['photo'])) {
            $post['more']['photos'] = $this->scModel->dealFiles($data['photo']);
        }
        if (!empty($data['file'])) {
            $post['more']['files'] = $this->scModel->dealFiles($data['file']);
        }
        if (!empty($post['thumbnail'])) {
            $post['thumbnail'] = cmf_asset_relative_url($post['thumbnail']);
        }
        $post['update_time'] = time();

        $result = $this->scModel->isUpdate(true)->allowField(true)->save($post, ['id'=>$id]);
        // $row = $this->scModel->where('id', $id)->update($post);

        if ($result === 1) {
            lothar_admin_log('编辑商品-id:' . $id . '-name:' . $post['name']);
            $this->success('修改成功', url('index'));
        } else {
            $this->error('修改失败');
        }
    }

    /**
     * 商品删除
     * @adminMenu(
     *     'name'   => '商品删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '商品删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = $this->request->param('id');

        $m = Db::name('shop_goods');
        $name = $m->where('id', $id)->value('name');
        $row  = $m->where('id', $id)->delete();
        if ($row === 1) {
            lothar_admin_log('删除商品-id:' . $id . '-name:' . $name);
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 状态操作
     * @adminMenu(
     *     'name'   => '状态操作',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '状态操作',
     *     'param'  => ''
     * )
     */
    public function change()
    {
        $param = $this->request->param();

        if (isset($param['ids'])) {
            $ids = $this->request->param('ids/a');
            unset($param['ids']);
            $this->scModel->where(['id' => ['in', $ids]])->update($param);
            $this->success('操作成功！', '');
        }
    }

}
