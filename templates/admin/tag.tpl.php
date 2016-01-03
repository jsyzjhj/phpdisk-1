<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: tag.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('tag_manage')?><!--#sitemap_tag(__('tag_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('tag_manage_tips')?></span>
</div>
<form name="disk_form" action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_tag')?></span>: <br /><span class="txtgray"><?=__('open_tag_tips')?></span></td>
	<td><input type="radio" id="ot1" name="setting[open_tag]" value="1" {#ifchecked(1,$setting['open_tag'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_tag]" value="0" {#ifchecked(0,$setting['open_tag'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<br />
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="5" class="f14"><?=__('tags_list')?>:</td>
</tr>
<!--#
if(count($tags)){
#-->
<tr>
	<td width="50%"><?=__('tag_name')?></td>
	<td align="center"><?=__('tag_count')?></td>
	<td align="center"><?=__('status')?></td>
</tr>
<form action="{#urr(ADMINCP,"item=$item&menu=file")#}" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<!--#
	foreach($tags as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}" height="20">
	<td>
	<input type="checkbox" name="tagids[]" id="tagids" value="{$v['tag_id']}"  /> <a href="{$v['a_tag']}" target="_blank">{$v['tag_name']}</a>
	</td>
	<td align="center">{$v['tag_count']}</td>
	<td align="center">{$v['status']}</td>
</tr>	
<!--#
	}
	unset($tags);
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="5">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.tagids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.tagids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="chg_show" id="chg_show" /><label for="chg_show"><?=__('is_show')?></label>&nbsp;
	<input type="radio" name="task" value="chg_hidden" id="chg_hidden" /><label for="chg_hidden"><?=__('is_hidden')?></label>&nbsp;
	<input type="radio" name="task" value="del_tag" id="del_tag" /><label for="del_tag"><?=__('delete')?></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<!--#	
}else{	
#-->
<tr>
	<td valign="middle"><?=__('tags_not_found')?></td>
</tr>
<!--#
}
#-->
</form>
</table>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("tagids[]") != true){
		alert("<?=__('please_select_tags')?>");
		return false;
	}
	if(getId('chg_show').checked ==false && getId('chg_hidden').checked ==false && getId('del_tag').checked ==false){
		alert("<?=__('please_select_tag_op')?>");
		return false;
	}
}
</script>
</div>
</div>
