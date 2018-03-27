<?php
/* ------------------------------------------------------------------------- */
if(!function_exists('str_split')) {
	function str_split($str, $size = 1)
	{
		$array = false;

		if($size > 0) {
			$array = array();
			for($i = 0; $i < strlen($str); $i+= $size) {
				$array[] = substr($str, $i, $size);
			}
		}

		return $array;
	}
}
/* ------------------------------------------------------------------------- */
if(!function_exists('array_tr')) {
	function array_tr($array, $tr)
	{
		foreach($array as $key => $value) {
			if(isset($tr[$value])) {
				$array[$key] = $tr[$value];
			}
		}
		return $array;
	}
}
/* ------------------------------------------------------------------------- */
function js_die($msg)
{
	echo 'alert("'.addcslashes($msg, "\r\n\"").'");'."\n";
	die();
}
/* ------------------------------------------------------------------------- */

if(empty($_GET['id']) && !eregi('^[a-z][a-z0-9_]+$', $_GET['id'])) js_die("ID para contador inválido");

require_once('../mysql_connect.php');
$result = @mysql_query('SELECT valor FROM contador ORDER BY hora DESC LIMIT 1') or js_die(mysql_error());
if((list($n) = @mysql_fetch_row($result)) === false) $n = 12000;
$n = array_tr(str_split(number_format($n, 2, ',', '.')), array('.' => '"p"', ',' => '"v"'));
?>
function contador() {
	if(document.getElementById) {
		var obj = document.getElementById("<?=$_GET['id']?>");
		if(obj != null) {
			var n = new Array();
			n = [<?=implode(', ', $n)?>];
			width = 0;
			width+= 56;
			for(i = 0; i < n.length; i++) width+= ( isNaN(n[i]) ? 10 : 30 );
			width+= 21;
			var html = "";
			html = html + "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"" + width + "\" height=\"43\">\n";
			html = html + "	<tr>\n";
			html = html + "		<td><img src=\"http://www.turmaluka.com.br/paul/erre.gif\" width=\"56\" height=\"43\" border=\"0\" alt=\"\" /></td>\n";
			for(i = 0; i < n.length; i++) {
				html = html + "		<td><img src=\"http://www.turmaluka.com.br/paul/n" + n[i] + ".gif\" width=\"" + ( isNaN(n[i]) ? "10" : "30" ) + "\" height=\"43\" border=\"0\" alt=\"\" /></td>\n";
			}
			html = html + "		<td><img src=\"http://www.turmaluka.com.br/paul/fim.gif\" width=\"21\" height=\"43\" border=\"0\" alt=\"\" /></td>\n";
			html = html + "	</tr>\n";
			html = html + "</table>\n";
			obj.innerHTML = html;
		}
	}
}
contador();
<?php
?>