<?php
/***************************************************************************
 *                              bbcode.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: bbcode.php,v 1.36.2.41 2006/02/26 17:34:50 grahamje Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

define("BBCODE_UID_LEN", 10);

// global that holds loaded-and-prepared bbcode templates, so we only have to do
// that stuff once.

$bbcode_tpl = null;
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
/**
 * Loads bbcode box list tags from the def_bbc_box.php file and associates the
 * values in four cases which are $bbc_value (check if a tag is enabled or not),
 * $bbc_auth (check if a bbcode is available to the user using the auth levels),
 * $bbc_open (the open tag for each bbcode) and $bbc_tag (the close tag for each
 * bbcode, also used like the open tag for some bbcodes).
 */
$bbc_config = $bbc_value = $bbc_auth = $bbc_open = $bbc_tag = array();
@include($phpbb_root_path . './includes/def_bbc_box.'.$phpEx);
foreach ( $bbc_config as $key => $value )
{
	$bbc_value[$value['bbc_name']] = $value['bbc_value'];
	$bbc_auth[$value['bbc_name']] = $value['bbc_auth'];
	$bbc_open[$value['bbc_name']] = $value['bbc_before'];
	$bbc_tag[$value['bbc_name']] = $value['bbc_after'];
}
//-- fin mod : bbcode box reloaded ---------------------------------------------

/**
 * Loads bbcode templates from the bbcode.tpl file of the current template set.
 * Creates an array, keys are bbcode names like "b_open" or "url", values
 * are the associated template.
 * Probably pukes all over the place if there's something really screwed
 * with the bbcode.tpl file.
 *
 * Nathan Codding, Sept 26 2001.
 */
function load_bbcode_template()
{
	global $template;
	$tpl_filename = $template->make_filename('bbcode.tpl');
	if (!file_exists($tpl_filename))
	{
		// Vende: XS is clever, bbcode isn't.
		// let's try to use default theme's file
		$tpl_filename = str_replace($template->tpl, $template->tpldef, $tpl_filename);
	}
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));

	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl  = str_replace('\'', '\\\'', $tpl);

	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);

	// Turn template blocks into PHP assignment statements for the values of $bbcode_tpls..
	$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$bbcode_tpls[\'\\1\'] = \'\\2\';', $tpl);

	$bbcode_tpls = array();

	eval($tpl);

	return $bbcode_tpls;
}


/**
 * Prepares the loaded bbcode templates for insertion into preg_replace()
 * or str_replace() calls in the bbencode_second_pass functions. This
 * means replacing template placeholders with the appropriate preg backrefs
 * or with language vars. NOTE: If you change how the regexps work in
 * bbencode_second_pass(), you MUST change this function.
 *
 * Nathan Codding, Sept 26 2001
 *
 */
