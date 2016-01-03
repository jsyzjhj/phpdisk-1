<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: stats.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('user_down_stats')?></h1>
<div class="tips_box"><b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('user_down_stats_tips')?></span>
</div>
<br />

<!--#
if($content){
#-->
<b><?=__('view_log')?></b> <br />
<textarea name="logs" style="width:90%; height:300px" readonly="readonly">{$content}</textarea>
<br />
<!--#
}else{
#-->
<div style="padding:5px;" align="center"><?=__('none_logs')?></div>
<!--#
}
#-->
<br /><br />
</div>
