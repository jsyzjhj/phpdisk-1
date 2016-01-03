<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: files.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action == 'index' || $action =='detail'){
#-->
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
function show_folder(){
	if(getId('sub_folder_list').style.display =='none'){
		getId('sub_folder_list').style.display = '';
		getId('hf_txt').innerHTML = "<?=__('hidden_sub_folder')?>";
		getId('img_sub_icon').src = "images/ico_desc.gif";
		setCookie('mydisk_show_folder_',1,30);
	}else{
		getId('sub_folder_list').style.display = 'none';
		getId('hf_txt').innerHTML = "<?=__('expand_sub_folder')?>";
		getId('img_sub_icon').src = "images/ico_add.gif";
		setCookie('mydisk_show_folder_',0,30);
	}
}
</script>
<!--# require_once template_echo('my_nav_bar',$user_tpl_dir);#-->
<form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="4"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><a href="{#urr("mydisk","item=files&action=index")#}"><img src="images/disk.gif" border="0" align="absmiddle" /><?=__('root_folder')?></a>
<!--#if($folder_node){#-->
	<!--#if($folder_node ==4){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$disk_href}">{$disk_name}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$parent_href2}">{$parent_folder2}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$parent_href}">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name} <span class="txtgray">{$folder_description}{$folder_stat}</span>
	<!--#}elseif($folder_node ==3){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$disk_href}">{$disk_name}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$parent_href}">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name} <span class="txtgray">{$folder_description}{$folder_stat}</span>
	<!--#}elseif($folder_node ==2){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="{$parent_href}">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name} <span class="txtgray">{$folder_description}{$folder_stat}</span>
	<!--#}else{#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;{$folder_name} <span class="txtgray">{$folder_description}{$folder_stat}</span>
	<!--#}#-->
<!--#}#-->
	</td>
</tr>
<!--#if($action =='index'){#-->  
<tr>
	<td width="50%" class="bold"><a href="{$n_url}"><?=__('file_name')?>{$n_order}</a></td>
	<td align="center" class="bold"><a href="{$s_url}"><?=__('file_size')?>{$s_order}</a></td>
	<td align="center" width="150" class="bold"><a href="{$t_url}"><?=__('file_upload_time')?>{$t_order}</a></td>
	<td align="right" width="150" class="bold"><?=__('operation')?></td>
</tr>
<!--#}#-->
<!--# if($action =='detail'){#-->
    <tr>
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
      <td class="ul_detail" width="25%" valign="top">
	  <li><a href="{$v['a_downfile']}" title="<?=__('download')?>">{#file_icon($v['file_extension'],'filetype_32')#}</a></li>
		<li><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />
		<a href="{$v['a_viewfile']}" target="_blank">{$v['file_name']}</a>
		</li>
		<!--# if($v['is_image']){#-->
		<li><img src="{$v['file_thumb']}" align="absmiddle" border="0" /></li>
		<!--#}#-->
		<!--#if($v['file_description']){#-->
        <li class="txtgray"><?=__('file_description')?>：{$v['file_description']}</li>
		<!--#}#-->
        <li class="txtgray"><?=__('file_size')?>：{$v['file_size']}</li>
        <li class="txtgray"><?=__('file_upload_time')?>：{$v['file_time']}</li>
        <li><span class="txtgray" style="display:none"><?=__('operation')?>：<a href="javascript:;" onclick="abox('{$v[a_file_modify]}','<?=__('file_modify')?>',400,280);" title="<?=__('modify')?>"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a> <a href="javascript:;" onclick="abox('{$v[a_file_delete]}','<?=__('file_delete')?>',400,200);" title="<?=__('delete')?>"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a></span></li>
		</td>
<!--#
	if(($k+1)%4 ==0) { echo "</tr><tr>";}
	}
}	
#-->
    </tr>
