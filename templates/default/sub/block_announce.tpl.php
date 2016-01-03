<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_announce.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if(count($C[announce_arr])){
#-->
<div style="padding:8px 0;">
<script language="javascript">
var anns_arr = new Array();
<!--#
	foreach($C[announce_arr] as $k => $v){
#-->
	anns_arr[{$k}] = '<img src="images/ann_icon.gif" align="absmiddle"> <a href="javascript:;" onclick="abox(\'{$v[href]}\',\'{$v[subject]}\',650,450);" class="f14">{$v[subject]} <span class="txtgray f10">({$v[in_time]})</span></a>';
<!--#
	}
#-->
</script>
<script language="javascript" type="text/javascript" src="includes/js/ann_js.js"></script>
</div>
<!--#
}
#-->
