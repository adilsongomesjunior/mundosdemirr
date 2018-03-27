<?php if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { header('Location: blog.php?pg='.substr(basename(__FILE__), 3, -4)); die(); }
if(!isset($com_titulo) || $com_titulo != false) {
	echo "			<h2>Not&iacute;cias</h2>\n";
	echo '			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />'."\n";
	echo "			<br />";
}
?>

			<p>
				Neste canal, voc&ecirc; poder&aacute; acompanhar as ultimas novidades sobre a publica&ccedil;&atilde;o de meus trabalhos al&eacute;m de noticias relacionadas ao universo da literatura fant&aacute;stica. Caso deseje receber essas e outras atualiza&ccedil;&otilde;es em seu e-mail basta se cadastrar na lista de mailing. O endere&ccedil;o &eacute;:
				<div align="center"><a href="http://groups.google.com/group/mundosdemirr/subscribe">http://groups.google.com/group/mundosdemirr/subscribe</a></div>
			</p>
			<br />
			<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />
			<br />

<?php
$query = 'SELECT titulo, UNIX_TIMESTAMP(data), texto FROM noticia WHERE data <= NOW() ORDER BY data DESC';
$result = mysql_query($query) or mysql_die();
while(list($titulo, $data, $texto) = mysql_fetch_row($result)) {
	$texto = text_adj($texto);
	$texto = str_replace("\n", "\n					", $texto)."\n";
?>
			<div class="post">
				<?=$GLOBALS['dias_da_semana'][date('w', $data)].date(', d \\d\\e ', $data).$GLOBALS['meses'][intval(date('m', $data))].date(' \\d\\e Y', $data);?>
				<h3><?=$titulo?></h3>
				<blockquote>
					<?=$texto?>
				</blockquote>
				<br />
				<blockquote>
					&nbsp; 
					por Claudio Villa<br />
				</blockquote>
				<img src="divider.gif" width="545" height="3" border="0" alt="" align="center" /><br />
				<br />
			</div>
<?php
}
?>