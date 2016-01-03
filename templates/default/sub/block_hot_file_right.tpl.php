<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_hot_file_right.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="common_box">
<!--#if($settings['show_hot_file_right']){#-->
<div class="tit2"><?=__('hot_file')?></div>
<ul>
<!--#
if(count($C[hot_file])){
	foreach($C[hot_file] as $v){
#-->
<li>{#file_icon($v['file_extension'])#}<a href="{$v['a_viewfile']}" title="{$v['file_name_all']}" target="_blank">{$v['file_name']}</a> {$v['file_views']}</li>
<!--#
	}
}
#-->
</ul>
</div>
<br />
<!--#}#-->
