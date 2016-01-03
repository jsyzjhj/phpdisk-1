<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: profile.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

if($pd_uid){
	$myinfo = get_mydisk_info($pd_uid);
}
$credit = $myinfo['credit'];
$nav_arr = get_my_nav();

switch($action){
	case 'password':

		if($task == 'password'){
			form_auth(gpc('formhash','P',''),formhash());

			$old_pwd = trim(gpc('old_pwd','P',''));
			$new_pwd = trim(gpc('new_pwd','P',''));
			$cfm_pwd = trim(gpc('cfm_pwd','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$rs = $db->fetch_one_array("select userid from {$tpf}users where password='".md5($old_pwd)."' and userid='$pd_uid'");
			if(!$rs){
				$error = true;
				$sysmsg[] = __('invalid_password');
			}
			unset($rs);
			if(checklength($new_pwd,6,20)){
				$error = true;
				$sysmsg[] = __('password_max_min');
			}elseif($new_pwd != $cfm_pwd){
				$error = true;
				$sysmsg[] = __('confirm_password_invalid');
			}else{
				$md5_pwd = md5($new_pwd);
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					uc_user_edit($pd_uid, $pd_username, $pd_username, $new_pwd, $pd_email);
				}else{
					$ucresult = uc_user_edit($pd_username, $old_pwd, $new_pwd);
					if($ucresult < 0) {
						$error = true;
						$sysmsg[] = 'UC:'.__('invalid_password');
					}
				}
			}
			if(!$error){
				$sql = "update {$tpf}users set password='$md5_pwd' where userid='$pd_uid'";
				$db->query_unbuffered($sql);
				pd_setcookie('phpdisk_info','');
				$sysmsg[] = __('password_modify_success');
				redirect(urr("account","action=login"),$sysmsg,2000,'top');
			}else{
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}

		}else{
			require_once template_echo('profile',$user_tpl_dir);
		}

		break;

	case 'payment':
		if(!display_plugin('payment','open_payment_plugin',$settings['open_payment'],0)){
			exit('ERROR: payment '.__('plugin_not_install'));
		}
		if($task){
			$money = trim(gpc('money','P',0));
			$auto_convert = (int)gpc('auto_convert','P',0);

			if(!$money){
				$error = false;
				$sysmsg[] = __('money_invalid');
			}
			$money = $money ? $money : 1;
		}
		if($task == 'alipay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				require_once PD_PLUGINS_DIR."payment/alipay/alipay_config.php";
				require_once PD_PLUGINS_DIR."payment/alipay/class/alipay_service.php";

				$out_trade_no = date('YmdHis');

				$parameter = array(
				"service"			=> "create_direct_pay_by_user",	//接口名称，不需要修改
				"payment_type"		=> "1",               			//交易类型，不需要修改

				//获取配置文件(alipay_config.php)中的值
				"partner"			=> $partner,
				"seller_email"		=> $seller_email,
				"return_url"		=> $return_url,
				"notify_url"		=> $notify_url,
				"_input_charset"	=> $_input_charset,
				"show_url"			=> $show_url,

				//从订单数据中动态获取到的必填参数
				"out_trade_no"		=> $out_trade_no,
				"subject" => $settings['site_title'].' '.__('ali_subject_pay'),
				"body" => __('ali_body_pay').' '.$money.' RMB',
				"total_fee"			=> $money,

				//扩展功能参数——网银提前
				"paymethod"			=> 'directPay',
				"defaultbank"		=> $defaultbank,

				//扩展功能参数——防钓鱼
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,

				//扩展功能参数——自定义参数
				"buyer_email"		=> $buyer_email,
				"extra_common_param"=> $extra_common_param,

				//扩展功能参数——分润
				"royalty_type"		=> $royalty_type,
				"royalty_parameters"=> $royalty_parameters
				);
				//
				$num = @$db->result_first("select count(*) from {$tpf}orders where order_number='$out_trade_no' and pay_method='$task' and userid='$pd_uid'");
				if(!$num){
					$ins = array(
					'pay_method' => $task,
					'userid' => $pd_uid,
					'order_number' => $out_trade_no,
					'total_fee' => $money,
					'pay_status' => 'pendding',
					'in_time' => $timestamp,
					'ip' => $onlineip,
					);
					$db->query_unbuffered("insert into {$tpf}orders set ".$db->sql_array($ins).";");
				}

				$alipay = new alipay_service($parameter,$key,$sign_type);
				$sHtmlText = $alipay->build_form();
				echo $sHtmlText;

			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='tenpay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){

				include_once PD_PLUGINS_DIR."payment/tenpay/PayRequestHandler.class.php";

				$bargainor_id = $settings['ten_mch'];
				$key = $settings['ten_key'];
				$return_url = $settings['phpdisk_url']."payment.php?action=tenpay&auto_convert=".$auto_convert;
				$strDate = date("Ymd");
				$strTime = date("His");
				$randNum = rand(1000, 9999);
				$strReq = $strTime . $randNum;
				$sp_billno = $strReq;
				$transaction_id = $bargainor_id . $strDate . $strReq;
				$total_fee = $money*100;
				$desc = __('ali_body_pay').'&nbsp;'.$money.'&nbsp;RMB';

				$num = @$db->result_first("select count(*) from {$tpf}orders where order_number='$transaction_id' and pay_method='$task' and userid='$pd_uid'");
				if(!$num){
					$ins = array(
					'pay_method' => $task,
					'userid' => $pd_uid,
					'order_number' => $transaction_id,
					'total_fee' => $money,
					'pay_status' => 'pendding',
					'in_time' => $timestamp,
					'ip' => $onlineip,
					);
					$db->query("insert into {$tpf}orders set ".$db->sql_array($ins).";");
				}
				$reqHandler = new PayRequestHandler();
				$reqHandler->init();
				$reqHandler->setKey($key);

				$reqHandler->setParameter("bargainor_id", $bargainor_id);
				$reqHandler->setParameter("sp_billno", $sp_billno);
				$reqHandler->setParameter("transaction_id", $transaction_id);
				$reqHandler->setParameter("total_fee", $total_fee);
				$reqHandler->setParameter("return_url", $return_url);
				$reqHandler->setParameter("desc", iconv('utf-8','gbk',$desc));

				$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
				$reqUrl = $reqHandler->getRequestURL();
				header("Location: $reqUrl");
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='chinabank'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				$go_url = "plugins/payment/chinabank/Send.php?v_amount=$money&auto_convert=".$auto_convert;
				echo "<script>window.location =\"$go_url\";</script>";
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='yeepay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				$go_url = "plugins/payment/yeepay/req.php?p3_Amt=$money&auto_convert=".$auto_convert;
				echo "<script>window.location =\"$go_url\";</script>";
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$auto_convert = 1;
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;

	case 'history':
		$perpage = 50;
		$sql_do = "{$tpf}orders where userid='$pd_uid'";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;
		function pay_history(){
			global $db,$tpf,$sql_do,$start_num,$perpage;
			$q = $db->query("select * from {$sql_do} order by order_id desc limit $start_num,$perpage");
			$logs = array();
			while($rs = $db->fetch_array($q)){
				$rs['total_fee'] = $rs['total_fee'] ? '￥'.$rs['total_fee'] : ' ';
				$rs['pay_status'] = get_pay_status($rs['pay_status']);
				$rs['in_time'] = custom_time("Y-m-d H:i:s",$rs['in_time']);
				$logs[] = $rs;
			}
			$db->free($q);
			unset($rs);
			return $logs;
		}
		$logs = pay_history();
		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=$item&action=$action"));

		require_once template_echo('profile',$user_tpl_dir);
		break;

	case 'exchange':

		if(file_exists(PD_PLUGINS_DIR."api/creditsettings.php")){
			include_once PD_PLUGINS_DIR."api/creditsettings.php";
		}

		$credit = $db->result_first("select credit from {$tpf}users where userid='$pd_uid' limit 1");

		if($task =='exchange2wealth'){
			form_auth(gpc('formhash','P',''),formhash());

			$towealth = (int)gpc('towealth','P',0);

			if($towealth <= 0) {
				$error = true;
				$sysmsg[] = __('credit_amount_error');
			}
			if($wealth-$towealth < 0) {
				$error = true;
				$sysmsg[] = __('credit_amount_too_big');
			}
			if(!$error){
				$tocredit = $towealth * $settings['credit_convert'];
				$db->query_unbuffered("update {$tpf}users set credit=credit+$tocredit,wealth=wealth-$towealth where userid='$pd_uid' limit 1");

				$sysmsg[] = __('wealth_exchange_success');
				redirect(urr("mydisk","item=profile&menu=$menu&action=exchange"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='exchange2uc'){
			form_auth(gpc('formhash','P',''),formhash());

			$netamount = $tocredits = 0;
			$tocredits = trim(gpc('tocredits','P',0));
			$password = trim(gpc('password','P',''));
			$amount = (int)gpc('amount','P',0);

			if((strpos($tocredits,'|') !==false) && !$_CACHE['creditsettings'][$tocredits]['ratio']) {
				$error = true;
				$sysmsg[] = __('credit_uc_error');
			}
			if($password){
				$total = $db->result_first("select count(*) from {$tpf}users where userid='$pd_uid' and password='".md5($password)."'");
				if(!$total){
					$error = true;
					$sysmsg[] = __('password_error');
				}
			}else{
				$error = true;
				$sysmsg[] = __('password_not_null');
			}

			if($amount <= 0) {
				$error = true;
				$sysmsg[] = __('credit_amount_error');
			}
			if($credit-$amount < 0) {
				$error = true;
				$sysmsg[] = __('credit_amount_too_big');
			}
			if(!$error){
				$netamount = floor($amount * 1/$_CACHE['creditsettings'][$tocredits]['ratio']);
				list($toappid, $tocredits) = explode('|', $tocredits);
				$ucresult = uc_credit_exchange_request($pd_uid, $_CACHE['creditsettings'][$tocredits]['creditsrc'], $tocredits, $toappid, $netamount);
				if(!$ucresult) {
					$error = true;
					$sysmsg[] = __('credit_uc_exchange_error');
				}
			}
			if(!$error){
				if($ucresult){
					$db->query_unbuffered("UPDATE {$tpf}users SET credit=credit-$amount WHERE userid='$pd_uid'");
				}
				$sysmsg[] = __('credit_exchange_success');
				redirect(urr("mydisk","item=profile&menu=$menu&action=exchange"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			if(display_plugin('api','open_uc_plugin',(!$settings['connect_uc'] || !$settings['uc_credit_exchange']),0)){
				$uc_msg = __('cannot_use_uc_credit_exchange');
			}
			if(!$settings['credit_open'] || !$settings['open_credit_convert']){
				$common_msg = __('cannot_use_common_credit_exchange');
			}
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;

	default:
		$group_set = $group_settings[$pd_gid];
		$group_set['max_flow_down'] = $group_set['max_flow_down'] ? $group_set['max_flow_down'] : __('no_limit');
		$group_set['max_flow_view'] = $group_set['max_flow_view'] ? $group_set['max_flow_view'] : __('no_limit');
		$group_set['max_folders'] = $group_set['max_folders'] ? $group_set['max_folders']: __('no_limit');
		$group_set['max_files'] = $group_set['max_files'] ? $group_set['max_files'] : __('no_limit');

		$upload_max = get_byte_value(ini_get('upload_max_filesize'));
		$post_max = get_byte_value(ini_get('post_max_size'));
		$settings_max = $settings['max_file_size'] ? get_byte_value($settings['max_file_size']) : 0;
		$max_php_file_size = min($upload_max, $post_max);
		$max_file_size_byte = ($settings_max && $settings_max <= $max_php_file_size) ? $settings_max : $max_php_file_size;

		if($group_set['max_filesize']){
			$group_set_max_file_size = get_byte_value($group_set['max_filesize']);
			$max_file_size_byte = ($group_set_max_file_size >=$max_file_size_byte) ? $max_file_size_byte : $group_set_max_file_size;
		}
		$group_set['max_filesize'] = get_size($max_file_size_byte,'B',0);

		$rs = $db->fetch_one_array("select user_file_types,user_store_space from {$tpf}users where userid='$pd_uid' limit 1");
		if($rs['user_file_types']){
			$group_set['user_file_types'] = $rs['user_file_types'];
		}else{
			$group_set['user_file_types'] = $group_set['group_file_types'] ? $group_set['group_file_types'] : __('no_limit');

		}
		if($rs['user_store_space']){
			$group_set['max_storage'] = $rs['user_store_space'];
		}else{
			$group_set['max_storage'] = $group_set['max_storage'] ? $group_set['max_storage'] : __('no_limit');
		}
		unset($rs);
		$rs = $db->fetch_one_array("select user_store_space from {$tpf}users where userid='$pd_uid'");
		if($rs['user_store_space'] ==0){
			$max_storage = $group_settings[$pd_gid]['max_storage']==0 ? __('no_limit') : $group_settings[$pd_gid]['max_storage'];
		}else{
			$max_storage = $rs['user_store_space'];
		}
		unset($rs);

		$stats['total_folders'] = (int)@$db->result_first("select count(*) from {$tpf}folders where userid='$pd_uid'");

		$stats['total_share_folders'] = @$db->result_first("select count(*) from {$tpf}folders where userid='$pd_uid' and in_share=1");

		$stats['total_files'] = (int)@$db->result_first("select count(*) from {$tpf}files where userid='$pd_uid'");

		$stats['file_size_total'] = get_size(@$db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid'"));

		$disk_fill = $max_storage ? @round($rs['file_size_total']/get_byte_value($max_storage),1)*120 : 0;
		$disk_percent = $max_storage ? @round($rs['file_size_total']/get_byte_value($max_storage),3)*100 : 0;

		$rs = $db->fetch_one_array("select reg_time,reg_ip,email,last_login_time,last_login_ip from {$tpf}users where userid='$pd_uid'");
		if($rs){
			$stats['reg_time'] = date("Y-m-d H:i:s",$rs['reg_time']);
			$stats['last_login_time'] = date("Y-m-d H:i:s",$rs['last_login_time']);
			$stats['reg_ip'] = $rs['reg_ip'];
			$stats['last_login_ip'] = $rs['last_login_ip'];
			$stats['email'] = $rs['email'];
		}
		unset($rs);

		require_once template_echo('profile',$user_tpl_dir);

}

?>