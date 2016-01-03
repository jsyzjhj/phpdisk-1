<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: share.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='share_folder'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=share")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<!--#
if(count($files_array) && $can_share){
#-->
<div class="file_box">
<li class="f14"><?=__('file_list')?>:</li>
<!--#
	foreach($files_array as $v){
#-->
<li><a href="{$v['a_viewfile']}" target="_blank" >{#file_icon($v['file_extension'])#}&nbsp;{$v['file_name']}</a> ({$v['file_size']})</li>
<!--#
	}
	unset($files_array);
#-->
<li>&nbsp;</li>
</div>
<br>
<div align="center">
<!--#if($in_share){#-->
<input type="hidden" name="task" value="unshare_folder" />
<input type="submit" class="btn" value="<?=__('btn_unshare')?>" />&nbsp;&nbsp;
<!--#}else{#-->
<input type="hidden" name="task" value="share_folder" />
<input type="submit" class="btn" value="<?=__('btn_share')?>" />&nbsp;&nbsp;
<!--#}#-->
<input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
<!--#	
}else{
#-->
<br /><br /><br />
<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen">{$notice_msg}</span></div>
<br>
<div align="center"><input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
<!--#
}
#-->

</form>
</div>
</div>
<!--#}#-->