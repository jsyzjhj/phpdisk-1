<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_footer.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>

<!--#show_adv_data('adv_bottom');#-->
<div class="body_bottom">
<div class="nav_bottom">{$site_index}&nbsp;
<!--#include sub/block_navigation_bottom#-->
{$contact_us}&nbsp;{$miibeian}&nbsp;{$site_stat}&nbsp;
</div>

<!--#if($settings['debug_info']){#-->
<!--div class="debug_info">{$pageinfo}</div-->
<!--#}#-->
<div class="foot_info">
Powered by <a href="http://www.phpdisk.com/" target="_blank">PHPDisk Team</a> {PHPDISK_EDITION} {PHPDISK_VERSION} &copy; 2008-{NOW_YEAR} All Rights Reserved.<!--#include sub/block_license#--></div>

</div>
</body>
</html>