<html>
<body>
<code>
<?php

require('../mysql_connect.php');

$result = mysql_query('SELECT id, titulo FROM post2 WHERE url = ""') or mysql_die();
while((list($id, $titulo) = mysql_fetch_row($result)) !== false) {
	$url = strtolower(str_flat($titulo));

	echo '<b>T&iacute;tulo:</b> '.$titulo."<br />\n";
	echo '<b>URL&nbsp;&nbsp;&nbsp;:</b> '.$url."<br />\n";

	$result2 = mysql_query('SELECT COUNT(*) FROM post2 WHERE url = "'.$url.'"') or mysql_die();
	list($quant1) = mysql_fetch_row($result2);

	$result2 = mysql_query('SELECT COUNT(*) FROM post WHERE url = "'.$url.'"') or mysql_die();
	list($quant2) = mysql_fetch_row($result2);

	$quant = $quant1 + $quant2;

	if($quant == 0) {
		mysql_query('UPDATE post2 SET url = "'.$url.'" WHERE id = '.$id) or mysql_die();
		if(mysql_affected_rows() > 0) {
			echo '<b>OK</b>';
		} else {
			echo 'N&atilde;o foi poss&iacute;vel atualizar a URL.';
		}
	} else {
		echo 'URL j&aacute; existente, modifique o t&iacute;tulo.';
	}
	echo "<br />\n";
	echo "<hr />\n";
}

?>
Done!
</code>
</body>
</html>