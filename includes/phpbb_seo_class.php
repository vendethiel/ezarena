<?php
/** 
*
* @package Advanced phpBB SEO mod Rewrite
* @version $Id: phpbb_seo_class.php, 0.2.2 2007/02/07 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://www.opensource.org/licenses/rpl.php RPL Public License 
*
*/

/**
* phpBB_SEO Class
* www.phpBB-SEO.com
* @package Advanced phpBB SEO mod Rewrite
*/
class phpbb_seo {
	var	$modrtype = 0;
	var	$seo_url = array();
	var	$seo_delim = array();
	var	$seo_ext = array();
	var	$seo_static = array();
	var	$seo_paths = array();
	var	$seo_url_filter = array();
	var	$seo_stats = array();
	var	$get_var = array();
	var	$path = "";
	var	$start = "";
	var	$filename = "";
	var	$file = "";
	var	$url_in = "";
	var	$url = "";
	var	$page_url = "";
	// --> Zero Dupe
	var	$do_redir = FALSE;
	var	$seo_opt = array();
	var	$encoding = "iso-8859-1";	
	/**
	* constuctor
	*/
	function phpbb_seo() {
		global $phpEx, $board_config;
		// config
		$this->encoding = "iso-8859-1";		
		$this->modrtype =  3; // 3 = Advanced
		$this->start = '';
		// --> DOMAIN SETTING <-- //
		// NOTE : If you add already declared a PHPBB_URL constant in common.php,
		// you should get rid of it and let this part do it instead.
		// You can hard-code the data to save process.
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		// $this->seo_path['phpbb_script'] should be = '' if phpbb is installed in the domain's root
		// 'phpbb/' in case it's installed in the phpbb/ folder.
		$this->seo_path['phpbb_script'] = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$this->seo_path['phpbb_script'] = ($this->seo_path['phpbb_script'] == '') ? '' : $this->seo_path['phpbb_script'] . '/';
		// Domain URL 
		$this->seo_path['root_url'] = $server_protocol . $server_name . $server_port . '/';
		$this->seo_path['phpbb_url'] = $this->seo_path['root_url'] . $this->seo_path['phpbb_script'];
		// Populate the $seo_path['PathToUrl'] array for multifolder setups handling.
		// Pattern is $this->seo_path['PathToUrl']['phpbb/'] = "http://www.example.com/phpbb/";
		$this->seo_path['PathToUrl'][$this->seo_path['phpbb_script']] = $this->seo_path['phpbb_url'];		
		// --> Zero Dupe
		$this->do_redir = FALSE;		
		// URL Settings
		$this->seo_url = array(
			'cat' =>  array(), 
			'forum' =>  array(), 
			'topic' =>  array(), 
			'user' =>  array()
		);
		$this->seo_delim = array('cat' => '-c', 
			'forum' => '-f', 
			'topic' => '-t', 
			'user' => '-u',
			// Rss
			'rss_forum' => '-rf',
			// Google
			'google_forum' => '-gf'
		);
		$this->seo_ext = array('cat' => '.html', 
			'forum' => '.html', 
			'topic' => '.html', 
			'user' => '.html',
			'gz_ext' => '',
		);
		$this->seo_static = array('cat' => 'cat', 
			'forum' => 'forum', 
			'topic' => 'topic', 
			'post' => 'post', 
			'user' => 'membre',
			'start' => '-', 
			'gz_ext' => '.gz',
			'index' => 'index.html'
		);
		// URL Filters
		$this->phpbb_filter = array('postdays' => 0, 'topicdays' => 0, 'postorder' => 'asc', 'highlight' => '');
		// Stop files
		$this->seo_stop_files = array("posting", "privmsg", "faq", "groupcp", "memberlist", "login", "search");
		// Stop vars
		$this->seo_stop_vars = array("view=", "mark=");
		// --> Meta tags
		$this->seo_meta_tags();

		return;
	}

