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
<!--#if($action =='category'){#-->
<div id="container">
<h1><?=__('category_title')?><!--#sitemap_tag(__('category_title'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('category_title_tips')?></span>
</div>
<form name="link_form" action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#
if(count($cates)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('show_order')?>/<?=__('cate_name')?></td>
	<td align="center" class="bold"><?=__('file_num')?></td>
	<td align="right" width="100" class="bold"><?=__('operation')?></td>
</tr>
{$cate_list}
<!--#
}else{	
#-->
<tr>
	<td colspan="6" align="center"><?=__('category_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td align="center" colspan="5">
	<input type="button" class="btn" value="<?=__('add_cate')?>" onclick="go('{#urr(ADMINCP,"item=$item&menu=file&action=add_cate")#}');" />&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_update')?>"/>
	</td>
</tr>
</table>
</form>
</div>
</div>
<!--#}elseif($action =='add_cate' || $action =='modify_cate'){#-->
<div id="container">
<!--#if($action =='add_cate'){#-->
<h1><?=__('add_cate_title')?></h1>
<!--#}else{#-->
<h1><?=__('modify_cate_title')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_cate_title_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="cate_id" value="{$cate_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><span class="bold"><?=__('pid')?>:</span><br /><span class="txtgray"><?=__('pid_tips')?></span></td>
	<td>
	<select name="pid">
	<option value="0" style="color:#008800"><?=__('top_cate')?></option>
	<!--#
	if(count($cate_arr)){
		foreach($cate_arr as $v){
	#-->
	<option value="{$v['cate_id']}" {#ifselected($pid,$v['cate_id'])#}>{$v['cate_name']}</option>
	<!--#
		}
		unset($cate_arr);
	}
	#-->
	</select>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('cate_name')?>:</span><br /><span class="txtgray"><?=__('cate_name_tips')?></span></td>
	<td><input type="text" name="cate_name" value="{$cate_name}" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('is_hidden')?>:</span><br /><span class="txtgray"><?=__('is_hidden_tips')?></span></td>
	<td><input type="radio" name="is_hidden" value="1" {#ifchecked($is_hidden,1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="is_hidden" value="0" {#ifchecked($is_hidden,0)#} /><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.cate_name.value.strtrim().length <1){
		alert("<?=__('cate_name_error')?>");
		o.cate_name.focus();
		return false;
	}
}
</script>
<!--#}elseif($action =='viewfile'){#-->
<div id="container">
<h1><?=__('file_manage')?><!--#sitemap_tag(__('file_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_setting_tips')?></span>
</div>
<div class="search_box">
<img src="{$admin_tpl_dir}images/it_nav.gif" align="absbottom" />
<?=__('view_mode')?>: 
<select name="view" id="view" onchange="chg_view();">
<option value="public_file" {#ifselected('public_file',$view,'str');#}><?=__('public_file')?></option>
<option value="temp_file" {#ifselected('temp_file',$view,'str');#}><?=__('temp_file')?></option>
</select>
</div>
<form name="file_frm" action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('file_name')?></td>
	<td align="center" width="10%" class="bold"><?=__('file_status')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td width="100" class="bold"><?=__('file_upload_time')?></td>
	<td align="center" width="100" class="bold"><?=__('upload_ip')?></td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />&nbsp;<a href="{$v['a_downfile']}" title="<?=__('download')?>">{#file_icon($v['file_extension'])#}</a>&nbsp;
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}" {$v[in_yun]}>{$v['file_name']}</a><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}" {$v[in_yun]}>{$v['file_name']}</a>
	<!--#}#-->
	</td>
	<td align="center">{$v['status_txt']}</td>
	<td align="center">{$v['file_size']}</td>
	<td class="txtgray">{$v['file_time']}</td>
	<td align="center" class="txtgray">{$v['ip']}</td>
</tr>
<!--#		
	}
	unset($files_array);
#-->
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.file_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="check_file" checked="checked" /><?=__('check_file')?> 
	<input type="radio" name="task" value="delete" /><span class="txtred"><?=__('delete')?></span>
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
<!--#		
}else{
#-->
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</form>
</div>
</div>
<script language="javascript">
function chg_view(){
	var view = getId('view').value.strtrim();
	document.location.href = '{#urr(ADMINCP,"item=$item&menu=file&action=$action&view='+view+'")#}';
}
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
</script>
<!--#}else{#-->
<div id="container">
<h1><?=__('public_setting')?><!--#sitemap_tag(__('public_setting'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_setting_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('check_public_file')?></span>: <br /><span class="txtgray"><?=__('check_public_file_tips')?></span></td>
	<td><input type="radio" name="setting[check_public_file]" value="1" {#ifchecked(1,$setting['check_public_file'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[check_public_file]" value="0" {#ifchecked(0,$setting['check_public_file'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('file_to_public_checked')?></span>: <br /><span class="txtgray"><?=__('file_to_public_checked_tips')?></span></td>
	<td><input type="radio" name="setting[file_to_public_checked]" value="0" {#ifchecked(0,$setting['file_to_public_checked'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[file_to_public_checked]" value="1" {#ifchecked(1,$setting['file_to_public_checked'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('show_index')?></span>: <br /><span class="txtgray"><?=__('show_index_tips')?></span></td>
	<td><input type="radio" name="setting[show_index]" value="1" {#ifchecked(1,$setting['show_index'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_index]" value="0" {#ifchecked(0,$setting['show_index'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('show_public')?></span>: <br /><span class="txtgray"><?=__('show_public_tips')?></span></td>
	<td><input type="radio" name="setting[show_public]" value="1" {#ifchecked(1,$setting['show_public'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_public]" value="0" {#ifchecked(0,$setting['show_public'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<!--#}#-->

