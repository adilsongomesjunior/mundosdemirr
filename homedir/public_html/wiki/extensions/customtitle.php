<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo <<<HEREDOC
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/CustomTitle/CustomTitle.php" );
HEREDOC;
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	"name" => "CustomTitle extension",
	"author" => "http://www.fckeditor.net",
	"version" => 'customtitle/mw-extension 1.0 2008',
	"url" => "http://www.mediawiki.org/wiki/Extension:CustomTitle",
	"description" => "CustomTitle extension"
);

$oCustomTitleExtension = new CustomTitle_MediaWiki();
$oCustomTitleExtension->registerHooks();

$wgExtensionFunctions[] = array($oCustomTitleExtension, "setupExtensionFunction");
$wgHooks['LanguageGetMagic'][] = array($oCustomTitleExtension, "addMagicWord");


class CustomTitle_MediaWiki
{
	protected $customTitle;
	protected $customPageTitle;

	function setupExtensionFunction()
	{
		global $wgParser;

		$wgParser->setFunctionHook( 'customtitle', array($this, "substitute"));        
	}

	function substitute(&$parser, $param1 = '', $param2 = '')
	{
		$ret = "";
		if ($param1 !== '')
			$ret .= "xxx-CustomTitleStart-xxx". $param1 ."xxx-CustomTitleEnd-xxx";
		if ($param2 !== '')
			$ret .= "xxx-CustomPageTitleStart-xxx". $param2 ."xxx-CustomPageTitleEnd-xxx";
		return $ret;        
	}

	function addMagicWord(&$magicWords, $langCode)
	{
		$magicWords['customtitle'] = array( 0, 'customtitle' );

		return true;
	}

	function onSkinTemplateOutputPageBeforeExec(&$m_skinTemplate, &$m_tpl)
	{
		if (isset($this->customTitle))
			$m_tpl->set('title', $this->customTitle);
		if (isset($this->customPageTitle))
			$m_tpl->set('pagetitle', $this->customPageTitle);

		return true;
	}

	function onOutputPageBeforeHTML(&$out, &$text)
	{
		if (($found = strpos($text, 'xxx-CustomTitleStart-xxx')) !== false) {
			if (preg_match("/xxx-CustomTitleStart-xxx(.*?)xxx-CustomTitleEnd-xxx/", $text, $matches)) {
				$this->customTitle = $matches[1];
				$text = str_replace($matches[0], "", $text);
			}
		}

		if (($found = strpos($text, 'xxx-CustomPageTitleStart-xxx')) !== false) {
			if (preg_match("/xxx-CustomPageTitleStart-xxx(.*?)xxx-CustomPageTitleEnd-xxx/", $text, $matches)) {
				$this->customPageTitle = $matches[1];
				$text = str_replace($matches[0], "", $text);
			}
		}

		return true;
	}

	public function registerHooks() {
		global $wgHooks;

		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array($this, 'onSkinTemplateOutputPageBeforeExec');
		$wgHooks['OutputPageBeforeHTML'][] = array($this, 'onOutputPageBeforeHTML');
	}
}