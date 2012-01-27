DROP TABLE IF EXISTS `#__podcast_feeds`;

CREATE TABLE `#__podcast_feeds` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__podcast_feeds` (`feed_id`, `feed_default`, `feed_title`, `alias`, `feed_link`, `feed_language`, `feed_copyright`, `feed_subtitle`, `feed_author`, `feed_block`, `feed_explicit`, `feed_keywords`, `feed_summary`, `feed_owner_name`, `feed_owner_email`, `feed_image`, `feed_category1`, `feed_category2`, `feed_category3`, `feed_new_feed_url`, `feed_complete`, `feed_created`, `published`)
VALUES
	(1,1,'Harris Creek Baptist Church - November','november','http://www.harriscreek.org','en-GB','(c) 2011, Harris Creek Baptist Church','Weekly Sermons from Harris Creek Baptist Church','Harris Creek Baptist Church',0,0,'church, sermon, baptist, harris creek','Harris Creek Baptist Church Podcast','Drew Greenway','dgreenway@harriscreek.org','http://www.harriscreek.org/images/logo-podcast.jpg','Religion & Spirituality > Christianity','Religion & Spirituality','Society & Culture',NULL,0,'2012-01-26 14:42:53',1),
	(2,0,'Harris Creek Baptist Church - December','december','http://www.harriscreek.org','en-GB','(c) 2011, Harris Creek Baptist Church','Weekly Sermons from Harris Creek Baptist Church','Harris Creek Baptist Church',0,0,'church, sermon, baptist, harris creek','Harris Creek Baptist Church Podcast','Drew Greenway','dgreenway@harriscreek.org','http://www.harriscreek.org/images/logo-podcast.jpg','Religion & Spirituality > Christianity','Religion & Spirituality','Society & Culture',NULL,0,'2012-01-26 14:42:53',1);

DROP TABLE IF EXISTS `#__podcast_media`;

CREATE TABLE `#__podcast_media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `item_author` varchar(255) DEFAULT NULL,
  `item_subtitle` varchar(255) DEFAULT NULL,
  `item_summary` text,
  `item_enclosure_url` varchar(511) DEFAULT NULL,
  `item_enclosure_length` varchar(31) DEFAULT NULL,
  `item_enclosure_type` varchar(255) DEFAULT NULL,
  `item_guid` varchar(255) DEFAULT NULL,
  `item_pubDate` date DEFAULT NULL,
  `item_duration` varchar(31) DEFAULT NULL,
  `item_keywords` varchar(255) DEFAULT NULL,
  `item_isClosedCaptioned` tinyint(1) unsigned zerofill DEFAULT '0',
  `item_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `item_image` varchar(511) DEFAULT NULL,
  `item_block` tinyint(1) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`media_id`),
  KEY `feed_id` (`feed_id`),
  KEY `item_alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__podcast_media` (`media_id`, `feed_id`, `item_title`, `alias`, `item_author`, `item_subtitle`, `item_summary`, `item_enclosure_url`, `item_enclosure_length`, `item_enclosure_type`, `item_guid`, `item_pubDate`, `item_duration`, `item_keywords`, `item_isClosedCaptioned`, `item_created`, `item_image`, `item_block`, `published`)
VALUES
	(1,1,'Submission // Uncommon Disciplines','submission-uncommon-disciplines','Drew Greenway','Drew Greenway\'s Album','11.06.11 Brady Herbert preaching \"Submission,\" from our series \"Uncommon Disciplines.\"','media/podcasts/11-6-11.mp3','15722706','audio/mpeg','9f819489cdc7ed3c1d1d8f46a9b6bc623e293b81','2011-11-06','32:45',NULL,0,'2012-01-26 15:26:00','',0,1),
	(2,1,'Simplicity // Uncommon Disciplines','simplicity-uncommon-disciplines','Drew Greenway','Drew Greenway\'s Album','11.13.11 Brady Herbert preaching \"Simplicity,\" the last sermon from our series \"Uncommon Disciplines.\"','media/podcasts/11-13-11.mp3','14506027','audio/mpeg','4d997dc8d6dd74854460c3ae6d7f4bb2e8f1d25c','2011-11-13','30:13',NULL,0,'2012-01-26 15:27:06','',0,1),
	(3,1,'Giving Up to Gain More','giving-up-to-gain-more','Drew Greenway','Drew Greenway\'s Album','11.20.11 Landon Collins preaching the standalone message \"Giving Up to Gain More.\"','media/podcasts/11-20-11.mp3','11678533','audio/mpeg','b5c731c9ef9461a645b97e77f9070319d3cdd675','2011-11-20','24:19',NULL,0,'2012-01-26 15:27:14','',0,1),
	(4,1,'The Scandal of God\'s Family Tree // The Scandal of Christmas','the-scandal-of-gods-family-tree-the-scandal-of-christmas','Drew Greenway','Drew Greenway\'s Album','11.27.11 Brady Herbert preaching \"The Scandal of God\'s Family Tree,\" from our advent series \"The Scandal of Christmas.\"','media/podcasts/11-27-11.mp3','14580006','audio/mpeg','8b5e52a68560586d5878a0c800495f217ba1f926','2011-11-27','30:22',NULL,0,'2012-01-26 15:27:21','',0,1),
	(5,2,'The Scandal of a Teenage Mom // The Scandal of Christmas','the-scandal-of-a-teenage-mom-the-scandal-of-christmas','Drew Greenway','Drew Greenway\'s Album','12.04.11 Brady Herbert preaching \"The Scandal of a Teenage Mom,\" from our series \"The Scandal of Christmas.\"\r\n','media/podcasts/12-4-11.mp3','17880420','audio/mpeg','2404d459143b091cd07c93a36ee714b053135611','2011-12-04','37:15',NULL,0,'2012-01-26 15:32:38','',0,1),
	(6,2,'The Scandal of an Unlikely King // The Scandal of Christmas','the-scandal-of-an-unlikely-king-the-scandal-of-christmas','Drew Greenway','Drew Greenway\'s Album','12.11.11 Brady Herbert preaching \"The Scandal of an Unlikely King,\" from our series \"The Scandal of Christmas.\"\r\n','media/podcasts/12-11-11.mp3','15238918','audio/mpeg','adc24a182e394925f9d571f9e741c9041011ea1c','2011-12-11','31:44',NULL,0,'2012-01-26 15:32:47','',0,1),
	(7,2,'The Scandal of the Magi // The Scandal of Christmas','the-scandal-of-the-magi-the-scandal-of-christmas','Drew Greenway','Drew Greenway\'s Album','12.18.11 Brady Herbert preaching \"The Scandal of the Magi,\" from our series \"The Scandal of Christmas.\"','media/podcasts/12-18-11.mp3','13769583','audio/mpeg','25242821e8f4a8ea4f18a6f4276b78912d559d02','2011-12-18','28:41',NULL,0,'2012-01-26 15:33:00','',0,1),
	(8,2,'The Scandal of the Incarnation // The Scandal of Christmas','12-24-11','Drew Greenway','Drew Greenway\'s Album','12.24.11 Brady Herbert preaching \"The Scandal of the Incarnation,\" from our series \"The Scandal of Christmas.\"','media/podcasts/12-24-11.mp3','15208198','audio/mpeg','6dbc235455c7ddcf2a0fd2135d930f61668caf2c','2011-12-24','31:41',NULL,0,'2012-01-26 15:33:07','',0,1);
