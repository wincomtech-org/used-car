<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
use app\service\model\ServiceCategoryModel;
use app\service\model\ServiceModel;
use app\usual\model\UsualCompanyModel;
// use app\usual\model\UsualCategoryModel;
use think\Db;
// use think\Config;

/**
* 车辆业务模块
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
        // $companyId = $this->request->param('companyId', 0, 'intval');

        $data = model('Service')->getLists($param);
        $categoryTree = model('ServiceCategory')->adminCategoryTree($modelId);

        // 模板赋值
        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');

        $this->assign('modelId', $modelId);
        $this->assign('category_tree', $categoryTree);
        $this->assign('lists', $data->items());
        $data->appends($param);
        $this->assign('pager', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $scModel = new ServiceModel();
        $cateModel = new ServiceCategoryModel();
        $compModel = new UsualCompanyModel();

        // $categoryTree = model('usual/UsualCategory')->adminCategoryTree(0,0,'service_category');
        $categoryTree = $cateModel->getOptions();
        $companyTree = $compModel->getCompanys();

        $this->assign('category_tree', $categoryTree);
        $this->assign('company_tree', $companyTree);
        $this->assign('service_status', $scModel->getServiceStatus());
        $this->assign('service_pay_status', $scModel->getStatus('','service_pay_status'));
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $data['post'];
            $username = $this->request->param('username/s');

            $scModel = new ServiceModel();
            // 判断用户
            if (empty($username)) {
                $this->error('客户名不能为空');
            }
            $userId = $scModel->getUid($username);
            if (empty($userId)) {
                $this->error('系统未检测到该用户');
            }
            $count = Db::name('service')->where(['model_id'=>$post['model_id'],'user_id'=>$userId])->count();
            if ($count>0) {
                $this->error('预约单已存在',url('index',['modelId'=>$post['model_id'],'uname'=>$username]));
            }

            // 预处理数据
            $post['user_id'] = $userId;
            $post['create_time'] = time();
            // 验证
            $result = $this->validate($post,'Service.add');
            if ($result !== true) {
                $this->error($result);
            }

            $scModel->adminAddArticle($post);

            $this->success('添加成功!', url('AdminService/edit', ['id'=>$scModel->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = model('Service')->getPost($id);
        $post['coordinate'] = $post['ucs_x'].(empty($post['ucs_y'])?'':','.$post['ucs_y']);

        $scModel = new ServiceModel;
        $cateModel = new ServiceCategoryModel();
        $compModel = new UsualCompanyModel();

        $categoryTree = $cateModel->getOptions($post['model_id']);
        $companyTree = $compModel->getCompanys($post['company_id']);
        // 用户提交资料
        // 更多 more
        $define_data = [];
        if (!empty($post['more'])) {
            $postMore = array_keys($post['more']);
            // $define_data = $cateModel->getDefineData($post['model_id'],false);
            $defconf = config('service_define_data');
            $ddkey = array_keys($defconf);
            foreach ($postMore as $row) {
                if (in_array($row,$ddkey)) {
                    $define_data[] = [
                        'title' => $defconf[$row],
                        'name' => $row
                    ];
                }
            }
        }

        $this->assign('category_tree', $categoryTree);
        $this->assign('company_tree', $companyTree);
        $this->assign('define_data', $define_data);
        $this->assign('service_status', $scModel->getServiceStatus($post['status']));
        $this->assign('service_pay_status', $scModel->getStatus($post['pay_status'],'service_pay_status'));
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $username = $this->request->param('username/s');

            // 验证
            $scModel = new ServiceModel();
            $userId = $scModel->getUid($username);
            if (empty($userId)) {
                $this->error('系统未检测到该用户');
            }

            $post = $data['post'];
            $post['user_id'] = $userId;
            $result = $this->validate($post, 'Service.edit');
            if ($result !== true) {
                $this->error($result);
            }

            if (!empty($data['photo'])) {
                $post['more']['photos'] = lothar_dealFiles($data['photo']);
            }
            if (!empty($data['file'])) {
                $post['more']['files'] = lothar_dealFiles($data['file']);
            }

            $scModel->adminEditArticle($post);

            $this->success('保存成功!');
        }
    }

    // 删除 回收机制
    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id = $this->request->param('id', 0, 'intval');
            $transStatus = true;
            Db::startTrans();
            try{
                model('Service')->where('id',$id)->update(['delete_time'=>time()]);
                $find = model('Service')->where('id',$id)->find();
                $data = [
                    'object_id'   => $find['id'],
                    'create_time' => time(),
                    'table_name'  => 'Service',
                    'name'        => $find['username']
                ];
                Db::name('recycleBin')->insert($data);
                Db::commit();
            }catch(Exception $e){
                Db::rollback();
                $transStatus = false;
            }
        }

        if (isset($param['ids'])) {
            $ids = $this->request->param('ids/a');
            $transStatus = true;
            Db::startTrans();
            try{
                model('Service')->where(['id'=>['in',$ids]])->update(['delete_time'=>time()]);
                $recycle = model('Service')->where(['id'=>['in',$ids]])->select();
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'Service',
                        'name'        => $value['username']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                Db::commit();
            }catch(Exception $e){
                Db::rollback();
                $transStatus = false;
            }
        }

        if ($transStatus === false) {
            $this->success("删除失败！", '');
        }
        $this->success("删除成功！", '');
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

    public function orderExcel()
    {
        $ids = $this->request->param('ids/a');
        $where = [];
        if (!empty($ids)) {
            $where = ['a.id'=>['in',$ids]];
        }

        $title = '车辆业务';
        $head = ['业务类型','车牌号','用户','联系方式','电话','预约时间'];
        $field = 'b.name,a.plateNo,a.username,a.contact,a.telephone,a.appoint_time';
        $dir = 'service';

        $data = Db::name('service')->alias('a')
              ->join('service_category b','a.model_id=b.id')
              ->field($field)
              ->where($where)
              ->select()->toArray();
        if (empty($data)) {
            $this->error('数据为空！');
        }

        $new = [];
        foreach ($data as $key => $value) {
            $value['appoint_time'] = date('Y-m-d H:i',$value['appoint_time']);
            $new[] = $value;
        }

        model('Service')->excelPort($title, $head, $new, $where, $dir);
    }



}