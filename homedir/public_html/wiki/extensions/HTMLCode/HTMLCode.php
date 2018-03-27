<?php
 
/*****************************************************************************
HTMLCode Extension
MediaWiki 1.5 and above

Installation:
  * Place SecureHTML.php in extensions/ under the MediaWiki tree.
  * Place SpecialSecureHTMLInput.php in includes/.
  * Add this to LocalSettings.php: include("extensions/HTMLCode/HTMLCode.php");

Usage: <htmlCode>HTML</htmlCode>

  HTML - The HTML you wish to display.

*****************************************************************************/

$wgExtensionFunctions[] = "wfHTMLCodeExtension";

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'HTML Code',
	'author' => 'G@ngrel',
	'url' => 'http://ga.ngrel.com/',
	'description' => 'Lets you include arbitrary HTML Code',
);


function wfHTMLCodeExtension() {
	global $wgParser;
	global $wgMessageCache;
	$wgParser->setHook( "htmlCode", "renderHTMLCode" );
	$wgMessageCache->addMessages(array('htmlcodeinput' => 'HTML Code Input'));
}

function renderHTMLCode( $input, $argv )
{
	return $input;
}
?>
