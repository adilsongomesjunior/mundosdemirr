<?php

if(!$fp_log) $fp_log = fopen('log/log_admin_'.date('Y_m_d').'.txt', 'ab');

if($fp_log) {
	$log = addcslashes($log, "\0..\37!@\177..\377");
	fwrite($fp_log, '['.date('Y-m-d H:i:s').' '.str_pad($_SERVER['REMOTE_ADDR'], 15).'] '.$log."\n");
} else {
	echo '<pre>';
	print_r(posix_getgrgid(filegroup('log')));
	print_r(posix_getpwuid(fileowner('log')));
	print_r(posix_getgrgid(getmygid()));
	print_r(posix_getpwuid(getmyuid()));
	print_r(posix_getgrgid(filegroup(__FILE__)));
	print_r(posix_getpwuid(fileowner(__FILE__)));
	echo '</pre>';
}
