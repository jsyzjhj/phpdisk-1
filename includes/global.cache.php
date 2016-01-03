<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: global.cache.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

function get_curr_tpl($tpl_type){
	global $db,$tpf;
	$tpl_name = @$db->result_first("select tpl_name from {$tpf}templates where tpl_type='$tpl_type' and actived=1");
	return array($tpl_name);
}
function get_lang_name(){
	global $db,$tpf;
	$lang_name = @$db->result_first("select lang_name from {$tpf}langs where actived=1");
	return array($lang_name);
}
function get_navigation_link($pos){
	global $db,$tpf;
	$pos = in_array($pos,array('top','bottom')) ? $pos : 'top';
	$q = $db->query("select * from {$tpf}navigations where position='$pos' order by show_order asc, navid desc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function get_ads($adv_position){
	global $tpf,$db;
	$scope = substr(substr(strrchr($_SERVER['PHP_SELF'],'/'),1),0,-4);
	$echo_data = false;
	$q = $db->query("select * from {$tpf}advertisements where adv_position='$adv_position' and is_hidden=0 order by show_order asc,advid desc");
	$adv_arr = array();
	while($rs = $db->fetch_array($q)){
		$adv_type = $rs['adv_type'];
		$param = unserialize($rs['params']);
		$code = $rs['code'];
		$starttime = $rs['starttime'];
		$endtime = $rs['endtime'];

		if(strpos($param['adv_scope'],',')){
			$a2 = explode(',',$param['adv_scope']);
			if(in_array('all',$a2)){
				$echo_data = true;
			}elseif(in_array($scope,$a2)){
				$echo_data = true;
			}
		}else{
			if(!$param['adv_scope'] || $param['adv_scope'] =='all'){
				$echo_data = true;
			}elseif($param['adv_scope'] ==$scope){
				$echo_data = true;
			}
		}
		if($echo_data){
			if($starttime && TS<$starttime){
				$rs['adv_str'] = '';
			}elseif($endtime && TS>$endtime){
				$rs['adv_str'] = '';
			}else{
				switch($adv_type){
					case 'adv_text':
						$size = $param['adv_txt_size'] ? 'font-size:'.$param['adv_txt_size'].';' : 'font-size:12px;';
						$color = $param['adv_txt_color'] ? 'color:'.$param['adv_txt_color'].';' : '';

						$rs['adv_str'] = '<div style="padding:8px 0;"><a href="'.$param['adv_txt_url'].'" target="_blank" style="'.$size.$color.'">'.$param['adv_txt_title'].'</a></div>';
						break;
					case 'adv_code':
						$rs['adv_str'] = $code;
						break;
					case 'adv_flash':
						$rs['adv_str'] = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'.$param['adv_flash_width'].'" height="'.$param['adv_flash_height'].'">
						  <param name="movie" value="'.$param['adv_flash_src'].'" />
						  <param name="quality" value="high" />
						  <param name="allowScriptAccess" value="always" />
						  <param name="wmode" value="transparent">
							 <embed src="'.$param['adv_flash_src'].'"
							  quality="high"
							  type="application/x-shockwave-flash"
							  WMODE="transparent"
							  width="'.$param['adv_flash_width'].'"
							  height="'.$param['adv_flash_height'].'"
							  pluginspage="http://www.macromedia.com/go/getflashplayer"
							  allowScriptAccess="always" />
						</object>';
						break;
					default:
						$rs['adv_str'] = '<a href="'.$param['adv_img_url'].'" target="_blank">';
						$rs['adv_str'] .= '<img src="'.$param['adv_img_src'].'" ';
						$rs['adv_str'] .= $param['adv_img_width'] ? ' width="'.$param['adv_img_width'].'" ' : '';
						$rs['adv_str'] .= $param['adv_img_height'] ? ' height="'.$param['adv_img_height'].'" ' : '';
						$rs['adv_str'] .= ' align="absmiddle" border="0" alt="'.$param['adv_img_alt'].'" />';
						$rs['adv_str'] .= '</a>';
				}
			}
		}
		$adv_arr[] = $rs;
	}
	$db->free($q);
	unset($rs);

	return $adv_arr;
}
// direct show in tpl
function show_adv_data($pos){
	$adv_content = get_ads($pos);

	$rtn = '';
	switch($pos){
		case 'adv_bottom':
			if(count($adv_content)){
				foreach($adv_content as $v){
					$rtn .= '<div align="center">'.$v['adv_str'].'</div>';
				}
				unset($adv_content);
			}
			break;

		default:
			if(count($adv_content)){
				foreach($adv_content as $v){
					$rtn .= $v['adv_str'];
				}
				unset($adv_content);
			}
	}
	echo $rtn;
}
function public_menu_list(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}categories where is_hidden=0 order by show_order asc,cate_id asc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$rs[num] = @$db->result_first("select count(*) from {$tpf}files where cate_id='{$rs['cate_id']}' or subcate_id='{$rs['cate_id']}' and in_recycle=0 and is_public=1 and cate_id>0 and userid>0 ");
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}

