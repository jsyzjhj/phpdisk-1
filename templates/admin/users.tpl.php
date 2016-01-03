<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: users.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='index' || $action =='search'){#-->
<div id="container">
<h1><?=__('user_list')?><!--#sitemap_tag(__('user_list'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_list_tips')?></span>
</div>
<form name="search_frm" action="{#urr(ADMINCP,"")#}" method="get" onsubmit="return dosearch(this);">
<input type="hidden" name="item" value="users" />
<input type="hidden" name="action" value="search" />
<div class="search_box">
<div class="l"><img src="{$admin_tpl_dir}images/it_nav.gif" align="absbottom" /><?=__('view_group_type')?>: 
<select id="gid" onchange="chg_gid();">
<option value="0" class="txtgreen" {#ifselected(0,$gid);#}><?=__('all_users')?></option>
<!--#
if(count($groups)){
	foreach($groups as $v){
#-->
<option value="{$v['gid']}" class="{$v['txtcolor']}" {#ifselected($v['gid'],$gid);#}>{$v['group_name']}</option>
<!--#
	}
	unset($groups);
}
#-->
</select>&nbsp;
<?=__('view_mode')?>: 
<select id="orderby" onchange="chg_orderby();">
<option value="0" class="txtgreen"><?=__('please_select')?></option>
<option value="time_asc" {#ifselected('time_asc',$orderby,'str');#}><?=__('time_asc')?></option>
<option value="time_desc" {#ifselected('time_desc',$orderby,'str');#}><?=__('time_desc')?></option>
<option value="is_locked" {#ifselected('is_locked',$orderby,'str');#}><?=__('is_locked')?></option>
</select>
</div>
<div class="r"><input type="text" name="word" value="{$word}" title="<?=__('search_users_tips')?>" /> <input type="submit" class="btn" value="<?=__('search_users')?>" /></div>
</div>
</form>
<div class="clear"></div>
<script language="javascript">
function chg_gid(){
	var gid = parseInt(getId('gid').value);
	document.location.href = '{#urr(ADMINCP,"item=users&menu=user&action=index&gid='+gid+'")#}';
}
function chg_orderby(){
	var orderby = getId('orderby').value.strtrim();
	var gid = parseInt(getId('gid').value);
	document.location.href = '{#urr(ADMINCP,"item=users&menu=user&action=index&gid='+gid+'&orderby='+orderby+'")#}';
}
function dosearch(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<form action="{#urr(ADMINCP,"item=users&menu=user")#}" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="index" />
<input type="hidden" name="task" value="move" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%" class="bold"><?=__('user_name')?> / <?=__('user_credit')?></td>
	<td align="center" class="bold"><?=__('user_email')?></td>
	<td align="center" width="80" class="bold"><?=__('user_group')?></td>
	<td align="center" width="150" class="bold"><?=__('reg_time')?></td>
	<td align="center" class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($users)){
	foreach($users as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>
	<!--#if($v['is_admin']){#-->
	<input type="checkbox" disabled="disabled"  />
	<!--#}else{#-->
	<input type="checkbox" name="userids[]" id="userids" value="{$v['userid']}"  /> 
	<!--#}#-->
	<a href="{$v['a_user_edit']}">{$v['username']}</a> <span class="txtgray" title="<?=__('credit')?>">{$v['credit']}</span>
	</td>
	<td align="center">{$v['email']}</td>
	<td align="center">{$v['group_name']}</td>
	<td align="center" class="txtgray">{$v['reg_time']}</td>
	<td align="center">
	<a href="{$v['a_user_edit']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_user_viewfile']}"><?=__('view')?></a>	
	<!--#if(!$v['is_admin']){#-->
	<a href="{$v['a_user_lock']}">{$v['status_text']}</a>
	<a href="{$v['a_user_delete']}" onclick="return confirm('<?=__('user_delete_confirm')?>');"><?=__('delete')?></a>
	<!--#}#-->
	</div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
	</td>
</tr>	
<!--#
	}
	unset($users);
#-->
<tr>
	<td width="30%" class="bold"><?=__('user_name')?> / <?=__('user_credit')?></td>
	<td align="center" class="bold"><?=__('user_email')?></td>
	<td align="center" width="80" class="bold"><?=__('user_group')?></td>
	<td align="center" width="150" class="bold"><?=__('reg_time')?></td>
	<td align="center" class="bold"><?=__('operation')?></td>
</tr>
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.userids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.userids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<?=__('move_to')?>: 
	<select name="dest_gid">
	<option value="0" class="txtgreen"><?=__('please_select')?></option>
	<!--#
	if(count($mini_groups)){
		foreach($mini_groups as $v){
	#-->
	<option value="{$v['gid']}" class="{$v['txtcolor']}">{$v['group_name']}</option>
	<!--#
		}
		unset($mini_groups);
	}
	#-->
	</select>&nbsp;&nbsp;<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<!--#	
}else{	
#-->
<tr>
	<td align="center" colspan="6"><?=__('user_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("userids[]") != true){
		alert("<?=__('please_select_move_users')?>");
		return false;
	}
	if(o.dest_gid.value ==0){
		alert("<?=__('please_select_dest_gid')?>");
		o.dest_gid.focus();
		return false;
	}
}
</script>
</div>
</div>
<!--#}elseif($action =='add_user'){#-->
<div id="container">
<h1><?=__('add_user')?><!--#sitemap_tag(__('add_user'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_user_tips')?></span>
</div>
<form name="user_frm" action="{#urr(ADMINCP,"item=users&menu=user")#}" method="post" onsubmit="return dosubmit1(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%" class="bold"><?=__('user_name')?> :</td>
	<td><input type="text" name="username" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_passwd')?> :</td>
	<td><input type="password" name="password" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('confirm_passwd')?> :</td>
	<td><input type="password" name="confirm_password" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_email')?> :</td>
	<td><input type="text" name="email" value="" maxlength="50" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_group')?> :</td>
	<td>
	<select name="gid">
	<!--#
	if(count($groups)){
		foreach($groups as $v){
	#-->
	<option value="{$v['gid']}" class="{$v['txtcolor']}" {#ifselected($v['gid'],$default_gid)#}>{$v['group_name']}</option>
	<!--#
		}
	}
	unset($groups);
	#-->
	</select>
	</td>
</tr>
<tr>
	<td class="bold"><?=__('user_status')?> :</td>
	<td><input type="radio" name="is_locked" id="lock" value="1" /><label for="lock"><?=__('user_locked')?></label>&nbsp;
	<input type="radio" name="is_locked" id="open" value="0" checked/><label for="open"><?=__('user_open')?></label></td>
</tr>
<tr>
	<td class="bold"><?=__('active_user')?> :</td>
	<td><input type="radio" name="is_activated" id="ia1" value="1" /><label for="ia1"><?=__('yes')?></label>&nbsp;
	<input type="radio" name="is_activated" id="ia2" value="0" checked/><label for="ia2"><?=__('no')?></label></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_credit')?> :</span><br /><span class="txtgray"><?=__('user_credit_tips')?></span></td>
	<td><input type="text" name="credit" value="{$settings['credit_reg']}" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_wealth')?> :</span><br /><span class="txtgray"><?=__('user_wealth_tips')?></span></td>
	<td><input type="text" name="wealth" value="0" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_rank')?> :</span><br /><span class="txtgray"><?=__('user_rank_tips')?></span></td>
	<td><input type="text" name="rank" value="0" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_exp')?> :</span><br /><span class="txtgray"><?=__('user_exp_tips')?></span></td>
	<td><input type="text" name="exp" value="0" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_store_space')?> :</span><br /><span class="txtgray"><?=__('user_store_space_tips')?></span></td>
	<td><input type="text" name="user_store_space" value="0" maxlength="30" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_file_types')?> :</span><br /><span class="txtgray"><?=__('user_file_types_tips')?></span></td>
	<td><input type="text" name="user_file_types" value="" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" id="s1" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn"  onclick="javascript:history.back();" value="<?=__('btn_back')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('username_error')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6 || o.password.value.strtrim().length >20){
		alert("<?=__('password_error')?>");
		o.password.focus();
		return false;
	}
	if(o.password.value.strtrim() != o.confirm_password.value.strtrim()){
		alert("<?=__('confirm_pwd_not_same')?>");
		o.confirm_password.focus();
		return false;
	}
	if(o.email.value.strtrim() <6 || o.email.value.strtrim().indexOf('@') ==-1 || o.email.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('invalid_email')?>");
		o.email.focus();
		return false;
	}
	getId('s1').disabled = true;
	getId('s1').value = "<?=__('txt_processing')?>";
	
}
</script>
</div>
</div>
<!--#}elseif($action =='user_edit'){#-->
<div id="container">
<h1><?=__('user_edit')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_edit_tips')?></span>
</div>
<form name="user_frm" action="{#urr(ADMINCP,"item=users&menu=user")#}" method="post" onsubmit="return doedit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<input type="hidden" name="uid" value="{$uid}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold"><?=__('uid')?> :</td>
	<td>{$uid}</td>
</tr>
<tr>
	<td width="50%" class="bold"><?=__('user_name')?> :</td>
	<td>{$user['username']}</td>
</tr>
<tr>
	<td class="bold"><?=__('user_passwd')?> :</td>
	<td><input type="text" name="password" value="" maxlength="20" /> <span class="txtgray"><?=__('no_edit_passwd_tips')?></span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_email')?> :</td>
	<td><input type="text" name="email" value="{$user['email']}" maxlength="50" /></td>
</tr>
<tr>
	<td class="bold"><?=__('user_group')?> :</td>
	<td>
	<select name="gid">
	<!--#
	if(count($groups)){
		foreach($groups as $v){
	#-->
	<option value="{$v['gid']}" class="{$v['txtcolor']}" {#ifselected($v['gid'],$user['gid']);#}>{$v['group_name']}</option>
	<!--#
		}
	}
	unset($groups);
	#-->
	</select>
	</td>
</tr>
<tr>
	<td class="bold"><?=__('user_status')?> :</td>
	<td><input type="radio" name="is_locked" id="lock" value="1" {#ifchecked($user['is_locked'],1)#} /><label for="lock"><?=__('user_locked')?></label>&nbsp;
	<input type="radio" name="is_locked" id="open" value="0" {#ifchecked($user['is_locked'],0)#} /><label for="open"><?=__('user_open')?></label></td>
</tr>
<tr>
	<td class="bold"><?=__('active_user')?> :</td>
	<td><input type="radio" name="is_activated" id="ia1" value="1" {#ifchecked($user['is_activated'],1)#}/><label for="ia1"><?=__('yes')?></label>&nbsp;
	<input type="radio" name="is_activated" id="ia2" value="0" {#ifchecked($user['is_activated'],0)#}/><label for="ia2"><?=__('no')?></label></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_credit')?> :</span><br /><span class="txtgray"><?=__('user_credit_tips')?></span></td>
	<td><input type="text" name="credit" value="{$user['credit']}" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_wealth')?> :</span><br /><span class="txtgray"><?=__('user_wealth_tips')?></span></td>
	<td><input type="text" name="wealth" value="{$user['wealth']}" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_rank')?> :</span><br /><span class="txtgray"><?=__('user_rank_tips')?></span></td>
	<td><input type="text" name="rank" value="{$user['rank']}" size="10" maxlength="10" />{#get_rank($user['rank'])#}</td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_exp')?> :</span><br /><span class="txtgray"><?=__('user_exp_tips')?></span></td>
	<td><input type="text" name="exp" value="{$user['exp']}" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_store_space')?> :</span><br /><span class="txtgray"><?=__('user_store_space_tips')?></span></td>
	<td><input type="text" name="user_store_space" value="{$user['user_store_space']}" maxlength="30" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_file_types')?> :</span><br /><span class="txtgray"><?=__('user_file_types_tips')?></span></td>
	<td><input type="text" name="user_file_types" value="{$user['user_file_types']}" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/>&nbsp;&nbsp;<input type="button" class="btn"  onclick="javascript:history.back();" value="<?=__('btn_back')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
function doedit(o){
	if(o.email.value.strtrim() <6 || o.email.value.strtrim().indexOf('@') ==-1 || o.email.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('invalid_email')?>");
		o.email.focus();
		return false;
	}
}
</script>
</div>
</div>
<!--#}elseif($action =='active'){#-->
<div id="container">
<h1><?=__('user_active')?><!--#sitemap_tag(__('user_active'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_active_tips')?></span>
</div>
<form name="user_frm" action="{#urr(ADMINCP,"item=users&menu=user")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('user_active_type')?>:</span><br /><span class="txtgray"><?=__('user_active_type_tips')?></span></td>
	<td>
	<select name="setting[user_active]">
	<option value="0" {#ifselected($settings[user_active],0)#}><?=__('not_need')?></option>
	<option value="1" {#ifselected($settings[user_active],1)#}><?=__('need_email')?></option>
	</select>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_active_curr')?>:</span><br /><span class="txtgray"><?=__('user_active_curr_tips')?></span></td>
	<td>
	<select name="user_active_curr">
	<option value="1"><?=__('user_active_curr_1')?></option>
	<option value="2"><?=__('user_active_curr_2')?></option>
	<option value="3"><?=__('user_active_curr_3')?></option>
	</select>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#}#-->

