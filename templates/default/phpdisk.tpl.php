<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: phpdisk.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="index_box">
<div class="l">
<div class="l_l"></div>
<div class="l_m">
<!--#include sub/block_gallery#-->
<!--#include sub/block_announce#-->
</div>
<div class="l_r"></div>
<div class="clear"></div>
</div>
<div class="r">
<div class="idx_r_box_login"> 
<!--#if(!$pd_uid){#-->
<form name="user_form" action="{#urr("account","")#}" method="post" onSubmit="return dosubmit(this);">
<input type="hidden" name="action" value="login" />
<input type="hidden" name="task" value="login" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="tit"><img src="images/login_nav.gif" width="18" height="18" align="absmiddle"><?=__('user_login')?></div>
<ul>
	<li>&nbsp;</li>
	<li class="li_input"><?=__('username')?>: <em class="u_em"><input class="u_input" type="text" name="username" value="" maxlength="20"></em></li>
	<li class="li_input"><?=__('password')?>: <em class="u_em"><input class="u_input" type="password" name="password" value="" maxlength="20"></em></li>
<!--#if($settings['login_verycode'] && $settings['open_verycode']){#-->  
	<li class="li_input"><?=__('verycode')?>: <input class="verycode" type="text" name="verycode" value="" maxlength="6"> <img style="cursor:pointer" id="imgcode" alt="<?=__('refresh')?>" border="0" onclick="chg_imgcode();" align="absbottom" /></li>
  <script type="text/javascript">
  getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type={$settings['verycode_type']}';
  function chg_imgcode(){
  	getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type={$settings['verycode_type']}&t='+Math.random();
  }
  </script>
	<!--#}#-->
	<li class="li_input2">&nbsp;<input type="submit" class="login_btn" value=""><input type="button" class="reg_btn" value="" onClick="go('{#urr("account","action=register")#}');" /></li>
	<!--#if($settings['open_demo_login']){#-->
	<li class="li_input3"><a href="{#urr("account","action=demologin")#}"><img src="images/demo_icon.gif" align="absmiddle" border="0"> <?=__('demo_login')?></a></li>
	<!--#}#-->
</ul>
</form>
<script language="javascript">
document.user_form.username.focus();
function dosubmit(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('invalid_username')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6){
		alert("<?=__('invalid_password')?>");
		o.password.focus();
		return false;
	}
<!--#if($settings['login_verycode']){#-->
	if(o.verycode.value.strtrim().length <4){
		alert("<?=__('invalid_verycode')?>");
		o.verycode.focus();
		return false;
	}
<!--#}#-->	
}
</script>
<!--#}else{#-->
<div class="tit"><img src="images/login_nav.gif" height="18" width="18" align="absmiddle"> <?=__('user_info')?></div>
<div class="l_info">
	<li>&nbsp;</li>
	<li><?=__('hello')?> , <a href="{#urr("space","username=".rawurlencode($pd_username))#}">{$pd_username}</a></li>
	<li>&nbsp;</li>
	<li><?=__('total_folders')?>: {$mystats['total_folders']}</li>
	<li><?=__('total_files')?>: {$mystats['total_files']}</li>
	<li><?=__('total_share_files')?>: {$mystats['total_share_files']}</li>
	<li><?=__('file_size_total')?>: {$mystats['file_size_total']}</li>
	<li><?=__('last_login_ip')?>: {$mystats['last_login_ip']}</li>
</div>
<!--#}#-->
</div>
</div>
<!--<div class="r_r"></div>
--><div class="clear"></div>
</div>
<div class="clear"></div>
<div class="index_box">
<div class="l">
<!--#include sub/block_hot_file_index#-->
</div>
<div class="r">
 <div class="idx_r_box"> 
 <div class="tit"><?=__('last_user_list')?></div>
 <ul>
 	<!--#
	if(count($last_users)){
		foreach($last_users as $v){
	#-->
 	<li><a href="{$v[a_space]}" target="_blank"><span class="txtgray" style="float:right">{$v[reg_time]}</span><img src="images/addbuddy.gif" align="absmiddle" border="0" />{$v[username]}</a></li>
	<!--#
		}
		unset($last_users);
	}
	#-->
 </ul>
 </div>
</div>
<div class="clear"></div>

<!--#if($settings['show_stat_index']){#-->
<div class="f_link">
<div class="tit"><span><img src="images/stat_icon.gif" align="absmiddle" border="0" /><?=__('site_stat')?></span></div>
<div class="ctn"><?=__('welcome_member')?>:<a href="{$last['a_last_user']}" title="{$last['username_all']}"><b>{$last['username']}</b></a> , <?=__('all_member')?>: <b>{$stats['users_count']}</b> , <?=__('all_file')?>: <b>{$stats['all_files_count']}</b> , <?=__('all_storage')?>: <b>{$stats['total_storage_count']}</b>
</div>
</div>
<!--#}#-->
<!--#include sub/block_links#-->
<div class="clear"></div>