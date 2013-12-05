<?php import('core.util.RunFunc'); ?>
<?php
if (!defined('CAL_GREGORIAN')) {
	define('CAL_GREGORIAN', 1);
}
if (!function_exists('cal_days_in_month')) {
	function cal_days_in_month($calendar, $month, $year) {
		return date('t', mktime(0, 0, 0, $month, 1, $year));
	}
}
?>