<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: public.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$pub_menu_option = get_option_public_folder();

switch($action){
	case 'index':
		if($task == 'to_public'){
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
				'is_public' => 1,
				'cate_id' => $cate_id,
				'subcate_id' => $subcate_id,
				'in_recycle' => 0,
				'is_checked' => (int)$settings['file_to_public_checked'],
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id in ($file_str) and userid='$pd_uid'");

				$sysmsg[] = __('move_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);

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
				delete_phpdisk_file("select * from {$tpf}files where file_id in ($file_str) and is_public=1 and userid='$pd_uid'");
				$db->query_unbuffered("delete from {$tpf}files where file_id in ($file_str) and is_public=1 and userid='$pd_uid'");

				$sysmsg[] = __('file_delete_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{

			$id = (int)gpc('id','G',0);
			$pid = (int)gpc('pid','G',0);
			$n = trim(gpc('n','G',''));
			$s = trim(gpc('s','G',''));
			$t = trim(gpc('t','G',''));

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

			if($id){
				if($pid){
					$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and cate_id='$pid' and subcate_id='$id' and is_public=1";
					$cate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$pid'");
					$subcate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$id'");
					$a_cate = urr("mydisk","item=public&menu=public&action=index&pid=0&id=$pid");
				}else{
					$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and cate_id='$id' and is_public=1";
					$cate_name = @$db->result_first("select cate_name from {$tpf}categories where cate_id='$id'");
				}
			}else{
				$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and cate_id='0' and is_public=1";
			}

			$perpage = 20;
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;
			function public_file(){
				global $db,$tpf,$sql_do,$sql_order,$start_num,$perpage,$pd_uid;
				$q = $db->query("select fl.*,u.username from {$sql_do} order by {$sql_order} limit $start_num,$perpage");
				$files_array = array();
				while($rs = $db->fetch_array($q)){
					$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
					$rs['file_thumb'] = get_file_thumb($rs);
					$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
					$rs['file_size'] = get_size($rs['file_size']);
					$rs['file_time'] = date("Y-m-d H:i:s",$rs['file_time']);
					$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
					$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
					$rs['a_file_modify'] = urr("mydisk","item=public&menu=public&action=file_modify&file_id={$rs['file_id']}");
					$rs['a_file_delete'] = urr("mydisk","item=public&menu=public&action=file_delete&file_id={$rs['file_id']}");
					$files_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
				return $files_array;
			}
			$files_array = public_file();
			if($pid){
				$subcate_id_t = $id;
				$cate_id_t = $pid ;
			}else{
				$subcate_id_t = 0;
				$cate_id_t = $id ;
			}

			$n_t = ($n=='asc') ? 'desc' : 'asc';
			$s_t = ($s=='asc') ? 'desc' : 'asc';
			$t_t = ($t=='asc') ? 'desc' : 'asc';
			$n_order = $n ? $L['o_'.$n_t] : '';
			$s_order = $s ? $L['o_'.$s_t] : '';
			$t_order = $t ? $L['o_'.$t_t] : '';
			$n_url = urr("mydisk","item=public&menu=public&action=index&pid=$pid&id=$id&n=$n_t");
			$s_url = urr("mydisk","item=public&menu=public&action=index&pid=$pid&id=$id&s=$s_t");
			$t_url = urr("mydisk","item=public&menu=public&action=index&pid=$pid&id=$id&t=$t_t");
			$arr = explode('&',$_SERVER['QUERY_STRING']);

			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=public&action=index&pid=$pid&id=$id&{$arr[4]}"));

			$a_upload_file = urr("mydisk","item=upload&is_public=1&cate_id=$cate_id_t&subcate_id=$subcate_id_t&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid");

			$group_set = $group_settings[$pd_gid];
			if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
				$server_oid = get_last_upload_server($pd_uid,$group_set['server_ids']);
				if($server_oid>1){
					// reload $a_upload_file
					$rs = $db->fetch_one_array("select server_host,server_key from {$tpf}servers where server_oid='$server_oid'limit 1");
					if($rs){
						$a_upload_file = $rs['server_host'].'?'.pd_encode("is_public=1&cate_id=$cate_id_t&subcate_id=$subcate_id_t&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid&server_key={$rs['server_key']}");
					}
					unset($rs);
				}
			}
			$nav_arr = get_my_nav();
			require_once template_echo('public',$user_tpl_dir);
		}
		break;

	case 'file_modify':
		$file_id = (int)gpc('file_id','GP',0);

		if($task == 'file_modify'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));
			$file_name = trim(gpc('file_name','P',''));
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
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}files where userid='$pd_uid' and file_name='$file_name' and file_id<>'$file_id'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('file_name_exists');
			}
			if(!$error){
				$ins = array(
				'file_name' => $file_name,
				'file_description' => $file_description,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id='{$file_id}' and userid='$pd_uid';");
				if($settings['open_tag']){
					make_tags($tags,$tag_arr,$file_id);
				}

				tb_redirect($ref,__('file_modify_success'));
			}else{
				tb_redirect($ref,$sysmsg);
			}
		}else{
      $str = '';
			$file = $db->fetch_one_array("select file_name,file_description from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
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
			require_once template_echo('public',$user_tpl_dir);

		}
		break;

	case 'file_delete':
		$file_id = (int)gpc('file_id','GP',0);

		if($task =='file_delete'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			if(!$error){
				/*delete_phpdisk_file("select * from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
				$db->query_unbuffered("delete from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");*/
				$ins = array(
				'folder_id' => -1,
				'is_public' => 0,
				'cate_id'=>0,
				'subcate_id'=>0,
				'in_recycle' => 0,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id='$file_id' and userid='$pd_uid' ");
				tb_redirect($ref,__('file_delete_success'));
			}else{
				tb_redirect($ref,$sysmsg,0);
			}
		}else{
			$rs = $db->fetch_one_array("select file_name,file_extension from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$file_name = $rs['file_name'].$tmp_ext;
			$file_extension = $rs['file_extension'];
			$ref = $_SERVER['HTTP_REFERER'];
			unset($rs);
			require_once template_echo('public',$user_tpl_dir);
		}
		break;

}
?>