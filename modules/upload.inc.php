<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: upload.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

@set_time_limit(0);
$group_set = $group_settings[$pd_gid];
$upload_max = get_byte_value(ini_get('upload_max_filesize'));
$post_max = get_byte_value(ini_get('post_max_size'));
$settings_max = $settings['max_file_size'] ? get_byte_value($settings['max_file_size']) : 0;
$max_php_file_size = min($upload_max, $post_max);
$max_file_size_byte = ($settings_max && $settings_max <= $max_php_file_size) ? $settings_max : $max_php_file_size;
if($group_set['max_filesize']){
	$group_set_max_file_size = get_byte_value($group_set['max_filesize']);
	$max_file_size_byte = ($group_set_max_file_size >=$max_file_size_byte) ? $max_file_size_byte : $group_set_max_file_size;
}
$max_user_file_size = get_size($max_file_size_byte,'B',0);

$file_id = (int)gpc('file_id','GP',0);
$folder_id = (int)gpc('folder_id','G',0);
$folder_node = (int)gpc('folder_node','G',0);
$is_public = (int)gpc('is_public','G',0);
$cate_id = (int)gpc('cate_id','G',0);
$subcate_id = (int)gpc('subcate_id','G',0);
$uid = (int)gpc('uid','G',0);
$action = $action ? $action : 'doupload';

