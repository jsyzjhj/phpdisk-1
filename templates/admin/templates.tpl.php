<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: templates.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('tpl_title')?><!--#sitemap_tag(__('tpl_title'));#--></h1>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('template_tips')?></span>
</div>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold" width="180"><?=__('tpl_snapshot')?></td>
	<td class="bold" width="120"><?=__('style_dir')?></td>
	<td class="bold" width="50%"><?=__('tpl_des')?></td>
	<td class="bold" align="right" width="60"><?=__('operation')?></td>
</tr>
<!--#
if(count($templates_arr)){
	foreach($templates_arr as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
		$tpl_type = (trim($v['tpl_type']) =='admin') ? "<span class='txtgreen'>(".__('admin_tpl').")</span>" : "<span class='txtblue'>(".__('user_tpl').")</span>";
#-->
<tr class="{$color}">
	<td><img src="templates/{$v['tpl_dir']}/images/snapshot.gif" align="absmiddle" border="0" style="margin-bottom:8px"  /><br />{$v['tpl_title']}</td>
	<td>{$v['tpl_dir']}{$tpl_type}</td>
	<td>
	<table>
		<tr>
			<td>{$v['tpl_desc']}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>	
				<span class="txtgray"><?=__('tpl_author')?>:</span><a href="{$v['tpl_site']}" target="_blank">{$v['tpl_author']}</a>&nbsp;
				<span class="txtgray"><?=__('tpl_version')?>:{$v['tpl_version']}</span>&nbsp;
				<span class="txtgray"><?=__('phpdisk_core')?>:{$v['phpdisk_core']}</span>
			</td>
		</tr>
	</table>
	</td>
	<td align="right">
	<!--# if($v['actived']){#-->
	<span class="txtgray"><?=__('actived_tpl')?></span>
	<!--# }else{#-->
	<a href="{#urr(ADMINCP,"item=templates&menu=lang_tpl&tpl_id=".$v['tpl_dir']."&action=active")#}" class="txtblue"><?=__('set_active_tpl')?></a>
	<!--#}#-->
	</td>
</tr>
<!--#
	}
	unset($templates_arr);
}
#-->
</table>
</div>