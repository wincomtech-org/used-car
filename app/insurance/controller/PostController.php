<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualCarModel;
use app\insurance\model\InsuranceModel;
use app\insurance\model\InsuranceCoverageModel;
use think\Db;

class PostController extends HomeBaseController
{
    public function index()
    {
        $id = $this->request->param('id', 0, 'intval');
        $mainModel = new InsuranceModel();

        $coverages = $mainModel->where('id', $id)->where('status', 1)->find();

        $this->assign('coverages', $coverages);

        return $this->fetch();
    }

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

    public function step3()
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

            $car_id = DB::name('usual_car')->where('plateNo',$cardata['identi']['plateNo'])->value('id');
            if (!empty($car_id)) {
                $post['car_id'] = $car_id;
            } else {
                $cardata['user_id'] = cmf_get_current_user_id();

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



}