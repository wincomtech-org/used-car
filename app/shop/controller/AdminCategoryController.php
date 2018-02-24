<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use think\Db;

/**
* 服务商城 独立模块
* 类别（类目）
*/
class AdminCategoryController extends AdminBaseController
{
    /**
     * 分类管理
     * @adminMenu(
     *     'name'   => '分类管理',
     *     'parent' => 'shop/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $categoryTree = $goodsCate->shopGoodsCategoryTableTree();

        $this->assign('category_tree', $categoryTree);
        return $this->fetch();
    }

    // 新增
    public function add()
    {
        $parentId = $this->request->param('parent', 0, 'intval');
        $goodsCate = new ShopGoodsCategoryModel();
        $categoriesTree = $goodsCate->adminCategoryTree($parentId);

        $this->assign('categories_tree', $categoriesTree);
        return $this->fetch();
    }
    public function addPost()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $data = $this->request->param();

        $result = $this->validate($data, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        $result = $goodsCate->addCategory($data);

        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminCategory/index'));
    }

    // 编辑
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = ShopGoodsCategoryModel::get($id)->toArray();

            $goodsCate = new ShopGoodsCategoryModel();
            // $category = $goodsCate->get($id)->toArray();
            $categoriesTree      = $goodsCate->adminCategoryTree($category['parent_id'], $id);
            //显示分类对应的属性
            $list=Db::name('shop_category_attr')
            ->field('ta.*,a.name as aname')
            ->alias('ta')
            ->join('cmf_shop_goods_attr a','a.id=ta.attr_id')
            ->where('cate_id',$id)->select();
            $attrs=Db::name('shop_goods_attr') 
            ->where('status',1)
            ->order('list_order asc')
            ->select();
             dump($list);dump($attrs);exit;
            $this->assign($category);
            $this->assign('list',$list);
            $this->assign('attrs',$attrs);
            $this->assign('categories_tree', $categoriesTree);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        $goodsCate = new ShopGoodsCategoryModel();
        $result = $goodsCate->editCategory($data);

        if ($result === false) {
            $this->error('保存失败!');
        }
        $this->success('保存成功!');
    }
    
    public function listOrder()
    {
        parent::listOrders(Db::name('shop_goods_category'));
        $this->success("排序更新成功！", '');
    }

    // 分类选择对话框
    public function select()
    {
        $ids = $this->request->param('ids');
        $selectedIds = explode(',', $ids);
        $goodsCate = new ShopGoodsCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;
        $config = ['url'=>'shop/AdminCategory/edit'];
        $categoryTree = $goodsCate->adminCategoryTableTree($selectedIds, $tpl, $config);
// dump($categoryTree);die;
        $where      = ['delete_time' => 0];
        $categories = $goodsCate->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function delete()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $id = $this->request->param('id');

        //获取删除的内容
        $findCategory = $goodsCate->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $goodsCate->where('parent_id', $id)->count();
        if ($categoryChildrenCount > 0) {
            $this->error('此分类有子类无法删除!');
        }
            //分类下有产品不能删除
        $categoryPostCount = Db::name('shop_goods')->where('cate_id', $id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此分类下有产品无法删除!');
        }
 
        // 删除操作，删除之后删除类与属性的对应
       
        Db::startTrans();
        try{
            $row=$goodsCate->where('id', $id)->delete();
            if($row===1){
                Db::name('shop_category_attr')->where('cate_id',$id)->delete();
                Db::commit();
            }else{
                throw \Exception('删除失败');
            }
            
        }catch(\Exception $e){
            Db::rollback();
            $this->error('删除失败!'.$e->getMessage());
        }
        $this->success('删除成功!');
        
    }

    /**
     * 分类属性管理
     * @adminMenu(
     *     'name'   => '分类属性管理',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性管理',
     *     'param'  => ''
     * )
     */
    public function attrs()
    {
        $data = $this->request->param();
        $where=[];
        if(empty($data['cid'])){
            $data['cid']=0;
        }else{
            $where['c.id']=['eq',$data['cid']];
        }
        if(empty($data['aname'])){
            $data['aname']='';
        }else{
            $where['a.name']=['like','%'.$data['aname'].'%'];
        }
        $list=Db::name('shop_category_attr')
        ->alias('ca')
        ->field('ca.*,a.name as aname,c.name as cname')
        ->join('cmf_shop_goods_attr a','a.id=ca.attr_id')
        ->join('cmf_shop_goods_category c','c.id=ca.cate_id')
        ->where($where)->order('c.path asc,ca.list_order asc')->paginate(10);
        $goodsCate = new ShopGoodsCategoryModel();
        $categoriesTree = $goodsCate->adminCategoryTree($data['cid']);
        
        $this->assign('categories_tree', $categoriesTree);
        $this->assign('list',$list);
        $this->assign('data',$data);
        $this->assign('pager',$list->render());
        return $this->fetch();
    }
    /**
     * 分类属性添加
     * @adminMenu(
     *     'name'   => '分类属性添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性添加',
     *     'param'  => ''
     * )
     */
    public function attrs_add()
    {
        $data = $this->request->param();
         
        if(empty($data['cid'])){
            $data['cid']=0;
        } 
        
        $goodsCate = new ShopGoodsCategoryModel();
        $categoriesTree = $goodsCate->adminCategoryTree($data['cid']);
        //获取属性
        $attrs=Db::name('shop_goods_attr')
        ->where('status',1)
        ->order('name asc')
        ->select();
        $this->assign('categories_tree', $categoriesTree);
        $this->assign('attrs', $attrs);
        return $this->fetch();
    }
    /**
     * 分类属性添加执行
     * @adminMenu(
     *     'name'   => '分类属性添加执行',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性添加执行',
     *     'param'  => ''
     * )
     */
    public function attrs_addPost()
    {
        $data = $this->request->param();
        $m=Db::name('shop_category_attr');
        $find=$m->where(['cate_id'=>$data['cate_id'],'attr_id'=>$data['attr_id']])->find();
        if(!empty($find)){
            $this->error('该属性已存在');
        }
       try {
           $m->insert($data);
       }catch (\Exception $e) { 
           $this->error('添加失败,请刷新重试');
       } 
         $this->success('添加成功'); 
    }
    
