<?php
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: index.php 17 2014-01-06 03:41:29Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

error_reporting(E_ALL ^E_NOTICE);
session_start();
define('PHPDISK_ROOT', '../');
define('IN_PHPDISK', true);
define('NOW_YEAR','2014');
$charset = 'utf-8';
$total_step = 8;
$lang_id = 'zh_cn';

require PHPDISK_ROOT.'includes/lib/php-gettext/gettext.inc.php';

_setlocale(LC_MESSAGES, $lang_id);
_bindtextdomain('phpdisk', 'languages');
_bind_textdomain_codeset('phpdisk', $charset);
_textdomain('phpdisk');

if(file_exists(PHPDISK_ROOT.'system/install.lock')){
	header("Location: ../index.php");
	exit;
}

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('LF',"\r\n");
} else {
	define('LF',"\n");
}
if(file_exists(PHPDISK_ROOT.'includes/auth.inc.php')){
	require PHPDISK_ROOT.'includes/auth.inc.php';
}

if(file_exists(PHPDISK_ROOT.'languages/'.$lang_id.'/license.php')){
	require PHPDISK_ROOT.'languages/'.$lang_id.'/license.php';
}

$version_type = $auth['is_commercial_edition'] ? __('pay_version') : __('free_version');
ob_start();
require PHPDISK_ROOT.'includes/phpdisk_version.inc.php';

function addslashes_array(&$array) {
	if(is_array($array)){
		foreach($array as $k => $v) {
			$array[$k] = addslashes_array($v);
		}
	}elseif(is_string($array)){
		$array = addslashes($array);
	}
	return $array;
}
function defend_xss($val){
	return is_array($val) ? $val : htmlspecialchars($val);
}

function gpc($name,$w = 'GPC',$default = '',$d_xss=0){
	$i = 0;
	for($i = 0; $i < strlen($w); $i++) {
		if($w[$i] == 'G' && isset($_GET[$name])) return $d_xss ? defend_xss($_GET[$name]) : $_GET[$name];
		if($w[$i] == 'P' && isset($_POST[$name])) return $d_xss ? defend_xss($_POST[$name]) : $_POST[$name];
		if($w[$i] == 'C' && isset($_COOKIE[$name])) return $d_xss ? defend_xss($_COOKIE[$name]) : $_COOKIE[$name];
	}
	return $default;
}
if(!@get_magic_quotes_gpc()){
	$_GET = addslashes_array($_GET);
	$_POST = addslashes_array($_POST);
	$_COOKIE = addslashes_array($_COOKIE);
}

@set_magic_quotes_runtime(0);

$step = (int)gpc('step','GP',0);
$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$config_file = PHPDISK_ROOT.'system/configs.inc.php';

$sqlfile = PHPDISK_ROOT.'install/phpdisk.sql';
if(!file_exists($sqlfile) || !is_readable($sqlfile)) {
	exit(__('db_file_not_exists'));
}
$fp = fopen($sqlfile, 'rb');
$sql = fread($fp, filesize($sqlfile));
fclose($fp);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title>PHPDISK <?php echo PHPDISK_VERSION .' '. PHPDISK_EDITION?> <?php echo __('install_guide') ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body style="margin-top:5px">
<div id="main">
<?php if($step ==3 || $step ==4 || $step ==5 || $step ==7){?>
  <form method="post" name="myform" action="<?php echo $php_self;?>" onsubmit="return chksubmit(this);">
<?php }else{?>  
  <form method="post" name="myform" action="<?php echo $php_self;?>">
<?php }?>
    <p class="title">PHPDISK <?php echo PHPDISK_VERSION .' '. PHPDISK_EDITION?> <span class="txtgreen">[<?php echo strtoupper($charset).$version_type; ?>]</span> <?php echo __('install_guide') ?></p>
    <hr noshade="noshade" />
