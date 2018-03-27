<?php

header('Content-type: text/plain; charset=iso-8859-1');

$no_specials = ( !empty($_GET['nospecials']) && ($_GET['nospecials'] == '1' || $_GET['nospecials'] == 'true') ? true : false );

$str = ( !empty($_GET['str']) ? $_GET['str'] : 'no str' );

$str = html_entity_decode($str);
$str = strtr($str, '. בגהאדְֱֲֳִיךכטֹÊָֻםמןלֽ־ּֿףפצעץ׃װײׂױתûüשÚÛÜÙחַסׁ',
                   '__aaaaaAAAAAeeeeEEEEiiiiIIIIoooooOOOOOuuuuUUUUcCnN');
$str = ereg_replace('[^a-zA-Z0-9_'.( $no_specials ? '' : '\\[\\]\\(\\)\\.\\-' ).']', '', $str);
$str = ereg_replace('_+', '_', $str);
$str = ereg_replace('(^_|_$)', '', $str);

echo strtolower($str);

?>