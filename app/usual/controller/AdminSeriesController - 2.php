<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use app\usual\model\UsualSeriesModel;
use app\usual\service\ArticleService;
use app\usual\model\UsualBrandModel;
use app\usual\model\UsualModelsModel;
use think\Db;
use app\admin\model\ThemeModel;

class AdminSeriesController extends AdminBaseController
{
    function _initialize()
    {
        // parent::_initialize();
        // $data = $this->request->param();
        $this->UsualModel = new UsualSeriesModel();
    }

    /**
     * 车系列表
     * @adminMenu(
     *     'name'   => '车系管理',
     *     'parent' => 'usual/AdminSeries/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $categoryId = $this->request->param('categoryId', 0, 'intval');
        // 等同于以下
        // $categoryId = isset($param['categoryId'])?intval($param['categoryId']):0;

        $postService = new ArticleService();
        $data        = $postService->adminArticleList($param);
        // dump($data);die;
        // dump($data->items());die;
        $data->appends($param);

        $CategoryModel  = new UsualBrandModel();
        $categoryTree   = $CategoryModel->adminCategoryTree($categoryId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('articles', $data->items());
        $this->assign('category_tree', $categoryTree);
        $this->assign('categoryId', $categoryId);
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    /**
     * 添加车系
     * @adminMenu(
     *     'name'   => '添加车系',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加车系',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');

        $CategoryModel  = new UsualModelsModel();
        $categoriesTree     = $CategoryModel->adminCategoryTree();

        $this->assign('models_tree', $categoriesTree);
        $this->assign('article_theme_files', $articleThemeFiles);
        return $this->fetch();
    }

    /**
     * 添加车系提交
     * @adminMenu(
     *     'name'   => '添加车系提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加车系提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'UsualSeries');
            if ($result !== true) {
                $this->error($result);
            }
// dump($data);die;
            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }
// dump($data);die;
            $this->UsualModel->adminAddArticle($data['post']);

            // 钩子
            // $data['post']['id'] = $this->UsualModel->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $data['post']
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminSeries/edit', ['id' => $this->UsualModel->id]));
        }

    }

    /**
     * 编辑车系
     * @adminMenu(
     *     'name'   => '编辑车系',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑车系',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $post            = $this->UsualModel->where('id', $id)->find();

        // $postCategories  = $post->categories()->alias('a')->column('a.name', 'a.id');
        // $postCategoryIds = implode(',', array_keys($postCategories));
        $postCategories = $this->UsualModel->getBrandName($post['brand_id']);
        $postCategoryIds = $post['brand_id'];

        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');

        $CategoryModel  = new UsualModelsModel();
        $categoriesTree     = $CategoryModel->adminCategoryTree($post['model_id']);

        $this->assign('models_tree', $categoriesTree);
        $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);
        $this->assign('bname', $postCategories);
        $this->assign('category_ids', $postCategoryIds);

        return $this->fetch();
    }

    /**
     * 编辑车系提交
     * @adminMenu(
     *     'name'   => '编辑车系提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑车系提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {

        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'UsualSeries');
            if ($result !== true) {
                $this->error($result);
            }

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }

            $this->UsualModel->adminEditArticle($data['post']);

            // 钩子
            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $data['post']
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('保存成功!');

        }
    }

    /**
     * 车系删除
     * @adminMenu(
     *     'name'   => '车系删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系删除',
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
                'table_name'  => 'usual_series',
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
                        'table_name'  => 'usual_series',
                        'name'        => $value['name']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    /**
     * 车系发布
     * @adminMenu(
     *     'name'   => '车系发布',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系发布',
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
     * 车系置顶
     * @adminMenu(
     *     'name'   => '车系置顶',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系置顶',
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
     * 车系推荐
     * @adminMenu(
     *     'name'   => '车系推荐',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车系推荐',
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
     * 通用排序
     * @adminMenu(
     *     'name'   => '通用排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '通用排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('usual_series'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

}