<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use app\usual\model\UsualCarModel;
// use app\admin\model\DistrictModel;
use think\Db;

/**
* 公司企业模块
*/
class AdminCarController extends AdminBaseController
{
    function _initialize()
    {
        // parent::_initialize();
        // $data = $this->request->param();
        $this->UsualModel = new UsualCarModel();
    }

    /**
     * 公司列表
     * @adminMenu(
     *     'name'   => '公司管理',
     *     'parent' => 'usual/AdminCar/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件

        $data        = $this->UsualModel->getLists($param);
        $data->appends($param);

        // $CategoryModel  = new UsualBrandModel();
        // $categoryTree   = $CategoryModel->adminCategoryTree($categoryId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('articles', $data->items());
        // $this->assign('category_tree', $categoryTree);
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    /**
     * 添加公司
     * @adminMenu(
     *     'name'   => '添加公司',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加公司',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $Brands = model('UsualBrand')->getBrands();
        $Models = model('UsualModels')->getModels();
        $Series = model('UsualSeries')->getSeries();
        $proId = $this->request->param('proId',1,'intval');
        $provinces = model('admin/District')->getDistricts(0,$proId);
        // 车源类别
        // $types = model('UsualItem')->getItems(0,1);
        // 颜色
        $colors = model('UsualItem')->getItems(0,2);
        // 燃料类型
        $fuels = model('UsualItem')->getItems(0,3);
        // 排放标准
        $effluents = model('UsualItem')->getItems(0,4);

        // $themeModel        = new ThemeModel();
        // $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');

        // $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('provinces', $provinces);
        $this->assign('colors', $colors);
        $this->assign('fuels', $fuels);
        $this->assign('effluents', $effluents);
        return $this->fetch();
    }

    /**
     * 添加公司提交
     * @adminMenu(
     *     'name'   => '添加公司提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加公司提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $data['post']['user_id'] = cmf_get_current_admin_id();
            $post   = $data['post'];

            $result = $this->validate($post, 'Car.add');
            if ($result !== true) {
                $this->error($result);
            }
            if (!empty($data['photo'])) {
                $post['more']['photos'] = $this->UsualModel->dealFiles($data['photo']);
            }
            if (!empty($data['identity_card'])) {
                $post['identi']['identity_card'] = $this->UsualModel->dealFiles($data['identity_card']);
            }
            if (!empty($data['file'])) {
                $post['more']['files'] = $this->UsualModel->dealFiles($data['file']);
            }

            $this->UsualModel->adminAddArticle($post);

            // 钩子
            // $post['id'] = $this->UsualModel->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminCar/edit', ['id' => $this->UsualModel->id]));
        }
    }

    /**
     * 编辑公司
     * @adminMenu(
     *     'name'   => '编辑公司',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑公司',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = $this->UsualModel->getPost($id);

        $Brands = model('UsualBrand')->getBrands($post['brand_id']);
        $Models = model('UsualModels')->getModels($post['model_id']);
        $Series = model('UsualSeries')->getSeries($post['serie_id']);
        $Series2 = model('UsualSeries')->getSeries($post['serie_id'],0,2);
        $provinces = model('admin/District')->getDistricts($post['province_id']);
        $citys = model('admin/District')->getDistricts($post['city_id'],$post['province_id']);
        // 车源类别
        // $types = model('UsualItem')->getItems($post['type'],1);
        // 颜色
        $colors = model('UsualItem')->getItems($post['car_color'],2);
        // 燃料类型
        $fuels = model('UsualItem')->getItems($post['car_fuel'],3);
        // 排放标准
        $effluents = model('UsualItem')->getItems($post['car_effluent'],4);

        // $themeModel        = new ThemeModel();
        // $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');

        // $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('Series2', $Series2);
        $this->assign('provinces', $provinces);
        $this->assign('citys', $citys);
        $this->assign('colors', $colors);
        $this->assign('fuels', $fuels);
        $this->assign('effluents', $effluents);

        // $themeModel        = new ThemeModel();
        // $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');

        // $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);
        return $this->fetch();
    }

    /**
     * 编辑公司提交
     * @adminMenu(
     *     'name'   => '编辑公司提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑公司提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];

            $result = $this->validate($post, 'Car.edit');
            if ($result !== true) {
                $this->error($result);
            }
            if (!empty($data['photo'])) {
                $post['more']['photos'] = $this->UsualModel->dealFiles($data['photo']);
            }
            if (!empty($data['identity_card'])) {
                $post['identi']['identity_card'] = $this->UsualModel->dealFiles($data['identity_card']);
            }
            if (!empty($data['file'])) {
                $post['more']['files'] = $this->UsualModel->dealFiles($data['file']);
            }

            $this->UsualModel->adminEditArticle($post);

            // 钩子
            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('保存成功!');
        }
    }

    /**
     * 公司删除
     * @adminMenu(
     *     'name'   => '公司删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $param           = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $this->UsualModel->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'UsualCar',
                'name'        => $result['name']
            ];
            $resultPortal = $this->UsualModel
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $this->UsualModel->where(['id' => ['in', $ids]])->select();
            $result  = $this->UsualModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'UsualCar',
                        'name'        => $value['name']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    /**
     * 公司发布
     * @adminMenu(
     *     'name'   => '公司发布',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司发布',
     *     'param'  => ''
     * )
     */
    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("发布成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("隐藏成功！", '');
        }
    }

    /**
     * 公司置顶
     * @adminMenu(
     *     'name'   => '公司置顶',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司置顶',
     *     'param'  => ''
     * )
     */
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }

    /**
     * 公司推荐
     * @adminMenu(
     *     'name'   => '公司推荐',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司推荐',
     *     'param'  => ''
     * )
     */
    public function recommend()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->UsualModel->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }

    /**
     * 公司认证
     * @adminMenu(
     *     'name'   => '公司认证',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '公司认证',
     *     'param'  => ''
     * )
     */
    public function audit()
    {
        # code...
    }

    /**
     * 车系排序
     * @adminMenu(
     *     'name'   => '车系排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('UsualCar'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

}