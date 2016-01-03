<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: folders.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action == 'index'){
#-->
<div id="container">
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<!--# require_once template_echo('my_nav_bar',$user_tpl_dir);#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<tr>
	<td width="60%" class="bold"><?=__('folder_name')?></td>
	<td width="15%" align="center" class="bold"><?=__('folder_size')?></td>
	<td align="right" class="bold"><?=__('operation')?></td>
</tr>
<form action="{#urr("mydisk","item=folders")#}" name="folder_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="index" />
<input type="hidden" name="formhash" value="{$formhash}" />
{$folder_list}
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.folder_form.folder_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.folder_form.folder_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<select name="dest_folder" style="width:120px">
	<option value="-1" class="txtgreen"><?=__('please_select')?></option>
	{$option_folder_3}
	</select>&nbsp;
	<input type="radio" id="to_folder" name="task" value="to_folder" checked="checked" /><label for="to_folder"><?=__('to_folder')?></label>
	<input type="radio" id="folder_delete" name="task" value="folder_delete"/><label for="folder_delete"><span class="txtred"><?=__('folder_to_recycle')?></span></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>" onclick="return confirm('<?=__('confirm_op')?>');" />&nbsp;
	</td>
</tr>
</form>
</table>
</div>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("folder_ids[]") != true){
		alert("<?=__('please_select_move_folders')?>");
		return false;
	}
	if(getId('to_folder').checked ==true && o.dest_folder.value ==-1){
		alert("<?=__('please_select_dest_folder')?>");
		o.dest_folder.focus();
		return false;
	}
}
</script>
<!--#
}elseif($action == 'folder_modify'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=folders")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('folder_name')?>:</li>
<li><input type="text" name="folder_name" value="{$folder['folder_name']}" size="30" maxlength="50" /></li>
<li><span id="e_1" class="txtred"></span></li>
<li><?=__('folder_description')?>(<?=__('optional')?>): </li>
<li><textarea name="folder_description" style="width:250px; height:80px;">{$folder['folder_description']}</textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.folder_name.value.strtrim().length <2){
		getId('e_1').innerText = "<?=__('folder_min_length')?>";
		o.folder_name.focus();
		return false;
	}
}
</script>
<!--#
}elseif($action == 'folder_create'){
#-->
<div id="container">
<div class="box_style">
	<!--#if($exceed_max_folders){#-->
	<li class="tb_box_msg"><?=__('exceed_max_folders_msg')?></li>
	<li>&nbsp;</li>
	<div align="center"><input type="button" class="btn" value="<?=__('btn_back')?>" onclick="self.parent.$.jBox.close(true);" /></div>
	<!--#}else{#-->
	<form action="{#urr("mydisk","item=folders")#}" method="post" onsubmit="return dosubmit(this);">
	<input type="hidden" name="action" value="{$action}" />
	<input type="hidden" name="task" value="{$action}" />
	<input type="hidden" name="ref" value="{$ref}" />
	<input type="hidden" name="formhash" value="{$formhash}" />
	<li><?=__('parent_folder')?>:</li>
	<li><select name="parent_id">
		<option value="-1"> <?=__('please_select_folder')?> </option>
		{$option_folder_3}
		</select>
	</li>
	<li><?=__('folder_name')?>:</li>
	<li><input type="text" name="folder_name" value="{$folder['folder_name']}" size="30" maxlength="50" /></li>
	<li><?=__('folder_description')?>(<?=__('optional')?>):</li>
	<li><textarea name="folder_description" style="width:250px; height:80px;">{$folder['description']}</textarea></li>
	<li>&nbsp;</li>
	<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
	</form>
	<script language="javascript">
	{$script}
	function dosubmit(o){
		if(o.parent_id.value ==-1){
			alert("<?=__('please_select_folder_tips')?>");
			o.parent_id.focus();
			return false;
		}
		if(o.folder_name.value.strtrim().length <2){
			alert("<?=__('folder_min_length')?>");
			o.folder_name.focus();
			return false;
		}
	}
	</script>
	<!--#}#-->
	</div>
<br />
<br />
<br />
</div>
<!--#
}elseif($action =='folder_delete'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=folders")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen">{$folder_name}</span></li>
<li><?=__('delete_folder_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}#-->