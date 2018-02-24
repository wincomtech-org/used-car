<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsModel;
use think\Db;

/**
* 服务商城 独立模块
* 产品
*/
class AdminGoodsController extends AdminBaseController
{
    private $m;
    private $order;
    
    public function _initialize()
    {
        parent::_initialize();
        $this->order = '';
        $this->m = Db::name('shop_goods');
        $this->assign('flag','商品');
        
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
    function index(){
        
        $m=$this->m;
        $where=[];
        $data=$this->request->param();
        if(empty($data['cid'])){
            $data['cid']=0;
        }else{
            $where['cid']=['eq',$data['cid']];
        }
        if(empty($data['name'])){
            $data['name']='';
        }else{
            $where['name']=['like','%'.$data['name'].'%'];
        }
        $list = $m->where($where)->order($this->order)->paginate(10);
        // 获取分页显示
        $page = $list->render();
        
        $CateModel = new CateModel();
        $catesTree      = $CateModel->adminCateTree($data['cid']);
        $cates=Db::name('cate')->order('path asc')->select();
        $tmp=[];
        foreach($cates as $v){
            $tmp[$v['id']]=$v['name'];
        }
        $this->assign('cates',$tmp);
        $this->assign('cates_tree',$catesTree);
        $this->assign('page',$page);
        $this->assign('list',$list);
        $this->assign('cid',$data['cid']);
        $this->assign('name',$data['name']);
        $this->assign('flag','产品名称');
        return $this->fetch();
    }
    /**
     * 产品名称编辑
     * @adminMenu(
     *     'name'   => '产品名称编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '产品名称编辑',
     *     'param'  => ''
     * )
     */
    function edit(){
        $m=$this->m;
        $id=$this->request->param('id');
        $info=$m->where('id',$id)->find();
        $CateModel = new CateModel();
        $catesTree      = $CateModel->adminCateTree();
        $this->assign('cates_tree',$catesTree);
        $this->assign('info',$info);
        $this->assign('flag','产品名称');
        return $this->fetch();
    }
    /**
     * 产品名称编辑_执行
     * @adminMenu(
     *     'name'   => '产品名称编辑_执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '产品名称编辑_执行',
     *     'param'  => ''
     * )
     */
    function editPost(){
        $m=$this->m;
        $data= $this->request->param();
        if(empty($data['id'])){
            $this->error('数据错误');
        }
        
        $data['time']=time();
        
        $row=$m->where('id', $data['id'])->update($data);
        if($row===1){
            $data_action=[
                'aid'=>session('ADMIN_ID'),
                'time'=>time(),
                'type'=>'goods',
                'ip'=>get_client_ip(),
                'action'=>'编辑产品-id'.$data['id'].'-name-'.$data['name'],
            ];
            Db::name('action')->insert($data_action);
            $this->success('修改成功',url('index'));
        }else{
            $this->error('修改失败');
        }
        
    }
    /**
     * 产品名称删除
     * @adminMenu(
     *     'name'   => '产品名称删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '产品名称删除',
     *     'param'  => ''
     * )
     */
    function delete(){
        $m=$this->m;
        $id=$this->request->param('id');
        $count=Db::name('goods_attr')->where('gid',$id)->count();
        if($count>0){
            $this->error('请先删除产品名称所属规格');
        }
        $info=$m->where('id',$id)->find();
        $row=$m->where('id='.$id)->delete();
        if($row===1){
            $data_action=[
                'aid'=>session('ADMIN_ID'),
                'time'=>time(),
                'type'=>'goods',
                'ip'=>get_client_ip(),
                'action'=>'删除产品-id'.$info['id'].'-name-'.$info['name'],
            ];
            Db::name('action')->insert($data_action);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
        
    }
    
    /**
     * 产品名称添加
     * @adminMenu(
     *     'name'   => '产品名称添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '产品名称添加',
     *     'param'  => ''
     * )
     */
    public function add(){
        $CateModel = new CateModel();
        $catesTree      = $CateModel->adminCateTree();
        $this->assign('cates_tree',$catesTree);
        $this->assign('flag','产品名称');
        return $this->fetch();
    }
    
    /**
     * 产品名称添加1
     * @adminMenu(
     *     'name'   => '产品名称添加_执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '产品名称添加_执行',
     *     'param'  => ''
     * )
     */
    public function addPost(){
        
        $m=$this->m;
        $data= $this->request->param();
        
        $data['time']=time();
        $data['insert_time']=time();
        
        $insert=$m->insertGetId($data);
        if($insert>=1){
            $this->success('已成功添加，继续添加规格',url('attr_add',['id'=>$insert]));
        }else{
            $this->error('添加失败');
        }
        exit;
    }

    
}