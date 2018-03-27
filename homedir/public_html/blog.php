<?php
error_reporting(E_ALL);

header('Content-Type: text/html; charset=iso-8859-1');

$arquivos = array(
	'Wiki'                   => 'wiki/',
	'O Autor'                => 'o_autor',
	'Not&iacute;cias'        => 'noticias',
	'Livros'                 => 'livros',
	'Agradecimentos'         => 'agradecimentos',
	'Contato'                => 'contato',
	'RSS'                    => array('rss', 'http://www.mundosdemirr.com/rss'),
//	'Pr&eacute;-Venda'       => 'pre_venda',
//	'T2G - Tale of Two Gods' => 't2g',
	'.Posts Recentes'        => 'posts_recentes',
	'.Arquivos'              => 'arquivos',
	'.Links'                 => 'links'
);

$GLOBALS['meses'] = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 
'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$GLOBALS['dias_da_semana'] = array('Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 
'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'S&aacute;bado');

echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt_BR">

<head>
	<title>Mundos de Mirr</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="estilos.css" />
	<script type="text/javascript" src="script.js"></script>
<head>

<body>
	<div id="main">
		<div id="head">
			<a href="http://www.mundosdemirr.com/" title="Home" id="backHome">
				<h1>Di&aacute;rio de Bordo</h1>
				<h2>de um escritor iniciante em mares bravios</h2>
				<hr />
			</a>
			<div id="contador"></div>
		</div>
<?php
require_once('mysql_connect.php');
?>
		<div id="menu">
			<hr />
			<span id="menuHead"></span>
			<div id="menuBody">
<?php
foreach($arquivos as $label => $basename) {
	if($label[0] != '.') {
		if(is_array($basename)) {
			$link     = $basename[1];
			$basename = $basename[0];
		} else {
			$link = $basename;
		}
		$link = ( strpos($link, '/') === false ? 'blog.php?pg='.$link : $link );
?>
				<a href="<?=$link?>"><img src="menu_<?=str_replace('/', '', $basename)?>.jpg" width="147" height="61" border="0" alt="<?=$label?>" /></a>
<?php
	}
}
?>
			</div>
			<span id="menuFoot"></span>
			<hr />
<?php
foreach($arquivos as $label => $basename) {
	if($label[0] == '.') {
		$funcname = 'menu_'.$basename;
		if(function_exists($funcname)) $funcname($basename, substr($label, 1));
	}
}
?>
			<!-- selos -->
			<!-- ... -->
			<!--
				<a href="rss.php"><img src="rss.gif" width="80" height="80" border="0" alt="RSS" /></a>
			-->

			<!-- ???
			<script language="JavaScript" type="text/javascript">var $d=new Date(document.lastModified);$p="53O"+$d.getDate()+"O"+$d.getMonth()+"O"+$d.getFullYear()+"O"+$d.getHours()+"O"+$d.getMinutes()+"O"+$d.getSeconds();document.write('<scr'+'ipt language="JavaScript" type="text/javascript" src="http://www.coca-cola.com.br/cokeringstamp.js?p='+$p+'&u=http://www.mundosdemirr.com"></scr'+'ipt>');</script>
			-->

		</div>
		<div id="body">
			<span id="conviteLink"></span>
<?php
if(empty($_GET['pg']) || !in_array($_GET['pg'], $arquivos)) {
	$_GET['pg']   = 'arquivos';
//	$_GET['data'] = date('y-m');
	$com_titulo   = false;
	if(file_exists('pg_home.php')) include_once('pg_home.php');
}
include_once('pg_'.$_GET['pg'].'.php');
?>
		</div>
		<div id="foot">
			<br />
			<img src="divider2.gif" width="600" height="3" border="0" alt="" /><br />
			<br />
			Copyright &copy; 2006 ~ 2007 - Claudio Villa<br />
			Todo conte&uacute;do deste blog &eacute; protegido por leis de copyright,<br />
			se deseja reproduzir parte de seu conte&uacute;do original, favor entrar em contato.<br />
			<br />

			<!-- Site Meter -->
			<script type="text/javascript" src="http://s22.sitemeter.com/js/counter.js?site=s22atreidestm"></script>
			<noscript>
				<a href="http://s22.sitemeter.com/stats.asp?site=s22atreidestm" target="_top"><img src="http://s22.sitemeter.com/meter.asp?site=s22atreidestm" alt="Site Meter" border="0"/></a>
			</noscript>
			<!-- Copyright (c) 2006 Site Meter -->

		</div>
	</div>
