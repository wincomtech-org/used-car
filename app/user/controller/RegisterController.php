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

use cmf\controller\HomeBaseController;
use think\Validate;
use app\user\model\UserModel;

class RegisterController extends HomeBaseController
{

    /**
     * 前台用户注册
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

        if (cmf_is_user_login()) {
            return redirect($this->request->root() . '/');
        } else {
            return $this->fetch(":register");
        }
    }

    /**
     * 前台用户注册提交
     */
    // PC端
    public function doRegisterPC()
    {
        $this->doRegister(1);
    }
    // 移动端
    public function doRegisterM()
    {
        $this->doRegister(2);
    }

    public function doRegister($captchaId)
    {
        if ($this->request->isPost()) {
            $rules = [
                'captcha'  => 'require',
                'code'     => 'require',
                'password' => 'require|min:6|max:32',

            ];
            $isOpenRegistration=cmf_is_open_registration();
            if ($isOpenRegistration) {
                unset($rules['code']);
            }
            $validate = new Validate($rules);
            $validate->message([
                'code.require'     => 'code码不能为空',
                'password.require' => '密码不能为空',
                'password.max'     => '密码不能超过32个字符',
                'password.min'     => '密码不能小于6个字符',
                'captcha.require'  => '验证码不能为空',
            ]);

            $data = $this->request->post();

            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            if (!cmf_captcha_check($data['captcha'],$captchaId)) {
                $this->error('验证码错误',url('user/Register/index'));
            }

            if(!$isOpenRegistration){
                $errMsg = cmf_check_verification_code($data['username'], $data['code']);
                if (!empty($errMsg)) {
                    $this->error($errMsg,url('index'));
                }
            }

            $register          = new UserModel();
            $user['user_pass'] = $data['password'];

            // 判断账号类型 实际只给出了邮箱注册 和 手机号注册
            if (Validate::is($data['username'], 'email')) {
                $user['user_email'] = $data['username'];
                $log                = $register->registerEmail($user);
            } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $log            = $register->registerMobile($user);
            } else {
                $user['user_login'] = $data['username'];
                // $log = $register->registerUname($user);
                $log = 2;
            }
            // 注册后处理
            $sessionLoginHttpReferer = session('login_http_referer');
            // $redirect                = empty($sessionLoginHttpReferer) ? cmf_get_root() . '/' : $sessionLoginHttpReferer;
            $redirect = cmf_get_root() . '/';
            switch ($log) {
                case 0:
                    $userId = cmf_get_current_user_id();
                    $extra['username'] = $data['username'];
                    $log = model('usual/News')->newsObject('register',$userId,$userId,$extra);
                    $result = lothar_put_news($log);
                    if ($result) {
                        $this->success('注册成功', $redirect);
                    } else {
                        $this->success('注册成功但消息记录添加失败', $redirect);
                    }
                    break;
                case 1:
                    $this->error("您的账户已注册过");
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