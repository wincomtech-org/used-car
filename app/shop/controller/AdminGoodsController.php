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
        $post = [
            'id'        => 0,
            'brand_id'  => 0,
            'status'    => 1,
            'cate_id'   => 0,
        ];
        $this->op($post);
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

        $result = $this->opPost($data);

        if ($result['status'] === true) {
            lothar_admin_log('添加商品-id:' . $result['post']['id'] .'-name:'. $result['post']['name']);
            $this->success('添加成功', url('index'));
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 一些共用逻辑
     * @return [type] [description]
     */
    public function op($post)
    {
        $cateModel = new ShopGoodsCategoryModel;

        // 获取分类面包屑
        $cateId = $this->request->param('cate_id/d');
        $cateId = empty($cateId) ? (isset($post['cate_id'])?$post['cate_id']:0) : $cateId;
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
        // 属性
        $attrs = $cateModel->getAttrByCate($cateId,[]);// 所有属性以及值


        $this->assign('cateCrumbs', $cateCrumbs);
        $this->assign('brands', $brands);
        $this->assign('statusOptions', $statusOptions);
        // $this->assign('specs', $specs);
        $this->assign('attrs', $attrs);

        $this->assign('cateId', $cateId);
        $this->assign('post', $post);
    }
    public function opPost($data, $id=0, $valid='add')
    {
        $post = $data['post'];
        $cateId = intval($post['cate_id']);

        // 验证
        $result = $this->validate($post, 'Goods.'.$valid);
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

        // 处理分类
        if (!empty($cateId)) {
            $parent_id = Db::name('shop_goods_category')->where('id',$cateId)->value('parent_id');
            if ($parent_id>0) {
                $post['cate_id_1'] = $parent_id;
                $post['cate_id_2'] = $cateId;
            } else {
                $post['cate_id_1'] = $cateId;
            }
        }

        /*处理规格 shop_goods_spec*/
        $goods_spec = isset($data['spec'])?$data['spec']:'';//所有数据
        // 提取新增的插入 ，此时goods_id>0才可以
        if (!empty($goods_spec['new'])) {
            $specNew = $goods_spec['new'];
        }
        // 已有的更新
        if (!empty($goods_spec['old'])) {
            $specOld = $goods_spec['old'];
        }
        // 要删除的

        /*其它项*/
        // $post['create_time'] = time();// 模型层中已定义？
        // $post['update_time'] = time();//模型层中已定义

        /*事务处理*/
        $result = true;
        Db::startTrans();
        try {
            if ($valid=='add') {
                $this->scModel->allowField(true)->save($post);
                $id = $this->scModel->id;
                $post['id'] = $id;//用于外面的日志
                // 新规格处理
                if (isset($specNew)) {
                    foreach ($specNew as $key => $sn) {
                        $specNew[$key]['goods_id'] = $id;
                    }
                }
                // 属性处理
                $post2 = $this->set_attr($data,$id);
                Db::name('shop_goods')->where('id',$id)->setField('avids',$post2['avids']);
            } else {
                $post2 = $this->set_attr($data,$id);
                $post['avids'] = $post2['avids'];
                $this->scModel->isUpdate(true)->allowField(true)->save($post, ['id'=>$id]);
                // $this->scModel->where('id', $id)->update($post);
            }
            if (isset($specNew)) {
                Db::name('shop_goods_spec')->insertAll($specNew);
                // model('ShopGoodsSpec')->saveAll($specNew);
            }
            if (isset($specOld)) {
                model('ShopGoodsSpec')->saveAll($specOld);
            }
            if (!empty($post2['diff1'])) {
                Db::name('shop_gav')->where(['goods_id'=>$id,'av_id'=>['in',$post2['diff1']]])->delete();
            }
            if (!empty($post2['gav'])) {
                Db::name('shop_gav')->insertAll($post2['gav']);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            if ($e->getMessage()) {
                $this->error($e->getMessage());
            } else {
                $result = false;
            }
        }
        return ['status'=>$result,'post'=>$post];
    }
    public function set_attr($data=[],$id=0)
    {
        /*处理属性 shop_gav */
        // 这个如果放在try外面，需要锁表？防止同一时间另外数据插入
        // $id = Db::table('information_schema.`TABLES`')->where(['TABLE_SCHEMA'=>config('database')['database'],'TABLE_NAME'=>Db::getTable('shop_goods')])->value('AUTO_INCREMENT');

        // 事实上无论是 goods_id,attr_id 还是 goods_id,av_id 都已经组成了唯一条件
        $attrs = isset($data['attr'])?$data['attr']:[];//所有属性
        $gav = $diff2 = $diff1 = [];
        $avids = '';
        if (!empty($attrs)) {
            // $post['more']['attr'] = $data['attr'];
            $attrs_old =  $data['goods_attrs'];
            if (empty($attrs_old)) {
                foreach ($attrs as $key => $row) {
                    $gav[] = ['goods_id'=>$id,'attr_id'=>$key,'av_id'=>$row];
                    $avs[] = $row;
                }
                // $avs = array_keys($attrs);
            } else {
                // $attrs_old = json_decode($attrs_old,true);
                $attrs_old = unserialize($attrs_old);
                if (!is_array($attrs_old)) {
                    throw new \Exception("属性数据非法");
                }
                $old_ids = array_values($attrs_old);
                $all_ids = array_values($attrs);
                // 比较两个数组差集
                $diff1 = array_diff($old_ids,$all_ids);
                $diff2 = array_diff($all_ids,$old_ids);
                // 新增的 
                if (!empty($diff2)) {
                    foreach ($diff2 as $row) {
                        $gav[] = ['goods_id'=>$id,'attr_id'=>array_search($row, $attrs),'av_id'=>$row];
                    }
                } else {
                    $gav = [];
                }
                // diff1 ,变化的用 delete() 解决，不更新
                $nodiff = array_intersect($old_ids, $all_ids);
                $avs = array_merge($diff2,$nodiff);
            }
            // 不变的、变化的、新增的数据聚合
            $avids = $this->scModel->fixAttr($avs);
        }
        return [
            'gav'   => $gav,
            'diff1' => $diff1,
            'avids' => $avids
        ];
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
        if (empty($id)) {
            $this->error('数据非法！');
        }

        $post = $this->scModel->getPost($id);
        if (empty($post)) {
            $this->error('数据丢失');
        }
        $this->op($post);

        // 采用单一规格处理
        // 获取所有已经入库的规格
        $goods_spec = Db::name('shop_goods_spec')->field('id,goods_id,spec_vars,market_price,price,stock,more')->where('goods_id',$id)->select();

        // 属性
        $goods_attrs = Db::name('shop_gav')->field('attr_id,av_id')->where('goods_id',$id)->select();
        $goods_attrs2 = [];
        foreach ($goods_attrs as $row) {
            $goods_attrs2[$row['attr_id']] = $row['av_id'];
        }

        $this->assign('goods_spec', $goods_spec);
        $this->assign('goods_attrs', $goods_attrs2);
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
        $id = intval($data['post']['id']);
        if (empty($id)) {
            $this->error('数据错误');
        }

        $result = $this->opPost($data,$id,'edit');

        if ($result['status'] === true) {
            // lothar_admin_log('编辑商品-id:' . $id . '-name:' . $result['post']['name']);
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
