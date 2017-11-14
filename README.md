# used-car
二手车交易

流程图
https://www.processon.com/mindmap/59cc4f0ce4b06e9fd2f7247f
GIT源码
https://github.com/wincomtech-org/used_car





大通车服二手车设计

接下来按顺序做的:
1、车辆属性设计
    // 筛选属性和拓展属性同时修改，以筛选属性为主，否则哪个被修改就用哪个。
    // 属性循环单独模板
    // 扩展属性显示所有属性
    // 属性大类 下拉或分页？在车辆模板里TAB切换？
2、车辆保险
3、车辆业务
4、个人中心
5、车辆买卖
6、支付模块
7、消息模块

注意:
路由会自己生成，在更新自定义导航。
首页要有自己的模型层。
下单和处理钱财消息的地方用回滚
instanceof
通过支付宝芝麻认证进行身份实名认证
状态：千分位：-4000交易失败 -3000系统取消 -2000卖家取消 -1000买家取消 0000初始化状态 1000交易完成。百分位：100已支付。十分位：10已发货。个分位：1买家已评论 2卖家已评论 3双方已评论。



车辆属性重新设计：
属性(分类)表
    字段：parent_id,name,unit(单位),code,code_type(text,select,radio,checkbox,number,hidden),path,remark,description,more,is_top,is_rec,status,list_order
    数据库字段格式正则匹配，避免字段冲突thumbnail,photos,files
    只能新增，编辑，不能删除，确保数据一致性。以后有必要再改
    推荐的单独拿出来放，置顶的会靠前

属性值表(select,radio,checkbox):提示属性分类必须为 select,radio,checkbox 多项型
    cate_id,name,exch(替换规则：>,大于*、<,小于*、~,在*之间),description,more,is_top,status,list_order
    暂时制定6个规则：>、>=、=、<=、<、~
    如果 description 不为空，则用之。

车辆表(car_seating,car_color,car_effluent,car_fuel,car_displacement,car_gearbox)
    前台需要用于搜索的字段必须是独立字段。如何将属性值表里的数据提取出来放到车辆表相应字段？等值相互赋值？
    用more字段保存这些数据



格局:
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
    #业务分类表(cmf_service_category)：菜鸟验车、车检预约
    #业务表(cmf_service)：业务代号，预约时间，车架号、联系人，联系方式、地址、维修历史、
    检测项目表(cmf_service_items<==>usual_item？)：尾气检测，外观检测，灯光检测,喇叭、玻璃，座椅、轮胎、胎压、底盘、雨刷、点火、安全带
    业务地点表(cmf_service_site？)：锦平车险、润之丰车险（是公司表吗）



●车辆买卖：
⊙店铺管理
#二手买卖店铺表(trade_shop)
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
#属性表(cmf_usual_item)：名称
    ①传统设计：车子表、属性表、属性值表、车子＆属性中间表
    ②diy方式：获取所以相关数据数组(id,name)，根据不同父id区分，下标以对应id代替。$attr[1]=[9=>"自动挡",10=>"手动挡"]。品牌、车型、地区也都可以这样拼一起。array_push？或array_merge？
车辆图集(cmf_usual_album？)：直接放在车辆表中。


●公司企业管理：is_baoxian   is_yewu
#公司表(usual_company)：名称、、置顶、推荐、认证状态、状态
    二手买卖的店铺与这个公司有关系吗？无


●认证体系：手机认证、邮箱认证、身份证认证、营业执照认证
#认证表(cmf_verify)：
#认证表(cmf_verify_model)：


●消息模块：需要消息提醒
消息记录表(cmf_news)：cmf_put_news()
    action 操作名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;
设置、列表


●地区管理：
地区表(cmf_district)：
●数据库备份：




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
用户操作记录表(cmf_user_action)：积分/金币周期奖励 cmf_user_action()
用户访问记录表(cmf_user_action_log)：
用户积分/金币变动表(cmf_user_score_log)：
评价表(cmf_comment)：
验证码发送记录表(cmf_verification_code)：手机或邮箱 cmf_get_verification_code()、cmf_verification_code_log()、cmf_check_verification_code()、cmf_clear_verification_code()

资源表(cmf_asset)：门户
回收站(cmf_recycle_bin)：












?>