<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsAttrModel;
// use app\shop\model\ShopSpecModel;
use think\Db;

/**
 * 服务商城 独立模块
 * 分类（类目、类别）
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
        $cateModel    = new ShopGoodsCategoryModel();
        $categoryTree = $cateModel->shopGoodsCategoryTableTree();

        $this->assign('category_tree', $categoryTree);
        return $this->fetch();
    }

    // 新增
    public function add()
    {
        $parentId       = $this->request->param('parent', 0, 'intval');
        $cateModel      = new ShopGoodsCategoryModel();
        $categoriesTree = $cateModel->adminCategoryTree($parentId);

        $this->assign('categories_tree', $categoriesTree);
        return $this->fetch();
    }
    public function addPost()
    {
        $cateModel = new ShopGoodsCategoryModel();
        $data      = $this->request->param();

        $result = $this->validate($data, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        $result = $cateModel->addCategory($data);

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

            $cateModel = new ShopGoodsCategoryModel();
            // $category = $cateModel->get($id)->toArray();

            // 分类树
            $categoriesTree = $cateModel->adminCategoryTree($category['parent_id'], $id);

            // 规格列表
            $specs = Db::name('shop_spec')->field('id,name')->where('status',1)->order('list_order')->select();//规格ID
            $cate_specIds = Db::name('shop_category_spec')->where('cate_id',$id)->column('spec_id');//原有规格ID
            foreach ($specs as $rol) {
                $rol['check'] = (in_array($rol['id'],$cate_specIds)) ? 'checked' : '';
                $cate_spec[] = $rol;
            }
            $cate_spec_old = empty($cate_specIds)?'':implode(',', $cate_specIds);

            //分类对应的属性
            $cate_attr = '';
            // $cate_attr = Db::name('shop_category_attr')
            //     ->alias('ta')
            //     ->field('a.name as aname')
            //     ->join('shop_goods_attr a', 'a.id=ta.attr_id')
            //     ->where('cate_id', $id)->select()->toArray();
            // 
            $cate_attr = Db::name('shop_category_attr')
                ->alias('ta')
                ->join('shop_goods_attr a', 'a.id=ta.attr_id')
                ->where('cate_id', $id)->column('a.name');
            $cate_attr = implode(',',$cate_attr);

            // 所有属性
            // $attrs = model('ShopGoodsAttr')->getAttrs()->toArray();

            // dump($cate_attr);
            // dump($attrs);exit;

            $this->assign($category);
            $this->assign('cate_spec', $cate_spec);
            $this->assign('cate_spec_old', $cate_spec_old);
            $this->assign('cate_attr', $cate_attr);
            // $this->assign('attrs', $attrs);
            $this->assign('categories_tree', $categoriesTree);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }
    public function editPost()
    {
        $data = $this->request->param();
        $post = $data['post'];

        $result = $this->validate($post, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        // 规格数据处理
        $cate_spec_old = empty($data['cate_spec_old']) ? [] : explode(',', $data['cate_spec_old']);//原有规格ID
        $spec = isset($data['spec']) ? $data['spec'] : [];//规格ID

        // 比较两个数组差集
        $diff1 = array_diff($cate_spec_old,$spec);
        $diff2 = array_diff($spec,$cate_spec_old);
        // 减少的
        // if (!empty($diff1)) {
        //     echo "diff1";
        // } else {
        //     echo "err1";
        // }
        // 增加的
        if (!empty($diff2)) {
            // echo "diff2";
            foreach ($diff2 as $row) {
                $map[] = ['cate_id'=>$post['id'],'spec_id'=>$row];
            }
        } else {
            // echo "err2";
            $map = [];
        }

        $post['spec_subset'] = isset($post['spec_subset']) ? $post['spec_subset'] : 0;

        // 属性单独处理 attrs()
        $post['attr_subset'] = isset($post['attr_subset']) ? $post['attr_subset'] : 0;

        $cateModel = new ShopGoodsCategoryModel();

        // 事务处理
        $transStatus = true;
        Db::startTrans();
        try{
            $cateModel->editCategory($post);
            if (isset($map)) {
                // Db::name('shop_category_spec')->where('cate_id',$post['id'])->delete();
                Db::name('shop_category_spec')->where(['cate_id'=>$post['id'],'spec_id'=>['in',$diff1]])->delete();
                Db::name('shop_category_spec')->insertAll($map);
            }
            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus === false) {
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
        $ids         = $this->request->param('ids');
        $selectedIds = explode(',', $ids);
        $cateModel   = new ShopGoodsCategoryModel();

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
        $config       = ['url' => 'shop/AdminCategory/edit'];
        $categoryTree = $cateModel->adminCategoryTableTree($selectedIds, $tpl, $config);
// dump($categoryTree);die;
        $where      = ['delete_time' => 0];
        $categories = $cateModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function delete()
    {
        $cateModel = new ShopGoodsCategoryModel();
        $id        = $this->request->param('id');

        //获取删除的内容
        $findCategory = $cateModel->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $cateModel->where('parent_id', $id)->count();
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
        try {
            $row = $cateModel->where('id', $id)->delete();
            if ($row === 1) {
                Db::name('shop_category_attr')->where('cate_id', $id)->delete();
                Db::commit();
            } else {
                throw \Exception('删除失败');
            }

        } catch (\Exception $e) {
            Db::rollback();
            $this->error('删除失败!' . $e->getMessage());
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
        $data  = $this->request->param();
        $where = [];
        if (empty($data['cid'])) {
            $data['cid'] = 0;
        } else {
            $where['c.id'] = ['eq', $data['cid']];
        }
        if (empty($data['aname'])) {
            $data['aname'] = '';
        } else {
            $where['a.name'] = ['like', '%' . $data['aname'] . '%'];
        }
        $list = Db::name('shop_category_attr')
            ->alias('ca')
            ->field('ca.*,a.name as aname,c.name as cname')
            ->join('shop_goods_attr a', 'a.id=ca.attr_id')
            ->join('shop_goods_category c', 'c.id=ca.cate_id')
            ->where($where)->order('c.path asc,ca.list_order asc')->paginate(10);
        $cateModel      = new ShopGoodsCategoryModel();
        $categoriesTree = $cateModel->adminCategoryTree($data['cid']);

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('list', $list);
        $this->assign('data', $data);
        $this->assign('pager', $list->render());
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

        if (empty($data['cid'])) {
            $data['cid'] = 0;
        }
        // 分类树
        $cateModel      = new ShopGoodsCategoryModel();
        $categoriesTree = $cateModel->adminCategoryTree($data['cid']);
        //属性树
        $attrModel = new ShopGoodsAttrModel;
        // 排除已有的属性
        $diff = Db::name('shop_category_attr')->where('cate_id',$data['cid'])->column('attr_id');
        $extra = ['id'=>['not in',$diff]];
        $attrs = $attrModel->getAttrs(1,'name asc',$extra);

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('attrs', $attrs);
        $this->assign('data', $data);
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
        $m    = Db::name('shop_category_attr');

        $result = 0;
        if (empty($data['attr_id'])) {
            $this->error('没有选择属性');
        } elseif (count($data['attr_id']) == 1) {
            $post = ['cate_id'=>$data['cate_id'],'is_query'=>$data['is_query'],'list_order'=>$data['list_order'],'attr_id'=>$data['attr_id'][0]];
            $result = $m->insert($post);
        } else {
            foreach ($data['attr_id'] as $row) {
                $post[] = ['cate_id'=>$data['cate_id'],'is_query'=>$data['is_query'],'list_order'=>$data['list_order'],'attr_id'=>$row];
            }
            $result = $m->insertAll($post);
        }

        if (empty($result)) {
            $this->error('添加失败,请刷新重试');
        }

        $this->success('添加成功',url('attrs',['cid'=>$data['cate_id']]));
    }

    /**
     * 分类属性状态修改
     * @adminMenu(
     *     'name'   => '分类属性状态修改',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性状态修改',
     *     'param'  => ''
     * )
     */
    public function changeStatus1()
    {
        $data = $this->request->param();

        $m = Db::name('shop_category_attr');

        if (isset($data['ids'])) {
            $ids = $this->request->param('ids/a');
            $m->where(['id' => ['in', $ids]])->update([$data["type"] => $data["value"]]);
            $this->success("更新成功！");
        }
        $this->success("更新失败！");
    }

    // 排序
    /**
     * 分类属性排序
     * @adminMenu(
     *     'name'   => '分类属性排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性排序',
     *     'param'  => ''
     * )
     */
    public function listOrder1()
    {
        parent::listOrders(Db::name('shop_category_attr'));
        $this->success("排序更新成功！", '');
    }
    /**
     * 分类属性删除
     * @adminMenu(
     *     'name'   => '分类属性删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '分类属性删除',
     *     'param'  => ''
     * )
     */
    public function delete1()
    {

        $m = Db::name('shop_category_attr');

        $param = $this->request->param();

        if (isset($param['id'])) {
            $id  = $this->request->param('id', 0, 'intval');
            $row = $m->where('id', $id)->delete();
            if ($row == 1) {
                $this->success("删除成功！");
            } else {
                $this->success("删除失败！");
            }

        }

        if (isset($param['ids'])) {
            $ids = $this->request->param('ids/a');

            $result = $m->where(['id' => ['in', $ids]])->delete();
            if ($result > 0) {

                $this->success("删除成功！", '');
            } else {
                $this->success("删除失败！");
            }
        }
        $this->success("删除失败！");
    }
}
