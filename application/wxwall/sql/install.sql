/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.7.14 : Database - dolphin
*********************************************************************
*/


DROP TABLE IF EXISTS `dp_wxwall_barrage`;

CREATE TABLE `dp_wxwall_barrage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `wechat_id` varchar(255) NOT NULL COMMENT '微信ID',
  `content` varchar(255) DEFAULT NULL COMMENT '弹幕内容',
  `create_time` int(20) NOT NULL COMMENT '发送时间',
  `flash_time` int(20) DEFAULT NULL COMMENT '当时幻灯播放点',
  `order_id` int(50) NOT NULL COMMENT '订单ID',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_barrage` */

/*Table structure for table `dp_wxwall_music` */

DROP TABLE IF EXISTS `dp_wxwall_music`;

CREATE TABLE `dp_wxwall_music` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(200) NOT NULL COMMENT '音频名称',
  `path` varchar(200) NOT NULL COMMENT '保存路径',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  `order_id` int(50) NOT NULL COMMENT '订单ID',
  `size` int(11) NOT NULL COMMENT '音频大小',
  `type` char(50) DEFAULT NULL COMMENT '音频类型',
  `create_time` int(50) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_music` */

/*Table structure for table `dp_wxwall_order` */

DROP TABLE IF EXISTS `dp_wxwall_order`;

CREATE TABLE `dp_wxwall_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  `groom` varchar(50) NOT NULL COMMENT '新郎姓名',
  `bride` varchar(50) NOT NULL COMMENT '新娘姓名',
  `package_price` int(11) NOT NULL COMMENT '订单总价',
  `game_terms` varchar(200) NOT NULL COMMENT '订单包含游戏类目',
  `lnteraction_terms` varchar(200) NOT NULL COMMENT '订单包含互动类目',
  `view_terms` varchar(200) NOT NULL COMMENT '订单包含展示类目',
  `wedding_date` int(20) NOT NULL COMMENT '婚礼时间',
  `order_number` int(50) NOT NULL COMMENT '订单号',
  `pay_status` int(1) NOT NULL DEFAULT '0' COMMENT '支付状态[0:未支付，1:已支付]',
  `pay_type` int(1) NOT NULL DEFAULT '0' COMMENT '支付类型[0:支付宝，1:微信，2:京东钱包]',
  `created_time` int(20) NOT NULL COMMENT '下单时间',
  `pay_time` int(20) DEFAULT NULL COMMENT '支付时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_order` */

/*Table structure for table `dp_wxwall_order_config` */

DROP TABLE IF EXISTS `dp_wxwall_order_config`;

CREATE TABLE `dp_wxwall_order_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  `order_id` int(50) NOT NULL COMMENT '订单ID',
  `config` text NOT NULL COMMENT '配置内容（json）',
  `create_time` int(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_order_config` */

/*Table structure for table `dp_wxwall_photo` */

DROP TABLE IF EXISTS `dp_wxwall_photo`;

CREATE TABLE `dp_wxwall_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(200) NOT NULL COMMENT '图片名称',
  `path` varchar(200) NOT NULL COMMENT '保存路径',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  `order_id` int(50) NOT NULL COMMENT '订单ID',
  `size` int(11) NOT NULL COMMENT '图片大小',
  `type` char(50) DEFAULT NULL COMMENT '图片类型',
  `create_time` int(50) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_photo` */

/*Table structure for table `dp_wxwall_video` */

DROP TABLE IF EXISTS `dp_wxwall_video`;

CREATE TABLE `dp_wxwall_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(200) NOT NULL COMMENT '视频名称',
  `path` varchar(200) NOT NULL COMMENT '保存路径',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  `order_id` int(50) NOT NULL COMMENT '订单ID',
  `size` int(11) NOT NULL COMMENT '视频大小',
  `type` char(50) DEFAULT NULL COMMENT '视频类型',
  `create_time` int(50) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_video` */

/*Table structure for table `dp_wxwall_wechat_user` */

DROP TABLE IF EXISTS `dp_wxwall_wechat_user`;

CREATE TABLE `dp_wxwall_wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `wechat_id` varchar(255) NOT NULL COMMENT '微信ID',
  `wechat_name` varchar(100) NOT NULL COMMENT '微信昵称',
  `wechat_avatar` varchar(255) NOT NULL COMMENT '微信头像URL',
  `user_id` int(11) NOT NULL COMMENT '用户UID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `dp_wxwall_wechat_user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
