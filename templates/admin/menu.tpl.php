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
<script lanuage="javascript">
function expand(id){
	if(getId('box_'+id).style.display == ''){
		getId('box_'+id).style.display = 'none';
		getId('img_'+id).src = "{$admin_tpl_dir}images/menu_close.gif";
		setCookie('admincp_menu_'+id,1,30);
	}else{
		getId('box_'+id).style.display = '';
		getId('img_'+id).src = "{$admin_tpl_dir}images/menu_open.gif";
		setCookie('admincp_menu_'+id,0,30);
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
	<div class="menu_box">
	<div class="title"><img align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><a href="./" target="_blank"><?=__('menu_site_index')?></a> | <a href="{#urr(ADMINCP,"item=main")#}"><?=__('menu_admin_index')?></a></div>
	</div>
	<br/>
<!--# if($menu =='base'){#-->
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_site_panel')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=settings&menu=$menu&action=base")#}"><?=__('menu_base_setting')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=settings&menu=$menu&action=advanced")#}"><?=__('menu_advanced_setting')?></a></li>
	</div>
	</div>
	<br/>
<!--#}elseif($menu =='user'){#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_user_panel')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=users&menu=$menu&action=add_user")#}"><?=__('menu_add_user')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=groups&menu=$menu&action=index")#}"><?=__('menu_user_group')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=users&menu=$menu&action=index")#}"><?=__('menu_user_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=users&menu=$menu&action=active")#}"><?=__('menu_user_active')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_email')?></div>
	<div id="box_2">
	<li><a href="{#urr(ADMINCP,"item=email&menu=$menu&action=setting")#}"><?=__('menu_email_setting')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=email&menu=$menu&action=mail_test")#}"><?=__('menu_email_test')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_other')?></div>
	<div id="box_3">
	<li><a href="{#urr(ADMINCP,"item=verycode&menu=$menu")#}"><?=__('menu_verycode')?></a></li>
	</div>
	</div>
	<br/>
<!--#}elseif($menu =='file'){#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_files')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=files&menu=$menu&action=index")#}"><?=__('menu_files_list')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=tag&menu=$menu")#}"><?=__('menu_tag')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_public')?></div>
	<div id="box_2">
	<li><a href="{#urr(ADMINCP,"item=public&menu=$menu")#}"><?=__('menu_public_setting')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=public&menu=$menu&action=category")#}"><?=__('menu_public_category')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=public&menu=$menu&action=viewfile")#}"><?=__('menu_public_viewfile')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_report')?></div>
	<div id="box_3">
	<li><a href="{#urr(ADMINCP,"item=report&menu=$menu")#}"><?=__('menu_report_setting')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=report&menu=$menu&action=user")#}"><?=__('menu_report_user')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=report&menu=$menu&action=system")#}"><?=__('menu_report_system')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=report&menu=$menu&action=file_unlocked")#}"><?=__('menu_report_file_unlocked')?></a></li>
	</div>
	</div>
	<br/>
<!--#}elseif($menu =='plugin'){#-->
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_plugins_cp')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=plugins&menu=$menu&menu=$menu")#}"><?=__('menu_plugins_index')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=plugins&menu=$menu&menu=$menu&action=shortcut")#}"><?=__('menu_plugins_cp_setting')?></a></li>
	</div>
	</div>
	<br/>
	<!--#if($settings['open_plugins_cp']){#-->
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_plugins_shortcut')?></div>
	<div id="box_2">
	<!--#
	if(count($s_plugins_arr)){
		foreach($s_plugins_arr as $v){
	#-->
		<li>{#get_name($v['plugin_name'],$v['admin_url'],$v['actived'])#}</li>
	<!--#
		}
		unset($s_plugins_arr);
	}else{
	#-->
		<li><?=__('cp_plugin_not_found')?></li>
	<!--#
	}
	#-->
	</div>
	</div>
	<br/>
	<!--#}#-->
	<!--#if($settings['open_plugins_last']){#-->
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_plugins_last_actived')?></div>
	<div id="box_3">
	<!--#
	if(count($plugins_arr)){
		foreach($plugins_arr as $v){
	#-->
		<li>{#get_name($v['plugin_name'],$v['admin_url'],$v['actived'])#}</li>
	<!--#
		}
		unset($plugins_arr);
	}
	#-->
	</div>
	</div>
	<br/>
	<!--#}#-->
<!--#}elseif($menu =='lang_tpl'){#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_template_language')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=lang&menu=$menu")#}"><?=__('menu_lang_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=templates&menu=$menu")#}"><?=__('menu_template_manage')?></a></li>
	</div>
	</div>
	<br/>
<!--#}elseif($menu =='extend'){#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_extend')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=advertisement&menu=$menu&action=index")#}"><?=__('menu_adv_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=link&menu=$menu&action=index")#}"><?=__('menu_link_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=announce&menu=$menu&action=index")#}"><?=__('menu_announce_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=navigation&menu=$menu&action=index")#}"><?=__('menu_navigation_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=credit&menu=$menu&action=index")#}"><?=__('menu_credit_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=comment&menu=$menu&action=index")#}"><?=__('menu_comment_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=seo&menu=$menu&action=index")#}"><?=__('menu_seo_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=union&menu=$menu&action=index")#}"><?=__('menu_union_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=gallery&menu=$menu&action=index")#}"><?=__('menu_gallery_manage')?></a></li>
	</div>
	</div>
	<br/>
<!--#}elseif($menu =='tool'){#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_database_manage')?></div>
	<div id="box_1">
	<li><a href="{#urr(ADMINCP,"item=database&menu=$menu&action=optimize")#}"><?=__('menu_database_optimize')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=database&menu=$menu&action=backup")#}"><?=__('menu_database_backup')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=database&menu=$menu&action=restore")#}"><?=__('menu_database_restore')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_system_setting')?></div>
	<div id="box_2">
	<li><a href="{#urr(ADMINCP,"item=cache&menu=$menu&action=search_index")#}"><?=__('menu_search_index')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=cache&menu=$menu&action=update")#}"><?=__('menu_cache_manage')?></a></li>
	<li><a href="{#urr(ADMINCP,"item=version&menu=$menu")#}"><?=__('menu_version_check')?></a></li>
	</div>
	</div>
	<br/>
<!--#}else{#-->	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><?=__('menu_system_common')?></div>
	<div id="box_1">
	<!--#
	if(count($cs_menus)){
		foreach($cs_menus as $v){
	#-->
	<li><a href="{#urr(ADMINCP,"$v[url]")#}">{$v['title']}</a></li>
	<!--#
		}
		unset($cs_menus);
	#-->	
	<li><a href="{#urr(ADMINCP,"item=sitemap&action=setting")#}" class="txtblue"><?=__('menu_system_common_setting')?></a></li>
	<!--#
	}else{
	#-->
	<li><?=__('none_common_menu')?></li>
	<!--#
	}
	#-->
	</div>
	</div>
	<br/>
<!--#}#-->	
	<div class="menu_box">
	<div class="title"><img align="absmiddle" src="{$admin_tpl_dir}images/menu_open.gif" border=0><a href="{#urr(ADMINCP,"item=users&action=adminlogout")#}" onClick="return confirm('<?=__('system_logout_confirm')?>');"><?=__('menu_logout')?></a></div>
	</div>
	<br/>
</div>
