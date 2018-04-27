<?php
namespace app\usual\model;

use think\Db;
use think\Model;
use think\Request;
// use app\admin\model\RouteModel;
// use tree\Tree;
use think\Image;
use excel\Excel;

/**
* 车辆共用 模型类
*/
class ComModel extends Model
{


// 以下是后加的
    /**
     * 新增数据
     * pk='id'
     * @param [array] $data [要保存的数据]
     * @param [bool] $return_id [是否返回ID]
     * $result = $this->id;
     * @return [number]       [description]
     */
    public function addDataCom($data,$return_id=false)
    {
        if (!empty($data['more.thumbnail'])) {
            $data['more.thumbnail'] = cmf_asset_relative_url($data['more.thumbnail']);
        }

        $result = $this->allowField(true)->save($data);
        // $this->allowField(true)->isUpdate(false)->data($data, true)->save();

        return ($return_id===true) ? $result : $this ;
    }

    /**
     * 修改数据
     * pk='id'
     * @param  [array] $data [要更新的数据]
     * @param  [object] [是否返回$this]
     * @return []       [description]
     */
    public function editDataCom($data,$obj=false)
    {
        $id = intval($data['id']);
        if (!empty($data['more.thumbnail'])) {
            $data['more.thumbnail'] = cmf_asset_relative_url($data['more.thumbnail']);
        }

        $result = $this->isUpdate(true)->allowField(true)->save($data, ['id' => $id]);
        // $this->allowField(true)->isUpdate(true)->data($data, true)->save();

        return $result;
    }

    /**
     * 后台管理编辑显示页面
     * @param int $id 唯一ID
     * @return $post 获取一条数据
    */
    public function getPost($id)
    {
        $post = $this->get($id);
        // $post = $this->where('id',$id)->find()->toArray();//find()结果集为空时toArray()报错
        // $post = $this->where('id',$id)->select()->toArray();

        if (empty($post)) {
            $post = [];
        } else {
            $post = $post->toArray();
        }

        // if (isset($post['content'])) {
        //     $post['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['content']));
        // }

        return $post;
    }

    // 分页数据量
    public function limitCom($limit=5)
    {
        if (empty($limit)) {
            $usualSettings = cmf_get_option('usual_settings');
            if (empty($usualSettings['pagesize'])) {
                $limit = config('pagerset.size');
            } else {
                $limit = $usualSettings['pagesize'];
            }
        }
        return $limit;
    }

    // 处理用户名 user_nickname|user_login|user_email|mobile
    public function getUsername($data=[])
    {
        $username = empty($data['user_nickname']) ? (empty($data['user_login']) ? (empty($data['mobile']) ? (empty($data['user_email'])?'--':$data['user_email']) : $data['mobile']) : $data['user_login']) : $data['user_nickname'];
        return $username;
    }
    // 获取用户ID
    public function getUid($uname='')
    {
        // 用户手机号为数字时
        if (empty($uname)) return false;

        $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
        // $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>['eq',$uname]])->value('id');
        // $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>['like', "%$uname%"]])->value('id');
        
        if (empty($uid)) return false;
        
        return $uid;
    }

    // 状态 从config.php
    public function getStatus($status='',$config='trade_order_status')
    {
        if (is_array($config)) {
            $ufoconfig = $config;
        } elseif (empty(config('?'.$config))) {
            return false;
        } else {
            $ufoconfig = config($config);
        }
        //非数值型非小数？ 
        $status = is_numeric($status)?intval($status):$status;
        $options = '';
        foreach ($ufoconfig as $key => $vo) {
            $options .= '<option value="'.$key.'" '.(($status===$key)?'selected':'').'>'.$vo.'</option>';
        }

        return $options;
    }

    // 选择框 从数据库
    public function createOptions($selectId=0, $option='', $data=[])
    {
        if ($option=='json') {
            return json_encode($data);
        } elseif ($option=='false' || $option===false) {
            return $data;
        }
        $options = (empty($option)) ? '':'<option value="">--'.$option.'--</option>';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').'>'.$v['name'].'</option>';
            }
        }
        return $options;
    }

    // Excel 处理
    public function excelPort($title='', $head='', $field='*', $where=[], $dir='', $colWidth=[24,15,15,15,18,18,20])
    {
        $dir = getcwd() .'/data/excel/'.$dir;//getcwd() 使用当前工作空间，CMF_ROOT网站根
        $excel = new Excel($dir);

        if (is_string($field)) {
            $dataTemp = $this->field($field)->where($where)->select()->toArray();
        } else {
            $dataTemp = $field;
        }
        if (empty($dataTemp)) {
            return false;
        }

        foreach ($dataTemp as $key => $row) {
            $data[] = array_values($row);
        }

        $excel->exportExcel($title, $head, $data, $colWidth);
    }



    /*
    * 图片上传处理
    * 控制器中使用
        $file_var = ['driving_license','identity_card'];
        $files = model('Service')->uploadPhotos($file_var);
        foreach ($files as $key => $it) {
            if (!empty($it['err'])) {
                $this->error($it['err']);
            }
            $post['more'][$key] = $it['data'];
        }
    */
    public function uploadPhotos($field_var=[], $module='', $valid=[])
    {
        $module     = empty($module) ? request()->module() : $module;
        $valid      = empty($valid) ? ['size' => 1024*1024,'ext' => 'jpg,jpeg,png,gif'] : $valid;
        $move       = '.' . DS . 'upload' . DS . $module . DS;
        // $move       = ROOT_PATH . 'public' . DS . 'upload'. DS .'service'. DS;

        if (is_string($field_var)) {
            return $this->uploadPhotoOne($field_var, $module, $valid, $move);
        } elseif (is_array($field_var)) {
            foreach ($field_var as $fo) {
                $data[$fo] = $this->uploadPhotoOne($fo, $module, $valid, $move);
            }
            return $data;
        }

        return false;
    }

    // 处理一张图片
    public function uploadPhotoOne($field_var, $module, $valid, $move)
    {
        $file = request()->file($field_var);

        // 移动到框架应用根目录/public/uploads/ 目录下
        if (empty($file)) {
            $data['err'] = '文件上传出错，请检查';
        } else {
            $result = $file->validate($valid)->move($move);
            // var_dump($result);
            if ($result) {
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
                // session('photo_'.$field_var, $photo);
                $data['data'] = $photo;
                $data['err'] = '';
            } else {
                // 上传失败获取错误信息
                $data['data'] = '';
                $data['err'] = $file->getError();
            }

            // json形式
            // if ($result) {
            //     $saveName = str_replace('//', '/', str_replace('\\', '/', $result->getSaveName()));
            //     $photo         = $module .'/'. $saveName;
            //     // session('photo_'.$field_var, $photo);
            //     $data = json_encode([
            //         'code' => 1,
            //         "msg"  => "上传成功",
            //         "data" => ['file' => $photo],
            //         "url"  => ''
            //     ]);
            // } else {
            //     $data = json_encode([
            //         'code' => 0,
            //         "msg"  => $file->getError(),
            //         "data" => "",
            //         "url"  => ''
            //     ]);
            // }
        }

        return $data;
    }

    // 同一字段多图上传
    public function uploadPhotoMulti($field_var, $module, $valid, $move)
    {
        # code...
    }
}