<?php
if(file_exists("index_novo.php")) {
	if(file_exists("index_antigo.php")) {
		if(!unlink("index_antigo.php")) {
			die("Erro!!! Apagar index_antigo.php por FTP!");
		}
	}
	if(!rename("index.php", "index_antigo.php")) die("Erro!!! Não foi possível renomear index.php para index_antigo.php");
	if(!rename("index_novo.php", "index.php")) die("Erro!!! Não foi possível renomear index_novo.php para index.php");
	echo "<h1>OK!</h1>";
}