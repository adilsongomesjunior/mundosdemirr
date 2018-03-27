<html>
<body>
<code>
<?php

require('../mysql_connect.php');

$result = mysql_query('SELECT id, titulo, url, data, texto FROM post2 WHERE url != ""') or mysql_die();
while((list($id, $titulo, $url, $data, $texto) = mysql_fetch_row($result)) !== false) {
	echo '<b>T&iacute;tulo:</b> '.$titulo."<br />\n";

	$titulo = addslashes($titulo);
	$texto  = addslashes($texto );

	mysql_query('INSERT INTO post (titulo, url, data, texto) VALUES ("'.$titulo.'", "'.$url.'", "'.$data.'", "'.$texto.'")') or print(mysql_error()."<br />\n");
	if(mysql_affected_rows() > 0) {
		echo '<b>Inserido com sussesso.</b>'."<br />\n";
		mysql_query('DELETE FROM post2 WHERE id = '.$id) or print(mysql_error()."<br />\n");
	}

	echo "<hr />\n";
}

?>
Done!
</code>
</body>
</html>