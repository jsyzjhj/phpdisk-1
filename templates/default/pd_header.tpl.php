<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_header.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if(!$inner_box){#-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--#}#-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>{$title}<!--#if($settings['powered_info']){#--> - Powered by PHPDisk Team<!--#}#--></title>
<link rel="shortcut icon" href="favicon.ico">
<meta name="Copyright" content="Powered by PHPDisk Team, {PHPDISK_EDITION} {PHPDISK_VERSION} build{PHPDISK_RELEASE}" />
<meta name="generator" content="PHPDisk {PHPDISK_VERSION}" />
<!--#if($settings['open_seo']){#-->
<meta name="keywords" content="{$file_keywords}{$settings['meta_keywords']}" />
<meta name="description" content="{$file_description}{$settings['meta_description']}" />
<!--#}#-->
<script type="text/javascript" src="includes/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-zh-CN.js"></script>
<link type="text/css" rel="stylesheet" href="images/js/skins/blue/jbox.css"/>
<script type="text/javascript" src="includes/js/common.js"></script>
<script type="text/javascript" src="includes/js/tree.js"></script>
<!--[if IE 6]>
<script src="includes/js/DD_belatedPNG.js"></script>
<script>
  DD_belatedPNG.fix('*');/*.png_bg 为定义的css*/ 
</script>
<![endif]-->
<link href="{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">

</head>

<!--#if($inner_box){#-->
<body style="background:#FFFFFF">
<!--#}else{#-->
<body>
<div class="body_top">
<div class="logo_l"><a href="./"><img src="{$user_tpl_dir}images/logo.png" align="absmiddle" border="0" alt="{$settings['site_title']}"></a></div>
<div class="m">
<!--#if($pd_uid){#-->
<a href="{$a_index_share}">{$pd_username}</a>
<a href="{#urr("account","action=logout")#}" onclick="return confirm('<?=__('Logout now?')?>');"><?=__('logout')?></a>
	<!--#if($settings[user_active] && !$pd_is_activated){#-->
	<a href="{#urr("account","action=active")#}"><span class="txtred"><?=__('unactivated')?></span></a>
	<!--#}else{#-->
	<a href="{#urr("mydisk","")#}"><?=__('mydisk')?></a>
	<!--#}#-->
<!--#if($pd_gid ==1){#-->
<a href="{#urr(ADMINCP,"")#}" target="_blank"><?=__('admincp')?></a>
<!--#}#-->
<!--#}else{#-->
<a href="{#urr("account","action=login")#}"><?=__('login')?></a>
<a href="{#urr("account","action=register")#}"><?=__('register')?></a>
<!--#}#-->
<!--#if($settings['show_public']){#-->
<a href="{#urr("public","")#}"><?=__('share_file')?></a>

<!--#}#-->
<a href="{#urr("extract","")#}"><?=__('file_extract')?></a>
<a href="{#urr("search","")#}"><?=__('search')?></a>
<!--#if($settings['open_tag']){#-->
<a href="{#urr("tag","")#}"><?=__('tag')?></a>
<!--#}#-->
<!--#include sub/block_navigation_top#-->
</div>

<div class="clear"></div>
</div>

<div class="circle_box">
<div class="logo_r">
<!--#show_adv_data('adv_top');#-->
</div>
<div class="clear"></div>
<!--#}#-->
