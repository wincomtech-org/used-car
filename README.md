# used-car
二手车交易 

流程图：
    https://www.processon.com/view/link/59cc6eb9e4b06e9fd2f745d4
    密码：1234
GIT源码：
    https://github.com/wincomtech-org/used_car
DOAMIN：
    http://usedcar.wincomtech.cn/
测试账号：super  111111
          lothar  111111
模板路径：
    \public\themes\datong_car\  主目录
    \public\themes\datong_car\public\  共用文件 head、header、footer、nav、banner、morejs
    \public\themes\datong_car\public\assets\  资源文件 css、js、images、font
DOMEvent DOMDocumentWrapper phpQueryEvents phpQuery Callback JSONP
    \simplewind\extend\phpQuery\phpQuery.php
        $.getJSON(url,data,callback)



大通车服二手车设计
修改内容：
    <!-- 导航 二手买卖 换成 车商城 -->
    <!-- 导航 检车预约 换成 车辆业务 -->
    <!-- 先选服务填资料，后有公司选公司。服务点无公司限制。菜鸟验车、6年免检单独页面(自营) -->

流程测试。
    <!-- 全站搜索链接修改。 -->
    检查一些页面的跳转，是否可改用js的。
    导航变色
    富文本编辑器bug。
    自定义属性图集。
    用户上传图片裁剪？
    清除缓存对session是否操作？


【设计种种】
预设变量：
    父级ID(parent_id)、
    用户名(username)、车牌号(plateNo)、认证资料(auerbach)、合同(contract)、
    金币(coin)、冻结金币(freeze)、积分(score)、优惠券(coupons)、经验值(exp)、
    创建时间(create_time)、更新时间(update_time)、到期时间(due_time)
    库存(inventory)、

车险服务流程
    已存在的车险查重
    险种的 保险责任、赔偿项目、赔偿额度？
车险流程修改：
    车险流程：填资料，选意向公司，选险种，提交到后台提醒，核算，电话联系，审核通过，个人中心显示核算价格和选择领取保单方式（在线付费邮寄或现场收费领取）
原版：
    先是录入车辆信息，然后进行意向投保公司选择，下一步选取投保项目，然后点击核算保险，后台提醒工作人员查看信息，人工核算后进行电话联系，个人中心里面给予显示核算价格和选择领取保单方式，还是在线付费邮寄和现场收费领取

新增服务商城：
点券改成优惠券
商品属性设计：
    核心：属性类别表 + 属性值表
    产品表(cmf_shop_goods)：
        (PK)产品ID、(FK1)类别ID、(FK2)品牌ID、产品名称(name)、价格(shop_price)、积分(score)、优惠券(conpon)、、添加时间(create_time)、库存(inventory)、状态(status)
    品牌表(cmf_shop_goods_brand)：可以直接使用已有的
        (PK)品牌ID、品牌名称、logo、推荐(is_rec)、状态
    类目表(cmf_shop_goods_category)：
        (PK)类别ID、(FK1)类别父ID(parent_id)、深度(path)、类别名称(name)、状态(status)、排序(listorder)
    属性表(cmf_shop_goods_attr)：
        (PK)属性ID、(FK1)类别ID(cateId)、属性名称(name)、显示类型(input_type,单选、多选、下拉)、状态、排序、是否查询(is_query)、值类型(vtype)、值长度(vlength)
    属性值表(cmf_shop_goods_av)：
        (PK)属性值ID、(FK1)属性ID(attrId)、属性值名称(name)、状态、排序
    产品属性关系表(cmf_shop_gav)：
        (PK)属性关系ID、(FK1)产品ID(proId)、(FK2)属性ID(attrId)、(FK3)属性值ID(avId)
    说明：属性值可以是在一个 textarea 框中用 | 隔开 获取。



涉及支付的地方：
    预约看车    trade/Post/seeCarPost
    开店申请    trade/Post/depositPost
    保险业务    insurance/Post/step5Post
    充值        user/Funds/rechargePost
    服务商城    shop/

充值：
    <!-- 充值成功，新增funds_apply，user_funds_log。 -->
    第三方到公账到账，但系统未能成功处理，二次订单查询。

提现：
    <!-- 提交提现，改user的coin、freeze，新增funds_apply，
    提现审核通过status=1，正在提现处理中，请耐心等待……
    提现成功，改funds_apply的status=10，新增user_funds_log
    取消改user的coin、freeze，funds_apply的status=-2
    审核不通过，funds_apply的status=-1，改user的coin
    每日提现一次 -->

开店保证金：300
    <!-- 申请，改user的coin，新增funds_apply=>type=openshop，
    审核失败，改user的coin，funds_apply的status=-1
    取消，改user的coin，funds_apply的status=-2
    成功，改funds_apply的status=1，新增user_funds_log -->
    成功后归为开店保证金。
    后期管理员第二次更改状态的处理：

