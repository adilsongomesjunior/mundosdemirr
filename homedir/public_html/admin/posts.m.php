<html><head><title>Posts</title></head><body><?php

if(!empty($_GET['edit']) && ereg('^[0-9]+$', $_GET['edit'])) {
	$result = mysql_query('SELECT url, titulo, DATE_FORMAT(data, "%Y %m %d %H %i"), texto FROM post WHERE id = '.$_GET['edit']) or mysql_die();
	if(list($url, $titulo, $data, $texto) = mysql_fetch_row($result)) {
		list($data_y, $data_m, $data_d, $data_h, $data_i) = explode(' ', $data);

		if(!empty($_POST['titulo'])) {

			$_POST['titulo'] =       ( !empty($_POST['titulo']) ? $_POST['titulo'] : $titulo );
			$_POST['url']    = strtolower(ereg_replace('(^_|_$)', '', str_flat($_POST['titulo'], true)));
			$_POST['data_d'] = intval(  isset($_POST['data_d']) ? $_POST['data_d'] : date('d') );
			$_POST['data_m'] = intval(  isset($_POST['data_m']) ? $_POST['data_m'] : date('m') );
			$_POST['data_y'] = intval(  isset($_POST['data_y']) ? $_POST['data_y'] : date('Y') );
			$_POST['data_h'] = intval(  isset($_POST['data_h']) ? $_POST['data_h'] : date('H') );
			$_POST['data_i'] = intval(  isset($_POST['data_i']) ? $_POST['data_i'] : date('i') );
			$_POST['texto']  =       ( !empty($_POST['texto'] ) ? $_POST['texto']  : $texto  );

			if($_POST['data_y'] <  10) $_POST['data_y']+= 2000;
			if($_POST['data_y'] < 100) $_POST['data_y']+= 1900;

			if(!get_magic_quotes_gpc()) {
				$_POST['titulo'] = addslashes($_POST['titulo']);
				$_POST['url']    = addslashes($_POST['url']   );
				$_POST['data_d'] = addslashes($_POST['data_d']);
				$_POST['data_m'] = addslashes($_POST['data_m']);
				$_POST['data_y'] = addslashes($_POST['data_y']);
				$_POST['data_h'] = addslashes($_POST['data_h']);
				$_POST['data_i'] = addslashes($_POST['data_i']);
				$_POST['texto']  = addslashes($_POST['texto'] );
			}

			$_POST['titulo'] = htmlentities($_POST['titulo']);
			$_POST['texto']  = htmlentities(trim($_POST['texto']));

			$result = mysql_query('SELECT COUNT(*) FROM post WHERE titulo = "'.$_POST['titulo'].'" AND id != '.$_GET['edit']) or mysql_die();
			list($quant) = mysql_fetch_row($result);
			if($quant == 0) {

				$result = mysql_query('SELECT COUNT(*) FROM post WHERE url = "'.$_POST['url'].'" AND id != '.$_GET['edit']) or mysql_die();
				list($quant) = mysql_fetch_row($result);
				if($quant == 0) {

					if(checkdate($_POST['data_m'], $_POST['data_d'], $_POST['data_y'])) {

$log = 'UPDATE post SET titulo = "'.$_POST['titulo'].'", url = "'.$_POST['url'].'", data = "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", texto = "'.$_POST['texto'].'" WHERE id = '.$_GET['edit'];
include('log.php');

						mysql_query('UPDATE post SET titulo = "'.$_POST['titulo'].'", url = "'.$_POST['url'].'", data = "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", texto = "'.$_POST['texto'].'" WHERE id = '.$_GET['edit']) or mysql_die();
						if(mysql_affected_rows() > 0
						||($_POST['titulo'] == $titulo
						&& $_POST['url']    == $url
						&& $_POST['data_d'] == $data_d
						&& $_POST['data_m'] == $data_m
						&& $_POST['data_y'] == $data_y
						&& $_POST['data_h'] == $data_h
						&& $_POST['data_i'] == $data_i
						&& $_POST['texto']  == $texto
						)) {
							echo '<div class="ok">Post atualizado com sucesso.</div>';
						} else {
							echo '<div class="erro">N&atilde;o foi poss&iacute;vel atualizar o post.</div>';
$log = mysql_error();
include('log.php');
						}
					} else {
						echo '<div class="erro">Data inv&aacute;lida, entre com uma data v&aacute;lida.</div>';
					}
				} else {
					echo '<div class="erro">URL j&aacute; existente, coloque um t&iacute;tulo diferente.</div>';
				}
			} else {
				echo '<div class="erro">T&iacute;tulo j&aacute; existente, coloque um diferente.</div>';
			}
			$_POST['titulo'] = stripslashes($_POST['titulo']);
			$_POST['url']    = stripslashes($_POST['url']   );
			$_POST['data_d'] = stripslashes($_POST['data_d']);
			$_POST['data_m'] = stripslashes($_POST['data_m']);
			$_POST['data_y'] = stripslashes($_POST['data_y']);
			$_POST['data_h'] = stripslashes($_POST['data_h']);
			$_POST['data_i'] = stripslashes($_POST['data_i']);
			$_POST['texto']  = stripslashes($_POST['texto'] );
		} else {
			$_POST['titulo'] = $titulo;
			$_POST['url']    = $url;
			$_POST['data_d'] = $data_d;
			$_POST['data_m'] = $data_m;
			$_POST['data_y'] = $data_y;
			$_POST['data_h'] = $data_h;
			$_POST['data_i'] = $data_i;
			$_POST['texto']  = $texto;
		}
?>
	<script type="text/javascript">
	<!-- //
	function ajax(url, data, method, callBackFunction)
	{
		var ajaxReq = new Object();
		ajaxReq.callBackFunction = callBackFunction;
		ajaxReq.callBack = function () {
			ajaxReq.callBackFunction(ajaxReq.xmlhttp);
			if(typeof(ajaxReq.xmlhttp) == "object") if(ajaxReq.xmlhttp.readyState == 4) delete ajaxReq.xmlhttp;
			if(typeof(ajaxReq.xmlhttp) != "object" && typeof(ajaxReq) == "object") delete ajaxReq;
		};
		ajaxReq.xmlhttp = false;
		/*@cc_on @*/
		/*@if (@_jscript_version >= 5)
		// JScript gives us Conditional compilation, we can cope with old IE versions.
		// and security blocked creation of the objects.
			try {
				ajaxReq.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					ajaxReq.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					ajaxReq.xmlhttp = false;
				}
			}
		@end @*/
		if(!ajaxReq.xmlhttp && typeof(XMLHttpRequest) != "undefined") ajaxReq.xmlhttp = new XMLHttpRequest();
		if(ajaxReq.xmlhttp) {
			if(url.indexOf("?") > -1) {
				querystring = url.substr(url.indexOf("?") + 1);
				url         = url.substr(0, url.indexOf("?"));
			} else {
				querystring = "";
			}
			if("<?=session_id()?>" != "" && "<?=session_id()?>" != "<" + "?=session_id()?" + ">") {
				if(querystring.length > 0) querystring = "&" + querystring;
				querystring = "<?=session_name()?>=<?=session_id()?>" + querystring;
			}
			if(method == "GET") {
				if(querystring.length > 0) querystring+= "&";
				if(data.length        > 0) querystring+= data + "&";
				querystring = "?" + querystring + "rnd=" + Math.random();
				post = null;
			} else if(method == "POST") {
				if(querystring.length > 0) querystring = "?" + querystring;
				post = data;
			}
			if(method == "GET" || method == "POST") {
				ajaxReq.xmlhttp.open(method, url + querystring, true);
				ajaxReq.xmlhttp.onreadystatechange = ajaxReq.callBack;
				if(method == "POST" && typeof(ajaxReq.xmlhttp.setRequestHeader) != "undefined") {
					ajaxReq.xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				}
				ajaxReq.url  = url;
				ajaxReq.get  = querystring;
				ajaxReq.post = post;
				ajaxReq.xmlhttp.send(post);
			} else {
				alert("AJAX Error:\nMethod \"" + method + "\" not allowed!");
			}
		} else {
			alert("AJAX Error:\nCould not initialize the XMLHTTP object.");
		}
	}

	function gerar_url()
	{
		var titulo = ( document.getElementById ? document.getElementById("titulo") : null );
		if(titulo != null) {
			ajax("str_flat.php", "str=" + escape(titulo.value) + "&nospecials=1", "GET", url_gerada);
		}
	}
	function url_gerada(request)
	{
		if(typeof(request) == "undefined" || (typeof(request) == "boolean" && request == false)) { // Error
			alert("Error: request == false");
		} else if(request.readyState == 4) { // Complete
			var url = ( document.getElementById ? document.getElementById("url") : null );
			if(url != null) url.value = request.responseText;
		}
	}
	// -->
	</script>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<div align="center">[<a href="?m=<?=$_GET['m']?>&id=<?=$_GET['id']?>"><b>voltar</b></a>]</div>
		<b>T&iacute;tulo:</b> <input type="text" name="titulo" id="titulo" value="<?=$_POST['titulo']?>" size="55" maxlength="70" /><br />
		<b>URL:</b> <input type="text" name="url" id="url" value="<?=$_POST['url']?>" disabled="disabled" size="55" class="disabled" /> <a href="#" onclick="gerar_url();">gerar</a><br />
		<b>Data:</b> <select name="data_d">
<?php for($i = 1; $i <= 31; $i++) echo '<option value="'.$i.'"'.( $_POST['data_d'] == $i ? ' selected="selected"' : '' ).'>'.( $i < 10 ? '0' : '' ).$i.'</option>'."\n"; ?>
			</select> / <select name="data_m">
<?php for($i = 1; $i <= 12; $i++) echo '<option value="'.$i.'"'.( $_POST['data_m'] == $i ? ' selected="selected"' : '' ).'>'.( $i < 10 ? '0' : '' ).$i.'</option>'."\n"; ?>
			</select> / <input type="text" name="data_y" value="<?=$_POST['data_y']?>" size="5" maxlength="4" /><br />
		<b>Hora:</b> <select name="data_h">
<?php for($i = 0; $i <= 23; $i++) echo '<option value="'.$i.'"'.( $_POST['data_h'] == $i ? ' selected="selected"' : '' ).'>'.( $i < 10 ? '0' : '' ).$i.'</option>'."\n"; ?>
			</select> / <select name="data_i">
<?php for($i = 0; $i <= 59; $i++) echo '<option value="'.$i.'"'.( $_POST['data_i'] == $i ? ' selected="selected"' : '' ).'>'.( $i < 10 ? '0' : '' ).$i.'</option>'."\n"; ?>
			</select><br />
		<b>Texto:</b> (<a href="cola.php" onclick="return popup(this.href, 500, 220);"><i>cola</i></a>)<br />
		<textarea name="texto" rows="15" cols="90"><?=$_POST['texto']?></textarea><br />
		<input type="submit" value="Enviar" /><br />
		<div align="center">[<a href="?m=<?=$_GET['m']?>&id=<?=$_GET['id']?>"><b>voltar</b></a>]</div>
	</form>
<?php
	} else {
		echo "<i>Post inexistente<br />\n";
	}

} else if(!empty($_GET['id']) && ereg('^[0-9]+$', $_GET['id'])) {

	if(!empty($_GET['aprovar']) && ereg('^[0-9]+$', $_GET['aprovar'])) {
		mysql_query('UPDATE comment SET aprovado = "1" WHERE id = '.$_GET['aprovar']);
$log = 'UPDATE comment SET aprovado = "1" WHERE id = '.$_GET['aprovar'];
include('log.php');

	} else if(!empty($_GET['desaprovar']) && ereg('^[0-9]+$', $_GET['desaprovar'])) {
		mysql_query('UPDATE comment SET aprovado = "0" WHERE id = '.$_GET['desaprovar']);
$log = 'UPDATE comment SET aprovado = "0" WHERE id = '.$_GET['desaprovar'];
include('log.php');

	} else if(!empty($_GET['apagar']) && ereg('^[0-9]+$', $_GET['apagar'])) {
		mysql_query('DELETE FROM comment WHERE id = '.$_GET['apagar']);
$log = 'DELETE FROM comment WHERE id = '.$_GET['apagar'];
include('log.php');
	}

	$result = mysql_query('SELECT url, titulo, DATE_FORMAT(data, "%d/%m/%Y %H:%i"), texto, IF(data <= NOW(), 1, 0) FROM post WHERE id = '.$_GET['id']) or mysql_die();
	if(list($url, $titulo, $data, $texto, $posted) = mysql_fetch_row($result)) {

		$texto  = text_adj($texto, true);

		if(!$posted) echo '<div class="notPosted">';
		echo '<h3 style="display:inline">'.$titulo." </h3>\n";
		echo '<span class="normal"> - <b>'.$url."</b></span><br />\n";
		echo '<div class="normal" style="float:right">[<a href="?m='.$_GET['m'].'&apagar='.$_GET['id'].'" onclick="return confirm(\'Apagar este texto?\');"><b class="notPosted">&nbsp;X&nbsp;</b></a>]&nbsp;&nbsp;</div>'."\n";
		echo $data."<br />\n";
		if(!$posted) echo "</div>\n";
		echo '<div align="center">[<a href="?m='.$_GET['m'].'&edit='.$_GET['id'].'"><b>Alterar</b></a>]</div>'."\n";
		echo '<div>'.$texto.'</div>';
		echo '<div align="center" style="clear:both">[<a href="?m='.$_GET['m'].'&edit='.$_GET['id'].'"><b>Alterar</b></a>]</div>'."\n";

		echo '<a name="comentarios"></a>';
		echo "<hr />\n";
		echo "<b>Coment&aacute;rios:</b><br />";

		$result = mysql_query('SELECT id, ip, DATE_FORMAT(data, "%d/%m/%Y %H:%i"), aprovado, nome, email, texto FROM comment WHERE post_id = '.$_GET['id'].' ORDER BY data DESC') or mysql_die();
		if(mysql_num_rows($result) > 0) {
			while(list($id, $ip, $data, $aprovado, $nome, $email, $texto) = mysql_fetch_row($result)) {
				echo '<a name="comentario'.$id.'"></a>';
				echo "<hr />\n";
				echo '<div class="comentario'.( $aprovado == 1 ? 'Aprovado' : 'Desaprovado' ).'">';
				echo '<div class="fRight">'.$ip.' -';
				echo ' [<a href="?m='.$_GET['m'].'&id='.$_GET['id'].'&'.( $aprovado == 1 ? 'des' : '' ).'aprovar='.$id.'#comentario'.$id.'">'.( $aprovado == 1 ? 'des' : '' ).'aprovar</a>]';
				echo ' [<a href="?m='.$_GET['m'].'&id='.$_GET['id'].'&apagar='.$id.'#comentarios" onclick="return confirm(\'Deseja realmente apagar o comentário de '.addslashes($nome).'?\');">apagar</a>]</div>';
				echo '<b>'.$nome.'</b> - '.$data."<br />\n";
				echo '<a href="mailto:'.$email.'">'.$email."</b><br />\n";
				echo '<div>'.$texto.'</div>';
				echo "</div>\n";
			}
		} else {
			echo "<i>Nenhum coment&aacute;rio</i><br />\n";
		}
		echo "<br />\n";

	} else {
		echo "<i>Post inexistente<br />\n";
	}

} else {

	if(!empty($_GET['apagar']) && ereg('^[0-9]+$', $_GET['apagar'])) {
$log = 'DELETE FROM comment WHERE post_id = '.$_GET['apagar'].' LIMIT 1';
include('log.php');
		mysql_query('DELETE FROM comment WHERE post_id = '.$_GET['apagar'].' LIMIT 1') or mysql_die();
$log = 'DELETE FROM post WHERE id = '.$_GET['apagar'].' LIMIT 1';
include('log.php');
		mysql_query('DELETE FROM post WHERE id = '.$_GET['apagar'].' LIMIT 1');
		if(mysql_affected_rows() != 0) {
			echo '<div class="ok">Texto apagado com sucesso!</div>';
		} else {
			echo '<div class="erro">N&atilde;o foi poss&iacute;vel apagar o texto.</div>';
$log = mysql_error();
include('log.php');
		}
	}

	$ano = 0;
	$mes = 0;
	$result = mysql_query(
		'('.
			'SELECT post.id, post.url, post.titulo, DATE_FORMAT(post.data, "%d/%m/%Y %H:%i"), IF(post.data <= NOW(), 1, 0), 0, 0, post.data FROM post LEFT JOIN comment ON comment.post_id = post.id WHERE comment.post_id IS NULL GROUP BY post.id'.
		') UNION ('.
			'SELECT post.id, post.url, post.titulo, DATE_FORMAT(post.data, "%d/%m/%Y %H:%i"), IF(post.data <= NOW(), 1, 0), SUM(IF(aprovado = "1", 1, 0)), SUM(IF(aprovado = "0", 1, 0)), post.data FROM post, comment WHERE comment.post_id = post.id GROUP BY post.id'.
		') ORDER BY 8 DESC'.
	'') or mysql_die();
	if(mysql_num_rows($result) > 0) {
		echo '<ul id="posts">'."\n";
		while(list($id, $url, $titulo, $data, $posted, $comments_aproved, $comments_to_aprove) = mysql_fetch_row($result)) {
			$comments_aproved   = str_pad($comments_aproved  , 1, '0', STR_PAD_LEFT);
			$comments_to_aprove = str_pad($comments_to_aprove, 1, '0', STR_PAD_LEFT);
			$comments_none      = str_pad(''                 , 1, '-', STR_PAD_LEFT);
			if($ano != substr($data, 6, 4)) {
				$ano = substr($data, 6, 4);
				echo '<li><div class="ano"><b>'.$ano."</b></div></li>\n";
				$mes = 0;
			}
			if($mes != substr($data, 3, 2)) {
				$mes = substr($data, 3, 2);
				echo '<li><div class="mes"><b>'.$GLOBALS['meses'][intval($mes)]."</b></div></li>\n";
			}
			echo '<li>';
			echo '<a href="?m='.$_GET['m'].'&id='.$id.'" class="post'.( $posted ? '' : ' notPosted' ).'">';
			echo $data;
			echo ' - <span class="normal">';
			if($posted) {
				echo '<b>[</b><span class="comentarioAprovado">'   .$comments_aproved  .'</span>';
				echo '<b>|</b><span class="comentarioDesaprovado">'.$comments_to_aprove.'</span>';
				echo '<b>]</b>';
			} else {
				echo '<b>[</b>'.$comments_none.'<b>|</b>'.$comments_none.'<b>]</b>';
			}
			echo '</span>';
			echo ' - <b>'.$titulo.'</b>';
			echo ' - '.$url;
			echo '</a>';
			echo "</li>\n";
		}
		echo "</ul>\n";
	} else {
		echo "<i>Nenhum post</i><br />\n";
	}
}

?>
</body>
</html>