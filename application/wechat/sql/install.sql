-- -----------------------------
-- 导出时间 `2017-04-15 15:42:35`
-- -----------------------------

-- -----------------------------
-- 表结构 `dp_we_material`
-- -----------------------------
DROP TABLE IF EXISTS `dp_we_material`;
CREATE TABLE `dp_we_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT '素材名',
  `type` varchar(50) NOT NULL COMMENT '素材类型',
  `attachment_id` int(10) unsigned DEFAULT NULL COMMENT '本地附件ID',
  `url` varchar(250) DEFAULT NULL COMMENT '图片素材url',
  `content` longtext COMMENT '素材内容',
  `media_id` varchar(100) NOT NULL COMMENT '素材id',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信素材表';


-- -----------------------------
-- 表结构 `dp_we_reply`
-- -----------------------------
DROP TABLE IF EXISTS `dp_we_reply`;
CREATE TABLE `dp_we_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `keyword` varchar(150) DEFAULT NULL COMMENT '关键词',
  `mode` tinyint(1) DEFAULT NULL COMMENT '匹配模式 1:完整匹配 2:模糊搜索',
  `type` varchar(50) NOT NULL COMMENT '回复类型',
  `msg_type` varchar(50) NOT NULL COMMENT '触发方式',
  `content` text NOT NULL COMMENT '回复内容',
  `expires_date` int(10) unsigned NOT NULL COMMENT '过期日期',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 0:无效 1:有效',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信自动回复';

