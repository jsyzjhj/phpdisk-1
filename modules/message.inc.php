<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: message.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'inbox':
		$msg_title = __('msg_inbox');
		if($task =='delete'){
			$msgid = (int)gpc('msgid','G',0);
			$rs = $db->fetch_one_array("select * from {$tpf}messages where msgid='$msgid' and touserid='$pd_uid'");
			if($rs['in_sendbox']){
				$db->query_unbuffered("update {$tpf}messages set is_del=1 where msgid='$msgid' and touserid='$pd_uid'");
			}else{
				$db->query_unbuffered("delete from {$tpf}messages where msgid='$msgid' and touserid='$pd_uid'");
			}
			redirect(urr("mydisk","item=message&action={$action}"),'',0);
		}else{
			$perpage = 20;
			$sql_do = " {$tpf}messages m, {$tpf}users u where m.touserid='$pd_uid' and m.userid=u.userid and m.is_del=0";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;
			function msg_list(){
				global $db,$tpf,$sql_do,$start_num,$perpage;
				$q = $db->query("select m.*,u.username from {$sql_do} order by msgid desc limit $start_num,$perpage");
				$msg_array = array();
				while($rs = $db->fetch_array($q)){
					$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
					$rs['a_view_content'] = urr("mydisk","item=message&action=view&msgid={$rs['msgid']}");
					$rs['a_delete'] = urr("mydisk","item=message&action=inbox&task=delete&msgid={$rs['msgid']}");
					$rs['content'] = preg_replace("/<.+?>/i","",str_replace('<br>',LF,$rs['content']));
					$rs['ctn_total'] = strlen($rs['content']);
					$rs['short_content'] = $rs['is_new'] ? '<b>'.cutstr($rs['content'],50).'</b>' : cutstr($rs['content'],50);
					$rs['short_content'] = $rs['is_reply'] ? "<img src=\"images/icon_reply.gif\" align=\"absmiddle\" border=\"0\">&nbsp;".$rs['short_content'] : $rs['short_content'];
					$rs['in_time'] = custom_time("Y-m-d H:i",$rs['in_time']);
					$msg_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $msg_array;
			}
			$msg_array = msg_list();
			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=message&action=$action"));

			$a_sendmsg = urr("mydisk","item=message&action=sendmsg");
			require_once template_echo('message',$user_tpl_dir);
		}

		break;

	case 'sendbox':
		$msg_title = __('msg_sendbox');
		if($task =='delete'){
			$msgid = (int)gpc('msgid','G',0);

			$rs = $db->fetch_one_array("select * from {$tpf}messages where msgid='$msgid' and userid='$pd_uid'");
			if($rs['is_del']){
				$db->query_unbuffered("delete from {$tpf}messages where msgid='$msgid' and userid='$pd_uid'");
			}else{
				$db->query_unbuffered("update {$tpf}messages set in_sendbox=0 where msgid='$msgid' and userid='$pd_uid'");
			}
			redirect(urr("mydisk","item=message&action={$action}"),'',0);
		}else{

			$perpage = 20;
			$sql_do = " {$tpf}messages m,{$tpf}users u where m.touserid=u.userid and m.userid='$pd_uid' and m.in_sendbox=1";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;
			function msg_sendbox(){
				global $db,$tpf,$sql_do,$start_num,$perpage;
				$q = $db->query("select * from {$sql_do} order by m.msgid desc limit $start_num,$perpage");
				$msg_array = array();
				while($rs = $db->fetch_array($q)){
					$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
					$rs['a_view_content'] = urr("mydisk","item=message&action=view&msgid={$rs['msgid']}");
					$rs['a_delete'] = urr("mydisk","item=message&action=sendbox&task=delete&msgid={$rs['msgid']}");
					$rs['content'] = preg_replace("/<.+?>/i","",str_replace('<br>',LF,$rs['content']));
					$rs['ctn_total'] = strlen($rs['content']);
					$rs['short_content'] = cutstr($rs['content'],50);
					$rs['in_time'] = custom_time("Y-m-d H:i",$rs['in_time']);
					$msg_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
			}
			$msg_array = msg_sendbox();
			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=message&action=$action"));
			$a_sendmsg = urr("mydisk","item=message&action=sendmsg");
			require_once template_echo('message',$user_tpl_dir);
		}
		break;

	case 'view':
		$msgid = (int)gpc('msgid','G',0);
		$ref = $_SERVER['HTTP_REFERER'];
		$db->query_unbuffered("update {$tpf}messages set is_new=0 where msgid='$msgid' and touserid='$pd_uid'");
		$rs = $db->fetch_one_array("select m.*,u.username from {$tpf}messages m,{$tpf}users u where u.userid=m.touserid and msgid='$msgid' limit 1");
		if($rs['userid'] == $pd_uid){
			$can_reply = 0;
			$sql_do = "{$tpf}messages m,{$tpf}users u where u.userid=m.touserid and msgid='$msgid' limit 1";
		}else{
			$can_reply = 1;
			$sql_do = "{$tpf}messages m,{$tpf}users u where u.userid=m.userid and msgid='$msgid' limit 1";
		}
		$msg_array = $db->fetch_one_array("select m.*,u.username from {$sql_do}");
		$msg_array['content'] = html_entity_decode($msg_array['content']);
		require_once template_echo('message',$user_tpl_dir);
		break;

	case 'reply':
		if($task =='reply'){
			form_auth(gpc('formhash','P',''),formhash());

			$msgid = (int)gpc('msgid','P',0);
			$username = trim(gpc('username','P',''));
			$msg_content = trim(gpc('msg_content','P',''));
			$save_box = (int)gpc('save_box','P',0);
			$ref = trim(gpc('ref','P',''));

			$rs = $db->fetch_one_array("select userid from {$tpf}users where username='$username'");
			if(!$rs['userid']){
				$error = true;
				$sysmsg[] = __('send_user_not_found');
			}else{
				$touserid = $rs['userid'];
			}
			if(checklength($msg_content,2,1000)){
				$error = true;
				$sysmsg[] = __('msg_min_max');
			}
			if($settings['credit_open']){
				$credit = $settings['credit_open'] ? (int)$settings['credit_msg'] : 0;
				$rs = $db->fetch_one_array("select credit from {$tpf}users where userid='$pd_uid'");
				if($rs['credit']>=$credit){
					$credit_ok = true;
				}else{
					$error = true;
					$sysmsg[] = __('not_enough_credit_for_send_msg');
				}
				unset($rs);
			}
			if(!$error){
				$ins = array(
				'reply_id' => $msgid,
				'userid' => $pd_uid,
				'touserid' => $touserid,
				'content' => htmlspecialchars($msg_content),
				'is_new' => 1,
				'in_sendbox' => $save_box,
				'in_time' => $timestamp,
				);
				$db->query("insert into {$tpf}messages set ".$db->sql_array($ins).";");
				$db->query_unbuffered("update {$tpf}messages set is_reply=1 where msgid='$msgid' and touserid='$pd_uid'");
				if($credit_ok){
					$credit = $settings['credit_open'] ? (int)$settings['credit_msg'] : 0;
					$db->query_unbuffered("update {$tpf}users set credit=credit-{$credit} where userid='$pd_uid'");
				}
				$exp_msg = (int)$settings['exp_msg'];
				$db->query_unbuffered("update {$tpf}users set exp=exp+$exp_msg where userid='$pd_uid'");
				tb_redirect($ref,__('send_msg_success'));
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$username = trim(gpc('username','P',''));
			$ref = trim(gpc('ref','P',''));
			$msgid = (int)gpc('msgid','P',0);
			require_once template_echo('message',$user_tpl_dir);
		}
		break;

	case 'sendmsg':
		if($task =='sendmsg'){
			form_auth(gpc('formhash','P',''),formhash());

			$username = trim(gpc('username','P',0));
			$msg_content = trim(gpc('msg_content','P',''));
			$save_box = (int)gpc('save_box','P',0);
			$ref = trim(gpc('ref','P',''));

			$rs = $db->fetch_one_array("select userid from {$tpf}users where username='$username'");
			if(!$rs['userid']){
				$error = true;
				$sysmsg[] = __('send_user_not_found');
			}else{
				$touserid = $rs['userid'];
			}
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}buddys where userid='$pd_uid' and touserid='$touserid'");
			if(!$rs['total']){
				$error = true;
				$sysmsg[] = __('not_your_buddy');
			}
			unset($rs);
			if(checklength($msg_content,2,1000)){
				$error = true;
				$sysmsg[] = __('msg_min_max');
			}
			if($settings['credit_open']){
				$credit = $settings['credit_open'] ? (int)$settings['credit_msg'] : 0;
				$rs = $db->fetch_one_array("select credit from {$tpf}users where userid='$pd_uid'");
				if($rs['credit']>=$credit){
					$credit_ok = true;
				}else{
					$error = true;
					$sysmsg[] = __('not_enough_credit_for_send_msg');
				}
				unset($rs);
			}
			if(!$error){
				$ins = array(
				'userid' => $pd_uid,
				'touserid' => $touserid,
				'content' => htmlspecialchars($msg_content),
				'is_new' => 1,
				'in_sendbox' => $save_box,
				'in_time' => $timestamp,
				);
				$db->query("insert into {$tpf}messages set ".$db->sql_array($ins).";");

				if($credit_ok){
					$credit = $settings['credit_open'] ? (int)$settings['credit_msg'] : 0;
					$db->query_unbuffered("update {$tpf}users set credit=credit-{$credit} where userid='$pd_uid'");
				}
				$exp_msg = (int)$settings['exp_msg'];
				$db->query_unbuffered("update {$tpf}users set exp=exp+$exp_msg where userid='$pd_uid'");
				tb_redirect($ref,__('send_msg_success'));
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$username = trim(gpc('username','G',''));
			$ref = $_SERVER['HTTP_REFERER'];
			function sel_users(){
				global $db,$tpf,$pd_uid;
				$q = $db->query("select b.*,u.username from {$tpf}users u,{$tpf}buddys b where u.userid=b.touserid and b.userid='$pd_uid'");
				$sel_users = array();
				while($rs = $db->fetch_array($q)){
					$sel_users[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $sel_users;
			}
			$sel_users = sel_users();
			require_once template_echo('message',$user_tpl_dir);
		}
		break;
}
?>