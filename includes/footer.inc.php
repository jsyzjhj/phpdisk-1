<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: footer.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

$site_index = '<a href="./">'.__('site_index').'</a>';
$contact_us = $settings['contact_us'] ? '&nbsp;<a href="mailto:'.$settings['contact_us'].'">'.__('contact_us_txt').'</a>' : '';
$miibeian = $settings['miibeian'] ? '&nbsp;<a href="http://www.miibeian.gov.cn/" target="_blank">'.$settings['miibeian'].'</a>' : '';
$site_stat = $settings['site_stat'] ? '&nbsp;'.stripslashes(base64_decode($settings['site_stat'])) : '';
$pageinfo = page_end_time();	
$C[navi_bottom_link] = get_navigation_link('bottom');
if($in_front){
	require_once template_echo('pd_footer',$user_tpl_dir);
}
if($q){
	$db->free($q);
}
$db->close();
unset($C,$tpf,$configs,$rs,$_SESSION);
ob_end_flush();

?>