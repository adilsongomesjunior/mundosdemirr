<html><head><title>Not&iacute;cias</title></head><body><?php

if(!empty($_GET['edit']) && ereg('^[0-9]+$', $_GET['edit'])) {
	$result = mysql_query('SELECT titulo, DATE_FORMAT(data, "%Y %m %d %H %i"), texto FROM noticia WHERE id = '.$_GET['edit']) or mysql_die();
	if(list($titulo, $data, $texto) = mysql_fetch_row($result)) {
		list($data_y, $data_m, $data_d, $data_h, $data_i) = explode(' ', $data);

		if(!empty($_POST['titulo'])) {

			$_POST['titulo'] = ( !empty($_POST['titulo']) ? $_POST['titulo'] : $titulo );
			$_POST['data_d'] = ( !empty($_POST['data_d']) ? $_POST['data_d'] : $data_d );
			$_POST['data_m'] = ( !empty($_POST['data_m']) ? $_POST['data_m'] : $data_m );
			$_POST['data_y'] = ( !empty($_POST['data_y']) ? $_POST['data_y'] : $data_y );
			$_POST['data_h'] = ( !empty($_POST['data_h']) ? $_POST['data_h'] : $data_h );
			$_POST['data_i'] = ( !empty($_POST['data_i']) ? $_POST['data_i'] : $data_i );
			$_POST['texto']  = ( !empty($_POST['texto'] ) ? $_POST['texto']  : $texto  );

			if($_POST['data_y'] <  10) $_POST['data_y']+= 2000;
			if($_POST['data_y'] < 100) $_POST['data_y']+= 1900;

			if(!get_magic_quotes_gpc()) {
				$_POST['titulo'] = addslashes($_POST['titulo']);
				$_POST['data_d'] = addslashes($_POST['data_d']);
				$_POST['data_m'] = addslashes($_POST['data_m']);
				$_POST['data_y'] = addslashes($_POST['data_y']);
				$_POST['data_h'] = addslashes($_POST['data_h']);
				$_POST['data_i'] = addslashes($_POST['data_i']);
				$_POST['texto']  = addslashes($_POST['texto'] );
			}

			$_POST['titulo'] = htmlentities($_POST['titulo']);
			$_POST['texto']  = htmlentities(trim($_POST['texto']));

			$result = mysql_query('SELECT COUNT(*) FROM noticia WHERE titulo = "'.$_POST['titulo'].'" AND id != '.$_GET['edit']) or mysql_die();
			list($quant) = mysql_fetch_row($result);
			if($quant == 0) {

				if(checkdate($_POST['data_m'], $_POST['data_d'], $_POST['data_y'])) {

$log = 'UPDATE noticia SET titulo = "'.$_POST['titulo'].'", data = "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", texto = "'.$_POST['texto'].'" WHERE id = '.$_GET['edit'];
include('log.php');

					mysql_query('UPDATE noticia SET titulo = "'.$_POST['titulo'].'", data = "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", texto = "'.$_POST['texto'].'" WHERE id = '.$_GET['edit']);
					if(mysql_affected_rows() > 0
					||($_POST['titulo'] == $titulo
					&& $_POST['data_d'] == $data_d
					&& $_POST['data_m'] == $data_m
					&& $_POST['data_y'] == $data_y
					&& $_POST['data_h'] == $data_h
					&& $_POST['data_i'] == $data_i
					&& $_POST['texto']  == $texto
					)) {
						echo '<div class="ok">Not&iacute;cia atualizada com sucesso.</div>';
					} else {
						echo '<div class="erro">N&atilde;o foi poss&iacute;vel atualizar a not&iacute;cia.</div>';
$log = mysql_error();
include('log.php');
					}
				} else {
					echo '<div class="erro">Data inv&aacute;lida, entre com uma data v&aacute;lida.</div>';
				}
			} else {
				echo '<div class="erro">T&iacute;tulo j&aacute; existente, coloque um diferente.</div>';
			}
			$_POST['titulo'] = stripslashes($_POST['titulo']);
			$_POST['data_d'] = stripslashes($_POST['data_d']);
			$_POST['data_m'] = stripslashes($_POST['data_m']);
			$_POST['data_y'] = stripslashes($_POST['data_y']);
			$_POST['data_h'] = stripslashes($_POST['data_h']);
			$_POST['data_i'] = stripslashes($_POST['data_i']);
			$_POST['texto']  = stripslashes($_POST['texto'] );
		} else {
			$_POST['titulo'] = $titulo;
			$_POST['data_d'] = $data_d;
			$_POST['data_m'] = $data_m;
			$_POST['data_y'] = $data_y;
			$_POST['data_h'] = $data_h;
			$_POST['data_i'] = $data_i;
			$_POST['texto']  = $texto;
		}
?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<div align="center">[<a href="?m=<?=$_GET['m']?>&id=<?=$_GET['id']?>"><b>voltar</b></a>]</div>
		<b>T&iacute;tulo:</b> <input type="text" name="titulo" id="titulo" value="<?=$_POST['titulo']?>" size="40" maxlength="40" /><br />
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
		echo "<i>Not&iacute;cia inexistente<br />\n";
	}

} else if(!empty($_GET['id']) && ereg('^[0-9]+$', $_GET['id'])) {

	$result = mysql_query('SELECT titulo, DATE_FORMAT(data, "%d/%m/%Y %H:%i"), texto, IF(data <= NOW(), 1, 0) FROM noticia WHERE id = '.$_GET['id']) or mysql_die();
	if(list($titulo, $data, $texto, $posted) = mysql_fetch_row($result)) {

		$texto  = text_adj($texto, true);

		if(!$posted) echo '<div class="notPosted">';
		echo '<h3>'.$titulo." </h3>\n";
		echo '<div class="normal" style="float:right">[<a href="?m='.$_GET['m'].'&apagar='.$_GET['id'].'" onclick="return confirm(\'Apagar esta notícia?\');"><b class="notPosted">&nbsp;X&nbsp;</b></a>]&nbsp;&nbsp;</div>'."\n";
		echo $data."<br />\n";
		if(!$posted) echo "</div>\n";
		echo '<div align="center">[<a href="?m='.$_GET['m'].'&edit='.$_GET['id'].'"><b>Alterar</b></a>]</div>'."\n";
		echo '<div>'.$texto.'</div>';
		echo '<div align="center">[<a href="?m='.$_GET['m'].'&edit='.$_GET['id'].'"><b>Alterar</b></a>]</div>'."\n";
		echo "<br />\n";

	} else {
		echo "<i>Not&iacute;cia inexistente<br />\n";
	}

} else {

	if(!empty($_GET['apagar']) && ereg('^[0-9]+$', $_GET['apagar'])) {
$log = 'DELETE FROM noticia WHERE id = '.$_GET['apagar'].' LIMIT 1';
include('log.php');
		mysql_query('DELETE FROM noticia WHERE id = '.$_GET['apagar'].' LIMIT 1');
		if(mysql_affected_rows() != 0) {
			echo '<div class="ok">Not&iacute;cia apagada com sucesso!</div>';
		} else {
			echo '<div class="erro">N&atilde;o foi poss&iacute;vel apagar a not&iacute;cia.</div>';
$log = mysql_error();
include('log.php');
		}
	}

	$ano = 0;
	$mes = 0;
	$result = mysql_query('SELECT id, titulo, DATE_FORMAT(data, "%d/%m/%Y %H:%i"), IF(data <= NOW(), 1, 0) FROM noticia ORDER BY data DESC') or mysql_die();
	if(mysql_num_rows($result) > 0) {
		echo '<ul id="posts">'."\n";
		while(list($id, $titulo, $data, $posted) = mysql_fetch_row($result)) {
			if($ano != substr($data, 6, 4)) {
				$ano = substr($data, 6, 4);
				echo '<li><div><b>'.$ano."</b></div></li>\n";
				$mes = 0;
			}
			if($mes != substr($data, 3, 2)) {
				$mes = substr($data, 3, 2);
				echo '<li><div>&nbsp;&nbsp;<b>'.$GLOBALS['meses'][intval($mes)]."</b></div></li>\n";
			}
			echo '<li><a href="?m='.$_GET['m'].'&id='.$id.'"'.( $posted ? '' : ' class="notPosted"' ).'>&nbsp;&nbsp;&nbsp;&nbsp;'.$data.' - <b>'.$titulo.'</b></a></li>'."\n";
		}
		echo "</ul>\n";
	} else {
		echo "<i>Nenhuma not&iacute;cia</i><br />\n";
	}
}

?>
</body>
</html>