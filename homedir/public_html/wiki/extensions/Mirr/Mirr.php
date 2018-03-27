<?php
 
$wgExtensionCredits['other'][] = array(
	'name'        => 'Mirr',
	'version'     => ExtMirr::VERSION,
	'author'      => '[http://www.mundosdemirr.com/ Gangrel]',
	'url'         => 'http://www.mundosdemirr.com/',
	'description' => 'patch html output customization'
);

$wgExtMirr = new ExtMirr();
$wgExtMirr->registerHooks();

class ExtMirr
{
	const VERSION = '0.1';

	public static $mTable       = array();
	public static $mTableRegExp = array();

	function setupExtensionFunction()
	{
		global $wgParser;

		$wgParser->setHook('twitter', array($this, 'twitter'));
	}

	function twitter($input, $args, $parser)
	{
		if(!isset($args['twitter'])) return '&lt;twitter&gt;Define a Twitter account&lt;/twitter&gt;';

		$args['width']      = ( isset($args['width']     ) ? $args['width']      : 250 );
		$args['height']     = ( isset($args['height']    ) ? $args['height']     : 300 );
		$args['shellbg']    = ( isset($args['shellbg']   ) ? $args['shellbg']    : '#000' );
		$args['shellcolor'] = ( isset($args['shellcolor']) ? $args['shellcolor'] : '#FFF' );
		$args['tweetbg']    = ( isset($args['tweetbg']   ) ? $args['tweetbg']    : '#000' );
		$args['tweetcolor'] = ( isset($args['tweetcolor']) ? $args['tweetcolor'] : '#FFF' );
		$args['links']      = ( isset($args['links']     ) ? $args['links']      : '#CCC' );

		$html = '<script src="http://widgets.twimg.com/j/2/widget.js"></script>';
		$html.= '<script>';
		$html.= 'new TWTR.Widget(';
		$html.= '	{';
		$html.= '		version: 2,';
		$html.= '		type: "profile",';
		$html.= '		rpp: 6,';
		$html.= '		interval: 6000,';
		$html.= '		width: '.$args['width'].',';
		$html.= '		height: '.$args['height'].',';
		$html.= '		theme: {';
		$html.= '			shell: {';
		$html.= '				background: "'.$args['shellbg'].'",';
		$html.= '				color: "'.$args['shellcolor'].'"';
		$html.= '			},';
		$html.= '			tweets: {';
		$html.= '				background: "'.$args['tweetbg'].'",';
		$html.= '				color: "'.$args['tweetcolor'].'",';
		$html.= '				links: "'.$args['links'].'"';
		$html.= '			}';
		$html.= '		},';
		$html.= '		features: {';
		$html.= '			scrollbar: false,';
		$html.= '			loop: false,';
		$html.= '			live: true,';
		$html.= '			hashtags: true,';
		$html.= '			timestamp: true,';
		$html.= '			avatars: true,';
		$html.= '			behavior: "all"';
		$html.= '		}';
		$html.= '	}';
		$html.= ').render().setUser("'.$args['twitter'].'").start();';
		$html.= '</script>';

		return $html;
	}


	function addMagicWord(&$magicWords, $langCode)
	{
		$magicWords['twitter'] = array(0, 'twitter');

		return true;
	}

	public function onBeforePageDisplay(&$out)
	{
		//echo '<pre style="border:1px solid #000; background:#FFF; coLor: #000; padding: 10px; padding: 0; margin: 0; text-align: left;">'.htmlentities(print_r(get_class_vars(get_class($out)), true)).'</pre>';
		//echo '<pre style="border:1px solid #000; background:#FFF; coLor: #000; padding: 10px; padding: 0; margin: 0; text-align: left;">'.htmlentities($out->mBodytext).'</pre>';
		//echo '<pre style="border:1px solid #000; background:#FFF; coLor: #000; padding: 10px; padding: 0; margin: 0; text-align: left;">'.htmlentities(print_r(ExtMirr::$mTable, true)).'</pre>';

		foreach(self::$mTable as $from => $to) {
			$out->mPagetitle = str_replace($from, $to, $out->mPagetitle);
			$out->mBodytext  = str_replace($from, $to, $out->mBodytext );
		}
		foreach(self::$mTableRegExp as $from => $to) {
			$out->mPagetitle = preg_replace($from, $to, $out->mPagetitle);
			$out->mBodytext  = preg_replace($from, $to, $out->mBodytext );
		}

		return true;
	}

	public function registerHooks()
	{
		global $wgHooks;
		global $wgExtensionFunctions;

		//ExtMirr::$mTable['123'] = '1 2 3';

		ExtMirr::$mTableRegExp['/([^=]|^)Categoria[:]/'] = '\1';

		$wgHooks['BeforePageDisplay'][] = array($this, 'onBeforePageDisplay');
		$wgHooks['LanguageGetMagic' ][] = array($this, 'addMagicWord');
		$wgExtensionFunctions[]         = array($this, 'setupExtensionFunction');

	}
}