<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_search.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<div class="tit"><?=__('search_title')?></div>
<div class="layout_box">
<div class="l">
<!--#if(!$error){#-->
<form name="search_frm" action="{#urr("search","")#}" method="get" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="search" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td colspan="4" class="tips_box">
	<img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?>: </b> 
	<span class="txtgray"><?=__('search_tips')?></span>
	</td>
</tr>
<tr>
	<td><?=__('keyword')?>: <input type="text" name="word" value="{$word}" title="<?=__('search_files_tips')?>" />
	<select name="scope">
	<!--#if($pd_uid){#-->
	<option value="mydisk" {#ifselected('mydisk',$scope,'str')#}><?=__('scope_mydisk')?></option>
	<!--#}#-->
	<option value="all" {#ifselected('all',$scope,'str')#}><?=__('scope_all')?></option>
	<option value="public" {#ifselected('public',$scope,'str')#}><?=__('scope_public')?></option>
	</select>
	<input type="submit" class="btn" value="<?=__('search')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
document.search_frm.word.focus();
function dosubmit(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<!--#if($action =='search'){#-->
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="50%" class="bold"><a href="{$n_url}"><?=__('file_name')?>{$n_order}</a></td>
	<td align="center" class="bold"><a href="{$u_url}"><?=__('username')?>{$u_order}</a></td>
	<td align="center" class="bold"><a href="{$s_url}"><?=__('file_size')?>{$s_order}</a></td>
	<td align="center" width="150" class="bold"><a href="{$t_url}"><?=__('file_upload_time')?>{$t_order}</a></td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>&nbsp;{#file_icon($v['file_extension'])#}&nbsp;
	<!--#if($v['is_locked']){#-->
	<span class="txtgray" title="<?=__('file_locked')?>">{$v['file_name']} {$v['file_description']}</span>
	<!--#}elseif($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a>&nbsp;<span class="txtgray">{$v['file_description']}</span><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a> <span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center"><a href="{$v['a_space']}" target="_blank">{$v['username']}</a></td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" width="150"  class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
}else{	
#-->
<tr>
	<td colspan="6"><?=__('search_is_empty')?></td>
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
<!--#}#-->
<!--#}#-->
</div>
<div class="r">

</div>
<div class="clear"></div>
</div>
</div>
