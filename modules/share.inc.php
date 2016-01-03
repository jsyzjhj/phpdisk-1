<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: share.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'share_folder':
		$folder_id = (int)gpc('folder_id','G',0);
		$in_share = (int)gpc('in_share','G',0);

		$can_share = (int)$group_settings[$pd_gid]['can_share'];

		if($task =='share_folder'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));
			$folder_id = (int)gpc('folder_id','P',0);

			$db->query_unbuffered("update {$tpf}folders set in_share=1 where folder_id='$folder_id' and userid='$pd_uid'");
			$db->query_unbuffered("update {$tpf}files set in_share=1 where folder_id='$folder_id' and userid='$pd_uid'");

			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0) && $settings['uc_feed']){
				$folder_name = $db->result_first("select folder_name from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
				uc_share_folder($folder_id,$folder_name);
			}

			tb_redirect($ref,__('folder_share_success'));

		}elseif($task =='unshare_folder'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));
			$folder_id = (int)gpc('folder_id','P',0);

			$db->query_unbuffered("update {$tpf}folders set in_share=0 where folder_id='$folder_id' and userid='$pd_uid'");
			$db->query_unbuffered("update {$tpf}files set in_share=0 where folder_id='$folder_id' and userid='$pd_uid'");
			tb_redirect($ref,__('folder_unshare_success'));

		}else{

			$notice_msg = __('none_file');
			if(!$folder_id){
				$notice_msg = __('root_path_not_share');
			}elseif($can_share){
				function share_file_list($folder_id){
					global $db,$tpf,$pd_uid;
				$q = $db->query("select file_id,file_key,file_name,file_extension,file_size from {$tpf}files where userid='$pd_uid' and folder_id='$folder_id' and in_recycle=0");
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
				$files_array = share_file_list($folder_id);
				$ref = $_SERVER['HTTP_REFERER'];
			}else{
				$notice_msg = __('cannot_share_folder');
			}
			require_once template_echo('share',$user_tpl_dir);
		}
		break;


}
?>
