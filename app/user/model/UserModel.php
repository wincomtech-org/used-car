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
namespace app\user\model;

use think\Db;
use think\Model;

class UserModel extends Model
{
    protected $type = [
        'more' => 'array',
        'identi' => 'array',
        'define_data' => 'array',
    ];

    public function doMobile($user)
    {
        $userQuery = Db::name("user");
        $result = $userQuery->where('mobile', $user['mobile'])->find();
        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam =[
                'user'=>$user,
                'compare_password_result'=>$comparePasswordResult
            ];
            hook_one("user_login_start",$hookParam);
            if ($comparePasswordResult) {
                //拉黑判断。
                if($result['user_status']==0){
                    return 3;
                }
                session('user', $result);
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $userQuery->where('id', $result["id"])->update($data);
                return 0;
            }
            return 1;
        }
        $hookParam =[
            'user'=>$user,
            'compare_password_result'=>false
        ];
        hook_one("user_login_start",$hookParam);
        return 2;
    }

    public function doName($user)
    {
        $userQuery = Db::name("user");
        $result = $userQuery->where('user_login', $user['user_login'])->find();
        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam =[
                'user'=>$user,
                'compare_password_result'=>$comparePasswordResult
            ];
            hook_one("user_login_start",$hookParam);
            if ($comparePasswordResult) {
                //拉黑判断。
                if($result['user_status']==0){
                    return 3;
                }
                session('user', $result);
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $userQuery->where('id', $result["id"])->update($data);
                return 0;
            }
            return 1;
        }
        $hookParam =[
            'user'=>$user,
            'compare_password_result'=>false
        ];
        hook_one("user_login_start",$hookParam);
        return 2;
    }

    public function doEmail($user)
    {
        $userQuery = Db::name("user");
        $result = $userQuery->where('user_email', $user['user_email'])->find();
        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam =[
                'user'=>$user,
                'compare_password_result'=>$comparePasswordResult
            ];
            hook_one("user_login_start",$hookParam);
            if ($comparePasswordResult) {

                //拉黑判断。
                if($result['user_status']==0){
                    return 3;
                }
                session('user', $result);
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $userQuery->where('id', $result["id"])->update($data);
                return 0;
            }
            return 1;
        }
        $hookParam =[
            'user'=>$user,
            'compare_password_result'=>false
        ];
        hook_one("user_login_start",$hookParam);
        return 2;
    }

    public function registerMobile($user)
    {
        $result = Db::name("user")->where('mobile', $user['mobile'])->find();

        $userStatus = 1;
        if (cmf_is_open_registration()) {
            $userStatus = 2;
        }

        if (empty($result)) {
            $user_pass = cmf_password($user['user_pass']);
            $data   = [
                'user_login'      => '',
                'user_email'      => '',
                'mobile'          => $user['mobile'],
                'user_nickname'   => '',
                'user_pass'       => $user_pass,
                'paypwd'          => $user_pass,
                'last_login_ip'   => get_client_ip(0, true),
                'create_time'     => time(),
                'last_login_time' => time(),
                'user_status'     => $userStatus,
                "user_type"       => 2,//会员
            ];
            $userId = Db::name("user")->insertGetId($data);
            $data   = Db::name("user")->where('id', $userId)->find();
            cmf_update_current_user($data);
            return 0;
        }
        return 1;
    }

    public function registerEmail($user)
    {
        $userQuery = Db::name("user");
        $result    = $userQuery->where('user_email', $user['user_email'])->find();

        $userStatus = 1;
        if (cmf_is_open_registration()) {
            $userStatus = 2;
        }

        if (empty($result)) {
            $user_pass = cmf_password($user['user_pass']);
            $data   = [
                'user_login'      => '',
                'user_email'      => $user['user_email'],
                'mobile'          => '',
                'user_nickname'   => '',
                'user_pass'       => $user_pass,
                'paypwd'          => $user_pass,
                'last_login_ip'   => get_client_ip(0, true),
                'create_time'     => time(),
                'last_login_time' => time(),
                'user_status'     => $userStatus,
                "user_type"       => 2,
            ];
            $userId = $userQuery->insertGetId($data);
            $date   = $userQuery->where('id', $userId)->find();
            cmf_update_current_user($date);
            return 0;
        }
        return 1;
    }

    /**
     * 通过手机重置密码
     * @param $mobile
     * @param $password
     * @return int
     */
    public function mobilePasswordReset($mobile, $password)
    {
        $userQuery = Db::name("user");
        $result    = $userQuery->where('mobile', $mobile)->find();
        if (!empty($result)) {
            $data = [
                'user_pass' => cmf_password($password),
            ];
            $userQuery->where('mobile', $mobile)->update($data);
            return 0;
        }
        return 1;
    }

    /**
     * 通过邮箱重置密码
     * @param $email
     * @param $password
     * @return int
     */
    public function emailPasswordReset($email, $password)
    {
        $result = $this->where('user_email', $email)->find();
        if (!empty($result)) {
            $data = [
                'user_pass' => cmf_password($password),
            ];
            $this->where('user_email', $email)->update($data);
            return 0;
        }
        return 1;
    }

    public function editData($user)
    {
        error_reporting(0);//Linux不起作用
        $oldInfo = cmf_get_current_user();
        // return $oldInfo;
        // 锁定字段，避免非法操作
        $data = [
            'user_nickname' => $user['user_nickname'],
            'sex'           => empty($user['sex'])?'':$user['sex'],
            'birthday'      => empty($user['birthday'])?'':strtotime($user['birthday']),
            'user_url'      => empty($user['user_url'])?'':$user['user_url'],
            'signature'     => empty($user['signature'])?'':$user['signature'],
            'more'          => empty($user['more'])?:json_encode($user['more']),//为统一session不使用模型层
        ];
        if (empty($oldInfo['user_login'])) {
            $data['user_login'] = $user['user_login'];
        }
        if (empty($oldInfo['user_email'])) {
            $data['user_email'] = $user['user_email'];
        }
        // dump($data);die;

        // 数据库操作
        $userQuery = Db::name("user");
        $result = $userQuery->where('id', $oldInfo['id'])->update($data);
        if (!empty($result)) {
            $userInfo = $userQuery->where('id', $oldInfo['id'])->find();
            cmf_update_current_user($userInfo);
            return 1;
        }
        return 0;
    }

    /**
     * 用户密码修改
     * @param $user
     * @return int
     */
    public function editPassword($user,$type='user_pass')
    {
        $userId    = cmf_get_current_user_id();
        $userQuery = Db::name("user");
        if ($user['password'] != $user['repassword']) {
            return 1;
        }
        // $pass = $userQuery->where('id', $userId)->find();
        $pass = $userQuery->where('id',$userId)->value($type);
        if (!cmf_compare_password($user['old_password'], $pass)) {
            return 2;
        }
        $data[$type] = cmf_password($user['password']);
        $userQuery->where('id', $userId)->update($data);
        return 0;
    }

    public function comments()
    {
        $userId               = cmf_get_current_user_id();
        $userQuery            = Db::name("Comment");
        $where['user_id']     = $userId;
        $where['delete_time'] = 0;
        $favorites            = $userQuery->where($where)->order('id desc')->paginate(10);
        $data['page']         = $favorites->render();
        $data['lists']        = $favorites->items();
        return $data;
    }

    public function deleteComment($id)
    {
        $userId              = cmf_get_current_user_id();
        $userQuery           = Db::name("Comment");
        $where['id']         = $id;
        $where['user_id']    = $userId;
        $data['delete_time'] = time();
        $userQuery->where($where)->update($data);
        return $data;
    }

    /**
     * 绑定用户手机号
     */
    public function bindingMobile($user)
    {
        $userId      = cmf_get_current_user_id();
        $data ['mobile'] = $user['username'];
        Db::name("user")->where('id', $userId)->update($data);
        $userInfo = Db::name("user")->where('id', $userId)->find();
        cmf_update_current_user($userInfo);
        return 0;
    }

    /**
     * 绑定用户邮箱
     */
    public function bindingEmail($user)
    {
        $userId     = cmf_get_current_user_id();
        $data ['user_email'] = $user['username'];
        Db::name("user")->where('id', $userId)->update($data);
        $userInfo = Db::name("user")->where('id', $userId)->find();
        cmf_update_current_user($userInfo);
        return 0;
    }
}
