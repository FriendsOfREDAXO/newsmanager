/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  georg
 * Created: 20.09.2017
 */

CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%newsmanager` (
    `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `id` int(10) unsigned NOT NULL,
    `status` tinyint(1) DEFAULT '0',
    `newsmanager_category_id` varchar(255) DEFAULT NULL,
    `title` varchar(255) NOT NULL DEFAULT '',
    `subtitle` varchar(255) NOT NULL DEFAULT '',
    `richtext` text,
    `images` text,
    `seo_description` varchar(255) NOT NULL DEFAULT '',
    `seo_canonical` varchar(255) DEFAULT NULL,
    `clang_id` int(10) DEFAULT NULL,
    `author` varchar(255) NOT NULL,
    `createuser` varchar(255) NOT NULL,
    `createdate` datetime NOT NULL,
    `updateuser` varchar(255) NOT NULL,
    `updatedate` datetime NOT NULL,
    PRIMARY KEY  (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%newsmanager_categories` (
    `pid` int(10) unsigned NOT NULL auto_increment,
    `id` int(10) unsigned NOT NULL,
    `name` varchar(255) default NULL,
    `clang_id` int(10),
    `createuser` varchar(255) NOT NULL,
    `createdate` datetime NOT NULL,
    `updateuser` varchar(255) NOT NULL,
    `updatedate` datetime NOT NULL,
    PRIMARY KEY  (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
