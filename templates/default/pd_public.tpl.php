<!--#
##
#	Project: PHPDisk Commercial Edition
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_public.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<div class="tit">{$title}</div>
<div class="layout_box">
<div class="l">
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
$i=1;
if(count($arr_file)){
	foreach($arr_file as $kk => $val){
		$i++;
		$is_right = ($i+1)%2==0 ? ' style="margin-left:10px"' : '';
#-->
<div class="fl_box" {$is_right}>
<div class="tit2"><a href="{#urr("public","pid=0&cate_id=$kk")#}">{#$public_file_title[$kk]#}</a></div>
<ul>
<!--#	
		foreach($val as $k => $v){
#-->
<li>{$v['file_time']}{#file_icon($v['file_extension'])#} <a href="{$v['a_viewfile']}" target="_blank">{$v['file_name']}</a></li>
<!--#
		}
#-->
</ul>
</div>
<!--#	
	if(($i+1)%2==0){ echo "<div class='clear'></div><br>";}
	}
}else{

#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<!--#
if(count($files_array)){

#-->
<tr>
	<td width="50%" class="bold"><a href="{$n_url}"><?=__('file_name')?>{$n_order}</a></td>
	<td align="center" class="bold"><a href="{$u_url}"><?=__('uploader')?>{$u_order}</a></td>
	<td align="center" class="bold"><a href="{$s_url}"><?=__('file_size')?>{$s_order}</a></td>
	<td align="center" width="150" class="bold"><a href="{$t_url}"><?=__('file_upload_time')?>{$t_order}</a></td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>&nbsp;{#file_icon($v['file_extension'])#}&nbsp;
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a> <span class="txtgray">{$v['file_description']}</span>
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a> <span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center"><a href="{$v['a_space']}" target="_blank">{$v['username']}</a></td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" width="150"  class="txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
}else{	
#-->
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
</table>
<!--#
}
#-->
</div>
<div class="r">
<div class="common_box">
	<div class="tit2"><?=__('public_category')?></div>
	<div class="cate_list">
	<script type="text/javascript">
	tr = new tree('tr');
	{$public_folder_tree}
	document.write(tr);
	</script>
	</div>
</div>
<br />
<div class="common_box">
<div class="tit2"><?=__('public_stats')?></div>
<ul>
	<li><b><?=__('public_files_count')?>:</b> {$stats['public_files_count']}</li>
	<li><b><?=__('total_file_store')?>:</b> {$total_file_store}</li>
</ul>
</div>
<br />
<!--#show_adv_data('adv_right');#-->
</div>
<div class="clear"></div>
</div>
</div>
