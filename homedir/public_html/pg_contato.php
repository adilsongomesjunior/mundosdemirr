<?php if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { header('Location: blog.php?pg='.substr(basename(__FILE__), 3, -4)); die(); }
if(!isset($com_titulo) || $com_titulo != false) {
	echo "			<h2>Contato</h2>\n";
	echo '			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />'."\n";
	echo "			<br />";
}


$to = 'contato@mundosdemirr.com';
$subject = '[MundosDeMirr.com] Contato';


$msg = array('');

$_POST['nome']     = ( !empty($_POST['nome']    ) ? $_POST['nome']     : '' );
$_POST['email']    = ( !empty($_POST['email']   ) ? $_POST['email']    : '' );
$_POST['mensagem'] = ( !empty($_POST['mensagem']) ? $_POST['mensagem'] : '' );

if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	$_POST['nome']     = stripslashes($_POST['nome']    );
	$_POST['email']    = stripslashes($_POST['email']   );
	$_POST['mensagem'] = stripslashes($_POST['mensagem']);
}

if(!empty($_POST['nome']    )
&& !empty($_POST['mensagem'])
) {
	$head = "Content-type: text/html; charset=iso-8859-1\r\n";
	$head.= "From: contato@mundosdemirr.com\r\n";
	if(preg_match('/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i', $_POST['email'])) {
		$head.= 'Reply-to: '.$_POST['email']."\r\n";
	}

	$body = '<html><body>'."\n";
	$body.= '<div style="background:#FFF;color:#000;font-family:Georgia,Times,Times New Roman,sans-serif;font-size:9pt;">'."\n";
	$body.= '<b>Nome: </b>'.htmlentities($_POST['nome']).'<br />'."\n";
	$body.= '<br />'."\n";
	$body.= '<b>Email: </b>'.htmlentities($_POST['email']).'<br />'."\n";
	$body.= '<br />'."\n";
	$body.= nl2br(trim(htmlentities($_POST['mensagem'])))."\n";
	$body.= '<hr />'."\n";
	$body.= 'IP: '.$_SERVER['REMOTE_ADDR'].'<br />'."\n";
	$body.= 'Data: '.date('d/m/Y H:i')."\n";
	$body.= '</div>'."\n";
	$body.= '</body></html>'."\n";

	ob_start();
	if(mail($to, $subject, $body, $head)) {
		$msg = array();
	} else {
		$msg[] = 'Não foi possível enviar sua mensagem, tente novamente mais tarde.';
	}
	$error = ob_get_clean();
	if(!empty($error)) {
		echo "<!--\n".trim(strip_tags($error))."\n-->";
	}
}

if(count($msg) > 0) {
	unset($msg[0]);
	if(count($msg) > 0) {
		echo "			<ul>\n";
		foreach($msg as $m) echo '				<li>'.htmlentities($m)."</li>\n";
		echo "			</ul>\n";
	}
?>
			<p>Atrav&eacute;s deste canal voc&ecirc; poder&aacute; me contatar com suas d&uacute;vidas, cr&iacute;ticas e sugest&otilde;es. Pe&ccedil;o para que sempre deixe seu endere&ccedil;o de e-mail para que possa retornar o contato. Todas as mensagens ser&atilde;o respondidas.</p>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<table border="0" cellpadding="0" cellspacing="0" width="545">
					<tr>
						<td width="10" rowspan="5">&nbsp;</td>
						<td>&nbsp;</td>
						<td>(<b style="color:red">*</b>) Campos obrigat&oacute;rios</td>
						<td width="10" rowspan="5">&nbsp;</td>
					</tr>
					<tr>
						<td align="right">(<b style="color:red">*</b>)&nbsp;<b>Nome:&nbsp;</b></td>
						<td align="left"><input type="text" name="nome" value="<?=htmlentities($_POST['nome'])?>" size="40" maxlength="80" style="width:100%" /></td>
						<td width="10" rowspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td align="right"><b>Email:&nbsp;</b></td>
						<td align="left"><input type="text" name="email" value="<?=htmlentities($_POST['email'])?>" size="40" maxlength="80" style="width:100%" /></td>
					</tr>
					<tr>
						<td align="right" valign="top" width="1%">(<b style="color:red">*</b>)&nbsp;<b>Mensagem:&nbsp;</b></td>
						<td align="left"><textarea name="mensagem" rows="6" cols="40" style="width:100%"><?=nl2br(trim(htmlentities($_POST['mensagem'])))?></textarea></td>
					</tr>
					<tr>
						<td align="right">&nbsp;</td>
						<td align="left"><input type="submit" value="Enviar" /></td>
					</tr>
				</table>
			</form>
<?php
} else {
	echo "			Sua mensagem foi enviada com sucesso!<br />\n";
	echo "			<br />\n";
	echo "			Obrigado por entrar em contato.\n";
}
?>