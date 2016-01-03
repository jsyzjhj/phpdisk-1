<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: profile.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action =='password'){
#-->
<div id="container">
<h1><?=__('modify_password')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('modify_password_tips')?></span>
</div>
</div>
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return chkform(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="15%" align="right"><?=__('current_password')?>: </td>
	<td><input type="password" name="old_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<tr>
	<td width="10%" align="right"><?=__('new_password')?>: </td>
	<td><input type="password" name="new_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<tr>
	<td width="10%" align="right"><?=__('confirm_password')?>: </td>
	<td><input type="password" name="cfm_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
<script language="javascript">
function chkform(o){
	if(o.old_pwd.value.strtrim().length <6){
		alert("<?=__('invalid_password')?>");
		o.old_pwd.focus();
		return false;
	}	
	if(o.new_pwd.value.strtrim().length <6){
		alert("<?=__('password_too_short')?>");
		o.new_pwd.focus();
		return false;
	}
	if(o.new_pwd.value != o.cfm_pwd.value){
		alert("<?=__('confirm_password_invalid')?>");
		o.cfm_pwd.focus();
		return false;
	}
}
</script>
<!--#}elseif($action =='payment'){#-->
<div id="container">
<h1><?=__('credit_manage')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('credit_manage_tips')?></span>
</div>
</div>
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return dosubmit(this);" target="_blank">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><span class="bold"><?=__('my_wealth')?></span>: </td>
	<td>{$wealth}&nbsp;&nbsp;<a href="{#urr("mydisk","item=profile&menu=$menu&action=history")#}"><?=__('view_history')?></a></td>
</tr>
<tr>
	<td><span class="bold"><?=__('my_credit')?></span>: </td>
	<td>{$credit}</td>
</tr>
<tr>
	<td><span class="bold"><?=__('auto_convert')?></span>: <br /><span class="txtgray"><?=__('credit_rate')?>: 1 <?=__('wealth')?> = {$settings['credit_convert']} <?=__('credit')?></span></td>
	<td><input type="radio" name="auto_convert" value="1" checked="checked"/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="auto_convert" value="0" /><?=__('no')?></td>
</tr>
<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_payment'],0)){#-->
<tr>
	<td><span class="bold"><?=__('online_pay')?></span>: </td>
	<td><input type="text" name="money" value="{$settings['default_amount']}" size="2" maxlength="4" style="text-align:center" onkeypress="return regInput(this,/^\d*$/,String.fromCharCode(event.keyCode))" /> <?=__('pay_byte')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('payment_gateway')?></span>: </td>
	<td>	
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_alipay'],0)){#-->
	<input type="radio" name="pv" value="alipay" onclick="put_value('alipay');" /><img src="images/alipay_icon.gif" align="absmiddle" border="0" />&nbsp;
	<!--#}#-->
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_tenpay'],0)){#-->
	<input type="radio" name="pv" value="tenpay" onclick="put_value('tenpay');" /><img src="images/tenpay_icon.gif" align="absmiddle" border="0" />&nbsp;
	<!--#}#-->
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_chinabank'],0)){#-->
	<input type="radio" name="pv" value="chinabank" onclick="put_value('chinabank');" /><img src="images/chinabank_icon.gif" align="absmiddle" border="0" />&nbsp;
	<!--#}#-->
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_yeepay'],0)){#-->
	<input type="radio" name="pv" value="yeepay" onclick="put_value('yeepay');" /><img src="images/yeepay_icon.gif" align="absmiddle" border="0" />&nbsp;
	<!--#}#-->
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="hidden" name="task" id="task" /><input type="submit" class="btn" id="s1" value=" <?=__('start_pay')?> " /></td>
</tr>
<!--#}else{#-->
<tr>
	<td>&nbsp;</td>
	<td><span class="txtred"><?=__('credit_pay_close')?></span></td>
</tr>
<!--#}#-->
</table>
</form>
<script language="javascript">
function regInput(obj, reg, inputStr){
	var docSel	= document.selection.createRange();
	if (docSel.parentElement().tagName != "INPUT")	return false;
	oSel = docSel.duplicate();
	oSel.text = "";
	var srcRange = obj.createTextRange();
	oSel.setEndPoint("StartToStart", srcRange);
	var str = oSel.text + inputStr + srcRange.text.substr(oSel.text.length);
	return reg.test(str);
}
function put_value(val){
	getId('task').value = val;
}
function dosubmit(o){
	if(o.task.value.strtrim() ==''){
		alert("<?=__('pls_select_payment')?>");
		return false;
	}
	var reg = /^-?\d+$/;
	if(reg.test(o.money.value.strtrim())){
		getId('s1').disabled = true;
		getId('s1').value = '<?=__(txt_paying)?>';	
		return true;
	}else{
		alert("<?=__('money_invalid')?>");
		o.money.focus();
		return false;
	}
}
</script>
<br /><br />
</div>
<!--#}elseif($action =='exchange'){#-->
<div id="container">
<h1><?=__('credit_exchange')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('credit_exchange_tips')?></span>
</div>
</div>
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return dosubmit2(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="exchange2wealth"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><span class="bold"><?=__('common_exchange')?></span>(<span class="txtgray"><?=__('common_exchange_tips')?></span>)</td>
</tr>
<tr>
	<td width="30%"><?=__('your_credit')?>:</td>
	<td>{$myinfo[credit]}</td>
</tr>
<tr>
	<td><?=__('my_wealth')?>: </td>
	<td class="txtblue">{$myinfo[wealth]}</td>
</tr>
<!--#if($common_msg){#-->
<tr>
	<td colspan="2" class="txtred">{$common_msg}</td>
</tr>
<!--#}else{#-->
<tr>
	<td><?=__('wealth_out')?>:</td>
	<td><input type="text" id="towealth" name="towealth" value="0" onkeyup="calwealth();" maxlength="10" /></td>
</tr>
<tr>
	<td><?=__('credit_to')?>:</td>
	<td><input type="text" id="deswealth" name="deswealth" value="0" disabled /></td>
</tr>
<tr>
	<td><?=__('credit_rate')?>:</td>
	<td>1 <?=__('wealth')?> = {$settings['credit_convert']} <?=__('credit')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" id="s2" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
<!--#}#-->
</table>
</form>
<script type="text/javascript">
function dosubmit2(o){
	if(o.wealth.value.toInt() ==0){
		alert("<?=__('wealth_not_zero')?>");
		o.wealth.focus();
		return false;
	}
	getId('s2').disabled = true;
	getId('s2').value = "<?=__('txt_processing')?>";
}
function calwealth(){
	getId('towealth').value = getId('towealth').value.toInt();
	if(getId('towealth').value >{$wealth}){
		getId('towealth').value = {$wealth};
	}
	if(getId('towealth').value != 0) {
		getId('deswealth').value = Math.floor({$settings['credit_convert']} * getId('towealth').value);
	} else {
		getId('deswealth').value = getId('towealth').value;
	}
}

</script>
<br />
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="exchange2uc"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><span class="bold"><?=__('uc_exchange')?></span>(<span class="txtgray"><?=__('uc_exchange_tips')?></span>)</td>
</tr>
<!--#if($uc_msg){#-->
<tr>
	<td colspan="2" class="txtred">{$uc_msg}</td>
</tr>
<!--#}else{#-->
<tr>
	<td width="30%"><?=__('credit_pwd')?>:</td>
	<td><input type="password" name="password" value="" maxlength="20"/></td>
</tr>
<tr>
	<td><?=__('credit_out')?>:</td>
	<td><input type="text" id="amount" name="amount" value="0" onkeyup="calcredit();" maxlength="10" /></td>
</tr>
<tr>
	<td><?=__('credit_to')?>:</td>
	<td>
	<input type="text" id="desamount" value="0" disabled />&nbsp;&nbsp;
	<select name="tocredits" id="tocredits" onChange="calcredit();">
	<!--#
	if(is_array($_CACHE['creditsettings'])) {
		foreach($_CACHE['creditsettings'] as $k => $v) { 
			if($v['ratio']) { 
	#-->
	<option value="{$k}" unit="{$v['unit']}" title="{$v['title']}" ratio="{$v['ratio']}">{$v['title']}</option>
	<!--#
			}
		}
	}#-->
	</select>
	</td>
</tr>
<tr>
	<td><?=__('credit_rate')?></td>
	<td>
	<span class="bold">1</span>
	<span id="orgcreditunit"><?=__('credit')?></span>
	<span id="orgcredittitle"></span>
	<?=__('exchange')?>&nbsp;<span class="bold" id="descreditamount">..</span>
	<span id="descreditunit"></span>
	<span id="descredittitle"></span>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" id="s1" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
<!--#}#-->
</table>
</form>
<script type="text/javascript">
function dosubmit(o){
	if(o.password.value.strtrim().length <6){
		alert("<?=__('password_not_null')?>");
		o.password.focus();
		return false;
	}
	if(o.amount.value.toInt() ==0){
		alert("<?=__('amount_not_zero')?>");
		o.amount.focus();
		return false;
	}
	getId('s1').disabled = true;
	getId('s1').value = "<?=__('txt_processing')?>";
}
function calcredit(){
	tocredit = getId('tocredits')[getId('tocredits').selectedIndex];
	getId('descreditunit').innerHTML = tocredit.getAttribute('unit');
	getId('descredittitle').innerHTML = tocredit.getAttribute('title');
	getId('descreditamount').innerHTML = Math.round(1/tocredit.getAttribute('ratio') * 100) / 100;
	getId('amount').value = getId('amount').value.toInt();
	if(getId('amount').value >{$credit}){
		getId('amount').value = {$credit};
	}
	if(getId('amount').value != 0) {
		getId('desamount').value = Math.floor(1/tocredit.getAttribute('ratio') * getId('amount').value);
	} else {
		getId('desamount').value = getId('amount').value;
	}
}
</script>
</div>
<!--#}elseif($action =='history'){#-->
<div id="container">
<h1><?=__('pay_history')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('pay_history_tips')?></span>
</div>
</div>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($logs)){
#-->
<tr>
	<td class="bold"><?=__('order_number')?></td>
	<td align="center" class="bold"><?=__('pay_method')?></td>
	<td align="center" class="bold"><?=__('total_fee')?></td>
	<td align="center" class="bold"><?=__('pay_status')?></td>
	<td align="center" class="bold"><?=__('in_time')?></td>
	<td align="center" class="bold"><?=__('ip')?></td>
</tr>
<!--#
}
#-->
<!--#
if(count($logs)){
	foreach($logs as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
		$k++;
#-->
<tr class="{$color}">
	<td>{$k}. {$v['order_number']}</td>
	<td align="center">{$v['pay_method']}</td>
	<td align="center">{$v['total_fee']}</td>
	<td align="center">{$v['pay_status']}</td>
	<td align="center"><span class="txtgray">{$v['in_time']}</span></td>
	<td align="center">{$v['ip']}</td>
</tr>
<!--#
	}
	unset($logs);
}else{
#-->
<tr>
	<td colspan="7" align="center"><?=__('none_logs')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="7">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
<br /><br />
</div>
<!--#}else{#-->
<div id="container">
<h1><?=__('profile_title')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('profile_title_tips')?></span>
</div>
</div>
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line" id="f_tab">
<tr>
	<td class="bold" colspan="2"><?=__('my_disk_stat')?>:</td>
</tr>
<tr>
	<td width="30%"><?=__('my_credit')?>: </td>
	<td>{$myinfo[credit]}</td>
</tr>
<tr>
	<td><?=__('my_wealth')?>: </td>
	<td>{$myinfo[wealth]}</td>
</tr>
<tr>
	<td><?=__('my_exp')?>: </td>
	<td>{$myinfo[exp]}</td>
</tr>
<tr>
	<td><?=__('total_folders')?>: </td>
	<td>{$stats['total_folders']} </td>
</tr>
<tr>
	<td><?=__('total_share_folders')?>: </td>
	<td>{$stats['total_share_folders']} </td>
</tr>
<tr>
	<td><?=__('total_files')?>: </td>
	<td>{$stats['total_files']} </td>
</tr>
<tr>
	<td><?=__('file_size_total')?>: </td>
	<td>
	<div class="tit"><?=__('disk_info')?>:</div>
	<div class="disk_info" title="<?=__('disk_remain')?>: {$nav_arr['disk_remain']}% ({$nav_arr['disk_space']})">
	<div style="background:url(images/disk_bar.gif);width:{$nav_arr['disk_fill']}px;">&nbsp;</div>
	</div>
	<div style="color:#666">{$nav_arr['now_space']}/{$nav_arr['max_storage']} (<b>{$nav_arr['disk_percent']}%</b>)</div>
	</td>
</tr>
<tr>
	<td><?=__('reg_time')?>: </td>
	<td>{$stats['reg_time']}</td>
</tr>
<tr>
	<td><?=__('last_login_time')?>: </td>
	<td>{$stats['last_login_time']}</td>
</tr>
<tr>
	<td><?=__('reg_ip')?>: </td>
	<td>{$stats['reg_ip']}</td>
</tr>
<tr>
	<td><?=__('last_login_ip')?>: </td>
	<td>{$stats['last_login_ip']}</td>
</tr>
<tr>
	<td><?=__('reg_email')?>: </td>
	<td>{$stats['email']}</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>	
<tr>
	<td class="bold" colspan="2"><?=__('my_power')?>:</td>
</tr>
<tr>
	<td><?=__('current_group')?>: </td>
	<td>{$pd_group_name}</td>
</tr>
<tr>
	<td><?=__('max_flow_down')?>: </td>
	<td>{$group_set['max_flow_down']}</td>
</tr>
<tr>
	<td><?=__('max_flow_view')?>: </td>
	<td>{$group_set['max_flow_view']}</td>
</tr>
<tr>
	<td><?=__('max_storage')?>: </td>
	<td>{$group_set['max_storage']}</td>
<tr>
<tr>
	<td><?=__('max_filesize')?>: </td>
	<td>{$group_set['max_filesize']}</td>
</tr>
<tr>
	<td><?=__('max_folders')?>: </td>
	<td>{$group_set['max_folders']}</td>
</tr>
<tr>
	<td><?=__('max_files')?>: </td>
	<td>{$group_set['max_files']}</td>
</tr>
<tr>
	<td><?=__('user_file_types')?>: </td>
	<td>{$group_set['user_file_types']}</td>
</tr>
</table>
<br /><br />
</div>
<!--#}#-->