    /**
     * 类别属性状态修改
     * @adminMenu(
     *     'name'   => '类别属性状态修改',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '类别属性状态修改',
     *     'param'  => ''
     * )
     */
    public function changeStatus1()
    {
        
        $data = $this->request->param();
        
        $m = Db::name('shop_category_attr');
        
        if (isset($data['ids'])) {
            $ids = $this->request->param('ids/a');
            
            $m->where(['id' => ['in', $ids]])->update([$data["type"]=> $data["value"]]);
            
            $this->success("更新成功！");
            
        }
        $this->success("更新失败！");
    }
    
    // 排序
    /**
     * 类别属性排序
     * @adminMenu(
     *     'name'   => '类别属性排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '类别属性排序',
     *     'param'  => ''
     * )
     */
    public function listOrder1()
    {
        parent::listOrders(Db::name('shop_category_attr'));
        $this->success("排序更新成功！", '');
    }
    /**
     * 类别属性删除
     * @adminMenu(
     *     'name'   => '类别属性删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '类别属性删除',
     *     'param'  => ''
     * )
     */
    public function delete1()
    {
         
        $m=Db::name('shop_category_attr');
       
        $param = $this->request->param();
      
        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $row=$m->where('id',$id)->delete();
            if($row==1){
                $this->success("删除成功！");
            }else{
                $this->success("删除失败！");
            }
           
            
        }
        
        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            
            $result  = $m->where(['id' => ['in', $ids]])->delete();
            if ($result>0) {
                
                $this->success("删除成功！", '');
            } else{
                $this->success("删除失败！");
            }
        }
        $this->success("删除失败！");
    }
}