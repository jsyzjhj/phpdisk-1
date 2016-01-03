<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: seo.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('seo_manage')?><!--#sitemap_tag(__('seo_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('seo_manage_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_seo')?></span>: <br /><span class="txtgray"><?=__('open_seo_tips')?></span></td>
	<td><input type="radio" name="setting[open_seo]" value="1" {#ifchecked(1,$setting['open_seo'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_seo]" value="0" {#ifchecked(0,$setting['open_seo'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('meta_keywords')?></span>: <br /><span class="txtgray"><?=__('meta_keywords_tips')?></span></td>
	<td><textarea id="meta_keywords" name="setting[meta_keywords]" style="width:300px;height:30px">{$setting['meta_keywords']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('meta_description')?></span>: <br /><span class="txtgray"><?=__('meta_description_tips')?></span></td>
	<td><textarea id="meta_description" name="setting[meta_description]" style="width:300px;height:30px">{$setting['meta_description']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="40%"><span class="bold"><?=__('open_rewrite')?></span>: <br /><span class="txtgray"><?=__('open_rewrite_tips')?></span></td>
	<td><input type="radio" name="setting[open_rewrite]" value="1" id="or1" {#ifchecked(1,$setting['open_rewrite'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_rewrite]" value="0" id="or2" {#ifchecked(0,$setting['open_rewrite'])#}/> <?=__('no')?>&nbsp;&nbsp;<a href="http://bbs.phpdisk.com/thread-4666-1-1.html" target="_blank"><?=__('get_rewrite_rule')?></a></td>
</tr>
<tr>
	<td align="center" colspan="2"><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
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