<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_hot_tags.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if(count($C[hot_tags])){
#-->
<div class="tag_list">
<div class="t_tit"><?=__('hot_tag_title')?></div>
<ul>
<li>
<!--#
	foreach($C[hot_tags] as $v){
#-->
<a href="{$v['a_view_tag']}">{$v['tag_name']}<span class="txtgray">{$v['tag_count']}</span></a>
<!--#
	}
#-->
</li>
</ul>
<br />
<div class="clear"></div>
</div>
<br />
<!--#}#-->
