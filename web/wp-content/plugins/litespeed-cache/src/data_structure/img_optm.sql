  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `optm_status` tinyint(4) NOT NULL DEFAULT '0',
  `src` text NOT NULL,
  `src_filesize` int(11) NOT NULL DEFAULT '0',
  `target_filesize` int(11) NOT NULL DEFAULT '0',
  `webp_filesize` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `optm_status` (`optm_status`)
