<?php
namespace app\usual\model;

use think\Db;
use think\Model;
use think\Request;
// use app\admin\model\RouteModel;
use app\usual\model\ComModel;

/**
* 车辆共用 模型类
*/
class UsualModel extends ComModel
{
    // 结合 ->toArray() 使用的，将json对象转维数组
    protected $type = [
        'more'        => 'array',
        'photos'      => 'array',
        'files'       => 'array',
        'identi'      => 'array',
        'define_data' => 'array',
        'file'        => 'array',
        'report'      => 'array',
    ];
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    /**
     * 关联 user表
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id')->setEagerlyType(1);
    }
    /**
     * 关联分类表
     */
    public function categories()
    {
        return $this->belongsToMany('PortalCategoryModel', 'portal_category_post', 'category_id', 'post_id');
    }

    /** 富文本自动转化
     * content 自动转化
     * @param $value
     * @return string
    */
    public function setContentAttr($value)
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
    }
    public function getContentAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }
    // information 自动转化
    public function setInformationAttr($value)
    {
        return $this->setContentAttr($value);
    }
    public function getInformationAttr($value)
    {
        return $this->getContentAttr($value);
    }

    /**
     * published_time 自动完成
     * @param $value
     * @return false|int
    */
    // 创建时间
    // function setCreateTimeAttr($value){ return strtotime($value);}
    // 更新时间 发布时间
    function setUpdateTimeAttr($value){ return strtotime($value);}
    function setPublishedTimeAttr($value){ return strtotime($value);}
    // pay_time 支付时间、生效时间
    function setPayTimeAttr($value){ return strtotime($value);}
    // dead_time失效时间 dead_time结束时间
    function setDeadTimeAttr($value){ return strtotime($value);}
    function setEndTimeAttr($value){ return strtotime($value);}
    // 删除时间
    function setDeleteTimeAttr($value){ return strtotime($value);}

    // issue_time上市时间 car_license_time上牌时间
    function setIssueTimeAttr($value){ return strtotime($value);}
    function setCarLicenseTimeAttr($value){ return strtotime($value);}
    function setCarCheckTimeAttr($value){ return strtotime($value);}
    function setCarInsurTimeAttr($value){ return strtotime($value);}
    // reg_time注册时间 appoint_time预约时间
    function setRegTimeAttr($value){ return strtotime($value);}
    function setAppointTimeAttr($value){ return strtotime($value);}
    // birthday生日 seller_birthday卖家生日
    function setBirthdayAttr($value){ return strtotime($value);}
    function setSellerBirthdayAttr($value){ return strtotime($value);}



    /**
     * 后台管理添加文章
     * @param array $data 文章数据
     * @param array|string $categories 文章分类 id
     * @return $this
    */
    public function adminAddArticle($data, $categories=null)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        if (!empty($data['buyer_username'])) {
            $data['buyer_uid'] = $this->getUid($data['buyer_username']);
        }
        if (!empty($data['seller_username'])) {
            $data['seller_uid'] = $this->getUid($data['seller_username']);
        }

        $data['create_time'] = time();

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();

        return $this;
    }

    /**
     * 后台管理编辑文章
     * @param array $data 文章数据
     * @param array|string $categories 文章分类 id
     * @return $this
     */
    public function adminEditArticle($data, $categories = null)
    {
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        if (!empty($data['identi']['driving_license'])) {
            $data['identi']['driving_license'] = cmf_asset_relative_url($data['identi']['driving_license']);
        }

        $data['status']         = empty($data['status']) ? 0 : $data['status'];
        $data['is_top']         = empty($data['is_top']) ? 0 : 1;
        $data['is_rec']         = empty($data['is_rec']) ? 0 : 1;
        $data['identi_status']  = empty($data['identi_status']) ? 0 : 1;
        $data['is_baoxian']     = empty($data['is_baoxian']) ? 0 : 1;
        $data['is_yewu']        = empty($data['is_yewu']) ? 0 : 1;

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();
        // $this->allowField(true)->isUpdate(true)->save($data, ['id' => $id]);

        return $this;
    }

    /*删除*/
    public function adminDeletePage($data)
    {
        if (isset($data['id'])) {
            $id = $data['id']; //获取删除id
            $res = $this->where(['id' => $id])->find();

            if ($res) {
                $res = json_decode(json_encode($res), true); //转换为数组
                $recycleData = [
                    'object_id'   => $res['id'],
                    'create_time' => time(),
                    'table_name'  => 'portal_post#page',
                    'name'        => $res['post_title'],

                ];

                Db::startTrans(); //开启事务
                $transStatus = false;
                try {
                    Db::name('portal_post')->where(['id' => $id])->update([
                        'delete_time' => time()
                    ]);
                    Db::name('recycle_bin')->insert($recycleData);

                    $transStatus = true;
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {

                    // 回滚事务
                    Db::rollback();
                }
                return $transStatus;
            } else {
                return false;
            }
        } elseif (isset($data['ids'])) {
            $ids = $data['ids'];
            $res = $this->where(['id' => ['in', $ids]])
                ->select();

            if ($res) {
                $res = json_decode(json_encode($res), true);
                foreach ($res as $key => $value) {
                    $recycleData[$key]['object_id']   = $value['id'];
                    $recycleData[$key]['create_time'] = time();
                    $recycleData[$key]['table_name']  = 'portal_post';
                    $recycleData[$key]['name']        = $value['post_title'];
                }

                Db::startTrans(); //开启事务
                $transStatus = false;
                try {
                    Db::name('portal_post')->where(['id' => ['in', $ids]])
                        ->update([
                            'delete_time' => time()
                        ]);
                    Db::name('recycle_bin')->insertAll($recycleData);
                    $transStatus = true;
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                }
                return $transStatus;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}