function prepare_bbcode_template($bbcode_tpl)
{
	global $lang;

	$bbcode_tpl['olist_open'] = str_replace('{LIST_TYPE}', '\\1', $bbcode_tpl['olist_open']);

	$bbcode_tpl['color_open'] = str_replace('{COLOR}', '\\1', $bbcode_tpl['color_open']);

	$bbcode_tpl['size_open'] = str_replace('{SIZE}', '\\1', $bbcode_tpl['size_open']);

	$bbcode_tpl['quote_open'] = str_replace('{L_QUOTE}', $lang['Quote'], $bbcode_tpl['quote_open']);

	$bbcode_tpl['quote_username_open'] = str_replace('{L_QUOTE}', $lang['Quote'], $bbcode_tpl['quote_username_open']);
	$bbcode_tpl['quote_username_open'] = str_replace('{L_WROTE}', $lang['wrote'], $bbcode_tpl['quote_username_open']);
	$bbcode_tpl['quote_username_open'] = str_replace('{USERNAME}', '\\1', $bbcode_tpl['quote_username_open']);

	$bbcode_tpl['code_open'] = str_replace('{L_CODE}', $lang['Code'], $bbcode_tpl['code_open']);

	$bbcode_tpl['img'] = str_replace('{URL}', '\\1', $bbcode_tpl['img']);

	//TRADEBIT PLAYER MOD
    $bbcode_tpl['movie'] = str_replace('{MOVIEURL}', '\\1', $bbcode_tpl['movie']);	
	
	// We do URLs in several different ways..

	$bbcode_tpl['url1'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url1'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url1']);

	$bbcode_tpl['url2'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url2'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url2']);

	$bbcode_tpl['url3'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url3'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['url3']);

	$bbcode_tpl['url4'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url4'] = str_replace('{DESCRIPTION}', '\\3', $bbcode_tpl['url4']);

	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
	
	$bbcode_tpl['play'] = str_replace('{URL}', '\\1', $bbcode_tpl['play']);
	
	$bbcode_tpl['dailymotion'] = str_replace('{DAILYMOTIONID}', '\\1', $bbcode_tpl['dailymotion']);
	$bbcode_tpl['dailymotion'] = str_replace('{DAILYMOTIONLINK}', $lang['dailymotion_link'], $bbcode_tpl['dailymotion']);
	
	$bbcode_tpl['GVideo'] = str_replace('{GVIDEOID}', '\\1', $bbcode_tpl['GVideo']);
	$bbcode_tpl['GVideo'] = str_replace('{GVIDEOLINK}', $lang['GVideo_link'], $bbcode_tpl['GVideo']);
	
	// Les différentes façon d'écrire le lien du site.. 
   	$bbcode_tpl['website1'] = str_replace('{URL}', '\\1\\2', $bbcode_tpl['website']); 
    
   	$bbcode_tpl['website2'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['website']);	
	
	$bbcode_tpl['youtube'] = str_replace('{YOUTUBEID}', '\\3', $bbcode_tpl['youtube']);
	$bbcode_tpl['youtube'] = str_replace('{YOUTUBELINK}', $lang['youtube_link'], $bbcode_tpl['youtube']);
	
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
	$bbcode_tpl['show'] = str_replace('{L_HIDE}', $lang['Hide'], $bbcode_tpl['show']);
	$bbcode_tpl['show'] = str_replace('{HTEXTE}', '\\1', $bbcode_tpl['show']);
	$bbcode_tpl['hide'] = str_replace('{L_HIDE}', $lang['Hide'], $bbcode_tpl['hide']);
	$bbcode_tpl['hide'] = str_replace('{L_HIDE_TEXT}', $lang['Hide_text'], $bbcode_tpl['hide']);
//-- fin mod : addon hide for bbcbxr -------------------------------------------
	
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	// code expand
	$expand_ary1 = array('{L_EXPAND}', '{L_EXPAND_MORE}', '{L_CONTRACT}', '{L_SELECT_ALL}');
	$expand_ary2 = array($lang['bbcbxr_expand'], $lang['bbcbxr_expand_more'], $lang['bbcbxr_contract'], $lang['bbcbxr_select']);
	$bbcode_tpl['code_open'] = str_replace($expand_ary1, $expand_ary2, $bbcode_tpl['code_open']);
	// spoiler
	$bbcode_tpl['spoil_open'] = str_replace('{L_BBCBXR_SPOIL}', $lang['bbcbxr_spoil'], $bbcode_tpl['spoil_open']);
	$bbcode_tpl['spoil_open'] = str_replace('{L_BBCBXR_SHOW}', $lang['bbcbxr_show'], $bbcode_tpl['spoil_open']);
	$bbcode_tpl['spoil_open'] = str_replace('{L_BBCBXR_HIDE}', $lang['bbcbxr_hide'], $bbcode_tpl['spoil_open']);
	// align
	$bbcode_tpl['align_open'] = str_replace('{ALIGN}', '\\1', $bbcode_tpl['align_open']);
	// anchor
	$bbcode_tpl['anchor_link'] = str_replace('{ANCHOR}', '\\1', $bbcode_tpl['anchor_link']);
	$bbcode_tpl['anchor_link'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['anchor_link']);
	$bbcode_tpl['anchor_target'] = str_replace('{ANCHOR}', '\\1', $bbcode_tpl['anchor_target']);
	$bbcode_tpl['anchor_target'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['anchor_target']);
	// marquee
	$bbcode_tpl['marq_open'] = str_replace('{MARQ}', '\\1', $bbcode_tpl['marq_open']);
	// flash
	$bbcode_tpl['flash'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['flash']);
	$bbcode_tpl['flash'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['flash']);
	$bbcode_tpl['flash'] = str_replace('{URL}', '\\3', $bbcode_tpl['flash']);
	// video
	$bbcode_tpl['video'] = str_replace('{URL}', '\\3', $bbcode_tpl['video']);
	$bbcode_tpl['video'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['video']);
	$bbcode_tpl['video'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['video']);
	// stream
	$bbcode_tpl['stream'] = str_replace('{URL}', '\\1', $bbcode_tpl['stream']);
	// real
	$bbcode_tpl['ram'] = str_replace('{URL}', '\\3', $bbcode_tpl['ram']);
	$bbcode_tpl['ram'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['ram']);
	$bbcode_tpl['ram'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['ram']);
	// quick
	$bbcode_tpl['quick'] = str_replace('{URL}', '\\3', $bbcode_tpl['quick']);
	$bbcode_tpl['quick'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['quick']);
	$bbcode_tpl['quick'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['quick']);
	// background color
	$bbcode_tpl['bcolor_open'] = str_replace('{COLOR}', '\\1', $bbcode_tpl['bcolor_open']);
	// font type
	$bbcode_tpl['font_open'] = str_replace('{FONT}', '\\1', $bbcode_tpl['font_open']);
//-- fin mod : bbcode box reloaded ---------------------------------------------

//-- mod : thumbnails ----------------------------------------------------------
//-- add
	$bbcode_tpl['thumbnails'] = str_replace('{URL}', '\\1', $bbcode_tpl['thumbnails']);
	$bbcode_tpl['thumbnails'] = str_replace('{L_THUMBNAILS_ALT}', $lang['Thumbnails_alt'], $bbcode_tpl['thumbnails']);
	$bbcode_tpl['thumbnails'] = str_replace('{L_THUMBNAILS_TITLE}', $lang['Thumbnails_title'], $bbcode_tpl['thumbnails']);
//-- fin mod : thumbnails ------------------------------------------------------	

	define("BBCODE_TPL_READY", true);

	return $bbcode_tpl;
}


/**
 * Does second-pass bbencoding. This should be used before displaying the message in
 * a thread. Assumes the message is already first-pass encoded, and we are given the
 * correct UID as used in first-pass encoding.
 */
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
function hide_in_quote($text)
{
	global $lang, $bbc_tag;

	$hide = $bbc_tag['hide'];
	$text = preg_replace("#\[$hide\](.*?)\[\/$hide\]#si", $lang['Hide_in_quote'], $text);
	return $text;
}

function bbencode_third_pass($text, $uid, $deprotect)
{
	global $bbcode_tpl, $bbc_tag;

	// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
	// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
	$text = " " . $text;

	// First: If there isn't a "[" and a "]" in the message, don't bother.
	if (! (strpos($text, "[") && strpos($text, "]")) )
	{
		// Remove padding, return.
		$text = substr($text, 1);
		return $text;
	}
	// Patterns and replacements for URL and email tags..
	$patterns = array();
	$replacements = array();
	$hide = $bbc_tag['hide'];

	if ( $deprotect )
	{
		$patterns[0] = "#\[$hide:$uid\](.*?)\[/$hide:$uid\]#si";
		$replacements[0] = $bbcode_tpl['show'];
	}
	else
	{
		$patterns[0] = "#\[$hide:$uid\](.*?)\[/$hide:$uid\]#si";
		$replacements[0] = $bbcode_tpl['hide'];
        }

	$text = preg_replace($patterns, $replacements, $text);

	// Remove our padding from the string..
	$text = substr($text, 1);

	return $text;
}
//-- fin mod : addon hide for bbcbxr -------------------------------------------
function bbencode_second_pass($text, $uid)
{
	global $lang, $bbcode_tpl;
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	global $bbc_tag;
//-- fin mod : bbcode box reloaded ---------------------------------------------	

	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

	// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
	// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
	$text = " " . $text;

	// First: If there isn't a "[" and a "]" in the message, don't bother.
	if (! (strpos($text, "[") && strpos($text, "]")) )
	{
		// Remove padding, return.
		$text = substr($text, 1);
		return $text;
	}

	// Only load the templates ONCE..
	if (!defined("BBCODE_TPL_READY"))
	{
		// load templates from file into array.
		$bbcode_tpl = load_bbcode_template();

		// prepare array for use in regexps.
		$bbcode_tpl = prepare_bbcode_template($bbcode_tpl);
	}

	// [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.
	$text = bbencode_second_pass_code($text, $uid, $bbcode_tpl);

	// [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.
	$text = str_replace("[quote:$uid]", $bbcode_tpl['quote_open'], $text);
	$text = str_replace("[/quote:$uid]", $bbcode_tpl['quote_close'], $text);

	// New one liner to deal with opening quotes with usernames...
	// replaces the two line version that I had here before..
	$text = preg_replace("/\[quote:$uid=\"(.*?)\"\]/si", $bbcode_tpl['quote_username_open'], $text);

	// [list] and [list=x] for (un)ordered lists.
	// unordered lists
	$text = str_replace("[list:$uid]", $bbcode_tpl['ulist_open'], $text);
	// li tags
	$text = str_replace("[*:$uid]", $bbcode_tpl['listitem'], $text);
	// ending tags
	$text = str_replace("[/list:u:$uid]", $bbcode_tpl['ulist_close'], $text);
	$text = str_replace("[/list:o:$uid]", $bbcode_tpl['olist_close'], $text);
	// Ordered lists
	$text = preg_replace("/\[list=([a1]):$uid\]/si", $bbcode_tpl['olist_open'], $text);

	// colours
	$text = preg_replace("/\[color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['color_open'], $text);
	$text = str_replace("[/color:$uid]", $bbcode_tpl['color_close'], $text);

	// size
	$text = preg_replace("/\[size=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['size_open'], $text);
	$text = str_replace("[/size:$uid]", $bbcode_tpl['size_close'], $text);

	// [b] and [/b] for bolding text.
	$text = str_replace("[b:$uid]", $bbcode_tpl['b_open'], $text);
	$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text);

	// [u] and [/u] for underlining text.
	$text = str_replace("[u:$uid]", $bbcode_tpl['u_open'], $text);
	$text = str_replace("[/u:$uid]", $bbcode_tpl['u_close'], $text);

	// [i] and [/i] for italicizing text.
	$text = str_replace("[i:$uid]", $bbcode_tpl['i_open'], $text);
	$text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text);
	
	// [titre1] and [/titre1] for for title.
	$text = str_replace("[titre1:$uid]", $bbcode_tpl['titre1_open'], $text);
	$text = str_replace("[/titre1:$uid]", $bbcode_tpl['titre1_close'], $text);

	// Patterns and replacements for URL and email tags..
	$patterns = array();
	$replacements = array();

	//TRADEBIT PLAYER MOD
    //[movie]movieurl[/movie] code.
    $text = bbencode_first_pass_pda($text, $uid, '[movie]', '[/movie]', '', false, 'check_country');	
	
	// [img]image_url_here[/img] code..
	// This one gets first-passed..
	$patterns[] = "#\[img:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
	$replacements[] = $bbcode_tpl['img'];

	 //TRADEBIT MOVIE MOD
	 // matches a [movie]xxxx://www.phpbb.com[/movie] code..
     $patterns[] = "#\[movie:$uid\]([\w]+?://[^ \"\n\r\t<]*?)\[/movie:$uid\]#is";
     $replacements[] = $bbcode_tpl['movie'];
	
	// matches a [url]xxxx://www.phpbb.com[/url] code..
	$patterns[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$replacements[] = '\\1'; //$bbcode_tpl['url1'];//Autoshorten URL MOD v1.0.4

	// [url]www.phpbb.com[/url] code.. (no xxxx:// prefix).
	$patterns[] = "#\[url\]((www|ftp)\.([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$replacements[] = '\\1'; //$bbcode_tpl['url2'];//Autoshorten URL MOD v1.0.4

	// [url=xxxx://www.phpbb.com]phpBB[/url] code..
	$patterns[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$replacements[] = $bbcode_tpl['url3'];

	// [url=www.phpbb.com]phpBB[/url] code.. (no xxxx:// prefix).
	$patterns[] = "#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$replacements[] = $bbcode_tpl['url4'];

	// [email]user@domain.tld[/email] code..
	$patterns[] = "#\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#si";
	$replacements[] = $bbcode_tpl['email'];
	
	//[ play ]and[ /play ]for quicking audio.
    $patterns[] = "#\[play:$uid\](.*?)\[/play:$uid\]#si";
    $replacements[] = $bbcode_tpl['play'];
	
	// [dailymotion]Dailymotion URL[/dailymotion] code..
	$patterns[] = "#\[dailymotion\](.*)[^[]*\[/dailymotion\]#is";
	$replacements[] = $bbcode_tpl['dailymotion'];
	
	// [GVideo]GVideo URL[/GVideo] code..
    $patterns[] = "#\[GVideo\]http://video.google.com/videoplay\?docid=([0-9A-Za-z-_]*)[^[]*\[/GVideo\]#is";
    $replacements[] = $bbcode_tpl['GVideo'];
	
	// Les différentes façon d'écrire le lien du site.. 
	// [website]xxxx://www.phpbb.com[/website] code.. 
   	$patterns[] = "#\[website\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/website\]#si"; 
   	$replacements[] = $bbcode_tpl['website1']; 
    
   	// [website]www.phpbb.com[/website] code.. (no xxxx:// prefix). 
   	$patterns[] = "#\[website\]([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/website\]#si"; 
   	$replacements[] = $bbcode_tpl['website2']; 	
	
	// [youtube]YouTube URL[/youtube] code..
	$patterns[] = "#\[youtube\](?:http|https)?://(?:www\.)?(youtube.com|youtu.be|gaming.youtube.com|m.youtube.com)/(watch\?v=|v/|)([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#is";
	$replacements[] = $bbcode_tpl['youtube'];
	
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	// [strike] and [/strike] code..
	$strike = $bbc_tag['strike'];
	$text = str_replace("[$strike:$uid]", $bbcode_tpl['s_open'], $text);
	$text = str_replace("[/$strike:$uid]", $bbcode_tpl['s_close'], $text);

	// [spoil] and [/spoil] code..
	$spoiler = $bbc_tag['spoiler'];
	$text = str_replace("[$spoiler:$uid]", $bbcode_tpl['spoil_open'], $text);
	$text = str_replace("[/$spoiler:$uid]", $bbcode_tpl['spoil_close'], $text);

	// [fade] and [/fade] code..
	$fade = $bbc_tag['fade'];
	$text = str_replace("[$fade:$uid]", $bbcode_tpl['fade_open'], $text);
	$text = str_replace("[/$fade:$uid]", $bbcode_tpl['fade_close'], $text);

	// [rainbow] and [/rainbow] code..
	$rainbow = $bbc_tag['rainbow'];
	$text = preg_replace("#\[$rainbow:$uid\](.*?)\[/$rainbow:$uid\]#sie", "rainbow('\\1')", $text);

	// [align=left|right|center|justify] and [/align] code..
	$bbc_align = array('left', 'right', 'center', 'justify');
	for ($i = 0; $i < count($bbc_align); $i++)
	{
		$align = $bbc_tag[$bbc_align[$i]];
		$text = preg_replace("/\[$align=(left|right|center|justify):$uid\]/si", $bbcode_tpl['align_open'], $text);
		$text = str_replace("[/$align:$uid]", $bbcode_tpl['align_close'], $text);
	}

	// [link=xxx] and [target=xxx] for anchor text
	$link = $bbc_tag['link'];
	$target = $bbc_tag['target'];
	$patterns[] = "#\[$link=(.*?):$uid\](.*?)\[/$link:$uid\]#is";
	$replacements[] = $bbcode_tpl['anchor_link'];
	$patterns[] = "#\[$target=(.*?):$uid\](.*?)\[/$target:$uid\]#is";
	$replacements[] = $bbcode_tpl['anchor_target'];

	// [marq=left|right|up|down] and [/marq] code..
	$bbc_marq = array('marql', 'marqr', 'marqu', 'marqd');
	for ($i = 0; $i < count($bbc_marq); $i++)
	{
		$marq = $bbc_tag[$bbc_marq[$i]];
		$text = preg_replace("/\[$marq=(left|right|up|down):$uid\]/si", $bbcode_tpl['marq_open'], $text);
		$text = str_replace("[/$marq:$uid]", $bbcode_tpl['marq_close'], $text);
	}

	//[flash width= height=]and[/flash] code..
	$flash = $bbc_tag['flash'];
	$patterns[] = "#\[$flash width=([0-6]?[0-9]?[0-9]) height=([0-5]?[0-9]?[0-9]):$uid\]([^?].*?)\[/$flash:$uid\]#si"; 
	$replacements[] = $bbcode_tpl['flash'];

	// [video width= height=] and [/video] code..
	$video = $bbc_tag['video'];
	$patterns[] = "#\[$video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\]([^?].*?)\[/$video:$uid\]#si";
	$replacements[] = $bbcode_tpl['video'];

	// [stream] and [/stream] code..
	$stream = $bbc_tag['stream'];
	$patterns[] = "#\[$stream:$uid\]([^?].*?)\[/$stream:$uid\]#si";
	$replacements[] = $bbcode_tpl['stream'];

	// [ram] and [/ram] code..
	$ram = $bbc_tag['real'];
	$patterns[] = "#\[$ram width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\]([^?].*?)\[/$ram:$uid\]#si";
	$replacements[] = $bbcode_tpl['ram'];

	// [quick] and [/quick] code..
	$quick = $bbc_tag['quick'];
	$patterns[] = "#\[$quick width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\]([^?].*?)\[/$quick:$uid\]#si"; 
	$replacements[] = $bbcode_tpl['quick'];

	// [sup] and [/sup] code..
	$sup = $bbc_tag['sup'];
	$text = str_replace("[$sup:$uid]", $bbcode_tpl['sup_open'], $text);
	$text = str_replace("[/$sup:$uid]", $bbcode_tpl['sup_close'], $text);

	// [sub] and [/sub] code..
	$sub = $bbc_tag['sub'];
	$text = str_replace("[$sub:$uid]", $bbcode_tpl['sub_open'], $text);
	$text = str_replace("[/$sub:$uid]", $bbcode_tpl['sub_close'], $text);

	// [hr] code..
	$text = str_replace("[hr:$uid]", $bbcode_tpl['hr'], $text);

	// background colours
	$text = preg_replace("/\[bcolor=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['bcolor_open'], $text);
	$text = str_replace("[/bcolor:$uid]", $bbcode_tpl['bcolor_close'], $text);

	// [font=] and [/font] code..
	$text = preg_replace("/\[font=(.*?):$uid\]/si", $bbcode_tpl['font_open'], $text);
	$text = str_replace("[/font:$uid]", $bbcode_tpl['font_close'], $text);
//-- fin mod : bbcode box reloaded ---------------------------------------------

//-- mod : thumbnails ----------------------------------------------------------
//-- add
	// [tmb]image_url_here[/tmb] for displaying thumbnails
	// This one gets first-passed..
	$tmb = $bbc_tag['tmb'];
	$patterns[] = "#\[$tmb:$uid\]([^?].*?)\[/$tmb:$uid\]#i";
	$replacements[] = $bbcode_tpl['thumbnails'];
//-- fin mod : thumbnails ------------------------------------------------------	

	$text = preg_replace($patterns, $replacements, $text);

	// Remove our padding from the string..
	$text = substr($text, 1);

	return $text;

} // bbencode_second_pass()

// Need to initialize the random numbers only ONCE
mt_srand( (double) microtime() * 1000000);

function make_bbcode_uid()
{
	// Unique ID for this message..

	$uid = dss_rand();
	$uid = substr($uid, 0, BBCODE_UID_LEN);

	return $uid;
}

function bbencode_first_pass($text, $uid)
{
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	global $bbc_value, $bbc_auth, $bbc_open, $bbc_tag;
//-- fin mod : bbcode box reloaded ---------------------------------------------
	// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
	// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
	$text = " " . $text;

	// [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.
	$text = bbencode_first_pass_pda($text, $uid, '[code]', '[/code]', '', true, '');

	// [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.
	$text = bbencode_first_pass_pda($text, $uid, '[quote]', '[/quote]', '', false, '');
	$text = bbencode_first_pass_pda($text, $uid, '/\[quote=\\\\&quot;(.*?)\\\\&quot;\]/is', '[/quote]', '', false, '', "[quote:$uid=\\\"\\1\\\"]");

	// [list] and [list=x] for (un)ordered lists.
	$open_tag = array();
	$open_tag[0] = "[list]";

	// unordered..
	$text = bbencode_first_pass_pda($text, $uid, $open_tag, "[/list]", "[/list:u]", false, 'replace_listitems');

	$open_tag[0] = "[list=1]";
	$open_tag[1] = "[list=a]";

	// ordered.
	$text = bbencode_first_pass_pda($text, $uid, $open_tag, "[/list]", "[/list:o]",  false, 'replace_listitems');

	// [color] and [/color] for setting text color
	$text = preg_replace("#\[color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/color\]#si", "[color=\\1:$uid]\\2[/color:$uid]", $text);

	// [size] and [/size] for setting text size
	$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);

	// [b] and [/b] for bolding text.
	$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);

	// [u] and [/u] for underlining text.
	$text = preg_replace("#\[u\](.*?)\[/u\]#si", "[u:$uid]\\1[/u:$uid]", $text);

	// [i] and [/i] for italicizing text.
	$text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text);
	
	// [titre1] and [/titre1] for title.
	$text = preg_replace("#\[titre1\](.*?)\[/titre1\]#si", "[titre1:$uid]\\1[/titre1:$uid]", $text);

	// [information] and [/information] for information text.
	$text = preg_replace("#\[information\](.*?)\[/information\]#si", "[information:$uid]\\1[/information:$uid]", $text);

	// [attention] and [/attention] for warning text.
	$text = preg_replace("#\[attention\](.*?)\[/attention\]#si", "[attention:$uid]\\1[/attention:$uid]", $text);

	// [erreur] and [/erreur] for error text.
	$text = preg_replace("#\[erreur\](.*?)\[/erreur\]#si", "[erreur:$uid]\\1[/erreur:$uid]", $text);

	// [question] and [/question] for questions.
	$text = preg_replace("#\[question\](.*?)\[/question\]#si", "[question:$uid]\\1[/question:$uid]", $text);	

	// [img]image_url_here[/img] code..
	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
	
	//[ play]image_url_here[/play ]code..
	$text = preg_replace("#\[play\](([a-z]+?)://([^, \n\r]+))\[/play\]#si", "[play:$uid]\\1[/play:$uid]", $text);
	
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
	// [hide]message[/hide]
	$hide = $bbc_tag['hide'];
	$bbc_sort = bbc_auth($bbc_auth['hide']);
	$text = ($bbc_value['hide'] && $bbc_sort) ? preg_replace("#\[$hide\](.*?)\[\/$hide\]#si","[$hide:$uid]\\1[/$hide:$uid]", $text) : $text;
//-- fin mod : addon hide for bbcbxr -------------------------------------------
	
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	// [strike] and [/strike]
	$strike = $bbc_tag['strike'];
	$bbc_sort = bbc_auth($bbc_auth['strike']);
	$text = ($bbc_value['strike'] && $bbc_sort) ? preg_replace("#\[$strike\](.*?)\[/$strike\]#si", "[$strike:$uid]\\1[/$strike:$uid]", $text) : $text;

	// [spoil] and [/spoil]
	$spoiler = $bbc_tag['spoiler'];
	$bbc_sort = bbc_auth($bbc_auth['spoiler']);
	$text = ($bbc_value['spoiler'] && $bbc_sort) ? preg_replace("#\[$spoiler\](.*?)\[/$spoiler\]#si", "[$spoiler:$uid]\\1[/$spoiler:$uid]", $text) : $text;

	// [fade] and [/fade] for faded text.
	$fade = $bbc_tag['fade'];
	$bbc_sort = bbc_auth($bbc_auth['fade']);
	$text = ($bbc_value['fade'] && $bbc_sort) ? preg_replace("#\[$fade\](.*?)\[/$fade\]#si", "[$fade:$uid]\\1[/$fade:$uid]", $text) : $text;

	// [rainbow] and [/rainbow]
	$rainbow = $bbc_tag['rainbow'];
	$bbc_sort = bbc_auth($bbc_auth['rainbow']);
	$text = ($bbc_value['rainbow'] && $bbc_sort) ? preg_replace("#\[$rainbow\](.*?)\[/$rainbow\]#si", "[$rainbow:$uid]\\1[/$rainbow:$uid]", $text) : $text;

	// [align] and [/align]
	$bbc_align = array('left', 'right', 'center', 'justify');
	for ($i = 0; $i < count($bbc_align); $i++)
	{
		$align_open = '[' . $bbc_open[$bbc_align[$i]] . ']';
		$align_close = '[/' . $bbc_tag[$bbc_align[$i]] . ']';
		$bbc_sort = bbc_auth($bbc_auth[$bbc_align[$i]]);
		$text = ($bbc_value[$bbc_align[$i]] && $bbc_sort) ? bbencode_first_pass_pda($text, $uid, $align_open, $align_close, '', false, '') : $text;
	}

	// [marq] and [/marq]
	$bbc_marq = array('marql', 'marqr', 'marqu', 'marqd');
	for ($i = 0; $i < count($bbc_marq); $i++)
	{
		$marq_open = '[' . $bbc_open[$bbc_marq[$i]] . ']';
		$marq_close = '[/' . $bbc_tag[$bbc_marq[$i]] . ']';
		$bbc_sort = bbc_auth($bbc_auth[$bbc_marq[$i]]);
		$text = ($bbc_value[$bbc_marq[$i]] && $bbc_sort) ? bbencode_first_pass_pda($text, $uid, $marq_open, $marq_close, '', false, '') : $text;
	}

	// [link=xxx] and [target=xxx] for anchor text
	$link = $bbc_tag['link'];
	$target = $bbc_tag['target'];
	$bbc_sort_l = bbc_auth($bbc_auth['link']);
	$bbc_sort_t = bbc_auth($bbc_auth['target']);
	$text = ($bbc_value['link'] && $bbc_sort_l) ? preg_replace("#\[$link=(.*?)\](.*?)\[/$link\]#is","[$link=\\1:$uid]\\2[/$link:$uid]", $text) : $text;
	$text = ($bbc_value['target'] && $bbc_sort_t) ? preg_replace("#\[$target=(.*?)\](.*?)\[/$target\]#is","[$target=\\1:$uid]\\2[/$target:$uid]", $text) : $text;

	//[flash width= heigth=] and [/flash]
	$flash = $bbc_tag['flash'];
	$bbc_sort = bbc_auth($bbc_auth['flash']);
	$text = ($bbc_value['flash'] && $bbc_sort) ? preg_replace("#\[$flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?(\.swf))\[\/$flash\]#si","[$flash width=\\1 height=\\2:$uid]\\3[/$flash:$uid]", $text) : $text;

	//[video width= heigth=] and [/video]
	$video = $bbc_tag['video'];
	$bbc_sort = bbc_auth($bbc_auth['video']);
	$text = ($bbc_value['video'] && $bbc_sort) ? preg_replace("#\[$video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?(\.(asf|asx|avi|mpg|mpeg|wmv)))\[\/$video\]#si","[$video width=\\1 height=\\2:$uid]\\3[/$video:$uid]", $text) : $text;

	// [stream] and [/stream]
	$stream = $bbc_tag['stream'];
	$bbc_sort = bbc_auth($bbc_auth['stream']);
	$text = ($bbc_value['stream'] && $bbc_sort) ? preg_replace("#\[$stream\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?(\.(mid|mp3|ogg|wav|wma)))\[/$stream\]#si", "[$stream:$uid]\\1[/$stream:$uid]", $text) : $text;

	// [real] and [/real]
	$ram = $bbc_tag['real'];
	$bbc_sort = bbc_auth($bbc_auth['real']);
	$text = ($bbc_value['real'] && $bbc_sort) ? preg_replace("#\[$ram width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?(\.(ra|rm|ram|rp|rpm|rpx|smi|smil)))\[/$ram\]#si", "[$ram width=\\1 height=\\2:$uid]\\3[/$ram:$uid]", $text) : $text;

	// [quick] and [/quick]
	$quick = $bbc_tag['quick'];
	$bbc_sort = bbc_auth($bbc_auth['quick']);
	$text = ($bbc_value['quick'] && $bbc_sort) ? preg_replace("#\[$quick width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?(\.mov|qt))\[/$quick\]#si", "[$quick width=\\1 height=\\2:$uid]\\3[/$quick:$uid]", $text) : $text;

	// [sup] and [/sup]
	$sup = $bbc_tag['sup'];
	$bbc_sort = bbc_auth($bbc_auth['sup']);
	$text = ($bbc_value['sup'] && $bbc_sort) ? preg_replace("#\[$sup\](.*?)\[/$sup\]#si", "[$sup:$uid]\\1[/$sup:$uid]", $text) : $text;

	// [sub] and [/sub]
	$sub = $bbc_tag['sub'];
	$bbc_sort = bbc_auth($bbc_auth['sub']);
	$text = ($bbc_value['sub'] && $bbc_sort) ? preg_replace("#\[$sub\](.*?)\[/$sub\]#si", "[$sub:$uid]\\1[/$sub:$uid]", $text) : $text;

	// [hr]
	$text = preg_replace("#\[hr\]#si", "[hr:$uid]", $text);

	// [bcolor] and [/bcolor] for setting background color
	$text = preg_replace("#\[bcolor=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/bcolor\]#si", "[bcolor=\\1:$uid]\\2[/bcolor:$uid]", $text);

	// [font=] and [/font]
	$text = preg_replace("#\[font=(.*?)\](.*?)\[/font\]#si", "[font=\\1:$uid]\\2[/font:$uid]", $text);
//-- fin mod : bbcode box reloaded ---------------------------------------------

//-- mod : thumbnails ----------------------------------------------------------
//-- add
	// [tmb]image_url_here[/tmb] for displaying thumbnails
	$tmb = $bbc_tag['tmb'];
	$bbc_sort = bbc_auth($bbc_auth['tmb']);
	$text = ($bbc_value['tmb'] && $bbc_sort) ? preg_replace("#\[$tmb\]((http|ftp)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/$tmb\]#sie", "'[$tmb:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/$tmb:$uid]'", $text) : $text;
//-- fin mod : thumbnails ------------------------------------------------------	

	// Remove our padding from the string..
	return substr($text, 1);;

} // bbencode_first_pass()

/**
 * $text - The text to operate on.
 * $uid - The UID to add to matching tags.
 * $open_tag - The opening tag to match. Can be an array of opening tags.
 * $close_tag - The closing tag to match.
 * $close_tag_new - The closing tag to replace with.
 * $mark_lowest_level - boolean - should we specially mark the tags that occur
 * 					at the lowest level of nesting? (useful for [code], because
 *						we need to match these tags first and transform HTML tags
 *						in their contents..
 * $func - This variable should contain a string that is the name of a function.
 *				That function will be called when a match is found, and passed 2
 *				parameters: ($text, $uid). The function should return a string.
 *				This is used when some transformation needs to be applied to the
 *				text INSIDE a pair of matching tags. If this variable is FALSE or the
 *				empty string, it will not be executed.
 * If open_tag is an array, then the pda will try to match pairs consisting of
 * any element of open_tag followed by close_tag. This allows us to match things
 * like [list=A]...[/list] and [list=1]...[/list] in one pass of the PDA.
 *
 * NOTES:	- this function assumes the first character of $text is a space.
 *				- every opening tag and closing tag must be of the [...] format.
 */
function bbencode_first_pass_pda($text, $uid, $open_tag, $close_tag, $close_tag_new, $mark_lowest_level, $func, $open_regexp_replace = false)
{
	$open_tag_count = 0;

	if (!$close_tag_new || ($close_tag_new == ''))
	{
		$close_tag_new = $close_tag;
	}

	$close_tag_length = strlen($close_tag);
	$close_tag_new_length = strlen($close_tag_new);
	$uid_length = strlen($uid);

	$use_function_pointer = ($func && ($func != ''));

	$stack = array();

	if (is_array($open_tag))
	{
		if (0 == count($open_tag))
		{
			// No opening tags to match, so return.
			return $text;
		}
		$open_tag_count = count($open_tag);
	}
	else
	{
		// only one opening tag. make it into a 1-element array.
		$open_tag_temp = $open_tag;
		$open_tag = array();
		$open_tag[0] = $open_tag_temp;
		$open_tag_count = 1;
	}

	$open_is_regexp = false;

	if ($open_regexp_replace)
	{
		$open_is_regexp = true;
		if (!is_array($open_regexp_replace))
		{
			$open_regexp_temp = $open_regexp_replace;
			$open_regexp_replace = array();
			$open_regexp_replace[0] = $open_regexp_temp;
		}
	}

	if ($mark_lowest_level && $open_is_regexp)
	{
		message_die(GENERAL_ERROR, "Unsupported operation for bbcode_first_pass_pda().");
	}

	// Start at the 2nd char of the string, looking for opening tags.
	$curr_pos = 1;
	while ($curr_pos && ($curr_pos < strlen($text)))
	{
		$curr_pos = strpos($text, "[", $curr_pos);

		// If not found, $curr_pos will be 0, and the loop will end.
		if ($curr_pos)
		{
			// We found a [. It starts at $curr_pos.
			// check if it's a starting or ending tag.
			$found_start = false;
			$which_start_tag = "";
			$start_tag_index = -1;

			for ($i = 0; $i < $open_tag_count; $i++)
			{
				// Grab everything until the first "]"...
				$possible_start = substr($text, $curr_pos, strpos($text, ']', $curr_pos + 1) - $curr_pos + 1);

				//
				// We're going to try and catch usernames with "[' characters.
				//
				if( preg_match('#\[quote=\\\&quot;#si', $possible_start, $match) && !preg_match('#\[quote=\\\&quot;(.*?)\\\&quot;\]#si', $possible_start) )
				{
					// OK we are in a quote tag that probably contains a ] bracket.
					// Grab a bit more of the string to hopefully get all of it..
					if ($close_pos = strpos($text, '&quot;]', $curr_pos + 14))
					{
						if (strpos(substr($text, $curr_pos + 14, $close_pos - ($curr_pos + 14)), '[quote') === false)
						{
							$possible_start = substr($text, $curr_pos, $close_pos - $curr_pos + 7);
						}
					}
				}

				// Now compare, either using regexp or not.
				if ($open_is_regexp)
				{
					$match_result = array();
					if (preg_match($open_tag[$i], $possible_start, $match_result))
					{
						$found_start = true;
						$which_start_tag = $match_result[0];
						$start_tag_index = $i;
						break;
					}
				}
				else
				{
					// straightforward string comparison.
					if (0 == strcasecmp($open_tag[$i], $possible_start))
					{
						$found_start = true;
						$which_start_tag = $open_tag[$i];
						$start_tag_index = $i;
						break;
					}
				}
			}

			if ($found_start)
			{
				// We have an opening tag.
				// Push its position, the text we matched, and its index in the open_tag array on to the stack, and then keep going to the right.
				$match = array("pos" => $curr_pos, "tag" => $which_start_tag, "index" => $start_tag_index);
				array_push($stack, $match);
				//
				// Rather than just increment $curr_pos
				// Set it to the ending of the tag we just found
				// Keeps error in nested tag from breaking out
				// of table structure..
				//
				$curr_pos += strlen($possible_start);
			}
			else
			{
				// check for a closing tag..
				$possible_end = substr($text, $curr_pos, $close_tag_length);
				if (0 == strcasecmp($close_tag, $possible_end))
				{
					// We have an ending tag.
					// Check if we've already found a matching starting tag.
					if (sizeof($stack) > 0)
					{
						// There exists a starting tag.
						$curr_nesting_depth = sizeof($stack);
						// We need to do 2 replacements now.
						$match = array_pop($stack);
						$start_index = $match['pos'];
						$start_tag = $match['tag'];
						$start_length = strlen($start_tag);
						$start_tag_index = $match['index'];

						if ($open_is_regexp)
						{
							$start_tag = preg_replace($open_tag[$start_tag_index], $open_regexp_replace[$start_tag_index], $start_tag);
						}

						// everything before the opening tag.
						$before_start_tag = substr($text, 0, $start_index);

						// everything after the opening tag, but before the closing tag.
						$between_tags = substr($text, $start_index + $start_length, $curr_pos - $start_index - $start_length);

						// Run the given function on the text between the tags..
						if ($use_function_pointer)
						{
							$between_tags = $func($between_tags, $uid);
						}

						// everything after the closing tag.
						$after_end_tag = substr($text, $curr_pos + $close_tag_length);

						// Mark the lowest nesting level if needed.
						if ($mark_lowest_level && ($curr_nesting_depth == 1))
						{
							if ($open_tag[0] == '[code]')
							{
								$code_entities_match = array('#<#', '#>#', '#"#', '#:#', '#\[#', '#\]#', '#\(#', '#\)#', '#\{#', '#\}#');
								$code_entities_replace = array('&lt;', '&gt;', '&quot;', '&#58;', '&#91;', '&#93;', '&#40;', '&#41;', '&#123;', '&#125;');
								$between_tags = preg_replace($code_entities_match, $code_entities_replace, $between_tags);
							}
							$text = $before_start_tag . substr($start_tag, 0, $start_length - 1) . ":$curr_nesting_depth:$uid]";
							$text .= $between_tags . substr($close_tag_new, 0, $close_tag_new_length - 1) . ":$curr_nesting_depth:$uid]";
						}
						else
						{
							if ($open_tag[0] == '[code]')
							{
								$text = $before_start_tag . '&#91;code&#93;';
								$text .= $between_tags . '&#91;/code&#93;';
							}
							else
							{
								if ($open_is_regexp)
								{
									$text = $before_start_tag . $start_tag;
								}
								else
								{
									$text = $before_start_tag . substr($start_tag, 0, $start_length - 1) . ":$uid]";
								}
								$text .= $between_tags . substr($close_tag_new, 0, $close_tag_new_length - 1) . ":$uid]";
							}
						}

						$text .= $after_end_tag;

						// Now.. we've screwed up the indices by changing the length of the string.
						// So, if there's anything in the stack, we want to resume searching just after it.
						// otherwise, we go back to the start.
						if (sizeof($stack) > 0)
						{
							$match = array_pop($stack);
							$curr_pos = $match['pos'];
//							bbcode_array_push($stack, $match);
//							++$curr_pos;
						}
						else
						{
							$curr_pos = 1;
						}
					}
					else
					{
						// No matching start tag found. Increment pos, keep going.
						++$curr_pos;
					}
				}
				else
				{
					// No starting tag or ending tag.. Increment pos, keep looping.,
					++$curr_pos;
				}
			}
		}
	} // while

	return $text;

} // bbencode_first_pass_pda()

/**
 * Does second-pass bbencoding of the [code] tags. This includes
 * running htmlspecialchars() over the text contained between
 * any pair of [code] tags that are at the first level of
 * nesting. Tags at the first level of nesting are indicated
 * by this format: [code:1:$uid] ... [/code:1:$uid]
 * Other tags are in this format: [code:$uid] ... [/code:$uid]
 */
function bbencode_second_pass_code($text, $uid, $bbcode_tpl)
{
	global $lang;

	$code_start_html = $bbcode_tpl['code_open'];
	$code_end_html =  $bbcode_tpl['code_close'];

	// First, do all the 1st-level matches. These need an htmlspecialchars() run,
	// so they have to be handled differently.
	$match_count = preg_match_all("#\[code:1:$uid\](.*?)\[/code:1:$uid\]#si", $text, $matches);

	for ($i = 0; $i < $match_count; $i++)
	{
		$before_replace = $matches[1][$i];
		$after_replace = $matches[1][$i];

		// Replace 2 spaces with "&nbsp; " so non-tabbed code indents without making huge long lines.
		$after_replace = str_replace("  ", "&nbsp; ", $after_replace);
		// now Replace 2 spaces with " &nbsp;" to catch odd #s of spaces.
		$after_replace = str_replace("  ", " &nbsp;", $after_replace);

		// Replace tabs with "&nbsp; &nbsp;" so tabbed code indents sorta right without making huge long lines.
		$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);

		// now Replace space occurring at the beginning of a line
		$after_replace = preg_replace("/^ {1}/m", '&nbsp;', $after_replace);

		$str_to_match = "[code:1:$uid]" . $before_replace . "[/code:1:$uid]";

		$replacement = $code_start_html;
		$replacement .= $after_replace;
		$replacement .= $code_end_html;

		$text = str_replace($str_to_match, $replacement, $text);
	}

	// Now, do all the non-first-level matches. These are simple.
	$text = str_replace("[code:$uid]", $code_start_html, $text);
	$text = str_replace("[/code:$uid]", $code_end_html, $text);

	return $text;

} // bbencode_second_pass_code()

