<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_links.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if(count($C[links_arr])){
#-->
<div class="f_link">
<div class="tit"><img src="images/link_icon.gif" align="absmiddle" border="0" /> <?=__('site_link')?></div>
<div class="ctn">
<!--#
	foreach($C[links_arr] as $k => $v){
		if($v[has_logo]){
#-->
	<a href="{$v['url']}" target="_blank"><img src="{$v['logo']}" align="absbottom" border="0" alt="{$v['title']}"></a>&nbsp;
<!--#
	}else{
#-->
	<a href="{$v['url']}" target="_blank">{$v['title']}</a>&nbsp;
<!--#
	}
	}
#-->
</div>
</div>
<!--#
}
#-->