重复
    车牌号的唯一性检测？车牌号查重。
    <!-- 保单(insurance_order)一定要有车牌号，车辆表(cmf_usual_car)不一定有车牌号，如果有则必须唯一。资料审核表(cmf_verify)不需要专门的车牌号字段。 -->
    <!-- 不做车牌号唯一性检测，会省去很多不必要的麻烦。 -->

    用户重新提交审核？管理员二次操作？
    无责取消 与 有责取消 ？
    我的点券怎么扣除退还？
    审核认证交钱 与 审核认证不用交钱的(身份证，手机号，邮箱)？
    在线支付的都需要订单号order_sn


按顺序做的:
1、车辆属性设计
    <!-- 筛选属性和拓展属性同时修改，以筛选属性为主，否则哪个被修改就用哪个。
    属性循环单独模板
    扩展属性显示所有属性
    属性大类 下拉或分页？在车辆模板里TAB切换？ -->
2、车辆保险
3、车辆业务
4、个人中心
    我的优惠券怎么扣除退还？
    在已有手机、邮箱登录的基础上可以加入用户名登录。昵称作为网站通用，优先级：昵称<=用户名<=手机号<=邮箱
5、车辆买卖
    <!-- 买家需要实名认证，卖家需要实名认证资质认证缴纳开店保证金才能卖车。 -->
    卖家开店：审核资料重新设计，转移到cmf_verify，代码结构修改。
        开店资料审核 config('verify_define_data');
    <!-- 前台车辆列表筛选采用占位符，简化url长度 -->
6、支付模块
7、消息模块

注意:
路由会自己生成，在更新自定义导航。
首页要有自己的模型层。
下单和处理钱财消息的地方用回滚
instanceof
通过支付宝芝麻认证进行身份实名认证
状态：千分位：-4000交易失败 -3000系统取消 -2000卖家取消 -1000买家取消 0000初始化状态 1000交易完成。百分位：100已支付。十分位：10已发货。个分位：1买家已评论 2卖家已评论 3双方已评论。


◎统配：
开店保证金：300
提现开关：充值开关：
全局列表分页数：
短信开关：
消息开关

◎格局:
主导航
    网站首页、车险服务、车辆买卖、车检服务、上牌过户、新闻资讯、APP下载
    突出车险服务放在首位
幻灯片下面放三大项服务：车险服务、车辆买卖、车辆业务咨询
准新车前还要加一项全新推荐，这个是新车的。把代价SUV去掉

◎配件
微信公众号：消息提醒
支付宝：
短信：
身份认证：
消息通知：
导入导出：
打印：
地图导航：

◎流程
保险公司=>投保=>填写客户资料（姓名、电话、号牌号码、行车本照片、身份证照）=>选择在线投保（在线投保有合同） 或 线下投保 => 付费（根据后台人员核算后填入价格）=> 缴费成功后填写邮寄地址=>=>
车检站点（地图显示检测线地址，可以导航）=>检车=>录入车辆信息（姓名、电话、联系方式、行车本照、预约时间）=>后台提醒，告知工作人员以及所选的检测部门=>审核=>结束
=>=>=>=>=>=>
车子在售卖之前有进行过车辆服务，已有车子信息，在第一次卖车交押金时提示一下



●初始化
动态配置文件

url美化：
条件筛选先用a标签试试 占位符 效果(string类型：00000000)。
001：车品牌、车系
01：其它参数
（默认最大99，强制转换成字符串）
str_split($param1,3)
str_split($param2,2)
增强筛选效率

如果车辆筛选出现a问题，则name换成id，通过id找name、分类cateId、分类code
甚者，备份文件。全部用占位符0000000000试试，省的特殊符被转义。是不是更牛逼了

如果采用js传输数据：每个对应标签加上 data-item="?1"，'?'代表标识符
只需传两个参：当前点击的节点数据 和 隐藏域中的数据。



●车险服务：
    强制险、自选险
    线上 或 线下 操作
#保险业务表(cmf_insurance)：
    名称、所属公司、总则、投保须知、具体险种(CheckBox)、状态(-1禁用 0隐藏 1显示)、
#险种表(cmf_insurance_coverage)：
    名称、所属业务(0表示公用模型)、参考价、保险类型(1强险 2商业险)、参考价(price)、状态(-1禁用 0未启用 1启用)、、、
#保单表(cmf_insurance_order)：
    订单号、是否线上、所属业务、被保车、投保人、投保金额、生效时间、周期(失效时间)、审核资料(more:identity_card/driving_license)、状态(0未支付待审 1已支付 2取消关闭 5已审核 6待确认 8已确认 10完成 11过期失效)、
理赔表(cmf_insurance_compensation)：
    理赔对象、理赔方式、理赔结果、开始时间、结束时间、状态、



