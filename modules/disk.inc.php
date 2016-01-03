<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: disk.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

if(!display_plugin('disk','open_disks_plugin',$settings['open_disks'],0)){
	exit('ERROR: disks'.__('plugin_not_install'));
}

$my_credit = $db->result_first("select credit from {$tpf}users where userid='$pd_uid' limit 1");

switch($action){
	case 'buy':
		if($task =='buy'){
			form_auth(gpc('formhash','P',''),formhash());

			$disk_id = (int)gpc('disk_id','P',0);

			if(!$disk_id){
				$error = true;
				$sysmsg[] = __('buy_error');
			}
			$rs = $db->fetch_one_array("select * from {$tpf}disks where disk_id='$disk_id'");
			if($rs){
				$expire_time = $rs['expire']*86400;
				$space = strtoupper($rs['space']);
				$space_day_credits = @round($rs['price']/$rs['expire'],2);
				$disk_price = $rs['price'];
			}
			unset($rs);
			$user_rent_space = $db->result_first("select user_rent_space from {$tpf}users where userid='$pd_uid' limit 1");

			if($disk_price > $my_credit){
				$error = true;
				$sysmsg[] = __('not_enough_credit');
			}
			if(get_byte_value($user_rent_space) >= get_byte_value($space)){
				$error = true;
				$sysmsg[] = __('pls_rent_biger_space');
			}

			if(!$error){
				$tmp = $db->result_first("select space_day_credits from {$tpf}users where userid='$pd_uid' limit 1");
				$expand_space = 0;
				$rs = $db->fetch_one_array("select * from {$tpf}disk2user where userid='$pd_uid' limit 1");
				if($rs['endtime'] > $timestamp){
					$expand_space = 1;
					$sub_credit = round($tmp * (floor(($rs['endtime']-$timestamp)/86400)));
				}
				unset($rs);

				$num = $db->result_first("select count(*) from {$tpf}disk2user where userid='$pd_uid' limit 1");
				if($num){
					$ins = array(
					'disk_id' => $disk_id,
					'starttime' => $timestamp,
					'endtime' => $timestamp+$expire_time,
					);
					$db->query_unbuffered("update {$tpf}disk2user set ".$db->sql_array($ins)." where userid='$pd_uid';");
				}else{
					$ins = array(
					'disk_id' => $disk_id,
					'userid' => $pd_uid,
					'starttime' => $timestamp,
					'endtime' => $timestamp+$expire_time,
					);
					$db->query_unbuffered("insert into {$tpf}disk2user set ".$db->sql_array($ins).";");
				}
				$disk_price = $expand_space ? ((int)$disk_price -$sub_credit) : $disk_price;
				$db->query_unbuffered("update {$tpf}users set credit=credit-$disk_price,user_rent_space='$space',space_day_credits='$space_day_credits',space_pos=1 where userid='$pd_uid'");

				$sysmsg[] = __('buy_disk_success');
				redirect(urr("mydisk","item=disk"),$sysmsg,3000);
			}else{
				redirect("javascript:history.back()",$sysmsg);
			}

		}else{
			function list_disk(){
				global $db,$tpf;
				$q = $db->query("select * from {$tpf}disks where is_hidden=0 order by show_order asc, disk_id asc");
				$disks = array();
				while($rs = $db->fetch_array($q)){
					$disks[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $disks;
			}
			$disks = list_disk();
			require_once template_echo('disk',$user_tpl_dir);
		}
		break;

	default:
		if($task =='setting'){
			form_auth(gpc('formhash','P',''),formhash());

			$space_pos = (int)gpc('space_pos','P',0);
			$pay_expand_time = (int)gpc('pay_expand_time','P',0);

			$space_day_credits = $db->result_first("select space_day_credits from {$tpf}users where userid='$pd_uid' limit 1");
			$tmp_credit = $space_day_credits * $pay_expand_time;

			if($tmp_credit >$my_credit){
				$error = true;
				$sysmsg[] = __('expand_credit_not_enough');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}users set space_pos='$space_pos',credit=credit-$tmp_credit where userid='$pd_uid' limit 1");
				$last_time = $pay_expand_time * 86400;
				$db->query_unbuffered("update {$tpf}disk2user set endtime=endtime+$last_time where userid='$pd_uid' limit 1");

				$sysmsg[] = __('update_setting_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}

		}else{
			$group_set = $group_settings[$pd_gid];
			$fs_used = $db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid' and space_pos=0");
			$rs_used = $db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid' and space_pos=1");
			$ts_used = get_size($fs_used+$rs_used);
			$fs_used = get_size($fs_used);
			$rs_used = get_size($rs_used);

			$rs = $db->fetch_one_array("select user_store_space,user_rent_space,space_day_credits,space_pos from {$tpf}users where userid='$pd_uid'");
			if($rs['user_store_space'] ==0){
				$fs_all = $group_set['max_storage']==0 ? __('no_limit') : $group_set['max_storage'];
			}else{
				$fs_all = $rs['user_store_space'];
			}
			$rent_space = $rs['user_rent_space'];
			$space_pos = $rs['space_pos'];
			$space_day_credits = $rs['space_day_credits'];
			unset($rs);

			$rs = $db->fetch_one_array("select du.*,d.space from {$tpf}disk2user du,{$tpf}disks d where du.disk_id=d.disk_id and  du.userid='$pd_uid' order by du.disk_id desc limit 1");
			if($rs){
				$leave_time = floor(($rs['endtime']-$timestamp)/86400);
				$has_time = ($timestamp<$rs['endtime']) ? 1 : 0;
				$starttime = date("Y-m-d H:i:s",$rs['starttime']);
			}
			unset($rs);
			$rs_all = $rent_space ? $rent_space : 0;
			$ts_all = $fs_all ? (get_size(get_byte_value($fs_all)+get_byte_value($rs_all))) : __('no_limit') ;

			$fs_rate = $fs_all ? @round(get_byte_value($fs_used)/get_byte_value($fs_all),2)*100 : 0;
			$rs_rate = $rs_all ? @round(get_byte_value($rs_used)/get_byte_value($rs_all),2)*100 : 0;
			$ts_rate = $ts_all ? @round(get_byte_value($ts_used)/get_byte_value($ts_all),2)*100 : 0;

			$a_online_pay = urr("mydisk","item=profile&menu=$menu&action=payment");
			require_once template_echo('disk',$user_tpl_dir);
		}

}
?>
