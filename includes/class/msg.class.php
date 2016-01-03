<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: msg.class.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class msg {

	function msg() {

	}
	function fmsg($str,$param){
		return sprintf($str,$param);
	}
}
?>