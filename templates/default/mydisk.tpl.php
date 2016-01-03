<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: mydisk.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script type="text/javascript">
function expand_menu(){
	if(getId('mydisk_left_frame').style.display =='none'){
		getId('mydisk_left_frame').style.display = '';
		getId('menu_img').src = "images/menu_left.gif";
		setCookie('mydisk_left_frame_status',1,30);
		getId('menu_img').alt = "<?=__('close_menu')?>";
		getId('mydisk_main_frame').width="87%";
	}else{
		getId('mydisk_left_frame').style.display = 'none';
		getId('menu_img').src = "images/menu_right.gif";
		setCookie('mydisk_left_frame_status',0,30);
		getId('menu_img').alt = "<?=__('open_menu')?>";
		getId('mydisk_main_frame').width="100%";
	}
}
function set_hl(n) {
	var hl = document.getElementsByTagName('li');
	for(var i = 0; i < hl.length; i++) {
		hl[i].id = '';
	}
	hl[n].id = "mydisk_nav_sel";
}
</script>

<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" style="background:url({$user_tpl_dir}/images/logo_cp.gif) no-repeat">
  <tr>
  	<td valign="top" height="50" colspan="3">
		<div class="mydisk_bar">
		<?=__('welcome')?>: {$pd_username}&nbsp;&nbsp;<?=__('user_group')?>: <span style="color:#0000FF">{$pd_group_name}</span>&nbsp;
			<!--#if($pd_gid ==1){#-->
			<a href="{#urr(ADMINCP,"")#}" target="_blank"><img src="images/admin_icon.gif" align="absbottom" border="0"><font color="#135294"><?=__('admincp')?></font></a>&nbsp;
			<!--#}#-->
			<a href="./" target="_top"><?=__('site_index')?></a>&nbsp;
			<a href="{#urr("account","action=logout")#}" onClick="return confirm('<?=__('confirm_logout')?>');" target="_top">[<?=__('logout')?>]</a>&nbsp;
		</div>
	  <div class="mydisk_nav">
		<ul>
		  <li><a href="{#urr("mydisk","item=files&menu=file&action=index")#}" onClick="set_hl(0);" ><?=__('menu_my_file')?></a></li>
		  <li><a href="{#urr("mydisk","item=public&menu=public&action=index")#}" onClick="set_hl(1);"><?=__('menu_public_file')?></a></li>
		  <li><a href="{#urr("mydisk","item=profile&menu=profile&action=mypower")#}" onClick="set_hl(2);"><?=__('menu_profile_center')?></a></li>
		  <li><a href="{#urr("mydisk","item=recycle&menu=recycle")#}" onClick="set_hl(3);"><?=__('menu_recycle')?></a></li>
		  <!--#if(display_plugin('disk','open_disks_plugin',$settings['open_disks'],0)){#-->
		  <li><a href="{#urr("mydisk","item=disk&menu=disk&action=buy")#}" onClick="set_hl(4);"><?=__('menu_disk_buy')?></a></li>
		  <!--#}#-->
		  </ul>
		</div>
	</td>
  </tr>
  </table>
<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" style="background:#FCFCFC; padding-bottom:20px;">
  <tr>
    <td valign="top" id="mydisk_left_frame" width="150">
	  <!--#require_once template_echo('menu',$user_tpl_dir);#-->
	  </td>
	  <td class="expand_menu" width="2" valign="top">
	  <img id="menu_img" align="absmiddle" src="images/menu_left.gif" border="0" onClick="expand_menu();">
	  </td>
    	<td valign="top" id="mydisk_main_frame" width="87%">
		<!--#require_once $action_module;#-->
		</td>
	</tr>
</table>
<script type="text/javascript">
if(getCookie('mydisk_left_frame_status')=='0'){
	getId('mydisk_left_frame').style.display = 'none';
	getId('menu_img').src = "images/menu_right.gif";
	getId('menu_img').alt = "<?=__('open_menu')?>";
	getId('mydisk_main_frame').width="100%";
}else{
	getId('mydisk_left_frame').style.display = '';
	getId('menu_img').src = "images/menu_left.gif";
	getId('menu_img').alt = "<?=__('close_menu')?>";
	getId('mydisk_main_frame').width="87%";
}
</script>