<?php
//	<script type="text/javascript" src="recall.php"></script>
?>
	<map name="mapaconvite">
		<area coords="14,145,247,204"  alt="Livraria Saraiva" href="http://www.livrariasaraiva.com.br/produto/produto.dll/detalhe?pro_id=2084275" />
		<area coords="18,218,242,253"  alt="Livraria Cultura" href="http://www.livrariacultura.com.br/scripts/cultura/resenha/resenha.asp?nitem=11016749" />
		<area coords="14,273,231,352"  alt="Livraria Sobrado" href="http://www.livrariasobrado.com.br/" />
		<area coords="13,361,90,439"   alt="Siciliano"        href="http://www.siciliano.com.br/produto/produto.dll/detalhe?pro_id=2084275" />
		<area coords="109,363,201,441" alt="Fnac"             href="http://www.fnac.com.br/Product.aspx?idProduct=858781254" />
		<area coords="214,376,331,436" alt="Livraria Nobel"   href="http://www.livrarianobel.com.br/" />
	</map>
<?php
//	<script type="text/javascript" src="convite.php"></script>
//	<script type="text/javascript" src="contador/contador.php?id=contador"></script>
?>
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-22917947-1']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
</body>

</html>

<?php

function space_count($str)
{
	$spaces = array(
		ord(' ') =>  3, ord('A') =>  9, ord('B') =>  8, ord('C') => 8, ord('D') => 9, ord('E') =>  8, ord('F') =>  7, ord('G') =>  9,
		ord('H') => 10, ord('I') =>  4, ord('J') =>  7, ord('K') => 8, ord('L') => 7, ord('M') => 11, ord('N') => 10, ord('O') =>  9,
		ord('P') =>  7, ord('Q') =>  9, ord('R') =>  8, ord('S') => 7, ord('T') => 8, ord('U') =>  9, ord('V') =>  9, ord('W') => 12,
		ord('X') =>  9, ord('Y') =>  8, ord('Z') =>  7, ord('a') => 7, ord('b') => 7, ord('c') =>  6, ord('d') =>  7, ord('e') =>  6,
		ord('f') =>  4, ord('g') =>  7, ord('h') =>  8, ord('i') => 4, ord('j') => 4, ord('k') =>  7, ord('l') =>  4, ord('m') => 12,
		ord('n') =>  8, ord('o') =>  6, ord('p') =>  7, ord('q') => 7, ord('r') => 6, ord('s') =>  5, ord('t') =>  5, ord('u') =>  8,
		ord('v') =>  8, ord('w') => 10, ord('x') =>  7, ord('y') => 8, ord('z') => 5, ord('1') =>  7, ord('2') =>  8, ord('3') =>  8,
		ord('4') =>  8, ord('5') =>  7, ord('6') =>  8, ord('7') => 8, ord('8') => 8, ord('9') =>  8, ord('0') =>  8, ord('"') =>  4,
		ord('\'')=>  2, ord('!') =>  4, ord('@') => 12, ord('#') => 8, ord('$') => 7, ord('%') => 10, ord('¨') =>  6, ord('&') =>  9,
		ord('*') =>  6, ord('(') =>  5, ord(')') =>  5, ord('_') => 8, ord('+') => 9, ord('-') =>  4, ord('=') =>  9, ord('`') =>  6,
		ord('´') =>  6, ord('{') =>  6, ord('}') =>  6, ord('[') => 5, ord(']') => 5, ord('^') =>  8, ord('~') =>  8, ord(':') =>  4,
		ord(';') =>  4, ord('?') =>  6, ord('/') =>  6, ord('°') => 5, ord('º') => 6, ord('ª') =>  6, ord('§') =>  6, ord('¹') =>  6,
		ord('²') =>  6, ord('³') =>  6, ord('£') =>  7, ord('¢') => 7, ord('¬') => 9, ord('<') =>  9, ord('>') =>  9, ord(',') =>  4,
		ord('.') =>  4, ord('|') =>  5, ord('\\')=>  6
	);

	$max = 12;

	$len = 0;
	for($i = 0; $i < strlen($str); $i++) {
		$len+= ( array_key_exists(ord($str{$i}), $spaces) ? $spaces[ord($str{$i})] : $max );
	}

	return $len;
}