/**
 * Rewritten by Nathan Codding - Feb 6, 2001.
 * - Goes through the given string, and replaces xxxx://yyyy with an HTML <a> tag linking
 * 	to that URL
 * - Goes through the given string, and replaces www.xxxx.yyyy[zzzz] with an HTML <a> tag linking
 * 	to http://www.xxxx.yyyy[/zzzz]
 * - Goes through the given string, and replaces xxxx@yyyy with an HTML mailto: tag linking
 *		to that email address
 * - Only matches these 2 patterns either after a space, or at the beginning of a line
 *
 * Notes: the email one might get annoying - it's easy to make it more restrictive, though.. maybe
 * have it require something like xxxx@yyyy.zzzz or such. We'll see.
 */
function make_clickable($text)
{
	global $board_config;
	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

	// pad it with a space so we can match things at the start of the 1st line.
	$ret = ' ' . $text;

	// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
	// xxxx can only be alpha characters.
	// yyyy is anything up to the first space, newline, comma, double quote or <
//Autoshorten URL MOD v1.0.4
	$url_meat = "\w\#$%&~/.\-;:=,?@\[\]+";
	$max_url_length = $board_config['max_url_length'];
	if ($max_url_length < 40) $max_url_length = 40; // prevent silly ACP setting from doing harm
	$prefix_length = $max_url_length - 20; // leave a 20 character tail
	$suffix_length = $max_url_length - $prefix_length - 3; // -3 for "..." in the middle
	$patterns[] = "#(^|[\n ])([\w]+?://[" . $url_meat . "]{1," . $max_url_length . "})($|[^" . $url_meat . "])#is";
	$replacements[] = "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>\\3";
	$patterns[] = "#(^|[\n ])([\w]+?://[" . $url_meat . "]{" . $prefix_length . "})([" . $url_meat . "]+)([" . $url_meat . "]{" . $suffix_length . "})($|[^" . $url_meat . "])#is";
	$replacements[] = "\\1<a href=\"\\2\\3\\4\" target=\"_blank\">\\2...\\4</a>\\5";
	$ret = preg_replace($patterns, $replacements, $ret);

	// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	// zzzz is optional.. will contain everything up to the first space, newline, 
	// comma, double quote or <.
//Autoshorten URL MOD v1.0.4
	$patlazy[] = "#(^|[\n ])((www|ftp)\.[" . $url_meat . "]{1," . $max_url_length . "})($|[^" . $url_meat . "])#is";
	$replazy[] = "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>\\4";
	$patlazy[] = "#(^|[\n ])((www|ftp)\.[" . $url_meat . "]{" . $prefix_length . "})([" . $url_meat . "]+)([" . $url_meat . "]{" . $suffix_length . "})($|[^" . $url_meat . "])#is";
	$replazy[] = "\\1<a href=\"http://\\2\\4\\5\" target=\"_blank\">\\2...\\5</a>\\6";
	$ret = preg_replace($patlazy, $replazy, $ret);

	// matches an email@domain type address at the start of a line, or after a space.
	// Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
	$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

	// Remove our padding..
	$ret = substr($ret, 1);

	return($ret);
}

