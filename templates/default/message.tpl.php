<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: message.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='inbox' || $action =='sendbox'){
#-->
<div id="container">
<h1>{$msg_title}</h1>
<div class="tips_box_p">
<div class="tips_box"><b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('tips_inbox')?></span>
</div>
</div>
<div id="send_btn">
<a href="javascript:;" onclick="abox('{$a_sendmsg}','<?=__('sendmsg')?>',500,300);"><?=__('sendmsg')?></a>&nbsp;
<a href="{#urr("mydisk","item=message&menu=profile&action=inbox")#}" id="a_inbox"><?=__('msg_inbox')?></a>&nbsp;
<a href="{#urr("mydisk","item=message&menu=profile&action=sendbox")#}" id="a_sendbox"><?=__('msg_sendbox')?></a>&nbsp;
</div>
<script language="javascript">
getId('a_{$action}').className = 'bold txtblue';
</script>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="20%" class="bold">
	<!--#if($action =='inbox'){#-->
	<?=__('msg_user')?>
	<!--#}else{#-->
	<?=__('msg_touser')?>
	<!--#}#-->
	</td>
	<td width="50%" class="bold"><?=__('msg_content')?></td>
	<td align="center" width="150" class="bold"><?=__('msg_time')?></td>
	<td width="100" align="center" class="bold"><?=__('operation')?></td>
</tr>
<!--#
if(count($msg_array)){
	 foreach($msg_array as $k => $v){
		 $color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><a href="{$v['a_space']}" target="_blank">{$v['username']}</a></td>
	<td><a href="javascript:;" onclick="abox('{$v['a_view_content']}','<?=__('manage_msg')?>',500,300);">{$v['short_content']}({$v['ctn_total']}<?=__('byte')?>)</a></td>
	<td align="center"><span class="txtgray">{$v['in_time']}</span></td>
	<td align="center">
	<!--#if($action =='inbox'){#-->
	<a href="javascript:;" onclick="abox('{$v['a_view_content']}','<?=__('manage_msg')?>',500,300);"><?=__('reply')?></a>&nbsp;<a href="{$v['a_delete']}" onclick="return confirm('<?=__('msg_confirm_delete')?>');"><?=__('delete')?></a>
	<!--#}else{#-->
	<a href="{$v['a_delete']}" onclick="return confirm('<?=__('msg_confirm_delete')?>');"><?=__('delete')?></a>
	<!--#}#-->
	</td>
</tr>
<!--#	 
	 }
	 unset($msg_array);
}else{
#-->
<tr>
	<td colspan="5"><?=__('msg_not_found')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="5">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>
</div>
<!--#}elseif($action =='sendmsg'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=message")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="username" id="username" value="{$username}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('msg_touser')?>:</li>
<li><input type="text" name="touser" id="touser" value="{$username}" size="20" maxlength="50" readonly />&nbsp;
<select id="sel_user" name="sel_user" onchange="on_sel_user();">
<!--#
if(count($sel_users)){
#-->
<option value=""><?=__('please_select')?></option>
<!--#
	foreach($sel_users as $v){
#-->
<option value="{$v['username']}">{$v['username']}</option>
<!--#
	}
	unset($sel_users);
}else{
#-->
<option disabled="disabled"><?=__('none_buddy')?></option>
<!--#
}
#-->
</select>
</li>
<li><?=__('msg_content')?>: </li>
<li><textarea name="msg_content" style="width:350px; height:100px;"></textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="checkbox" id="sb" name="save_box" value="1" /><label for="sb"><?=__('save_msg_to_box')?></label></li>
</form>
</div>
</div>
<script language="javascript">
function on_sel_user(){
	getId('username').value = getId('sel_user').options[getId('sel_user').selectedIndex].value;
	getId('touser').value = getId('sel_user').options[getId('sel_user').selectedIndex].value;
}
function dosubmit(o){
	if(o.msg_content.value.strtrim().length <2 || o.msg_content.value.strtrim().length > 1000){
		alert("<?=__('msg_min_max')?>");
		o.msg_content.focus();
		return false;
	}
}
</script>
<!--#}elseif($action =='view'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=message")#}" method="post">
<input type="hidden" name="action" value="reply" />
<input type="hidden" name="username" value="{$msg_array['username']}" />
<input type="hidden" name="msgid" value="{$msg_array['msgid']}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('msg_user')?>:</li>
<li><input type="text" name="touser" value="{$msg_array['username']}" size="20" maxlength="50" readonly /></li>
<li><?=__('msg_content')?>: </li>
<li><textarea name="msg_content" style="width:350px; height:100px;" readonly="readonly">{$msg_array['content']}</textarea></li>
<li>
<!--#if($can_reply){#-->
<input type="submit" class="btn" value="<?=__('reply_msg')?>" />&nbsp;&nbsp;
<!--#}else{#-->
<input type="button" class="btn" value="<?=__('btn_close')?>"  onclick="self.parent.$.jBox.close(true);" />
<!--#}#-->
</li>
</form>
</div>
</div>
<!--#}elseif($action =='reply'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=message")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="reply" />
<input type="hidden" name="username" value="{$username}" />
<input type="hidden" name="msgid" value="{$msgid}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('msg_touser')?>:</li>
<li><input type="text" name="touser" value="{$username}" size="20" maxlength="50" readonly /></li>
<li><?=__('msg_content')?>: </li>
<li><textarea name="msg_content" style="width:350px; height:100px;"></textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="checkbox" id="sb" name="save_box" value="1" /><label for="sb"><?=__('save_msg_to_box')?></label></li>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.msg_content.value.strtrim().length <2 || o.msg_content.value.strtrim().length > 1000){
		alert("<?=__('msg_min_max')?>");
		o.msg_content.focus();
		return false;
	}
}
</script>
<!--#}#-->