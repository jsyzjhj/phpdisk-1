<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: files.inc.php 28 2014-01-29 03:12:01Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$option_folder_4 = get_option_folders(4);
$pub_menu_option = get_option_public_folder();
// fix set_extract_code
$a_upload_file = urr("mydisk","item=upload&is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid");
$a_folder_create = urr("mydisk","item=folders&action=folder_create&folder_node=1");
$a_share_folder = '';
$a_list_detail = urr("mydisk","item=files&action=detail");

$group_set = $group_settings[$pd_gid];
if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
	// reload $a_upload_file
	$rs = $db->fetch_one_array("select server_host,server_key from {$tpf}servers where is_default=1 limit 1");
	if($rs){
		$a_upload_file = $rs['server_host'].'?'.pd_encode("is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid&server_key={$rs['server_key']}");
	}
	unset($rs);
}

$tmp_arr = array('a_folder_create'=>$a_folder_create,'a_upload_file' =>$a_upload_file,'a_list_detail'=>$a_list_detail,'a_share_folder'=>$a_share_folder,'title'=>__('extract_file_list'));
$nav_arr = get_my_nav($tmp_arr);

switch($action){
	case 'index':
	case 'detail':

		if($task == 'to_folder'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());
			$dest_folder = gpc('dest_folder','P',0);

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if($dest_folder == -1){
				$error = true;
				$sysmsg[] = __('please_select_dest_folder');
			}else{
				$dest_folder = $dest_folder ? (int)$dest_folder : -1;
			}

			if(!$error){
				$ins = array(
				'folder_id' => $dest_folder,
				'is_public' => 0,
				'cate_id' => 0,
				'subcate_id' => 0,
				'is_checked' => (int)$settings['file_to_public_checked'],
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id in ($file_str) and userid='$pd_uid'");

				$sysmsg[] = __('move_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='to_public'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());
			$public_cate = gpc('public_cate','P',0);

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if($public_cate == -1){
				$error = true;
				$sysmsg[] = __('please_select_dest_folder');
			}else{
				$public_cate = (int)$public_cate;
			}
			$pid = $db->result_first("select pid from {$tpf}categories where cate_id='$public_cate'");
			if($pid){
				$cate_id = $pid;
				$subcate_id = $public_cate;
			}else{
				$cate_id = $public_cate;
				$subcate_id = 0;
			}
			if(!$error){
				$ins = array(
				'folder_id' => 0,
				'is_public' => 1,
				'cate_id' => $cate_id,
				'subcate_id' => $subcate_id,
				'in_recycle' => 0,
				'is_checked' => (int)$settings['file_to_public_checked'],
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id in ($file_str) and userid='$pd_uid' ");

				$sysmsg[] = __('move_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task == 'to_share'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if(!$error){
				$ins = array(
				'in_share' => 1,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id in ($file_str) and userid='$pd_uid'");

				$sysmsg[] = __('share_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='to_extract'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_extract_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if(count($file_ids) >10){
				$error = true;
				$sysmsg[] = __('extract_files_limit');
			}

			$q = $db->query("select * from {$tpf}files where file_id in ($file_str) and userid='$pd_uid' order by file_id desc");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				if($rs['folder_id']){
					$rs2 = $db->fetch_one_array("select folder_name from {$tpf}folders where folder_id='{$rs['folder_id']}'");
					$rs['store_at'] = $rs2['folder_name'];
					unset($rs2);
				}else{
					$rs['store_at'] = __('root_folder');
				}
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = custom_time("Y-m-d",$rs['file_time']);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$default_date = date("Y-m-d",$timestamp+86400*10);
			$extract_code_status = '';
			$extract_total = 0;
			$action = 'set_extract_code';
			require_once template_echo('files',$user_tpl_dir);

		}elseif($task =='is_link_code'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_link_files'),1);
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			if(!$error){
				header('Location:'.urr("mydisk","item=$item&action=make_link_code&file_ids=$file_str&order=asc"));
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task == 'file_delete'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if(!$error){
				$sql = "update {$tpf}files set in_recycle=1 where file_id in ($file_str) and userid='$pd_uid'";
				$db->query_unbuffered($sql);
				$sysmsg[] = __('delete_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$folder_id = (int)gpc('folder_id','G',0);
			$folder_node = (int)gpc('folder_node','G',0);
			$n = trim(gpc('n','G',''));
			$s = trim(gpc('s','G',''));
			$t = trim(gpc('t','G',''));

			$rs = $db->fetch_one_array("select in_recycle,folder_name,folder_node,parent_id,in_share,folder_description,folder_size from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid' and in_recycle=0");
			if($rs){
				$in_share = $rs['in_share'];
				$folder_name = $rs['folder_name'];
				$folder_description = $rs['folder_description'] ? '['.cutstr(str_replace("\r\n",'',preg_replace("/<.+?>/i","",$rs['folder_description'])),50).']' : '';
				$file_count = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id='$folder_id' and userid='$pd_uid' and in_recycle=0");
				$folder_stat = $file_count ? ' ('.__('all_file').$file_count.' , '.__('folder_size').get_size($rs['folder_size']).')' : '';
				$folder_node = $rs['folder_node'];
				$rs2 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid' and in_recycle=0");
				$parent_folder = $rs2['folder_name'];

				if($folder_node ==4){
					$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node,parent_id from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid')  and userid='$pd_uid'");
					$parent_folder2 = $rs3['folder_name'];
					$parent_href2 = urr("mydisk","item=files&action=index&folder_node=2&folder_id={$rs3['folder_id']}");

					$rs4 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs3['parent_id']}' and userid='$pd_uid'");
					$disk_name = $rs4['folder_name'];
					$disk_href = urr("mydisk","item=files&action=index&folder_node=1&folder_id={$rs3['parent_id']}");
					$parent_href = urr("mydisk","item=files&action=index&folder_node=3&folder_id={$rs['parent_id']}");

				}elseif($folder_node ==3){
					$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid')  and userid='$pd_uid'");
					$disk_name = $rs3['folder_name'];
					$disk_href = urr("mydisk","item=files&action=index&folder_node=1&folder_id={$rs3['folder_id']}");
					$parent_href = urr("mydisk","item=files&action=index&folder_node=2&folder_id={$rs['parent_id']}");

				}else{
					$rs2 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid'");
					$in_recycle = $rs["in_recycle"];
					$parent_href = urr("mydisk","item=files&action=index&folder_node={$rs2['folder_node']}&folder_id={$rs2['folder_id']}");

				}
				unset($rs2,$rs3,$rs4);
			}
			$folder_id = $folder_id ? (int)$folder_id : -1;
			/*function sub_folders($folder_id){
				global $db,$tpf,$pd_uid,$pd_gid,$group_settings,$settings;
				$q = $db->query("select * from {$tpf}folders where parent_id='$folder_id' and userid='$pd_uid' and in_recycle=0 order by folder_order asc, folder_id asc");
				$sub_folders = array();
				$folder_count = $folder_size = 0;
				while($rs = $db->fetch_array($q)){
					$folder_count++;

					$rs3 = $db->fetch_one_array("select count(*) as sub_total from {$tpf}folders where parent_id='{$rs['folder_id']}' and userid='$pd_uid'");
					$rs['folder_icon'] = $rs['in_share'] ? 'share_folder' : 'folder';
					$rs['folder_size'] = get_size($rs['folder_size']);
					$rs['folder_count'] = $folder_count;
					$rs['folder_time'] = date("Y-m-d",$rs['in_time']);
					$rs['a_view'] = urr("mydisk","item=files&action=index&folder_node={$rs['folder_node']}&folder_id={$rs['folder_id']}");

					$rs['a_modify'] = urr("mydisk","item=folders&action=folder_modify&folder_id={$rs['folder_id']}");
					$rs['a_delete'] = urr("mydisk","item=folders&action=folder_delete&folder_id={$rs['folder_id']}");
					$rs['sub_total'] = $rs3['sub_total'] ? '('.$rs3['sub_total'].')' : '';

					$sub_folders[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $sub_folders;
			}
			$sub_folders = sub_folders($folder_id);*/

			$o_arr = array('asc','desc');
			if($n){
				$sql_order = in_array($n,$o_arr) ? " file_name $n" : " file_name asc";
			}elseif($s){
				$sql_order = in_array($s,$o_arr) ? " file_size $s" : " file_size asc";
			}elseif($t){
				$sql_order = in_array($t,$o_arr) ? " file_time $t" : " file_time asc";
			}else{
				$sql_order = " file_id desc";
			}

			$perpage = 30;
			$sql_do = " {$tpf}files where folder_id='$folder_id' and userid='$pd_uid' and in_recycle=0 and is_public=0";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			function folder_files($folder_id){
				global $db,$tpf,$sql_do,$sql_order,$start_num,$perpage,$settings;
				$q = $db->query("select * from {$sql_do} order by {$sql_order} limit $start_num,$perpage");
				$files_array = array();
				while($rs = $db->fetch_array($q)){
					$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
					$rs['file_thumb'] = get_file_thumb($rs);

					$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
					$rs['file_name'] = ($action =='detail') ? cutstr($rs['file_name'].$tmp_ext,15) : cutstr($rs['file_name'].$tmp_ext,35);
					$rs['folder_icon'] = $rs['in_share'] ? 'share_folder' : 'folder';
					$rs['file_size'] = get_size($rs['file_size']);
					$rs['file_description'] = cutstr($rs['file_description'],80);
					$rs['file_time'] = custom_time("Y-m-d",$rs['file_time']);
					$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
					$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
					$rs['a_file_modify'] = urr("mydisk","item=files&action=file_modify&file_id={$rs['file_id']}");
					$rs['a_file_delete'] = urr("mydisk","item=files&action=file_delete&file_id={$rs['file_id']}");
					$rs['a_file_unshare'] = urr("mydisk","item=files&action=unshare_file&file_id={$rs['file_id']}");
					$rs['a_file_short_url'] = urr("mydisk","item=files&action=short_url&file_id={$rs['file_id']}");
					$rs['out_file_short_url'] = 'http://phpdisk.com/'.$rs['file_short_url'];
					if(can_true_link($rs['file_extension'])){
						if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0) && $rs['server_oid']>1){
							$rs2 = $db->fetch_one_array("select server_host,server_store_path from {$tpf}servers where server_oid='{$rs['server_oid']}' limit 1");
							$str = $rs2['server_host'].$rs2['server_store_path'].'/'.$rs['file_store_path'].'/'.$rs['file_real_name'];
							$rs['file_out_link'] = $rs['store_old'] ? $str : $str.$tmp_ext;
							unset($rs2);
						}else{
							$str = $settings['phpdisk_url'].$settings['file_path'].'/'.$rs['file_store_path'].'/'.$rs['file_real_name'];
							$rs['file_out_link'] = $rs['store_old'] ? $str : $str.$tmp_ext;
						}
					}else{
						$rs['file_out_link'] = $settings['phpdisk_url'].urr("viewfile","file_id={$rs['file_id']}");
					}

					$files_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $files_array;
			}
			$files_array = folder_files($folder_id);

			$a_upload_file = urr("mydisk","item=upload&is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid");

			$a_share_folder = $folder_id ? urr("mydisk","item=share&action=share_folder&folder_id=$folder_id&in_share=$in_share") : '';
			$chg_action = ($action=='detail') ? 'index' : 'detail';
			$a_list_detail = urr("mydisk","item=files&action=$chg_action&folder_node=$folder_node&folder_id=$folder_id");

			$group_set = $group_settings[$pd_gid];
			if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
				// reload $a_upload_file
				$rs = $db->fetch_one_array("select server_host,server_key from {$tpf}servers where is_default=1 limit 1");
				if($rs){
					$a_upload_file = $rs['server_host'].'?'.pd_encode("is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid&server_key={$rs['server_key']}");
				}
				unset($rs);
			}

			$tmp_arr = array('a_folder_create'=>$a_folder_create,'a_upload_file' =>$a_upload_file,'a_list_detail'=>$a_list_detail,'a_share_folder'=>$a_share_folder,'title'=>__('file_manage'));
			$nav_arr = get_my_nav($tmp_arr);

			$n_t = ($n=='asc') ? 'desc' : 'asc';
			$s_t = ($s=='asc') ? 'desc' : 'asc';
			$t_t = ($t=='asc') ? 'desc' : 'asc';
			$n_order = $n ? $L['o_'.$n_t] : '';
			$s_order = $s ? $L['o_'.$s_t] : '';
			$t_order = $t ? $L['o_'.$t_t] : '';
			$n_url = urr("mydisk","item=files&action=$action&folder_node=$folder_node&folder_id=$folder_id&n=$n_t");
			$s_url = urr("mydisk","item=files&action=$action&folder_node=$folder_node&folder_id=$folder_id&s=$s_t");
			$t_url = urr("mydisk","item=files&action=$action&folder_node=$folder_node&folder_id=$folder_id&t=$t_t");
			$arr = explode('&',$_SERVER['QUERY_STRING']);

			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=files&action=$action&folder_node=$folder_node&folder_id=$folder_id&{$arr[4]}"));

			require_once template_echo('files',$user_tpl_dir);
		}
		break;

	case 'set_extract_code':

		if($task =='set_extract_code'){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array(''));
			$extract_type = (int)gpc('extract_type','P',0);
			$extract_total = (int)gpc('extract_total','P',0);
			$extract_time = trim(gpc('extract_time','P',0));
			$extract_code_custom = trim(gpc('extract_code_custom','P',''));
			$extract_code = substr(md5(random(8).$pd_uid),0,8).XCODE;

			$arr = explode('-',$extract_time);
			$tmp_count = count($arr)-1;

			if(strlen($extract_time) !=10 || $tmp_count !=2 || ((int)$arr[0] < date("Y",$timestamp))){
				$error = true;
				$sysmsg[] = __('extract_time_format');
			}else{
				$extract_time = @mktime(23,59,59,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
			}
			if($extract_total >30000){
				$error = true;
				$sysmsg[] = __('exceed_extract_num');
			}

			$ids_arr = get_ids_arr($file_ids,__('please_select_extract_files'),1);
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$extract_file_ids = $ids_arr[1];
			}
			if(count($file_ids) >20){
				$error = true;
				$sysmsg[] = __('extract_files_limit');
			}
			if($extract_code_custom && checklength($extract_code_custom,6,16) || preg_match("/[^a-z0-9]/i",$extract_code_custom)){
				$error = true;
				$sysmsg[] = __('extract_code_custom_max_min');
			}
			if($extract_code_custom){
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}extracts where extract_code='$extract_code_custom'");
				if($rs['total']){
					$error = true;
					$sysmsg[] = __('extract_code_custom_exists');
				}
				unset($rs);
			}
			$extract_code = $extract_code_custom ? $extract_code_custom : check_extract_code($extract_code);

			if(!$error){
				$ins = array(
				'userid' => $pd_uid,
				'extract_code' => $extract_code,
				'extract_file_ids' => $extract_file_ids,
				'extract_total' => $extract_total,
				'extract_time' => $extract_time,
				'extract_type' => $extract_type,
				'in_time' => $timestamp,
				);
				$db->query("insert into {$tpf}extracts set ".$db->sql_array($ins).";");
				redirect(urr("mydisk","item=files&action=extract_code_list"),'',0);
			}else{
				$sysmsg[] = __('extract_code_setting_error');
				redirect(urr("mydisk","item=files&action=index"),$sysmsg);
			}
		}
		break;

	case 'extract_code_list':
		$perpage = 20;
		$sql_do = " {$tpf}extracts where userid='$pd_uid'";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;
		function extract_code_list(){
			global $db,$tpf,$sql_do,$start_num,$perpage;
			$q = $db->query("select * from {$sql_do} order by extract_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$rs['extract_type_txt'] = (int)$rs['extract_type'] ? __('time') : __('count');
				$rs['extract_time'] = date("Y-m-d",$rs['extract_time']);
				$rs['extract_status_text'] = $rs['extract_locked'] ? '<span>'.__('extract_open').'</span>' : '<span class="txtred">'.__('extract_close').'</span>';
				$rs['a_modify'] = urr("mydisk","item=files&action=extract_modify&extract_id={$rs['extract_id']}");
				$rs['a_status'] = urr("mydisk","item=files&action=extract_status&extract_id={$rs['extract_id']}");
				$rs['a_delete'] = urr("mydisk","item=files&action=extract_delete&extract_id={$rs['extract_id']}");
				$rs['a_view_extract_file'] = urr("mydisk","item=files&action=view_extract_file&extract_id={$rs['extract_id']}");
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			return $files_array;
		}
		$files_array = extract_code_list();
		$a_list_detail = urr("mydisk","item=files&action=detail");
		$tmp_arr = array('a_folder_create'=>$a_folder_create,'a_upload_file' =>$a_upload_file,'a_list_detail'=>$a_list_detail,'a_share_folder'=>$a_share_folder,'title'=>__('extract_code_list'));
		$nav_arr = get_my_nav($tmp_arr);

		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=$item&action=$action"));

		require_once template_echo('files',$user_tpl_dir);
		break;

	case 'extract_status':
		$extract_id = (int)gpc('extract_id','G',0);
		$rs = $db->fetch_one_array("select extract_locked from {$tpf}extracts where extract_id='$extract_id' and userid='$pd_uid'");
		$extract_locked = $rs['extract_locked'] ? 0 : 1;
		unset($rs);
		$db->query_unbuffered("update {$tpf}extracts set extract_locked='$extract_locked' where extract_id='$extract_id' and userid='$pd_uid'");

		redirect(urr("mydisk","item=files&action=extract_code_list"),'',0);
		break ;

	case 'extract_delete':
		$extract_id = (int)gpc('extract_id','G',0);
		$db->query("delete from {$tpf}extracts where userid='$pd_uid' and extract_id='$extract_id'");

		redirect(urr("mydisk","item=files&action=extract_code_list"),'',0);
		break;

	case 'extract_modify':
		$extract_id = (int)gpc('extract_id','G',0);

		if($task =='extract_modify'){
			form_auth(gpc('formhash','P',''),formhash());

			$extract_id = (int)gpc('extract_id','P',0);
			$file_ids = gpc('file_ids','P',array(''));
			$extract_type = (int)gpc('extract_type','P',0);
			$extract_total = (int)gpc('extract_total','P',0);
			$extract_time = trim(gpc('extract_time','P',0));

			$arr = explode('-',$extract_time);
			$tmp_count = count($arr)-1;

			if(strlen($extract_time) !=10 || $tmp_count !=2 || ((int)$arr[0] < date("Y"))){
				$error = true;
				$sysmsg[] = __('extract_time_format');
			}else{
				$extract_time = @mktime(23,59,59,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
			}
			if($extract_total >30000){
				$error = true;
				$sysmsg[] = __('exceed_extract_num');
			}

			$ids_arr = get_ids_arr($file_ids,__('please_select_extract_files'),1);
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $extract_file_ids = $ids_arr[1];
			}
			if(count($file_ids) >10){
				$error = true;
				$sysmsg[] = __('extract_files_limit');
			}

			if(!$error){
				$ins = array(
				'extract_file_ids' => $extract_file_ids,
				'extract_total' => $extract_total,
				'extract_time' => $extract_time,
				'extract_type' => $extract_type,
				);
				$db->query("update {$tpf}extracts set ".$db->sql_array($ins)." where userid='$pd_uid' and extract_id='$extract_id';");
				redirect(urr("mydisk","item=files&action=extract_code_list"),'',0);
			}

		}else{
			function list_cur_extract($extract_id){
				global $db,$tpf,$pd_uid;
				$rs = $db->fetch_one_array("select * from {$tpf}extracts where userid='$pd_uid' and extract_id='$extract_id'");
				if($rs){
					$file_str = $rs['extract_file_ids'];
					$default_date = date("Y-m-d",$rs['extract_time']);
					$extract_code_status = 'readonly';
					$default_code = $rs['extract_code'];
					$extract_total = $rs['extract_total'];
					$extract_type = (int)$rs['extract_type'];
				}
				unset($rs);
				$q = $db->query("select * from {$tpf}files where userid='$pd_uid' and in_recycle=0 and file_id in ($file_str) and userid='$pd_uid' order by file_id desc");
				$files_array = array();
				while($rs = $db->fetch_array($q)){
					if($rs['folder_id']){
						$rs2 = $db->fetch_one_array("select folder_name from {$tpf}folders where folder_id='{$rs['folder_id']}'");
						$rs['store_at'] = $rs2['folder_name'];
						unset($rs2);
					}else{
						$rs['store_at'] = __('root_folder');
					}
					$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
					$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
					$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
					$rs['file_size'] = get_size($rs['file_size']);
					$rs['file_time'] = custom_time("Y-m-d",$rs['file_time']);
					$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
					$files_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $files_array;
			}
			$userid = @$db->result_first("select userid from {$tpf}extracts where extract_id='$extract_id' ");
			$files_array = list_cur_extract($extract_id);
			$a_list_detail = urr("mydisk","item=files&action=detail");
			$tmp_arr = array('a_folder_create'=>$a_folder_create,'a_upload_file' =>$a_upload_file,'a_list_detail'=>$a_list_detail,'a_share_folder'=>$a_share_folder,'title'=>__('extract_file_list'));
			$nav_arr = get_my_nav($tmp_arr);

		}
		require_once template_echo('files',$user_tpl_dir);
		break;

	case 'view_extract_file':
		$extract_id = (int)gpc('extract_id','G',0);
		function view_extract($extract_id){
			global $db,$tpf,$pd_uid;
			$rs = $db->fetch_one_array("select * from {$tpf}extracts where userid='$pd_uid' and extract_id='$extract_id'");
			if($rs){
				$file_str = $rs['extract_file_ids'];
			}
			$q = $db->query("select file_id,file_key,file_name,file_extension,file_size from {$tpf}files where userid='$pd_uid' and in_recycle=0 and file_id in ($file_str)");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['file_size'] = get_size($rs['file_size']);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			return $files_array;
		}
		$userid = @$db->result_first("select userid from {$tpf}extracts where extract_id='$extract_id' ");
		$files_array = view_extract($extract_id);
		require_once template_echo('files',$user_tpl_dir);
		break;

	case 'file_modify':
		$file_id = (int)gpc('file_id','GP',0);

		if($task == 'file_modify'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));
			$file_name = trim(gpc('file_name','P',''));
			$in_share = (int)gpc('in_share','P',0);
			$file_description = trim(gpc('file_description','P',''));
			$tags = trim(gpc('file_tag','P',''));

			if(checklength($file_name,1,100)){
				$error = true;
				$sysmsg[] = __('file_min_max');
			}
			if($file_description && checklength($file_description,1,250)){
				$error = true;
				$sysmsg[] = __('file_description_min_max');
			}
			if($tags){
				$tags = str_replace('，',',',$tags);
				$tags = str_replace(',,',',',$tags);
				$tags = (substr($tags,-1) ==',') ? substr($tags,0,-1) : $tags;

				$tag_arr = explode(',',$tags);
				if(count($tag_arr) >5){
					$error = true;
					$sysmsg[] = __('too_many_tags');
				}
			}
			if(!$error){
				if($tags){
					$db->query_unbuffered("update {$tpf}files set in_share=1 where file_id='$file_id' and userid='$pd_uid'");
				}else{
					$db->query_unbuffered("update {$tpf}files set in_share=0 where file_id='$file_id' and userid='$pd_uid'");
				}
				$ins = array(
				'file_name' => $file_name,
				'file_description' => $file_description,
				'in_share' => $in_share,
				'ip' => $onlineip,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id='$file_id' and userid='$pd_uid';");
				if($settings['open_tag']){
					make_tags($tags,$tag_arr,$file_id);
				}

				tb_redirect($ref,__('file_modify_success'));

			}else{
				tb_redirect('back',$sysmsg);
			}
		}else{
			$file = $db->fetch_one_array("select file_name,file_description,in_share from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$str = '';
			if($settings['open_tag']){
				$q = $db->query("select * from {$tpf}file2tag where file_id='$file_id' order by ftid asc");
				while($rs = $db->fetch_array($q)){
					$str .= "{$rs['tag_name']},";
				}
				$db->free($q);
				unset($rs);
				$file['file_tag'] = substr($str,-1) ? substr($str,0,-1) : $str;
			}
			$ref = $_SERVER['HTTP_REFERER'];
			$a_replace_upload = urr("mydisk","item=upload&action=upload_replace&file_id={$file_id}&uid=$pd_uid");
			require_once template_echo('files',$user_tpl_dir);
		}
		break;

	case 'file_delete':
		$file_id = (int)gpc('file_id','GP',0);
		if($task =='file_delete'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$sql = "update {$tpf}files set in_recycle=1 where file_id='$file_id' and userid='$pd_uid'";
			$db->query_unbuffered($sql);
			tb_redirect($ref,__('file_delete_success'));
		}else{
			$rs = $db->fetch_one_array("select file_name,file_extension from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('files',$user_tpl_dir);
		}
		break;

	case 'unshare_file':
		$file_id = (int)gpc('file_id','GP',0);

		if($task =='unshare_file'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$sql = "update {$tpf}files set in_share=0 where file_id='$file_id' and userid='$pd_uid'";
			$db->query_unbuffered($sql);

			tb_redirect($ref,__('unshare_file_success'));
		}else{
			$rs = $db->fetch_one_array("select file_name,file_extension from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('files',$user_tpl_dir);
		}
		break;

	case 'short_url':
		$file_id = (int)gpc('file_id','GP',0);
		$rs = $db->fetch_one_array("select file_extension,file_name,file_short_url from {$tpf}files where file_id='$file_id'");
		if($rs){
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$msg = $rs['file_short_url'] ? '<li class="txtred">'.__('file_short_url_warning').'</li>' : '';
		}
		unset($rs);
		$a_viewfile = urr("viewfile","file_id=".$file_id);
		$file_cur_url = $settings['phpdisk_url'].$a_viewfile;

		if($task =='short_url'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$file_short_url = random(6);

			$url = "http://phpdisk.com/";
			$fp = @fopen($url,"r");
			if(!$fp){
				$error = true;
				$sysmsg[] = __('cannot_make_short_url');
			}
			@fclose($fp);

			if(!$error){

				$sql = "update {$tpf}files set file_short_url='$file_short_url' where file_id='$file_id' and userid='$pd_uid'";
				$db->query_unbuffered($sql);

				$a_file_short_url = 'http://phpdisk.com/'.$file_short_url;
				$o = $settings['phpdisk_url'].urr("viewfile","file_id=$file_id");
				$url = 'http://phpdisk.com/?a=in&o='.$o.'&n='.$file_short_url.'&t='.$timestamp;

				echo '<div style=\'padding:30px;\' id="su_loading"><img src="images/ajax_load_bar.gif" align="absmiddle" border="0" /><br><br> '.__('data_loading').'</div>';
				echo '
				<script type="text/javascript">document.write("<img src='.$url.' width=0 height=0>");</script>
				<script type="text/javascript">
				window.setTimeout("su_link()", 5000);
				function su_link() {
					g(\'su_loading\').style.display = "none";
					g(\'suc_su_box\').style.display = "";
				}
				</script>';
				$msg = '<li class="txtblue">'.__('add_file_short_url_success').'</li>';
				require_once template_echo('files',$user_tpl_dir);
			}else{
				tb_redirect($ref,__('cannot_make_short_url'));
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('files',$user_tpl_dir);
		}
		break;
	case 'make_link_code':
		$file_str = gpc('file_ids','G','');
		$file_str = get_ids($file_str);
		if(!$file_str){
			exit('Error');
		}

		$order = gpc('order','G','');
		$order = $order=='asc' ? 'desc' : 'asc';
		if($file_str){
			$q = $db->query("select file_id,file_name,file_key,file_extension,is_image,file_store_path,file_real_name,store_old,server_oid from {$tpf}files where file_id in ($file_str) and userid='$pd_uid' order by file_id $order");
			$upl_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				if(can_true_link($rs['file_extension'])){
					if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0) && $rs['server_oid']>1){
						$rs2 = $db->fetch_one_array("select server_host,server_store_path from {$tpf}servers where server_oid='{$rs['server_oid']}' limit 1");
						$url_pfx = $rs2['server_host'].$rs2['server_store_path'].'/'.$rs['file_store_path'].'/';
						if($rs['store_old']){
							$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);
							$rs['file_link_img'] = $url_pfx.$rs['file_real_name'];
						}else{
							$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);
							$rs['file_link_img'] = $url_pfx.$rs['file_real_name'].$tmp_ext;
						}
						unset($rs2);
					}else{
						$url_pfx = $settings['phpdisk_url'].$settings['file_path'].'/'.$rs['file_store_path'].'/';
						if($rs['store_old']){
							$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);
							$rs['file_link_img'] = $url_pfx.$rs['file_real_name'];
						}else{
							$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);
							$rs['file_link_img'] = $url_pfx.$rs['file_real_name'].$tmp_ext;
						}
					}
				}else{
					$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);
					$rs['file_link_img'] = $settings['phpdisk_url'].urr("downfile","action=view&file_id=".$rs['file_id']."&file_key=".$rs['file_key']);
				}
				$upl_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$order_url = $settings['phpdisk_url'].urr("mydisk","item=$item&action=$action&file_ids=$file_str&order=$order");

			require_once template_echo('files',$user_tpl_dir);
		}
		break;
	default:
		redirect(urr("mydisk","item=files&action=index"),'',0);
}

function check_extract_code($extract_code){
	global $db,$tpf;
	$rs = $db->fetch_one_array("select count(*) as total from {$tpf}extracts where extract_code='$extract_code'");
	if($rs['total'] <1){
		return $extract_code;
	}else{
		return substr(md5($extract_code.random(8)),0,8).XCODE;
	}
	unset($rs);
}

?>