-- -----------------------------
-- 导出时间 `2017-05-29 10:38:01`
-- -----------------------------

-- -----------------------------
-- 表结构 `dp_dev_database_sql`
-- -----------------------------
DROP TABLE IF EXISTS `dp_dev_database_sql`;
CREATE TABLE `dp_dev_database_sql` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `sql_` varchar(250) DEFAULT NULL,
  `create_time` char(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

