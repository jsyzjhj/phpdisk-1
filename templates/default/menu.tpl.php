<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: menu.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script type="text/javascript" src="includes/js/tree.js"></script>
<script lanuage="javascript">
function expand(id) {
	if(getId('box_'+id).style.display == ''){
		getId('box_'+id).style.display = 'none';
		getId('img_'+id).src = "images/menu_close.gif";
		setCookie('mydisk_menu_'+id,1,30);
	}else{
		getId('box_'+id).style.display = '';
		getId('img_'+id).src = "images/menu_open.gif";
		setCookie('mydisk_menu_'+id,0,30);
	}
}
$(document).ready(function(){
	$("#menu_container li").mouseover(function(){
		$(this).addClass("m_over");
	}).mouseout(function(){
		$(this).removeClass("m_over");
	});
});
</script>
<div id="menu_container">
<!--#if($menu =='file'){#-->
<div class="menu_box">
<div class="title"><img align="absmiddle" src="images/menu_open.gif" border=0><?=__('folder_list')?></div>
<script type="text/javascript">
tr = new tree('tr');
{$folder_list}
document.write(tr);
</script>
</div>
<!--#}elseif($menu == 'public'){#-->
<div class="menu_box">
<div class="title"><img align="absmiddle" src="images/menu_open.gif" border=0><?=__('public_category')?></div>
<script type="text/javascript">
tr = new tree('tr');
{$public_folder_tree}
document.write(tr);
</script>
</div>
<br />
<div class="menu_box">
<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="images/menu_open.gif" border=0><?=__('data_stats')?></div>
<div id="box_1">
	<li><?=__('file_count')?>: {$file_count}</li>
	<li><?=__('total_space')?>: {$total_space}</li>
</div>	
</div>
<!--#}elseif($menu =='profile'){#-->
<div class="menu_box">
<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="images/menu_open.gif" border=0><?=__('menu_profile')?></div>
<div id="box_1">
	<li><a href="{#urr("mydisk","item=profile&menu=$menu&action=mypower")#}"><?=__('menu_mypower')?></a></li>
	<li><a href="{#urr("mydisk","item=profile&menu=$menu&action=password")#}"><?=__('menu_password_modify')?></a></li>
	<li><a href="{#urr("mydisk","item=profile&menu=$menu&action=exchange")#}"><?=__('menu_credit_exchange')?></a></li>
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_payment'],0)){#-->
	<li><a href="{#urr("mydisk","item=profile&menu=$menu&action=payment")#}"><?=__('menu_profile_payment')?></a></li>
	<li><a href="{#urr("mydisk","item=profile&menu=$menu&action=history")#}"><?=__('menu_profile_history')?></a></li>
	<!--#}#-->
	<!--#if(display_plugin('filelog','open_filelog_plugin',($settings['open_filelog'] && $settings['open_down_filelog']),0)){#-->
	<li><a href="{#urr("mydisk","item=stats&menu=$menu")#}"><?=__('menu_stats_down')?></a></li>
	<!--#}#-->
</div>
</div>
<br/>
<div class="menu_box">
<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="images/menu_open.gif" border=0><?=__('menu_buddy')?></div>
<div id="box_2">
	<li><a href="{#urr("mydisk","item=buddy&menu=$menu&action=mybuddy")#}"><?=__('menu_my_buddy')?></a></li>
	<li><a href="{#urr("mydisk","item=buddy&menu=$menu&action=whobuddy")#}"><?=__('menu_who_buddy')?></a></li>
	<li><a href="{#urr("mydisk","item=buddy&menu=$menu&action=invite")#}"><?=__('menu_invite_buddy')?></a></li>
	<li><a href="{#urr("mydisk","item=buddy&menu=$menu&action=invite_success")#}"><?=__('menu_invite_success_buddy')?></a></li>
</div>
</div>
<br/>
<div class="menu_box">
<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="images/menu_open.gif" border=0><?=__('menu_message')?></div>
<div id="box_3">
	<li><a href="{#urr("mydisk","item=message&menu=$menu&action=inbox")#}"><?=__('menu_msg_inbox')?>{$new_msg}</a></li>
	<li><a href="{#urr("mydisk","item=message&menu=$menu&action=sendbox")#}"><?=__('menu_msg_sendbox')?></a></li>
</div>
</div>
<br/>
<!--#}elseif($menu =='disk'){#-->
<div class="menu_box">
<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="images/menu_open.gif" border=0><?=__('menu_op_panel')?></div>
<div id="box_1">
	<!--#if(display_plugin('disk','open_disks_plugin',$settings['open_disks'],0)){#-->
	<li><a href="{#urr("mydisk","item=disk")#}"><?=__('menu_disk_setting')?></a></li>
	<!--#}#-->
</div>
</div>
<br />
<!--#}elseif($menu =='recycle'){#-->
<div class="menu_box">
<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="images/menu_open.gif" border=0><?=__('menu_files_recycle')?></div>
<div id="box_1">
	<li><a href="{#urr("mydisk","item=recycle&menu=$menu&action=delete_all")#}"><?=__('menu_delete_all')?></a></li>
	<li><a href="{#urr("mydisk","item=recycle&menu=$menu&action=restore_all")#}"><?=__('menu_restore_all')?></a></li>
</div>
</div>
<br/>
<div class="menu_box">
<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="images/menu_open.gif" border=0><?=__('data_stats')?></div>
<div id="box_2">
	<li><?=__('folder_count')?>: {$folder_count}</li>
	<li><?=__('file_count')?>: {$file_count}</li>
	<li><?=__('total_space')?>: {$total_space}</li>
</div>
</div>
<br/>
<!--#}#-->
</div>