/**
 * Nathan Codding - Feb 6, 2001
 * Reverses the effects of make_clickable(), for use in editpost.
 * - Does not distinguish between "www.xxxx.yyyy" and "http://aaaa.bbbb" type URLs.
 *
 */
function undo_make_clickable($text)
{
	$text = preg_replace("#<!-- BBCode auto-link start --><a href=\"(.*?)\" target=\"_blank\">.*?</a><!-- BBCode auto-link end -->#i", "\\1", $text);
	$text = preg_replace("#<!-- BBcode auto-mailto start --><a href=\"mailto:(.*?)\">.*?</a><!-- BBCode auto-mailto end -->#i", "\\1", $text);

	return $text;

}

/**
 * Nathan Codding - August 24, 2000.
 * Takes a string, and does the reverse of the PHP standard function
 * htmlspecialchars().
 */
function undo_htmlspecialchars($input)
{
	$input = preg_replace("/&gt;/i", ">", $input);
	$input = preg_replace("/&lt;/i", "<", $input);
	$input = preg_replace("/&quot;/i", "\"", $input);
	$input = preg_replace("/&amp;/i", "&", $input);

	return $input;
}

/**
 * This is used to change a [*] tag into a [*:$uid] tag as part
 * of the first-pass bbencoding of [list] tags. It fits the
 * standard required in order to be passed as a variable
 * function into bbencode_first_pass_pda().
 */
