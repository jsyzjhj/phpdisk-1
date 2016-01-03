<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: public.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action == 'index'){#-->
<div id="container">
<script language="javascript">
$(document).ready(function(){
	$("td.ul_detail").each(function(){
		var obj = $(this).find("span");
		$(this).mouseover(function(){
			obj.css("display","");
			$(this).addClass("alt_bg");
		}).mouseout(function(){
			obj.css("display","none");
			$(this).removeClass("alt_bg");
		});
	});
});
</script>
<h1><?=__('public_file')?></h1>
<form action="{#urr("mydisk","item=public")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%" class="bold"><a href="{$n_url}"><?=__('file_name')?>{$n_order}</a></td>
	<td class="bold" width="20%"><?=__('username')?></td>
	<td class="bold" width="100"><a href="{$s_url}"><?=__('file_size')?>{$s_order}</a></td>
	<td align="center" class="bold"><a href="{$t_url}"><?=__('file_upload_time')?>{$t_order}</a></td>
	<td width="50" align="right" class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>
	<!--#if($pd_uid==$v[userid]){#-->
	<input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />
	<!--#}else{#-->
	<input type="checkbox" disabled="disabled"/>
	<!--#}#-->
	<a href="{$v['a_downfile']}" title="<?=__('download')?>">{#file_icon($v['file_extension'])#}</a>&nbsp;
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a>&nbsp;<span class="txtgray">{$v['file_description']}</span><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
		<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a>
	<span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td><!--#if($pd_uid==$v[userid]){#--><span class="txtblue">{$v['username']}</span><!--#}else{#-->{$v['username']}<!--#}#--></td>
	<td>{$v['file_size']}</td>
	<td class="txtgray" align="center">{$v['file_time']}</td>
	<td align="right">&nbsp;
	<!--#if($pd_uid==$v[userid]){#-->
	<a href="javascript:;" onclick="abox('{$v['a_file_modify']}','<?=__('file_modify')?>',400,280);" title="<?=__('modify')?>"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>
	<a href="javascript:;" onclick="abox('{$v['a_file_delete']}','<?=__('file_delete')?>',400,200);" title="<?=__('delete')?>"><img src="images/delete_icon.gif" border="0" align="absmiddle" /></a>
	<!--#}else{#-->
	--
	<!--#}#-->
	</td>
</tr>
<!--#		
	}
}
#-->
<!--#
if(count($files_array)){
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.file_form.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_form.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<span id="public_cate">
	<select name="public_cate" style="width:120px">
	<option value="-1" class="txtgreen"><?=__('please_select')?></option>
	{$pub_menu_option}
	</select>&nbsp;
	</span>
	<input type="radio" id="to_public" name="task" value="to_public" checked="checked"/><label for="to_public"><?=__('public_cate')?></label>&nbsp;
	<input type="radio" id="file_delete" name="task" value="file_delete"/><label for="file_delete"><span class="txtred"><?=__('file_delete')?></span></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>" onclick="return confirm('<?=__('confirm_op')?>');" />
	</td>
</tr>
<!--#
}else{
#-->
<tr>
	<td colspan="6" align="center"><?=__('none_public_file')?></td>
</tr>
<!--#}#-->
</table>
</form>
</div>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
	if(o.to_folder.checked ==true && o.dest_folder.value ==-1){
		alert("<?=__('please_select_dest_folder')?>");
		o.dest_folder.focus();
		return false;
	}
	if(o.to_public.checked ==true && o.public_cate.value ==-1){
		alert("<?=__('please_select_dest_folder')?>");
		o.public_cate.focus();
		return false;
	}
}
</script>
<!--#}elseif($action =='file_modify'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=public")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('file_name')?>(<?=__('none_extension')?>):</li>
<li><input type="text" name="file_name" value="{$file['file_name']}" size="30" maxlength="50" /></li>
<!--#if($settings['open_tag']){#-->
<li><?=__('file_tag')?>[<?=__('file_tag_tips')?>](<?=__('optional')?>):</li>
<li><input type="text" name="file_tag" value="{$file['file_tag']}" size="30" maxlength="50" /></li>
<!--#}#-->
<li><?=__('file_description')?>(<?=__('optional')?>): </li>
<li><textarea name="file_description" style="width:250px; height:80px;">{$file['file_description']}</textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.file_name.value.strtrim().length <2){
		alert("<?=__('file_min_max')?>");
		o.file_name.focus();
		return false;
	}

}
</script>
<!--#
}elseif($action =='file_delete'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=public")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li>{#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('delete_file_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}#-->
