CREATE TABLE IF NOT EXISTS `#__podcast_assets` (
  `podcast_asset_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `asset_enclosure_url` varchar(500) NOT NULL,
  `asset_enclosure_length` varchar(31) NOT NULL,
  `asset_enclosure_type` varchar(255) NOT NULL,
  `asset_duration` varchar(31) NOT NULL,
  `asset_closed_caption` int(1) NOT NULL DEFAULT '0',
  `storage_engine` varchar(30) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`podcast_asset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__podcast_assets_map` (
  `podcast_asset_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `default` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__podcast_episodes` (
  `episode_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) DEFAULT NULL,
  `episode_title` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `episode_author` varchar(255) DEFAULT NULL,
  `episode_subtitle` varchar(255) DEFAULT NULL,
  `episode_summary` text,
  `episode_guid` varchar(255) DEFAULT NULL,
  `episode_pubDate` date DEFAULT NULL,
  `episode_keywords` varchar(255) DEFAULT NULL,
  `episode_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `episode_image` varchar(511) DEFAULT NULL,
  `episode_block` tinyint(1) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`episode_id`),
  KEY `feed_id` (`feed_id`),
  KEY `episode_alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__podcast_feeds` (
  `feed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed_default` tinyint(1) DEFAULT '0',
  `feed_title` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `feed_link` varchar(255) DEFAULT NULL,
  `feed_language` varchar(255) DEFAULT NULL,
  `feed_copyright` varchar(255) DEFAULT NULL,
  `feed_subtitle` varchar(255) DEFAULT NULL,
  `feed_author` varchar(255) DEFAULT NULL,
  `feed_block` tinyint(1) DEFAULT '0',
  `feed_explicit` tinyint(1) DEFAULT '0',
  `feed_keywords` varchar(255) DEFAULT NULL,
  `feed_summary` text,
  `feed_owner_name` varchar(255) DEFAULT NULL,
  `feed_owner_email` varchar(255) DEFAULT NULL,
  `feed_image` varchar(511) DEFAULT NULL,
  `feed_category1` varchar(255) DEFAULT NULL,
  `feed_category2` varchar(255) DEFAULT NULL,
  `feed_category3` varchar(255) DEFAULT NULL,
  `feed_new_feed_url` varchar(511) DEFAULT NULL,
  `feed_complete` tinyint(1) DEFAULT '0',
  `feed_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`feed_id`),
	KEY `alias` (`alias`)
);