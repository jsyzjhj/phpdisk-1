<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_announce.tpl.php 32 2013-08-10 05:39:14Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if(!$settings[hide_license] && $auth['is_commercial_edition']){#-->
&nbsp;<a href="http://www.phpdisk.com/commerce.html?w={#$_SERVER['HTTP_HOST']#}" target="_blank" title="可以查询到您现在使用的产品是否为PHPDisk官方正版授权"><img src="images/ico_auth.gif" align="absmiddle" border="0" />正版授权</a>
<!--#}#-->