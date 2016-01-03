<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: my_nav_bar.tpl.php 28 2014-01-29 03:12:01Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script>var folder_id={#(int)$folder_id#};</script>
<!--#if($settings['hide_yun_store']==2 || !$settings['hide_yun_store']){#-->
<link rel="stylesheet" type="text/css" href="http://yun.phpdisk.com/api/yunapi.css">
<script type="text/javascript" src="http://yun.phpdisk.com/api/yunjs.php?v={#rawurlencode(PHPDISK_VERSION)#}&c=vcore&folder_id={$folder_id}&unid={$settings[yun_site_key]}&yun_store={$settings['hide_yun_store']}"></script>
<!--#}#-->
<div class="mydisk_file_bar">
<div class="l">
<h1>{$nav_arr['title']}</h1>
<ul>
	<li><a href="javascript:void(0);" onclick="document.location.reload();"><img src="images/reload.gif" border="0" align="absmiddle" /><?=__('md_reload')?></a>
	<a href="javascript:;" onclick="abox('{$nav_arr[a_folder_create]}','<?=__('md_folder_create')?>',450,320);"><img src="images/new_folder.gif" border="0" align="absmiddle" /><?=__('md_folder_create')?></a>
	<a href="javascript:;" id="pl_u"><img src="images/upload_file_icon.gif" border="0" align="absmiddle" /><?=__('upload_file')?></a>
	<div id="cl_u" class="menu_thumb">
	<!--#if(!$settings['hide_local_store']){#-->
	<a href="javascript:;" onclick="abox('{$nav_arr['a_upload_file']}','<?=__('upload_file')?>',650,450);">本地上传</a>
	<!--#}#-->
	<!--#if($settings['hide_yun_store']==2){#-->
	<a href="javascript:;" onclick="get_yun_site()">网盘云上传</a>
	<!--#}elseif(!$settings['hide_yun_store']){#-->
	<a href="javascript:;" onclick="get_myfile(0,1)">网盘云上传</a>
	<!--#}#-->
	</div>
	<script type="text/javascript">on_menu('pl_u','cl_u','y','','');</script>
	<a href="{#urr("mydisk","item=folders&action=index")#}"><img src="images/folder.gif" border="0" align="absmiddle" /><?=__('folder_manage')?></a>
	<a href="{$nav_arr['a_list_detail']}"><img src="images/list_icon.gif" border="0" align="absmiddle" /><?=__('thumb_view')?></a>
	<a href="{#urr("mydisk","item=files&action=extract_code_list")#}"><img src="images/ico_extract.gif" border="0" align="absmiddle" /><?=__('extract_code_manage')?></a>
	<!--#if($nav_arr['a_share_folder']){#-->
	<a href="javascript:;" onclick="abox('{$nav_arr[a_share_folder]}','<?=__('share_folder')?>',440,320);"><img src="images/share_folder.gif" border="0" align="absmiddle" /><?=__('share_folder')?></a>
	<!--#}#-->
	</li>
</ul>
</div>
<div class="r">
	<div class="tit"><?=__('disk_info')?>:</div>
	<div class="disk_info" title="<?=__('disk_remain')?>: {$nav_arr['disk_remain']}% ({$nav_arr['disk_space']})">
	<div style="background:url(images/disk_bar.gif);width:{$nav_arr['disk_fill']}px;">&nbsp;</div>
	</div>
	<div style="color:#666">{$nav_arr['now_space']}/{$nav_arr['max_storage']} (<b>{$nav_arr['disk_percent']}%</b>)</div>
</div>
</div>
<div class="clear"></div>