function replace_listitems($text, $uid)
{
	$text = str_replace("[*]", "[*:$uid]", $text);

	return $text;
}

/**
 * Escapes the "/" character with "\/". This is useful when you need
 * to stick a runtime string into a PREG regexp that is being delimited
 * with slashes.
 */
function escape_slashes($input)
{
	$output = str_replace('/', '\/', $input);
	return $output;
}

/**
 * This function does exactly what the PHP4 function array_push() does
 * however, to keep phpBB compatable with PHP 3 we had to come up with our own
 * method of doing it.
 * This function was deprecated in phpBB 2.0.18
 */
function bbcode_array_push(&$stack, $value)
{
   $stack[] = $value;
   return(sizeof($stack));
}

/**
 * This function does exactly what the PHP4 function array_pop() does
 * however, to keep phpBB compatable with PHP 3 we had to come up with our own
 * method of doing it.
 * This function was deprecated in phpBB 2.0.18
 */
function bbcode_array_pop(&$stack)
{
   $arrSize = count($stack);
   $x = 1;

   while(list($key, $val) = each($stack))
   {
      if($x < count($stack))
      {
	 		$tmpArr[] = $val;
      }
      else
      {
	 		$return_val = $val;
      }
      $x++;
   }
   $stack = $tmpArr;

   return($return_val);
}

