<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: verycode.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('verycode_title')?><!--#sitemap_tag(__('verycode_title'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('verycode_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=user")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_verycode')?></span>: <br /><span class="txtgray"><?=__('open_verycode_tips')?></span></td>
	<td><input type="radio" name="setting[open_verycode]" value="1" {#ifchecked(1,$setting['open_verycode'])#}/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_verycode]" value="0" {#ifchecked(0,$setting['open_verycode'])#}/><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('op_verycode')?></span>: <br /><span class="txtgray"><?=__('verycode_tips')?></span></td>
	<td><input type="checkbox" name="setting[register_verycode]" id="reg" value="1" {#ifchecked(1,$setting['register_verycode'])#} /><label for="reg"><?=__('register_verycode')?></label>&nbsp;
	<input type="checkbox" name="setting[login_verycode]" id="login" value="1" {#ifchecked(1,$setting['login_verycode'])#}/><label for="login"><?=__('login_verycode')?></label>&nbsp;
	<input type="checkbox" name="setting[forget_verycode]" id="forget" value="1" {#ifchecked(1,$setting['forget_verycode'])#}/><label for="forget"><?=__('forget_verycode')?></label>&nbsp;
	<input type="checkbox" name="setting[active_verycode]" id="active" value="1" {#ifchecked(1,$setting['active_verycode'])#}/><label for="active"><?=__('active_verycode')?></label>&nbsp;
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('verycode_type')?></span>: <br /><span class="txtgray"><?=__('verycode_type_tips')?></span></td>
	<td>
	<!--#for($i=1;$i<=2;$i++){#-->
	<input type="radio" name="setting[verycode_type]" id="vt_{$i}" value="{$i}" {#ifchecked($i,$settings['verycode_type'])#} /><img src="includes/imgcode.inc.php?verycode_type={$i}&nosess=1&t={$timestamp}" align="absbottom" style="cursor:pointer"/>&nbsp;&nbsp;
	<!--#}#-->
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
