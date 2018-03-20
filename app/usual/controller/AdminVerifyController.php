<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\usual\model\VerifyModel;
use app\usual\model\VerifyModelModel;
// use think\Config;

/**
* 认证模块
*/
class AdminVerifyController extends AdminBaseController
{
    /*function _initialize()
    {
        // parent::_initialize();
        // dump(config('database.database'));
        // dump(config('Verify_status'));
    }*/

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $auth_code = $this->request->param('auth_code');
        $auth_status = $this->request->param('auth_status',0,'intval');

        $scModel = new VerifyModel();
        $data    = $scModel->getLists($param);
        $categoryTree = model('VerifyModel')->getOptions($auth_code);
        $statusTree = $scModel->getVerifyStatus($auth_status);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('category_tree', $categoryTree);
        $this->assign('status_tree', $statusTree);
        $this->assign('lists', $data->items());
        $data->appends($param);
        $this->assign('pager', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $scModel = new VerifyModel();
        $sc2Model = new VerifyModelModel();
        $this->assign('category_tree', $sc2Model->getOptions(0,0,0,true));
        $this->assign('define_data', $sc2Model->getDefineData('',''));
        $this->assign('status_tree', $scModel->getVerifyStatus());
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $postUid = $post['user_id'];

            $scModel = new VerifyModel();
            // 获取用户
            if (!empty($postUid)) {
                $count = Db::name('user')->where('id',$postUid)->count();
                if ($count<1) {
                    $this->error('对不起，该用户已不存在！');
                }
            }
            $username = $this->request->param('username/s');
            $userId = $scModel->getUid($username);
            if (empty($userId)) {
                $this->error('系统未检测到该用户');
            }
            if ($postUid!=$userId) {
                $this->error('用户ID 和 用户名 不对应！');
            }
            if (empty($postUid)) {
                $this->error('请填写用户ID 或者用户名');
            }
            $post['user_id'] = $userId;

            // 验证
            $result = $this->validate($post,'Verify.add');
            if ($result !== true) {
                $this->error($result);
            }
            $scModel->adminAddArticle($post);

            $this->success('添加成功!', url('AdminVerify/edit', ['id'=>$scModel->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $scModel = new VerifyModel();
        $sc2Model = new VerifyModelModel();
        $post = $scModel->getPost($id);
        $vm = $sc2Model->getOptions($post['auth_code'],0,0,true);
        $define_data = $sc2Model->getDefineData('','');
        $statusTree = $scModel->getVerifyStatus($post['auth_status']);

        $this->assign('category_tree', $vm);
        $this->assign('define_data', $define_data);
        $this->assign('status_tree', $statusTree);
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];

            $scModel = new VerifyModel();
            // 验证
            // $result = $this->validate($post, 'Verify.edit');
            // if ($result !== true) {
            //     $this->error($result);
            // }

            if (!empty($data['photo_names'])) {
                 $post['more']['photos'] = lothar_dealFiles(['names'=>$data['photo_names'],'urls'=>$data['photo_urls']]);
            }
            if (!empty($data['file_names'])) {
                $post['more']['files'] = lothar_dealFiles(['names'=>$data['file_names'],'urls'=>$data['file_urls']]);
            }

            $scModel->adminEditArticle($post);

            $this->success('保存成功!');
        }
    }

    // 删除 回收机制
    public function delete()
    {
        $param = $this->request->param();

        $scModel = new VerifyModel();
        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = $scModel
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = $scModel->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'Verify',
                    'name'        => $result['order_sn']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $scModel->where(['id' => ['in', $ids]])->select();
            $result  = $scModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'Verify',
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
            model('Verify')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Verify')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("禁用成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('Verify')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Verify')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('Verify')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('Verify')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }
    public function status()
    {
        $ids = $this->request->param('ids/a');
        $s = $this->request->param('s/d');
        if (!empty($ids) && isset($s)) {
            model('Verify')->where(['id'=>['in',$ids]])->setField('auth_status',$s);
            $this->success('状态修改成功');
        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('verify'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }
}