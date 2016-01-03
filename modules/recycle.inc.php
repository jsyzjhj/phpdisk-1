<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: recycle.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'files':
		if($task =='delete_complete_recycle'){
			form_auth(gpc('formhash','P',''),formhash());

			$fd_sel_ids = gpc('fd_sel_ids','P',array());
			$fl_sel_ids = gpc('fl_sel_ids','P',array());

			if(!count($fd_sel_ids) && !count($fl_sel_ids)){
				$error = true;
				$sysmsg[] = __('please_select_operation_files');
			}
			if(!$error){
				if(count($fd_sel_ids)){
					$ids_arr = get_ids_arr($fd_sel_ids,'');
					if(!$ids_arr[0]){
						$fd_str = $ids_arr[1];
					}
				}
				if(count($fl_sel_ids)){
					$ids_arr = get_ids_arr($fl_sel_ids,'');
					if(!$ids_arr[0]){
						$fl_str = $ids_arr[1];
					}
				}
				if($fl_str){
					delete_phpdisk_file("select * from {$tpf}files where file_id in ($fl_str) and userid='$pd_uid'");
					$db->query_unbuffered("delete from {$tpf}files where file_id in ($fl_str) and userid='$pd_uid'");}
				if($fd_str){
					delete_phpdisk_file("select * from {$tpf}files where folder_id in ($fd_str) and userid='$pd_uid'");
					$db->query_unbuffered("delete from {$tpf}folders where folder_id in ($fd_str) and userid='$pd_uid'");
					$db->query_unbuffered("delete from {$tpf}files where folder_id in ($fd_str) and userid='$pd_uid'");}
				$sysmsg[] = __('folder_delete_complete_success');
				redirect(urr("mydisk","item=recycle&action=files"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='restore_recycle'){
			form_auth(gpc('formhash','P',''),formhash());

			$fd_sel_ids = gpc('fd_sel_ids','P',array());
			$fl_sel_ids = gpc('fl_sel_ids','P',array());

			if(!count($fd_sel_ids) && !count($fl_sel_ids)){
				$error = true;
				$sysmsg[] = __('please_select_operation_files');
			}
			if(!$error){
				if(count($fd_sel_ids)){
					$ids_arr = get_ids_arr($fd_sel_ids,'');
					if(!$ids_arr[0]){
						$fd_str = $ids_arr[1];
					}
				}
				if(count($fl_sel_ids)){
					$ids_arr = get_ids_arr($fl_sel_ids,'');
					if(!$ids_arr[0]){
						$fl_str = $ids_arr[1];
					}
				}
				if($fl_str){
					$db->query_unbuffered("update {$tpf}files set in_recycle=0 where file_id in ($fl_str) and userid='$pd_uid'");}
				if($fd_str){
					$db->query_unbuffered("update {$tpf}folders set in_recycle=0 where folder_id in ($fd_str) and userid='$pd_uid'");
					$db->query_unbuffered("update {$tpf}files set in_recycle=0 where folder_id in ($fd_str) and userid='$pd_uid'");
				}
				$sysmsg[] = __('folder_restore_success');
				redirect(urr("mydisk","item=recycle&action=files"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			function recycle_files(){
				global $db,$tpf,$pd_uid;
				$q = $db->query("select * from {$tpf}files where userid='$pd_uid' and in_recycle=1 order by file_id desc ");
				$files_array = array();
				while($rs = $db->fetch_array($q)){
					$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
					$rs['file_thumb'] = get_file_thumb($rs);
					$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
					$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
					$rs['file_size'] = get_size($rs['file_size']);
					$rs['file_time'] = date("Y-m-d",$rs['file_time']);
					$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
					$rs['a_delete_complete'] = urr("mydisk","item=recycle&action=file_delete_complete&file_id={$rs['file_id']}");
					$rs['a_restore'] = urr("mydisk","item=recycle&action=file_restore&file_id={$rs['file_id']}");
					$files_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $files_array;
			}
			$files_array = recycle_files();
			function recycle_folders(){
				global $db,$tpf,$pd_uid;
				$q = $db->query("select * from {$tpf}folders where userid='$pd_uid' and in_recycle=1 order by folder_id desc");
				$folders_array = array();
				while($rs = $db->fetch_array($q)){
					$rs['folder_name'] = cutstr($rs['folder_name'],35);
					$rs['folder_time'] = date("Y-m-d",$rs['in_time']);
					$rs['folder_size'] = get_size($rs['folder_size']);
					$rs['a_viewfolder'] = urr("mydisk","item=recycle&action=show_files&folder_id={$rs['folder_id']}");
					$rs['a_delete_complete'] = urr("mydisk","item=recycle&action=folder_delete_complete&folder_id={$rs['folder_id']}");
					$rs['a_restore'] = urr("mydisk","item=recycle&action=folder_restore&folder_id={$rs['folder_id']}");

					$rs2 = $db->fetch_one_array("select count(*) as total from {$tpf}files where folder_id='{$rs['folder_id']}'");
					$rs['total'] = $rs2['total'] ? "({$rs2['total']})" : '';
					$folders_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $folders_array;
			}
			$folders_array = recycle_folders();
			if(!count($files_array) && !$folders_array){
				$recycle_empty = 1;
			}

			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'show_files':
		$folder_id = (int)gpc('folder_id','G',0);

		$files_array = recycle_show_file($folder_id);
		$ref = $_SERVER['HTTP_REFERER'];
		require_once template_echo('recycle',$user_tpl_dir);
		break;

	case 'folder_delete_complete':
		$folder_id = (int)gpc('folder_id','GP',0);

		if($task =='folder_delete_complete'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			delete_phpdisk_file("select * from {$tpf}files where folder_id='$folder_id' and userid='$pd_uid'");

			$db->query_unbuffered("delete from {$tpf}files where folder_id='$folder_id' and userid='$pd_uid'");
			$db->query_unbuffered("delete from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid' and in_recycle=1");
			tb_redirect($ref,__('folder_delete_complete_success'));

		}else{
			$files_array = recycle_show_file($folder_id);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'file_delete_complete':
		$file_id = (int)gpc('file_id','GP',0);
		if($task =='file_delete_complete'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			delete_phpdisk_file("select * from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$db->query_unbuffered("delete from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			tb_redirect($ref,__('file_delete_complete_success'));

		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'folder_restore':
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task =='folder_restore'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$db->query_unbuffered("update {$tpf}files set in_recycle=0 where folder_id='$folder_id' and userid='$pd_uid'");
			$db->query_unbuffered("update {$tpf}folders set in_recycle=0 where folder_id='$folder_id' and userid='$pd_uid'");

			tb_redirect($ref,__('folder_restore_success'));
		}else{
			$files_array = recycle_show_file($folder_id);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'file_restore':
		$file_id = (int)gpc('file_id','GP',0);
		if($task =='file_restore'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$db->query_unbuffered("update {$tpf}files set in_recycle=0 where file_id='$file_id' and userid='$pd_uid'");
			tb_redirect($ref,__('file_restore_success'));
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'restore_all':
		if($task =='restore_all'){
			form_auth(gpc('formhash','P',''),formhash());

			$db->query_unbuffered("update {$tpf}files set in_recycle=0 where in_recycle=1 and userid='$pd_uid'");
			$db->query_unbuffered("update {$tpf}folders set in_recycle=0 where in_recycle=1 and userid='$pd_uid'");
			$sysmsg[] = __('restore_all_success');
			redirect(urr("mydisk","item=recycle&action=files"),$sysmsg);
		}else{
			$folder_num = @$db->result_first("select count(*) from {$tpf}folders where in_recycle=1 and userid='$pd_uid'");
			$file_num = @$db->result_first("select count(*) from {$tpf}files where in_recycle=1 and userid='$pd_uid'");
			$tmp = (int)@$db->result_first("select sum(file_size) from {$tpf}files where in_recycle=1 and userid='$pd_uid'");
			$all_size = get_size($tmp);
			$disabled = (!$folder_num && !$file_num) ? 'disabled' : '';

			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	case 'delete_all':
		if($task =='delete_all'){
			form_auth(gpc('formhash','P',''),formhash());

			delete_phpdisk_file("select * from {$tpf}files where in_recycle=1 and userid='$pd_uid'");

			$db->query_unbuffered("delete from {$tpf}folders where in_recycle=1 and userid='$pd_uid'");
			$db->query_unbuffered("delete from {$tpf}files where in_recycle=1 and userid='$pd_uid'");
			$sysmsg[] = __('delete_all_success');
			redirect(urr("mydisk","item=recycle&action=files"),$sysmsg);

		}else{
			$folder_num = @$db->result_first("select count(*) from {$tpf}folders where in_recycle=1 and userid='$pd_uid'");
			$file_num = @$db->result_first("select count(*) from {$tpf}files where in_recycle=1 and userid='$pd_uid'");
			$tmp = (int)@$db->result_first("select sum(file_size) from {$tpf}files where in_recycle=1 and userid='$pd_uid'");
			$all_size = get_size($tmp);
			$disabled = (!$folder_num && !$file_num) ? 'disabled' : '';

			require_once template_echo('recycle',$user_tpl_dir);
		}
		break;

	default:
		redirect(urr("mydisk","item=recycle&menu=recycle&action=files"),'',0);
}
function recycle_show_file($folder_id){
	global $db,$tpf,$pd_uid;
	$q = $db->query("select file_id,file_key,file_name,file_extension,file_size from {$tpf}files where userid='$pd_uid' and folder_id='$folder_id'");
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
?>