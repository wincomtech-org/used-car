<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
// use app\insurance\model\InsuranceCoverageModel;
use think\Db;

class AdminCoverageController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $insuranceId = $this->request->param('insuranceId',0,'intval');
        $companyId = $this->request->param('companyId',0,'intval');

        $data = model('InsuranceCoverage')->getLists($param);
        $data->appends($param);
        $insurances = model('InsuranceCoverage')->getInsurance($insuranceId,$companyId);
        $companys = model('InsuranceCoverage')->getCompany($companyId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('articles', $data->items());
        $this->assign('insurances', $insurances);
        $this->assign('companys', $companys);
        $this->assign('insuranceId', $insuranceId);
        $this->assign('companyId', $companyId);
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $categoryId = $this->request->param('cid',0,'intval');
        $companyId = $this->request->param('comid',0,'intval');

        $insurances = model('InsuranceCoverage')->getInsurance($categoryId,$companyId);
        $companys = model('InsuranceCoverage')->getCompany($companyId);

        $this->assign('categoryId', $categoryId);
        $this->assign('companyId', $companyId);
        $this->assign('insurances', $insurances);
        $this->assign('companys', $companys);
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post,'Insurance');
            if ($result !== true) {
                $this->error($result);
            }
            // dump($post);die;
            model('InsuranceCoverage')->adminAddArticle($post);

            // 钩子
            // $post['id'] = model('InsuranceOrder')->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminCoverage/edit', ['id' => model('InsuranceCoverage')->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $categoryId = $this->request->param('cid', 0, 'intval');
        $companyId = $this->request->param('comid',0,'intval');

        $post = model('InsuranceCoverage')->getPost($id);
        // $post = model('InsuranceCoverage')->where('id', $id)->find();
        $company_id = model('Insurance')->where('id',$post['insurance_id'])->value('company_id');
        $insurances = model('InsuranceCoverage')->getInsurance($post['insurance_id'],$companyId);
        $companys = model('InsuranceCoverage')->getCompany($company_id);

        $this->assign('post', $post);
        $this->assign('insurances', $insurances);
        $this->assign('companys', $companys);
        $this->assign('categoryId', $categoryId);
        $this->assign('companyId', $companyId);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            // dump($data);die;
            $post   = $data['post'];
            $result = $this->validate($post, 'Insurance');
            if ($result !== true) {
                $this->error($result);
            }
            model('InsuranceCoverage')->adminEditArticle($post);

            // 钩子
            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = model('InsuranceCoverage')
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = model('InsuranceCoverage')->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'Insurance',
                    'name'        => $result['name']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = model('InsuranceCoverage')->where(['id' => ['in', $ids]])->select();
            $result  = model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'Insurance',
                        'name'        => $value['name']
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
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("禁用成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceCoverage')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('InsuranceCoverage'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }
}