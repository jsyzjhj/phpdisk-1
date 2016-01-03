<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: cache.func.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
function stats_cache($arr=0){
	global $db,$tpf;
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$v = str_replace(array("'",'\\'),'',$v);
			$sqls .= "('$k','".$db->escape(trim($v))."'),";
		}
		$sqls = substr($sqls,0,-1);
		$db->query("replace into {$tpf}stats (vars,value) values $sqls;");
	}
	
	$q = $db->query("select * from {$tpf}stats order by vars ");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['vars']."' => '".$rs['value']."',".LF;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$stats = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/global/stats.inc.php",$str);

}
function settings_cache($arr=0){
	global $db,$tpf,$configs,$settings;
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$v = str_replace(array("'",'\\'),'',$v);
			$sqls .= "('$k','".$db->escape(trim($v))."'),";
		}
		$sqls = substr($sqls,0,-1);
		$db->query("replace into `{$configs['dbname']}`.{$tpf}settings (vars,value) values $sqls;");
	}
	$q = $db->query("select * from `{$configs['dbname']}`.{$tpf}settings order by vars ");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['vars']."' => '".$rs['value']."',".LF;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/settings.inc.php",$str);

}
function update_remote_settings(){
	global $db,$tpf,$configs,$settings;
	$q = $db->query("select server_host,server_key from {$tpf}servers where server_oid>1",'SILENT');
	while($q && $rs = $db->fetch_array($q)){
		echo '<script type="text/javascript" src="'.$rs['server_host'].'update_configs.php?code='.pd_encode($rs['server_key']).'"></script>';
	}
	$db->free($q);
	unset($rs);
}
function plugin_cache(){
	global $db,$tpf;
	$q = $db->query("select plugin_name,actived from {$tpf}plugins order by plugin_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[plugin_name]}'=>array(".LF;
		$str_c .= "\t\t'plugin_name'=>'{$rs[plugin_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$plugin_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/global/plugin_settings.inc.php",$str);	
}
function lang_cache(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}langs order by lang_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[lang_name]}'=>array(".LF;
		$str_c .= "\t\t'lang_name'=>'{$rs[lang_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$lang_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/global/lang_settings.inc.php",$str);		
}
function tpl_cache(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}templates order by tpl_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[tpl_name]}'=>array(".LF;
		$str_c .= "\t\t'tpl_name'=>'{$rs[tpl_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t\t'tpl_type'=>'{$rs[tpl_type]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$tpl_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/global/tpl_settings.inc.php",$str);		
}
function group_settings_cache(){
	global $db,$tpf;

	$q = $db->query("select * from {$tpf}groups order by gid");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['gid']."' => array(".LF;
		$str_c .= "\t\t'max_messages' => '".$rs['max_messages']."',".LF;
		$str_c .= "\t\t'max_flow_down' => '".$rs['max_flow_down']."',".LF;
		$str_c .= "\t\t'max_flow_view' => '".$rs['max_flow_view']."',".LF;
		$str_c .= "\t\t'max_storage' => '".$rs['max_storage']."',".LF;
		$str_c .= "\t\t'max_filesize' => '".$rs['max_filesize']."',".LF;
		$str_c .= "\t\t'group_file_types' => '".$rs['group_file_types']."',".LF;
		$str_c .= "\t\t'max_folders' => '".$rs['max_folders']."',".LF;
		$str_c .= "\t\t'max_files' => '".$rs['max_files']."',".LF;
		$str_c .= "\t\t'can_share' => '".$rs['can_share']."',".LF;
		$str_c .= "\t\t'secs_loading' => '".$rs['secs_loading']."',".LF;
		$str_c .= "\t\t'server_ids' => '".$rs['server_ids']."',".LF;
		$str_c .= "\t),".LF.LF;
		
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$group_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	
	write_file(PHPDISK_ROOT."./system/global/group_settings.inc.php",$str);
}
function update_remote_group_settings(){
	global $db,$tpf;
	$q = $db->query("select server_host,server_key from {$tpf}servers where server_oid>1",'SILENT');
	while($q && $rs = $db->fetch_array($q)){
		echo '<script type="text/javascript" src="'.$rs['server_host'].'update_configs.php?code='.pd_encode($rs['server_key']).'"></script>';
	}
	$db->free($q);
	unset($rs);
}


function folders_menu_cache(){
	global $db,$tpf,$pd_uid;
	
	$cache_dir = PHPDISK_ROOT."system/cache/$pd_uid/";
	make_dir($cache_dir);
	
	$num = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id=0 and in_recycle=0 and userid='$pd_uid'");
	$folder_size = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id=0 and in_recycle=0 and userid='$pd_uid'");
	$count = $num ? __('all_file')."$num , ".__('folder_size').get_size($folder_size) : '';

	$str_c = "tr.add(0,-1,'".__('mydisk_cp_manage')."','".urr("mydisk","item=files&action=index")."','{$count}');".LF;

	$q = $db->query("select folder_id,parent_id,folder_name,folder_node,folder_size from {$tpf}folders where userid='$pd_uid' and in_recycle=0 order by folder_order asc,in_time asc");
	while($rs = $db->fetch_array($q)){
		$num = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id='{$rs['folder_id']}' and userid='$pd_uid'");
		$count = $num ? __('all_file')."$num , ".__('folder_size').get_size($rs['folder_size']) : '';
		$rs['parent_id'] = $rs['parent_id']==-1 ? 0 : (int)$rs['parent_id'];
		$str_c .= "tr.add({$rs['folder_id']},{$rs['parent_id']},'{$rs['folder_name']}','".urr("mydisk","item=files&action=index&folder_node={$rs['folder_node']}&folder_id={$rs['folder_id']}")."','{$count}');".LF;
	}
	$db->free($q);
	unset($rs);
	return $str_c;
}
function public_menu_cache($front=0){
	global $db,$tpf,$pd_uid;
	if($front){
		$str_c = "tr.add(0,-1,'".__('public_file_list')."','".urr("public","")."');".LF;
	}else{
		$str_c = "tr.add(0,-1,'".__('public_file_manage')."','###');".LF;
	}

	$q = $db->query("select * from {$tpf}categories where is_hidden=0 order by show_order asc,cate_id asc");
	while($rs = $db->fetch_array($q)){
		$num = @$db->result_first("select count(*) from {$tpf}files where cate_id='{$rs['cate_id']}' or subcate_id='{$rs['cate_id']}' and in_recycle=0 and is_public=1 and cate_id>0 and userid>0 ");
		if($front){
			$str_c .= "tr.add({$rs['cate_id']},{$rs['pid']},'{$rs['cate_name']}','".urr("public","pid={$rs['pid']}&cate_id={$rs['cate_id']}")."','".$num."','');".LF;
		}else{
			$str_c .= "tr.add({$rs['cate_id']},{$rs['pid']},'{$rs['cate_name']}','".urr("mydisk","item=public&action=index&pid={$rs['pid']}&id={$rs['cate_id']}")."','".$num."');".LF;
		}
	}
	$db->free($q);
	unset($rs);

	return $str_c;

}
function remote_server_url(){
	global $db,$tpf,$configs,$settings;
	if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
		$rs = $db->fetch_one_array("select server_host,server_store_path,server_key from {$tpf}servers where server_id>1 order by is_default desc limit 1");
		if($rs){
			$remote_server_url = $rs['server_host'].'update_configs.php?code='.$rs[server_key];
		}
		unset($rs);
	}else{
		$remote_server_url = '';
	}
	return $remote_server_url;
}

?>