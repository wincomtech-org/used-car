<?php
namespace app\service\controller;

use cmf\controller\HomeBaseController;
use app\service\model\ServiceCategoryModel;
use think\Db;
use think\Validate;

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
        $servId = $this->request->param('servId',0,'intval');

        if (!empty($servId)) {
            $this->redirect('appoint', ['compId'=>$this->compId,'servId'=>$servId]);
        }

        $services = model('service/ServiceCategory')->fromCateList();

        $this->assign('services',$services);
        return $this->fetch();
    }

    public function appoint()
    {
        $servId = $this->request->param('servId',0,'intval');
        $scModel = new ServiceCategoryModel();
        $servInfo = $scModel->getPost($servId);
        if (empty($servInfo)) {
            abort(404,'数据不存在！');
        }
        $define_data = $servInfo['define_data'];
        if (!empty($define_data)) {
            $new_data = $scModel->getDefineData($define_data,false);
            $this->assign('new_data',$new_data);
            if (in_array('service_point',$define_data)) {
                $Provinces = model('admin/District')->getDistricts(0,1);
                $servicePoint = model('usual/UsualCoordinate')->getCoordinates(0, ['company_id'=>$this->compId], false);
                $this->assign('Provinces', $Provinces);
                $this->assign('servicePoint',$servicePoint);
                $this->assign('servicePointJson',json_encode($servicePoint));
            }
        }

// dump($servicePoint);die;
        $this->assign('servId',$servId);
        $this->assign('servInfo',$servInfo);
        return $this->fetch();
    }

    public function appointPost()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 获取数据
        $data = $this->request->param();
        $userId = cmf_get_current_user_id();

        $post = $data['post'];
        $post['company_id'] = $this->compId;
        $post['user_id'] = $userId;
        // $more = $data['more'];

        $servCates = Db::name('service_category')->field('name,define_data')->where('id',$post['model_id'])->find();

        // 数据验证
        $rule = [
            'model_id' => 'require',
            'company_id' => 'require',
            'username|姓名' => 'chsAlpha|max:32',
            'telephone' => 'require',
            'birthday|生日'   => 'dateFormat:Y-m-d|after:-88 year|before:-1 day',
            'seller_name|卖家姓名' => 'chsAlpha|max:32',
            'plateNo' => 'require',
            'car_vin' => 'require',
            'reg_time|注册日期'   => 'dateFormat:Y-m-d|before:-1 day',
            'appoint_time|预约时间'   => 'dateFormat:Y-m-d|after:1 day',
        ];
        // 筛选需要验证的字段
        $filter_var = json_decode($servCates['define_data']);
        $all_var = array_keys(config('service_define_data'));
        foreach ($all_var as $value) {
            if (!in_array($value,$filter_var)) {
                // if (isset($rule[$value])) {
                    unset($rule[$value]);
                // }
            }
        }
        // 开始验证
        $validate = new Validate();
        $validate->rule($rule);
        $validate->message([
            'model_id.require' => '模型数据丢失',
            'company_id.require' => '公司数据丢失',
            'username.chsDash' => '姓名只能是汉字、字母',
            'username.max' => '姓名最大长度为32个字符',
            'telephone.require' => '电话必填',
            'birthday.dateFormat' => '生日格式不正确',
            'birthday.after' => '出生日期也太早了吧？',
            'birthday.before' => '出生日期也太晚了吧？',
            'seller_name.chsDash' => '姓名只能是汉字、字母',
            'seller_name.max' => '姓名最大长度为32个字符',
            'plateNo.require' => '请填写车牌号',
            // 'plateNo.isPlateNo' => '车牌号格式不对',
            'car_vin.require' => '请填写车架号',
            'reg_time.dateFormat' => '注册日期格式不正确',
            'reg_time.before' => '注册日期太晚了吧？',
            'appoint_time.dateFormat' => '预约时间格式不正确',
            'appoint_time.after' => '预约时间也太早了吧？',
        ]);
        if (!$validate->check($post)) {
            $this->error($validate->getError());
        }

        // 处理图片 直接拿官版的
        if (!empty($data['identity_card'])) {
            $post['more']['identity_card'] = model('Service')->dealFiles($data['identity_card']);
        }

        // 提交
        Db::startTrans();
        $sta = false;
        try{
            $id = model('Service')->addAppoint($post);
            $data = [
                'title' => '预约车辆服务：'.$servCates['name'],
                'user_id'=> $userId,
                'object'=> 'service:'.$id,
                'content'=>'客户ID：'.$userId.'，公司ID：'.$this->compId
            ];
            lothar_put_news($data);
            $sta = true;
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        if ($sta===false) {
            $this->error('提交失败');
        }

        // $this->success('提交成功，请等待工作人员回复',url('user/Service/index',['id'=>$post['model_id']]));
        $servName = Db::name('service_category')->where('id',$post['model_id'])->value('name');
        $this->assign('servId',$post['model_id']);
        $this->assign('servName',$servName);
        return $this->fetch('appoint_tip');
    }



    // 更多
    public function more()
    {
        // 借助 validate 验证
        // $result = $this->validate($post, 'Service.appoint');
        // if ($result !== true) {
        //     $this->error($result);
        // }

        // 处理图片文件
        // dump($_FILES);die;
        // dump(request()->file('identity_card'));
        // dump(request()->file('driving_license'));die;
        // $files   = $this->request->file();dump($files);die;
        // $files = $this->request->file($new_var);// 这样得到的不是一个对象了 无法处理不是对象的数据
        // $files = $this->request->file('photo');// 单字段多张 photo[]
        // dump($files);
        // // 处理表单上传文件 貌似一次性不能处理几张图？
        // $field_var = ['identity_card','driving_license','qualified','loan_invoice'];
        // $define_data = json_decode($servCates['define_data']);
        // foreach ($field_var as $value) {
        //     if (in_array($value,$define_data)) {
        //         $new_var[] = $value;
        //     }
        // }
        // $files = model('Service')->uploadPhotos($new_var);
        // foreach ($files as $key => $it) {
        //     if (!empty($it['err'])) {
        //         $this->error($it['err']);
        //     }
        //     $post['more'][$key] = $it['data'];
        // }



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