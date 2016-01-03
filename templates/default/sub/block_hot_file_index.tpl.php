<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_hot_file_index.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div style="margin-top:10px;">
<div class="fl_box">
<div class="tit2"><a href="{#urr("public","")#}"><span style="float:right; cursor:pointer"><?=__('last_file_more')?></span></a><?=__('last_file')?></div>
<ul>
<!--#
if(count($C[last_file])){
	foreach($C[last_file] as $v){
#-->
	<li><a href="{$v['a_viewfile']}" target="_blank">{$v['file_time']}{$v[file_icon]} {$v['file_name']}</a></li>
<!--#
	}
}
#-->
</ul>
</div>

<div class="fl_box" style="margin-left:10px">
<div class="tit2"><?=__('hot_file')?></div>
<ul>
<!--#
if(count($C[hot_file])){
	foreach($C[hot_file] as $v){
#-->
	<li><a href="{$v['a_viewfile']}" target="_blank">{$v['file_time']}{$v[file_icon]} {$v['file_name']}</a></li>
<!--#
	}
}
#-->
</ul>
</div>
</div>
<div class="clear"></div>
