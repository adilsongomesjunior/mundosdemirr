<?php
session_start();

$_SESSION['ok'] = false;

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	if($_POST['user'] == 'paul'
	&& $_POST['pass'] == 'paz'
	) {
		$_SESSION['ok'] = true;
		$log = 'login ok';
	} else {
		$log = 'try login with: '.$_POST['user'].' / '.$_POST['pass'];
	}
	include('log.php');
}

header('Location: index.php');
?>