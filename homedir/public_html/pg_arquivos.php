<?php if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { header('Location: blog.php?pg='.substr(basename(__FILE__), 3, -4)); die(); }

//echo '<div style="text-align:center;font-size:14pt;">Estamos com problemas técnicos no momento.<br /><br />Em breve tudo estará normalizado.</div>';
//return;

if(!empty($_GET['data']) && !ereg('^([0-9]{2,4})\-([0-9]{1,2})$', $_GET['data'], $matches_data)) unset($_GET['data']);
if(!empty($_GET['id'])   && !ereg('^[0-9]+$'                    , $_GET['id']                 )) unset($_GET['id']  );

if((!isset($com_titulo) || $com_titulo != false) && !isset($_GET['id'])) {
	echo "			<h2>Arquivos</h2>\n";
	echo '			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />'."\n";
	echo "			<br />";
}

if(!empty($_GET['data'])) {
	if($matches_data[1] <  10) $matches_data[1]+= 2000;
	if($matches_data[1] < 100) $matches_data[1]+= 1900;
	if($matches_data[2] <  10) $matches_data[2] = '0'.$matches_data[2];
	$data = $matches_data[1].'-'.$matches_data[2];
//	$query = 'SELECT post.id, post.url, post.titulo, UNIX_TIMESTAMP(post.data), post.texto, COUNT(*) FROM post, comment WHERE comment.post_id = post.id AND post.data <= NOW() AND DATE_FORMAT(post.data, "%Y-%m") = "'.$data.'" GROUP BY post.id ORDER BY post.data DESC';

	$query = '(';
	$query.= 'SELECT post.id, post.url, post.titulo, UNIX_TIMESTAMP(post.data), post.texto, COUNT(*) FROM post, comment WHERE comment.post_id = post.id AND post.data <= NOW() AND comment.aprovado = "1" AND DATE_FORMAT(post.data, "%Y-%m") = "'.$data.'" GROUP BY post.id';
	$query.= ') UNION (';
	$query.= 'SELECT post.id, post.url, post.titulo, UNIX_TIMESTAMP(post.data), post.texto, 0        FROM post LEFT JOIN comment ON comment.post_id = post.id WHERE (comment.post_id IS NULL OR (comment.post_id IS NOT NULL AND comment.aprovado != "1")) AND post.data <= NOW() AND DATE_FORMAT(post.data, "%Y-%m") = "'.$data.'"';
	$query.= ') ORDER BY 4';


} else if(!empty($_GET['id'])) {
	$query = 'SELECT post.id, ""      , post.titulo, UNIX_TIMESTAMP(post.data), post.texto, -1       FROM post          WHERE post.id = '.$_GET['id'];
} else {
	$query = '(';
	$query.= 'SELECT post.id, post.url, post.titulo, UNIX_TIMESTAMP(post.data), post.texto, COUNT(*) FROM post, comment WHERE comment.post_id = post.id AND comment.aprovado = "1" AND post.data <= NOW() GROUP BY post.id';
	$query.= ') UNION (';
	$query.= 'SELECT post.id, post.url, post.titulo, UNIX_TIMESTAMP(post.data), post.texto, 0        FROM post LEFT JOIN comment ON comment.post_id = post.id WHERE (comment.post_id IS NULL OR (comment.post_id IS NOT NULL AND comment.aprovado != "1")) AND post.data <= NOW()'; //
	$query.= ') ORDER BY 4 DESC LIMIT 1';

/**/
	echo '			<div align="center">'."\n";
	echo '				<a href="http://www.mundosdemirr.com/"><img src="http://www.mundosdemirr.com/banner/pelo_sangue_e_pela_fe.gif" width="468" height="60" alt="" /></a><br />'."\n";
	echo '				<br />'."\n";
	echo '				Ajude a divulgar o lan&ccedil;amento de meu livro, colocando o banner em seu site ou blog.<br />'."\n";
	echo '				<textarea rows="3" cols="89" style="width:468px;height:60px;font-family:Courier New;font-size:9pt;" readonly="readonly">';
	echo htmlentities('<a href="http://www.mundosdemirr.com/"><img src="http://www.mundosdemirr.com/banner/pelo_sangue_e_pela_fe.gif" width="468" height="60" alt="" /></a>');
	echo '</textarea><br />'."\n";
	echo "			(Copie e cole este c&oacute;digo no HTML/template de seu site ou blog)<br />\n";
	echo '			</div>'."\n";
/** /
	echo "			&nbsp;&nbsp;&nbsp;&nbsp;Sou um escritor iniciante, cuja a maior paix&atilde;o &eacute; mexer com a imagina&ccedil;&atilde;o e as emo&ccedil;&otilde;es das pessoas. Como um eterno viajante, passo a vida navegando por mundos imagin&aacute;rios e vivendo aventuras sem fim. Criei esse blog inspirado em alguns escritores profissionais que relatam seu dia a dia, suas dificuldades e experi&ecirc;ncias em criar universos fantasticos. Acompanhe-me nessa viagem, mas tenha cuidado; Uma vez que se deixe levar pela fantasia, n&atilde;o h&aacute; mais volta.<br />\n";
/**/
	echo "			<br />\n";
	echo '			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />'."\n";
	echo "			<br />\n";

}