function my_folder_root(){
	global $db,$tpf;
	$file_count = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id=0 and in_recycle=0 and userid='$pd_uid'");
	$folder_size = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id=0 and in_recycle=0 and userid='$pd_uid'");
	return array('file_count'=>$file_count,'folder_size'=>$folder_size);
}
function my_folder_menu(){
	global $db,$tpf,$pd_uid;

	$q = $db->query("select folder_id,parent_id,folder_name,folder_node from {$tpf}folders where userid='$pd_uid' and in_recycle=0 order by folder_order asc,in_time asc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		//$num = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id='{$rs['folder_id']}' and userid='$pd_uid'");
		//$rs[folder_size] = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id='{$rs[folder_id]}' and userid='$pd_uid'");
		//$rs[count] = $num ? __('all_file')."$num , ".__('folder_size').get_size($rs['folder_size']) : '';
		$rs['parent_id'] = $rs['parent_id']==-1 ? 0 : (int)$rs['parent_id'];

		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function get_option_folders($deep=4){
	global $db,$tpf,$pd_uid;
	
	$q = $db->query("select folder_node,folder_id,folder_name,folder_description,parent_id from {$tpf}folders where userid='$pd_uid' and in_recycle=0 order by folder_order asc,in_time asc");
	$folders = array();
	while($rs = $db->fetch_array($q)){
		$folders[] = $rs;
	}
	$db->free($q);
	unset($rs);
	
	$str_c = '<option value=\'0\' style=\'color:#0000FF\' id=\'fd_0\'>'.__('root_folder').'</option>'.LF;
	for($i = 0; $i < count($folders); $i++) {
		if($folders[$i]['folder_node'] == 1) {
			$str_c .= '<option value=\''.$folders[$i]['folder_id'].'\' id=\'fd_'.$folders[$i]['folder_id'].'\'>'.$folders[$i]['folder_name'].'</option>'.LF;
			for($j = 0; $j < count($folders); $j++) {
				if($folders[$j]['parent_id'] == $folders[$i]['folder_id'] && $folders[$j]['folder_node'] == 2) {
					$str_c .= '<option value=\''.$folders[$j]['folder_id'].'\' id=\'fd_'.$folders[$j]['folder_id'].'\'>'.str_repeat('&nbsp;',4).$folders[$j]['folder_name'].'</option>'.LF;
					for($k = 0; $k < count($folders); $k++) {
						if($folders[$k]['parent_id'] == $folders[$j]['folder_id'] && $folders[$k]['folder_node'] == 3) {
							$str_c .= '<option value=\''.$folders[$k]['folder_id'].'\' id=\'fd_'.$folders[$k]['folder_id'].'\'>'.str_repeat('&nbsp;',8).$folders[$k]['folder_name'].'</option>'.LF;
							if($deep ==4){
								for($l=0;$l<count($folders);$l++){
									if($folders[$l]['parent_id'] == $folders[$k]['folder_id'] && $folders[$l]['folder_node'] == 4) {
										$str_c .= '<option value=\''.$folders[$l]['folder_id'].'\' id=\'fd_'.$folders[$l]['folder_id'].'\'>'.str_repeat('&nbsp;',12).$folders[$l]['folder_name'].'</option>'.LF;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return $str_c;
}
function get_mydisk_info($pd_uid){
	global $db,$tpf,$settings;
	$rs = $db->fetch_one_array("select wealth,credit,rank,exp from {$tpf}users where userid='$pd_uid' limit 1");
	if($rs){
		$myinfo['credit'] = (int)$rs['credit'];
		$myinfo['wealth'] = (int)$rs['wealth'];
		$myinfo['rank'] = (int)$rs['rank'];
		$myinfo['exp'] = (int)$rs['exp'];
		$myinfo['this_exp'] = ($myinfo['rank']+1)*$settings['exp_const'];
		$myinfo['lv_tips'] = ($myinfo['rank']+1)*$settings['exp_const']-$myinfo['exp'];
		$myinfo['exp_fill'] = @round(100*($myinfo['exp']/(($myinfo['rank']+1)*$settings['exp_const'])));
		$myinfo['exp_fill'] = $myinfo['exp_fill']>100 ? 100 : $myinfo['exp_fill'];
	}
	unset($rs);
	return $myinfo;
}

function get_option_public_folder(){
	global $db,$tpf;
	$q = $db->query("select cate_id,cate_name,pid from {$tpf}categories where is_hidden=0 order by show_order asc,cate_id asc");
	$folders = array();
	while($rs = $db->fetch_array($q)){
		$folders[] = $rs;
	}
	$db->free($q);
	unset($rs);
		
	for($i = 0; $i < count($folders); $i++) {
		if($folders[$i]['pid'] == 0) {
			$str_c .= '<option value=\''.$folders[$i]['cate_id'].'\'>'.$folders[$i]['cate_name'].'</option>'.LF;
			for($j = 0; $j < count($folders); $j++) {
				if($folders[$j]['pid'] == $folders[$i]['cate_id'] && $folders[$j]['pid'] <> 0) {
					$str_c .= '<option value=\''.$folders[$j]['cate_id'].'\'>'.str_repeat('&nbsp;',4).$folders[$j]['cate_name'].'</option>'.LF;
				}
			}
		}
	}
	return $str_c;
}
function main_stats(){
	global $db,$tpf;
	$stats['user_folders_count'] = (int)@$db->result_first("select count(*) from {$tpf}folders");

	$stats['user_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files where is_public=0");

	$stats['users_count'] = (int)@$db->result_first("select count(*) from {$tpf}users ");

	$stats['users_locked_count'] = (int)@$db->result_first("select count(*) from {$tpf}users where is_locked=1");

	$stats['extract_code_count'] = (int)@$db->result_first("select count(*) from {$tpf}extracts");

	$stats['all_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files");

	$storage_count_tmp = (float)@$db->result_first("select sum(file_size) from {$tpf}files where is_public=0");

	$public_storage_count_tmp = (float)@$db->result_first("select sum(file_size) from {$tpf}files where is_public=1");

	$stats['user_storage_count'] = get_size($storage_count_tmp);
	$stats['public_storage_count'] = get_size($public_storage_count_tmp);
	$stats['total_storage_count'] = get_size($storage_count_tmp+$public_storage_count_tmp);
	$stats['users_open_count'] = $stats['users_count']-$stats['users_locked_count'];
	$stats['stat_time'] = TS;

	stats_cache($stats);
}
?>