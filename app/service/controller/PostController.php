<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use think\Db;

class PostController extends HomeBaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->compId = $this->request->param('compId',0,'intval');
        if (!empty($this->compId)) {
            $companyInfo = Db::name('usual_company')->where('id',$this->compId)->value('name');
            $this->assign('compId',$this->compId);
            $this->assign('companyInfo',$companyInfo);
        }
        // $crumbs = $this->getCrumbs();
        // $this->assign('crumbs',$crumbs);
    }

    public function index()
    {
        $services = model('service/ServiceCategory')->fromCateList();

        $this->assign('services',$services);
        return $this->fetch();
    }

    public function appoint()
    {
        $servId = $this->request->param('servId',0,'intval');
        if (!empty($servId)) {
            $servInfo = model('service/ServiceCategory')->getPost($servId);
            if (!empty($servInfo['define_data'])) {
                $define_data = $servInfo['define_data'];
                $define_data_conf = config('service_define_data');
                $new_data = [];
                foreach ($define_data as $d) {
                    $new_data[] = [
                        'title' => $define_data_conf[$d],
                        'name' => $d
                    ];
                }
                if (!empty(in_array('service_point',$define_data))) {
                    $Provinces = model('admin/District')->getDistricts(0,1);
                    $this->assign('Provinces', $Provinces);
                }
                $this->assign('new_data',$new_data);
            }
            $this->assign('servInfo',$servInfo);
        }
        $servicePoint = model('usual/UsualCoordinate')->getCoordinates(0, ['company_id'=>$this->compId], '请选择服务点');

        $this->assign('servId',$servId);
        $this->assign('servicePoint',$servicePoint);
        return $this->fetch();
    }

    public function appointPost()
    {
        // $data = $this->request->param(true); dump($data);die;
        // dump(ROOT_PATH);die;

        // 获取数据
        $data = $this->request->param();
        $post = $data['post'];
        // $more = $data['more'];

        // 借助 validate 验证
        $result = $this->validate($post, 'Service.appoint');
        if ($result !== true) {
            $this->error($result);
        }

        // 处理表单上传文件
        $field_var = ['identity_card','driving_license','qualified','loan_invoice'];
        // dump($_FILES);die;
        // $files   = $this->request->file();dump($files);die;
        // $files = $this->request->file($field_var);// 这样得到的不是一个对象了 无法处理不是对象的数据
        // $files = $this->request->file('photo');// 单字段多张 photo[]
        // dump($files);

        $files = model('Service')->uploadPhotos($field_var);
        if (!empty($files['err'])) {
            foreach ($files['err'] as $value) {
                $this->error($value);
            }
        }
        if (!empty($files['data'])) {
            foreach ($files['data'] as $key => $value) {
                $post['more'][$key] = $value;
            }
        }

        // 提交
        $result = model('Service')->addAppoint($post);
        if ($result) {
            $this->success('提交成功',url('user/Profile/center'));
        }
        $this->error('提交失败');

        // 无法处理不是对象的数据
        // foreach($files as $key=>$file){
        //     // var_dump($key).'<br>';
        //     if (is_string($key)) {
        //         // 移动到框架应用根目录/public/uploads/ 目录下
        //         $result = $file->validate([
        //             'size' => 1024*1024,
        //             'ext'  => 'jpg,jpeg,png,gif'
        //         ])->move('.' . DS . 'upload' . DS . 'service' . DS);
        //         // ])->move(ROOT_PATH . 'public' . DS . 'upload'. DS .'service'. DS);

        //         if($result){
        //             // 成功上传后 获取上传信息
        //             // 输出 jpg
        //             echo $result->getExtension();
        //             // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
        //             echo $result->getSaveName();
        //             // 输出 42a79759f284b767dfcb2a0197904287.jpg
        //             echo $result->getFilename();

        //             // 处理
        //             $saveName = str_replace('//', '/', str_replace('\\', '/', $result->getSaveName()));
        //             $service         = 'service/' . $saveName;
        //             $post['more'][$key] = $service;
        //             var_dump($service).'<br><br><br>';
        //             // session('service', $service);
        //         }else{
        //             // 上传失败获取错误信息
        //             echo $file->getError();
        //         }
        //     }
        // }


    }
}