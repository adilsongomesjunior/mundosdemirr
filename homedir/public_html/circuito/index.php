<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once('parse_ini_string.php');
echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
	<title>Circuito Mirr</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="circuito.css" />
	<script type="text/javascript" src="circuito.js"></script>
</head>

<body>
	<div id="conteudo">
<?php
require_once('circuito.class.php');
$circuito = file_get_contents('circuito.txt');
$circuito = preg_replace('/data=([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})[\r\n]/', 'data[]=\1~\1', $circuito); // One day game
$circuito = preg_replace('/(data|jogo)=/'                               , '\1[]='       , $circuito); // Convert data/jogo to array
$c = new circuito(parse_ini_string($circuito));
$c->show('2012-07', '2012-12');
?>
		<img src="../p.gif" width="1" height="1" align="absmiddle" style="display:block;clear:both;" />
	</div>
</body>

</html>
