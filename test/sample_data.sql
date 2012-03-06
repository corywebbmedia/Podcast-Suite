CREATE TABLE IF NOT EXISTS `#__podcast_assets` (
  `podcast_asset_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `asset_enclosure_url` varchar(500) NOT NULL,
  `asset_enclosure_length` varchar(31) NOT NULL,
  `asset_enclosure_type` varchar(255) NOT NULL,
  `asset_duration` varchar(31) NOT NULL,
  `asset_closed_caption` int(1) NOT NULL DEFAULT '0',
  `storage_engine` varchar(20) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`podcast_asset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `#__podcast_assets` (`podcast_asset_id`, `asset_enclosure_url`, `asset_enclosure_length`, `asset_enclosure_type`, `asset_duration`, `asset_closed_caption`, `storage_engine`, `enabled`) VALUES
(1, '/media/podcasts/french_lesson_1.mp3', '15722706', 'audio/mpeg', '32:45', 0, 'local', 1),
(2, '/media/podcasts/french_lesson_2.mp3', '14506027', 'audio/mpeg', '30:13', 0, 'local', 1),
(3, '/media/podcasts/french_lesson_3.mp3', '11678533', 'audio/mpeg', '24:19', 0, 'local', 1),
(4, '/media/podcasts/french_lesson_4.mp3', '14580006', 'audio/mpeg', '30:22', 0, 'local', 1),
(5, '/media/podcasts/french_lesson_5.mp3', '17880420', 'audio/mpeg', '37:15', 0, 'local', 1),
(6, '/media/podcasts/german_lesson_1.mp3', '15238918', 'audio/mpeg', '31:44', 0, 'local', 1),
(7, '/media/podcasts/german_lesson_2.mp3', '13769583', 'audio/mpeg', '28:41', 0, 'local', 1),
(8, '/media/podcasts/german_lesson_3.mp3', '15208198', 'audio/mpeg', '31:41', 0, 'local', 1);

CREATE TABLE IF NOT EXISTS `#__podcast_assets_map` (
  `podcast_asset_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `default` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__podcast_assets_map` (`podcast_asset_id`, `episode_id`, `default`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(2, 1, 0),
(3, 2, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

INSERT INTO `#__podcast_episodes` (`episode_id`, `feed_id`, `episode_title`, `alias`, `episode_author`, `episode_subtitle`, `episode_summary`, `episode_guid`, `episode_pubDate`, `episode_keywords`, `episode_created`, `episode_image`, `episode_block`, `published`) VALUES
(1, 1, 'Submission // Uncommon Disciplines', 'submission-uncommon-disciplines', 'Drew Greenway', 'Drew Greenway''s Album', '11.06.11 Brady Herbert preaching "Submission," from our series "Uncommon Disciplines."', '9f819489cdc7ed3c1d1d8f46a9b6bc623e293b81', '2011-11-06', NULL, '2012-01-26 21:26:00', '', 0, 1),
(2, 1, 'Simplicity // Uncommon Disciplines', 'simplicity-uncommon-disciplines', 'Drew Greenway', 'Drew Greenway''s Album', '11.13.11 Brady Herbert preaching "Simplicity," the last sermon from our series "Uncommon Disciplines."', '4d997dc8d6dd74854460c3ae6d7f4bb2e8f1d25c', '2011-11-13', NULL, '2012-01-26 21:27:06', '', 0, 1),
(3, 1, 'Giving Up to Gain More', 'giving-up-to-gain-more', 'Drew Greenway', 'Drew Greenway''s Album', '11.20.11 Landon Collins preaching the standalone message "Giving Up to Gain More."', 'b5c731c9ef9461a645b97e77f9070319d3cdd675', '2011-11-20', NULL, '2012-01-26 21:27:14', '', 0, 1),
(4, 1, 'The Scandal of God''s Family Tree // The Scandal of Christmas', 'the-scandal-of-gods-family-tree-the-scandal-of-christmas', 'Drew Greenway', 'Drew Greenway''s Album', '11.27.11 Brady Herbert preaching "The Scandal of God''s Family Tree," from our advent series "The Scandal of Christmas."', '8b5e52a68560586d5878a0c800495f217ba1f926', '2011-11-27', NULL, '2012-01-26 21:27:21', '', 0, 1),
(5, 2, 'The Scandal of a Teenage Mom // The Scandal of Christmas', 'the-scandal-of-a-teenage-mom-the-scandal-of-christmas', 'Drew Greenway', 'Drew Greenway''s Album', '12.04.11 Brady Herbert preaching "The Scandal of a Teenage Mom," from our series "The Scandal of Christmas."\r\n', '2404d459143b091cd07c93a36ee714b053135611', '2011-12-04', NULL, '2012-01-26 21:32:38', '', 0, 1),
(6, 2, 'The Scandal of an Unlikely King // The Scandal of Christmas', 'the-scandal-of-an-unlikely-king-the-scandal-of-christmas', 'Drew Greenway', 'Drew Greenway''s Album', '12.11.11 Brady Herbert preaching "The Scandal of an Unlikely King," from our series "The Scandal of Christmas."\r\n', 'adc24a182e394925f9d571f9e741c9041011ea1c', '2011-12-11', NULL, '2012-01-26 21:32:47', '', 0, 1),
(7, 2, 'The Scandal of the Magi // The Scandal of Christmas', 'the-scandal-of-the-magi-the-scandal-of-christmas', 'Drew Greenway', 'Drew Greenway''s Album', '12.18.11 Brady Herbert preaching "The Scandal of the Magi," from our series "The Scandal of Christmas."', '25242821e8f4a8ea4f18a6f4276b78912d559d02', '2011-12-18', NULL, '2012-01-26 21:33:00', '', 0, 1),
(8, 2, 'The Scandal of the Incarnation // The Scandal of Christmas', '12-24-11', 'Drew Greenway', 'Drew Greenway''s Album', '12.24.11 Brady Herbert preaching "The Scandal of the Incarnation," from our series "The Scandal of Christmas."', '6dbc235455c7ddcf2a0fd2135d930f61668caf2c', '2011-12-24', NULL, '2012-01-26 21:33:07', '', 0, 1);

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
  `feed_complete` tinyint(1) unsigned DEFAULT '0',
  `feed_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`feed_id`),
  KEY `feed_alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `#__podcast_feeds` (`feed_id`, `feed_default`, `feed_title`, `alias`, `feed_link`, `feed_language`, `feed_copyright`, `feed_subtitle`, `feed_author`, `feed_block`, `feed_explicit`, `feed_keywords`, `feed_summary`, `feed_owner_name`, `feed_owner_email`, `feed_image`, `feed_category1`, `feed_category2`, `feed_category3`, `feed_new_feed_url`, `feed_complete`, `feed_created`, `published`) VALUES
(1, 1, 'Harris Creek Baptist Church - November', 'november', 'http://www.harriscreek.org', 'en-GB', '(c) 2011, Harris Creek Baptist Church', 'Weekly Sermons from Harris Creek Baptist Church', 'Harris Creek Baptist Church', 0, 0, 'church, sermon, baptist, harris creek', 'Harris Creek Baptist Church Podcast', 'Drew Greenway', 'dgreenway@harriscreek.org', 'http://www.harriscreek.org/images/logo-podcast.jpg', 'Religion & Spirituality > Christianity', 'Religion & Spirituality', 'Society & Culture', NULL, 0, '2012-01-26 20:42:53', 1),
(2, 0, 'Harris Creek Baptist Church - December', 'december', 'http://www.harriscreek.org', 'en-GB', '(c) 2011, Harris Creek Baptist Church', 'Weekly Sermons from Harris Creek Baptist Church', 'Harris Creek Baptist Church', 0, 0, 'church, sermon, baptist, harris creek', 'Harris Creek Baptist Church Podcast', 'Drew Greenway', 'dgreenway@harriscreek.org', 'http://www.harriscreek.org/images/logo-podcast.jpg', 'Religion & Spirituality > Christianity', 'Religion & Spirituality', 'Society & Culture', NULL, 0, '2012-01-26 20:42:53', 1);