switch($action){

	default:

		$upload_url = urr("mydisk","item=upload&is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid");
		if($task == 'doupload'){
			$file = $_FILES['upload_file'];
			$file['name'] = $db->escape($file['name']);

			create_store_dir();
			$file_real_path = PHPDISK_ROOT.'/'.$settings['file_path'].'/';
			$file_store_path = short_date("Y").'/'.short_date("m").'/'.short_date("d").'/';

			if(!is_utf8()){
				$file['name'] = convert_str('utf-8','gbk',$file['name']);
			}
			$file_extension = get_extension($file['name']);
			$esp = strlen($file_extension)+1;
			if($file_extension){
				$file_name = substr($file['name'],0,strlen($file['name'])-$esp);
			}else{
				$file_name = $file['name'];
			}
			/*if($settings['store_true_filename']){
			$num = $db->result_first("select count(*) from {$tpf}files where file_name='$file_name' and file_extension='$file_extension'");
			$file_real_name = $num ? $file_name.'_'.random(2) : $file_name;
			}else{*/
			$file_real_name = md5(uniqid(mt_rand(),true).microtime().$pd_uid);
			//}
			$file_real_name_store = is_utf8() ? convert_str('utf-8','gbk',$file_real_name) : $file_real_name;
			$file_ext = get_real_ext($file_extension);
			$dest_file = $file_real_path.$file_store_path.$file_real_name_store.$file_ext;

			if(upload_file($file['tmp_name'],$dest_file)){

				$report_status =0;
				$report_arr = explode(',',$settings['report_word']);
				if(count($report_arr)){
					foreach($report_arr as $value){
						if (strpos($file['name'],$value) !== false){
							$report_status = 2;
						}
					}
				}
				$file_key = random(8);

				$file_mime = strtolower($db->escape($file['type']));
				$img_arr = getimagesize($dest_file);
				if($img_arr[2] && @in_array($file_extension,array('jpg','jpeg','png','gif','bmp'))){
					$is_image = 1;
					make_thumb($dest_file, $file_real_path.$file_store_path.$file_real_name_store.'_thumb.'.$file_extension,$settings['thumb_width'],$settings['thumb_height']);
				}else{
					$is_image = 0;
				}
				if(file_exists($file_real_path.$file_store_path.$file_real_name_store.'_thumb.'.$file_extension)){
					$thumb_size = filesize($file_real_path.$file_store_path.$file_real_name_store.'_thumb.'.$file_extension);
				}else{
					$thumb_size = 0;
				}
				$db->ping();
				if($settings['all_file_share']){
					$in_share = 1;
				}else{
					$in_share = (int)@$db->result_first("select in_share from {$tpf}folders where folder_id='$folder_id'");
				}
				$is_checked = $is_public ? ($settings['check_public_file'] ? 0 :1) : 1;
				$server_oid = 0;
				$ins = array(
				'file_name' => $file_name,
				'file_key' => $file_key,
				'file_extension' => $file_extension,
				'is_image' => $is_image,
				'file_mime' => $file_mime,
				'file_description' => $file_description ? $file_description : '',
				'file_store_path' => $file_store_path,
				'file_real_name' => $file_real_name,
				'file_md5' => $file_md5 ? $file_md5 : '',
				'server_oid' => (int)$server_oid,
				'file_size' => $file['size'],
				'thumb_size' => $thumb_size,
				'file_time' => $timestamp,
				'is_checked' => $is_checked,
				'in_share' => $in_share,
				'is_public' => $is_public,
				'report_status' => $report_status,
				'userid' => $uid,
				'folder_id' => $folder_id,
				'cate_id' => $cate_id,
				'subcate_id' => $subcate_id,
				'ip' => $onlineip,
				);
				$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins).";");
				$file_id = $db->insert_id();

				$db->query_unbuffered("update {$tpf}folders set folder_size=folder_size+{$file['size']} where userid='$pd_uid' and folder_id='$folder_id'");
				if($settings['open_tag'] && $tags){
					make_tags($tags,$tag_arr,$file_id);
				}

				if($settings['credit_open']){
					$credit = $settings['credit_open'] ? (int)$settings['credit_upload'] : 0;
					$db->query_unbuffered("update {$tpf}users set credit=credit+{$credit} where userid='$pd_uid'");
				}
				$exp_upload = (int)$settings['exp_upload'];
				$db->query_unbuffered("update {$tpf}users set exp=exp+$exp_upload where userid='$pd_uid'");


				@unlink($file['tmp_name']);
			}else{
				$access_str = '<?php exit(); ?>';
				$error_log = PHPDISK_ROOT.'system/upload_log.php';
				if(file_exists($error_log)){
					$content = read_file($error_log);
				}
				$str = ' ';
				if(strpos($content,$access_str) ===false){
					$str = $access_str.LF.$str;
				}
				write_file($error_log,$str,'a+');
			}
			if(display_plugin('filelog','open_filelog_plugin',($settings['open_filelog'] && $settings['open_upload_filelog']),0)){
				$username = @$db->result_first("select username from {$tpf}users where userid='$pd_uid' limit 1");
				$log_format = $file_name.'.'.$file_extension.'|'.get_size($file['size']).'|'.__('upload').'|'.$username.'|-|'.date("Y-m-d H:i:s").'|'.$onlineip;
				all_file_logs($log_format);
			}

		}else{

			$cannot_upload = false;

			$group_set = $group_settings[$pd_gid];

			$total = @$db->result_first("select count(*) from {$tpf}files where userid='$pd_uid'");
			if($group_set['max_files'] && $total >= $group_set['max_files']){
				$cannot_upload = true;
				$hints_msg = __('user_files_exceeded');
			}
			$rs = $db->fetch_one_array("select space_pos,user_store_space from {$tpf}users where userid='$pd_uid' limit 1");
			if(display_plugin('disk','open_disks_plugin',$settings['open_disks'],0)){
				if($rs['space_pos']){
					$my_all_file = @$db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid' and space_pos='1'");
					$rs = $db->fetch_one_array("select space from {$tpf}disks d,{$tpf}disk2user du where d.disk_id=du.disk_id and du.userid='$pd_uid' and endtime>$timestamp");
					if($rs){
						$disk_space = get_byte_value($rs['space']);
						if($my_all_file >=$disk_space){
							$cannot_upload = true;
							$hints_msg = __('rent_space_exceeded');
						}
					}else{
						$cannot_upload = true;
						$hints_msg = __('rent_space_not_found');
					}
					unset($rs);

				}else{
					$my_all_file = @$db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid' and space_pos='0'");
					$tmp_max_storage = $rs['user_store_space'] ? $rs['user_store_space'] : $group_set['max_storage'];
					if($tmp_max_storage && $my_all_file >= get_byte_value($tmp_max_storage)){
						$cannot_upload = true;
						$hints_msg = __('user_storage_exceeded');
					}
				}
			}else{
				$my_all_file = @$db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid'");
				$tmp_max_storage = $rs['user_store_space'] ? $rs['user_store_space'] : $group_set['max_storage'];
				if($tmp_max_storage && $my_all_file >= get_byte_value($tmp_max_storage)){
					$cannot_upload = true;
					$hints_msg = __('user_storage_exceeded');
				}
			}

			$rs = $db->fetch_one_array("select user_file_types from {$tpf}users where userid='$pd_uid'");
			if($group_set['group_file_types']){
				$arr = explode(',',trim($group_set['group_file_types']));
				for($i=0;$i<count($arr);$i++){
					$user_file_types .= '*.'.$arr[$i].';';
				}
			}else{
				if($rs['user_file_types']){
					$arr = explode(',',trim($rs['user_file_types']));
					for($i=0;$i<count($arr);$i++){
						$user_file_types .= '*.'.$arr[$i].';';
					}
				}else{
					$user_file_types = '*.*';
				}
			}

			if($is_public){

				if($cate_id && $subcate_id){
					$cate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$cate_id'");
					$subcate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$subcate_id'");
					$a_cate = urr("mydisk","item=public&action=index&pid=0&id=$cate_id");
				}else{
					$cate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$cate_id'");
				}

			}else{
				$rs = $db->fetch_one_array("select in_recycle,folder_name,folder_node,parent_id from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
				if($rs){
					$folder_name = $rs['folder_name'];
					$folder_node = $rs['folder_node'];
					$rs2 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid'");
					$parent_folder = $rs2['folder_name'];

					if($folder_node ==4){
						$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node,parent_id from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid') and userid='$pd_uid'");
						$parent_folder2 = $rs3['folder_name'];
						$parent_href2 = urr("mydisk","item=files&action=index&folder_node=2&folder_id={$rs3['folder_id']}");

						$rs4 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs3['parent_id']}' and userid='$pd_uid'");
						$disk_name = $rs4['folder_name'];
						$disk_href = urr("mydisk","item=files&action=index&folder_node=1&folder_id={$rs3['parent_id']}");
						$parent_href = urr("mydisk","item=files&action=index&folder_node=3&folder_id={$rs['parent_id']}");

					}elseif($folder_node ==3){
						$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid') and userid='$pd_uid'");
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
			}
			require_once template_echo($item,$user_tpl_dir);
		}
}



?>