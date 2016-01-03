<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: credit.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('credit_manage')?><!--#sitemap_tag(__('credit_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('credit_manage_tips')?></span>
</div>
<form name="user_frm" action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('credit_open')?>:</span><br /><span class="txtgray"><?=__('credit_open_tips')?></span></td>
	<td><input type="radio" name="setting[credit_open]" value="1" {#ifchecked(1,$settings['credit_open'])#}/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[credit_open]" value="0" {#ifchecked(0,$settings['credit_open'])#}/><?=__('no')?></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('credit_union')?>:</span><br /><span class="txtgray"><?=__('credit_union_tips')?></span></td>
	<td>
	<?=__('credit_name')?> <input type="text" id="cu" name="setting[credit_union]" value="{$settings['credit_union']}" size="5" maxlength="10" /> ， 
	<?=__('wealth_name')?> <input type="text" id="wu" name="setting[wealth_union]" value="{$settings['wealth_union']}" size="5" maxlength="10" /> ， 
	<?=__('exp_name')?> <input type="text" id="eu" name="setting[exp_union]" value="{$settings['exp_union']}" size="5" maxlength="10" />
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_credit_convert')?>:</span><br /><span class="txtgray"><?=__('open_credit_convert_tips')?></span></td>
	<td><input type="radio" name="setting[open_credit_convert]" value="1" {#ifchecked(1,$settings['open_credit_convert'])#}/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_credit_convert]" value="0" {#ifchecked(0,$settings['open_credit_convert'])#}/><?=__('no')?></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('credit_convert')?>:</span><br /><span class="txtgray"><?=__('credit_convert_tips')?></span></td>
	<td><input type="text" name="setting[credit_convert]" value="{$settings['credit_convert']}" size="5" maxlength="6" /></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('exp_const')?>:</span><br /><span class="txtgray"><?=__('exp_const_tips')?></span></td>
	<td><input type="text" name="setting[exp_const]" value="{$settings['exp_const']}" size="5" maxlength="6" /></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="7"><span class="bold"><?=__('credit_setting')?>:</span><span class="txtgray">(<?=__('credit_tips')?>)</span></td>
</tr>
<tr>
	<td width="50"><?=__('project')?></td>
	<td width="100" align="center"><?=__('credit_reg')?></td>
	<td width="100" align="center"><?=__('credit_login')?></td>
	<td width="100" align="center"><?=__('credit_invite')?></td>
	<td width="100" align="center"><?=__('credit_msg')?></td>
	<td width="100" align="center"><?=__('credit_upload')?></td>
	<td width="100" align="center"><?=__('credit_down')?></td>
	<td width="100" align="center"><?=__('credit_down_my')?></td>
</tr>
<tr>
	<td class="bold"><?=__('credit')?></td>
	<td align="center">(+)<input type="text" name="setting[credit_reg]" value="{$settings['credit_reg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[credit_login]" value="{$settings['credit_login']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[credit_invite]" value="{$settings['credit_invite']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(-)<input type="text" name="setting[credit_msg]" value="{$settings['credit_msg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[credit_upload]" value="{$settings['credit_upload']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(-)<input type="text" name="setting[credit_down]" value="{$settings['credit_down']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[credit_down_my]" value="{$settings['credit_down_my']}" size="1" maxlength="2" style="text-align:center"/></td>
</tr>
<!--tr>
	<td class="bold"><?=__('wealth')?></td>
	<td align="center">(+)<input type="text" name="setting[wealth_reg]" value="{$settings['wealth_reg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[wealth_login]" value="{$settings['wealth_login']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[wealth_invite]" value="{$settings['wealth_invite']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(-)<input type="text" name="setting[wealth_msg]" value="{$settings['wealth_msg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[wealth_upload]" value="{$settings['wealth_upload']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(-)<input type="text" name="setting[wealth_down]" value="{$settings['wealth_down']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[wealth_down_my]" value="{$settings['wealth_down_my']}" size="1" maxlength="2" style="text-align:center"/></td>
</tr-->
<tr>
	<td class="bold"><?=__('exp')?></td>
	<td align="center">(+)<input type="text" name="setting[exp_reg]" value="{$settings['exp_reg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_login]" value="{$settings['exp_login']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_invite]" value="{$settings['exp_invite']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_msg]" value="{$settings['exp_msg']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_upload]" value="{$settings['exp_upload']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_down]" value="{$settings['exp_down']}" size="1" maxlength="2" style="text-align:center"/></td>
	<td align="center">(+)<input type="text" name="setting[exp_down_my]" value="{$settings['exp_down_my']}" size="1" maxlength="2" style="text-align:center"/></td>
</tr>
<tr>
	<td colspan="7">&nbsp;</td>
</tr>
<tr>
	<td align="center" colspan="7"><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(){
	if(getId('cu').value.strtrim() == ''){
		alert("<?=__('cu_error')?>");
		getId('cu').focus();
		return false;
	}
	if(getId('wu').value.strtrim() == ''){
		alert("<?=__('wu_error')?>");
		getId('wu').focus();
		return false;
	}
	if(getId('wu').value.strtrim() == ''){
		alert("<?=__('wu_error')?>");
		getId('wu').focus();
		return false;
	}
}
</script>