function menu_posts_recentes($basename, $label)
{
	echo '			<img src="menu_'.$basename.'.gif" width="146" height="28" border="0" alt="'.$label.'" /><br />'."\n";
	if($result = @mysql_query('SELECT url, titulo FROM post WHERE data <= NOW() ORDER BY data DESC LIMIT 5')) {
		echo '			<table border="0" cellpadding="0" cellspacing="0" align="center">'."\n";
		echo "				<tr>\n";
		echo '					<td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>'."\n";
		echo '					<td align="left" id="arquivos">'."\n";
		while(list($url, $titulo) = mysql_fetch_row($result)) {
			if(space_count(html_entity_decode($titulo)) > 182) {
				$titulo = substr(html_entity_decode($titulo), 0, -1).'...';
				while(space_count($titulo) > 182) {
					$titulo = substr($titulo, 0, -4).'...';
				}
				$titulo = htmlentities($titulo);
			}
			echo '						<a href="/'.$url.'" style="width:182px;overflow:hidden;"><nobr>'.$titulo."</nobr><br /></a>\n";
//			echo "						<br />\n";
		}
		echo "					</td>\n";
//		echo '					<td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>'."\n";
		echo "		</tr>\n";
		echo "</table>\n";
	}
	echo "			<hr />\n";
	echo "			<br />\n";
}

function menu_arquivos($basename, $label)
{
	echo '			<img src="menu_'.$basename.'.gif" width="84" height="32" border="0" alt="'.$label.'" /><br />'."\n";
	if($result = @mysql_query('SELECT YEAR(data), MONTH(data) FROM post WHERE data <= NOW() GROUP BY 1, 2 ORDER BY 1 DESC, 2 ASC')) {
		$ano_atual = 0;
		echo '			<table border="0" cellpadding="0" cellspacing="0" align="center" width="90"><tr><td align="left" id="arquivos">'."\n";
		while(list($ano, $mes) = mysql_fetch_row($result)) {
			if($ano_atual == 0 || $ano_atual != $ano) {
				if($ano_atual != 0) {
					echo "					<br />";
					echo "				</div>\n";
					echo '				<script type="text/javascript">show_hide(\'arquivos'.$ano_atual.'\');</script>';
				}
				$ano_atual = $ano;
				echo '				<a href="#" onclick="show_hide(\'arquivos'.$ano.'\'); return false;"><b>+ '.$ano."</b></a>\n";
				echo '				<div id="arquivos'.$ano.'">'."\n";
			}
			echo '					<a href="blog.php?pg='.$basename.'&data='.$ano.'-'.$mes.'">&nbsp; &nbsp; '.$GLOBALS['meses'][$mes]."</a>\n";
		}
		if($ano_atual != 0) {
			echo "				</div>\n";
			echo '				<script type="text/javascript">show_hide(\'arquivos'.$ano_atual.'\');</script>';
		}
		echo "			</td></tr></table>\n";
	}
	echo "			<hr />\n";
	echo "			<br />\n";
}

function menu_links($basename, $label)
{
	echo '			<img src="menu_'.$basename.'.gif" width="66" height="32" border="0" alt="'.$label.'" /><br />'."\n";

	$links = array(
		'Universo Fantástico'              => 'http://www.universofantastico.com.br/',
		'Jovem Nerd'		           => 'http://jovemnerd.ig.com.br/',
		'Dragões do Éter'	           => 'http://www.raphaeldraccon.com/blog/',
		'Crianças da Noite (Blognovela)'   => 'http://falerpg.com.br/cdn/',
		'Blog Insonia'                     => 'http://bloginsonia.wordpress.com',
		'Velocidade'                       => 'http://www.velocidade.org/',
		'Grimelken'                        => 'http://www.grinmelken.com.br/',
		'Ciranda da Bailarina'             => 'http://www.my_eyes.blogger.com.br/',
		'Dros&oacute;fila Bas&oacute;fila' => 'http://drosofila.blogspot.com/',
		'Only If Time'                     => 'http://mariceres.blogspot.com/',
		'Som no Blog'                      => 'http://somnoblog.blogspot.com/',
		'Estante M&aacute;gica'            => 'http://estantemagica.blogspot.com/',
		'Doces Pensantes'                  => 'http://docespensantes.blogspot.com/',
		'Em Busca dos Sete Mares'          => 'http://diario-uruz.blogspot.com/',
		'Necropolis'                       => 'http://necropolis-vf.blogspot.com/',
		'Obvious'                          => 'http://blog.uncovering.org/',
		'Livros Legais'                    => 'http://livroslegais.blog.terra.com.br/',
		'Contos de Anera'                  => 'http://contos-de-aneras.blogspot.com/',

	);

	foreach($links as $label => $link) {
		echo '			<a href="'.$link.'">'.$label."</a><br />\n";
	}
	echo "			<hr />\n";
	echo "			<br />\n";
}

?>