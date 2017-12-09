/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : usedcar

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-12-09 16:05:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `cmf_admin_menu`;
CREATE TABLE `cmf_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '菜单类型;1:有界面可访问菜单,2:无界面可访问菜单,0:只作为菜单',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;1:显示,0:不显示',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `app` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '应用名',
  `controller` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作名称',
  `param` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '额外参数',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parent_id`),
  KEY `model` (`controller`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of cmf_admin_menu
-- ----------------------------
INSERT INTO `cmf_admin_menu` VALUES ('1', '0', '0', '1', '90', 'admin', 'Plugin', 'default', '', '插件管理', 'cloud', '插件管理');
INSERT INTO `cmf_admin_menu` VALUES ('2', '1', '1', '1', '10000', 'admin', 'Hook', 'index', '', '钩子管理', '', '钩子管理');
INSERT INTO `cmf_admin_menu` VALUES ('3', '2', '1', '0', '10000', 'admin', 'Hook', 'plugins', '', '钩子插件管理', '', '钩子插件管理');
INSERT INTO `cmf_admin_menu` VALUES ('4', '2', '2', '0', '10000', 'admin', 'Hook', 'pluginListOrder', '', '钩子插件排序', '', '钩子插件排序');
INSERT INTO `cmf_admin_menu` VALUES ('5', '2', '1', '0', '10000', 'admin', 'Hook', 'sync', '', '同步钩子', '', '同步钩子');
INSERT INTO `cmf_admin_menu` VALUES ('6', '0', '0', '1', '80', 'admin', 'Setting', 'default', '', '设置', 'cogs', '系统设置入口');
INSERT INTO `cmf_admin_menu` VALUES ('7', '6', '1', '1', '50', 'admin', 'Link', 'index', '', '友情链接', '', '友情链接管理');
INSERT INTO `cmf_admin_menu` VALUES ('8', '7', '1', '0', '10000', 'admin', 'Link', 'add', '', '添加友情链接', '', '添加友情链接');
INSERT INTO `cmf_admin_menu` VALUES ('9', '7', '2', '0', '10000', 'admin', 'Link', 'addPost', '', '添加友情链接提交保存', '', '添加友情链接提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('10', '7', '1', '0', '10000', 'admin', 'Link', 'edit', '', '编辑友情链接', '', '编辑友情链接');
INSERT INTO `cmf_admin_menu` VALUES ('11', '7', '2', '0', '10000', 'admin', 'Link', 'editPost', '', '编辑友情链接提交保存', '', '编辑友情链接提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('12', '7', '2', '0', '10000', 'admin', 'Link', 'delete', '', '删除友情链接', '', '删除友情链接');
INSERT INTO `cmf_admin_menu` VALUES ('13', '7', '2', '0', '10000', 'admin', 'Link', 'listOrder', '', '友情链接排序', '', '友情链接排序');
INSERT INTO `cmf_admin_menu` VALUES ('14', '7', '2', '0', '10000', 'admin', 'Link', 'toggle', '', '友情链接显示隐藏', '', '友情链接显示隐藏');
INSERT INTO `cmf_admin_menu` VALUES ('15', '6', '1', '1', '10', 'admin', 'Mailer', 'index', '', '邮箱配置', '', '邮箱配置');
INSERT INTO `cmf_admin_menu` VALUES ('16', '15', '2', '0', '10000', 'admin', 'Mailer', 'indexPost', '', '邮箱配置提交保存', '', '邮箱配置提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('17', '15', '1', '0', '10000', 'admin', 'Mailer', 'template', '', '邮件模板', '', '邮件模板');
INSERT INTO `cmf_admin_menu` VALUES ('18', '15', '2', '0', '10000', 'admin', 'Mailer', 'templatePost', '', '邮件模板提交', '', '邮件模板提交');
INSERT INTO `cmf_admin_menu` VALUES ('19', '15', '1', '0', '10000', 'admin', 'Mailer', 'test', '', '邮件发送测试', '', '邮件发送测试');
INSERT INTO `cmf_admin_menu` VALUES ('20', '6', '1', '0', '700', 'admin', 'Menu', 'index', '', '后台菜单', '', '后台菜单管理');
INSERT INTO `cmf_admin_menu` VALUES ('21', '20', '1', '0', '10000', 'admin', 'Menu', 'lists', '', '所有菜单', '', '后台所有菜单列表');
INSERT INTO `cmf_admin_menu` VALUES ('22', '20', '1', '0', '10000', 'admin', 'Menu', 'add', '', '后台菜单添加', '', '后台菜单添加');
INSERT INTO `cmf_admin_menu` VALUES ('23', '20', '2', '0', '10000', 'admin', 'Menu', 'addPost', '', '后台菜单添加提交保存', '', '后台菜单添加提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('24', '20', '1', '0', '10000', 'admin', 'Menu', 'edit', '', '后台菜单编辑', '', '后台菜单编辑');
INSERT INTO `cmf_admin_menu` VALUES ('25', '20', '2', '0', '10000', 'admin', 'Menu', 'editPost', '', '后台菜单编辑提交保存', '', '后台菜单编辑提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('26', '20', '2', '0', '10000', 'admin', 'Menu', 'delete', '', '后台菜单删除', '', '后台菜单删除');
INSERT INTO `cmf_admin_menu` VALUES ('27', '20', '2', '0', '10000', 'admin', 'Menu', 'listOrder', '', '后台菜单排序', '', '后台菜单排序');
INSERT INTO `cmf_admin_menu` VALUES ('28', '20', '1', '0', '10000', 'admin', 'Menu', 'getActions', '', '导入新后台菜单', '', '导入新后台菜单');
INSERT INTO `cmf_admin_menu` VALUES ('29', '6', '1', '1', '30', 'admin', 'Nav', 'index', '', '导航管理', '', '导航管理');
INSERT INTO `cmf_admin_menu` VALUES ('30', '29', '1', '0', '10000', 'admin', 'Nav', 'add', '', '添加导航', '', '添加导航');
INSERT INTO `cmf_admin_menu` VALUES ('31', '29', '2', '0', '10000', 'admin', 'Nav', 'addPost', '', '添加导航提交保存', '', '添加导航提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('32', '29', '1', '0', '10000', 'admin', 'Nav', 'edit', '', '编辑导航', '', '编辑导航');
INSERT INTO `cmf_admin_menu` VALUES ('33', '29', '2', '0', '10000', 'admin', 'Nav', 'editPost', '', '编辑导航提交保存', '', '编辑导航提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('34', '29', '2', '0', '10000', 'admin', 'Nav', 'delete', '', '删除导航', '', '删除导航');
INSERT INTO `cmf_admin_menu` VALUES ('35', '29', '1', '0', '10000', 'admin', 'NavMenu', 'index', '', '导航菜单', '', '导航菜单');
INSERT INTO `cmf_admin_menu` VALUES ('36', '35', '1', '0', '10000', 'admin', 'NavMenu', 'add', '', '添加导航菜单', '', '添加导航菜单');
INSERT INTO `cmf_admin_menu` VALUES ('37', '35', '2', '0', '10000', 'admin', 'NavMenu', 'addPost', '', '添加导航菜单提交保存', '', '添加导航菜单提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('38', '35', '1', '0', '10000', 'admin', 'NavMenu', 'edit', '', '编辑导航菜单', '', '编辑导航菜单');
INSERT INTO `cmf_admin_menu` VALUES ('39', '35', '2', '0', '10000', 'admin', 'NavMenu', 'editPost', '', '编辑导航菜单提交保存', '', '编辑导航菜单提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('40', '35', '2', '0', '10000', 'admin', 'NavMenu', 'delete', '', '删除导航菜单', '', '删除导航菜单');
INSERT INTO `cmf_admin_menu` VALUES ('41', '35', '2', '0', '10000', 'admin', 'NavMenu', 'listOrder', '', '导航菜单排序', '', '导航菜单排序');
INSERT INTO `cmf_admin_menu` VALUES ('42', '1', '1', '1', '10000', 'admin', 'Plugin', 'index', '', '插件列表', '', '插件列表');
INSERT INTO `cmf_admin_menu` VALUES ('43', '42', '2', '0', '10000', 'admin', 'Plugin', 'toggle', '', '插件启用禁用', '', '插件启用禁用');
INSERT INTO `cmf_admin_menu` VALUES ('44', '42', '1', '0', '10000', 'admin', 'Plugin', 'setting', '', '插件设置', '', '插件设置');
INSERT INTO `cmf_admin_menu` VALUES ('45', '42', '2', '0', '10000', 'admin', 'Plugin', 'settingPost', '', '插件设置提交', '', '插件设置提交');
INSERT INTO `cmf_admin_menu` VALUES ('46', '42', '2', '0', '10000', 'admin', 'Plugin', 'install', '', '插件安装', '', '插件安装');
INSERT INTO `cmf_admin_menu` VALUES ('47', '42', '2', '0', '10000', 'admin', 'Plugin', 'update', '', '插件更新', '', '插件更新');
INSERT INTO `cmf_admin_menu` VALUES ('48', '42', '2', '0', '10000', 'admin', 'Plugin', 'uninstall', '', '卸载插件', '', '卸载插件');
INSERT INTO `cmf_admin_menu` VALUES ('49', '109', '0', '1', '10000', 'admin', 'User', 'default', '', '管理组', '', '管理组');
INSERT INTO `cmf_admin_menu` VALUES ('50', '49', '1', '1', '10000', 'admin', 'Rbac', 'index', '', '角色管理', '', '角色管理');
INSERT INTO `cmf_admin_menu` VALUES ('51', '50', '1', '0', '10000', 'admin', 'Rbac', 'roleAdd', '', '添加角色', '', '添加角色');
INSERT INTO `cmf_admin_menu` VALUES ('52', '50', '2', '0', '10000', 'admin', 'Rbac', 'roleAddPost', '', '添加角色提交', '', '添加角色提交');
INSERT INTO `cmf_admin_menu` VALUES ('53', '50', '1', '0', '10000', 'admin', 'Rbac', 'roleEdit', '', '编辑角色', '', '编辑角色');
INSERT INTO `cmf_admin_menu` VALUES ('54', '50', '2', '0', '10000', 'admin', 'Rbac', 'roleEditPost', '', '编辑角色提交', '', '编辑角色提交');
INSERT INTO `cmf_admin_menu` VALUES ('55', '50', '2', '0', '10000', 'admin', 'Rbac', 'roleDelete', '', '删除角色', '', '删除角色');
INSERT INTO `cmf_admin_menu` VALUES ('56', '50', '1', '0', '10000', 'admin', 'Rbac', 'authorize', '', '设置角色权限', '', '设置角色权限');
INSERT INTO `cmf_admin_menu` VALUES ('57', '50', '2', '0', '10000', 'admin', 'Rbac', 'authorizePost', '', '角色授权提交', '', '角色授权提交');
INSERT INTO `cmf_admin_menu` VALUES ('58', '0', '1', '0', '10000', 'admin', 'RecycleBin', 'index', '', '回收站', '', '回收站');
INSERT INTO `cmf_admin_menu` VALUES ('59', '58', '2', '0', '10000', 'admin', 'RecycleBin', 'restore', '', '回收站还原', '', '回收站还原');
INSERT INTO `cmf_admin_menu` VALUES ('60', '58', '2', '0', '10000', 'admin', 'RecycleBin', 'delete', '', '回收站彻底删除', '', '回收站彻底删除');
INSERT INTO `cmf_admin_menu` VALUES ('61', '6', '1', '1', '800', 'admin', 'Route', 'index', '', 'URL美化', '', 'URL规则管理');
INSERT INTO `cmf_admin_menu` VALUES ('62', '61', '1', '0', '10000', 'admin', 'Route', 'add', '', '添加路由规则', '', '添加路由规则');
INSERT INTO `cmf_admin_menu` VALUES ('63', '61', '2', '0', '10000', 'admin', 'Route', 'addPost', '', '添加路由规则提交', '', '添加路由规则提交');
INSERT INTO `cmf_admin_menu` VALUES ('64', '61', '1', '0', '10000', 'admin', 'Route', 'edit', '', '路由规则编辑', '', '路由规则编辑');
INSERT INTO `cmf_admin_menu` VALUES ('65', '61', '2', '0', '10000', 'admin', 'Route', 'editPost', '', '路由规则编辑提交', '', '路由规则编辑提交');
INSERT INTO `cmf_admin_menu` VALUES ('66', '61', '2', '0', '10000', 'admin', 'Route', 'delete', '', '路由规则删除', '', '路由规则删除');
INSERT INTO `cmf_admin_menu` VALUES ('67', '61', '2', '0', '10000', 'admin', 'Route', 'ban', '', '路由规则禁用', '', '路由规则禁用');
INSERT INTO `cmf_admin_menu` VALUES ('68', '61', '2', '0', '10000', 'admin', 'Route', 'open', '', '路由规则启用', '', '路由规则启用');
INSERT INTO `cmf_admin_menu` VALUES ('69', '61', '2', '0', '10000', 'admin', 'Route', 'listOrder', '', '路由规则排序', '', '路由规则排序');
INSERT INTO `cmf_admin_menu` VALUES ('70', '61', '1', '0', '10000', 'admin', 'Route', 'select', '', '选择URL', '', '选择URL');
INSERT INTO `cmf_admin_menu` VALUES ('71', '6', '1', '1', '0', 'admin', 'Setting', 'site', '', '网站信息', '', '网站信息');
INSERT INTO `cmf_admin_menu` VALUES ('72', '71', '2', '0', '10000', 'admin', 'Setting', 'sitePost', '', '网站信息设置提交', '', '网站信息设置提交');
INSERT INTO `cmf_admin_menu` VALUES ('73', '6', '1', '0', '850', 'admin', 'Setting', 'password', '', '密码修改', '', '密码修改');
INSERT INTO `cmf_admin_menu` VALUES ('74', '73', '2', '0', '10000', 'admin', 'Setting', 'passwordPost', '', '密码修改提交', '', '密码修改提交');
INSERT INTO `cmf_admin_menu` VALUES ('75', '6', '1', '1', '60', 'admin', 'Setting', 'upload', '', '上传设置', '', '上传设置');
INSERT INTO `cmf_admin_menu` VALUES ('76', '75', '2', '0', '10000', 'admin', 'Setting', 'uploadPost', '', '上传设置提交', '', '上传设置提交');
INSERT INTO `cmf_admin_menu` VALUES ('77', '6', '1', '0', '10000', 'admin', 'Setting', 'clearCache', '', '清除缓存', '', '清除缓存');
INSERT INTO `cmf_admin_menu` VALUES ('78', '6', '1', '1', '40', 'admin', 'Slide', 'index', '', '幻灯片管理', '', '幻灯片管理');
INSERT INTO `cmf_admin_menu` VALUES ('79', '78', '1', '0', '10000', 'admin', 'Slide', 'add', '', '添加幻灯片', '', '添加幻灯片');
INSERT INTO `cmf_admin_menu` VALUES ('80', '78', '2', '0', '10000', 'admin', 'Slide', 'addPost', '', '添加幻灯片提交', '', '添加幻灯片提交');
INSERT INTO `cmf_admin_menu` VALUES ('81', '78', '1', '0', '10000', 'admin', 'Slide', 'edit', '', '编辑幻灯片', '', '编辑幻灯片');
INSERT INTO `cmf_admin_menu` VALUES ('82', '78', '2', '0', '10000', 'admin', 'Slide', 'editPost', '', '编辑幻灯片提交', '', '编辑幻灯片提交');
INSERT INTO `cmf_admin_menu` VALUES ('83', '78', '2', '0', '10000', 'admin', 'Slide', 'delete', '', '删除幻灯片', '', '删除幻灯片');
INSERT INTO `cmf_admin_menu` VALUES ('84', '78', '1', '0', '10000', 'admin', 'SlideItem', 'index', '', '幻灯片页面列表', '', '幻灯片页面列表');
INSERT INTO `cmf_admin_menu` VALUES ('85', '84', '1', '0', '10000', 'admin', 'SlideItem', 'add', '', '幻灯片页面添加', '', '幻灯片页面添加');
INSERT INTO `cmf_admin_menu` VALUES ('86', '84', '2', '0', '10000', 'admin', 'SlideItem', 'addPost', '', '幻灯片页面添加提交', '', '幻灯片页面添加提交');
INSERT INTO `cmf_admin_menu` VALUES ('87', '84', '1', '0', '10000', 'admin', 'SlideItem', 'edit', '', '幻灯片页面编辑', '', '幻灯片页面编辑');
INSERT INTO `cmf_admin_menu` VALUES ('88', '84', '2', '0', '10000', 'admin', 'SlideItem', 'editPost', '', '幻灯片页面编辑提交', '', '幻灯片页面编辑提交');
INSERT INTO `cmf_admin_menu` VALUES ('89', '84', '2', '0', '10000', 'admin', 'SlideItem', 'delete', '', '幻灯片页面删除', '', '幻灯片页面删除');
INSERT INTO `cmf_admin_menu` VALUES ('90', '84', '2', '0', '10000', 'admin', 'SlideItem', 'ban', '', '幻灯片页面隐藏', '', '幻灯片页面隐藏');
INSERT INTO `cmf_admin_menu` VALUES ('91', '84', '2', '0', '10000', 'admin', 'SlideItem', 'cancelBan', '', '幻灯片页面显示', '', '幻灯片页面显示');
INSERT INTO `cmf_admin_menu` VALUES ('92', '84', '2', '0', '10000', 'admin', 'SlideItem', 'listOrder', '', '幻灯片页面排序', '', '幻灯片页面排序');
INSERT INTO `cmf_admin_menu` VALUES ('93', '6', '1', '1', '100', 'admin', 'Storage', 'index', '', '文件存储', '', '文件存储');
INSERT INTO `cmf_admin_menu` VALUES ('94', '93', '2', '0', '10000', 'admin', 'Storage', 'settingPost', '', '文件存储设置提交', '', '文件存储设置提交');
INSERT INTO `cmf_admin_menu` VALUES ('95', '6', '1', '1', '105', 'admin', 'Theme', 'index', '', '模板管理', '', '模板管理');
INSERT INTO `cmf_admin_menu` VALUES ('96', '95', '1', '0', '10000', 'admin', 'Theme', 'install', '', '安装模板', '', '安装模板');
INSERT INTO `cmf_admin_menu` VALUES ('97', '95', '2', '0', '10000', 'admin', 'Theme', 'uninstall', '', '卸载模板', '', '卸载模板');
INSERT INTO `cmf_admin_menu` VALUES ('98', '95', '2', '0', '10000', 'admin', 'Theme', 'installTheme', '', '模板安装', '', '模板安装');
INSERT INTO `cmf_admin_menu` VALUES ('99', '95', '2', '0', '10000', 'admin', 'Theme', 'update', '', '模板更新', '', '模板更新');
INSERT INTO `cmf_admin_menu` VALUES ('100', '95', '2', '0', '10000', 'admin', 'Theme', 'active', '', '启用模板', '', '启用模板');
INSERT INTO `cmf_admin_menu` VALUES ('101', '95', '1', '0', '10000', 'admin', 'Theme', 'files', '', '模板文件列表', '', '启用模板');
INSERT INTO `cmf_admin_menu` VALUES ('102', '95', '1', '0', '10000', 'admin', 'Theme', 'fileSetting', '', '模板文件设置', '', '模板文件设置');
INSERT INTO `cmf_admin_menu` VALUES ('103', '95', '1', '0', '10000', 'admin', 'Theme', 'fileArrayData', '', '模板文件数组数据列表', '', '模板文件数组数据列表');
INSERT INTO `cmf_admin_menu` VALUES ('104', '95', '2', '0', '10000', 'admin', 'Theme', 'fileArrayDataEdit', '', '模板文件数组数据添加编辑', '', '模板文件数组数据添加编辑');
INSERT INTO `cmf_admin_menu` VALUES ('105', '95', '2', '0', '10000', 'admin', 'Theme', 'fileArrayDataEditPost', '', '模板文件数组数据添加编辑提交保存', '', '模板文件数组数据添加编辑提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('106', '95', '2', '0', '10000', 'admin', 'Theme', 'fileArrayDataDelete', '', '模板文件数组数据删除', '', '模板文件数组数据删除');
INSERT INTO `cmf_admin_menu` VALUES ('107', '95', '2', '0', '10000', 'admin', 'Theme', 'settingPost', '', '模板文件编辑提交保存', '', '模板文件编辑提交保存');
INSERT INTO `cmf_admin_menu` VALUES ('108', '95', '1', '0', '10000', 'admin', 'Theme', 'dataSource', '', '模板文件设置数据源', '', '模板文件设置数据源');
INSERT INTO `cmf_admin_menu` VALUES ('109', '0', '0', '1', '50', 'user', 'AdminIndex', 'default', '', '用户管理', 'group', '用户管理');
INSERT INTO `cmf_admin_menu` VALUES ('110', '49', '1', '1', '10000', 'admin', 'User', 'index', '', '管理员', '', '管理员管理');
INSERT INTO `cmf_admin_menu` VALUES ('111', '110', '1', '0', '10000', 'admin', 'User', 'add', '', '管理员添加', '', '管理员添加');
INSERT INTO `cmf_admin_menu` VALUES ('112', '110', '2', '0', '10000', 'admin', 'User', 'addPost', '', '管理员添加提交', '', '管理员添加提交');
INSERT INTO `cmf_admin_menu` VALUES ('113', '110', '1', '0', '10000', 'admin', 'User', 'edit', '', '管理员编辑', '', '管理员编辑');
INSERT INTO `cmf_admin_menu` VALUES ('114', '110', '2', '0', '10000', 'admin', 'User', 'editPost', '', '管理员编辑提交', '', '管理员编辑提交');
INSERT INTO `cmf_admin_menu` VALUES ('115', '110', '1', '0', '10000', 'admin', 'User', 'userInfo', '', '个人信息', '', '管理员个人信息修改');
INSERT INTO `cmf_admin_menu` VALUES ('116', '110', '2', '0', '10000', 'admin', 'User', 'userInfoPost', '', '管理员个人信息修改提交', '', '管理员个人信息修改提交');
INSERT INTO `cmf_admin_menu` VALUES ('117', '110', '2', '0', '10000', 'admin', 'User', 'delete', '', '管理员删除', '', '管理员删除');
INSERT INTO `cmf_admin_menu` VALUES ('118', '110', '2', '0', '10000', 'admin', 'User', 'ban', '', '停用管理员', '', '停用管理员');
INSERT INTO `cmf_admin_menu` VALUES ('119', '110', '2', '0', '10000', 'admin', 'User', 'cancelBan', '', '启用管理员', '', '启用管理员');
INSERT INTO `cmf_admin_menu` VALUES ('120', '0', '0', '1', '70', 'portal', 'AdminIndex', 'default', '', '门户管理', 'th', '门户管理');
INSERT INTO `cmf_admin_menu` VALUES ('121', '120', '1', '1', '10000', 'portal', 'AdminArticle', 'index', '', '文章管理', '', '文章列表');
INSERT INTO `cmf_admin_menu` VALUES ('122', '121', '1', '0', '10000', 'portal', 'AdminArticle', 'add', '', '添加文章', '', '添加文章');
INSERT INTO `cmf_admin_menu` VALUES ('123', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'addPost', '', '添加文章提交', '', '添加文章提交');
INSERT INTO `cmf_admin_menu` VALUES ('124', '121', '1', '0', '10000', 'portal', 'AdminArticle', 'edit', '', '编辑文章', '', '编辑文章');
INSERT INTO `cmf_admin_menu` VALUES ('125', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'editPost', '', '编辑文章提交', '', '编辑文章提交');
INSERT INTO `cmf_admin_menu` VALUES ('126', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'delete', '', '文章删除', '', '文章删除');
INSERT INTO `cmf_admin_menu` VALUES ('127', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'publish', '', '文章发布', '', '文章发布');
INSERT INTO `cmf_admin_menu` VALUES ('128', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'top', '', '文章置顶', '', '文章置顶');
INSERT INTO `cmf_admin_menu` VALUES ('129', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'recommend', '', '文章推荐', '', '文章推荐');
INSERT INTO `cmf_admin_menu` VALUES ('130', '121', '2', '0', '10000', 'portal', 'AdminArticle', 'listOrder', '', '文章排序', '', '文章排序');
INSERT INTO `cmf_admin_menu` VALUES ('131', '120', '1', '1', '10000', 'portal', 'AdminCategory', 'index', '', '分类管理', '', '文章分类列表');
INSERT INTO `cmf_admin_menu` VALUES ('132', '131', '1', '0', '10000', 'portal', 'AdminCategory', 'add', '', '添加文章分类', '', '添加文章分类');
INSERT INTO `cmf_admin_menu` VALUES ('133', '131', '2', '0', '10000', 'portal', 'AdminCategory', 'addPost', '', '添加文章分类提交', '', '添加文章分类提交');
INSERT INTO `cmf_admin_menu` VALUES ('134', '131', '1', '0', '10000', 'portal', 'AdminCategory', 'edit', '', '编辑文章分类', '', '编辑文章分类');
INSERT INTO `cmf_admin_menu` VALUES ('135', '131', '2', '0', '10000', 'portal', 'AdminCategory', 'editPost', '', '编辑文章分类提交', '', '编辑文章分类提交');
INSERT INTO `cmf_admin_menu` VALUES ('136', '131', '1', '0', '10000', 'portal', 'AdminCategory', 'select', '', '文章分类选择对话框', '', '文章分类选择对话框');
INSERT INTO `cmf_admin_menu` VALUES ('137', '131', '2', '0', '10000', 'portal', 'AdminCategory', 'listOrder', '', '文章分类排序', '', '文章分类排序');
INSERT INTO `cmf_admin_menu` VALUES ('138', '131', '2', '0', '10000', 'portal', 'AdminCategory', 'delete', '', '删除文章分类', '', '删除文章分类');
INSERT INTO `cmf_admin_menu` VALUES ('139', '120', '1', '1', '10000', 'portal', 'AdminPage', 'index', '', '页面管理', '', '页面管理');
INSERT INTO `cmf_admin_menu` VALUES ('140', '139', '1', '0', '10000', 'portal', 'AdminPage', 'add', '', '添加页面', '', '添加页面');
INSERT INTO `cmf_admin_menu` VALUES ('141', '139', '2', '0', '10000', 'portal', 'AdminPage', 'addPost', '', '添加页面提交', '', '添加页面提交');
INSERT INTO `cmf_admin_menu` VALUES ('142', '139', '1', '0', '10000', 'portal', 'AdminPage', 'edit', '', '编辑页面', '', '编辑页面');
INSERT INTO `cmf_admin_menu` VALUES ('143', '139', '2', '0', '10000', 'portal', 'AdminPage', 'editPost', '', '编辑页面提交', '', '编辑页面提交');
INSERT INTO `cmf_admin_menu` VALUES ('144', '139', '2', '0', '10000', 'portal', 'AdminPage', 'delete', '', '删除页面', '', '删除页面');
INSERT INTO `cmf_admin_menu` VALUES ('145', '120', '1', '1', '10000', 'portal', 'AdminTag', 'index', '', '文章标签', '', '文章标签');
INSERT INTO `cmf_admin_menu` VALUES ('146', '145', '1', '0', '10000', 'portal', 'AdminTag', 'add', '', '添加文章标签', '', '添加文章标签');
INSERT INTO `cmf_admin_menu` VALUES ('147', '145', '2', '0', '10000', 'portal', 'AdminTag', 'addPost', '', '添加文章标签提交', '', '添加文章标签提交');
INSERT INTO `cmf_admin_menu` VALUES ('148', '145', '2', '0', '10000', 'portal', 'AdminTag', 'upStatus', '', '更新标签状态', '', '更新标签状态');
INSERT INTO `cmf_admin_menu` VALUES ('149', '145', '2', '0', '10000', 'portal', 'AdminTag', 'delete', '', '删除文章标签', '', '删除文章标签');
INSERT INTO `cmf_admin_menu` VALUES ('150', '0', '1', '0', '10000', 'user', 'AdminAsset', 'index', '', '资源管理', 'file', '资源管理列表');
INSERT INTO `cmf_admin_menu` VALUES ('151', '150', '2', '0', '10000', 'user', 'AdminAsset', 'delete', '', '删除文件', '', '删除文件');
INSERT INTO `cmf_admin_menu` VALUES ('152', '109', '0', '1', '10000', 'user', 'AdminIndex', 'default1', '', '用户组', '', '用户组');
INSERT INTO `cmf_admin_menu` VALUES ('153', '152', '1', '1', '10000', 'user', 'AdminIndex', 'index', '', '本站用户', '', '本站用户');
INSERT INTO `cmf_admin_menu` VALUES ('154', '153', '2', '0', '10000', 'user', 'AdminIndex', 'ban', '', '本站用户拉黑', '', '本站用户拉黑');
INSERT INTO `cmf_admin_menu` VALUES ('155', '153', '2', '0', '10000', 'user', 'AdminIndex', 'cancelBan', '', '本站用户启用', '', '本站用户启用');
INSERT INTO `cmf_admin_menu` VALUES ('156', '152', '1', '1', '10000', 'user', 'AdminOauth', 'index', '', '第三方用户', '', '第三方用户');
INSERT INTO `cmf_admin_menu` VALUES ('157', '156', '2', '0', '10000', 'user', 'AdminOauth', 'delete', '', '删除第三方用户绑定', '', '删除第三方用户绑定');
INSERT INTO `cmf_admin_menu` VALUES ('158', '6', '1', '1', '900', 'user', 'AdminUserAction', 'index', '', '用户操作管理', '', '用户操作管理');
INSERT INTO `cmf_admin_menu` VALUES ('159', '158', '1', '0', '10000', 'user', 'AdminUserAction', 'edit', '', '编辑用户操作', '', '编辑用户操作');
INSERT INTO `cmf_admin_menu` VALUES ('160', '158', '2', '0', '10000', 'user', 'AdminUserAction', 'editPost', '', '编辑用户操作提交', '', '编辑用户操作提交');
INSERT INTO `cmf_admin_menu` VALUES ('161', '158', '1', '0', '10000', 'user', 'AdminUserAction', 'sync', '', '同步用户操作', '', '同步用户操作');
INSERT INTO `cmf_admin_menu` VALUES ('162', '0', '1', '1', '20', 'insurance', 'AdminIndex', 'default', '', '车险服务', 'flash', '');
INSERT INTO `cmf_admin_menu` VALUES ('163', '0', '1', '1', '30', 'trade', 'AdminIndex', 'default', '', '车辆买卖', 'car', '');
INSERT INTO `cmf_admin_menu` VALUES ('164', '0', '1', '1', '40', 'service', 'AdminIndex', 'default', '', '车辆业务', 'cubes', '');
INSERT INTO `cmf_admin_menu` VALUES ('165', '0', '1', '1', '10', 'usual', 'AdminIndex', 'default', '', '车辆统配', 'cogs', '');
INSERT INTO `cmf_admin_menu` VALUES ('166', '165', '1', '1', '5', 'usual', 'AdminItemCate', 'index', '', '车辆属性', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('167', '165', '1', '1', '2', 'usual', 'AdminBrand', 'index', '', '品牌管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('168', '165', '1', '1', '15', 'usual', 'AdminVerify', 'index', '', '认证管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('169', '165', '1', '1', '10', 'usual', 'AdminCompany', 'index', 'id=1', '公司企业管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('170', '162', '1', '1', '2', 'insurance', 'AdminInsurance', 'index', '', '保险业务', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('171', '162', '1', '1', '1', 'insurance', 'AdminOrder', 'index', '', '保单管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('172', '163', '1', '1', '10000', 'trade', 'AdminOrder', 'index', '', '订单管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('173', '164', '1', '1', '10000', 'service', 'AdminService', 'index', '', '业务管理', '', '⊙菜鸟验车\r\n⊙预约检车\r\n⊙上牌预约\r\n⊙过户申请\r\n⊙合作寄存点\r\n⊙服务地点');
INSERT INTO `cmf_admin_menu` VALUES ('174', '164', '1', '1', '10000', 'service', 'AdminCategory', 'index', '', '业务模型', '', '⊙菜鸟验车\r\n⊙预约检车\r\n⊙上牌预约\r\n⊙过户申请\r\n⊙合作寄存点\r\n⊙服务地点');
INSERT INTO `cmf_admin_menu` VALUES ('175', '163', '1', '1', '10000', 'trade', 'AdminShop', 'index', '', '店铺管理', '', '由用户表里的用户 产生店铺');
INSERT INTO `cmf_admin_menu` VALUES ('176', '165', '1', '1', '100', 'usual', 'AdminIndex', 'config', '', '二手车配置', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('177', '165', '1', '1', '3', 'usual', 'AdminSeries', 'index', '', '车系管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('178', '165', '1', '1', '4', 'usual', 'AdminModels', 'index', '', '车型管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('179', '167', '1', '0', '10000', 'usual', 'AdminBrand', 'add', '', '品牌添加', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('180', '6', '1', '1', '10000', 'admin', 'District', 'index', '', '地区管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('181', '162', '1', '1', '3', 'insurance', 'AdminCoverage', 'index', '', '险种管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('182', '165', '1', '1', '1', 'usual', 'AdminCar', 'index', '', '车辆管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('183', '6', '1', '1', '1000', 'admin', 'DbBackup', 'index', '', '数据库管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('184', '165', '1', '1', '20', 'usual', 'AdminNews', 'index', '', '消息管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('185', '0', '0', '1', '60', 'funds', 'AdminFunds', 'default', '', '资金管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('186', '185', '1', '1', '10000', 'funds', 'AdminFunds', 'index', '', '资金列表', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('187', '185', '1', '1', '10000', 'funds', 'AdminRecharge', 'index', '', '充值管理', '', '');
INSERT INTO `cmf_admin_menu` VALUES ('188', '185', '1', '1', '10000', 'funds', 'AdminWithdraw', 'index', '', '提现管理', '', '');

-- ----------------------------
-- Table structure for cmf_asset
-- ----------------------------
DROP TABLE IF EXISTS `cmf_asset`;
CREATE TABLE `cmf_asset` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `file_size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小,单位B',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:可用,0:不可用',
  `download_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `file_key` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件惟一码',
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `file_path` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件路径,相对于upload目录,可以为url',
  `file_md5` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件md5值',
  `file_sha1` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `suffix` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀名,不包括点',
  `more` text COMMENT '其它详细信息,JSON格式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='资源表';

-- ----------------------------
-- Records of cmf_asset
-- ----------------------------
INSERT INTO `cmf_asset` VALUES ('5', '1', '4288', '1507876093', '1', '0', '0017258984a2322273fbde79a092b884674ad9f0f016ad18697d9cb29c423616', '大通车服logo.png', 'portal/20171013/1f661e0d9d9f0c97b17a50e6e06580c0.png', '0017258984a2322273fbde79a092b884', '796d87176a36d808062bc11080cde44872bee928', 'png', '');

-- ----------------------------
-- Table structure for cmf_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `cmf_auth_access`;
CREATE TABLE `cmf_auth_access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类,请加应用前缀,如admin_',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of cmf_auth_access
-- ----------------------------
INSERT INTO `cmf_auth_access` VALUES ('1', '3', 'usual/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('2', '3', 'usual/adminnews/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('3', '3', 'insurance/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('4', '3', 'insurance/adminorder/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('5', '3', 'trade/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('6', '3', 'trade/adminorder/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('7', '3', 'service/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('8', '3', 'service/adminservice/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('9', '3', 'portal/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('10', '3', 'portal/adminarticle/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('11', '3', 'portal/adminarticle/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('12', '3', 'portal/adminarticle/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('13', '3', 'portal/adminarticle/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('14', '3', 'portal/adminarticle/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('15', '3', 'portal/adminarticle/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('16', '3', 'portal/adminarticle/publish', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('17', '3', 'portal/adminarticle/top', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('18', '3', 'portal/adminarticle/recommend', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('19', '3', 'portal/adminarticle/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('20', '3', 'portal/admincategory/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('21', '3', 'portal/admincategory/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('22', '3', 'portal/admincategory/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('23', '3', 'portal/admincategory/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('24', '3', 'portal/admincategory/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('25', '3', 'portal/admincategory/select', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('26', '3', 'portal/admincategory/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('27', '3', 'portal/admincategory/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('28', '3', 'portal/adminpage/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('29', '3', 'portal/adminpage/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('30', '3', 'portal/adminpage/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('31', '3', 'portal/adminpage/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('32', '3', 'portal/adminpage/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('33', '3', 'portal/adminpage/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('34', '3', 'portal/admintag/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('35', '3', 'portal/admintag/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('36', '3', 'portal/admintag/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('37', '3', 'portal/admintag/upstatus', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('38', '3', 'portal/admintag/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('39', '4', 'usual/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('40', '4', 'usual/admincar/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('41', '4', 'usual/adminbrand/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('42', '4', 'usual/adminbrand/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('43', '4', 'usual/adminseries/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('44', '4', 'usual/adminmodels/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('45', '4', 'usual/adminitemcate/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('46', '4', 'usual/adminverify/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('47', '4', 'usual/adminnews/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('48', '4', 'insurance/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('49', '4', 'insurance/admininsurance/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('50', '4', 'insurance/admincoverage/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('51', '4', 'trade/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('52', '4', 'trade/adminshop/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('53', '4', 'service/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('54', '4', 'service/admincategory/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('55', '4', 'user/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('56', '4', 'user/adminindex/default1', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('57', '4', 'user/adminindex/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('58', '4', 'user/adminindex/ban', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('59', '4', 'user/adminindex/cancelban', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('60', '4', 'user/adminoauth/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('61', '4', 'user/adminoauth/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('62', '4', 'portal/adminindex/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('63', '4', 'portal/adminarticle/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('64', '4', 'portal/adminarticle/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('65', '4', 'portal/adminarticle/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('66', '4', 'portal/adminarticle/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('67', '4', 'portal/adminarticle/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('68', '4', 'portal/adminarticle/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('69', '4', 'portal/adminarticle/publish', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('70', '4', 'portal/adminarticle/top', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('71', '4', 'portal/adminarticle/recommend', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('72', '4', 'portal/adminarticle/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('73', '4', 'portal/admincategory/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('74', '4', 'portal/admincategory/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('75', '4', 'portal/admincategory/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('76', '4', 'portal/admincategory/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('77', '4', 'portal/admincategory/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('78', '4', 'portal/admincategory/select', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('79', '4', 'portal/admincategory/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('80', '4', 'portal/admincategory/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('81', '4', 'portal/adminpage/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('82', '4', 'portal/adminpage/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('83', '4', 'portal/adminpage/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('84', '4', 'portal/adminpage/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('85', '4', 'portal/adminpage/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('86', '4', 'portal/adminpage/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('87', '4', 'portal/admintag/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('88', '4', 'portal/admintag/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('89', '4', 'portal/admintag/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('90', '4', 'portal/admintag/upstatus', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('91', '4', 'portal/admintag/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('92', '4', 'admin/setting/default', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('93', '4', 'admin/setting/site', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('94', '4', 'admin/setting/sitepost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('95', '4', 'admin/nav/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('96', '4', 'admin/nav/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('97', '4', 'admin/nav/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('98', '4', 'admin/nav/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('99', '4', 'admin/nav/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('100', '4', 'admin/nav/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('101', '4', 'admin/navmenu/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('102', '4', 'admin/navmenu/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('103', '4', 'admin/navmenu/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('104', '4', 'admin/navmenu/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('105', '4', 'admin/navmenu/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('106', '4', 'admin/navmenu/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('107', '4', 'admin/navmenu/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('108', '4', 'admin/slide/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('109', '4', 'admin/slide/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('110', '4', 'admin/slide/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('111', '4', 'admin/slide/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('112', '4', 'admin/slide/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('113', '4', 'admin/slide/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('114', '4', 'admin/slideitem/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('115', '4', 'admin/slideitem/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('116', '4', 'admin/slideitem/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('117', '4', 'admin/slideitem/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('118', '4', 'admin/slideitem/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('119', '4', 'admin/slideitem/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('120', '4', 'admin/slideitem/ban', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('121', '4', 'admin/slideitem/cancelban', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('122', '4', 'admin/slideitem/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('123', '4', 'admin/link/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('124', '4', 'admin/link/add', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('125', '4', 'admin/link/addpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('126', '4', 'admin/link/edit', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('127', '4', 'admin/link/editpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('128', '4', 'admin/link/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('129', '4', 'admin/link/listorder', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('130', '4', 'admin/link/toggle', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('131', '4', 'admin/setting/upload', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('132', '4', 'admin/setting/uploadpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('133', '4', 'admin/setting/password', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('134', '4', 'admin/setting/passwordpost', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('135', '4', 'admin/dbbackup/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('136', '4', 'admin/setting/clearcache', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('137', '4', 'admin/recyclebin/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('138', '4', 'admin/recyclebin/restore', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('139', '4', 'admin/recyclebin/delete', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('140', '4', 'user/adminasset/index', 'admin_url');
INSERT INTO `cmf_auth_access` VALUES ('141', '4', 'user/adminasset/delete', 'admin_url');

-- ----------------------------
-- Table structure for cmf_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `cmf_auth_rule`;
CREATE TABLE `cmf_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `app` varchar(15) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(100) NOT NULL DEFAULT '' COMMENT '额外url参数',
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `condition` varchar(200) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `module` (`app`,`status`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4 COMMENT='权限规则表';

-- ----------------------------
-- Records of cmf_auth_rule
-- ----------------------------
INSERT INTO `cmf_auth_rule` VALUES ('1', '1', 'admin', 'admin_url', 'admin/Hook/index', '', '钩子管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('2', '1', 'admin', 'admin_url', 'admin/Hook/plugins', '', '钩子插件管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('3', '1', 'admin', 'admin_url', 'admin/Hook/pluginListOrder', '', '钩子插件排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('4', '1', 'admin', 'admin_url', 'admin/Hook/sync', '', '同步钩子', '');
INSERT INTO `cmf_auth_rule` VALUES ('5', '1', 'admin', 'admin_url', 'admin/Link/index', '', '友情链接', '');
INSERT INTO `cmf_auth_rule` VALUES ('6', '1', 'admin', 'admin_url', 'admin/Link/add', '', '添加友情链接', '');
INSERT INTO `cmf_auth_rule` VALUES ('7', '1', 'admin', 'admin_url', 'admin/Link/addPost', '', '添加友情链接提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('8', '1', 'admin', 'admin_url', 'admin/Link/edit', '', '编辑友情链接', '');
INSERT INTO `cmf_auth_rule` VALUES ('9', '1', 'admin', 'admin_url', 'admin/Link/editPost', '', '编辑友情链接提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('10', '1', 'admin', 'admin_url', 'admin/Link/delete', '', '删除友情链接', '');
INSERT INTO `cmf_auth_rule` VALUES ('11', '1', 'admin', 'admin_url', 'admin/Link/listOrder', '', '友情链接排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('12', '1', 'admin', 'admin_url', 'admin/Link/toggle', '', '友情链接显示隐藏', '');
INSERT INTO `cmf_auth_rule` VALUES ('13', '1', 'admin', 'admin_url', 'admin/Mailer/index', '', '邮箱配置', '');
INSERT INTO `cmf_auth_rule` VALUES ('14', '1', 'admin', 'admin_url', 'admin/Mailer/indexPost', '', '邮箱配置提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('15', '1', 'admin', 'admin_url', 'admin/Mailer/template', '', '邮件模板', '');
INSERT INTO `cmf_auth_rule` VALUES ('16', '1', 'admin', 'admin_url', 'admin/Mailer/templatePost', '', '邮件模板提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('17', '1', 'admin', 'admin_url', 'admin/Mailer/test', '', '邮件发送测试', '');
INSERT INTO `cmf_auth_rule` VALUES ('18', '1', 'admin', 'admin_url', 'admin/Menu/index', '', '后台菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('19', '1', 'admin', 'admin_url', 'admin/Menu/lists', '', '所有菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('20', '1', 'admin', 'admin_url', 'admin/Menu/add', '', '后台菜单添加', '');
INSERT INTO `cmf_auth_rule` VALUES ('21', '1', 'admin', 'admin_url', 'admin/Menu/addPost', '', '后台菜单添加提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('22', '1', 'admin', 'admin_url', 'admin/Menu/edit', '', '后台菜单编辑', '');
INSERT INTO `cmf_auth_rule` VALUES ('23', '1', 'admin', 'admin_url', 'admin/Menu/editPost', '', '后台菜单编辑提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('24', '1', 'admin', 'admin_url', 'admin/Menu/delete', '', '后台菜单删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('25', '1', 'admin', 'admin_url', 'admin/Menu/listOrder', '', '后台菜单排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('26', '1', 'admin', 'admin_url', 'admin/Menu/getActions', '', '导入新后台菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('27', '1', 'admin', 'admin_url', 'admin/Nav/index', '', '导航管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('28', '1', 'admin', 'admin_url', 'admin/Nav/add', '', '添加导航', '');
INSERT INTO `cmf_auth_rule` VALUES ('29', '1', 'admin', 'admin_url', 'admin/Nav/addPost', '', '添加导航提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('30', '1', 'admin', 'admin_url', 'admin/Nav/edit', '', '编辑导航', '');
INSERT INTO `cmf_auth_rule` VALUES ('31', '1', 'admin', 'admin_url', 'admin/Nav/editPost', '', '编辑导航提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('32', '1', 'admin', 'admin_url', 'admin/Nav/delete', '', '删除导航', '');
INSERT INTO `cmf_auth_rule` VALUES ('33', '1', 'admin', 'admin_url', 'admin/NavMenu/index', '', '导航菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('34', '1', 'admin', 'admin_url', 'admin/NavMenu/add', '', '添加导航菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('35', '1', 'admin', 'admin_url', 'admin/NavMenu/addPost', '', '添加导航菜单提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('36', '1', 'admin', 'admin_url', 'admin/NavMenu/edit', '', '编辑导航菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('37', '1', 'admin', 'admin_url', 'admin/NavMenu/editPost', '', '编辑导航菜单提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('38', '1', 'admin', 'admin_url', 'admin/NavMenu/delete', '', '删除导航菜单', '');
INSERT INTO `cmf_auth_rule` VALUES ('39', '1', 'admin', 'admin_url', 'admin/NavMenu/listOrder', '', '导航菜单排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('40', '1', 'admin', 'admin_url', 'admin/Plugin/default', '', '插件管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('41', '1', 'admin', 'admin_url', 'admin/Plugin/index', '', '插件列表', '');
INSERT INTO `cmf_auth_rule` VALUES ('42', '1', 'admin', 'admin_url', 'admin/Plugin/toggle', '', '插件启用禁用', '');
INSERT INTO `cmf_auth_rule` VALUES ('43', '1', 'admin', 'admin_url', 'admin/Plugin/setting', '', '插件设置', '');
INSERT INTO `cmf_auth_rule` VALUES ('44', '1', 'admin', 'admin_url', 'admin/Plugin/settingPost', '', '插件设置提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('45', '1', 'admin', 'admin_url', 'admin/Plugin/install', '', '插件安装', '');
INSERT INTO `cmf_auth_rule` VALUES ('46', '1', 'admin', 'admin_url', 'admin/Plugin/update', '', '插件更新', '');
INSERT INTO `cmf_auth_rule` VALUES ('47', '1', 'admin', 'admin_url', 'admin/Plugin/uninstall', '', '卸载插件', '');
INSERT INTO `cmf_auth_rule` VALUES ('48', '1', 'admin', 'admin_url', 'admin/Rbac/index', '', '角色管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('49', '1', 'admin', 'admin_url', 'admin/Rbac/roleAdd', '', '添加角色', '');
INSERT INTO `cmf_auth_rule` VALUES ('50', '1', 'admin', 'admin_url', 'admin/Rbac/roleAddPost', '', '添加角色提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('51', '1', 'admin', 'admin_url', 'admin/Rbac/roleEdit', '', '编辑角色', '');
INSERT INTO `cmf_auth_rule` VALUES ('52', '1', 'admin', 'admin_url', 'admin/Rbac/roleEditPost', '', '编辑角色提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('53', '1', 'admin', 'admin_url', 'admin/Rbac/roleDelete', '', '删除角色', '');
INSERT INTO `cmf_auth_rule` VALUES ('54', '1', 'admin', 'admin_url', 'admin/Rbac/authorize', '', '设置角色权限', '');
INSERT INTO `cmf_auth_rule` VALUES ('55', '1', 'admin', 'admin_url', 'admin/Rbac/authorizePost', '', '角色授权提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('56', '1', 'admin', 'admin_url', 'admin/RecycleBin/index', '', '回收站', '');
INSERT INTO `cmf_auth_rule` VALUES ('57', '1', 'admin', 'admin_url', 'admin/RecycleBin/restore', '', '回收站还原', '');
INSERT INTO `cmf_auth_rule` VALUES ('58', '1', 'admin', 'admin_url', 'admin/RecycleBin/delete', '', '回收站彻底删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('59', '1', 'admin', 'admin_url', 'admin/Route/index', '', 'URL美化', '');
INSERT INTO `cmf_auth_rule` VALUES ('60', '1', 'admin', 'admin_url', 'admin/Route/add', '', '添加路由规则', '');
INSERT INTO `cmf_auth_rule` VALUES ('61', '1', 'admin', 'admin_url', 'admin/Route/addPost', '', '添加路由规则提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('62', '1', 'admin', 'admin_url', 'admin/Route/edit', '', '路由规则编辑', '');
INSERT INTO `cmf_auth_rule` VALUES ('63', '1', 'admin', 'admin_url', 'admin/Route/editPost', '', '路由规则编辑提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('64', '1', 'admin', 'admin_url', 'admin/Route/delete', '', '路由规则删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('65', '1', 'admin', 'admin_url', 'admin/Route/ban', '', '路由规则禁用', '');
INSERT INTO `cmf_auth_rule` VALUES ('66', '1', 'admin', 'admin_url', 'admin/Route/open', '', '路由规则启用', '');
INSERT INTO `cmf_auth_rule` VALUES ('67', '1', 'admin', 'admin_url', 'admin/Route/listOrder', '', '路由规则排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('68', '1', 'admin', 'admin_url', 'admin/Route/select', '', '选择URL', '');
INSERT INTO `cmf_auth_rule` VALUES ('69', '1', 'admin', 'admin_url', 'admin/Setting/default', '', '设置', '');
INSERT INTO `cmf_auth_rule` VALUES ('70', '1', 'admin', 'admin_url', 'admin/Setting/site', '', '网站信息', '');
INSERT INTO `cmf_auth_rule` VALUES ('71', '1', 'admin', 'admin_url', 'admin/Setting/sitePost', '', '网站信息设置提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('72', '1', 'admin', 'admin_url', 'admin/Setting/password', '', '密码修改', '');
INSERT INTO `cmf_auth_rule` VALUES ('73', '1', 'admin', 'admin_url', 'admin/Setting/passwordPost', '', '密码修改提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('74', '1', 'admin', 'admin_url', 'admin/Setting/upload', '', '上传设置', '');
INSERT INTO `cmf_auth_rule` VALUES ('75', '1', 'admin', 'admin_url', 'admin/Setting/uploadPost', '', '上传设置提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('76', '1', 'admin', 'admin_url', 'admin/Setting/clearCache', '', '清除缓存', '');
INSERT INTO `cmf_auth_rule` VALUES ('77', '1', 'admin', 'admin_url', 'admin/Slide/index', '', '幻灯片管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('78', '1', 'admin', 'admin_url', 'admin/Slide/add', '', '添加幻灯片', '');
INSERT INTO `cmf_auth_rule` VALUES ('79', '1', 'admin', 'admin_url', 'admin/Slide/addPost', '', '添加幻灯片提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('80', '1', 'admin', 'admin_url', 'admin/Slide/edit', '', '编辑幻灯片', '');
INSERT INTO `cmf_auth_rule` VALUES ('81', '1', 'admin', 'admin_url', 'admin/Slide/editPost', '', '编辑幻灯片提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('82', '1', 'admin', 'admin_url', 'admin/Slide/delete', '', '删除幻灯片', '');
INSERT INTO `cmf_auth_rule` VALUES ('83', '1', 'admin', 'admin_url', 'admin/SlideItem/index', '', '幻灯片页面列表', '');
INSERT INTO `cmf_auth_rule` VALUES ('84', '1', 'admin', 'admin_url', 'admin/SlideItem/add', '', '幻灯片页面添加', '');
INSERT INTO `cmf_auth_rule` VALUES ('85', '1', 'admin', 'admin_url', 'admin/SlideItem/addPost', '', '幻灯片页面添加提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('86', '1', 'admin', 'admin_url', 'admin/SlideItem/edit', '', '幻灯片页面编辑', '');
INSERT INTO `cmf_auth_rule` VALUES ('87', '1', 'admin', 'admin_url', 'admin/SlideItem/editPost', '', '幻灯片页面编辑提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('88', '1', 'admin', 'admin_url', 'admin/SlideItem/delete', '', '幻灯片页面删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('89', '1', 'admin', 'admin_url', 'admin/SlideItem/ban', '', '幻灯片页面隐藏', '');
INSERT INTO `cmf_auth_rule` VALUES ('90', '1', 'admin', 'admin_url', 'admin/SlideItem/cancelBan', '', '幻灯片页面显示', '');
INSERT INTO `cmf_auth_rule` VALUES ('91', '1', 'admin', 'admin_url', 'admin/SlideItem/listOrder', '', '幻灯片页面排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('92', '1', 'admin', 'admin_url', 'admin/Storage/index', '', '文件存储', '');
INSERT INTO `cmf_auth_rule` VALUES ('93', '1', 'admin', 'admin_url', 'admin/Storage/settingPost', '', '文件存储设置提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('94', '1', 'admin', 'admin_url', 'admin/Theme/index', '', '模板管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('95', '1', 'admin', 'admin_url', 'admin/Theme/install', '', '安装模板', '');
INSERT INTO `cmf_auth_rule` VALUES ('96', '1', 'admin', 'admin_url', 'admin/Theme/uninstall', '', '卸载模板', '');
INSERT INTO `cmf_auth_rule` VALUES ('97', '1', 'admin', 'admin_url', 'admin/Theme/installTheme', '', '模板安装', '');
INSERT INTO `cmf_auth_rule` VALUES ('98', '1', 'admin', 'admin_url', 'admin/Theme/update', '', '模板更新', '');
INSERT INTO `cmf_auth_rule` VALUES ('99', '1', 'admin', 'admin_url', 'admin/Theme/active', '', '启用模板', '');
INSERT INTO `cmf_auth_rule` VALUES ('100', '1', 'admin', 'admin_url', 'admin/Theme/files', '', '模板文件列表', '');
INSERT INTO `cmf_auth_rule` VALUES ('101', '1', 'admin', 'admin_url', 'admin/Theme/fileSetting', '', '模板文件设置', '');
INSERT INTO `cmf_auth_rule` VALUES ('102', '1', 'admin', 'admin_url', 'admin/Theme/fileArrayData', '', '模板文件数组数据列表', '');
INSERT INTO `cmf_auth_rule` VALUES ('103', '1', 'admin', 'admin_url', 'admin/Theme/fileArrayDataEdit', '', '模板文件数组数据添加编辑', '');
INSERT INTO `cmf_auth_rule` VALUES ('104', '1', 'admin', 'admin_url', 'admin/Theme/fileArrayDataEditPost', '', '模板文件数组数据添加编辑提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('105', '1', 'admin', 'admin_url', 'admin/Theme/fileArrayDataDelete', '', '模板文件数组数据删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('106', '1', 'admin', 'admin_url', 'admin/Theme/settingPost', '', '模板文件编辑提交保存', '');
INSERT INTO `cmf_auth_rule` VALUES ('107', '1', 'admin', 'admin_url', 'admin/Theme/dataSource', '', '模板文件设置数据源', '');
INSERT INTO `cmf_auth_rule` VALUES ('108', '1', 'admin', 'admin_url', 'admin/User/default', '', '管理组', '');
INSERT INTO `cmf_auth_rule` VALUES ('109', '1', 'admin', 'admin_url', 'admin/User/index', '', '管理员', '');
INSERT INTO `cmf_auth_rule` VALUES ('110', '1', 'admin', 'admin_url', 'admin/User/add', '', '管理员添加', '');
INSERT INTO `cmf_auth_rule` VALUES ('111', '1', 'admin', 'admin_url', 'admin/User/addPost', '', '管理员添加提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('112', '1', 'admin', 'admin_url', 'admin/User/edit', '', '管理员编辑', '');
INSERT INTO `cmf_auth_rule` VALUES ('113', '1', 'admin', 'admin_url', 'admin/User/editPost', '', '管理员编辑提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('114', '1', 'admin', 'admin_url', 'admin/User/userInfo', '', '个人信息', '');
INSERT INTO `cmf_auth_rule` VALUES ('115', '1', 'admin', 'admin_url', 'admin/User/userInfoPost', '', '管理员个人信息修改提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('116', '1', 'admin', 'admin_url', 'admin/User/delete', '', '管理员删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('117', '1', 'admin', 'admin_url', 'admin/User/ban', '', '停用管理员', '');
INSERT INTO `cmf_auth_rule` VALUES ('118', '1', 'admin', 'admin_url', 'admin/User/cancelBan', '', '启用管理员', '');
INSERT INTO `cmf_auth_rule` VALUES ('119', '1', 'portal', 'admin_url', 'portal/AdminArticle/index', '', '文章管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('120', '1', 'portal', 'admin_url', 'portal/AdminArticle/add', '', '添加文章', '');
INSERT INTO `cmf_auth_rule` VALUES ('121', '1', 'portal', 'admin_url', 'portal/AdminArticle/addPost', '', '添加文章提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('122', '1', 'portal', 'admin_url', 'portal/AdminArticle/edit', '', '编辑文章', '');
INSERT INTO `cmf_auth_rule` VALUES ('123', '1', 'portal', 'admin_url', 'portal/AdminArticle/editPost', '', '编辑文章提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('124', '1', 'portal', 'admin_url', 'portal/AdminArticle/delete', '', '文章删除', '');
INSERT INTO `cmf_auth_rule` VALUES ('125', '1', 'portal', 'admin_url', 'portal/AdminArticle/publish', '', '文章发布', '');
INSERT INTO `cmf_auth_rule` VALUES ('126', '1', 'portal', 'admin_url', 'portal/AdminArticle/top', '', '文章置顶', '');
INSERT INTO `cmf_auth_rule` VALUES ('127', '1', 'portal', 'admin_url', 'portal/AdminArticle/recommend', '', '文章推荐', '');
INSERT INTO `cmf_auth_rule` VALUES ('128', '1', 'portal', 'admin_url', 'portal/AdminArticle/listOrder', '', '文章排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('129', '1', 'portal', 'admin_url', 'portal/AdminCategory/index', '', '分类管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('130', '1', 'portal', 'admin_url', 'portal/AdminCategory/add', '', '添加文章分类', '');
INSERT INTO `cmf_auth_rule` VALUES ('131', '1', 'portal', 'admin_url', 'portal/AdminCategory/addPost', '', '添加文章分类提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('132', '1', 'portal', 'admin_url', 'portal/AdminCategory/edit', '', '编辑文章分类', '');
INSERT INTO `cmf_auth_rule` VALUES ('133', '1', 'portal', 'admin_url', 'portal/AdminCategory/editPost', '', '编辑文章分类提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('134', '1', 'portal', 'admin_url', 'portal/AdminCategory/select', '', '文章分类选择对话框', '');
INSERT INTO `cmf_auth_rule` VALUES ('135', '1', 'portal', 'admin_url', 'portal/AdminCategory/listOrder', '', '文章分类排序', '');
INSERT INTO `cmf_auth_rule` VALUES ('136', '1', 'portal', 'admin_url', 'portal/AdminCategory/delete', '', '删除文章分类', '');
INSERT INTO `cmf_auth_rule` VALUES ('137', '1', 'portal', 'admin_url', 'portal/AdminIndex/default', '', '门户管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('138', '1', 'portal', 'admin_url', 'portal/AdminPage/index', '', '页面管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('139', '1', 'portal', 'admin_url', 'portal/AdminPage/add', '', '添加页面', '');
INSERT INTO `cmf_auth_rule` VALUES ('140', '1', 'portal', 'admin_url', 'portal/AdminPage/addPost', '', '添加页面提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('141', '1', 'portal', 'admin_url', 'portal/AdminPage/edit', '', '编辑页面', '');
INSERT INTO `cmf_auth_rule` VALUES ('142', '1', 'portal', 'admin_url', 'portal/AdminPage/editPost', '', '编辑页面提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('143', '1', 'portal', 'admin_url', 'portal/AdminPage/delete', '', '删除页面', '');
INSERT INTO `cmf_auth_rule` VALUES ('144', '1', 'portal', 'admin_url', 'portal/AdminTag/index', '', '文章标签', '');
INSERT INTO `cmf_auth_rule` VALUES ('145', '1', 'portal', 'admin_url', 'portal/AdminTag/add', '', '添加文章标签', '');
INSERT INTO `cmf_auth_rule` VALUES ('146', '1', 'portal', 'admin_url', 'portal/AdminTag/addPost', '', '添加文章标签提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('147', '1', 'portal', 'admin_url', 'portal/AdminTag/upStatus', '', '更新标签状态', '');
INSERT INTO `cmf_auth_rule` VALUES ('148', '1', 'portal', 'admin_url', 'portal/AdminTag/delete', '', '删除文章标签', '');
INSERT INTO `cmf_auth_rule` VALUES ('149', '1', 'user', 'admin_url', 'user/AdminAsset/index', '', '资源管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('150', '1', 'user', 'admin_url', 'user/AdminAsset/delete', '', '删除文件', '');
INSERT INTO `cmf_auth_rule` VALUES ('151', '1', 'user', 'admin_url', 'user/AdminIndex/default', '', '用户管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('152', '1', 'user', 'admin_url', 'user/AdminIndex/default1', '', '用户组', '');
INSERT INTO `cmf_auth_rule` VALUES ('153', '1', 'user', 'admin_url', 'user/AdminIndex/index', '', '本站用户', '');
INSERT INTO `cmf_auth_rule` VALUES ('154', '1', 'user', 'admin_url', 'user/AdminIndex/ban', '', '本站用户拉黑', '');
INSERT INTO `cmf_auth_rule` VALUES ('155', '1', 'user', 'admin_url', 'user/AdminIndex/cancelBan', '', '本站用户启用', '');
INSERT INTO `cmf_auth_rule` VALUES ('156', '1', 'user', 'admin_url', 'user/AdminOauth/index', '', '第三方用户', '');
INSERT INTO `cmf_auth_rule` VALUES ('157', '1', 'user', 'admin_url', 'user/AdminOauth/delete', '', '删除第三方用户绑定', '');
INSERT INTO `cmf_auth_rule` VALUES ('158', '1', 'user', 'admin_url', 'user/AdminUserAction/index', '', '用户操作管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('159', '1', 'user', 'admin_url', 'user/AdminUserAction/edit', '', '编辑用户操作', '');
INSERT INTO `cmf_auth_rule` VALUES ('160', '1', 'user', 'admin_url', 'user/AdminUserAction/editPost', '', '编辑用户操作提交', '');
INSERT INTO `cmf_auth_rule` VALUES ('161', '1', 'user', 'admin_url', 'user/AdminUserAction/sync', '', '同步用户操作', '');
INSERT INTO `cmf_auth_rule` VALUES ('162', '1', 'insurance', 'admin_url', 'insurance/AdminIndex/default', '', '车险服务', '');
INSERT INTO `cmf_auth_rule` VALUES ('163', '1', 'trade', 'admin_url', 'trade/AdminIndex/default', '', '车辆买卖', '');
INSERT INTO `cmf_auth_rule` VALUES ('164', '1', 'service', 'admin_url', 'service/AdminIndex/default', '', '车辆业务', '');
INSERT INTO `cmf_auth_rule` VALUES ('165', '1', 'usual', 'admin_url', 'usual/AdminIndex/default', '', '车辆统配', '');
INSERT INTO `cmf_auth_rule` VALUES ('166', '1', 'usual', 'admin_url', 'usual/AdminItemCate/index', '', '车辆属性', '');
INSERT INTO `cmf_auth_rule` VALUES ('167', '1', 'usual', 'admin_url', 'usual/AdminBrand/index', '', '品牌管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('168', '1', 'usual', 'admin_url', 'usual/AdminVerify/index', '', '认证管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('169', '1', 'usual', 'admin_url', 'usual/AdminCompany/index', 'id=1', '公司企业管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('170', '1', 'insurance', 'admin_url', 'insurance/AdminInsurance/index', '', '保险业务', '');
INSERT INTO `cmf_auth_rule` VALUES ('171', '1', 'insurance', 'admin_url', 'insurance/AdminOrder/index', '', '保单管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('172', '1', 'trade', 'admin_url', 'trade/AdminOrder/index', '', '订单管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('173', '1', 'service', 'admin_url', 'service/AdminService/index', '', '业务管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('174', '1', 'service', 'admin_url', 'service/AdminCategory/index', '', '业务模型', '');
INSERT INTO `cmf_auth_rule` VALUES ('175', '1', 'trade', 'admin_url', 'trade/AdminShop/index', '', '店铺管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('176', '1', 'usual', 'admin_url', 'usual/AdminIndex/config', '', '二手车配置', '');
INSERT INTO `cmf_auth_rule` VALUES ('177', '1', 'usual', 'admin_url', 'usual/AdminSeries/index', '', '车系管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('178', '1', 'usual', 'admin_url', 'usual/AdminModels/index', '', '车型管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('179', '1', 'usual', 'admin_url', 'usual/AdminBrand/add', '', '品牌添加', '');
INSERT INTO `cmf_auth_rule` VALUES ('180', '1', 'usual', 'admin_url', 'usual/AdminBrand/edit', 'id=1', '品牌', '');
INSERT INTO `cmf_auth_rule` VALUES ('181', '1', 'admin', 'admin_url', 'admin/District/index', '', '地区管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('182', '1', 'insurance', 'admin_url', 'insurance/AdminCoverage/index', '', '险种管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('183', '1', 'usual', 'admin_url', 'usual/AdminCar/index', '', '车辆管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('184', '1', 'admin', 'admin_url', 'admin/DbBackup/index', '', '数据库管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('185', '1', 'usual', 'admin_url', 'usual/AdminNews/index', '', '消息管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('186', '1', 'funds', 'admin_url', 'funds/AdminFunds/default', '', '资金管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('187', '1', 'funds', 'admin_url', 'funds/AdminFunds/index', '', '资金列表', '');
INSERT INTO `cmf_auth_rule` VALUES ('188', '1', 'funds', 'admin_url', 'funds/AdminRecharge/index', '', '充值管理', '');
INSERT INTO `cmf_auth_rule` VALUES ('189', '1', 'funds', 'admin_url', 'funds/AdminWithdraw/index', '', '提现管理', '');

-- ----------------------------
-- Table structure for cmf_comment
-- ----------------------------
DROP TABLE IF EXISTS `cmf_comment`;
CREATE TABLE `cmf_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消息处理人ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论内容 id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:已审核,0:未审核',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '评论类型；1实名评论',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '评论内容所在表，不带表前缀',
  `full_name` varchar(50) NOT NULL DEFAULT '' COMMENT '评论者昵称',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '评论者邮箱',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  `url` text COMMENT '原文地址',
  `content` text COMMENT '评论内容',
  `more` text COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`object_id`),
  KEY `comment_approved_date_gmt` (`status`),
  KEY `comment_parent` (`parent_id`),
  KEY `table_id_status` (`table_name`,`object_id`,`status`),
  KEY `createtime` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of cmf_comment
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_district
-- ----------------------------
DROP TABLE IF EXISTS `cmf_district`;
CREATE TABLE `cmf_district` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区修改者ID',
  `name` varchar(120) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8 COMMENT='地区表';

-- ----------------------------
-- Records of cmf_district
-- ----------------------------
INSERT INTO `cmf_district` VALUES ('1', '0', '0', '中国', '0');
INSERT INTO `cmf_district` VALUES ('2', '1', '0', '北京', '1');
INSERT INTO `cmf_district` VALUES ('3', '1', '0', '安徽', '1');
INSERT INTO `cmf_district` VALUES ('4', '1', '0', '福建', '1');
INSERT INTO `cmf_district` VALUES ('5', '1', '0', '甘肃', '1');
INSERT INTO `cmf_district` VALUES ('6', '1', '0', '广东', '1');
INSERT INTO `cmf_district` VALUES ('7', '1', '0', '广西', '1');
INSERT INTO `cmf_district` VALUES ('8', '1', '0', '贵州', '1');
INSERT INTO `cmf_district` VALUES ('9', '1', '0', '海南', '1');
INSERT INTO `cmf_district` VALUES ('10', '1', '0', '河北', '1');
INSERT INTO `cmf_district` VALUES ('11', '1', '0', '河南', '1');
INSERT INTO `cmf_district` VALUES ('12', '1', '0', '黑龙江', '1');
INSERT INTO `cmf_district` VALUES ('13', '1', '0', '湖北', '1');
INSERT INTO `cmf_district` VALUES ('14', '1', '0', '湖南', '1');
INSERT INTO `cmf_district` VALUES ('15', '1', '0', '吉林', '1');
INSERT INTO `cmf_district` VALUES ('16', '1', '0', '江苏', '1');
INSERT INTO `cmf_district` VALUES ('17', '1', '0', '江西', '1');
INSERT INTO `cmf_district` VALUES ('18', '1', '0', '辽宁', '1');
INSERT INTO `cmf_district` VALUES ('19', '1', '0', '内蒙古', '1');
INSERT INTO `cmf_district` VALUES ('20', '1', '0', '宁夏', '1');
INSERT INTO `cmf_district` VALUES ('21', '1', '0', '青海', '1');
INSERT INTO `cmf_district` VALUES ('22', '1', '0', '山东', '1');
INSERT INTO `cmf_district` VALUES ('23', '1', '0', '山西', '1');
INSERT INTO `cmf_district` VALUES ('24', '1', '0', '陕西', '1');
INSERT INTO `cmf_district` VALUES ('25', '1', '0', '上海', '1');
INSERT INTO `cmf_district` VALUES ('26', '1', '0', '四川', '1');
INSERT INTO `cmf_district` VALUES ('27', '1', '0', '天津', '1');
INSERT INTO `cmf_district` VALUES ('28', '1', '0', '西藏', '1');
INSERT INTO `cmf_district` VALUES ('29', '1', '0', '新疆', '1');
INSERT INTO `cmf_district` VALUES ('30', '1', '0', '云南', '1');
INSERT INTO `cmf_district` VALUES ('31', '1', '0', '浙江', '1');
INSERT INTO `cmf_district` VALUES ('32', '1', '0', '重庆', '1');
INSERT INTO `cmf_district` VALUES ('33', '1', '0', '香港', '1');
INSERT INTO `cmf_district` VALUES ('34', '1', '0', '澳门', '1');
INSERT INTO `cmf_district` VALUES ('35', '1', '0', '台湾', '1');
INSERT INTO `cmf_district` VALUES ('36', '3', '0', '安庆', '2');
INSERT INTO `cmf_district` VALUES ('37', '3', '0', '蚌埠', '2');
INSERT INTO `cmf_district` VALUES ('38', '3', '0', '巢湖', '2');
INSERT INTO `cmf_district` VALUES ('39', '3', '0', '池州', '2');
INSERT INTO `cmf_district` VALUES ('40', '3', '0', '滁州', '2');
INSERT INTO `cmf_district` VALUES ('41', '3', '0', '阜阳', '2');
INSERT INTO `cmf_district` VALUES ('42', '3', '0', '淮北', '2');
INSERT INTO `cmf_district` VALUES ('43', '3', '0', '淮南', '2');
INSERT INTO `cmf_district` VALUES ('44', '3', '0', '黄山', '2');
INSERT INTO `cmf_district` VALUES ('45', '3', '0', '六安', '2');
INSERT INTO `cmf_district` VALUES ('46', '3', '0', '马鞍山', '2');
INSERT INTO `cmf_district` VALUES ('47', '3', '0', '宿州', '2');
INSERT INTO `cmf_district` VALUES ('48', '3', '0', '铜陵', '2');
INSERT INTO `cmf_district` VALUES ('49', '3', '0', '芜湖', '2');
INSERT INTO `cmf_district` VALUES ('50', '3', '0', '宣城', '2');
INSERT INTO `cmf_district` VALUES ('51', '3', '0', '亳州', '2');
INSERT INTO `cmf_district` VALUES ('52', '2', '0', '北京', '2');
INSERT INTO `cmf_district` VALUES ('53', '4', '0', '福州', '2');
INSERT INTO `cmf_district` VALUES ('54', '4', '0', '龙岩', '2');
INSERT INTO `cmf_district` VALUES ('55', '4', '0', '南平', '2');
INSERT INTO `cmf_district` VALUES ('56', '4', '0', '宁德', '2');
INSERT INTO `cmf_district` VALUES ('57', '4', '0', '莆田', '2');
INSERT INTO `cmf_district` VALUES ('58', '4', '0', '泉州', '2');
INSERT INTO `cmf_district` VALUES ('59', '4', '0', '三明', '2');
INSERT INTO `cmf_district` VALUES ('60', '4', '0', '厦门', '2');
INSERT INTO `cmf_district` VALUES ('61', '4', '0', '漳州', '2');
INSERT INTO `cmf_district` VALUES ('62', '5', '0', '兰州', '2');
INSERT INTO `cmf_district` VALUES ('63', '5', '0', '白银', '2');
INSERT INTO `cmf_district` VALUES ('64', '5', '0', '定西', '2');
INSERT INTO `cmf_district` VALUES ('65', '5', '0', '甘南', '2');
INSERT INTO `cmf_district` VALUES ('66', '5', '0', '嘉峪关', '2');
INSERT INTO `cmf_district` VALUES ('67', '5', '0', '金昌', '2');
INSERT INTO `cmf_district` VALUES ('68', '5', '0', '酒泉', '2');
INSERT INTO `cmf_district` VALUES ('69', '5', '0', '临夏', '2');
INSERT INTO `cmf_district` VALUES ('70', '5', '0', '陇南', '2');
INSERT INTO `cmf_district` VALUES ('71', '5', '0', '平凉', '2');
INSERT INTO `cmf_district` VALUES ('72', '5', '0', '庆阳', '2');
INSERT INTO `cmf_district` VALUES ('73', '5', '0', '天水', '2');
INSERT INTO `cmf_district` VALUES ('74', '5', '0', '武威', '2');
INSERT INTO `cmf_district` VALUES ('75', '5', '0', '张掖', '2');
INSERT INTO `cmf_district` VALUES ('76', '6', '0', '广州', '2');
INSERT INTO `cmf_district` VALUES ('77', '6', '0', '深圳', '2');
INSERT INTO `cmf_district` VALUES ('78', '6', '0', '潮州', '2');
INSERT INTO `cmf_district` VALUES ('79', '6', '0', '东莞', '2');
INSERT INTO `cmf_district` VALUES ('80', '6', '0', '佛山', '2');
INSERT INTO `cmf_district` VALUES ('81', '6', '0', '河源', '2');
INSERT INTO `cmf_district` VALUES ('82', '6', '0', '惠州', '2');
INSERT INTO `cmf_district` VALUES ('83', '6', '0', '江门', '2');
INSERT INTO `cmf_district` VALUES ('84', '6', '0', '揭阳', '2');
INSERT INTO `cmf_district` VALUES ('85', '6', '0', '茂名', '2');
INSERT INTO `cmf_district` VALUES ('86', '6', '0', '梅州', '2');
INSERT INTO `cmf_district` VALUES ('87', '6', '0', '清远', '2');
INSERT INTO `cmf_district` VALUES ('88', '6', '0', '汕头', '2');
INSERT INTO `cmf_district` VALUES ('89', '6', '0', '汕尾', '2');
INSERT INTO `cmf_district` VALUES ('90', '6', '0', '韶关', '2');
INSERT INTO `cmf_district` VALUES ('91', '6', '0', '阳江', '2');
INSERT INTO `cmf_district` VALUES ('92', '6', '0', '云浮', '2');
INSERT INTO `cmf_district` VALUES ('93', '6', '0', '湛江', '2');
INSERT INTO `cmf_district` VALUES ('94', '6', '0', '肇庆', '2');
INSERT INTO `cmf_district` VALUES ('95', '6', '0', '中山', '2');
INSERT INTO `cmf_district` VALUES ('96', '6', '0', '珠海', '2');
INSERT INTO `cmf_district` VALUES ('97', '7', '0', '南宁', '2');
INSERT INTO `cmf_district` VALUES ('98', '7', '0', '桂林', '2');
INSERT INTO `cmf_district` VALUES ('99', '7', '0', '百色', '2');
INSERT INTO `cmf_district` VALUES ('100', '7', '0', '北海', '2');
INSERT INTO `cmf_district` VALUES ('101', '7', '0', '崇左', '2');
INSERT INTO `cmf_district` VALUES ('102', '7', '0', '防城港', '2');
INSERT INTO `cmf_district` VALUES ('103', '7', '0', '贵港', '2');
INSERT INTO `cmf_district` VALUES ('104', '7', '0', '河池', '2');
INSERT INTO `cmf_district` VALUES ('105', '7', '0', '贺州', '2');
INSERT INTO `cmf_district` VALUES ('106', '7', '0', '来宾', '2');
INSERT INTO `cmf_district` VALUES ('107', '7', '0', '柳州', '2');
INSERT INTO `cmf_district` VALUES ('108', '7', '0', '钦州', '2');
INSERT INTO `cmf_district` VALUES ('109', '7', '0', '梧州', '2');
INSERT INTO `cmf_district` VALUES ('110', '7', '0', '玉林', '2');
INSERT INTO `cmf_district` VALUES ('111', '8', '0', '贵阳', '2');
INSERT INTO `cmf_district` VALUES ('112', '8', '0', '安顺', '2');
INSERT INTO `cmf_district` VALUES ('113', '8', '0', '毕节', '2');
INSERT INTO `cmf_district` VALUES ('114', '8', '0', '六盘水', '2');
INSERT INTO `cmf_district` VALUES ('115', '8', '0', '黔东南', '2');
INSERT INTO `cmf_district` VALUES ('116', '8', '0', '黔南', '2');
INSERT INTO `cmf_district` VALUES ('117', '8', '0', '黔西南', '2');
INSERT INTO `cmf_district` VALUES ('118', '8', '0', '铜仁', '2');
INSERT INTO `cmf_district` VALUES ('119', '8', '0', '遵义', '2');
INSERT INTO `cmf_district` VALUES ('120', '9', '0', '海口', '2');
INSERT INTO `cmf_district` VALUES ('121', '9', '0', '三亚', '2');
INSERT INTO `cmf_district` VALUES ('122', '9', '0', '白沙', '2');
INSERT INTO `cmf_district` VALUES ('123', '9', '0', '保亭', '2');
INSERT INTO `cmf_district` VALUES ('124', '9', '0', '昌江', '2');
INSERT INTO `cmf_district` VALUES ('125', '9', '0', '澄迈县', '2');
INSERT INTO `cmf_district` VALUES ('126', '9', '0', '定安县', '2');
INSERT INTO `cmf_district` VALUES ('127', '9', '0', '东方', '2');
INSERT INTO `cmf_district` VALUES ('128', '9', '0', '乐东', '2');
INSERT INTO `cmf_district` VALUES ('129', '9', '0', '临高县', '2');
INSERT INTO `cmf_district` VALUES ('130', '9', '0', '陵水', '2');
INSERT INTO `cmf_district` VALUES ('131', '9', '0', '琼海', '2');
INSERT INTO `cmf_district` VALUES ('132', '9', '0', '琼中', '2');
INSERT INTO `cmf_district` VALUES ('133', '9', '0', '屯昌县', '2');
INSERT INTO `cmf_district` VALUES ('134', '9', '0', '万宁', '2');
INSERT INTO `cmf_district` VALUES ('135', '9', '0', '文昌', '2');
INSERT INTO `cmf_district` VALUES ('136', '9', '0', '五指山', '2');
INSERT INTO `cmf_district` VALUES ('137', '9', '0', '儋州', '2');
INSERT INTO `cmf_district` VALUES ('138', '10', '0', '石家庄', '2');
INSERT INTO `cmf_district` VALUES ('139', '10', '0', '保定', '2');
INSERT INTO `cmf_district` VALUES ('140', '10', '0', '沧州', '2');
INSERT INTO `cmf_district` VALUES ('141', '10', '0', '承德', '2');
INSERT INTO `cmf_district` VALUES ('142', '10', '0', '邯郸', '2');
INSERT INTO `cmf_district` VALUES ('143', '10', '0', '衡水', '2');
INSERT INTO `cmf_district` VALUES ('144', '10', '0', '廊坊', '2');
INSERT INTO `cmf_district` VALUES ('145', '10', '0', '秦皇岛', '2');
INSERT INTO `cmf_district` VALUES ('146', '10', '0', '唐山', '2');
INSERT INTO `cmf_district` VALUES ('147', '10', '0', '邢台', '2');
INSERT INTO `cmf_district` VALUES ('148', '10', '0', '张家口', '2');
INSERT INTO `cmf_district` VALUES ('149', '11', '0', '郑州', '2');
INSERT INTO `cmf_district` VALUES ('150', '11', '0', '洛阳', '2');
INSERT INTO `cmf_district` VALUES ('151', '11', '0', '开封', '2');
INSERT INTO `cmf_district` VALUES ('152', '11', '0', '安阳', '2');
INSERT INTO `cmf_district` VALUES ('153', '11', '0', '鹤壁', '2');
INSERT INTO `cmf_district` VALUES ('154', '11', '0', '济源', '2');
INSERT INTO `cmf_district` VALUES ('155', '11', '0', '焦作', '2');
INSERT INTO `cmf_district` VALUES ('156', '11', '0', '南阳', '2');
INSERT INTO `cmf_district` VALUES ('157', '11', '0', '平顶山', '2');
INSERT INTO `cmf_district` VALUES ('158', '11', '0', '三门峡', '2');
INSERT INTO `cmf_district` VALUES ('159', '11', '0', '商丘', '2');
INSERT INTO `cmf_district` VALUES ('160', '11', '0', '新乡', '2');
INSERT INTO `cmf_district` VALUES ('161', '11', '0', '信阳', '2');
INSERT INTO `cmf_district` VALUES ('162', '11', '0', '许昌', '2');
INSERT INTO `cmf_district` VALUES ('163', '11', '0', '周口', '2');
INSERT INTO `cmf_district` VALUES ('164', '11', '0', '驻马店', '2');
INSERT INTO `cmf_district` VALUES ('165', '11', '0', '漯河', '2');
INSERT INTO `cmf_district` VALUES ('166', '11', '0', '濮阳', '2');
INSERT INTO `cmf_district` VALUES ('167', '12', '0', '哈尔滨', '2');
INSERT INTO `cmf_district` VALUES ('168', '12', '0', '大庆', '2');
INSERT INTO `cmf_district` VALUES ('169', '12', '0', '大兴安岭', '2');
INSERT INTO `cmf_district` VALUES ('170', '12', '0', '鹤岗', '2');
INSERT INTO `cmf_district` VALUES ('171', '12', '0', '黑河', '2');
INSERT INTO `cmf_district` VALUES ('172', '12', '0', '鸡西', '2');
INSERT INTO `cmf_district` VALUES ('173', '12', '0', '佳木斯', '2');
INSERT INTO `cmf_district` VALUES ('174', '12', '0', '牡丹江', '2');
INSERT INTO `cmf_district` VALUES ('175', '12', '0', '七台河', '2');
INSERT INTO `cmf_district` VALUES ('176', '12', '0', '齐齐哈尔', '2');
INSERT INTO `cmf_district` VALUES ('177', '12', '0', '双鸭山', '2');
INSERT INTO `cmf_district` VALUES ('178', '12', '0', '绥化', '2');
INSERT INTO `cmf_district` VALUES ('179', '12', '0', '伊春', '2');
INSERT INTO `cmf_district` VALUES ('180', '13', '0', '武汉', '2');
INSERT INTO `cmf_district` VALUES ('181', '13', '0', '仙桃', '2');
INSERT INTO `cmf_district` VALUES ('182', '13', '0', '鄂州', '2');
INSERT INTO `cmf_district` VALUES ('183', '13', '0', '黄冈', '2');
INSERT INTO `cmf_district` VALUES ('184', '13', '0', '黄石', '2');
INSERT INTO `cmf_district` VALUES ('185', '13', '0', '荆门', '2');
INSERT INTO `cmf_district` VALUES ('186', '13', '0', '荆州', '2');
INSERT INTO `cmf_district` VALUES ('187', '13', '0', '潜江', '2');
INSERT INTO `cmf_district` VALUES ('188', '13', '0', '神农架林区', '2');
INSERT INTO `cmf_district` VALUES ('189', '13', '0', '十堰', '2');
INSERT INTO `cmf_district` VALUES ('190', '13', '0', '随州', '2');
INSERT INTO `cmf_district` VALUES ('191', '13', '0', '天门', '2');
INSERT INTO `cmf_district` VALUES ('192', '13', '0', '咸宁', '2');
INSERT INTO `cmf_district` VALUES ('193', '13', '0', '襄樊', '2');
INSERT INTO `cmf_district` VALUES ('194', '13', '0', '孝感', '2');
INSERT INTO `cmf_district` VALUES ('195', '13', '0', '宜昌', '2');
INSERT INTO `cmf_district` VALUES ('196', '13', '0', '恩施', '2');
INSERT INTO `cmf_district` VALUES ('197', '14', '0', '长沙', '2');
INSERT INTO `cmf_district` VALUES ('198', '14', '0', '张家界', '2');
INSERT INTO `cmf_district` VALUES ('199', '14', '0', '常德', '2');
INSERT INTO `cmf_district` VALUES ('200', '14', '0', '郴州', '2');
INSERT INTO `cmf_district` VALUES ('201', '14', '0', '衡阳', '2');
INSERT INTO `cmf_district` VALUES ('202', '14', '0', '怀化', '2');
INSERT INTO `cmf_district` VALUES ('203', '14', '0', '娄底', '2');
INSERT INTO `cmf_district` VALUES ('204', '14', '0', '邵阳', '2');
INSERT INTO `cmf_district` VALUES ('205', '14', '0', '湘潭', '2');
INSERT INTO `cmf_district` VALUES ('206', '14', '0', '湘西', '2');
INSERT INTO `cmf_district` VALUES ('207', '14', '0', '益阳', '2');
INSERT INTO `cmf_district` VALUES ('208', '14', '0', '永州', '2');
INSERT INTO `cmf_district` VALUES ('209', '14', '0', '岳阳', '2');
INSERT INTO `cmf_district` VALUES ('210', '14', '0', '株洲', '2');
INSERT INTO `cmf_district` VALUES ('211', '15', '0', '长春', '2');
INSERT INTO `cmf_district` VALUES ('212', '15', '0', '吉林', '2');
INSERT INTO `cmf_district` VALUES ('213', '15', '0', '白城', '2');
INSERT INTO `cmf_district` VALUES ('214', '15', '0', '白山', '2');
INSERT INTO `cmf_district` VALUES ('215', '15', '0', '辽源', '2');
INSERT INTO `cmf_district` VALUES ('216', '15', '0', '四平', '2');
INSERT INTO `cmf_district` VALUES ('217', '15', '0', '松原', '2');
INSERT INTO `cmf_district` VALUES ('218', '15', '0', '通化', '2');
INSERT INTO `cmf_district` VALUES ('219', '15', '0', '延边', '2');
INSERT INTO `cmf_district` VALUES ('220', '16', '0', '南京', '2');
INSERT INTO `cmf_district` VALUES ('221', '16', '0', '苏州', '2');
INSERT INTO `cmf_district` VALUES ('222', '16', '0', '无锡', '2');
INSERT INTO `cmf_district` VALUES ('223', '16', '0', '常州', '2');
INSERT INTO `cmf_district` VALUES ('224', '16', '0', '淮安', '2');
INSERT INTO `cmf_district` VALUES ('225', '16', '0', '连云港', '2');
INSERT INTO `cmf_district` VALUES ('226', '16', '0', '南通', '2');
INSERT INTO `cmf_district` VALUES ('227', '16', '0', '宿迁', '2');
INSERT INTO `cmf_district` VALUES ('228', '16', '0', '泰州', '2');
INSERT INTO `cmf_district` VALUES ('229', '16', '0', '徐州', '2');
INSERT INTO `cmf_district` VALUES ('230', '16', '0', '盐城', '2');
INSERT INTO `cmf_district` VALUES ('231', '16', '0', '扬州', '2');
INSERT INTO `cmf_district` VALUES ('232', '16', '0', '镇江', '2');
INSERT INTO `cmf_district` VALUES ('233', '17', '0', '南昌', '2');
INSERT INTO `cmf_district` VALUES ('234', '17', '0', '抚州', '2');
INSERT INTO `cmf_district` VALUES ('235', '17', '0', '赣州', '2');
INSERT INTO `cmf_district` VALUES ('236', '17', '0', '吉安', '2');
INSERT INTO `cmf_district` VALUES ('237', '17', '0', '景德镇', '2');
INSERT INTO `cmf_district` VALUES ('238', '17', '0', '九江', '2');
INSERT INTO `cmf_district` VALUES ('239', '17', '0', '萍乡', '2');
INSERT INTO `cmf_district` VALUES ('240', '17', '0', '上饶', '2');
INSERT INTO `cmf_district` VALUES ('241', '17', '0', '新余', '2');
INSERT INTO `cmf_district` VALUES ('242', '17', '0', '宜春', '2');
INSERT INTO `cmf_district` VALUES ('243', '17', '0', '鹰潭', '2');
INSERT INTO `cmf_district` VALUES ('244', '18', '0', '沈阳', '2');
INSERT INTO `cmf_district` VALUES ('245', '18', '0', '大连', '2');
INSERT INTO `cmf_district` VALUES ('246', '18', '0', '鞍山', '2');
INSERT INTO `cmf_district` VALUES ('247', '18', '0', '本溪', '2');
INSERT INTO `cmf_district` VALUES ('248', '18', '0', '朝阳', '2');
INSERT INTO `cmf_district` VALUES ('249', '18', '0', '丹东', '2');
INSERT INTO `cmf_district` VALUES ('250', '18', '0', '抚顺', '2');
INSERT INTO `cmf_district` VALUES ('251', '18', '0', '阜新', '2');
INSERT INTO `cmf_district` VALUES ('252', '18', '0', '葫芦岛', '2');
INSERT INTO `cmf_district` VALUES ('253', '18', '0', '锦州', '2');
INSERT INTO `cmf_district` VALUES ('254', '18', '0', '辽阳', '2');
INSERT INTO `cmf_district` VALUES ('255', '18', '0', '盘锦', '2');
INSERT INTO `cmf_district` VALUES ('256', '18', '0', '铁岭', '2');
INSERT INTO `cmf_district` VALUES ('257', '18', '0', '营口', '2');
INSERT INTO `cmf_district` VALUES ('258', '19', '0', '呼和浩特', '2');
INSERT INTO `cmf_district` VALUES ('259', '19', '0', '阿拉善盟', '2');
INSERT INTO `cmf_district` VALUES ('260', '19', '0', '巴彦淖尔盟', '2');
INSERT INTO `cmf_district` VALUES ('261', '19', '0', '包头', '2');
INSERT INTO `cmf_district` VALUES ('262', '19', '0', '赤峰', '2');
INSERT INTO `cmf_district` VALUES ('263', '19', '0', '鄂尔多斯', '2');
INSERT INTO `cmf_district` VALUES ('264', '19', '0', '呼伦贝尔', '2');
INSERT INTO `cmf_district` VALUES ('265', '19', '0', '通辽', '2');
INSERT INTO `cmf_district` VALUES ('266', '19', '0', '乌海', '2');
INSERT INTO `cmf_district` VALUES ('267', '19', '0', '乌兰察布市', '2');
INSERT INTO `cmf_district` VALUES ('268', '19', '0', '锡林郭勒盟', '2');
INSERT INTO `cmf_district` VALUES ('269', '19', '0', '兴安盟', '2');
INSERT INTO `cmf_district` VALUES ('270', '20', '0', '银川', '2');
INSERT INTO `cmf_district` VALUES ('271', '20', '0', '固原', '2');
INSERT INTO `cmf_district` VALUES ('272', '20', '0', '石嘴山', '2');
INSERT INTO `cmf_district` VALUES ('273', '20', '0', '吴忠', '2');
INSERT INTO `cmf_district` VALUES ('274', '20', '0', '中卫', '2');
INSERT INTO `cmf_district` VALUES ('275', '21', '0', '西宁', '2');
INSERT INTO `cmf_district` VALUES ('276', '21', '0', '果洛', '2');
INSERT INTO `cmf_district` VALUES ('277', '21', '0', '海北', '2');
INSERT INTO `cmf_district` VALUES ('278', '21', '0', '海东', '2');
INSERT INTO `cmf_district` VALUES ('279', '21', '0', '海南', '2');
INSERT INTO `cmf_district` VALUES ('280', '21', '0', '海西', '2');
INSERT INTO `cmf_district` VALUES ('281', '21', '0', '黄南', '2');
INSERT INTO `cmf_district` VALUES ('282', '21', '0', '玉树', '2');
INSERT INTO `cmf_district` VALUES ('283', '22', '0', '济南', '2');
INSERT INTO `cmf_district` VALUES ('284', '22', '0', '青岛', '2');
INSERT INTO `cmf_district` VALUES ('285', '22', '0', '滨州', '2');
INSERT INTO `cmf_district` VALUES ('286', '22', '0', '德州', '2');
INSERT INTO `cmf_district` VALUES ('287', '22', '0', '东营', '2');
INSERT INTO `cmf_district` VALUES ('288', '22', '0', '菏泽', '2');
INSERT INTO `cmf_district` VALUES ('289', '22', '0', '济宁', '2');
INSERT INTO `cmf_district` VALUES ('290', '22', '0', '莱芜', '2');
INSERT INTO `cmf_district` VALUES ('291', '22', '0', '聊城', '2');
INSERT INTO `cmf_district` VALUES ('292', '22', '0', '临沂', '2');
INSERT INTO `cmf_district` VALUES ('293', '22', '0', '日照', '2');
INSERT INTO `cmf_district` VALUES ('294', '22', '0', '泰安', '2');
INSERT INTO `cmf_district` VALUES ('295', '22', '0', '威海', '2');
INSERT INTO `cmf_district` VALUES ('296', '22', '0', '潍坊', '2');
INSERT INTO `cmf_district` VALUES ('297', '22', '0', '烟台', '2');
INSERT INTO `cmf_district` VALUES ('298', '22', '0', '枣庄', '2');
INSERT INTO `cmf_district` VALUES ('299', '22', '0', '淄博', '2');
INSERT INTO `cmf_district` VALUES ('300', '23', '0', '太原', '2');
INSERT INTO `cmf_district` VALUES ('301', '23', '0', '长治', '2');
INSERT INTO `cmf_district` VALUES ('302', '23', '0', '大同', '2');
INSERT INTO `cmf_district` VALUES ('303', '23', '0', '晋城', '2');
INSERT INTO `cmf_district` VALUES ('304', '23', '0', '晋中', '2');
INSERT INTO `cmf_district` VALUES ('305', '23', '0', '临汾', '2');
INSERT INTO `cmf_district` VALUES ('306', '23', '0', '吕梁', '2');
INSERT INTO `cmf_district` VALUES ('307', '23', '0', '朔州', '2');
INSERT INTO `cmf_district` VALUES ('308', '23', '0', '忻州', '2');
INSERT INTO `cmf_district` VALUES ('309', '23', '0', '阳泉', '2');
INSERT INTO `cmf_district` VALUES ('310', '23', '0', '运城', '2');
INSERT INTO `cmf_district` VALUES ('311', '24', '0', '西安', '2');
INSERT INTO `cmf_district` VALUES ('312', '24', '0', '安康', '2');
INSERT INTO `cmf_district` VALUES ('313', '24', '0', '宝鸡', '2');
INSERT INTO `cmf_district` VALUES ('314', '24', '0', '汉中', '2');
INSERT INTO `cmf_district` VALUES ('315', '24', '0', '商洛', '2');
INSERT INTO `cmf_district` VALUES ('316', '24', '0', '铜川', '2');
INSERT INTO `cmf_district` VALUES ('317', '24', '0', '渭南', '2');
INSERT INTO `cmf_district` VALUES ('318', '24', '0', '咸阳', '2');
INSERT INTO `cmf_district` VALUES ('319', '24', '0', '延安', '2');
INSERT INTO `cmf_district` VALUES ('320', '24', '0', '榆林', '2');
INSERT INTO `cmf_district` VALUES ('321', '25', '0', '上海', '2');
INSERT INTO `cmf_district` VALUES ('322', '26', '0', '成都', '2');
INSERT INTO `cmf_district` VALUES ('323', '26', '0', '绵阳', '2');
INSERT INTO `cmf_district` VALUES ('324', '26', '0', '阿坝', '2');
INSERT INTO `cmf_district` VALUES ('325', '26', '0', '巴中', '2');
INSERT INTO `cmf_district` VALUES ('326', '26', '0', '达州', '2');
INSERT INTO `cmf_district` VALUES ('327', '26', '0', '德阳', '2');
INSERT INTO `cmf_district` VALUES ('328', '26', '0', '甘孜', '2');
INSERT INTO `cmf_district` VALUES ('329', '26', '0', '广安', '2');
INSERT INTO `cmf_district` VALUES ('330', '26', '0', '广元', '2');
INSERT INTO `cmf_district` VALUES ('331', '26', '0', '乐山', '2');
INSERT INTO `cmf_district` VALUES ('332', '26', '0', '凉山', '2');
INSERT INTO `cmf_district` VALUES ('333', '26', '0', '眉山', '2');
INSERT INTO `cmf_district` VALUES ('334', '26', '0', '南充', '2');
INSERT INTO `cmf_district` VALUES ('335', '26', '0', '内江', '2');
INSERT INTO `cmf_district` VALUES ('336', '26', '0', '攀枝花', '2');
INSERT INTO `cmf_district` VALUES ('337', '26', '0', '遂宁', '2');
INSERT INTO `cmf_district` VALUES ('338', '26', '0', '雅安', '2');
INSERT INTO `cmf_district` VALUES ('339', '26', '0', '宜宾', '2');
INSERT INTO `cmf_district` VALUES ('340', '26', '0', '资阳', '2');
INSERT INTO `cmf_district` VALUES ('341', '26', '0', '自贡', '2');
INSERT INTO `cmf_district` VALUES ('342', '26', '0', '泸州', '2');
INSERT INTO `cmf_district` VALUES ('343', '27', '0', '天津', '2');
INSERT INTO `cmf_district` VALUES ('344', '28', '0', '拉萨', '2');
INSERT INTO `cmf_district` VALUES ('345', '28', '0', '阿里', '2');
INSERT INTO `cmf_district` VALUES ('346', '28', '0', '昌都', '2');
INSERT INTO `cmf_district` VALUES ('347', '28', '0', '林芝', '2');
INSERT INTO `cmf_district` VALUES ('348', '28', '0', '那曲', '2');
INSERT INTO `cmf_district` VALUES ('349', '28', '0', '日喀则', '2');
INSERT INTO `cmf_district` VALUES ('350', '28', '0', '山南', '2');
INSERT INTO `cmf_district` VALUES ('351', '29', '0', '乌鲁木齐', '2');
INSERT INTO `cmf_district` VALUES ('352', '29', '0', '阿克苏', '2');
INSERT INTO `cmf_district` VALUES ('353', '29', '0', '阿拉尔', '2');
INSERT INTO `cmf_district` VALUES ('354', '29', '0', '巴音郭楞', '2');
INSERT INTO `cmf_district` VALUES ('355', '29', '0', '博尔塔拉', '2');
INSERT INTO `cmf_district` VALUES ('356', '29', '0', '昌吉', '2');
INSERT INTO `cmf_district` VALUES ('357', '29', '0', '哈密', '2');
INSERT INTO `cmf_district` VALUES ('358', '29', '0', '和田', '2');
INSERT INTO `cmf_district` VALUES ('359', '29', '0', '喀什', '2');
INSERT INTO `cmf_district` VALUES ('360', '29', '0', '克拉玛依', '2');
INSERT INTO `cmf_district` VALUES ('361', '29', '0', '克孜勒苏', '2');
INSERT INTO `cmf_district` VALUES ('362', '29', '0', '石河子', '2');
INSERT INTO `cmf_district` VALUES ('363', '29', '0', '图木舒克', '2');
INSERT INTO `cmf_district` VALUES ('364', '29', '0', '吐鲁番', '2');
INSERT INTO `cmf_district` VALUES ('365', '29', '0', '五家渠', '2');
INSERT INTO `cmf_district` VALUES ('366', '29', '0', '伊犁', '2');
INSERT INTO `cmf_district` VALUES ('367', '30', '0', '昆明', '2');
INSERT INTO `cmf_district` VALUES ('368', '30', '0', '怒江', '2');
INSERT INTO `cmf_district` VALUES ('369', '30', '0', '普洱', '2');
INSERT INTO `cmf_district` VALUES ('370', '30', '0', '丽江', '2');
INSERT INTO `cmf_district` VALUES ('371', '30', '0', '保山', '2');
INSERT INTO `cmf_district` VALUES ('372', '30', '0', '楚雄', '2');
INSERT INTO `cmf_district` VALUES ('373', '30', '0', '大理', '2');
INSERT INTO `cmf_district` VALUES ('374', '30', '0', '德宏', '2');
INSERT INTO `cmf_district` VALUES ('375', '30', '0', '迪庆', '2');
INSERT INTO `cmf_district` VALUES ('376', '30', '0', '红河', '2');
INSERT INTO `cmf_district` VALUES ('377', '30', '0', '临沧', '2');
INSERT INTO `cmf_district` VALUES ('378', '30', '0', '曲靖', '2');
INSERT INTO `cmf_district` VALUES ('379', '30', '0', '文山', '2');
INSERT INTO `cmf_district` VALUES ('380', '30', '0', '西双版纳', '2');
INSERT INTO `cmf_district` VALUES ('381', '30', '0', '玉溪', '2');
INSERT INTO `cmf_district` VALUES ('382', '30', '0', '昭通', '2');
INSERT INTO `cmf_district` VALUES ('383', '31', '0', '杭州', '2');
INSERT INTO `cmf_district` VALUES ('384', '31', '0', '湖州', '2');
INSERT INTO `cmf_district` VALUES ('385', '31', '0', '嘉兴', '2');
INSERT INTO `cmf_district` VALUES ('386', '31', '0', '金华', '2');
INSERT INTO `cmf_district` VALUES ('387', '31', '0', '丽水', '2');
INSERT INTO `cmf_district` VALUES ('388', '31', '0', '宁波', '2');
INSERT INTO `cmf_district` VALUES ('389', '31', '0', '绍兴', '2');
INSERT INTO `cmf_district` VALUES ('390', '31', '0', '台州', '2');
INSERT INTO `cmf_district` VALUES ('391', '31', '0', '温州', '2');
INSERT INTO `cmf_district` VALUES ('392', '31', '0', '舟山', '2');
INSERT INTO `cmf_district` VALUES ('393', '31', '0', '衢州', '2');
INSERT INTO `cmf_district` VALUES ('394', '32', '0', '重庆', '2');
INSERT INTO `cmf_district` VALUES ('395', '33', '0', '香港', '2');
INSERT INTO `cmf_district` VALUES ('396', '34', '0', '澳门', '2');
INSERT INTO `cmf_district` VALUES ('397', '35', '0', '台湾', '2');
INSERT INTO `cmf_district` VALUES ('398', '36', '0', '迎江区', '3');
INSERT INTO `cmf_district` VALUES ('399', '36', '0', '大观区', '3');
INSERT INTO `cmf_district` VALUES ('400', '36', '0', '宜秀区', '3');
INSERT INTO `cmf_district` VALUES ('401', '36', '0', '桐城市', '3');
INSERT INTO `cmf_district` VALUES ('402', '36', '0', '怀宁县', '3');
INSERT INTO `cmf_district` VALUES ('403', '36', '0', '枞阳县', '3');
INSERT INTO `cmf_district` VALUES ('404', '36', '0', '潜山县', '3');
INSERT INTO `cmf_district` VALUES ('405', '36', '0', '太湖县', '3');
INSERT INTO `cmf_district` VALUES ('406', '36', '0', '宿松县', '3');
INSERT INTO `cmf_district` VALUES ('407', '36', '0', '望江县', '3');
INSERT INTO `cmf_district` VALUES ('408', '36', '0', '岳西县', '3');
INSERT INTO `cmf_district` VALUES ('409', '37', '0', '中市区', '3');
INSERT INTO `cmf_district` VALUES ('410', '37', '0', '东市区', '3');
INSERT INTO `cmf_district` VALUES ('411', '37', '0', '西市区', '3');
INSERT INTO `cmf_district` VALUES ('412', '37', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('413', '37', '0', '怀远县', '3');
INSERT INTO `cmf_district` VALUES ('414', '37', '0', '五河县', '3');
INSERT INTO `cmf_district` VALUES ('415', '37', '0', '固镇县', '3');
INSERT INTO `cmf_district` VALUES ('416', '38', '0', '居巢区', '3');
INSERT INTO `cmf_district` VALUES ('417', '38', '0', '庐江县', '3');
INSERT INTO `cmf_district` VALUES ('418', '38', '0', '无为县', '3');
INSERT INTO `cmf_district` VALUES ('419', '38', '0', '含山县', '3');
INSERT INTO `cmf_district` VALUES ('420', '38', '0', '和县', '3');
INSERT INTO `cmf_district` VALUES ('421', '39', '0', '贵池区', '3');
INSERT INTO `cmf_district` VALUES ('422', '39', '0', '东至县', '3');
INSERT INTO `cmf_district` VALUES ('423', '39', '0', '石台县', '3');
INSERT INTO `cmf_district` VALUES ('424', '39', '0', '青阳县', '3');
INSERT INTO `cmf_district` VALUES ('425', '40', '0', '琅琊区', '3');
INSERT INTO `cmf_district` VALUES ('426', '40', '0', '南谯区', '3');
INSERT INTO `cmf_district` VALUES ('427', '40', '0', '天长市', '3');
INSERT INTO `cmf_district` VALUES ('428', '40', '0', '明光市', '3');
INSERT INTO `cmf_district` VALUES ('429', '40', '0', '来安县', '3');
INSERT INTO `cmf_district` VALUES ('430', '40', '0', '全椒县', '3');
INSERT INTO `cmf_district` VALUES ('431', '40', '0', '定远县', '3');
INSERT INTO `cmf_district` VALUES ('432', '40', '0', '凤阳县', '3');
INSERT INTO `cmf_district` VALUES ('433', '41', '0', '蚌山区', '3');
INSERT INTO `cmf_district` VALUES ('434', '41', '0', '龙子湖区', '3');
INSERT INTO `cmf_district` VALUES ('435', '41', '0', '禹会区', '3');
INSERT INTO `cmf_district` VALUES ('436', '41', '0', '淮上区', '3');
INSERT INTO `cmf_district` VALUES ('437', '41', '0', '颍州区', '3');
INSERT INTO `cmf_district` VALUES ('438', '41', '0', '颍东区', '3');
INSERT INTO `cmf_district` VALUES ('439', '41', '0', '颍泉区', '3');
INSERT INTO `cmf_district` VALUES ('440', '41', '0', '界首市', '3');
INSERT INTO `cmf_district` VALUES ('441', '41', '0', '临泉县', '3');
INSERT INTO `cmf_district` VALUES ('442', '41', '0', '太和县', '3');
INSERT INTO `cmf_district` VALUES ('443', '41', '0', '阜南县', '3');
INSERT INTO `cmf_district` VALUES ('444', '41', '0', '颖上县', '3');
INSERT INTO `cmf_district` VALUES ('445', '42', '0', '相山区', '3');
INSERT INTO `cmf_district` VALUES ('446', '42', '0', '杜集区', '3');
INSERT INTO `cmf_district` VALUES ('447', '42', '0', '烈山区', '3');
INSERT INTO `cmf_district` VALUES ('448', '42', '0', '濉溪县', '3');
INSERT INTO `cmf_district` VALUES ('449', '43', '0', '田家庵区', '3');
INSERT INTO `cmf_district` VALUES ('450', '43', '0', '大通区', '3');
INSERT INTO `cmf_district` VALUES ('451', '43', '0', '谢家集区', '3');
INSERT INTO `cmf_district` VALUES ('452', '43', '0', '八公山区', '3');
INSERT INTO `cmf_district` VALUES ('453', '43', '0', '潘集区', '3');
INSERT INTO `cmf_district` VALUES ('454', '43', '0', '凤台县', '3');
INSERT INTO `cmf_district` VALUES ('455', '44', '0', '屯溪区', '3');
INSERT INTO `cmf_district` VALUES ('456', '44', '0', '黄山区', '3');
INSERT INTO `cmf_district` VALUES ('457', '44', '0', '徽州区', '3');
INSERT INTO `cmf_district` VALUES ('458', '44', '0', '歙县', '3');
INSERT INTO `cmf_district` VALUES ('459', '44', '0', '休宁县', '3');
INSERT INTO `cmf_district` VALUES ('460', '44', '0', '黟县', '3');
INSERT INTO `cmf_district` VALUES ('461', '44', '0', '祁门县', '3');
INSERT INTO `cmf_district` VALUES ('462', '45', '0', '金安区', '3');
INSERT INTO `cmf_district` VALUES ('463', '45', '0', '裕安区', '3');
INSERT INTO `cmf_district` VALUES ('464', '45', '0', '寿县', '3');
INSERT INTO `cmf_district` VALUES ('465', '45', '0', '霍邱县', '3');
INSERT INTO `cmf_district` VALUES ('466', '45', '0', '舒城县', '3');
INSERT INTO `cmf_district` VALUES ('467', '45', '0', '金寨县', '3');
INSERT INTO `cmf_district` VALUES ('468', '45', '0', '霍山县', '3');
INSERT INTO `cmf_district` VALUES ('469', '46', '0', '雨山区', '3');
INSERT INTO `cmf_district` VALUES ('470', '46', '0', '花山区', '3');
INSERT INTO `cmf_district` VALUES ('471', '46', '0', '金家庄区', '3');
INSERT INTO `cmf_district` VALUES ('472', '46', '0', '当涂县', '3');
INSERT INTO `cmf_district` VALUES ('473', '47', '0', '埇桥区', '3');
INSERT INTO `cmf_district` VALUES ('474', '47', '0', '砀山县', '3');
INSERT INTO `cmf_district` VALUES ('475', '47', '0', '萧县', '3');
INSERT INTO `cmf_district` VALUES ('476', '47', '0', '灵璧县', '3');
INSERT INTO `cmf_district` VALUES ('477', '47', '0', '泗县', '3');
INSERT INTO `cmf_district` VALUES ('478', '48', '0', '铜官山区', '3');
INSERT INTO `cmf_district` VALUES ('479', '48', '0', '狮子山区', '3');
INSERT INTO `cmf_district` VALUES ('480', '48', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('481', '48', '0', '铜陵县', '3');
INSERT INTO `cmf_district` VALUES ('482', '49', '0', '镜湖区', '3');
INSERT INTO `cmf_district` VALUES ('483', '49', '0', '弋江区', '3');
INSERT INTO `cmf_district` VALUES ('484', '49', '0', '鸠江区', '3');
INSERT INTO `cmf_district` VALUES ('485', '49', '0', '三山区', '3');
INSERT INTO `cmf_district` VALUES ('486', '49', '0', '芜湖县', '3');
INSERT INTO `cmf_district` VALUES ('487', '49', '0', '繁昌县', '3');
INSERT INTO `cmf_district` VALUES ('488', '49', '0', '南陵县', '3');
INSERT INTO `cmf_district` VALUES ('489', '50', '0', '宣州区', '3');
INSERT INTO `cmf_district` VALUES ('490', '50', '0', '宁国市', '3');
INSERT INTO `cmf_district` VALUES ('491', '50', '0', '郎溪县', '3');
INSERT INTO `cmf_district` VALUES ('492', '50', '0', '广德县', '3');
INSERT INTO `cmf_district` VALUES ('493', '50', '0', '泾县', '3');
INSERT INTO `cmf_district` VALUES ('494', '50', '0', '绩溪县', '3');
INSERT INTO `cmf_district` VALUES ('495', '50', '0', '旌德县', '3');
INSERT INTO `cmf_district` VALUES ('496', '51', '0', '涡阳县', '3');
INSERT INTO `cmf_district` VALUES ('497', '51', '0', '蒙城县', '3');
INSERT INTO `cmf_district` VALUES ('498', '51', '0', '利辛县', '3');
INSERT INTO `cmf_district` VALUES ('499', '51', '0', '谯城区', '3');
INSERT INTO `cmf_district` VALUES ('500', '52', '0', '东城区', '3');
INSERT INTO `cmf_district` VALUES ('501', '52', '0', '西城区', '3');
INSERT INTO `cmf_district` VALUES ('502', '52', '0', '海淀区', '3');
INSERT INTO `cmf_district` VALUES ('503', '52', '0', '朝阳区', '3');
INSERT INTO `cmf_district` VALUES ('504', '52', '0', '崇文区', '3');
INSERT INTO `cmf_district` VALUES ('505', '52', '0', '宣武区', '3');
INSERT INTO `cmf_district` VALUES ('506', '52', '0', '丰台区', '3');
INSERT INTO `cmf_district` VALUES ('507', '52', '0', '石景山区', '3');
INSERT INTO `cmf_district` VALUES ('508', '52', '0', '房山区', '3');
INSERT INTO `cmf_district` VALUES ('509', '52', '0', '门头沟区', '3');
INSERT INTO `cmf_district` VALUES ('510', '52', '0', '通州区', '3');
INSERT INTO `cmf_district` VALUES ('511', '52', '0', '顺义区', '3');
INSERT INTO `cmf_district` VALUES ('512', '52', '0', '昌平区', '3');
INSERT INTO `cmf_district` VALUES ('513', '52', '0', '怀柔区', '3');
INSERT INTO `cmf_district` VALUES ('514', '52', '0', '平谷区', '3');
INSERT INTO `cmf_district` VALUES ('515', '52', '0', '大兴区', '3');
INSERT INTO `cmf_district` VALUES ('516', '52', '0', '密云县', '3');
INSERT INTO `cmf_district` VALUES ('517', '52', '0', '延庆县', '3');
INSERT INTO `cmf_district` VALUES ('518', '53', '0', '鼓楼区', '3');
INSERT INTO `cmf_district` VALUES ('519', '53', '0', '台江区', '3');
INSERT INTO `cmf_district` VALUES ('520', '53', '0', '仓山区', '3');
INSERT INTO `cmf_district` VALUES ('521', '53', '0', '马尾区', '3');
INSERT INTO `cmf_district` VALUES ('522', '53', '0', '晋安区', '3');
INSERT INTO `cmf_district` VALUES ('523', '53', '0', '福清市', '3');
INSERT INTO `cmf_district` VALUES ('524', '53', '0', '长乐市', '3');
INSERT INTO `cmf_district` VALUES ('525', '53', '0', '闽侯县', '3');
INSERT INTO `cmf_district` VALUES ('526', '53', '0', '连江县', '3');
INSERT INTO `cmf_district` VALUES ('527', '53', '0', '罗源县', '3');
INSERT INTO `cmf_district` VALUES ('528', '53', '0', '闽清县', '3');
INSERT INTO `cmf_district` VALUES ('529', '53', '0', '永泰县', '3');
INSERT INTO `cmf_district` VALUES ('530', '53', '0', '平潭县', '3');
INSERT INTO `cmf_district` VALUES ('531', '54', '0', '新罗区', '3');
INSERT INTO `cmf_district` VALUES ('532', '54', '0', '漳平市', '3');
INSERT INTO `cmf_district` VALUES ('533', '54', '0', '长汀县', '3');
INSERT INTO `cmf_district` VALUES ('534', '54', '0', '永定县', '3');
INSERT INTO `cmf_district` VALUES ('535', '54', '0', '上杭县', '3');
INSERT INTO `cmf_district` VALUES ('536', '54', '0', '武平县', '3');
INSERT INTO `cmf_district` VALUES ('537', '54', '0', '连城县', '3');
INSERT INTO `cmf_district` VALUES ('538', '55', '0', '延平区', '3');
INSERT INTO `cmf_district` VALUES ('539', '55', '0', '邵武市', '3');
INSERT INTO `cmf_district` VALUES ('540', '55', '0', '武夷山市', '3');
INSERT INTO `cmf_district` VALUES ('541', '55', '0', '建瓯市', '3');
INSERT INTO `cmf_district` VALUES ('542', '55', '0', '建阳市', '3');
INSERT INTO `cmf_district` VALUES ('543', '55', '0', '顺昌县', '3');
INSERT INTO `cmf_district` VALUES ('544', '55', '0', '浦城县', '3');
INSERT INTO `cmf_district` VALUES ('545', '55', '0', '光泽县', '3');
INSERT INTO `cmf_district` VALUES ('546', '55', '0', '松溪县', '3');
INSERT INTO `cmf_district` VALUES ('547', '55', '0', '政和县', '3');
INSERT INTO `cmf_district` VALUES ('548', '56', '0', '蕉城区', '3');
INSERT INTO `cmf_district` VALUES ('549', '56', '0', '福安市', '3');
INSERT INTO `cmf_district` VALUES ('550', '56', '0', '福鼎市', '3');
INSERT INTO `cmf_district` VALUES ('551', '56', '0', '霞浦县', '3');
INSERT INTO `cmf_district` VALUES ('552', '56', '0', '古田县', '3');
INSERT INTO `cmf_district` VALUES ('553', '56', '0', '屏南县', '3');
INSERT INTO `cmf_district` VALUES ('554', '56', '0', '寿宁县', '3');
INSERT INTO `cmf_district` VALUES ('555', '56', '0', '周宁县', '3');
INSERT INTO `cmf_district` VALUES ('556', '56', '0', '柘荣县', '3');
INSERT INTO `cmf_district` VALUES ('557', '57', '0', '城厢区', '3');
INSERT INTO `cmf_district` VALUES ('558', '57', '0', '涵江区', '3');
INSERT INTO `cmf_district` VALUES ('559', '57', '0', '荔城区', '3');
INSERT INTO `cmf_district` VALUES ('560', '57', '0', '秀屿区', '3');
INSERT INTO `cmf_district` VALUES ('561', '57', '0', '仙游县', '3');
INSERT INTO `cmf_district` VALUES ('562', '58', '0', '鲤城区', '3');
INSERT INTO `cmf_district` VALUES ('563', '58', '0', '丰泽区', '3');
INSERT INTO `cmf_district` VALUES ('564', '58', '0', '洛江区', '3');
INSERT INTO `cmf_district` VALUES ('565', '58', '0', '清濛开发区', '3');
INSERT INTO `cmf_district` VALUES ('566', '58', '0', '泉港区', '3');
INSERT INTO `cmf_district` VALUES ('567', '58', '0', '石狮市', '3');
INSERT INTO `cmf_district` VALUES ('568', '58', '0', '晋江市', '3');
INSERT INTO `cmf_district` VALUES ('569', '58', '0', '南安市', '3');
INSERT INTO `cmf_district` VALUES ('570', '58', '0', '惠安县', '3');
INSERT INTO `cmf_district` VALUES ('571', '58', '0', '安溪县', '3');
INSERT INTO `cmf_district` VALUES ('572', '58', '0', '永春县', '3');
INSERT INTO `cmf_district` VALUES ('573', '58', '0', '德化县', '3');
INSERT INTO `cmf_district` VALUES ('574', '58', '0', '金门县', '3');
INSERT INTO `cmf_district` VALUES ('575', '59', '0', '梅列区', '3');
INSERT INTO `cmf_district` VALUES ('576', '59', '0', '三元区', '3');
INSERT INTO `cmf_district` VALUES ('577', '59', '0', '永安市', '3');
INSERT INTO `cmf_district` VALUES ('578', '59', '0', '明溪县', '3');
INSERT INTO `cmf_district` VALUES ('579', '59', '0', '清流县', '3');
INSERT INTO `cmf_district` VALUES ('580', '59', '0', '宁化县', '3');
INSERT INTO `cmf_district` VALUES ('581', '59', '0', '大田县', '3');
INSERT INTO `cmf_district` VALUES ('582', '59', '0', '尤溪县', '3');
INSERT INTO `cmf_district` VALUES ('583', '59', '0', '沙县', '3');
INSERT INTO `cmf_district` VALUES ('584', '59', '0', '将乐县', '3');
INSERT INTO `cmf_district` VALUES ('585', '59', '0', '泰宁县', '3');
INSERT INTO `cmf_district` VALUES ('586', '59', '0', '建宁县', '3');
INSERT INTO `cmf_district` VALUES ('587', '60', '0', '思明区', '3');
INSERT INTO `cmf_district` VALUES ('588', '60', '0', '海沧区', '3');
INSERT INTO `cmf_district` VALUES ('589', '60', '0', '湖里区', '3');
INSERT INTO `cmf_district` VALUES ('590', '60', '0', '集美区', '3');
INSERT INTO `cmf_district` VALUES ('591', '60', '0', '同安区', '3');
INSERT INTO `cmf_district` VALUES ('592', '60', '0', '翔安区', '3');
INSERT INTO `cmf_district` VALUES ('593', '61', '0', '芗城区', '3');
INSERT INTO `cmf_district` VALUES ('594', '61', '0', '龙文区', '3');
INSERT INTO `cmf_district` VALUES ('595', '61', '0', '龙海市', '3');
INSERT INTO `cmf_district` VALUES ('596', '61', '0', '云霄县', '3');
INSERT INTO `cmf_district` VALUES ('597', '61', '0', '漳浦县', '3');
INSERT INTO `cmf_district` VALUES ('598', '61', '0', '诏安县', '3');
INSERT INTO `cmf_district` VALUES ('599', '61', '0', '长泰县', '3');
INSERT INTO `cmf_district` VALUES ('600', '61', '0', '东山县', '3');
INSERT INTO `cmf_district` VALUES ('601', '61', '0', '南靖县', '3');
INSERT INTO `cmf_district` VALUES ('602', '61', '0', '平和县', '3');
INSERT INTO `cmf_district` VALUES ('603', '61', '0', '华安县', '3');
INSERT INTO `cmf_district` VALUES ('604', '62', '0', '皋兰县', '3');
INSERT INTO `cmf_district` VALUES ('605', '62', '0', '城关区', '3');
INSERT INTO `cmf_district` VALUES ('606', '62', '0', '七里河区', '3');
INSERT INTO `cmf_district` VALUES ('607', '62', '0', '西固区', '3');
INSERT INTO `cmf_district` VALUES ('608', '62', '0', '安宁区', '3');
INSERT INTO `cmf_district` VALUES ('609', '62', '0', '红古区', '3');
INSERT INTO `cmf_district` VALUES ('610', '62', '0', '永登县', '3');
INSERT INTO `cmf_district` VALUES ('611', '62', '0', '榆中县', '3');
INSERT INTO `cmf_district` VALUES ('612', '63', '0', '白银区', '3');
INSERT INTO `cmf_district` VALUES ('613', '63', '0', '平川区', '3');
INSERT INTO `cmf_district` VALUES ('614', '63', '0', '会宁县', '3');
INSERT INTO `cmf_district` VALUES ('615', '63', '0', '景泰县', '3');
INSERT INTO `cmf_district` VALUES ('616', '63', '0', '靖远县', '3');
INSERT INTO `cmf_district` VALUES ('617', '64', '0', '临洮县', '3');
INSERT INTO `cmf_district` VALUES ('618', '64', '0', '陇西县', '3');
INSERT INTO `cmf_district` VALUES ('619', '64', '0', '通渭县', '3');
INSERT INTO `cmf_district` VALUES ('620', '64', '0', '渭源县', '3');
INSERT INTO `cmf_district` VALUES ('621', '64', '0', '漳县', '3');
INSERT INTO `cmf_district` VALUES ('622', '64', '0', '岷县', '3');
INSERT INTO `cmf_district` VALUES ('623', '64', '0', '安定区', '3');
INSERT INTO `cmf_district` VALUES ('624', '64', '0', '安定区', '3');
INSERT INTO `cmf_district` VALUES ('625', '65', '0', '合作市', '3');
INSERT INTO `cmf_district` VALUES ('626', '65', '0', '临潭县', '3');
INSERT INTO `cmf_district` VALUES ('627', '65', '0', '卓尼县', '3');
INSERT INTO `cmf_district` VALUES ('628', '65', '0', '舟曲县', '3');
INSERT INTO `cmf_district` VALUES ('629', '65', '0', '迭部县', '3');
INSERT INTO `cmf_district` VALUES ('630', '65', '0', '玛曲县', '3');
INSERT INTO `cmf_district` VALUES ('631', '65', '0', '碌曲县', '3');
INSERT INTO `cmf_district` VALUES ('632', '65', '0', '夏河县', '3');
INSERT INTO `cmf_district` VALUES ('633', '66', '0', '嘉峪关市', '3');
INSERT INTO `cmf_district` VALUES ('634', '67', '0', '金川区', '3');
INSERT INTO `cmf_district` VALUES ('635', '67', '0', '永昌县', '3');
INSERT INTO `cmf_district` VALUES ('636', '68', '0', '肃州区', '3');
INSERT INTO `cmf_district` VALUES ('637', '68', '0', '玉门市', '3');
INSERT INTO `cmf_district` VALUES ('638', '68', '0', '敦煌市', '3');
INSERT INTO `cmf_district` VALUES ('639', '68', '0', '金塔县', '3');
INSERT INTO `cmf_district` VALUES ('640', '68', '0', '瓜州县', '3');
INSERT INTO `cmf_district` VALUES ('641', '68', '0', '肃北', '3');
INSERT INTO `cmf_district` VALUES ('642', '68', '0', '阿克塞', '3');
INSERT INTO `cmf_district` VALUES ('643', '69', '0', '临夏市', '3');
INSERT INTO `cmf_district` VALUES ('644', '69', '0', '临夏县', '3');
INSERT INTO `cmf_district` VALUES ('645', '69', '0', '康乐县', '3');
INSERT INTO `cmf_district` VALUES ('646', '69', '0', '永靖县', '3');
INSERT INTO `cmf_district` VALUES ('647', '69', '0', '广河县', '3');
INSERT INTO `cmf_district` VALUES ('648', '69', '0', '和政县', '3');
INSERT INTO `cmf_district` VALUES ('649', '69', '0', '东乡族自治县', '3');
INSERT INTO `cmf_district` VALUES ('650', '69', '0', '积石山', '3');
INSERT INTO `cmf_district` VALUES ('651', '70', '0', '成县', '3');
INSERT INTO `cmf_district` VALUES ('652', '70', '0', '徽县', '3');
INSERT INTO `cmf_district` VALUES ('653', '70', '0', '康县', '3');
INSERT INTO `cmf_district` VALUES ('654', '70', '0', '礼县', '3');
INSERT INTO `cmf_district` VALUES ('655', '70', '0', '两当县', '3');
INSERT INTO `cmf_district` VALUES ('656', '70', '0', '文县', '3');
INSERT INTO `cmf_district` VALUES ('657', '70', '0', '西和县', '3');
INSERT INTO `cmf_district` VALUES ('658', '70', '0', '宕昌县', '3');
INSERT INTO `cmf_district` VALUES ('659', '70', '0', '武都区', '3');
INSERT INTO `cmf_district` VALUES ('660', '71', '0', '崇信县', '3');
INSERT INTO `cmf_district` VALUES ('661', '71', '0', '华亭县', '3');
INSERT INTO `cmf_district` VALUES ('662', '71', '0', '静宁县', '3');
INSERT INTO `cmf_district` VALUES ('663', '71', '0', '灵台县', '3');
INSERT INTO `cmf_district` VALUES ('664', '71', '0', '崆峒区', '3');
INSERT INTO `cmf_district` VALUES ('665', '71', '0', '庄浪县', '3');
INSERT INTO `cmf_district` VALUES ('666', '71', '0', '泾川县', '3');
INSERT INTO `cmf_district` VALUES ('667', '72', '0', '合水县', '3');
INSERT INTO `cmf_district` VALUES ('668', '72', '0', '华池县', '3');
INSERT INTO `cmf_district` VALUES ('669', '72', '0', '环县', '3');
INSERT INTO `cmf_district` VALUES ('670', '72', '0', '宁县', '3');
INSERT INTO `cmf_district` VALUES ('671', '72', '0', '庆城县', '3');
INSERT INTO `cmf_district` VALUES ('672', '72', '0', '西峰区', '3');
INSERT INTO `cmf_district` VALUES ('673', '72', '0', '镇原县', '3');
INSERT INTO `cmf_district` VALUES ('674', '72', '0', '正宁县', '3');
INSERT INTO `cmf_district` VALUES ('675', '73', '0', '甘谷县', '3');
INSERT INTO `cmf_district` VALUES ('676', '73', '0', '秦安县', '3');
INSERT INTO `cmf_district` VALUES ('677', '73', '0', '清水县', '3');
INSERT INTO `cmf_district` VALUES ('678', '73', '0', '秦州区', '3');
INSERT INTO `cmf_district` VALUES ('679', '73', '0', '麦积区', '3');
INSERT INTO `cmf_district` VALUES ('680', '73', '0', '武山县', '3');
INSERT INTO `cmf_district` VALUES ('681', '73', '0', '张家川', '3');
INSERT INTO `cmf_district` VALUES ('682', '74', '0', '古浪县', '3');
INSERT INTO `cmf_district` VALUES ('683', '74', '0', '民勤县', '3');
INSERT INTO `cmf_district` VALUES ('684', '74', '0', '天祝', '3');
INSERT INTO `cmf_district` VALUES ('685', '74', '0', '凉州区', '3');
INSERT INTO `cmf_district` VALUES ('686', '75', '0', '高台县', '3');
INSERT INTO `cmf_district` VALUES ('687', '75', '0', '临泽县', '3');
INSERT INTO `cmf_district` VALUES ('688', '75', '0', '民乐县', '3');
INSERT INTO `cmf_district` VALUES ('689', '75', '0', '山丹县', '3');
INSERT INTO `cmf_district` VALUES ('690', '75', '0', '肃南', '3');
INSERT INTO `cmf_district` VALUES ('691', '75', '0', '甘州区', '3');
INSERT INTO `cmf_district` VALUES ('692', '76', '0', '从化市', '3');
INSERT INTO `cmf_district` VALUES ('693', '76', '0', '天河区', '3');
INSERT INTO `cmf_district` VALUES ('694', '76', '0', '东山区', '3');
INSERT INTO `cmf_district` VALUES ('695', '76', '0', '白云区', '3');
INSERT INTO `cmf_district` VALUES ('696', '76', '0', '海珠区', '3');
INSERT INTO `cmf_district` VALUES ('697', '76', '0', '荔湾区', '3');
INSERT INTO `cmf_district` VALUES ('698', '76', '0', '越秀区', '3');
INSERT INTO `cmf_district` VALUES ('699', '76', '0', '黄埔区', '3');
INSERT INTO `cmf_district` VALUES ('700', '76', '0', '番禺区', '3');
INSERT INTO `cmf_district` VALUES ('701', '76', '0', '花都区', '3');
INSERT INTO `cmf_district` VALUES ('702', '76', '0', '增城区', '3');
INSERT INTO `cmf_district` VALUES ('703', '76', '0', '从化区', '3');
INSERT INTO `cmf_district` VALUES ('704', '76', '0', '市郊', '3');
INSERT INTO `cmf_district` VALUES ('705', '77', '0', '福田区', '3');
INSERT INTO `cmf_district` VALUES ('706', '77', '0', '罗湖区', '3');
INSERT INTO `cmf_district` VALUES ('707', '77', '0', '南山区', '3');
INSERT INTO `cmf_district` VALUES ('708', '77', '0', '宝安区', '3');
INSERT INTO `cmf_district` VALUES ('709', '77', '0', '龙岗区', '3');
INSERT INTO `cmf_district` VALUES ('710', '77', '0', '盐田区', '3');
INSERT INTO `cmf_district` VALUES ('711', '78', '0', '湘桥区', '3');
INSERT INTO `cmf_district` VALUES ('712', '78', '0', '潮安县', '3');
INSERT INTO `cmf_district` VALUES ('713', '78', '0', '饶平县', '3');
INSERT INTO `cmf_district` VALUES ('714', '79', '0', '南城区', '3');
INSERT INTO `cmf_district` VALUES ('715', '79', '0', '东城区', '3');
INSERT INTO `cmf_district` VALUES ('716', '79', '0', '万江区', '3');
INSERT INTO `cmf_district` VALUES ('717', '79', '0', '莞城区', '3');
INSERT INTO `cmf_district` VALUES ('718', '79', '0', '石龙镇', '3');
INSERT INTO `cmf_district` VALUES ('719', '79', '0', '虎门镇', '3');
INSERT INTO `cmf_district` VALUES ('720', '79', '0', '麻涌镇', '3');
INSERT INTO `cmf_district` VALUES ('721', '79', '0', '道滘镇', '3');
INSERT INTO `cmf_district` VALUES ('722', '79', '0', '石碣镇', '3');
INSERT INTO `cmf_district` VALUES ('723', '79', '0', '沙田镇', '3');
INSERT INTO `cmf_district` VALUES ('724', '79', '0', '望牛墩镇', '3');
INSERT INTO `cmf_district` VALUES ('725', '79', '0', '洪梅镇', '3');
INSERT INTO `cmf_district` VALUES ('726', '79', '0', '茶山镇', '3');
INSERT INTO `cmf_district` VALUES ('727', '79', '0', '寮步镇', '3');
INSERT INTO `cmf_district` VALUES ('728', '79', '0', '大岭山镇', '3');
INSERT INTO `cmf_district` VALUES ('729', '79', '0', '大朗镇', '3');
INSERT INTO `cmf_district` VALUES ('730', '79', '0', '黄江镇', '3');
INSERT INTO `cmf_district` VALUES ('731', '79', '0', '樟木头', '3');
INSERT INTO `cmf_district` VALUES ('732', '79', '0', '凤岗镇', '3');
INSERT INTO `cmf_district` VALUES ('733', '79', '0', '塘厦镇', '3');
INSERT INTO `cmf_district` VALUES ('734', '79', '0', '谢岗镇', '3');
INSERT INTO `cmf_district` VALUES ('735', '79', '0', '厚街镇', '3');
INSERT INTO `cmf_district` VALUES ('736', '79', '0', '清溪镇', '3');
INSERT INTO `cmf_district` VALUES ('737', '79', '0', '常平镇', '3');
INSERT INTO `cmf_district` VALUES ('738', '79', '0', '桥头镇', '3');
INSERT INTO `cmf_district` VALUES ('739', '79', '0', '横沥镇', '3');
INSERT INTO `cmf_district` VALUES ('740', '79', '0', '东坑镇', '3');
INSERT INTO `cmf_district` VALUES ('741', '79', '0', '企石镇', '3');
INSERT INTO `cmf_district` VALUES ('742', '79', '0', '石排镇', '3');
INSERT INTO `cmf_district` VALUES ('743', '79', '0', '长安镇', '3');
INSERT INTO `cmf_district` VALUES ('744', '79', '0', '中堂镇', '3');
INSERT INTO `cmf_district` VALUES ('745', '79', '0', '高埗镇', '3');
INSERT INTO `cmf_district` VALUES ('746', '80', '0', '禅城区', '3');
INSERT INTO `cmf_district` VALUES ('747', '80', '0', '南海区', '3');
INSERT INTO `cmf_district` VALUES ('748', '80', '0', '顺德区', '3');
INSERT INTO `cmf_district` VALUES ('749', '80', '0', '三水区', '3');
INSERT INTO `cmf_district` VALUES ('750', '80', '0', '高明区', '3');
INSERT INTO `cmf_district` VALUES ('751', '81', '0', '东源县', '3');
INSERT INTO `cmf_district` VALUES ('752', '81', '0', '和平县', '3');
INSERT INTO `cmf_district` VALUES ('753', '81', '0', '源城区', '3');
INSERT INTO `cmf_district` VALUES ('754', '81', '0', '连平县', '3');
INSERT INTO `cmf_district` VALUES ('755', '81', '0', '龙川县', '3');
INSERT INTO `cmf_district` VALUES ('756', '81', '0', '紫金县', '3');
INSERT INTO `cmf_district` VALUES ('757', '82', '0', '惠阳区', '3');
INSERT INTO `cmf_district` VALUES ('758', '82', '0', '惠城区', '3');
INSERT INTO `cmf_district` VALUES ('759', '82', '0', '大亚湾', '3');
INSERT INTO `cmf_district` VALUES ('760', '82', '0', '博罗县', '3');
INSERT INTO `cmf_district` VALUES ('761', '82', '0', '惠东县', '3');
INSERT INTO `cmf_district` VALUES ('762', '82', '0', '龙门县', '3');
INSERT INTO `cmf_district` VALUES ('763', '83', '0', '江海区', '3');
INSERT INTO `cmf_district` VALUES ('764', '83', '0', '蓬江区', '3');
INSERT INTO `cmf_district` VALUES ('765', '83', '0', '新会区', '3');
INSERT INTO `cmf_district` VALUES ('766', '83', '0', '台山市', '3');
INSERT INTO `cmf_district` VALUES ('767', '83', '0', '开平市', '3');
INSERT INTO `cmf_district` VALUES ('768', '83', '0', '鹤山市', '3');
INSERT INTO `cmf_district` VALUES ('769', '83', '0', '恩平市', '3');
INSERT INTO `cmf_district` VALUES ('770', '84', '0', '榕城区', '3');
INSERT INTO `cmf_district` VALUES ('771', '84', '0', '普宁市', '3');
INSERT INTO `cmf_district` VALUES ('772', '84', '0', '揭东县', '3');
INSERT INTO `cmf_district` VALUES ('773', '84', '0', '揭西县', '3');
INSERT INTO `cmf_district` VALUES ('774', '84', '0', '惠来县', '3');
INSERT INTO `cmf_district` VALUES ('775', '85', '0', '茂南区', '3');
INSERT INTO `cmf_district` VALUES ('776', '85', '0', '茂港区', '3');
INSERT INTO `cmf_district` VALUES ('777', '85', '0', '高州市', '3');
INSERT INTO `cmf_district` VALUES ('778', '85', '0', '化州市', '3');
INSERT INTO `cmf_district` VALUES ('779', '85', '0', '信宜市', '3');
INSERT INTO `cmf_district` VALUES ('780', '85', '0', '电白县', '3');
INSERT INTO `cmf_district` VALUES ('781', '86', '0', '梅县', '3');
INSERT INTO `cmf_district` VALUES ('782', '86', '0', '梅江区', '3');
INSERT INTO `cmf_district` VALUES ('783', '86', '0', '兴宁市', '3');
INSERT INTO `cmf_district` VALUES ('784', '86', '0', '大埔县', '3');
INSERT INTO `cmf_district` VALUES ('785', '86', '0', '丰顺县', '3');
INSERT INTO `cmf_district` VALUES ('786', '86', '0', '五华县', '3');
INSERT INTO `cmf_district` VALUES ('787', '86', '0', '平远县', '3');
INSERT INTO `cmf_district` VALUES ('788', '86', '0', '蕉岭县', '3');
INSERT INTO `cmf_district` VALUES ('789', '87', '0', '清城区', '3');
INSERT INTO `cmf_district` VALUES ('790', '87', '0', '英德市', '3');
INSERT INTO `cmf_district` VALUES ('791', '87', '0', '连州市', '3');
INSERT INTO `cmf_district` VALUES ('792', '87', '0', '佛冈县', '3');
INSERT INTO `cmf_district` VALUES ('793', '87', '0', '阳山县', '3');
INSERT INTO `cmf_district` VALUES ('794', '87', '0', '清新县', '3');
INSERT INTO `cmf_district` VALUES ('795', '87', '0', '连山', '3');
INSERT INTO `cmf_district` VALUES ('796', '87', '0', '连南', '3');
INSERT INTO `cmf_district` VALUES ('797', '88', '0', '南澳县', '3');
INSERT INTO `cmf_district` VALUES ('798', '88', '0', '潮阳区', '3');
INSERT INTO `cmf_district` VALUES ('799', '88', '0', '澄海区', '3');
INSERT INTO `cmf_district` VALUES ('800', '88', '0', '龙湖区', '3');
INSERT INTO `cmf_district` VALUES ('801', '88', '0', '金平区', '3');
INSERT INTO `cmf_district` VALUES ('802', '88', '0', '濠江区', '3');
INSERT INTO `cmf_district` VALUES ('803', '88', '0', '潮南区', '3');
INSERT INTO `cmf_district` VALUES ('804', '89', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('805', '89', '0', '陆丰市', '3');
INSERT INTO `cmf_district` VALUES ('806', '89', '0', '海丰县', '3');
INSERT INTO `cmf_district` VALUES ('807', '89', '0', '陆河县', '3');
INSERT INTO `cmf_district` VALUES ('808', '90', '0', '曲江县', '3');
INSERT INTO `cmf_district` VALUES ('809', '90', '0', '浈江区', '3');
INSERT INTO `cmf_district` VALUES ('810', '90', '0', '武江区', '3');
INSERT INTO `cmf_district` VALUES ('811', '90', '0', '曲江区', '3');
INSERT INTO `cmf_district` VALUES ('812', '90', '0', '乐昌市', '3');
INSERT INTO `cmf_district` VALUES ('813', '90', '0', '南雄市', '3');
INSERT INTO `cmf_district` VALUES ('814', '90', '0', '始兴县', '3');
INSERT INTO `cmf_district` VALUES ('815', '90', '0', '仁化县', '3');
INSERT INTO `cmf_district` VALUES ('816', '90', '0', '翁源县', '3');
INSERT INTO `cmf_district` VALUES ('817', '90', '0', '新丰县', '3');
INSERT INTO `cmf_district` VALUES ('818', '90', '0', '乳源', '3');
INSERT INTO `cmf_district` VALUES ('819', '91', '0', '江城区', '3');
INSERT INTO `cmf_district` VALUES ('820', '91', '0', '阳春市', '3');
INSERT INTO `cmf_district` VALUES ('821', '91', '0', '阳西县', '3');
INSERT INTO `cmf_district` VALUES ('822', '91', '0', '阳东县', '3');
INSERT INTO `cmf_district` VALUES ('823', '92', '0', '云城区', '3');
INSERT INTO `cmf_district` VALUES ('824', '92', '0', '罗定市', '3');
INSERT INTO `cmf_district` VALUES ('825', '92', '0', '新兴县', '3');
INSERT INTO `cmf_district` VALUES ('826', '92', '0', '郁南县', '3');
INSERT INTO `cmf_district` VALUES ('827', '92', '0', '云安县', '3');
INSERT INTO `cmf_district` VALUES ('828', '93', '0', '赤坎区', '3');
INSERT INTO `cmf_district` VALUES ('829', '93', '0', '霞山区', '3');
INSERT INTO `cmf_district` VALUES ('830', '93', '0', '坡头区', '3');
INSERT INTO `cmf_district` VALUES ('831', '93', '0', '麻章区', '3');
INSERT INTO `cmf_district` VALUES ('832', '93', '0', '廉江市', '3');
INSERT INTO `cmf_district` VALUES ('833', '93', '0', '雷州市', '3');
INSERT INTO `cmf_district` VALUES ('834', '93', '0', '吴川市', '3');
INSERT INTO `cmf_district` VALUES ('835', '93', '0', '遂溪县', '3');
INSERT INTO `cmf_district` VALUES ('836', '93', '0', '徐闻县', '3');
INSERT INTO `cmf_district` VALUES ('837', '94', '0', '肇庆市', '3');
INSERT INTO `cmf_district` VALUES ('838', '94', '0', '高要市', '3');
INSERT INTO `cmf_district` VALUES ('839', '94', '0', '四会市', '3');
INSERT INTO `cmf_district` VALUES ('840', '94', '0', '广宁县', '3');
INSERT INTO `cmf_district` VALUES ('841', '94', '0', '怀集县', '3');
INSERT INTO `cmf_district` VALUES ('842', '94', '0', '封开县', '3');
INSERT INTO `cmf_district` VALUES ('843', '94', '0', '德庆县', '3');
INSERT INTO `cmf_district` VALUES ('844', '95', '0', '石岐街道', '3');
INSERT INTO `cmf_district` VALUES ('845', '95', '0', '东区街道', '3');
INSERT INTO `cmf_district` VALUES ('846', '95', '0', '西区街道', '3');
INSERT INTO `cmf_district` VALUES ('847', '95', '0', '环城街道', '3');
INSERT INTO `cmf_district` VALUES ('848', '95', '0', '中山港街道', '3');
INSERT INTO `cmf_district` VALUES ('849', '95', '0', '五桂山街道', '3');
INSERT INTO `cmf_district` VALUES ('850', '96', '0', '香洲区', '3');
INSERT INTO `cmf_district` VALUES ('851', '96', '0', '斗门区', '3');
INSERT INTO `cmf_district` VALUES ('852', '96', '0', '金湾区', '3');
INSERT INTO `cmf_district` VALUES ('853', '97', '0', '邕宁区', '3');
INSERT INTO `cmf_district` VALUES ('854', '97', '0', '青秀区', '3');
INSERT INTO `cmf_district` VALUES ('855', '97', '0', '兴宁区', '3');
INSERT INTO `cmf_district` VALUES ('856', '97', '0', '良庆区', '3');
INSERT INTO `cmf_district` VALUES ('857', '97', '0', '西乡塘区', '3');
INSERT INTO `cmf_district` VALUES ('858', '97', '0', '江南区', '3');
INSERT INTO `cmf_district` VALUES ('859', '97', '0', '武鸣县', '3');
INSERT INTO `cmf_district` VALUES ('860', '97', '0', '隆安县', '3');
INSERT INTO `cmf_district` VALUES ('861', '97', '0', '马山县', '3');
INSERT INTO `cmf_district` VALUES ('862', '97', '0', '上林县', '3');
INSERT INTO `cmf_district` VALUES ('863', '97', '0', '宾阳县', '3');
INSERT INTO `cmf_district` VALUES ('864', '97', '0', '横县', '3');
INSERT INTO `cmf_district` VALUES ('865', '98', '0', '秀峰区', '3');
INSERT INTO `cmf_district` VALUES ('866', '98', '0', '叠彩区', '3');
INSERT INTO `cmf_district` VALUES ('867', '98', '0', '象山区', '3');
INSERT INTO `cmf_district` VALUES ('868', '98', '0', '七星区', '3');
INSERT INTO `cmf_district` VALUES ('869', '98', '0', '雁山区', '3');
INSERT INTO `cmf_district` VALUES ('870', '98', '0', '阳朔县', '3');
INSERT INTO `cmf_district` VALUES ('871', '98', '0', '临桂县', '3');
INSERT INTO `cmf_district` VALUES ('872', '98', '0', '灵川县', '3');
INSERT INTO `cmf_district` VALUES ('873', '98', '0', '全州县', '3');
INSERT INTO `cmf_district` VALUES ('874', '98', '0', '平乐县', '3');
INSERT INTO `cmf_district` VALUES ('875', '98', '0', '兴安县', '3');
INSERT INTO `cmf_district` VALUES ('876', '98', '0', '灌阳县', '3');
INSERT INTO `cmf_district` VALUES ('877', '98', '0', '荔浦县', '3');
INSERT INTO `cmf_district` VALUES ('878', '98', '0', '资源县', '3');
INSERT INTO `cmf_district` VALUES ('879', '98', '0', '永福县', '3');
INSERT INTO `cmf_district` VALUES ('880', '98', '0', '龙胜', '3');
INSERT INTO `cmf_district` VALUES ('881', '98', '0', '恭城', '3');
INSERT INTO `cmf_district` VALUES ('882', '99', '0', '右江区', '3');
INSERT INTO `cmf_district` VALUES ('883', '99', '0', '凌云县', '3');
INSERT INTO `cmf_district` VALUES ('884', '99', '0', '平果县', '3');
INSERT INTO `cmf_district` VALUES ('885', '99', '0', '西林县', '3');
INSERT INTO `cmf_district` VALUES ('886', '99', '0', '乐业县', '3');
INSERT INTO `cmf_district` VALUES ('887', '99', '0', '德保县', '3');
INSERT INTO `cmf_district` VALUES ('888', '99', '0', '田林县', '3');
INSERT INTO `cmf_district` VALUES ('889', '99', '0', '田阳县', '3');
INSERT INTO `cmf_district` VALUES ('890', '99', '0', '靖西县', '3');
INSERT INTO `cmf_district` VALUES ('891', '99', '0', '田东县', '3');
INSERT INTO `cmf_district` VALUES ('892', '99', '0', '那坡县', '3');
INSERT INTO `cmf_district` VALUES ('893', '99', '0', '隆林', '3');
INSERT INTO `cmf_district` VALUES ('894', '100', '0', '海城区', '3');
INSERT INTO `cmf_district` VALUES ('895', '100', '0', '银海区', '3');
INSERT INTO `cmf_district` VALUES ('896', '100', '0', '铁山港区', '3');
INSERT INTO `cmf_district` VALUES ('897', '100', '0', '合浦县', '3');
INSERT INTO `cmf_district` VALUES ('898', '101', '0', '江州区', '3');
INSERT INTO `cmf_district` VALUES ('899', '101', '0', '凭祥市', '3');
INSERT INTO `cmf_district` VALUES ('900', '101', '0', '宁明县', '3');
INSERT INTO `cmf_district` VALUES ('901', '101', '0', '扶绥县', '3');
INSERT INTO `cmf_district` VALUES ('902', '101', '0', '龙州县', '3');
INSERT INTO `cmf_district` VALUES ('903', '101', '0', '大新县', '3');
INSERT INTO `cmf_district` VALUES ('904', '101', '0', '天等县', '3');
INSERT INTO `cmf_district` VALUES ('905', '102', '0', '港口区', '3');
INSERT INTO `cmf_district` VALUES ('906', '102', '0', '防城区', '3');
INSERT INTO `cmf_district` VALUES ('907', '102', '0', '东兴市', '3');
INSERT INTO `cmf_district` VALUES ('908', '102', '0', '上思县', '3');
INSERT INTO `cmf_district` VALUES ('909', '103', '0', '港北区', '3');
INSERT INTO `cmf_district` VALUES ('910', '103', '0', '港南区', '3');
INSERT INTO `cmf_district` VALUES ('911', '103', '0', '覃塘区', '3');
INSERT INTO `cmf_district` VALUES ('912', '103', '0', '桂平市', '3');
INSERT INTO `cmf_district` VALUES ('913', '103', '0', '平南县', '3');
INSERT INTO `cmf_district` VALUES ('914', '104', '0', '金城江区', '3');
INSERT INTO `cmf_district` VALUES ('915', '104', '0', '宜州市', '3');
INSERT INTO `cmf_district` VALUES ('916', '104', '0', '天峨县', '3');
INSERT INTO `cmf_district` VALUES ('917', '104', '0', '凤山县', '3');
INSERT INTO `cmf_district` VALUES ('918', '104', '0', '南丹县', '3');
INSERT INTO `cmf_district` VALUES ('919', '104', '0', '东兰县', '3');
INSERT INTO `cmf_district` VALUES ('920', '104', '0', '都安', '3');
INSERT INTO `cmf_district` VALUES ('921', '104', '0', '罗城', '3');
INSERT INTO `cmf_district` VALUES ('922', '104', '0', '巴马', '3');
INSERT INTO `cmf_district` VALUES ('923', '104', '0', '环江', '3');
INSERT INTO `cmf_district` VALUES ('924', '104', '0', '大化', '3');
INSERT INTO `cmf_district` VALUES ('925', '105', '0', '八步区', '3');
INSERT INTO `cmf_district` VALUES ('926', '105', '0', '钟山县', '3');
INSERT INTO `cmf_district` VALUES ('927', '105', '0', '昭平县', '3');
INSERT INTO `cmf_district` VALUES ('928', '105', '0', '富川', '3');
INSERT INTO `cmf_district` VALUES ('929', '106', '0', '兴宾区', '3');
INSERT INTO `cmf_district` VALUES ('930', '106', '0', '合山市', '3');
INSERT INTO `cmf_district` VALUES ('931', '106', '0', '象州县', '3');
INSERT INTO `cmf_district` VALUES ('932', '106', '0', '武宣县', '3');
INSERT INTO `cmf_district` VALUES ('933', '106', '0', '忻城县', '3');
INSERT INTO `cmf_district` VALUES ('934', '106', '0', '金秀', '3');
INSERT INTO `cmf_district` VALUES ('935', '107', '0', '城中区', '3');
INSERT INTO `cmf_district` VALUES ('936', '107', '0', '鱼峰区', '3');
INSERT INTO `cmf_district` VALUES ('937', '107', '0', '柳北区', '3');
INSERT INTO `cmf_district` VALUES ('938', '107', '0', '柳南区', '3');
INSERT INTO `cmf_district` VALUES ('939', '107', '0', '柳江县', '3');
INSERT INTO `cmf_district` VALUES ('940', '107', '0', '柳城县', '3');
INSERT INTO `cmf_district` VALUES ('941', '107', '0', '鹿寨县', '3');
INSERT INTO `cmf_district` VALUES ('942', '107', '0', '融安县', '3');
INSERT INTO `cmf_district` VALUES ('943', '107', '0', '融水', '3');
INSERT INTO `cmf_district` VALUES ('944', '107', '0', '三江', '3');
INSERT INTO `cmf_district` VALUES ('945', '108', '0', '钦南区', '3');
INSERT INTO `cmf_district` VALUES ('946', '108', '0', '钦北区', '3');
INSERT INTO `cmf_district` VALUES ('947', '108', '0', '灵山县', '3');
INSERT INTO `cmf_district` VALUES ('948', '108', '0', '浦北县', '3');
INSERT INTO `cmf_district` VALUES ('949', '109', '0', '万秀区', '3');
INSERT INTO `cmf_district` VALUES ('950', '109', '0', '蝶山区', '3');
INSERT INTO `cmf_district` VALUES ('951', '109', '0', '长洲区', '3');
INSERT INTO `cmf_district` VALUES ('952', '109', '0', '岑溪市', '3');
INSERT INTO `cmf_district` VALUES ('953', '109', '0', '苍梧县', '3');
INSERT INTO `cmf_district` VALUES ('954', '109', '0', '藤县', '3');
INSERT INTO `cmf_district` VALUES ('955', '109', '0', '蒙山县', '3');
INSERT INTO `cmf_district` VALUES ('956', '110', '0', '玉州区', '3');
INSERT INTO `cmf_district` VALUES ('957', '110', '0', '北流市', '3');
INSERT INTO `cmf_district` VALUES ('958', '110', '0', '容县', '3');
INSERT INTO `cmf_district` VALUES ('959', '110', '0', '陆川县', '3');
INSERT INTO `cmf_district` VALUES ('960', '110', '0', '博白县', '3');
INSERT INTO `cmf_district` VALUES ('961', '110', '0', '兴业县', '3');
INSERT INTO `cmf_district` VALUES ('962', '111', '0', '南明区', '3');
INSERT INTO `cmf_district` VALUES ('963', '111', '0', '云岩区', '3');
INSERT INTO `cmf_district` VALUES ('964', '111', '0', '花溪区', '3');
INSERT INTO `cmf_district` VALUES ('965', '111', '0', '乌当区', '3');
INSERT INTO `cmf_district` VALUES ('966', '111', '0', '白云区', '3');
INSERT INTO `cmf_district` VALUES ('967', '111', '0', '小河区', '3');
INSERT INTO `cmf_district` VALUES ('968', '111', '0', '金阳新区', '3');
INSERT INTO `cmf_district` VALUES ('969', '111', '0', '新天园区', '3');
INSERT INTO `cmf_district` VALUES ('970', '111', '0', '清镇市', '3');
INSERT INTO `cmf_district` VALUES ('971', '111', '0', '开阳县', '3');
INSERT INTO `cmf_district` VALUES ('972', '111', '0', '修文县', '3');
INSERT INTO `cmf_district` VALUES ('973', '111', '0', '息烽县', '3');
INSERT INTO `cmf_district` VALUES ('974', '112', '0', '西秀区', '3');
INSERT INTO `cmf_district` VALUES ('975', '112', '0', '关岭', '3');
INSERT INTO `cmf_district` VALUES ('976', '112', '0', '镇宁', '3');
INSERT INTO `cmf_district` VALUES ('977', '112', '0', '紫云', '3');
INSERT INTO `cmf_district` VALUES ('978', '112', '0', '平坝县', '3');
INSERT INTO `cmf_district` VALUES ('979', '112', '0', '普定县', '3');
INSERT INTO `cmf_district` VALUES ('980', '113', '0', '毕节市', '3');
INSERT INTO `cmf_district` VALUES ('981', '113', '0', '大方县', '3');
INSERT INTO `cmf_district` VALUES ('982', '113', '0', '黔西县', '3');
INSERT INTO `cmf_district` VALUES ('983', '113', '0', '金沙县', '3');
INSERT INTO `cmf_district` VALUES ('984', '113', '0', '织金县', '3');
INSERT INTO `cmf_district` VALUES ('985', '113', '0', '纳雍县', '3');
INSERT INTO `cmf_district` VALUES ('986', '113', '0', '赫章县', '3');
INSERT INTO `cmf_district` VALUES ('987', '113', '0', '威宁', '3');
INSERT INTO `cmf_district` VALUES ('988', '114', '0', '钟山区', '3');
INSERT INTO `cmf_district` VALUES ('989', '114', '0', '六枝特区', '3');
INSERT INTO `cmf_district` VALUES ('990', '114', '0', '水城县', '3');
INSERT INTO `cmf_district` VALUES ('991', '114', '0', '盘县', '3');
INSERT INTO `cmf_district` VALUES ('992', '115', '0', '凯里市', '3');
INSERT INTO `cmf_district` VALUES ('993', '115', '0', '黄平县', '3');
INSERT INTO `cmf_district` VALUES ('994', '115', '0', '施秉县', '3');
INSERT INTO `cmf_district` VALUES ('995', '115', '0', '三穗县', '3');
INSERT INTO `cmf_district` VALUES ('996', '115', '0', '镇远县', '3');
INSERT INTO `cmf_district` VALUES ('997', '115', '0', '岑巩县', '3');
INSERT INTO `cmf_district` VALUES ('998', '115', '0', '天柱县', '3');
INSERT INTO `cmf_district` VALUES ('999', '115', '0', '锦屏县', '3');
INSERT INTO `cmf_district` VALUES ('1000', '115', '0', '剑河县', '3');
INSERT INTO `cmf_district` VALUES ('1001', '115', '0', '台江县', '3');
INSERT INTO `cmf_district` VALUES ('1002', '115', '0', '黎平县', '3');
INSERT INTO `cmf_district` VALUES ('1003', '115', '0', '榕江县', '3');
INSERT INTO `cmf_district` VALUES ('1004', '115', '0', '从江县', '3');
INSERT INTO `cmf_district` VALUES ('1005', '115', '0', '雷山县', '3');
INSERT INTO `cmf_district` VALUES ('1006', '115', '0', '麻江县', '3');
INSERT INTO `cmf_district` VALUES ('1007', '115', '0', '丹寨县', '3');
INSERT INTO `cmf_district` VALUES ('1008', '116', '0', '都匀市', '3');
INSERT INTO `cmf_district` VALUES ('1009', '116', '0', '福泉市', '3');
INSERT INTO `cmf_district` VALUES ('1010', '116', '0', '荔波县', '3');
INSERT INTO `cmf_district` VALUES ('1011', '116', '0', '贵定县', '3');
INSERT INTO `cmf_district` VALUES ('1012', '116', '0', '瓮安县', '3');
INSERT INTO `cmf_district` VALUES ('1013', '116', '0', '独山县', '3');
INSERT INTO `cmf_district` VALUES ('1014', '116', '0', '平塘县', '3');
INSERT INTO `cmf_district` VALUES ('1015', '116', '0', '罗甸县', '3');
INSERT INTO `cmf_district` VALUES ('1016', '116', '0', '长顺县', '3');
INSERT INTO `cmf_district` VALUES ('1017', '116', '0', '龙里县', '3');
INSERT INTO `cmf_district` VALUES ('1018', '116', '0', '惠水县', '3');
INSERT INTO `cmf_district` VALUES ('1019', '116', '0', '三都', '3');
INSERT INTO `cmf_district` VALUES ('1020', '117', '0', '兴义市', '3');
INSERT INTO `cmf_district` VALUES ('1021', '117', '0', '兴仁县', '3');
INSERT INTO `cmf_district` VALUES ('1022', '117', '0', '普安县', '3');
INSERT INTO `cmf_district` VALUES ('1023', '117', '0', '晴隆县', '3');
INSERT INTO `cmf_district` VALUES ('1024', '117', '0', '贞丰县', '3');
INSERT INTO `cmf_district` VALUES ('1025', '117', '0', '望谟县', '3');
INSERT INTO `cmf_district` VALUES ('1026', '117', '0', '册亨县', '3');
INSERT INTO `cmf_district` VALUES ('1027', '117', '0', '安龙县', '3');
INSERT INTO `cmf_district` VALUES ('1028', '118', '0', '铜仁市', '3');
INSERT INTO `cmf_district` VALUES ('1029', '118', '0', '江口县', '3');
INSERT INTO `cmf_district` VALUES ('1030', '118', '0', '石阡县', '3');
INSERT INTO `cmf_district` VALUES ('1031', '118', '0', '思南县', '3');
INSERT INTO `cmf_district` VALUES ('1032', '118', '0', '德江县', '3');
INSERT INTO `cmf_district` VALUES ('1033', '118', '0', '玉屏', '3');
INSERT INTO `cmf_district` VALUES ('1034', '118', '0', '印江', '3');
INSERT INTO `cmf_district` VALUES ('1035', '118', '0', '沿河', '3');
INSERT INTO `cmf_district` VALUES ('1036', '118', '0', '松桃', '3');
INSERT INTO `cmf_district` VALUES ('1037', '118', '0', '万山特区', '3');
INSERT INTO `cmf_district` VALUES ('1038', '119', '0', '红花岗区', '3');
INSERT INTO `cmf_district` VALUES ('1039', '119', '0', '务川县', '3');
INSERT INTO `cmf_district` VALUES ('1040', '119', '0', '道真县', '3');
INSERT INTO `cmf_district` VALUES ('1041', '119', '0', '汇川区', '3');
INSERT INTO `cmf_district` VALUES ('1042', '119', '0', '赤水市', '3');
INSERT INTO `cmf_district` VALUES ('1043', '119', '0', '仁怀市', '3');
INSERT INTO `cmf_district` VALUES ('1044', '119', '0', '遵义县', '3');
INSERT INTO `cmf_district` VALUES ('1045', '119', '0', '桐梓县', '3');
INSERT INTO `cmf_district` VALUES ('1046', '119', '0', '绥阳县', '3');
INSERT INTO `cmf_district` VALUES ('1047', '119', '0', '正安县', '3');
INSERT INTO `cmf_district` VALUES ('1048', '119', '0', '凤冈县', '3');
INSERT INTO `cmf_district` VALUES ('1049', '119', '0', '湄潭县', '3');
INSERT INTO `cmf_district` VALUES ('1050', '119', '0', '余庆县', '3');
INSERT INTO `cmf_district` VALUES ('1051', '119', '0', '习水县', '3');
INSERT INTO `cmf_district` VALUES ('1052', '119', '0', '道真', '3');
INSERT INTO `cmf_district` VALUES ('1053', '119', '0', '务川', '3');
INSERT INTO `cmf_district` VALUES ('1054', '120', '0', '秀英区', '3');
INSERT INTO `cmf_district` VALUES ('1055', '120', '0', '龙华区', '3');
INSERT INTO `cmf_district` VALUES ('1056', '120', '0', '琼山区', '3');
INSERT INTO `cmf_district` VALUES ('1057', '120', '0', '美兰区', '3');
INSERT INTO `cmf_district` VALUES ('1058', '137', '0', '市区', '3');
INSERT INTO `cmf_district` VALUES ('1059', '137', '0', '洋浦开发区', '3');
INSERT INTO `cmf_district` VALUES ('1060', '137', '0', '那大镇', '3');
INSERT INTO `cmf_district` VALUES ('1061', '137', '0', '王五镇', '3');
INSERT INTO `cmf_district` VALUES ('1062', '137', '0', '雅星镇', '3');
INSERT INTO `cmf_district` VALUES ('1063', '137', '0', '大成镇', '3');
INSERT INTO `cmf_district` VALUES ('1064', '137', '0', '中和镇', '3');
INSERT INTO `cmf_district` VALUES ('1065', '137', '0', '峨蔓镇', '3');
INSERT INTO `cmf_district` VALUES ('1066', '137', '0', '南丰镇', '3');
INSERT INTO `cmf_district` VALUES ('1067', '137', '0', '白马井镇', '3');
INSERT INTO `cmf_district` VALUES ('1068', '137', '0', '兰洋镇', '3');
INSERT INTO `cmf_district` VALUES ('1069', '137', '0', '和庆镇', '3');
INSERT INTO `cmf_district` VALUES ('1070', '137', '0', '海头镇', '3');
INSERT INTO `cmf_district` VALUES ('1071', '137', '0', '排浦镇', '3');
INSERT INTO `cmf_district` VALUES ('1072', '137', '0', '东成镇', '3');
INSERT INTO `cmf_district` VALUES ('1073', '137', '0', '光村镇', '3');
INSERT INTO `cmf_district` VALUES ('1074', '137', '0', '木棠镇', '3');
INSERT INTO `cmf_district` VALUES ('1075', '137', '0', '新州镇', '3');
INSERT INTO `cmf_district` VALUES ('1076', '137', '0', '三都镇', '3');
INSERT INTO `cmf_district` VALUES ('1077', '137', '0', '其他', '3');
INSERT INTO `cmf_district` VALUES ('1078', '138', '0', '长安区', '3');
INSERT INTO `cmf_district` VALUES ('1079', '138', '0', '桥东区', '3');
INSERT INTO `cmf_district` VALUES ('1080', '138', '0', '桥西区', '3');
INSERT INTO `cmf_district` VALUES ('1081', '138', '0', '新华区', '3');
INSERT INTO `cmf_district` VALUES ('1082', '138', '0', '裕华区', '3');
INSERT INTO `cmf_district` VALUES ('1083', '138', '0', '井陉矿区', '3');
INSERT INTO `cmf_district` VALUES ('1084', '138', '0', '高新区', '3');
INSERT INTO `cmf_district` VALUES ('1085', '138', '0', '辛集市', '3');
INSERT INTO `cmf_district` VALUES ('1086', '138', '0', '藁城市', '3');
INSERT INTO `cmf_district` VALUES ('1087', '138', '0', '晋州市', '3');
INSERT INTO `cmf_district` VALUES ('1088', '138', '0', '新乐市', '3');
INSERT INTO `cmf_district` VALUES ('1089', '138', '0', '鹿泉市', '3');
INSERT INTO `cmf_district` VALUES ('1090', '138', '0', '井陉县', '3');
INSERT INTO `cmf_district` VALUES ('1091', '138', '0', '正定县', '3');
INSERT INTO `cmf_district` VALUES ('1092', '138', '0', '栾城县', '3');
INSERT INTO `cmf_district` VALUES ('1093', '138', '0', '行唐县', '3');
INSERT INTO `cmf_district` VALUES ('1094', '138', '0', '灵寿县', '3');
INSERT INTO `cmf_district` VALUES ('1095', '138', '0', '高邑县', '3');
INSERT INTO `cmf_district` VALUES ('1096', '138', '0', '深泽县', '3');
INSERT INTO `cmf_district` VALUES ('1097', '138', '0', '赞皇县', '3');
INSERT INTO `cmf_district` VALUES ('1098', '138', '0', '无极县', '3');
INSERT INTO `cmf_district` VALUES ('1099', '138', '0', '平山县', '3');
INSERT INTO `cmf_district` VALUES ('1100', '138', '0', '元氏县', '3');
INSERT INTO `cmf_district` VALUES ('1101', '138', '0', '赵县', '3');
INSERT INTO `cmf_district` VALUES ('1102', '139', '0', '新市区', '3');
INSERT INTO `cmf_district` VALUES ('1103', '139', '0', '南市区', '3');
INSERT INTO `cmf_district` VALUES ('1104', '139', '0', '北市区', '3');
INSERT INTO `cmf_district` VALUES ('1105', '139', '0', '涿州市', '3');
INSERT INTO `cmf_district` VALUES ('1106', '139', '0', '定州市', '3');
INSERT INTO `cmf_district` VALUES ('1107', '139', '0', '安国市', '3');
INSERT INTO `cmf_district` VALUES ('1108', '139', '0', '高碑店市', '3');
INSERT INTO `cmf_district` VALUES ('1109', '139', '0', '满城县', '3');
INSERT INTO `cmf_district` VALUES ('1110', '139', '0', '清苑县', '3');
INSERT INTO `cmf_district` VALUES ('1111', '139', '0', '涞水县', '3');
INSERT INTO `cmf_district` VALUES ('1112', '139', '0', '阜平县', '3');
INSERT INTO `cmf_district` VALUES ('1113', '139', '0', '徐水县', '3');
INSERT INTO `cmf_district` VALUES ('1114', '139', '0', '定兴县', '3');
INSERT INTO `cmf_district` VALUES ('1115', '139', '0', '唐县', '3');
INSERT INTO `cmf_district` VALUES ('1116', '139', '0', '高阳县', '3');
INSERT INTO `cmf_district` VALUES ('1117', '139', '0', '容城县', '3');
INSERT INTO `cmf_district` VALUES ('1118', '139', '0', '涞源县', '3');
INSERT INTO `cmf_district` VALUES ('1119', '139', '0', '望都县', '3');
INSERT INTO `cmf_district` VALUES ('1120', '139', '0', '安新县', '3');
INSERT INTO `cmf_district` VALUES ('1121', '139', '0', '易县', '3');
INSERT INTO `cmf_district` VALUES ('1122', '139', '0', '曲阳县', '3');
INSERT INTO `cmf_district` VALUES ('1123', '139', '0', '蠡县', '3');
INSERT INTO `cmf_district` VALUES ('1124', '139', '0', '顺平县', '3');
INSERT INTO `cmf_district` VALUES ('1125', '139', '0', '博野县', '3');
INSERT INTO `cmf_district` VALUES ('1126', '139', '0', '雄县', '3');
INSERT INTO `cmf_district` VALUES ('1127', '140', '0', '运河区', '3');
INSERT INTO `cmf_district` VALUES ('1128', '140', '0', '新华区', '3');
INSERT INTO `cmf_district` VALUES ('1129', '140', '0', '泊头市', '3');
INSERT INTO `cmf_district` VALUES ('1130', '140', '0', '任丘市', '3');
INSERT INTO `cmf_district` VALUES ('1131', '140', '0', '黄骅市', '3');
INSERT INTO `cmf_district` VALUES ('1132', '140', '0', '河间市', '3');
INSERT INTO `cmf_district` VALUES ('1133', '140', '0', '沧县', '3');
INSERT INTO `cmf_district` VALUES ('1134', '140', '0', '青县', '3');
INSERT INTO `cmf_district` VALUES ('1135', '140', '0', '东光县', '3');
INSERT INTO `cmf_district` VALUES ('1136', '140', '0', '海兴县', '3');
INSERT INTO `cmf_district` VALUES ('1137', '140', '0', '盐山县', '3');
INSERT INTO `cmf_district` VALUES ('1138', '140', '0', '肃宁县', '3');
INSERT INTO `cmf_district` VALUES ('1139', '140', '0', '南皮县', '3');
INSERT INTO `cmf_district` VALUES ('1140', '140', '0', '吴桥县', '3');
INSERT INTO `cmf_district` VALUES ('1141', '140', '0', '献县', '3');
INSERT INTO `cmf_district` VALUES ('1142', '140', '0', '孟村', '3');
INSERT INTO `cmf_district` VALUES ('1143', '141', '0', '双桥区', '3');
INSERT INTO `cmf_district` VALUES ('1144', '141', '0', '双滦区', '3');
INSERT INTO `cmf_district` VALUES ('1145', '141', '0', '鹰手营子矿区', '3');
INSERT INTO `cmf_district` VALUES ('1146', '141', '0', '承德县', '3');
INSERT INTO `cmf_district` VALUES ('1147', '141', '0', '兴隆县', '3');
INSERT INTO `cmf_district` VALUES ('1148', '141', '0', '平泉县', '3');
INSERT INTO `cmf_district` VALUES ('1149', '141', '0', '滦平县', '3');
INSERT INTO `cmf_district` VALUES ('1150', '141', '0', '隆化县', '3');
INSERT INTO `cmf_district` VALUES ('1151', '141', '0', '丰宁', '3');
INSERT INTO `cmf_district` VALUES ('1152', '141', '0', '宽城', '3');
INSERT INTO `cmf_district` VALUES ('1153', '141', '0', '围场', '3');
INSERT INTO `cmf_district` VALUES ('1154', '142', '0', '从台区', '3');
INSERT INTO `cmf_district` VALUES ('1155', '142', '0', '复兴区', '3');
INSERT INTO `cmf_district` VALUES ('1156', '142', '0', '邯山区', '3');
INSERT INTO `cmf_district` VALUES ('1157', '142', '0', '峰峰矿区', '3');
INSERT INTO `cmf_district` VALUES ('1158', '142', '0', '武安市', '3');
INSERT INTO `cmf_district` VALUES ('1159', '142', '0', '邯郸县', '3');
INSERT INTO `cmf_district` VALUES ('1160', '142', '0', '临漳县', '3');
INSERT INTO `cmf_district` VALUES ('1161', '142', '0', '成安县', '3');
INSERT INTO `cmf_district` VALUES ('1162', '142', '0', '大名县', '3');
INSERT INTO `cmf_district` VALUES ('1163', '142', '0', '涉县', '3');
INSERT INTO `cmf_district` VALUES ('1164', '142', '0', '磁县', '3');
INSERT INTO `cmf_district` VALUES ('1165', '142', '0', '肥乡县', '3');
INSERT INTO `cmf_district` VALUES ('1166', '142', '0', '永年县', '3');
INSERT INTO `cmf_district` VALUES ('1167', '142', '0', '邱县', '3');
INSERT INTO `cmf_district` VALUES ('1168', '142', '0', '鸡泽县', '3');
INSERT INTO `cmf_district` VALUES ('1169', '142', '0', '广平县', '3');
INSERT INTO `cmf_district` VALUES ('1170', '142', '0', '馆陶县', '3');
INSERT INTO `cmf_district` VALUES ('1171', '142', '0', '魏县', '3');
INSERT INTO `cmf_district` VALUES ('1172', '142', '0', '曲周县', '3');
INSERT INTO `cmf_district` VALUES ('1173', '143', '0', '桃城区', '3');
INSERT INTO `cmf_district` VALUES ('1174', '143', '0', '冀州市', '3');
INSERT INTO `cmf_district` VALUES ('1175', '143', '0', '深州市', '3');
INSERT INTO `cmf_district` VALUES ('1176', '143', '0', '枣强县', '3');
INSERT INTO `cmf_district` VALUES ('1177', '143', '0', '武邑县', '3');
INSERT INTO `cmf_district` VALUES ('1178', '143', '0', '武强县', '3');
INSERT INTO `cmf_district` VALUES ('1179', '143', '0', '饶阳县', '3');
INSERT INTO `cmf_district` VALUES ('1180', '143', '0', '安平县', '3');
INSERT INTO `cmf_district` VALUES ('1181', '143', '0', '故城县', '3');
INSERT INTO `cmf_district` VALUES ('1182', '143', '0', '景县', '3');
INSERT INTO `cmf_district` VALUES ('1183', '143', '0', '阜城县', '3');
INSERT INTO `cmf_district` VALUES ('1184', '144', '0', '安次区', '3');
INSERT INTO `cmf_district` VALUES ('1185', '144', '0', '广阳区', '3');
INSERT INTO `cmf_district` VALUES ('1186', '144', '0', '霸州市', '3');
INSERT INTO `cmf_district` VALUES ('1187', '144', '0', '三河市', '3');
INSERT INTO `cmf_district` VALUES ('1188', '144', '0', '固安县', '3');
INSERT INTO `cmf_district` VALUES ('1189', '144', '0', '永清县', '3');
INSERT INTO `cmf_district` VALUES ('1190', '144', '0', '香河县', '3');
INSERT INTO `cmf_district` VALUES ('1191', '144', '0', '大城县', '3');
INSERT INTO `cmf_district` VALUES ('1192', '144', '0', '文安县', '3');
INSERT INTO `cmf_district` VALUES ('1193', '144', '0', '大厂', '3');
INSERT INTO `cmf_district` VALUES ('1194', '145', '0', '海港区', '3');
INSERT INTO `cmf_district` VALUES ('1195', '145', '0', '山海关区', '3');
INSERT INTO `cmf_district` VALUES ('1196', '145', '0', '北戴河区', '3');
INSERT INTO `cmf_district` VALUES ('1197', '145', '0', '昌黎县', '3');
INSERT INTO `cmf_district` VALUES ('1198', '145', '0', '抚宁县', '3');
INSERT INTO `cmf_district` VALUES ('1199', '145', '0', '卢龙县', '3');
INSERT INTO `cmf_district` VALUES ('1200', '145', '0', '青龙', '3');
INSERT INTO `cmf_district` VALUES ('1201', '146', '0', '路北区', '3');
INSERT INTO `cmf_district` VALUES ('1202', '146', '0', '路南区', '3');
INSERT INTO `cmf_district` VALUES ('1203', '146', '0', '古冶区', '3');
INSERT INTO `cmf_district` VALUES ('1204', '146', '0', '开平区', '3');
INSERT INTO `cmf_district` VALUES ('1205', '146', '0', '丰南区', '3');
INSERT INTO `cmf_district` VALUES ('1206', '146', '0', '丰润区', '3');
INSERT INTO `cmf_district` VALUES ('1207', '146', '0', '遵化市', '3');
INSERT INTO `cmf_district` VALUES ('1208', '146', '0', '迁安市', '3');
INSERT INTO `cmf_district` VALUES ('1209', '146', '0', '滦县', '3');
INSERT INTO `cmf_district` VALUES ('1210', '146', '0', '滦南县', '3');
INSERT INTO `cmf_district` VALUES ('1211', '146', '0', '乐亭县', '3');
INSERT INTO `cmf_district` VALUES ('1212', '146', '0', '迁西县', '3');
INSERT INTO `cmf_district` VALUES ('1213', '146', '0', '玉田县', '3');
INSERT INTO `cmf_district` VALUES ('1214', '146', '0', '唐海县', '3');
INSERT INTO `cmf_district` VALUES ('1215', '147', '0', '桥东区', '3');
INSERT INTO `cmf_district` VALUES ('1216', '147', '0', '桥西区', '3');
INSERT INTO `cmf_district` VALUES ('1217', '147', '0', '南宫市', '3');
INSERT INTO `cmf_district` VALUES ('1218', '147', '0', '沙河市', '3');
INSERT INTO `cmf_district` VALUES ('1219', '147', '0', '邢台县', '3');
INSERT INTO `cmf_district` VALUES ('1220', '147', '0', '临城县', '3');
INSERT INTO `cmf_district` VALUES ('1221', '147', '0', '内丘县', '3');
INSERT INTO `cmf_district` VALUES ('1222', '147', '0', '柏乡县', '3');
INSERT INTO `cmf_district` VALUES ('1223', '147', '0', '隆尧县', '3');
INSERT INTO `cmf_district` VALUES ('1224', '147', '0', '任县', '3');
INSERT INTO `cmf_district` VALUES ('1225', '147', '0', '南和县', '3');
INSERT INTO `cmf_district` VALUES ('1226', '147', '0', '宁晋县', '3');
INSERT INTO `cmf_district` VALUES ('1227', '147', '0', '巨鹿县', '3');
INSERT INTO `cmf_district` VALUES ('1228', '147', '0', '新河县', '3');
INSERT INTO `cmf_district` VALUES ('1229', '147', '0', '广宗县', '3');
INSERT INTO `cmf_district` VALUES ('1230', '147', '0', '平乡县', '3');
INSERT INTO `cmf_district` VALUES ('1231', '147', '0', '威县', '3');
INSERT INTO `cmf_district` VALUES ('1232', '147', '0', '清河县', '3');
INSERT INTO `cmf_district` VALUES ('1233', '147', '0', '临西县', '3');
INSERT INTO `cmf_district` VALUES ('1234', '148', '0', '桥西区', '3');
INSERT INTO `cmf_district` VALUES ('1235', '148', '0', '桥东区', '3');
INSERT INTO `cmf_district` VALUES ('1236', '148', '0', '宣化区', '3');
INSERT INTO `cmf_district` VALUES ('1237', '148', '0', '下花园区', '3');
INSERT INTO `cmf_district` VALUES ('1238', '148', '0', '宣化县', '3');
INSERT INTO `cmf_district` VALUES ('1239', '148', '0', '张北县', '3');
INSERT INTO `cmf_district` VALUES ('1240', '148', '0', '康保县', '3');
INSERT INTO `cmf_district` VALUES ('1241', '148', '0', '沽源县', '3');
INSERT INTO `cmf_district` VALUES ('1242', '148', '0', '尚义县', '3');
INSERT INTO `cmf_district` VALUES ('1243', '148', '0', '蔚县', '3');
INSERT INTO `cmf_district` VALUES ('1244', '148', '0', '阳原县', '3');
INSERT INTO `cmf_district` VALUES ('1245', '148', '0', '怀安县', '3');
INSERT INTO `cmf_district` VALUES ('1246', '148', '0', '万全县', '3');
INSERT INTO `cmf_district` VALUES ('1247', '148', '0', '怀来县', '3');
INSERT INTO `cmf_district` VALUES ('1248', '148', '0', '涿鹿县', '3');
INSERT INTO `cmf_district` VALUES ('1249', '148', '0', '赤城县', '3');
INSERT INTO `cmf_district` VALUES ('1250', '148', '0', '崇礼县', '3');
INSERT INTO `cmf_district` VALUES ('1251', '149', '0', '金水区', '3');
INSERT INTO `cmf_district` VALUES ('1252', '149', '0', '邙山区', '3');
INSERT INTO `cmf_district` VALUES ('1253', '149', '0', '二七区', '3');
INSERT INTO `cmf_district` VALUES ('1254', '149', '0', '管城区', '3');
INSERT INTO `cmf_district` VALUES ('1255', '149', '0', '中原区', '3');
INSERT INTO `cmf_district` VALUES ('1256', '149', '0', '上街区', '3');
INSERT INTO `cmf_district` VALUES ('1257', '149', '0', '惠济区', '3');
INSERT INTO `cmf_district` VALUES ('1258', '149', '0', '郑东新区', '3');
INSERT INTO `cmf_district` VALUES ('1259', '149', '0', '经济技术开发区', '3');
INSERT INTO `cmf_district` VALUES ('1260', '149', '0', '高新开发区', '3');
INSERT INTO `cmf_district` VALUES ('1261', '149', '0', '出口加工区', '3');
INSERT INTO `cmf_district` VALUES ('1262', '149', '0', '巩义市', '3');
INSERT INTO `cmf_district` VALUES ('1263', '149', '0', '荥阳市', '3');
INSERT INTO `cmf_district` VALUES ('1264', '149', '0', '新密市', '3');
INSERT INTO `cmf_district` VALUES ('1265', '149', '0', '新郑市', '3');
INSERT INTO `cmf_district` VALUES ('1266', '149', '0', '登封市', '3');
INSERT INTO `cmf_district` VALUES ('1267', '149', '0', '中牟县', '3');
INSERT INTO `cmf_district` VALUES ('1268', '150', '0', '西工区', '3');
INSERT INTO `cmf_district` VALUES ('1269', '150', '0', '老城区', '3');
INSERT INTO `cmf_district` VALUES ('1270', '150', '0', '涧西区', '3');
INSERT INTO `cmf_district` VALUES ('1271', '150', '0', '瀍河回族区', '3');
INSERT INTO `cmf_district` VALUES ('1272', '150', '0', '洛龙区', '3');
INSERT INTO `cmf_district` VALUES ('1273', '150', '0', '吉利区', '3');
INSERT INTO `cmf_district` VALUES ('1274', '150', '0', '偃师市', '3');
INSERT INTO `cmf_district` VALUES ('1275', '150', '0', '孟津县', '3');
INSERT INTO `cmf_district` VALUES ('1276', '150', '0', '新安县', '3');
INSERT INTO `cmf_district` VALUES ('1277', '150', '0', '栾川县', '3');
INSERT INTO `cmf_district` VALUES ('1278', '150', '0', '嵩县', '3');
INSERT INTO `cmf_district` VALUES ('1279', '150', '0', '汝阳县', '3');
INSERT INTO `cmf_district` VALUES ('1280', '150', '0', '宜阳县', '3');
INSERT INTO `cmf_district` VALUES ('1281', '150', '0', '洛宁县', '3');
INSERT INTO `cmf_district` VALUES ('1282', '150', '0', '伊川县', '3');
INSERT INTO `cmf_district` VALUES ('1283', '151', '0', '鼓楼区', '3');
INSERT INTO `cmf_district` VALUES ('1284', '151', '0', '龙亭区', '3');
INSERT INTO `cmf_district` VALUES ('1285', '151', '0', '顺河回族区', '3');
INSERT INTO `cmf_district` VALUES ('1286', '151', '0', '金明区', '3');
INSERT INTO `cmf_district` VALUES ('1287', '151', '0', '禹王台区', '3');
INSERT INTO `cmf_district` VALUES ('1288', '151', '0', '杞县', '3');
INSERT INTO `cmf_district` VALUES ('1289', '151', '0', '通许县', '3');
INSERT INTO `cmf_district` VALUES ('1290', '151', '0', '尉氏县', '3');
INSERT INTO `cmf_district` VALUES ('1291', '151', '0', '开封县', '3');
INSERT INTO `cmf_district` VALUES ('1292', '151', '0', '兰考县', '3');
INSERT INTO `cmf_district` VALUES ('1293', '152', '0', '北关区', '3');
INSERT INTO `cmf_district` VALUES ('1294', '152', '0', '文峰区', '3');
INSERT INTO `cmf_district` VALUES ('1295', '152', '0', '殷都区', '3');
INSERT INTO `cmf_district` VALUES ('1296', '152', '0', '龙安区', '3');
INSERT INTO `cmf_district` VALUES ('1297', '152', '0', '林州市', '3');
INSERT INTO `cmf_district` VALUES ('1298', '152', '0', '安阳县', '3');
INSERT INTO `cmf_district` VALUES ('1299', '152', '0', '汤阴县', '3');
INSERT INTO `cmf_district` VALUES ('1300', '152', '0', '滑县', '3');
INSERT INTO `cmf_district` VALUES ('1301', '152', '0', '内黄县', '3');
INSERT INTO `cmf_district` VALUES ('1302', '153', '0', '淇滨区', '3');
INSERT INTO `cmf_district` VALUES ('1303', '153', '0', '山城区', '3');
INSERT INTO `cmf_district` VALUES ('1304', '153', '0', '鹤山区', '3');
INSERT INTO `cmf_district` VALUES ('1305', '153', '0', '浚县', '3');
INSERT INTO `cmf_district` VALUES ('1306', '153', '0', '淇县', '3');
INSERT INTO `cmf_district` VALUES ('1307', '154', '0', '济源市', '3');
INSERT INTO `cmf_district` VALUES ('1308', '155', '0', '解放区', '3');
INSERT INTO `cmf_district` VALUES ('1309', '155', '0', '中站区', '3');
INSERT INTO `cmf_district` VALUES ('1310', '155', '0', '马村区', '3');
INSERT INTO `cmf_district` VALUES ('1311', '155', '0', '山阳区', '3');
INSERT INTO `cmf_district` VALUES ('1312', '155', '0', '沁阳市', '3');
INSERT INTO `cmf_district` VALUES ('1313', '155', '0', '孟州市', '3');
INSERT INTO `cmf_district` VALUES ('1314', '155', '0', '修武县', '3');
INSERT INTO `cmf_district` VALUES ('1315', '155', '0', '博爱县', '3');
INSERT INTO `cmf_district` VALUES ('1316', '155', '0', '武陟县', '3');
INSERT INTO `cmf_district` VALUES ('1317', '155', '0', '温县', '3');
INSERT INTO `cmf_district` VALUES ('1318', '156', '0', '卧龙区', '3');
INSERT INTO `cmf_district` VALUES ('1319', '156', '0', '宛城区', '3');
INSERT INTO `cmf_district` VALUES ('1320', '156', '0', '邓州市', '3');
INSERT INTO `cmf_district` VALUES ('1321', '156', '0', '南召县', '3');
INSERT INTO `cmf_district` VALUES ('1322', '156', '0', '方城县', '3');
INSERT INTO `cmf_district` VALUES ('1323', '156', '0', '西峡县', '3');
INSERT INTO `cmf_district` VALUES ('1324', '156', '0', '镇平县', '3');
INSERT INTO `cmf_district` VALUES ('1325', '156', '0', '内乡县', '3');
INSERT INTO `cmf_district` VALUES ('1326', '156', '0', '淅川县', '3');
INSERT INTO `cmf_district` VALUES ('1327', '156', '0', '社旗县', '3');
INSERT INTO `cmf_district` VALUES ('1328', '156', '0', '唐河县', '3');
INSERT INTO `cmf_district` VALUES ('1329', '156', '0', '新野县', '3');
INSERT INTO `cmf_district` VALUES ('1330', '156', '0', '桐柏县', '3');
INSERT INTO `cmf_district` VALUES ('1331', '157', '0', '新华区', '3');
INSERT INTO `cmf_district` VALUES ('1332', '157', '0', '卫东区', '3');
INSERT INTO `cmf_district` VALUES ('1333', '157', '0', '湛河区', '3');
INSERT INTO `cmf_district` VALUES ('1334', '157', '0', '石龙区', '3');
INSERT INTO `cmf_district` VALUES ('1335', '157', '0', '舞钢市', '3');
INSERT INTO `cmf_district` VALUES ('1336', '157', '0', '汝州市', '3');
INSERT INTO `cmf_district` VALUES ('1337', '157', '0', '宝丰县', '3');
INSERT INTO `cmf_district` VALUES ('1338', '157', '0', '叶县', '3');
INSERT INTO `cmf_district` VALUES ('1339', '157', '0', '鲁山县', '3');
INSERT INTO `cmf_district` VALUES ('1340', '157', '0', '郏县', '3');
INSERT INTO `cmf_district` VALUES ('1341', '158', '0', '湖滨区', '3');
INSERT INTO `cmf_district` VALUES ('1342', '158', '0', '义马市', '3');
INSERT INTO `cmf_district` VALUES ('1343', '158', '0', '灵宝市', '3');
INSERT INTO `cmf_district` VALUES ('1344', '158', '0', '渑池县', '3');
INSERT INTO `cmf_district` VALUES ('1345', '158', '0', '陕县', '3');
INSERT INTO `cmf_district` VALUES ('1346', '158', '0', '卢氏县', '3');
INSERT INTO `cmf_district` VALUES ('1347', '159', '0', '梁园区', '3');
INSERT INTO `cmf_district` VALUES ('1348', '159', '0', '睢阳区', '3');
INSERT INTO `cmf_district` VALUES ('1349', '159', '0', '永城市', '3');
INSERT INTO `cmf_district` VALUES ('1350', '159', '0', '民权县', '3');
INSERT INTO `cmf_district` VALUES ('1351', '159', '0', '睢县', '3');
INSERT INTO `cmf_district` VALUES ('1352', '159', '0', '宁陵县', '3');
INSERT INTO `cmf_district` VALUES ('1353', '159', '0', '虞城县', '3');
INSERT INTO `cmf_district` VALUES ('1354', '159', '0', '柘城县', '3');
INSERT INTO `cmf_district` VALUES ('1355', '159', '0', '夏邑县', '3');
INSERT INTO `cmf_district` VALUES ('1356', '160', '0', '卫滨区', '3');
INSERT INTO `cmf_district` VALUES ('1357', '160', '0', '红旗区', '3');
INSERT INTO `cmf_district` VALUES ('1358', '160', '0', '凤泉区', '3');
INSERT INTO `cmf_district` VALUES ('1359', '160', '0', '牧野区', '3');
INSERT INTO `cmf_district` VALUES ('1360', '160', '0', '卫辉市', '3');
INSERT INTO `cmf_district` VALUES ('1361', '160', '0', '辉县市', '3');
INSERT INTO `cmf_district` VALUES ('1362', '160', '0', '新乡县', '3');
INSERT INTO `cmf_district` VALUES ('1363', '160', '0', '获嘉县', '3');
INSERT INTO `cmf_district` VALUES ('1364', '160', '0', '原阳县', '3');
INSERT INTO `cmf_district` VALUES ('1365', '160', '0', '延津县', '3');
INSERT INTO `cmf_district` VALUES ('1366', '160', '0', '封丘县', '3');
INSERT INTO `cmf_district` VALUES ('1367', '160', '0', '长垣县', '3');
INSERT INTO `cmf_district` VALUES ('1368', '161', '0', '浉河区', '3');
INSERT INTO `cmf_district` VALUES ('1369', '161', '0', '平桥区', '3');
INSERT INTO `cmf_district` VALUES ('1370', '161', '0', '罗山县', '3');
INSERT INTO `cmf_district` VALUES ('1371', '161', '0', '光山县', '3');
INSERT INTO `cmf_district` VALUES ('1372', '161', '0', '新县', '3');
INSERT INTO `cmf_district` VALUES ('1373', '161', '0', '商城县', '3');
INSERT INTO `cmf_district` VALUES ('1374', '161', '0', '固始县', '3');
INSERT INTO `cmf_district` VALUES ('1375', '161', '0', '潢川县', '3');
INSERT INTO `cmf_district` VALUES ('1376', '161', '0', '淮滨县', '3');
INSERT INTO `cmf_district` VALUES ('1377', '161', '0', '息县', '3');
INSERT INTO `cmf_district` VALUES ('1378', '162', '0', '魏都区', '3');
INSERT INTO `cmf_district` VALUES ('1379', '162', '0', '禹州市', '3');
INSERT INTO `cmf_district` VALUES ('1380', '162', '0', '长葛市', '3');
INSERT INTO `cmf_district` VALUES ('1381', '162', '0', '许昌县', '3');
INSERT INTO `cmf_district` VALUES ('1382', '162', '0', '鄢陵县', '3');
INSERT INTO `cmf_district` VALUES ('1383', '162', '0', '襄城县', '3');
INSERT INTO `cmf_district` VALUES ('1384', '163', '0', '川汇区', '3');
INSERT INTO `cmf_district` VALUES ('1385', '163', '0', '项城市', '3');
INSERT INTO `cmf_district` VALUES ('1386', '163', '0', '扶沟县', '3');
INSERT INTO `cmf_district` VALUES ('1387', '163', '0', '西华县', '3');
INSERT INTO `cmf_district` VALUES ('1388', '163', '0', '商水县', '3');
INSERT INTO `cmf_district` VALUES ('1389', '163', '0', '沈丘县', '3');
INSERT INTO `cmf_district` VALUES ('1390', '163', '0', '郸城县', '3');
INSERT INTO `cmf_district` VALUES ('1391', '163', '0', '淮阳县', '3');
INSERT INTO `cmf_district` VALUES ('1392', '163', '0', '太康县', '3');
INSERT INTO `cmf_district` VALUES ('1393', '163', '0', '鹿邑县', '3');
INSERT INTO `cmf_district` VALUES ('1394', '164', '0', '驿城区', '3');
INSERT INTO `cmf_district` VALUES ('1395', '164', '0', '西平县', '3');
INSERT INTO `cmf_district` VALUES ('1396', '164', '0', '上蔡县', '3');
INSERT INTO `cmf_district` VALUES ('1397', '164', '0', '平舆县', '3');
INSERT INTO `cmf_district` VALUES ('1398', '164', '0', '正阳县', '3');
INSERT INTO `cmf_district` VALUES ('1399', '164', '0', '确山县', '3');
INSERT INTO `cmf_district` VALUES ('1400', '164', '0', '泌阳县', '3');
INSERT INTO `cmf_district` VALUES ('1401', '164', '0', '汝南县', '3');
INSERT INTO `cmf_district` VALUES ('1402', '164', '0', '遂平县', '3');
INSERT INTO `cmf_district` VALUES ('1403', '164', '0', '新蔡县', '3');
INSERT INTO `cmf_district` VALUES ('1404', '165', '0', '郾城区', '3');
INSERT INTO `cmf_district` VALUES ('1405', '165', '0', '源汇区', '3');
INSERT INTO `cmf_district` VALUES ('1406', '165', '0', '召陵区', '3');
INSERT INTO `cmf_district` VALUES ('1407', '165', '0', '舞阳县', '3');
INSERT INTO `cmf_district` VALUES ('1408', '165', '0', '临颍县', '3');
INSERT INTO `cmf_district` VALUES ('1409', '166', '0', '华龙区', '3');
INSERT INTO `cmf_district` VALUES ('1410', '166', '0', '清丰县', '3');
INSERT INTO `cmf_district` VALUES ('1411', '166', '0', '南乐县', '3');
INSERT INTO `cmf_district` VALUES ('1412', '166', '0', '范县', '3');
INSERT INTO `cmf_district` VALUES ('1413', '166', '0', '台前县', '3');
INSERT INTO `cmf_district` VALUES ('1414', '166', '0', '濮阳县', '3');
INSERT INTO `cmf_district` VALUES ('1415', '167', '0', '道里区', '3');
INSERT INTO `cmf_district` VALUES ('1416', '167', '0', '南岗区', '3');
INSERT INTO `cmf_district` VALUES ('1417', '167', '0', '动力区', '3');
INSERT INTO `cmf_district` VALUES ('1418', '167', '0', '平房区', '3');
INSERT INTO `cmf_district` VALUES ('1419', '167', '0', '香坊区', '3');
INSERT INTO `cmf_district` VALUES ('1420', '167', '0', '太平区', '3');
INSERT INTO `cmf_district` VALUES ('1421', '167', '0', '道外区', '3');
INSERT INTO `cmf_district` VALUES ('1422', '167', '0', '阿城区', '3');
INSERT INTO `cmf_district` VALUES ('1423', '167', '0', '呼兰区', '3');
INSERT INTO `cmf_district` VALUES ('1424', '167', '0', '松北区', '3');
INSERT INTO `cmf_district` VALUES ('1425', '167', '0', '尚志市', '3');
INSERT INTO `cmf_district` VALUES ('1426', '167', '0', '双城市', '3');
INSERT INTO `cmf_district` VALUES ('1427', '167', '0', '五常市', '3');
INSERT INTO `cmf_district` VALUES ('1428', '167', '0', '方正县', '3');
INSERT INTO `cmf_district` VALUES ('1429', '167', '0', '宾县', '3');
INSERT INTO `cmf_district` VALUES ('1430', '167', '0', '依兰县', '3');
INSERT INTO `cmf_district` VALUES ('1431', '167', '0', '巴彦县', '3');
INSERT INTO `cmf_district` VALUES ('1432', '167', '0', '通河县', '3');
INSERT INTO `cmf_district` VALUES ('1433', '167', '0', '木兰县', '3');
INSERT INTO `cmf_district` VALUES ('1434', '167', '0', '延寿县', '3');
INSERT INTO `cmf_district` VALUES ('1435', '168', '0', '萨尔图区', '3');
INSERT INTO `cmf_district` VALUES ('1436', '168', '0', '红岗区', '3');
INSERT INTO `cmf_district` VALUES ('1437', '168', '0', '龙凤区', '3');
INSERT INTO `cmf_district` VALUES ('1438', '168', '0', '让胡路区', '3');
INSERT INTO `cmf_district` VALUES ('1439', '168', '0', '大同区', '3');
INSERT INTO `cmf_district` VALUES ('1440', '168', '0', '肇州县', '3');
INSERT INTO `cmf_district` VALUES ('1441', '168', '0', '肇源县', '3');
INSERT INTO `cmf_district` VALUES ('1442', '168', '0', '林甸县', '3');
INSERT INTO `cmf_district` VALUES ('1443', '168', '0', '杜尔伯特', '3');
INSERT INTO `cmf_district` VALUES ('1444', '169', '0', '呼玛县', '3');
INSERT INTO `cmf_district` VALUES ('1445', '169', '0', '漠河县', '3');
INSERT INTO `cmf_district` VALUES ('1446', '169', '0', '塔河县', '3');
INSERT INTO `cmf_district` VALUES ('1447', '170', '0', '兴山区', '3');
INSERT INTO `cmf_district` VALUES ('1448', '170', '0', '工农区', '3');
INSERT INTO `cmf_district` VALUES ('1449', '170', '0', '南山区', '3');
INSERT INTO `cmf_district` VALUES ('1450', '170', '0', '兴安区', '3');
INSERT INTO `cmf_district` VALUES ('1451', '170', '0', '向阳区', '3');
INSERT INTO `cmf_district` VALUES ('1452', '170', '0', '东山区', '3');
INSERT INTO `cmf_district` VALUES ('1453', '170', '0', '萝北县', '3');
INSERT INTO `cmf_district` VALUES ('1454', '170', '0', '绥滨县', '3');
INSERT INTO `cmf_district` VALUES ('1455', '171', '0', '爱辉区', '3');
INSERT INTO `cmf_district` VALUES ('1456', '171', '0', '五大连池市', '3');
INSERT INTO `cmf_district` VALUES ('1457', '171', '0', '北安市', '3');
INSERT INTO `cmf_district` VALUES ('1458', '171', '0', '嫩江县', '3');
INSERT INTO `cmf_district` VALUES ('1459', '171', '0', '逊克县', '3');
INSERT INTO `cmf_district` VALUES ('1460', '171', '0', '孙吴县', '3');
INSERT INTO `cmf_district` VALUES ('1461', '172', '0', '鸡冠区', '3');
INSERT INTO `cmf_district` VALUES ('1462', '172', '0', '恒山区', '3');
INSERT INTO `cmf_district` VALUES ('1463', '172', '0', '城子河区', '3');
INSERT INTO `cmf_district` VALUES ('1464', '172', '0', '滴道区', '3');
INSERT INTO `cmf_district` VALUES ('1465', '172', '0', '梨树区', '3');
INSERT INTO `cmf_district` VALUES ('1466', '172', '0', '虎林市', '3');
INSERT INTO `cmf_district` VALUES ('1467', '172', '0', '密山市', '3');
INSERT INTO `cmf_district` VALUES ('1468', '172', '0', '鸡东县', '3');
INSERT INTO `cmf_district` VALUES ('1469', '173', '0', '前进区', '3');
INSERT INTO `cmf_district` VALUES ('1470', '173', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('1471', '173', '0', '向阳区', '3');
INSERT INTO `cmf_district` VALUES ('1472', '173', '0', '东风区', '3');
INSERT INTO `cmf_district` VALUES ('1473', '173', '0', '同江市', '3');
INSERT INTO `cmf_district` VALUES ('1474', '173', '0', '富锦市', '3');
INSERT INTO `cmf_district` VALUES ('1475', '173', '0', '桦南县', '3');
INSERT INTO `cmf_district` VALUES ('1476', '173', '0', '桦川县', '3');
INSERT INTO `cmf_district` VALUES ('1477', '173', '0', '汤原县', '3');
INSERT INTO `cmf_district` VALUES ('1478', '173', '0', '抚远县', '3');
INSERT INTO `cmf_district` VALUES ('1479', '174', '0', '爱民区', '3');
INSERT INTO `cmf_district` VALUES ('1480', '174', '0', '东安区', '3');
INSERT INTO `cmf_district` VALUES ('1481', '174', '0', '阳明区', '3');
INSERT INTO `cmf_district` VALUES ('1482', '174', '0', '西安区', '3');
INSERT INTO `cmf_district` VALUES ('1483', '174', '0', '绥芬河市', '3');
INSERT INTO `cmf_district` VALUES ('1484', '174', '0', '海林市', '3');
INSERT INTO `cmf_district` VALUES ('1485', '174', '0', '宁安市', '3');
INSERT INTO `cmf_district` VALUES ('1486', '174', '0', '穆棱市', '3');
INSERT INTO `cmf_district` VALUES ('1487', '174', '0', '东宁县', '3');
INSERT INTO `cmf_district` VALUES ('1488', '174', '0', '林口县', '3');
INSERT INTO `cmf_district` VALUES ('1489', '175', '0', '桃山区', '3');
INSERT INTO `cmf_district` VALUES ('1490', '175', '0', '新兴区', '3');
INSERT INTO `cmf_district` VALUES ('1491', '175', '0', '茄子河区', '3');
INSERT INTO `cmf_district` VALUES ('1492', '175', '0', '勃利县', '3');
INSERT INTO `cmf_district` VALUES ('1493', '176', '0', '龙沙区', '3');
INSERT INTO `cmf_district` VALUES ('1494', '176', '0', '昂昂溪区', '3');
INSERT INTO `cmf_district` VALUES ('1495', '176', '0', '铁峰区', '3');
INSERT INTO `cmf_district` VALUES ('1496', '176', '0', '建华区', '3');
INSERT INTO `cmf_district` VALUES ('1497', '176', '0', '富拉尔基区', '3');
INSERT INTO `cmf_district` VALUES ('1498', '176', '0', '碾子山区', '3');
INSERT INTO `cmf_district` VALUES ('1499', '176', '0', '梅里斯达斡尔区', '3');
INSERT INTO `cmf_district` VALUES ('1500', '176', '0', '讷河市', '3');
INSERT INTO `cmf_district` VALUES ('1501', '176', '0', '龙江县', '3');
INSERT INTO `cmf_district` VALUES ('1502', '176', '0', '依安县', '3');
INSERT INTO `cmf_district` VALUES ('1503', '176', '0', '泰来县', '3');
INSERT INTO `cmf_district` VALUES ('1504', '176', '0', '甘南县', '3');
INSERT INTO `cmf_district` VALUES ('1505', '176', '0', '富裕县', '3');
INSERT INTO `cmf_district` VALUES ('1506', '176', '0', '克山县', '3');
INSERT INTO `cmf_district` VALUES ('1507', '176', '0', '克东县', '3');
INSERT INTO `cmf_district` VALUES ('1508', '176', '0', '拜泉县', '3');
INSERT INTO `cmf_district` VALUES ('1509', '177', '0', '尖山区', '3');
INSERT INTO `cmf_district` VALUES ('1510', '177', '0', '岭东区', '3');
INSERT INTO `cmf_district` VALUES ('1511', '177', '0', '四方台区', '3');
INSERT INTO `cmf_district` VALUES ('1512', '177', '0', '宝山区', '3');
INSERT INTO `cmf_district` VALUES ('1513', '177', '0', '集贤县', '3');
INSERT INTO `cmf_district` VALUES ('1514', '177', '0', '友谊县', '3');
INSERT INTO `cmf_district` VALUES ('1515', '177', '0', '宝清县', '3');
INSERT INTO `cmf_district` VALUES ('1516', '177', '0', '饶河县', '3');
INSERT INTO `cmf_district` VALUES ('1517', '178', '0', '北林区', '3');
INSERT INTO `cmf_district` VALUES ('1518', '178', '0', '安达市', '3');
INSERT INTO `cmf_district` VALUES ('1519', '178', '0', '肇东市', '3');
INSERT INTO `cmf_district` VALUES ('1520', '178', '0', '海伦市', '3');
INSERT INTO `cmf_district` VALUES ('1521', '178', '0', '望奎县', '3');
INSERT INTO `cmf_district` VALUES ('1522', '178', '0', '兰西县', '3');
INSERT INTO `cmf_district` VALUES ('1523', '178', '0', '青冈县', '3');
INSERT INTO `cmf_district` VALUES ('1524', '178', '0', '庆安县', '3');
INSERT INTO `cmf_district` VALUES ('1525', '178', '0', '明水县', '3');
INSERT INTO `cmf_district` VALUES ('1526', '178', '0', '绥棱县', '3');
INSERT INTO `cmf_district` VALUES ('1527', '179', '0', '伊春区', '3');
INSERT INTO `cmf_district` VALUES ('1528', '179', '0', '带岭区', '3');
INSERT INTO `cmf_district` VALUES ('1529', '179', '0', '南岔区', '3');
INSERT INTO `cmf_district` VALUES ('1530', '179', '0', '金山屯区', '3');
INSERT INTO `cmf_district` VALUES ('1531', '179', '0', '西林区', '3');
INSERT INTO `cmf_district` VALUES ('1532', '179', '0', '美溪区', '3');
INSERT INTO `cmf_district` VALUES ('1533', '179', '0', '乌马河区', '3');
INSERT INTO `cmf_district` VALUES ('1534', '179', '0', '翠峦区', '3');
INSERT INTO `cmf_district` VALUES ('1535', '179', '0', '友好区', '3');
INSERT INTO `cmf_district` VALUES ('1536', '179', '0', '上甘岭区', '3');
INSERT INTO `cmf_district` VALUES ('1537', '179', '0', '五营区', '3');
INSERT INTO `cmf_district` VALUES ('1538', '179', '0', '红星区', '3');
INSERT INTO `cmf_district` VALUES ('1539', '179', '0', '新青区', '3');
INSERT INTO `cmf_district` VALUES ('1540', '179', '0', '汤旺河区', '3');
INSERT INTO `cmf_district` VALUES ('1541', '179', '0', '乌伊岭区', '3');
INSERT INTO `cmf_district` VALUES ('1542', '179', '0', '铁力市', '3');
INSERT INTO `cmf_district` VALUES ('1543', '179', '0', '嘉荫县', '3');
INSERT INTO `cmf_district` VALUES ('1544', '180', '0', '江岸区', '3');
INSERT INTO `cmf_district` VALUES ('1545', '180', '0', '武昌区', '3');
INSERT INTO `cmf_district` VALUES ('1546', '180', '0', '江汉区', '3');
INSERT INTO `cmf_district` VALUES ('1547', '180', '0', '硚口区', '3');
INSERT INTO `cmf_district` VALUES ('1548', '180', '0', '汉阳区', '3');
INSERT INTO `cmf_district` VALUES ('1549', '180', '0', '青山区', '3');
INSERT INTO `cmf_district` VALUES ('1550', '180', '0', '洪山区', '3');
INSERT INTO `cmf_district` VALUES ('1551', '180', '0', '东西湖区', '3');
INSERT INTO `cmf_district` VALUES ('1552', '180', '0', '汉南区', '3');
INSERT INTO `cmf_district` VALUES ('1553', '180', '0', '蔡甸区', '3');
INSERT INTO `cmf_district` VALUES ('1554', '180', '0', '江夏区', '3');
INSERT INTO `cmf_district` VALUES ('1555', '180', '0', '黄陂区', '3');
INSERT INTO `cmf_district` VALUES ('1556', '180', '0', '新洲区', '3');
INSERT INTO `cmf_district` VALUES ('1557', '180', '0', '经济开发区', '3');
INSERT INTO `cmf_district` VALUES ('1558', '181', '0', '仙桃市', '3');
INSERT INTO `cmf_district` VALUES ('1559', '182', '0', '鄂城区', '3');
INSERT INTO `cmf_district` VALUES ('1560', '182', '0', '华容区', '3');
INSERT INTO `cmf_district` VALUES ('1561', '182', '0', '梁子湖区', '3');
INSERT INTO `cmf_district` VALUES ('1562', '183', '0', '黄州区', '3');
INSERT INTO `cmf_district` VALUES ('1563', '183', '0', '麻城市', '3');
INSERT INTO `cmf_district` VALUES ('1564', '183', '0', '武穴市', '3');
INSERT INTO `cmf_district` VALUES ('1565', '183', '0', '团风县', '3');
INSERT INTO `cmf_district` VALUES ('1566', '183', '0', '红安县', '3');
INSERT INTO `cmf_district` VALUES ('1567', '183', '0', '罗田县', '3');
INSERT INTO `cmf_district` VALUES ('1568', '183', '0', '英山县', '3');
INSERT INTO `cmf_district` VALUES ('1569', '183', '0', '浠水县', '3');
INSERT INTO `cmf_district` VALUES ('1570', '183', '0', '蕲春县', '3');
INSERT INTO `cmf_district` VALUES ('1571', '183', '0', '黄梅县', '3');
INSERT INTO `cmf_district` VALUES ('1572', '184', '0', '黄石港区', '3');
INSERT INTO `cmf_district` VALUES ('1573', '184', '0', '西塞山区', '3');
INSERT INTO `cmf_district` VALUES ('1574', '184', '0', '下陆区', '3');
INSERT INTO `cmf_district` VALUES ('1575', '184', '0', '铁山区', '3');
INSERT INTO `cmf_district` VALUES ('1576', '184', '0', '大冶市', '3');
INSERT INTO `cmf_district` VALUES ('1577', '184', '0', '阳新县', '3');
INSERT INTO `cmf_district` VALUES ('1578', '185', '0', '东宝区', '3');
INSERT INTO `cmf_district` VALUES ('1579', '185', '0', '掇刀区', '3');
INSERT INTO `cmf_district` VALUES ('1580', '185', '0', '钟祥市', '3');
INSERT INTO `cmf_district` VALUES ('1581', '185', '0', '京山县', '3');
INSERT INTO `cmf_district` VALUES ('1582', '185', '0', '沙洋县', '3');
INSERT INTO `cmf_district` VALUES ('1583', '186', '0', '沙市区', '3');
INSERT INTO `cmf_district` VALUES ('1584', '186', '0', '荆州区', '3');
INSERT INTO `cmf_district` VALUES ('1585', '186', '0', '石首市', '3');
INSERT INTO `cmf_district` VALUES ('1586', '186', '0', '洪湖市', '3');
INSERT INTO `cmf_district` VALUES ('1587', '186', '0', '松滋市', '3');
INSERT INTO `cmf_district` VALUES ('1588', '186', '0', '公安县', '3');
INSERT INTO `cmf_district` VALUES ('1589', '186', '0', '监利县', '3');
INSERT INTO `cmf_district` VALUES ('1590', '186', '0', '江陵县', '3');
INSERT INTO `cmf_district` VALUES ('1591', '187', '0', '潜江市', '3');
INSERT INTO `cmf_district` VALUES ('1592', '188', '0', '神农架林区', '3');
INSERT INTO `cmf_district` VALUES ('1593', '189', '0', '张湾区', '3');
INSERT INTO `cmf_district` VALUES ('1594', '189', '0', '茅箭区', '3');
INSERT INTO `cmf_district` VALUES ('1595', '189', '0', '丹江口市', '3');
INSERT INTO `cmf_district` VALUES ('1596', '189', '0', '郧县', '3');
INSERT INTO `cmf_district` VALUES ('1597', '189', '0', '郧西县', '3');
INSERT INTO `cmf_district` VALUES ('1598', '189', '0', '竹山县', '3');
INSERT INTO `cmf_district` VALUES ('1599', '189', '0', '竹溪县', '3');
INSERT INTO `cmf_district` VALUES ('1600', '189', '0', '房县', '3');
INSERT INTO `cmf_district` VALUES ('1601', '190', '0', '曾都区', '3');
INSERT INTO `cmf_district` VALUES ('1602', '190', '0', '广水市', '3');
INSERT INTO `cmf_district` VALUES ('1603', '191', '0', '天门市', '3');
INSERT INTO `cmf_district` VALUES ('1604', '192', '0', '咸安区', '3');
INSERT INTO `cmf_district` VALUES ('1605', '192', '0', '赤壁市', '3');
INSERT INTO `cmf_district` VALUES ('1606', '192', '0', '嘉鱼县', '3');
INSERT INTO `cmf_district` VALUES ('1607', '192', '0', '通城县', '3');
INSERT INTO `cmf_district` VALUES ('1608', '192', '0', '崇阳县', '3');
INSERT INTO `cmf_district` VALUES ('1609', '192', '0', '通山县', '3');
INSERT INTO `cmf_district` VALUES ('1610', '193', '0', '襄城区', '3');
INSERT INTO `cmf_district` VALUES ('1611', '193', '0', '樊城区', '3');
INSERT INTO `cmf_district` VALUES ('1612', '193', '0', '襄阳区', '3');
INSERT INTO `cmf_district` VALUES ('1613', '193', '0', '老河口市', '3');
INSERT INTO `cmf_district` VALUES ('1614', '193', '0', '枣阳市', '3');
INSERT INTO `cmf_district` VALUES ('1615', '193', '0', '宜城市', '3');
INSERT INTO `cmf_district` VALUES ('1616', '193', '0', '南漳县', '3');
INSERT INTO `cmf_district` VALUES ('1617', '193', '0', '谷城县', '3');
INSERT INTO `cmf_district` VALUES ('1618', '193', '0', '保康县', '3');
INSERT INTO `cmf_district` VALUES ('1619', '194', '0', '孝南区', '3');
INSERT INTO `cmf_district` VALUES ('1620', '194', '0', '应城市', '3');
INSERT INTO `cmf_district` VALUES ('1621', '194', '0', '安陆市', '3');
INSERT INTO `cmf_district` VALUES ('1622', '194', '0', '汉川市', '3');
INSERT INTO `cmf_district` VALUES ('1623', '194', '0', '孝昌县', '3');
INSERT INTO `cmf_district` VALUES ('1624', '194', '0', '大悟县', '3');
INSERT INTO `cmf_district` VALUES ('1625', '194', '0', '云梦县', '3');
INSERT INTO `cmf_district` VALUES ('1626', '195', '0', '长阳', '3');
INSERT INTO `cmf_district` VALUES ('1627', '195', '0', '五峰', '3');
INSERT INTO `cmf_district` VALUES ('1628', '195', '0', '西陵区', '3');
INSERT INTO `cmf_district` VALUES ('1629', '195', '0', '伍家岗区', '3');
INSERT INTO `cmf_district` VALUES ('1630', '195', '0', '点军区', '3');
INSERT INTO `cmf_district` VALUES ('1631', '195', '0', '猇亭区', '3');
INSERT INTO `cmf_district` VALUES ('1632', '195', '0', '夷陵区', '3');
INSERT INTO `cmf_district` VALUES ('1633', '195', '0', '宜都市', '3');
INSERT INTO `cmf_district` VALUES ('1634', '195', '0', '当阳市', '3');
INSERT INTO `cmf_district` VALUES ('1635', '195', '0', '枝江市', '3');
INSERT INTO `cmf_district` VALUES ('1636', '195', '0', '远安县', '3');
INSERT INTO `cmf_district` VALUES ('1637', '195', '0', '兴山县', '3');
INSERT INTO `cmf_district` VALUES ('1638', '195', '0', '秭归县', '3');
INSERT INTO `cmf_district` VALUES ('1639', '196', '0', '恩施市', '3');
INSERT INTO `cmf_district` VALUES ('1640', '196', '0', '利川市', '3');
INSERT INTO `cmf_district` VALUES ('1641', '196', '0', '建始县', '3');
INSERT INTO `cmf_district` VALUES ('1642', '196', '0', '巴东县', '3');
INSERT INTO `cmf_district` VALUES ('1643', '196', '0', '宣恩县', '3');
INSERT INTO `cmf_district` VALUES ('1644', '196', '0', '咸丰县', '3');
INSERT INTO `cmf_district` VALUES ('1645', '196', '0', '来凤县', '3');
INSERT INTO `cmf_district` VALUES ('1646', '196', '0', '鹤峰县', '3');
INSERT INTO `cmf_district` VALUES ('1647', '197', '0', '岳麓区', '3');
INSERT INTO `cmf_district` VALUES ('1648', '197', '0', '芙蓉区', '3');
INSERT INTO `cmf_district` VALUES ('1649', '197', '0', '天心区', '3');
INSERT INTO `cmf_district` VALUES ('1650', '197', '0', '开福区', '3');
INSERT INTO `cmf_district` VALUES ('1651', '197', '0', '雨花区', '3');
INSERT INTO `cmf_district` VALUES ('1652', '197', '0', '开发区', '3');
INSERT INTO `cmf_district` VALUES ('1653', '197', '0', '浏阳市', '3');
INSERT INTO `cmf_district` VALUES ('1654', '197', '0', '长沙县', '3');
INSERT INTO `cmf_district` VALUES ('1655', '197', '0', '望城县', '3');
INSERT INTO `cmf_district` VALUES ('1656', '197', '0', '宁乡县', '3');
INSERT INTO `cmf_district` VALUES ('1657', '198', '0', '永定区', '3');
INSERT INTO `cmf_district` VALUES ('1658', '198', '0', '武陵源区', '3');
INSERT INTO `cmf_district` VALUES ('1659', '198', '0', '慈利县', '3');
INSERT INTO `cmf_district` VALUES ('1660', '198', '0', '桑植县', '3');
INSERT INTO `cmf_district` VALUES ('1661', '199', '0', '武陵区', '3');
INSERT INTO `cmf_district` VALUES ('1662', '199', '0', '鼎城区', '3');
INSERT INTO `cmf_district` VALUES ('1663', '199', '0', '津市市', '3');
INSERT INTO `cmf_district` VALUES ('1664', '199', '0', '安乡县', '3');
INSERT INTO `cmf_district` VALUES ('1665', '199', '0', '汉寿县', '3');
INSERT INTO `cmf_district` VALUES ('1666', '199', '0', '澧县', '3');
INSERT INTO `cmf_district` VALUES ('1667', '199', '0', '临澧县', '3');
INSERT INTO `cmf_district` VALUES ('1668', '199', '0', '桃源县', '3');
INSERT INTO `cmf_district` VALUES ('1669', '199', '0', '石门县', '3');
INSERT INTO `cmf_district` VALUES ('1670', '200', '0', '北湖区', '3');
INSERT INTO `cmf_district` VALUES ('1671', '200', '0', '苏仙区', '3');
INSERT INTO `cmf_district` VALUES ('1672', '200', '0', '资兴市', '3');
INSERT INTO `cmf_district` VALUES ('1673', '200', '0', '桂阳县', '3');
INSERT INTO `cmf_district` VALUES ('1674', '200', '0', '宜章县', '3');
INSERT INTO `cmf_district` VALUES ('1675', '200', '0', '永兴县', '3');
INSERT INTO `cmf_district` VALUES ('1676', '200', '0', '嘉禾县', '3');
INSERT INTO `cmf_district` VALUES ('1677', '200', '0', '临武县', '3');
INSERT INTO `cmf_district` VALUES ('1678', '200', '0', '汝城县', '3');
INSERT INTO `cmf_district` VALUES ('1679', '200', '0', '桂东县', '3');
INSERT INTO `cmf_district` VALUES ('1680', '200', '0', '安仁县', '3');
INSERT INTO `cmf_district` VALUES ('1681', '201', '0', '雁峰区', '3');
INSERT INTO `cmf_district` VALUES ('1682', '201', '0', '珠晖区', '3');
INSERT INTO `cmf_district` VALUES ('1683', '201', '0', '石鼓区', '3');
INSERT INTO `cmf_district` VALUES ('1684', '201', '0', '蒸湘区', '3');
INSERT INTO `cmf_district` VALUES ('1685', '201', '0', '南岳区', '3');
INSERT INTO `cmf_district` VALUES ('1686', '201', '0', '耒阳市', '3');
INSERT INTO `cmf_district` VALUES ('1687', '201', '0', '常宁市', '3');
INSERT INTO `cmf_district` VALUES ('1688', '201', '0', '衡阳县', '3');
INSERT INTO `cmf_district` VALUES ('1689', '201', '0', '衡南县', '3');
INSERT INTO `cmf_district` VALUES ('1690', '201', '0', '衡山县', '3');
INSERT INTO `cmf_district` VALUES ('1691', '201', '0', '衡东县', '3');
INSERT INTO `cmf_district` VALUES ('1692', '201', '0', '祁东县', '3');
INSERT INTO `cmf_district` VALUES ('1693', '202', '0', '鹤城区', '3');
INSERT INTO `cmf_district` VALUES ('1694', '202', '0', '靖州', '3');
INSERT INTO `cmf_district` VALUES ('1695', '202', '0', '麻阳', '3');
INSERT INTO `cmf_district` VALUES ('1696', '202', '0', '通道', '3');
INSERT INTO `cmf_district` VALUES ('1697', '202', '0', '新晃', '3');
INSERT INTO `cmf_district` VALUES ('1698', '202', '0', '芷江', '3');
INSERT INTO `cmf_district` VALUES ('1699', '202', '0', '沅陵县', '3');
INSERT INTO `cmf_district` VALUES ('1700', '202', '0', '辰溪县', '3');
INSERT INTO `cmf_district` VALUES ('1701', '202', '0', '溆浦县', '3');
INSERT INTO `cmf_district` VALUES ('1702', '202', '0', '中方县', '3');
INSERT INTO `cmf_district` VALUES ('1703', '202', '0', '会同县', '3');
INSERT INTO `cmf_district` VALUES ('1704', '202', '0', '洪江市', '3');
INSERT INTO `cmf_district` VALUES ('1705', '203', '0', '娄星区', '3');
INSERT INTO `cmf_district` VALUES ('1706', '203', '0', '冷水江市', '3');
INSERT INTO `cmf_district` VALUES ('1707', '203', '0', '涟源市', '3');
INSERT INTO `cmf_district` VALUES ('1708', '203', '0', '双峰县', '3');
INSERT INTO `cmf_district` VALUES ('1709', '203', '0', '新化县', '3');
INSERT INTO `cmf_district` VALUES ('1710', '204', '0', '城步', '3');
INSERT INTO `cmf_district` VALUES ('1711', '204', '0', '双清区', '3');
INSERT INTO `cmf_district` VALUES ('1712', '204', '0', '大祥区', '3');
INSERT INTO `cmf_district` VALUES ('1713', '204', '0', '北塔区', '3');
INSERT INTO `cmf_district` VALUES ('1714', '204', '0', '武冈市', '3');
INSERT INTO `cmf_district` VALUES ('1715', '204', '0', '邵东县', '3');
INSERT INTO `cmf_district` VALUES ('1716', '204', '0', '新邵县', '3');
INSERT INTO `cmf_district` VALUES ('1717', '204', '0', '邵阳县', '3');
INSERT INTO `cmf_district` VALUES ('1718', '204', '0', '隆回县', '3');
INSERT INTO `cmf_district` VALUES ('1719', '204', '0', '洞口县', '3');
INSERT INTO `cmf_district` VALUES ('1720', '204', '0', '绥宁县', '3');
INSERT INTO `cmf_district` VALUES ('1721', '204', '0', '新宁县', '3');
INSERT INTO `cmf_district` VALUES ('1722', '205', '0', '岳塘区', '3');
INSERT INTO `cmf_district` VALUES ('1723', '205', '0', '雨湖区', '3');
INSERT INTO `cmf_district` VALUES ('1724', '205', '0', '湘乡市', '3');
INSERT INTO `cmf_district` VALUES ('1725', '205', '0', '韶山市', '3');
INSERT INTO `cmf_district` VALUES ('1726', '205', '0', '湘潭县', '3');
INSERT INTO `cmf_district` VALUES ('1727', '206', '0', '吉首市', '3');
INSERT INTO `cmf_district` VALUES ('1728', '206', '0', '泸溪县', '3');
INSERT INTO `cmf_district` VALUES ('1729', '206', '0', '凤凰县', '3');
INSERT INTO `cmf_district` VALUES ('1730', '206', '0', '花垣县', '3');
INSERT INTO `cmf_district` VALUES ('1731', '206', '0', '保靖县', '3');
INSERT INTO `cmf_district` VALUES ('1732', '206', '0', '古丈县', '3');
INSERT INTO `cmf_district` VALUES ('1733', '206', '0', '永顺县', '3');
INSERT INTO `cmf_district` VALUES ('1734', '206', '0', '龙山县', '3');
INSERT INTO `cmf_district` VALUES ('1735', '207', '0', '赫山区', '3');
INSERT INTO `cmf_district` VALUES ('1736', '207', '0', '资阳区', '3');
INSERT INTO `cmf_district` VALUES ('1737', '207', '0', '沅江市', '3');
INSERT INTO `cmf_district` VALUES ('1738', '207', '0', '南县', '3');
INSERT INTO `cmf_district` VALUES ('1739', '207', '0', '桃江县', '3');
INSERT INTO `cmf_district` VALUES ('1740', '207', '0', '安化县', '3');
INSERT INTO `cmf_district` VALUES ('1741', '208', '0', '江华', '3');
INSERT INTO `cmf_district` VALUES ('1742', '208', '0', '冷水滩区', '3');
INSERT INTO `cmf_district` VALUES ('1743', '208', '0', '零陵区', '3');
INSERT INTO `cmf_district` VALUES ('1744', '208', '0', '祁阳县', '3');
INSERT INTO `cmf_district` VALUES ('1745', '208', '0', '东安县', '3');
INSERT INTO `cmf_district` VALUES ('1746', '208', '0', '双牌县', '3');
INSERT INTO `cmf_district` VALUES ('1747', '208', '0', '道县', '3');
INSERT INTO `cmf_district` VALUES ('1748', '208', '0', '江永县', '3');
INSERT INTO `cmf_district` VALUES ('1749', '208', '0', '宁远县', '3');
INSERT INTO `cmf_district` VALUES ('1750', '208', '0', '蓝山县', '3');
INSERT INTO `cmf_district` VALUES ('1751', '208', '0', '新田县', '3');
INSERT INTO `cmf_district` VALUES ('1752', '209', '0', '岳阳楼区', '3');
INSERT INTO `cmf_district` VALUES ('1753', '209', '0', '君山区', '3');
INSERT INTO `cmf_district` VALUES ('1754', '209', '0', '云溪区', '3');
INSERT INTO `cmf_district` VALUES ('1755', '209', '0', '汨罗市', '3');
INSERT INTO `cmf_district` VALUES ('1756', '209', '0', '临湘市', '3');
INSERT INTO `cmf_district` VALUES ('1757', '209', '0', '岳阳县', '3');
INSERT INTO `cmf_district` VALUES ('1758', '209', '0', '华容县', '3');
INSERT INTO `cmf_district` VALUES ('1759', '209', '0', '湘阴县', '3');
INSERT INTO `cmf_district` VALUES ('1760', '209', '0', '平江县', '3');
INSERT INTO `cmf_district` VALUES ('1761', '210', '0', '天元区', '3');
INSERT INTO `cmf_district` VALUES ('1762', '210', '0', '荷塘区', '3');
INSERT INTO `cmf_district` VALUES ('1763', '210', '0', '芦淞区', '3');
INSERT INTO `cmf_district` VALUES ('1764', '210', '0', '石峰区', '3');
INSERT INTO `cmf_district` VALUES ('1765', '210', '0', '醴陵市', '3');
INSERT INTO `cmf_district` VALUES ('1766', '210', '0', '株洲县', '3');
INSERT INTO `cmf_district` VALUES ('1767', '210', '0', '攸县', '3');
INSERT INTO `cmf_district` VALUES ('1768', '210', '0', '茶陵县', '3');
INSERT INTO `cmf_district` VALUES ('1769', '210', '0', '炎陵县', '3');
INSERT INTO `cmf_district` VALUES ('1770', '211', '0', '朝阳区', '3');
INSERT INTO `cmf_district` VALUES ('1771', '211', '0', '宽城区', '3');
INSERT INTO `cmf_district` VALUES ('1772', '211', '0', '二道区', '3');
INSERT INTO `cmf_district` VALUES ('1773', '211', '0', '南关区', '3');
INSERT INTO `cmf_district` VALUES ('1774', '211', '0', '绿园区', '3');
INSERT INTO `cmf_district` VALUES ('1775', '211', '0', '双阳区', '3');
INSERT INTO `cmf_district` VALUES ('1776', '211', '0', '净月潭开发区', '3');
INSERT INTO `cmf_district` VALUES ('1777', '211', '0', '高新技术开发区', '3');
INSERT INTO `cmf_district` VALUES ('1778', '211', '0', '经济技术开发区', '3');
INSERT INTO `cmf_district` VALUES ('1779', '211', '0', '汽车产业开发区', '3');
INSERT INTO `cmf_district` VALUES ('1780', '211', '0', '德惠市', '3');
INSERT INTO `cmf_district` VALUES ('1781', '211', '0', '九台市', '3');
INSERT INTO `cmf_district` VALUES ('1782', '211', '0', '榆树市', '3');
INSERT INTO `cmf_district` VALUES ('1783', '211', '0', '农安县', '3');
INSERT INTO `cmf_district` VALUES ('1784', '212', '0', '船营区', '3');
INSERT INTO `cmf_district` VALUES ('1785', '212', '0', '昌邑区', '3');
INSERT INTO `cmf_district` VALUES ('1786', '212', '0', '龙潭区', '3');
INSERT INTO `cmf_district` VALUES ('1787', '212', '0', '丰满区', '3');
INSERT INTO `cmf_district` VALUES ('1788', '212', '0', '蛟河市', '3');
INSERT INTO `cmf_district` VALUES ('1789', '212', '0', '桦甸市', '3');
INSERT INTO `cmf_district` VALUES ('1790', '212', '0', '舒兰市', '3');
INSERT INTO `cmf_district` VALUES ('1791', '212', '0', '磐石市', '3');
INSERT INTO `cmf_district` VALUES ('1792', '212', '0', '永吉县', '3');
INSERT INTO `cmf_district` VALUES ('1793', '213', '0', '洮北区', '3');
INSERT INTO `cmf_district` VALUES ('1794', '213', '0', '洮南市', '3');
INSERT INTO `cmf_district` VALUES ('1795', '213', '0', '大安市', '3');
INSERT INTO `cmf_district` VALUES ('1796', '213', '0', '镇赉县', '3');
INSERT INTO `cmf_district` VALUES ('1797', '213', '0', '通榆县', '3');
INSERT INTO `cmf_district` VALUES ('1798', '214', '0', '江源区', '3');
INSERT INTO `cmf_district` VALUES ('1799', '214', '0', '八道江区', '3');
INSERT INTO `cmf_district` VALUES ('1800', '214', '0', '长白', '3');
INSERT INTO `cmf_district` VALUES ('1801', '214', '0', '临江市', '3');
INSERT INTO `cmf_district` VALUES ('1802', '214', '0', '抚松县', '3');
INSERT INTO `cmf_district` VALUES ('1803', '214', '0', '靖宇县', '3');
INSERT INTO `cmf_district` VALUES ('1804', '215', '0', '龙山区', '3');
INSERT INTO `cmf_district` VALUES ('1805', '215', '0', '西安区', '3');
INSERT INTO `cmf_district` VALUES ('1806', '215', '0', '东丰县', '3');
INSERT INTO `cmf_district` VALUES ('1807', '215', '0', '东辽县', '3');
INSERT INTO `cmf_district` VALUES ('1808', '216', '0', '铁西区', '3');
INSERT INTO `cmf_district` VALUES ('1809', '216', '0', '铁东区', '3');
INSERT INTO `cmf_district` VALUES ('1810', '216', '0', '伊通', '3');
INSERT INTO `cmf_district` VALUES ('1811', '216', '0', '公主岭市', '3');
INSERT INTO `cmf_district` VALUES ('1812', '216', '0', '双辽市', '3');
INSERT INTO `cmf_district` VALUES ('1813', '216', '0', '梨树县', '3');
INSERT INTO `cmf_district` VALUES ('1814', '217', '0', '前郭尔罗斯', '3');
INSERT INTO `cmf_district` VALUES ('1815', '217', '0', '宁江区', '3');
INSERT INTO `cmf_district` VALUES ('1816', '217', '0', '长岭县', '3');
INSERT INTO `cmf_district` VALUES ('1817', '217', '0', '乾安县', '3');
INSERT INTO `cmf_district` VALUES ('1818', '217', '0', '扶余县', '3');
INSERT INTO `cmf_district` VALUES ('1819', '218', '0', '东昌区', '3');
INSERT INTO `cmf_district` VALUES ('1820', '218', '0', '二道江区', '3');
INSERT INTO `cmf_district` VALUES ('1821', '218', '0', '梅河口市', '3');
INSERT INTO `cmf_district` VALUES ('1822', '218', '0', '集安市', '3');
INSERT INTO `cmf_district` VALUES ('1823', '218', '0', '通化县', '3');
INSERT INTO `cmf_district` VALUES ('1824', '218', '0', '辉南县', '3');
INSERT INTO `cmf_district` VALUES ('1825', '218', '0', '柳河县', '3');
INSERT INTO `cmf_district` VALUES ('1826', '219', '0', '延吉市', '3');
INSERT INTO `cmf_district` VALUES ('1827', '219', '0', '图们市', '3');
INSERT INTO `cmf_district` VALUES ('1828', '219', '0', '敦化市', '3');
INSERT INTO `cmf_district` VALUES ('1829', '219', '0', '珲春市', '3');
INSERT INTO `cmf_district` VALUES ('1830', '219', '0', '龙井市', '3');
INSERT INTO `cmf_district` VALUES ('1831', '219', '0', '和龙市', '3');
INSERT INTO `cmf_district` VALUES ('1832', '219', '0', '安图县', '3');
INSERT INTO `cmf_district` VALUES ('1833', '219', '0', '汪清县', '3');
INSERT INTO `cmf_district` VALUES ('1834', '220', '0', '玄武区', '3');
INSERT INTO `cmf_district` VALUES ('1835', '220', '0', '鼓楼区', '3');
INSERT INTO `cmf_district` VALUES ('1836', '220', '0', '白下区', '3');
INSERT INTO `cmf_district` VALUES ('1837', '220', '0', '建邺区', '3');
INSERT INTO `cmf_district` VALUES ('1838', '220', '0', '秦淮区', '3');
INSERT INTO `cmf_district` VALUES ('1839', '220', '0', '雨花台区', '3');
INSERT INTO `cmf_district` VALUES ('1840', '220', '0', '下关区', '3');
INSERT INTO `cmf_district` VALUES ('1841', '220', '0', '栖霞区', '3');
INSERT INTO `cmf_district` VALUES ('1842', '220', '0', '浦口区', '3');
INSERT INTO `cmf_district` VALUES ('1843', '220', '0', '江宁区', '3');
INSERT INTO `cmf_district` VALUES ('1844', '220', '0', '六合区', '3');
INSERT INTO `cmf_district` VALUES ('1845', '220', '0', '溧水县', '3');
INSERT INTO `cmf_district` VALUES ('1846', '220', '0', '高淳县', '3');
INSERT INTO `cmf_district` VALUES ('1847', '221', '0', '沧浪区', '3');
INSERT INTO `cmf_district` VALUES ('1848', '221', '0', '金阊区', '3');
INSERT INTO `cmf_district` VALUES ('1849', '221', '0', '平江区', '3');
INSERT INTO `cmf_district` VALUES ('1850', '221', '0', '虎丘区', '3');
INSERT INTO `cmf_district` VALUES ('1851', '221', '0', '吴中区', '3');
INSERT INTO `cmf_district` VALUES ('1852', '221', '0', '相城区', '3');
INSERT INTO `cmf_district` VALUES ('1853', '221', '0', '园区', '3');
INSERT INTO `cmf_district` VALUES ('1854', '221', '0', '新区', '3');
INSERT INTO `cmf_district` VALUES ('1855', '221', '0', '常熟市', '3');
INSERT INTO `cmf_district` VALUES ('1856', '221', '0', '张家港市', '3');
INSERT INTO `cmf_district` VALUES ('1857', '221', '0', '玉山镇', '3');
INSERT INTO `cmf_district` VALUES ('1858', '221', '0', '巴城镇', '3');
INSERT INTO `cmf_district` VALUES ('1859', '221', '0', '周市镇', '3');
INSERT INTO `cmf_district` VALUES ('1860', '221', '0', '陆家镇', '3');
INSERT INTO `cmf_district` VALUES ('1861', '221', '0', '花桥镇', '3');
INSERT INTO `cmf_district` VALUES ('1862', '221', '0', '淀山湖镇', '3');
INSERT INTO `cmf_district` VALUES ('1863', '221', '0', '张浦镇', '3');
INSERT INTO `cmf_district` VALUES ('1864', '221', '0', '周庄镇', '3');
INSERT INTO `cmf_district` VALUES ('1865', '221', '0', '千灯镇', '3');
INSERT INTO `cmf_district` VALUES ('1866', '221', '0', '锦溪镇', '3');
INSERT INTO `cmf_district` VALUES ('1867', '221', '0', '开发区', '3');
INSERT INTO `cmf_district` VALUES ('1868', '221', '0', '吴江市', '3');
INSERT INTO `cmf_district` VALUES ('1869', '221', '0', '太仓市', '3');
INSERT INTO `cmf_district` VALUES ('1870', '222', '0', '崇安区', '3');
INSERT INTO `cmf_district` VALUES ('1871', '222', '0', '北塘区', '3');
INSERT INTO `cmf_district` VALUES ('1872', '222', '0', '南长区', '3');
INSERT INTO `cmf_district` VALUES ('1873', '222', '0', '锡山区', '3');
INSERT INTO `cmf_district` VALUES ('1874', '222', '0', '惠山区', '3');
INSERT INTO `cmf_district` VALUES ('1875', '222', '0', '滨湖区', '3');
INSERT INTO `cmf_district` VALUES ('1876', '222', '0', '新区', '3');
INSERT INTO `cmf_district` VALUES ('1877', '222', '0', '江阴市', '3');
INSERT INTO `cmf_district` VALUES ('1878', '222', '0', '宜兴市', '3');
INSERT INTO `cmf_district` VALUES ('1879', '223', '0', '天宁区', '3');
INSERT INTO `cmf_district` VALUES ('1880', '223', '0', '钟楼区', '3');
INSERT INTO `cmf_district` VALUES ('1881', '223', '0', '戚墅堰区', '3');
INSERT INTO `cmf_district` VALUES ('1882', '223', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('1883', '223', '0', '新北区', '3');
INSERT INTO `cmf_district` VALUES ('1884', '223', '0', '武进区', '3');
INSERT INTO `cmf_district` VALUES ('1885', '223', '0', '溧阳市', '3');
INSERT INTO `cmf_district` VALUES ('1886', '223', '0', '金坛市', '3');
INSERT INTO `cmf_district` VALUES ('1887', '224', '0', '清河区', '3');
INSERT INTO `cmf_district` VALUES ('1888', '224', '0', '清浦区', '3');
INSERT INTO `cmf_district` VALUES ('1889', '224', '0', '楚州区', '3');
INSERT INTO `cmf_district` VALUES ('1890', '224', '0', '淮阴区', '3');
INSERT INTO `cmf_district` VALUES ('1891', '224', '0', '涟水县', '3');
INSERT INTO `cmf_district` VALUES ('1892', '224', '0', '洪泽县', '3');
INSERT INTO `cmf_district` VALUES ('1893', '224', '0', '盱眙县', '3');
INSERT INTO `cmf_district` VALUES ('1894', '224', '0', '金湖县', '3');
INSERT INTO `cmf_district` VALUES ('1895', '225', '0', '新浦区', '3');
INSERT INTO `cmf_district` VALUES ('1896', '225', '0', '连云区', '3');
INSERT INTO `cmf_district` VALUES ('1897', '225', '0', '海州区', '3');
INSERT INTO `cmf_district` VALUES ('1898', '225', '0', '赣榆县', '3');
INSERT INTO `cmf_district` VALUES ('1899', '225', '0', '东海县', '3');
INSERT INTO `cmf_district` VALUES ('1900', '225', '0', '灌云县', '3');
INSERT INTO `cmf_district` VALUES ('1901', '225', '0', '灌南县', '3');
INSERT INTO `cmf_district` VALUES ('1902', '226', '0', '崇川区', '3');
INSERT INTO `cmf_district` VALUES ('1903', '226', '0', '港闸区', '3');
INSERT INTO `cmf_district` VALUES ('1904', '226', '0', '经济开发区', '3');
INSERT INTO `cmf_district` VALUES ('1905', '226', '0', '启东市', '3');
INSERT INTO `cmf_district` VALUES ('1906', '226', '0', '如皋市', '3');
INSERT INTO `cmf_district` VALUES ('1907', '226', '0', '通州市', '3');
INSERT INTO `cmf_district` VALUES ('1908', '226', '0', '海门市', '3');
INSERT INTO `cmf_district` VALUES ('1909', '226', '0', '海安县', '3');
INSERT INTO `cmf_district` VALUES ('1910', '226', '0', '如东县', '3');
INSERT INTO `cmf_district` VALUES ('1911', '227', '0', '宿城区', '3');
INSERT INTO `cmf_district` VALUES ('1912', '227', '0', '宿豫区', '3');
INSERT INTO `cmf_district` VALUES ('1913', '227', '0', '宿豫县', '3');
INSERT INTO `cmf_district` VALUES ('1914', '227', '0', '沭阳县', '3');
INSERT INTO `cmf_district` VALUES ('1915', '227', '0', '泗阳县', '3');
INSERT INTO `cmf_district` VALUES ('1916', '227', '0', '泗洪县', '3');
INSERT INTO `cmf_district` VALUES ('1917', '228', '0', '海陵区', '3');
INSERT INTO `cmf_district` VALUES ('1918', '228', '0', '高港区', '3');
INSERT INTO `cmf_district` VALUES ('1919', '228', '0', '兴化市', '3');
INSERT INTO `cmf_district` VALUES ('1920', '228', '0', '靖江市', '3');
INSERT INTO `cmf_district` VALUES ('1921', '228', '0', '泰兴市', '3');
INSERT INTO `cmf_district` VALUES ('1922', '228', '0', '姜堰市', '3');
INSERT INTO `cmf_district` VALUES ('1923', '229', '0', '云龙区', '3');
INSERT INTO `cmf_district` VALUES ('1924', '229', '0', '鼓楼区', '3');
INSERT INTO `cmf_district` VALUES ('1925', '229', '0', '九里区', '3');
INSERT INTO `cmf_district` VALUES ('1926', '229', '0', '贾汪区', '3');
INSERT INTO `cmf_district` VALUES ('1927', '229', '0', '泉山区', '3');
INSERT INTO `cmf_district` VALUES ('1928', '229', '0', '新沂市', '3');
INSERT INTO `cmf_district` VALUES ('1929', '229', '0', '邳州市', '3');
INSERT INTO `cmf_district` VALUES ('1930', '229', '0', '丰县', '3');
INSERT INTO `cmf_district` VALUES ('1931', '229', '0', '沛县', '3');
INSERT INTO `cmf_district` VALUES ('1932', '229', '0', '铜山县', '3');
INSERT INTO `cmf_district` VALUES ('1933', '229', '0', '睢宁县', '3');
INSERT INTO `cmf_district` VALUES ('1934', '230', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('1935', '230', '0', '亭湖区', '3');
INSERT INTO `cmf_district` VALUES ('1936', '230', '0', '盐都区', '3');
INSERT INTO `cmf_district` VALUES ('1937', '230', '0', '盐都县', '3');
INSERT INTO `cmf_district` VALUES ('1938', '230', '0', '东台市', '3');
INSERT INTO `cmf_district` VALUES ('1939', '230', '0', '大丰市', '3');
INSERT INTO `cmf_district` VALUES ('1940', '230', '0', '响水县', '3');
INSERT INTO `cmf_district` VALUES ('1941', '230', '0', '滨海县', '3');
INSERT INTO `cmf_district` VALUES ('1942', '230', '0', '阜宁县', '3');
INSERT INTO `cmf_district` VALUES ('1943', '230', '0', '射阳县', '3');
INSERT INTO `cmf_district` VALUES ('1944', '230', '0', '建湖县', '3');
INSERT INTO `cmf_district` VALUES ('1945', '231', '0', '广陵区', '3');
INSERT INTO `cmf_district` VALUES ('1946', '231', '0', '维扬区', '3');
INSERT INTO `cmf_district` VALUES ('1947', '231', '0', '邗江区', '3');
INSERT INTO `cmf_district` VALUES ('1948', '231', '0', '仪征市', '3');
INSERT INTO `cmf_district` VALUES ('1949', '231', '0', '高邮市', '3');
INSERT INTO `cmf_district` VALUES ('1950', '231', '0', '江都市', '3');
INSERT INTO `cmf_district` VALUES ('1951', '231', '0', '宝应县', '3');
INSERT INTO `cmf_district` VALUES ('1952', '232', '0', '京口区', '3');
INSERT INTO `cmf_district` VALUES ('1953', '232', '0', '润州区', '3');
INSERT INTO `cmf_district` VALUES ('1954', '232', '0', '丹徒区', '3');
INSERT INTO `cmf_district` VALUES ('1955', '232', '0', '丹阳市', '3');
INSERT INTO `cmf_district` VALUES ('1956', '232', '0', '扬中市', '3');
INSERT INTO `cmf_district` VALUES ('1957', '232', '0', '句容市', '3');
INSERT INTO `cmf_district` VALUES ('1958', '233', '0', '东湖区', '3');
INSERT INTO `cmf_district` VALUES ('1959', '233', '0', '西湖区', '3');
INSERT INTO `cmf_district` VALUES ('1960', '233', '0', '青云谱区', '3');
INSERT INTO `cmf_district` VALUES ('1961', '233', '0', '湾里区', '3');
INSERT INTO `cmf_district` VALUES ('1962', '233', '0', '青山湖区', '3');
INSERT INTO `cmf_district` VALUES ('1963', '233', '0', '红谷滩新区', '3');
INSERT INTO `cmf_district` VALUES ('1964', '233', '0', '昌北区', '3');
INSERT INTO `cmf_district` VALUES ('1965', '233', '0', '高新区', '3');
INSERT INTO `cmf_district` VALUES ('1966', '233', '0', '南昌县', '3');
INSERT INTO `cmf_district` VALUES ('1967', '233', '0', '新建县', '3');
INSERT INTO `cmf_district` VALUES ('1968', '233', '0', '安义县', '3');
INSERT INTO `cmf_district` VALUES ('1969', '233', '0', '进贤县', '3');
INSERT INTO `cmf_district` VALUES ('1970', '234', '0', '临川区', '3');
INSERT INTO `cmf_district` VALUES ('1971', '234', '0', '南城县', '3');
INSERT INTO `cmf_district` VALUES ('1972', '234', '0', '黎川县', '3');
INSERT INTO `cmf_district` VALUES ('1973', '234', '0', '南丰县', '3');
INSERT INTO `cmf_district` VALUES ('1974', '234', '0', '崇仁县', '3');
INSERT INTO `cmf_district` VALUES ('1975', '234', '0', '乐安县', '3');
INSERT INTO `cmf_district` VALUES ('1976', '234', '0', '宜黄县', '3');
INSERT INTO `cmf_district` VALUES ('1977', '234', '0', '金溪县', '3');
INSERT INTO `cmf_district` VALUES ('1978', '234', '0', '资溪县', '3');
INSERT INTO `cmf_district` VALUES ('1979', '234', '0', '东乡县', '3');
INSERT INTO `cmf_district` VALUES ('1980', '234', '0', '广昌县', '3');
INSERT INTO `cmf_district` VALUES ('1981', '235', '0', '章贡区', '3');
INSERT INTO `cmf_district` VALUES ('1982', '235', '0', '于都县', '3');
INSERT INTO `cmf_district` VALUES ('1983', '235', '0', '瑞金市', '3');
INSERT INTO `cmf_district` VALUES ('1984', '235', '0', '南康市', '3');
INSERT INTO `cmf_district` VALUES ('1985', '235', '0', '赣县', '3');
INSERT INTO `cmf_district` VALUES ('1986', '235', '0', '信丰县', '3');
INSERT INTO `cmf_district` VALUES ('1987', '235', '0', '大余县', '3');
INSERT INTO `cmf_district` VALUES ('1988', '235', '0', '上犹县', '3');
INSERT INTO `cmf_district` VALUES ('1989', '235', '0', '崇义县', '3');
INSERT INTO `cmf_district` VALUES ('1990', '235', '0', '安远县', '3');
INSERT INTO `cmf_district` VALUES ('1991', '235', '0', '龙南县', '3');
INSERT INTO `cmf_district` VALUES ('1992', '235', '0', '定南县', '3');
INSERT INTO `cmf_district` VALUES ('1993', '235', '0', '全南县', '3');
INSERT INTO `cmf_district` VALUES ('1994', '235', '0', '宁都县', '3');
INSERT INTO `cmf_district` VALUES ('1995', '235', '0', '兴国县', '3');
INSERT INTO `cmf_district` VALUES ('1996', '235', '0', '会昌县', '3');
INSERT INTO `cmf_district` VALUES ('1997', '235', '0', '寻乌县', '3');
INSERT INTO `cmf_district` VALUES ('1998', '235', '0', '石城县', '3');
INSERT INTO `cmf_district` VALUES ('1999', '236', '0', '安福县', '3');
INSERT INTO `cmf_district` VALUES ('2000', '236', '0', '吉州区', '3');
INSERT INTO `cmf_district` VALUES ('2001', '236', '0', '青原区', '3');
INSERT INTO `cmf_district` VALUES ('2002', '236', '0', '井冈山市', '3');
INSERT INTO `cmf_district` VALUES ('2003', '236', '0', '吉安县', '3');
INSERT INTO `cmf_district` VALUES ('2004', '236', '0', '吉水县', '3');
INSERT INTO `cmf_district` VALUES ('2005', '236', '0', '峡江县', '3');
INSERT INTO `cmf_district` VALUES ('2006', '236', '0', '新干县', '3');
INSERT INTO `cmf_district` VALUES ('2007', '236', '0', '永丰县', '3');
INSERT INTO `cmf_district` VALUES ('2008', '236', '0', '泰和县', '3');
INSERT INTO `cmf_district` VALUES ('2009', '236', '0', '遂川县', '3');
INSERT INTO `cmf_district` VALUES ('2010', '236', '0', '万安县', '3');
INSERT INTO `cmf_district` VALUES ('2011', '236', '0', '永新县', '3');
INSERT INTO `cmf_district` VALUES ('2012', '237', '0', '珠山区', '3');
INSERT INTO `cmf_district` VALUES ('2013', '237', '0', '昌江区', '3');
INSERT INTO `cmf_district` VALUES ('2014', '237', '0', '乐平市', '3');
INSERT INTO `cmf_district` VALUES ('2015', '237', '0', '浮梁县', '3');
INSERT INTO `cmf_district` VALUES ('2016', '238', '0', '浔阳区', '3');
INSERT INTO `cmf_district` VALUES ('2017', '238', '0', '庐山区', '3');
INSERT INTO `cmf_district` VALUES ('2018', '238', '0', '瑞昌市', '3');
INSERT INTO `cmf_district` VALUES ('2019', '238', '0', '九江县', '3');
INSERT INTO `cmf_district` VALUES ('2020', '238', '0', '武宁县', '3');
INSERT INTO `cmf_district` VALUES ('2021', '238', '0', '修水县', '3');
INSERT INTO `cmf_district` VALUES ('2022', '238', '0', '永修县', '3');
INSERT INTO `cmf_district` VALUES ('2023', '238', '0', '德安县', '3');
INSERT INTO `cmf_district` VALUES ('2024', '238', '0', '星子县', '3');
INSERT INTO `cmf_district` VALUES ('2025', '238', '0', '都昌县', '3');
INSERT INTO `cmf_district` VALUES ('2026', '238', '0', '湖口县', '3');
INSERT INTO `cmf_district` VALUES ('2027', '238', '0', '彭泽县', '3');
INSERT INTO `cmf_district` VALUES ('2028', '239', '0', '安源区', '3');
INSERT INTO `cmf_district` VALUES ('2029', '239', '0', '湘东区', '3');
INSERT INTO `cmf_district` VALUES ('2030', '239', '0', '莲花县', '3');
INSERT INTO `cmf_district` VALUES ('2031', '239', '0', '芦溪县', '3');
INSERT INTO `cmf_district` VALUES ('2032', '239', '0', '上栗县', '3');
INSERT INTO `cmf_district` VALUES ('2033', '240', '0', '信州区', '3');
INSERT INTO `cmf_district` VALUES ('2034', '240', '0', '德兴市', '3');
INSERT INTO `cmf_district` VALUES ('2035', '240', '0', '上饶县', '3');
INSERT INTO `cmf_district` VALUES ('2036', '240', '0', '广丰县', '3');
INSERT INTO `cmf_district` VALUES ('2037', '240', '0', '玉山县', '3');
INSERT INTO `cmf_district` VALUES ('2038', '240', '0', '铅山县', '3');
INSERT INTO `cmf_district` VALUES ('2039', '240', '0', '横峰县', '3');
INSERT INTO `cmf_district` VALUES ('2040', '240', '0', '弋阳县', '3');
INSERT INTO `cmf_district` VALUES ('2041', '240', '0', '余干县', '3');
INSERT INTO `cmf_district` VALUES ('2042', '240', '0', '波阳县', '3');
INSERT INTO `cmf_district` VALUES ('2043', '240', '0', '万年县', '3');
INSERT INTO `cmf_district` VALUES ('2044', '240', '0', '婺源县', '3');
INSERT INTO `cmf_district` VALUES ('2045', '241', '0', '渝水区', '3');
INSERT INTO `cmf_district` VALUES ('2046', '241', '0', '分宜县', '3');
INSERT INTO `cmf_district` VALUES ('2047', '242', '0', '袁州区', '3');
INSERT INTO `cmf_district` VALUES ('2048', '242', '0', '丰城市', '3');
INSERT INTO `cmf_district` VALUES ('2049', '242', '0', '樟树市', '3');
INSERT INTO `cmf_district` VALUES ('2050', '242', '0', '高安市', '3');
INSERT INTO `cmf_district` VALUES ('2051', '242', '0', '奉新县', '3');
INSERT INTO `cmf_district` VALUES ('2052', '242', '0', '万载县', '3');
INSERT INTO `cmf_district` VALUES ('2053', '242', '0', '上高县', '3');
INSERT INTO `cmf_district` VALUES ('2054', '242', '0', '宜丰县', '3');
INSERT INTO `cmf_district` VALUES ('2055', '242', '0', '靖安县', '3');
INSERT INTO `cmf_district` VALUES ('2056', '242', '0', '铜鼓县', '3');
INSERT INTO `cmf_district` VALUES ('2057', '243', '0', '月湖区', '3');
INSERT INTO `cmf_district` VALUES ('2058', '243', '0', '贵溪市', '3');
INSERT INTO `cmf_district` VALUES ('2059', '243', '0', '余江县', '3');
INSERT INTO `cmf_district` VALUES ('2060', '244', '0', '沈河区', '3');
INSERT INTO `cmf_district` VALUES ('2061', '244', '0', '皇姑区', '3');
INSERT INTO `cmf_district` VALUES ('2062', '244', '0', '和平区', '3');
INSERT INTO `cmf_district` VALUES ('2063', '244', '0', '大东区', '3');
INSERT INTO `cmf_district` VALUES ('2064', '244', '0', '铁西区', '3');
INSERT INTO `cmf_district` VALUES ('2065', '244', '0', '苏家屯区', '3');
INSERT INTO `cmf_district` VALUES ('2066', '244', '0', '东陵区', '3');
INSERT INTO `cmf_district` VALUES ('2067', '244', '0', '沈北新区', '3');
INSERT INTO `cmf_district` VALUES ('2068', '244', '0', '于洪区', '3');
INSERT INTO `cmf_district` VALUES ('2069', '244', '0', '浑南新区', '3');
INSERT INTO `cmf_district` VALUES ('2070', '244', '0', '新民市', '3');
INSERT INTO `cmf_district` VALUES ('2071', '244', '0', '辽中县', '3');
INSERT INTO `cmf_district` VALUES ('2072', '244', '0', '康平县', '3');
INSERT INTO `cmf_district` VALUES ('2073', '244', '0', '法库县', '3');
INSERT INTO `cmf_district` VALUES ('2074', '245', '0', '西岗区', '3');
INSERT INTO `cmf_district` VALUES ('2075', '245', '0', '中山区', '3');
INSERT INTO `cmf_district` VALUES ('2076', '245', '0', '沙河口区', '3');
INSERT INTO `cmf_district` VALUES ('2077', '245', '0', '甘井子区', '3');
INSERT INTO `cmf_district` VALUES ('2078', '245', '0', '旅顺口区', '3');
INSERT INTO `cmf_district` VALUES ('2079', '245', '0', '金州区', '3');
INSERT INTO `cmf_district` VALUES ('2080', '245', '0', '开发区', '3');
INSERT INTO `cmf_district` VALUES ('2081', '245', '0', '瓦房店市', '3');
INSERT INTO `cmf_district` VALUES ('2082', '245', '0', '普兰店市', '3');
INSERT INTO `cmf_district` VALUES ('2083', '245', '0', '庄河市', '3');
INSERT INTO `cmf_district` VALUES ('2084', '245', '0', '长海县', '3');
INSERT INTO `cmf_district` VALUES ('2085', '246', '0', '铁东区', '3');
INSERT INTO `cmf_district` VALUES ('2086', '246', '0', '铁西区', '3');
INSERT INTO `cmf_district` VALUES ('2087', '246', '0', '立山区', '3');
INSERT INTO `cmf_district` VALUES ('2088', '246', '0', '千山区', '3');
INSERT INTO `cmf_district` VALUES ('2089', '246', '0', '岫岩', '3');
INSERT INTO `cmf_district` VALUES ('2090', '246', '0', '海城市', '3');
INSERT INTO `cmf_district` VALUES ('2091', '246', '0', '台安县', '3');
INSERT INTO `cmf_district` VALUES ('2092', '247', '0', '本溪', '3');
INSERT INTO `cmf_district` VALUES ('2093', '247', '0', '平山区', '3');
INSERT INTO `cmf_district` VALUES ('2094', '247', '0', '明山区', '3');
INSERT INTO `cmf_district` VALUES ('2095', '247', '0', '溪湖区', '3');
INSERT INTO `cmf_district` VALUES ('2096', '247', '0', '南芬区', '3');
INSERT INTO `cmf_district` VALUES ('2097', '247', '0', '桓仁', '3');
INSERT INTO `cmf_district` VALUES ('2098', '248', '0', '双塔区', '3');
INSERT INTO `cmf_district` VALUES ('2099', '248', '0', '龙城区', '3');
INSERT INTO `cmf_district` VALUES ('2100', '248', '0', '喀喇沁左翼蒙古族自治县', '3');
INSERT INTO `cmf_district` VALUES ('2101', '248', '0', '北票市', '3');
INSERT INTO `cmf_district` VALUES ('2102', '248', '0', '凌源市', '3');
INSERT INTO `cmf_district` VALUES ('2103', '248', '0', '朝阳县', '3');
INSERT INTO `cmf_district` VALUES ('2104', '248', '0', '建平县', '3');
INSERT INTO `cmf_district` VALUES ('2105', '249', '0', '振兴区', '3');
INSERT INTO `cmf_district` VALUES ('2106', '249', '0', '元宝区', '3');
INSERT INTO `cmf_district` VALUES ('2107', '249', '0', '振安区', '3');
INSERT INTO `cmf_district` VALUES ('2108', '249', '0', '宽甸', '3');
INSERT INTO `cmf_district` VALUES ('2109', '249', '0', '东港市', '3');
INSERT INTO `cmf_district` VALUES ('2110', '249', '0', '凤城市', '3');
INSERT INTO `cmf_district` VALUES ('2111', '250', '0', '顺城区', '3');
INSERT INTO `cmf_district` VALUES ('2112', '250', '0', '新抚区', '3');
INSERT INTO `cmf_district` VALUES ('2113', '250', '0', '东洲区', '3');
INSERT INTO `cmf_district` VALUES ('2114', '250', '0', '望花区', '3');
INSERT INTO `cmf_district` VALUES ('2115', '250', '0', '清原', '3');
INSERT INTO `cmf_district` VALUES ('2116', '250', '0', '新宾', '3');
INSERT INTO `cmf_district` VALUES ('2117', '250', '0', '抚顺县', '3');
INSERT INTO `cmf_district` VALUES ('2118', '251', '0', '阜新', '3');
INSERT INTO `cmf_district` VALUES ('2119', '251', '0', '海州区', '3');
INSERT INTO `cmf_district` VALUES ('2120', '251', '0', '新邱区', '3');
INSERT INTO `cmf_district` VALUES ('2121', '251', '0', '太平区', '3');
INSERT INTO `cmf_district` VALUES ('2122', '251', '0', '清河门区', '3');
INSERT INTO `cmf_district` VALUES ('2123', '251', '0', '细河区', '3');
INSERT INTO `cmf_district` VALUES ('2124', '251', '0', '彰武县', '3');
INSERT INTO `cmf_district` VALUES ('2125', '252', '0', '龙港区', '3');
INSERT INTO `cmf_district` VALUES ('2126', '252', '0', '南票区', '3');
INSERT INTO `cmf_district` VALUES ('2127', '252', '0', '连山区', '3');
INSERT INTO `cmf_district` VALUES ('2128', '252', '0', '兴城市', '3');
INSERT INTO `cmf_district` VALUES ('2129', '252', '0', '绥中县', '3');
INSERT INTO `cmf_district` VALUES ('2130', '252', '0', '建昌县', '3');
INSERT INTO `cmf_district` VALUES ('2131', '253', '0', '太和区', '3');
INSERT INTO `cmf_district` VALUES ('2132', '253', '0', '古塔区', '3');
INSERT INTO `cmf_district` VALUES ('2133', '253', '0', '凌河区', '3');
INSERT INTO `cmf_district` VALUES ('2134', '253', '0', '凌海市', '3');
INSERT INTO `cmf_district` VALUES ('2135', '253', '0', '北镇市', '3');
INSERT INTO `cmf_district` VALUES ('2136', '253', '0', '黑山县', '3');
INSERT INTO `cmf_district` VALUES ('2137', '253', '0', '义县', '3');
INSERT INTO `cmf_district` VALUES ('2138', '254', '0', '白塔区', '3');
INSERT INTO `cmf_district` VALUES ('2139', '254', '0', '文圣区', '3');
INSERT INTO `cmf_district` VALUES ('2140', '254', '0', '宏伟区', '3');
INSERT INTO `cmf_district` VALUES ('2141', '254', '0', '太子河区', '3');
INSERT INTO `cmf_district` VALUES ('2142', '254', '0', '弓长岭区', '3');
INSERT INTO `cmf_district` VALUES ('2143', '254', '0', '灯塔市', '3');
INSERT INTO `cmf_district` VALUES ('2144', '254', '0', '辽阳县', '3');
INSERT INTO `cmf_district` VALUES ('2145', '255', '0', '双台子区', '3');
INSERT INTO `cmf_district` VALUES ('2146', '255', '0', '兴隆台区', '3');
INSERT INTO `cmf_district` VALUES ('2147', '255', '0', '大洼县', '3');
INSERT INTO `cmf_district` VALUES ('2148', '255', '0', '盘山县', '3');
INSERT INTO `cmf_district` VALUES ('2149', '256', '0', '银州区', '3');
INSERT INTO `cmf_district` VALUES ('2150', '256', '0', '清河区', '3');
INSERT INTO `cmf_district` VALUES ('2151', '256', '0', '调兵山市', '3');
INSERT INTO `cmf_district` VALUES ('2152', '256', '0', '开原市', '3');
INSERT INTO `cmf_district` VALUES ('2153', '256', '0', '铁岭县', '3');
INSERT INTO `cmf_district` VALUES ('2154', '256', '0', '西丰县', '3');
INSERT INTO `cmf_district` VALUES ('2155', '256', '0', '昌图县', '3');
INSERT INTO `cmf_district` VALUES ('2156', '257', '0', '站前区', '3');
INSERT INTO `cmf_district` VALUES ('2157', '257', '0', '西市区', '3');
INSERT INTO `cmf_district` VALUES ('2158', '257', '0', '鲅鱼圈区', '3');
INSERT INTO `cmf_district` VALUES ('2159', '257', '0', '老边区', '3');
INSERT INTO `cmf_district` VALUES ('2160', '257', '0', '盖州市', '3');
INSERT INTO `cmf_district` VALUES ('2161', '257', '0', '大石桥市', '3');
INSERT INTO `cmf_district` VALUES ('2162', '258', '0', '回民区', '3');
INSERT INTO `cmf_district` VALUES ('2163', '258', '0', '玉泉区', '3');
INSERT INTO `cmf_district` VALUES ('2164', '258', '0', '新城区', '3');
INSERT INTO `cmf_district` VALUES ('2165', '258', '0', '赛罕区', '3');
INSERT INTO `cmf_district` VALUES ('2166', '258', '0', '清水河县', '3');
INSERT INTO `cmf_district` VALUES ('2167', '258', '0', '土默特左旗', '3');
INSERT INTO `cmf_district` VALUES ('2168', '258', '0', '托克托县', '3');
INSERT INTO `cmf_district` VALUES ('2169', '258', '0', '和林格尔县', '3');
INSERT INTO `cmf_district` VALUES ('2170', '258', '0', '武川县', '3');
INSERT INTO `cmf_district` VALUES ('2171', '259', '0', '阿拉善左旗', '3');
INSERT INTO `cmf_district` VALUES ('2172', '259', '0', '阿拉善右旗', '3');
INSERT INTO `cmf_district` VALUES ('2173', '259', '0', '额济纳旗', '3');
INSERT INTO `cmf_district` VALUES ('2174', '260', '0', '临河区', '3');
INSERT INTO `cmf_district` VALUES ('2175', '260', '0', '五原县', '3');
INSERT INTO `cmf_district` VALUES ('2176', '260', '0', '磴口县', '3');
INSERT INTO `cmf_district` VALUES ('2177', '260', '0', '乌拉特前旗', '3');
INSERT INTO `cmf_district` VALUES ('2178', '260', '0', '乌拉特中旗', '3');
INSERT INTO `cmf_district` VALUES ('2179', '260', '0', '乌拉特后旗', '3');
INSERT INTO `cmf_district` VALUES ('2180', '260', '0', '杭锦后旗', '3');
INSERT INTO `cmf_district` VALUES ('2181', '261', '0', '昆都仑区', '3');
INSERT INTO `cmf_district` VALUES ('2182', '261', '0', '青山区', '3');
INSERT INTO `cmf_district` VALUES ('2183', '261', '0', '东河区', '3');
INSERT INTO `cmf_district` VALUES ('2184', '261', '0', '九原区', '3');
INSERT INTO `cmf_district` VALUES ('2185', '261', '0', '石拐区', '3');
INSERT INTO `cmf_district` VALUES ('2186', '261', '0', '白云矿区', '3');
INSERT INTO `cmf_district` VALUES ('2187', '261', '0', '土默特右旗', '3');
INSERT INTO `cmf_district` VALUES ('2188', '261', '0', '固阳县', '3');
INSERT INTO `cmf_district` VALUES ('2189', '261', '0', '达尔罕茂明安联合旗', '3');
INSERT INTO `cmf_district` VALUES ('2190', '262', '0', '红山区', '3');
INSERT INTO `cmf_district` VALUES ('2191', '262', '0', '元宝山区', '3');
INSERT INTO `cmf_district` VALUES ('2192', '262', '0', '松山区', '3');
INSERT INTO `cmf_district` VALUES ('2193', '262', '0', '阿鲁科尔沁旗', '3');
INSERT INTO `cmf_district` VALUES ('2194', '262', '0', '巴林左旗', '3');
INSERT INTO `cmf_district` VALUES ('2195', '262', '0', '巴林右旗', '3');
INSERT INTO `cmf_district` VALUES ('2196', '262', '0', '林西县', '3');
INSERT INTO `cmf_district` VALUES ('2197', '262', '0', '克什克腾旗', '3');
INSERT INTO `cmf_district` VALUES ('2198', '262', '0', '翁牛特旗', '3');
INSERT INTO `cmf_district` VALUES ('2199', '262', '0', '喀喇沁旗', '3');
INSERT INTO `cmf_district` VALUES ('2200', '262', '0', '宁城县', '3');
INSERT INTO `cmf_district` VALUES ('2201', '262', '0', '敖汉旗', '3');
INSERT INTO `cmf_district` VALUES ('2202', '263', '0', '东胜区', '3');
INSERT INTO `cmf_district` VALUES ('2203', '263', '0', '达拉特旗', '3');
INSERT INTO `cmf_district` VALUES ('2204', '263', '0', '准格尔旗', '3');
INSERT INTO `cmf_district` VALUES ('2205', '263', '0', '鄂托克前旗', '3');
INSERT INTO `cmf_district` VALUES ('2206', '263', '0', '鄂托克旗', '3');
INSERT INTO `cmf_district` VALUES ('2207', '263', '0', '杭锦旗', '3');
INSERT INTO `cmf_district` VALUES ('2208', '263', '0', '乌审旗', '3');
INSERT INTO `cmf_district` VALUES ('2209', '263', '0', '伊金霍洛旗', '3');
INSERT INTO `cmf_district` VALUES ('2210', '264', '0', '海拉尔区', '3');
INSERT INTO `cmf_district` VALUES ('2211', '264', '0', '莫力达瓦', '3');
INSERT INTO `cmf_district` VALUES ('2212', '264', '0', '满洲里市', '3');
INSERT INTO `cmf_district` VALUES ('2213', '264', '0', '牙克石市', '3');
INSERT INTO `cmf_district` VALUES ('2214', '264', '0', '扎兰屯市', '3');
INSERT INTO `cmf_district` VALUES ('2215', '264', '0', '额尔古纳市', '3');
INSERT INTO `cmf_district` VALUES ('2216', '264', '0', '根河市', '3');
INSERT INTO `cmf_district` VALUES ('2217', '264', '0', '阿荣旗', '3');
INSERT INTO `cmf_district` VALUES ('2218', '264', '0', '鄂伦春自治旗', '3');
INSERT INTO `cmf_district` VALUES ('2219', '264', '0', '鄂温克族自治旗', '3');
INSERT INTO `cmf_district` VALUES ('2220', '264', '0', '陈巴尔虎旗', '3');
INSERT INTO `cmf_district` VALUES ('2221', '264', '0', '新巴尔虎左旗', '3');
INSERT INTO `cmf_district` VALUES ('2222', '264', '0', '新巴尔虎右旗', '3');
INSERT INTO `cmf_district` VALUES ('2223', '265', '0', '科尔沁区', '3');
INSERT INTO `cmf_district` VALUES ('2224', '265', '0', '霍林郭勒市', '3');
INSERT INTO `cmf_district` VALUES ('2225', '265', '0', '科尔沁左翼中旗', '3');
INSERT INTO `cmf_district` VALUES ('2226', '265', '0', '科尔沁左翼后旗', '3');
INSERT INTO `cmf_district` VALUES ('2227', '265', '0', '开鲁县', '3');
INSERT INTO `cmf_district` VALUES ('2228', '265', '0', '库伦旗', '3');
INSERT INTO `cmf_district` VALUES ('2229', '265', '0', '奈曼旗', '3');
INSERT INTO `cmf_district` VALUES ('2230', '265', '0', '扎鲁特旗', '3');
INSERT INTO `cmf_district` VALUES ('2231', '266', '0', '海勃湾区', '3');
INSERT INTO `cmf_district` VALUES ('2232', '266', '0', '乌达区', '3');
INSERT INTO `cmf_district` VALUES ('2233', '266', '0', '海南区', '3');
INSERT INTO `cmf_district` VALUES ('2234', '267', '0', '化德县', '3');
INSERT INTO `cmf_district` VALUES ('2235', '267', '0', '集宁区', '3');
INSERT INTO `cmf_district` VALUES ('2236', '267', '0', '丰镇市', '3');
INSERT INTO `cmf_district` VALUES ('2237', '267', '0', '卓资县', '3');
INSERT INTO `cmf_district` VALUES ('2238', '267', '0', '商都县', '3');
INSERT INTO `cmf_district` VALUES ('2239', '267', '0', '兴和县', '3');
INSERT INTO `cmf_district` VALUES ('2240', '267', '0', '凉城县', '3');
INSERT INTO `cmf_district` VALUES ('2241', '267', '0', '察哈尔右翼前旗', '3');
INSERT INTO `cmf_district` VALUES ('2242', '267', '0', '察哈尔右翼中旗', '3');
INSERT INTO `cmf_district` VALUES ('2243', '267', '0', '察哈尔右翼后旗', '3');
INSERT INTO `cmf_district` VALUES ('2244', '267', '0', '四子王旗', '3');
INSERT INTO `cmf_district` VALUES ('2245', '268', '0', '二连浩特市', '3');
INSERT INTO `cmf_district` VALUES ('2246', '268', '0', '锡林浩特市', '3');
INSERT INTO `cmf_district` VALUES ('2247', '268', '0', '阿巴嘎旗', '3');
INSERT INTO `cmf_district` VALUES ('2248', '268', '0', '苏尼特左旗', '3');
INSERT INTO `cmf_district` VALUES ('2249', '268', '0', '苏尼特右旗', '3');
INSERT INTO `cmf_district` VALUES ('2250', '268', '0', '东乌珠穆沁旗', '3');
INSERT INTO `cmf_district` VALUES ('2251', '268', '0', '西乌珠穆沁旗', '3');
INSERT INTO `cmf_district` VALUES ('2252', '268', '0', '太仆寺旗', '3');
INSERT INTO `cmf_district` VALUES ('2253', '268', '0', '镶黄旗', '3');
INSERT INTO `cmf_district` VALUES ('2254', '268', '0', '正镶白旗', '3');
INSERT INTO `cmf_district` VALUES ('2255', '268', '0', '正蓝旗', '3');
INSERT INTO `cmf_district` VALUES ('2256', '268', '0', '多伦县', '3');
INSERT INTO `cmf_district` VALUES ('2257', '269', '0', '乌兰浩特市', '3');
INSERT INTO `cmf_district` VALUES ('2258', '269', '0', '阿尔山市', '3');
INSERT INTO `cmf_district` VALUES ('2259', '269', '0', '科尔沁右翼前旗', '3');
INSERT INTO `cmf_district` VALUES ('2260', '269', '0', '科尔沁右翼中旗', '3');
INSERT INTO `cmf_district` VALUES ('2261', '269', '0', '扎赉特旗', '3');
INSERT INTO `cmf_district` VALUES ('2262', '269', '0', '突泉县', '3');
INSERT INTO `cmf_district` VALUES ('2263', '270', '0', '西夏区', '3');
INSERT INTO `cmf_district` VALUES ('2264', '270', '0', '金凤区', '3');
INSERT INTO `cmf_district` VALUES ('2265', '270', '0', '兴庆区', '3');
INSERT INTO `cmf_district` VALUES ('2266', '270', '0', '灵武市', '3');
INSERT INTO `cmf_district` VALUES ('2267', '270', '0', '永宁县', '3');
INSERT INTO `cmf_district` VALUES ('2268', '270', '0', '贺兰县', '3');
INSERT INTO `cmf_district` VALUES ('2269', '271', '0', '原州区', '3');
INSERT INTO `cmf_district` VALUES ('2270', '271', '0', '海原县', '3');
INSERT INTO `cmf_district` VALUES ('2271', '271', '0', '西吉县', '3');
INSERT INTO `cmf_district` VALUES ('2272', '271', '0', '隆德县', '3');
INSERT INTO `cmf_district` VALUES ('2273', '271', '0', '泾源县', '3');
INSERT INTO `cmf_district` VALUES ('2274', '271', '0', '彭阳县', '3');
INSERT INTO `cmf_district` VALUES ('2275', '272', '0', '惠农县', '3');
INSERT INTO `cmf_district` VALUES ('2276', '272', '0', '大武口区', '3');
INSERT INTO `cmf_district` VALUES ('2277', '272', '0', '惠农区', '3');
INSERT INTO `cmf_district` VALUES ('2278', '272', '0', '陶乐县', '3');
INSERT INTO `cmf_district` VALUES ('2279', '272', '0', '平罗县', '3');
INSERT INTO `cmf_district` VALUES ('2280', '273', '0', '利通区', '3');
INSERT INTO `cmf_district` VALUES ('2281', '273', '0', '中卫县', '3');
INSERT INTO `cmf_district` VALUES ('2282', '273', '0', '青铜峡市', '3');
INSERT INTO `cmf_district` VALUES ('2283', '273', '0', '中宁县', '3');
INSERT INTO `cmf_district` VALUES ('2284', '273', '0', '盐池县', '3');
INSERT INTO `cmf_district` VALUES ('2285', '273', '0', '同心县', '3');
INSERT INTO `cmf_district` VALUES ('2286', '274', '0', '沙坡头区', '3');
INSERT INTO `cmf_district` VALUES ('2287', '274', '0', '海原县', '3');
INSERT INTO `cmf_district` VALUES ('2288', '274', '0', '中宁县', '3');
INSERT INTO `cmf_district` VALUES ('2289', '275', '0', '城中区', '3');
INSERT INTO `cmf_district` VALUES ('2290', '275', '0', '城东区', '3');
INSERT INTO `cmf_district` VALUES ('2291', '275', '0', '城西区', '3');
INSERT INTO `cmf_district` VALUES ('2292', '275', '0', '城北区', '3');
INSERT INTO `cmf_district` VALUES ('2293', '275', '0', '湟中县', '3');
INSERT INTO `cmf_district` VALUES ('2294', '275', '0', '湟源县', '3');
INSERT INTO `cmf_district` VALUES ('2295', '275', '0', '大通', '3');
INSERT INTO `cmf_district` VALUES ('2296', '276', '0', '玛沁县', '3');
INSERT INTO `cmf_district` VALUES ('2297', '276', '0', '班玛县', '3');
INSERT INTO `cmf_district` VALUES ('2298', '276', '0', '甘德县', '3');
INSERT INTO `cmf_district` VALUES ('2299', '276', '0', '达日县', '3');
INSERT INTO `cmf_district` VALUES ('2300', '276', '0', '久治县', '3');
INSERT INTO `cmf_district` VALUES ('2301', '276', '0', '玛多县', '3');
INSERT INTO `cmf_district` VALUES ('2302', '277', '0', '海晏县', '3');
INSERT INTO `cmf_district` VALUES ('2303', '277', '0', '祁连县', '3');
INSERT INTO `cmf_district` VALUES ('2304', '277', '0', '刚察县', '3');
INSERT INTO `cmf_district` VALUES ('2305', '277', '0', '门源', '3');
INSERT INTO `cmf_district` VALUES ('2306', '278', '0', '平安县', '3');
INSERT INTO `cmf_district` VALUES ('2307', '278', '0', '乐都县', '3');
INSERT INTO `cmf_district` VALUES ('2308', '278', '0', '民和', '3');
INSERT INTO `cmf_district` VALUES ('2309', '278', '0', '互助', '3');
INSERT INTO `cmf_district` VALUES ('2310', '278', '0', '化隆', '3');
INSERT INTO `cmf_district` VALUES ('2311', '278', '0', '循化', '3');
INSERT INTO `cmf_district` VALUES ('2312', '279', '0', '共和县', '3');
INSERT INTO `cmf_district` VALUES ('2313', '279', '0', '同德县', '3');
INSERT INTO `cmf_district` VALUES ('2314', '279', '0', '贵德县', '3');
INSERT INTO `cmf_district` VALUES ('2315', '279', '0', '兴海县', '3');
INSERT INTO `cmf_district` VALUES ('2316', '279', '0', '贵南县', '3');
INSERT INTO `cmf_district` VALUES ('2317', '280', '0', '德令哈市', '3');
INSERT INTO `cmf_district` VALUES ('2318', '280', '0', '格尔木市', '3');
INSERT INTO `cmf_district` VALUES ('2319', '280', '0', '乌兰县', '3');
INSERT INTO `cmf_district` VALUES ('2320', '280', '0', '都兰县', '3');
INSERT INTO `cmf_district` VALUES ('2321', '280', '0', '天峻县', '3');
INSERT INTO `cmf_district` VALUES ('2322', '281', '0', '同仁县', '3');
INSERT INTO `cmf_district` VALUES ('2323', '281', '0', '尖扎县', '3');
INSERT INTO `cmf_district` VALUES ('2324', '281', '0', '泽库县', '3');
INSERT INTO `cmf_district` VALUES ('2325', '281', '0', '河南蒙古族自治县', '3');
INSERT INTO `cmf_district` VALUES ('2326', '282', '0', '玉树县', '3');
INSERT INTO `cmf_district` VALUES ('2327', '282', '0', '杂多县', '3');
INSERT INTO `cmf_district` VALUES ('2328', '282', '0', '称多县', '3');
INSERT INTO `cmf_district` VALUES ('2329', '282', '0', '治多县', '3');
INSERT INTO `cmf_district` VALUES ('2330', '282', '0', '囊谦县', '3');
INSERT INTO `cmf_district` VALUES ('2331', '282', '0', '曲麻莱县', '3');
INSERT INTO `cmf_district` VALUES ('2332', '283', '0', '市中区', '3');
INSERT INTO `cmf_district` VALUES ('2333', '283', '0', '历下区', '3');
INSERT INTO `cmf_district` VALUES ('2334', '283', '0', '天桥区', '3');
INSERT INTO `cmf_district` VALUES ('2335', '283', '0', '槐荫区', '3');
INSERT INTO `cmf_district` VALUES ('2336', '283', '0', '历城区', '3');
INSERT INTO `cmf_district` VALUES ('2337', '283', '0', '长清区', '3');
INSERT INTO `cmf_district` VALUES ('2338', '283', '0', '章丘市', '3');
INSERT INTO `cmf_district` VALUES ('2339', '283', '0', '平阴县', '3');
INSERT INTO `cmf_district` VALUES ('2340', '283', '0', '济阳县', '3');
INSERT INTO `cmf_district` VALUES ('2341', '283', '0', '商河县', '3');
INSERT INTO `cmf_district` VALUES ('2342', '284', '0', '市南区', '3');
INSERT INTO `cmf_district` VALUES ('2343', '284', '0', '市北区', '3');
INSERT INTO `cmf_district` VALUES ('2344', '284', '0', '城阳区', '3');
INSERT INTO `cmf_district` VALUES ('2345', '284', '0', '四方区', '3');
INSERT INTO `cmf_district` VALUES ('2346', '284', '0', '李沧区', '3');
INSERT INTO `cmf_district` VALUES ('2347', '284', '0', '黄岛区', '3');
INSERT INTO `cmf_district` VALUES ('2348', '284', '0', '崂山区', '3');
INSERT INTO `cmf_district` VALUES ('2349', '284', '0', '胶州市', '3');
INSERT INTO `cmf_district` VALUES ('2350', '284', '0', '即墨市', '3');
INSERT INTO `cmf_district` VALUES ('2351', '284', '0', '平度市', '3');
INSERT INTO `cmf_district` VALUES ('2352', '284', '0', '胶南市', '3');
INSERT INTO `cmf_district` VALUES ('2353', '284', '0', '莱西市', '3');
INSERT INTO `cmf_district` VALUES ('2354', '285', '0', '滨城区', '3');
INSERT INTO `cmf_district` VALUES ('2355', '285', '0', '惠民县', '3');
INSERT INTO `cmf_district` VALUES ('2356', '285', '0', '阳信县', '3');
INSERT INTO `cmf_district` VALUES ('2357', '285', '0', '无棣县', '3');
INSERT INTO `cmf_district` VALUES ('2358', '285', '0', '沾化县', '3');
INSERT INTO `cmf_district` VALUES ('2359', '285', '0', '博兴县', '3');
INSERT INTO `cmf_district` VALUES ('2360', '285', '0', '邹平县', '3');
INSERT INTO `cmf_district` VALUES ('2361', '286', '0', '德城区', '3');
INSERT INTO `cmf_district` VALUES ('2362', '286', '0', '陵县', '3');
INSERT INTO `cmf_district` VALUES ('2363', '286', '0', '乐陵市', '3');
INSERT INTO `cmf_district` VALUES ('2364', '286', '0', '禹城市', '3');
INSERT INTO `cmf_district` VALUES ('2365', '286', '0', '宁津县', '3');
INSERT INTO `cmf_district` VALUES ('2366', '286', '0', '庆云县', '3');
INSERT INTO `cmf_district` VALUES ('2367', '286', '0', '临邑县', '3');
INSERT INTO `cmf_district` VALUES ('2368', '286', '0', '齐河县', '3');
INSERT INTO `cmf_district` VALUES ('2369', '286', '0', '平原县', '3');
INSERT INTO `cmf_district` VALUES ('2370', '286', '0', '夏津县', '3');
INSERT INTO `cmf_district` VALUES ('2371', '286', '0', '武城县', '3');
INSERT INTO `cmf_district` VALUES ('2372', '287', '0', '东营区', '3');
INSERT INTO `cmf_district` VALUES ('2373', '287', '0', '河口区', '3');
INSERT INTO `cmf_district` VALUES ('2374', '287', '0', '垦利县', '3');
INSERT INTO `cmf_district` VALUES ('2375', '287', '0', '利津县', '3');
INSERT INTO `cmf_district` VALUES ('2376', '287', '0', '广饶县', '3');
INSERT INTO `cmf_district` VALUES ('2377', '288', '0', '牡丹区', '3');
INSERT INTO `cmf_district` VALUES ('2378', '288', '0', '曹县', '3');
INSERT INTO `cmf_district` VALUES ('2379', '288', '0', '单县', '3');
INSERT INTO `cmf_district` VALUES ('2380', '288', '0', '成武县', '3');
INSERT INTO `cmf_district` VALUES ('2381', '288', '0', '巨野县', '3');
INSERT INTO `cmf_district` VALUES ('2382', '288', '0', '郓城县', '3');
INSERT INTO `cmf_district` VALUES ('2383', '288', '0', '鄄城县', '3');
INSERT INTO `cmf_district` VALUES ('2384', '288', '0', '定陶县', '3');
INSERT INTO `cmf_district` VALUES ('2385', '288', '0', '东明县', '3');
INSERT INTO `cmf_district` VALUES ('2386', '289', '0', '市中区', '3');
INSERT INTO `cmf_district` VALUES ('2387', '289', '0', '任城区', '3');
INSERT INTO `cmf_district` VALUES ('2388', '289', '0', '曲阜市', '3');
INSERT INTO `cmf_district` VALUES ('2389', '289', '0', '兖州市', '3');
INSERT INTO `cmf_district` VALUES ('2390', '289', '0', '邹城市', '3');
INSERT INTO `cmf_district` VALUES ('2391', '289', '0', '微山县', '3');
INSERT INTO `cmf_district` VALUES ('2392', '289', '0', '鱼台县', '3');
INSERT INTO `cmf_district` VALUES ('2393', '289', '0', '金乡县', '3');
INSERT INTO `cmf_district` VALUES ('2394', '289', '0', '嘉祥县', '3');
INSERT INTO `cmf_district` VALUES ('2395', '289', '0', '汶上县', '3');
INSERT INTO `cmf_district` VALUES ('2396', '289', '0', '泗水县', '3');
INSERT INTO `cmf_district` VALUES ('2397', '289', '0', '梁山县', '3');
INSERT INTO `cmf_district` VALUES ('2398', '290', '0', '莱城区', '3');
INSERT INTO `cmf_district` VALUES ('2399', '290', '0', '钢城区', '3');
INSERT INTO `cmf_district` VALUES ('2400', '291', '0', '东昌府区', '3');
INSERT INTO `cmf_district` VALUES ('2401', '291', '0', '临清市', '3');
INSERT INTO `cmf_district` VALUES ('2402', '291', '0', '阳谷县', '3');
INSERT INTO `cmf_district` VALUES ('2403', '291', '0', '莘县', '3');
INSERT INTO `cmf_district` VALUES ('2404', '291', '0', '茌平县', '3');
INSERT INTO `cmf_district` VALUES ('2405', '291', '0', '东阿县', '3');
INSERT INTO `cmf_district` VALUES ('2406', '291', '0', '冠县', '3');
INSERT INTO `cmf_district` VALUES ('2407', '291', '0', '高唐县', '3');
INSERT INTO `cmf_district` VALUES ('2408', '292', '0', '兰山区', '3');
INSERT INTO `cmf_district` VALUES ('2409', '292', '0', '罗庄区', '3');
INSERT INTO `cmf_district` VALUES ('2410', '292', '0', '河东区', '3');
INSERT INTO `cmf_district` VALUES ('2411', '292', '0', '沂南县', '3');
INSERT INTO `cmf_district` VALUES ('2412', '292', '0', '郯城县', '3');
INSERT INTO `cmf_district` VALUES ('2413', '292', '0', '沂水县', '3');
INSERT INTO `cmf_district` VALUES ('2414', '292', '0', '苍山县', '3');
INSERT INTO `cmf_district` VALUES ('2415', '292', '0', '费县', '3');
INSERT INTO `cmf_district` VALUES ('2416', '292', '0', '平邑县', '3');
INSERT INTO `cmf_district` VALUES ('2417', '292', '0', '莒南县', '3');
INSERT INTO `cmf_district` VALUES ('2418', '292', '0', '蒙阴县', '3');
INSERT INTO `cmf_district` VALUES ('2419', '292', '0', '临沭县', '3');
INSERT INTO `cmf_district` VALUES ('2420', '293', '0', '东港区', '3');
INSERT INTO `cmf_district` VALUES ('2421', '293', '0', '岚山区', '3');
INSERT INTO `cmf_district` VALUES ('2422', '293', '0', '五莲县', '3');
INSERT INTO `cmf_district` VALUES ('2423', '293', '0', '莒县', '3');
INSERT INTO `cmf_district` VALUES ('2424', '294', '0', '泰山区', '3');
INSERT INTO `cmf_district` VALUES ('2425', '294', '0', '岱岳区', '3');
INSERT INTO `cmf_district` VALUES ('2426', '294', '0', '新泰市', '3');
INSERT INTO `cmf_district` VALUES ('2427', '294', '0', '肥城市', '3');
INSERT INTO `cmf_district` VALUES ('2428', '294', '0', '宁阳县', '3');
INSERT INTO `cmf_district` VALUES ('2429', '294', '0', '东平县', '3');
INSERT INTO `cmf_district` VALUES ('2430', '295', '0', '荣成市', '3');
INSERT INTO `cmf_district` VALUES ('2431', '295', '0', '乳山市', '3');
INSERT INTO `cmf_district` VALUES ('2432', '295', '0', '环翠区', '3');
INSERT INTO `cmf_district` VALUES ('2433', '295', '0', '文登市', '3');
INSERT INTO `cmf_district` VALUES ('2434', '296', '0', '潍城区', '3');
INSERT INTO `cmf_district` VALUES ('2435', '296', '0', '寒亭区', '3');
INSERT INTO `cmf_district` VALUES ('2436', '296', '0', '坊子区', '3');
INSERT INTO `cmf_district` VALUES ('2437', '296', '0', '奎文区', '3');
INSERT INTO `cmf_district` VALUES ('2438', '296', '0', '青州市', '3');
INSERT INTO `cmf_district` VALUES ('2439', '296', '0', '诸城市', '3');
INSERT INTO `cmf_district` VALUES ('2440', '296', '0', '寿光市', '3');
INSERT INTO `cmf_district` VALUES ('2441', '296', '0', '安丘市', '3');
INSERT INTO `cmf_district` VALUES ('2442', '296', '0', '高密市', '3');
INSERT INTO `cmf_district` VALUES ('2443', '296', '0', '昌邑市', '3');
INSERT INTO `cmf_district` VALUES ('2444', '296', '0', '临朐县', '3');
INSERT INTO `cmf_district` VALUES ('2445', '296', '0', '昌乐县', '3');
INSERT INTO `cmf_district` VALUES ('2446', '297', '0', '芝罘区', '3');
INSERT INTO `cmf_district` VALUES ('2447', '297', '0', '福山区', '3');
INSERT INTO `cmf_district` VALUES ('2448', '297', '0', '牟平区', '3');
INSERT INTO `cmf_district` VALUES ('2449', '297', '0', '莱山区', '3');
INSERT INTO `cmf_district` VALUES ('2450', '297', '0', '开发区', '3');
INSERT INTO `cmf_district` VALUES ('2451', '297', '0', '龙口市', '3');
INSERT INTO `cmf_district` VALUES ('2452', '297', '0', '莱阳市', '3');
INSERT INTO `cmf_district` VALUES ('2453', '297', '0', '莱州市', '3');
INSERT INTO `cmf_district` VALUES ('2454', '297', '0', '蓬莱市', '3');
INSERT INTO `cmf_district` VALUES ('2455', '297', '0', '招远市', '3');
INSERT INTO `cmf_district` VALUES ('2456', '297', '0', '栖霞市', '3');
INSERT INTO `cmf_district` VALUES ('2457', '297', '0', '海阳市', '3');
INSERT INTO `cmf_district` VALUES ('2458', '297', '0', '长岛县', '3');
INSERT INTO `cmf_district` VALUES ('2459', '298', '0', '市中区', '3');
INSERT INTO `cmf_district` VALUES ('2460', '298', '0', '山亭区', '3');
INSERT INTO `cmf_district` VALUES ('2461', '298', '0', '峄城区', '3');
INSERT INTO `cmf_district` VALUES ('2462', '298', '0', '台儿庄区', '3');
INSERT INTO `cmf_district` VALUES ('2463', '298', '0', '薛城区', '3');
INSERT INTO `cmf_district` VALUES ('2464', '298', '0', '滕州市', '3');
INSERT INTO `cmf_district` VALUES ('2465', '299', '0', '张店区', '3');
INSERT INTO `cmf_district` VALUES ('2466', '299', '0', '临淄区', '3');
INSERT INTO `cmf_district` VALUES ('2467', '299', '0', '淄川区', '3');
INSERT INTO `cmf_district` VALUES ('2468', '299', '0', '博山区', '3');
INSERT INTO `cmf_district` VALUES ('2469', '299', '0', '周村区', '3');
INSERT INTO `cmf_district` VALUES ('2470', '299', '0', '桓台县', '3');
INSERT INTO `cmf_district` VALUES ('2471', '299', '0', '高青县', '3');
INSERT INTO `cmf_district` VALUES ('2472', '299', '0', '沂源县', '3');
INSERT INTO `cmf_district` VALUES ('2473', '300', '0', '杏花岭区', '3');
INSERT INTO `cmf_district` VALUES ('2474', '300', '0', '小店区', '3');
INSERT INTO `cmf_district` VALUES ('2475', '300', '0', '迎泽区', '3');
INSERT INTO `cmf_district` VALUES ('2476', '300', '0', '尖草坪区', '3');
INSERT INTO `cmf_district` VALUES ('2477', '300', '0', '万柏林区', '3');
INSERT INTO `cmf_district` VALUES ('2478', '300', '0', '晋源区', '3');
INSERT INTO `cmf_district` VALUES ('2479', '300', '0', '高新开发区', '3');
INSERT INTO `cmf_district` VALUES ('2480', '300', '0', '民营经济开发区', '3');
INSERT INTO `cmf_district` VALUES ('2481', '300', '0', '经济技术开发区', '3');
INSERT INTO `cmf_district` VALUES ('2482', '300', '0', '清徐县', '3');
INSERT INTO `cmf_district` VALUES ('2483', '300', '0', '阳曲县', '3');
INSERT INTO `cmf_district` VALUES ('2484', '300', '0', '娄烦县', '3');
INSERT INTO `cmf_district` VALUES ('2485', '300', '0', '古交市', '3');
INSERT INTO `cmf_district` VALUES ('2486', '301', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('2487', '301', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('2488', '301', '0', '沁县', '3');
INSERT INTO `cmf_district` VALUES ('2489', '301', '0', '潞城市', '3');
INSERT INTO `cmf_district` VALUES ('2490', '301', '0', '长治县', '3');
INSERT INTO `cmf_district` VALUES ('2491', '301', '0', '襄垣县', '3');
INSERT INTO `cmf_district` VALUES ('2492', '301', '0', '屯留县', '3');
INSERT INTO `cmf_district` VALUES ('2493', '301', '0', '平顺县', '3');
INSERT INTO `cmf_district` VALUES ('2494', '301', '0', '黎城县', '3');
INSERT INTO `cmf_district` VALUES ('2495', '301', '0', '壶关县', '3');
INSERT INTO `cmf_district` VALUES ('2496', '301', '0', '长子县', '3');
INSERT INTO `cmf_district` VALUES ('2497', '301', '0', '武乡县', '3');
INSERT INTO `cmf_district` VALUES ('2498', '301', '0', '沁源县', '3');
INSERT INTO `cmf_district` VALUES ('2499', '302', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('2500', '302', '0', '矿区', '3');
INSERT INTO `cmf_district` VALUES ('2501', '302', '0', '南郊区', '3');
INSERT INTO `cmf_district` VALUES ('2502', '302', '0', '新荣区', '3');
INSERT INTO `cmf_district` VALUES ('2503', '302', '0', '阳高县', '3');
INSERT INTO `cmf_district` VALUES ('2504', '302', '0', '天镇县', '3');
INSERT INTO `cmf_district` VALUES ('2505', '302', '0', '广灵县', '3');
INSERT INTO `cmf_district` VALUES ('2506', '302', '0', '灵丘县', '3');
INSERT INTO `cmf_district` VALUES ('2507', '302', '0', '浑源县', '3');
INSERT INTO `cmf_district` VALUES ('2508', '302', '0', '左云县', '3');
INSERT INTO `cmf_district` VALUES ('2509', '302', '0', '大同县', '3');
INSERT INTO `cmf_district` VALUES ('2510', '303', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('2511', '303', '0', '高平市', '3');
INSERT INTO `cmf_district` VALUES ('2512', '303', '0', '沁水县', '3');
INSERT INTO `cmf_district` VALUES ('2513', '303', '0', '阳城县', '3');
INSERT INTO `cmf_district` VALUES ('2514', '303', '0', '陵川县', '3');
INSERT INTO `cmf_district` VALUES ('2515', '303', '0', '泽州县', '3');
INSERT INTO `cmf_district` VALUES ('2516', '304', '0', '榆次区', '3');
INSERT INTO `cmf_district` VALUES ('2517', '304', '0', '介休市', '3');
INSERT INTO `cmf_district` VALUES ('2518', '304', '0', '榆社县', '3');
INSERT INTO `cmf_district` VALUES ('2519', '304', '0', '左权县', '3');
INSERT INTO `cmf_district` VALUES ('2520', '304', '0', '和顺县', '3');
INSERT INTO `cmf_district` VALUES ('2521', '304', '0', '昔阳县', '3');
INSERT INTO `cmf_district` VALUES ('2522', '304', '0', '寿阳县', '3');
INSERT INTO `cmf_district` VALUES ('2523', '304', '0', '太谷县', '3');
INSERT INTO `cmf_district` VALUES ('2524', '304', '0', '祁县', '3');
INSERT INTO `cmf_district` VALUES ('2525', '304', '0', '平遥县', '3');
INSERT INTO `cmf_district` VALUES ('2526', '304', '0', '灵石县', '3');
INSERT INTO `cmf_district` VALUES ('2527', '305', '0', '尧都区', '3');
INSERT INTO `cmf_district` VALUES ('2528', '305', '0', '侯马市', '3');
INSERT INTO `cmf_district` VALUES ('2529', '305', '0', '霍州市', '3');
INSERT INTO `cmf_district` VALUES ('2530', '305', '0', '曲沃县', '3');
INSERT INTO `cmf_district` VALUES ('2531', '305', '0', '翼城县', '3');
INSERT INTO `cmf_district` VALUES ('2532', '305', '0', '襄汾县', '3');
INSERT INTO `cmf_district` VALUES ('2533', '305', '0', '洪洞县', '3');
INSERT INTO `cmf_district` VALUES ('2534', '305', '0', '吉县', '3');
INSERT INTO `cmf_district` VALUES ('2535', '305', '0', '安泽县', '3');
INSERT INTO `cmf_district` VALUES ('2536', '305', '0', '浮山县', '3');
INSERT INTO `cmf_district` VALUES ('2537', '305', '0', '古县', '3');
INSERT INTO `cmf_district` VALUES ('2538', '305', '0', '乡宁县', '3');
INSERT INTO `cmf_district` VALUES ('2539', '305', '0', '大宁县', '3');
INSERT INTO `cmf_district` VALUES ('2540', '305', '0', '隰县', '3');
INSERT INTO `cmf_district` VALUES ('2541', '305', '0', '永和县', '3');
INSERT INTO `cmf_district` VALUES ('2542', '305', '0', '蒲县', '3');
INSERT INTO `cmf_district` VALUES ('2543', '305', '0', '汾西县', '3');
INSERT INTO `cmf_district` VALUES ('2544', '306', '0', '离石市', '3');
INSERT INTO `cmf_district` VALUES ('2545', '306', '0', '离石区', '3');
INSERT INTO `cmf_district` VALUES ('2546', '306', '0', '孝义市', '3');
INSERT INTO `cmf_district` VALUES ('2547', '306', '0', '汾阳市', '3');
INSERT INTO `cmf_district` VALUES ('2548', '306', '0', '文水县', '3');
INSERT INTO `cmf_district` VALUES ('2549', '306', '0', '交城县', '3');
INSERT INTO `cmf_district` VALUES ('2550', '306', '0', '兴县', '3');
INSERT INTO `cmf_district` VALUES ('2551', '306', '0', '临县', '3');
INSERT INTO `cmf_district` VALUES ('2552', '306', '0', '柳林县', '3');
INSERT INTO `cmf_district` VALUES ('2553', '306', '0', '石楼县', '3');
INSERT INTO `cmf_district` VALUES ('2554', '306', '0', '岚县', '3');
INSERT INTO `cmf_district` VALUES ('2555', '306', '0', '方山县', '3');
INSERT INTO `cmf_district` VALUES ('2556', '306', '0', '中阳县', '3');
INSERT INTO `cmf_district` VALUES ('2557', '306', '0', '交口县', '3');
INSERT INTO `cmf_district` VALUES ('2558', '307', '0', '朔城区', '3');
INSERT INTO `cmf_district` VALUES ('2559', '307', '0', '平鲁区', '3');
INSERT INTO `cmf_district` VALUES ('2560', '307', '0', '山阴县', '3');
INSERT INTO `cmf_district` VALUES ('2561', '307', '0', '应县', '3');
INSERT INTO `cmf_district` VALUES ('2562', '307', '0', '右玉县', '3');
INSERT INTO `cmf_district` VALUES ('2563', '307', '0', '怀仁县', '3');
INSERT INTO `cmf_district` VALUES ('2564', '308', '0', '忻府区', '3');
INSERT INTO `cmf_district` VALUES ('2565', '308', '0', '原平市', '3');
INSERT INTO `cmf_district` VALUES ('2566', '308', '0', '定襄县', '3');
INSERT INTO `cmf_district` VALUES ('2567', '308', '0', '五台县', '3');
INSERT INTO `cmf_district` VALUES ('2568', '308', '0', '代县', '3');
INSERT INTO `cmf_district` VALUES ('2569', '308', '0', '繁峙县', '3');
INSERT INTO `cmf_district` VALUES ('2570', '308', '0', '宁武县', '3');
INSERT INTO `cmf_district` VALUES ('2571', '308', '0', '静乐县', '3');
INSERT INTO `cmf_district` VALUES ('2572', '308', '0', '神池县', '3');
INSERT INTO `cmf_district` VALUES ('2573', '308', '0', '五寨县', '3');
INSERT INTO `cmf_district` VALUES ('2574', '308', '0', '岢岚县', '3');
INSERT INTO `cmf_district` VALUES ('2575', '308', '0', '河曲县', '3');
INSERT INTO `cmf_district` VALUES ('2576', '308', '0', '保德县', '3');
INSERT INTO `cmf_district` VALUES ('2577', '308', '0', '偏关县', '3');
INSERT INTO `cmf_district` VALUES ('2578', '309', '0', '城区', '3');
INSERT INTO `cmf_district` VALUES ('2579', '309', '0', '矿区', '3');
INSERT INTO `cmf_district` VALUES ('2580', '309', '0', '郊区', '3');
INSERT INTO `cmf_district` VALUES ('2581', '309', '0', '平定县', '3');
INSERT INTO `cmf_district` VALUES ('2582', '309', '0', '盂县', '3');
INSERT INTO `cmf_district` VALUES ('2583', '310', '0', '盐湖区', '3');
INSERT INTO `cmf_district` VALUES ('2584', '310', '0', '永济市', '3');
INSERT INTO `cmf_district` VALUES ('2585', '310', '0', '河津市', '3');
INSERT INTO `cmf_district` VALUES ('2586', '310', '0', '临猗县', '3');
INSERT INTO `cmf_district` VALUES ('2587', '310', '0', '万荣县', '3');
INSERT INTO `cmf_district` VALUES ('2588', '310', '0', '闻喜县', '3');
INSERT INTO `cmf_district` VALUES ('2589', '310', '0', '稷山县', '3');
INSERT INTO `cmf_district` VALUES ('2590', '310', '0', '新绛县', '3');
INSERT INTO `cmf_district` VALUES ('2591', '310', '0', '绛县', '3');
INSERT INTO `cmf_district` VALUES ('2592', '310', '0', '垣曲县', '3');
INSERT INTO `cmf_district` VALUES ('2593', '310', '0', '夏县', '3');
INSERT INTO `cmf_district` VALUES ('2594', '310', '0', '平陆县', '3');
INSERT INTO `cmf_district` VALUES ('2595', '310', '0', '芮城县', '3');
INSERT INTO `cmf_district` VALUES ('2596', '311', '0', '莲湖区', '3');
INSERT INTO `cmf_district` VALUES ('2597', '311', '0', '新城区', '3');
INSERT INTO `cmf_district` VALUES ('2598', '311', '0', '碑林区', '3');
INSERT INTO `cmf_district` VALUES ('2599', '311', '0', '雁塔区', '3');
INSERT INTO `cmf_district` VALUES ('2600', '311', '0', '灞桥区', '3');
INSERT INTO `cmf_district` VALUES ('2601', '311', '0', '未央区', '3');
INSERT INTO `cmf_district` VALUES ('2602', '311', '0', '阎良区', '3');
INSERT INTO `cmf_district` VALUES ('2603', '311', '0', '临潼区', '3');
INSERT INTO `cmf_district` VALUES ('2604', '311', '0', '长安区', '3');
INSERT INTO `cmf_district` VALUES ('2605', '311', '0', '蓝田县', '3');
INSERT INTO `cmf_district` VALUES ('2606', '311', '0', '周至县', '3');
INSERT INTO `cmf_district` VALUES ('2607', '311', '0', '户县', '3');
INSERT INTO `cmf_district` VALUES ('2608', '311', '0', '高陵县', '3');
INSERT INTO `cmf_district` VALUES ('2609', '312', '0', '汉滨区', '3');
INSERT INTO `cmf_district` VALUES ('2610', '312', '0', '汉阴县', '3');
INSERT INTO `cmf_district` VALUES ('2611', '312', '0', '石泉县', '3');
INSERT INTO `cmf_district` VALUES ('2612', '312', '0', '宁陕县', '3');
INSERT INTO `cmf_district` VALUES ('2613', '312', '0', '紫阳县', '3');
INSERT INTO `cmf_district` VALUES ('2614', '312', '0', '岚皋县', '3');
INSERT INTO `cmf_district` VALUES ('2615', '312', '0', '平利县', '3');
INSERT INTO `cmf_district` VALUES ('2616', '312', '0', '镇坪县', '3');
INSERT INTO `cmf_district` VALUES ('2617', '312', '0', '旬阳县', '3');
INSERT INTO `cmf_district` VALUES ('2618', '312', '0', '白河县', '3');
INSERT INTO `cmf_district` VALUES ('2619', '313', '0', '陈仓区', '3');
INSERT INTO `cmf_district` VALUES ('2620', '313', '0', '渭滨区', '3');
INSERT INTO `cmf_district` VALUES ('2621', '313', '0', '金台区', '3');
INSERT INTO `cmf_district` VALUES ('2622', '313', '0', '凤翔县', '3');
INSERT INTO `cmf_district` VALUES ('2623', '313', '0', '岐山县', '3');
INSERT INTO `cmf_district` VALUES ('2624', '313', '0', '扶风县', '3');
INSERT INTO `cmf_district` VALUES ('2625', '313', '0', '眉县', '3');
INSERT INTO `cmf_district` VALUES ('2626', '313', '0', '陇县', '3');
INSERT INTO `cmf_district` VALUES ('2627', '313', '0', '千阳县', '3');
INSERT INTO `cmf_district` VALUES ('2628', '313', '0', '麟游县', '3');
INSERT INTO `cmf_district` VALUES ('2629', '313', '0', '凤县', '3');
INSERT INTO `cmf_district` VALUES ('2630', '313', '0', '太白县', '3');
INSERT INTO `cmf_district` VALUES ('2631', '314', '0', '汉台区', '3');
INSERT INTO `cmf_district` VALUES ('2632', '314', '0', '南郑县', '3');
INSERT INTO `cmf_district` VALUES ('2633', '314', '0', '城固县', '3');
INSERT INTO `cmf_district` VALUES ('2634', '314', '0', '洋县', '3');
INSERT INTO `cmf_district` VALUES ('2635', '314', '0', '西乡县', '3');
INSERT INTO `cmf_district` VALUES ('2636', '314', '0', '勉县', '3');
INSERT INTO `cmf_district` VALUES ('2637', '314', '0', '宁强县', '3');
INSERT INTO `cmf_district` VALUES ('2638', '314', '0', '略阳县', '3');
INSERT INTO `cmf_district` VALUES ('2639', '314', '0', '镇巴县', '3');
INSERT INTO `cmf_district` VALUES ('2640', '314', '0', '留坝县', '3');
INSERT INTO `cmf_district` VALUES ('2641', '314', '0', '佛坪县', '3');
INSERT INTO `cmf_district` VALUES ('2642', '315', '0', '商州区', '3');
INSERT INTO `cmf_district` VALUES ('2643', '315', '0', '洛南县', '3');
INSERT INTO `cmf_district` VALUES ('2644', '315', '0', '丹凤县', '3');
INSERT INTO `cmf_district` VALUES ('2645', '315', '0', '商南县', '3');
INSERT INTO `cmf_district` VALUES ('2646', '315', '0', '山阳县', '3');
INSERT INTO `cmf_district` VALUES ('2647', '315', '0', '镇安县', '3');
INSERT INTO `cmf_district` VALUES ('2648', '315', '0', '柞水县', '3');
INSERT INTO `cmf_district` VALUES ('2649', '316', '0', '耀州区', '3');
INSERT INTO `cmf_district` VALUES ('2650', '316', '0', '王益区', '3');
INSERT INTO `cmf_district` VALUES ('2651', '316', '0', '印台区', '3');
INSERT INTO `cmf_district` VALUES ('2652', '316', '0', '宜君县', '3');
INSERT INTO `cmf_district` VALUES ('2653', '317', '0', '临渭区', '3');
INSERT INTO `cmf_district` VALUES ('2654', '317', '0', '韩城市', '3');
INSERT INTO `cmf_district` VALUES ('2655', '317', '0', '华阴市', '3');
INSERT INTO `cmf_district` VALUES ('2656', '317', '0', '华县', '3');
INSERT INTO `cmf_district` VALUES ('2657', '317', '0', '潼关县', '3');
INSERT INTO `cmf_district` VALUES ('2658', '317', '0', '大荔县', '3');
INSERT INTO `cmf_district` VALUES ('2659', '317', '0', '合阳县', '3');
INSERT INTO `cmf_district` VALUES ('2660', '317', '0', '澄城县', '3');
INSERT INTO `cmf_district` VALUES ('2661', '317', '0', '蒲城县', '3');
INSERT INTO `cmf_district` VALUES ('2662', '317', '0', '白水县', '3');
INSERT INTO `cmf_district` VALUES ('2663', '317', '0', '富平县', '3');
INSERT INTO `cmf_district` VALUES ('2664', '318', '0', '秦都区', '3');
INSERT INTO `cmf_district` VALUES ('2665', '318', '0', '渭城区', '3');
INSERT INTO `cmf_district` VALUES ('2666', '318', '0', '杨陵区', '3');
INSERT INTO `cmf_district` VALUES ('2667', '318', '0', '兴平市', '3');
INSERT INTO `cmf_district` VALUES ('2668', '318', '0', '三原县', '3');
INSERT INTO `cmf_district` VALUES ('2669', '318', '0', '泾阳县', '3');
INSERT INTO `cmf_district` VALUES ('2670', '318', '0', '乾县', '3');
INSERT INTO `cmf_district` VALUES ('2671', '318', '0', '礼泉县', '3');
INSERT INTO `cmf_district` VALUES ('2672', '318', '0', '永寿县', '3');
INSERT INTO `cmf_district` VALUES ('2673', '318', '0', '彬县', '3');
INSERT INTO `cmf_district` VALUES ('2674', '318', '0', '长武县', '3');
INSERT INTO `cmf_district` VALUES ('2675', '318', '0', '旬邑县', '3');
INSERT INTO `cmf_district` VALUES ('2676', '318', '0', '淳化县', '3');
INSERT INTO `cmf_district` VALUES ('2677', '318', '0', '武功县', '3');
INSERT INTO `cmf_district` VALUES ('2678', '319', '0', '吴起县', '3');
INSERT INTO `cmf_district` VALUES ('2679', '319', '0', '宝塔区', '3');
INSERT INTO `cmf_district` VALUES ('2680', '319', '0', '延长县', '3');
INSERT INTO `cmf_district` VALUES ('2681', '319', '0', '延川县', '3');
INSERT INTO `cmf_district` VALUES ('2682', '319', '0', '子长县', '3');
INSERT INTO `cmf_district` VALUES ('2683', '319', '0', '安塞县', '3');
INSERT INTO `cmf_district` VALUES ('2684', '319', '0', '志丹县', '3');
INSERT INTO `cmf_district` VALUES ('2685', '319', '0', '甘泉县', '3');
INSERT INTO `cmf_district` VALUES ('2686', '319', '0', '富县', '3');
INSERT INTO `cmf_district` VALUES ('2687', '319', '0', '洛川县', '3');
INSERT INTO `cmf_district` VALUES ('2688', '319', '0', '宜川县', '3');
INSERT INTO `cmf_district` VALUES ('2689', '319', '0', '黄龙县', '3');
INSERT INTO `cmf_district` VALUES ('2690', '319', '0', '黄陵县', '3');
INSERT INTO `cmf_district` VALUES ('2691', '320', '0', '榆阳区', '3');
INSERT INTO `cmf_district` VALUES ('2692', '320', '0', '神木县', '3');
INSERT INTO `cmf_district` VALUES ('2693', '320', '0', '府谷县', '3');
INSERT INTO `cmf_district` VALUES ('2694', '320', '0', '横山县', '3');
INSERT INTO `cmf_district` VALUES ('2695', '320', '0', '靖边县', '3');
INSERT INTO `cmf_district` VALUES ('2696', '320', '0', '定边县', '3');
INSERT INTO `cmf_district` VALUES ('2697', '320', '0', '绥德县', '3');
INSERT INTO `cmf_district` VALUES ('2698', '320', '0', '米脂县', '3');
INSERT INTO `cmf_district` VALUES ('2699', '320', '0', '佳县', '3');
INSERT INTO `cmf_district` VALUES ('2700', '320', '0', '吴堡县', '3');
INSERT INTO `cmf_district` VALUES ('2701', '320', '0', '清涧县', '3');
INSERT INTO `cmf_district` VALUES ('2702', '320', '0', '子洲县', '3');
INSERT INTO `cmf_district` VALUES ('2703', '321', '0', '长宁区', '3');
INSERT INTO `cmf_district` VALUES ('2704', '321', '0', '闸北区', '3');
INSERT INTO `cmf_district` VALUES ('2705', '321', '0', '闵行区', '3');
INSERT INTO `cmf_district` VALUES ('2706', '321', '0', '徐汇区', '3');
INSERT INTO `cmf_district` VALUES ('2707', '321', '0', '浦东新区', '3');
INSERT INTO `cmf_district` VALUES ('2708', '321', '0', '杨浦区', '3');
INSERT INTO `cmf_district` VALUES ('2709', '321', '0', '普陀区', '3');
INSERT INTO `cmf_district` VALUES ('2710', '321', '0', '静安区', '3');
INSERT INTO `cmf_district` VALUES ('2711', '321', '0', '卢湾区', '3');
INSERT INTO `cmf_district` VALUES ('2712', '321', '0', '虹口区', '3');
INSERT INTO `cmf_district` VALUES ('2713', '321', '0', '黄浦区', '3');
INSERT INTO `cmf_district` VALUES ('2714', '321', '0', '南汇区', '3');
INSERT INTO `cmf_district` VALUES ('2715', '321', '0', '松江区', '3');
INSERT INTO `cmf_district` VALUES ('2716', '321', '0', '嘉定区', '3');
INSERT INTO `cmf_district` VALUES ('2717', '321', '0', '宝山区', '3');
INSERT INTO `cmf_district` VALUES ('2718', '321', '0', '青浦区', '3');
INSERT INTO `cmf_district` VALUES ('2719', '321', '0', '金山区', '3');
INSERT INTO `cmf_district` VALUES ('2720', '321', '0', '奉贤区', '3');
INSERT INTO `cmf_district` VALUES ('2721', '321', '0', '崇明县', '3');
INSERT INTO `cmf_district` VALUES ('2722', '322', '0', '青羊区', '3');
INSERT INTO `cmf_district` VALUES ('2723', '322', '0', '锦江区', '3');
INSERT INTO `cmf_district` VALUES ('2724', '322', '0', '金牛区', '3');
INSERT INTO `cmf_district` VALUES ('2725', '322', '0', '武侯区', '3');
INSERT INTO `cmf_district` VALUES ('2726', '322', '0', '成华区', '3');
INSERT INTO `cmf_district` VALUES ('2727', '322', '0', '龙泉驿区', '3');
INSERT INTO `cmf_district` VALUES ('2728', '322', '0', '青白江区', '3');
INSERT INTO `cmf_district` VALUES ('2729', '322', '0', '新都区', '3');
INSERT INTO `cmf_district` VALUES ('2730', '322', '0', '温江区', '3');
INSERT INTO `cmf_district` VALUES ('2731', '322', '0', '高新区', '3');
INSERT INTO `cmf_district` VALUES ('2732', '322', '0', '高新西区', '3');
INSERT INTO `cmf_district` VALUES ('2733', '322', '0', '都江堰市', '3');
INSERT INTO `cmf_district` VALUES ('2734', '322', '0', '彭州市', '3');
INSERT INTO `cmf_district` VALUES ('2735', '322', '0', '邛崃市', '3');
INSERT INTO `cmf_district` VALUES ('2736', '322', '0', '崇州市', '3');
INSERT INTO `cmf_district` VALUES ('2737', '322', '0', '金堂县', '3');
INSERT INTO `cmf_district` VALUES ('2738', '322', '0', '双流县', '3');
INSERT INTO `cmf_district` VALUES ('2739', '322', '0', '郫县', '3');
INSERT INTO `cmf_district` VALUES ('2740', '322', '0', '大邑县', '3');
INSERT INTO `cmf_district` VALUES ('2741', '322', '0', '蒲江县', '3');
INSERT INTO `cmf_district` VALUES ('2742', '322', '0', '新津县', '3');
INSERT INTO `cmf_district` VALUES ('2743', '322', '0', '都江堰市', '3');
INSERT INTO `cmf_district` VALUES ('2744', '322', '0', '彭州市', '3');
INSERT INTO `cmf_district` VALUES ('2745', '322', '0', '邛崃市', '3');
INSERT INTO `cmf_district` VALUES ('2746', '322', '0', '崇州市', '3');
INSERT INTO `cmf_district` VALUES ('2747', '322', '0', '金堂县', '3');
INSERT INTO `cmf_district` VALUES ('2748', '322', '0', '双流县', '3');
INSERT INTO `cmf_district` VALUES ('2749', '322', '0', '郫县', '3');
INSERT INTO `cmf_district` VALUES ('2750', '322', '0', '大邑县', '3');
INSERT INTO `cmf_district` VALUES ('2751', '322', '0', '蒲江县', '3');
INSERT INTO `cmf_district` VALUES ('2752', '322', '0', '新津县', '3');
INSERT INTO `cmf_district` VALUES ('2753', '323', '0', '涪城区', '3');
INSERT INTO `cmf_district` VALUES ('2754', '323', '0', '游仙区', '3');
INSERT INTO `cmf_district` VALUES ('2755', '323', '0', '江油市', '3');
INSERT INTO `cmf_district` VALUES ('2756', '323', '0', '盐亭县', '3');
INSERT INTO `cmf_district` VALUES ('2757', '323', '0', '三台县', '3');
INSERT INTO `cmf_district` VALUES ('2758', '323', '0', '平武县', '3');
INSERT INTO `cmf_district` VALUES ('2759', '323', '0', '安县', '3');
INSERT INTO `cmf_district` VALUES ('2760', '323', '0', '梓潼县', '3');
INSERT INTO `cmf_district` VALUES ('2761', '323', '0', '北川县', '3');
INSERT INTO `cmf_district` VALUES ('2762', '324', '0', '马尔康县', '3');
INSERT INTO `cmf_district` VALUES ('2763', '324', '0', '汶川县', '3');
INSERT INTO `cmf_district` VALUES ('2764', '324', '0', '理县', '3');
INSERT INTO `cmf_district` VALUES ('2765', '324', '0', '茂县', '3');
INSERT INTO `cmf_district` VALUES ('2766', '324', '0', '松潘县', '3');
INSERT INTO `cmf_district` VALUES ('2767', '324', '0', '九寨沟县', '3');
INSERT INTO `cmf_district` VALUES ('2768', '324', '0', '金川县', '3');
INSERT INTO `cmf_district` VALUES ('2769', '324', '0', '小金县', '3');
INSERT INTO `cmf_district` VALUES ('2770', '324', '0', '黑水县', '3');
INSERT INTO `cmf_district` VALUES ('2771', '324', '0', '壤塘县', '3');
INSERT INTO `cmf_district` VALUES ('2772', '324', '0', '阿坝县', '3');
INSERT INTO `cmf_district` VALUES ('2773', '324', '0', '若尔盖县', '3');
INSERT INTO `cmf_district` VALUES ('2774', '324', '0', '红原县', '3');
INSERT INTO `cmf_district` VALUES ('2775', '325', '0', '巴州区', '3');
INSERT INTO `cmf_district` VALUES ('2776', '325', '0', '通江县', '3');
INSERT INTO `cmf_district` VALUES ('2777', '325', '0', '南江县', '3');
INSERT INTO `cmf_district` VALUES ('2778', '325', '0', '平昌县', '3');
INSERT INTO `cmf_district` VALUES ('2779', '326', '0', '通川区', '3');
INSERT INTO `cmf_district` VALUES ('2780', '326', '0', '万源市', '3');
INSERT INTO `cmf_district` VALUES ('2781', '326', '0', '达县', '3');
INSERT INTO `cmf_district` VALUES ('2782', '326', '0', '宣汉县', '3');
INSERT INTO `cmf_district` VALUES ('2783', '326', '0', '开江县', '3');
INSERT INTO `cmf_district` VALUES ('2784', '326', '0', '大竹县', '3');
INSERT INTO `cmf_district` VALUES ('2785', '326', '0', '渠县', '3');
INSERT INTO `cmf_district` VALUES ('2786', '327', '0', '旌阳区', '3');
INSERT INTO `cmf_district` VALUES ('2787', '327', '0', '广汉市', '3');
INSERT INTO `cmf_district` VALUES ('2788', '327', '0', '什邡市', '3');
INSERT INTO `cmf_district` VALUES ('2789', '327', '0', '绵竹市', '3');
INSERT INTO `cmf_district` VALUES ('2790', '327', '0', '罗江县', '3');
INSERT INTO `cmf_district` VALUES ('2791', '327', '0', '中江县', '3');
INSERT INTO `cmf_district` VALUES ('2792', '328', '0', '康定县', '3');
INSERT INTO `cmf_district` VALUES ('2793', '328', '0', '丹巴县', '3');
INSERT INTO `cmf_district` VALUES ('2794', '328', '0', '泸定县', '3');
INSERT INTO `cmf_district` VALUES ('2795', '328', '0', '炉霍县', '3');
INSERT INTO `cmf_district` VALUES ('2796', '328', '0', '九龙县', '3');
INSERT INTO `cmf_district` VALUES ('2797', '328', '0', '甘孜县', '3');
INSERT INTO `cmf_district` VALUES ('2798', '328', '0', '雅江县', '3');
INSERT INTO `cmf_district` VALUES ('2799', '328', '0', '新龙县', '3');
INSERT INTO `cmf_district` VALUES ('2800', '328', '0', '道孚县', '3');
INSERT INTO `cmf_district` VALUES ('2801', '328', '0', '白玉县', '3');
INSERT INTO `cmf_district` VALUES ('2802', '328', '0', '理塘县', '3');
INSERT INTO `cmf_district` VALUES ('2803', '328', '0', '德格县', '3');
INSERT INTO `cmf_district` VALUES ('2804', '328', '0', '乡城县', '3');
INSERT INTO `cmf_district` VALUES ('2805', '328', '0', '石渠县', '3');
INSERT INTO `cmf_district` VALUES ('2806', '328', '0', '稻城县', '3');
INSERT INTO `cmf_district` VALUES ('2807', '328', '0', '色达县', '3');
INSERT INTO `cmf_district` VALUES ('2808', '328', '0', '巴塘县', '3');
INSERT INTO `cmf_district` VALUES ('2809', '328', '0', '得荣县', '3');
INSERT INTO `cmf_district` VALUES ('2810', '329', '0', '广安区', '3');
INSERT INTO `cmf_district` VALUES ('2811', '329', '0', '华蓥市', '3');
INSERT INTO `cmf_district` VALUES ('2812', '329', '0', '岳池县', '3');
INSERT INTO `cmf_district` VALUES ('2813', '329', '0', '武胜县', '3');
INSERT INTO `cmf_district` VALUES ('2814', '329', '0', '邻水县', '3');
INSERT INTO `cmf_district` VALUES ('2815', '330', '0', '利州区', '3');
INSERT INTO `cmf_district` VALUES ('2816', '330', '0', '元坝区', '3');
INSERT INTO `cmf_district` VALUES ('2817', '330', '0', '朝天区', '3');
INSERT INTO `cmf_district` VALUES ('2818', '330', '0', '旺苍县', '3');
INSERT INTO `cmf_district` VALUES ('2819', '330', '0', '青川县', '3');
INSERT INTO `cmf_district` VALUES ('2820', '330', '0', '剑阁县', '3');
INSERT INTO `cmf_district` VALUES ('2821', '330', '0', '苍溪县', '3');
INSERT INTO `cmf_district` VALUES ('2822', '331', '0', '峨眉山市', '3');
INSERT INTO `cmf_district` VALUES ('2823', '331', '0', '乐山市', '3');
INSERT INTO `cmf_district` VALUES ('2824', '331', '0', '犍为县', '3');
INSERT INTO `cmf_district` VALUES ('2825', '331', '0', '井研县', '3');
INSERT INTO `cmf_district` VALUES ('2826', '331', '0', '夹江县', '3');
INSERT INTO `cmf_district` VALUES ('2827', '331', '0', '沐川县', '3');
INSERT INTO `cmf_district` VALUES ('2828', '331', '0', '峨边', '3');
INSERT INTO `cmf_district` VALUES ('2829', '331', '0', '马边', '3');
INSERT INTO `cmf_district` VALUES ('2830', '332', '0', '西昌市', '3');
INSERT INTO `cmf_district` VALUES ('2831', '332', '0', '盐源县', '3');
INSERT INTO `cmf_district` VALUES ('2832', '332', '0', '德昌县', '3');
INSERT INTO `cmf_district` VALUES ('2833', '332', '0', '会理县', '3');
INSERT INTO `cmf_district` VALUES ('2834', '332', '0', '会东县', '3');
INSERT INTO `cmf_district` VALUES ('2835', '332', '0', '宁南县', '3');
INSERT INTO `cmf_district` VALUES ('2836', '332', '0', '普格县', '3');
INSERT INTO `cmf_district` VALUES ('2837', '332', '0', '布拖县', '3');
INSERT INTO `cmf_district` VALUES ('2838', '332', '0', '金阳县', '3');
INSERT INTO `cmf_district` VALUES ('2839', '332', '0', '昭觉县', '3');
INSERT INTO `cmf_district` VALUES ('2840', '332', '0', '喜德县', '3');
INSERT INTO `cmf_district` VALUES ('2841', '332', '0', '冕宁县', '3');
INSERT INTO `cmf_district` VALUES ('2842', '332', '0', '越西县', '3');
INSERT INTO `cmf_district` VALUES ('2843', '332', '0', '甘洛县', '3');
INSERT INTO `cmf_district` VALUES ('2844', '332', '0', '美姑县', '3');
INSERT INTO `cmf_district` VALUES ('2845', '332', '0', '雷波县', '3');
INSERT INTO `cmf_district` VALUES ('2846', '332', '0', '木里', '3');
INSERT INTO `cmf_district` VALUES ('2847', '333', '0', '东坡区', '3');
INSERT INTO `cmf_district` VALUES ('2848', '333', '0', '仁寿县', '3');
INSERT INTO `cmf_district` VALUES ('2849', '333', '0', '彭山县', '3');
INSERT INTO `cmf_district` VALUES ('2850', '333', '0', '洪雅县', '3');
INSERT INTO `cmf_district` VALUES ('2851', '333', '0', '丹棱县', '3');
INSERT INTO `cmf_district` VALUES ('2852', '333', '0', '青神县', '3');
INSERT INTO `cmf_district` VALUES ('2853', '334', '0', '阆中市', '3');
INSERT INTO `cmf_district` VALUES ('2854', '334', '0', '南部县', '3');
INSERT INTO `cmf_district` VALUES ('2855', '334', '0', '营山县', '3');
INSERT INTO `cmf_district` VALUES ('2856', '334', '0', '蓬安县', '3');
INSERT INTO `cmf_district` VALUES ('2857', '334', '0', '仪陇县', '3');
INSERT INTO `cmf_district` VALUES ('2858', '334', '0', '顺庆区', '3');
INSERT INTO `cmf_district` VALUES ('2859', '334', '0', '高坪区', '3');
INSERT INTO `cmf_district` VALUES ('2860', '334', '0', '嘉陵区', '3');
INSERT INTO `cmf_district` VALUES ('2861', '334', '0', '西充县', '3');
INSERT INTO `cmf_district` VALUES ('2862', '335', '0', '市中区', '3');
INSERT INTO `cmf_district` VALUES ('2863', '335', '0', '东兴区', '3');
INSERT INTO `cmf_district` VALUES ('2864', '335', '0', '威远县', '3');
INSERT INTO `cmf_district` VALUES ('2865', '335', '0', '资中县', '3');
INSERT INTO `cmf_district` VALUES ('2866', '335', '0', '隆昌县', '3');
INSERT INTO `cmf_district` VALUES ('2867', '336', '0', '东  区', '3');
INSERT INTO `cmf_district` VALUES ('2868', '336', '0', '西  区', '3');
INSERT INTO `cmf_district` VALUES ('2869', '336', '0', '仁和区', '3');
INSERT INTO `cmf_district` VALUES ('2870', '336', '0', '米易县', '3');
INSERT INTO `cmf_district` VALUES ('2871', '336', '0', '盐边县', '3');
INSERT INTO `cmf_district` VALUES ('2872', '337', '0', '船山区', '3');
INSERT INTO `cmf_district` VALUES ('2873', '337', '0', '安居区', '3');
INSERT INTO `cmf_district` VALUES ('2874', '337', '0', '蓬溪县', '3');
INSERT INTO `cmf_district` VALUES ('2875', '337', '0', '射洪县', '3');
INSERT INTO `cmf_district` VALUES ('2876', '337', '0', '大英县', '3');
INSERT INTO `cmf_district` VALUES ('2877', '338', '0', '雨城区', '3');
INSERT INTO `cmf_district` VALUES ('2878', '338', '0', '名山县', '3');
INSERT INTO `cmf_district` VALUES ('2879', '338', '0', '荥经县', '3');
INSERT INTO `cmf_district` VALUES ('2880', '338', '0', '汉源县', '3');
INSERT INTO `cmf_district` VALUES ('2881', '338', '0', '石棉县', '3');
INSERT INTO `cmf_district` VALUES ('2882', '338', '0', '天全县', '3');
INSERT INTO `cmf_district` VALUES ('2883', '338', '0', '芦山县', '3');
INSERT INTO `cmf_district` VALUES ('2884', '338', '0', '宝兴县', '3');
INSERT INTO `cmf_district` VALUES ('2885', '339', '0', '翠屏区', '3');
INSERT INTO `cmf_district` VALUES ('2886', '339', '0', '宜宾县', '3');
INSERT INTO `cmf_district` VALUES ('2887', '339', '0', '南溪县', '3');
INSERT INTO `cmf_district` VALUES ('2888', '339', '0', '江安县', '3');
INSERT INTO `cmf_district` VALUES ('2889', '339', '0', '长宁县', '3');
INSERT INTO `cmf_district` VALUES ('2890', '339', '0', '高县', '3');
INSERT INTO `cmf_district` VALUES ('2891', '339', '0', '珙县', '3');
INSERT INTO `cmf_district` VALUES ('2892', '339', '0', '筠连县', '3');
INSERT INTO `cmf_district` VALUES ('2893', '339', '0', '兴文县', '3');
INSERT INTO `cmf_district` VALUES ('2894', '339', '0', '屏山县', '3');
INSERT INTO `cmf_district` VALUES ('2895', '340', '0', '雁江区', '3');
INSERT INTO `cmf_district` VALUES ('2896', '340', '0', '简阳市', '3');
INSERT INTO `cmf_district` VALUES ('2897', '340', '0', '安岳县', '3');
INSERT INTO `cmf_district` VALUES ('2898', '340', '0', '乐至县', '3');
INSERT INTO `cmf_district` VALUES ('2899', '341', '0', '大安区', '3');
INSERT INTO `cmf_district` VALUES ('2900', '341', '0', '自流井区', '3');
INSERT INTO `cmf_district` VALUES ('2901', '341', '0', '贡井区', '3');
INSERT INTO `cmf_district` VALUES ('2902', '341', '0', '沿滩区', '3');
INSERT INTO `cmf_district` VALUES ('2903', '341', '0', '荣县', '3');
INSERT INTO `cmf_district` VALUES ('2904', '341', '0', '富顺县', '3');
INSERT INTO `cmf_district` VALUES ('2905', '342', '0', '江阳区', '3');
INSERT INTO `cmf_district` VALUES ('2906', '342', '0', '纳溪区', '3');
INSERT INTO `cmf_district` VALUES ('2907', '342', '0', '龙马潭区', '3');
INSERT INTO `cmf_district` VALUES ('2908', '342', '0', '泸县', '3');
INSERT INTO `cmf_district` VALUES ('2909', '342', '0', '合江县', '3');
INSERT INTO `cmf_district` VALUES ('2910', '342', '0', '叙永县', '3');
INSERT INTO `cmf_district` VALUES ('2911', '342', '0', '古蔺县', '3');
INSERT INTO `cmf_district` VALUES ('2912', '343', '0', '和平区', '3');
INSERT INTO `cmf_district` VALUES ('2913', '343', '0', '河西区', '3');
INSERT INTO `cmf_district` VALUES ('2914', '343', '0', '南开区', '3');
INSERT INTO `cmf_district` VALUES ('2915', '343', '0', '河北区', '3');
INSERT INTO `cmf_district` VALUES ('2916', '343', '0', '河东区', '3');
INSERT INTO `cmf_district` VALUES ('2917', '343', '0', '红桥区', '3');
INSERT INTO `cmf_district` VALUES ('2918', '343', '0', '东丽区', '3');
INSERT INTO `cmf_district` VALUES ('2919', '343', '0', '津南区', '3');
INSERT INTO `cmf_district` VALUES ('2920', '343', '0', '西青区', '3');
INSERT INTO `cmf_district` VALUES ('2921', '343', '0', '北辰区', '3');
INSERT INTO `cmf_district` VALUES ('2922', '343', '0', '塘沽区', '3');
INSERT INTO `cmf_district` VALUES ('2923', '343', '0', '汉沽区', '3');
INSERT INTO `cmf_district` VALUES ('2924', '343', '0', '大港区', '3');
INSERT INTO `cmf_district` VALUES ('2925', '343', '0', '武清区', '3');
INSERT INTO `cmf_district` VALUES ('2926', '343', '0', '宝坻区', '3');
INSERT INTO `cmf_district` VALUES ('2927', '343', '0', '经济开发区', '3');
INSERT INTO `cmf_district` VALUES ('2928', '343', '0', '宁河县', '3');
INSERT INTO `cmf_district` VALUES ('2929', '343', '0', '静海县', '3');
INSERT INTO `cmf_district` VALUES ('2930', '343', '0', '蓟县', '3');
INSERT INTO `cmf_district` VALUES ('2931', '344', '0', '城关区', '3');
INSERT INTO `cmf_district` VALUES ('2932', '344', '0', '林周县', '3');
INSERT INTO `cmf_district` VALUES ('2933', '344', '0', '当雄县', '3');
INSERT INTO `cmf_district` VALUES ('2934', '344', '0', '尼木县', '3');
INSERT INTO `cmf_district` VALUES ('2935', '344', '0', '曲水县', '3');
INSERT INTO `cmf_district` VALUES ('2936', '344', '0', '堆龙德庆县', '3');
INSERT INTO `cmf_district` VALUES ('2937', '344', '0', '达孜县', '3');
INSERT INTO `cmf_district` VALUES ('2938', '344', '0', '墨竹工卡县', '3');
INSERT INTO `cmf_district` VALUES ('2939', '345', '0', '噶尔县', '3');
INSERT INTO `cmf_district` VALUES ('2940', '345', '0', '普兰县', '3');
INSERT INTO `cmf_district` VALUES ('2941', '345', '0', '札达县', '3');
INSERT INTO `cmf_district` VALUES ('2942', '345', '0', '日土县', '3');
INSERT INTO `cmf_district` VALUES ('2943', '345', '0', '革吉县', '3');
INSERT INTO `cmf_district` VALUES ('2944', '345', '0', '改则县', '3');
INSERT INTO `cmf_district` VALUES ('2945', '345', '0', '措勤县', '3');
INSERT INTO `cmf_district` VALUES ('2946', '346', '0', '昌都县', '3');
INSERT INTO `cmf_district` VALUES ('2947', '346', '0', '江达县', '3');
INSERT INTO `cmf_district` VALUES ('2948', '346', '0', '贡觉县', '3');
INSERT INTO `cmf_district` VALUES ('2949', '346', '0', '类乌齐县', '3');
INSERT INTO `cmf_district` VALUES ('2950', '346', '0', '丁青县', '3');
INSERT INTO `cmf_district` VALUES ('2951', '346', '0', '察雅县', '3');
INSERT INTO `cmf_district` VALUES ('2952', '346', '0', '八宿县', '3');
INSERT INTO `cmf_district` VALUES ('2953', '346', '0', '左贡县', '3');
INSERT INTO `cmf_district` VALUES ('2954', '346', '0', '芒康县', '3');
INSERT INTO `cmf_district` VALUES ('2955', '346', '0', '洛隆县', '3');
INSERT INTO `cmf_district` VALUES ('2956', '346', '0', '边坝县', '3');
INSERT INTO `cmf_district` VALUES ('2957', '347', '0', '林芝县', '3');
INSERT INTO `cmf_district` VALUES ('2958', '347', '0', '工布江达县', '3');
INSERT INTO `cmf_district` VALUES ('2959', '347', '0', '米林县', '3');
INSERT INTO `cmf_district` VALUES ('2960', '347', '0', '墨脱县', '3');
INSERT INTO `cmf_district` VALUES ('2961', '347', '0', '波密县', '3');
INSERT INTO `cmf_district` VALUES ('2962', '347', '0', '察隅县', '3');
INSERT INTO `cmf_district` VALUES ('2963', '347', '0', '朗县', '3');
INSERT INTO `cmf_district` VALUES ('2964', '348', '0', '那曲县', '3');
INSERT INTO `cmf_district` VALUES ('2965', '348', '0', '嘉黎县', '3');
INSERT INTO `cmf_district` VALUES ('2966', '348', '0', '比如县', '3');
INSERT INTO `cmf_district` VALUES ('2967', '348', '0', '聂荣县', '3');
INSERT INTO `cmf_district` VALUES ('2968', '348', '0', '安多县', '3');
INSERT INTO `cmf_district` VALUES ('2969', '348', '0', '申扎县', '3');
INSERT INTO `cmf_district` VALUES ('2970', '348', '0', '索县', '3');
INSERT INTO `cmf_district` VALUES ('2971', '348', '0', '班戈县', '3');
INSERT INTO `cmf_district` VALUES ('2972', '348', '0', '巴青县', '3');
INSERT INTO `cmf_district` VALUES ('2973', '348', '0', '尼玛县', '3');
INSERT INTO `cmf_district` VALUES ('2974', '349', '0', '日喀则市', '3');
INSERT INTO `cmf_district` VALUES ('2975', '349', '0', '南木林县', '3');
INSERT INTO `cmf_district` VALUES ('2976', '349', '0', '江孜县', '3');
INSERT INTO `cmf_district` VALUES ('2977', '349', '0', '定日县', '3');
INSERT INTO `cmf_district` VALUES ('2978', '349', '0', '萨迦县', '3');
INSERT INTO `cmf_district` VALUES ('2979', '349', '0', '拉孜县', '3');
INSERT INTO `cmf_district` VALUES ('2980', '349', '0', '昂仁县', '3');
INSERT INTO `cmf_district` VALUES ('2981', '349', '0', '谢通门县', '3');
INSERT INTO `cmf_district` VALUES ('2982', '349', '0', '白朗县', '3');
INSERT INTO `cmf_district` VALUES ('2983', '349', '0', '仁布县', '3');
INSERT INTO `cmf_district` VALUES ('2984', '349', '0', '康马县', '3');
INSERT INTO `cmf_district` VALUES ('2985', '349', '0', '定结县', '3');
INSERT INTO `cmf_district` VALUES ('2986', '349', '0', '仲巴县', '3');
INSERT INTO `cmf_district` VALUES ('2987', '349', '0', '亚东县', '3');
INSERT INTO `cmf_district` VALUES ('2988', '349', '0', '吉隆县', '3');
INSERT INTO `cmf_district` VALUES ('2989', '349', '0', '聂拉木县', '3');
INSERT INTO `cmf_district` VALUES ('2990', '349', '0', '萨嘎县', '3');
INSERT INTO `cmf_district` VALUES ('2991', '349', '0', '岗巴县', '3');
INSERT INTO `cmf_district` VALUES ('2992', '350', '0', '乃东县', '3');
INSERT INTO `cmf_district` VALUES ('2993', '350', '0', '扎囊县', '3');
INSERT INTO `cmf_district` VALUES ('2994', '350', '0', '贡嘎县', '3');
INSERT INTO `cmf_district` VALUES ('2995', '350', '0', '桑日县', '3');
INSERT INTO `cmf_district` VALUES ('2996', '350', '0', '琼结县', '3');
INSERT INTO `cmf_district` VALUES ('2997', '350', '0', '曲松县', '3');
INSERT INTO `cmf_district` VALUES ('2998', '350', '0', '措美县', '3');
INSERT INTO `cmf_district` VALUES ('2999', '350', '0', '洛扎县', '3');
INSERT INTO `cmf_district` VALUES ('3000', '350', '0', '加查县', '3');
INSERT INTO `cmf_district` VALUES ('3001', '350', '0', '隆子县', '3');
INSERT INTO `cmf_district` VALUES ('3002', '350', '0', '错那县', '3');
INSERT INTO `cmf_district` VALUES ('3003', '350', '0', '浪卡子县', '3');
INSERT INTO `cmf_district` VALUES ('3004', '351', '0', '天山区', '3');
INSERT INTO `cmf_district` VALUES ('3005', '351', '0', '沙依巴克区', '3');
INSERT INTO `cmf_district` VALUES ('3006', '351', '0', '新市区', '3');
INSERT INTO `cmf_district` VALUES ('3007', '351', '0', '水磨沟区', '3');
INSERT INTO `cmf_district` VALUES ('3008', '351', '0', '头屯河区', '3');
INSERT INTO `cmf_district` VALUES ('3009', '351', '0', '达坂城区', '3');
INSERT INTO `cmf_district` VALUES ('3010', '351', '0', '米东区', '3');
INSERT INTO `cmf_district` VALUES ('3011', '351', '0', '乌鲁木齐县', '3');
INSERT INTO `cmf_district` VALUES ('3012', '352', '0', '阿克苏市', '3');
INSERT INTO `cmf_district` VALUES ('3013', '352', '0', '温宿县', '3');
INSERT INTO `cmf_district` VALUES ('3014', '352', '0', '库车县', '3');
INSERT INTO `cmf_district` VALUES ('3015', '352', '0', '沙雅县', '3');
INSERT INTO `cmf_district` VALUES ('3016', '352', '0', '新和县', '3');
INSERT INTO `cmf_district` VALUES ('3017', '352', '0', '拜城县', '3');
INSERT INTO `cmf_district` VALUES ('3018', '352', '0', '乌什县', '3');
INSERT INTO `cmf_district` VALUES ('3019', '352', '0', '阿瓦提县', '3');
INSERT INTO `cmf_district` VALUES ('3020', '352', '0', '柯坪县', '3');
INSERT INTO `cmf_district` VALUES ('3021', '353', '0', '阿拉尔市', '3');
INSERT INTO `cmf_district` VALUES ('3022', '354', '0', '库尔勒市', '3');
INSERT INTO `cmf_district` VALUES ('3023', '354', '0', '轮台县', '3');
INSERT INTO `cmf_district` VALUES ('3024', '354', '0', '尉犁县', '3');
INSERT INTO `cmf_district` VALUES ('3025', '354', '0', '若羌县', '3');
INSERT INTO `cmf_district` VALUES ('3026', '354', '0', '且末县', '3');
INSERT INTO `cmf_district` VALUES ('3027', '354', '0', '焉耆', '3');
INSERT INTO `cmf_district` VALUES ('3028', '354', '0', '和静县', '3');
INSERT INTO `cmf_district` VALUES ('3029', '354', '0', '和硕县', '3');
INSERT INTO `cmf_district` VALUES ('3030', '354', '0', '博湖县', '3');
INSERT INTO `cmf_district` VALUES ('3031', '355', '0', '博乐市', '3');
INSERT INTO `cmf_district` VALUES ('3032', '355', '0', '精河县', '3');
INSERT INTO `cmf_district` VALUES ('3033', '355', '0', '温泉县', '3');
INSERT INTO `cmf_district` VALUES ('3034', '356', '0', '呼图壁县', '3');
INSERT INTO `cmf_district` VALUES ('3035', '356', '0', '米泉市', '3');
INSERT INTO `cmf_district` VALUES ('3036', '356', '0', '昌吉市', '3');
INSERT INTO `cmf_district` VALUES ('3037', '356', '0', '阜康市', '3');
INSERT INTO `cmf_district` VALUES ('3038', '356', '0', '玛纳斯县', '3');
INSERT INTO `cmf_district` VALUES ('3039', '356', '0', '奇台县', '3');
INSERT INTO `cmf_district` VALUES ('3040', '356', '0', '吉木萨尔县', '3');
INSERT INTO `cmf_district` VALUES ('3041', '356', '0', '木垒', '3');
INSERT INTO `cmf_district` VALUES ('3042', '357', '0', '哈密市', '3');
INSERT INTO `cmf_district` VALUES ('3043', '357', '0', '伊吾县', '3');
INSERT INTO `cmf_district` VALUES ('3044', '357', '0', '巴里坤', '3');
INSERT INTO `cmf_district` VALUES ('3045', '358', '0', '和田市', '3');
INSERT INTO `cmf_district` VALUES ('3046', '358', '0', '和田县', '3');
INSERT INTO `cmf_district` VALUES ('3047', '358', '0', '墨玉县', '3');
INSERT INTO `cmf_district` VALUES ('3048', '358', '0', '皮山县', '3');
INSERT INTO `cmf_district` VALUES ('3049', '358', '0', '洛浦县', '3');
INSERT INTO `cmf_district` VALUES ('3050', '358', '0', '策勒县', '3');
INSERT INTO `cmf_district` VALUES ('3051', '358', '0', '于田县', '3');
INSERT INTO `cmf_district` VALUES ('3052', '358', '0', '民丰县', '3');
INSERT INTO `cmf_district` VALUES ('3053', '359', '0', '喀什市', '3');
INSERT INTO `cmf_district` VALUES ('3054', '359', '0', '疏附县', '3');
INSERT INTO `cmf_district` VALUES ('3055', '359', '0', '疏勒县', '3');
INSERT INTO `cmf_district` VALUES ('3056', '359', '0', '英吉沙县', '3');
INSERT INTO `cmf_district` VALUES ('3057', '359', '0', '泽普县', '3');
INSERT INTO `cmf_district` VALUES ('3058', '359', '0', '莎车县', '3');
INSERT INTO `cmf_district` VALUES ('3059', '359', '0', '叶城县', '3');
INSERT INTO `cmf_district` VALUES ('3060', '359', '0', '麦盖提县', '3');
INSERT INTO `cmf_district` VALUES ('3061', '359', '0', '岳普湖县', '3');
INSERT INTO `cmf_district` VALUES ('3062', '359', '0', '伽师县', '3');
INSERT INTO `cmf_district` VALUES ('3063', '359', '0', '巴楚县', '3');
INSERT INTO `cmf_district` VALUES ('3064', '359', '0', '塔什库尔干', '3');
INSERT INTO `cmf_district` VALUES ('3065', '360', '0', '克拉玛依市', '3');
INSERT INTO `cmf_district` VALUES ('3066', '361', '0', '阿图什市', '3');
INSERT INTO `cmf_district` VALUES ('3067', '361', '0', '阿克陶县', '3');
INSERT INTO `cmf_district` VALUES ('3068', '361', '0', '阿合奇县', '3');
INSERT INTO `cmf_district` VALUES ('3069', '361', '0', '乌恰县', '3');
INSERT INTO `cmf_district` VALUES ('3070', '362', '0', '石河子市', '3');
INSERT INTO `cmf_district` VALUES ('3071', '363', '0', '图木舒克市', '3');
INSERT INTO `cmf_district` VALUES ('3072', '364', '0', '吐鲁番市', '3');
INSERT INTO `cmf_district` VALUES ('3073', '364', '0', '鄯善县', '3');
INSERT INTO `cmf_district` VALUES ('3074', '364', '0', '托克逊县', '3');
INSERT INTO `cmf_district` VALUES ('3075', '365', '0', '五家渠市', '3');
INSERT INTO `cmf_district` VALUES ('3076', '366', '0', '阿勒泰市', '3');
INSERT INTO `cmf_district` VALUES ('3077', '366', '0', '布克赛尔', '3');
INSERT INTO `cmf_district` VALUES ('3078', '366', '0', '伊宁市', '3');
INSERT INTO `cmf_district` VALUES ('3079', '366', '0', '布尔津县', '3');
INSERT INTO `cmf_district` VALUES ('3080', '366', '0', '奎屯市', '3');
INSERT INTO `cmf_district` VALUES ('3081', '366', '0', '乌苏市', '3');
INSERT INTO `cmf_district` VALUES ('3082', '366', '0', '额敏县', '3');
INSERT INTO `cmf_district` VALUES ('3083', '366', '0', '富蕴县', '3');
INSERT INTO `cmf_district` VALUES ('3084', '366', '0', '伊宁县', '3');
INSERT INTO `cmf_district` VALUES ('3085', '366', '0', '福海县', '3');
INSERT INTO `cmf_district` VALUES ('3086', '366', '0', '霍城县', '3');
INSERT INTO `cmf_district` VALUES ('3087', '366', '0', '沙湾县', '3');
INSERT INTO `cmf_district` VALUES ('3088', '366', '0', '巩留县', '3');
INSERT INTO `cmf_district` VALUES ('3089', '366', '0', '哈巴河县', '3');
INSERT INTO `cmf_district` VALUES ('3090', '366', '0', '托里县', '3');
INSERT INTO `cmf_district` VALUES ('3091', '366', '0', '青河县', '3');
INSERT INTO `cmf_district` VALUES ('3092', '366', '0', '新源县', '3');
INSERT INTO `cmf_district` VALUES ('3093', '366', '0', '裕民县', '3');
INSERT INTO `cmf_district` VALUES ('3094', '366', '0', '和布克赛尔', '3');
INSERT INTO `cmf_district` VALUES ('3095', '366', '0', '吉木乃县', '3');
INSERT INTO `cmf_district` VALUES ('3096', '366', '0', '昭苏县', '3');
INSERT INTO `cmf_district` VALUES ('3097', '366', '0', '特克斯县', '3');
INSERT INTO `cmf_district` VALUES ('3098', '366', '0', '尼勒克县', '3');
INSERT INTO `cmf_district` VALUES ('3099', '366', '0', '察布查尔', '3');
INSERT INTO `cmf_district` VALUES ('3100', '367', '0', '盘龙区', '3');
INSERT INTO `cmf_district` VALUES ('3101', '367', '0', '五华区', '3');
INSERT INTO `cmf_district` VALUES ('3102', '367', '0', '官渡区', '3');
INSERT INTO `cmf_district` VALUES ('3103', '367', '0', '西山区', '3');
INSERT INTO `cmf_district` VALUES ('3104', '367', '0', '东川区', '3');
INSERT INTO `cmf_district` VALUES ('3105', '367', '0', '安宁市', '3');
INSERT INTO `cmf_district` VALUES ('3106', '367', '0', '呈贡县', '3');
INSERT INTO `cmf_district` VALUES ('3107', '367', '0', '晋宁县', '3');
INSERT INTO `cmf_district` VALUES ('3108', '367', '0', '富民县', '3');
INSERT INTO `cmf_district` VALUES ('3109', '367', '0', '宜良县', '3');
INSERT INTO `cmf_district` VALUES ('3110', '367', '0', '嵩明县', '3');
INSERT INTO `cmf_district` VALUES ('3111', '367', '0', '石林县', '3');
INSERT INTO `cmf_district` VALUES ('3112', '367', '0', '禄劝', '3');
INSERT INTO `cmf_district` VALUES ('3113', '367', '0', '寻甸', '3');
INSERT INTO `cmf_district` VALUES ('3114', '368', '0', '兰坪', '3');
INSERT INTO `cmf_district` VALUES ('3115', '368', '0', '泸水县', '3');
INSERT INTO `cmf_district` VALUES ('3116', '368', '0', '福贡县', '3');
INSERT INTO `cmf_district` VALUES ('3117', '368', '0', '贡山', '3');
INSERT INTO `cmf_district` VALUES ('3118', '369', '0', '宁洱', '3');
INSERT INTO `cmf_district` VALUES ('3119', '369', '0', '思茅区', '3');
INSERT INTO `cmf_district` VALUES ('3120', '369', '0', '墨江', '3');
INSERT INTO `cmf_district` VALUES ('3121', '369', '0', '景东', '3');
INSERT INTO `cmf_district` VALUES ('3122', '369', '0', '景谷', '3');
INSERT INTO `cmf_district` VALUES ('3123', '369', '0', '镇沅', '3');
INSERT INTO `cmf_district` VALUES ('3124', '369', '0', '江城', '3');
INSERT INTO `cmf_district` VALUES ('3125', '369', '0', '孟连', '3');
INSERT INTO `cmf_district` VALUES ('3126', '369', '0', '澜沧', '3');
INSERT INTO `cmf_district` VALUES ('3127', '369', '0', '西盟', '3');
INSERT INTO `cmf_district` VALUES ('3128', '370', '0', '古城区', '3');
INSERT INTO `cmf_district` VALUES ('3129', '370', '0', '宁蒗', '3');
INSERT INTO `cmf_district` VALUES ('3130', '370', '0', '玉龙', '3');
INSERT INTO `cmf_district` VALUES ('3131', '370', '0', '永胜县', '3');
INSERT INTO `cmf_district` VALUES ('3132', '370', '0', '华坪县', '3');
INSERT INTO `cmf_district` VALUES ('3133', '371', '0', '隆阳区', '3');
INSERT INTO `cmf_district` VALUES ('3134', '371', '0', '施甸县', '3');
INSERT INTO `cmf_district` VALUES ('3135', '371', '0', '腾冲县', '3');
INSERT INTO `cmf_district` VALUES ('3136', '371', '0', '龙陵县', '3');
INSERT INTO `cmf_district` VALUES ('3137', '371', '0', '昌宁县', '3');
INSERT INTO `cmf_district` VALUES ('3138', '372', '0', '楚雄市', '3');
INSERT INTO `cmf_district` VALUES ('3139', '372', '0', '双柏县', '3');
INSERT INTO `cmf_district` VALUES ('3140', '372', '0', '牟定县', '3');
INSERT INTO `cmf_district` VALUES ('3141', '372', '0', '南华县', '3');
INSERT INTO `cmf_district` VALUES ('3142', '372', '0', '姚安县', '3');
INSERT INTO `cmf_district` VALUES ('3143', '372', '0', '大姚县', '3');
INSERT INTO `cmf_district` VALUES ('3144', '372', '0', '永仁县', '3');
INSERT INTO `cmf_district` VALUES ('3145', '372', '0', '元谋县', '3');
INSERT INTO `cmf_district` VALUES ('3146', '372', '0', '武定县', '3');
INSERT INTO `cmf_district` VALUES ('3147', '372', '0', '禄丰县', '3');
INSERT INTO `cmf_district` VALUES ('3148', '373', '0', '大理市', '3');
INSERT INTO `cmf_district` VALUES ('3149', '373', '0', '祥云县', '3');
INSERT INTO `cmf_district` VALUES ('3150', '373', '0', '宾川县', '3');
INSERT INTO `cmf_district` VALUES ('3151', '373', '0', '弥渡县', '3');
INSERT INTO `cmf_district` VALUES ('3152', '373', '0', '永平县', '3');
INSERT INTO `cmf_district` VALUES ('3153', '373', '0', '云龙县', '3');
INSERT INTO `cmf_district` VALUES ('3154', '373', '0', '洱源县', '3');
INSERT INTO `cmf_district` VALUES ('3155', '373', '0', '剑川县', '3');
INSERT INTO `cmf_district` VALUES ('3156', '373', '0', '鹤庆县', '3');
INSERT INTO `cmf_district` VALUES ('3157', '373', '0', '漾濞', '3');
INSERT INTO `cmf_district` VALUES ('3158', '373', '0', '南涧', '3');
INSERT INTO `cmf_district` VALUES ('3159', '373', '0', '巍山', '3');
INSERT INTO `cmf_district` VALUES ('3160', '374', '0', '潞西市', '3');
INSERT INTO `cmf_district` VALUES ('3161', '374', '0', '瑞丽市', '3');
INSERT INTO `cmf_district` VALUES ('3162', '374', '0', '梁河县', '3');
INSERT INTO `cmf_district` VALUES ('3163', '374', '0', '盈江县', '3');
INSERT INTO `cmf_district` VALUES ('3164', '374', '0', '陇川县', '3');
INSERT INTO `cmf_district` VALUES ('3165', '375', '0', '香格里拉县', '3');
INSERT INTO `cmf_district` VALUES ('3166', '375', '0', '德钦县', '3');
INSERT INTO `cmf_district` VALUES ('3167', '375', '0', '维西', '3');
INSERT INTO `cmf_district` VALUES ('3168', '376', '0', '泸西县', '3');
INSERT INTO `cmf_district` VALUES ('3169', '376', '0', '蒙自县', '3');
INSERT INTO `cmf_district` VALUES ('3170', '376', '0', '个旧市', '3');
INSERT INTO `cmf_district` VALUES ('3171', '376', '0', '开远市', '3');
INSERT INTO `cmf_district` VALUES ('3172', '376', '0', '绿春县', '3');
INSERT INTO `cmf_district` VALUES ('3173', '376', '0', '建水县', '3');
INSERT INTO `cmf_district` VALUES ('3174', '376', '0', '石屏县', '3');
INSERT INTO `cmf_district` VALUES ('3175', '376', '0', '弥勒县', '3');
INSERT INTO `cmf_district` VALUES ('3176', '376', '0', '元阳县', '3');
INSERT INTO `cmf_district` VALUES ('3177', '376', '0', '红河县', '3');
INSERT INTO `cmf_district` VALUES ('3178', '376', '0', '金平', '3');
INSERT INTO `cmf_district` VALUES ('3179', '376', '0', '河口', '3');
INSERT INTO `cmf_district` VALUES ('3180', '376', '0', '屏边', '3');
INSERT INTO `cmf_district` VALUES ('3181', '377', '0', '临翔区', '3');
INSERT INTO `cmf_district` VALUES ('3182', '377', '0', '凤庆县', '3');
INSERT INTO `cmf_district` VALUES ('3183', '377', '0', '云县', '3');
INSERT INTO `cmf_district` VALUES ('3184', '377', '0', '永德县', '3');
INSERT INTO `cmf_district` VALUES ('3185', '377', '0', '镇康县', '3');
INSERT INTO `cmf_district` VALUES ('3186', '377', '0', '双江', '3');
INSERT INTO `cmf_district` VALUES ('3187', '377', '0', '耿马', '3');
INSERT INTO `cmf_district` VALUES ('3188', '377', '0', '沧源', '3');
INSERT INTO `cmf_district` VALUES ('3189', '378', '0', '麒麟区', '3');
INSERT INTO `cmf_district` VALUES ('3190', '378', '0', '宣威市', '3');
INSERT INTO `cmf_district` VALUES ('3191', '378', '0', '马龙县', '3');
INSERT INTO `cmf_district` VALUES ('3192', '378', '0', '陆良县', '3');
INSERT INTO `cmf_district` VALUES ('3193', '378', '0', '师宗县', '3');
INSERT INTO `cmf_district` VALUES ('3194', '378', '0', '罗平县', '3');
INSERT INTO `cmf_district` VALUES ('3195', '378', '0', '富源县', '3');
INSERT INTO `cmf_district` VALUES ('3196', '378', '0', '会泽县', '3');
INSERT INTO `cmf_district` VALUES ('3197', '378', '0', '沾益县', '3');
INSERT INTO `cmf_district` VALUES ('3198', '379', '0', '文山县', '3');
INSERT INTO `cmf_district` VALUES ('3199', '379', '0', '砚山县', '3');
INSERT INTO `cmf_district` VALUES ('3200', '379', '0', '西畴县', '3');
INSERT INTO `cmf_district` VALUES ('3201', '379', '0', '麻栗坡县', '3');
INSERT INTO `cmf_district` VALUES ('3202', '379', '0', '马关县', '3');
INSERT INTO `cmf_district` VALUES ('3203', '379', '0', '丘北县', '3');
INSERT INTO `cmf_district` VALUES ('3204', '379', '0', '广南县', '3');
INSERT INTO `cmf_district` VALUES ('3205', '379', '0', '富宁县', '3');
INSERT INTO `cmf_district` VALUES ('3206', '380', '0', '景洪市', '3');
INSERT INTO `cmf_district` VALUES ('3207', '380', '0', '勐海县', '3');
INSERT INTO `cmf_district` VALUES ('3208', '380', '0', '勐腊县', '3');
INSERT INTO `cmf_district` VALUES ('3209', '381', '0', '红塔区', '3');
INSERT INTO `cmf_district` VALUES ('3210', '381', '0', '江川县', '3');
INSERT INTO `cmf_district` VALUES ('3211', '381', '0', '澄江县', '3');
INSERT INTO `cmf_district` VALUES ('3212', '381', '0', '通海县', '3');
INSERT INTO `cmf_district` VALUES ('3213', '381', '0', '华宁县', '3');
INSERT INTO `cmf_district` VALUES ('3214', '381', '0', '易门县', '3');
INSERT INTO `cmf_district` VALUES ('3215', '381', '0', '峨山', '3');
INSERT INTO `cmf_district` VALUES ('3216', '381', '0', '新平', '3');
INSERT INTO `cmf_district` VALUES ('3217', '381', '0', '元江', '3');
INSERT INTO `cmf_district` VALUES ('3218', '382', '0', '昭阳区', '3');
INSERT INTO `cmf_district` VALUES ('3219', '382', '0', '鲁甸县', '3');
INSERT INTO `cmf_district` VALUES ('3220', '382', '0', '巧家县', '3');
INSERT INTO `cmf_district` VALUES ('3221', '382', '0', '盐津县', '3');
INSERT INTO `cmf_district` VALUES ('3222', '382', '0', '大关县', '3');
INSERT INTO `cmf_district` VALUES ('3223', '382', '0', '永善县', '3');
INSERT INTO `cmf_district` VALUES ('3224', '382', '0', '绥江县', '3');
INSERT INTO `cmf_district` VALUES ('3225', '382', '0', '镇雄县', '3');
INSERT INTO `cmf_district` VALUES ('3226', '382', '0', '彝良县', '3');
INSERT INTO `cmf_district` VALUES ('3227', '382', '0', '威信县', '3');
INSERT INTO `cmf_district` VALUES ('3228', '382', '0', '水富县', '3');
INSERT INTO `cmf_district` VALUES ('3229', '383', '0', '西湖区', '3');
INSERT INTO `cmf_district` VALUES ('3230', '383', '0', '上城区', '3');
INSERT INTO `cmf_district` VALUES ('3231', '383', '0', '下城区', '3');
INSERT INTO `cmf_district` VALUES ('3232', '383', '0', '拱墅区', '3');
INSERT INTO `cmf_district` VALUES ('3233', '383', '0', '滨江区', '3');
INSERT INTO `cmf_district` VALUES ('3234', '383', '0', '江干区', '3');
INSERT INTO `cmf_district` VALUES ('3235', '383', '0', '萧山区', '3');
INSERT INTO `cmf_district` VALUES ('3236', '383', '0', '余杭区', '3');
INSERT INTO `cmf_district` VALUES ('3237', '383', '0', '市郊', '3');
INSERT INTO `cmf_district` VALUES ('3238', '383', '0', '建德市', '3');
INSERT INTO `cmf_district` VALUES ('3239', '383', '0', '富阳市', '3');
INSERT INTO `cmf_district` VALUES ('3240', '383', '0', '临安市', '3');
INSERT INTO `cmf_district` VALUES ('3241', '383', '0', '桐庐县', '3');
INSERT INTO `cmf_district` VALUES ('3242', '383', '0', '淳安县', '3');
INSERT INTO `cmf_district` VALUES ('3243', '384', '0', '吴兴区', '3');
INSERT INTO `cmf_district` VALUES ('3244', '384', '0', '南浔区', '3');
INSERT INTO `cmf_district` VALUES ('3245', '384', '0', '德清县', '3');
INSERT INTO `cmf_district` VALUES ('3246', '384', '0', '长兴县', '3');
INSERT INTO `cmf_district` VALUES ('3247', '384', '0', '安吉县', '3');
INSERT INTO `cmf_district` VALUES ('3248', '385', '0', '南湖区', '3');
INSERT INTO `cmf_district` VALUES ('3249', '385', '0', '秀洲区', '3');
INSERT INTO `cmf_district` VALUES ('3250', '385', '0', '海宁市', '3');
INSERT INTO `cmf_district` VALUES ('3251', '385', '0', '嘉善县', '3');
INSERT INTO `cmf_district` VALUES ('3252', '385', '0', '平湖市', '3');
INSERT INTO `cmf_district` VALUES ('3253', '385', '0', '桐乡市', '3');
INSERT INTO `cmf_district` VALUES ('3254', '385', '0', '海盐县', '3');
INSERT INTO `cmf_district` VALUES ('3255', '386', '0', '婺城区', '3');
INSERT INTO `cmf_district` VALUES ('3256', '386', '0', '金东区', '3');
INSERT INTO `cmf_district` VALUES ('3257', '386', '0', '兰溪市', '3');
INSERT INTO `cmf_district` VALUES ('3258', '386', '0', '市区', '3');
INSERT INTO `cmf_district` VALUES ('3259', '386', '0', '佛堂镇', '3');
INSERT INTO `cmf_district` VALUES ('3260', '386', '0', '上溪镇', '3');
INSERT INTO `cmf_district` VALUES ('3261', '386', '0', '义亭镇', '3');
INSERT INTO `cmf_district` VALUES ('3262', '386', '0', '大陈镇', '3');
INSERT INTO `cmf_district` VALUES ('3263', '386', '0', '苏溪镇', '3');
INSERT INTO `cmf_district` VALUES ('3264', '386', '0', '赤岸镇', '3');
INSERT INTO `cmf_district` VALUES ('3265', '386', '0', '东阳市', '3');
INSERT INTO `cmf_district` VALUES ('3266', '386', '0', '永康市', '3');
INSERT INTO `cmf_district` VALUES ('3267', '386', '0', '武义县', '3');
INSERT INTO `cmf_district` VALUES ('3268', '386', '0', '浦江县', '3');
INSERT INTO `cmf_district` VALUES ('3269', '386', '0', '磐安县', '3');
INSERT INTO `cmf_district` VALUES ('3270', '387', '0', '莲都区', '3');
INSERT INTO `cmf_district` VALUES ('3271', '387', '0', '龙泉市', '3');
INSERT INTO `cmf_district` VALUES ('3272', '387', '0', '青田县', '3');
INSERT INTO `cmf_district` VALUES ('3273', '387', '0', '缙云县', '3');
INSERT INTO `cmf_district` VALUES ('3274', '387', '0', '遂昌县', '3');
INSERT INTO `cmf_district` VALUES ('3275', '387', '0', '松阳县', '3');
INSERT INTO `cmf_district` VALUES ('3276', '387', '0', '云和县', '3');
INSERT INTO `cmf_district` VALUES ('3277', '387', '0', '庆元县', '3');
INSERT INTO `cmf_district` VALUES ('3278', '387', '0', '景宁', '3');
INSERT INTO `cmf_district` VALUES ('3279', '388', '0', '海曙区', '3');
INSERT INTO `cmf_district` VALUES ('3280', '388', '0', '江东区', '3');
INSERT INTO `cmf_district` VALUES ('3281', '388', '0', '江北区', '3');
INSERT INTO `cmf_district` VALUES ('3282', '388', '0', '镇海区', '3');
INSERT INTO `cmf_district` VALUES ('3283', '388', '0', '北仑区', '3');
INSERT INTO `cmf_district` VALUES ('3284', '388', '0', '鄞州区', '3');
INSERT INTO `cmf_district` VALUES ('3285', '388', '0', '余姚市', '3');
INSERT INTO `cmf_district` VALUES ('3286', '388', '0', '慈溪市', '3');
INSERT INTO `cmf_district` VALUES ('3287', '388', '0', '奉化市', '3');
INSERT INTO `cmf_district` VALUES ('3288', '388', '0', '象山县', '3');
INSERT INTO `cmf_district` VALUES ('3289', '388', '0', '宁海县', '3');
INSERT INTO `cmf_district` VALUES ('3290', '389', '0', '越城区', '3');
INSERT INTO `cmf_district` VALUES ('3291', '389', '0', '上虞市', '3');
INSERT INTO `cmf_district` VALUES ('3292', '389', '0', '嵊州市', '3');
INSERT INTO `cmf_district` VALUES ('3293', '389', '0', '绍兴县', '3');
INSERT INTO `cmf_district` VALUES ('3294', '389', '0', '新昌县', '3');
INSERT INTO `cmf_district` VALUES ('3295', '389', '0', '诸暨市', '3');
INSERT INTO `cmf_district` VALUES ('3296', '390', '0', '椒江区', '3');
INSERT INTO `cmf_district` VALUES ('3297', '390', '0', '黄岩区', '3');
INSERT INTO `cmf_district` VALUES ('3298', '390', '0', '路桥区', '3');
INSERT INTO `cmf_district` VALUES ('3299', '390', '0', '温岭市', '3');
INSERT INTO `cmf_district` VALUES ('3300', '390', '0', '临海市', '3');
INSERT INTO `cmf_district` VALUES ('3301', '390', '0', '玉环县', '3');
INSERT INTO `cmf_district` VALUES ('3302', '390', '0', '三门县', '3');
INSERT INTO `cmf_district` VALUES ('3303', '390', '0', '天台县', '3');
INSERT INTO `cmf_district` VALUES ('3304', '390', '0', '仙居县', '3');
INSERT INTO `cmf_district` VALUES ('3305', '391', '0', '鹿城区', '3');
INSERT INTO `cmf_district` VALUES ('3306', '391', '0', '龙湾区', '3');
INSERT INTO `cmf_district` VALUES ('3307', '391', '0', '瓯海区', '3');
INSERT INTO `cmf_district` VALUES ('3308', '391', '0', '瑞安市', '3');
INSERT INTO `cmf_district` VALUES ('3309', '391', '0', '乐清市', '3');
INSERT INTO `cmf_district` VALUES ('3310', '391', '0', '洞头县', '3');
INSERT INTO `cmf_district` VALUES ('3311', '391', '0', '永嘉县', '3');
INSERT INTO `cmf_district` VALUES ('3312', '391', '0', '平阳县', '3');
INSERT INTO `cmf_district` VALUES ('3313', '391', '0', '苍南县', '3');
INSERT INTO `cmf_district` VALUES ('3314', '391', '0', '文成县', '3');
INSERT INTO `cmf_district` VALUES ('3315', '391', '0', '泰顺县', '3');
INSERT INTO `cmf_district` VALUES ('3316', '392', '0', '定海区', '3');
INSERT INTO `cmf_district` VALUES ('3317', '392', '0', '普陀区', '3');
INSERT INTO `cmf_district` VALUES ('3318', '392', '0', '岱山县', '3');
INSERT INTO `cmf_district` VALUES ('3319', '392', '0', '嵊泗县', '3');
INSERT INTO `cmf_district` VALUES ('3320', '393', '0', '衢州市', '3');
INSERT INTO `cmf_district` VALUES ('3321', '393', '0', '江山市', '3');
INSERT INTO `cmf_district` VALUES ('3322', '393', '0', '常山县', '3');
INSERT INTO `cmf_district` VALUES ('3323', '393', '0', '开化县', '3');
INSERT INTO `cmf_district` VALUES ('3324', '393', '0', '龙游县', '3');
INSERT INTO `cmf_district` VALUES ('3325', '394', '0', '合川区', '3');
INSERT INTO `cmf_district` VALUES ('3326', '394', '0', '江津区', '3');
INSERT INTO `cmf_district` VALUES ('3327', '394', '0', '南川区', '3');
INSERT INTO `cmf_district` VALUES ('3328', '394', '0', '永川区', '3');
INSERT INTO `cmf_district` VALUES ('3329', '394', '0', '南岸区', '3');
INSERT INTO `cmf_district` VALUES ('3330', '394', '0', '渝北区', '3');
INSERT INTO `cmf_district` VALUES ('3331', '394', '0', '万盛区', '3');
INSERT INTO `cmf_district` VALUES ('3332', '394', '0', '大渡口区', '3');
INSERT INTO `cmf_district` VALUES ('3333', '394', '0', '万州区', '3');
INSERT INTO `cmf_district` VALUES ('3334', '394', '0', '北碚区', '3');
INSERT INTO `cmf_district` VALUES ('3335', '394', '0', '沙坪坝区', '3');
INSERT INTO `cmf_district` VALUES ('3336', '394', '0', '巴南区', '3');
INSERT INTO `cmf_district` VALUES ('3337', '394', '0', '涪陵区', '3');
INSERT INTO `cmf_district` VALUES ('3338', '394', '0', '江北区', '3');
INSERT INTO `cmf_district` VALUES ('3339', '394', '0', '九龙坡区', '3');
INSERT INTO `cmf_district` VALUES ('3340', '394', '0', '渝中区', '3');
INSERT INTO `cmf_district` VALUES ('3341', '394', '0', '黔江开发区', '3');
INSERT INTO `cmf_district` VALUES ('3342', '394', '0', '长寿区', '3');
INSERT INTO `cmf_district` VALUES ('3343', '394', '0', '双桥区', '3');
INSERT INTO `cmf_district` VALUES ('3344', '394', '0', '綦江县', '3');
INSERT INTO `cmf_district` VALUES ('3345', '394', '0', '潼南县', '3');
INSERT INTO `cmf_district` VALUES ('3346', '394', '0', '铜梁县', '3');
INSERT INTO `cmf_district` VALUES ('3347', '394', '0', '大足县', '3');
INSERT INTO `cmf_district` VALUES ('3348', '394', '0', '荣昌县', '3');
INSERT INTO `cmf_district` VALUES ('3349', '394', '0', '璧山县', '3');
INSERT INTO `cmf_district` VALUES ('3350', '394', '0', '垫江县', '3');
INSERT INTO `cmf_district` VALUES ('3351', '394', '0', '武隆县', '3');
INSERT INTO `cmf_district` VALUES ('3352', '394', '0', '丰都县', '3');
INSERT INTO `cmf_district` VALUES ('3353', '394', '0', '城口县', '3');
INSERT INTO `cmf_district` VALUES ('3354', '394', '0', '梁平县', '3');
INSERT INTO `cmf_district` VALUES ('3355', '394', '0', '开县', '3');
INSERT INTO `cmf_district` VALUES ('3356', '394', '0', '巫溪县', '3');
INSERT INTO `cmf_district` VALUES ('3357', '394', '0', '巫山县', '3');
INSERT INTO `cmf_district` VALUES ('3358', '394', '0', '奉节县', '3');
INSERT INTO `cmf_district` VALUES ('3359', '394', '0', '云阳县', '3');
INSERT INTO `cmf_district` VALUES ('3360', '394', '0', '忠县', '3');
INSERT INTO `cmf_district` VALUES ('3361', '394', '0', '石柱', '3');
INSERT INTO `cmf_district` VALUES ('3362', '394', '0', '彭水', '3');
INSERT INTO `cmf_district` VALUES ('3363', '394', '0', '酉阳', '3');
INSERT INTO `cmf_district` VALUES ('3364', '394', '0', '秀山', '3');
INSERT INTO `cmf_district` VALUES ('3365', '395', '0', '沙田区', '3');
INSERT INTO `cmf_district` VALUES ('3366', '395', '0', '东区', '3');
INSERT INTO `cmf_district` VALUES ('3367', '395', '0', '观塘区', '3');
INSERT INTO `cmf_district` VALUES ('3368', '395', '0', '黄大仙区', '3');
INSERT INTO `cmf_district` VALUES ('3369', '395', '0', '九龙城区', '3');
INSERT INTO `cmf_district` VALUES ('3370', '395', '0', '屯门区', '3');
INSERT INTO `cmf_district` VALUES ('3371', '395', '0', '葵青区', '3');
INSERT INTO `cmf_district` VALUES ('3372', '395', '0', '元朗区', '3');
INSERT INTO `cmf_district` VALUES ('3373', '395', '0', '深水埗区', '3');
INSERT INTO `cmf_district` VALUES ('3374', '395', '0', '西贡区', '3');
INSERT INTO `cmf_district` VALUES ('3375', '395', '0', '大埔区', '3');
INSERT INTO `cmf_district` VALUES ('3376', '395', '0', '湾仔区', '3');
INSERT INTO `cmf_district` VALUES ('3377', '395', '0', '油尖旺区', '3');
INSERT INTO `cmf_district` VALUES ('3378', '395', '0', '北区', '3');
INSERT INTO `cmf_district` VALUES ('3379', '395', '0', '南区', '3');
INSERT INTO `cmf_district` VALUES ('3380', '395', '0', '荃湾区', '3');
INSERT INTO `cmf_district` VALUES ('3381', '395', '0', '中西区', '3');
INSERT INTO `cmf_district` VALUES ('3382', '395', '0', '离岛区', '3');
INSERT INTO `cmf_district` VALUES ('3383', '396', '0', '澳门', '3');
INSERT INTO `cmf_district` VALUES ('3384', '397', '0', '台北', '3');
INSERT INTO `cmf_district` VALUES ('3385', '397', '0', '高雄', '3');
INSERT INTO `cmf_district` VALUES ('3386', '397', '0', '基隆', '3');
INSERT INTO `cmf_district` VALUES ('3387', '397', '0', '台中', '3');
INSERT INTO `cmf_district` VALUES ('3388', '397', '0', '台南', '3');
INSERT INTO `cmf_district` VALUES ('3389', '397', '0', '新竹', '3');
INSERT INTO `cmf_district` VALUES ('3390', '397', '0', '嘉义', '3');
INSERT INTO `cmf_district` VALUES ('3391', '397', '0', '宜兰县', '3');
INSERT INTO `cmf_district` VALUES ('3392', '397', '0', '桃园县', '3');
INSERT INTO `cmf_district` VALUES ('3393', '397', '0', '苗栗县', '3');
INSERT INTO `cmf_district` VALUES ('3394', '397', '0', '彰化县', '3');
INSERT INTO `cmf_district` VALUES ('3395', '397', '0', '南投县', '3');
INSERT INTO `cmf_district` VALUES ('3396', '397', '0', '云林县', '3');
INSERT INTO `cmf_district` VALUES ('3397', '397', '0', '屏东县', '3');
INSERT INTO `cmf_district` VALUES ('3398', '397', '0', '台东县', '3');
INSERT INTO `cmf_district` VALUES ('3399', '397', '0', '花莲县', '3');
INSERT INTO `cmf_district` VALUES ('3400', '397', '0', '澎湖县', '3');
INSERT INTO `cmf_district` VALUES ('3401', '3', '0', '合肥', '2');
INSERT INTO `cmf_district` VALUES ('3402', '3401', '0', '庐阳区', '3');
INSERT INTO `cmf_district` VALUES ('3403', '3401', '0', '瑶海区', '3');
INSERT INTO `cmf_district` VALUES ('3404', '3401', '0', '蜀山区', '3');
INSERT INTO `cmf_district` VALUES ('3405', '3401', '0', '包河区', '3');
INSERT INTO `cmf_district` VALUES ('3406', '3401', '0', '长丰县', '3');
INSERT INTO `cmf_district` VALUES ('3407', '3401', '0', '肥东县', '3');
INSERT INTO `cmf_district` VALUES ('3408', '3401', '0', '肥西县', '3');

-- ----------------------------
-- Table structure for cmf_funds_apply
-- ----------------------------
DROP TABLE IF EXISTS `cmf_funds_apply`;
CREATE TABLE `cmf_funds_apply` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '申请',
  `type` char(10) NOT NULL DEFAULT 'withdraw' COMMENT '用户操作类型',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户Id',
  `order_sn` varchar(150) NOT NULL DEFAULT '' COMMENT '订单号：type为recharge时',
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '账号：type为withdraw时',
  `username` varchar(25) NOT NULL DEFAULT '' COMMENT '姓名：type为withdraw时',
  `coin` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `payment` varchar(15) NOT NULL DEFAULT '' COMMENT '提现方式：alipay支付宝 wxpay微信',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态： -2取消 -1审核失败 0审核中 1审核通过 10完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='用户资金相关申请表';

-- ----------------------------
-- Records of cmf_funds_apply
-- ----------------------------
INSERT INTO `cmf_funds_apply` VALUES ('1', 'withdraw', '3', '', '31', '33423', '100.00', 'alipay', '1512717758', '', '0');
INSERT INTO `cmf_funds_apply` VALUES ('2', 'withdraw', '3', '', '13987564125', '王静', '120.00', 'alipay', '1512720140', '', '0');
INSERT INTO `cmf_funds_apply` VALUES ('3', 'withdraw', '3', '', '234234', '问问', '100.00', 'wxpay', '1512720472', '', '0');

-- ----------------------------
-- Table structure for cmf_hook
-- ----------------------------
DROP TABLE IF EXISTS `cmf_hook`;
CREATE TABLE `cmf_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '钩子类型(1:系统钩子;2:应用钩子;3:模板钩子)',
  `once` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否只允许一个插件运行(0:多个;1:一个)',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子',
  `app` varchar(15) NOT NULL DEFAULT '' COMMENT '应用名(只有应用钩子才用)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子表';

-- ----------------------------
-- Records of cmf_hook
-- ----------------------------
INSERT INTO `cmf_hook` VALUES ('1', '1', '0', '应用初始化', 'app_init', 'cmf', '应用初始化');
INSERT INTO `cmf_hook` VALUES ('2', '1', '0', '应用开始', 'app_begin', 'cmf', '应用开始');
INSERT INTO `cmf_hook` VALUES ('3', '1', '0', '模块初始化', 'module_init', 'cmf', '模块初始化');
INSERT INTO `cmf_hook` VALUES ('4', '1', '0', '控制器开始', 'action_begin', 'cmf', '控制器开始');
INSERT INTO `cmf_hook` VALUES ('5', '1', '0', '视图输出过滤', 'view_filter', 'cmf', '视图输出过滤');
INSERT INTO `cmf_hook` VALUES ('6', '1', '0', '应用结束', 'app_end', 'cmf', '应用结束');
INSERT INTO `cmf_hook` VALUES ('7', '1', '0', '日志write方法', 'log_write', 'cmf', '日志write方法');
INSERT INTO `cmf_hook` VALUES ('8', '1', '0', '输出结束', 'response_end', 'cmf', '输出结束');
INSERT INTO `cmf_hook` VALUES ('9', '1', '0', '后台控制器初始化', 'admin_init', 'cmf', '后台控制器初始化');
INSERT INTO `cmf_hook` VALUES ('10', '1', '0', '前台控制器初始化', 'home_init', 'cmf', '前台控制器初始化');
INSERT INTO `cmf_hook` VALUES ('11', '1', '1', '发送手机验证码', 'send_mobile_verification_code', 'cmf', '发送手机验证码');
INSERT INTO `cmf_hook` VALUES ('12', '3', '0', '模板 body标签开始', 'body_start', '', '模板 body标签开始');
INSERT INTO `cmf_hook` VALUES ('13', '3', '0', '模板 head标签结束前', 'before_head_end', '', '模板 head标签结束前');
INSERT INTO `cmf_hook` VALUES ('14', '3', '0', '模板底部开始', 'footer_start', '', '模板底部开始');
INSERT INTO `cmf_hook` VALUES ('15', '3', '0', '模板底部开始之前', 'before_footer', '', '模板底部开始之前');
INSERT INTO `cmf_hook` VALUES ('16', '3', '0', '模板底部结束之前', 'before_footer_end', '', '模板底部结束之前');
INSERT INTO `cmf_hook` VALUES ('17', '3', '0', '模板 body 标签结束之前', 'before_body_end', '', '模板 body 标签结束之前');
INSERT INTO `cmf_hook` VALUES ('18', '3', '0', '模板左边栏开始', 'left_sidebar_start', '', '模板左边栏开始');
INSERT INTO `cmf_hook` VALUES ('19', '3', '0', '模板左边栏结束之前', 'before_left_sidebar_end', '', '模板左边栏结束之前');
INSERT INTO `cmf_hook` VALUES ('20', '3', '0', '模板右边栏开始', 'right_sidebar_start', '', '模板右边栏开始');
INSERT INTO `cmf_hook` VALUES ('21', '3', '0', '模板右边栏结束之前', 'before_right_sidebar_end', '', '模板右边栏结束之前');
INSERT INTO `cmf_hook` VALUES ('22', '3', '1', '评论区', 'comment', '', '评论区');
INSERT INTO `cmf_hook` VALUES ('23', '3', '1', '留言区', 'guestbook', '', '留言区');
INSERT INTO `cmf_hook` VALUES ('24', '2', '0', '后台首页仪表盘', 'admin_dashboard', 'admin', '后台首页仪表盘');
INSERT INTO `cmf_hook` VALUES ('25', '4', '0', '后台模板 head标签结束前', 'admin_before_head_end', '', '后台模板 head标签结束前');
INSERT INTO `cmf_hook` VALUES ('26', '4', '0', '后台模板 body 标签结束之前', 'admin_before_body_end', '', '后台模板 body 标签结束之前');
INSERT INTO `cmf_hook` VALUES ('27', '2', '0', '后台登录页面', 'admin_login', 'admin', '后台登录页面');
INSERT INTO `cmf_hook` VALUES ('28', '1', '1', '前台模板切换', 'switch_theme', 'cmf', '前台模板切换');
INSERT INTO `cmf_hook` VALUES ('29', '3', '0', '主要内容之后', 'after_content', '', '主要内容之后');
INSERT INTO `cmf_hook` VALUES ('30', '2', '0', '文章显示之前', 'portal_before_assign_article', 'portal', '文章显示之前');
INSERT INTO `cmf_hook` VALUES ('31', '2', '0', '后台文章保存之后', 'portal_admin_after_save_article', 'portal', '后台文章保存之后');

-- ----------------------------
-- Table structure for cmf_hook_plugin
-- ----------------------------
DROP TABLE IF EXISTS `cmf_hook_plugin`;
CREATE TABLE `cmf_hook_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名',
  `plugin` varchar(30) NOT NULL DEFAULT '' COMMENT '插件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子插件表';

-- ----------------------------
-- Records of cmf_hook_plugin
-- ----------------------------
INSERT INTO `cmf_hook_plugin` VALUES ('2', '10000', '1', 'send_mobile_verification_code', 'MobileCodeDemo');

-- ----------------------------
-- Table structure for cmf_insurance
-- ----------------------------
DROP TABLE IF EXISTS `cmf_insurance`;
CREATE TABLE `cmf_insurance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '保险名称',
  `image` varchar(255) NOT NULL COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '启用时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `content` text COMMENT '总则',
  `information` text COMMENT '投保须知',
  `more` text NOT NULL COMMENT '扩展属性：coverage勾选的公共险种模型',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `desc2` varchar(255) NOT NULL DEFAULT '' COMMENT '次级描述',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `identi_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '认证状态：-1禁止认证 0未认证 1已认证',
  `status` tinyint(2) NOT NULL COMMENT '状态：-1禁用 0隐藏 1显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='保险业务表';

-- ----------------------------
-- Records of cmf_insurance
-- ----------------------------
INSERT INTO `cmf_insurance` VALUES ('1', '2', '0', '太平洋保险', '', '', '1508904236', '1510717757', '1508904120', '0', '&lt;p&gt;发个方法好的&lt;/p&gt;', '&lt;p&gt;正确&lt;/p&gt;', '{\"coverage\":[\"1\",\"4\",\"6\",\"7\",\"8\"],\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/insurance01.png\"}', '', '老品牌，全国通赔', '舒心投保体验', '0', '1', '1', '1', '10000');
INSERT INTO `cmf_insurance` VALUES ('2', '1', '0', '安盛天平', '', '', '1508917303', '1511515413', '1508917200', '0', '&lt;ul style=&quot;list-style-type: none;&quot; class=&quot; list-paddingleft-2&quot;&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;总 则&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第一条 本保险合同由保险条款、投保单、保险单、批单和特别约定组成。凡涉及本保险合同的约定，均应采用书面形式。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第二条 本保险合同中的非营业用汽车是指在中华人民共和国境内（不含港、澳、台地区）行驶的党政机关、企事业单位、社会团体、使领馆等机构从事公务或在生产经营活动中不以直接或间接方式收取运费或租金的自用汽车，包括客车、货车、客货两用车。 第三条 本保险合同为不定值保险合同。保险人按照承保险别承担保险责任，附加险不能单独承保&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;保险责任&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第四条 保险期间内，被保险人或其允许的驾驶人在使用保险车辆过程中，因下列原因造成保险车辆的损失，保险人依照本保险合同的约定负责赔偿：&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（一） 碰撞、倾覆、坠落；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（二） 火灾、爆炸、自燃；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（三） 外界物体坠落、倒塌；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（四） 暴风、龙卷风；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（五） 雷击、雹灾、暴雨、洪水、海啸；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（六） 地陷、冰陷、崖崩、雪崩、泥石流、滑坡；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（七） 载运保险车辆的渡船遭受自然灾害（只限于驾驶人随船的情形）。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第五条 发生保险事故时，被保险人为防止或者减少保险车辆的损失所支付的必要的、合理的施救费用，由保险人承担，最高不超过保险金额的数额。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;责任免除&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第五条 保险期间内，被保险人或其允许的驾驶人在使用保险车辆过程中，因下列原因造成保险车辆的损失，保险人依照本保险合同的约定负责赔偿：&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（一） 碰撞、倾覆、坠落；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（二） 火灾、爆炸、自燃；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（三） 外界物体坠落、倒塌；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（四） 暴风、龙卷风；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（五） 雷击、雹灾、暴雨、洪水、海啸；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（六） 地陷、冰陷、崖崩、雪崩、泥石流、滑坡；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（七） 载运保险车辆的渡船遭受自然灾害（只限于驾驶人随船的情形）。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第五条 发生保险事故时，被保险人为防止或者减少保险车辆的损失所支付的必要的、合理的施救费用，由保险人承担，最高不超过保险金额的数额。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;总 则&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第五条 保险期间内，被保险人或其允许的驾驶人在使用保险车辆过程中，因下列原因造成保险车辆的损失，保险人依照本保险合同的约定负责赔偿：&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（一） 碰撞、倾覆、坠落；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（二） 火灾、爆炸、自燃；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（三） 外界物体坠落、倒塌；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（四） 暴风、龙卷风；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（五） 雷击、雹灾、暴雨、洪水、海啸；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（六） 地陷、冰陷、崖崩、雪崩、泥石流、滑坡；&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;（七） 载运保险车辆的渡船遭受自然灾害（只限于驾驶人随船的情形）。&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;第五条 发生保险事故时，被保险人为防止或者减少保险车辆的损失所支付的必要的、合理的施救费用，由保险人承担，最高不超过保险金额的数额。&lt;/p&gt;&lt;/li&gt;\n&lt;/ul&gt;', '&lt;p&gt;456&lt;/p&gt;', '{\"coverage\":[\"1\",\"2\",\"3\",\"4\"],\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/insurance02.png\"}', '', '好保险省更多', '理赔省心', '0', '1', '1', '1', '10000');
INSERT INTO `cmf_insurance` VALUES ('3', '1', '0', '阳光保险', '', '', '1509085896', '1510717816', '1509085860', '0', '', '', '{\"coverage\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\"],\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/insurance03.png\"}', '', '一对一专项顾问', '服务新升级', '0', '1', '1', '1', '10000');
INSERT INTO `cmf_insurance` VALUES ('4', '0', '0', '中华保险', '', '', '1510039164', '1510717797', '1510039020', '0', '', '', '{\"coverage\":[\"1\",\"2\"],\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/insurance04.png\"}', '', '快易免服务', '24小时极速闪赔', '0', '1', '1', '1', '10000');

-- ----------------------------
-- Table structure for cmf_insurance_compensation
-- ----------------------------
DROP TABLE IF EXISTS `cmf_insurance_compensation`;
CREATE TABLE `cmf_insurance_compensation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_insurance_compensation
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_insurance_coverage
-- ----------------------------
DROP TABLE IF EXISTS `cmf_insurance_coverage`;
CREATE TABLE `cmf_insurance_coverage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `insurance_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的保险业务ID。0表示公用模型',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `type` tinyint(1) unsigned NOT NULL COMMENT '保险类型：1强险 2商业险',
  `name` varchar(255) NOT NULL COMMENT '险种名称',
  `price` float unsigned NOT NULL COMMENT '参考价',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '启用时间',
  `delete_time` int(10) unsigned NOT NULL COMMENT '删除时间',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `description` tinytext COMMENT '描述',
  `content` text COMMENT '险种内容',
  `more` text COMMENT '扩展属性',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1禁用 0未启用 1启用',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_insurance_coverage
-- ----------------------------
INSERT INTO `cmf_insurance_coverage` VALUES ('1', '0', '0', '1', '车辆损失险', '0', '1510729745', '1508923020', '0', '', '提供各大车险公司服务\r\n为您的安全保驾护航', '&lt;ul class=&quot; list-paddingleft-2&quot;&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;保险责任：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;道路交通事故中造成受害人(不包括本车人员和被保险人)的人身伤亡、财产损失&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;赔偿项目：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;交通事故中的死亡伤残赔偿、医疗费用赔偿、财产损失赔偿等。&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;赔偿额度：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;责任限额12万。交通事故中有责任的赔偿限额：死亡伤残赔偿限额：110000元 ；医疗费用赔偿限额：10000元；财产损失赔偿限额：2000元。机动车在道路交通事故中有无责任的赔偿限额：死亡伤残赔偿限额：11000元；医疗费用赔偿限额：1000元；财产损失赔偿限额：100元。&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;/ul&gt;', '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service1.jpg\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('2', '0', '0', '1', '第三责任险', '111', '1510729706', '1508924100', '0', '', '提供各大车险公司服务\r\n为您的安全保驾护航', '&lt;ul class=&quot; list-paddingleft-2&quot;&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;保险责任：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;道路交通事故中造成受害人(不包括本车人员和被保险人)的人身伤亡、财产损失&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;赔偿项目：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;交通事故中的死亡伤残赔偿、医疗费用赔偿、财产损失赔偿等。&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li style=&quot;&quot;&gt;&lt;p&gt;&lt;span class=&quot;insurance_icon_tit&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: 100px; vertical-align: top;&quot;&gt;赔偿额度：&lt;/span&gt;&lt;span class=&quot;insurance_icon_txt&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; display: inline-block; width: calc(100% - 100px);&quot;&gt;责任限额12万。交通事故中有责任的赔偿限额：死亡伤残赔偿限额：110000元 ；医疗费用赔偿限额：10000元；财产损失赔偿限额：2000元。机动车在道路交通事故中有无责任的赔偿限额：死亡伤残赔偿限额：11000元；医疗费用赔偿限额：1000元；财产损失赔偿限额：100元。&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;/ul&gt;', '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service3.jpg\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('3', '0', '0', '2', '全车盗抢险', '0', '1510729797', '1508979900', '0', '', '提供各大车险公司服务\r\n为您的安全保驾护航', '&lt;p&gt;盗抢规则：&lt;/p&gt;', '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service2.jpg\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('4', '0', '0', '2', '车上座位责任险', '0', '1508980030', '1508980013', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('5', '0', '0', '2', '玻璃单独破碎险', '0', '1508980049', '1508980033', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('6', '0', '0', '2', '自燃险', '0', '1508980059', '1508980053', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('7', '0', '0', '2', '划痕险', '0', '1508980171', '1508980063', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('8', '0', '0', '2', '责任险率', '0', '1508980194', '1508980174', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');
INSERT INTO `cmf_insurance_coverage` VALUES ('9', '0', '0', '2', '不计免额险', '0', '1508981415', '1508980140', '0', '', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '10000');

-- ----------------------------
-- Table structure for cmf_insurance_order
-- ----------------------------
DROP TABLE IF EXISTS `cmf_insurance_order`;
CREATE TABLE `cmf_insurance_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `insurance_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '保险业务ID',
  `coverIds` varchar(255) NOT NULL DEFAULT '' COMMENT '自选险种',
  `car_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '车辆ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '保单编号',
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '保险业务名称',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '投保金额',
  `pay_id` varchar(30) NOT NULL DEFAULT '' COMMENT '支付标识：alipay支付宝 wxjs微信js  wxnative微信扫码',
  `company_name` varchar(150) NOT NULL DEFAULT '' COMMENT '投保公司名',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间(生效时间)',
  `appoint_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约时间',
  `finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `dead_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '失效时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `more` text COMMENT '扩展属性：审核资料',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '投保类型：1线上 2线下',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态：-11过期失效 -3管理员取消 -2卖家取消 -1取消/关闭 0待审核未支付 1已审核 5已确认合同 6已支付 10完成',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`),
  KEY `idx1` (`user_id`),
  KEY `idx2` (`car_id`),
  KEY `idx3` (`insurance_id`),
  KEY `idx4` (`order_sn`),
  KEY `idx5` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='保单表';

-- ----------------------------
-- Records of cmf_insurance_order
-- ----------------------------
INSERT INTO `cmf_insurance_order` VALUES ('1', '2', '[\"1\",\"2\"]', '6', '3', '0', 'INSUR-2017120253101494', '', '0.00', '', '', '1512181733', '0', '0', '0', '0', '0', null, '', '', '1', '0', '10000');

-- ----------------------------
-- Table structure for cmf_link
-- ----------------------------
DROP TABLE IF EXISTS `cmf_link`;
CREATE TABLE `cmf_link` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:不显示',
  `rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接地址',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '友情链接图标',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `rel` varchar(50) NOT NULL DEFAULT '' COMMENT '链接与网站的关系',
  PRIMARY KEY (`id`),
  KEY `link_visible` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='友情链接表';

-- ----------------------------
-- Records of cmf_link
-- ----------------------------
INSERT INTO `cmf_link` VALUES ('1', '0', '1', '1', '8', '华创再在线官网', 'http://www.wincomtech.cn', '华创在线', '', '_blank', '');

-- ----------------------------
-- Table structure for cmf_nav
-- ----------------------------
DROP TABLE IF EXISTS `cmf_nav`;
CREATE TABLE `cmf_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_main` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否为主导航;1:是;0:不是',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航位置名称',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='前台导航位置表';

-- ----------------------------
-- Records of cmf_nav
-- ----------------------------
INSERT INTO `cmf_nav` VALUES ('1', '1', '主导航', '主导航');
INSERT INTO `cmf_nav` VALUES ('2', '0', '底部导航', '');

-- ----------------------------
-- Table structure for cmf_nav_menu
-- ----------------------------
DROP TABLE IF EXISTS `cmf_nav_menu`;
CREATE TABLE `cmf_nav_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nav_id` int(11) NOT NULL COMMENT '导航 id',
  `parent_id` int(11) NOT NULL COMMENT '父 id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COMMENT='前台导航菜单表';

-- ----------------------------
-- Records of cmf_nav_menu
-- ----------------------------
INSERT INTO `cmf_nav_menu` VALUES ('1', '1', '0', '1', '10', '网站首页', '', 'home', 'ion-android-home', '0-1');
INSERT INTO `cmf_nav_menu` VALUES ('17', '1', '0', '1', '20', '关于我们', '', 'about/19.html', 'ion-compose', '');
INSERT INTO `cmf_nav_menu` VALUES ('18', '1', '0', '1', '30', '车险服务', '', 'insurance.html', 'ion-android-apps', '');
INSERT INTO `cmf_nav_menu` VALUES ('19', '1', '0', '1', '40', '车商城', '', 'trade.html', 'ion-android-home', '');
INSERT INTO `cmf_nav_menu` VALUES ('20', '1', '0', '1', '50', '车辆业务', '', 'service.html', 'ion-person', '');
INSERT INTO `cmf_nav_menu` VALUES ('21', '1', '0', '1', '60', '活动推荐', '', '{\"action\":\"portal\\/List\\/index\",\"param\":{\"id\":2}}', 'ion-search', '');
INSERT INTO `cmf_nav_menu` VALUES ('22', '1', '0', '1', '70', '新闻资讯', '', '{\"action\":\"portal\\/List\\/index\",\"param\":{\"id\":1}}', 'ion-star', '');
INSERT INTO `cmf_nav_menu` VALUES ('23', '1', '19', '1', '10000', '新车', '', '{\"action\":\"trade\\/Index\\/index\",\"param\":{\"platform\":1}}', 'ion-android-arrow-dr', '');
INSERT INTO `cmf_nav_menu` VALUES ('24', '1', '19', '1', '10000', '二手车', '', '{\"action\":\"trade\\/Index\\/index\",\"param\":{\"platform\":2}}', 'ion-android-arrow-dr', '');
INSERT INTO `cmf_nav_menu` VALUES ('25', '1', '22', '1', '10000', '热门新闻', '', '{\"action\":\"portal\\/List\\/index\",\"param\":{\"id\":5}}', 'ion-android-arrow-dr', '');
INSERT INTO `cmf_nav_menu` VALUES ('26', '1', '19', '1', '10000', '服务商城', '', '{\"action\":\"trade\\/Index\\/index\",\"param\":{\"platform\":3}}', '', '');

-- ----------------------------
-- Table structure for cmf_news
-- ----------------------------
DROP TABLE IF EXISTS `cmf_news`;
CREATE TABLE `cmf_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `deal_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息处理人',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '消息标题',
  `object` varchar(100) NOT NULL DEFAULT '' COMMENT '消息对象的id,格式:不带前缀的表名+id;如posts:1表示xx_posts表里id为1的记录',
  `action` varchar(100) NOT NULL DEFAULT '' COMMENT '来源所在名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;',
  `app` varchar(50) NOT NULL DEFAULT '' COMMENT '消息的来源所在应用名或插件名等',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `content` text COMMENT '详情',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '用户的ip',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0未读 1已读 2已处理',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_news
-- ----------------------------
INSERT INTO `cmf_news` VALUES ('1', '3', '1', '预约保险', 'insurance_order:1', 'insurance/post/step2post', 'insurance', '', '客户ID：3，保单ID：1', '1512181733', '127.0.0.1', '0');
INSERT INTO `cmf_news` VALUES ('2', '3', '0', '预约车辆服务：菜鸟验车', 'service:1', 'service/post/appointpost', 'service', '', '客户ID：3，公司ID：1', '1512541470', '127.0.0.1', '0');

-- ----------------------------
-- Table structure for cmf_option
-- ----------------------------
DROP TABLE IF EXISTS `cmf_option`;
CREATE TABLE `cmf_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `autoload` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否自动加载;1:自动加载;0:不自动加载',
  `option_name` varchar(64) NOT NULL DEFAULT '' COMMENT '配置名',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置值',
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='全站配置表';

-- ----------------------------
-- Records of cmf_option
-- ----------------------------
INSERT INTO `cmf_option` VALUES ('7', '1', 'site_info', '{\"site_name\":\"\\u5927\\u901a\\u8f66\\u670d\\u6709\\u9650\\u8d23\\u4efb\\u516c\\u53f8\",\"site_seo_title\":\"\\u5927\\u901a\\u8f66\\u670d\",\"site_seo_keywords\":\"\\u4e8c\\u624b\\u8f66\",\"site_seo_description\":\"\\u4e8c\\u624b\\u8f66\\u4ea4\\u6613\",\"site_icp\":\"\\u4eacICP\\u590716017208\\u53f7-1\",\"site_admin_email\":\"admin@admin.com\",\"site_analytics\":\"\",\"site_copyright\":\"\\u5927\\u901a\\u8f66\\u670dxxxx\\u670d\\u52a1\\u6709\\u9650\\u516c\\u53f8\\u7248\\u6743\\u6240\\u6709\",\"site_tel\":\"186-9666-4008\",\"site_addr\":\"xx\\u5e02xx\\u533a\\uff0cxxx\\u533a\\uff0cxxx\\u533a\",\"site_logo\":\"portal\\/20171013\\/1f661e0d9d9f0c97b17a50e6e06580c0.png\"}');
INSERT INTO `cmf_option` VALUES ('8', '1', 'smtp_setting', '{\"from_name\":\"admin\",\"from\":\"wowlothar@foxmail.com\",\"host\":\"smtp.qq.com\",\"smtp_secure\":\"\",\"port\":\"25\",\"username\":\"wowlothar@foxmail.com\",\"password\":\"opqzaolxpbbjbdcf\"}');
INSERT INTO `cmf_option` VALUES ('9', '1', 'admin_dashboard_widgets', '[{\"name\":\"CmfHub\",\"is_system\":1},{\"name\":\"MainContributors\",\"is_system\":1},{\"name\":\"Contributors\",\"is_system\":1},{\"name\":\"Custom1\",\"is_system\":1},{\"name\":\"SystemInfo\",\"is_system\":0},{\"name\":\"Custom3\",\"is_system\":1},{\"name\":\"Custom4\",\"is_system\":1},{\"name\":\"Custom5\",\"is_system\":1},{\"name\":\"Custom2\",\"is_system\":1}]');
INSERT INTO `cmf_option` VALUES ('10', '1', 'cmf_settings', '{\"open_registration\":\"1\",\"banned_usernames\":\"\"}');
INSERT INTO `cmf_option` VALUES ('11', '1', 'cdn_settings', '{\"cdn_static_root\":\"\"}');
INSERT INTO `cmf_option` VALUES ('12', '1', 'admin_settings', '{\"admin_password\":\"\",\"admin_style\":\"flatadmin\"}');

-- ----------------------------
-- Table structure for cmf_plugin
-- ----------------------------
DROP TABLE IF EXISTS `cmf_plugin`;
CREATE TABLE `cmf_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '插件类型;1:网站;8:微信',
  `has_admin` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理,0:没有;1:有',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:开启;0:禁用',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '插件标识名,英文字母(惟一)',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `hooks` varchar(255) NOT NULL DEFAULT '' COMMENT '实现的钩子;以“,”分隔',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '插件版本号',
  `description` varchar(255) NOT NULL COMMENT '插件描述',
  `config` text COMMENT '插件配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='插件表';

-- ----------------------------
-- Records of cmf_plugin
-- ----------------------------
INSERT INTO `cmf_plugin` VALUES ('2', '1', '0', '1', '0', 'MobileCodeDemo', '手机验证码演示插件', '', '', 'ThinkCMF', '', '1.0', '手机验证码演示插件', '{\"account_sid\":\"\",\"auth_token\":\"\",\"app_id\":\"\",\"template_id\":\"\",\"expire_minute\":\"30\"}');

-- ----------------------------
-- Table structure for cmf_portal_category
-- ----------------------------
DROP TABLE IF EXISTS `cmf_portal_category`;
CREATE TABLE `cmf_portal_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

-- ----------------------------
-- Records of cmf_portal_category
-- ----------------------------
INSERT INTO `cmf_portal_category` VALUES ('1', '0', '0', '1', '0', '10000', '新闻资讯', '新闻', '0-1', '大通车服新闻', '大通车服,新闻', '大通车服新闻资讯', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('2', '0', '0', '1', '0', '10000', '活动推荐', '活动', '0-2', '大通车服活动', '大通车服，活动', '大通车服活动推荐', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('3', '0', '0', '1', '0', '10000', '车辆服务', '', '0-3', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('4', '3', '0', '1', '0', '10000', '买车流程', '', '0-3-4', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('5', '1', '0', '1', '0', '10000', '热门新闻', '', '0-1-5', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('6', '0', '0', '1', '0', '10000', '关于我们', '', '0-6', '', '', '', 'list', 'about', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('7', '1', '0', '1', '0', '10000', '用车技巧', '', '0-1-7', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('8', '3', '0', '1', '0', '10000', '理赔指引', '有了理赔指引，出险理赔不慌乱', '0-3-8', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');
INSERT INTO `cmf_portal_category` VALUES ('9', '3', '0', '1', '0', '10000', '新手帮助', '有问题找车服', '0-3-9', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');

-- ----------------------------
-- Table structure for cmf_portal_category_post
-- ----------------------------
DROP TABLE IF EXISTS `cmf_portal_category_post`;
CREATE TABLE `cmf_portal_category_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  PRIMARY KEY (`id`),
  KEY `term_taxonomy_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

-- ----------------------------
-- Records of cmf_portal_category_post
-- ----------------------------
INSERT INTO `cmf_portal_category_post` VALUES ('1', '1', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('4', '4', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('5', '5', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('6', '6', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('7', '7', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('8', '8', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('9', '9', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('10', '10', '3', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('11', '11', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('13', '13', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('14', '14', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('15', '15', '4', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('16', '16', '4', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('17', '17', '4', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('18', '18', '4', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('19', '19', '6', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('20', '20', '6', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('21', '21', '6', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('22', '22', '6', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('23', '23', '6', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('24', '12', '7', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('25', '14', '5', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('26', '12', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('27', '13', '5', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('28', '11', '5', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('29', '3', '2', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('30', '2', '1', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('31', '2', '5', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('32', '24', '8', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('33', '25', '8', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('34', '26', '8', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('35', '27', '9', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('36', '28', '9', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('37', '29', '9', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('38', '30', '9', '10000', '1');
INSERT INTO `cmf_portal_category_post` VALUES ('39', '31', '9', '10000', '1');

-- ----------------------------
-- Table structure for cmf_portal_post
-- ----------------------------
DROP TABLE IF EXISTS `cmf_portal_post`;
CREATE TABLE `cmf_portal_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `post_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型,1:文章;2:页面',
  `post_format` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容格式;1:html;2:md',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '发表者用户id',
  `post_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:已发布;0:未发布;',
  `comment_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '评论状态;1:允许;0:不允许',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶;1:置顶;0:不置顶',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_hits` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '查看数',
  `post_like` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `post_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'post标题',
  `post_keywords` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo keywords',
  `post_excerpt` varchar(500) NOT NULL DEFAULT '' COMMENT 'post摘要',
  `post_source` varchar(150) NOT NULL DEFAULT '' COMMENT '转载文章的来源',
  `post_content` text COMMENT '文章内容',
  `post_content_filtered` text COMMENT '处理过的文章内容',
  `more` text COMMENT '扩展属性,如缩略图;格式为json',
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_type`,`post_status`,`create_time`,`id`),
  KEY `post_parent` (`parent_id`),
  KEY `post_author` (`user_id`),
  KEY `post_date` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='portal应用 文章表';

-- ----------------------------
-- Records of cmf_portal_post
-- ----------------------------
INSERT INTO `cmf_portal_post` VALUES ('1', '0', '2', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1507875360', '1510558282', '1507875240', '0', '单页演示', '', '', '', '\n&lt;p style=&quot;text-indent:2em;&quot;&gt;单页展示&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', '', '{\"thumbnail\":\"\",\"template\":\"page\"}');
INSERT INTO `cmf_portal_post` VALUES ('2', '0', '1', '1', '1', '1', '1', '0', '0', '11', '0', '0', '1507876048', '1510645725', '1507875960', '0', '上线通知', '', '上线摘要', '', '&lt;p&gt;上线内容：本站将于2017年上线。&lt;/p&gt;', '', '{\"thumbnail\":\"\",\"template\":\"\",\"photos\":[{\"url\":\"portal\\/20171013\\/1f661e0d9d9f0c97b17a50e6e06580c0.png\",\"name\":\"大通车服logo.png\"}]}');
INSERT INTO `cmf_portal_post` VALUES ('3', '0', '1', '1', '1', '1', '1', '0', '0', '14', '0', '0', '1507876137', '1510645674', '1507876080', '0', '活动1', '', '', '', '&lt;p&gt;最新活动极简出&lt;/p&gt;', '', '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('4', '0', '1', '1', '1', '1', '1', '0', '0', '1', '0', '0', '1510050010', '1510050289', '1510049940', '0', '尾气检测', '', '交检测费，等候上线。检测前会有工作人员进行初检，由检测员开车上线，拿...', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/car_service01.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('5', '0', '1', '1', '1', '1', '1', '0', '0', '1', '0', '0', '1510050404', '1510050404', '1510050372', '0', '查违章', '', '查询窗口领取并填写“机动车定期检验登记表”，可凭行驶证领取。填好表中事...', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/c4e37762e79866a2f10d3c5926bbd188924ddbd3_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('6', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510050437', '1510050437', '1510050412', '0', '交押金', '', '押金窗口缴押金，拿好押金条，领取并填写外观检验单。', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/c4e37762e79866a2f10d3c5926bbd188924ddbd3_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('7', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510050472', '1510050472', '1510050445', '0', '外观检测', '', '持外观检验单到外观工位，先查相关手续，核验第三者保险（强制性保险）是否', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/8a37e5af175db41e06004dc098e9c173aee70116_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('8', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510050503', '1510050503', '1510050480', '0', '上线检测', '', '外观检验没问题，排队等候上线检测。检测线负责刹车、大灯（远光）、底盘', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/61f4d9a7eb72c52d84b7d86abe75a85b96b52da8_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('9', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510050534', '1510050534', '1510050510', '0', '总监审核', '', '准备一张身份证复印件，到大厅总检处签字盖章。', '', null, null, '{\"thumbnail\":\"thumbnail\\\\&quot;:\\\\&quot;\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/b74aaf555eb970c3a1fdd6e7b2b5dd2a7a971286_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('10', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510050567', '1510050567', '1510050545', '0', '交费，领标', '', '各窗口交相关费用，退回押金，交工本费领“机动车检验合格标志”，标后', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/156c2157ea31033cd8d2ae8431be8497387e5db0_m.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('11', '0', '1', '1', '1', '1', '1', '0', '0', '16', '0', '0', '1510108023', '1510645645', '1510107840', '0', '三年血泪史分享 二手车寄售骗局揭秘编辑', '', '', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/news_img.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('12', '0', '1', '1', '1', '1', '1', '0', '0', '34', '0', '0', '1510108075', '1510645598', '1510108020', '0', '汽车的老祖宗德国人是如何玩转二手车', '', '11月23日至24日，以“中国与欧洲相遇”为主题的汉堡峰会将要召开，我将受邀前往德国参加此次会议。虽然此次峰会是宏观金融层面的会议，但是作为一名“二手车人”，我最关心的还是还是德国二手车是如何发展的，看看有没有可以借鉴的地方。二手车销量远高于新车。最开始，咱们先看看德国的二手车销量。在这里先跟大家透露一点，判断一个国家二手车行业..', '', '\n&lt;p style=\'padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; line-height: 1.6; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 2em;\'&gt;11月23日至24日，以“中国与欧洲相遇”为主题的汉堡峰会将要召开，我将受邀前往德国参加此次会议。虽然此次峰会是宏观金融层面的会议，但是作为一名“二手车人”，我最关心的还是还是德国二手车是如何发展的，看看有没有可以借鉴的地方。&lt;/p&gt;\n&lt;h6 style=\'padding: 0px; margin: 30px 0px; color: rgb(51, 51, 51); list-style: none; font-size: 18px; font-weight: normal; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255);\'&gt;二手车销量远高于新车&lt;/h6&gt;\n&lt;p style=\'padding: 0px; margin-top: 15px; margin-bottom: 15px; color: rgb(102, 102, 102); list-style: none; line-height: 1.6; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 2em;\'&gt;最开始，咱们先看看德国的二手车销量。在这里先跟大家透露一点，判断一个国家二手车行业发展成熟与否的重要标准就是该国二手车销量与新车销量的对比，而一般发达国家二手车的销量都远高于新车。&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;/portal/article/index/id/12/cid/1/image/hot_news.jpg&quot; alt=&quot;&quot; style=\'padding: 0px; margin: 20px auto; color: rgb(51, 51, 51); list-style: none; font-size: 24px; border: none; outline: none; transform: scale(1) translateZ(0px); max-width: 100%; display: block; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255);\'&gt;&lt;/p&gt;\n&lt;p style=\'padding: 0px; margin-top: 15px; margin-bottom: 15px; color: rgb(102, 102, 102); list-style: none; line-height: 1.6; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 2em;\'&gt;根据相关数据统计，德国目前人口总数约在8000万左右，但汽车保有量却达到了4300万辆，平均每1.9个人就拥有一辆汽车。而最近十年以来德国新车的销量逐年下滑，平均每年不足300万辆。而二手车的销量却呈相反态势，2015年时销量达到了730万辆，二手车的销量是新车的2.4倍以上。美国和日本的这一比例在2.5倍左右，英国的更高达到了3.5倍。&lt;/p&gt;\n&lt;p style=\'padding: 0px; margin-top: 15px; margin-bottom: 15px; color: rgb(102, 102, 102); list-style: none; line-height: 1.6; font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 2em;\'&gt;而我国2015年统计的广义乘用车销量达到了2058万辆，二手车销量只有941万辆。虽然二手车销量正在逐年上涨，但还是远远不及新车的销量。&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/news_img.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('13', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510108957', '1510645617', '1510108800', '0', '汽车新闻1', '', '', '', null, null, '{\"thumbnail\":\"http:\\/\\/tx.car\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/news_img.jpg\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('14', '0', '1', '1', '1', '1', '1', '0', '0', '1', '0', '0', '1510112081', '1510645531', '1510111800', '0', '新闻资讯花花', '', '', '', null, null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('15', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510112771', '1510112771', '1510112401', '0', '预约交谈', '', '及时交谈，预约时间确定', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/icon_07_01.png\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('16', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510112820', '1510381166', '1510112760', '0', '预约看车', '', '专人带看\r\n安排售车顾问陪同您看车', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/icon_08.png\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('17', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510113114', '1510113114', '1510113010', '0', '签订协议', '', '安排顾问指导您完成协议合同签订', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/icon_09.png\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('18', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510113167', '1510113167', '1510113123', '0', '售后服务', '', 'GV预估个人', '', null, null, '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/icon_10.png\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('19', '0', '1', '1', '1', '1', '1', '0', '0', '35', '0', '0', '1510558406', '1510562058', '1510558260', '0', '公司介绍', '', '', '', '\n&lt;p style=&quot;text-indent:2em;&quot;&gt;大通车服有限公司是一家提供各种车险服务，二手车买卖，检车预约，车辆服务的的公司，致力于为广大车友提供最便捷，最安全，最省心的服务。&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;/static/js/ueditor/themes/default/images/spacer.gif&quot; word_img=&quot;file:///E:/WXS/%E9%A1%B9%E7%9B%AE/%E4%BA%8C%E6%89%8B%E8%BD%A6%E4%BA%A4%E6%98%93/%E5%89%8D%E7%AB%AF%E4%BB%A3%E7%A0%81/second-hand_car1113/image/about.jpg&quot; style=&quot;background:url(http://tx.car/static/js/ueditor/lang/zh-cn/images/localimage.png) no-repeat center center;border:1px solid #ddd&quot;&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:2em;&quot;&gt;华创在线服务领域涵盖网站建设，企业定制化系统（酒店管理系统，医疗管理系统，房产管理系统，金融管理系统，教育管理系统等），APP开发，微信公众号二次开发，商城网站开发，电子商务定制，百度推广服务等。\r\n \r\n华创在线创始团队多数来自百度，腾讯，阿里巴巴，Facebook等知名互联网公司，具备十年以上的互联网行业经验。公司60%以上为技术研发人员，均毕业于清华大学，浙江大学，中国科学技术大学等知名高校，公司技术实力雄厚。&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent: 2em;&quot;&gt;至臻品质，至真服务，华创在线与您携手共赢，共创未来！&lt;/p&gt;\n', null, '{\"thumbnail\":\"\",\"template\":\"about\"}');
INSERT INTO `cmf_portal_post` VALUES ('20', '0', '1', '1', '1', '1', '1', '0', '0', '6', '0', '0', '1510558939', '1510562398', '1510558860', '0', '服务理念', '', '', '', '&lt;p&gt;服务理念内容：&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"about\"}');
INSERT INTO `cmf_portal_post` VALUES ('21', '0', '1', '1', '1', '1', '1', '0', '0', '2', '0', '0', '1510559032', '1510562441', '1510558980', '0', '保险服务', '', '', '', '&lt;p&gt;保险服务内容&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"about\"}');
INSERT INTO `cmf_portal_post` VALUES ('22', '0', '1', '1', '1', '1', '1', '0', '0', '7', '0', '0', '1510559763', '1510562424', '1510559700', '0', '交易流程', '', '', '', '&lt;p&gt;交易流程内容&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"about\"}');
INSERT INTO `cmf_portal_post` VALUES ('23', '0', '1', '1', '1', '1', '1', '0', '0', '4', '0', '0', '1510559782', '1510562378', '1510559760', '0', '售后服务', '', '', '', '&lt;p&gt;售后服务内容&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"about\"}');
INSERT INTO `cmf_portal_post` VALUES ('24', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510714736', '1510714736', '1510714640', '0', '保护现场', '', '', '', '\n&lt;h6 style=&quot;padding: 0px; margin: 0px 0px 30px; color: rgb(208, 0, 0); list-style: none; font-size: 24px; font-weight: normal;&quot;&gt;领取赔款&lt;/h6&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔资料审核后，案件结案。保险公司将支付赔款，完成理赔。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔时效：人保一小时通知赔付，平安赔款3天到账，大地当天【赔付，安盛1个工作日赔付。限未发生人伤、物损，且车辆损失1万元以下（含），单证齐全。&lt;/p&gt;\n&lt;p&gt;&lt;span style=\'color: rgb(51, 51, 51); font-family: å¾®è½¯é›…é»‘, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 24px; background-color: rgb(255, 255, 255);\'&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;/themes/datong_car/public/assets/images/example/money.jpg&quot; alt=&quot;&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; border: none; outline: none; transform: scale(1) translateZ(0px); max-width: 100%; vertical-align: middle;&quot;&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('25', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510714792', '1510714792', '1510714765', '0', '报警', '', '', '', '\n&lt;h6 style=&quot;padding: 0px; margin: 0px 0px 30px; color: rgb(208, 0, 0); list-style: none; font-size: 24px; font-weight: normal;&quot;&gt;报警&lt;/h6&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔资料审核后，案件结案。保险公司将支付赔款，完成理赔。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔时效：人保一小时通知赔付，平安赔款3天到账，大地当天【赔付，安盛1个工作日赔付。限未发生人伤、物损，且车辆损失1万元以下（含），单证齐全。&lt;/p&gt;\n&lt;p&gt;&lt;span style=\'color: rgb(51, 51, 51); font-family: å¾®è½¯é›…é»‘, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 24px; background-color: rgb(255, 255, 255);\'&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;/themes/datong_car/public/assets/images/example/money.jpg&quot; alt=&quot;&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; border: none; outline: none; transform: scale(1) translateZ(0px); max-width: 100%; vertical-align: middle;&quot;&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('26', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510714835', '1510726461', '1510714800', '0', '提供理赔资料', '', '', '', '\n&lt;h6 style=&quot;padding: 0px; margin: 0px 0px 30px; color: rgb(208, 0, 0); list-style: none; font-size: 24px; font-weight: normal;&quot;&gt;提供理赔资料&lt;/h6&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔资料审核后，案件结案。保险公司将支付赔款，完成理赔。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px; margin-top: 0px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 18px; line-height: 1.7;&quot;&gt;理赔时效：人保一小时通知赔付，平安赔款3天到账，大地当天【赔付，安盛1个工作日赔付。限未发生人伤、物损，且车辆损失1万元以下（含），单证齐全。&lt;/p&gt;\n&lt;p&gt;&lt;span style=\'color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 24px; background-color: rgb(255, 255, 255);\'&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;/themes/datong_car/public/assets/images/example/money.jpg&quot; alt=&quot;&quot; style=&quot;padding: 0px; margin: 0px; list-style: none; font-size: inherit; border: none; outline: none; transform: scale(1) translateZ(0px); max-width: 100%; vertical-align: middle;&quot;&gt;&lt;/p&gt;\n', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('27', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510823954', '1510823954', '1510823927', '0', ' 逾期年检如何处罚？', '', '对于未参加年审的车型，不允许上路行驶，要是上路被查的话，可处记3分、罚款200元的处罚。而未按时参加年审的车，要是发生交通事故的，都是要负事故的主要或全部责任，而且造成的损失，保险公司不予理赔', '', '&lt;p&gt;&lt;span style=\'color: rgb(102, 102, 102); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 14px; background-color: rgb(242, 242, 242);\'&gt;对于未参加年审的车型，不允许上路行驶，要是上路被查的话，可处记3分、罚款200元的处罚。而未按时参加年审的车，要是发生交通事故的，都是要负事故的主要或全部责任，而且造成的损失，保险公司不予理赔&lt;/span&gt;&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('28', '0', '1', '1', '1', '1', '1', '0', '0', '1', '0', '0', '1510823982', '1510823982', '1510823964', '0', ' 哪些情况不适用免检呢？', '', '首先，必须是非营运车辆，且核载人数为6人以下，车辆注册登记的时间为2010年9月1日后。当然了，包含的车型有微、小、中、型轿车；微型、小型普通客车；小型专用客车；微型和小型越野客车。', '', '&lt;p&gt;&lt;span style=\'color: rgb(102, 102, 102); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 14px; background-color: rgb(242, 242, 242);\'&gt;首先，必须是非营运车辆，且核载人数为6人以下，车辆注册登记的时间为2010年9月1日后。当然了，包含的车型有微、小、中、型轿车；微型、小型普通客车；小型专用客车；微型和小型越野客车。&lt;/span&gt;&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('29', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510824015', '1510824015', '1510823992', '0', ' 可免检的车型', '', '符合上诉那些情况，都是符合免检的，不过，当这些情况下，则不在适用免检了：1)车辆出厂超过4年且未办理上牌手续；2)车辆曾发生过重大事故或发生致人死亡的事故；3)有交通违章、交通事故为处理完毕的。', '', '&lt;p&gt;&lt;span style=\'color: rgb(102, 102, 102); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 14px; background-color: rgb(242, 242, 242);\'&gt;符合上诉那些情况，都是符合免检的，不过，当这些情况下，则不在适用免检了：1)车辆出厂超过4年且未办理上牌手续；2)车辆曾发生过重大事故或发生致人死亡的事故；3)有交通违章、交通事故为处理完毕的。&lt;/span&gt;&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('30', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510824041', '1510824041', '1510824025', '0', ' 年检年限规定', '', '6年免检标志是从2014年9月开始实行的，规定在2012年的9月1日(含9月1日)后注册登记的新车，有2年免检机会；规定在2010年的9月1日(含9月1日)后注册登记的新车只有1次免检机会；而对于2010年的9月1日前注册登记的新车，是没有免检机会的。', '', '&lt;p&gt;&lt;span style=\'color: rgb(102, 102, 102); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 14px; background-color: rgb(242, 242, 242);\'&gt;6年免检标志是从2014年9月开始实行的，规定在2012年的9月1日(含9月1日)后注册登记的新车，有2年免检机会；规定在2010年的9月1日(含9月1日)后注册登记的新车只有1次免检机会；而对于2010年的9月1日前注册登记的新车，是没有免检机会的。&lt;/span&gt;&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"\"}');
INSERT INTO `cmf_portal_post` VALUES ('31', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1510824075', '1510824075', '1510824052', '0', ' 6年免检等于不用年检吗？', '', '其实6年免检并非指车辆不用年审，而是指6年不用上线去检测，但每2年还必须到车管所去申领年检合格标志的。且要将年检合格标志贴在前挡风玻璃上，要是不贴标志被查的，可处扣1分、罚款200元的。', '', '&lt;p&gt;&lt;span style=\'color: rgb(102, 102, 102); font-family: 微软雅黑, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 14px; background-color: rgb(242, 242, 242);\'&gt;其实6年免检并非指车辆不用年审，而是指6年不用上线去检测，但每2年还必须到车管所去申领年检合格标志的。且要将年检合格标志贴在前挡风玻璃上，要是不贴标志被查的，可处扣1分、罚款200元的。&lt;/span&gt;&lt;/p&gt;', null, '{\"thumbnail\":\"\",\"template\":\"\"}');

-- ----------------------------
-- Table structure for cmf_portal_tag
-- ----------------------------
DROP TABLE IF EXISTS `cmf_portal_tag`;
CREATE TABLE `cmf_portal_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '标签文章数',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章标签表';

-- ----------------------------
-- Records of cmf_portal_tag
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_portal_tag_post
-- ----------------------------
DROP TABLE IF EXISTS `cmf_portal_tag_post`;
CREATE TABLE `cmf_portal_tag_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '标签 id',
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章 id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  PRIMARY KEY (`id`),
  KEY `term_taxonomy_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 标签文章对应表';

-- ----------------------------
-- Records of cmf_portal_tag_post
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_recycle_bin
-- ----------------------------
DROP TABLE IF EXISTS `cmf_recycle_bin`;
CREATE TABLE `cmf_recycle_bin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT '0' COMMENT '删除内容 id',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `table_name` varchar(60) DEFAULT '' COMMENT '删除内容所在表名',
  `name` varchar(255) DEFAULT '' COMMENT '删除内容名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=' 回收站';

-- ----------------------------
-- Records of cmf_recycle_bin
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_role
-- ----------------------------
DROP TABLE IF EXISTS `cmf_role`;
CREATE TABLE `cmf_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父角色ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;0:禁用;1:正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `list_order` float NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of cmf_role
-- ----------------------------
INSERT INTO `cmf_role` VALUES ('1', '0', '1', '1329633709', '1329633709', '0', '超级管理员', '拥有网站最高管理员权限！');
INSERT INTO `cmf_role` VALUES ('2', '0', '1', '1329633709', '1329633709', '0', '普通管理员', '权限由最高管理员分配！');
INSERT INTO `cmf_role` VALUES ('3', '0', '1', '0', '0', '0', '客服', '消息处理');
INSERT INTO `cmf_role` VALUES ('4', '0', '1', '0', '0', '0', '编辑', '');

-- ----------------------------
-- Table structure for cmf_role_user
-- ----------------------------
DROP TABLE IF EXISTS `cmf_role_user`;
CREATE TABLE `cmf_role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色 id',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of cmf_role_user
-- ----------------------------
INSERT INTO `cmf_role_user` VALUES ('12', '2', '2');
INSERT INTO `cmf_role_user` VALUES ('13', '3', '3');

-- ----------------------------
-- Table structure for cmf_route
-- ----------------------------
DROP TABLE IF EXISTS `cmf_route`;
CREATE TABLE `cmf_route` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:启用,0:不启用',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'URL规则类型;1:用户自定义;2:别名添加',
  `full_url` varchar(255) NOT NULL DEFAULT '' COMMENT '完整url',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '实际显示的url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='url路由表';

-- ----------------------------
-- Records of cmf_route
-- ----------------------------
INSERT INTO `cmf_route` VALUES ('1', '5000', '1', '2', 'portal/List/index?id=6', 'about');
INSERT INTO `cmf_route` VALUES ('2', '4999', '1', '2', 'portal/Article/index?cid=6', 'about/:id');

-- ----------------------------
-- Table structure for cmf_service
-- ----------------------------
DROP TABLE IF EXISTS `cmf_service`;
CREATE TABLE `cmf_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '业务模型ID',
  `company_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '服务公司ID ',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户、联系人',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `username` varchar(50) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '' COMMENT '联系方式',
  `telephone` varchar(15) NOT NULL DEFAULT '',
  `birthday` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '客户地址',
  `seller_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卖家ID',
  `seller_name` varchar(50) NOT NULL DEFAULT '' COMMENT '卖家名',
  `seller_contact` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家联系方式',
  `seller_birthday` varchar(30) NOT NULL DEFAULT '' COMMENT '卖家生日',
  `plateNo` varchar(7) NOT NULL DEFAULT '' COMMENT '车牌号',
  `car_vin` varchar(17) NOT NULL DEFAULT '' COMMENT '车架号',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `appoint_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约时间',
  `service_point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '服务点',
  `service_address` varchar(255) NOT NULL DEFAULT '' COMMENT '服务详细地址',
  `coordinate` varchar(50) NOT NULL DEFAULT '' COMMENT '自定义服务点坐标',
  `fix_history` text COMMENT '维修历史',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注，给管理员区分记录类型用',
  `description` text COMMENT '描述给前台用户用',
  `more` text COMMENT '扩展属性',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶：0否 1是',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：-11过期 -5卖家取消失败 -4买家取消失败 -3管理员取消 -2卖家取消 -1买家取消 0预约中 1预约成功 2取车中 3正在检测 4检测完成 9送回中 10完成结束',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '默认值10000，默认排序按从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='业务表';

-- ----------------------------
-- Records of cmf_service
-- ----------------------------
INSERT INTO `cmf_service` VALUES ('1', '1', '1', '3', '0', '汪某人', '', '0551-63512518', '', '', '0', '', '', '', '皖AH67XB', '', '0', '0', '0', '', '', null, '', null, null, '0', '0', '0', '0', '0', '10000');

-- ----------------------------
-- Table structure for cmf_service_category
-- ----------------------------
DROP TABLE IF EXISTS `cmf_service_category`;
CREATE TABLE `cmf_service_category` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `type` char(10) NOT NULL DEFAULT 'service' COMMENT '业务类型（service，shop，flow）',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '业务中文名',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '业务代码',
  `dir` varchar(20) NOT NULL DEFAULT '' COMMENT '业务文件夹',
  `dev` varchar(20) NOT NULL DEFAULT '' COMMENT '开发者',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '业务描述',
  `content` text COMMENT '内容',
  `more` text COMMENT '业务扩展配置',
  `indus_bid` tinytext COMMENT '绑定行业',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶： 0否 1是',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '业务开启状态： 0关闭 1开启',
  `open_define` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启自定义客户资料',
  `define_data` varchar(255) NOT NULL DEFAULT '' COMMENT '自定义客户资料',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '默认值10000，默认排序按从小到大',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_service_category
-- ----------------------------
INSERT INTO `cmf_service_category` VALUES ('1', '0', '0', 'service', '菜鸟验车', 'noob', '', 'admin', '', '平台预约 线下取车、验车、送车  平台工作人员代检', '\n&lt;h6 style=&quot;padding: 0px; margin: 0px; color: rgb(51, 51, 51); list-style: none; font-size: 18px; font-weight: normal; font-family: 微软雅黑, &quot; microsoft yahei sans-serif white-space: normal&gt;办理网上预约验车手续须知：&lt;/h6&gt;\n&lt;p style=&quot;padding: 0px 0px 0px 23px; margin-top: 10px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 16px; line-height: 1.78; position: relative;&quot;&gt;&lt;span style=&quot;padding: 0px; margin: 0px; list-style: none; position: absolute; top: 0px; left: 0px;&quot;&gt;1、&lt;/span&gt;本市注册登记的在用机动车（号牌号码后部有汉字的除外）。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px 0px 0px 23px; margin-top: 10px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 16px; line-height: 1.78; position: relative;&quot;&gt;&lt;span style=&quot;padding: 0px; margin: 0px; list-style: none; position: absolute; top: 0px; left: 0px;&quot;&gt;2、&lt;/span&gt;车辆检验有效期在截止前的三个月之内，检验有效期截止的具体日期 请查看您的行驶证副页，或登录交管局主站使用“车辆违法”查询功 能进行查看。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px 0px 0px 23px; margin-top: 10px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 16px; line-height: 1.78; position: relative;&quot;&gt;&lt;span style=&quot;padding: 0px; margin: 0px; list-style: none; position: absolute; top: 0px; left: 0px;&quot;&gt;3、&lt;/span&gt;您可以预约从第二日起连续一周之内的网上预约验车服务。（如：您在07月15日，可以预约07月16-21日之间的预约验车手续。）&lt;/p&gt;\n&lt;p style=&quot;padding: 0px 0px 0px 23px; margin-top: 10px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 16px; line-height: 1.78; position: relative;&quot;&gt;&lt;span style=&quot;padding: 0px; margin: 0px; list-style: none; position: absolute; top: 0px; left: 0px;&quot;&gt;4、&lt;/span&gt;如遇检测场网络设备故障或雨雪等恶劣天气检测场暂停验车的，请您接到通知或看到通报后不要再前往验车，不算爽约，可重新预约。如遇其它问题可联系我们查询检测场电话。&lt;/p&gt;\n&lt;p style=&quot;padding: 0px 0px 0px 23px; margin-top: 10px; margin-bottom: 0px; color: rgb(102, 102, 102); list-style: none; font-size: 16px; line-height: 1.78; position: relative;&quot;&gt;&lt;span style=&quot;padding: 0px; margin: 0px; list-style: none; position: absolute; top: 0px; left: 0px;&quot;&gt;5、&lt;/span&gt;您在办理网上预约验车过程中遇到问题或有何建议意见请通过以下方 式反映：邮箱：1120594563@163.com；电话：87625172。 感谢 您的支持和关注。&lt;/p&gt;\n', '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service1.jpg\"}', '', '1509692503', '0', '0', '1', '1', '[\"username\",\"telephone\",\"plateNo\"]', '10', '下下下', '上上上', '中转站');
INSERT INTO `cmf_service_category` VALUES ('2', '0', '0', 'service', '预约检车', 'inspectcar', '', 'admin', '', '提供各大车险公司服务\r\n为您的安全保驾护航', '', '{\"thumbnail\":\"\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service2.jpg\"}', '', '1511768040', '0', '0', '1', '1', '[\"username\",\"contact\",\"plateNo\",\"reg_time\",\"identity_card\",\"driving_license\",\"appoint_time\",\"service_point\"]', '20', '', '', '');
INSERT INTO `cmf_service_category` VALUES ('3', '0', '0', 'service', '上牌预约', 'applylicense', '', 'admin', '', '随时预约', '', '{\"thumbnail\":\"http:\\/\\/tx.car\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service1.jpg\"}', '', '1509692503', '0', '0', '1', '1', '[\"username\",\"telephone\",\"identity_card\",\"driving_license\",\"appoint_time\",\"service_point\"]', '30', '', '', '');
INSERT INTO `cmf_service_category` VALUES ('4', '0', '0', 'service', '过户申请', 'assigned', '', 'admin', '', '', '', '{\"thumbnail\":\"http:\\/\\/tx.car\\/themes\\/datong_car\\/public\\/assets\\/images\\/example\\/service2.jpg\"}', '', '1509692460', '0', '0', '1', '1', '[\"username\",\"contact\",\"address\",\"seller_name\",\"seller_contact\",\"plateNo\",\"reg_time\",\"identity_card\",\"driving_license\",\"qualified\",\"loan_invoice\",\"appoint_time\",\"service_point\"]', '40', '', '', '');

-- ----------------------------
-- Table structure for cmf_slide
-- ----------------------------
DROP TABLE IF EXISTS `cmf_slide`;
CREATE TABLE `cmf_slide` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:显示,0不显示',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片分类',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分类备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片表';

-- ----------------------------
-- Records of cmf_slide
-- ----------------------------
INSERT INTO `cmf_slide` VALUES ('1', '1', '0', '首页Banner', '暂时仅支持  一张');

-- ----------------------------
-- Table structure for cmf_slide_item
-- ----------------------------
DROP TABLE IF EXISTS `cmf_slide_item`;
CREATE TABLE `cmf_slide_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) NOT NULL DEFAULT '0' COMMENT '幻灯片id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '幻灯片名称',
  `image` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片图片',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片链接',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '幻灯片描述',
  `content` text CHARACTER SET utf8 COMMENT '幻灯片内容',
  `more` text COMMENT '链接打开方式',
  PRIMARY KEY (`id`),
  KEY `slide_cid` (`slide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片子项表';

-- ----------------------------
-- Records of cmf_slide_item
-- ----------------------------
INSERT INTO `cmf_slide_item` VALUES ('1', '1', '1', '10000', 'banner1', '/themes/datong_car/public/assets/images/example/banner.jpg', 'http://www.wincomtech.cn', '', '', '', null);

-- ----------------------------
-- Table structure for cmf_theme
-- ----------------------------
DROP TABLE IF EXISTS `cmf_theme`;
CREATE TABLE `cmf_theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后升级时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模板状态,1:正在使用;0:未使用',
  `is_compiled` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为已编译模板',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '主题目录名，用于主题的维一标识',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '主题名称',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '主题版本号',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '主题作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `lang` varchar(10) NOT NULL DEFAULT '' COMMENT '支持语言',
  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '主题关键字',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '主题描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmf_theme
-- ----------------------------
INSERT INTO `cmf_theme` VALUES ('1', '0', '0', '0', '0', 'simpleboot3', 'simpleboot3', '1.0.2', 'http://demo.thinkcmf.com', '', 'ThinkCMF', 'http://www.thinkcmf.com', 'zh-cn', 'ThinkCMF模板', 'ThinkCMF默认模板');
INSERT INTO `cmf_theme` VALUES ('2', '0', '0', '0', '0', 'datong_car', 'datong_car', '1.0.0', 'http://www.wowlothar.cn', '', 'Lothar', 'http://www.wowlothar.cn', 'zh-cn', '大通车服模板', '大通车服默认模板');

-- ----------------------------
-- Table structure for cmf_theme_file
-- ----------------------------
DROP TABLE IF EXISTS `cmf_theme_file`;
CREATE TABLE `cmf_theme_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_public` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否公共的模板文件',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '模板名称',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '模板文件名',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作',
  `file` varchar(50) NOT NULL DEFAULT '' COMMENT '模板文件，相对于模板根目录，如Portal/index.html',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '模板文件描述',
  `more` text COMMENT '模板更多配置,用户自己后台设置的',
  `config_more` text COMMENT '模板更多配置,来源模板的配置文件',
  `draft_more` text COMMENT '模板更多配置,用户临时保存的配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmf_theme_file
-- ----------------------------
INSERT INTO `cmf_theme_file` VALUES ('105', '0', '10', 'simpleboot3', '文章页', 'portal/Article/index', 'portal/article', '文章页模板文件', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('106', '0', '10', 'simpleboot3', '联系我们页', 'portal/Page/index', 'portal/contact', '联系我们页模板文件', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"Wincomtech<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u5408\\u80a5\\u5e02\\u4e09\\u5b5d\\u53e3XX\\u8def0001\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u5408\\u80a5\\u5e02\\u4e09\\u5b5d\\u53e3XX\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 SanXiao Road, Hefei China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('107', '0', '5', 'simpleboot3', '首页', 'portal/Index/index', 'portal/index', '首页模板文件', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('108', '0', '10', 'simpleboot3', '文章列表页', 'portal/List/index', 'portal/list', '文章列表模板文件', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('109', '0', '10', 'simpleboot3', '单页面', 'portal/Page/index', 'portal/page', '单页面模板文件', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('110', '0', '10', 'simpleboot3', '搜索页面', 'portal/search/index', 'portal/search', '搜索模板文件', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('111', '1', '0', 'simpleboot3', '模板全局配置', 'public/Config', 'public/config', '模板全局配置文件', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('112', '1', '1', 'simpleboot3', '导航条', 'public/Nav', 'public/nav', '导航条模板文件', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"\\u5927\\u901a\\u8f66\\u670d\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '');
INSERT INTO `cmf_theme_file` VALUES ('113', '0', '10', 'datong_car', '文章页', 'portal/Article/index', 'portal/article', '文章页模板文件', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('114', '0', '10', 'datong_car', '联系我们页', 'portal/Page/index', 'portal/contact', '联系我们页模板文件', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"Wincomtech<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u5408\\u80a5\\u5e02\\u4e09\\u5b5d\\u53e3XX\\u8def0001\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u5408\\u80a5\\u5e02\\u4e09\\u5b5d\\u53e3XX\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 SanXiao Road, Hefei China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('115', '0', '5', 'datong_car', '首页', 'portal/Index/index', 'portal/index', '首页模板文件', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('116', '0', '10', 'datong_car', '文章列表页', 'portal/List/index', 'portal/list', '文章列表模板文件', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('117', '0', '10', 'datong_car', '单页面', 'portal/Page/index', 'portal/page', '单页面模板文件', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('118', '0', '10', 'datong_car', '搜索页面', 'portal/search/index', 'portal/search', '搜索模板文件', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('119', '1', '0', 'datong_car', '模板全局配置', 'public/Config', 'public/config', '模板全局配置文件', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('120', '1', '1', 'datong_car', '导航条', 'public/Nav', 'public/nav', '导航条模板文件', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', null);
INSERT INTO `cmf_theme_file` VALUES ('121', '0', '6', 'datong_car', '文章页', 'portal/Article/index', 'portal/about', '文章页模板文件', '[]', '[]', null);

-- ----------------------------
-- Table structure for cmf_third_party_user
-- ----------------------------
DROP TABLE IF EXISTS `cmf_third_party_user`;
CREATE TABLE `cmf_third_party_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '本站用户id',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'access_token过期时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:正常;0:禁用',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `third_party` varchar(20) NOT NULL DEFAULT '' COMMENT '第三方惟一码',
  `app_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方应用 id',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `access_token` varchar(512) NOT NULL DEFAULT '' COMMENT '第三方授权码',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '第三方用户id',
  `union_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方用户多个产品中的惟一 id,(如:微信平台)',
  `more` text COMMENT '扩展信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方用户表';

-- ----------------------------
-- Records of cmf_third_party_user
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_trade_order
-- ----------------------------
DROP TABLE IF EXISTS `cmf_trade_order`;
CREATE TABLE `cmf_trade_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单编号',
  `car_id` int(11) unsigned NOT NULL COMMENT '车子ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `order_sn` varchar(150) NOT NULL COMMENT '订单号',
  `order_name` varchar(150) NOT NULL COMMENT '订单名称',
  `buyer_uid` int(11) unsigned NOT NULL COMMENT '买家编号',
  `buyer_username` varchar(20) NOT NULL COMMENT '买家用户名',
  `buyer_contact` varchar(60) NOT NULL COMMENT '买家联系方式',
  `buyer_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址',
  `seller_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卖家编号',
  `seller_username` varchar(30) NOT NULL COMMENT '卖家用户名',
  `pay_id` varchar(30) NOT NULL DEFAULT '' COMMENT '支付标识：alipay支付宝 wxjs微信js  wxnative微信扫码',
  `bargain_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订金、预约金',
  `nums` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `product_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品金额',
  `shipping_id` varchar(30) NOT NULL COMMENT '快递标识',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递费',
  `tracking_no` varchar(30) NOT NULL COMMENT '快递单号',
  `order_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价',
  `refund` decimal(10,2) NOT NULL COMMENT '退款',
  `remark` varchar(255) NOT NULL COMMENT '备注，给管理员区分记录类型用',
  `description` varchar(255) NOT NULL COMMENT '描述，给前台用户用',
  `more` text COMMENT '扩展数据',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态：-11过期 -5卖家取消失败,-4买家取消失败,-3管理员取消,-2卖家取消,-1买家取消,0未支付订金,1预约中,8支付全部,10完成(确认收货)',
  `audit_data` varchar(255) NOT NULL COMMENT '审核资料：上传票据照片',
  PRIMARY KEY (`id`),
  KEY `idx1` (`pay_id`),
  KEY `idx2` (`buyer_uid`),
  KEY `idx3` (`seller_uid`),
  KEY `idx4` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='车辆买卖订单表';

-- ----------------------------
-- Records of cmf_trade_order
-- ----------------------------
INSERT INTO `cmf_trade_order` VALUES ('1', '1', '0', 'DSC20171025-f5re4e', '', '3', '洛萨', '18356082312', '合肥市蜀山区佛子岭路66号', '1', 'admin', 'alipay', '0.00', '1', '0.00', '', '0.00', '', '100.00', '0.00', '订单测试', '', '{\"username\":\"\",\"contact\":\"\",\"driving_license\":\"\"}', '1509613450', '0', '0', '0', '8', '');

-- ----------------------------
-- Table structure for cmf_trade_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `cmf_trade_order_detail`;
CREATE TABLE `cmf_trade_order_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单明细编号',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `obj_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对象编号：车子ID',
  `obj_name` varchar(100) NOT NULL DEFAULT '' COMMENT '对象名称',
  `obj_type` varchar(20) NOT NULL DEFAULT '' COMMENT '对象类型',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `num` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `detail_type` varchar(20) NOT NULL DEFAULT '' COMMENT '用于增值服务code记录',
  `more` text COMMENT '拓展属性',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单详情表';

-- ----------------------------
-- Records of cmf_trade_order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_trade_shop
-- ----------------------------
DROP TABLE IF EXISTS `cmf_trade_shop`;
CREATE TABLE `cmf_trade_shop` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '认领者ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `type` char(10) NOT NULL COMMENT '店铺类型：person个人 enterprise企业',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '店铺名称',
  `image` varchar(255) NOT NULL COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺签名',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `com_url` varchar(100) NOT NULL DEFAULT '' COMMENT '外链',
  `more` text COMMENT '扩展属性',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `identi_status` tinyint(2) NOT NULL COMMENT '认证状态：0未认证 1已认证 2禁止认证',
  `status` tinyint(2) NOT NULL COMMENT '状态：0隐藏 1显示 2禁用',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='二手买卖店铺表';

-- ----------------------------
-- Records of cmf_trade_shop
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user`;
CREATE TABLE `cmf_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户类型;1:admin;2:会员',
  `user_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码;cmf_password加密',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '用户登录邮箱',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别;0:保密,1:男,2:女',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `coin` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金币',
  `freeze` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '冻结',
  `ticket` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '点券',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `user_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常,2:未验证',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `more` text COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  KEY `user_login` (`user_login`),
  KEY `user_nickname` (`user_nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of cmf_user
-- ----------------------------
INSERT INTO `cmf_user` VALUES ('1', '1', 'admin', 'admin', '###b0b5b1441fcc40910db4b7d99d049ddf', 'admin@admin.com', '', '', '0', '0', '0.00', '0.00', '0.00', '0', '', '', '1507865317', '1512787745', '127.0.0.1', '1', '', '');
INSERT INTO `cmf_user` VALUES ('2', '1', '超人不会飞', 'super', '###797fe4d0d1b299ac9b581f4fa4025dbb', 'super@qq.com', '', '', '0', '0', '0.00', '0.00', '0.00', '0', '', '', '0', '0', '', '1', '', '');
INSERT INTO `cmf_user` VALUES ('3', '1', '洛萨', 'lothar', '###797fe4d0d1b299ac9b581f4fa4025dbb', 'lothar@qq.com', '13333333333', 'avatar/20171125/584d5aa4308ccc597df494da2b84700d.jpg', '0', '0', '80.00', '320.00', '0.00', '785865600', '', '', '0', '1512721893', '127.0.0.1', '1', '', '{\"qq\":\"34242432\",\"address\":\"56特有涂改液\"}');
INSERT INTO `cmf_user` VALUES ('4', '2', '', '', '###797fe4d0d1b299ac9b581f4fa4025dbb', '', '18956471234', '', '0', '0', '0.00', '0.00', '0.00', '0', '', '', '1512194173', '1512194173', '127.0.0.1', '2', '', null);

-- ----------------------------
-- Table structure for cmf_user_action
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_action`;
CREATE TABLE `cmf_user_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '更改积分，可以为负',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '更改金币，可以为负',
  `reward_number` int(11) NOT NULL DEFAULT '0' COMMENT '奖励次数',
  `cycle_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '周期类型;0:不限;1:按天;2:按小时;3:永久',
  `cycle_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '周期时间值',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称',
  `app` varchar(50) NOT NULL DEFAULT '' COMMENT '操作所在应用名或插件名等',
  `url` text COMMENT '执行操作的url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户操作表';

-- ----------------------------
-- Records of cmf_user_action
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user_action_log
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_action_log`;
CREATE TABLE `cmf_user_action_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `last_visit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后访问时间',
  `object` varchar(100) NOT NULL DEFAULT '' COMMENT '访问对象的id,格式:不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户ip',
  PRIMARY KEY (`id`),
  KEY `user_object_action` (`user_id`,`object`,`action`),
  KEY `user_object_action_ip` (`user_id`,`object`,`action`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问记录表';

-- ----------------------------
-- Records of cmf_user_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user_favorite
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_favorite`;
CREATE TABLE `cmf_user_favorite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户 id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '收藏内容的标题',
  `url` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) CHARACTER SET utf8 DEFAULT '' COMMENT '收藏内容的描述',
  `table_name` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '收藏实体以前所在表,不带前缀',
  `object_id` int(10) unsigned DEFAULT '0' COMMENT '收藏内容原来的主键id',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户收藏表';

-- ----------------------------
-- Records of cmf_user_favorite
-- ----------------------------
INSERT INTO `cmf_user_favorite` VALUES ('1', '3', '宝马7系 2009款 740Li领先型', '{\"action\":\"trade\\/Post\\/details\",\"param\":{\"id\":3}}', '操作用户[3]洛萨', 'usual_car', '3', '1512007448');
INSERT INTO `cmf_user_favorite` VALUES ('2', '1', '福特 嘉年华两厢 2011款 1.5 自动 时尚型', '{\"action\":\"trade\\/Post\\/details\",\"param\":{\"id\":2}}', '操作用户[1]admin', 'usual_car', '2', '1512457570');

-- ----------------------------
-- Table structure for cmf_user_funds_log
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_funds_log`;
CREATE TABLE `cmf_user_funds_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户操作类型 user_funds_log_type。自定义：',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `coin` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '更改金币，可以为负',
  `remain` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余金额',
  `obj_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对象ID',
  `apply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '申请ID',
  `app` char(15) NOT NULL DEFAULT '' COMMENT '记录的来源所在应用名或插件名等',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '用户的ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='用户资金操作日志表';

-- ----------------------------
-- Records of cmf_user_funds_log
-- ----------------------------
INSERT INTO `cmf_user_funds_log` VALUES ('1', '8', '3', '20.00', '20.00', '0', '0', 'user', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('2', '2', '3', '-10.00', '10.00', '0', '0', 'insurance', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('3', '8', '3', '2000.00', '2010.00', '0', '0', 'recharge', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('4', '3', '3', '-30.00', '1980.00', '0', '0', 'service', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('5', '5', '3', '-300.00', '1680.00', '0', '0', 'trade', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('6', '9', '3', '-100.00', '1580.00', '0', '0', 'user', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('7', '10', '3', '-60.00', '1520.00', '0', '0', 'user', '1512489600', '127.0.0.1');
INSERT INTO `cmf_user_funds_log` VALUES ('8', '10', '3', '100.00', '1620.00', '0', '0', 'user', '1512489600', '127.0.0.1');

-- ----------------------------
-- Table structure for cmf_user_login_attempt
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_login_attempt`;
CREATE TABLE `cmf_user_login_attempt` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login_attempts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '尝试次数',
  `attempt_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '尝试登录时间',
  `locked_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户 ip',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '用户账号,手机号,邮箱或用户名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户登录尝试表';

-- ----------------------------
-- Records of cmf_user_login_attempt
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user_score_log
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_score_log`;
CREATE TABLE `cmf_user_score_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称。自定义：regCar第一次登记申请开店',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '更改积分，可以为负',
  `coin` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '更改金币，可以为负',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户操作积分等奖励日志表';

-- ----------------------------
-- Records of cmf_user_score_log
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user_ticket_log
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_ticket_log`;
CREATE TABLE `cmf_user_ticket_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户操作类型funds_type',
  `ticket` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '点券数额，可以为负',
  `deal_uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户点券记录表';

-- ----------------------------
-- Records of cmf_user_ticket_log
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_user_token
-- ----------------------------
DROP TABLE IF EXISTS `cmf_user_token`;
CREATE TABLE `cmf_user_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT ' 过期时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'token',
  `device_type` varchar(10) NOT NULL DEFAULT '' COMMENT '设备类型;mobile,android,iphone,ipad,web,pc,mac,wxapp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='用户客户端登录 token 表';

-- ----------------------------
-- Records of cmf_user_token
-- ----------------------------
INSERT INTO `cmf_user_token` VALUES ('3', '1', '1528339745', '1512787745', '8a0974a4e71a6d4ca475899d8e76f3af8a0974a4e71a6d4ca475899d8e76f3af', 'web');
INSERT INTO `cmf_user_token` VALUES ('4', '3', '1527744994', '1512192994', 'dc256e0c455256ac1b543488cfa766c7dc256e0c455256ac1b543488cfa766c7', 'web');

-- ----------------------------
-- Table structure for cmf_usual_brand
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_brand`;
CREATE TABLE `cmf_usual_brand` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `deal_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `index` char(4) NOT NULL DEFAULT '*' COMMENT '索引',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `more` text COMMENT '扩展',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx1` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='品牌表';

-- ----------------------------
-- Records of cmf_usual_brand
-- ----------------------------
INSERT INTO `cmf_usual_brand` VALUES ('1', '0', '0', '宝马', '', '', '*', '0', '', '德国', '0', '{\"thumbnail\":\"http:\\/\\/www.bmw.com.cn\\/content\\/dam\\/bmw\\/marketCN\\/bmw_com_cn\\/bmw_ds2_module_box.png.asset.1481563906324.png\"}', '0-1', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('2', '0', '0', '大众', '', '', '*', '0', '', '德国', '0', '{\"thumbnail\":\"http:\\/\\/www.vw.com.cn\\/content\\/dam\\/vw-ngw\\/vw\\/logo\\/PC_93x122_Final.png\"}', '0-2', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('3', '0', '0', '雪佛兰', '', '', '*', '0', '', '', '0', '{\"thumbnail\":\"https:\\/\\/www.chevrolet.com.cn\\/\\/img\\/navigation\\/logo.png\"}', '0-3', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('4', '0', '0', '福特', '', '', '*', '0', '', '美国福特汽车公司（Ford Motor Company）旗下的众多品牌之一', '0', '{\"thumbnail\":\"https:\\/\\/www.ford.com.cn\\/content\\/dam\\/Ford\\/website-assets\\/ap\\/ch\\/header\\/logo.jpg\"}', '0-4', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('5', '0', '0', '凯迪拉克', '', '', '*', '0', '', '', '0', '{\"thumbnail\":\"https:\\/\\/www.cadillac.com.cn\\/images\\/logo.png\"}', '0-5', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('6', '0', '0', '斯巴鲁', '', '', '*', '0', '', '日本。\r\n富士重工业株式会社（ FHI ）。', '0', '{\"thumbnail\":\"http:\\/\\/www.subaru-china.cn\\/impublic\\/common\\/img\\/logo.jpg\"}', '0-6', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('7', '0', '0', '比亚迪', '', '', '*', '0', '', '', '0', '{\"thumbnail\":\"http:\\/\\/www.bydauto.com.cn\\/template\\/images\\/header\\/logo_xny.png\"}', '0-7', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('8', '0', '0', '别克', '', '', '*', '0', '', '美国通用汽车公司', '0', '{\"thumbnail\":\"http:\\/\\/www.buick.com.cn\\/img\\/shared\\/logo_buick.png\"}', '0-8', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('9', '0', '0', '林肯', '', '', '*', '0', '', '', '0', '{\"thumbnail\":\"https:\\/\\/www.lincoln.com.cn\\/content\\/dam\\/lincoln\\/logo.png\"}', '0-9', '10000', '', '', '');
INSERT INTO `cmf_usual_brand` VALUES ('10', '0', '0', '奥迪', '', '', '*', '0', '', '德国大众汽车集团子公司奥迪汽车公司旗下的', '0', '{\"thumbnail\":\"\"}', '0-10', '10000', '', '', '');

-- ----------------------------
-- Table structure for cmf_usual_car
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_car`;
CREATE TABLE `cmf_usual_car` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '车源平台： 1新车 2旧车',
  `brand_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `serie_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '车系ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '车型ID',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `country_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '国家ID',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市ID',
  `deal_uid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '处理人',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '车子标题',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `car_vin` varchar(17) NOT NULL DEFAULT '' COMMENT '车架号（Vehicle Identification Number），中文名叫车辆识别代码， 是制造厂为了识别而给一辆车指定的一组字码。VIN码是由17位字母、数字组成的编码',
  `plateNo` varchar(7) NOT NULL DEFAULT '' COMMENT '车牌号',
  `car_license_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上牌时间',
  `car_check_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '年检到期日',
  `car_insur_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '保险到期日',
  `car_age` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '车龄',
  `car_mileage` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '里程',
  `car_displacement` float unsigned NOT NULL DEFAULT '0' COMMENT '排量：单位L',
  `car_seating` smallint(6) unsigned NOT NULL DEFAULT '5' COMMENT '座位数',
  `car_gearbox` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '变速箱：0不限 1自动 2手动',
  `car_effluent` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排放标准',
  `car_fuel` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '燃料类型',
  `car_color` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '颜色',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否热门',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容详情',
  `more` text COMMENT '扩展属性',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1禁用 0隐藏 1显示 ',
  `identi_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证审核状态： -1审核不通过 0未审核 1审核通过 2禁止操作',
  `identi` text COMMENT '认证体系 认证资料',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  `sell_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '售卖状态： -11售罄 -2禁止出售 -1下架 0初始态 1上架(售卖中) 2已下单 3已付款 10完成(最终确认) ',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上架时间',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '车源类别：0未分类 1准新车、2练手车、3分期购',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺价',
  `down_payment` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '首付',
  `bargain_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订金、预约金',
  `inventory` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '库存',
  `old_user` varchar(255) NOT NULL DEFAULT '' COMMENT '以前的车主',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='车辆表';

-- ----------------------------
-- Records of cmf_usual_car
-- ----------------------------
INSERT INTO `cmf_usual_car` VALUES ('1', '1', '2', '2', '2', '1', '0', '3', '3401', '0', '大众 CC 2015款 1.8T 自动 豪华型', '', '', 'eq123456789875463', '皖AH67XB', '1510243200', '0', '0', '3', '7.50', '1.8', '5', '26', '14', '15', '6', '1510814246', '1512465505', '0', '0', '0', '0', '', '', '', '{\"car_seating\":\"3\",\"car_color\":\"6\",\"car_length\":\"144\",\"car_age\":\"30\",\"car_effluent\":\"14\",\"car_fuel\":\"15\",\"car_displacement\":\"21\",\"car_mileage\":\"36\",\"car_engine\":\"\",\"car_gearbox\":\"26\",\"thumbnail\":\"https:\\/\\/c1.xinstatic.com\\/f2\\/20171129\\/1213\\/5a1e3406f185c449197_18.jpg\",\"photos\":[{\"url\":\"https:\\/\\/c1.xinstatic.com\\/f2\\/20171129\\/1213\\/5a1e3406f185c449197_18.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171128\\/1747\\/5a1d309c1a2f3394194_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171128\\/1746\\/5a1d30692245f485179_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171128\\/1747\\/5a1d3096e0b4a149087_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171128\\/1746\\/5a1d30912c8eb290047_20.jpg\",\"name\":\"\"}]}', '1', '1', '{\"username\":\"王铮\",\"contact\":\"手机：13333333333\",\"plateNo\":\"皖AH67XB\",\"driving_license\":\"\"}', '', '', '', '10000', '1', '1509590656', '10.78', '1', '29.18', '19.98', '5.99', '0.00', '1', '');
INSERT INTO `cmf_usual_car` VALUES ('2', '1', '4', '11', '2', '1', '0', '3', '3401', '0', '福特 嘉年华两厢 2011款 1.5 自动 时尚型', '', '', 'xzuih433hf7463343', '皖H967JN', '1352563200', '1544064060', '1544064060', '5', '4.40', '1.5', '5', '26', '13', '15', '10', '1510814220', '1512528103', '0', '0', '0', '1', '', '', '', '{\"car_seating\":\"3\",\"car_color\":\"10\",\"car_length\":\"121\",\"car_age\":\"31\",\"car_effluent\":\"13\",\"car_fuel\":\"15\",\"car_displacement\":\"20\",\"car_mileage\":\"35\",\"car_engine\":\"JX493ZLQ3\",\"car_gearbox\":\"26\",\"thumbnail\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1752\\/5a1e8372a23ff749974_19.jpg\",\"photos\":[{\"url\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1752\\/5a1e8372a23ff749974_19.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1755\\/5a1e83fe9df67478481_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1752\\/5a1e8369598d4375149_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1754\\/5a1e83e7b0d7b426279_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c3.xinstatic.com\\/f2\\/20171129\\/1752\\/5a1e836d94e07827031_20.jpg\",\"name\":\"\"}]}', '1', '1', '{\"username\":\"澄迈\",\"contact\":\"\",\"plateNo\":\"皖H967JN\",\"driving_license\":\"\"}', '', '', '', '10000', '1', '1510392426', '9.80', '2', '10.63', '4.78', '1.43', '0.00', '1', '');
INSERT INTO `cmf_usual_car` VALUES ('3', '1', '1', '17', '2', '1', '0', '3', '3401', '0', '宝马 1系两厢五门版 2012款 1.6T 自动 116i都市版', '', '', '', '皖A95K88', '1350057600', '0', '0', '0', '14.00', '2.5', '3', '28', '14', '15', '8', '1510814246', '1512465531', '0', '0', '0', '0', '', '', '', '{\"car_seating\":\"3\",\"car_color\":\"8\",\"car_length\":\"\",\"car_age\":\"\",\"car_effluent\":\"14\",\"car_fuel\":\"15\",\"car_displacement\":\"\",\"car_mileage\":\"\",\"car_engine\":\"\",\"car_gearbox\":\"28\",\"thumbnail\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1726\\/5a1e7d3fa651c407670_19.jpg\",\"photos\":[{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1726\\/5a1e7d3fa651c407670_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1727\\/5a1e7d7a28744241112_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1726\\/5a1e7d2fbae64486662_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1727\\/5a1e7d741c49c885807_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c2.xinstatic.com\\/f2\\/20171129\\/1726\\/5a1e7d3c7ab05985442_20.jpg\",\"name\":\"\"}]}', '1', '1', '{\"username\":\"贝尔\",\"contact\":\"QQ：456876646\",\"plateNo\":\"皖A95K88\",\"driving_license\":\"https:\\/\\/c1.xinstatic.com\\/f2\\/20171113\\/1802\\/5a096daf09902191543_18.jpg\"}', '', '', '', '10000', '1', '1510552638', '30.00', '3', '30.18', '17.98', '5.39', '0.00', '1', '');
INSERT INTO `cmf_usual_car` VALUES ('4', '1', '4', '14', '4', '1', '0', '31', '383', '0', '福特 Mustang 2015款 2.3T 自动 性能版', '', '', '', '皖A85K88', '1325433600', '0', '0', '5', '2.80', '2.3', '3', '26', '14', '15', '7', '1512119386', '1512465543', '0', '0', '0', '0', '', '', null, '{\"car_seating\":\"3\",\"car_color\":\"7\",\"car_length\":\"160\",\"car_age\":\"\",\"car_effluent\":\"14\",\"car_fuel\":\"15\",\"car_displacement\":\"\",\"car_mileage\":\"\",\"car_engine\":\"\",\"car_gearbox\":\"26\",\"thumbnail\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1712\\/5a1fcb9209ee7452880_19.jpg\",\"photos\":[{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1712\\/5a1fcb9209ee7452880_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcbc848c81733344_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1712\\/5a1fcb8c75a67422131_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcbc2394c8716043_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1712\\/5a1fcb8f3e9ca641995_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcb9f9b50d944989_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcba31ed87538246_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcba68b7c0631568_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcbbc7e6c5748880_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c4.xinstatic.com\\/f2\\/20171130\\/1713\\/5a1fcbd0d8804237222_20.jpg\",\"name\":\"\"}]}', '1', '1', '{\"username\":\"陈东\",\"contact\":\"18956743215\",\"plateNo\":\"皖A85K88\",\"driving_license\":\"\"}', '', '', '', '10000', '1', '1512118965', '37.06', '0', '43.40', '37.06', '10.74', '0.00', '1', '');
INSERT INTO `cmf_usual_car` VALUES ('5', '1', '4', '13', '5', '1', '0', '3', '3401', '0', '福特 全顺经典 2009款 2.8T 手动 标准型短轴中顶JX493ZLQ3 柴油', '', '', '', '皖A55K88', '1391443200', '0', '0', '3', '9.30', '2.8', '4', '27', '12', '16', '6', '1512119920', '1512465558', '0', '0', '0', '0', '', '', null, '{\"car_seating\":\"2\",\"car_color\":\"6\",\"car_length\":\"220\",\"car_age\":\"\",\"car_effluent\":\"12\",\"car_fuel\":\"16\",\"car_displacement\":\"\",\"car_mileage\":\"\",\"car_engine\":\"\",\"car_gearbox\":\"27\",\"thumbnail\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143e6ca019161901_20.jpg\",\"photos\":[{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143e6ca019161901_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1643\\/5a114442b77d2947738_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143dd2f6ca814522_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1643\\/5a1144305ccc7526465_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143e202340843673_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143f8d7695187119_20.jpg\",\"name\":\"\"},{\"url\":\"https:\\/\\/c5.xinstatic.com\\/f2\\/20171119\\/1642\\/5a1143fd311fa347233_20.jpg\",\"name\":\"\"}]}', '1', '1', '{\"username\":\"\",\"contact\":\"\",\"plateNo\":\"皖A55K88\",\"driving_license\":\"\"}', '', '', '', '10000', '1', '1512119643', '16.52', '0', '15.72', '8.88', '1.36', '200.00', '1', '');

-- ----------------------------
-- Table structure for cmf_usual_company
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_company`;
CREATE TABLE `cmf_usual_company` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '认领者ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `province_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `city_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '城市ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间，注册时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `com_url` varchar(100) NOT NULL DEFAULT '' COMMENT '公司官网',
  `coordinates` varchar(800) NOT NULL DEFAULT '' COMMENT '坐标组',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '主描述',
  `desc2` varchar(255) NOT NULL DEFAULT '' COMMENT '次级描述',
  `content` text COMMENT '内容',
  `more` text COMMENT '扩展属性',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_baoxian` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否保险公司',
  `is_yewu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否业务公司',
  `identi_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证状态：-1禁止认证 0未认证 1已认证',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：-1禁用 0隐藏 1显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='公司表';

-- ----------------------------
-- Records of cmf_usual_company
-- ----------------------------
INSERT INTO `cmf_usual_company` VALUES ('1', '1', '0', '0', '0', '大通车服', '', '', '1511493781', '1512181594', '1511493720', '0', '', '', '', '大通车行', '有限公司', '', '{\"thumbnail\":\"portal\\/20171013\\/1f661e0d9d9f0c97b17a50e6e06580c0.png\"}', '0', '1', '1', '1', '1', '1', '10000');
INSERT INTO `cmf_usual_company` VALUES ('2', '1', '0', '10', '146', '润之丰车险', '', '', '1508837547', '1510821132', '1508837460', '0', '', '', '', '好车检省更多', '检测省心', '&lt;p&gt;保障&lt;/p&gt;', '{\"thumbnail\":\"\"}', '0', '0', '1', '1', '1', '1', '10000');
INSERT INTO `cmf_usual_company` VALUES ('3', '1', '0', '10', '146', '开平车检', '', '', '1508990912', '1510820613', '1508990700', '0', '', '', '', '7天左右即可拿检测报告', '快速出结果', '', '{\"thumbnail\":\"http:\\/\\/pimg1.4008000000.com\\/app_images\\/4008000000\\/v20\\/index_b\\/logo.png\",\"photos\":[{\"url\":\"http:\\/\\/pimg1.4008000000.com\\/app_images\\/4008000000\\/v20\\/index_b\\/logo.png\",\"name\":\"\"},{\"url\":\"http:\\/\\/pimg1.4008000000.com\\/app_images\\/4008000000\\/v20\\/index_b\\/logo.png\",\"name\":\"\"}]}', '0', '0', '0', '1', '1', '1', '10000');
INSERT INTO `cmf_usual_company` VALUES ('4', '0', '0', '0', '0', '华通车检', '', '', '1510820665', '1510820665', '1510820648', '0', '', '', '', '各项功能专项检测', '服务新升级', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '1', '1', '1', '10000');
INSERT INTO `cmf_usual_company` VALUES ('5', '1', '0', '0', '0', '平安车险', '', '', '1510820692', '1510821534', '1510820640', '0', '', '', '', '总部深圳', '全国连锁', '', '{\"thumbnail\":\"\"}', '0', '1', '1', '1', '1', '1', '10000');
INSERT INTO `cmf_usual_company` VALUES ('6', '1', '0', '10', '146', '锦平车险', '', '', '1508834130', '1510821960', '0', '0', '', '', '', '多家单位，就近选择', '省心车检体验', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '1', '1', '1', '10000');

-- ----------------------------
-- Table structure for cmf_usual_coordinate
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_coordinate`;
CREATE TABLE `cmf_usual_coordinate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` mediumint(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应省份ID',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的城市ID',
  `name` varchar(255) NOT NULL DEFAULT '暂未设置' COMMENT '服务点名称',
  `ucs_x` char(10) NOT NULL DEFAULT '0.00' COMMENT '横坐标',
  `ucs_y` char(10) NOT NULL DEFAULT '0.00' COMMENT '纵坐标',
  `tel` varchar(255) NOT NULL DEFAULT '' COMMENT '电话',
  `addr` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用：1是 0否',
  `total` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '被选次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_usual_coordinate
-- ----------------------------
INSERT INTO `cmf_usual_coordinate` VALUES ('1', '5', '3', '3401', '平安合肥地区', '117.241405', '31.819577', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('2', '4', '3', '3401', '华通合肥地区', '117.241405', '31.819577', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('3', '3', '3', '3401', '开平合肥地区', '117.241405', '31.819577', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('4', '2', '3', '3401', '润之丰合肥地区', '117.241405', '31.819577', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('5', '6', '3', '3401', '锦平合肥地区', '117.241405', '31.819577', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('6', '1', '3', '3401', '三里街', '117.322762', '31.874442', '400-8358009', '合肥瑶海区地区', '全国', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('7', '1', '3', '3401', '万达广场', '117.227829', '31.826471', '0551-63512518', '绿地蓝海B座605', '华创公司部', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('8', '1', '3', '3401', '包河政府附近', '117.316366', '31.79996', '', '', '', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('9', '1', '3', '3401', '杏花公园', '117.278853', '31.875209', '18955172687', '庐阳杏花公园', '曹翔', '1', '0');
INSERT INTO `cmf_usual_coordinate` VALUES ('10', '1', '2', '52', '北京总部', '116.676204', '40.02398', '010-4685789', '北京市区', '西乡', '1', '0');

-- ----------------------------
-- Table structure for cmf_usual_item
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_item`;
CREATE TABLE `cmf_usual_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '属性值的名称',
  `rule` varchar(255) NOT NULL DEFAULT '' COMMENT '替换规则',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `more` text COMMENT '扩展属性：',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶：1是 0否',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态：-1禁用 0隐藏 1显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COMMENT='属性值表';

-- ----------------------------
-- Records of cmf_usual_item
-- ----------------------------
INSERT INTO `cmf_usual_item` VALUES ('1', '22', '0', '2', '', '', '', '{\"thumbnail\":\"\"}', '1510281005', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('2', '22', '0', '4', '', '', '', '{\"thumbnail\":\"\"}', '1510281034', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('3', '22', '0', '5', '', '', '', '', '1510281639', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('4', '22', '0', '7', '', '', '', '', '1510281698', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('5', '22', '0', '>7', '', '', '7座以上', '', '1510281865', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('6', '20', '0', '1', '', '', '白色', '{\"thumbnail\":\"\"}', '1510397216', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('7', '20', '0', '2', '', '', '黑色', '{\"thumbnail\":\"\"}', '1510394432', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('8', '20', '0', '3', '', '', '灰色', '{\"thumbnail\":\"\"}', '1510394454', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('9', '20', '0', '4', '', '', '黄色', '{\"thumbnail\":\"\"}', '1510394486', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('10', '20', '0', '5', '', '', '红色', '{\"thumbnail\":\"\"}', '1510394510', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('11', '20', '0', '6', '', '', '彩色', '{\"thumbnail\":\"\"}', '1510396450', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('12', '18', '0', '>=3', '', '', '国三以上', '{\"thumbnail\":\"\"}', '1510396584', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('13', '18', '0', '>=4', '', '', '国四以上', '{\"thumbnail\":\"\"}', '1510396715', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('14', '18', '0', '5', '', '', '国五', '{\"thumbnail\":\"\"}', '1510396736', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('15', '19', '0', '1', '', '', '汽油', '{\"thumbnail\":\"\"}', '1510396789', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('16', '19', '0', '2', '', '', '柴油', '{\"thumbnail\":\"\"}', '1510396878', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('17', '19', '0', '3', '', '', '纯电动', '{\"thumbnail\":\"\"}', '1510396840', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('18', '19', '0', '4', '', '', '油电混合', '{\"thumbnail\":\"\"}', '1510396859', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('19', '21', '0', '<1', '', '', '1.0L以下', '{\"thumbnail\":\"\"}', '1510283163', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('20', '21', '0', '1.0~1.6', '', '', '1.1L-1.6L', '{\"thumbnail\":\"\"}', '1510283479', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('21', '21', '0', '1.7~2', '', '', '1.7L-2.0L', '{\"thumbnail\":\"\"}', '1510283465', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('22', '21', '0', '2.1~2.5', '', '', '2.1L-2.5L', '{\"thumbnail\":\"\"}', '1510283449', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('23', '21', '0', '2.5~3', '', '', '2.6L-3.0L', '{\"thumbnail\":\"\"}', '1510283514', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('24', '21', '0', '3~4', '', '', '3.0L-4.0L', '{\"thumbnail\":\"\"}', '1510283540', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('25', '21', '0', '>4', '', '', '4.0L以上', '{\"thumbnail\":\"\"}', '1510283564', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('26', '17', '0', '1', '', '', '自动', '{\"thumbnail\":\"\"}', '1510394362', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('27', '17', '0', '2', '', '', '手动', '{\"thumbnail\":\"\"}', '1510394344', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('28', '17', '0', '3', '', '', '手自一体', '{\"thumbnail\":\"\"}', '1510394325', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('29', '25', '0', '<=1', '', '', '1年以内', '{\"thumbnail\":\"\"}', '1511344443', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('30', '25', '0', '<=3', '', '', '3年以内', '{\"thumbnail\":\"\"}', '1511344475', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('31', '25', '0', '<=5', '', '', '5年以内', '{\"thumbnail\":\"\"}', '1511344502', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('32', '25', '0', '>5', '', '', '5年以上', '{\"thumbnail\":\"\"}', '1511344524', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('33', '24', '0', '<=1', '', '', '1万公里以内', '{\"thumbnail\":\"\"}', '1511344578', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('34', '24', '0', '<=3', '', '', '3万公里以内', '{\"thumbnail\":\"\"}', '1511344826', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('35', '24', '0', '<=5', '', '', '5万公里以内', '{\"thumbnail\":\"\"}', '1511345046', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('36', '24', '0', '<=8', '', '', '8万公里以内', '{\"thumbnail\":\"\"}', '1511345085', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item` VALUES ('37', '24', '0', '>8', '', '', '8万公里以上', '{\"thumbnail\":\"\"}', '1511345540', '0', '0', '1', '10000');

-- ----------------------------
-- Table structure for cmf_usual_item_cate
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_item_cate`;
CREATE TABLE `cmf_usual_item_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '属性名',
  `unit` varchar(10) NOT NULL DEFAULT '' COMMENT '单位：',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '字段码',
  `code_type` varchar(10) NOT NULL DEFAULT 'text' COMMENT '字段码类型',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `more` text COMMENT '扩展属性',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐：1是 0否',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态：-1禁用 0隐藏 1显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COMMENT='属性(分类)表';

-- ----------------------------
-- Records of cmf_usual_item_cate
-- ----------------------------
INSERT INTO `cmf_usual_item_cate` VALUES ('1', '0', '0', '车身', '', 'carbody', 'all', '0-1', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('2', '0', '0', '发动机', '', 'engine', 'all', '0-2', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('3', '0', '0', '变速箱', '', 'gearbox', 'all', '0-3', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('4', '0', '0', '底盘转向', '', 'chassis-steering', 'all', '0-4', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('5', '0', '0', '车轮制动', '', 'wheel_brake', 'all', '0-5', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('6', '0', '0', '主动安全配置', '', 'security_config', 'all', '0-6', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('7', '0', '0', '被动安全配置', '', 'Passive_safety_features', 'all', '0-7', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('8', '0', '0', '防盗配置', '', 'VTD', 'all', '0-8', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('9', '0', '0', '操控配置', '', 'control_config', 'all', '0-9', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('10', '0', '0', '外部配置', '', 'EXTERIOR_SPECIFICATION', 'all', '0-10', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('11', '0', '0', '内部配置', '', 'INTERIOR_SPECIFICATION', 'all', '0-11', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('12', '0', '0', '座椅配置', '', 'seat_config', 'all', '0-12', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('13', '0', '0', '空调配置', '', 'air-conditioned', 'all', '0-13', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('14', '0', '0', '灯光配置', '', 'LightingCollocation', 'all', '0-14', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('15', '0', '0', '多媒体配置', '', 'multi_config', 'all', '0-15', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('16', '0', '0', '驾驶辅助配置', '', 'Pilot_config', 'all', '0-16', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('17', '3', '0', '变速箱', '', 'car_gearbox', 'select', '0-3-17', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('18', '2', '0', '排放标准', '', 'car_effluent', 'select', '0-2-18', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('19', '2', '0', '燃料类型', '', 'car_fuel', 'select', '0-2-19', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('20', '1', '0', '颜色', '', 'car_color', 'select', '0-1-20', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('21', '2', '0', '排量', 'L', 'car_displacement', 'select', '0-2-21', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('22', '1', '0', '座位数', '座', 'car_seating', 'select', '0-1-22', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '100');
INSERT INTO `cmf_usual_item_cate` VALUES ('23', '1', '0', '长度', 'mm', 'car_length', 'text', '0-1-23', '', '', '{\"thumbnail\":\"\"}', '0', '0', '1', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('24', '2', '0', '里程', '万公里', 'car_mileage', 'select', '0-2-24', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('25', '1', '0', '车龄', '年', 'car_age', 'select', '0-1-25', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');
INSERT INTO `cmf_usual_item_cate` VALUES ('26', '2', '0', '发动机', '', 'car_engine', 'text', '0-2-26', '', '', '{\"thumbnail\":\"\"}', '0', '0', '0', '1', '10000');

-- ----------------------------
-- Table structure for cmf_usual_models
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_models`;
CREATE TABLE `cmf_usual_models` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `brand_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '专属品牌ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶：1是 0否',
  `is_rec` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐：1是 0否',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `more` text COMMENT '扩展',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='品牌表';

-- ----------------------------
-- Records of cmf_usual_models
-- ----------------------------
INSERT INTO `cmf_usual_models` VALUES ('1', '0', '0', '0', 'SUV', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-1', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('2', '0', '0', '0', '轿车', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-2', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('3', '0', '0', '0', 'MPV', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-3', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('4', '0', '4', '0', '性能车', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-4', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('5', '0', '0', '0', '商用车', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-5', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('6', '0', '0', '0', '新能源', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-6', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('7', '0', '0', '0', '中型客车', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-7', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('8', '0', '0', '0', '旅行车', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-8', '10000', '', '', '');
INSERT INTO `cmf_usual_models` VALUES ('9', '0', '7', '0', '王朝', '', '', '0', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-9', '10000', '', '', '');

-- ----------------------------
-- Table structure for cmf_usual_series
-- ----------------------------
DROP TABLE IF EXISTS `cmf_usual_series`;
CREATE TABLE `cmf_usual_series` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `brand_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID，车系分类ID',
  `model_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '车型ID',
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `index` char(4) NOT NULL DEFAULT '*' COMMENT '索引',
  `price` decimal(10,0) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text COMMENT '内容',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶:1是 0否',
  `is_rec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐：1是 0否',
  `status` tinyint(2) NOT NULL COMMENT '状态,1:发布,0:不发布',
  `more` text COMMENT '扩展',
  `path` varchar(255) NOT NULL COMMENT '分类层级关系路径',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  `seo_title` varchar(100) NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx1` (`parent_id`),
  KEY `idx2` (`brand_id`),
  KEY `idx3` (`model_id`),
  KEY `idx4` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COMMENT='品牌表';

-- ----------------------------
-- Records of cmf_usual_series
-- ----------------------------
INSERT INTO `cmf_usual_series` VALUES ('1', '0', '2', '0', '0', '一汽-大众', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-1', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('2', '1', '2', '0', '0', 'CC', '', '', '*', '0', '0', '0', '0', '0', '', '1', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-1-2', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('3', '0', '4', '0', '0', '长安福特', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-3', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('4', '0', '4', '0', '0', '江铃福特', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-4', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('5', '0', '4', '0', '0', '福特（进口）', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-5', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('6', '0', '2', '0', '0', '上汽大众', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-6', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('7', '0', '2', '0', '0', '大众（进口）', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-7', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('8', '1', '2', '0', '0', '宝来', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-1-8', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('9', '6', '2', '0', '0', 'POLO', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-6-9', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('10', '3', '4', '0', '0', 'S-MAX', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-3-10', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('11', '3', '4', '0', '0', '嘉年华', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-3-11', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('12', '3', '4', '0', '0', '福克斯', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-3-12', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('13', '4', '4', '0', '0', '全顺', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-4-13', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('14', '5', '4', '0', '0', '野马', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-5-14', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('15', '7', '2', '0', '0', '甲壳虫', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-7-15', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('16', '0', '1', '0', '0', '华晨宝马', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-16', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('17', '16', '1', '0', '0', '1系', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-16-17', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('18', '16', '1', '0', '0', '2系', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-16-18', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('19', '16', '1', '0', '0', '3系', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-16-19', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('20', '16', '1', '0', '0', '5系', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '{\"thumbnail\":\"\"}', '0-16-20', '10000', '', '', '');
INSERT INTO `cmf_usual_series` VALUES ('21', '16', '1', '0', '0', 'X1', '', '', '*', '0', '0', '0', '0', '0', '', '', '', '0', '1', '0', '{\"thumbnail\":\"\"}', '0-16-21', '10000', '', '', '');

-- ----------------------------
-- Table structure for cmf_verification_code
-- ----------------------------
DROP TABLE IF EXISTS `cmf_verification_code`;
CREATE TABLE `cmf_verification_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当天已经发送成功的次数',
  `send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后发送成功时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证码过期时间',
  `code` varchar(8) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '最后发送成功的验证码',
  `account` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '手机号或者邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='手机邮箱数字验证码表';

-- ----------------------------
-- Records of cmf_verification_code
-- ----------------------------

-- ----------------------------
-- Table structure for cmf_verify
-- ----------------------------
DROP TABLE IF EXISTS `cmf_verify`;
CREATE TABLE `cmf_verify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '认证用户ID',
  `deal_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `auth_code` char(20) NOT NULL DEFAULT '' COMMENT '认证项目code，注意这里没有根据ID来做',
  `auth_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '认证次数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `more` text COMMENT '扩展数据：认证数据',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶：0否 1是',
  `auth_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证状态：-1禁止认证 0未认证 1已认证 2取消 3认证失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_verify
-- ----------------------------
INSERT INTO `cmf_verify` VALUES ('1', '3', '0', 'mobile', '0', '1511768040', '1512768040', '{\"mobile\":\"133654987\",\"email\":\"\",\"identity_card\":\"\",\"driving_license\":\"\",\"real_name\":\"\",\"gender\":\"\",\"birthday\":\"\",\"telephone\":\"\",\"alipay\":\"\",\"weixin\":\"\",\"ID_Type\":\"\",\"ID_No\":\"\",\"booklet\":\"\",\"house_certificate\":\"\",\"marriage_lines\":\"\",\"birthcity\":\"\",\"residecity\":\"\",\"diploma\":\"\",\"graduateschool\":\"\",\"education\":\"\",\"business_license\":\"\",\"work_occupation\":\"\",\"work_company\":\"\",\"work_position\":\"\",\"work_experience\":\"\"}', '0', '0');

-- ----------------------------
-- Table structure for cmf_verify_model
-- ----------------------------
DROP TABLE IF EXISTS `cmf_verify_model`;
CREATE TABLE `cmf_verify_model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `deal_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '认证项目名称',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '认证项目code',
  `more` text COMMENT '扩展数据：选择相关认证内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：0关闭 1开启',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序：从小到大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cmf_verify_model
-- ----------------------------
INSERT INTO `cmf_verify_model` VALUES ('1', '0', '手机认证', 'mobile', '{\"thumbnail\":\"\",\"mobile\":\"mobile\"}', '1', '10');
INSERT INTO `cmf_verify_model` VALUES ('2', '0', '邮箱认证', 'email', '{\"thumbnail\":\"\",\"email\":\"email\"}', '1', '20');
INSERT INTO `cmf_verify_model` VALUES ('3', '0', '实名认证', 'certification', '{\"thumbnail\":\"\",\"identity_card\":\"identity_card\",\"real_name\":\"real_name\"}', '1', '30');
INSERT INTO `cmf_verify_model` VALUES ('4', '0', '企业资格认证', 'enterprise', '{\"thumbnail\":\"\",\"business_license\":\"business_license\",\"work_company\":\"work_company\"}', '1', '40');
