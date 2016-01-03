<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: upload.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script type="text/javascript">
function open_tag(){
<!--#if($settings['open_tag'] && $action !='upload_replace'){#-->
	return true;
<!--#}else{#-->
	return false;
<!--#}#-->
}
function upload_replace(){
<!--#if($action =='upload_replace'){#-->
	return true;
<!--#}else{#-->
	return false;
<!--#}#-->
}
</script>
<script type="text/javascript" src="includes/js/core.js"></script>
<script type="text/javascript" src="includes/js/queue.js"></script>
<script type="text/javascript" src="includes/js/progress.js"></script>
<script type="text/javascript" src="includes/js/speed.js"></script>
<script type="text/javascript" src="includes/js/events.js"></script>
<script type="text/javascript">
var lang = new Array();
lang['has_upload'] = "<?=__('has_upload')?>";
lang['current_speed'] = "<?=__('current_speed')?>";
lang['queue_too_many_files'] = "<?=__('queue_too_many_files')?>";
lang['current_file_size'] = "<?=__('current_file_size')?>";
lang['file_too_big'] = "<?=__('file_too_big')?>";
lang['zero_byte_file'] = "<?=__('zero_byte_file')?>";
lang['unknown_error'] = "<?=__('unknown_error')?>";
lang['upload_complete'] = "<?=__('upload_complete')?>";
lang['js_tag'] = "<?=__('js_tag')?>";
lang['js_tag_tips'] = "<?=__('js_tag_tips')?>";
lang['js_content'] = "<?=__('js_content')?>";
lang['js_expand'] = "<?=__('js_expand')?>";
lang['replace_file_tips'] = "<?=__('replace_file_tips')?>";
var upl;
window.onload = function() {
	var settings = {
		flash_url : "includes/js/upload.swf",
		upload_url: '{$upload_url}',
		post_params: {"task":"{$action}","file_id":"{$file_id}"},
		file_size_limit : "{$max_user_file_size}B",
		file_types : "{$user_file_types}",
		button_image_url : "images/upload_icon.gif",
		button_placeholder_id : "spanPDButton",
		button_width: 110,
		button_height: 18,
		button_text : "<span><?=__('select_your_files')?>({$max_user_file_size})</span>",
		file_queued_handler : fileQueued,
		file_dialog_complete_handler: fileDialogComplete,
		file_queue_error_handler : fileQueueError,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		custom_settings : {
			uploadprogressbar : "uploadprogressbar"
		}
	};
	upl = new SWFUpload(settings);
 };
</script>

<div id="container">
<!--#if($is_public){#-->
<div class="store_nav"><?=__('store_location')?>：<img src="images/icon_nav.gif" align="absmiddle" border="0" />
<!--#if($cate_id){#-->
	<!--#if($subcate_id){#-->
	<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$a_cate}';"><img src="images/folder_open.gif" border="0" align="absmiddle" />{$cate_name}</a> &raquo; 
	<img src="images/folder_open.gif" border="0" align="absmiddle" />{$subcate_name}
	<!--#}else{#-->
	<img src="images/folder_open.gif" border="0" align="absmiddle" />{$cate_name}
	<!--#}#-->
<!--#}else{#-->	
	<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{#urr("mydisk","item=public&action=index")#}';"><img src="images/tree/base.gif" border="0" align="absmiddle" /><?=__('temp_store_space')?></a>
<!--#}#-->	
</div>
<!--#}else{#-->
<div class="store_nav"><?=__('store_location')?>：<img src="images/icon_nav.gif" align="absmiddle" border="0" /><a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{#urr("mydisk","item=files&action=index")#}';"><img src="images/disk.gif" border="0" align="absmiddle" /><?=__('root_folder')?></a>
<!--#if($folder_node){#-->
	<!--#if($folder_node ==4){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$disk_href}';">{$disk_name}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$parent_href2}';">{$parent_folder2}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$parent_href}';">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name}
	<!--#}elseif($folder_node ==3){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$disk_href}';">{$disk_name}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$parent_href}';">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name}
	<!--#}elseif($folder_node ==2){#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;<a href="javascript:;" onclick="self.parent.$.jBox.close(true);self.parent.document.location='{$parent_href}';">{$parent_folder}</a>
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="top" />&nbsp;{$folder_name}
	<!--#}else{#-->
	&raquo;&nbsp;<img src="images/folder_open.gif" border="0" align="absmiddle" />&nbsp;{$folder_name}
	<!--#}#-->
<!--#}#-->
</div>
<!--#}#-->

<!--#if($cannot_upload){#-->
<div class="up_msg_box">
<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen">{$hints_msg}</span></div>
<br><br>
<div align="center"><input type="button" class="btn" value="<?=__('btn_close')?>" onclick="self.parent.$.jBox.close(true);" /></div>
</div>
<!--#}else{#-->
<div class="upload_style">
	<span id="spanPDButton"></span>
</div>
<div class="upload_btn">
	<input type="button" class="btn" style="height:2.5em" value="<?=__('btn_upload_file')?>" id="upload_btn" disabled="disabled"/>
</div>
<div class="clear"></div>
</div>	
<div id="up_msg_tips" style="display:none"><img src="images/up_suc.gif" align="absmiddle" border="0" /> <span id="up_msg"></span> <a href="###" onclick="self.parent.$.jBox.close(true);self.parent.document.location.reload();"><?=__('close')?></a></div>
<div id="uploadprogressbar"></div>
</div>

<!--#}#-->
