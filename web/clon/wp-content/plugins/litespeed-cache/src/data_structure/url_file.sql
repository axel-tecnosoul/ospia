`id` bigint(20) NOT NULL AUTO_INCREMENT,
`url_id` bigint(20) NOT NULL,
`vary` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'md5 of final vary',
`filename` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'md5 of file content',
`type` tinyint(4) NOT NULL COMMENT 'css=1,js=2,ccss=3,ucss=4',
`mobile` tinyint(4) NOT NULL COMMENT 'mobile=1',
`webp` tinyint(4) NOT NULL COMMENT 'webp=1',
`expired` int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`),
KEY `filename` (`filename`),
KEY `type` (`type`),
KEY `url_id_2` (`url_id`,`vary`,`type`),
KEY `filename_2` (`filename`,`expired`),
KEY `url_id` (`url_id`,`expired`)
