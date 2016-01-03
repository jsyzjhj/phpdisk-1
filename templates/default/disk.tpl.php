<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: disk.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='buy'){#-->
<div id="container">
<h1><?=__('buy_disk')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('buy_disk_tips')?></span>
</div>
</div>
<script language="javascript">
$(document).ready(function(){
	$(".disk_box").each(function(){
		$(this).mouseover(function(){
			$(this).addClass("disk_sel_bg");
		}).mouseout(function(){
			$(this).removeClass("disk_sel_bg");
		});
	});
});
</script>

<div>
<div class="f14" style=" margin-left:10px; padding:5px"><img src="images/icon_nav.gif" align="absmiddle" border="0" /> <?=__('your_credit')?>:  <span class="txtred bold">{$my_credit}</span>
</div>
<!--#
if(!count($disks)){
#-->
<div align="center" style="padding:10px"><?=__('disk_not_found')?></div>
<!--#
}else{
#-->
<!--#
	foreach($disks as $k => $v){
#-->
<form action="{#urr("mydisk","item=disk")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="disk_id" value="{$v['disk_id']}" />
<input type="hidden" name="formhash" value="{$formhash}" />
	<div class="disk_box">
	<li class="disk_tit"><img src="images/disk.gif" align="absmiddle" border="0" />{$v['title']}</li>
	<!--#if($v['logo']){#-->
	<li><img src="{$v['logo']}" style="padding:2px" align="top" border="0" /></li>
	<!--#}#-->
	<li><?=__('space_size')?>: {$v['space']}</li>
	<li><?=__('space_expire')?>: <font class="bold">{$v['expire']}</font> <?=__('day')?></li>
	<li><?=__('space_price')?>: <font class="bold txtred">{$v['price']}</font> <?=__('credit')?></li>
	<li><input type="submit" class="btn" onclick="return confirm('<?=__('buy_disk_confirm')?>\r\n\r\n({$v['title']})');" value="<?=__('buy_or_expand')?>" /></li>
	</div>
</form>	
<!--#
		if(($k+1)%4==0){ echo "<div class='clear'></div>";}
	}
	unset($disks);
}
#-->
<div class="clear"></div>
<br />
</div>
</div>
<!--#}else{#-->
<div id="container">
<h1><?=__('disk_manage')?></h1>
<div class="tips_box_p">
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('disk_manage_tips')?></span>
</div>
</div>
<form action="{#urr("mydisk","item=disk")#}" method="post">
<input type="hidden" name="task" value="setting"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><span class="bold"><?=__('my_current_credits')?>:</span></td>
	<td><span class="txtred bold">{$my_credit}</span>&nbsp;&nbsp;<a href="{$a_online_pay}"><?=__('online_pay')?></a></td>
</tr>
<tr>
	<td><span class="bold"><?=__('cur_space_pos')?>:</span><br /><span class="txtgray"><?=__('cur_space_pos_tips')?></span></td>
	<td><input type="radio" name="space_pos" value="0" {#ifchecked(0,$space_pos)#} /><?=__('free_space')?>&nbsp;&nbsp;<input type="radio" name="space_pos" value="1" {#ifchecked(1,$space_pos)#} /><?=__('rent_space')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('rent_space')?>:</span></td>
	<td><?=__('used')?> <b>{$rs_used}</b>/<b>{$rs_all}</b>, <?=__('at')?> {$rs_rate}% 
	<!--#if($has_time){#-->
	<span class="txtred">(<?=__('starttime')?>:{$starttime},<?=__('leave_time')?> <font class="txtblue">{$leave_time}</font> <?=__('day')?>)</span>
	<!--#}#-->
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('free_space')?>:</span></td>
	<td><?=__('used')?> <b>{$fs_used}</b>/<b>{$fs_all}</b>, <?=__('at')?> {$fs_rate}%</td>
</tr>
<tr>
	<td><span class="bold"><?=__('total_space')?>:</span></td>
	<td><?=__('used')?> <b>{$ts_used}</b>/<b>{$ts_all}</b>, <?=__('at')?> {$ts_rate}%</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold"><?=__('pay_space')?>:</span></td>
	<td><select name="pay_expand_time" id="pay_expand_time" onchange="show_pay_credit();">
	<option value="0"><?=__('pls_select')?></option>
	<option value="15"><?=__('disk_half_month')?></option>
	<option value="30"><?=__('disk_one_month')?></option>
	<option value="60"><?=__('disk_two_month')?></option>
	<option value="90"><?=__('disk_three_month')?></option>
	<option value="180"><?=__('disk_half_year')?></option>
	<option value="365"><?=__('disk_one_year')?></option>
	</select>&nbsp;&nbsp;<span class="txtblue" id="pay_tips"></span>
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;
	<input type="button" class="btn" value="<?=__('buy_or_expand')?>" onclick="go('{#urr("mydisk","item=disk&action=buy")#}');" />
	</td>
</tr>
</table>
</form>
</div>
<script type="text/javascript">
function show_pay_credit(){
	var tmp = getId('pay_expand_time').value;
	getId('pay_tips').innerHTML = (tmp==0) ? "<?=__('pls_select')?>" : "<?=__('need_credit')?> "+Math.round({$space_day_credits} * tmp);
}
</script>
<!--#}#-->