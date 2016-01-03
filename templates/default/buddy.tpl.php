<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: buddy.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='mybuddy' || $action =='whobuddy' || $action =='invite_success' || $action =='search'){
#-->
<div id="container">
<h1>{$buddy_title}</h1>
<div class="tips_box_p">
<div class="tips_box"><b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('tips_buddy')?></span>
</div>
</div>
<!--#if($action !='invite_success'){#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="left">
	<div class="tips_box_p">
	<form action="{#urr("mydisk","item=buddy")#}" method="post" onsubmit="return dosubmit(this);">
	<input type="hidden" name="action" value="{$action}" />
	<input type="hidden" name="task" value="addbuddy" />
	<input type="hidden" name="formhash" value="{$formhash}" />
	<img src="images/addbuddy.gif" align="absbottom" /> <?=__('add_buddy')?>: <input type="text" name="buddy_name" maxlength="30" />&nbsp;<input type="submit" class="btn" value="<?=__('btn_submit')?>" />
	</form>
	</div>
	</td>
	<td align="right">
	<div class="tips_box_p">
	<form action="{#urr("mydisk","")#}" method="get" onsubmit="return dosubmit2(this);">
	<input type="hidden" name="item" value="buddy" />
	<input type="hidden" name="action" value="search" />
	<img src="images/icon_search.gif" align="absbottom" /> <?=__('search_buddy')?>: <input type="text" name="word" maxlength="30" value="{$word}" />
	<select name="scope">
		<option value="my" {#ifselected($scope,'my','str')#}><?=__('my_buddy')?></option>
		<option value="added" {#ifselected($scope,'added','str')#}><?=__('added_buddy')?></option>
		<option value="all" {#ifselected($scope,'all','str')#}><?=__('all_buddy')?></option>
	</select>
	<input type="submit" class="btn" value="<?=__('btn_search')?>" />
	</form>
	</div>
	</td>
</tr>
</table>	
<!--#}#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<!--#if($action =='invite_success'){#-->
	<td width="20%" class="bold"><?=__('invited_buddy')?></td>
	<td width="150" class="bold"><?=__('invite_time')?></td>
	<!--#}else{#-->
	<td width="20%" class="bold"><?=__('my_buddy')?></td>
	<td width="150" class="bold"><?=__('buddy_time')?></td>
	<!--#}#-->
	<td class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($buddys_arr)){
	 foreach($buddys_arr as $k => $v){
	 	$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><a href="{$v['a_space']}" target="_blank" title="<?=__('view_buddy')?>">{$v['username']}</a></td>
	<td><span class="txtgray">{$v['in_time']}</span></td>
	<td>
	<!--#if($action =='mybuddy'){#-->
	<a href="javascript:;" onclick="abox('{$v['a_sendmsg']}','<?=__('send_msg')?>',500,300);"><img src="images/msg.gif" align="absbottom" border="0" /><?=__('send_msg')?></a>&nbsp;&nbsp;
	<a href="javascript:;" onclick="abox('{$v['a_delbuddy']}','<?=__('del_buddy')?>',400,200);"><img src="images/delbuddy.gif" align="absbottom" border="0" /><?=__('del_buddy')?></a>
	<!--#}elseif($action =='invite_success'){#-->
	<a href="javascript:;" onclick="abox('{$v['a_sendmsg']}','<?=__('send_msg')?>',500,300);"><img src="images/msg.gif" align="absbottom" border="0" /><?=__('send_msg')?></a>&nbsp;&nbsp;
	<!--#}else{#-->
	<a href="javascript:;" onclick="abox('{$v['a_addbuddy']}','<?=__('add_buddy')?>',400,200);"><img src="images/addbuddy.gif" align="absbottom" border="0" /><?=__('add_buddy')?></a>
	<!--#}#-->
	</td>
</tr>
<!--#	 
	 }
	 unset($buddys_arr);
}else{
#-->
<tr>
	<td colspan="4"><?=__('buddy_not_found')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="4">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.buddy_name.value.strtrim().length <2){
		alert("<?=__('username_not_found')?>");
		o.buddy_name.focus();
		return false;
	}
}
function dosubmit2(o){
	if(o.word.value.strtrim().length <2){
		o.word.focus();
		return false;
	}
}
</script>
<!--#}elseif($action =='delbuddy'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=buddy")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="userid" value="{$userid}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li><?=__('my_buddy')?> <span class="txtred">{$buddy_name}</span></li>
<li><?=__('delete_buddy_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}if($action =='s_addbuddy'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=buddy")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="userid" value="{$userid}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li><?=__('add_buddy')?> <span class="txtgreen">{$buddy_name}</span></li>
<li><?=__('add_buddy_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="self.parent.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}elseif($action =='invite'){#-->
<div id="container">
<h1><?=__('buddy_invite')?></h1>
<div class="tips_box_p">
<div class="tips_box"><b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('tips_buddy_invite')?></span>
</div>
</div>
<br /><br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><?=__('invite_link')?>：<input type="text" id="ivt" value="{$invite_url}" onclick="getId('ivt').select();copy_text('ivt');" size="80" maxlength="100" readonly /></td>
</tr>
</table>
<br /><br /><br /><br />
</div>
<script language="javascript">
function copy_text(id){
	var field = getId(id);
	if (field){
		if (document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('copy_success')?>");
		}else{
			alert("<?=__('alert_ie_copytext')?>");
		}	
	}
}
</script>
<!--#}#-->