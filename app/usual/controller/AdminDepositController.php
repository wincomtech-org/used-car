<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use app\usual\model\UsualCoordinateModel;
use app\usual\model\UsualCompanyModel;
use think\Db;

/**
* 公司企业模块
*/
class AdminDepositController extends AdminBaseController
{
    function _initialize()
    {
        parent::_initialize();
        // $data = $this->request->param();
        $this->uModel = new UsualCoordinateModel();
    }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $compId = $this->request->param('compId',0,'intval');

        $data        = $this->uModel->getLists($param);
        $data->appends($param);

        $compModel  = new UsualCompanyModel();
        $CompanyTree   = $compModel->getCompanys($compId);

        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('articles', $data->items());
        $this->assign('company_tree', $CompanyTree);
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $compModel  = new UsualCompanyModel();
        $CompanyTree   = $compModel->getCompanys(0,0,0,true);
        $Provinces = model('admin/District')->getDistricts();

        $this->assign('company_tree', $CompanyTree);
        $this->assign('Provinces', $Provinces);
        return $this->fetch();
    }

    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'Deposit.add');
            if ($result !== true) {
                $this->error($result);
            }

            if (!empty($data['photos'])) {
                $post['more']['photos'] = $this->uModel->dealFiles($data['photos']);
            }
            if (!empty($data['files'])) {
                $post['more']['files'] = $this->uModel->dealFiles($data['files']);
            }

            $this->uModel->adminAddArticle($post);

            // 钩子
            // $post['id'] = $this->uModel->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminDeposit/edit', ['id' => $this->uModel->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = $this->uModel->getPost($id);
        $compModel  = new UsualCompanyModel();
        $CompanyTree   = $compModel->getCompanys($post['company_id'],0,0,true);
        $Provinces = model('admin/District')->getDistricts($post['province_id']);
        $Citys = model('admin/District')->getDistricts($post['city_id'],$post['province_id']);

        $this->assign('post', $post);
        $this->assign('company_tree', $CompanyTree);
        $this->assign('Provinces', $Provinces);
        $this->assign('Citys', $Citys);

        return $this->fetch();
    }

    public function editPost()
    {

        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'Deposit.edit');
            if ($result !== true) {
                $this->error($result);
            }

            if (!empty($data['photos'])) {
                $post['more']['photos'] = $this->uModel->dealFiles($data['photos']);
            }
            if (!empty($data['files'])) {
                $post['more']['files'] = $this->uModel->dealFiles($data['files']);
            }

            $this->uModel->adminEditArticle($post);

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
        $param           = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $this->uModel->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'UsualCoordinate',
                'name'        => $result['name']
            ];
            $result = $this->uModel
                ->where(['id' => $id])
                ->delete();
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $result  = $this->uModel->where(['id' => ['in', $ids]])->delete();
            if ($result) {
                $this->success("删除成功！", '');
            }
        }
    }

    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['status' => 1]);
            $this->success("发布成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("隐藏成功！", '');
        }
    }

    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }

    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->uModel->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }

    // coordinate ajax
    public function Ajax()
    {
        // if ($this->request->isPjax()) {
        if ($this->request->isPost()) {
            $compId = $this->request->param('compId',0,'intval');
            $provId = $this->request->param('provId',0,'intval');
            $cityId = $this->request->param('cityId',0,'intval');
            if (!empty($cityId)) {
                return model('UsualCoordinate')->getCoordinates(0, ['company_id'=>$compId,'city_id'=>$cityId], '请选择服务点');
            } elseif (!empty($provId)) {
                return model('UsualCoordinate')->getCoordinates(0, ['company_id'=>$compId,'province_id'=>$provId], '请选择服务点');
            }
            return '<option>--暂无该区数据--</option>';
        }
        return '<option>--数据错误--</option>';
    }

    public function listOrder()
    {
        // parent::listOrders(Db::name('UsualCoordinate'));
        // $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

}