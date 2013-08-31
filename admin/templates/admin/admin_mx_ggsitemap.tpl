<a name="top"></a>
<br/>
<h1><a href="http://www.phpbb-seo.com/" title="by www.phpBB-SEO.com" class="maintitle">{L_CONFIGURATION_TITLE}</a></h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_MENU}</th>
	</tr>
	<tr>
		<td class="row2" align="center"><a href="#general" class="nav">{L_GENERAL_SETTINGS}</a> || <a href="#ggs" class="nav">{L_GGS_SETTINGS}</a> || <a href="#rss" class="nav">{L_RSS_SETTINGS}</a> || <a href="#yahoo" class="nav">{L_YAHOO_SETTINGS}</a> 
	<!-- BEGIN mx_config -->
		 || <a href="#mx" class="nav">{mx_config.L_SITEMAP_MX_SET}</a>
	<!-- END mx_config -->
	<!-- BEGIN kb_config -->
		 || <a href="#mxkb" class="nav">{kb_config.L_SITEMAP_KB_SET}</a>
	<!-- END kb_config -->
	<!-- BEGIN kb_config_phpbb -->
		 || <a href="#kb" class="nav">{kb_config_phpbb.L_SITEMAP_KB_SET}</a>
	<!-- END kb_config_phpbb -->
		</td>
	</tr>
</table>
<br/>
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="general"></a>{L_CLEAR_CACHE}</th>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_CLEAR_CACHE}</span><br /><span class="gensmall">{L_CLEAR_CACHE_EXPLAIN}</span></td> 
		<td class="row2">{CLEAR_CACHE}</td> 
	</tr>
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_CACHE_STATUS}</span><br /><span class="gensmall">{L_CACHE_STATUS_MSG}</span></td>
	</tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="clear_cache" value="{L_SUBMIT}" class="mainoption" />
