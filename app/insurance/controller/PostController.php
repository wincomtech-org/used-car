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
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            // $post = $data['post'];
            $cardata = $data['car'];

            if (!empty($data['data_filling_online'])) {
                $post['type'] = 1;
            }
            if (!empty($data['data_filling_offline'])) {
                $post['type'] = 2;
            }
            $userId = cmf_get_current_user_id();


            // 处理车辆数据
            $carInfo = DB::name('usual_car')->field('id,user_id')->where('plateNo',$cardata['identi']['plateNo'])->find();
            if (!empty($carInfo)) {
                if ($carInfo['user_id']!=$userId) {
                    $this->error('该车牌号已被其他用户填写，请联系管理员');
                }
                $post['car_id'] = $carInfo['id'];
            } else {
                $cardata['user_id'] = $userId;
                $cardata['plateNo'] = $cardata['identi']['plateNo'];

                $carModel = new UsualCarModel();
                $result = $this->validate($cardata, 'usual/Car.insurance');
                if ($result !== true) {
                    $this->error($result);
                }

                // 行驶证 单图不需要额外处理
                // $cardata['identi']['driving_license'];
                // 身份证
                // if (!empty($cardata['identi']['identity_card'])) {
                //     $cardata['identi']['identity_card'] = $carModel->dealFiles($cardata['identi']['identity_card']);
                // }
                $file_var = ['driving_license','identity_card'];
                $carUp = $carModel->uploadPhotos($file_var);
                if (!empty($carUp['err'])) {
                    foreach ($carUp['err'] as $value) {
                        $this->error($value);
                    }
                }
                foreach ($carUp['data'] as $key=>$var) {
                    $cardata['identi'][$key] = $var;
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
            $result = $this->validate($post, 'Post.step3');
            if ($result !== true) {
                $this->error($result);
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
                    'title' => '预约保险',
                    'object'=> 'insurance_order:'.$id,
                    'content'=>'客户ID：'.$userId.'，保单ID：'.$id
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
            $this->error('提交失败');
        }
    }

    // 合同
    public function step5()
    {
        $insurId = $this->request->param('id',0,'intval');
        $down = $this->request->param('down/d');

        $insurOrder = Db::name('insurance_order')->field('status,insurance_id')->where('id',$insurId)->find();
        $where = ['id'=>$insurOrder['insurance_id'],'identi_status'=>1,'status'=>1];
        // $insurInfo = model('Insurance')->getPost($insurOrder['insurance_id']);
        $insurInfo = Db::name('insurance')->field('company_id,name,content,information,more')->where($where)->find();
        if (empty($insurInfo)) {
            $this->error('该保险已被关闭或者失效，请联系管理员');
        }
        $insurInfo['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($insurInfo['content']));

        // if ($down==1) {
        //     # code...
        // }

        $this->assign('id',$insurId);
        $this->assign('Order',$insurOrder);
        $this->assign('Info',$insurInfo);
        return $this->fetch();
    }

    // 付钱
    public function step6()
    {
        // $data = $this->request->param();
        // $agree = $this->request->param('agree',null);
        // $insurId = $this->request->param('id',null);
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

    // 查看险种
    public function coverage()
    {
        $insurId = $this->request->param('id');

        return $this->fetch();
    }


}