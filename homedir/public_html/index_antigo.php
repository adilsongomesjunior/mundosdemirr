<?php
error_reporting(E_ALL);
header('Content-Type: text/html; charset=iso-8859-1');
echo '<'.'?xml version="1.0" encoding="iso-8859-1"?'.">\n"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt_BR">

<head>
	<title>Mundos de Mirr</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript">
	<!-- //
	function adj_msg()
	{
		var height = ( window.innerHeight ? window.innerHeight : ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) );
		var obj = ( document.getElementById ? document.getElementById("msg") : null );
		if(obj == null || height == 0) return;
		move_obj_to("msg", 0, (height - 450) / 2, 7, 50);
	}
	function move_obj_to(obj_name, pos, to, step, delay)
	{
		var obj = ( document.getElementById ? document.getElementById(obj_name) : null );
		if(obj == null) return;
		if(!obj.style) obj.style = obj;
		obj.style.marginTop = pos + "px";
		obj.style.marginBottom = pos + "px";
		if(pos >= to) return;
		pos+= step;
		if(pos > to) pos = to;
		window.setTimeout("move_obj_to(\"" + obj_name + "\", " + pos + ", " + to + ", " + step + ", " + delay + ")", delay);
	}
	// -->
	</script>
<head>

<body style="background-color:#483521;text-align:center;margin:0" onload="adj_msg();">
	<img src="imagens/blog_fechado.jpg" width="700" height="450" alt="" id="msg" usemap="#link" border="0" /><br />
	<img src="imagens/banner_mesa_redonda.jpg" /><br />
	<map name="link">
		<area coords="10,398,260,428" href="mailto:contato@mundosdemirr.com" />
	</map>
</body>

</html>