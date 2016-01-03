<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_viewfile.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($settings['open_thunder']){#-->
<script src="http://pstatic.xunlei.com/js/webThunderDetect.js"></script>
<!--#}#-->
<!--#if($settings['open_flashget']){#-->
<script src="http://ufile.qushimeiti.com/Flashget_union.php?fg_uid={$settings['flashget_uid']}"></script>
<script type="text/javascript">
function ConvertURL2FG(url,fUrl,uid){	
	try{
		FlashgetDown(url,uid);
	}catch(e){
		location.href = fUrl;
	}
}
function Flashget_SetHref(obj,uid){obj.href = obj.fg;}
</script>
<!--#}#-->
<!--#if($settings['open_vote']){#-->
	<script type="text/javascript">
	var lang = new Array();
	lang['vote_just'] = "<?=__('vote_just')?>";
	</script>
	<script type="text/javascript" src="includes/js/digg.js"></script>
<!--#}#-->
<div class="layout_box">
<!--#if(!$action){#-->
<div class="l">
<!--#if($file['is_del']){#-->
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/> <?=__('file_is_del')?></div>
<script type="text/javascript">
setTimeout('function re(){top.location = "{$settings['phpdisk_url']}"};re();',5000);
</script>
<!--#}elseif($file['is_locked'] && $pd_gid<>1){#-->
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/> <?=__('locked_msg')?></div>
<!--#}elseif(!$file['in_share'] && ($file['userid'] <> $pd_uid) && !$file['is_public'] && $pd_gid<>1 && !$file['in_extract']){#-->
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/> <?=__('not_share_msg')?></div>
<!--#}else{#-->
<div class="file_box">
	<h3 id="file_tit">{#file_icon($file['file_extension'],'filetype_32','absbottom')#} {$file['file_name']}</h3>
	<div class="fb_l">
		<table width="100%" cellpadding="4" cellspacing="0" align="center" class="td_line f14">
		<tr>
			<td width="50%"><?=__('uploader')?>: {$file['username']}</td>
			<td><?=__('file_size')?>: {$file['file_size']}</td>
		</tr>
		<tr>
			<td><?=__('upload_ip')?>:<span id="file_upload_ip">{#ip_encode($file['ip'])#}</span></td>
			<td><?=__('upload_time')?>: <span id="file_upload_time">{$file['file_time']}</span></td>
		</tr>
		<tr>
			<td><?=__('file_downs')?>: <span id="file_downs">{$file['file_downs']}</span> </td>
			<td><?=__('file_views')?>: <span id="file_views">{$file['file_views']}</span> </td>
		</tr>
		<tr>
			<td colspan="2"><?=__('file_tag')?>: {$file['tags']}</td>
		</tr>
		<tr>
			<td colspan="2"><!-- JiaThis Button BEGIN -->
<div id="jiathis_style_32x32">
	<a class="jiathis_button_qzone"></a>
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_renren"></a>
	<a class="jiathis_button_kaixin001"></a>
	<a href="http://www.jiathis.com/share?uid=91831" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<!-- JiaThis Button END --></td>
		</tr>
		</table>
		<!--#if($file['file_description']){#-->
		<div id="file_desc" class="txtgray f14"><?=__('description')?>:<br />{$file['file_description']}</div>
		<br /><br />
		<!--#}#-->
	</div>
	<div class="fb_r">
	<br />
	<br />
	<!--#show_adv_data('adv_viewfile_right');#-->
	</div>
</div>
<div class="clear"></div>
<br />
{#preview_file($file)#}
	<!--#show_adv_data('adv_viewfile_hits_bottom');#-->
<!--#if($settings['open_vote']){#-->
<div class="digg">
<div id="digg0" onmouseover="this.style.backgroundPosition='0 0'" onmouseout="this.style.backgroundPosition='-189px 0'" onfocus="this.blur()" onClick="pdVote({$file['file_id']},1)">
	<div class="digg_bar"><div id="eimg1" style="width:{$file['g_px']}px"></div></div>
	<span id="barnum1"><span id="sp1">{$file['good_rate']}%</span> (<span id="s1">{$file['good_count']}</span>)</span>
</div>
<div id="digg1" onmouseover="this.style.backgroundPosition='-567px 0'" onmouseout="this.style.backgroundPosition='-378px 0'" onfocus="this.blur()" onclick="pdVote({$file['file_id']},2)">
	<div class="digg_bar"><div id="eimg2" style="width:{$file['b_px']}px"></div></div>
	<span id="barnum2"><span id="sp2">{$file['bad_rate']}%</span> (<span id="s2">{$file['bad_count']}</span>)</span>
</div>
</div>
<div class="clear"></div>
<!--#}#-->

<!--#if($settings['open_file_url']){#-->
<div class="file_url">
	<li class="txtgray"><?=__('file_view_url')?>: <input type="text" class="txtgray" value="{$file['file_view_url']}" id="f_view" size="55" onclick="getId('f_view').select();copy_text('f_view');" readonly/>&nbsp;&nbsp;<input type="button" value="<?=__('copy_link')?>" onclick="getId('f_view').select();copy_text('f_view');" /></li>
	<li class="txtgray"><?=__('file_ubb_url')?>: <input type="text" class="txtgray" value="{$file['file_ubb_url']}" id="f_ubb" size="55" onclick="getId('f_ubb').select();copy_text('f_ubb');" readonly />&nbsp;&nbsp;<input type="button" value="<?=__('copy_link')?>" onclick="getId('f_ubb').select();copy_text('f_ubb');" /></li>
	<li class="txtgray"><?=__('file_html_url')?>: <input type="text" class="txtgray" value="{$file['file_html_url']}" id="f_html" size="55" onclick="getId('f_html').select();copy_text('f_html');" readonly />&nbsp;&nbsp;<input type="button" value="<?=__('copy_link')?>" onclick="getId('f_html').select();copy_text('f_html');" /></li>
</div>
<!--#}#-->

<!--#show_adv_data('adv_viewfile_download_top');#-->
<div class="file_item">
	<li>&nbsp;</li>
	<li>
	<!--#if($settings['login_down_file'] && !$pd_uid && $file['userid']){#-->
	<span class="file_login"><?=__('file_down_tips')?></span>
	<!--#}elseif(!$file['is_checked'] && $pd_gid<>1){#-->
	<span class="file_status"><?=__('file_checking')?></span>
	<!--#}else{#-->
			<span id="down_link"></span>&nbsp;&nbsp;
			<!--#if($settings['open_thunder']){#-->
			<span id="file_thunder"><a oncontextmenu=ThunderNetwork_SetHref(this) onclick="return OnDownloadClick_Simple(this,2,4)" href="#" thunderResTitle="{$file['file_name']}" thunderType="" thunderPid="{$settings['thunder_pid']}" thunderHref="{$file['thunder_url']}"><img src="images/thunder.gif" border="0" align="absbottom" /> <?=__('thunder_download')?></a></span>
			<!--#}#-->
			<!--#if($settings['open_flashget']){#-->
			<span id="file_flashget"><a href="#" onClick="ConvertURL2FG('{$file['flashget_url']}','{$file['url']}',{$settings['flashget_uid']})" oncontextmenu="Flashget_SetHref(this)" fg="{$file['flashget_url']}"><img src="images/flashget.gif" border="0" align="absbottom" /> <?=__('flashget_download')?></a></span>
			<!--#}#-->
			<script type="text/javascript">
			var secs = {$loading_secs};
			var wait = secs * 1000;
			var data_loading = "<img src=\"images/ajax_loading.gif\" align=\"absmiddle\" border=\"0\" /><?=__('data_loading')?>";
			getId('down_link').innerHTML = data_loading + " (" + secs + ")";
			for(i = 1; i <= secs; i++) {
				window.setTimeout("update_sec(" + i + ")", i * 1000);
			}
			window.setTimeout("down_file_link()", wait);
			function update_sec(num, value) {
				if(num == (wait/1000)) {
					getId('down_link').innerHTML = data_loading;
				} else {
					echo = (wait / 1000) - num;
					getId('down_link').innerHTML = data_loading + " (" + echo + ")";
				}
			}
			function down_file_link() {
				getId('down_link').innerHTML = "<a href=\"{$file['a_downfile']}\" onclick=\"down_process('{$file['file_id']}');\"><img src=\"images/down.gif\" border=\"0\" align=\"absbottom\" /> <?=__('download_this_file')?></a>";
			}
			function down_process(file_id){
				var xmlhttp = createHttpRequest();
				xmlhttp.open("get","ajax.php?action=down_process&file_id="+file_id,true);
				xmlhttp.onreadystatechange = function(){
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
						if(xmlhttp.responseText == 'true'){
							getId('down_link').innerHTML = "<img src=\"images/ajax_loading.gif\" align=\"absmiddle\" border=\"0\" /><span class='txtred'><?=__('data_loading')?></span>";
							setTimeout('down_file_link()',3000);
						}
					}
				}
				xmlhttp.send(null);
			}
			</script>
	<!--#}#-->
	</li>
	<!--#show_adv_data('adv_viewfile_download_bottom');#-->
</div>
<br />
<!--#
if(count($relate_file)){
#-->
<div class="fl_box">
<div class="tit2"><?=__('user_other_file')?></div>
<ul>
<!--#
	foreach($relate_file as $k =>$v){
		
#-->
<li><a href="{$v['a_viewfile']}"><span class="txtgray" style="float:right">{$v[file_time]}</span>{#file_icon($v['file_extension'])#} {$v['file_name']}</a></li>
<!--#
	}
	unset($relate_file);
#-->
</ul>
</div>
<!--#
}
#-->
<!--#
if(count($you_like_file)){
#-->
<div class="fl_box" style="margin-left:10px">
<div class="tit2"><?=__('you_like_file')?></div>
<ul>
<!--#
	foreach($you_like_file as $k =>$v){
		
#-->
<li><a href="{$v['a_viewfile']}"><span class="txtgray" style="float:right">{$v[file_time]}</span>{#file_icon($v['file_extension'])#} {$v['file_name']}</a></li>
<!--#
	}
	unset($you_like_file);
#-->
</ul>
</div>
<!--#
}
#-->
<div class="clear"></div>
<br />
<div>	
	<li style="margin-top:8px;">
	<!--#if($settings['open_report']){#-->
	<a href="javascript:void(0);" onclick="display_box('report_box');" title="<?=__('report_title')?>"><img src="images/report.gif" border="0" align="absbottom" /> <?=__('to_report')?></a>
	<!--#}#-->
	<!--#if($settings['open_comment']){#-->
	<a href="javascript:void(0);" onclick="display_box('cmt_box');" title="<?=__('cmt_title')?>"><img src="images/cmt.gif" border="0" align="absbottom" /> <?=__('to_comment')?></a>
	<!--#}#-->
	</li>
</div>
<div id="report_box" class="rb" style="display:none">
<!--#if($has_report){#-->
<div class="warning"><?=__('report_already_exists')?></div>
<!--#}else{#-->
<form action="viewfile.php" method="post" onsubmit="return doreport(this);">
<input type="hidden" name="action" value="report" />
<input type="hidden" name="file_id" value="{$file['file_id']}" />
<input type="hidden" name="file_key" value="{$file['file_key']}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li class="txtgray"><?=__('report_content')?>:</li>
<li><textarea name="content" rows="8" cols="60">{$login_txt}</textarea></li>
<li><input type="submit" value="<?=__('btn_submit')?>" class="btn" {$disabled} />&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cb('report_box');" title="<?=__('close')?>">[X]</a></li>
</form>
<!--#}#-->
</div>
<div id="cmt_box" class="rb" style="display:none">
<form action="viewfile.php" method="post" onsubmit="return docmt(this);">
<input type="hidden" name="action" value="comment" />
<input type="hidden" name="file_id" value="{$file['file_id']}" />
<input type="hidden" name="file_key" value="{$file['file_key']}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li class="txtgray"><?=__('cmt_content')?>:</li>
<li><textarea name="content" rows="8" cols="60">{$login_txt}</textarea></li>
<li><input type="submit" value="<?=__('btn_submit')?>" class="btn" {$disabled} />&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cb('cmt_box');" title="<?=__('close')?>">[X]</a></li>
</form>
</div>
<br />
<!--#if($settings['open_comment']){#-->
	<div class="cmt_u_box">
	<div class="cmt_title"><img src="images/ico_cmt.gif" align="absmiddle" border="0" /><?=__('user_cmts')?>:</div>
	<!--#
	if(count($cmts)){
		foreach($cmts as $v){
	#-->
	<div class="cmt_cts">
		<div class="cmt_name"><a href="{$v['a_space']}" target="_blank"><img src="images/ico_home.gif" align="absmiddle" border="0" />{$v['username']}</a> <span class="f11 txtgray">@ {$v['in_time']}</span></div>
		<div class="cmt_content">{$v['content']}</div>
	</div>
	<!--#
		}
		unset($cmts);
	#-->
	<div align="right"><a href="{$a_comment}"><?=__('view_all_cmts')?></a></div>
	<!--#
	}else{
	#-->
	<div class="cmt_cts"><?=__('cmt_not_found')?></div>
	<!--#
	}
	#-->
	</div>
<!--#}#-->
<script language="javascript">
function display_box(id){
	if(id =='cmt_box'){
		getId('cmt_box').style.display = '';
		getId('report_box').style.display = 'none';
	}else{
		getId('cmt_box').style.display = 'none';
		getId('report_box').style.display = '';
	}
}
function cb(id){
	getId(id).style.display = 'none';
}
function doreport(o){
	if(o.content.value.strtrim().length <2 || o.content.value.strtrim().length >100){
		alert("<?=__('report_content_error')?>");
		o.content.focus();
		return false;
	}
}
function docmt(o){
	if(o.content.value.strtrim().length <2 || o.content.value.strtrim().length >200){
		alert("<?=__('cmt_content_error')?>");
		o.content.focus();
		return false;
	}
}
function copy_text(id){
	var field = getId(id);
	if (field){
		if (document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('txt_copy_success')?>");
		}	
	}
}
</script>
<!--#}#-->
</div>
<div class="r">
<!--#
if(count($C[relate_file]) && $settings['show_relative_file']){
#-->
<br />
<div class="common_box">
<div class="tit2"><?=__('same_extension_file')?></div>
<ul>
<!--#
	foreach($C[relate_file] as $v){
#-->
<li>{#file_icon($v['file_extension'])#} <a href="{$v['a_viewfile']}">{$v['file_name']}</a></li>
<!--#
	}
#-->
</ul>
</div>
<!--#
}
#-->
<div class="clear"></div>
<br />
<!--#show_adv_data('adv_right');#-->
</div>
<!-- end not action -->
<!--#}#-->
<div class="clear"></div>
</div>
<script type="text/javascript">var jiathis_config = {data_track_clickback:true};</script>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=91831" charset="utf-8"></script>
