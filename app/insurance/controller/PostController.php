<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualCarModel;
use app\insurance\model\InsuranceModel;
use app\insurance\model\InsuranceCoverageModel;
use think\Db;

class PostController extends HomeBaseController
{
    // 选保险
    public function index()
    {
        $id = $this->request->param('id', 0, 'intval');
        $mainModel = new InsuranceModel();

        $coverages = $mainModel->where('id', $id)->where('status', 1)->find();

        $this->assign('coverages', $coverages);

        return $this->fetch();
    }

    // 选择险种
    public function step1()
    {
        $id = $this->request->param('id', 0, 'intval');
        $mainModel = new InsuranceModel();
        $ufoModel = new InsuranceCoverageModel();

        if (empty($id)) {
            $this->error('ID 非法',url('Index/index').'#AAA');
        }
        $iInfo = $mainModel->getPost($id);

        $coverages = $ufoModel->fromCateList($iInfo['more']['coverage']);

        $crumbs = $this->getCrumbs();

        $this->assign('crumbs', $crumbs);
        $this->assign('InsurId', $id);
        $this->assign('iInfo', $iInfo);
        $this->assign('coverages', $coverages);
        return $this->fetch();
    }

    // 个人资料
    public function step2()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        if ($this->request->isPost()) {
            $data   = $this->request->param();

            $result = $this->validate($data, 'Post.step2');
            if ($result !== true) {
                $this->error($result);
            }
            // session('insuranceStep1',json_encode($data));
            $data['coverIds'] = json_encode($data['coverIds']);
            session('insuranceStep1',$data);

            // 不存 session 时
            // $coverIds = '';
            // if (!empty($data['coverIds'])) {
            //     $coverIds = json_encode($data['coverIds']);
            // }

            // $post = [
            //     'coverIds'      => $coverIds,
            //     'insurance_id'  => $data['insurance_id'],
            //     'user_id'       => cmf_get_current_user_id(),
            // ]
            // $insertId = Db::name('insurance_order')->insertGetId($post);

            // $this->redirect('Post/step2', ['id'=>$insertId,'iid'=>$data['insurance_id']]);
        }

        $id = $this->request->param('insurance_id', 0, 'intval');
        $mainModel = new InsuranceModel();
        $iName = $mainModel->where('id',$id)->value('name');

        $this->assign('iName', $iName);
        return $this->fetch();
    }

    public function step2Post()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'),'',6);
        }
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            // $post = $data['post'];
            $cardata = $data['car'];
            $userId = cmf_get_current_user_id();

            if (!empty($data['data_filling_online'])) {
                $post['type'] = 1;
            }
            if (!empty($data['data_filling_offline'])) {
                $post['type'] = 2;
            }

            // 处理车辆数据
            if (empty($cardata['identi']['plateNo'])) {
                $this->error('请填写车牌号码',url('Post/step2'));
            }
            $carInfo = DB::name('usual_car')->field('id,user_id')->where('plateNo',$cardata['identi']['plateNo'])->find();
            if (!empty($carInfo)) {
                if ($carInfo['user_id']!=$userId) {
                    $this->error('该车牌号已被其他用户填写，请联系管理员',url('Index/index'));
                }
                $post['car_id'] = $carInfo['id'];
            } else {
                $cardata['user_id'] = $userId;
                $cardata['plateNo'] = $cardata['identi']['plateNo'];

                $carValid = $cardata['identi'];
                $carModel = new UsualCarModel();
                // dump($carValid);die;
                // $result = $this->validate($cardata, 'usual/Car.insurance');
                $result = $this->validate($carValid, 'Post.car');
                if ($result !== true) {
                    $this->error($result,url('Post/step2'));
                }

                // 行驶证 单图不需要额外处理
                // $file_var = ['driving_license','identity_card'];
                // $carUp = $carModel->uploadPhotos($file_var);
                // foreach ($carUp as $key => $it) {
                //     if (!empty($it['err'])) {
                //         $this->error($it['err']);
                //     }
                //     $cardata['identi'][$key] = $it['data'];
                // }
                // 直接拿官版的
                if (!empty($data['identity_card'])) {
                    $cardata['identi']['identity_card'] = $carModel->dealFiles($data['identity_card']);
                }

                $carModel->adminAddArticle($cardata);
                $post['car_id'] = $carModel->id;
                // $post['car_id'] = Db::name('usual_car')->insertGetId($cardata);
            }


            // 处理保单数据
            // $post_pre = json_decode(session('insuranceStep1'));
            $post_pre = session('insuranceStep1');
            $post = array_merge($post,$post_pre);
            $post['user_id'] = $userId;
            $post['order_sn'] = cmf_get_order_sn('insurance_');
            $post['create_time'] = time();
            // dump($post);die;
            $result = $this->validate($post, 'Post.step3');
            if ($result !== true) {
                $this->error($result,url('Post/step2'));
            }

            Db::startTrans();
            $sta = false;
            try{
                // 不用session时
                // $res = Db::name('insurance_order')->where('id',$post['id'])->update($post);
                // 使用session
                Db::name('insurance_order')->insert($post);
                $id = Db::getLastInsID();
                $data = [
                    'title'     => '预约保险',
                    'user_id'   => $userId,
                    'object'    => 'insurance_order:'.$id,
                    'content'   => '客户ID：'.$userId.'，保单ID：'.$id,
                    'adminurl'  => 2,
                ];
                lothar_put_news($data);
                $sta = true;
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }

            if ($sta===true) {
                $this->success('提交成功，请等待工作人员回复',url('user/Insurance/index'));
            }
            $this->error('提交失败',url('Index/index'));
        }
    }



