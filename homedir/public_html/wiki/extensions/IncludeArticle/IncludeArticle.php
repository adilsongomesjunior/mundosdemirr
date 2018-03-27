<?php
# Include Article Extension
# author Markus Rückerl, bomber-online.de
# copyright © 2007 Markus Rückerl
# licence GNU General Public Licence 2.0 or later
 
if( !defined('MEDIAWIKI') ) {
  die();
}
 
$wgExtensionFunctions[] = "wfIncArticleExtension";
$wgExtensionCredits['parserhook'][] = array(
  'name' => 'IncludeArticle',
  'author' => 'Markus Rueckerl',
  'url' => 'http://www.mediawiki.org/wiki/Extension:IncludeArticle',
  'description' => 'Allows the inclusion of any article to be shown on any wiki page.'
);
 
function wfIncArticleExtension() {
    global $wgParser;
    $wgParser->setHook( "IncArticle", "renderIncArticle" );
}
 
function renderIncArticle( $input, $argv, &$parser ) {
    global $wgUser;
    $newvariables[] = array();
    if (!isset($argv["start"])){$argv["start"]=0;}     
    if (!isset($argv["count"])){$argv["count"]=200;}
    if (!isset($argv["lines"])){$argv["lines"]=false;}
    if (!isset($argv['namespaces'])){$argv['namespaces']=0;}
    if (!isset($argv["article"])){$argv["article"]=getrandompage($argv['namespaces']);}
    if (isset($argv["random"])){$argv["article"]=getrandompage($argv['namespaces']);}
    $articlestart = $argv["start"];
	if($argv["count"] != '*') {
	    $articleend = $argv["count"] + $articlestart;
	} else {
	    $articleend = '*';
	}
    $preloadTitle = Title::newFromText( $argv["article"] );
    if ( isset($preloadTitle ) && $preloadTitle->userCanRead())
    {
       $rev=Revision::newFromTitle($preloadTitle);
       if ( is_object( $rev ) )
       {
          $text = $rev->getText();
          $text = preg_replace( '~</?includeonly>~', '', $text );
          $aTitlecomp = $rev->getTitle()->getPrefixedText();
          $aTitleblank = $rev->getTitle()->getText();
       }
       else
       {
           $text = '';
       }
    }
	if($articleend != '*') {
	    if ($argv["lines"]==false)
	    {
	    $text = substr($text, $articlestart, $articleend);
	    }
	    else
	    {
	        $linestart=$articlestart;
	        $lineend=$articleend;
	        $artoutput="";
	        for ($i=0;$i<=$lineend;$i++)
	        {
	                $endpos = stripos($text,"\n");
	                $artlen = strlen($text);
	                $artoutput2 = substr($text,0,$endpos+1);
	                $artoutput = $artoutput.$artoutput2;
	                $text = substr($text, $endpos+1, $artlen);
	        }
	        for ($i=1;$i<$linestart;$i++)
	        {
	                $endpos = stripos($artoutput,"\n");
	                $artlen = strlen($artoutput);
	                $artoutput = substr($artoutput, $endpos+1, $artlen);
	        }
	        $text = $artoutput;
	    }
	}
    $newvariables["title"]=$aTitlecomp;
    $newvariables["titleblank"]=$aTitleblank;
    $newvariables["content"]=$text;
    $variables = $parser->replaceVariables( $input, $newvariables );
    $output = $parser->parse( $variables, $parser->mTitle, $parser->mOptions, true, false );
    $inhalt = $output->getText();
    $html=$inhalt;
    return $html;
}
 
function getrandompage( $varns) {
        global $wgOut, $wgExtraRandompageSQL, $wgContLang;
        $namespaces = $varns;
        $namespaces = preg_split('!\s*(\|\s*)+!', trim( $namespaces ) );
        $fname = 'wfSpecialRandompage';
        $i = rand(0, count($namespaces)-1);
        # Determine namespace
        $t = Title::newFromText ( $namespaces[$i] . ":Dummy" ) ;
        $namespace = $t->getNamespace () ;
 
        # NOTE! We use a literal constant in the SQL instead of the RAND()
        # function because RAND() will return a different value for every row
        # in the table. That's both very slow and returns results heavily
        # biased towards low values, as rows later in the table will likely
        # never be reached for comparison.
        #
        # Using a literal constant means the whole thing gets optimized on
        # the index, and the comparison is both fast and fair.
 
        # interpolation and sprintf() can muck up with locale-specific decimal separator
        $randstr = wfRandom();
 
        $db =& wfGetDB( DB_SLAVE );
        $use_index = $db->useIndexClause( 'page_random' );
        $page = $db->tableName( 'page' );
 
        $extra = $wgExtraRandompageSQL ? "AND ($wgExtraRandompageSQL)" : '';
        $sql = "SELECT page_id,page_title
                FROM $page $use_index
                WHERE page_namespace=$namespace AND page_is_redirect=0 $extra
                AND page_random>$randstr
                ORDER BY page_random";
        $sql = $db->limitResult($sql, 1, 0);
        $res = $db->query( $sql, $fname );
 
        $title = null;
        if( $s = $db->fetchObject( $res ) ) {
                $title =& Title::makeTitle( $namespace, $s->page_title );
        }
        if( is_null( $title ) ) {
                # That's not supposed to happen :)
                $title = Title::newMainPage();
        }
        $title = $title->getPrefixedText();
        return $title;
}
