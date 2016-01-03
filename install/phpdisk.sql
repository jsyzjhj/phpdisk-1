-- PHPDisk SQL Dump
-- http://www.phpdisk.com/
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `phpdisk`
--

-- --------------------------------------------------------

--
-- 表的结构 `pd_adminsession`
--

DROP TABLE IF EXISTS `pd_adminsession`;
CREATE TABLE IF NOT EXISTS `pd_adminsession` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `login_time` int(10) unsigned NOT NULL default '0',
  `hashcode` char(9) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_adminsession`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_advertisements`
--

DROP TABLE IF EXISTS `pd_advertisements`;
CREATE TABLE IF NOT EXISTS `pd_advertisements` (
  `advid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `adv_type` varchar(30) NOT NULL,
  `adv_position` varchar(50) NOT NULL,
  `params` text NOT NULL,
  `code` text NOT NULL,
  `show_order` tinyint(3) unsigned NOT NULL default '0',
  `starttime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`advid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_advertisements`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_announces`
--

DROP TABLE IF EXISTS `pd_announces`;
CREATE TABLE IF NOT EXISTS `pd_announces` (
  `annid` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `show_order` tinyint(1) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  `is_expand` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`annid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 导出表中的数据 `pd_announces`
--

INSERT INTO `pd_announces` (`annid`, `userid`, `subject`, `content`, `show_order`, `is_hidden`, `is_expand`, `in_time`) VALUES
(2, 1, 'PHPDISK v5.1 新增功能与修正列表', '[新增]分布式服务器管理员可自行添加ID作为FTP与文件的对应标识。<br>[新增]公共文件,缩短地址，网盘文件的直接显示外链地址。<br>[新增]如果是共享文件/公共文件，点击后有下载页面，私人文件直接下载。<br>[新增]文件管理添加目录显示。<br>[新增]充值选项，自动转化为积分。<br>[新增]MYSQL数据库类提交错误时，输入email，处理完发邮件通知用户。<br>[修正]整合，在linux下无法整合UC，通信不成功问题。<br>[修正]GBK上传添加描述、标签出现乱码问题。<br>[修正]Mysql类出错时在linux主机下的目录问题。<br>[修正]只能设置为共享的文件才能使用提取码功能。<br>[修正]使用代码广告会令页面不断跳转。', 0, 0, 1, 1286171569),
(3, 1, 'PHPDISK v5.3.0新增功能与改进', '[新增]支持PHPWIND论坛整合。<br>[新增]新增几种广告管理，让管理员更好的投放广告。<br>[新增]支持常用的文件在线浏览，如mp3播放，flash播放等支持。<br>[新增]PHPDISK可实现在线检测自动升级，比起传统手动升级更加便捷。<br>[新增]标题排序，用户可以直接点击表头，对网盘中的文件进行排序，如，按大小、按日期等。<br>[新增]引入用户经验等级模式，用户使用网盘，帐号会自动升级。<br>[新增]增加首页幻灯片展示效果，可以让网盘更具个性效果。<br>[新增]用户充值方式支持使用网银接口与易宝支付接口。<br>[修正]公告模式的改进，阅读、显示更加人性化。<br>[修正]改进结构系统布局UI，引入更华丽的ajax效果，大大提升用户交互体验。<br>[修正]在生成外链的[img]代码直接变成&lt;IMG src=""&gt;  代码，多一种模式的显示。<br>[修正]修正UCenter整合时出现用户重复记录问题。<br>[修正]修正搜索引擎直接收录文件问题，而不能通过文件展示页下载的问题。<br>[修正]分布服务器插件，可支持子程序配置，同时可支持FTP中转上传与子程序直接上传的形式。大大减少主服务器资源消耗。<br>[修正]外链，提取码等可由管理员设定，后台使用了大部分的开关形式。<br>[修正]SEO插件nginx修正。<br>[修正]移动文件到二级公共文件时文件无法显示问题。<br>[修正]管理员后台更加精细的分类。<br>[修正]修正公共文件显示文件空间不正确问题。', 0, 0, 0, 1288057490),
(4, 1, 'PHPDisk v5.5.0 新增功能与改进说明', '[增加]添加一键设置所有文件共享。<br>[增加]后台搜索缓存管理。<br>[增加]语言包在线切换功能。<br>[增加]文件替换功能，替换后原文件地址不变，适合做永久链接。<br>[增加]模板SQL 标签{sql[xxx][$v]}{/sql}调用，用户可以通过修改模板，实现对数据库进行个性化的调用。<br>[增加]JS数据调用。<br>[增加]数组调用。<br>[增加]分享工具功能，用户可以通过工具将网盘上的文件资源分享到其他的网站中。<br>[增加]添加后台sitemap功能，管理员可以更快捷定位到管理功能。<br>[增加]添加后台快捷操作面板，整合了后台配置面板，管理员可定义自己常用快捷功能。<br>[优化]优化精简程序核心架构代码，系统运行更快更稳定。<br>[优化]优化下载出现“外链未开启提示”。<br>[优化]将大部分常用的插件集成到系统后台，免去反复安装的麻烦。<br>[修正]分布式服务器出现显示乱码问题。<br>[修正]部分接口无法进行充值转换问题。<br>[修正]充值接口空白问题。<br>[修正]文件浏览页标题，附加上网站标题，方便SEO。<br>[改进]下载提示，更加友好显示文件下载。', 0, 0, 0, 1301419754),
(5, 1, 'PHPDisk 6.5.0 V-Core系列', '1、引入国际化语言包功能(po , mo)，让系统维护语言包更简洁，进一步向国际化的方向跨进。<br>2、为了兼容所有的浏览器，系统全面放弃iframe 框架结构。<br>3、系统上多处页面上的细节改动，更加合理地布局。<br>4、进一步改进缓存及程序架构底层，速度运营更稳定更快速。<br>5、同一套内核将会针对不同的方向及领域，专业化的方向发展。<br>6、v-core首先将推出FMS(File Manage System) 文件管理系统方向，站长可以将此做成WEB2.0模式的下载站，而内容可以由网站的用户上传。<br>7、公共文件部分的改进，激发此部分的效能。<br>
8、可自定配置网站后台的管理员入口，增加网站管理员安全。', 0, 0, 0, 1338516732),
(6, 1, 'PHPDisk 6.8.0 V-Core系列', '新增客户端支持<br>改进分布服务配置<br>修正现有版本存在的BUG<br>优化程序架构<br>改进缓存体系，修正共享文件无法操作', 0, 0, 0, 1357737649);

-- --------------------------------------------------------

--
-- 表的结构 `pd_buddys`
--

DROP TABLE IF EXISTS `pd_buddys`;
CREATE TABLE IF NOT EXISTS `pd_buddys` (
  `bdid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `touserid` int(10) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bdid`),
  KEY `userid` (`userid`),
  KEY `touserid` (`touserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_buddys`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_categories`
--

DROP TABLE IF EXISTS `pd_categories`;
CREATE TABLE IF NOT EXISTS `pd_categories` (
  `cate_id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `cate_name` varchar(50) NOT NULL,
  `cate_size` int(10) unsigned NOT NULL default '0',
  `show_order` tinyint(3) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_categories`
--

-- --------------------------------------------------------

--
-- 表的结构 `pd_comments`
--

DROP TABLE IF EXISTS `pd_comments`;
CREATE TABLE IF NOT EXISTS `pd_comments` (
  `cmt_id` int(10) unsigned NOT NULL auto_increment,
  `file_id` bigint(20) unsigned NOT NULL default '0',
  `file_key` char(8) NOT NULL,
  `content` text NOT NULL,
  `userid` int(10) unsigned NOT NULL default '0',
  `is_checked` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`cmt_id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_comments`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_cp_shortcut`
--

DROP TABLE IF EXISTS `pd_cp_shortcut`;
CREATE TABLE IF NOT EXISTS `pd_cp_shortcut` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_cp_shortcut`
--



-- --------------------------------------------------------

--
-- 表的结构 `pd_disk2user`
--

DROP TABLE IF EXISTS `pd_disk2user`;
CREATE TABLE IF NOT EXISTS `pd_disk2user` (
  `duid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `disk_id` mediumint(8) unsigned NOT NULL default '0',
  `starttime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`duid`),
  KEY `userid` (`userid`),
  KEY `diskid` (`disk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_disk2user`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_disks`
--

DROP TABLE IF EXISTS `pd_disks`;
CREATE TABLE IF NOT EXISTS `pd_disks` (
  `disk_id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `space` varchar(50) NOT NULL,
  `price` int(10) unsigned NOT NULL default '0',
  `expire` smallint(5) unsigned NOT NULL default '0',
  `show_order` tinyint(1) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`disk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_disks`
--


-- --------------------------------------------------------


--
-- 表的结构 `pd_extracts`
--

DROP TABLE IF EXISTS `pd_extracts`;
CREATE TABLE IF NOT EXISTS `pd_extracts` (
  `extract_id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `extract_code` varchar(16) NOT NULL,
  `extract_file_ids` text NOT NULL,
  `extract_total` smallint(5) unsigned NOT NULL default '0',
  `extract_count` smallint(5) unsigned NOT NULL default '0',
  `extract_time` int(10) unsigned NOT NULL default '0',
  `extract_type` tinyint(1) unsigned NOT NULL default '0',
  `extract_locked` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`extract_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_extracts`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_file2tag`
--

DROP TABLE IF EXISTS `pd_file2tag`;
CREATE TABLE IF NOT EXISTS `pd_file2tag` (
  `ftid` int(11) unsigned NOT NULL auto_increment,
  `tag_name` varchar(30) NOT NULL,
  `file_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ftid`),
  KEY `tag_name` (`tag_name`),
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_file2tag`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_files`
--

DROP TABLE IF EXISTS `pd_files`;
CREATE TABLE IF NOT EXISTS `pd_files` (
  `file_id` bigint(20) unsigned NOT NULL auto_increment,
  `yun_fid` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT  '0',
  `file_name` varchar(100) NOT NULL,
  `file_key` char(8) NOT NULL,
  `file_short_url` char(6) NOT NULL,
  `file_extension` varchar(10) NOT NULL,
  `is_image` tinyint(1) unsigned NOT NULL default '0',
  `file_mime` varchar(50) NOT NULL,
  `file_description` text NOT NULL,
  `file_store_path` varchar(50) NOT NULL,
  `file_real_name` varchar(255) NOT NULL,
  `file_md5` char(32) NOT NULL,
  `server_oid` smallint(5) unsigned NOT NULL default '0',
  `store_old` tinyint(1) unsigned NOT NULL default '0',
  `file_size` int(10) unsigned NOT NULL default '0',
  `thumb_size` int(10) unsigned NOT NULL default '0',
  `file_time` int(10) unsigned NOT NULL default '0',
  `file_views` int(10) unsigned default '0',
  `file_downs` int(10) unsigned NOT NULL default '0',
  `file_last_view` int(10) unsigned default '0',
  `file_credit` tinyint(2) unsigned NOT NULL default '0',
  `report_status` tinyint(1) unsigned NOT NULL default '0',
  `in_share` tinyint(1) unsigned NOT NULL default '0',
  `space_pos` tinyint(1) unsigned NOT NULL default '0',
  `good_count` mediumint(8) unsigned NOT NULL default '0',
  `bad_count` mediumint(8) unsigned NOT NULL default '0',
  `is_locked` tinyint(1) unsigned NOT NULL default '0',
  `is_checked` tinyint(1) unsigned NOT NULL default '0',
  `is_public` tinyint(1) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `folder_id` bigint(20) NOT NULL default '0',
  `cate_id` int(10) unsigned NOT NULL default '0',
  `subcate_id` int(10) unsigned NOT NULL default '0',
  `in_recycle` tinyint(1) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`file_id`),
  KEY `userid` (`userid`),
  KEY `folder_id` (`folder_id`),
  KEY `server_id` (`server_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_files`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_folders`
--

DROP TABLE IF EXISTS `pd_folders`;
CREATE TABLE IF NOT EXISTS `pd_folders` (
  `folder_id` bigint(20) unsigned NOT NULL auto_increment,
  `parent_id` bigint(20) NOT NULL default '0',
  `folder_node` tinyint(1) unsigned NOT NULL default '0',
  `folder_name` varchar(50) NOT NULL,
  `folder_description` varchar(255) NOT NULL,
  `in_recycle` tinyint(1) unsigned NOT NULL default '0',
  `in_share` tinyint(1) unsigned NOT NULL default '0',
  `folder_order` smallint(5) unsigned NOT NULL default '0',
  `folder_size` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`folder_id`),
  KEY `userid` (`userid`),
  KEY `parent_id` (`parent_id`),
  KEY `folder_node` (`folder_node`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_folders`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_gallery`
--

DROP TABLE IF EXISTS `pd_gallery`;
CREATE TABLE IF NOT EXISTS `pd_gallery` (
  `gal_id` int(10) unsigned NOT NULL auto_increment,
  `gal_path` varchar(200) NOT NULL,
  `gal_title` varchar(150) NOT NULL,
  `go_url` varchar(200) NOT NULL,
  `gal_target` varchar(10) NOT NULL,
  `show_order` tinyint(1) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pd_gallery`
--

INSERT INTO `pd_gallery` (`gal_id`, `gal_path`, `gal_title`, `go_url`, `gal_target`, `show_order`, `is_hidden`) VALUES
(1, 'images/01.jpg', '丰富的插件、模板下载，满足您全方位的需求。', 'http://www.phpdisk.com/store.html', '_blank', 0, 0),
(2, 'images/02.jpg', '全新架构，重构内核，PHPDISK v6.5.0发布', 'http://bbs.phpdisk.com/thread-3377-1-1.html', '_blank', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pd_groups`
--

DROP TABLE IF EXISTS `pd_groups`;
CREATE TABLE IF NOT EXISTS `pd_groups` (
  `gid` tinyint(3) unsigned NOT NULL,
  `group_type` tinyint(1) unsigned NOT NULL default '0',
  `group_name` varchar(50) NOT NULL,
  `max_messages` tinyint(3) unsigned NOT NULL default '0',
  `max_flow_down` varchar(20) NOT NULL default '0',
  `max_flow_view` varchar(20) NOT NULL default '0',
  `max_storage` varchar(20) NOT NULL default '0',
  `group_file_types` varchar(150) NOT NULL,
  `max_filesize` varchar(20) NOT NULL default '0',
  `max_folders` int(10) unsigned NOT NULL default '0',
  `max_files` int(10) unsigned NOT NULL default '0',
  `can_share` tinyint(1) unsigned NOT NULL default '0',
  `secs_loading` smallint(5) unsigned NOT NULL default '0',
  `server_ids` varchar(30) NOT NULL,
  PRIMARY KEY  (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_groups`
--

INSERT INTO `pd_groups` (`gid`, `group_type`, `group_name`, `max_messages`, `max_flow_down`, `max_flow_view`, `max_storage`, `group_file_types`, `max_filesize`, `max_folders`, `max_files`, `can_share`, `secs_loading`, `server_ids`) VALUES
(1, 1, '系统管理员', 0, '0', '0', '0', '', '0', 0, 0, 1, 5, '0'),
(2, 1, 'VIP会员', 0, '10g', '20g', '0', '', '1m', 0, 0, 1, 0, '0'),
(3, 1, '高级会员', 0, '0', '0', '0', '', '0', 0, 0, 1, 0, '1'),
(4, 1, '普通会员', 0, '0', '0', '0', '', '0', 0, 0, 1, 0, '1');

-- --------------------------------------------------------

--
-- 表的结构 `pd_invitelog`
--

DROP TABLE IF EXISTS `pd_invitelog`;
CREATE TABLE IF NOT EXISTS `pd_invitelog` (
  `bdid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `touserid` int(10) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bdid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_invitelog`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_langs`
--

DROP TABLE IF EXISTS `pd_langs`;
CREATE TABLE IF NOT EXISTS `pd_langs` (
  `lang_name` varchar(30) NOT NULL,
  `actived` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`lang_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_langs`
--

INSERT INTO `pd_langs` (`lang_name`, `actived`) VALUES
('zh_cn', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pd_links`
--

DROP TABLE IF EXISTS `pd_links`;
CREATE TABLE IF NOT EXISTS `pd_links` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `show_order` tinyint(1) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pd_links`
--

INSERT INTO `pd_links` (`linkid`, `title`, `url`, `logo`, `show_order`, `is_hidden`) VALUES
(1, 'PHPDisk网络硬盘', 'http://www.phpdisk.com', './images/logo_small.gif', 2, 0),
(2, 'PHPDisk交流论坛', 'http://bbs.phpdisk.com', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pd_messages`
--

DROP TABLE IF EXISTS `pd_messages`;
CREATE TABLE IF NOT EXISTS `pd_messages` (
  `msgid` int(11) unsigned NOT NULL auto_increment,
  `reply_id` int(11) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `touserid` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `in_sendbox` tinyint(1) unsigned NOT NULL default '0',
  `is_del` tinyint(1) unsigned NOT NULL default '0',
  `is_reply` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`msgid`),
  KEY `touserid` (`touserid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_messages`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_navigations`
--

DROP TABLE IF EXISTS `pd_navigations`;
CREATE TABLE IF NOT EXISTS `pd_navigations` (
  `navid` int(10) unsigned NOT NULL auto_increment,
  `text` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `href` varchar(80) NOT NULL,
  `target` varchar(10) NOT NULL,
  `position` varchar(10) NOT NULL,
  `show_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`navid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pd_navigations`
--

INSERT INTO `pd_navigations` (`navid`, `text`, `title`, `href`, `target`, `position`, `show_order`) VALUES
(1, 'PHPDisk论坛', 'PHPDisk官方交流论坛', 'http://bbs.phpdisk.com', '_blank', 'top', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pd_orders`
--

DROP TABLE IF EXISTS `pd_orders`;
CREATE TABLE IF NOT EXISTS `pd_orders` (
  `order_id` int(11) unsigned NOT NULL auto_increment,
  `pay_method` varchar(10) NOT NULL,
  `userid` int(10) unsigned NOT NULL default '0',
  `order_number` varchar(50) NOT NULL,
  `total_fee` float unsigned NOT NULL default '0',
  `pay_status` varchar(10) NOT NULL,
  `retcode` tinyint(3) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`order_id`),
  KEY `pay_method` (`pay_method`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_orders`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_plugins`
--

DROP TABLE IF EXISTS `pd_plugins`;
CREATE TABLE IF NOT EXISTS `pd_plugins` (
  `plugin_name` varchar(100) NOT NULL,
  `actived` tinyint(1) NOT NULL default '0',
  `action_time` int(10) unsigned NOT NULL default '0',
  `in_shortcut` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`plugin_name`),
  KEY `in_shortcut` (`in_shortcut`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_plugins`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_replys`
--

DROP TABLE IF EXISTS `pd_replys`;
CREATE TABLE IF NOT EXISTS `pd_replys` (
  `rpid` int(11) unsigned NOT NULL auto_increment,
  `tid` int(11) unsigned NOT NULL default '0',
  `userid` int(10) NOT NULL,
  `content` text NOT NULL,
  `is_best` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`rpid`),
  KEY `tid` (`tid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_replys`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_reports`
--

DROP TABLE IF EXISTS `pd_reports`;
CREATE TABLE IF NOT EXISTS `pd_reports` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `file_id` bigint(20) unsigned NOT NULL default '0',
  `file_key` char(8) NOT NULL,
  `content` varchar(255) NOT NULL,
  `userid` int(10) unsigned NOT NULL default '0',
  `is_new` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_reports`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_search_index`
--

DROP TABLE IF EXISTS `pd_search_index`;
CREATE TABLE IF NOT EXISTS `pd_search_index` (
  `searchid` int(11) NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `scope` varchar(6) NOT NULL,
  `word` varchar(200) NOT NULL,
  `search_time` int(10) NOT NULL default '0',
  `total_count` smallint(6) NOT NULL default '0',
  `file_ids` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`searchid`),
  KEY `userid` (`userid`),
  KEY `scope` (`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_search_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_servers`
--

DROP TABLE IF EXISTS `pd_servers`;
CREATE TABLE IF NOT EXISTS `pd_servers` (
  `server_id` smallint(5) unsigned NOT NULL auto_increment,
  `server_oid` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
  `server_name` varchar(50) NOT NULL,
  `server_host` varchar(100) NOT NULL,
  `server_closed` tinyint(1) unsigned NOT NULL default '0',
  `server_store_path` varchar(50) NOT NULL,
  `server_key` varchar(50) NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL default '0',
  `ftp_host` varchar(50) NOT NULL,
  `ftp_port` varchar(10) NOT NULL,
  `ftp_user` varchar(20) NOT NULL,
  `ftp_pass` varchar(20) NOT NULL,
  `ftp_ssl` tinyint(1) unsigned NOT NULL default '0',
  `ftp_pasv` tinyint(1) unsigned NOT NULL default '0',
  `ftp_path` varchar(30) NOT NULL,
  `ftp_closed` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`server_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
--
-- 导出表中的数据 `pd_servers`
--

INSERT INTO `pd_servers` (`server_id`, `server_name`, `server_host`, `server_closed`, `is_default`) VALUES
(1, 'Local Server', '-', 0, 9);;

-- --------------------------------------------------------

--
-- 表的结构 `pd_settings`
--

DROP TABLE IF EXISTS `pd_settings`;
CREATE TABLE IF NOT EXISTS `pd_settings` (
  `vars` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`vars`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_settings`
--

INSERT INTO `pd_settings` (`vars`, `value`) VALUES
('site_title', 'PHPDisk网盘系统'),
('phpdisk_url', 'http://localhost/phpdisk/'),
('file_path', 'filestores'),
('max_file_size', '0'),
('perpage', '20'),
('gzipcompress', '1'),
('allow_access', '1'),
('allow_register', '1'),
('close_access_reason', '系统维护中...'),
('close_register_reason', '系统暂时关闭注册...'),
('meta_keywords', 'phpdisk网盘,php文件管理系统'),
('meta_description', 'phpdisk网盘,php文件管理系统'),
('site_stat', ''),
('miibeian', ''),
('contact_us', 'mail@mail.com'),
('credit_convert', '1'),
('user_active','0'),
('debug_info', '1'),
('open_demo_login', '1'),
('open_share', '1'),
('open_link', '1'),
('open_link_domain', '*.phpdisk.com|www.163.com|'),
('report_word', 'bat,sh'),
('encrypt_key', 'r2FITb5S6CtR'),
('register_verycode', '1'),
('login_verycode', '0'),
('open_seo', '1'),
('version_info', '1'),
('email_address', 'admin@163.com'),
('email_pwd', '123456'),
('email_user', 'admin'),
('email_smtp', 'smtp.163.com'),
('email_port', '25'),
('email_ssl', '0'),
('open_rewrite', '0'),
('credit_invite', '6'),
('credit_reg', '10'),
('credit_login', '2'),
('credit_msg', '1'),
('credit_upload', '3'),
('credit_down', '2'),
('credit_open', '1'),
('login_down_file', '0'),
('online_demo', '0'),
('credit_down_my', '1'),
('filter_extension', 'asp,asa,aspx,ascx,dtd,xsd,xsl,xslt,as,wml,java,vtm,vtml,jst,asr,php,php3,php4,php5,vb,vbs,jsf,jsp,pl,cgi,js,html,htm,xhtml,xml,css,shtm,cfm,cfml,shtml,bat,sh'),
('open_thunder', '0'),
('thunder_pid', '11111'),
('open_flashget', '0'),
('flashget_uid', '75870'),
('connect_uc', '0'),
('uc_charset', 'utf-8'),
('uc_dbname', 'ultrax'),
('uc_dbtablepre', 'pre_ucenter_'),
('uc_appid', '2'),
('uc_key', 'phpdisk_dx15_uc'),
('uc_api', 'http://localhost/x15/uc_server'),
('uc_feed', '1'),
('uc_credit_exchange', '1'),
('uc_dbcharset', 'utf8'),
('thumb_width', '120'),
('thumb_height', '90'),
('check_comment', '1'),
('secs_loading', '10'),
('true_link', '0'),
('true_link_extension', 'gif,png,bmp,wav,mp3,torrent,jpg,exe'),
('open_verycode', '1'),
('verycode_type', '2'),
('forget_verycode', '0'),
('open_tag', '1'),
('open_comment', '1'),
('open_vote', '1'),
('open_file_url', '1'),
('open_report', '1'),
('viewfile_keyword', ''),
('powered_info', '0'),
('uc_admin', 'admin'),
('uc_dbhost', 'localhost'),
('uc_dbuser', 'root'),
('uc_dbpwd', 'passwd'),
('store_true_filename', '0'),
('open_plugins_cp', '1'),
('open_credit_convert', '1'),
('open_multi_server', '0'),
('show_index', '1'),
('show_public', '1'),
('open_email', '0'),
('open_plugins_last', '1'),
('connect_uc_type', 'discuz'),
('open_file_preview', '1'),
('open_file_extract_code', '1'),
('open_file_outlink', '1'),
('open_file_shorturl', '0'),
('downfile_directly', '0'),
('open_gallery_index', '1'),
('gallery_type', '1'),
('gallery_size_width', '650'),
('gallery_size_height', '200'),
('open_autoupdate', '0'),
('downfile_stat_time', '3600'),
('create_default_folder', ''),
('default_amount', '10'),
('show_relative_file', '1'),
('wealth_reg', '0'),
('wealth_login', '0'),
('wealth_invite', '0'),
('wealth_msg', '0'),
('wealth_upload', '0'),
('wealth_down', '0'),
('wealth_down_my', '0'),
('exp_reg', '20'),
('exp_login', '2'),
('exp_invite', '6'),
('exp_msg', '1'),
('exp_upload', '3'),
('exp_down', '2'),
('exp_down_my', '1'),
('credit_union', '积分'),
('wealth_union', '金钱'),
('exp_union', '经验'),
('exp_const', '50'),
('show_stat_index', '1'),
('invite_register_encode', '1'),
('share_tool', 'PCEtLSBKaWFUaGlzIEJ1dHRvbiBCRUdJTiAtLT4NCjxkaXYgaWQ9ImNrZXBvcCI+DQoJPGEgaHJlZj0iaHR0cDovL3d3dy5qaWF0aGlzLmNvbS9zaGFyZS8/dWlkPTkxODMxIiBjbGFzcz0iamlhdGhpcyBqaWF0aGlzX3R4dCBqdGljbyBqdGljb19qaWF0aGlzIiB0YXJnZXQ9Il9ibGFuayI+5YiG5Lqr5Yiw77yaPC9hPg0KCTxhIGNsYXNzPSJqaWF0aGlzX2J1dHRvbl90b29sc18xIj48L2E+DQoJPGEgY2xhc3M9ImppYXRoaXNfYnV0dG9uX3Rvb2xzXzIiPjwvYT4NCgk8YSBjbGFzcz0iamlhdGhpc19idXR0b25fdG9vbHNfMyI+PC9hPg0KCTwvZGl2Pg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPnZhciBqaWF0aGlzX2NvbmZpZyA9IHsiZGF0YV90cmFja19jbGlja2JhY2siOnRydWV9Ozwvc2NyaXB0Pg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iaHR0cDovL3YxLmppYXRoaXMuY29tL2NvZGUvamlhLmpzP3VpZD05MTgzMSIgY2hhcnNldD0idXRmLTgiPjwvc2NyaXB0Pg0KPCEtLSBKaWFUaGlzIEJ1dHRvbiBFTkQgLS0+'),
('file_to_public_checked', '0');

-- --------------------------------------------------------

--
-- 表的结构 `pd_stats`
--

DROP TABLE IF EXISTS `pd_stats`;
CREATE TABLE IF NOT EXISTS `pd_stats` (
  `vars` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY  (`vars`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_stats`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_tags`
--

DROP TABLE IF EXISTS `pd_tags`;
CREATE TABLE IF NOT EXISTS `pd_tags` (
  `tag_id` int(11) unsigned NOT NULL auto_increment,
  `tag_name` varchar(30) NOT NULL,
  `tag_count` int(10) unsigned NOT NULL default '0',
  `is_hidden` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_tags`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_templates`
--

DROP TABLE IF EXISTS `pd_templates`;
CREATE TABLE IF NOT EXISTS `pd_templates` (
  `tpl_name` varchar(50) NOT NULL,
  `actived` tinyint(1) unsigned NOT NULL,
  `tpl_type` varchar(30) NOT NULL,
  PRIMARY KEY  (`tpl_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pd_templates`
--

INSERT INTO `pd_templates` (`tpl_name`, `actived`, `tpl_type`) VALUES
('admin', 1, 'admin'),
('default', 1, 'user');

-- --------------------------------------------------------

--
-- 表的结构 `pd_topics`
--

DROP TABLE IF EXISTS `pd_topics`;
CREATE TABLE IF NOT EXISTS `pd_topics` (
  `tid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `credit` tinyint(3) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `is_closed` tinyint(1) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`tid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_topics`
--


-- --------------------------------------------------------

--
-- 表的结构 `pd_users`
--

DROP TABLE IF EXISTS `pd_users`;
CREATE TABLE IF NOT EXISTS `pd_users` (
  `userid` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gid` tinyint(3) unsigned default '0',
  `reset_code` varchar(32) NOT NULL,
  `is_activated` tinyint(1) default '0',
  `is_locked` tinyint(1) default '0',
  `last_login_time` int(11) default '0',
  `last_login_ip` varchar(15) NOT NULL,
  `reg_time` int(10) unsigned default '0',
  `reg_ip` varchar(15) NOT NULL,
  `credit` int(10) unsigned NOT NULL default '0',
  `wealth` float NOT NULL default '0',
  `rank` tinyint(3) unsigned NOT NULL default '0',
  `exp` smallint(5) unsigned NOT NULL default '0',
  `accept_pm` tinyint(1) default '1',
  `show_email` tinyint(1) default '0',
  `space_pos` tinyint(1) unsigned NOT NULL default '0',
  `user_file_types` varchar(150) NOT NULL,
  `user_store_space` varchar(30) NOT NULL,
  `user_rent_space` varchar(30) NOT NULL,
  `space_day_credits` float NOT NULL,
  `down_flow_count` varchar(20) NOT NULL default '0',
  `view_flow_count` varchar(20) NOT NULL default '0',
  `flow_reset_time` int(10) unsigned NOT NULL default '0',
  `max_flow_down` varchar(30) NOT NULL,
  `max_flow_view` varchar(30) NOT NULL,
  PRIMARY KEY  (`userid`),
  KEY `username` (`username`),
  KEY `gid` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pd_users`
--