//
// Smilies code ... would this be better tagged on to the end of bbcode.php?
// Probably so and I'll move it before B2
//
function smilies_pass($message, $path = false)
{
	static $orig, $repl;

	if (!isset($orig))
	{
		global $db, $board_config;
		$orig = $repl = array();

		$sql = 'SELECT * FROM ' . SMILIES_TABLE;
		if( !$result = $db->sql_query($sql, false, 'smilies_') )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
		}
		$smilies = $db->sql_fetchrowset($result);

		if (count($smilies))
		{
			usort($smilies, 'smiley_sort');
		}

		for ($i = 0; $i < count($smilies); $i++)
		{
			$orig[] = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
			$repl[] = '<img src="'. $path . $board_config['smilies_path'] . '/' . $smilies[$i]['smile_url'] . '" alt="' . $smilies[$i]['emoticon'] . '" border="0" />';
		}
	}

	if (count($orig))
	{
		$message = preg_replace($orig, $repl, ' ' . $message . ' ');
		$message = substr($message, 1, -1);
	}
	
	return $message;
}

function smiley_sort($a, $b)
{
	if ( strlen($a['code']) == strlen($b['code']) )
	{
		return 0;
	}

	return ( strlen($a['code']) > strlen($b['code']) ) ? -1 : 1;
}

	//Checks the boards default language to choose the right
	//FLV Player
	function check_country($text, $uid)
	{
	        // We need the board_config variable
	        global $board_config;
	        // Checks if code has already been modified
	        if(!strstr($text, 'phpbbplayer.php')) {
	                // Use germanplayer if Language is french
	                // otherwise the international player is used
	                if($board_config['default_lang'] == 'french')
	                {
	                        $text = "http://www.bitclix.de/portablecode/phpbbplayer.php?filmurl=".$text."";
	                } else {
	                        $text = "http://www.tradebit.com/portablecode/phpbbplayer.php?filmurl=".$text."";
	                }
	        }
		return $text;
	}
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
function rainbow($text)
{
	//
	// Returns text highlighted in rainbow colours
	//
	
	if ( !defined('RAINBOW_COLORS_LOADED') )
	{
		$colors = load_rainbow_colors ();
	}
	$text = trim(stripslashes($text));
	$length = strlen($text);
	$result = '';
	$color_counter = 0;
	$TAG_OPEN = false;
	for ( $i = 0; $i < $length; $i++ )
	{
		$char = substr($text, $i, 1);
		if ( !$TAG_OPEN )
		{
			if ( $char == '<' )
			{
				$TAG_OPEN = true;
				$result .= $char;
			}
			elseif ( preg_match("#\S#i", $char) )
			{
				$color_counter++;
				$result .= '<span style="color: ' . $colors[$color_counter] . ';">' . $char . '</span>';
				$color_counter = ( $color_counter == 7 ) ? 0 : $color_counter;
			}
			else
			{
				$result .= $char;
			}
		}
		else
		{
			if ( $char == '>' )
			{
				$TAG_OPEN = false;
			}
			$result .= $char;
		}
	}
	return $result;
}

