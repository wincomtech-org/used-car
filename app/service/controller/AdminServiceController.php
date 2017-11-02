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

        $data = model('Service')->getLists($param);
        $data->appends($param);

        $this->assign('payId', isset($param['payId']) ? $param['payId'] : '');
        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('sn', isset($param['sn']) ? $param['sn'] : '');
        $this->assign('lists', $data->items());
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $car_title = $this->request->param('car_name/s');
            $car_id = Db::name('usual_car')->where(['name'=>['like', "%$car_title%"]])->value('id');
            if (empty($car_id)) {
                $this->error('车子标题不存在！');
            }
            $post   = $data['post'];
            $post['car_id'] = intval($car_id);
            $result = $this->validate($post,'Order.add');
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

        $this->assign('order_status', config('service_status'));
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();

            $post   = $data['post'];
            $result = $this->validate($post, 'Order.edit');
            if ($result !== true) {
                $this->error($result);
            }
            if ($post['status']==1 && empty($post['pay_time'])) {
                $this->error('支付时间不能为空 <br>或者 支付状态不能为未支付、取消！');
            }

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $post['more']['identity_card'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($post['more']['identity_card'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }
            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $post['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($post['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }

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