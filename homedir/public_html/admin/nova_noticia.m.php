<html><head><title>Nova notícia</title></head><body><?php

$_POST['titulo'] = ( !empty($_POST['titulo']) ? $_POST['titulo'] : '');
$_POST['data_d'] = ( !empty($_POST['data_d']) ? $_POST['data_d'] : date('d') );
$_POST['data_m'] = ( !empty($_POST['data_m']) ? $_POST['data_m'] : date('m') );
$_POST['data_y'] = ( !empty($_POST['data_y']) ? $_POST['data_y'] : date('Y') );
$_POST['data_h'] = ( !empty($_POST['data_h']) ? $_POST['data_h'] : date('H') );
$_POST['data_i'] = ( !empty($_POST['data_i']) ? $_POST['data_i'] : date('i') );
$_POST['texto']  = ( !empty($_POST['texto'] ) ? $_POST['texto']  : '' );

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

if(!empty($_POST['titulo'])) {
	$result = mysql_query('SELECT COUNT(*) FROM noticia WHERE titulo = "'.$_POST['titulo'].'"') or mysql_die();
	list($quant) = mysql_fetch_row($result);
	if($quant == 0) {


		if(checkdate($_POST['data_m'], $_POST['data_d'], $_POST['data_y'])) {

			mysql_query('INSERT INTO noticia (titulo, data, texto) VALUES ("'.$_POST['titulo'].'", "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", "'.$_POST['texto'].'")');
$log = 'INSERT INTO noticia (titulo, data, texto) VALUES ("'.$_POST['titulo'].'", "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", "'.$_POST['texto'].'")';
include('log.php');
			if(mysql_affected_rows() > 0) {
				$id = mysql_insert_id();
				echo '<script type="text/javascript">'."\n";
				echo 'document.location.href = "index.php?m=noticias&id='.$id.'";'."\n";
				echo "</script>\n";
				$_POST = array();
			} else {
				echo 'N&atilde;o foi poss&iacute;vel inserir o not&iacute;cia.';
$log = 'mysql error: ['.mysql_error().']';
include('log.php');
			}
		} else {
			echo 'Data inv&aacute;lida, entre com uma data v&aacute;lida.';
		}
	} else {
		echo 'T&iacute;tulo j&aacute; existente, coloque um diferente.';
	}
}
if(count($_POST['titulo']) > 0) {
?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
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
	</form>
<?php
}
?>
</body>
</html>