function load_rainbow_colors ()
{
	return array(
		1 => 'red',
		2 => 'orange',
		3 => 'yellow',
		4 => 'green',
		5 => 'blue',
		6 => 'indigo',
		7 => 'violet'
		);
}
//-- fin mod : bbcode box reloaded ---------------------------------------------

// Start Smilies Invasion Mod
function smilies_count($message)
{
	
	$smilies_count = 0;

	global $db, $board_config;

	$sql = 'SELECT * FROM ' . SMILIES_TABLE;
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
	}
	$smilies = $db->sql_fetchrowset($result);

	if (count($smilies))
	{
		usort($smilies, 'smiley_sort');
	}

	$i = 0;
	while ($i < count($smilies))
	{
		$orig = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
		$repl = '<img src="'. $board_config['smilies_path'] . '/' . $smilies[$i]['smile_url'] . '" alt="' . $smilies[$i]['emoticon'] . '" title="' . $smilies[$i]['emoticon'] . '" border="0" />';
		// Matching limit set to 1 otherwise the user could enter the same smiley N times (lets call it Armageddon from now on)
		$tmp = preg_replace($orig, $repl, ' ' . $message . ' ', 1);
		$tmp = trim($tmp);
				
		if(strcasecmp($tmp, $message) != 0)
		{
			$smilies_count++;
			$message = $tmp;
		}
		else
		{
			// If we are not in Armageddon
			$i++;
		}
	}
	
	return $smilies_count;
}
// End Smilies Invasion Mod

