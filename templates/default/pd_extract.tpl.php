<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_extract.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<div class="tit"><?=__('extract_file')?></div>
<div class="layout_box">
<div class="l">
<form name="extract_frm" action="{#urr("extract","")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="file_extract" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td colspan="4" class="tips_box">
	<img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?>: </b> 
	<span class="txtgray"><?=__('extract_tips')?></span>
	</td>
</tr>
<tr>
	<td><?=__('extract_code')?>: <input type="text" name="extract_code" value="{$extract_code}"/>
		<input type="submit" class="btn" value="<?=__('pick')?>" /></td>
</tr>
</table>
</form>
<script language="JavaScript" type="text/javascript">
document.extract_frm.extract_code.focus();
function dosubmit(o){
	if(o.extract_code.value.strtrim().length <6 || o.extract_code.value.strtrim().legnth >16){
		alert("<?=__('js_extract_code')?>");
		o.extract_code.focus();
		return false;
	}
}
</script>
<!--#if($action =='file_extract'){#-->
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
<!--#
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
#-->
<li><span>*</span> {#$sysmsg[$i]#}</li>
<!--#
	}
}
unset($sysmsg);
#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
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
	<td align="center">{$v['file_size']}</td>
	<td align="center" width="150"  class="txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
<!--#}#-->
</div>
<div class="r">

</div>
<div class="clear"></div>
</div>
</div>