	// --> URL rewriting functions <--
	/**
	* Prepare Titles for URL injection
	*/
	function format_url( $url, $type = 'topic' ) {
		$url = preg_replace("`\[.*\]`U","",$url);
		$url = strip_tags($url);
		$url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$url);
		$url= htmlentities($url, ENT_COMPAT, $this->encoding);
		$url= preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i","\\1", $url );
		$url = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $url);
		$url = ( $url == "" ) ? $type : strtolower(trim($url, '-'));
		return $url;
	}
	/**
	* Rewrite URLs.
	* Allow adding of many more cases than just the
	* regular phpBB URL rewritting without slowing up the process.
	*/
	function url_rewrite($url, $non_html_amp = FALSE) {
		global $phpEx;
		$this->url = $this->url_in = $url;
		if ( strpos($this->url, ".$phpEx") === FALSE || defined('IN_ADMIN') || defined('IN_LOGIN') ) {
			return $url;
		}
		// Grabb params
		$this->url = str_replace('&amp;', '&', $this->url);
		$parsed_url = @parse_url($this->url);
		// V: OMG HOW DID THIS MOD GOT RELEASED WITHOUT THAT
		$this->get_vars = array();
		if (isset($parsed_url['query']))
		{
			parse_str($parsed_url['query'], $this->get_vars);
		}
		$this->file = basename($parsed_url['path']);
		$this->path = trim(trim(dirname($parsed_url['path']), "."),  "/");
		$this->path = (!empty($this->path)) ? ( isset( $this->seo_path['PathToUrl'][$this->path . '/'] ) ? $this->seo_path['PathToUrl'][$this->path . '/'] : $this->path . '/' ) : '';
		$this->filename = trim(str_replace(".$phpEx", "", $this->file));
		if ( in_array($this->filename, $this->seo_stop_files) ) {
			return $url;
		}
		// Reset $url
		$this->url = $this->file;
		if ( @method_exists($this, $this->filename) ) {
			$this->{$this->filename}();
			// Assamble URL
			$this->url .= $this->query_string($this->get_vars);
			//$this->url = (!$non_html_amp) ? str_replace('&', '&amp;', $this->url) : $this->url;
			return $this->path . $this->url . ((!empty($parsed_url['fragment'])) ? "#" . $parsed_url['fragment'] : '');
		} else {
			return $url;
		}
	}
	/**
	* Set the $start var proper
	* @access private
	*/
	function seo_pagination() {
		$this->start = intval($this->get_vars['start']);
		$this->start = ( $this->start > 0  ) ? $this->seo_static['start'] . $this->get_vars['start'] : '';
		unset($this->get_vars['start']);
	}
	/**
	* URL rewritting for viewtopic.php
	* @access private
	*/
	function viewtopic() {
		$this->filter_url($this->seo_stop_vars);
		if ( !empty($this->get_vars[POST_TOPIC_URL]) && !empty($this->seo_url['topic'][$this->get_vars[POST_TOPIC_URL]]) ) {
			// Filter default params
			$this->filter_get_var($this->phpbb_filter);
			$this->seo_pagination();
			$this->url = $this->seo_url['topic'][$this->get_vars[POST_TOPIC_URL]] . $this->seo_delim['topic'] . $this->get_vars[POST_TOPIC_URL] . $this->start . $this->seo_ext['topic'];
			unset($this->get_vars[POST_TOPIC_URL]);
		} elseif ( !empty($this->get_vars[POST_POST_URL]) ) {
			$this->url =  $this->seo_static['post'] . $this->get_vars[POST_POST_URL] . $this->seo_ext['topic'];
			unset($this->get_vars[POST_POST_URL]);
		}
		return;
	}
	/**
	* URL rewritting for viewforum.php
	* @access private
	*/
	function viewforum() {
		$this->filter_url($this->seo_stop_vars);
		if ( !empty($this->get_vars[POST_FORUM_URL]) && !empty($this->seo_url['forum'][$this->get_vars[POST_FORUM_URL]]) ) {
			// Filter default params
			$this->filter_get_var($this->phpbb_filter);
			$this->seo_pagination();
			$this->url = $this->seo_url['forum'][$this->get_vars[POST_FORUM_URL]] . $this->seo_delim['forum'] . $this->get_vars[POST_FORUM_URL] . $this->start . $this->seo_ext['forum'];
			unset($this->get_vars[POST_FORUM_URL]);
		}
		return;
	}
	/**
	 * userlist
	 */
	function userlist() {
		$this->profile();
	}

	/**
	* URL rewritting for profile.php
	* @access private
	*/
	function profile() {
		if ( !empty($this->get_vars[POST_USERS_URL]) && $this->get_vars['mode'] === 'viewprofile') {
			$this->url =  $this->seo_static['user'] . $this->get_vars[POST_USERS_URL] . $this->seo_ext['user'];
			unset($this->get_vars[POST_USERS_URL]);
			unset($this->get_vars['mode']);
		}
		return;
	}
	/**
	* URL rewritting for index.php
	* @access private
	*/
	function index() {
		if ( !empty($this->get_vars[POST_CAT_URL]) && !empty($this->seo_url['cat'][$this->get_vars[POST_CAT_URL]]) ) {
			$this->url = $this->seo_url['cat'][$this->get_vars[POST_CAT_URL]] . $this->seo_delim['cat'] . $this->get_vars[POST_CAT_URL] . $this->seo_ext['cat'];
			unset($this->get_vars[POST_CAT_URL]);
		} else {
			$this->url = $this->seo_path['phpbb_url'] . $this->seo_static['index'];
		}
		return;
	}
	// --> Extra rewriting

	// <-- Extra rewriting
	/**
	* Will break if a $filter pattern is foundin $url.
	* Example $filter = array("view=", "mark=");
	* @access private
	*/
	function filter_url($filter = array()) {
		foreach ($filter as $patern ) {
			if ( strpos($this->url_in, $patern) !== FALSE ) {
				unset($this->get_vars);
				$this->url = $this->url_in;
				break;
			}
		}
		return;
	}
	/**
	* Will unset all default var stored in $filter array.
	* Example $filter = array('postdays' => 0, 'topicdays' => 0, 'postorder' => 'asc');
	* @access private
	*/
	function filter_get_var($filter = array()) {
		if ( !empty($this->get_vars) ) {
			foreach ($this->get_vars as $paramkey => $paramval) {
				if ( array_key_exists($paramkey, $filter) ) {
					if ( $filter[$paramkey] ==  $this->get_vars[$paramkey] ) {
						unset($this->get_vars[$paramkey]);
					}
				}
			}	
		}
		return;
	}
	/**
	* Will return the remaining GET vars to take care of
	* @access private
	*/
	function query_string() {
		if(empty($this->get_vars)) {
			return '';
		}
		$params = array();
		foreach($this->get_vars as $key => $value) {
			$params[] = $key . '=' . $value;
		}
		return '?' . implode('&', $params);
	}
	// --> Add on Functions <--
	// --> Gen stats
	/**
	* Returns usable microtime
	* Borrowed from php.net
	* Required for the phpBB SEO Google sitemaps module
	*/
	function microtime_float() {
		return array_sum(explode(' ',microtime()));
	}
	// --> Zero Duplicate
	/**
	* Custom HTTP 301 redirections.
	* To kill duplicates
	*/
	function seo_redirect($url, $header = "301 Moved Permanently", $code = 301, $replace = TRUE) {
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
	* Helps out grabbing boolean vars
	*/
	function seo_cond($bool = FALSE, $or = FALSE) {
		if ( $bool || ($this->do_redir && $or) ) {
			$this->do_redir = TRUE;
		}
		return;
	}
	/**
	* Returns the REQUEST_URI
	*/
	function seo_req_uri() {
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
	* check start var consistency
	*/
	function seo_start($start = 0, $limit = 0) {
		if ($limit > 0) {
			$start = ( is_int( $start/$limit ) ) ? $start : intval($start/$limit)*$limit;
			$this->start = ( $start > 0  ) ? $this->seo_static['start'] . $start : '';
		} else {
			$this->start = ( $start > 0  ) ? $this->seo_static['start'] . $start : '';
		}
	}
	// -- > Meta tags
	var	$seo_meta = array();
	/**
	* Returns meta tag code
	*/
	function build_meta($page_title = '') {
		$meta_desc = ( $this->seo_meta['meta_desc'] != '' ) ? $this->seo_meta['meta_desc'] : $this->seo_meta['meta_desc_def'];
		$keywords = ( $this->seo_meta['keywords'] != '' ) ? $this->seo_meta['keywords'] : $this->seo_meta['meta_keywords_def'];
		$title = ( $this->seo_meta['meta_title'] != '' ) ? $this->seo_meta['meta_title'] : $page_title;
		return sprintf( $this->seo_meta['meta_tpl'], $title, $this->seo_meta['meta_lang'], $meta_desc, $keywords, $this->seo_meta['meta_cat'], $this->seo_meta['meta_robots'] );
	}
	/**
	* Returns a word list separated by comas
	* You might want tu use mb_strlen() instead of strlen()
	* if you are using UTF-8 : mb_strlen($word, 'UTF-8')
	* you can as well change the minimum word size here : if ( strlen($word) >= 3 ) {
	* Possible Options :
	* - $limit = 0 means no limit.
	*   By default, ' . and , are deleted.
	*/
	function make_keywords($text, $limit = 15) {
		$keywords = '';
		$num = 0;
		$text = preg_replace(array("`[[:punct:]]+`", "`[\s]+`"), array(" ", " "), strip_tags($text) );
		$text = explode(" ", $text);
		// We take the most used words first
		$text = array_count_values($text);
		foreach ($text as $word => $count) {
			if ( strlen($word) >= 3 ) {
				$keywords .= ($keywords == '') ? $word : ',' . $word;
				$num++;
				if ( $limit > 0 && $num >= $limit ) {
					break;
				}
			}	
		}
		return $keywords;
	}
	/**
	* Filter php/html tags and white spaces and returns htmlspecialchared string
	*/
	function meta_filter_txt($text) {
		return htmlspecialchars(preg_replace("`[\s]+`", " ", strip_tags($text) ) );
	}
	/**
	* Initialize meta tags
	* @access private
	*/
	function seo_meta_tags() {
		global $board_config;
		$this->seo_meta = array('meta_tpl' => '<meta name="title" content="%s">' . "\n" . '<meta name="description" lang="%s" content="%s">' . "\n" . '<meta name="keywords"    content="%s">' . "\n" . '<meta name="category"    content="%s">' . "\n" . '<meta name="robots"      content="%s">'. "\n",
			'meta_title' => '',
			'meta_desc' => '',
			'meta_keywords' => '',
			// Here you can hard code a static default title, description and keywords
			// As is, the mod will return information based on the phpbb config
			'meta_title_def' => "", 
			'meta_desc_def' => "fun rpg",  
			'meta_keywords_def' => "",
			'meta_lang' => 'fr',
			'meta_cat' => 'general',
			'meta_robots' => 'index,follow',
			'meta_gened' => FALSE,
			'page_title' => '',
			'keywords' => '',
		);
		return;
	}	
}
?>
