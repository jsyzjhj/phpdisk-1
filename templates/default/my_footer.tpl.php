<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: my_footer.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($inner_box){#-->
</body>
</html>
<!--#}else{#-->
<br/><br/>
<div style="border-bottom:1px #ccc solid">&nbsp;</div>
<br/>
<div align="center" class="f10 txtgray" style="display:{$debug_info}">{$pageinfo}</div>
<div align="center" class="f10 txtgray">Powered by <a href="http://www.phpdisk.com/" target="_blank">PHPDisk Team</a> <!--#if($settings['version_info']){#-->{PHPDISK_EDITION} {PHPDISK_VERSION}<!--#}#--> &copy; 2008-{NOW_YEAR} All Rights Reserved. <!--#include sub/block_license#-->{$site_stat}</div>

<br/><br/><br/>	
</body>
</html>
<!--#}#-->
