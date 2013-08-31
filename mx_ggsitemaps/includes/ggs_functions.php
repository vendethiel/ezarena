<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: ggs_functions.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
// First basic security
if ( !defined('IN_PHPBB') && !defined('IN_PORTAL') ) {
	die('Hacking attempt');
	exit;
}
// Define table names.
if (defined('IN_PORTAL')) {
	$table_prefix =  $mx_table_prefix;
}
define('GGSITEMAP_TABLE', $table_prefix.'ggs_config');
/**
* phpBB_SEO Class lite
* For Compatibility with the phpBB SEO mod rewrites
* www.phpBB-SEO.com
* @package phpBB SEO
*/
// 
if (!is_object($phpbb_seo)) {
	class phpbb_seo {
		var	$seo_url = array();
		var	$seo_delim = array();
		var	$seo_ext = array();
		var	$seo_static = array();
		var	$modrtype = -1;
		var	$encoding = '';
		/**
		* constuctor
		*/
		function phpbb_seo() {
			$this->encoding = ''; // Leave as is to allow setting in acp in case you're not using the phpBB SEO mod rewrites.
			// URL Settings
			$this->seo_url = array( 'cat' => 'cat', 
				'forum' => 'forum', 
				'topic' => 'topic', 
				'user' => 'member'
			);
			$this->seo_delim = array('cat' => '-vc', 
				'forum' => '-vf', 
				'topic' => '-vt', 
				'user' => '-u'
			);
			$this->seo_ext = array('cat' => '.html', 
				'forum' => '.html', 
				'topic' => '.html', 
				'user' => '.html'
			);
			$this->seo_static = array('cat' => 'cat', 
				'forum' => 'forum', 
				'topic' => 'topic', 
				'post' => 'post', 
				'user' => 'member', 
				'start' => '-', 
				'gz_ext' => '.gz',
				'index' => ''
			);
			$this->modrtype = -1;
			return;
		}
		// --> Gen stats 
		/**
		* Returns microtime
		* Borrowed from php.net
		*/
		function microtime_float() {
			return array_sum(explode(' ', microtime()));
		}
		// --> URL rewriting functions <--
		/**
		* Prepare Titles for URL injection
		* Replace by the function you'd prefer for different URL injection standards
		*/
		function format_url( $url, $type = 'topic' ) {
			//Short url
			$url = preg_replace("(\[.*\])U","",$url);
			$find = array('&quot;','&amp;','&lt;','&gt;','\r\n','\n',);
			$url = str_replace ($find, '-', $url);
			$url = str_replace ('ß', 'ss', $url);
			$url = str_replace (array('ö','Ö'), 'oe', $url);
			$url = str_replace (array('ä','Ä'), 'ae', $url);
			$url = str_replace (array('ü','Ü'), 'ue', $url);
			$find = "ÀÁÂÃÅàáâãåÒÓÔÕØòóôõøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛùúûÿÑñ";
			$replace = "aaaaaaaaaaooooooooooeeeeeeeecciiiiiiiiuuuuuuynn";
			$url = strtr($url,$find,$replace);
			$url = preg_replace("`[^a-zA-Z0-9]`", "-", $url);
			$url = preg_replace("`[-]+`", "-", $url);
			$url = trim($url, '-');
			$url = ( $url == "" ) ? $type : strtolower($url);
			return $url;
		}
	}
	$phpbb_seo = new phpbb_seo();
}
/**
* GGSitemaps Class
* www.phpBB-SEO.com
* @package phpBB SEO
*/
class GGSitemaps {
	// $_GET vars
	var $actions = array();
	var $action = 'sitemapindex';
	var $list_id = 0;
	// Working vars
	var $ggsitemaps_config = array();
	var $output_data = array();
	var $cache_config = array();
	var $yahoo_config = array();
	var $ext_config = array();
	var $gzip_config = array();
	var $style_config = array();
	var $Errors = array();
	var $Error_count = 0;
	/**
	* constuctor
	*/
	function GGSitemaps($actions = array(), $paths = array()) {
		global $db, $board_config, $phpEx, $phpbb_seo;
		$start_time = $phpbb_seo->microtime_float();
		// Set default values
		$this->Errors = array();
		$this->Error_count = 0;
		$this->ggsitemaps_config = array();
		// Grab ggsitemaps config
		$sql = "SELECT * FROM " . GGSITEMAP_TABLE;
		//Begin sql cache
		if ( !$result = $db->sql_query( $sql ) ) {
		//if( !($result = $db->sql_query($sql, false, 'GGS_')) ) {
		//End sql cache 
			$this->mx_sitemaps_message_die( CRITICAL_ERROR, "Could not query mx Sitemaps configuration information ", "", __LINE__, __FILE__, $sql );
		}
		$row = array();
		while ( $row = $db->sql_fetchrow($result) ) {
			$this->ggsitemaps_config[$row['config_name']] = $row['config_value'];
		}
		$db->sql_freeresult($result);
		unset($row);
		// reset params
		$this->actions 		= $actions;
		$this->path_config 	= $paths;
		// The main array
		$this->output_data 	= array('microtime'=> $start_time,
						'time'	=> time(),
						'mem_usage' => 0,
						'gen_data' => '',
						'gen_out' => '',
						'url_sofar' => 0,
						'mod_since' => ( $this->ggsitemaps_config['ggs_mod_since'] == "TRUE" ) ? TRUE : FALSE,
						'showstats' => ($this->ggsitemaps_config['ggs_showstats'] == "TRUE" ) ? TRUE : FALSE,
						'exclude_list' => array(),
						'data' => '',
						'url' => '',
						'uri' => '',
		);
		if ($this->output_data['showstats']) {
			if ( @function_exists('memory_get_usage') ) {
				$this->output_data['mem_usage'] = memory_get_usage();
			}
		}
		$this->yahoo_config	= array('yahoo' => ($this->actions['action'] === 'yahoo') ? TRUE : FALSE,
						'yahoo_limit' => intval($this->ggsitemaps_config['yahoo_limit']),
						'yahoo_sql_limit' => intval($this->ggsitemaps_config['yahoo_sql_limit']),
						'limit_time' => ( $this->ggsitemaps_config['yahoo_limit_time'] >= 0 ) ? round($this->ggsitemaps_config['yahoo_limit_time'],2) * 3600*24 : 14*3600*24,
						'yahoo_pagination' => ($this->ggsitemaps_config['yahoo_pagination'] === 'TRUE') ? TRUE : FALSE,
						'yahoo_limitdown' => intval($this->ggsitemaps_config['yahoo_limitdown']),
						'yahoo_limitup'	=> intval($this->ggsitemaps_config['yahoo_limitup']),
						'yahoo_sort' => 'DESC',
		);
		$this->ext_config 	= array('gzip_ext' => '',
						'file_ext' => '',
						'gzip_ext_out' => '',
		);
		$this->gzip_config 	= array('gzip' 	=> ( $this->ggsitemaps_config['ggs_gzip'] == "TRUE" ) ? TRUE : FALSE,
						'gzip_level' => $this->ggsitemaps_config['ggs_gzip_level'],
		);
		$this->cache_config 	= array('cache_enable' => ( $this->ggsitemaps_config['ggs_cached'] == "TRUE" ) ? TRUE : FALSE,
						'auto_regen' => ( $this->ggsitemaps_config['ggs_auto_regen'] == "TRUE" ) ? TRUE : FALSE,
						'force_cache_gzip' => ( $this->ggsitemaps_config['ggs_force_cache_gzip'] == "TRUE" ) ? TRUE : FALSE,
						'cache_born' => intval($this->ggsitemaps_config['google_cache_born']),
						'cache_max_age' => round($this->ggsitemaps_config['ggs_cache_max_age'],2) * 3600,
						'rss_cache_born' => intval($this->ggsitemaps_config['rss_cache_born']),
						'yahoo_cache_born' => intval($this->ggsitemaps_config['yahoo_cache_born']),
						'rss_cache_max_age' => round($this->ggsitemaps_config['rss_cache_max_age'],2)* 3600,
						'yahoo_cache_max_age' => round($this->ggsitemaps_config['yahoo_cache_max_age'],2)* 3600,
						'rss_auto_regen' => ( $this->ggsitemaps_config['rss_auto_regen'] == "TRUE" ) ? TRUE : FALSE,
						'cache_dir' => $this->ggsitemaps_config['ggs_cache_dir'],
						'file_name' => '',
						'extra_cat' => '',
						'auth_param' => '',
						'cached' => TRUE,
					);
		// Can you believe it, sprintf is faster than straight parsing. 
		$this->style_config	= array('Sitemap_tpl' => "\n\t" . '<url>' . "\n\t\t" . '<loc>%s</loc>' . "\n\t\t" . '<lastmod>%s</lastmod>' . "\n\t\t" . '<changefreq>%s</changefreq>' . "\n\t\t" . '<priority>%s</priority>' . "\n\t" . '</url>',
						'SitmIndex_tpl' => "\n\t" . '<sitemap>' . "\n\t\t" . '<loc>%s</loc>' . "\n\t\t" . '<lastmod>%s</lastmod>' . "\n\t" . '</sitemap>',
						'rss_tpl' => "\n\t\t" . '<item>' . "\n\t\t\t" . '<title>%s</title>'. "\n\t\t\t" . '<link>%s</link>' . "\n\t\t\t" . '<pubDate>%s</pubDate>' . "\n\t\t\t" . '<description>%s</description>' . "\n\t\t\t" . '<source url="%s">%s</source>' . "\n\t\t\t" . '<guid isPermaLink="true">%s</guid>' . "\n\t\t" . '</item>',
						'stats_genlist'	=> "\n" . '<!-- URL list generated in  %s s %s - %s sql - %s URLs listed -->',
						'stats_start' => "\n" . '<!--  Output started from cache after %s s - %s sql -->',
						'stats_nocache'	=> "\n" . '<!--  Output ended after %s s %s -->',
						'stats_end' => "\n" . '<!--  Output from cache ended up after %s s - %s sql -->',
		);
		$this->mod_r_config	= array('mod_rewrite' => ( $this->ggsitemaps_config['ggs_mod_rewrite'] == "TRUE" ) ? TRUE : FALSE,
						'mod_r_type' => intval($this->ggsitemaps_config['ggs_mod_rewrite_type']),
						'topic_topic' => "viewtopic.$phpEx?" . POST_TOPIC_URL . "=",
						'forum_forum'=> "viewforum.$phpEx?" . POST_FORUM_URL . "=",
						'start' => '&amp;start=',
						'ext'	=> '',
						'ext_out'=> '',
						'forum_google'=> "sitemap.$phpEx?forum=",
						'forum_rss'=> "rss.$phpEx?forum=",
						'extra_params'=> "",
						'zero_dupe'=> ( $this->ggsitemaps_config['ggs_zero_dupe'] == "TRUE" ) ? TRUE : FALSE,
						'forum_simple'=> $phpbb_seo->seo_static['forum'],
						'topic_simple'=> $phpbb_seo->seo_static['topic'],
						'topic_anchor' => $phpbb_seo->seo_delim['topic'],
						'forum_anchor' => $phpbb_seo->seo_delim['forum'],

		);
		// Clear buffer, just in case it was started elswhere
		while (@ob_end_clean());
		$this->ggs_output();
		return;
	}
	// --> URL rewriting functions <--
	/**
	* Initialize mod rewrite to handle multiple URL standards.
	* Only one if is added after this to properly switch 
	* between the four types (none, advanced, mixed and simple).
	* @access private
	*/
	function ggs_init_mod_rewrite() {
		global $phpbb_seo;
		// vars will fell like rain in the code ;)
		$this->mod_r_config['forum_pre'] = $this->mod_r_config['forum_forum'];
		$this->mod_r_config['topic_pre'] = $this->mod_r_config['topic_topic'];
		$this->mod_r_config['forum_pre_google'] = $this->mod_r_config['forum_google'];
		$this->mod_r_config['forum_pre_rss'] = $this->mod_r_config['forum_rss'];
		// Mod rewrite type auto detection
		$this->mod_r_config['mod_r_type'] = ($phpbb_seo->modrtype >= 0) ? intval($phpbb_seo->modrtype) : $this->mod_r_config['mod_r_type'];
		if ($this->mod_r_config['mod_rewrite']) { // Module links
			$this->mod_r_config['forum_pre_google'] = $this->mod_r_config['forum_google'] = 'forum-gf';
			$this->mod_r_config['forum_pre_rss'] = $this->mod_r_config['forum_rss'] = 'forum-rss';
			$this->mod_r_config['ext_out'] = '.xml';
			$this->mod_r_config['ext_out'] .= $this->ext_config['gzip_ext_out'];
		}
		if ($this->mod_r_config['mod_r_type'] >= 1) { // Simple mod rewrite, default is none (0)
			$this->mod_r_config['start'] = $phpbb_seo->seo_static['start'];
			$this->mod_r_config['forum_pre'] = $phpbb_seo->seo_static['forum'];
			$this->mod_r_config['topic_pre'] = $phpbb_seo->seo_static['topic'];
			$this->mod_r_config['ext'] = '.html';
		}
		if ($this->mod_r_config['mod_r_type'] >= 2) { // +Mixed
			$this->mod_r_config['forum_pre'] = '';
			if ($this->mod_r_config['mod_rewrite']) { // Module links
				$this->mod_r_config['forum_pre_google']  = $this->mod_r_config['forum_pre_rss'] = '';
			}
		} 
		if ($this->mod_r_config['mod_r_type'] >= 3) { // +Advanced
			$this->mod_r_config['topic_pre'] = '';
		}
		// Mod rewrite extentions settings.
		if ( $this->mod_r_config['ext'] == "" ) {
			foreach ( $phpbb_seo->seo_ext as $key => $value ) {
				$phpbb_seo->seo_ext[$key] = "";
			}
		}
		return;
	}
	// --> Output functions <--
	/**
	* ggs_output() is called when no cache file is available for the request
	* Will filter cases, call function to build output and cache on the fly
	* @access private
	*/
	function ggs_output() {
		global $board_config, $lang, $phpEx, $phpbb_seo;
		// Check if gzip is avalable and set proper values for this event
		// if phpBB gun-zip is acvtivated, then we must activat it in the module
		$this->gzip_config['gzip'] = ($board_config['gzip_compress']) ? TRUE : $this->gzip_config['gzip'];
		if (!$this->check_gzip() && $this->gzip_config['gzip']) {
			$this->gzip_config['gzip'] = FALSE;
		}
		// handle the force Gun-zip cache option
		$this->ext_config['gzip_ext'] = ($this->gzip_config['gzip'] || $this->cache_config['force_cache_gzip']) ? '.gz' : '';
		$this->ext_config['file_ext'] = ($this->yahoo_config['yahoo']) ? '.txt' : '.xml';
		$this->ext_config['gzip_ext_out'] = ($this->gzip_config['gzip']) ? '.gz' : '';
		// URI check for gzip handling
		$this->output_data['uri'] = $this->ggs_seo_req_uri();

		// What to do now ?
		switch ($this->actions['type']) {
			case 'rss_':
				$this->rss_config	= array('rss' =>  ($this->actions['type'] === 'rss_') ? TRUE : FALSE,
							'rss_url_limit' => intval($this->ggsitemaps_config['rss_url_limit']),
							'rss_sql_limit' => intval($this->ggsitemaps_config['rss_sql_limit']),
							'limit_time' => ( $this->ggsitemaps_config['rss_limit_time'] >= 0 ) ? round($this->ggsitemaps_config['rss_limit_time'],2) * 86400 : 864000,
							'rss_lang' => ($this->ggsitemaps_config['rss_lang'] != '') ? "\n\t\t" . '<language>' . $this->ggsitemaps_config['rss_lang'] . '</language>' : '',
							'rss_cache_auth' => ( $this->ggsitemaps_config['rss_cache_auth'] == "TRUE" ) ? TRUE : FALSE,
							'rss_image' => $this->path_config['img_url'] . trim($this->ggsitemaps_config['rss_image'], "/"),
							'rss_forum_image'=> $this->path_config['img_url'] . trim($this->ggsitemaps_config['rss_forum_image'], "/"),
							'rss_first' => ( $this->ggsitemaps_config['rss_first'] == "TRUE" ) ? TRUE : FALSE,
							'rss_last' => ( $this->ggsitemaps_config['rss_last'] == "TRUE" ) ? TRUE : FALSE,
							'rss_sort' => 'DESC',	
							'msg_txt' => ( $this->ggsitemaps_config['rss_msg_txt'] == "TRUE" ) ? TRUE : FALSE,
							'rss_allow_bbcode' => ( $this->ggsitemaps_config['rss_allow_bbcode'] == "TRUE" ) ? TRUE : FALSE,
							'rss_strip_bbcode' => trim( $this->ggsitemaps_config['rss_strip_bbcode'] ),
							'rss_allow_links' => ( $this->ggsitemaps_config['rss_allow_links'] == "TRUE" ) ? TRUE : FALSE,
							'rss_allow_smilies' => ( $this->ggsitemaps_config['rss_allow_smilies'] == "TRUE" ) ? TRUE : FALSE,
							'allow_short' => ( $this->ggsitemaps_config['rss_allow_short'] == "TRUE" ) ? TRUE : FALSE,
							'allow_long' => ( $this->ggsitemaps_config['rss_allow_long'] == "TRUE" ) ? TRUE : FALSE,
							'yahoo_notify_long' => ( $this->ggsitemaps_config['yahoo_notify_long'] == "TRUE" ) ? TRUE : FALSE,
							'yahoo_notify'=> ( $this->ggsitemaps_config['yahoo_notify'] == "TRUE" ) ? TRUE : FALSE,
							'yahoo_notify_url' => '',
							'yahoo_appid' => ( $this->ggsitemaps_config['yahoo_appid'] !='' ) ? trim($this->ggsitemaps_config['yahoo_appid']) : '',
							'msg_sumarize' => ( $this->ggsitemaps_config['rss_sumarize'] >= 0 ) ? intval($this->ggsitemaps_config['rss_sumarize']) : 0,
							'msg_sumarize_method' => trim( $this->ggsitemaps_config['rss_sumarize_method'] ),
							'sitename' => $this->ggsitemaps_config['rss_sitename'],
							'site_desc' => $this->ggsitemaps_config['rss_site_desc'],
							'c_info' => ($this->ggsitemaps_config['rss_cinfo'] !='') ? "\n\t\t" . '<copyright>' . $this->ggsitemaps_config['rss_cinfo'] . '</copyright>' : '',
							'rss_charset' => trim( $this->ggsitemaps_config['rss_charset'] ),
							'rss_charset_conv' => trim( $this->ggsitemaps_config['rss_charset_conv'] ),
							'rss_xslt' => ( $this->ggsitemaps_config['rss_xslt'] == "TRUE" ) ? TRUE : FALSE,
							'rss_force_xslt' => ( $this->ggsitemaps_config['rss_force_xslt'] == "TRUE" ) ? TRUE : FALSE,
						);
				$this->rss_config['rss_charset'] = ( !empty($phpbb_seo->encoding) ) ? strtolower($phpbb_seo->encoding) : $this->rss_config['rss_charset'];
				// In case we're using utf-8, do nothing
				$this->rss_config['non_utf8'] = ( $this->rss_config['rss_charset'] === 'utf-8' ) ? FALSE : TRUE;
				// Go as fast as possible, only inlude utf_tools.php when required.
				$this->rss_config['use_native_utf8_encode'] = ( ($this->rss_config['rss_charset'] === 'iso-8859-1') && ($this->rss_config['rss_charset_conv'] === 'auto') && @extension_loaded('xml') ) ? TRUE : FALSE;
				// gzip extension
				$this->ext_config['gzip_ext_out'] = ( $this->ggsitemaps_config['rss_gzip_ext'] == "TRUE" ) ? $this->ext_config['gzip_ext_out'] : '';
				// URI check for gzip handling
				$this->check_requested_ext($this->output_data['uri']);
				// Initialize URL rewriting
				$this->ggs_init_mod_rewrite();
				$this->cache_config['cache_max_age'] = $this->cache_config['rss_cache_max_age'];
				$this->cache_config['auto_regen'] = $this->cache_config['rss_auto_regen'];
				$this->cache_config['cache_born'] = $this->cache_config['rss_cache_born'];
				if ($this->rss_config['allow_long'] && $this->actions['long'] === 'long') {
					$this->rss_config['rss_url_limit'] = intval( $this->ggsitemaps_config['rss_url_limit_long']);
					$this->ggsitemaps_config['rss_url_limit_txt'] = intval( $this->ggsitemaps_config['rss_url_limit_txt_long']);
					$this->mod_r_config['extra_params'] = ($this->mod_r_config['mod_rewrite']) ? '-l' : '&amp;l';
					$this->rss_config['extra_title'] = $lang['rss_long'];
				} elseif ($this->rss_config['allow_short'] && $this->actions['short'] === 'short') {
					$this->rss_config['rss_url_limit'] = intval( $this->ggsitemaps_config['rss_url_limit_short'] );
					$this->ggsitemaps_config['rss_url_limit_txt'] = intval( $this->ggsitemaps_config['rss_url_limit_txt_short'] );
					$this->mod_r_config['extra_params'] = ($this->mod_r_config['mod_rewrite']) ? '-s' : '&amp;s';
					$this->rss_config['extra_title'] = $lang['rss_short'];
				}
				$this->rss_config['msg_out'] = ($this->rss_config['msg_txt'] && $this->actions['msgtxt'] === 'msg') ? TRUE : FALSE;
				if ( $this->rss_config['msg_out'] ) {
					$this->rss_config['rss_url_limit'] = intval($this->ggsitemaps_config['rss_url_limit_txt']);
					$this->rss_config['rss_sql_limit'] = intval($this->ggsitemaps_config['rss_sql_limit_txt']);
					$this->mod_r_config['extra_params'] .= ($this->mod_r_config['mod_rewrite']) ? '-m' : '&amp;m';
					$this->rss_config['extra_title'] = $lang['rss_msg'] . $this->rss_config['extra_title'];
					// initalize bbcode filters
					if ( !empty($this->rss_config['rss_strip_bbcode']) ) {
						$this->rss_config['rss_bbcode_filters'] = $this->set_strip_bbcode($this->rss_config['rss_strip_bbcode']);
					}
				}
				if ( $this->actions['cat'] == 'cat' ) {
					$this->cache_config['extra_cat'] = '-cat';
				}
				// Deal with auth
				if ( $this->actions['auth_checked'] ) {
					$this->cache_config['cache_enable'] = ($this->cache_config['cache_enable']) ? $this->rss_config['rss_cache_auth'] : $this->cache_config['cache_enable'];
					@sort($this->actions['not_auth']);
					$this->cache_config['auth_param'] = implode("-", $this->actions['not_auth']) . 'auth';
				}
				$this->ggs_setup_cache();
				$this->GGs_rss();
				$this->GGs_yahoo_notify();
				break;
			case 'google_':
				$this->google_config	= array('ggs_default_priority' =>  sprintf('%.2f', $this->ggsitemaps_config['ggs_default_priority']),
								'ggs_sticky_priority' => sprintf('%.2f', $this->ggsitemaps_config['ggs_sticky_priority']),
								'ggs_announce_priority' => sprintf('%.2f', $this->ggsitemaps_config['ggs_announce_priority']),
								'ggs_pagination' => ($this->ggsitemaps_config['ggs_pagination'] === 'TRUE') ? TRUE : FALSE,
								'ggs_limitdown' => intval($this->ggsitemaps_config['ggs_limitdown']),
								'ggs_limitup'=> intval($this->ggsitemaps_config['ggs_limitup']),
								'ggs_sql_limit' => intval($this->ggsitemaps_config['ggs_sql_limit']),
								'ggs_url_limit' => intval($this->ggsitemaps_config['ggs_url_limit']),
								'ggs_sort' => ($this->ggsitemaps_config['ggs_sort'] === 'DESC') ? 'DESC' : 'ASC',
								'ggs_xslt' => ( $this->ggsitemaps_config['ggs_xslt'] == "TRUE" ) ? TRUE : FALSE,
				);
				$this->ext_config['gzip_ext_out'] = ( $this->ggsitemaps_config['ggs_gzip_ext'] == "TRUE" ) ? $this->ext_config['gzip_ext_out'] : '';
				// URI check for gzip handling
				$this->check_requested_ext($this->output_data['uri']);
				// Initialize URL rewriting
				$this->ggs_init_mod_rewrite();
				$this->ggs_setup_cache();
				if ($this->actions['action'] != 'sitemapindex') {
					$this->GGs_sitemap();
				} else {
					$this->GGs_sitemapindex();
				}
				break;
			case 'yahoo_':
				// URI check for gzip handling
				$this->check_requested_ext($this->output_data['uri']);
				// Initialize URL rewriting
				$this->ggs_init_mod_rewrite();
				$this->cache_config['cache_max_age'] = $this->cache_config['yahoo_cache_max_age'];
				$this->cache_config['auto_regen'] = $this->cache_config['yahoo_auto_regen'];
				$this->cache_config['cache_born'] = $this->cache_config['yahoo_cache_born'];
				// No stats for Yahoo urllist.txt
				$this->output_data['showstats'] = FALSE;
				$this->ggs_setup_cache();
				$this->GGs_yahoo();
				break;
			default:
				// something is wrong
				$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'No action matched your request');
		}
		if ($this->cache_config['cache_enable']) {
			$this->write_sitm_cache();	
			if ($this->check_sitm_cache($this->cache_config['file'])){
				$this->GGs_cache_output();
			} else {
				$this->GGs_otfoutput();
			}
		} else {
			$this->GGs_otfoutput();
		}
		return;
	}
	/**
	* GGs_cache_output() is called to output from a cached file
	* Build the last stats, send the header and output the cached file
	* @access private
	*/
	function GGs_cache_output() {
		global $lang,$phpbb_seo;
		// Unset lang array before output
		unset($lang);
		if ($this->output_data['showstats']) {
			$this->output_data['gen_out'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
			$genstats = sprintf($this->style_config['stats_start'], $this->output_data['gen_out'], $db->num_queries);
		} else {
			$genstats = '';
		}
		if ($this->gzip_config['gzip']) {
			$this->send_header();
			readfile($this->cache_config['file']);
		} else {
			$this->send_header();
			if ($this->cache_config['force_cache_gzip']) {
				readgzfile($this->cache_config['file']);
				if ($this->output_data['showstats']) {
					$this->output_data['gen_out'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
					$genstat2 = sprintf($this->style_config['stats_end'], $this->output_data['gen_out'], $db->num_queries);
					echo $genstats . $genstat2;
				}
			} else {
				readfile($this->cache_config['file']);
				if ($this->output_data['showstats']) {
					$this->output_data['gen_out'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
					$genstat2 = sprintf($this->style_config['stats_end'], $this->output_data['gen_out'], $db->num_queries);
					echo $genstats . $genstat2;
				}
			}
		}
		$this->safe_exit();
		return;
	}
	/**
	* GGs_otfoutput() will do the output on the fly
	* when cache disabled or caching failed
	* @access private
	*/
	function GGs_otfoutput() {
		global $lang,$phpbb_seo;
		// Unset lang array before output
		unset($lang);
		if ($this->gzip_config['gzip']) {
			$this->output_data['data'] = gzencode($this->output_data['data'], $this->gzip_config['gzip_level']);
			$this->send_header();
			echo $this->output_data['data'];
			unset($this->output_data['data']);

		} else {
			$this->send_header();
			echo $this->output_data['data'];
			if ($this->output_data['showstats']) {
				$mem_stats = $this->ggs_mem_usage();
				$this->output_data['gen_out'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
				$genstats = sprintf($this->style_config['stats_nocache'], $this->output_data['gen_out'], $mem_stats);
				echo $genstats;
			}
			unset($this->output_data['data']);
		}
		$this->safe_exit();
		return;
	}
	/**
	* send_header() takes care about headers
	* @access private
	*/
	function send_header() {
		if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2')) {
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		} else {
			header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		}
		if ($this->gzip_config['gzip']) {
			header('Expires: '. $this->output_data['expires_time']);
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', $this->output_data['last_mod_time']));
			header('Etag: ' . $this->output_data['etag']);
			header('Accept-Ranges: bytes');
			header("Content-type: " . (($this->yahoo_config['yahoo']) ? 'text/plain' : 'text/xml') . '; charset=UTF-8');
			header('Content-Encoding: ' . $this->check_gzip_type());
		} else {
			header('Expires: '. $this->output_data['expires_time']);
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', $this->output_data['last_mod_time']));
			header('Etag: ' . $this->output_data['etag']);
			header('Accept-Ranges: bytes');
			header("Content-type: " . (($this->yahoo_config['yahoo']) ? 'text/plain' : 'text/xml') . '; charset=UTF-8');
		}
		return;
	}
	// --> Build list functions <--
	// --> Google sitemap functions <--
	/**
	* GGs_sitemapindex() will build our sitemapIndex
	* Listing all available sitemaps
	* @access private
	*/
	function GGs_sitemapindex() {
		global $phpEx, $db, $board_config, $phpbb_seo;
		$sitemapindex_url = $this->path_config['sitemap_url'] . (($this->mod_r_config['mod_rewrite']) ? 'sitemaps.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx);
		$this->seo_kill_dupes($sitemapindex_url);
		$ggs_xslt = ($this->google_config['ggs_xslt']) ? "\n" . '<?xml-stylesheet type="text/xsl" href="' . $this->path_config['sitemap_url'] . 'ggs_style/mxgss.xsl"?>' : '';
		$this->output_data['data'] = "<?xml version='1.0' encoding='UTF-8'?>" . $ggs_xslt . "\n" . '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n\t" . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n\t" . 'http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"' . "\n\t" . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" . '<!--	Generated by Google Yahoo MSN Sitemaps and RSS ' . $this->ggsitemaps_config['ggs_ver'] . ' - ' . $this->ggsitemaps_config['ggs_c_info'] . ' -->' . "\n";
		$dir = @opendir( $this->path_config['module_path'] . 'includes' );
		while( ($file = @readdir($dir)) !== FALSE ) {
			if( preg_match("/^google_[a-zA-Z0-9_-]+\." . $phpEx . "$/", $file) ) {
				include_once($this->path_config['module_path'] . 'includes/' . $file);
			}
		}
		@closedir($dir);
		if ($this->output_data['showstats']) {
			$this->output_data['gen_data'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
			$mem_stats = $this->ggs_mem_usage();
			$this->output_data['data'] .= "\n" . '</sitemapindex>' . sprintf($this->style_config['stats_genlist'], $this->output_data['gen_data'], $mem_stats, $db->num_queries, $this->output_data['url_sofar']);
		} else {
			$this->output_data['data'] .= "\n" . '</sitemapindex>';
		}
		return;
	}
	/**
	* GGs_sitemap() will build the actual Google sitemaps, all cases
	* @access private
	*/
	function GGs_sitemap() {
		global $phpEx, $db, $board_config, $portal_config, $phpbb_seo;
		// Initialize SQL cycling : do not query for more than required
		$this->google_config['ggs_sql_limit'] = ($this->google_config['ggs_sql_limit'] > $this->google_config['ggs_url_limit']) ? $this->google_config['ggs_url_limit'] : $this->google_config['ggs_sql_limit'];
		$ggs_xslt = ($this->google_config['ggs_xslt']) ? "\n" . '<?xml-stylesheet type="text/xsl" href="' . $this->path_config['sitemap_url'] . 'ggs_style/mxgss.xsl"?>' : '';
		$this->output_data['data'] = "<?xml version='1.0' encoding='UTF-8'?>" . $ggs_xslt . "\n" . '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n\t" . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n\t" . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"' . "\n\t" . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" . '<!--	Generated Google Yahoo MSN Sitemaps and RSS ' . $this->ggsitemaps_config['ggs_ver'] . ' - ' . $this->ggsitemaps_config['ggs_c_info'] . ' -->' . "\n";
		include($this->path_config['module_path'] . 'includes/google_' . $this->actions['action'] . '.' . $phpEx);
		if ($this->output_data['showstats']) {
			$this->output_data['gen_data'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
			$mem_stats = $this->ggs_mem_usage();
			$this->output_data['data'] .= "\n" . '</urlset>' . sprintf($this->style_config['stats_genlist'], $this->output_data['gen_data'], $mem_stats, $db->num_queries, $this->output_data['url_sofar']);
		} else {
			$this->output_data['data'] .= "\n" . '</urlset>';
		}
		return;
	}
	// --> Yahoo! functions <--
	/**
	* GGs_yahoo() will build our urllist.txt to be submited at Yahoo.com
	* @access private
	*/
	function GGs_yahoo() {
		global $phpEx, $db, $board_config, $phpbb_seo;
		// Initialize SQL cycling : do not query for more than required
		$this->yahoo_config['yahoo_sql_limit'] = ($this->yahoo_config['yahoo_sql_limit'] > $this->yahoo_config['yahoo_limit']) ? $this->yahoo_config['yahoo_limit'] : $this->yahoo_config['yahoo_sql_limit'];
		$this->output_data['showstats'] = FALSE;
		$this->mod_r_config['start'] = str_replace("&amp;", "&", $this->mod_r_config['start']);
		$dir = @opendir( $this->path_config['module_path'] . 'includes' );
		while( ($file = @readdir($dir)) !== FALSE ) {
			if( preg_match("/^yahoo_[a-zA-Z0-9_-]+\." . $phpEx . "$/", $file) ) {
				include_once($this->path_config['module_path'] . 'includes/' . $file);
			}
		}
		@closedir($dir);
		return;
	}
	/**
	* GGs_yahoo_notify() will handle yahoo notification of new content
	* @access private
	*/
	function GGs_yahoo_notify() {
		global $lang;
		$not_curl= TRUE;
		if ($this->rss_config['yahoo_notify'] != '') {
			if ( $this->rss_config['yahoo_notify_url'] != '' && $this->rss_config['yahoo_appid'] != '') {
				// The Yahoo! Web Services request
				// Based on the Yahoo! developper hints : http://developer.yahoo.com/php/
				//	$request = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=" . $this->rss_config['yahoo_appid'] . "&url=$url"
				$request = "http://www.phpbb-seo.com/yahoo.php?appid=" . $this->rss_config['yahoo_appid'] . "&url=" . $this->rss_config['yahoo_notify_url'];
				if (function_exists('curl_exec')) {
					$not_curl= FALSE;
					// Initialize the session
					$session = curl_init($request);
					// Set curl options
					curl_setopt($session, CURLOPT_HEADER, false);
					curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
					// Make the request
					$response = curl_exec($session);
					// Close the curl session
					curl_close($session);
					// Get HTTP Status code from the response
					$status_codes = array();
					preg_match('/\d\d\d/', $response, $status_code);
					$status_code = $status_codes[0];
					// Get the XML from the response, bypassing the header
					if (!($xml = strstr($response, '<?xml'))) {
						$xml = null;
						$not_curl= TRUE;
					}
				} else if ( $not_curl && function_exists('file_get_contents') ) {
					// Make the request
					if ($xml = file_get_contents($request)) {
						// Retrieve HTTP status code
						list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
					} else {
						$this->mx_sitemaps_message_die(GENERAL_ERROR, sprintf($lang['yahoo_no_method'], $request, $xml));
					}
				}
				// Check the XML return message
				// Do it this way here in case curl actually returned no header 
				// but did get the proper answer. 
				if (!strpos($xml, 'success')) {
					// Check the HTTP Status code
					switch( $status_code ) {
						case 200:
							// Success
							break;
						case 503:
							$this->mx_sitemaps_message_die(GENERAL_ERROR, $lang['yahoo_error_503']);
							break;
						case 403:
							$this->mx_sitemaps_message_die(GENERAL_ERROR, $lang['yahoo_error_403']);
							break;
						case 400:
							$this->mx_sitemaps_message_die(GENERAL_ERROR, sprintf($lang['yahoo_error_400'], $request, $xml));
							break;
						default:
							$this->mx_sitemaps_message_die(GENERAL_ERROR, sprintf($lang['yahoo_error'], $status_code, $request, $xml) );
					}
				}
			}
		}
		return;
	}
	// --> RSS functions <--
	/**
	* GGs_rss() will build all rss output
	* @access private
	*/
	function GGs_rss() {
		global $phpEx, $db, $board_config, $userdata, $phpbb_root_path, $lang, $phpbb_seo;
		// Set up msg outpout
		$this->rss_config['rss_last'] = ($this->rss_config['rss_first']) ? $this->rss_config['rss_last'] : TRUE;
		// Initialize SQL cycling : do not query for more than required
		$this->rss_config['rss_sql_limit'] = ($this->rss_config['rss_sql_limit'] > $this->rss_config['rss_url_limit']) ? $this->rss_config['rss_url_limit'] : $this->rss_config['rss_sql_limit'];
		// Built the auth warning
		$auth_msg = '';
		if ( $this->actions['auth_checked'] ) {
			$auth_msg = '<br/><br/>' . ( ( is_numeric($this->actions['list_id']) &&  $this->actions['list_id'] > 0 ) ? sprintf($lang['rss_auth_this'], $userdata['username'] ) : sprintf($lang['rss_auth_some'], $userdata['username'] ) );
			$auth_msg = htmlspecialchars($auth_msg);
		}
		// XSLT styling
		$rss_xslt = '';
		if ($this->rss_config['rss_xslt']) {
			// Isn't this a bit stupid, we need to trick browsers to allow xlst usage
			// We do it by adding some space chars at the beginning of the xml code
			// FF 2 and IE7 only look for the first 500 chars to decide it's rss or not
			// and impose their private handling
			$blanc_fix = '';
			if ($this->rss_config['rss_force_xslt']) {
				for ($i=0; $i<650; $i++) {
					$blanc_fix .= ' ';
				}
				$blanc_fix = "\n" . '<!-- Some spaces ' . $blanc_fix . ' to force xlst -->';
			}
			$rss_xslt = ($this->rss_config['rss_xslt']) ? '<?xml-stylesheet title="XSL_formatting" type="text/xsl" href="' . $this->path_config['rss_url'] . 'ggs_style/mxrss2.xsl"?>' . $blanc_fix : '';
		}
		$this->output_data['data'] = '<?xml version="1.0" encoding="utf-8"?>' . $rss_xslt . "\n" . '<!--	Generated by Google Yahoo MSN Sitemaps and RSS ' . $this->ggsitemaps_config['ggs_ver'] . ' - ' . $this->ggsitemaps_config['ggs_c_info'] . ' -->' . "\n" . '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/">';
		
		$this->style_config['rsschan_img_tpl'] = '<image>' . "\n\t\t\t" . '<title>%s</title>' . "\n\t\t\t" . '<url>%s</url>' . "\n\t\t\t" . '<link>%s</link>' . "\n\t\t" . '</image>';
		
		$this->style_config['rsschan_tpl'] = "\n\t" . '<channel>' . "\n\t\t" . '<title>%s</title>' . "\n\t\t" . '<link>%s</link>' . "\n\t\t" . '<description>%s</description>' . $this->rss_config['rss_lang'] . $this->rss_config['c_info'] . "\n\t\t" . '<lastBuildDate>%s</lastBuildDate>' . "\n\t\t" . '%s' . "\n\t\t" . '<docs>http://blogs.law.harvard.edu/tech/rss</docs>' . "\n\t\t" . '<generator>Ultimate Google Sitemaps and RSS ' . $this->ggsitemaps_config['ggs_ver'] . ' www.phpBB-SEO.com</generator>' . "\n\t\t" . '<ttl>' . intval( ($this->cache_config['rss_cache_max_age'] - ($this->output_data['time'] - $this->output_data['last_mod_time'])) / 60) . '</ttl>';
		
		if (in_array($this->actions['action'], $this->actions['actions'])) {
			include($this->path_config['module_path'] . 'includes/rss_' . $this->actions['action'] . '.' . $phpEx);
			if ($this->output_data['showstats']) {
				$this->output_data['gen_data'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
				$mem_stats = $this->ggs_mem_usage();
				$this->output_data['data'] .= "\n\t" . '</channel>' . "\n" . '</rss>' . sprintf($this->style_config['stats_genlist'], $this->output_data['gen_data'], $mem_stats, $db->num_queries, $this->output_data['url_sofar']);
			} else {
				$this->output_data['data'] .= "\n\t" . '</channel>' . "\n" . '</rss>';
			}
		} else {
			// We are working on all available files
			$rss_gen_url = $this->path_config['rss_url'] . (($this->mod_r_config['mod_rewrite']) ? "rss" . $this->mod_r_config['extra_params'] . ".xml" . $this->ext_config['gzip_ext_out'] : "rss.$phpEx" . ( (substr($this->mod_r_config['extra_params'], 0, 5) === "&amp;") ? "?" . substr($this->mod_r_config['extra_params'], 5) : ''));
			$chan_title_gen = htmlspecialchars($this->rss_config['sitename'] . $this->rss_config['extra_title']);
			$chan_desc_gen = htmlspecialchars($this->rss_config['site_desc']);
			$rss_link_url = ($this->actions['action'] === 'rss' || $this->actions['action'] === 'channels' ) ? $this->path_config['root_url'] : $this->path_config['phpbb_url'];
			$board_image = sprintf($this->style_config['rsschan_img_tpl'], $chan_title_gen, $this->rss_config['rss_image'], $rss_link_url);
			$chan_time = gmdate('D, d M Y H:i:s \G\M\T', $this->output_data['last_mod_time']);
			if ($this->actions['action'] === 'channels') {

				$rss_list_url = $this->path_config['rss_url'] . (($this->mod_r_config['mod_rewrite']) ? 'channels-rss' . $this->mod_r_config['extra_params'] . '.xml' . $this->ext_config['gzip_ext_out'] : 'rss.'.$phpEx . '?channels' . $this->mod_r_config['extra_params']);
				$this->seo_kill_dupes($rss_list_url);
				$chan_title = htmlspecialchars($this->rss_config['sitename'] . $lang['rss_chan_list'] . $this->rss_config['extra_title']);
				$chan_desc = htmlspecialchars($this->rss_config['site_desc'] . $lang['rss_chan_list']);
				$this->output_data['data'] .= sprintf($this->style_config['rsschan_tpl'], $chan_title, $rss_link_url, $chan_desc . $auth_msg, $chan_time, $board_image);
				$this->output_data['url_sofar']++;
				$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $chan_title, $this->path_config['root_url'], $chan_time, $chan_desc, $rss_list_url, htmlspecialchars($this->rss_config['sitename']), $this->path_config['root_url']);
				$this->output_data['url_sofar']++;
			} else {
				$this->seo_kill_dupes($rss_gen_url);
				$this->output_data['data'] .= sprintf($this->style_config['rsschan_tpl'], $chan_title_gen, $rss_link_url, $chan_desc_gen . $auth_msg, $chan_time, $board_image);
				$this->output_data['url_sofar']++;
			}
			$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $chan_title_gen, $this->path_config['root_url'], $chan_time, $chan_desc_gen, $rss_gen_url, htmlspecialchars($this->rss_config['sitename']), $this->path_config['root_url']);
			$this->output_data['url_sofar']++;

			// URL limit, we take the last xx items from each feed 
			// where xx is the URL limit divided by the number of feeds
			$this->rss_config['rss_url_limit'] = intval($this->rss_config['rss_url_limit'] / $this->actions['file_count']);
			$url_sofar_total = 0;
			$dir = @opendir( $this->path_config['module_path'] . 'includes' );
			while( ($file = @readdir($dir)) !== FALSE ) {
				if( preg_match("/^rss_[a-zA-Z0-9_-]+\." . $phpEx . "$/", $file) ) {
					include_once($this->path_config['module_path'] . 'includes/' . $file);
					// Keep total
					$url_sofar_total = $url_sofar_total + $this->output_data['url_sofar'];
					// Reset current
					$this->output_data['url_sofar'] = 0;
				}
			}
			@closedir($dir);
			$this->output_data['url_sofar'] = $url_sofar_total;
			$this->output_data['data'] .= "\n\t" . '</channel>';
			if ($this->output_data['showstats']) {
				$this->output_data['gen_data'] = sprintf('%.5f', $phpbb_seo->microtime_float() - $this->output_data['microtime']);
				$mem_stats = $this->ggs_mem_usage();
				$this->output_data['data'] .= "\n" . '</rss>' . sprintf($this->style_config['stats_genlist'], $this->output_data['gen_data'], $mem_stats, $db->num_queries, $this->output_data['url_sofar']);
			} else {
				$this->output_data['data'] .= "\n" . '</rss>';
			}
		}
		if ( $this->rss_config['non_utf8'] ) {
			$encoding = trim($this->rss_config['rss_charset']);
			if ($encoding === 'auto' && @extension_loaded('mbstring')) {
				$encoding = trim(@mb_strtolower(@mb_internal_encoding()));
			}
			if ( $encoding == '' || $encoding === 'auto' ||  $encoding == 'no value') {
				$encoding = 'iso-8859-1';
			}
			if ( !$this->rss_config['use_native_utf8_encode'] ) { // Only inlcude the file if required 15ko is not much but still
				require_once($this->path_config['module_path'] . "includes/utf/utf_tools.$phpEx");
				$this->output_data['data'] = utf8_recode($this->output_data['data'], $encoding, $this);
			} else {
				$this->output_data['data'] = utf8_encode($this->output_data['data']);
			}
		}
		return;
	}
	/**
	* Some text formating functions for rss text output
	* un_htmlspecialchars()
	* @access private
	*/
	function un_htmlspecialchars($text) {
		return preg_replace(array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#'), array('>', '<', '"', '&'), $text);
	}
	/**
	* format_rss_txt() will put together BBcodes and smilies before the output
	* @access private
	*/
	function format_rss_txt($subject, $message, $msg_sumarize = 0, $message_url, $bbcode_uid, $allow_smiles = TRUE, $allow_html = FALSE, $allow_sig = FALSE ) {
		global $board_config, $userdata, $lang;
		// Since &apos; is not HTML, but is XML convert.
		$message = ' ' . str_replace("’", "'", $message);
		if ( !empty($this->rss_config['rss_bbcode_filters']) ) {
			$patterns = $this->rss_config['rss_bbcode_filters']['pattern'];
			$replaces = $this->rss_config['rss_bbcode_filters']['replace'];
			if ( !empty($patterns) ) {
				$message = preg_replace($patterns, $replaces, $message);
				// Take care of nested bbcode tags when filtering all
				if ( strpos($this->rss_config['rss_strip_bbcode'], 'all') !== FALSE ) {
					$nested_cnt = preg_match_all("`(\[[a-z]([^\[\]]*)\])`i", $message, $matches);
					for ($i=1; $i<=$nested_cnt; $i++) {
							$message = preg_replace($patterns, $replaces, $message);
					}
				}
				
			}
		}
		if ($msg_sumarize > 0 ) {
			$message = $this->summarize( $message, $msg_sumarize, $this->rss_config['msg_sumarize_method'] );
		}
		// Close all possibly broken quote tags after summarize, since they could break the layout.
		if (strpos($message, "[quote:$bbcode_uid") !== FALSE ) {
			$open_count = preg_match_all("#\[quote\:$bbcode_uid#si", $message, $open_matches);
			$close_count = preg_match_all("#\[/quote\:$bbcode_uid#si", $message, $close_matches);
			$tags_to_close = $open_count - $close_count;
			if ($tags_to_close > 0 ) {
				for ($i=1; $i<=$tags_to_close; $i++) {
					$message .= ( ($i == $tags_to_close) ? '<br/><br/><b>...</b>' : '' ) . " [/quote:$bbcode_uid]";
				}
			}
		}
		// If the board has HTML off but the post has HTML
		// on then we process it, else leave it alone
		// Left commented for now as it would only be usefull for atom feed format
		// And everything goes through htmlspecialchars anyway
		//if ( $board_config['allow_html'] || !$userdata['user_allowhtml']) {
		//	if ( !$allow_html ) {
		//		$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		//	}
		//}
		if ($bbcode_uid != '') {
			if ($this->rss_config['rss_allow_bbcode']) {
				if ( !$this->rss_config['rss_allow_links'] ) {
					$message = preg_replace("`\[/?url(=.*?)?\]`si", "", $message);
				}
				$message = bbencode_second_pass($message, $bbcode_uid);
				if ( $msg_sumarize > 0 || !empty($this->rss_config['rss_bbcode_filters']) ) {
					// Clean all possible bbcode_uids left
					$message = preg_replace('`\:[0-9a-z\:=\"]+\]`si', ']', $message);
				}

			} else {
					$message = preg_replace("`\:[0-9a-z\:=\"]+\]`i", "]", $message);
			}
		}
		if ( $this->rss_config['rss_allow_links'] ) {
			$message = make_clickable($message);
		}
		// Parse smilies
		if ( $this->rss_config['rss_allow_smilies'] ) {
			if ( $allow_smiles ) {
				$message = smilies_pass($message);
				$message = preg_replace('`' . $this->path_config['smilies_path'] . '`', $this->path_config['smilies_url'], $message);
			}
		}
		// Replace naughty words
		if (count($orig_word)) {
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
		}
		$message .= '<br/><br/><a href="' . $message_url . '" title="'. $subject .'"><b>' . $lang['rss_more'] . '</b></a>';
		$message = str_replace("\n", "\n<br/>\n", $message);
		$message = str_replace("span", "div class=\"detail\"", $message);
		$message = (preg_replace('|[\x00-\x08\x0B\x0C\x0E-\x1f]|','',$message));
		return $message;
	}
	/**
	* Summarize method selector
	* @access private
	*/
	function summarize($string, $limit, $method = 'setences') {
		// Take care of UTF-8 with the phpBB3 method
		if ( !$this->rss_config['non_utf8'] ) {
			global $phpEx;
			require_once($this->path_config['module_path'] . "includes/utf/utf_tools.$phpEx");
		}
		switch ($method) {
			case 'words':
				return $this->word_limit($string, $limit);
				break;
			case 'chars':
				return $this->char_limit($string, $limit);
				break;
			case 'sentences':
			default:
				return $this->sentence_limit($string, $limit);
				break;
		}
	}
	/**
	* Cut the text by sentences, sort of.
	* Borrowed from www.php.net http://www.php.net/strtok
	* @access private
	*/
	function sentence_limit($paragraph, $limit = 10, $ellipsis = ' ...') {
		$tok = strtok($paragraph, " ");
		$text = "";
		$sentences = 1;
		while($tok){
			$text .= " " . $tok;
			if ( (substr($tok, -1) == "!") || (substr($tok, -1) == ".") || (substr($tok, -1) == "?") ) {
				$sentences++;
			}
			if( $sentences > $limit ) {
				break;
			}
			$tok = strtok(" ");
		}
		return trim($text) . ($tok ? $ellipsis : "");
	}
	/**
	* Cut the text according to the number of words.
	* Borrowed from www.php.net http://www.php.net/preg_replace
	* @access private
	*/
	function word_limit($string, $length = 50, $ellipsis = ' ...') {
		if ($this->rss_config['non_utf8']) {
			return count($words = preg_split('/\s+/', phpbb_ltrim($string), $length + 1)) > $length ? phpbb_rtrim(substr($string, 0, strlen($string) - strlen(end($words)))) . $ellipsis : $string;
		} else {
			return count($words = preg_split('/\s+/', phpbb_ltrim($string), $length + 1)) > $length ? phpbb_rtrim(utf8_substr($string, 0, utf8_strlen($string) - utf8_strlen(end($words)))) . $ellipsis : $string;
		}
	}
	/**
	* Cut the text according to the number of characters.
	* Borrowed from www.php.net http://www.php.net/preg_replace
	* @access private
	*/
	function char_limit($string, $length = 100, $ellipsis = ' ...') {
		if ($this->rss_config['non_utf8']) {
			return strlen($fragment = substr($string, 0, $length + 1 - strlen($ellipsis))) < strlen($string) + 1 ? preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
		} else {
			return utf8_strlen($fragment = utf8_substr($string, 0, $length + 1 - utf8_strlen($ellipsis))) < utf8_strlen($string) + 1 ? preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
		}
	}
	/**
	* set_strip_bbcode($bbcode_list) will build up the unauthed bbcode list
	* $bbcode_list = 'code:0,img:1,quote';
	* $bbcode_list = 'all';
	* 1 means the bbcode and it's content will be striped.
	* all means all bbcodes.
	* $returned_list = array('patern' => $matching_patterns, 'replace' => $replace_patterns);
	* @access private
	*/
	function set_strip_bbcode($bbcode_list) {
		if (preg_match("`all\:?([0-1]*)`i", $bbcode_list, $matches)) {
			if ( ($matches[1] != 1 ) ) {
				$patterns[] = '`\[[a-z]+([^\[\]]*)\]([^\[\]]*)\[/[a-z]+([^\[\]]*)\]`mi';
				$replaces[] = "\\2";
			} else {
				$patterns[] = '`\[([a-z]+)([^\[\]]*)\]([^\[\]]*)\[/[a-z]+([^\[\]]*)\]`mi';
				$replaces[] = "{\\1}";
			}
		} else {
			$exclude_list =  ( empty($bbcode_list) ? array() : explode(',', $bbcode_list) );
			$patterns = array();
			$replaces = array();
			foreach ($exclude_list as $key => $value ) {
				$value = trim($value);
				if (preg_match("`[a-z]+(\:([0-1]*))?`i", $value, $matches) ) {
					$values = (strpos($value, ':') !== FALSE) ?  explode(':', $value) : array($value);
					if ( ($matches[2] != 1 ) ) {
						$patterns[] = '`\[/?'.$values[0].'([^\[\]]*)\]`si';
						$replaces[] = "";
					} else {
						$patterns[] = '`\[('.$values[0].')([^\[\]]*)\].*\[/'.$values[0].'(\:[0-9a-z\:="]*)\]`si';
						$replaces[] = "{\\1}";
					}
				}
			}
		}
		return  array('pattern' => $patterns, 'replace' => $replaces);
	}
	// --> Cache function <--
	/**
	* Check and cache set up
	* @access private
	*/
	function ggs_setup_cache() {
		// build cache file name 
		$this->cache_config['file_name'] = $this->actions['type'] . md5( $this->actions['action'] . ( ( !empty($this->actions['list_id']) ) ?  '_' . $this->actions['list_id'] : '' ) . $this->cache_config['auth_param'] . $this->cache_config['extra_cat'] . str_replace("&amp;", "-", $this->mod_r_config['extra_params']) ). $this->ext_config['file_ext'] . $this->ext_config['gzip_ext'];
		$this->cache_config['file'] = $this->path_config['module_path'] . $this->cache_config['cache_dir'] . $this->cache_config['file_name'];

		// Output, first check cache
		if ($this->check_sitm_cache($this->cache_config['file'])) {
			// Check expiration
			$this->cache_config['cache_too_old'] = (@filemtime($this->cache_config['file']) + $this->cache_config['cache_max_age']) < $this->output_data['time'] ? TRUE : FALSE;
			if ($this->cache_config['cache_too_old'] && $this->cache_config['auto_regen']) {
				@unlink($this->cache_config['file']);
				$this->cache_config['cached'] = FALSE;
			}
		}

		// Expiration time & Etags
		if (!$this->cache_config['cached']) {
			// Take care about lastmod when not cached
			if (($this->cache_config['cache_born'] + $this->cache_config['cache_max_age']) <= $this->output_data['time']) {
				$this->ggs_updt_lastmod($this->actions['type'] . 'cache_born');
				$this->output_data['last_mod_time'] = $this->output_data['time'];
				$this->output_data['expires_time'] = gmdate('D, d M Y H:i:s \G\M\T', ($this->output_data['time'] + $this->cache_config['cache_max_age']));
				$this->output_data['etag'] = md5($this->output_data['expires_time'] . $this->cache_config['file']);

			} else {
				$this->output_data['last_mod_time'] = $this->cache_config['cache_born'];
				$this->output_data['expires_time'] = gmdate('D, d M Y H:i:s \G\M\T', ($this->output_data['cache_born'] + $this->cache_config['cache_max_age']));
				$this->output_data['etag'] = md5($this->output_data['expires_time'] . $this->cache_config['file']);
			}
			$this->check_mod_since();
		} else {
			$this->output_data['last_mod_time'] = @filemtime($this->cache_config['file']);
			$this->output_data['expires_time'] = gmdate('D, d M Y H:i:s \G\M\T', ($this->output_data['last_mod_time'] + $this->cache_config['cache_max_age']));
			$this->output_data['etag'] = md5($this->output_data['expires_time'] . $this->cache_config['file']);
			$this->check_mod_since();
			$this->GGs_cache_output();
		}
		return;
	}
	/**
	* Update the lastmod date when cache is not actvated.
	* @access private
	*/
	function ggs_updt_lastmod($config_name) {
		global $db;
		$sql = "UPDATE ". GGSITEMAP_TABLE ."
			SET config_value = " . $this->output_data['time'] . "
			WHERE config_name = '{$config_name}'";
		if ( !$result = $db->sql_query( $sql ) ) {
			$this->mx_sitemaps_message_die( CRITICAL_ERROR, "Could not update last mod time", "", __LINE__, __FILE__, $sql );
		}
		return;
	}
	/**
	* check_mod_since() will exit with 304 Not Modified header
	* and exit upon HTTP_IF_MODIFIED_SINCE or HTTP_IF_NONE_MATCH Checks
	* @access private
	*/
	function check_mod_since() {
		if ($this->output_data['mod_since']) {
			$http = (@function_exists("getallheaders")) ? "HTTP/1.1 " : "Status: ";
			if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $this->output_data['last_mod_time']) {
					header($http . ' 304 Not Modified');
					exit();
				}
			}
			if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
				if ($_SERVER['HTTP_IF_NONE_MATCH'] == $this->output_data['etag']) {
					header($http . ' 304 Not Modified');
					exit();
				}
			}
		}
		return;
	}
	/**
	* check_sitm_cache($file) will tell if the required file exists.
	* @access private
	*/
	function check_sitm_cache($file) {
		if(!$this->cache_config['cache_enable']) {
			$this->cache_config['cached'] = FALSE;
			return FALSE;
		}
		if(!@file_exists($file)) {
			$this->cache_config['cached'] = FALSE;
			return FALSE;
		}
		$this->cache_config['cached'] = TRUE;
		return TRUE;
	}
	/**
	* write_sitm_cache( $action, $id = 0 ) will write the cached file.
	* @access private
	*/
	function write_sitm_cache() {
		if(!$this->cache_config['cache_enable']) {
			return FALSE;
		}
		$file = $this->cache_config['file'];
		if ($this->gzip_config['gzip'] || $this->cache_config['force_cache_gzip']) {
			$handle = @gzopen($file, 'wb' . $this->gzip_config['gzip_level']);
			@gzwrite($handle, $this->output_data['data']);
			@gzclose ($file);
		} else {
			$handle = @fopen($file, 'wb');
			@fwrite($handle, $this->output_data['data']);
			@fclose ($file);
		}
		$this->ggs_updt_lastmod($this->actions['type'] . '_cache_born');
		@umask(0000);
		@chmod($file,  0666);
		return TRUE;
	}
	// --> Gun-Zip handeling <--
	/**
	* check_gzip() tells is Gun-Zip is available
	* @access private
	*/
	function check_gzip() {
		if (headers_sent()) {
			return FALSE;
		}
		if ( (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !==FALSE ) || strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !==FALSE ) {
			return TRUE;
		} else {
			return FALSE;
		}
		return;
	}
	/**
	* check_gzip_type() return the user's Gun-Zip type
	* @access private
	*/
	function check_gzip_type() {
		if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !==FALSE ) {
			return 'gzip';
		} elseif (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !==FALSE ) {
			return 'x-gzip';
		}
		return 'gzip';
	}
	/**
	* check_requested_ext($uri) will force the .gz extention if required
	* @access private
	*/
	function check_requested_ext($uri) {
		if ( ( strpos($uri, '.gz') !== FALSE ) && ($this->ext_config['gzip_ext_out'] == '') && !strpos($uri, '.php')) {
			$uri = str_replace ('.gz', "", $uri);
			$url= $this->path_config['root_url'] . phpbb_ltrim($uri, "/");
			$this->ggs_seo_redirect($url);
		} elseif ( ( strpos($uri, '.gz') === FALSE ) && ($this->ext_config['gzip_ext_out'] != '') && !strpos($uri, '.php')) {
			$uri = $uri . '.gz';
			$url= $this->path_config['root_url'] . phpbb_ltrim($uri, "/");
			$this->ggs_seo_redirect($url);
		}
		return;
	}
	// --> Others <--
	/**
	* seo_kill_dupes($url) will kill dupicate when pages are not cached
	* @access private
	*/
	function seo_kill_dupes($url) {
			if ($this->mod_r_config['zero_dupe']) {
			$requested_url = $this->path_config['root_url'] . phpbb_ltrim($this->output_data['uri'], "/");
			$url = str_replace("&amp;", "&", $url);
			if ( !($requested_url === $url) ) {
				$this->ggs_seo_redirect($url);
			}
		}
		return;
	}
	/**
	* ggs_mem_usage($id_list) will build up the public unauthed ids
	* @access private
	*/
	function ggs_mem_usage() {
		if (function_exists('memory_get_usage')) {
			if ($memory_usage = memory_get_usage()) {
				$memory_usage -= $this->output_data['mem_usage'];
				$memory_usage = ($memory_usage >= 1048576) ? round((round($memory_usage / 1048576 * 100) / 100), 2) . ' MB' : (($memory_usage >= 1024) ? round((round($memory_usage / 1024 * 100) / 100), 2) . ' Kb' : $memory_usage . ' b');
				return "( Mem Usage : $memory_usage )";
			}
		}
		return '';
	}
	/**
	* Custom HTTP 301 redirections.
	* To kill duplicates
	*/
	function ggs_seo_redirect($url, $header = "301 Moved Permanently", $code = 301, $replace = TRUE) {
		global $db;
		if ( !empty($db) ) {
			$db->sql_close();
		}
		if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r") || strstr(urldecode($url), ';url')) {
			message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
		}
		$http = (@function_exists("getallheaders")) ? "HTTP/1.1 " : "Status: ";
		header($http . $header, $replace, $code);
		header("Location:" . $url);
		exit();
	}
	/**
	* Returns the REQUEST_URI
	*/
	function ggs_seo_req_uri() {
		// Apache mod_rewrite
		if ( isset($_SERVER['REQUEST_URI']) ) {
			return $_SERVER['REQUEST_URI'];
		}
		// IIS  isapi_rewrite
		if ( isset($_SERVER['HTTP_X_REWRITE_URL']) ) {
			return $_SERVER['HTTP_X_REWRITE_URL'];
		}
		// no mod rewrite
		return  $_SERVER['SCRIPT_NAME'] . ( ( isset($_SERVER['QUERY_STRING']) ) ? '?'.$_SERVER['QUERY_STRING'] : "" );
	}
	/**
	* set_exclude_list($id_list) will build up the public unauthed ids
	* @access private
	*/
	function set_exclude_list($id_list) {
		$exclude_list = ( empty($id_list) ? array() : explode(',', $id_list) );
		foreach ($exclude_list as $key => $value ) {
			$this->output_data['exclude_list'][intval($value)] = intval($value);
		}
		return;
	}
	/**
	* mx_sitemaps_message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
	* Will properly handle error for all cases, admin always get full debug
	* @access private
	*/
	function mx_sitemaps_message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '') {
		global $userdata, $lang;

		if ( $userdata['user_level'] == ADMIN ) {
			if (defined('IN_PORTAL')) {
				mx_message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '');
			} else {
				message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '');			
			}

		} else {
			$message = ($msg_code == GENERAL_ERROR) ? $lang['An_error_occured'] : $lang['Information'];
			$message .= "<br/>$msg_text<br/>$err_line<br/>$err_file<br/>$sql";
			if ($msg_text != 'Request not accepted' ) {
				$header_msg = "500 Internal Server Error";
			} else {
				$header_msg = "403 Forbidden";
			}
			$message = "<b>$header_msg :</b><br/><br/>$message";
			if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2')) {
				header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
			} else {
				header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
			}
			header("HTTP/1.1 $header_msg");
			header ('Content-Type: text/html');
			echo '<html><head><title>' . $header_msg . '</title><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"></head><body><br/><pre>' . $message . '</pre></body></html>';
			$this->safe_exit();
		}
		return;
	}
	/**
	* For a safe exit
	* @access private
	*/
	function safe_exit() {
		global $db;
		if ( !empty($db) ) {
			$db->sql_close();
		}
		exit();
	}
}
?>
