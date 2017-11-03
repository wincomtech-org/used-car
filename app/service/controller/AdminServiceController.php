<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
// use app\service\model\ServiceModel;
use think\Db;
// use think\Config;

/**
* 公司企业模块
*/
class AdminServiceController extends AdminBaseController
{
    /*function _initialize()
    {
        // parent::_initialize();
        // dump(config('database.database'));
        // dump(config('service_status'));
    }*/

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $modelId = $this->request->param('modelId', 0, 'intval');

        $data = model('Service')->getLists($param);
        $data->appends($param);
        $categoryTree = model('usual/UsualCategory')->adminCategoryTree($modelId,0,'service_category');

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('modelId', $modelId);
        $this->assign('category_tree', $categoryTree);
        $this->assign('lists', $data->items());
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $categoryTree = model('usual/UsualCategory')->adminCategoryTree(0,0,'service_category');
        $companyTree = model('usual/UsualCompany')->getCompanys(0,0,0,true);

        $this->assign('category_tree', $categoryTree);
        $this->assign('company_tree', $companyTree);
        $this->assign('service_status', model('Service')->getServiceStatus());
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $username = $this->request->param('username/s');
            $user_id = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>['eq', $username]])->value('id');
            if (empty($user_id)) {
                $this->error('系统未检测到该用户');
            }

            $post   = $data['post'];
            $post['user_id'] = intval($user_id);

            $result = $this->validate($post,'Service.add');
            if ($result !== true) {
                $this->error($result);
            }
            model('Service')->adminAddArticle($post);

            // 钩子
            // $post['id'] = model('Service')->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminService/edit', ['id' => model('Service')->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = model('Service')->getPost($id);
        $categoryTree = model('usual/UsualCategory')->adminCategoryTree($post['model_id'],0,'service_category');
        $companyTree = model('usual/UsualCompany')->getCompanys($post['company_id'],0,0,true);

        $this->assign('category_tree', $categoryTree);
        $this->assign('company_tree', $companyTree);
        $this->assign('service_status', model('Service')->getServiceStatus($post['status']));
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $username = $this->request->param('username/s');
            $user_id = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>['eq', $username]])->value('id');
            if (empty($user_id)) {
                $this->error('系统未检测到该用户');
            }

            $post   = $data['post'];
            $post['user_id'] = intval($user_id);
            $result = $this->validate($post, 'Service.edit');
            if ($result !== true) {
                $this->error($result);
            }

            // $post['more']['photos'] = model('Service')->dealFiles(['names'=>$data['photo_names'],'urls'=>$data['photo_urls']]);
            // $post['more']['files'] = model('Service')->dealFiles(['names'=>$data['file_names'],'urls'=>$data['file_urls']]);

            model('Service')->adminEditArticle($post);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = model('Service')
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = model('Service')->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'Service',
                    'name'        => $result['order_sn']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = model('Service')->where(['id' => ['in', $ids]])->select();
            $result  = model('Service')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'Service',
                        'name'        => $value['order_sn']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("禁用成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Service')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }
    public function status()
    {
        $ids = $this->request->param('ids/a');
        $s = $this->request->param('s/d');
        if (!empty($ids) && isset($s)) {
            model('Service')->where(['id'=>['in',$ids]])->update(['status'=>$s]);
            $this->success('状态修改成功');
        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('Service'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }
}