//echo $query.'<hr />';

if(!empty($_GET['data'])) {
	echo '<div id="titulo"></div>'."\n";
}
$titulos = array();

$result = mysql_query($query) or mysql_die();
while(list($id, $url, $titulo, $data, $texto, $quant) = mysql_fetch_row($result)) {
	$texto = text_adj($texto);
	$texto = str_replace("\n", "\n					", $texto)."\n";
	if($url != '') {
		$titulos[$url] = $titulo;
		echo '			<a name="'.$url.'"></a>'."\n";
	}
?>
			<div class="post">
				<?=$GLOBALS['dias_da_semana'][date('w', $data)].date(', d \\d\\e ', $data).$GLOBALS['meses'][intval(date('m', $data))].date(' \\d\\e Y', $data)."\n";?>
				<h3><?=( $url != '' ? '<a href="/'.$url.'">' : '' ).$titulo.( $url != '' ? '</a>' : '' )?></h3>
				<blockquote>
					<?=$texto?>
				</blockquote>
				<br style="clear:both" />
				<blockquote>
					&nbsp; 
					por Claudio Villa<?php
	if($quant >= 0) {
		echo ' | <a href="comentarios.php?id='.$id.'" onclick="return !popup(this.href, 400, 450);">'.( $quant == 0 ? 'nenhum' : $quant ).' coment&aacute;rio'.( $quant > 1 ? 's' : '' ).'</a>';
	}
?><br />
				</blockquote>
				<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />
				<br />
			</div>
<?php
	if($url == '') {

		echo '<a name="comentarios"></a>'."\n";

		$_POST['vazio']      = htmlentities( isset($_POST['vazio']     ) ? $_POST['vazio']      : '.' );
		$_POST['nome']       = htmlentities( isset($_POST['nome']      ) ? $_POST['nome']       : '' );
		$_POST['comentario'] = htmlentities( isset($_POST['comentario']) ? $_POST['comentario'] : '' );
		if(get_magic_quotes_gpc()) {
			$_POST['vazio']      = stripslashes($_POST['vazio']);
			$_POST['nome']       = stripslashes($_POST['nome']);
			$_POST['comentario'] = stripslashes($_POST['comentario']);
		}
		if($_POST['vazio'] == '' && !empty($_POST['nome']) && !empty($_POST['comentario'])) {
			mysql_query('INSERT INTO comment (post_id, ip, data, nome, texto) VALUES ('.$id.', "'.$_SERVER['REMOTE_ADDR'].'", "'.date('Y-m-d H:i:s').'", "'.addslashes($_POST['nome']).'", "'.addslashes($_POST['comentario']).'")') or mysql_die();
			if(mysql_affected_rows() > 0) {
				echo '			<div class="alert">'."\n";
				echo '				Seu coment&aacute;rio foi enviado com sucesso!<br /><br />Assim que for aprovado, seu coment&aacute;rio estar&aacute; visivel.'."\n";
				echo "			</div>\n";
				echo '			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />'."\n";
				$_POST['comentario'] = "";
			}
		}

		echo "			<blockquote>\n";


		$result2 = mysql_query('SELECT COUNT(*) FROM comment WHERE post_id = '.$id.' AND aprovado != "1"') or mysql_die();
		list($quant) = mysql_fetch_row($result2);
		if($quant > 0) {
			echo '				'.$quant.' coment&aacute;rio'.( $quant == 1 ? '' : 's' )." esperando autoriza&ccedil;&atilde;o.<br />\n";
			echo "				<br />\n";
		}

		$result2 = mysql_query('SELECT nome, UNIX_TIMESTAMP(data), texto FROM comment WHERE post_id = '.$id.' AND aprovado = "1" ORDER BY data DESC') or mysql_die();
		while(list($nome, $data, $texto) = mysql_fetch_row($result2)) {
			echo '				<b>'.$nome."</b><br />\n";
			echo '				<small>'.$GLOBALS['dias_da_semana'][date('w', $data)].date(', d \\d\\e ', $data).$GLOBALS['meses'][intval(date('m', $data))].date(' \\d\\e Y', $data)."<br /></small>\n";
			echo '				<div class="comentario">'.$texto."</div>\n";
			echo "				<br />\n";
		}
		echo "			</blockquote>\n";

		echo "			<blockquote>\n";
		echo '				<form action="'.$_SERVER['REQUEST_URI'].'#comentarios" method="post">'."\n";
		echo '					<div style="display:none;"><b>N&atilde;o preencha este campo:</b> <input type="text" name="vazio" value=" " size="20" maxlength="25" id="vazio" /><br /></div>'."\n";
		echo '					<b>Nome:</b> <input type="text" name="nome" value="'.$_POST['nome'].'" size="20" maxlength="25" /><br />'."\n";
		echo "					<b>Coment&aacute;rio:</b><br />\n";
		echo '					<textarea name="comentario" rows="5" cols="40" style="width:100%">'.$_POST['comentario'].'</textarea><br />'."\n";
		echo '					<input type="submit" value="Enviar" /><br />'."\n";
		echo "				</form>\n";
		echo "			</blockquote>\n";
		echo '			<script type="text/javascript">'."\n";
		echo "			<!--\n";
		echo '			var obj = ( document.getElementById ? document.getElementById("vazio") : null );'."\n";
		echo "			if(obj != null) {\n";
		echo '				obj.value = "";'."\n";
		echo "			}\n";
		echo "			//-->\n";
		echo "			</script>\n";
	}
}

if(count($titulos) > 0) {
	echo '<script type="text/javascript">'."\n";
	echo "<!-- //\n";
	echo 'var obj = ( document.getElementById ? document.getElementById("titulo") : null );'."\n";
	echo "if(obj != null) {\n";
	echo '	html = "<ul>\\n";'."\n";
	foreach($titulos as $url => $titulo) {
		echo '	html+= "	<li><a href=\\"#'.$url.'\\">'.$titulo.'</a><br /></li>\\n";'."\n";
	}
	echo '	html+= "</ul>\\n";'."\n";
	echo '	html+= "<img src=\"divider.gif\" width=\"545\" height=\"3\" border=\"0\" alt=\"\" align=\"center\" /><br />\\n";'."\n";
	echo '	html+= "<br />\\n";'."\n";
	echo "	obj.innerHTML = html\n";
	echo "}\n";
	echo "// -->\n";
	echo '</script>';
}
?>