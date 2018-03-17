<?php
namespace app\shop\controller;

use think\Db;
use cmf\controller\AdminBaseController;
use app\shop\model\ShopOrderModel;
use express\WorkPlugin;

/**
* 服务商城 独立模块
* 订单
*/
class AdminOrderController extends AdminBaseController
{
    public function index()
    {
        /*// OK
        $typeCom = 'rrs';
        $typeNu = '6080943656';
        // 异常
        $typeCom = 'zhongtong';
        $typeNu = '474184190064';
        $typeNu = '471791993640';
        // 异常
        $typeCom = 'yuantong';
        $typeNu = '888017949354264875';
        $typeNu = '888017061034034049';
        // 异常
        $typeCom = 'yunda';
        $typeNu = '3912633749099';
        // OK
        $typeCom = 'huitongkuaidi';
        $typeNu = '70523393645614';
        // OK
        $typeCom = 'youzhengguonei';
        $typeNu = '9891835741800';

        $express = new WorkPlugin($typeCom,$typeNu);
        $result = $express->workOrder();
        echo $result;die;*/


        $param = $this->request->param();

        $scModel = new ShopOrderModel;

        // $list = Db::name('shop_order')->paginate(10);
        $list = $scModel->getLists($param);
// dump($list->toArray());



        $this->assign('keyword',(isset($param['keyword'])?$param['keyword']:''));
        $this->assign('list',$list->items());
        $list->appends($param);
        $this->assign('pager',$list->render());
        return $this->fetch();
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $scModel = new ShopOrderModel();
        $post      = $scModel->where('id', $id)->find();

        $this->assign('post', $post);

        return $this->fetch();
    }

    public function editPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $data['post'];

            // 验证
            // $result = $this->validate($post, 'Order');
            // if ($result !== true) {
            //     $this->error($result);
            // }

            $scModel = new ShopOrderModel();
            $scModel->editDataCom($post);

            $this->success('保存成功!', url('index'));
        }
    }

    public function delete()
    {
        //查看有无关联
        $this->error("删除功能暂不开放");
        // $scModel = new ShopOrderModel();
        $m1        = Db::name('shop_order');
        $m2        = Db::name('recycleBin');

        $param     = $this->request->param();

        if (isset($param['id'])) {
            $id   = $this->request->param('id', 0, 'intval');
            $result = $m1->where('id',$id)->setField('delete_time',time());
            $log = [
                'object_id' => $id,
                'create_time'=>time(),
                'table_name'=>'shop_order',
                'name'=>''
            ];
            $m2->insert($log);
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $m1->where(['id' => ['in', $ids]])->select();
            $result  = $m1->field('id,order_sn')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $log[] = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'shop_order',
                        'name'        => $value['order_sn'],
                    ];
                }
                $m2->insertAll($log);
                $this->success("删除成功！", '');
            }
        }
    }

    public function changeStatus()
    {

        $data = $this->request->param();

        $attrModel = new ShopOrderModel();

        if (isset($data['ids'])) {
            $ids = $this->request->param('ids/a');

            $attrModel->where(['id' => ['in', $ids]])->update([$data["type"] => $data["value"]]);

            $this->success("更新成功！");

        }
        $this->success("更新失败！");
    }

    public function listOrder()
    {
        parent::listOrders($this->m);
        $this->success("排序更新成功！", '');
    }

    
}