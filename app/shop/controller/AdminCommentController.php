<?php
namespace app\shop\controller;

use think\Db;
use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 评价
*/
class AdminCommentController extends AdminBaseController
{
    /**
     * 评价列表
     * @adminMenu(
     *     'name'   => '评价管理',
     *     'parent' => 'shop/AdminExpress/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '评价列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $star = $this->request->param('star','');
        $keyword = $this->request->param('keyword','');

        $where = [];
        if (is_numeric($star)) {
            $where['a.star'] = $star;
        }
        if (!empty($keyword)) {
            $where['a.description'] = ['like','%'.$keyword.'%'];
        }

        $list = Db::name('shop_evaluate')->alias('a')
        ->field('a.*,b.user_nickname,b.user_login,b.mobile,c.name')
        ->join([
            ['user b','a.user_id=b.id','LEFT'],
            ['shop_goods c','a.goods_id=c.id']
        ])
        ->where($where)
        ->order('a.id DESC')
        ->paginate();


        $starV = config('shop_evaluate_star');
        $starOption = model('usual/Com')->getStatus($star,$starV);

        $this->assign('keyword', $keyword);
        $this->assign('starV',$starV);
        $this->assign('starOption',$starOption);
        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        $list->appends($param);//添加URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    /**
     * 添加评价
     * @adminMenu(
     *     'name'   => '添加评价',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加评价',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加评价提交
     * @adminMenu(
     *     'name'   => '添加评价提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加评价提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $post = $this->opPost();

        $result = Db::name('shop_evaluate')->insert($post);
        if (empty($result)) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminExpress/index'));
    }

    public function opPost($valid='add')
    {
        $data = $this->request->param();
        // dump($data);die;

        // $result = $this->validate($data, 'Comment.'.$valid);
        // if ($result !== true) {
        //     $this->error($result);
        // }

        $post = [
            'star'  => $data['star'],
            'description'  => $data['description'],
            'status' => isset($data['status'])?$data['status']:'1',
        ];

        return $post;
    }

    /**
     * 编辑评价
     * @adminMenu(
     *     'name'   => '编辑评价',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑评价',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $post = Db::name('shop_evaluate')->alias('a')
            ->field('a.*,b.user_nickname,b.user_login,b.mobile,c.name')
            ->join([
                ['user b','a.user_id=b.id','LEFT'],
                ['shop_goods c','a.goods_id=c.id']
            ])
            ->where('a.id',$id)
            ->find();

            $post['evaluate_image'] = json_decode($post['evaluate_image'],true);
            $post['username'] = model('usual/Com')->getUsername($post);
            $this->assign('post',$post);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }

    /**
     * 编辑评价提交
     * @adminMenu(
     *     'name'   => '编辑评价提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑评价提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $id = $this->request->param('id',0,'intval');

        $post = $this->opPost('edit');

        $result = Db::name('shop_evaluate')->where('id',$id)->update($post);
        if (empty($result)) {
            $this->error('保存失败或无变化');
        }

        $this->success('保存成功!',url('index'));
    }

    /**
     * 评价排序
     * @adminMenu(
     *     'name'   => '评价排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '评价排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('shop_evaluate'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除评价 回收机制
     * @adminMenu(
     *     'name'   => '删除评价',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除评价',
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
            $this->error('此评价有关联的订单，无法删除!');
        }

        $result = Db::name('shop_evaluate')->where('id', $id)->delete();
        if ($result) {
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}