<?php
if(!$step){
?>
<p>
	<li><?php echo __('lc_1') ?></li><br /><br />
	<li><?php echo __('lc_2') ?></li>
</p>
<p>&nbsp;</p>
<p align="center"><?php echo __('welcome_msg')?></p>
<p>&nbsp;</p>
<hr noshade="noshade" />
<p align="right">
<input type="hidden" name="step" value="1" />
<input class="formbutton" type="submit" value="<?php echo __('next_step') ?>" />
</p>
<?php
}elseif($step == 1){
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('user_license') ?></p>
	<p align="center"><textarea rows="50" cols="100" readonly="readonly"><?php echo $phpdisk_license ?></textarea>
	</p>
    <hr noshade="noshade" />
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" type="submit" value="<?php echo __('agree') ?>" />&nbsp;&nbsp;<input class="formbutton" type="button" value="<?php echo __('disagree') ?>" onclick="javascript:window.close();" />
    </p>
<?php 
}else if($step ==2){
	$short_open_tag = @ini_get('short_open_tag');
	$system_dir = PHPDISK_ROOT.'system/';
	$filestores_dir = PHPDISK_ROOT.'filestores/';
	$template_dir = PHPDISK_ROOT.'templates/';
	$plugins_dir = PHPDISK_ROOT.'plugins/';
	$chk_system_dir = dir_writeable($system_dir) ? 1 : 0;
	$chk_filestores_dir = dir_writeable($filestores_dir) ? 1 : 0;
	$chk_plugins_dir = dir_writeable($plugins_dir) ? 1 : 0;
	if($short_open_tag && $chk_system_dir && $chk_filestores_dir && $chk_plugins_dir){
		$install_halt =0;
	}else{
		$install_halt =1;
	}
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('install_note') ?></p>
    <p><?php echo __('welcome_to_use') ?> PHPDisk <?php echo PHPDISK_VERSION .' '. PHPDISK_EDITION?>，<?php echo __('install_settings') ?>: </p>
    <ul>
      <li><?php echo __('mysql_server_or_ip') ?> </li>
      <li><?php echo __('mysql_username_or_password') ?> </li>
      <li><?php echo __('mysql_database_name') ?> </li>
      <li><?php echo $system_dir ?> <?php echo __('check_dir1') ?></li>
	  <li><?php echo $system_dir ?> <?php echo __('check_dir2') ?>：<?php output_txt($chk_system_dir,1); ?></li>
      <li><?php echo $filestores_dir ?> <?php echo __('check_dir1') ?></li>
	  <li><?php echo $filestores_dir ?> <?php echo __('check_dir2') ?>：<?php output_txt($chk_filestores_dir,1); ?></li>
      <li><?php echo $plugins_dir ?> <?php echo __('check_dir1') ?></li>
	  <li><?php echo $plugins_dir ?> <?php echo __('check_dir2') ?>：<?php output_txt($chk_plugins_dir,1); ?></li>
    </ul>
    <p><?php echo __('database_tips_info') ?></p>
	<?php 
	if($short_open_tag !=1){
	?>
		<p class="txtred"><b><?php echo __('php_env_setting') ?>：</b><?php echo __('short_open_tag') ?></p>
	<?php 
	}
	?>
	<?php if(!$install_halt){?>
    <hr noshade="noshade" />
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" type="submit" value="<?php echo __('next_step') ?>" />
    </p>
	<?php }?>
<?php
} elseif ($step == 3) {

	$fp = fopen($config_file,'w');
	if (!$fp) {
		exit("Can not open file <b>$config_file</b> .");
	}
	@fclose($fp);
	$exist_error = false;
	$write_error = false;
	if (file_exists($config_file)) {
		$fileexists = output_txt(1, 0);
	} else {
		$fileexists = output_txt(0, 0);
		$exist_error = true;
	}
	if (is_writable($config_file)) {
		$filewriteable = output_txt(1, 0);
	} else {
		$filewriteable = output_txt(0, 0);
		$write_error = true;
	}
	if ($exist_error) {
		$config_info = $config_file.' '.__('config_file_not_exists');
	} elseif($write_error) {
		$config_info = __('config_file_cant_write');
	}
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('database_setting') ?></p>
    <p><?php echo $config_file;?> <?php echo __('file_exists') ?> <?php echo $fileexists;?></p>
    <p><?php echo $config_file;?> <?php echo __('file_writeable') ?> <?php echo $filewriteable;?></p>
<?php
if ($config_info) {
?>
    <p><?php echo $config_info;?></p>
    <hr noshade="noshade" />
    <p align="right">
      <input class="formbutton" type="button" value="<?php echo __('prev_step') ?>" onclick="history.back(1)" />
    </p>
<?php
} else {
?>
    <hr noshade="noshade" />
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td colspan="2" class="bold"><?php echo __('base_info') ?></td>
      </tr>
      <tr>
        <td width="30%"><?php echo __('dbhost') ?>:</td>
        <td><input type="text" value="localhost" name="dbhost" class="formfield" style="width:150px"> <?php echo __('dbhost_tips') ?></td>
      </tr>
      <tr>
        <td><?php echo __('dbuser') ?>:</td>
        <td><input type="text" value="DBuser" name="dbuser" class="formfield" style="width:150px" onclick="this.value='';"></td>
      </tr>
      <tr>
        <td><?php echo __('dbpasswd') ?>:</td>
        <td><input type="password" value="" name="dbpasswd" class="formfield" style="width:150px" onclick="this.value='';"></td>
      </tr>
    </table>
	<script language="javascript">
	document.myform.dbhost.focus();
	function chksubmit(o){
		if(o.dbhost.value == ""){
			alert("<?php echo __('js_dbhost') ?>");
			o.dbhost.focus();
			return false;
		}
		if(o.dbuser.value == ""){
			alert("<?php echo __('js_dbuser') ?>");
			o.dbuser.focus();
			return false;
		}
		if(o.dbpasswd.value == ""){
			if(!confirm('<?php echo __('js_dbpasswd') ?>')){
				o.dbpasswd.focus();
				return false;
			}
		}
		o.s1.disabled = true;
		return true;
	}
	</script>
    <p>&nbsp;</p>
    <p><?php echo __('database_tips_info') ?></p>
    <hr noshade="noshade" />
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" name="s1" type="submit" value="<?php echo __('next_step') ?>" />
    </p>
<?php 
}
} elseif ($step == 4) {
	$dbhost = trim(gpc('dbhost','P','',1));
	$dbuser = trim(gpc('dbuser','P','',1));
	$dbpasswd = trim(gpc('dbpasswd','P','',1));
	
	if(!$dbhost || !$dbuser){

?>
    <p><?php echo __('fill_all_blank') ?></p>
    <hr noshade="noshade" />
    <p align="right">
      <input class="formbutton" type="button" value="<?php echo __('prev_step') ?>" onclick="history.back(1)" />
    </p>
<?php
	} else {
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('install_database') ?></p>
<?php
if(!function_exists('mysql_close')){
	exit(__('mysql_not_support'));
}	
$list_db = 0;

require_once PHPDISK_ROOT.'includes/class/mysql.class.php';

$db = new cls_mysql;
$db->connect($dbhost,$dbuser,$dbpasswd);

$q = $db->query("show databases;",'SILENT');
if($q){
	$list_db = 1;
	$db_list = array();
	while($rs = $db->fetch_array($q)){
		$db_list[] = $rs;
	}
	$db->free($q);
	unset($rs);
}
?>
    <hr noshade="noshade" />
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td colspan="2" class="bold"><?php echo __('database_info') ?></td>
      </tr>
	  <tr>
	  	<td colspan="2"><span class="txtred"><?php echo __('fill_db_tips') ?></span></td>
	  </tr>
	  <tr>
	  	<td colspan="2"><span class="txtred"><?php echo __('no_script_tips') ?></span></td>
	  </tr>
      <tr>
        <td width="20%"><?php echo __('dbname') ?>:</td>
        <td><input type="radio" id="rd1" name="rd" onclick="chg_db(1);" checked="checked" />
		<input type="text" value="phpdisk" name="dbname1" id="dbname1" class="formfield" style="width:150px" onclick="this.value='';"></td>
      </tr>
      <?php
      if($list_db){
      ?>
	  <tr>
	  	<td></td>
		<td><input type="radio" id="rd2" name="rd" onclick="chg_db(2);" />
		<select name="dbname2" id="dbname2">
		<option value="0"><?php echo __('please_select') ?></option>
		<?php
		sort($db_list);
		foreach($db_list as $k => $v){
			echo '<option value="'.$db_list[$k]['Database'].'">'.$db_list[$k]['Database'].'</option>';
		}
		?>
		</select>
		</td>
	  </tr>
	  <?php
      }
	  ?>
    </table>
	<br />
    <hr noshade="noshade" />
    <p align="right">
	  <input type="hidden" name="dbhost" value="<?php echo $dbhost ?>"	 />
	  <input type="hidden" name="dbuser" value="<?php echo $dbuser ?>" />
	  <input type="hidden" name="dbpasswd" value="<?php echo $dbpasswd ?>" />
	  <input type="hidden" name="dbname" id="dbname" value="" />
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" name="s1" type="submit" value="<?php echo __('next_step') ?>" />
    </p>
	<script type="text/javascript">
	function g(id){
		return document.getElementById(id);
	}
	function chg_db(id){
		if(id==1){
			g('dbname1').disabled = false;
			g('dbname2').disabled = true;
		}else{
			g('dbname1').disabled = true;
			g('dbname2').disabled = false;
		}
	}
	function chksubmit(o){
		if(g('rd2').checked==true){
			if(o.dbname2.value ==0){
				alert("<?php echo __('dbname2_null') ?>");
				o.dbname2.focus();
				return false;
			}else{
				o.dbname.value = o.dbname2.value;
			}
		}else{
			if(o.dbname1.value ==''){
				alert("<?php echo __('dbname1_null') ?>");
				o.dbname1.focus();
				return false;
			}else{
				o.dbname.value = o.dbname1.value;
			}
		}
	}
	g('dbname2').disabled = true;
	</script>
<?php
	}
} elseif ($step == 5) {
	$dbname = trim(gpc('dbname','P','',1));
	$dbhost = trim(gpc('dbhost','P','',1));
	$dbuser = trim(gpc('dbuser','P','',1));
	$dbpasswd = trim(gpc('dbpasswd','P','',1));

	if(!$dbname || !$dbhost || !$dbuser || !$dbpasswd){

?>
    <p><?php echo __('fill_all_blank') ?></p>
    <hr noshade="noshade" />
    <p align="right">
      <input class="formbutton" type="button" value="<?php echo __('prev_step') ?>" onclick="history.back(1)" />
    </p>
<?php
	} else {
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('set_admin_account') ?></p>
<?php

$_l = mysql_connect($dbhost,$dbuser,$dbpasswd) or die(__('could_not_connect'). mysql_error());
if(!mysql_select_db($dbname,$_l)){
	mysql_query("create database `{$dbname}`;") or die(__('invalid_query') . mysql_error());
}
@mysql_close($_l);

if(is_writable($config_file)) {

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF.LF;
	$str .= "\$configs = array(".LF.LF;
	$str .= "\t'dbhost' => '$dbhost',".LF.LF;
	$str .= "\t'dbname' => '$dbname',".LF.LF;
	$str .= "\t'dbuser' => '$dbuser',".LF.LF;
	$str .= "\t'dbpasswd' => '$dbpasswd',".LF.LF;
	$str .= "\t'pconnect' => 0,".LF.LF;
	$str .= "\t'tpf' => 'pd_',".LF.LF;
	$str .= "\t'charset' => '$charset',".LF.LF;
	$str .= "\t'debug' => '0',".LF.LF;
	$str .= ");".LF.LF;
	$str .= "define('ADMINCP','admincp');".LF;
	$str .= "?>".LF;
	

	$fp = fopen($config_file,'w');
	if (!$fp) {
		exit("Can not open file <b>$config_file</b> .");
	}
	if(is_writable($config_file)){
		if(@fwrite($fp,$str)){
			$msg .= "<font color=blue>{$config_file} ".__('write_success')."</font>";
		}else{
			$msg .= "<font color=red>{$config_file} ".__('write_failture')."</font>";
			$flag = true;
		}
		@fclose($fp);
	}else{
		$msg .= "<font color=red>{$config_file} ".__('cant_write')."</font>";
		$flag = true;
	}
	echo $msg;
	if($flag){
		exit;
	}
}

require_once $config_file;
require_once PHPDISK_ROOT.'includes/class/mysql.class.php';
$db = new cls_mysql;

$db->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
$tpf = $configs['tpf'];

$msg = '';
$error = false;
$curr_os = PHP_OS;
$curr_php_version = PHP_VERSION;
if($curr_php_version < '4.0.6') {
	$msg .= "<font color=\"#FF0000\">".__('php_version_too_lower')."</font><br />";
	$error = true;
}

$query = $db->query("SELECT VERSION()");
$curr_mysql_version = $db->result($query, 0);
if($curr_mysql_version < '4.1') {
	$msg .= "<font color=\"#FF0000\">".__('mysql_version_too_lower')."</font><br />";
	$error = true;
}

$db->select_db($configs['dbname']);
if($db->get_error()) {
	if($db->get_error()) {
		$msg .= "<font color=\"#FF0000\">".__('database_not_found')."</font><br />";
		$error = true;
	} else {
		$db->select_db($configs['dbname']);
		$msg .= __('database_create_success')."<br />";
	}
}

$db->query("SELECT COUNT(*) FROM {$tpf}users ", 'SILENT');
if(!$db->get_error()) {
	$msg .= "<font color=\"#FF0000\">".__('database_already_exists')."</font><br />";
	$alert = " onclick=\"return confirm('".__('database_confirm')."');\"";
} else {
	$alert = '';
}

if($error) {
	$msg .= "<font color=\"#FF0000\">".__('file_not_chmod')."</font>";
} else {
	$msg .= __('server_env_ok');
}
if ($msg) {
	echo "<p>".$msg."</p>";
}
if($error) {
?>
    <p align="right">
      <input type="button" class="formbutton" value="<?php echo __('quit') ?>" onclick="javascript: window.close();">
    </p>
<?php
} else {
?>
    <p>&nbsp;</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="30%" nowrap><?php echo __('username') ?>:</td>
        <td><input type="text" value="" name="username" class="formfield" style="width:150px"></td>
      </tr>
      <tr>
        <td width="30%" nowrap><?php echo __('password') ?>:</td>
        <td><input type="password" value="" name="password" class="formfield" style="width:150px"></td>
      </tr>
      <tr>
        <td width="30%" nowrap><?php echo __('confirm_password') ?>:</td>
        <td><input type="password" value="" name="confirmpassword" class="formfield" style="width:150px"></td>
      </tr>
      <tr>
        <td width="30%" nowrap><?php echo __('email') ?>:</td>
        <td><input type="text" value="" name="email" class="formfield" style="width:150px"></td>
      </tr>
    </table>
	<script language="JavaScript" type="text/javascript">
	document.myform.username.focus();
	function chksubmit(o){
		if(o.username.value == ""){
			alert("<?php echo __('js_username') ?>");
			o.username.focus();
			return false;
		}
		if(o.password.value == ""){
			alert("<?php echo __('js_password') ?>");
			o.password.focus();
			return false;
		}
		if(o.password.value.length <6){
			alert("<?php echo __('js_password_too_short') ?>");
			o.password.focus();
			return false;
		}
		if(o.password.value != o.confirmpassword.value){
			alert("<?php echo __('js_confirm_password') ?>");
			o.confirmpassword.focus();
			return false;
		}
		if(o.email.value == "" || o.email.value.indexOf('@') ==-1 || o.email.value.indexOf('.') ==-1){
			alert("<?php echo __('js_email') ?>");
			o.email.focus();
			return false;
		}
		o.s1.disabled = true;
		return true;
	}
	</script>
    <p>&nbsp;</p>
    <hr noshade="noshade" />
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" name="s1" type="submit" value="<?php echo __('next_step') ?>" <?php echo $alert;?> />
    </p>
<?php
}
	}
} elseif ($step == 6) {
	
	$username = trim(gpc('username','P','',1));
	$password = trim(gpc('password','P','',1));
	$confirmpassword = trim(gpc('confirmpassword','P','',1));
	$email = trim(gpc('email','P','',1));
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('check_user_info') ?></p>
<?php
if (!$username || !$password || !$confirmpassword || !$email) {
	$msg = "<p>".__('fill_all_blank')."</p>";
	$error = true;
} elseif (strlen($password) < 6) {
	$msg = "<p>".__('s_password_too_short')."</p>";
	$error = true;
} elseif ($password != $confirmpassword) {
	$msg = "<p>".__('s_password_not_same')."</p>";
	$error = true;
} elseif (strlen($email) <6 || strpos($email,'@') ===false){
	$msg = "<p>".__('s_email')."</p>";
	$error = false;
} else {
	$msg = "<p>".__('s_check_server_env')."</p>";
	$error = false;
}
$name_key = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#','$','(',')','%','@','+','?',';','^');
foreach($name_key as $value){
	if (strpos($username,$value) !== false){
		$msg = "<p>".__('bad_chars')."</p>";
		$error = true;
	}
}
if ($error) {
	echo $msg;
?>
    <hr noshade="noshade" />
    <p align="right">
      <input class="formbutton" type="button" value="<?php echo __('prev_step') ?>" onclick="history.back(1)" />
    </p>
<?php
} else {
	echo $msg;
?>
    <p>&nbsp;</p>
    <p><?php echo __('username') ?>: <?php echo $username;?><input type="hidden" name="username" value="<?php echo $username;?>" /></p>
    <p><?php echo __('password') ?>: <?php echo $password;?><input type="hidden" name="password" value="<?php echo $password;?>" /></p>
    <p><?php echo __('email') ?>: <?php echo $email;?><input type="hidden" name="email" value="<?php echo $email;?>" /></p>
    <p>&nbsp;</p>
    <p><?php echo __('user_info_right') ?></p>
    <hr noshade="noshade" />
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" type="submit" value="<?php echo __('next_step') ?>" />
    </p>
<?php
}
} elseif ($step == 7) {
	$username = trim(gpc('username','P','',1));
	$password = trim(gpc('password','P','',1));
	$email = trim(gpc('email','P','',1));
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('import_data') ?></p>
	<p>
<?php
require_once $config_file;
require_once PHPDISK_ROOT.'includes/class/mysql.class.php';

$db = new cls_mysql;
$db->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
$tpf = $configs['tpf'];

$sql = preg_replace("/\-\-.*[\r\n]+/i","",trim($sql));
runquery($sql);

$ins = array(
'username' => $username,
'password' => md5($password),
'email' => $email,
'gid' => 1,
'reg_time' => time(),
'reg_ip' => $db->escape($_SERVER['REMOTE_ADDR']),
);
$db->query("insert into {$tpf}users set ".$db->sql_array($ins).";");
$_SESSION[contact_us] = $email;
?>
    </p>
    <p><?php echo __('all_create') ?><?php echo $tablenum;?> <?php echo __('tables') ?>.</p>
    <hr noshade="noshade" />
    <p><?php echo __('base_settings') ?>：</p>
	<?php 
	$arr = explode('install',$_SERVER['REQUEST_URI']);
	$port = $_SERVER['SERVER_PORT']=='80' ? '' : ':'.$_SERVER['SERVER_PORT'];
	$phpdisk_url = 'http://'.$_SERVER['SERVER_NAME'].$port.$arr[0];
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="15%" nowrap><?php echo __('site_title') ?>:</td>
        <td><input type="text" value="<?php echo __('project_name') ?>" name="site_title" class="formfield" style="width:200px" maxlength="50"></td>
      </tr>
      <tr>
        <td width="15%" nowrap><?php echo __('phpdisk_url') ?>:</td>
        <td><input type="text" value="<?php echo $phpdisk_url; ?>" name="phpdisk_url" class="formfield" style="width:300px" maxlength="50"> <?php echo __('phpdisk_url_tips') ?></td>
      </tr>
      <tr>
        <td width="15%" nowrap><?php echo __('encrypt_key') ?>:</td>
        <td><input type="text" id="encrypt_key" name="encrypt_key" value="" class="formfield" maxlength="16"/>&nbsp;<a href="###" onclick="make_key();"><?php echo __('reflash_key') ?></a></td>
      </tr>
      <tr>
        <td width="15%" nowrap>联系邮箱:</td>
        <td><input type="text" id="contact_us" name="contact_us" value="<?php echo $_SESSION[contact_us]?>" class="formfield" maxlength="200"/>&nbsp;</td>
      </tr>      
      <tr>
        <td width="15%" nowrap><?php echo __('open_gzip') ?>:</td>
        <td>
        <? if(function_exists('ob_gzhandler')){?>
        <input type="radio" name="gzipcompress" value="1" checked="checked" /><?php echo __('yes') ?>
		<input type="radio" name="gzipcompress" value="0" /><?php echo __('no') ?>
		<? }else{?>
		<span class="txtred"><?php __('gzipcompress_not_support') ?></span>
		<? }?>
		</td>
      </tr>
	</table>  
    <input type="hidden" name="username" value="<?php echo $username;?>" />
    <input type="hidden" name="password" value="<?php echo $password;?>" />
	<script language="javascript">
	make_key();
	function chksubmit(o){
		if(o.site_title.value == ""){
			alert("<?php echo __('js_site_title') ?>");
			o.site_title.focus();
			return false;
		}
		if(o.phpdisk_url.value == ""){
			alert("<?php echo __('js_phpdisk_url') ?>");
			o.phpdisk_url.focus();
			return false;
		}
		if(o.encrypt_key.value == ""){
			alert("<?php echo __('js_encrypt_key') ?>");
			o.encrypt_key.focus();
			return false;
		}
		if(o.contact_us.value == ""){
			alert("管理员联系邮箱不能为空");
			o.contact_us.focus();
			return false;
		}
	}
	function make_key(){
		var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var tmp = "";
		var code = "";
		for(var i=0;i<12;i++){
			code += chars.charAt(Math.ceil(Math.random()*100000000)%chars.length);
		}
		document.getElementById('encrypt_key').value = code;
	}
	</script>
    <p align="right">
      <input type="hidden" name="step" value="<?php echo $step+1 ?>" />
      <input class="formbutton" type="submit" value="<?php echo __('next_step') ?>" />
    </p>
<?php 
}elseif($step ==8){
	require_once $config_file;
	require_once PHPDISK_ROOT.'includes/class/mysql.class.php';

	$db = new cls_mysql;
	$db->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
	unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
	$tpf = $configs['tpf'];

	$site_title = trim(gpc('site_title','P','',1));
	$phpdisk_url = trim(gpc('phpdisk_url','P','',1));
	$gzipcompress = trim(gpc('gzipcompress','P','',1));
	$contact_us = trim(gpc('contact_us','P','',1));
	$encrypt_key = trim(gpc('encrypt_key','P','',1));
	$username = trim(gpc('username','P','',1));
	$password = trim(gpc('password','P','',1));

	if (!$site_title || !$phpdisk_url || !$encrypt_key) {
		$msg = "<p>".__('site_title_and_phpdisk_url')."</p>";
		$error = true;
	}

	if ($error) {
		echo $msg;
?>
    <hr noshade="noshade" />
    <p align="right">
      <input class="formbutton" type="button" value="<?php echo __('prev_step') ?>" onclick="javascript:history.back();" />
    </p>
<?php
	} else {
?>
    <p class="title"><?php echo __('the') ?>(<span class="txtblue"><?php echo $step ?></span>/<?php echo $total_step ?>)<?php echo __('step') ?>:<?php echo __('finished_install') ?></p>
	<p>
<?php	
$settings = array(
'site_title' => $site_title,
'phpdisk_url' => $phpdisk_url,
'gzipcompress' => (int)$gzipcompress,
'encrypt_key' => $encrypt_key,
'max_file_size' => 0,
'contact_us' => $contact_us,
);
$setting_file = PHPDISK_ROOT.'system/settings.inc.php';
$str = $str2 = '';
foreach($settings as $k => $v){
	$str2 .= "('$k','$v'),";
}
$str2 = substr($str2,0,-1);
$db->query("replace into {$tpf}settings(vars,value) values $str2 ;");

$q = $db->query("select * from {$tpf}settings");
while($rs = $db->fetch_array($q)){
	$str_c .= "\t'".$rs['vars']."' => '".$rs['value']."',".LF;
}
$db->free($q);
unset($rs);

$str = "<?php".LF.LF;
$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
$str .= "\$settings = array(".LF.LF;
$str .= $str_c;
$str .= ");".LF.LF;
$str .= "?>".LF;

$msg = '';
$fp = fopen($setting_file,'w');
if (!$fp) {
	exit("Can not open file <b>$setting_file</b> .");
}
if(is_writable($setting_file)){
	if(@fwrite($fp,$str)){
		$msg .= "<font color=blue>{$setting_file} ".__('write_success')."</font>";
	}else{
		$msg .= "<font color=red>{$setting_file} ".__('write_fail')."</font>";
		$flag = true;
	}
	@fclose($fp);
}else{
	$msg .= "<font color=red>{$setting_file} ".__('cannot_write')."</font>";
	$flag = true;
}
write_file(PHPDISK_ROOT.'system/install.lock','PHPDisk installed! Time:'.date("Y-m-d H:i:s"));
echo $msg;
if($flag){
	exit;
}
?>
    <hr noshade="noshade" />
    <p><?php echo __('finished_tips') ?></p>
	<p class="txtblue"><?php echo __('reinstall_tips') ?></p>
    <p><?php echo __('thanks') ?></p>
    <p>&nbsp;</p>
    <p><?php echo __('username') ?>: <?php echo $username;?></p>
    <p><?php echo __('password') ?>: <?php echo $password;?></p>
    <p>&nbsp;</p>
    <p><a href="../"><?php echo __('visit_phpdisk') ?></a></p>
    <hr noshade="noshade" />
    <p align="right"><a href="http://www.phpdisk.com/" target="_blank"><?php echo __('phpdisk_official_site') ?></a></p>
<?php
	}
}
@unlink($setting_file);
?>
  </form>
