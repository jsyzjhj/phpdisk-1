<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: version.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('admincp_version')?><!--#sitemap_tag(__('admincp_version'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('version_tips')?></span>
</div>
<br />
<!--#if($action){#-->
<!--#if($action && $action <>'step7'){#-->
<div><img src="images/ajax_load_bar.gif" align="absmiddle" border="0" /></div>
<br />
<!--#}#-->
<div class="f14"><b>{$action}</b> {$msg}</div>
<!--#}else{#-->
<div id="warning"><img src="images/loading.gif" border="0" align="absmiddle" /><?=__('version_checking')?></div>
<!--#}#-->
<div style="width:100%">
<iframe style="z-index: 1; display:none;overflow:auto; width:100%; height:auto; padding:1px; border:2px #efefef solid; margin-bottom:10px;" id="iframe_changelog" src="" frameborder="0" scrolling="auto"></iframe>
</div>
<br />
<div class="f14 txtred"><?=__('curr_version_info')?></div>
<br />
<div><b>PHPDisk {PHPDISK_EDITION} {PHPDISK_VERSION} [{$charset_info}]</b> (Build{PHPDISK_RELEASE})</div>
</div>
</div>
<script language="javascript">
function autoupdate(){
	var xmlhttp = createHttpRequest();
	xmlhttp.open("get","./admin/autoupdate.inc.php?action=upgrade",true);
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			var arr = xmlhttp.responseText.split('|');
			if(parseInt(arr[1]) > parseInt('{PHPDISK_RELEASE}')){
				getId('warning').innerHTML = "<span><?=__('last_version_is')?>："+arr[0]+" ,Release"+arr[1]+", <?=__('your_version_is')?>：{PHPDISK_EDITION} {PHPDISK_VERSION} Release{PHPDISK_RELEASE} , <a href={#urr(ADMINCP,"item=version&menu=tool&action=step1")#} onclick='return confirm(\"<?=__('confirm_update')?>\");' class=txtred><?=__('update_now')?></a> or <a href="+arr[2]+" target=_blank><?=__('download_update')?></a></span>";
				getId('iframe_changelog').src = arr[3];
				getId('iframe_changelog').style.display = '';
				getId('warning').className = "warning";
			}else{
				getId('warning').innerHTML = "<span><?=__('your_version_is_lastest')?></span>";
				getId('warning').className = "txtblue";
			}
		}
	}
	xmlhttp.send(null);
	document.write("<img src=http://www.phpdisk.com/autoupdate.php?edition={#rawurlencode(PHPDISK_EDITION)#}&version={PHPDISK_VERSION}&release={PHPDISK_RELEASE}&server={SERVER_NAME} width=0 height=0>");
	
}
<!--#if(!$action){#-->
autoupdate();
<!--#}#-->
</script>
