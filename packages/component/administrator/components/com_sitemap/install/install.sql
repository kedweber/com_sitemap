CREATE TABLE IF NOT EXISTS `#__sitemap_configs` (
  `sitemap_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `package` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `config` TEXT,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` bigint(20) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sitemap_config_id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `option` (`package`,`name`)
) DEFAULT CHARSET=utf8;