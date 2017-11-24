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
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            // dump($data);

            $result = $this->validate($data, 'Post.step2');
            if ($result !== true) {
                $this->error($result);
            }

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

        $id = $this->request->param('id', 0, 'intval');
        $InsurId = $this->request->param('iid', 0, 'intval');
        $mainModel = new InsuranceModel();
        $iName = $mainModel->where('id',$InsurId)->value('name');

        $this->assign('iName', $iName);
        $this->assign('id', $id);
        return $this->fetch();
    }

    public function step2Post()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post = $data['post'];
            $cardata = $data['car'];
            // dump($post);
            if (!empty($data['data_filling_online'])) {
                $post['type'] = 1;
            }
            if (!empty($data['data_filling_offline'])) {
                $post['type'] = 2;
            }

            $carInfo = DB::name('usual_car')->field('id,user_id')->where('plateNo',$cardata['identi']['plateNo'])->find();
            $userId = cmf_get_current_user_id();
            if (!empty($carInfo)) {
                if ($carInfo['user_id']!=$userId) {
                    $this->error('该车牌号已被其他用户填写，请联系管理员');
                }
                $post['car_id'] = $carInfo['id'];
            } else {
                $cardata['user_id'] = $userId;
                $cardata['plateNo'] = $cardata['identi']['plateNo'];

                // $carModel = new UsualCarModel();
                // $result = $this->validate($cardata, 'usual/Car.add');
                // if ($result !== true) {
                //     $this->error($result);
                // }

                // if (!empty($cardata['identi']['identity_card'])) {
                //     $cardata['identi']['identity_card'] = $carModel->dealFiles($cardata['identi']['identity_card']);
                // }

                // $carModel->adminAddArticle($cardata);
                // $post['car_id'] = $carModel->id;
                // $post['car_id'] = Db::name('usual_car')->insertGetId($cardata);
            }

            $result = $this->validate($post, 'Post.step3');
            if ($result !== true) {
                $this->error($result);
            }

            // $res = Db::name('insurance_order')->where('id',$post['id'])->update($post);
            if (!empty($res)) {
                $data = [
                    'title' => '预约保险',
                    'object'=> 'insurance_order'.$post['id'],
                    'content'=>'',
                    'create_time'=>time(),
                    'ip' => get_client_ip()
                ];
                cmf_put_news($data);
            }
        }
    }

    // 合同
    public function step5()
    {
        $insurId = $this->request->param('insurId',null);

        $this->assign('insurId',$insurId);
        return $this->fetch();
    }

    // 付钱
    public function step6()
    {
        // $data = $this->request->param();
        // $agree = $this->request->param('agree',null);
        // $insurId = $this->request->param('insurId',null);
        // $uid = cmf_get_current_user_id();

        // $result = $this->validate(['insurance_id'=>$insurId], 'insurance/Order.agree');
        // if ($result !== true) {
        //     $this->error($result);
        // }

        // if ($agree==1) {
        //     $where = ['user_id'=>$uid,'insurance_id'=>$insurId];
        //     Db::name('insurance_order')->where($where)->setField('status',8);
        // }

        return $this->fetch();
    }

    // 结果
    public function step7()
    {
        return $this->fetch();
    }


}