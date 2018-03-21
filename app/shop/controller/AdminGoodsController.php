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

        $cateModel = new ShopGoodsCategoryModel;
        // 获取分类面包屑
        $cateCrumbs = model('ShopGoodsCategory')->cateCrumbs($cateId);
        // 品牌
        $brands = model('ShopBrand')->getBrands();
        // 状态
        $statusOptions = $this->scModel->getGoodsStatus();
        // 规格 递归？
        $specs = $cateModel->getSpecByCate($cateId);
        // 属性
        $attrs = $cateModel->getAttrByCate($cateId,[]);


        $this->assign('cateCrumbs', $cateCrumbs);
        $this->assign('brands', $brands);
        $this->assign('statusOptions', $statusOptions);
        $this->assign('specs', $specs);
        $this->assign('attrs', $attrs);

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
        $cateId = intval($post['cate_id']);

        // 验证
        $result = $this->validate($post, 'Goods.add');
        if ($result !== true) {
            $this->error($result);
        }
        // 处理文件图片
        $style = config('thumbnail_size');
        if (!empty($data['photo'])) {
            $post['photos'] = lothar_dealFiles($data['photo'],$style);
        } else {
            $post['photos'] = [];
        }
        if (!empty($data['file'])) {
            $post['files'] = lothar_dealFiles($data['file']);
        } else {
            $post['files'] = [];
        }
        if (!empty($post['thumbnail'])) {
            $thumbnail = cmf_asset_relative_url($post['thumbnail']);
            $post['thumbnail'] = lothar_thumb_make($thumbnail,$style);
        } else {
            $post['thumbnail'] = '';
        }
        if (!empty($cateId)) {
            $parent_id = Db::name('shop_goods_category')->where('id',$cateId)->value('parent_id');
            if ($parent_id>0) {
                $post['cate_id_1'] = $parent_id;
                $post['cate_id_2'] = $cateId;
            } else {
                $post['cate_id_1'] = $cateId;
            }
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

        $cateModel = new ShopGoodsCategoryModel;
        // 获取分类面包屑
        $cateId = empty($cateId) ? $post['cate_id'] : $cateId;
        if (empty($cateId)) {
            $this->error('请选择分类！');
        }
        $cateCrumbs = $cateModel->cateCrumbs($cateId);
        // 品牌
        $brands = model('ShopBrand')->getBrands($post['brand_id']);
        // 状态
        $statusOptions = $this->scModel->getGoodsStatus($post['status']);

        // 规格 递归？
        // $specs = $cateModel->getSpecByCate($cateId);//所有规格
        // 采用单一规格处理
        // 获取所有已经入库的规格
        $goods_spec = Db::name('shop_goods_spec')->field('id,goods_id,spec_vars,market_price,price,stock,more')->where('goods_id',$id)->select();

        // 属性
        $attrs = $cateModel->getAttrByCate($cateId,[]);// 所有属性以及值
        $goods_attrs = Db::name('shop_goods_item')->field('attr_id,av_id')->where('goods_id',$id)->select();
        $goods_attrs2 = [];
        foreach ($goods_attrs as $row) {
            $goods_attrs2[$row['attr_id']] = $row['av_id'];
        }

// dump($goods_spec);die;


        $this->assign('cateCrumbs', $cateCrumbs);
        $this->assign('brands', $brands);
        $this->assign('statusOptions', $statusOptions);

        // $this->assign('specs', $specs);
        $this->assign('goods_spec', $goods_spec);
        $this->assign('attrs', $attrs);
        $this->assign('goods_attrs', $goods_attrs2);

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
// dump($data);die;
        $post = $data['post'];
        $id   = intval($post['id']);
        $cateId = intval($post['cate_id']);
        if (empty($id)) {
            $this->error('数据错误');
        }

        // 验证
        $result = $this->validate($post, 'Goods.edit');
        if ($result !== true) {
            $this->error($result);
        }

/*数据处理*/
        $style = config('thumbnail_size');
        // dump($data['photo']);die;
        // 处理文件图片
        if (!empty($data['photo'])) {
            $post['photos'] = lothar_dealFiles($data['photo'],$style);
        } else {
            $post['photos'] = [];
        }
        if (!empty($data['file'])) {
            $post['files'] = lothar_dealFiles($data['file']);
        } else {
            $post['files'] = [];
        }
        if (!empty($post['thumbnail'])) {
            $thumbnail = cmf_asset_relative_url($post['thumbnail']);
            $post['thumbnail'] = lothar_thumb_make($thumbnail,$style);
        } else {
            $post['thumbnail'] = '';
        }

        // 处理分类
        if (!empty($cateId)) {
            $post['cate_id_1'] = Db::name('shop_goods_category')->where('id',$cateId)->value('parent_id');
            $post['cate_id_2'] = $cateId;
        }
        if (!empty($cateId)) {
            $parent_id = Db::name('shop_goods_category')->where('id',$cateId)->value('parent_id');
            if ($parent_id>0) {
                $post['cate_id_1'] = $parent_id;
                $post['cate_id_2'] = $cateId;
            } else {
                $post['cate_id_1'] = $cateId;
            }
        }

        // 处理规格 shop_goods_spec
        // $post['more']['spec'] = '';
        $goods_spec = isset($data['spec'])?$data['spec']:'';//所有数据

        // 提取新增的 插入
        if (!empty($goods_spec['new'])) {
            $specNew = $goods_spec['new'];
        }
        // 已有的更新
        if (!empty($goods_spec['old'])) {
            $specOld = $goods_spec['old'];
        }
        // 要删除的

// dump($goods_spec);
// die;


        // 处理属性 shop_goods_item 
        // 事实上无论是 goods_id,attr_id 还是 goods_id,av_id 都已经组成了唯一条件
        $attrs = isset($data['attr'])?$data['attr']:[];//所有属性
        $gav = [];
        if (!empty($attrs)) {
            // $post['more']['attr'] = $data['attr'];
            $attrs_old =  $data['goods_attrs'];
            // $attrs_old = json_decode($attrs_old,true);
            $attrs_old = unserialize($attrs_old);
            if (!is_array($attrs_old)) {
                $this->error('属性数据非法');
            }
            if (empty($attrs_old)) {
                foreach ($attrs as $key => $row) {
                    $gav[] = ['goods_id'=>$id,'attr_id'=>$key,'av_id'=>$row];
                // dump($gav);die;
                }
            } else {
                $old_ids = array_values($attrs_old);
                $attr_ids = array_values($attrs);
                // 比较两个数组差集
                $diff1 = array_diff($old_ids,$attr_ids);
                $diff2 = array_diff($attr_ids,$old_ids);
                // 增加的 
                if (!empty($diff2)) {
                    foreach ($diff2 as $row) {
                        $gav[] = ['goods_id'=>$id,'attr_id'=>array_search($row, $attrs),'av_id'=>$row];
                    }
                } else {
                    $gav = [];
                }
                // 减少的用 delete() 解决，不更新
            }
        }

        // 其它项
        $post['update_time'] = time();



        // 事务处理
        $result = true;
        Db::startTrans();
        try {
            // $result = $this->scModel->where('id', $id)->update($post);
            $this->scModel->isUpdate(true)->allowField(true)->save($post, ['id'=>$id]);
            if (!empty($gav)) {
                if (isset($diff1)) {
                    Db::name('shop_goods_item')->where(['goods_id'=>$id,'av_id'=>['in',$diff1]])->delete();
                }
                Db::name('shop_goods_item')->insertAll($gav);
            }
            if (isset($specNew)) {
                Db::name('shop_goods_spec')->insertAll($specNew);
                // model('ShopGoodsSpec')->saveAll($specNew);
            }
            if (isset($specOld)) {
                model('ShopGoodsSpec')->saveAll($specOld);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $result = false;
        }

        if ($result === true) {
            // lothar_admin_log('编辑商品-id:' . $id . '-name:' . $post['name']);
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
