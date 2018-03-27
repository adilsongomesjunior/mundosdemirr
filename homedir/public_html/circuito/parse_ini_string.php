<?php
if(!function_exists('parse_ini_string')) {
	function parse_ini_string($ini, $process_sections = true)
	{
		$lines   = explode("\n", $ini);
		$ret     = Array();
		$section = false;
		foreach($lines as $line) {
			$line = trim($line);
			if(!$line || $line[0] == '#' || $line[0] == ';') continue;
			if($line[0] == '[' && $pos = strpos($line, ']')) {
				$section = substr($line, 1, $pos - 1);
				continue;
			}
			if(!strpos($line, '=')) continue;
			$tmp = explode('=', $line, 2);
			$tmp[0] = trim($tmp[0]);
			$tmp[1] = trim($tmp[1]);
			$array  = (substr($tmp[0], -2) == '[]');
			if($array) $tmp[0] = substr($tmp[0], 0, -2);
			if($process_sections && $section) {
				if($array) {
					$ret[$section][$tmp[0]][] = $tmp[1];
				} else {
					$ret[$section][$tmp[0]]   = $tmp[1];
				}
			} else {
				if($array) {
					$ret[$tmp[0]][] = $tmp[1];
				} else {
					$ret[$tmp[0]]   = $tmp[1];
				}
			}
		}
		return $ret;
	}
}
