<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: groups.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='index'){#-->
<div id="container">
<h1><?=__('user_group_list')?><!--#sitemap_tag(__('user_group_list'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?> </b>
<span class="txtgray"><?=__('user_group_list_tips')?></span>
</div>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($groups)){
#-->
<tr>
	<td width="40%" class="bold"><?=__('group_name')?></td>
	<td align="center" class="bold"><?=__('user_count')?></td>
	<td align="center" width="80" class="bold"><?=__('group_type')?></td>
	<td align="center" width="150" class="bold"><?=__('group_server')?></td>
	<td align="center" class="bold"><?=__('operation')?></td>
</tr>

<!--#
	foreach($groups as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>&nbsp;&nbsp;<a href="{$v['a_view']}" title="<?=__('view')?>">{$v['group_name']}</a></td>
	<td align="center">{$v['user_count']}</td>
	<td align="center">{$v['group_type_txt']}</td>
	<td align="center">{$v['group_server']}</td>
	<td align="center">
	<a href="{$v['a_group_setting']}"><?=__('group_setting')?></a>&nbsp;
	<a href="{$v['a_group_modify']}"><?=__('group_modify')?></a>&nbsp;
	<!--#if(!$v['group_type']){#-->
	<a href="{$v['a_group_delete']}" onclick="return confirm('<?=__('group_delete_confirm')?>');"><?=__('delete')?></a>
	<!--#}#-->
	</td>
</tr>	
<!--#
	}
	unset($groups);
}	
#-->
<tr>
	<td colspan="5"><input type="button" class="btn" onclick="go('{#urr(ADMINCP,"item=groups&menu=user&action=group_create")#}');" value="<?=__('create_group')?>" /></td>
</tr>
</table>
</div>
</div>
<!--#}elseif($action =='group_create' || $action =='group_modify'){#-->
<div id="container">
<h1><?=__('user_group_create')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_group_create_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=groups&menu=user")#}" method="post" onsubmit="return chkform(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="gid" value="{$gid}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('group_name')?></span>: <br /><span class="txtgray"><?=__('group_name_tips')?></span></td>
	<td><input type="text" name="group_name" value="{$group_name}" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
<script language="javascript">
function chkform(o){
	if(o.group_name.value.strtrim().length <2){
		alert("<?=__('js_group_name_error')?>");
		o.group_name.focus();
		return false;
	}	
}
</script>
</div>
</div>
<!--#}elseif($action =='group_setting'){#-->
<div id="container">
<h1><?=__('user_group_setting')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_group_setting_tips')?></span>
</div>
<div class="search_box">
<div class="l"><img src="{$admin_tpl_dir}images/it_nav.gif" align="absbottom" /><a href="{#urr(ADMINCP,"item=groups&menu=user&action=index")#}"><b><?=__('all_group_name')?></b></a>: {$group_set['group_name']}</div>
</div>
<div class="clear"></div>
<form action="{#urr(ADMINCP,"item=groups&menu=user")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="gid" value="{$gid}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><b><?=__('max_flow_down')?></b>: <br /><span class="txtgray"><?=__('max_flow_down_tips')?></span></td>
	<td><input type="text" name="max_flow_down" value="{$group_set['max_flow_down']}"/> <?=__('setting_tips')?></td>
</tr>
<tr>
	<td><b><?=__('max_flow_view')?></b>: <br /><span class="txtgray"><?=__('max_flow_view_tips')?></span></td>
	<td><input type="text" name="max_flow_view" value="{$group_set['max_flow_view']}"/></td>
</tr>
<tr>
	<td><b><?=__('max_storage')?></b>: <br /><span class="txtgray"><?=__('max_storage_tips')?></span></td>
	<td><input type="text" name="max_storage" value="{$group_set['max_storage']}"/></td>
</tr>
<tr>
	<td><b><?=__('max_filesize')?></b>: <br /><span class="txtgray"><?=__('max_filesize_tips')?></span></td>
	<td><input type="text" name="max_filesize" value="{$group_set['max_filesize']}"/></td>
</tr>
<tr>
	<td><b><?=__('group_file_types')?></b>: <br /><span class="txtgray"><?=__('group_file_types_tips')?></span></td>
	<td><input type="text" name="group_file_types" size="50" value="{$group_set['group_file_types']}"/></td>
</tr>
<tr>
	<td><b><?=__('max_folders')?></b>: <br /><span class="txtgray"><?=__('max_folders_tips')?></span></td>
	<td><input type="text" name="max_folders" value="{$group_set['max_folders']}"/></td>
</tr>
<tr>
	<td><b><?=__('max_files')?></b>: <br /><span class="txtgray"><?=__('max_files_tips')?></span></td>
	<td><input type="text" name="max_files" value="{$group_set['max_files']}"/></td>
</tr>
<tr>
	<td><b><?=__('can_share')?></b>: <br /><span class="txtgray"><?=__('can_share_tips')?></span></td>
	<td><input type="radio" name="can_share" value="1" {#ifchecked(1,$group_set['can_share'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="can_share" value="0" {#ifchecked(0,$group_set['can_share'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><b><?=__('secs_loading')?></b>: <br /><span class="txtgray"><?=__('secs_loading_tips')?></span></td>
	<td><input type="text" name="secs_loading" value="{$group_set['secs_loading']}"/></td>
</tr>
<tr>
	<td><b><?=__('server_ids')?></b>: <br /><span class="txtgray"><?=__('server_ids_tips')?></span></td>
	<td>
	<select name="server_ids[]" multiple="multiple" size="5">
	<!--#
	if(count($server_arr)){
		foreach($server_arr as $v){
	#-->
	<option value="{$v['server_oid']}" {#multi_selected($v['server_oid'],$group_set['server_ids'])#}>{$v['server_name']}</option>
	<!--#
		}
		unset($server_arr);
	}
	#-->
	</select>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#}#-->
