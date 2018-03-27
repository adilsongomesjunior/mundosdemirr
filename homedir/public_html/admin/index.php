<?php
header('Content-type: text/html; charset=iso-8859-1');

session_start();
if(!isset($_SESSION['ok'])) $_SESSION['ok'] = false;
$ok = $_SESSION['ok'];

$GLOBALS['meses'] = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 
'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$GLOBALS['dias_da_semana'] = array('Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 
'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'S&aacute;bado');

echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt_BR">

<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="estilos.css" />
	<script type="text/javascript">
	<!-- //
	function popup(url, width, height)
	{
		url+= ( url.indexOf("?") == -1 ? "?" : "&" ) + "<?=session_name().'='.session_id()?>";
		var x = window.open(url, "popup", "width=" + width + ",height=" + height);
		return (x == false || x == null);
	}
	function album_foto(href, target)
	{
		var target = ( document.getElementById ? document.getElementById(target) : null );
		if(target == null) return false;
		target.innerHTML = '<img src="' + href + '" />';
		return true;
	}
	// -->
	</script>
</head>

<body>
<?=( $ok ? '<div id="exit">[<a href="login.php"><b>Sair</b></a>]</div>'."\n" : '' )?>	<div id="head"><h1>Admin</h1></div>
<?php
if($ok) {
	$modulos = glob('*.m.php');
	if(is_array($modulos) && count($modulos) > 0) {
		echo '<div id="menu">'."\n";
		echo "	<ul>\n";
		foreach($modulos as $modulo) {
			$m        = substr($modulo, 0, -6);
			$html[$m] = file_get_contents($modulo);
			if(ereg('<title[^>]*>([^<]+)</title>', $html[$m], $matches)) {
				$titulo = $matches[1];
			} else {
				$titulo = $m;
			}
			if(ereg('<body[^>]*>(.+)</body>', $html[$m], $matches)) {
				$html[$m] = $matches[1];
			}
			echo '<li><a href="index.php?m='.$m.'">'.$titulo.'</a></li>';
		}
		echo "</ul><br /></div>\n";
		echo '<br style="clear:left" />'."\n";
		echo '<div id="content">'."\n";
		if(!empty($_GET['m']) && in_array($_GET['m'].'.m.php', $modulos)) {
			require_once('../mysql_connect.php');
			eval('?>'.trim($html[$_GET['m']]));
		} else {
			echo "&nbsp;\n";
		}
		echo "</div>\n";
	} else {
		echo "<i>no modules</i>\n";
	}
} else {
?>
<form action="login.php" method="post">
	<code>
		<b>User:</b> <input type="text"     name="user" value="" style="width:167px;" /><br />
		<b>Pass:</b> <input type="password" name="pass" value="" style="width:167px;" /><br />
		&nbsp; &nbsp; &nbsp; <input type="submit" value="Enter" />
	</code>
</form>
<?php
}
?>
	<div id="foot">Admin v.0.0.1a</div>
</body>

</html>