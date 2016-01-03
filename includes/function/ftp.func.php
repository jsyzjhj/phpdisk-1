<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: ftp.func.php 18 2014-01-06 03:44:27Z along $
#
#	Copyright (C) 2008-2012 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

function pftp_connnect($ftp_host,$ftp_user,$ftp_pass,$ftp_port = 21,$ftp_path = '/',$ftp_ssl = 0,$ftp_pasv = 1){
	@set_time_limit(0);
	$ftp_host = wipe_replace($ftp_host);
	$ftp_user = wipe_replace($ftp_user);
	$ftp_pass = wipe_replace($ftp_pass);
	$ftp_path = wipe_replace($ftp_path);
	
	$func = $ftp_ssl && function_exists('ftp_ssl_connect') ? 'ftp_ssl_connect' : 'ftp_connect';
	if($func == 'ftp_connect' && !function_exists('ftp_connect')) {
		pftp_log(__('ftp_not_supported'));
	}
	if($ftp_conn_id = @$func($ftp_host, $ftp_port, 30)){
		if(pftp_login($ftp_conn_id, $ftp_user, $ftp_pass)){
			@ftp_pasv($ftp_conn_id,$ftp_pasv);
			if(pftp_chdir($ftp_conn_id, $ftp_path)){
				return $ftp_conn_id;
			}else{
				pftp_log(__('ftp_chdir_error'));
			}
		}else{
			pftp_log(__('ftp_login_error'));
		}
	}else{
		pftp_log(__('ftp_cannot_connect'));
	}
	pftp_close($ftp_conn_id);
}
function pftp_login($ftp_conn_id,$ftp_user,$ftp_pass){
	$ftp_user = wipe_replace($ftp_user);
	$ftp_pass = str_replace(array("\n", "\r"), array('', ''), $ftp_pass);
	return @ftp_login($ftp_conn_id, $ftp_user, $ftp_pass);
}
function pftp_get($ftp_conn_id, $local_file, $remote_file) {
	$remote_file = wipe_replace($remote_file);
	$local_file = wipe_replace($local_file);
	return @ftp_get($ftp_conn_id, $local_file, $remote_file, FTP_BINARY);
}
function pftp_put($ftp_conn_id, $remote_file, $local_file) {
	$remote_file = wipe_replace($remote_file);
	$local_file = wipe_replace($local_file);
	return @ftp_put($ftp_conn_id, $remote_file, $local_file, FTP_BINARY);
}
function pftp_mkdir($ftp_conn_id, $dir){
	$dir = wipe_replace($dir);
	return @ftp_mkdir($ftp_conn_id, $dir);
}
function pftp_rmdir($ftp_conn_id, $dir){
	$dir = wipe_replace($dir);
	return @ftp_rmdir($ftp_conn_id, $dir);
}
function pftp_size($ftp_conn_id, $remote_file){
	$dir = wipe_replace($remote_file);
	return @ftp_size($ftp_conn_id, $remote_file);
}
function pftp_delete($ftp_conn_id, $path){
	$path = wipe_replace($path);
	return @ftp_delete($ftp_conn_id, $path);
}
function pftp_site($ftp_conn_id, $cmd){
	$cmd = wipe_replace($cmd);
	return @ftp_site($ftp_conn_id, $cmd);
}
function pftp_chmod($ftp_conn_id, $mode, $file_name){
	$mode = (int)$mode;
	$file_name = wipe_replace($file_name);
	if(function_exists('ftp_chmod')){
		return ftp_chmod($ftp_conn_id, $mode, $file_name);
	} else {
		return pftp_site($ftp_conn_id, 'CHMOD '.$mode.' '.$file_name);
	}
}
function pftp_chdir($ftp_conn_id,$dir){
	$dir = wipe_replace($dir);
	return @ftp_chdir($ftp_conn_id,$dir);
}
function pftp_close($ftp_res) {
	return @ftp_close($ftp_res);
}
function pftp_log($str){
	$access_str = '<?php exit(); ?>';
	$log_file = PHPDISK_ROOT.'./system/ftp_log.php';
	
	$content = file_exists($log_file) ? read_file($log_file) : ''; 

	if(!$content && strpos($content,$access_str) ===false){
		$str = $access_str.LF.$str."|".date("Y-m-d H:i:s").LF;
	}else{
		$str = $str."|".date("Y-m-d H:i:s").LF;
	}
	write_file($log_file,$str,'a+');
}
?>