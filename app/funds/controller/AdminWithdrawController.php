<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
use think\Db;

/**
* 后台 
* 财务管理 提现管理
*/
class AdminWithdrawController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $param['type'] = 'withdraw';

        $fundsModel = new FundsApplyModel();
        $list = $fundsModel->getLists($param);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $fundsModel = new FundsApplyModel();
        $post = $fundsModel->getPost($id);
        if (empty($post)) {
            $this->error('数据不存在！');
        }

        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->post();
        // 验证
        $result = $this->validate($data,'Apply.withdraw');
        if ($result===false) {
            $this->error($result);
        }

        bcscale(2);
        if ($data['status']==-1 || $data['status']==-2) {
            $transStatus = true;
            Db::startTrans();
            try{
                model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
                Db::name('user')->where('id',$data['user_id'])->setInc('coin',$data['coin']);
                Db::name('user')->where('id',$data['user_id'])->setDec('freeze',$data['coin']);

                $userNew   = Db::name('user')->where('id',$data['user_id'])->find();
                // lothar_put_funds_log($data['user_id'], -9, $data['coin'],$userNew['coin'], 'funds',cmf_get_current_admin_id());
                cmf_update_current_user($userNew);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $transStatus = false;
            }
        } elseif ($data['status']==10) {
            $transStatus = true;
            Db::startTrans();
            try{
                model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
                Db::name('user')->where('id',$data['user_id'])->setDec('coin',$data['coin']);
                Db::name('user')->where('id',$data['user_id'])->setDec('freeze',$data['coin']);

                $userNew   = Db::name('user')->where('id',$data['user_id'])->find();
                lothar_put_funds_log($data['user_id'], 9, -$data['coin'],$userNew['coin'], 'funds',cmf_get_current_admin_id());
                cmf_update_current_user($userNew);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $transStatus = false;
            }
        } else {
            $transStatus = model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
        }

        // $result = model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
        // $result = Db::name('funnds_apply')->update($data);

        if (empty($transStatus)) {
            $this->error('修改失败');
        }
        $this->success('修改成功',url('index'));
    }

    // Excel导出 
    public function orderExcel()
    {
        $ids = $this->request->param('ids/a');
        $where = [];
        if (!empty($ids)) {
            $where = ['a.id'=>['in',$ids]];
        }
        $where['a.type'] = 'withdraw';

        $title = '提现管理';
        $head = ['订单号','提现金额','用户ID','提现方式','创建时间','状态'];
        $field = 'a.order_sn,a.coin,a.user_id,a.payment,a.create_time,a.status';
        $dir = 'funds';
        $statusV = config('funds_apply_status');

        $data = Db::name('funds_apply')->alias('a')
              ->join('user b','a.user_id=b.id')
              ->field($field)
              ->where($where)
              ->select()->toArray();
        if (empty($data)) {
            $this->error('数据为空！');
        }

        $new = [];
        foreach ($data as $key => $value) {
            $value['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $value['status'] = $statusV[$value['status']];
            $new[] = $value;
        }

        model('FundsApply')->excelPort($title, $head, $new, $where, $dir);
    }

    // 更多……  保留代码
    public function more()
    {
        # code...
    }
}