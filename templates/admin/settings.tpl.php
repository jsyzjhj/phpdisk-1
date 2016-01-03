<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: settings.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='base'){
#-->
<div id="container">
<h1><?=__('base_setting')?><!--#sitemap_tag(__('base_setting'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('setting_tips')?></span><br />
<span class="txtred">{$file_path_tips}</span>
</div>
<form action="{#urr(ADMINCP,"item=settings&menu=base")#}" method="post" onsubmit="return chksettings();">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('site_title')?></span>: <br /><span class="txtgray"><?=__('site_title_tips')?></span></td>
	<td><input type="text" id="site_title" name="setting[site_title]" value="{$setting['site_title']}" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('site_stat')?></span>: <br /><span class="txtgray"><?=__('site_stat_tips')?></span></td>
	<td><textarea id="site_stat" name="setting[site_stat]" style="width:300px;height:30px">{$setting['site_stat']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('site_stat','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('site_stat','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('miibeian')?></span>: <br /><span class="txtgray"><?=__('miibeian_tips')?></span></td>
	<td><input type="text" id="miibeian" name="setting[miibeian]" value="{$setting['miibeian']}" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('contact_us')?></span>: <br /><span class="txtgray"><?=__('contact_us_tips')?></span></td>
	<td><input type="text" id="contact_us" name="setting[contact_us]" value="{$setting['contact_us']}" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('phpdisk_url')?></span>: <br /><span class="txtgray"><?=__('phpdisk_url_tips')?></span></td>
	<td><input type="text" id="phpdisk_url" name="setting[phpdisk_url]" value="{$setting['phpdisk_url']}" size="40" maxlength="150"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('encrypt_key')?></span>: <br /><span class="txtgray"><?=__('encrypt_key_tips')?></span></td>
	<td><input type="text" id="encrypt_key" name="setting[encrypt_key]" value="{$setting['encrypt_key']}" maxlength="16"/>&nbsp;<input type="button" value="<?=__('make_random')?>" class="btn" onclick="make_code();" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('allow_access')?></span>: <br /><span class="txtgray"><?=__('allow_access_tips')?></span></td>
	<td><input type="radio" name="setting[allow_access]" value="1" {#ifchecked(1,$setting['allow_access'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[allow_access]" value="0" {#ifchecked(0,$setting['allow_access'])#}/> <?=__('no')?><br />
	<textarea name="setting[close_access_reason]" id="close_access_reason" style="width:300px; height:30px">{$settings['close_access_reason']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('close_access_reason','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('close_access_reason','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('allow_register')?></span>: <br /><span class="txtgray"><?=__('allow_register_tips')?></span></td>
	<td><input type="radio" name="setting[allow_register]" value="1" {#ifchecked(1,$setting['allow_register'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[allow_register]" value="0" {#ifchecked(0,$setting['allow_register'])#}/> <?=__('no')?><br />
	<textarea name="setting[close_register_reason]" id="close_register_reason" style="width:300px; height:30px">{$settings['close_register_reason']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('close_register_reason','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('close_register_reason','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
<script language="javascript">
function chksettings(){
	if(getId('site_title').value.strtrim().length <1){
		alert("<?=__('js_site_title')?>");
		getId('site_title').focus();
		return false;
	}
	if(getId('phpdisk_url').value.strtrim().length <1){
		alert("<?=__('js_phpdisk_url')?>");
		getId('phpdisk_url').focus();
		return false;
	}
	if(getId('encrypt_key').value.strtrim().length <8){
		alert("<?=__('js_encrypt_key')?>");
		getId('encrypt_key').focus();
		return false;
	}
}
function make_code(){
   var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   var tmp = "";
   var code = "";
   for(var i=0;i<12;i++){
	   code += chars.charAt(Math.ceil(Math.random()*100000000)%chars.length);
   }
   getId('encrypt_key').value = code;
}
</script>
</div>
</div>
<!--#}elseif($action =='advanced'){#-->
<div id="container">
<h1><?=__('advanced_setting')?><!--#sitemap_tag(__('advanced_setting'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('setting_tips')?></span><br />
<span class="txtred">{$file_path_tips}</span>
</div>
<form action="{#urr(ADMINCP,"item=settings&menu=base")#}" method="post" onsubmit="return chksettings();">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('max_file_size')?></span>: <br /><span class="txtgray"><?=__('max_file_size_tips')?></span></td>
	<td><input type="text" id="max_file_size" name="setting[max_file_size]" value="{$setting['max_file_size']}" maxlength="10"/> <?=__('current_file_size')?>: <b>{$max_user_file_size}</b></td>
</tr>
<tr>
	<td><span class="bold"><?=__('file_path')?></span>: <br /><span class="txtgray"><?=__('file_path_tips')?></span></td>
	<td><input type="text" id="file_path" name="setting[file_path]" value="{$setting['file_path']}" maxlength="30"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('login_down_file')?></span>: <br /><span class="txtgray"><?=__('login_down_file_tips')?></span></td>
	<td><input type="radio" name="setting[login_down_file]" value="1" {#ifchecked(1,$setting['login_down_file'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[login_down_file]" value="0" {#ifchecked(0,$setting['login_down_file'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_demo_login')?></span>: <br /><span class="txtgray"><?=__('open_demo_login_tips')?></span></td>
	<td><input type="radio" name="setting[open_demo_login]" value="1" {#ifchecked(1,$setting['open_demo_login'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_demo_login]" value="0" {#ifchecked(0,$setting['open_demo_login'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('secs_for_user')?></span>: <br /><span class="txtgray"><?=__('secs_for_user_tips')?></span></td>
	<td><input type="radio" name="setting[secs_for_user]" value="1" {#ifchecked(1,$setting['secs_for_user'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[secs_for_user]" value="0" {#ifchecked(0,$setting['secs_for_user'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('global_secs_loading')?></span>: <br /><span class="txtgray"><?=__('global_secs_loading_tips')?></span></td>
	<td><input type="text" name="setting[global_secs_loading]" value="{$setting['global_secs_loading']}" maxlength="5"/> </td>
</tr>
<tr>
	<td><span class="bold"><?=__('gzipcompress')?></span>: <br /><span class="txtgray"><?=__('gzipcompress_tips')?></span></td>
	<td><input type="radio" name="setting[gzipcompress]" value="1" {#ifchecked(1,$setting['gzipcompress'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[gzipcompress]" value="0" {#ifchecked(0,$setting['gzipcompress'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('perpage')?></span>: <br /><span class="txtgray"><?=__('perpage_tips')?></span></td>
	<td><input type="text" id="perpage" name="setting[perpage]" value="{$setting['perpage']}" maxlength="3"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_file_preview')?></span>: <br /><span class="txtgray"><?=__('open_file_preview_tips')?></span></td>
	<td><input type="radio" name="setting[open_file_preview]" value="1" {#ifchecked(1,$settings['open_file_preview'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_file_preview]" value="0" {#ifchecked(0,$settings['open_file_preview'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_file_extract_code')?></span>: <br /><span class="txtgray"><?=__('open_file_extract_code_tips')?></span></td>
	<td><input type="radio" name="setting[open_file_extract_code]" value="1" {#ifchecked(1,$settings['open_file_extract_code'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_file_extract_code]" value="0" {#ifchecked(0,$settings['open_file_extract_code'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('downfile_directly')?></span>: <br /><span class="txtgray"><?=__('downfile_directly_tips')?></span></td>
	<td><input type="radio" name="setting[downfile_directly]" value="1" {#ifchecked(1,$settings['downfile_directly'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[downfile_directly]" value="0" {#ifchecked(0,$settings['downfile_directly'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('show_relative_file')?></span>: <br /><span class="txtgray"><?=__('show_relative_file_tips')?></span></td>
	<td><input type="radio" name="setting[show_relative_file]" value="1" {#ifchecked(1,$settings['show_relative_file'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_relative_file]" value="0" {#ifchecked(0,$settings['show_relative_file'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('show_hot_file_right')?></span>: <br /><span class="txtgray"><?=__('show_hot_file_right_tips')?></span></td>
	<td><input type="radio" name="setting[show_hot_file_right]" value="1" {#ifchecked(1,$settings['show_hot_file_right'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_hot_file_right]" value="0" {#ifchecked(0,$settings['show_hot_file_right'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('show_stat_index')?></span>: <br /><span class="txtgray"><?=__('show_stat_index_tips')?></span></td>
	<td><input type="radio" name="setting[show_stat_index]" value="1" {#ifchecked(1,$settings['show_stat_index'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_stat_index]" value="0" {#ifchecked(0,$settings['show_stat_index'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('invite_register_encode')?></span>: <br /><span class="txtgray"><?=__('invite_register_encode_tips')?></span></td>
	<td><input type="radio" name="setting[invite_register_encode]" value="1" {#ifchecked(1,$settings['invite_register_encode'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[invite_register_encode]" value="0" {#ifchecked(0,$settings['invite_register_encode'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('create_default_folder')?></span>: <br /><span class="txtgray"><?=__('create_default_folder_tips')?></span></td>
	<td><input type="text" name="setting[create_default_folder]" value="{$settings['create_default_folder']}" maxlength="30" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('all_file_share')?></span>: <br /><span class="txtgray"><?=__('all_file_share_tips')?></span></td>
	<td><input type="radio" name="setting[all_file_share]" value="1" {#ifchecked(1,$settings['all_file_share'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[all_file_share]" value="0" {#ifchecked(0,$settings['all_file_share'])#}/> <?=__('no')?>&nbsp;&nbsp;<a href="{#urr(ADMINCP,"item=settings&menu=base&action=share")#}" onclick="return confirm('<?=__('confirm_all_share')?>');"><?=__('set_all_file_share')?></a></td>
</tr>
<tr>
	<td><span class="bold"><?=__('share_tool')?></span>: <br /><span class="txtgray"><?=__('share_tool_tips')?></span></td>
	<td>
	<textarea name="setting[share_tool]" id="share_tool" style="width:300px; height:30px">{$settings['share_tool']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('share_tool','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('share_tool','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">使用本地存储上传</span>: <br /><span class="txtgray">使用经典的上传方式，用户可以把自己本地电脑上的上传并存储到网盘上。</span></td>
	<td><input type="radio" name="setting[hide_local_store]" value="0" {#ifchecked(0,$setting['hide_local_store'])#}/> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[hide_local_store]" value="1" {#ifchecked(1,$setting['hide_local_store'])#} /> <?=__('no')?>&nbsp;&nbsp;<a href="http://faq.phpdisk.com/phpdisk-yun-33-view.html" target="_blank" class="txtred">本地存储上传与网盘云存储上传比较与区别>></a></td>
</tr>
<tr>
	<td><span class="bold">使用网盘云存储上传</span>: <br /><span class="txtgray">用户可以把<a href="http://yun.phpdisk.com/" target="_blank" class="txtred">网盘云</a>上自己帐号的文件引用到您的网盘站上，用户下载此类文件时，均不占用您的网盘站空间及带宽，大大降低您的网盘站存储成本。</span></td>
	<td><a href="http://bbs.phpdisk.com/forum-33-1.html" target="_blank" class="txtblue">有问题？网盘云在线交流反馈等着你>></a><br /><input type="radio" name="setting[hide_yun_store]" value="1" {#ifchecked(1,$setting['hide_yun_store'])#} /> 不使用&nbsp;&nbsp;	<br />	<input type="radio" name="setting[hide_yun_store]" value="0" {#ifchecked(0,$setting['hide_yun_store'])#}/> 网盘云用户版&nbsp;&nbsp;<br /><input type="radio" name="setting[hide_yun_store]" value="2" {#ifchecked(2,$setting['hide_yun_store'])#}/> 网盘云站长版，站长版密钥：<input type="text" name="setting[yun_site_key]" value="{$settings[yun_site_key]}" size="40" maxlength="32" />&nbsp;&nbsp;
	</td>
</tr>
<!--#if($auth['is_commercial_edition']){#-->
<tr>
	<td><span class="bold">隐藏授权链接查询</span>: <br /><span class="txtgray">系统底部将会出现一个授权链接，可点击查询域名是否是官方正版授权用户，或快捷获得官方技术支持。</span></td>
	<td><input type="radio" name="setting[hide_license]" value="1" {#ifchecked(1,$setting['hide_license'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[hide_license]" value="0" {#ifchecked(0,$setting['hide_license'])#}/> <?=__('no')?></td>
</tr>
<!--#}#-->
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
<script language="javascript">
function chksettings(){
	if(getId('max_file_size').value.strtrim().length <1){
		alert("<?=__('js_max_file_size')?>");
		getId('max_file_size').focus();
		return false;
	}
	if(getId('dst').value.strtrim() == ''){
		alert("<?=__('show_hot_file_right_error')?>");
		getId('dst').focus();
		return false;
	}
	if(getId('perpage').value.strtrim().length <1){
		alert("<?=__('js_perpage')?>");
		getId('perpage').focus();
		return false;
	}
}
</script>
</div>
</div>
<!--#}#-->