<!--#}else{#-->
<tbody id="ajax_file">
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />&nbsp;<a href="{$v['a_downfile']}" title="<?=__('total_space')?><?=__('download')?>">{#file_icon($v['file_extension'])#}</a>&nbsp;
	<!--#if($v['is_image']){#-->
		<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank">{$v['file_name']}</a>
	<span class="txtgray">{$v['file_description']}</span><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','','');</script>
	<!--#}else{#-->
		<a href="{$v['a_viewfile']}" target="_blank">{$v['file_name']}</a>
	<span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center">{$v['file_size']}</td>
	<td align="center"  class="txtgray">{$v['file_time']}</td>
	<td align="right">
	<!--#if($v['in_share']){#-->
	<a href="javascript:;" onclick="abox('{$v['a_file_unshare']}','<?=__('file_unshare')?>',400,200);" title="<?=__('file_unshare')?>"><img src="images/share_file.gif" border="0" align="absmiddle" /></a>
	<!--#}#-->
	<!--#if($settings['open_file_outlink']){#-->
	<a href="javascript:void(0);" id="pl_{$k}"title="<?=__('out_link')?>"><img src="images/ico_link.gif" border="0" align="absmiddle" /></a>
	<div id="cl_{$k}" class="menu_thumb"><input type="text" size="30" id="file_out_link_{$k}" value="{$v['file_out_link']}" readonly title="<?=__('out_link')?>" /><input type="button" value="<?=__('copy')?>" class="btn" onclick="getId('file_out_link_{$k}').select();copy_text('file_out_link_{$k}');" /></div>
<script type="text/javascript">on_menu('pl_{$k}','cl_{$k}','-x','','');</script>
	<!--#}#-->
	<!--#if($settings['open_file_extract_code']){#-->
	<a href="###" id="pe_{$k}" title="<?=__('extract_code')?>"><img src="images/ico_code.gif" border="0" align="absmiddle" /></a>
	<div id="ce_{$k}" class="menu_thumb"><input type="text" size="8" value="{$v['file_key']}" id="file_key_{$k}" readonly title="<?=__('extract_code')?>" /><input type="button" value="<?=__('copy')?>" class="btn" onclick="getId('file_key_{$k}').select();copy_text('file_key_{$k}');" /></div>
<script type="text/javascript">on_menu('pe_{$k}','ce_{$k}','-x','','');</script>
	<!--#}#-->
	<a href="javascript:;" onclick="abox('{$v['a_file_modify']}','<?=__('file_modify')?>',400,280);" title="<?=__('modify')?>"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>
	<a href="javascript:;" onclick="abox('{$v['a_file_delete']}','<?=__('file_delete')?>',400,200);" title="<?=__('delete')?>"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a>
	</td>
</tr>
<!--#		
	}
}else{
#-->
<tr class="color4">
	<td align="center" colspan="6">
	<!--#if($action == 'search'){#-->
	<?=__('search_is_empty')?>
	<!--#}else{#-->
	<?=__('folder_is_empty')?>
	<!--#}#-->
	</td>
</tr>
<!--#}#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
<!--#
if(count($files_array)){
#-->
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.file_form.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_form.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<span id="dest_folder">
	<select name="dest_folder" style="width:120px">
	<option value="-1" class="txtgreen"><?=__('please_select')?></option>
	{$option_folder_4}
	</select>&nbsp;
	</span>
	<span id="public_cate" style="display:none">
	<select name="public_cate" style="width:120px">
	<option value="-1" class="txtgreen"><?=__('please_select')?></option>
	{$pub_menu_option}
	</select>&nbsp;
	</span>
	<input type="radio" id="to_folder" name="task" value="to_folder" checked="checked" onclick="chk_folder();"/><label for="to_folder"><?=__('my_folder')?></label>&nbsp;
	<input type="radio" id="to_public" name="task" value="to_public" onclick="chk_public();"/><label for="to_public"><?=__('to_public')?></label>&nbsp;
	<input type="radio" id="to_extract" name="task" value="to_extract"/><label for="to_extract"><?=__('make_extract_code')?></label>&nbsp;
	<input type="radio" id="is_link_code" name="task" value="is_link_code"/><label for="is_link_code"><?=__('is_link_code')?></label>&nbsp;
	<input type="radio" id="to_share" name="task" value="to_share"/><label for="to_share"><?=__('to_share')?></label>&nbsp;
	<input type="radio" id="file_delete" name="task" value="file_delete"/><label for="file_delete"><span class="txtred"><?=__('move_to_recycle')?></span></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>" onclick="return confirm('<?=__('confirm_op')?>');" />
	</td>
</tr>
<!--#
}
#-->

</tbody>
<!--#}#-->
</table>
</form>
</div>
<script language="javascript">
function chk_folder(){
	if(getId('to_folder').checked ==true){
		getId('dest_folder').style.display = '';
		getId('public_cate').style.display = 'none';
	}else{
		getId('dest_folder').style.display = 'none';
		getId('public_cate').style.display = '';
	}
}
function chk_public(){
	if(getId('to_public').checked ==true){
		getId('dest_folder').style.display = 'none';
		getId('public_cate').style.display = '';
	}else{
		getId('dest_folder').style.display = '';
		getId('public_cate').style.display = 'none';
	}
}
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
<!--#
}elseif($action =='file_modify'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=files")#}" method="post" onsubmit="return dosubmit(this);">
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
<li><?=__('in_share')?>:</li>
<li><input type="radio" name="in_share" value="1" {#ifchecked($file['in_share'],1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="in_share" value="0" {#ifchecked($file['in_share'],0)#} /><?=__('no')?></li>
<li><?=__('file_description')?>(<?=__('optional')?>): </li>
<li><textarea name="file_description" style="width:250px; height:60px;">{$file['file_description']}</textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.file_name.value.strtrim().length <1){
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
<form action="{#urr("mydisk","item=files")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li>{#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('delete_file_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_delete')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#
}elseif($action =='unshare_file'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=files")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li>{#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('unshare_file_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#
}elseif($action =='set_extract_code' || $action =='extract_modify'){
#-->
<div id="container">
<!--# require_once template_echo('my_nav_bar',$user_tpl_dir);#-->
<form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="extract_id" value="{$extract_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%" class="bold"><?=__('file_name')?></td>
	<td class="bold"><?=__('store_location')?></td>
	<td align="center" width="80" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
</tr>
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}" height="20">
	<td width="40%" class="td_line"><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" checked="checked" />&nbsp;<a href="{$v['a_downfile']}" title="<?=__('download')?>">{#file_icon($v['file_extension'])#}</a>&nbsp;{$v['file_name']}
	</td>
	<td class="td_line txtgray"><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;{$v['store_at']}</td>
	<td align="center" width="80"  class="td_line">{$v['file_size']}</td>
	<td align="center" width="150"  class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
unset($files_array);	
}
#-->
</table>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold f14" colspan="2"><?=__('extract_code_setting')?>:</td>
</tr>
<tr>
	<td width="50%"><span class="bold"><?=__('extract_code_custom')?></span>: <br /><span class="txtgray"><?=__('extract_code_custom_tips')?></span></td>
	<td><input type="text"  name="extract_code_custom" id="extract_code_custom" value="{$default_code}" {$extract_code_status}/>
	<!--#if($extract_code_status){#-->
	<input type="button" class="btn" onclick="getId('extract_code_custom').select();copy_text('extract_code_custom');" value="<?=__('copy')?>" />
	<!--#}#-->
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('extract_type')?></span>: <br /><span class="txtgray"><?=__('extract_type_tips')?></span></td>
	<td><input type="radio" name="extract_type" value="0" {#ifchecked(0,$extract_type)#} /><?=__('order_extract_count')?>&nbsp;&nbsp;<input type="radio" name="extract_type" value="1" {#ifchecked(1,$extract_type)#}/><?=__('order_extract_date')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('extract_total')?></span>: <br /><span class="txtgray"><?=__('extract_total_tips')?></span></td>
	<td><input type="text"  name="extract_total" value="{$extract_total}"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('extract_time')?></span>: <br /><span class="txtgray"><?=__('extract_time_tips')?></span></td>
	<td><input type="text"  name="extract_time" value="{$default_date}"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;
	<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" />
	</td>
</tr>
</table>
</form>
</div>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
	if(o.extract_code_custom.value.strtrim().length >0 && o.extract_code_custom.value.strtrim().length <6){
		alert("<?=__('extract_code_custom_max_min')?>");
		o.extract_code_custom.focus();
		return false;
	}
	if(o.extract_time.value.strtrim().length !=10 || o.extract_time.value.strtrim().indexOf('-') !=4 ){
		alert("<?=__('extract_time_format')?>");
		o.extract_time.focus();
		return false;
	}
}
</script>
<!--#
}else if($action =='extract_code_list'){
#-->
<div id="container">
<!--# require_once template_echo('my_nav_bar',$user_tpl_dir);#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%" class="bold"><?=__('extract_code')?></td>
	<td class="bold" align="center"><?=__('extract_count')?>/<?=__('extract_total')?></td>
	<td align="center" width="80" class="bold"><?=__('extract_type')?></td>
	<td align="center" width="150" class="bold"><?=__('extract_time')?></td>
	<td align="center" width="80" class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td width="40%" class="td_line"><input type="text" id="ext_{$k}" value="{$v['extract_code']}" size="20" readonly/> <input type="button" class="btn" onclick="getId('ext_{$k}').select();copy_text('ext_{$k}');" value="<?=__('copy')?>" />&nbsp;<a href="javascript:;" onclick="abox('{$v['a_view_extract_file']}','<?=__('view_extract_file')?>',440,320);">[<?=__('view')?>]</a></td>
	<td class="td_line txtgray" align="center">{$v['extract_count']}/{$v['extract_total']}</td>
	<td align="center" width="80"  class="td_line">{$v['extract_type_txt']}</td>
	<td align="center" width="150"  class="td_line txtgray">{$v['extract_time']}</td>
	<td align="center" class="td_line txtgray">
	<a href="{$v['a_modify']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;&nbsp;<a href="{$v['a_status']}">{$v['extract_status_text']}</a>
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_modify']}"><?=__('extract_modify')?></a>
	<a href="{$v['a_delete']}" onclick="return confirm('<?=__('extract_delete_confirm')?>');"><?=__('extract_delete')?></a>
	</div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
	</td>
</tr>
<!--#		
	}
