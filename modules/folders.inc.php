<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: folders.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'index':
		if($task == 'to_folder'){
			form_auth(gpc('formhash','P',''),formhash());

			$folder_ids = gpc('folder_ids','P',array());
			$dest_folder = gpc('dest_folder','P',0);

			$ids_arr = get_ids_arr($folder_ids,__('please_select_move_folders'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$folder_str = $ids_arr[1];
			}
			if($dest_folder ==-1){
				$error = true;
				$sysmsg[] = __('please_select_dest_folder');
			}else{
				$dest_folder = $dest_folder ? (int)$dest_folder : -1;
			}

			if(!$error){
				$rs = $db->fetch_one_array("select folder_node from {$tpf}folders where folder_id='$dest_folder'");
				$folder_node = (int)$rs['folder_node']+1;
				$sql = "update {$tpf}folders set parent_id='$dest_folder',folder_node='$folder_node' where folder_id<>'$dest_folder' and folder_id in ($folder_str)";
				$db->query_unbuffered($sql);

				$sysmsg[] = __('folder_move_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task == 'folder_delete'){
			form_auth(gpc('formhash','P',''),formhash());

			$folder_ids = gpc('folder_ids','P',array());
			$dest_folder = gpc('dest_folder','P',0);

			$ids_arr = get_ids_arr($folder_ids,__('please_select_move_folders'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$folder_str = $ids_arr[1];
			}

			if(!$error){
				$db->query_unbuffered("update {$tpf}folders set in_recycle=1 where folder_id in ($folder_str) and userid='$pd_uid'");
				$sysmsg[] = __('folder_delete_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			function folder_list(){
				global $db,$tpf,$group_settings,$pd_uid;
				$q = $db->query("select folder_node,folder_id,folder_name,folder_description,parent_id,folder_size,in_share from {$tpf}folders where userid='$pd_uid' and in_recycle=0");
				$folders = array();
				while($rs = $db->fetch_array($q)){
					$folders[] = $rs;
				}
				$db->free($q);
				unset($rs);
				$group_set = $group_settings[$pd_gid];

				for($i = 0; $i < count($folders); $i++) {
					if($folders[$i]['folder_node'] == 1) {
						$folder_node_i = $folders[$i]['folder_node'];
						$folder_id_i = $folders[$i]['folder_id'];
						$folder_name_i = $folders[$i]['folder_name'];
						$in_share = $folders[$i]['in_share'];
						$href_i = urr("mydisk","item=files&action=index&folder_node=$folder_node_i&folder_id=$folder_id_i");
						$a_share = urr("mydisk","item=share&action=share_folder&folder_id=$folder_id_i&in_share=$in_share");
						$a_modify = urr("mydisk","item=folders&action=folder_modify&folder_id=$folder_id_i");
						$a_delete = urr("mydisk","item=folders&action=folder_delete&folder_id=$folder_id_i");

						$folder_icon = $in_share ? 'share_folder' : 'folder';
						$folder_list .= '<tr>';
						$folder_list .= '<td class="td_line"><input type="checkbox" name="folder_ids[]" id="folder_ids" value="'.$folder_id_i.'" />';
						$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_share.'\',\''.__('share_folder').'\',440,320);" title="'.__('share').'"><img src="images/'.$folder_icon.'.gif" border="0" align="absmiddle"></a>&nbsp;';
						$folder_list .= '<a href="'.$href_i.'">'.$folder_name_i.'</a>&nbsp;';
						$folder_list .= '<span class="txtgray">'.$folders[$i]['folder_description'].'</span>';
						$folder_list .= '</td>'.LF;
						$folder_list .= '<td align="center">'.LF;
						$folder_list .= get_size($folders[$i]['folder_size']).LF;
						$folder_list .= '</td>'.LF;
						$folder_list .= '<td align="right">'.LF;
						$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_modify.'\',\''.__('folder_modify').'\',400,280);" title="'.__('modify').'"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>&nbsp;'.LF;
						$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_delete.'\',\''.__('folder_delete').'\',400,200);" title="'.__('delete').'"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a>'.LF;
						$folder_list .= '</td></tr>'.LF;

						for($j = 0; $j < count($folders); $j++) {
							$folder_node_j = $folders[$j]['folder_node'];
							$folder_id_j = $folders[$j]['folder_id'];
							$folder_name_j = $folders[$j]['folder_name'];
							$in_share = $folders[$j]['in_share'];
							$href_j = urr("mydisk","item=files&action=index&folder_node=$folder_node_j&folder_id=$folder_id_j");
							$a_share = urr("mydisk","item=share&action=share_folder&folder_id=$folder_id_j&in_share=$in_share");				
							$a_modify = urr("mydisk","item=folders&action=folder_modify&folder_id=$folder_id_j");
							$a_delete = urr("mydisk","item=folders&action=folder_delete&folder_id=$folder_id_j");

							if($folders[$j]['parent_id'] == $folders[$i]['folder_id'] && $folders[$j]['folder_node'] == 2) {
								$folder_icon = $in_share ? 'share_folder' : 'folder';
								$folder_list .= '<tr>';
								$folder_list .= '<td class="td_line">'.str_repeat('&nbsp;',4).'<input type="checkbox" name="folder_ids[]" id="folder_ids" value="'.$folder_id_j.'" />';
								$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_share.'\',\''.__('share_folder').'\',440,320);" title="'.__('share').'"><img src="images/'.$folder_icon.'.gif" border="0" align="absmiddle"></a>&nbsp;';
								$folder_list .= '<a href="'.$href_j.'">'.$folder_name_j.'</a>&nbsp;';
								$folder_list .= '<span class="txtgray">'.$folders[$j]['folder_description'].'</span>';
								$folder_list .= '</td>'.LF;
								$folder_list .= '<td width="15%" align="center">'.LF;
								$folder_list .= get_size($folders[$j]['folder_size']).LF;
								$folder_list .= '</td>'.LF;
								$folder_list .= '<td align="right">'.LF;
								$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_modify.'\',\''.__('folder_modify').'\',400,280);" title="'.__('modify').'"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>&nbsp;'.LF;
								$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_delete.'\',\''.__('folder_delete').'\',400,200);" title="'.__('delete').'"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a>'.LF;
								$folder_list .= '</td></tr>'.LF;

								for($k = 0; $k < count($folders); $k++) {
									$folder_node_k = $folders[$k]['folder_node'];
									$folder_id_k = $folders[$k]['folder_id'];
									$folder_name_k = $folders[$k]['folder_name'];
									$in_share = $folders[$k]['in_share'];
									$href_k = urr("mydisk","item=files&action=index&folder_node=$folder_node_k&folder_id=$folder_id_k");
									$a_share = urr("mydisk","item=share&action=share_folder&folder_id=$folder_id_k&in_share=$in_share");
									$a_modify = urr("mydisk","item=folders&action=folder_modify&folder_id=$folder_id_k");
									$a_delete = urr("mydisk","item=folders&action=folder_delete&folder_id=$folder_id_k");

									if($folders[$k]['parent_id'] == $folders[$j]['folder_id'] && $folders[$k]['folder_node'] == 3) {
										$folder_icon = $in_share ? 'share_folder' : 'folder';
										$folder_list .= '<tr>';
										$folder_list .= '<td class="td_line">'.str_repeat('&nbsp;',8).'<input type="checkbox" name="folder_ids[]" id="folder_ids" value="'.$folder_id_k.'" />';
										$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_share.'\',\''.__('share_folder').'\',440,320);" title="'.__('share').'"><img src="images/'.$folder_icon.'.gif" border="0" align="absmiddle"></a>&nbsp;';
										$folder_list .= '<a href="'.$href_k.'">'.$folder_name_k.'</a>&nbsp;';
										$folder_list .= '<span class="txtgray">'.$folders[$k]['folder_description'].'</span>';
										$folder_list .= '</td>'.LF;
										$folder_list .= '<td width="15%" align="center">'.LF;
										$folder_list .= get_size($folders[$k]['folder_size']).LF;
										$folder_list .= '</td>'.LF;
										$folder_list .= '<td align="right">'.LF;
										$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_modify.'\',\''.__('folder_modify').'\',400,280);" title="'.__('modify').'"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>&nbsp;'.LF;
										$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_delete.'\',\''.__('folder_delete').'\',400,200);" title="'.__('delete').'"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a>'.LF;
										$folder_list .= '</td></tr>'.LF;

										for($l = 0; $l < count($folders); $l++) {
											$folder_node_l = $folders[$l]['folder_node'];
											$folder_id_l = $folders[$l]['folder_id'];
											$folder_name_l = $folders[$l]['folder_name'];
											$in_share = $folders[$l]['in_share'];
											$href_l = urr("mydisk","item=files&action=index&folder_node=$folder_node_l&folder_id=$folder_id_l");
											$a_share = urr("mydisk","item=share&action=share_folder&folder_id=$folder_id_l&in_share=$in_share");
											$a_modify = urr("mydisk","item=folders&action=folder_modify&folder_id=$folder_id_l");
											$a_delete = urr("mydisk","item=folders&action=folder_delete&folder_id=$folder_id_l");

											if($folders[$l]['parent_id'] == $folders[$k]['folder_id'] && $folders[$l]['folder_node'] == 4) {
												$folder_icon = $in_share ? 'share_folder' : 'folder';
												$folder_list .= '<tr>';
												$folder_list .= '<td class="td_line">'.str_repeat('&nbsp;',12).'<input type="checkbox" name="folder_ids[]" id="folder_ids" value="'.$folder_id_l.'" />';
												$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_share.'\',\''.__('share_folder').'\',440,320);" title="'.__('share').'"><img src="images/'.$folder_icon.'.gif" border="0" align="absmiddle"></a>&nbsp;';
												$folder_list .= '<a href="'.$href_l.'">'.$folder_name_l.'</a>&nbsp;';
												$folder_list .= '<span class="txtgray">'.$folders[$l]['folder_description'].'</span>';
												$folder_list .= '</td>'.LF;
												$folder_list .= '<td width="15%" align="center">'.LF;
												$folder_list .= get_size($folders[$l]['folder_size']).LF;
												$folder_list .= '</td>'.LF;
												$folder_list .= '<td align="right">'.LF;
												$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_modify.'\',\''.__('folder_modify').'\',400,280);" title="'.__('modify').'"><img src="images/edit_icon.gif" border="0" align="absmiddle" /></a>&nbsp;'.LF;
												$folder_list .= '<a href="javascript:;" onclick="abox(\''.$a_delete.'\',\''.__('folder_delete').'\',400,200);" title="'.__('delete').'"><img src="images/recycle_icon.gif" border="0" align="absmiddle" /></a>'.LF;
												$folder_list .= '</td></tr>'.LF;
											}
										}
									}
								}
							}
						}
					}
				}
				return $folder_list;
			}
			$folder_list = folder_list();

			$option_folder_3 = get_option_folders(3);

			$a_upload_file = urr("mydisk","item=upload&is_public=$is_public&cate_id=$cate_id&subcate_id=$subcate_id&folder_node=$folder_node&folder_id=$folder_id&uid=$pd_uid");
			$a_folder_create = urr("mydisk","item=folders&action=folder_create&folder_node=1");
			$a_share_folder = '';
			$a_list_detail = urr("mydisk","item=files&action=detail");

			$tmp_arr = array('a_folder_create'=>$a_folder_create,'a_upload_file' =>$a_upload_file,'a_list_detail'=>$a_list_detail,'a_share_folder'=>$a_share_folder,'title'=>__('folder_manage'));
			$nav_arr = get_my_nav($tmp_arr);

			require_once template_echo('folders',$user_tpl_dir);
		}
		break;

	case 'folder_modify':

		$folder_id = (int)gpc('folder_id','GP',0);
		if($task == 'folder_modify'){
			form_auth(gpc('formhash','P',''),formhash());

			$folder_name = trim(gpc('folder_name','P',''));
			$folder_description = trim(gpc('folder_description','P',''));
			$ref = trim(gpc('ref','P',''));
			if(checklength($folder_name,1,100)){
				$error = true;
				$sysmsg[] = __('folder_min_max');
			}elseif(is_bad_chars($folder_name)){
				$error = true;
				$sysmsg[] = __('folder_name_bad_chars');
			}
			$num = @$db->result_first("select folder_id from {$tpf}folders where userid='$pd_uid' and folder_name='$folder_name' and folder_id<>'$folder_id'");
			if($num){
				$error = true;
				$sysmsg[] = __('folder_exists');
			}

			if(!$error){
				$ins = array(
				'folder_name' => $folder_name,
				'folder_description' => $folder_description,
				);
				$db->query_unbuffered("update {$tpf}folders set ".$db->sql_array($ins)." where folder_id='{$folder_id}' and userid='$pd_uid';");
				tb_redirect($ref,__('folder_modify_success'));
			}else{
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}
		}else{
			$folder = $db->fetch_one_array("select folder_name,folder_description from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('folders',$user_tpl_dir);
		}
		break;

	case 'folder_create':
		$group_set = $group_settings[$pd_gid];

		$folder_node = (int)gpc('folder_node','G',0);
		$folder_id = (int)gpc('folder_id','G',0);

		if($task == 'folder_create'){
			form_auth(gpc('formhash','P',''),formhash());

			$parent_id = (int)gpc('parent_id','P',0);
			$folder_name = trim(gpc('folder_name','P',''));
			$folder_description = trim(gpc('folder_description','P',''));
			$ref = trim(gpc('ref','P',''));

			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}folders where userid='$pd_uid'");
			if($group_set['max_folders'] && $rs['total'] >= $group_set['max_folders']){
				$error = true;
				$sysmsg[] = __('exceed_max_folders');
			}
			if(checklength($folder_name,1,100)){
				$error = true;
				$sysmsg[] = __('folder_min_max');
			}elseif(is_bad_chars($folder_name)){
				$error = true;
				$sysmsg[] = __('folder_name_bad_chars');
			}
			$num = @$db->result_first("select count(*) from {$tpf}folders where userid='$pd_uid' and folder_name='$folder_name'");
			if($num){
				$error = true;
				$sysmsg[] = __('folder_exists');
			}

			$folder_node = @$db->result_first("select folder_node from {$tpf}folders where userid='$pd_uid' and folder_id='$parent_id'");
			$folder_node = (int)($folder_node+1);
			if(!$error){
				$ins = array(
				'folder_name' => $folder_name,
				'folder_description' => $folder_description,
				'parent_id' => $parent_id ? $parent_id : -1,
				'folder_node' => $folder_node,
				'userid' => $pd_uid,
				'in_time' => $timestamp,
				);
				$db->query("insert into {$tpf}folders set ".$db->sql_array($ins).";");

				tb_redirect($ref,__('folder_create_success'));
			}else{
				redirect('back',$sysmsg);
			}
		}else{

			$option_folder_3 = get_option_folders(3);

			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}folders where userid='$pd_uid'");
			if($group_set['max_folders'] && $rs['total'] >=$group_set['max_folders']){
				$exceed_max_folders = true;
			}
			unset($rs);
			$ref = $_SERVER['HTTP_REFERER'];
			$script = 'getId(\'fd_'.$folder_id.'\').selected=true;'.LF;

			require_once template_echo('folders',$user_tpl_dir);
		}
		break;

	case 'folder_delete':
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task =='folder_delete'){
			form_auth(gpc('formhash','P',''),formhash());

			$ref = trim(gpc('ref','P',''));

			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}folders where parent_id='$folder_id' and userid='$pd_uid'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('has_sub_folder');
			}
			unset($rs);
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set in_recycle=1 where folder_id='$folder_id' and userid='$pd_uid'");
				$db->query_unbuffered("update {$tpf}folders set in_recycle=1 where folder_id='$folder_id' and userid='$pd_uid'");
				tb_redirect($ref,__('folder_delete_success'));

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select folder_name,folder_node from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			$folder_name = $rs['folder_name'];
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo('folders',$user_tpl_dir);
		}
		break;

}
?>
