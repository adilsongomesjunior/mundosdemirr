<?php
error_reporting(E_ALL);

header('Content-Type: text/html; charset=iso-8859-1');

$GLOBALS['meses'] = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 
'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$GLOBALS['dias_da_semana'] = array('Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 
'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'S&aacute;bado');

echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt_BR">

<head>
	<title>Mundos de Mirr - Coment&aacute;rios</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<style type="text/css">
	<!--
	BODY {
		margin: 0;
		background: url("bg_paper_mid.jpg") repeat-y center #FFF;
		color: #000;
	}
	BODY, TH, TD, INPUT, SELECT, TEXTAREA {
		font-family: Georgia, Times, Times New Roman, sans-serif;
		font-size: 9pt;
	}
	A {
		color: #008;
		text-decoration: none;
	}
	IMG {
		border: 0;
	}
	H3 {
		display: block;
		width: auto;
		height: 30px;
		margin: 5px 5px 0;
		padding: 3px 0 0 35px;
		background: url("icon.gif") no-repeat left top;
		font-size: 14pt;
	}
	H3 A {
		color: #000;
	}
	HR {
		border-color: #000;
	}
	BLOCKQUOTE {
		margin: 0 5px 5px;
		text-align: justify;
	}
	.alert {
		margin: 0 5px 5px;
		text-align: justify;
		color: #C00;
		text-align: center;
	}
	TEXTAREA {
		width: 99%;
	}
	#main {
	}
	-->
	</style>
<head>

<body>
	<div id="main">
<?php
if(!empty($_GET['id']) && ereg('^[0-9]+$', $_GET['id'])) {
	require_once('mysql_connect.php');

	$result = mysql_query('SELECT url, titulo FROM post WHERE id = '.$_GET['id']) or mysql_die();
	if(list($url, $titulo) = mysql_fetch_row($result)) {
		echo '<h3><a href="/'.$url.'" onclick="if(window.opener){window.opener.document.location.href=this.href;window.opener.focus();return false;}" target="_BLANK">'.$titulo."</a></h3>\n";
		echo '<hr size="1" noshadow="noshadow" />'."\n";

		$_POST['vazio']      = htmlentities( isset($_POST['vazio']     ) ? $_POST['vazio']      : '.' );
		$_POST['nome']       = htmlentities( isset($_POST['nome']      ) ? $_POST['nome']       : '' );
		$_POST['email']      = htmlentities( isset($_POST['email']     ) ? $_POST['email']      : '' );
		$_POST['comentario'] = htmlentities( isset($_POST['comentario']) ? $_POST['comentario'] : '' );
		if(get_magic_quotes_gpc()) {
			$_POST['vazio']      = stripslashes($_POST['vazio']);
			$_POST['nome']       = stripslashes($_POST['nome']);
			$_POST['email']      = stripslashes($_POST['email']);
			$_POST['comentario'] = stripslashes($_POST['comentario']);
		}
		if($_POST['vazio'] == '' && !empty($_POST['nome']) && !empty($_POST['comentario'])) {
			mysql_query('INSERT INTO comment (post_id, ip, data, nome, email, texto) VALUES ('.$_GET['id'].', "'.$_SERVER['REMOTE_ADDR'].'", "'.date('Y-m-d H:i:s').'", "'.addslashes($_POST['nome']).'", "'.addslashes($_POST['email']).'", "'.addslashes($_POST['comentario']).'")') or mysql_die();
			if(mysql_affected_rows() > 0) {
				echo '<div class="alert">'."\n";
				echo '	Seu coment&aacute;rio foi enviado com sucesso!<br /><br />Assim que for aprovado, seu coment&aacute;rio estar&aacute; vis&iacute;vel.'."\n";
				echo "</div>\n";
				echo '<hr size="1" noshadow="noshadow" />'."\n";
				$_POST['comentario'] = '';
			}
		}

		$result2 = mysql_query('SELECT COUNT(*) FROM comment WHERE post_id = '.$id.' AND aprovado != "1"') or mysql_die();
		list($quant) = mysql_fetch_row($result2);
		if($quant > 0) {
			echo "<blockquote>\n";
			echo '	'.$quant.' coment&aacute;rio'.( $quant == 1 ? '' : 's' )." esperando autoriza&ccedil;&atilde;o.<br />\n";
			echo "	<br />\n";
			echo "</blockquote>\n";
		}

		$result2 = mysql_query('SELECT nome, UNIX_TIMESTAMP(data), texto FROM comment WHERE post_id = '.$_GET['id'].' AND aprovado = "1" ORDER BY data DESC') or mysql_die();
		if(mysql_num_rows($result2) > 0) {
			echo "<blockquote>\n";
			echo "	<br />\n";
			while(list($nome, $data, $texto) = mysql_fetch_row($result2)) {
				echo '	<b>'.$nome."</b><br />\n";
				echo '	<small>'.$GLOBALS['dias_da_semana'][date('w', $data)].date(', d \\d\\e ', $data).$GLOBALS['meses'][intval(date('m', $data))].date(' \\d\\e Y', $data)."<br /></small>\n";
				echo '	<div>'.$texto."</div>\n";
				echo "	<br />\n";
			}
			echo "</blockquote>\n";
			echo '<hr size="1" noshadow="noshadow" />'."\n";
		}
		echo "<blockquote>\n";
		echo '	<form action="'.$_SERVER['REQUEST_URI'].'" method="post">'."\n";
		echo '		<div style="display:none;"><b>N&atilde;o preencha este campo:</b> <input type="text" name="vazio" value=" " size="20" maxlength="25" id="vazio" /><br /></div>'."\n";
		echo '		<b>Nome:</b> <input type="text" name="nome" value="'.$_POST['nome'].'" size="20" maxlength="25" /><br />'."\n";
		echo '		<b>Email:</b> <input type="text" name="email" value="'.$_POST['email'].'" size="20" maxlength="25" /> (Opcional. Seu e-mail não ficará visível para outros usuários)<br />'."\n";
		echo "		<b>Coment&aacute;rio:</b><br />\n";
		echo '		<textarea name="comentario" rows="5" cols="40">'.$_POST['comentario'].'</textarea><br />'."\n";
		echo '		<input type="submit" value="Enviar" /><br />'."\n";
		echo "	</form>\n";
		echo "</blockquote>\n";
		echo '<script type="text/javascript">'."\n";
		echo "<!--\n";
		echo 'var obj = ( document.getElementById ? document.getElementById("vazio") : null );'."\n";
		echo "if(obj != null) {\n";
		echo '	obj.value = "";'."\n";
		echo "}\n";
		echo "//-->\n";
		echo "</script>\n";
	} else {
		echo "<i>??</i>";
	}
} else {
	echo "<i>?</i>";
}
?>
	</div>
</body>

</html>