unset($files_array);	
}
#-->
<tr>
	<td colspan="5"><input type="button" class="btn" onclick="go('{#urr("mydisk","item=files&action=index")#}');" value="<?=__('extract_add')?>" /></td>
</tr>
<!--#if($page_nav){#-->
<tr>
	<td colspan="5">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>
<!--#}elseif($action =='view_extract_file'){#-->
<div id="container">
<div class="box_style">
<div class="file_box">
<li class="f14"><?=__('file_list')?>:</li>
<!--#
if(count($files_array)){
	foreach($files_array as $v){
#-->
<li><a href="{$v['a_viewfile']}" target="_blank" >{#file_icon($v['file_extension'])#}&nbsp;{$v['file_name']}</a> ({$v['file_size']})</li>
<!--#
	}
	unset($files_array);
}
#-->
</div>
<br />
<div align="center"><input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
</div>
</div>
<!--#
}else if($action =='make_link_code'){
#-->
<div id="container">
<h1><?=__('make_link_title')?></h1>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?></b>:
<span class="txtgray"><?=__('make_link_tips')?></span></div><br />
<div><?=__('make_link_mode')?>: <a href="javascript:void(0);" onclick="get_mode('ubb');">[UBB]</a> - <a href="javascript:void(0);" onclick="get_mode('img');">[IMG]</a> - <a href="javascript:void(0);" onclick="get_mode('img2');">&lt;IMG&gt;</a> - <a href="javascript:void(0);" onclick="get_mode('html');">[HTML]</a> - <a href="javascript:void(0);" onclick="get_mode('url');">[URL]</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="go('{$order_url}');">[<?=__('order_url')?>]</a></div>
<textarea id="link_area" style="width:98%; height:250px"></textarea><br />
<input type="button" class="btn" value="<?=__('copy_text')?>" onclick="getId('link_area').select();copy_text('link_area');" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="go('{#urr("mydisk","item=files&action=index")#}');" />
</div>
<script language="javascript">
var upl_array = new Array();
<!--#
if(count($upl_array)){
	foreach($upl_array as $k => $v){
#-->
upl_array[{$k}] = {"file_name":"{$v['file_name_all']}","file_link":"{$v['file_link']}","file_link_img":"{$v['file_link_img']}"};
<!--#
	}
	unset($upl_array);
}
#-->
function get_mode(type){
	var str = '';
	for(var i=0;i<upl_array.length;i++){
		var file = upl_array[i];
		switch(type){
			case 'ubb':
				var line = '[url=' + file['file_link'] + ']'+file['file_name']+'[/url]';
			break;
			
			case 'img':
				var line = '[img]' + file['file_link_img'] + '[/img]';
			break;
			
			case 'img2':
				var line = '<img src="' + file['file_link_img'] + '" border="0" />';
			break;
			
			case 'html':
				var line = '<a href="' + file['file_link'] + '" >'+file['file_name']+'</a>';
			break;
			
			case 'url':
				var line = file['file_link_img'];
			break;
			
		}
		str += line + "\n";
	}
	if(document.all){
		getId('link_area').innerText = str;
	}else{
		getId('link_area').innerHTML = str;
	}
}
get_mode('ubb');
</script>

<!--#
}elseif($action =='short_url'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=files")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<!--#if($task){#-->
<div id="suc_su_box" style="display:none" class="cfm_info">
{$msg}
<li><?=__('file')?>: {#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('file_cur_url')?>: <a href="{$a_viewfile}" class="txtblue" target="_blank">{$file_cur_url}</a></li>
<li>&nbsp;</li>
<li><?=__('file_short_url')?>: <input type="text" value="{$a_file_short_url}" size="25" readonly /> <a href="{$a_file_short_url}" target="_blank"><?=__('visit_url')?></a></li>
<li>&nbsp;</li>
<li><input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
<!--#}else{#-->
<div class="cfm_info">
{$msg}
<li><?=__('file')?>: {#file_icon($file_extension)#}&nbsp;<span class="txtgreen">{$file_name}</span></li>
<li><?=__('file_cur_url')?>: <a href="{$a_viewfile}" class="txtblue" target="_blank">{$file_cur_url}</a></li>
<li>&nbsp;</li>
<li><?=__('add_file_short_url_confirm')?></li>
<li><?=__('file_short_url_format')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
<!--#}#-->
</form>
</div>
</div>
<!--#
}
#-->
<script language="javascript">
function copy_text(id){
	var field = getId(id);
	if (field){
		if(document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('copy_success')?>");
		}	
	}
}
</script>
