<?php
namespace app\shop\controller;

use think\Db;
use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 快递 物流
*/
class AdminExpressController extends AdminBaseController
{
    /**
     * 快递公司列表
     * @adminMenu(
     *     'name'   => '快递管理',
     *     'parent' => 'shop/AdminExpress/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '快递公司列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $list = Db::name('shop_express')->where($param)->order('list_order,id DESC')->paginate();

        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        $list->appends($param);//添加URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    /**
     * 添加快递公司
     * @adminMenu(
     *     'name'   => '添加快递公司',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加快递公司',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加快递公司提交
     * @adminMenu(
     *     'name'   => '添加快递公司提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加快递公司提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $post = $this->opPost();

        $result = Db::name('shop_express')->insert($post);
        if (empty($result)) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminExpress/index'));
    }

    public function opPost($valid='add')
    {
        $data = $this->request->param();
        // dump($data);die;

        $result = $this->validate($data, 'Express.'.$valid);
        if ($result !== true) {
            $this->error($result);
        }

        $post = [
            'name'  => $data['name'],
            'code'  => $data['code'],
            'index' => isset($data['index'])?$data['index']:'*',
        ];

        return $post;
    }

    /**
     * 编辑快递公司
     * @adminMenu(
     *     'name'   => '编辑快递公司',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑快递公司',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $post = Db::name('shop_express')->where('id',$id)->find();
            $this->assign($post);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }

    /**
     * 编辑快递公司提交
     * @adminMenu(
     *     'name'   => '编辑快递公司提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑快递公司提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $id = $this->request->param('id',0,'intval');

        $post = $this->opPost('edit');

        $result = Db::name('shop_express')->where('id',$id)->update($post);
        if (empty($result)) {
            $this->error('保存失败或无变化');
        }

        $this->success('保存成功!',url('index'));
    }

    /**
     * 快递公司排序
     * @adminMenu(
     *     'name'   => '快递公司排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '快递公司排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('shop_express'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除快递公司 回收机制
     * @adminMenu(
     *     'name'   => '删除快递公司',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除快递公司',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = $this->request->param('id');
        $scModel = new ShopBrandModel();
        
        //获取删除的内容
        $find = Db::name('shop_order')->where('shipping_id', $id)->count();
        if ($find>0) {
            $this->error('此快递有关联的订单，无法删除!');
        }

        $result = Db::name('shop_express')->where('id', $id)->delete();
        if ($result) {
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}