<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: admincp.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<script type=text/javascript>
function expand_menu(){
	if(getId('admincp_left_frame').style.display =='none'){
		getId('admincp_left_frame').style.display = '';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_left.gif";
		setCookie('admincp_left_frame_status',1,30);
		getId('menu_img').alt = "<?=__('close_menu')?>";
		getId('admincp_main_frame').width="87%";
	}else{
		getId('admincp_left_frame').style.display = 'none';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_right.gif";
		setCookie('admincp_left_frame_status',0,30);
		getId('menu_img').alt = "<?=__('open_menu')?>";
		getId('admincp_main_frame').width="100%";
	}
}
function set_hl(n) {
	var hl = document.getElementsByTagName('li');
	for(var i = 0; i < hl.length; i++) {
		hl[i].id = '';
	}
	hl[n].id = "admin_nav_sel";
}	
</script>

<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" style="background:url({$admin_tpl_dir}images/logo_cp.gif) no-repeat">
  <tr>
  	<td height="50" colspan="4">
  	  <div class="admin_nav">
  	    <ul>
  	      <li><a href="{#urr(ADMINCP,"item=main&menu=base")#}" onClick="set_hl(0);"><?=__('menu_site_setting')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=users&menu=user&action=index")#}" onClick="set_hl(1);"><?=__('menu_user_setting')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=files&menu=file&action=index")#}" onClick="set_hl(2);"><?=__('menu_files_manage')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=plugins&menu=plugin")#}" onClick="set_hl(3);"><?=__('menu_plugins_manage')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=templates&menu=lang_tpl")#}" onClick="set_hl(4);"><?=__('menu_template_language')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=advertisement&menu=extend")#}" onClick="set_hl(5);"><?=__('menu_extend_tools')?></a></li>
  	      <li><a href="{#urr(ADMINCP,"item=database&menu=tool&action=optimize")#}" onClick="set_hl(6);"><?=__('menu_system_tools')?></a></li>
        </ul>
  	    <div id="sitemap"><a href="{#urr(ADMINCP,"item=sitemap")#}" title="<?=__('sitemap_tips')?>">【SiteMap】</a>&nbsp;&nbsp;</div>
      </div>
	  </td>
  </tr>
  </table>
<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" style="background:#FCFCFC; padding:15px 0">
  <tr>
    <td valign="top" width="150" id="admincp_left_frame" >
	  <!--#require_once template_echo('menu',$admin_tpl_dir);#-->
	  </td>
	  <td class="expand_menu" valign="top">
	  <img id="menu_img" align="absmiddle" src="{$admin_tpl_dir}images/menu_left.gif" border="0" onClick="expand_menu();">
	  </td>
		<td valign="top" width="87%" id="admincp_main_frame">
			<!--#require_once $action_module;#-->
		</td>
		</tr>
	</table>
	<script type="text/javascript">
	if(getCookie('admincp_left_frame_status')=='0'){
		getId('admincp_left_frame').style.display = 'none';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_right.gif";
		getId('menu_img').alt = "<?=__('open_menu')?>";
		getId('admincp_main_frame').width="100%";
	}else{
		getId('admincp_left_frame').style.display = '';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_left.gif";
		getId('menu_img').alt = "<?=__('close_menu')?>";
		getId('admincp_main_frame').width="87%";
	}
	</script>
