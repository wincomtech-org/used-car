/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : usedcar

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2018-03-16 11:04:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_shop_brand
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_brand`;
CREATE TABLE `cmf_shop_brand` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '品牌名称',
  `thumbnail` varchar(1000) NOT NULL DEFAULT '' COMMENT '缩略图',
  `index` char(4) NOT NULL DEFAULT '*' COMMENT '索引',
  `show_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '展示方式：1图片 2文字',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐：0否 1是',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`),
  KEY `idx1` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='品牌表';

-- ----------------------------
-- Records of cmf_shop_brand
-- ----------------------------
INSERT INTO `cmf_shop_brand` VALUES ('1', '0', '威威', '', '*', '1', '0', '0', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('2', '0', '亿德隆', 'http://www.datongchefu.cn/upload/default/20171225/logo_lucency.png', '*', '1', '0', '1', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('3', '0', '金井', '', '*', '1', '0', '0', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('4', '0', '佳艺田', '', '*', '1', '0', '1', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('5', '0', 'BLOX', '', '*', '1', '0', '1', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('6', '0', 'L．T．W/乐田王', '', '*', '1', '0', '0', '1', '10000');
INSERT INTO `cmf_shop_brand` VALUES ('7', '0', 'Dunlop/邓禄普', '', '*', '1', '0', '0', '1', '10000');

-- ----------------------------
-- Table structure for cmf_shop_cart
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_cart`;
CREATE TABLE `cmf_shop_cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车：清空则删除',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `spec_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品对应规格值 ID，用于唯一性检测。0表示没有规格',
  `goods_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `spec_vars` varchar(255) NOT NULL DEFAULT '' COMMENT '所选规格',
  `number` smallint(3) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '售价',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_shop_cart
-- ----------------------------
INSERT INTO `cmf_shop_cart` VALUES ('6', '3', '0', '4', 'null', '1', '40.00', '12.00');
INSERT INTO `cmf_shop_cart` VALUES ('3', '1', '2', '6', '黑色L号', '1', '47.00', '56.00');

-- ----------------------------
-- Table structure for cmf_shop_category_attr
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_category_attr`;
CREATE TABLE `cmf_shop_category_attr` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `attr_id` mediumint(20) unsigned NOT NULL DEFAULT '0' COMMENT '属性id',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序',
  `is_query` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否查询：0否 1是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate_attr_id` (`cate_id`,`attr_id`) USING BTREE COMMENT '分类和属性对应唯一'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='shop应用 分类属性对应表';

-- ----------------------------
-- Records of cmf_shop_category_attr
-- ----------------------------
INSERT INTO `cmf_shop_category_attr` VALUES ('1', '1', '6', '10000', '1');
INSERT INTO `cmf_shop_category_attr` VALUES ('2', '1', '7', '1', '0');
INSERT INTO `cmf_shop_category_attr` VALUES ('3', '1', '8', '10000', '1');
INSERT INTO `cmf_shop_category_attr` VALUES ('4', '5', '4', '10000', '1');
INSERT INTO `cmf_shop_category_attr` VALUES ('5', '5', '2', '10000', '1');
INSERT INTO `cmf_shop_category_attr` VALUES ('6', '2', '4', '10000', '1');
INSERT INTO `cmf_shop_category_attr` VALUES ('7', '2', '2', '10000', '1');

-- ----------------------------
-- Table structure for cmf_shop_category_spec
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_category_spec`;
CREATE TABLE `cmf_shop_category_spec` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `spec_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '规格id',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate_spec_id` (`cate_id`,`spec_id`) USING BTREE COMMENT '分类和规格对应唯一'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='shop应用 分类规格对应表';

-- ----------------------------
-- Records of cmf_shop_category_spec
-- ----------------------------
INSERT INTO `cmf_shop_category_spec` VALUES ('28', '1', '2', '10000');
INSERT INTO `cmf_shop_category_spec` VALUES ('29', '5', '1', '10000');
INSERT INTO `cmf_shop_category_spec` VALUES ('30', '5', '2', '10000');
INSERT INTO `cmf_shop_category_spec` VALUES ('31', '2', '1', '10000');
INSERT INTO `cmf_shop_category_spec` VALUES ('32', '2', '2', '10000');

-- ----------------------------
-- Table structure for cmf_shop_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_evaluate`;
CREATE TABLE `cmf_shop_evaluate` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品评价表',
  `goods_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '买家ID',
  `star` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评级：-1差评 0 中评 1好评',
  `description` tinytext COMMENT '评价内容',
  `evaluate_image` text COMMENT '有图评价',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1显示 0隐藏',
  PRIMARY KEY (`id`),
  KEY `star` (`star`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_shop_evaluate
-- ----------------------------
INSERT INTO `cmf_shop_evaluate` VALUES ('1', '6', '3', '1', '非常不错，用的很好，心情美美哒', null, '1520819881', '1');
INSERT INTO `cmf_shop_evaluate` VALUES ('2', '6', '1', '-1', '一般般', null, '1520819081', '1');
INSERT INTO `cmf_shop_evaluate` VALUES ('3', '6', '3', '-1', '道具卡发到你看', null, '1520819952', '1');
INSERT INTO `cmf_shop_evaluate` VALUES ('4', '6', '3', '1', '好爱', null, '1520912934', '1');
INSERT INTO `cmf_shop_evaluate` VALUES ('5', '6', '3', '0', '个热热', '[{\"url\":\"http:\\/\\/tx.car\\/upload\\/shop\\/20180310\\/aea761a589577d5254cdbd4aabb4041b.jpg\",\"name\":\"\"},{\"url\":\"http:\\/\\/tx.car\\/upload\\/shop\\/20180310\\/aea761a589577d5254cdbd4aabb4041b.jpg\",\"name\":\"\"}]', '1520913311', '1');

-- ----------------------------
-- Table structure for cmf_shop_gav
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_gav`;
CREATE TABLE `cmf_shop_gav` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `attr_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `av_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性值ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gav` (`goods_id`,`attr_id`,`av_id`) USING BTREE COMMENT '商品、属性和属性值对应唯一'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务商城产品属性关系表';

-- ----------------------------
-- Records of cmf_shop_gav
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods`;
CREATE TABLE `cmf_shop_goods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品公共表id',
  `cate_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类ID',
  `cate_id_1` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类ID',
  `cate_id_2` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类ID',
  `brand_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '产品名称',
  `thumbnail` varchar(1000) NOT NULL DEFAULT '' COMMENT '缩略图，主图',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '售价',
  `stock` smallint(6) unsigned NOT NULL DEFAULT '999' COMMENT '库存',
  `cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `coupon` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '优惠券：1开启 0关闭 。这个备用，暂时由总开关控制',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分兑换',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '产品简介',
  `content` text COMMENT '内容、详情',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `comments` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否热卖：0否 1是',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐：0否 1是',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态：-2禁止出售 -1下架 0初始态 1上架(售卖中)',
  `more` text COMMENT '扩展属性：',
  PRIMARY KEY (`id`),
  KEY `idx1` (`cate_id`),
  KEY `idx2` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='服务商城商品表';

-- ----------------------------
-- Records of cmf_shop_goods
-- ----------------------------
INSERT INTO `cmf_shop_goods` VALUES ('1', '1', '1', '1', '0', '盯盯拍M6智能WiFi行车记录仪', '/themes/datong_car/public/assets/images/product.png', '1000.00', '1923.00', '0', '2100.00', '1', '0', '', null, '1519959222', '0', '0', '1', '1', '1', null);
INSERT INTO `cmf_shop_goods` VALUES ('2', '2', '2', '0', '0', '壳牌（Shell）喜力 汽车机油 润滑油  4L装 5W-40全合成灰壳超凡喜力SN级', 'https://gd2.alicdn.com/imgextra/i3/574884780/TB2ZvHQnuJ8puFjy1XbXXagqVXa_!!574884780.jpg_400x400.jpg', '0.00', '52.00', '0', '60.00', '1', '0', '', null, '1519959285', '0', '0', '0', '0', '1', null);
INSERT INTO `cmf_shop_goods` VALUES ('3', '5', '1', '5', '0', '汽油发动机小车面包车矿物质机油SG15W40汽车四季保养通用', '/themes/datong_car/public/assets/images/product_04.png', '0.00', '88.00', '0', '100.00', '1', '0', '', null, '1519959334', '0', '0', '0', '0', '1', null);
INSERT INTO `cmf_shop_goods` VALUES ('4', '20', '4', '20', '4', '福田欧曼座椅汽车原厂配件 欧曼ETX气囊主座椅坐垫 海绵垫座垫', 'https://img-tmdetail.alicdn.com/bao/uploaded///img.alicdn.com/bao/uploaded/TB15LxoQXXXXXXxXpXXXXXXXXXX_!!0-item_pic.jpg_160x160q90.jpg', '12.00', '40.00', '0', '50.00', '1', '100', '', '&lt;p&gt;佛挡杀佛&lt;/p&gt;', '1519975823', '0', '0', '1', '1', '1', '{\"photos\":[{\"url\":\"https:\\/\\/img-tmdetail.alicdn.com\\/bao\\/uploaded\\/\\/\\/img.alicdn.com\\/bao\\/uploaded\\/TB1HbbDXIIrBKNjSZK9XXagoVXa_!!0-item_pic.jpg_160x160q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img-tmdetail.alicdn.com\\/bao\\/uploaded\\/\\/\\/img.alicdn.com\\/bao\\/uploaded\\/TB11oI9oiAKL1JjSZFoXXagCFXa_!!0-item_pic.jpg_160x160q90.jpg\",\"name\":\"\"}]}');
INSERT INTO `cmf_shop_goods` VALUES ('5', '10', '2', '10', '0', '力魔（LIQUI MOLY）超级新星合成润滑油', '/themes/datong_car/public/assets/images/product_01.png', '0.00', '96.00', '999', '101.00', '1', '1800', '', null, '1520321040', '0', '0', '0', '0', '1', null);
INSERT INTO `cmf_shop_goods` VALUES ('6', '11', '2', '11', '7', '邓禄普汽车轮胎SP T1 195/65R15 91H 本田思域适配包安装', 'shop/20180310/aea761a589577d5254cdbd4aabb4041b.jpg', '289.00', '309.00', '999', '376.00', '1', '5', '', '\n&lt;p&gt;&lt;span style=&quot;color: rgb(0, 112, 192); font-size: 14px;&quot;&gt;商品详情&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;color: rgb(0, 112, 192); font-size: 14px;&quot;&gt;南方金额为健康科教文&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;color: rgb(0, 112, 192); font-size: 14px;&quot;&gt;王庆伟二二我去额为全英文全英文确认完工iuo&lt;/span&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;color: rgb(0, 112, 192); font-size: 16px;&quot;&gt;&lt;img src=&quot;https://img.baidu.com/hi/jx2/j_0028.gif&quot;&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;h6 style=\'-webkit-tap-highlight-color: transparent; padding: 0px; margin: 0px; color: rgb(61, 31, 61); list-style: none; font-size: 16px; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal;\'&gt;&amp;gt;&amp;gt;温馨提示&amp;lt;&amp;lt;&lt;/h6&gt;\n&lt;p style=\'-webkit-tap-highlight-color: transparent; padding: 0px; margin-top: 10px; margin-bottom: 10px; color: rgb(153, 153, 153); list-style: none; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; line-height: 1.5;\'&gt;1.如果看上了本件商品，请直接拍下并付款,如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款&lt;/p&gt;\n&lt;p style=\'-webkit-tap-highlight-color: transparent; padding: 0px; margin-top: 10px; margin-bottom: 10px; color: rgb(153, 153, 153); list-style: none; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; line-height: 1.5;\'&gt;2.如果看上了本件商品，请直接拍下并付款,如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款&lt;/p&gt;\n&lt;p style=\'-webkit-tap-highlight-color: transparent; padding: 0px; margin-top: 10px; margin-bottom: 10px; color: rgb(153, 153, 153); list-style: none; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; line-height: 1.5;\'&gt;3.如果看上了本件商品，请直接拍下并付款,如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款&lt;/p&gt;\n&lt;p style=\'-webkit-tap-highlight-color: transparent; padding: 0px; margin-top: 10px; margin-bottom: 10px; color: rgb(153, 153, 153); list-style: none; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; line-height: 1.5;\'&gt;4.如果看上了本件商品，请直接拍下并付款,如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款如果看上了本件商品，请直接拍下并付款&lt;/p&gt;\n', '1520326388', '0', '0', '1', '1', '1', '{\"photos\":[{\"url\":\"https:\\/\\/img.alicdn.com\\/bao\\/uploaded\\/i3\\/1984719051\\/TB1dWdicb9YBuNjy0FgXXcxcXXa_!!0-item_pic.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i1\\/1984719051\\/TB25DhufyGO.eBjSZFpXXb3tFXa_!!1984719051.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i2\\/1984719051\\/TB2ZXk3uXXXXXaoXpXXXXXXXXXX_!!1984719051.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i1\\/1984719051\\/TB2ObZWXNbxQeBjy1XdXXXVBFXa_!!1984719051.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i3\\/1984719051\\/TB1vVyyfJzJ8KJjSspkXXbF7VXa_!!0-item_pic.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/bao\\/uploaded\\/i1\\/3297027993\\/TB1K0.8ibYI8KJjy0FaXXbAiVXa_!!0-item_pic.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i1\\/3297027993\\/TB28yTwd7fb_uJkSmRyXXbWxVXa_!!3297027993.jpg_60x60q90.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i3\\/3297027993\\/TB2947VnhPI8KJjSspfXXcCFXXa_!!3297027993.jpg_60x60q90.jpg\",\"name\":\"\"}]}');

-- ----------------------------
-- Table structure for cmf_shop_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods_attr`;
CREATE TABLE `cmf_shop_goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(201) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大。这个排序可放到shop_category_attr表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='服务商城属性表';

-- ----------------------------
-- Records of cmf_shop_goods_attr
-- ----------------------------
INSERT INTO `cmf_shop_goods_attr` VALUES ('1', '属性', '1', '400');
INSERT INTO `cmf_shop_goods_attr` VALUES ('2', '材质', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('3', '长度', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('4', ' 安装类型', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('5', '属性5', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('6', '属性2', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('7', '属性3', '1', '10000');
INSERT INTO `cmf_shop_goods_attr` VALUES ('8', '属性4', '1', '10000');

-- ----------------------------
-- Table structure for cmf_shop_goods_av
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods_av`;
CREATE TABLE `cmf_shop_goods_av` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attr_id` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `name` varchar(202) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COMMENT='服务商城属性值表';

-- ----------------------------
-- Records of cmf_shop_goods_av
-- ----------------------------
INSERT INTO `cmf_shop_goods_av` VALUES ('1', '1', '1-1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('2', '2', 'ss1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('3', '2', 'ss2', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('4', '1', '1-2', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('5', '2', 'ss3', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('6', '2', 'ss4', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('7', '5', '5-1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('8', '4', '自建型', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('9', '4', '全手动', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('10', '6', '2-1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('11', '6', '2-2', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('12', '6', '2-3', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('13', '7', '3-1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('14', '8', '4-1', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('15', '8', '4-2', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('16', '8', '4-3', '1', '10000');
INSERT INTO `cmf_shop_goods_av` VALUES ('17', '8', '4-4', '1', '10000');

-- ----------------------------
-- Table structure for cmf_shop_goods_category
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods_category`;
CREATE TABLE `cmf_shop_goods_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '深度，分类层级关系路径',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `spec_subset` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '规格关联到子类',
  `attr_subset` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '属性关联到子类',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐：0否 1是',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：0隐藏 1显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '默认值10000，默认排序按从小到大',
  PRIMARY KEY (`id`),
  KEY `idx1` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='服务商城类别表';

-- ----------------------------
-- Records of cmf_shop_goods_category
-- ----------------------------
INSERT INTO `cmf_shop_goods_category` VALUES ('1', '0', '0-1', '线下服务', '线下灵活的服务模式', '0', '1', '1', '1', '1', '10');
INSERT INTO `cmf_shop_goods_category` VALUES ('2', '0', '0-2', '维修保养', '', '0', '1', '1', '1', '1', '20');
INSERT INTO `cmf_shop_goods_category` VALUES ('3', '0', '0-3', '车载电器', '', '0', '0', '0', '1', '1', '30');
INSERT INTO `cmf_shop_goods_category` VALUES ('4', '0', '0-4', '汽车装饰', '', '0', '0', '0', '1', '1', '40');
INSERT INTO `cmf_shop_goods_category` VALUES ('5', '1', '0-1-5', '维修', '', '0', '0', '0', '0', '1', '1');
INSERT INTO `cmf_shop_goods_category` VALUES ('6', '1', '0-1-6', '美容清洗', '', '0', '0', '0', '1', '1', '2');
INSERT INTO `cmf_shop_goods_category` VALUES ('7', '1', '0-1-7', '功能升级', '', '0', '0', '0', '0', '1', '5');
INSERT INTO `cmf_shop_goods_category` VALUES ('8', '1', '0-1-8', '贴膜专区', '', '0', '0', '0', '0', '1', '3');
INSERT INTO `cmf_shop_goods_category` VALUES ('9', '1', '0-1-9', '车机导航', '', '0', '0', '0', '0', '1', '4');
INSERT INTO `cmf_shop_goods_category` VALUES ('10', '2', '0-2-10', '润滑油', '', '0', '0', '0', '0', '1', '1');
INSERT INTO `cmf_shop_goods_category` VALUES ('11', '2', '0-2-11', '轮胎', '', '0', '0', '0', '0', '1', '2');
INSERT INTO `cmf_shop_goods_category` VALUES ('12', '2', '0-2-12', '配件', '', '0', '0', '0', '0', '1', '3');
INSERT INTO `cmf_shop_goods_category` VALUES ('13', '2', '0-2-13', '添加剂', '', '0', '0', '0', '0', '1', '4');
INSERT INTO `cmf_shop_goods_category` VALUES ('14', '2', '0-2-14', '贴膜', '', '0', '0', '0', '0', '1', '5');
INSERT INTO `cmf_shop_goods_category` VALUES ('15', '3', '0-3-15', '行车记录仪', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('16', '3', '0-3-16', '发烧音响', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('17', '3', '0-3-17', '车载净化器', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('18', '3', '0-3-18', '冰箱电源', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('19', '3', '0-3-19', '车载导航', '', '0', '0', '0', '1', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('20', '4', '0-4-20', '座垫', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('21', '4', '0-4-21', '车香脚垫', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `cmf_shop_goods_category` VALUES ('22', '4', '0-4-22', '内饰', '', '0', '0', '0', '1', '1', '0');

-- ----------------------------
-- Table structure for cmf_shop_goods_item
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods_item`;
CREATE TABLE `cmf_shop_goods_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '每件商品关联的属性，便于查询j计算',
  `goods_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `attr_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '属性ID',
  `av_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性值ID',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='每件商品关联的属性表';

-- ----------------------------
-- Records of cmf_shop_goods_item
-- ----------------------------
INSERT INTO `cmf_shop_goods_item` VALUES ('19', '6', '2', '5');
INSERT INTO `cmf_shop_goods_item` VALUES ('20', '6', '4', '9');

-- ----------------------------
-- Table structure for cmf_shop_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods_spec`;
CREATE TABLE `cmf_shop_goods_spec` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品关联的规格，便于查询j计算',
  `goods_id` bigint(20) NOT NULL,
  `spec_vars` varchar(255) NOT NULL DEFAULT '' COMMENT '规格值',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '售价',
  `stock` smallint(6) unsigned NOT NULL DEFAULT '999' COMMENT '库存',
  `more` text COMMENT '拓展属性：图集',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='商品关联的规格表：单一规格对多个值关系';

-- ----------------------------
-- Records of cmf_shop_goods_spec
-- ----------------------------
INSERT INTO `cmf_shop_goods_spec` VALUES ('1', '6', '白色M号', '45.00', '36.00', '789', null);
INSERT INTO `cmf_shop_goods_spec` VALUES ('2', '6', '黑色L号', '56.00', '47.00', '333', null);

-- ----------------------------
-- Table structure for cmf_shop_order
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_order`;
CREATE TABLE `cmf_shop_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单编号',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '车子ID（只有一种商品时）',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `buyer_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '买家ID',
  `address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '买家收货信息',
  `seller_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卖家编号',
  `seller_username` varchar(30) NOT NULL DEFAULT '' COMMENT '卖家用户名',
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '订单号',
  `order_name` varchar(150) NOT NULL DEFAULT '' COMMENT '订单名称',
  `order_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简述：规格集合',
  `nums` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '商品总数',
  `bargain_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订金、预约金',
  `product_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品总额',
  `order_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实付款',
  `shipping_id` varchar(50) NOT NULL DEFAULT '' COMMENT '快递标识',
  `tracking_no` varchar(30) NOT NULL DEFAULT '' COMMENT '快递单号',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递费',
  `pay_id` varchar(30) NOT NULL DEFAULT '' COMMENT '支付标识：cash余额 alipay支付宝 wxpay微信',
  `refund` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款',
  `refund_data` varchar(255) NOT NULL DEFAULT '' COMMENT '审核资料：上传票据照片',
  `refund_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否退款：1是 0否',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注，给管理员区分记录类型用',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述，给前台用户用，用户附言',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '客户下单IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `cancel_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单取消时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间：确认收货后',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态：-11过期,-2卖家取消,-1买家取消,0待付款,1待发货,2待收货,3待评价,10完成',
  `more` text COMMENT '拓展数据：',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='服务商城订单表';

-- ----------------------------
-- Records of cmf_shop_order
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_shop_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_order_detail`;
CREATE TABLE `cmf_shop_order_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单明细编号',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `spec_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID，为0表示没有规格',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对象编号，商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '对象名称',
  `goods_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '对象类型：1实物（physical），2虚拟（virtual）',
  `number` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `code_type` varchar(20) NOT NULL DEFAULT '' COMMENT '用于增值服务code记录',
  `more` text COMMENT '拓展属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='服务商城订单详情表';

-- ----------------------------
-- Records of cmf_shop_order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_shop_shipping_address
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_shipping_address`;
CREATE TABLE `cmf_shop_shipping_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单明细编号',
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认：0否 1是',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人称呼',
  `telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `contact` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人联系方式',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货详细地址',
  `country_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '国家',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '地区',
  `street_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '街道',
  `more` text COMMENT '拓展属性',
  PRIMARY KEY (`id`),
  KEY `idx1` (`user_id`,`is_main`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='收货地址管理表';

-- ----------------------------
-- Records of cmf_shop_shipping_address
-- ----------------------------
INSERT INTO `cmf_shop_shipping_address` VALUES ('1', '1', '3', '大通', '13333333333', '', '安徽省合肥市蜀山区荷叶地街道绿地蓝海大厦B座605室', '0', '0', '0', '0', '0', null);
INSERT INTO `cmf_shop_shipping_address` VALUES ('2', '0', '3', 'ddd', '13333333333', '', 'sasa', '0', '0', '0', '0', '0', null);

-- ----------------------------
-- Table structure for cmf_shop_sku
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_sku`;
CREATE TABLE `cmf_shop_sku` (
  `id` bigint(20) unsigned NOT NULL COMMENT '商品SKU组合（商家货号）',
  `goods_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `spec_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID',
  `sku_md5` char(32) NOT NULL DEFAULT '' COMMENT 'SKU唯一码，用于筛选',
  `sku` text COMMENT '存放规格以及对应的规格值。规则（是否json?）：1:5g,6g,8g|2:红色,白色,清凉蓝色|3:S,M,L',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '售价',
  `stock` smallint(6) unsigned NOT NULL DEFAULT '999' COMMENT '库存',
  `thumbnail` varchar(1000) NOT NULL DEFAULT '' COMMENT '缩略图，主图',
  `more` text COMMENT '扩展数据：规格数据集（颜色、尺码）',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='shop应用 SKU组合表';

-- ----------------------------
-- Records of cmf_shop_sku
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_shop_spec
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_spec`;
CREATE TABLE `cmf_shop_spec` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,1:使用,0:不使用',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='商品规格表';

-- ----------------------------
-- Records of cmf_shop_spec
-- ----------------------------
INSERT INTO `cmf_shop_spec` VALUES ('1', '0', '颜色', '1', '1');
INSERT INTO `cmf_shop_spec` VALUES ('2', '0', '尺码', '1', '10');
INSERT INTO `cmf_shop_spec` VALUES ('3', '0', '型号', '0', '10');
