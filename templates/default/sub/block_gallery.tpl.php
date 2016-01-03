<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: block_gallery.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($settings['gallery_type'] ==2){
#-->
<br />
<script type="text/javascript">
var picsarr = new Array();
var linksarr = new Array();
var textsarr = new Array();
var swf_width = {$settings[gallery_size_width]};
var swf_height = {$settings[gallery_size_height]};
var pics = '';
var links = '';
var texts = '';
<!--#
if(count($C[gallery_arr])){
	foreach($C[gallery_arr] as $k => $v){
#-->
	picsarr[{#($k+1)#}] = "{$v[gal_path]}";
	linksarr[{#($k+1)#}] = "{$v[go_url]}";
	textsarr[{#($k+1)#}] = "{$v[gal_title]}";
<!--#
	}
}
#-->
for(i=1;i<picsarr.length;i++){
	if(pics=="") pics = picsarr[i]; else pics += "|"+picsarr[i];
}
for(i=1;i<linksarr.length;i++){
	if(links=="") links = linksarr[i]; else links += "|"+linksarr[i];
}
for(i=1;i<textsarr.length;i++){
	if(texts=="") texts = textsarr[i]; else texts += "|"+textsarr[i];
}
document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ');
document.write('codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ');
document.write('width="'+ swf_width +'" height="'+ swf_height +'">');
document.write('<param name="movie" value="images/flash/gallery_{$settings[gallery_type]}.swf"><param name="quality" value="high">');
document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
document.write('<param name="FlashVars" value="TitleBgPosition=1&bcastr_file='+pics+'&bcastr_link='+links+'&bcastr_title='+texts+'">');
document.write('<embed src="images/flash/gallery_{$settings[gallery_type]}.swf" wmode="opaque" ');
document.write('FlashVars="TitleBgPosition=1&bcastr_file='+pics+'&bcastr_link='+links+'&bcastr_title='+texts+'& ');
document.write('menu="false" quality="high" width="'+ swf_width +'" height="'+ swf_height +'" type="application/x-shockwave-flash" ');
document.write('pluginspage="http://www.macromedia.com/go/getflashplayer" />');
document.write('</object>');
</script>
<div class="clear"></div>
<br />
<!--#
}else{
	if(count($C[gallery_arr])){
		foreach($C[gallery_arr] as $k => $v){
			$pics .= $v['gal_path'].'|';
			$links .= $v['go_url'].'|';
			$texts .= $v['gal_title'].'|';
		}
	}
#-->
<br />
<script type="text/javascript">
var focus_width = {$settings[gallery_size_width]};
var focus_height = {$settings[gallery_size_height]};
var text_height = 18;
var swf_height = focus_height+text_height;
var pics = clearText("{$pics}");
var links = clearText("{$links}");
var texts = clearText("{$texts}");
document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cabjavascript:void(0)version=6,0,0,0" width="'+ focus_width +'" height="'+ swf_height +'" align="left"  hspace="0">');
document.write('<param name="allowScriptAccess" value="sameDomain"><param name="movie" value="images/flash/gallery_{$settings['gallery_type']}.swf"><param name="quality" value="high"><param name="bgcolor" value="#F0F0F0">');
document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'">');
document.write('<embed src="images/flash/gallery_{$settings['gallery_type']}.swf" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'" menu="false" bgcolor="#F0F0F0" quality="high" width="'+ focus_width +'" height="'+ swf_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
document.write('</object>');
function clearText(str) {
	return str.substr(0, str.length - 1);
}
</script>
<div class="clear"></div>
<br />
<!--#
}
#-->
