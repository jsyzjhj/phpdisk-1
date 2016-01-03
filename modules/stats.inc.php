<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: stats.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

if(!display_plugin('filelog','open_filelog_plugin',$settings['open_filelog'],0)){
	exit('ERROR: filelog'.__('plugin_not_install'));
}

switch($action){
	default:
		$log_arr = glob(PHPDISK_ROOT."system/cache/$pd_uid/".date("Ymd")."_*.log");
		if(count($log_arr)){
			foreach($log_arr as $fn){
				$content = file_exists($fn) ? read_file($fn) : 'Open file error!';
			}
		}
		
		require_once template_echo('stats',$user_tpl_dir);
}
?>