<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: files.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='index' || $action =='search'){
#-->
<div id="container">
<h1><?=__('file_list')?><!--#sitemap_tag(__('file_list'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_title_tips')?><span class="txtred">蓝色标题的文件是存储于<a href="http://yun.phpdisk.com/" target="_blank">网盘云</a>上的文件</span></span>
</div>
<form name="search_frm" action="{#urr(ADMINCP,"")#}" method="get" onsubmit="return dosearch(this);">
<input type="hidden" name="item" value="files" />
<input type="hidden" name="menu" value="file" />
<input type="hidden" name="action" value="search" />
<div class="search_box">
<div class="l"><img src="{$admin_tpl_dir}images/it_nav.gif" align="absbottom" />
<?=__('view_mode')?>: 
<select name="view" id="view" onchange="chg_view();">
<option value="mydisk_file" {#ifselected('mydisk_file',$view,'str');#}><?=__('mydisk_file')?></option>
<option value="mydisk_recycle" {#ifselected('mydisk_recycle',$view,'str');#}><?=__('mydisk_recycle')?></option>
</select>&nbsp;&nbsp;<span id="ys_tips" onclick="yun_stat()" style="cursor:pointer"><img src="images/ajax_loading.gif" align="absmiddle" border="0" />网盘云统计中...</span>
</div>
<div class="r"><input type="text" name="word" value="{$word}" title="<?=__('search_files_tips')?>" /> <input type="submit" class="btn" value="<?=__('search_files')?>" /></div>
</div>
</form>
<div class="clear"></div>
<script language="javascript">
function chg_view(){
	var view = getId('view').value.strtrim();
	document.location.href = '{#urr(ADMINCP,"item=files&menu=file&action=index&view='+view+'")#}';
}
function dosearch(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<form name="public_frm" action="{#urr(ADMINCP,"item=files&menu=file")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="40%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold" width="150"><?=__('username')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
	<td align="right" width="80" class="bold">
	<?=__('status')?>/<?=__('operation')?>
	</td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td width="40%"><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />&nbsp;<a href="{$v['a_downfile']}" title="<?=__('download')?>">{#file_icon($v['file_extension'])#}</a>&nbsp;
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}" {$v[in_yun]}>{$v['file_name']}</a><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}" {$v[in_yun]}>{$v['file_name']}</a>
	<!--#}#-->
	</td>
	<td align="center"><a href="{$v['a_user_view']}">{$v['username']}</a></td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" width="150" class="txtgray">{$v['file_time']}</td>
	<td align="center">
	{$v['status_txt']} / 
	<a href="{$v['a_recycle_delete']}" onclick="return confirm('<?=__('recycle_delete_confirm')?>');"><?=__('delete')?></a>
	</td>
</tr>
<!--#		
	}
	unset($files_array);
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.public_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.public_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="check_public" checked="checked" /><?=__('check_public')?>&nbsp;&nbsp;
	<input type="radio" name="task" value="file_to_locked" /><?=__('file_to_locked')?>&nbsp;&nbsp;
	<input type="radio" name="task" value="file_to_unlocked" /><?=__('file_to_unlocked')?>&nbsp;&nbsp;
	<input type="radio" name="task" value="delete_file_complete" /><?=__('delete_complete')?>&nbsp;&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
<!--#		
}else{
#-->
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
function yun_stat(){
	$('#ys_tips').removeClass();
	$('#ys_tips').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />网盘云统计中...');
	$.getScript('http://yun.phpdisk.com/api/yun_stat.php?action=site_stat&site_key={$settings[yun_site_key]}',function(){
		var arr = cbc.split('|');
		if(arr[0]=='true'){
			$('#ys_tips').html(arr[1]);
			$('#ys_tips').addClass('txtgreen');
		}else{
			$('#ys_tips').html(cbc);
			$('#ys_tips').addClass('txtred');
		}
	});
}
setTimeout(function(){yun_stat();},2250);
</script>
<!--#}#-->