// Extended_PM_Notification MOD
// This function is an altered version of asinshesq's bbcode_process_to_plain_text()
function pm_message_to_plain_text($text)
{
	global $lang;

	$newline = "\r\n";
	$q1 = $newline . '>>>>>>>>>>>>>>>>>>>>>>' . $newline;
	$q2 = $newline . '<<<<<<<<<<<<<<<<<<<<<<' . $newline; $newline;
	$l1 = $newline . '   (*) '; 
	$img1 = '[image at: ';
	$img2 = ' ]';

	$text = preg_replace('/\[quote=\"(.*?)\"\]/', $newline . '\\1 '. $lang['wrote'].':'.$q1, $text);
	$text = preg_replace('/\[quote\]/', $newline . $lang['Quote'].':'.$q1, $text);
	$text = preg_replace('/\[\/quote\]/', $q2, $text);

	$text = preg_replace('/\[code\]/', $newline . $lang['Code'].':'.$q1, $text);
	$text = preg_replace('/\[\/code:?1*\]/', $q2, $text);

	$text = preg_replace('/&#91;/', '[', $text);
	$text = preg_replace('/&#93;/', ']', $text);

	$text = preg_replace('/\[list\]/', $newline . '\\1 '. $lang['List'].':'.$q1, $text);
	$text = preg_replace('/\[list=[a-z]+\]/', $newline . '\\1 '. $lang['Ordered_list'].':'.$q1, $text);
	$text = preg_replace('/\[list=[1-2]?[0-9]+\]/', $newline . '\\1 '. $lang['Ordered_list'].':'.$q1, $text);
	$text = preg_replace('/\[\/list\]/', $q2, $text);
	$text = preg_replace('/\[\*\]/', $l1, $text);

	$text = preg_replace('/\[img\](.*?)\[\/img\]/', $img1 .'\\1' . $img2, $text);
	$text = preg_replace('/\[url=(.*?)\](.*?)\[\/url\]/', '\\1', $text);
	$text = preg_replace('/\[url\](.*?)\[\/url\]/', '\\1', $text);
	
	$text = preg_replace('/\[b\](.*?)\[\/b\]/', '\\1', $text);
	$text = preg_replace('/\[u\](.*?)\[\/u\]/', '\\1', $text);
	$text = preg_replace('/\[i\](.*?)\[\/i\]/', '\\1', $text);
	$text = preg_replace('/\[color=\#[0-9A-F]{6}\](.*?)\[\/color\]/', '\\1', $text);
	$text = preg_replace('/\[color=[a-z]+\](.*?)\[\/color\]/', '\\1', $text);
	$text = preg_replace('/\[size=[1-2]?[0-9]\](.*?)\[\/size\]/', '\\1', $text);
	$text = preg_replace('/\[email\](.*?)\[\/email\]/', '\\1', $text);

	$text = preg_replace('/(\\r\\n){3,}/s', $newline.$newline, $text);

	return $text;
}

$Clicks = array();

function AddClicksCounter($message)
{
	global $db, $Clicks, $lang;

	$ArraySub = array();
	
	preg_match_all('#href="([^"]*)"#Ui', $message, $ArraySub, PREG_SET_ORDER);
	
	for($i=0; $i<count($ArraySub); $i++)
	{
		$match = $ArraySub[$i][0];
		$url = trim($ArraySub[$i][1]);
		
		if(eregi('\/$', $url))
		{
			$url = substr($url, 0, strlen($url)-1);
		}
		$md5 = md5($url);
		
		if(!is_array($Clicks[$md5]))
		{
			$sql = $db->sql_query('SELECT id,clicks FROM '.CLICKS_TABLE.' WHERE url=\''.addslashes($url).'\' LIMIT 0,1');
			
			if($db->sql_numrows($sql))
			{
				$row = $db->sql_fetchrow($sql);
				$Clicks[$md5] = array();
				$Clicks[$md5][] = $row['id'];
				$Clicks[$md5][] = $row['clicks'];
			}
			else
			{
				$sql = $db->sql_query('INSERT INTO '.CLICKS_TABLE.'(id,url,clicks) VALUES (\'\', \''.addslashes($url).'\', \'0\')');
				$Clicks[$md5] = array();
				$Clicks[$md5][] = $db->sql_nextid();
				$Clicks[$md5][] = '0';
			}
		}
		$redirect = append_sid('./click.php?id='.$Clicks[$md5][0]);
		$message = preg_replace('#'.preg_quote($match, '#').'([^>]*)>(.*)<\/a>#Ui', 'href="'.$redirect.'"\\1>\\2</a> ('.sprintf($lang['ClickedXtimes'], $Clicks[$md5][1]).')', $message);
	}
	
	return $message;
}

?>
