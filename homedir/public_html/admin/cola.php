<?php
header('Content-type: text/html; charset=iso-8859-1');

if(isset($_GET[session_name()])) session_id($_GET[session_name()]);

session_start();
if(!isset($_SESSION['ok'])) $_SESSION['ok'] = false;
$ok = $_SESSION['ok'];

//echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt_BR">

<head>
	<title>Mundos de Mirr - Cola</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="estilos.css" />
<head>

<body>
<?php if($ok) { ?>

<b style="font-size:16pt;float:right;">Cola</b><br />

<br /><br />[i]<i>it&aacute;lico</i>[/i]
<br /><br />[b]<b>negrito</b>[/b]
<br /><br />[link]http://www.mundosdemirr.com[/link]
<br /><br />[link=http://www.mundosdemirr.com]Mundos de Mirr[/link]
<br /><br />[img=foto1.jpg] (sendo que a foto deve estar em /public_html/imagens/)
<br />200 x 300

<?php } else echo 'Colou?'; ?>
</body>

</html>