<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

// This file was the current value of auto_prepend_file during the Wordfence WAF installation (Sun, 02 Feb 2020 16:59:45 +0000)
if (file_exists('/var/www/hc/wordfence-waf.php')) {
	include_once '/var/www/hc/wordfence-waf.php';
}
if (file_exists('/var/www/hc/wp-content/plugins/wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", '/var/www/hc/wp-content/wflogs/');
	include_once '/var/www/hc/wp-content/plugins/wordfence/waf/bootstrap.php';
}
?>