●车辆业务：
⊙菜鸟验车
    录入车牌号，姓名，联系方式等
⊙预约检车
    6年免检
⊙上牌预约
⊙过户申请
⊙合作寄存点
    自己送过去，拖车
⊙服务地点
合并还是拆分业务表？地点要有地图。

#业务分类表(cmf_service_category)：
    检测项目：菜鸟验车、车检预约、尾气检测，外观检测，灯光检测,喇叭、玻璃，座椅、轮胎、胎压、底盘、雨刷、点火、安全带
#业务表(cmf_service)：业务代号，预约时间，车架号、联系人，联系方式、地址、维修历史、

服务点表(cmf_usual_coordinate)：



●车辆买卖：
⊙店铺管理
#二手买卖店铺表(cmf_trade_shop)
    店铺名来自 卖家，即用户数据
⊙订单管理
#订单表(cmf_trade_order)：
    下单人、联系方式、车架号、车牌号、金额、下单时间、状态
#订单详情表(cmf_trade_order_detail)：
    订单编号、车子ID、对象名称、单价、数量

●车子管理：
#车辆表(cmf_usual_car)：brand_id,serie_id,model_id,user_id,country_id,province_id,city_id,status,identi_status,identi,sell_status
    属性：价格、上牌时间、里程、车龄、排量、变速箱、座位数、
    diy分类属性：颜色、燃料类型、排放标准、车源类别、国别
    其它属性：品牌、车系、国别、城市、
    备用属性：库存
#品牌表(cmf_usual_brand)：名称
    车系从属品牌（品牌子类）
车系表(cmf_usual_series)：名称
车型表(cmf_usual_models)：名称
车辆图集(cmf_usual_album？)：直接放在车辆表中。
#属性表(cmf_usual_item)：名称
    ①传统设计：车子表、属性表、属性值表、车子＆属性中间表
    ②diy方式：获取所以相关数据数组(id,name)，根据不同父id区分，下标以对应id代替。$attr[1]=[9=>"自动挡",10=>"手动挡"]。品牌、车型、地区也都可以这样拼一起。

###车辆属性重新设计：
属性(分类)表(cmf_usual_item_cate)：
    字段：parent_id,name,unit(单位),code,code_type(text,select,radio,checkbox,number,hidden),path,remark,description,more,is_top,is_rec,status,list_order
    数据库字段格式正则匹配，避免字段冲突thumbnail,photos,files
    只能新增，编辑，不能删除，确保数据一致性。以后有必要再改
    推荐的单独拿出来放，置顶的会靠前

属性值表(cmf_usual_item)：
    属性分类必须为 select,radio,checkbox 多项型
    cate_id,name,exch(替换规则：>,大于*、<,小于*、~,在*之间),description,more,is_top,status,list_order
    暂时制定6个规则：>、>=、=、<=、<、~
    如果 description 不为空，则用之。

车辆表(car_seating,car_color,car_effluent,car_fuel,car_displacement,car_gearbox)
    前台需要用于搜索的字段必须是独立字段。如何将属性值表里的数据提取出来放到车辆表相应字段？等值相互赋值？
    用more字段保存这些数据



●公司企业管理：is_baoxian   is_yewu
#公司表(usual_company)：名称、、置顶、推荐、认证状态、状态
    二手买卖的店铺与这个公司有关系吗？无

●认证体系：手机认证、邮箱认证、身份证认证、营业执照认证
lothar_verify()
#认证表(cmf_verify)：
#认证表(cmf_verify_model)：


●消息模块：需要消息提醒
\simplewind\cmf\common.php
    lothar_put_news()
消息记录表(cmf_news)：
    action 操作名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;
设置、列表


●地区管理：
地区表(cmf_district)：
●数据库备份：

●资金管理
cmf_user_funds_log
cmf_funds_apply 申请
●积分管理
cmf_user_ticket_log



系统已有：
●门户管理：
分类表(cmf_portal_category)
文章表(cmf_portal_post)
分类与文章关系表(cmf_portal_category_post)

●其它：
系统配置表(cmf_option)：
插件表(cmf_plugin)
插件表(cmf_plugin)

角色表(cmf_role)：

用户表(cmf_user)：
用户操作设定表(cmf_user_action)：积分/金币周期奖励 cmf_user_action()
用户积分/金币变动表(cmf_user_score_log)：
用户访问记录表(cmf_user_action_log)：
用户收藏记录表(cmf_user_favorite)：
token记录(cmf_user_token)：
评价表(cmf_comment)：
验证码发送记录表(cmf_verification_code)：手机或邮箱 cmf_get_verification_code()、cmf_verification_code_log()、cmf_check_verification_code()、cmf_clear_verification_code()

资源表(cmf_asset)：门户
回收站(cmf_recycle_bin)：












?>