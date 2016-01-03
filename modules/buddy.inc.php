<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: buddy.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'mybuddy':
	case 'whobuddy':
	case 'invite_success':
		if($action=='mybuddy'){
		$buddy_title = __('buddy_title_mybuddy');
		}elseif($action=='whobuddy'){
		$buddy_title = __('buddy_title_whobuddy');
		}elseif($action=='invite_success'){
		$buddy_title = __('buddy_title_invite_success');
		}

		if($task =='addbuddy'){
			form_auth(gpc('formhash','P',''),formhash());

			$buddy_name = trim(gpc('buddy_name','P',''));
			$go_back = true;

			if($buddy_name){
				$rs = $db->fetch_one_array("select userid from {$tpf}users where username='$buddy_name'");
				if($rs['userid']){
					$rs2 = $db->fetch_one_array("select count(*) as total from {$tpf}buddys where touserid='{$rs['userid']}' and userid='$pd_uid'");
					if($rs['userid'] == $pd_uid){
						$sysmsg[] = __('cannot_add_self');
					}elseif($rs2['total']){
						$sysmsg[] = __('already_buddy');
					}else{
						$ins = array(
						'userid' => $pd_uid,
						'touserid' => $rs['userid'],
						'in_time' => $timestamp,
						);
						$db->query("insert into {$tpf}buddys set ".$db->sql_array($ins).";");
						$sysmsg[] = __('addbuddy_success');
						$go_back = false;
					}
				}else{
					$sysmsg[] = __('username_not_found');
				}
				if($go_back){
					redirect('back',$sysmsg);
				}else{
					redirect(urr("mydisk","item=buddy&menu=profile&action=mybuddy"),$sysmsg);
				}
			}
		}else{
			$perpage = 20;
			if($action =='mybuddy'){
				$sql_do = " {$tpf}buddys b, {$tpf}users u where b.userid='$pd_uid' and b.touserid=u.userid";
			}elseif($action =='invite_success'){
				$sql_do = " {$tpf}invitelog b, {$tpf}users u where b.userid='$pd_uid' and b.touserid=u.userid";
			}else{
				$sql_do = " {$tpf}buddys b, {$tpf}users u where b.touserid='$pd_uid' and b.userid=u.userid";
			}
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;
			function buddy_list(){
				global $db,$tpf,$sql_do,$start_num,$perpage;
				$q = $db->query("select b.*,u.username from {$sql_do} order by bdid desc limit $start_num,$perpage");
				$buddys_arr = array();
				while($rs = $db->fetch_array($q)){
					$rs['userid'] = ($action =='mybuddy') ? $rs['touserid'] : $rs['userid'];
					$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
					$rs['a_sendmsg'] = urr("mydisk","item=message&menu=profile&action=sendmsg&username=".rawurlencode($rs['username']));
					$rs['a_delbuddy'] = urr("mydisk","item=buddy&menu=profile&action=delbuddy&userid={$rs['touserid']}");
					$rs['a_addbuddy'] = urr("mydisk","item=buddy&menu=profile&action=s_addbuddy&userid={$rs['userid']}");
					$rs['in_time'] = $rs['in_time'] ? date("Y-m-d H:i",$rs['in_time']) : '--';
					$buddys_arr[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $buddys_arr;
			}
			$buddys_arr = buddy_list();
			
			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=buddy&menu=profile&action=$action"));

			require_once template_echo('buddy',$user_tpl_dir);
		}
		break;

	case 'search':
		$buddy_title = __('buddy_search');

		$scope = trim(gpc('scope','G',''));
		$word = trim(gpc('word','G',''));
		$word = str_replace('　',' ',replace_inject_str($word));
		$perpage = 20;

		if($scope =='my'){
			$sql_do = " {$tpf}buddys b, {$tpf}users u where b.userid='$pd_uid' and b.touserid=u.userid and u.username like '%{$word}%'";
		}elseif($scope =='added'){
			$sql_do = " {$tpf}buddys b, {$tpf}users u where b.touserid='$pd_uid' and b.userid=u.userid and u.username like '%{$word}%'";
		}elseif($scope =='all'){
			$sql_do = " {$tpf}users u where u.username like '%{$word}%'";
		}
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;
		function search_buddy($scope){
			global $db,$tpf,$sql_do,$start_num,$perpage;
			if($scope =='all'){
				$q = $db->query("select * from {$sql_do} order by userid desc limit $start_num,$perpage");
			}else{
				$q = $db->query("select b.*,u.username from {$sql_do} order by bdid desc limit $start_num,$perpage");
			}
			$buddys_arr = array();
			while($rs = $db->fetch_array($q)){
				$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
				$rs['a_addbuddy'] = urr("mydisk","item=buddy&menu=profile&action=s_addbuddy&userid={$rs['userid']}");
				$rs['in_time'] = $rs['in_time'] ? custom_time("Y-m-d H:i",$rs['in_time']) : '--';
				$buddys_arr[] = $rs;
			}
			$db->free($q);
			unset($rs);
			return $buddys_arr;
		}
		$buddys_arr = search_buddy($scope);
		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=buddy&menu=profile&action=search&scope=$scope&word=".rawurlencode($word).""));

		require_once template_echo('buddy',$user_tpl_dir);

		break;

	case 'delbuddy':
		$userid = (int)gpc('userid','GP',0);
		if($task =='delbuddy'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$db->query_unbuffered("delete from {$tpf}buddys where touserid='$userid' and userid='$pd_uid'");

			tb_redirect($ref,__('delbuddy_success'));
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}users where userid='$userid'");
			if($rs){
				$buddy_name = $rs['username'];
			}
			unset($rs);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('buddy',$user_tpl_dir);
		}
		break;

	case 's_addbuddy':
		$userid = (int)gpc('userid','GP',0);
		if($task =='s_addbuddy'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			if($userid){
				$rs = $db->fetch_one_array("select userid from {$tpf}users where userid='$userid'");
				if($rs['userid']){
					$rs2 = $db->fetch_one_array("select count(*) as total from {$tpf}buddys where touserid='{$rs['userid']}' and userid='$pd_uid'");
					if($rs['userid'] == $pd_uid){
						$sysmsg = __('cannot_add_self');
					}elseif($rs2['total']){
						$sysmsg = __('already_buddy');
					}else{
						$ins = array(
						'userid' => $pd_uid,
						'touserid' => $rs['userid'],
						'in_time' => $timestamp,
						);
						$db->query("insert into {$tpf}buddys set ".$db->sql_array($ins).";");

						$sysmsg = __('addbuddy_success');
					}
				}else{
					$sysmsg = __('username_not_found');
				}
			}
			tb_redirect($ref,$sysmsg);
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}users where userid='$userid'");
			if($rs){
				$buddy_name = $rs['username'];
			}
			unset($rs);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('buddy',$user_tpl_dir);
		}
		break;
	case 'invite':
		$invite_url = $settings['invite_register_encode'] ? $settings['phpdisk_url'].urr("account","action=register&".pd_encode('uid='.$pd_uid)) : $settings['phpdisk_url'].urr("account",'action=register&uid='.$pd_uid);
		require_once template_echo('buddy',$user_tpl_dir);

		break;
}
?>