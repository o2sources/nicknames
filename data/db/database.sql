CREATE TABLE `category` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `nickname` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) character set latin1 NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;