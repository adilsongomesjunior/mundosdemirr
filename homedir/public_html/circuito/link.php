<html>
<head>
	<title>Circuito</title>
	<style type="text/css">
	BODY {
		background: #FFF;
	}
	A {
		color: #FFF;
		text-decoration: none;
		font-size: 10pt;
	}
	</style>
	<script type="text/javascript">
	function up(h)
	{
		var a = document.getElementsByTagName("A"); a = a[0];
		var s = window.parseInt(a.style.fontSize.replace("pt", ""));
		a.style.fontSize = (s + 1) + "pt";
		if(s >= 200
		|| a.offsetHeight > (h * 2)
		|| a.offsetHeight > document.body.offsetHeight
		|| a.offsetWidth  > document.body.offsetWidth
		) { 
			a.style.fontSize = s + "pt";
			a.style.color    = "#000";
			return;
		}
		up(a.offsetHeight);
	}
	window.onload = function (e) {
		var a = document.getElementsByTagName("A"); a = a[0];
		a.style.color    = "#FFF";
		a.style.fontSize = "10pt";
		up(a.offsetHeight);
	};
	window.onresize = window.onload;
	</script>
</head>
<body>
	<table border="0" width="100%" height="100%">
		<tr>
			<td align="center">
				<a href="index.php" onclick="this.blur(); return true;">Circuito de aventuras Mirr</a>
			</td>
		</tr>
	</table>
</body>
</html>