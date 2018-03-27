<?php
if(!empty($_GET['path']) && in_array($_GET['path'], array('blog', 'rss'))) {
	header('Location: /'.$_GET['path'].'.php');
} else {
	if(!empty($_GET['path']) && ereg('^([a-zA-Z0-9_]+)$', $_GET['path'], $matches)) {
		require_once('mysql_connect.php');
		$result = mysql_query('SELECT id FROM post WHERE url = "'.$matches[1].'"') or mysql_die();
		if(mysql_num_rows($result) == 1) list($id) = mysql_fetch_row($result);
	}
	if(!empty($id)) {
		header('Content-Type: text/html; charset=iso-8859-1');
		readfile('http://'.$_SERVER['HTTP_HOST'].'/blog.php?pg=arquivos&id='.$id);
	} else if(!empty($_GET['path']) && is_dir($_GET['path'])) {
		header('Location: /'.$_GET['path'].'/index.php');
	} else {
		header('HTTP/1.0 404 Not Found');
	}
}
