<?php
namespace app\service\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class ServiceModel extends UsualModel
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function getLists($filter, $isPage = false)
    {
        $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login';
        $where = ['a.delete_time' => 0];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
        ];

        // 模型
        if (!empty($filter['modelId'])) {
            $where['a.model_id'] = $filter['modelId'];
        }
        // 预约时间
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.appoint_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.appoint_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.appoint_time'] = ['<= time', $endTime];
            }
        }
        // 公司
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
                $uid = intval($uid);
            }
            $where['a.user_id'] = $uid;
        }
        // 关键词
        $sn = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($sn)) {
            $where['a.description'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.is_top DESC,a.id DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        // $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login,e.user_nickname seller_nickname,e.user_login seller_login';
        $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login';
        // $where = ['a.id' => $id];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_login'];
        // $post['seller_username'] = $post['seller_nickname'] ? $post['seller_nickname'] : $post['seller_login'];

        return $post;
    }

    public function getServiceStatus($status='')
    {
        return $this->getStatus($status,'service_status');
    }



/*前台*/
    // 用户提交预约单
    public function addAppoint($post)
    {
        $data = [
            'create_time'   => time(),
        ];
        $data = array_merge($data,$post);

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();
        // $id = Db::name("service")->insertGetId($data);

        return $this->id;
        // return $id;
        // return $this->adminAddArticle($data);
    }

    // 图片上传处理
    public function uploadPhotos($filter_var=[])
    {
        $request    = request();
        $module     = $request->module();
        if (is_string($filter_var)) {
            return false;
        } else {
            foreach ($filter_var as $fo) {
                $file = $request->file($fo);
                // 移动到框架应用根目录/public/uploads/ 目录下
                if (!empty($file)) {
                    $result = $file->validate([
                        'size' => 1024*1024,
                        'ext'  => 'jpg,jpeg,png,gif'
                    ])->move('.' . DS . 'upload' . DS . $module . DS);
                    // ])->move(ROOT_PATH . 'public' . DS . 'upload'. DS .'service'. DS);

                    // var_dump($result);
                    if($result){
                        // 成功上传后 获取上传信息
                        // 输出 jpg
                        // echo $result->getExtension();
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                        // echo $result->getSaveName();
                        // 输出 42a79759f284b767dfcb2a0197904287.jpg
                        // echo $result->getFilename();

                        // 处理
                        $saveName = str_replace('//', '/', str_replace('\\', '/', $result->getSaveName()));
                        $photo    = $module .'/'. $saveName;
                        $data[$fo] = $photo;
                        // session($fo.'photo', $photo);
                    }else{
                        // 上传失败获取错误信息
                        $error[$fo] = $file->getError();
                    }
                }
            }
            if (!empty($data)) {
                $res['data'] = $data;
            }
            if (!empty($error)) {
                $res['error'] = $error;
            }
            return $res;
        }

        return false;
    }
}