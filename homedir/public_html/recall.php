<?php
@header('Content-Type: text/javascript; charset=iso-8859-1');
@session_start();
$img = '/convite_web.jpg';                 $msg = '';
$img = '/convite_web_recall.jpg';          $msg = 'Veja o convite para o recall do livro Pelo Sangue e Pela Fé';
$img = '/convite_web_vendas.jpg';          $msg = 'Veja os locais de venda do livro Pelo Sangue e Pela Fé';
//$img = '/imagens/banner_mesa_redonda.jpg'; $msg = 'Clique aqui para visualizar o banner';

if(($size = @getimagesize(dirname(__FILE__).$img)) === false) {
	$size[1] = 0;
	$size[3] = '';
}
?>
<?php if(false) { ?><pre><script type="text/javascript"><?php } ?>
/*
 * Convite by G@ngrel
 */

height = ( window.innerHeight ? window.innerHeight : ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) );
document.write('<div id="convitePannel" style="z-index:3000;position:absolute;display:block;top:0;left:0;width:100%;height:1px;text-align:center;opacity:1;filter:alpha(opacity=100);overflow:hidden;">');
document.write(	'<div style="height:' + height + 'px;background:#000;opacity:0.66;filter:alpha(opacity=66);"></div>');
document.write(	'<div id="convite" style="margin-top:-' + (((height - <?=$size[1]?>) / 2) + <?=$size[1]?>) + 'px;opacity:0;filter:alpha(opacity=0);">');
document.write(		'<div style="width:<?=$size[0]?>px;margin:0 auto;text-align:right;opacity:1;filter:alpha(opacity=100);">');
document.write(			'<a href="#" style="color:#FFF;text-decoration:none;border-left:1px solid #000;border-right:1px solid #000;background:#000;font-family:Verdana;font-size:8pt;opacity:1;filter:alpha(opacity=100);" onclick="conviteFechar(); return false;">[Fechar]</a>');
document.write(		'</div>');
document.write(		'<img id="conviteImg" src="<?=$img?>" <?=$size[3]?> alt="" style="opacity:1;filter:alpha(opacity=100);" usemap="#mapaconvite" /><br />');
//document.write(		'<div style="background:#CCC;width:100px;height:100px;overflow:auto:opacity:1;filter:alpha(opacity=100);direction:rtl;" />');
//document.write(		'<div style="direction:ltr;">');
//document.write(			'...');
//document.write(		'</div>');
//document.write(		'</div>');
document.write(	'</div>');
document.write('</div>');

function conviteFechar()
{
	var obj = ( document.getElementById ? document.getElementById("convitePannel") : null );
	if(obj != null) {
		if(!obj.style) obj.style = obj;
		obj.style.display = "none";
		document.body.style.overflow = "auto";
	}
	conviteLinkMostra();
}

function conviteMove()
{
	var obj = ( document.getElementById ? document.getElementById("convitePannel") : null );
	if(obj != null) {
		if(!obj.style) obj.style = obj;
		if(obj.style.display != "none") {
			topPage = ( window.pageYOffset ? window.pageYOffset : document.body.scrollTop );
			obj.style.top = topPage + "px";
			setTimeout("conviteMove();", 30);
		}
	}
}

function conviteMostra(init)
{
	var bkg = ( document.getElementById ? document.getElementById("convitePannel") : null );
	var obj = ( document.getElementById ? document.getElementById("convite")       : null );
//	var img = ( document.getElementById ? document.getElementById("conviteImg")    : null );
	if(obj != null) { // && img != null) {
		if(!bkg.style) bkg.style = bkg;
		if(!obj.style) obj.style = obj;
//		if(!img.style) img.style = img;
		height = ( window.innerHeight ? window.innerHeight : ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) );
		wait = 100;
		if(init) {
			bkg.style.display = "block";
			bkg.style.height  = "1px";
			obj.style.zoom    = 1;
			obj.style.filter  = "alpha(opacity=0)";
			obj.style.opacity = "0";
			wait = 1000;
		} else if(bkg.style.height != height + "px") {
			if(!document.body.style) document.body.style = document.body;
			document.body.style.overflow = "hidden";
			h = parseInt(bkg.style.height) * 2;
			if(h == 0    ) h = 10;
			if(h > height) h = height;
			bkg.style.height = h + "px";
			wait = 10;
		} else { //if(img.complete) {
			opacity = parseInt(obj.style.opacity * 100) + 20;
			if(opacity >= 100) {
				opacity = 99;
				wait = 0;
			}
			obj.style.filter  = "alpha(opacity=" + opacity + ")";
			obj.style.opacity = opacity / 100;
		}
		if(wait > 0) setTimeout("conviteMostra(" + ( /*!img.complete*/ false ? "true" : "false" ) + ");", wait);
	}
}

function conviteInicia()
{
	var obj = ( document.getElementById ? document.getElementById("conviteLink") : null );
	if(obj != null) {
		if(!obj.style) obj.style = obj;
		obj.style.display = "none";
	}
	conviteMove();
	conviteMostra(true);
}

function conviteLinkMostra()
{
	var obj = ( document.getElementById ? document.getElementById("conviteLink") : null );
	if(obj != null) {
		if(!obj.style) obj.style = obj;
		if(obj.innerHTML == "") {
			obj.innerHTML = "<div align=\"center\"><a href=\"#\" onclick=\"conviteInicia(); return false;\"><?=htmlentities($msg)?></a></div>\n<br />\n<img src=\"divider.gif\" width=\"545\" height=\"3\" border=\"0\" alt=\"\" align=\"center\" /><br />\n<br />\n";
		}
		obj.style.display = "block";
	} else {
		setTimeout("conviteLinkMostra();", 1000);
	}
}

<?php
if(empty($_SESSION['convite']) || $_SESSION['convite'] === false) {
	$_SESSION['convite'] = true;
	echo "conviteInicia();\n";
} else {
	echo "conviteLinkMostra();";
}
?>
