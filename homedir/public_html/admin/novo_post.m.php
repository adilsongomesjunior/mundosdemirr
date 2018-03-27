<html><head><title>Novo post</title></head><body><?php

$_POST['titulo'] =       ( !empty($_POST['titulo']) ? $_POST['titulo'] : '');
$_POST['url']    = strtolower(ereg_replace('(^_|_$)', '', str_flat($_POST['titulo'], true)));
$_POST['data_d'] = intval(  isset($_POST['data_d']) ? $_POST['data_d'] : date('d') );
$_POST['data_m'] = intval(  isset($_POST['data_m']) ? $_POST['data_m'] : date('m') );
$_POST['data_y'] = intval(  isset($_POST['data_y']) ? $_POST['data_y'] : date('Y') );
$_POST['data_h'] = intval(  isset($_POST['data_h']) ? $_POST['data_h'] : date('H') );
$_POST['data_i'] = intval(  isset($_POST['data_i']) ? $_POST['data_i'] : date('i') );
$_POST['texto']  =       ( !empty($_POST['texto'] ) ? $_POST['texto']  : '' );

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

if(!empty($_POST['titulo'])) {
	$result = mysql_query('SELECT COUNT(*) FROM post WHERE titulo = "'.$_POST['titulo'].'"') or mysql_die();
	list($quant) = mysql_fetch_row($result);
	if($quant == 0) {

		$result = mysql_query('SELECT COUNT(*) FROM post WHERE url = "'.$_POST['url'].'"') or mysql_die();
		list($quant) = mysql_fetch_row($result);
		if($quant == 0) {

			if(checkdate($_POST['data_m'], $_POST['data_d'], $_POST['data_y'])) {

				mysql_query('INSERT INTO post (titulo, url, data, texto) VALUES ("'.$_POST['titulo'].'", "'.$_POST['url'].'", "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", "'.$_POST['texto'].'")');
$log = 'INSERT INTO post (titulo, url, data, texto) VALUES ("'.$_POST['titulo'].'", "'.$_POST['url'].'", "'.$_POST['data_y'].'-'.( $_POST['data_m'] < 10 ? '0' : '' ).$_POST['data_m'].'-'.( $_POST['data_d'] < 10 ? '0' : '' ).$_POST['data_d'].' '.( $_POST['data_h'] < 10 ? '0' : '' ).$_POST['data_h'].':'.( $_POST['data_i'] < 10 ? '0' : '' ).$_POST['data_i'].'", "'.$_POST['texto'].'")';
include('log.php');
				if(mysql_affected_rows() > 0) {
					$id = mysql_insert_id();
					echo '<script type="text/javascript">'."\n";
					echo 'document.location.href = "index.php?m=posts&id='.$id.'";'."\n";
					echo "</script>\n";
					$_POST = array();
				} else {
					echo '<div class="erro">N&atilde;o foi poss&iacute;vel inserir o post.</div>';
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
}
if(count($_POST['titulo']) > 0) {
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
	</form>
<?php
}
?>
</body>
</html>