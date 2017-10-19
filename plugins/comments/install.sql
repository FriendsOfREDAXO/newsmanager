CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%newsmanager_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `re_article_pid` int(10) unsigned DEFAULT NULL,
  `comment` text,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;