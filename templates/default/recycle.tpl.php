<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: recycle.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='files'){
#-->
<div id="container">
<h1><?=__('file_list')?></h1>
<div class="tips_box_p">
<div class="tips_box">
<b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('file_recycle_tips')?></span>
</div>
</div>
<form action="{#urr("mydisk","item=recycle")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="60%" class="bold"><?=__('file_name')?></td>
	<td align="center" width="80" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_time')?></td>
	<td align="center" width="80" class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($folders_array)){
	foreach($folders_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td width="60%"><input type="checkbox" name="fd_sel_ids[]" id="sel_ids" value="{$v['folder_id']}" />&nbsp;<a href="javascript:;" onclick="abox('{$v['a_viewfolder']}','<?=__('view_folder')?>',440,320);"><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;{$v['folder_name']}</a> {$v['total']}</td>
	<td align="center">{$v['folder_size']}</td>
	<td align="center" class="txtgray">{$v['folder_time']}</td>
	<td align="center">
	<a href="javascript:;" onclick="abox('{$v['a_restore']}','<?=__('restore_folder')?>',400,200);" title="<?=__('restore_folder')?>"><img src="images/restore_icon.gif" border="0" align="absmiddle" /></a>&nbsp;
	<a href="javascript:;" onclick="abox('{$v['a_delete_complete']}','<?=__('delete_folder')?>',400,200);" title="<?=__('delete_folder')?>"><img src="images/delete_icon.gif" border="0" align="absmiddle" /></a>
	</td>
</tr>

<!--#		
	}
	unset($folders_array);	
}
#-->
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ((count($folders_array)+$k)%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td width="40%"><input type="checkbox" name="fl_sel_ids[]" id="sel_ids" value="{$v['file_id']}" />&nbsp;
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{#file_icon($v['file_extension'])#} {$v['file_name']}</a>
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{#file_icon($v['file_extension'])#} {$v['file_name']}</a> <span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" class="txtgray">{$v['file_time']}</td>
	<td align="center">
	<a href="javascript:;" onclick="abox('{$v['a_restore']}','<?=__('restore_file')?>',400,200);" title="<?=__('restore_file')?>"><img src="images/restore_icon.gif" border="0" align="absmiddle" /></a>&nbsp;
	<a href="javascript:;" onclick="abox('{$v['a_delete_complete']}','<?=__('delete_file')?>',400,200);" title="<?=__('delete_file')?>"><img src="images/delete_icon.gif" border="0" align="absmiddle" /></a>
	</td>
</tr>

<!--#		
	}
	unset($files_array);	
}
#-->
<!--#if($recycle_empty){#-->
<tr class="color4">
	<td align="center" colspan="6" class="td_line"><?=__('recycle_is_empty')?></td>
</tr>
<!--#}else{#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.file_form.sel_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_form.sel_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="restore_recycle" id="rr" /><label for="rr"><?=__('restore_it')?></label>&nbsp;
	<input type="radio" name="task" value="delete_complete_recycle" id="dcr" checked="checked" /><label for="dcr"><span class="txtred"><?=__('delete_complete')?></span></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>" onclick="return confirm('<?=__('confirm_op')?>');" />
	</td>
</tr>
<!--#}#-->
</table>
</form>
</div>
<script type="text/javascript">
function dosubmit(o){
	if((checkbox_ids("fl_sel_ids[]") != true) && (checkbox_ids("fd_sel_ids[]") != true)){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
</script>
<!--#}elseif($action == 'show_files'){#-->
<div id="container">
<div class="box_style">
<!--#
if(count($files_array)){
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
<!--#	
}else{
#-->
<br /><br />
<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen"><?=__('none_file')?></span></div>
<br /><br />
<!--#
}
#-->
<br />
<div align="center"><input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
</div>
</div>
<!--#}elseif($action == 'folder_delete_complete'){#-->
<div id="container">
<form action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="box_style">
<!--#
if(count($files_array)){
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
<!--#	
}else{
#-->
<br /><br />
<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen"><?=__('none_file')?></span></div>
<br /><br />
<!--#
}
#-->
<br />
<div align="center"><input type="submit" class="btn" value="<?=__('btn_delete_complete')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
</div>
</form>
</div>

<!--#}elseif($action == 'file_delete_complete'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li>{#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('delete_file_complete_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_delete_complete')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>

<!--#}elseif($action == 'folder_restore'){#-->
<div id="container">
<form action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="box_style">
<!--#
if(count($files_array)){
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
<!--#	
}else{
#-->
<br /><br />
<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen"><?=__('none_file')?></span></div>
<br /><br />
<!--#
}
#-->
<br />
<div align="center"><input type="submit" class="btn" value="<?=__('btn_restore')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
</div>
</form>
</div>

<!--#}elseif($action == 'file_restore'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li>{#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('file_restore_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_restore')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}elseif($action == 'restore_all'){#-->
<div id="container">
<h1><?=__('file_list')?></h1>
<div class="tips_box">
<b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('file_recycle_tips')?></span>
</div>
<div>
<br />
<form name="frm" action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('folder')?>: <b class="txtblue">{$folder_num}</b> , <?=__('file')?>: <b class="txtgreen">{$file_num}</b> , <?=__('size')?>: <b>{$all_size}</b></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_restore_all')?>" onclick="return confirm('<?=__('confirm_op')?>');" {$disabled}/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="go('{#urr("mydisk","item=recycle&action=files")#}');" /></li>
<li>&nbsp;</li>
</form>
<br />
<br />

</div>
</div>
</div>

<!--#}elseif($action =='delete_all'){#-->
<div id="container">
<h1><?=__('file_list')?></h1>
<div class="tips_box">
<b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('file_recycle_tips')?></span>
</div>
<div>
<br />
<form name="frm" action="{#urr("mydisk","item=recycle")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('folder')?>: <b class="txtblue">{$folder_num}</b> , <?=__('file')?>: <b class="txtgreen">{$file_num}</b> , <?=__('size')?>: <b>{$all_size}</b></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_empty_all')?>" onclick="return confirm('<?=__('confirm_op')?>');" {$disabled}/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="go('{#urr("mydisk","item=recycle&action=files")#}');" /></li>
<li>&nbsp;</li>
</form>
<br />
<br />

</div>
</div>
</div>
<!--#}#-->