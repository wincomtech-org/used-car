<?php
namespace app\shop\controller;

use app\shop\model\ShopGoodsAttrModel;
use cmf\controller\AdminBaseController;
use think\Db;

/**
 * 服务商城 独立模块
 * 属性
 * 属性值
 * 产品属性关系
 */
class AdminAttrController extends AdminBaseController
{
    private $order;
    private $m;
    private $m1;
    public function _initialize()
    {
        parent::_initialize();
        $this->m     = Db::name('shop_goods_attr');
        $this->m1    = Db::name('shop_goods_av');
        $this->order = 'list_order asc,id asc';

    }
    /**
     * 属性管理
     * @adminMenu(
     *     'name'   => '属性管理',
     *     'parent' => 'shop/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $m     = $this->m;
        $data  = $this->request->param();
        $where = [];
        if (empty($data['name'])) {
            $data['name'] = '';
        } else {
            $where['name'] = ['like', '%' . $data['name'] . '%'];
        }
        $list = $m->where($where)->order($this->order)->paginate(10);

        $this->assign('data', $data);

        $this->assign('list', $list->items());
        $list->appends($data);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }
    /**
     * 属性添加
     * @adminMenu(
     *     'name'   => '属性添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性添加',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }
    /**
     * 属性添加执行
     * @adminMenu(
     *     'name'   => '属性添加执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性添加执行',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $data['post'];

            // 验证
            $result = $this->validate($post, 'Attr');
            if ($result !== true) {
                $this->error($result);
            }

            $attrModel = new ShopGoodsAttrModel();
            $attrModel->addAttr($post);

            $this->success('添加成功!', url('AdminAttr/edit', ['id' => $attrModel->id]));
        }

    }
    /**
     * 属性编辑
     * @adminMenu(
     *     'name'   => '属性编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性编辑',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $attrModel = new ShopGoodsAttrModel();
        $post      = $attrModel->where('id', $id)->find();
        // 已有属性值
        $attrs = $this->m1->where('attr_id', $id)->column('name');
        $attrs = implode(',', $attrs);

        $this->assign('attrs', $attrs);
        $this->assign('post', $post);

        return $this->fetch();
    }
    /**
     * 属性编辑执行
     * @adminMenu(
     *     'name'   => '属性编辑执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性编辑执行',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $data['post'];

            // 验证
            $result = $this->validate($post, 'Attr');
            if ($result !== true) {
                $this->error($result);
            }

            $attrModel = new ShopGoodsAttrModel();
            $attrModel->editAttr($post);

            $this->success('保存成功!', url('index'));
        }
    }
    /**
     * 属性删除
     * @adminMenu(
     *     'name'   => '属性删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        //删除属性要看属性有没有在分类下引用,没有才能删除
        $this->error("删除功能暂不开放");
        $m         = $this->m;
        $m1        = $this->m1;
        $param     = $this->request->param();
        $attrModel = new ShopGoodsAttrModel();
        if (isset($param['id'])) {
            $id   = $this->request->param('id', 0, 'intval');
            $rows = $m1->where('attr_id', $id)->count();

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
                        'name'        => $value['post_title'],
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    /**
     * 属性状态修改
     * @adminMenu(
     *     'name'   => '属性状态修改',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性状态修改',
     *     'param'  => ''
     * )
     */
    public function changeStatus()
    {

        $data = $this->request->param();

        $attrModel = new ShopGoodsAttrModel();

        if (isset($data['ids'])) {
            $ids = $this->request->param('ids/a');

            $attrModel->where(['id' => ['in', $ids]])->update([$data["type"] => $data["value"]]);

            $this->success("更新成功！");

        }
        $this->success("更新失败！");
    }

    // 排序
    /**
     * 属性排序
     * @adminMenu(
     *     'name'   => '属性排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders($this->m);
        $this->success("排序更新成功！", '');
    }

/*属性值*/
    /**
     * 属性值列表
     * @adminMenu(
     *     'name'   => '属性值列表',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性值列表',
     *     'param'  => ''
     * )
     */
    public function listav()
    {
        $data  = $this->request->param();
        $where = [];
        if (empty($data['aid'])) {
            $data['aid'] = 0;
        } else {
            $where['a.id'] = ['eq', $data['aid']];
        }
        if (empty($data['name'])) {
            $data['name'] = '';
        } else {
            $where['av.name'] = ['like', '%' . $data['name'] . '%'];
        }

        $list = $this->m1->alias('av')
            ->field('av.*,a.name as aname')
            ->join('shop_goods_attr a', 'a.id=av.attr_id')
            ->where($where)->order('av.attr_id,av.list_order')->paginate(10);

        $attrModel = new ShopGoodsAttrModel();
        $attrs     = $attrModel->getAttrs();

        $this->assign('attrs', $attrs);
        $this->assign('list', $list);
        $this->assign('data', $data);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }
    /**
     * 属性值添加
     * @adminMenu(
     *     'name'   => '属性值添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性值添加',
     *     'param'  => ''
     * )
     */
    public function addav()
    {
        $aid = $this->request->param('aid');

        $attrModel = new ShopGoodsAttrModel();
        $attrs     = $attrModel->getAttrs(1);

        $this->assign('attrs', $attrs);
        $this->assign('aid', $aid);
        return $this->fetch();
    }
    /**
     * 属性值添加执行
     * @adminMenu(
     *     'name'   => '属性值添加执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性值添加执行',
     *     'param'  => ''
     * )
     */
    public function addavPost()
    {
        $data = $this->request->param();
        $m    = $this->m1;

        $where = [
            'attr_id' => $data['attr_id'],
            'name'    => $data['name'],
        ];
        $find = $m->where($where)->count();
        if ($find>0) {
            $this->error('该属性值已存在！');
        }

        $insert = $m->insertGetId($data);
        if ($insert > 0) {
            $this->success('添加成功',url('editav',['id'=>$insert]));
        } else {
            $this->error('添加失败');
        }
    }
    /**
     * 属性值编辑
     * @adminMenu(
     *     'name'   => '属性值编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性值编辑',
     *     'param'  => ''
     * )
     */
    public function editav()
    {
        $id = $this->request->param('id/d',0,'intval');
        $post = $this->m1->where('id',$id)->find();
        $attrModel = new ShopGoodsAttrModel();
        $attrs     = $attrModel->getAttrs(1);

        $this->assign('attrs', $attrs);
        $this->assign($post);
        return $this->fetch();
    }
    /**
     * 属性值编辑执行
     * @adminMenu(
     *     'name'   => '属性值编辑执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '属性值编辑执行',
     *     'param'  => ''
     * )
     */
    public function editavPost()
    {
        $data = $this->request->param();

        // 检测同一属性下其它属性值重名情况
        $where = [
            'attr_id' => $data['attr_id'],
            'id'      => ['neq',$data['id']],
            'name'    => $data['name'],
        ];
        $find = $this->m1->where($where)->count();
        if ($find>0) {
            $this->error('该属性值已存在！');
        }

        $result = $this->m1->update($data);
        if ($result>0) {
            $this->success('保存成功');
        }
        $this->error('更新失败或数据无变化');
    }

}
