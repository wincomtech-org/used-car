<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
use app\insurance\model\InsuranceOptionModel;
use think\Db;

/**
* 保险通用
*/
class AdminIndexController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return $this->fetch();
    }

    public function edit()
    {
        /*使用模型处理*/
        $optionModel = new InsuranceOptionModel();
        $post = $optionModel->getPost(1);

        /*使用原生处理*/
        // $post = Db::name('insurance_option')->where('id',1)->find();
        // // 富文本
        // $post['content'] = $this->ueditorAfter($post['content']);  
        // // 附件
        // $post['file'] = json_decode($post['file'],true);

        $this->assign('post',$post);
        return $this->fetch();
    }

    /*富文本转义？*/
    public function editPost()
    {
        /*使用模型处理*/
        $data = $this->request->param();
        $post = $data['post'];
        $optionModel = new InsuranceOptionModel();
        // 直接拿官版的
        if (!empty($data['file'])) {
            $post['file'] = $optionModel->dealFiles($data['file']);
        }
        // $optionModel->adminAddArticle($post);
        $post['id'] = 1;
        $optionModel->adminEditArticle($post);

        /*使用原生处理*/
        // $data = $_POST;
        // $post = $data['post'];
        // $optionModel = new InsuranceOptionModel();
        // // 富文本
        // $post['content'] = $this->ueditorBefore($post['content']);    
        // // 直接拿官版的
        // if (!empty($data['file'])) {
        //     $post['file'] = $optionModel->dealFiles($data['file']);
        //     $post['file'] = json_encode($post['file']);
        // }
        // $result = Db::name('insurance_option')->where('id',1)->update($post);

        $this->success('提交成功',null,'',3);
    }

    public function ueditorBefore($content='')
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($content), true));
    }
    public function ueditorAfter($content='')
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($content));
    }





}