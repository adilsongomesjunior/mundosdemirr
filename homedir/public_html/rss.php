<?php
require_once('mysql_connect.php');

header('Content-type: application/rss+xml; chatset=iso-8859-1');

echo '<'.'?xml version="1.0" encoding="ISO-8859-1"?'.">\n"; ?>
<rss version="2.0">
	<channel>
		<title>Mundos de Mirr</title>
		<link>http://www.mundosdemirr.com/blog</link>
		<description>Diário de Bordo de um escritor iniciante em mares bravios</description>
		<language>pt-br</language>
		<copyright>Copyright 2006 ~ <?php echo date('Y'); ?>, Claudio Villa</copyright>
<?php
$result = mysql_query('SELECT url, titulo, UNIX_TIMESTAMP(data) FROM post WHERE data <= NOW() ORDER BY data DESC LIMIT 8') or mysql_die();
if((list($url, $titulo, $data) = mysql_fetch_row($result)) !== false) {
	$ttl_data = mktime(0, 0, 0, date('n', $data), date('j', $data), date('Y', $data));
	if(date('N', $ttl_data) > 5) {
		$ttl_data = strtotime('next Monday', $ttl_data);
	}
	if(($ttl_data - time()) > (60 * 60 * 24 * 7)) {
		$ttl = 60 * 2;
	} else {
		$ttl = floor((strtotime('next Monday')- time()) / 60) + (4.5 * 60);
	}
?>
		<ttl><?=$ttl?></ttl>
<?php
/*
 <!-- 
if($ttl > (60 * 24)) { $d = floor($ttl / (60 * 24)).'d '; $ttl = $ttl % (60 * 24); } else { $d = ''; }
if($ttl >  60      ) { $h = floor($ttl /  60      )     ; $ttl = $ttl %  60      ; } else { $h =  0; }
                       $m = $ttl;
echo $d.str_pad($h, 2, '0', STR_PAD_LEFT).':'.str_pad($m, 2, '0', STR_PAD_LEFT);
 -->
*/
?>

		<lastBuildDate><?=substr(date('r', $data), 0, -14).'04:30:00 -0300'?></lastBuildDate>
<?php
	do {
		$titulo = html_entity_decode($titulo);
		$titulo = str_replace('<', '-', $titulo);
		$titulo = str_replace('>', '-', $titulo);
?>
		<item>
			<title><?=$titulo?></title>
<?php
//			<description>...</description>
?>
			<pubDate><?=substr(date('r', $data), 0, -14).'00:00:00 -0300'?></pubDate>
			<link>http://www.mundosdemirr.com/<?=$url?></link>
			<guid>http://www.mundosdemirr.com/<?=$url?></guid>
		</item>
<?php
	} while((list($url, $titulo, $data) = mysql_fetch_row($result)) !== false);
}
?>
	</channel>
</rss>
