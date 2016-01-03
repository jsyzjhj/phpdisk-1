<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: main.tpl.php 30 2014-03-23 02:31:10Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('admincp_statistics')?><!--#sitemap_tag(__('admincp_statistics'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('stats_tips')?></span>
</div>
<div id="warning"></div>
<!--#if($install_dir_exists){#-->
<div id="install_exists_tips" class="msg_tips"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('install_exists_tips')?></div>
<!--#}#-->
<!--#if($datacall_secure){#-->
<div id="install_exists_tips" class="msg_tips"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('secure_tips')?></div>
<!--#}#-->
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0">
<tr>
	<td width="15%" align="right"><?=__('users_count')?>: </td>
	<td>{$stats['users_count']} , <?=__('users_locked_count')?>&nbsp;&nbsp;<a href="{#urr(ADMINCP,"item=users&menu=extend&action=index&gid=0&orderby=is_locked")#}"><span class="txtred bold">{$stats['users_locked_count']}</span></a>  , <?=__('users_open_count')?>&nbsp;&nbsp;<span class="txtblue bold">{$stats['users_open_count']}</span></td>
</tr>
<tr>
	<td align="right"><?=__('user_files_count')?>: </td>
	<td>{$stats['user_files_count']}  , <?=__('in_storage')?> <b>{$stats['user_storage_count']}</b></td>
</tr>
<tr>
	<td align="right"><?=__('public_files_count')?>: </td>
	<td>{$stats['public_files_count']} , <?=__('in_storage')?> <b>{$stats['public_storage_count']}</b></td>
</tr>
<tr>
	<td align="right"><?=__('total_storage_count')?>: </td>
	<td>{$stats['all_files_count']} , <?=__('in_storage')?> <b>{$stats['total_storage_count']}</b></td>
</tr>
<tr>
	<td align="right"><?=__('other_stats')?>: </td>
	<td><?=__('extract_code_count')?> {$stats['extract_code_count']} , <?=__('user_folders_count')?> {$stats['user_folders_count']} </td>
</tr>
</table>
<br />
<table width="100%" cellpadding="4" cellspacing="1" class="tableborder" style="display:{$show_news_frame}">
<tr>
	<td class="table_title"><?=__('phpdisk_site_news')?></td>
</tr>
<tr>
	<td><div id="phpdisk_news"></div></td>
</tr>
</table>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="1" class="tableborder">
<tr>
	<td class="table_title" colspan="2"><?=__('system_env')?></td>
</tr>
<!--#if(!$settings['online_demo']){#-->
<tr>
	<td class="tablerow"><?=__('system_host')?>: {$_SERVER['SERVER_NAME']}({$_SERVER['SERVER_ADDR']})</td>
	<td class="tablerow" valign="top" width="50%" rowspan="6"><div style="margin-bottom:5px;"><?=__('phpdisk_email_subscribe')?></div><script >var nId = "0e1bc68fa78ff8fd7d9841059b4313737169dd94b352cf7e",nWidth="500",sColor="light",sText="<?=__('phpdisk_email_subscribe2')?>" ;</script><script src="http://list.qq.com/zh_CN/htmledition/js/qf/page/qfcode.js" charset="gb18030"></script></td>
</tr>
<tr>
	<td class="tablerow"><?=__('system_server')?>: {$_SERVER['SERVER_SOFTWARE']}</td>
</tr>
<!--#}#-->
<tr>
	<td class="tablerow"><?=__('system_base')?>: MySQL {$mysql_info}, PHP {PHP_VERSION}, <?=__('system_post_file')?> <span class="bold">{$post_max_size}</span>, <?=__('system_upload_file')?> <span class="bold">{$file_max_size}</span><span class="txtred">(<?=__('max_upload_file_tips')?>)</span></td>
<tr>
	<td class="tablerow"><?=__('system_gd_info')?>: {$gd_support} ({$gd_info})</td>
</tr>
<tr>
	<td class="tablerow"><?=__('iconv_txt')?>: (<?=__('iconv_support')?>: {$iconv_support} <?=__('or')?> <?=__('mbstring_support')?>: {$mbstring_support} ) <span class="txtgray">(<?=__('iconv_tips')?>)</span></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_prober')?>: <a href="http://bbs.phpdisk.com/viewthread.php?tid=1506" target="_blank">http://bbs.phpdisk.com/viewthread.php?tid=1506</a></td>
</tr>
</table>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="1" class="tableborder">
<tr>
	<td class="table_title"><?=__('about_system')?></td>
</tr>
<tr>
	<td class="tablerow"><?=__('program_develop')?>: <a href="http://bbs.phpdisk.com/space.php?uid=1" target="_blank">along</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('official_site')?>: <a href="http://www.phpdisk.com/" target="_blank">http://www.phpdisk.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_bbs')?>: <a href="http://bbs.phpdisk.com/" target="_blank">http://bbs.phpdisk.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_demo')?>: <a href="http://demo.phpdisk.com/" target="_blank">http://demo.phpdisk.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('version_info')?>: <b>PHPDisk {PHPDISK_EDITION} {PHPDISK_VERSION} [{$charset_info}]</b> (Build{PHPDISK_RELEASE})</td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_commend_tips')?></td>
</tr>
</table>

</div>
</div>
<script language="javascript">
function autoupdate(){
	document.write("<img src=http://www.phpdisk.com/autoupdate.php?edition={#rawurlencode(PHPDISK_EDITION)#}&version={PHPDISK_VERSION}&release={PHPDISK_RELEASE}&server={SERVER_NAME} width=0 height=0>");
	
}
autoupdate();
$('#phpdisk_news').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />官方动态数据加载中...');
$.getScript('{$news_url}',function(){
	var arr = cb.split('|');
	if(arr[2]!=''){
	$.jBox(arr[2],{title:arr[1], buttons: {}});
	}
	$('#phpdisk_news').html(arr[0]);
});
setTimeout(function(){
	$.getScript('{$upgrade_url}?pr={PHPDISK_RELEASE}',function(){			
		if(dt!=''){
		var arr2 = dt.split('|');
		$.jBox.messager(arr2[1],arr2[0],0);
		}
	});
},3000);
</script>
