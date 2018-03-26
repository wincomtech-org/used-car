<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace app\user\controller;

use think\Validate;
use cmf\controller\HomeBaseController;
use app\user\model\UserModel;

class LoginController extends HomeBaseController
{
    /**
     * 登录
     */
    public function index()
    {
        $redirect = $this->request->post("redirect");
        if (empty($redirect)) {
            $redirect = $this->request->server('HTTP_REFERER');
        } else {
            $redirect = base64_decode($redirect);
        }
        session('login_http_referer', $redirect);
        if (cmf_is_user_login()) { //已经登录时直接跳到首页
            return redirect($this->request->root() . '/');
        } else {
            return $this->fetch(":login");
        }
    }

    /**
     * 登录验证提交
     */
    public function doLogin()
    {
        if ($this->request->isPost()) {
            $validate = new Validate([
                'captcha'  => 'require',
                'username' => 'require',
                'password' => 'require|min:6|max:32',
            ]);
            $validate->message([
                'username.require' => '用户名不能为空',
                'password.require' => '密码不能为空',
                'password.max'     => '密码不能超过32个字符',
                'password.min'     => '密码不能小于6个字符',
                'captcha.require'  => '验证码不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            if (!cmf_captcha_check($data['captcha'])) {
                $this->error('验证码错误');
            }

            $userModel         = new UserModel();
            $user['user_pass'] = $data['password'];
            if (Validate::is($data['username'], 'email')) {
                $user['user_email'] = $data['username'];
                $log                = $userModel->doEmail($user);
            } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $log            = $userModel->doMobile($user);
            } else {
                $user['user_login'] = $data['username'];
                $log                = $userModel->doName($user);
            }
            $session_login_http_referer = session('login_http_referer');
            // $redirect = empty($session_login_http_referer) ? $this->request->root() : $session_login_http_referer;
            // $redirect = empty($session_login_http_referer) ? cmf_url('user/Profile/center') : $session_login_http_referer;
            $redirect = cmf_url('user/Profile/center');
            switch ($log) {
                case 0:
                    cmf_user_action('login');
                    $this->success('登录成功', $redirect);
                    break;
                case 1:
                    $this->error('登录密码错误');
                    break;
                case 2:
                    $this->error('账户不存在');
                    break;
                case 3:
                    $this->error('账号被禁止访问系统');
                    break;
                default :
                    $this->error('未受理的请求');
            }
        } else {
            $this->error("请求错误");
        }
    }

    /** 自定义
     * 找回密码
    */
    public function findPassword()
    {
        $set = cmf_get_option('sms_yunpian');
        if (empty($set['switch'])) {
            $this->error('此模块后台未开启');
        }
        $data = $this->request->param();
        if (!empty($data['username'])) {
            if (!preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
                $this->error('手机号码填写错误！',url('findPassword'));
            }
            if (!cmf_captcha_check($data['captcha'])) {
                $this->error('验证码错误',url('findPassword'));
            }
            session('findmypwd',$data);
            $this->success('进入下一项',url('user/Login/findPassword2'));
        }

        return $this->fetch('/find_password');
    }
    // 短信验证
    public function findPassword2()
    {
        $data = $this->request->param();
        $user = session('findmypwd');

        if (!empty($data['verification_code'])) {
            // $errMsg = cmf_check_verification_code($user['username'], $data['verification_code']);
            // if (!empty($errMsg)) {
            //     $this->error($errMsg,url('findPassword2'));
            // }

            if ($data['verification_code']==session('sms_code')) {
                session('sms_code',null);
            } else {
                $this->error('短信验证码错误');
            }
            session('findmypwd',array_merge($user,$data));
            $this->success('进入下一项',url('user/Login/findPassword3'));
        }

        $this->assign($user);
        return $this->fetch('/find_password2');
    }
    // 设置新密码
    public function findPassword3()
    {
        return $this->fetch('/find_password3');
    }
    public function findPassword3Post()
    {
        $jumpurl = url('user/Login/findpassword');

        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data = array_merge(session('findmypwd'),$data);
            // echo "临时测试（不必在意）：<br>";
            // dump($data);die;


            $validate = new Validate([
                'captcha'           => 'require',
                'verification_code' => 'require',
                'password'          => 'require|min:6|max:32',
                'password2'         => 'require',
            ]);
            $validate->message([
                'captcha.require'           => '验证码数据意外丢失',
                'verification_code.require' => '短信验证码数据意外丢失',
                'password.require'          => '密码不能为空',
                'password.max'              => '密码不能超过32个字符',
                'password.min'              => '密码不能小于6个字符',
            ]);
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            if ($data['password']!=$data['password2']) {
                $this->error('两次密码不一样');
            }

            $userModel = new UserModel();
            if ($validate::is($data['username'], 'email')) {
                $log = $userModel->emailPasswordReset($data['username'], $data['password']);
            } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $log            = $userModel->mobilePasswordReset($data['username'], $data['password']);
            } else {
                $log = 2;
            }
            switch ($log) {
                case 0:
                    $this->success('密码重置成功', cmf_get_root() . '/');
                    session('findmypwd',null);
                    break;
                case 1:
                    $this->error("您的账户尚未注册",$jumpurl);
                    break;
                case 2:
                    $this->error("您输入的账号格式错误",$jumpurl);
                    break;
                default :
                    $this->error('未受理的请求',$jumpurl);
            }
        } else {
            $this->error("请求错误",$jumpurl);
        }
    }

    /** 官版
     * 用户密码重置
     */
    public function passwordReset()
    {
        if ($this->request->isPost()) {
            $validate = new Validate([
                'captcha'           => 'require',
                'verification_code' => 'require',
                'password'          => 'require|min:6|max:32',
                // 'password2'         => 'checkPwd2',
            ]);
            $validate->message([
                'verification_code.require' => '验证码不能为空',
                'password.require'          => '密码不能为空',
                'password.max'              => '密码不能超过32个字符',
                'password.min'              => '密码不能小于6个字符',
                'captcha.require'           => '验证码不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            if (!cmf_captcha_check($data['captcha'])) {
                $this->error('验证码错误');
            }
            $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
            if (!empty($errMsg)) {
                $this->error($errMsg);
            }

            $userModel = new UserModel();
            if ($validate::is($data['username'], 'email')) {
                $log = $userModel->emailPasswordReset($data['username'], $data['password']);
            } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $log            = $userModel->mobilePasswordReset($data['username'], $data['password']);
            } else {
                $log = 2;
            }
            switch ($log) {
                case 0:
                    $this->success('密码重置成功', $this->request->root());
                    break;
                case 1:
                    $this->error("您的账户尚未注册");
                    break;
                case 2:
                    $this->error("您输入的账号格式错误");
                    break;
                default :
                    $this->error('未受理的请求');
            }
        } else {
            $this->error("请求错误");
        }
    }


}