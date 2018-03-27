<html><head><title>Contador</title></head><body>	<code>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<b>Valor:</b> <input type="text" name="valor" size="9" maxlength="9" /> <input type="submit" value="Inserir" /> <i>Ex.: 12.000,00</i><br />
		</form>
	</code>
	<pre><?php
if(isset($_POST['valor']) && ereg('^([0-9]{1,3}(\.[0-9]{3}))(,([0-9]{2}))?$', $_POST['valor'], $matches)) {
	$valor = str_replace('.', '', $matches[1]).'.'.str_pad($matches[4], 2, '0', STR_PAD_RIGHT);
	mysql_query('INSERT INTO contador (hora, valor) VALUES (NOW(), '.$valor.')') or die(mysql_error());
$log = 'INSERT INTO contador (hora, valor) VALUES (NOW(), '.$valor.')';
include('log.php');
}

$result = mysql_query('SELECT DATE_FORMAT(hora, "%d/%m/%Y %h:%i"), valor FROM contador ORDER BY hora DESC') or die(mysql_error());
$rows = mysql_num_rows($result);
if($rows != 0) {
	while(list($data, $valor) = mysql_fetch_row($result)) {
		echo $data.' - <b>R$ '.number_format($valor, 2, ',', '.')."</b>\n";
	}
}
?></pre>