<?php
namespace app\usual\model;

use think\Db;
use think\Model;
use app\admin\model\RouteModel;

/**
* 车辆共用 模型类
*/
class UsualModel extends Model
{
    protected $type = [
        'more' => 'array',
        'identi' => 'array',
        'define_data' => 'array',
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

    /**
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
     * published_time 发布时间 自动完成
     * @param $value
     * @return false|int
    */
    public function setPublishedTimeAttr($value){ return strtotime($value);}
    // pay_time 支付时间、生效时间
    public function setPayTimeAttr($value){ return strtotime($value);}
    // dead_time 失效时间
    public function setDeadTimeAttr($value){ return strtotime($value);}
    // car_license_time 上牌时间
    public function setCarLicenseTimeAttr($value){ return strtotime($value);}
    // reg_time 注册时间
    public function setRegTimeAttr($value){ return strtotime($value);}
    // appoint_time 预约时间
    public function setAppointTimeAttr($value){ return strtotime($value);}
    // birthday 生日
    public function setBirthdayAttr($value){ return strtotime($value);}
    // seller_birthday 卖家生日
    public function setSellerBirthdayAttr($value){ return strtotime($value);}

    /**
     * status 用户名 自动完成
     * @param $value
     * @return int
    */
    // public function setBuyerUidAttr($value)
    // {
    //     return Db::name('user')->whereOr(['user_login|user_nickname|user_email'=>['like', "%$value%"]])->value('id');
    // }
    // public function setSellerUidAttr($value)
    // {
    //     return $this->setBuyerUidAttr($value);
    // }



    /**
     * 后台管理添加文章
     * @param array $data 文章数据
     * @param array|string $categories 文章分类 id
     * @return $this
    */
    public function adminAddArticle($data, $categories=null)
    {
        // $data['user_id'] = cmf_get_current_admin_id();
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        if (!empty($data['buyer_username'])) {
            $data['buyer_uid'] = Db::name('user')->whereOr(['user_login|user_nickname|user_email'=>['eq', $data['buyer_username']]])->value('id');
        }
        if (!empty($data['seller_username'])) {
            $data['seller_uid'] = Db::name('user')->whereOr(['user_login|user_nickname|user_email'=>['eq', $data['seller_username']]])->value('id');
        }

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();

        // if (isset($categories)) {
        //     if (is_string($categories)) {
        //         $categories = explode(',', $categories);
        //     }
        //     $this->categories()->save($categories);
        // }

        // if (isset($data['post_keywords'])) {
        //     $data['post_keywords'] = str_replace('，', ',', $data['post_keywords']);
        //     $keywords = explode(',', $data['post_keywords']);
        //     $this->addTags($keywords, $this->id);
        // }

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
        $data['user_id'] = !empty($data['user_id']) ? $data['user_id'] : cmf_get_current_admin_id();
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        if (!empty($data['identi']['driving_license'])) {
            $data['identi']['driving_license'] = cmf_asset_relative_url($data['identi']['driving_license']);
        }

        $data['status']         = empty($data['status']) ? 0 : 1;
        $data['is_top']         = empty($data['is_top']) ? 0 : 1;
        $data['is_rec']         = empty($data['is_rec']) ? 0 : 1;
        $data['sell_status']    = empty($data['sell_status']) ? 0 : 1;
        $data['identi_status']  = empty($data['identi_status']) ? 0 : 1;
        $data['is_baoxian']     = empty($data['is_baoxian']) ? 0 : 1;
        $data['is_yewu']        = empty($data['is_yewu']) ? 0 : 1;

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();
        // $this->allowField(true)->isUpdate(true)->save($data, ['id' => $id]);

        // if (isset($categories)) {
        //     if (is_string($categories)) {
        //         $categories = explode(',', $categories);
        //     }
        //     $oldCategoryIds        = $this->categories()->column('category_id');
        //     $sameCategoryIds       = array_intersect($categories, $oldCategoryIds);
        //     $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
        //     $newCategoryIds        = array_diff($categories, $sameCategoryIds);
        //     if (!empty($needDeleteCategoryIds)) {
        //         $this->categories()->detach($needDeleteCategoryIds);
        //     }
        //     if (!empty($newCategoryIds)) {
        //         $this->categories()->attach(array_values($newCategoryIds));
        //     }
        // }

        // if (isset($data['post_keywords'])) {
        //     $data['post_keywords'] = str_replace('，', ',', $data['post_keywords']);
        //     $keywords = explode(',', $data['post_keywords']);
        //     $this->addTags($keywords, $data['id']);
        // }

        return $this;
    }

    /*文章标签*/
    public function addTags($keywords, $articleId)
    {
        $portalTagModel = new PortalTagModel();
        $tagIds = [];
        $data = [];

        if (!empty($keywords)) {
            $oldTagIds = Db::name('portal_tag_post')->where('post_id', $articleId)->column('tag_id');
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                if (!empty($keyword)) {
                    $findTag = $portalTagModel->where('name', $keyword)->find();
                    if (empty($findTag)) {
                        $tagId = $portalTagModel->insertGetId([
                            'name' => $keyword
                        ]);
                    } else {
                        $tagId = $findTag['id'];
                    }
                    if (!in_array($tagId, $oldTagIds)) {
                        array_push($data, ['tag_id' => $tagId, 'post_id' => $articleId]);
                    }
                    array_push($tagIds, $tagId);
                }
            }

            if (empty($tagIds) && !empty($oldTagIds)) {
                Db::name('portal_tag_post')->where('post_id', $articleId)->delete();
            }

            $sameTagIds = array_intersect($oldTagIds, $tagIds);
            $shouldDeleteTagIds = array_diff($oldTagIds, $sameTagIds);

            if (!empty($shouldDeleteTagIds)) {
                Db::name('portal_tag_post')->where(['post_id' => $articleId, 'tag_id' => ['in', $shouldDeleteTagIds]])->delete();
            }
            if (!empty($data)) {
                Db::name('portal_tag_post')->insertAll($data);
            }
        } else {
            Db::name('portal_tag_post')->where('post_id', $articleId)->delete();
        }
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

    /**
     * 后台管理添加页面
     * @param array $data 页面数据
     * @return $this
     */
    public function adminAddPage($data)
    {
        $data['user_id'] = cmf_get_current_admin_id();
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['post_type']   = 2;

        $this->allowField(true)->data($data, true)->save();

        return $this;
    }

    /**
     * 后台管理编辑提交处理
     * @param array $data 页面数据
     * @return $this
     */
    public function adminEditPage($data)
    {
        $data['user_id'] = cmf_get_current_admin_id();
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['post_type']   = 2;

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();

        // 路由定义 别名alias
        // $routeModel = new RouteModel();
        // $routeModel->setRoute($data['post_alias'], 'portal/Page/index', ['id' => $data['id']], 2, 5000);
        // $routeModel->getRoutes(true);

        return $this;
    }



// 以下是后加的
    /**
     * 后台管理编辑显示页面
     * @param int $id 唯一ID
     * @return $post 获取一条数据
    */
    public function getPost($id)
    {
        $post_obj = $this->get($id);
        // $post_obj = $this->where('id',$id)->find()->toArray();//find()结果集为空时toArray()报错
        // $post_obj = $this->where('id',$id)->select()->toArray();

        $post = [];
        if (!empty($post_obj)) {
            $post = $post_obj->toArray();
        }

        // if (isset($post['content'])) {
        //     $post['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['content']));
        // }
        // if (isset($post['information'])) {
        //     $post['information'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['information']));
        // }

        return $post;
    }

    public function dealFiles($files=['names'=>[],'urls'=>[]], $pk='')
    {
        $post = [];
        $names = $files['names']; $urls = $files['urls'];
        if (!empty($names) && !empty($urls)) {
            foreach ($urls as $key => $url) {
                $relative_url = cmf_asset_relative_url($url);
                array_push($post, ["url"=>$relative_url, "name"=>$names[$key]]);
            }
        }

        return $post;
    }

    public function getStatus($status='',$config='trade_order_status')
    {
        if (empty(config('?'.$config))) {
            return false;
        }
        $status = intval($status);
        $ufoconfig = config($config);
        $options = '';
        foreach ($ufoconfig as $key => $vo) {
            $options .= '<option value="'.$key.'" '.($status==$key?'selected':'').'>'.$vo.'</option>';
        }

        return $options;
    }

    // 选择框
    public function createOptions($selectId, $option, $data)
    {
        if ($option===false) {
            return $data;
        } else {
            $options = (empty($option)) ? '':'<option value="">--'.$option.'--</option>';
            if (is_array($data)) {
                foreach ($data as $v) {
                    $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
                }
            }
            return $options;
        }
    }
}