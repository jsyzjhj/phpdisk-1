<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: gallery.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='add_gal' || $action =='modify_gal'){
#-->
<div id="container">
<!--#if($action =='add_gal'){#-->
<h1><?=__('add_gallery_title')?></h1>
<!--#}else{#-->
<h1><?=__('edit_gallery_title')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('gallery_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="gal_id" value="{$gal_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><span class="bold"><?=__('gal_title')?>:</span><br /><span class="txtgray"><?=__('gal_title_tips')?></span></td>
	<td><input type="text" name="gal_title" size="50" value="{$gal_title}" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('gal_path')?>:</span><br /><span class="txtgray"><?=__('gal_path_tips')?></span></td>
	<td><input type="text" name="gal_path" size="50" value="{$gal_path}" maxlength="200" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('go_url')?>:</span><br /><span class="txtgray"><?=__('go_url_tips')?></span></td>
	<td><input type="text" name="go_url" size="50" value="{$go_url}" maxlength="200" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('gal_target')?>:</span><br /><span class="txtgray"><?=__('gal_target_tips')?></span></td>
	<td>
	<select name="gal_target">
		<option {#ifselected('_blank',$gal_target,'str')#}>_blank</option>
		<option {#ifselected('_self',$gal_target,'str')#}>_self</option>
		<option {#ifselected('_parent',$gal_target,'str')#}>_parent</option>
		<option {#ifselected('_top',$gal_target,'str')#}>_top</option>
	</select>
	</td>
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
	if(o.gal_title.value.strtrim().length <1){
		alert("<?=__('gal_title_error')?>");
		o.gal_title.focus();
		return false;
	}
	if(o.gal_path.value.strtrim().length <1){
		alert("<?=__('gal_path_error')?>");
		o.gal_path.focus();
		return false;
	}
	if(o.go_url.value.strtrim().length <1){
		alert("<?=__('go_url_error')?>");
		o.go_url.focus();
		return false;
	}
}
</script>
<!--#
}else{
#-->
<div id="container">
<h1><?=__('gallery_title')?><!--#sitemap_tag(__('gallery_title'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('gallery_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_gallery_index')?></span>: <br /><span class="txtgray"><?=__('open_gallery_index_tips')?></span></td>
	<td><input type="radio" name="setting[open_gallery_index]" value="1" {#ifchecked(1,$settings['open_gallery_index'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_gallery_index]" value="0" {#ifchecked(0,$settings['open_gallery_index'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('gallery_type')?></span>: <br /><span class="txtgray"><?=__('gallery_type_tips')?></span></td>
	<td>
	<!--#for($i=1;$i<=2;$i++){#-->
	<input type="radio" name="setting[gallery_type]" value="{$i}" {#ifchecked($i,$settings['gallery_type'])#} /> <?=__('style')?>{$i}&nbsp;&nbsp;
	<!--#}#-->
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('gallery_size')?></span>: <br /><span class="txtgray"><?=__('gallery_size_tips')?></span></td>
	<td><?=__('width')?><input type="text" name="setting[gallery_size_width]" value="{$settings['gallery_size_width']}" size="2" maxlength="4" /> x <?=__('height')?> <input type="text" name="setting[gallery_size_height]" value="{$settings['gallery_size_height']}" size="2" maxlength="4" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></td>
</tr>
</table>
</form>
<br />
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_order" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#
if(count($gallerys)){
#-->
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold"><?=__('text')?></td>
	<td class="bold"><?=__('path')?></td>
	<td class="bold" width="35%"><?=__('href')?></td>
	<td class="bold"><?=__('target')?></td>
	<td class="bold"><?=__('operation')?></td>
</tr>
<!--#
	foreach($gallerys as $k => $v){
#-->
<tr>
	<td>
	<input type="text" name="show_order[]" value="{$v['show_order']}" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="galids[]" value="{$v['gal_id']}" />
	</td>
	<td>{$v['gal_title']}</td>
	<td>{$v['gal_path']}</td>
	<td><a href="{$v['go_url']}" target="_blank">{$v['go_url']}</a></td>
	<td>{$v['gal_target']}</td>
	<td><a href="{$v['a_modify_gal']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_modify_gal']}"><?=__('modify')?></a>
	<a href="{$v['a_delete_gal']}" onclick="return confirm('<?=__('gallery_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
	</td>
</tr>
<!--#
	}
	unset($gallerys);
}else{	
#-->
<tr>
	<td><?=__('gallery_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td align="center" colspan="6"><input type="button" class="btn" value="<?=__('add_new_gallery')?>" onclick="go('{#urr(ADMINCP,"item=$item&menu=extend&action=add_gal")#}');" /> <input type="submit" class="btn" value="<?=__('btn_update')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#}#-->