</tr> 
</table></form>
<br/>
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="general"></a>{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{L_GENERAL_SETTINGS_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_S_MOD_REWRITE}</span><br /><span class="gensmall">{L_S_MOD_REWRITE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="ggs_mod_rewrite" value="FALSE" {REWRITE_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_mod_rewrite" value="TRUE" {REWRITE_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_S_MOD_REWRITE_TYPE}</span><br /><span class="gensmall">{L_S_MOD_REWRITE_TYPE_EXPLAIN}</span></td> 
		<td class="row2">{MOD_REWRITE_TYPE}</td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_ZERO_DUPE}</span><br /><span class="gensmall">{L_ZERO_DUPE_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_zero_dupe" value="FALSE" {ZERO_DUPE_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_zero_dupe" value="TRUE" {ZERO_DUPE_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_SHOWSTATS}</span><br /><span class="gensmall">{L_SHOWSTATS_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_showstats" value="FALSE" {SHOWSTATS_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_showstats" value="TRUE" {SHOWSTATS_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_GUN_ZIP}</span><br /><span class="gensmall">{L_GUN_ZIP_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_gzip" value="FALSE" {GUN_ZIP_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_gzip" value="TRUE" {GUN_ZIP_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_GUN_ZIP_LEVEL}</span><br /><span class="gensmall">{L_GUN_ZIP_LEVEL_EXPLAIN}</span></td> 
		<td class="row2">{GUN_ZIP_LEVEL}</td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_MOD_SINCE}</span><br /><span class="gensmall">{L_MOD_SINCE_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_mod_since" value="FALSE" {MOD_SINCE_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_mod_since" value="TRUE" {MOD_SINCE_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_CACHE}</span><br /><span class="gensmall">{L_CACHE_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_cached" value="FALSE" {CACHE_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_cached" value="TRUE" {CACHE_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_CACHE_DIR}</span><br /><span class="gensmall">{L_CACHE_DIR_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_cache_dir" value="{CACHE_DIR}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_FORCE_CACHE_GUN_ZIP}</span><br /><span class="gensmall">{L_FORCE_CACHE_GUN_ZIP_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_force_cache_gzip" value="FALSE" {FORCE_CACHE_GUN_ZIP_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_force_cache_gzip" value="TRUE" {FORCE_CACHE_GUN_ZIP_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_SORT_ORDER}</span><br /><span class="gensmall">{L_SORT_ORDER_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="ggs_sort" value="DESC" {SITEMAP_SORT_DESC} /> {L_NEW_FIRST}&nbsp;&nbsp;<input type="radio" name="ggs_sort" value="ASC" {SITEMAP_SORT_ASC} /> {L_OLD_FIRST}</td>
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td><a href="#top" class="nav">{L_BACK_TO_TOP}</a></td>
	</tr>
</table>
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="ggs"></a>{L_GGS_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{L_GGS_SETTINGS_EXPLAIN}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_GGS_XSLT}</span><br /><span class="gensmall">{L_GGS_XSLT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_xslt" value="FALSE" {GGS_XSLT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_xslt" value="TRUE" {GGS_XSLT_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_SQL_LIMIT}</span><br /><span class="gensmall">{L_SQL_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_sql_limit" value="{SQL_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_DEFAULT_LIMIT}</span><br /><span class="gensmall">{L_DEFAULT_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_url_limit" value="{DEFAULT_LIMIT}" /></td> 
	</tr>	
	<tr> 
		<td class="row1"><span class="gen">{L_GGS_CACHE_MX_AGE}</span><br /><span class="gensmall">{L_GGS_CACHE_MX_AGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_cache_max_age" value="{GSS_CACHE_MX_AGE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_GGS_AUTO_REGEN}</span><br /><span class="gensmall">{L_GGS_AUTO_REGEN_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_auto_regen" value="FALSE" {AUTO_REGEN_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_auto_regen" value="TRUE" {AUTO_REGEN_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_GGS_GZIP_EXT}</span><br /><span class="gensmall">{L_GGS_GZIP_EXT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_gzip_ext" value="FALSE" {GGS_GZIP_EXT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_gzip_ext" value="TRUE" {GGS_GZIP_EXT_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_FORUM_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_SITEMAP_FORUM_EXCLUDE}</span><br /><span class="gensmall">{L_SITEMAP_FORUM_EXCLUDE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_exclude_forums" value="{SITEMAP_FORUM_EXCLUDE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_ANNOUNCE_PRIORITY}</span><br /><span class="gensmall">{L_ANNOUNCE_PRIORITY_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_announce_priority" value="{ANNOUNCE_PRIORITY}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_STICKY_PRIORITY}</span><br /><span class="gensmall">{L_STICKY_PRIORITY_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_sticky_priority" value="{STICKY_PRIORITY}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_DEFAULT_PRIORITY}</span><br /><span class="gensmall">{L_DEFAULT_PRIORITY_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_default_priority" value="{DEFAULT_PRIORITY}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_PAGINATION}</span><br /><span class="gensmall">{L_PAGINATION_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="ggs_pagination" value="FALSE" {PAGINATION_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="ggs_pagination" value="TRUE" {PAGINATION_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_PAGINATION_LIMIT1}</span><br /><span class="gensmall">{L_PAGINATION_LIMIT_EXPLAIN1}</span></td> 
		<td class="row2"><input type="text" name="ggs_limitdown" value="{PAGINATION_LIMITDOWN}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_PAGINATION_LIMIT2}</span><br /><span class="gensmall">{L_PAGINATION_LIMIT_EXPLAIN2}</span></td> 
		<td class="row2"><input type="text" name="ggs_limitup" value="{PAGINATION_LIMITUP}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td><a href="#top" class="nav">{L_BACK_TO_TOP}</a></td>
	</tr>
</table>
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="rss"></a>{L_RSS_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{L_RSS_SETTINGS_EXPLAIN}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_XSLT}</span><br /><span class="gensmall">{L_RSS_XSLT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_xslt" value="FALSE" {RSS_XSLT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_xslt" value="TRUE" {RSS_XSLT_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_FORCE_XSLT}</span><br /><span class="gensmall">{L_RSS_FORCE_XSLT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_force_xslt" value="FALSE" {RSS_FORCE_XSLT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_force_xslt" value="TRUE" {RSS_FORCE_XSLT_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SITENAME}</span><br /><span class="gensmall">{L_RSS_SITENAME_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_sitename" value="{RSS_SITENAME}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SITEDESC}</span><br /><span class="gensmall">{L_RSS_SITEDESC_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_site_desc" value="{RSS_SITEDESC}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_CINFO}</span><br /><span class="gensmall">{L_RSS_CINFO_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_cinfo" value="{RSS_CINFO}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_LANG}</span><br /><span class="gensmall">{L_RSS_LANG_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_lang" value="{RSS_LANG}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_CHARSET}</span><br /><span class="gensmall">{L_RSS_CHARSET_EXPLAIN}</span></td> 
		<td class="row2">{RSS_CHARSET}</td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_CHARSET_CONV}</span><br /><span class="gensmall">{L_RSS_CHARSET_CONV_EXPLAIN}</span></td> 
		<td class="row2">{RSS_CHARSET_CONV}</td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_IMAGE}</span><br /><span class="gensmall">{L_RSS_IMAGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_image" value="{RSS_IMAGE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_FORUM_IMAGE}</span><br /><span class="gensmall">{L_RSS_FORUM_IMAGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_forum_image" value="{RSS_FORUM_IMAGE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_CACHE_MX_AGE}</span><br /><span class="gensmall">{L_RSS_CACHE_MX_AGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_cache_max_age" value="{RSS_CACHE_MX_AGE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_AUTO_REGEN}</span><br /><span class="gensmall">{L_RSS_AUTO_REGEN_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_auto_regen" value="FALSE" {RSS_AUTO_REGEN_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_auto_regen" value="TRUE" {RSS_AUTO_REGEN_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_GZIP_EXT}</span><br /><span class="gensmall">{L_RSS_GZIP_EXT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_gzip_ext" value="FALSE" {RSS_GZIP_EXT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_gzip_ext" value="TRUE" {RSS_GZIP_EXT_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_YAHOO_NOTIFY}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_NOTIFY}</span><br /><span class="gensmall">{L_YAHOO_NOTIFY_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="yahoo_notify" value="FALSE" {YAHOO_NOTIFY_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="yahoo_notify" value="TRUE" {YAHOO_NOTIFY_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_APPID}</span><br /><span class="gensmall">{L_YAHOO_APPID_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_appid" value="{YAHOO_APPID}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_NOTIFY_LONG}</span><br /><span class="gensmall">{L_YAHOO_NOTIFY_LONG_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="yahoo_notify_long" value="FALSE" {YAHOO_NOTIFY_LONG_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="yahoo_notify_long" value="TRUE" {YAHOO_NOTIFY_LONG_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_RSS_CONTENT_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_MSG_TXT}</span><br /><span class="gensmall">{L_RSS_MSG_TXT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_msg_txt" value="FALSE" {RSS_MSG_TXT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_msg_txt" value="TRUE" {RSS_MSG_TXT_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_BBCODE}</span><br /><span class="gensmall">{L_RSS_ALLOW_BBCODE_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_bbcode" value="FALSE" {RSS_ALLOW_BBCODE_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_bbcode" value="TRUE" {RSS_ALLOW_BBCODE_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_STRIP_BBCODE}</span><br /><span class="gensmall">{L_RSS_STRIP_BBCODE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_strip_bbcode" value="{RSS_STRIP_BBCODE}" /></td> 
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_LINKS}</span><br /><span class="gensmall">{L_RSS_ALLOW_LINKS_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_links" value="FALSE" {RSS_ALLOW_LINKS_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_links" value="TRUE" {RSS_ALLOW_LINKS_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_SMILIES}</span><br /><span class="gensmall">{L_RSS_ALLOW_SMILIES_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_smilies" value="FALSE" {RSS_ALLOW_SMILIES_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_smilies" value="TRUE" {RSS_ALLOW_SMILIES_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SUMARIZE}</span><br /><span class="gensmall">{L_RSS_SUMARIZE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_sumarize" value="{RSS_SUMARIZE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SUMARIZE_METHOD}</span><br /><span class="gensmall">{L_RSS_SUMARIZE_METHOD_EXPLAIN}</span></td> 
		<td class="row2">{RSS_SUMARIZE_METHOD}</td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_FIRST}</span><br /><span class="gensmall">{L_RSS_FIRST_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_first" value="FALSE" {RSS_FIRST_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_first" value="TRUE" {RSS_FIRST_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_LAST}</span><br /><span class="gensmall">{L_RSS_LAST_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_last" value="FALSE" {RSS_LAST_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_last" value="TRUE" {RSS_LAST_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_SHORT}</span><br /><span class="gensmall">{L_RSS_ALLOW_SHORT_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_short" value="FALSE" {RSS_ALLOW_SHORT_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_short" value="TRUE" {RSS_ALLOW_SHORT_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_LONG}</span><br /><span class="gensmall">{L_RSS_ALLOW_LONG_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_long" value="FALSE" {RSS_ALLOW_LONG_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_long" value="TRUE" {RSS_ALLOW_LONG_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_RSS_LIMIT_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_TIME_LIMIT}</span><br /><span class="gensmall">{L_RSS_TIME_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_limit_time" value="{RSS_TIME_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT_LONG}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_LONG_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit_long" value="{RSS_URL_LIMIT_LONG}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit" value="{RSS_URL_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT_SHORT}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_SHORT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit_short" value="{RSS_URL_LIMIT_SHORT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SQL_LIMIT}</span><br /><span class="gensmall">{L_RSS_SQL_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_sql_limit" value="{RSS_SQL_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT_TXT_LONG}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_TXT_LONG_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit_txt_long" value="{RSS_URL_LIMIT_TXT_LONG}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT_TXT}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_TXT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit_txt" value="{RSS_URL_LIMIT_TXT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_URL_LIMIT_TXT_SHORT}</span><br /><span class="gensmall">{L_RSS_URL_LIMIT_TXT_SHORT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_url_limit_txt_short" value="{RSS_URL_LIMIT_TXT_SHORT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_SQL_LIMIT_TXT}</span><br /><span class="gensmall">{L_RSS_SQL_LIMIT_TXT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_sql_limit_txt" value="{RSS_SQL_LIMIT_TXT}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_FORUM_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_ALLOW_AUTH}</span><br /><span class="gensmall">{L_RSS_ALLOW_AUTH_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_allow_auth" value="FALSE" {RSS_ALLOW_AUTH_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_allow_auth" value="TRUE" {RSS_ALLOW_AUTH_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_CACHE_AUTH}</span><br /><span class="gensmall">{L_RSS_CACHE_AUTH_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="rss_cache_auth" value="FALSE" {RSS_CACHE_AUTH_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="rss_cache_auth" value="TRUE" {RSS_CACHE_AUTH_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_RSS_EXCLUDE_FORUM}</span><br /><span class="gensmall">{L_RSS_EXCLUDE_FORUM_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_exclude_forum" value="{RSS_EXCLUDE_FORUM}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td><a href="#top" class="nav">{L_BACK_TO_TOP}</a></td>
	</tr>
</table>
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="yahoo"></a>{L_YAHOO_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{L_YAHOO_SETTINGS_EXPLAIN}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_LIMIT}</span><br /><span class="gensmall">{L_YAHOO_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_limit" value="{YAHOO_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_SQL_LIMIT}</span><br /><span class="gensmall">{L_YAHOO_SQL_LIMIT_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_sql_limit" value="{YAHOO_SQL_LIMIT}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_LIMIT_TIME}</span><br /><span class="gensmall">{L_YAHOO_LIMIT_TIME_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_limit_time" value="{YAHOO_LIMIT_TIME}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_CACHE_MX_AGE}</span><br /><span class="gensmall">{L_YAHOO_CACHE_MX_AGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_cache_max_age" value="{YAHOO_CACHE_MX_AGE}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_AUTO_REGEN}</span><br /><span class="gensmall">{L_YAHOO_AUTO_REGEN_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="yahoo_auto_regen" value="FALSE" {YAHOO_AUTO_REGEN_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="yahoo_auto_regen" value="TRUE" {YAHOO_AUTO_REGEN_YES} /> {L_YES}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{L_FORUM_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_PAGINATION}</span><br /><span class="gensmall">{L_YAHOO_PAGINATION_EXPLAIN}</span></td> 
		<td class="row2"><input type="radio" name="yahoo_pagination" value="FALSE" {YAHOO_PAGINATION_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="yahoo_pagination" value="TRUE" {YAHOO_PAGINATION_YES} /> {L_YES}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_PAGINATION_LIMIT1}</span><br /><span class="gensmall">{L_YAHOO_PAGINATION_LIMIT_EXPLAIN1}</span></td> 
		<td class="row2"><input type="text" name="yahoo_limitdown" value="{YAHOO_PAGINATION_LIMITDOWN}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_PAGINATION_LIMIT2}</span><br /><span class="gensmall">{L_YAHOO_PAGINATION_LIMIT_EXPLAIN2}</span></td> 
		<td class="row2"><input type="text" name="yahoo_limitup" value="{YAHOO_PAGINATION_LIMITUP}" /></td> 
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_YAHOO_EXCLUDE}</span><br /><span class="gensmall">{L_YAHOO_EXCLUDE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_exclude" value="{YAHOO_EXCLUDE}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td><a href="#top" class="nav">{L_BACK_TO_TOP}</a></td>
	</tr>
</table>
<!-- BEGIN mx_config -->
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="mx"></a>{mx_config.L_SITEMAP_MX_SET}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{mx_config.L_SITEMAP_MX_SET_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{mx_config.L_GGS_SETTINGS_KB}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{mx_config.L_MX_EXCLUDE}</span><br /><span class="gensmall">{mx_config.L_MX_EXCLUDE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_mx_exclude" value="{mx_config.MX_EXCLUDE}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{mx_config.L_RSS_SETTINGS_MX}</b></td>
	</tr>
		<td class="row1"><span class="gen">{mx_config.L_RSS_EXCLUDE_MX}</span><br /><span class="gensmall">{mx_config.L_RSS_EXCLUDE_MX_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_exclude_mx" value="{mx_config.RSS_EXCLUDE_MX}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{mx_config.L_YAHOO_MX_SETTINGS}</b></td>
	</tr>
		<td class="row1"><span class="gen">{mx_config.L_YAHOO_EXCLUDE_MX}</span><br /><span class="gensmall">{mx_config.L_YAHOO_EXCLUDE_MX_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_exclude_mx" value="{mx_config.YAHOO_EXCLUDE_MX}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td><a href="#top" class="nav">{L_BACK_TO_TOP}</a></td>
	</tr>
</table>
<!-- END mx_config -->
<!-- BEGIN kb_config -->
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="mxkb"></a>{kb_config.L_SITEMAP_KB_SET}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{kb_config.L_SITEMAP_KB_SET_EXPLAIN}</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config.L_KB_MX_PAGE}</span><br /><span class="gensmall">{kb_config.L_KB_MX_PAGE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_kb_mx_page" value="{kb_config.KB_MX_PAGE}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config.L_GGS_SETTINGS_KB}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config.L_KB_MX_EXCLUDE}</span><br /><span class="gensmall">{kb_config.L_KB_MX_EXCLUDE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_kb_exclude" value="{kb_config.KB_MX_EXCLUDE}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config.L_RSS_SETTINGS_KB}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config.L_RSS_EXCLUDE_KB}</span><br /><span class="gensmall">{kb_config.L_RSS_EXCLUDE_KB_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_exclude_kbcat" value="{kb_config.RSS_EXCLUDE_KB}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config.L_YAHOO_KB_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config.L_YAHOO_EXCLUDE_KB}</span><br /><span class="gensmall">{kb_config.L_YAHOO_EXCLUDE_KB_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_exclude_kbcat" value="{kb_config.YAHOO_EXCLUDE_KB}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<!-- END kb_config -->
<!-- BEGIN kb_config_phpbb -->
<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2"><a name="kb"></a>{kb_config_phpbb.L_SITEMAP_KB_SET}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2">{kb_config_phpbb.L_SITEMAP_KB_SET_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config_phpbb.L_GGS_SETTINGS_KB}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config_phpbb.L_KB_MX_EXCLUDE}</span><br /><span class="gensmall">{kb_config_phpbb.L_KB_MX_EXCLUDE_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="ggs_kb_exclude" value="{kb_config_phpbb.KB_MX_EXCLUDE}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config_phpbb.L_RSS_SETTINGS_KB}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config_phpbb.L_RSS_EXCLUDE_KB}</span><br /><span class="gensmall">{kb_config_phpbb.L_RSS_EXCLUDE_KB_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="rss_exclude_kbcat" value="{kb_config_phpbb.RSS_EXCLUDE_KB}" /></td> 
	</tr>
	<tr>
		<td class="row2" colspan="2"><b>{kb_config_phpbb.L_YAHOO_KB_SETTINGS}</b></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{kb_config_phpbb.L_YAHOO_EXCLUDE_KB}</span><br /><span class="gensmall">{kb_config_phpbb.L_YAHOO_EXCLUDE_KB_EXPLAIN}</span></td> 
		<td class="row2"><input type="text" name="yahoo_exclude_kbcat" value="{kb_config_phpbb.RSS_EXCLUDE_KB}" /></td> 
	</tr>
<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr> 
</table></form>
<!-- END kb_config_phpbb -->

<div align="center"><span class="copyright">{VER_INFO}</span></div>
<br clear="all" />