// 后续处理
    // 签合同
    public function step5()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        $orderId = $this->request->param('id',0,'intval');
        $down = $this->request->param('down/d');
        if (empty($orderId)) {
            $this->error('保单非法');
        }

        $findOrder = Db::name('insurance_order')->field('order_sn,amount,status,insurance_id')->where('id',$orderId)->find();

        $where = ['id'=>$findOrder['insurance_id'],'identi_status'=>1,'status'=>1];
        // $insurInfo = model('Insurance')->getPost($findOrder['insurance_id']);
        $insurInfo = Db::name('insurance')->field('company_id,name,content,information,more')->where($where)->find();
        if (empty($insurInfo)) {
            $this->error('该保险已被关闭或者失效，请联系管理员');
        }
        $insurInfo['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($insurInfo['content']));

        // if ($down==1) {
        //     # code...
        // }

        $this->assign('orderId',$orderId);
        $this->assign('order',$findOrder);
        $this->assign('info',$insurInfo);
        return $this->fetch();
    }

    // 付钱页面 pay.html
    public function step6()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        $data = $this->request->param();//order_sn,amount
        $agree = $this->request->param('agree',null);
        $orderId = $this->request->param('orderId/d');

        // 判断是否二次支付：
        // if (!empty($data['status'])) {
        //     $this->error('请勿重复支付',url('user/Insurance/index'));
        // }

        if ($data['amount']<='0.00') {
            $this->error('请等待管理员填写支付金额');
        }
        if ($agree==null) {
            $this->error('请勾选同意按钮');
        }

        $where = ['id'=>$orderId];
        if ($agree==1) {
            Db::name('insurance_order')->where($where)->setField('status',5);
        }

        // 判断是否为手机端、微信端
        // $map = [
        //     'action'    => 'insurance',
        //     'order_sn'  => $data['order_sn'],
        //     'coin'      => $data['amount'],
        //     'id'        => $orderId,
        // ];
        // $this->showPay($map);

        $this->assign($data);
        $this->assign($orderId,$orderId);
        $this->assign('formurl',url('step7',['order_sn'=>$data['order_sn']]));
        return $this->fetch();
    }

    // 支付 paytype,order_sn,action
    public function step7()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 前置数据
        $paytype = $this->request->param('paytype');
        if (empty($paytype)) {
            $this->error('请选择支付方式');
        }
        $orderId = $this->request->param('orderId/d');
        if (empty($orderId)) {
            $this->error('保单支付失败');
        }
        $order = Db::name('insurance_order')->field('order_sn,amount,pay_id')->where('id',$orderId)->find();
        $map = [
            'paytype'   => $paytype,
            'action'    => 'insurance',
            'order_sn'  => $order['order_sn'],
            'coin'      => $order['amount'],
            // 'id'        => $orderId,
        ];

        // 判断是否二次支付：已有订单未支付，直接去支付
        // 转向支付接口
        $this->success('前往支付中心……',cmf_url('funds/Pay/pay',$map));
    }

    // 查看险种
    public function coverage()
    {
        $orderId = $this->request->param('id');

        return $this->fetch();
    }


}