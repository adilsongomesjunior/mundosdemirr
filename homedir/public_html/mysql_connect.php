<?php

/* ------------------------------------------------------------------------- */
function mysql_die($msg = '')
{
	echo '<hr />';
	if(!empty($msg)) echo $msg.'<hr />';
	echo mysql_error();
	echo "<hr />\n";
	$bt = debug_backtrace();
	echo "<!--\n".print_r($bt, true)."\n-->";
//	echo '<hr />';
	die();
}
/* ------------------------------------------------------------------------- */

mysql_connect('localhost', 'mundosde_mirr', 'cn93p34i') or mysql_die();
mysql_select_db('mundosde_mirr') or mysql_die();

/* ------------------------------------------------------------------------- */
function mysql_get_sets($table, $column)
{
	$result = mysql_query('SHOW COLUMNS FROM '.$table.' LIKE "'.$column.'"') or mysql_die();
	if(($row = mysql_fetch_assoc($result)) !== false) {
		$sets = $row['Type'];
		$sets = substr($sets, 5, strlen($sets) - 7);
	} else {
		$sets = '';
	}
	mysql_free_result($result);
	return explode("','", $sets);
}
/* ------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------- */
function mysql_get_enums($table, $column)
{
	$result = mysql_query('SHOW COLUMNS FROM '.$table.' LIKE "'.$column.'"') or mysql_die();
	if(($row = mysql_fetch_assoc($result)) !== false) {
		$enums = $row['Type'];
		$enums = substr($enums, 6, strlen($enums) - 8);
	} else {
		$enums = '';
	}
	mysql_free_result($result);
	return explode("','", $enums);
}
/* ------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------- */
function text_entities($text)
{
	$trans_tbl = get_html_translation_table(HTML_ENTITIES);

	unset($trans_tbl['<']);
	unset($trans_tbl['>']);
	unset($trans_tbl[' ']);
	unset($trans_tbl['&']);
	unset($trans_tbl['"']);
	$text = strtr($text, $trans_tbl);

	return $text;
}
/* ------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------- */
function str_flat($string, $no_specials = false)
{
	$string = html_entity_decode($string);
	$string = strtr($string, '. áâäàãÁÂÄÀÃéêëèÉÊËÈíîïìÍÎÏÌóôöòõÓÔÖÒÕúûüùÚÛÜÙçÇñÑ',
	                         '__aaaaaAAAAAeeeeEEEEiiiiIIIIoooooOOOOOuuuuUUUUcCnN');
	$string = ereg_replace('[^a-zA-Z0-9_'.( $no_specials ? '' : '\\[\\]\\(\\)\\.\\-' ).']', '', $string);
	$string = ereg_replace('_+', '_', $string);

	return $string;
}
/* ------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------- */
function valid_email($email)
{
	return eregi('^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$', $email);
}
/* ------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------- */
function text_adj($text, $admin = false)
{
	$text = strtr($text, array("\r\n" => "\n", "\r" => "\n"));

	$text = strtr('&nbsp;&nbsp;&nbsp;&nbsp;'.$text, array(
		'[i]' => '<i>', '[/i]' => '</i>',
		'[b]' => '<b>', '[/b]' => '</b>',

		"\n"     => "<br />\n&nbsp;&nbsp;&nbsp;&nbsp;"
	));

	$text = str_replace('&nbsp;&nbsp;&nbsp;&nbsp;<br />', '<br />', $text);

	$youtube       = '(&nbsp;&nbsp;&nbsp;&nbsp;)?http:\/\/www.youtube.com/watch\?v=([a-zA-Z0-9_]+)(<br \/>)?';
	$album         = '^(.*)\[album=([^]]+)\](.*)$';           // TODO: make it better
	$regexp_img    = '\[img=([^]]+)\]';                       // TODO: make it better
	$regexp_link_1 = '\[link\]([^[]+)\[/link\]';                         // TODO: 
	$regexp_link_2 = '\[link=([^]]+)\]('.$regexp_img.'|[^[]+)\[/link\]'; // TODO: 

	// Youtube
	$text = ereg_replace($youtube, '<div align="center"><object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/\2"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/\2" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object></div>', $text);

	// Album
	while(ereg($album, $text, $matches)) {
		$text = $matches[1];
		$dir  = ( $admin ? '../' : '' ).'albuns/'.$matches[2].'/';
		$id   = 'album_'.$matches[2].'_foto';
		if(file_exists($dir) && is_dir($dir)) {
			$text.= '<div style="text-align:center;">';
			$text.= '<div class="album">';
			$text.= '<table border="0" cellpadding="0" cellspacing="0">';
			$text.= '<tr>';
			$text.= '<td class="foto" id="'.$id.'"></td>';
			$text.= '</tr>';
			$text.= '</table>';
			$text.= '<div class="fotos">';
			$text.= '<table border="0" cellpadding="0" cellspacing="0">';
			$text.= '<tr>';
			$first = true;
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(ereg('^(.+)P.jpg$', $file, $matches)) {
						$text.= '<td>';
						$text.= '<a href="'.$dir.$matches[1].'G.jpg" target="foto" onclick="return !album_foto(this.href, \''.$id.'\');">';
						$text.= '<img src="'.$dir.$file.'" /><br />';
						$text.= '</a>';
						$text.= '<td>';
						if($first) {
							$text.= '<script type="text/javascript">'."\n";
							$text.= "<!-- //\n";
							$text.= 'album_foto(\''.$dir.$matches[1].'G.jpg\', \''.$id.'\');';
							$text.= "// -->\n";
							$text.= "</script>\n";
							$first = false;
						}
					}
				}
			}
			$text.= '</tr>';
			$text.= '</table>';
			$text.= '</div>';
			$text.= '</div>';
			$text.= '</div>';
			$text.= "\n";
		} else {
			$text.= '<div style="border:1px solid #000;background-color:#FFF;color:#000;">Album '.$matches[2].' inexistente.</div>';
		}
		if(isset($matches[3])) {
			$text.= $matches[3];
		}
	}

	// Link
	$text = ereg_replace($regexp_link_1, '<a href="\1">\1</a>', $text);
	$text = ereg_replace($regexp_link_2, '<a href="\1">\2'.( $admin ? ' [<u>\1</u>]' : '' ).'</a>', $text);

	$text = ereg_replace('&nbsp;&nbsp;&nbsp;&nbsp;((<a href="[^"]*">)?'.$regexp_img.'('.( $admin ? ' \[<u>[^<]+</u>\]' : '' ).'</a>)?)(<br />('."\n".'&nbsp;&nbsp;&nbsp;&nbsp;))?', '\1\6', $text);

	// Image
	$text = ereg_replace($regexp_img, '<img src="'.( $admin ? '../' : '' ).'imagens/\1" align="left" hspace="3" />', $text);

	return $text;
}
/* ------------------------------------------------------------------------- */
?>