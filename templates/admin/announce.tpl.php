<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: announce.tpl.php 25 2014-01-10 03:13:43Z along $
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
<h1><?=__('announces_title')?><!--#sitemap_tag(__('announces_title'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('announces_list_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=announce&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('show_announce_detail')?></span>: <br /><span class="txtgray"><?=__('show_announce_detail_tips')?></span></td>
	<td><input type="radio" name="setting[show_announce_detail]" value="1" {#ifchecked(1,$settings['show_announce_detail'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_announce_detail]" value="0" {#ifchecked(0,$settings['show_announce_detail'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></td>
</tr>
</table>
</form>
<br />
<form name="ann_form" action="{#urr(ADMINCP,"item=announce&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#
if(count($announces)){
#-->
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold" width="30%"><?=__('ann_subject')?></td>
	<td class="bold" width="40%"><?=__('ann_content')?></td>
	<td class="bold" width="120" align="center"><?=__('expand')?></td>
	<td class="bold" align="right"><?=__('operation')?></td>
</tr>
<!--#
	foreach($announces as $k => $v){
#-->
<tr>
	<td>
	<input type="text" name="show_order[]" value="{$v['show_order']}" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="annids[]" value="{$v['annid']}" />
	</td>
	<td><a href="{$v['a_modify_announce']}">{$v['subject']}</a></td>
	<td><span title="{$v['content']}">{$v['short_content']}</span></td>
	<td align="center">{$v['expand']}</td>
	<td align="right"><a href="{$v['a_modify_announce']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;<a href="{$v['a_change_status']}">{$v['status_text']}</a>
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_modify_announce']}"><?=__('modify')?></a>
	<a href="{$v['a_delete_announce']}" onclick="return confirm('<?=__('announces_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	</td>
</tr>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
<!--#
	}
	unset($announces);
}else{	
#-->
<tr>
	<td><?=__('announces_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td align="center" colspan="5"><input type="button" class="btn" value="<?=__('add_announces')?>" onclick="go('{#urr(ADMINCP,"item=announce&menu=extend&action=add_announce")#}');" /> <input type="submit" class="btn" value="<?=__('btn_update')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#
}elseif($action =='add_announce' || $action =='modify_announce'){
#-->
<div id="container">
<!--#if($action =='add_announce'){#-->
<h1><?=__('add_announces_title')?></h1>
<!--#}else{#-->
<h1><?=__('edit_announces_title')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_announces_list_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=announce&menu=extend")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="annid" value="{$annid}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><b><?=__('ann_subject')?></b>:<br /><span class="txtgray"><?=__('ann_subject_tips')?></span></td>
	<td><input type="text" name="subject" value="{$subject}" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('expand')?></b>:<br /><span class="txtgray"><?=__('expand_tips')?></span></td>
	<td><input type="radio" name="expand" value="1" {#ifchecked($expand,1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="expand" value="0" {#ifchecked($expand,0)#} /><?=__('no')?></td>
</tr>
<tr>
	<td><b><?=__('ann_content')?></b>:<br /><span class="txtgray"><?=__('ann_content_tips')?></span></td>
	<td><textarea name="content" id="content" cols="50" rows="10" style="width:400px;height:120px">{$content}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('content','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('content','sub');">[-]</a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.subject.value.strtrim().length <2){
		alert("<?=__('subject_error')?>");
		o.subject.focus();
		return false;
	}
	if(o.content.value.strtrim().length <2){
		alert("<?=__('content_error')?>");
		o.content.focus();
		return false;
	}
}
</script>
<!--#
}
#-->