</div>
<strong>Powered by <a href="http://www.phpdisk.com/" target="_blank">PHPDisk Team</a> <?php echo PHPDISK_VERSION .' '. PHPDISK_EDITION?> (C) 2008-<?php echo NOW_YEAR ?> All Rights Reserved.</strong>
</body>
</html>
<?php

function output_txt($output_txt = 1, $output = 1) {
	if($output_txt) {
		$text = '... <font color="#0000EE">Yes</font><br />';
		if(!$output) {
			return $text;
		}
		echo $text;
	} else {
		$text = '... <font color="#FF0000">No</font><br />';
		if(!$output) {
			return $text;
		}
		echo $text;
	}
}

function runquery($sql) {
	global $db, $tablenum;

	$sql = str_replace("\r", "\n", $sql);

	foreach(explode(";\n", trim($sql)) as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 26) == 'CREATE TABLE IF NOT EXISTS') {
				$name = preg_replace("/CREATE TABLE IF NOT EXISTS `([a-z0-9_]+)` .*/is", "\\1", $query);
				echo __('create_table').' '.$name.' ... <font color="#0000EE">'.__('success').'</font><br />';
				$db->query($query);
				$tablenum++;
			} else {
				$db->query($query);
			}
		}
	}
}
function write_file($f,$str,$mode = 'wb') {
	$fp = fopen($f,$mode);
	if (!$fp) {
		exit("Can not open file <b>$f</b> .code:1");
	}
	if(is_writable($f)){
		if(!fwrite($fp,$str)){
			exit("Can not write file <b>$f</b> .code:2");
		}
	}else{
		exit("Can not write file <b>$f</b> .code:3");
	}
	fclose($fp);
}
function read_file($f) {
	if (file_exists($f)) {
		if (PHP_VERSION >= "4.3.0") return file_get_contents($f);
		$fp = fopen($f,"r");
		$fsize = filesize($f);
		$c = fread($fp, $fsize);
		fclose($fp);
		return $c;
	} else{
		exit("<b>$f</b> does not exist!");
	}
}
function dir_writeable($dir) {
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/phpdisk.test", 'w')) {
			@fclose($fp);
			@unlink("$dir/phpdisk.test");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}



?>