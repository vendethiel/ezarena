#
# Basic DB data for phpBB2 devel
#
# $Id: mysql_basic.sql,v 1.29.2.25 2006/03/09 21:55:09 grahamje Exp $

START TRANSACTION;

# -- Config
# default lang and other stuff (forum start) are entered by the install process
INSERT INTO phpbb_config (config_name, config_value) VALUES ('config_id','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sitename','yourdomain.com');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('site_desc','A _little_ text to describe your forum');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_name','phpbb2mysql');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_path','/');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_domain','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_secure','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('session_length','3600');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_html','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_html_tags','b,i,u,pre');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_bbcode','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_smilies','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_sig','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_namechange','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_theme_create','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_local','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_remote','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_upload','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('enable_confirm', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_autologin','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_autologin_time','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('override_user_style','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('posts_per_page','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('topics_per_page','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('hot_threshold','25');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_poll_options','10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_sig_chars','255');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_inbox_privmsgs','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_sentbox_privmsgs','25');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_savebox_privmsgs','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email_sig','Merci et @ bientôt !');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email','youraddress@yourdomain.com');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_delivery','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_host','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_username','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_password','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sendmail_fix','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('require_activation','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('flood_interval','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('search_flood_interval','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_login_attempts', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('login_reset_time', '30');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email_form','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_filesize','6144');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_max_width','80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_max_height','80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_path','images/avatars');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_gallery_path','images/avatars/gallery');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smilies_path','images/smiles');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('default_style','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('default_dateformat','d M Y à G:i');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_timezone','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('prune_enable','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('privmsg_disable','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('gzip_compress','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('coppa_fax', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('coppa_mail', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('record_online_users', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('record_online_date', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('server_name', 'www.myserver.tld');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('server_port', '80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('script_path', '/phpBB2/');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('version', '.0.23');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('ultimarena_version', '7.0.0 Happy New Year Edition');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cache_rcs', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_level_admin', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_level_mod', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_ranks_stats', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_box_on', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_advanced', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_per_row', '14');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_time_regen', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_style_path', 'default');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('users_qp_settings', '1-0-1-1-1-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anons_qp_settings', '1-0-1-1-1-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('LoAl_Intervalle_logos', '120');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_url_length', '60');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('admin_login', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bluecard_limit', '3');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bluecard_limit_2', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_user_bancard', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('report_forum', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('flags_path', 'images/flags/');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_msg', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_mode', '-1,0');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_reply', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_topic', '2');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_page', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_post', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_browse', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_donate', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_name', 'Points');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_user_group_auth_ids', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_system_version', '2.1.1');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('removed_users', '0');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_colortext', '1');
INSERT INTO `phpbb_config` VALUES ('account_delete', '1');

INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar', '0');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_guests', 'images/guest.gif');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_users', 'images/noavatar.gif');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_type', '1');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_random', '0');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_choose', '0');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_override', '0');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('gender_required', '0');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('prune_shouts', '0');

INSERT INTO phpbb_config VALUES ('forum_icon_path','images/forum_icons');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('presentation_required', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('presentation_forum', '0');

# -- Latest active topics on index
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ('topics_on_index', '10');

# -- Advanced Posts Merging
INSERT INTO phpbb_config (config_name, config_value) VALUES('time_to_merge', 0); 
INSERT INTO phpbb_config (config_name, config_value) VALUES('merge_flood_interval', 0); 

# -- Today-Yesterday Relative Time
INSERT INTO phpbb_config (config_name, config_value) VALUES ('ty_lastpost_cutoff','20');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('ty_lastpost_append','...');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('ty_use_rel_date','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('ty_use_rel_time','0');

# -- Post Description
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sub_title_length', '100');

# -- PM threshold
INSERT INTO phpbb_config (config_name, config_value) VALUES ('pm_allow_threshold', '15');

# -- Search latest 24h 48h 72h
INSERT INTO phpbb_config (config_name, config_value) VALUES ('search_latest_hours', '24,48,72');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('search_latest_results', 'topics');

# -- DB Maintenance
DELETE FROM phpbb_config WHERE config_name = 'index_rebuild_position';
DELETE FROM phpbb_config WHERE config_name = 'index_rebuild_end_position';
DELETE FROM phpbb_config WHERE config_name = 'index_rebuild_postlimit';
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuild_end', '0');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuild_pos', '-1');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_maxmemory', '500');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_minposts', '3');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_php3only', '0');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_php3pps', '1');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_php4pps', '8');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_timelimit', '240');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_rebuildcfg_timeoverwrite', '0');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_disallow_postcounter', '0');
INSERT IGNORE INTO phpbb_config (config_name, config_value) VALUES ('dbmtnc_disallow_rebuild', '0');

# -- Google Yahoo MSN Sitemaps and RSS (GYM)
INSERT INTO phpbb_config VALUES ('ggs_gzip', 'FALSE');
INSERT INTO phpbb_config VALUES ('ggs_gzip_ext', 'FALSE');
INSERT INTO phpbb_config VALUES ('rss_gzip_ext', 'FALSE');
INSERT INTO phpbb_config VALUES ('ggs_exclude_forums', '');
INSERT INTO phpbb_config VALUES ('rss_exclude_forum', '');
INSERT INTO phpbb_config VALUES ('rss_allow_auth', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_mod_rewrite', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_zero_dupe', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_mod_rewrite_type', '0');
INSERT INTO phpbb_ggs_config VALUES ('ggs_showstats', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_gzip', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_gzip_level', '6');
INSERT INTO phpbb_ggs_config VALUES ('ggs_cached', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_auto_regen', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_gzip_ext', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_mod_since', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_force_cache_gzip', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_cache_max_age', '24');
INSERT INTO phpbb_ggs_config VALUES ('ggs_cache_dir', 'gs_cache/');
INSERT INTO phpbb_ggs_config VALUES ('google_cache_born', '0');
INSERT INTO phpbb_ggs_config VALUES ('rss_cache_born', '0');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_cache_born', '0');
INSERT INTO phpbb_ggs_config VALUES ('ggs_xslt', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_sql_limit', '200');
INSERT INTO phpbb_ggs_config VALUES ('ggs_url_limit', '2500');
INSERT INTO phpbb_ggs_config VALUES ('ggs_sort', 'DESC');
INSERT INTO phpbb_ggs_config VALUES ('ggs_exclude_forums', '');
INSERT INTO phpbb_ggs_config VALUES ('ggs_announce_priority', '0.5');
INSERT INTO phpbb_ggs_config VALUES ('ggs_default_priority', '1.0');
INSERT INTO phpbb_ggs_config VALUES ('ggs_sticky_priority', '0.75');
INSERT INTO phpbb_ggs_config VALUES ('ggs_pagination', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_limitdown', '5');
INSERT INTO phpbb_ggs_config VALUES ('ggs_limitup', '5');
INSERT INTO phpbb_ggs_config VALUES ('ggs_mx_exclude', '');
INSERT INTO phpbb_ggs_config VALUES ('ggs_kb_mx_page', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('ggs_kb_exclude', '');
INSERT INTO phpbb_ggs_config VALUES ('rss_cache_max_age', '12');
INSERT INTO phpbb_ggs_config VALUES ('rss_limit_time', '60');
INSERT INTO phpbb_ggs_config VALUES ('rss_auto_regen', 'TRUE');	
INSERT INTO phpbb_ggs_config VALUES ('rss_charset_conv', 'auto');
INSERT INTO phpbb_ggs_config VALUES ('rss_charset', '$charset');
INSERT INTO phpbb_ggs_config VALUES ('rss_gzip_ext', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_xslt', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_force_xslt', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_lang', 'en');
INSERT INTO phpbb_ggs_config VALUES ('rss_sitename', '$rss_title');
INSERT INTO phpbb_ggs_config VALUES ('rss_site_desc', '$rss_desc');
INSERT INTO phpbb_ggs_config VALUES ('rss_cinfo', '$rss_title');
INSERT INTO phpbb_ggs_config VALUES ('rss_image', 'rss_board_big.gif');
INSERT INTO phpbb_ggs_config VALUES ('rss_forum_image', 'rss_forum_big.gif');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_auth', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_cache_auth', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit_long', '500');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit', '100');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit_short', '25');
INSERT INTO phpbb_ggs_config VALUES ('rss_sql_limit', '100');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit_txt_long', '200');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit_txt', '50');
INSERT INTO phpbb_ggs_config VALUES ('rss_url_limit_txt_short', '25');
INSERT INTO phpbb_ggs_config VALUES ('rss_sql_limit_txt', '25');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_short', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_long', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_sumarize', '10');
INSERT INTO phpbb_ggs_config VALUES ('rss_sumarize_method', 'sentences');
INSERT INTO phpbb_ggs_config VALUES ('rss_exclude_forum', '');
INSERT INTO phpbb_ggs_config VALUES ('rss_first', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('rss_last', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_msg_txt', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_bbcode', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_strip_bbcode', '');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_links', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_allow_smilies', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('rss_exclude_kbcat', '');
INSERT INTO phpbb_ggs_config VALUES ('rss_exclude_mx', '');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_limit', '500');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_sql_limit', '100');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_limit_time', '60');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_exclude', '');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_cache_max_age', '48');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_auto_regen', 'TRUE');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_pagination', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_limitdown', '5');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_limitup', '5');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_notify', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_appid', '');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_notify_long', 'FALSE');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_exclude_kbcat', '');
INSERT INTO phpbb_ggs_config VALUES ('yahoo_exclude_mx', '');
INSERT INTO phpbb_ggs_config VALUES ('ggs_c_info', '(C) 2006 dcz - http://www.phpbb-seo.com/');
INSERT INTO phpbb_ggs_config VALUES ('ggs_ver', 'v1.2.0RC4');

# -- Addon "disable phpBB SEO"
INSERT INTO phpbb_config VALUES ('disable_rewrite', 1);

# -- AreaBB
INSERT INTO phpbb_areabb_blocs VALUES (1,1,6,'PHP'),(2,1,2,'PHP'),(3,1,7,'PHP'),(4,1,0,''),(5,1,0,''),(6,1,3,'PHP'),(7,1,4,'PHP'),(8,1,5,'PHP'),(9,1,0,''),(10,1,0,'');
INSERT INTO phpbb_areabb_blocs VALUES (11,1,0,''),(12,2,2,'PHP'),(13,2,4,'PHP'),(14,2,6,'PHP'),(15,2,5,'PHP'),(16,2,7,'PHP'),(17,2,0,''),(18,2,0,''),(19,2,0,''),(20,2,0,'');
INSERT INTO phpbb_areabb_blocs VALUES (21,2,0,''),(22,2,0,''),(23,3,2,'PHP'),(24,3,9,'PHP'),(25,3,0,''),(76,16,25,'PHP'),(77,16,7,'PHP'),(78,16,24,'PHP'),(79,16,5,'PHP'),(80,16,19,'PHP');
INSERT INTO phpbb_areabb_blocs VALUES (81,16,16,'PHP'),(82,16,0,''),(83,16,0,''),(84,16,4,'PHP'),(85,16,26,'PHP'),(86,16,18,'PHP'),(98,18,7,'PHP'),(99,18,17,'PHP'),(100,18,6,'PHP'),(101,18,23,'PHP');
INSERT INTO phpbb_areabb_blocs VALUES (102,18,24,'PHP'),(103,18,3,'PHP'),(104,18,4,'PHP'),(105,18,18,'PHP'),(106,18,5,'PHP'),(107,18,19,'PHP'),(108,18,0,''),(109,19,19,'PHP'),(110,19,9,'PHP'),(111,19,21,'PHP');
INSERT INTO phpbb_areabb_blocs VALUES (112,20,22,'PHP'),(113,20,20,'PHP'),(114,20,24,'PHP'),(118,22,0,''),(119,22,25,'PHP'),(120,22,0,'');
INSERT INTO phpbb_areabb_config VALUES ('affichage_categorie','2'),('affichage_icone','1'),('affichage_jeux','2'),('affichage_nbre_jeux','1'),('arcade_par_defaut','5'),('auth_dwld','1'),('avoir_poste_joue','1'),('chemin_pkg_jeux','areabb/games/'),('defiler_topics_recents','1'),('format_pag','0');
INSERT INTO phpbb_areabb_config VALUES ('forum_presente','7'),('games_par_defaut','6'),('games_par_page','8'),('games_time_tolerance','4'),('game_order','News'),('game_popup','0'),('group_vip','0'),('liens_aleatoire','0'),('liens_cache','1'),('liens_nbre_liens','0');
INSERT INTO phpbb_areabb_config VALUES ('liens_scroll','1'),('mod_gender','1'),('mod_point_system','1'),('mod_profile','1'),('mod_rcs','1'),('nbre_topics_min','10'),('nbre_topics_recents','10'),('news_aff_asv','1'),('news_aff_coms','1'),('news_aff_icone','1');
INSERT INTO phpbb_areabb_config VALUES ('news_forums','207'),('news_nbre_coms','20'),('news_nbre_mots','500'),('news_nbre_news','3'),('news_par_defaut','7'),('nom_group_vip','0'),('presente','1');
INSERT INTO phpbb_areabb_feuille VALUES (16,5,3,12),(18,7,3,14),(19,6,1,15),(20,6,1,16);
INSERT INTO phpbb_areabb_liens VALUES (2,'EzCom','http://ezcom-fr.com',10,'http://www.ezcom-fr.com/styles/procss3/imageset/site_logo.png');
INSERT INTO phpbb_areabb_modeles VALUES (1,'<table width=\'100%\' cellspacing=\'0\' cellpadding=\'2\' border=\'0\' align=\'center\' valign=\'top\'>\r\n<tr>\r\n      <td width=\'28%\' align=\'center\' valign=\'top\'>%s</td>\r\n      <td width=\'44%\' align=\'center\' valign=\'top\'><center>%s</center></td>\r\n      <td width=\'28%\' align=\'center\' valign=\'top\'>%s</td>\r\n</tr>\r\n</table>','3 colonnes, le bloc central est 2 fois plus large que les autres'),(2,'<table width=\'100%\'>\r\n   <tr>\r\n      <td class=\'row1\'>%s</td>\r\n   </tr>\r\n</table>','Bloc 100% de la largeur'),(3,'<table width=\'100%\' cellspacing=\'0\' cellpadding=\'2\' border=\'0\' align=\'center\' valign=\'top\'>\r\n<tr>\r\n    <td width=\'22%\' align=\'center\' valign=\'top\'>\r\n         %s \r\n         %s \r\n         %s \r\n         %s \r\n         %s \r\n      </td>\r\n      <td width=\'56%\' align=\'center\' valign=\'top\'>%s</td>\r\n      <td width=\'22%\' align=\'center\' valign=\'top\'>\r\n         %s \r\n         %s \r\n         %s \r\n         %s \r\n         %s \r\n       </td>\r\n</tr>\r\n</table>','Structure traditionnelle');
INSERT INTO phpbb_areabb_mods VALUES (1,'config',0,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(2,'login',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(3,'news',1,'3'),(4,'recent_topics',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(5,'whoisonline',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(6,'welcome',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(7,'statistiques',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(8,'profile',0,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(9,'games',1,'2'),(16,'liste_jeux_SP2',1,'1');
INSERT INTO phpbb_areabb_mods VALUES (17,'liens',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(18,'changestyle',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(19,'classvictoire',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(20,'podium_jeu',1,'2'),(21,'fiche_jeux',1,'2'),(22,'classement_jeu',1,'2'),(23,'sondage',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(24,'qui_joue',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30'),(25,'aleatoire',1,'1,2'),(26,'menu_SP1',1,'1');
INSERT INTO phpbb_areabb_note VALUES (4,342,5),(6,868,5),(3,868,4),(7,446,4),(4,446,5),(24,2,2),(19,2,5),(26,443,4),(27,579,2),(37,662,5);
INSERT INTO phpbb_areabb_note VALUES (44,730,3),(39,446,2),(30,2,5),(85,367,5),(24,868,4),(46,868,0),(14,868,5),(39,2,3),(72,2,3);
INSERT INTO phpbb_areabb_squelette VALUES (5,'Salle de jeux','',1,0),(6,'Parties engagées','826',2,0),(7,'Les News',NULL,3,0);
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('AreaBB_version', '0.9.1');

# -- Categories
INSERT INTO phpbb_categories (cat_id, cat_title, cat_order) VALUES (1, 'Catégorie Test 1', 10);


# -- Forums
INSERT INTO phpbb_forums (forum_id, forum_name, forum_desc, cat_id, forum_order, forum_posts, forum_topics, forum_last_post_id, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_announce, auth_sticky, auth_pollcreate, auth_vote, auth_download) VALUES (1, 'Forum Test 1', 'Juste un forum de test.', 1, 10, 1, 1, 1, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 3);


# -- Users
INSERT INTO phpbb_users (user_id, username, user_level, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_viewemail, user_style, user_aim, user_yim, user_msnm, user_posts, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_pm, user_notify_pm, user_allow_viewonline, user_rank, user_avatar, user_lang, user_timezone, user_dateformat, user_actkey, user_newpasswd, user_notify, user_active) VALUES ( -1, 'Anonymous', 0, 0, '', '', '', '', '', '', '', '', 0, NULL, '', '', '', 0, 0, 1, 1, 1, 0, 1, 1, NULL, '', '', 0, '', '', '', 0, 0);

# -- username: admin    password: admin (change this or remove it once everything is working!)
INSERT INTO phpbb_users (user_id, username, user_level, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_viewemail, user_style, user_aim, user_yim, user_msnm, user_posts, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_pm, user_notify_pm, user_popup_pm, user_allow_viewonline, user_rank, user_avatar, user_lang, user_timezone, user_dateformat, user_actkey, user_newpasswd, user_notify, user_active) VALUES ( 2, 'Admin', 1, 0, '21232f297a57a5a743894a0e4a801fc3', 'admin@yourdomain.com', '', '', '', '', '', '', 1, 1, '', '', '', 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, '', 'french', 0, 'd M Y h:i a', '', '', 0, 1);


# -- Ranks
INSERT INTO phpbb_ranks (rank_id, rank_title, rank_min, rank_special, rank_image) VALUES ( 1, 'Administrateur', -1, 1, NULL);


# -- Write-confirmation
INSERT INTO `phpbb_config` VALUES ('question_conf', 'Combien font 6 + 2 ?');
INSERT INTO `phpbb_config` VALUES ('question_conf_enable', '0');
INSERT INTO `phpbb_config` VALUES ('reponse_conf', 'huit');


# -- Groups
INSERT INTO phpbb_groups (group_id, group_name, group_description, group_single_user) VALUES (1, 'Anonymous', 'Personal User', 1);
INSERT INTO phpbb_groups (group_id, group_name, group_description, group_single_user) VALUES (2, 'Admin', 'Personal User', 1);


# -- User -> Group
INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES (1, -1, 0);
INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES (2, 2, 0);


# -- Demo Topic
INSERT INTO phpbb_topics (topic_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, forum_id, topic_status, topic_type, topic_vote, topic_first_post_id, topic_last_post_id) VALUES (1, 'Bienvenue sur la premod ezArena', 2, '972086460', 0, 0, 1, 0, 0, 0, 1, 1);


# -- Demo Post
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, post_username, poster_ip) VALUES (1, 1, 1, 2, 972086460, NULL, '7F000001');
INSERT INTO phpbb_posts_text (post_id, post_subject, post_text) VALUES (1, NULL, 'Vous pouvez effacer ce post si vous ne relevez aucun problème !');


# -- Themes
INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3) VALUES (1, 'phpbb', 'subSilver', 'subSilver/style.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, \'Courier New\', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', '', '', '');

INSERT INTO phpbb_themes_name (themes_id, tr_color1_name, tr_color2_name, tr_color3_name, tr_class1_name, tr_class2_name, tr_class3_name, th_color1_name, th_color2_name, th_color3_name, th_class1_name, th_class2_name, th_class3_name, td_color1_name, td_color2_name, td_color3_name, td_class1_name, td_class2_name, td_class3_name, fontface1_name, fontface2_name, fontface3_name, fontsize1_name, fontsize2_name, fontsize3_name, fontcolor1_name, fontcolor2_name, fontcolor3_name, span_class1_name, span_class2_name, span_class3_name) VALUES (1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

# -- Smilies
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 1, ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 2, ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 3, ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 4, ':)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 5, ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 6, ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 7, ':(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 8, ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 9, ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 10, ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 11, ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 12, ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 13, ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 14, ':?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 15, ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 16, ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 17, '8)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 18, '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 19, ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 20, ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 21, ':x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 22, ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 23, ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 24, ':P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 25, ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 26, ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 27, ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 28, ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 29, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 30, ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 31, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 32, ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 33, ';)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 34, ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 35, ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 36, ':?:', 'icon_question.gif', 'Question');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 37, ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 38, ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 39, ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 40, ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 41, ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 42, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');


# -- wordlist
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 1, 'example', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 2, 'post', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 3, 'phpbb', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 4, 'installation', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 5, 'delete', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 6, 'topic', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 7, 'forum', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 8, 'since', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 9, 'everything', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 10, 'seems', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 11, 'working', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 12, 'welcome', 0 );


# -- wordmatch
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 1, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 2, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 3, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 4, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 5, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 6, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 7, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 8, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 9, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 10, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 11, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 12, 1, 1 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 3, 1, 1 );


# -- bbc_box
INSERT INTO phpbb_bbc_box VALUES (1,'strike','1','0','s','s','strike','strike','0',30),(2,'spoiler','1','0','spoil','spoil','spoiler','spoiler','0',40),(3,'fade','1','0','fade','fade','fade','fade','0',50),(4,'rainbow','1','0','rainbow','rainbow','rainbow','rainbow','0',60),(5,'justify','1','0','align=justify','align','justify','justify','0',70),(6,'right','1','0','align=right','align','right','right','0',80),(7,'center','1','0','align=center','align','center','center','0',90),(8,'left','1','0','align=left','align','left','left','0',100),(9,'link','1','0','link=','link','link','alink','0',110),(10,'target','1','0','target=','target','target','atarget','0',120);
INSERT INTO phpbb_bbc_box VALUES (11,'marqd','1','0','marq=down','marq','marqd','marqd','0',130),(12,'marqu','1','0','marq=up','marq','marqu','marqu','0',140),(13,'marql','1','0','marq=left','marq','marql','marql','0',150),(14,'marqr','1','0','marq=right','marq','marqr','marqr','0',160),(15,'email','1','0','email','email','email','email','0',170),(16,'flash','1','0','flash width=250 height=250','flash','flash','flash','0',180),(17,'video','1','0','video width=400 height=350','video','video','video','0',190),(18,'stream','1','0','stream','stream','stream','stream','0',200),(19,'real','1','0','ram width=220 height=140','ram','real','real','0',210),(20,'quick','1','0','quick width=480 height=224','quick','quick','quick','0',220);
INSERT INTO phpbb_bbc_box VALUES (21,'sup','1','0','sup','sup','sup','sup','0',230),(22,'sub','1','0','sub','sub','sub','sub','0',240),(23,'hide','1','0','hide','hide','hide','hide','0',10),(24,'tmb','1','0','tmb','tmb','tmb','tmb','0',20),(25,'youtube','1','0','youtube','youtube','youtube','youtube','0',250),(26,'website','1','0','website','website','website','website','0',260),(27,'google','1','0','GVideo','GVideo','google','google','0',270),(28,'dailymotion','1','0','dailymotion','dailymotion','dailymotion','dailymotion','0',280),(29,'titre 1','1','0','titre1','titre1','titre1','titre1','0',290),(30,'movie','1','0','movie','movie','movie','movie','0',300);
INSERT INTO phpbb_bbc_box VALUES (31,'play','1','0','play','play','play','play','0',310);

# -- Logos
INSERT INTO phpbb_logos VALUES (1,'images/ulti1.gif','1',0,0);


# -- ACP Site Announcement Centre
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_text', '[size=18][color=red][b]Changez votre annonce de site via votre panneau d\'administration.   :) [/b][/color][/size]'); 
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_status', '1');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_access', '1');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_guest_text', '[size=18][color=blue][b]Changez votre annonce pour les invites via votre panneau d\'administration.   :) [/b][/color][/size]'); 
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_guest_status', '1');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_text_draft', '[size=18][color=red][b]Prévisualisation dans l\'ACP   :) [/b][/color][/size]'); 
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_mod_version', 'v1.2.3');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_forum_id', '');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_topic_id', '');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_forum_topic_first_latest', '1');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_title', 'Annonce du site');
INSERT INTO phpbb_announcement_centre (announcement_desc, announcement_value) VALUES('announcement_guest_title', 'Annonce du site pour les invités');

# -- Advanced IP Tracking 1.0.5
INSERT INTO phpbb_ip_tracking_config VALUES (25000);

# -- Birthday Event 1.1.0
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_show',1);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_require',0);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_lock',0);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_lookahead',7);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_min',5);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_max',100);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_zodiac',0);
INSERT INTO phpbb_config (config_name,config_value) VALUES ('bday_wishes',1);

# EzArena
INSERT INTO `phpbb_config` VALUES ('ezarena_version', '1.0.0');

#
# ATTACH MOD
#

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_dir','files');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_img','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('topic_icon','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('display_order','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize','262144');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_quota','52428800');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize_pm','262144');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments','3');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments_pm','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('disable_mod','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_pm_attach','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_topic_review','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_ftp_upload','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('show_apcp','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attach_version','2.4.5');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_upload_quota', '0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_pm_quota', '0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_server','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('download_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_user','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pass','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pasv_mode','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_display_inlined','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_create_thumbnail','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_min_thumb_filesize','12000');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_imagick', '');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('use_gd2','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('wma_autoplay','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('flash_autoplay','0');

# -- forbidden_extensions
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (1,'php');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (2,'php3');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (3,'php4');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (4,'phtml');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (5,'pl');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (6,'asp');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (7,'cgi');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (8,'php5');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (9,'php6');

# -- extension_groups
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (1,'Images',1,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (2,'Archives',0,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (3,'Plain Text',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (4,'Documents',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (5,'Real Media',0,0,2,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (6,'Streams',2,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (7,'Flash Files',3,0,1,'',0,'');

# -- extensions
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (1, 1,'gif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (2, 1,'png', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (3, 1,'jpeg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (4, 1,'jpg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (5, 1,'tif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (6, 1,'tga', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (7, 2,'gtar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (8, 2,'gz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (9, 2,'tar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (10, 2,'zip', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (11, 2,'rar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (12, 2,'ace', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (13, 3,'txt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (14, 3,'c', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (15, 3,'h', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (16, 3,'cpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (17, 3,'hpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (18, 3,'diz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (19, 4,'xls', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (20, 4,'doc', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (21, 4,'dot', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (22, 4,'pdf', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (23, 4,'ai', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (24, 4,'ps', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (25, 4,'ppt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (26, 5,'rm', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (27, 6,'wma', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (28, 7,'swf', '');

# -- default quota limits
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (1, 'Low', 262144);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (2, 'Medium', 2097152);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (3, 'High', 5242880);

#
# ADDON: thumbnail settings
#

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_thumb_size','400');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_thumb_quality','90');

#
# QTE
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('qte_version', '1.6.1');

#
# Subforums +
#
INSERT INTO phpbb_config (config_name, config_value) VALUES('mod_sf_version','0.0.6');

#
# ADR
#

# Alignments
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (1, 'Adr_alignment_neutral', 'Adr_alignment_neutral_desc', 0, 'Neutral.gif', 0, 0);
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (2, 'Adr_alignment_evil', 'Adr_alignment_evil_desc', 0, 'Evil.gif', 1000, 2);
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (3, 'Adr_alignment_good', 'Adr_alignment_good_desc', 0, 'Good.gif', 1000, 1);

# Monsters
INSERT INTO phpbb_adr_battle_monsters (monster_id, monster_name, monster_img, monster_level, monster_base_hp, monster_base_att, monster_base_def, monster_base_mp, monster_base_custom_spell, monster_base_magic_attack, monster_base_magic_resistance, monster_base_mp_power, monster_base_sp, monster_thief_skill, monster_base_element, monster_base_karma, monster_season, monster_weather, monster_message_enable, monster_message) VALUES (1338, 'torch eye', 'torch eye.gif', 1, 12, 24, 25, 1, 'a magical spell', 7, 9, 1, 3, 21, 6, 0, 0, '0', 0, '');

# Classes
INSERT INTO phpbb_adr_classes (class_id, class_name, class_desc, class_level, class_img, class_might_req, class_dexterity_req, class_constitution_req, class_intelligence_req, class_wisdom_req, class_charisma_req, class_base_hp, class_base_mp, class_base_ac, class_update_hp, class_update_mp, class_update_ac, class_update_xp_req, class_update_of, class_update_of_req, class_selectable, class_magic_attack_req, class_magic_resistance_req) VALUES (1, 'Anti Paladin', 'Defeats Paladins', 0, 'Anti Paladin.gif', 0, 0, 0, 0, 0, 0, 12, 1, 10, 12, 2, 1, 2000, 0, 0, 1, 0, 0);

# Elements 
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (1, 'Adr_element_water', 'Adr_element_water_desc', 0, 'Water.gif', 10, 10, 10, 10, 30, 30, 4, 100, 100, 4, 100);
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (2, 'Adr_element_earth', 'Adr_element_earth_desc', 0, 'Earth.gif', 30, 30, 10, 10, 10, 10, 6, 100, 100, 6, 100);
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (3, 'Adr_element_holy', 'Adr_element_holy_desc', 2, 'Holy.gif', 20, 20, 20, 20, 20, 20, 7, 100, 100, 7, 100);
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (4, 'Adr_element_fire', 'Adr_element_fire_desc', 0, 'Fire.gif', 15, 15, 40, 10, 10, 10, 1, 100, 100, 1, 100);
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (6, 'Air', 'Element Air', 0, 'Wind.gif', 10, 10, 10, 40, 15, 15, 2, 100, 100, 2, 100);
INSERT INTO phpbb_adr_elements (element_id, element_name, element_desc, element_level, element_img, element_skill_mining_bonus, element_skill_stone_bonus, element_skill_forge_bonus, element_skill_enchantment_bonus, element_skill_trading_bonus, element_skill_thief_bonus, element_oppose_strong, element_oppose_strong_dmg, element_oppose_same_dmg, element_oppose_weak, element_oppose_weak_dmg) VALUES (5, 'Unholy', 'Element Unholy', 1, 'Unholy.gif', 30, 30, 30, 30, 30, 30, 3, 100, 100, 3, 100);

# Config
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('max_characteristic', 20);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('min_characteristic', 6);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('allow_reroll', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('allow_character_delete', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('allow_shop_steal', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('new_shop_price', 500);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('item_modifier_power', 150);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('skill_trading_power', 2);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('skill_thief_failure_damage', 2000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('skill_thief_failure_punishment', 2);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('skill_thief_failure_type', 2);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('skill_thief_failure_time', 6);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('vault_loan_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('interests_rate', 4);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('interests_time', 432000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('loan_interests', 8);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('loan_interests_time', 432000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('loan_max_sum', 5000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('loan_requirements', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('stock_max_change', 15);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('stock_min_change', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('vault_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_monster_stats_modifier', 120);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_exp_min', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_exp_max', 200);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_exp_modifier', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_reward_min', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_reward_max', 200);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_reward_modifier', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_heal_cost', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_resurrect_cost', 25);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_allow_user_caution', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_allow_user_judge', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_allow_user_blank', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_amount_user_blank', 10000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_user_judge_voters', 10);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('cell_user_judge_posts', 2);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('item_power_level', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('training_skill_cost', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('training_charac_cost', 10);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('training_upgrade_cost', 10000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('training_allow_change', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('training_change_cost', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('next_level_penalty', 10);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_pvp_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_pvp_defies_max', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_exp_min', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_exp_max', 500);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_exp_modifier', 150);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_reward_min', 50);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_reward_max', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('pvp_base_reward_modifier', 150);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_disable_rpg', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_limit_regen_duration', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_battle_limit', 30);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_skill_limit', 20);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_trading_limit', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_thief_limit', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('weight_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_base_sp_modifier', 120);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('posts_min', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_limit_enable', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('posts_enable', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_calc_type', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('job_salary_enable', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('job_salary_cron_time', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('job_salary_cron_last_time', 1104681333);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_allow_retire_character', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_minimum_retire_level', 8);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_retire_points_award', 5000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_retire_points_award_level', 1000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('event_hi', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_event_limit_enable', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_character_event_limit', 40);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_min_donation', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_win_chance', 90);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_chance_increase', 500);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_super_rare_amount', 10000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('temple_total_donations', 387896);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('beggar_min_donation', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('beggar_win_chance', 90);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('beggar_chance_increase', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('beggar_super_rare_amount', 5000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('beggar_total_donations', 64793);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('lake_min_donation', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('lake_win_chance', 90);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('lake_chance_increase', 500);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('lake_super_rare_amount', 5000);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('lake_total_donations', 2181);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_karma_enable', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_karma_min', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_karma_trading_bonus', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_karma_shop_owner_bonus', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_karma_give_bonus', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('last_character_replen', 0);

# Jobs
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (1, 'Town Cryer', 'Notify the town of latest events', 0, 0, 0, 1, 0, 'town_cryer.gif', 500, 300, 717, 3, 5, 7, 75, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (2, 'Priest', 'Spread the word of God throughout your town', 0, 0, 0, 2, 0, 'priest.gif', 600, 400, 735, 3, 3, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (3, 'Miners Guide', 'Guide people thrugh the mines', 0, 7, 0, 1, 0, 'Dwarf.gif', 600, 400, 0, 1, 1, 7, 75, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (4, 'Prison Guard', 'Guard the prison', 0, 3, 0, 5, 0, 'Half-orc.gif', 1000, 700, 712, 2, 2, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (5, 'Bank Guard', 'Guard the Bank', 0, 0, 0, 6, 0, 'Super Guard.gif', 1100, 800, 36, 2, 2, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (6, 'Town Harlet', 'Your the town harlet', 9, 0, 0, 1, 0, 'servant.gif', 500, 300, 0, 1, 1, 7, 75, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (7, 'King', 'You rule the Kingdom', 0, 0, 0, 12, 0, 'King.gif', 2500, 1500, 309, 1, 1, 7, 175, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (8, 'Town Guard', 'Walk the town guarding people', 0, 0, 0, 3, 0, 'Super Guard.gif', 700, 450, 659, 5, 5, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (9, 'Town Freak', 'Your the town freak!!', 0, 0, 0, 1, 0, 'sea creater.gif', 520, 320, 42, 0, 1, 7, 75, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (10, 'Assasin', 'Work for the Thieves guild', 0, 0, 0, 7, 0, 'assassin.gif', 1300, 900, 717, 2, 2, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (11, 'Court Jester', 'Court Jester', 0, 0, 0, 3, 0, 'jester.gif', 700, 450, 42, 1, 1, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (12, 'Town Bully', 'Kick everyone ass', 0, 0, 0, 7, 0, 'bully.gif', 1250, 850, 152, 1, 1, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (13, 'Temple Priestess', 'You work in the temple', 20, 0, 0, 1, 0, 'raceimage1.gif', 600, 400, 0, 1, 1, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (14, 'Temple Priest', 'You work in the temple', 8, 0, 0, 1, 0, 'highpriest.gif', 600, 400, 0, 1, 1, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (15, 'Body Guard', 'Rich Merchant looking for a body guard', 0, 0, 0, 2, 0, 'guard1.gif', 600, 420, 73, 1, 2, 7, 95, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (16, 'Town Duke', 'A Town Noble', 0, 0, 0, 8, 0, 'male elf.gif', 1400, 990, 0, 1, 2, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (17, 'Servant', 'You serve a town Noble', 0, 0, 0, 1, 0, 'peasent.gif', 500, 300, 735, 4, 5, 7, 75, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (18, 'Soul Catcher', 'Vampire needed for soul catching', 0, 9, 0, 1, 0, 'vampire.gif', 750, 550, 719, 1, 1, 7, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (19, 'Treasure Hunting', 'Hunt for the Undead Gauntlets', 0, 0, 0, 1, 0, 'terra-seed_0.gif', 500, 500, 3214, 1, 1, 30, 100, 1);
INSERT INTO phpbb_adr_jobs (job_id, job_name, job_desc, job_class_id, job_race_id, job_alignment_id, job_level, job_auth_level, job_img, job_salary, job_exp, job_item_reward_id, job_slots_available, job_slots_max, job_duration, job_sp_reward, job_payment_intervals) VALUES (20, 'Town Banker', 'You work at the bank', 0, 0, 0, 3, 0, 'sephiroth_0.gif', 650, 450, 726, 1, 2, 7, 100, 1);

# Lake donations kinds
INSERT INTO phpbb_adr_lake_donations (item_id, item_chance, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_weight, item_max_skill, item_add_power, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_sell_back_percentage) VALUES (1, 0, 1, 6601, 6, 3, 150, 150, 'Sword/Bastard Sword.gif', 'Sword of Wounding', 'A Gift From The Lady Of The Lake', 6, 50, 6, 3, 3, 1, 200, 50, 100, 10);
INSERT INTO phpbb_adr_lake_donations (item_id, item_chance, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_weight, item_max_skill, item_add_power, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_sell_back_percentage) VALUES (2, 1, 1, 9900, 6, 5, 200, 200, 'Sword/Holy Sword.gif', 'Sword of Holy Might', 'A Gift From The Lady Of The Lake', 6, 50, 10, 5, 3, 3, 200, 50, 100, 10);
INSERT INTO phpbb_adr_lake_donations (item_id, item_chance, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_weight, item_max_skill, item_add_power, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_sell_back_percentage) VALUES (3, 2, 1, 14851, 6, 8, 200, 200, 'Sword/Fire Sword.gif', 'Sword of Hellfire', 'A Gift From The Lady Of The Lake', 6, 50, 16, 8, 3, 4, 200, 50, 100, 10);
INSERT INTO phpbb_adr_lake_donations (item_id, item_chance, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_weight, item_max_skill, item_add_power, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_sell_back_percentage) VALUES (4, 3, 1, 19800, 6, 11, 325, 325, 'Sword/Long Sword.gif', 'Sword of Crushing', 'A Gift From The Lady Of The Lake', 6, 50, 22, 11, 3, 2, 200, 50, 100, 10);
INSERT INTO phpbb_adr_lake_donations (item_id, item_chance, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_weight, item_max_skill, item_add_power, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_sell_back_percentage) VALUES (5, 4, 1, 26401, 6, 15, 425, 425, 'Sword/Dragon Sword.gif', 'Sword of Destruction', 'A Gift From The Lady Of The Lake', 6, 50, 30, 15, 3, 5, 200, 50, 100, 10);

# Races
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (1, 'Adr_race_human', 'Adr_race_human_desc', 0, 'Human.gif', 0, 0, 0, 0, 0, 0, 5, 5, 5, 5, 5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1000, 5, 2, 'Suzail');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (2, 'Adr_race_half-elf', 'Adr_race_half-elf_desc', 0, 'Half-elf.gif', 0, 1, 0, 0, 0, 1, 0, 5, 0, 10, 5, 10, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 900, 5, 2, 'Suzail');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (3, 'Orc', 'Race Orc', 0, 'Half-orc.gif', 2, 0, 2, 0, 0, 0, 15, 0, 0, 0, 0, 15, 0, 0, 0, 2, 0, 2, 0, 2, 0, 0, 1500, 5, 2, 'Suzail');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (4, 'Adr_race_elf', 'Adr_race_elf_desc', 0, 'Elf.gif', 0, 2, 0, 2, 0, 0, 0, 0, 5, 15, 10, 0, 2, 0, 2, 0, 0, 0, 2, 0, 0, 0, 800, 5, 2, 'Suzail');

# Shops
INSERT INTO phpbb_adr_shops (shop_id, shop_owner_id, shop_name, shop_desc, shop_logo) VALUES (1, 1, 'Adr_shop_forums', 'Adr_shop_forums_desc', '');
INSERT INTO phpbb_adr_shops (shop_id, shop_owner_id, shop_name, shop_desc, shop_logo) VALUES (4, 445, 'Enchanter''s Tower:  Requests accepted by PM', 'Selling a few weakly (+3-9) enchanted items.  PM me with requests for more powerful items.  Prices will go down if stuff sells!', '');
INSERT INTO phpbb_adr_shops (shop_id, shop_owner_id, shop_name, shop_desc, shop_logo) VALUES (8, 478, 'Agouti''s Emporium', 'various curios are sold here(swords, armor, and other interesting artifacts)', '');

# Shop Items
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (513, 1, 56, 3, 1, 1, 1, 'Fire Magic.gif', 'Fire Ball', 'Fire Ball', 11, 0, 1, 4, 200, 50, 100, 8, 1, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (14, 1, 660, 5, 2, 75, 75, 'armor/shadow_cloak.gif', 'Shadow Cloak', 'Shadow Cloak', 7, 0, 0, 0, 100, 100, 100, 9, 10, 0, 4, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (15, 1, 154, 1, 6, 175, 175, 'armor/quarter_platemail.gif', 'Quarter Platemail', 'Quarter Platemail', 7, 0, 0, 0, 100, 100, 100, 3, 250, 0, 12, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (16, 1, 386, 2, 6, 175, 175, 'armor/half_platemail.gif', 'Half Platemail', 'Half Platemail', 7, 0, 0, 0, 100, 100, 100, 3, 300, 0, 12, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (17, 1, 771, 3, 6, 175, 175, 'armor/threequarter_platemail.gif', 'Three Quarter Platemail', 'Three Quarter Platemail', 7, 0, 0, 0, 100, 100, 100, 3, 350, 0, 12, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (20, 1, 1761, 5, 7, 200, 200, 'armor/silver_full_plate.gif', 'Silver Full Plate', 'Silver Full Plate', 7, 0, 0, 0, 100, 100, 100, 3, 400, 0, 14, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (21, 1, 1232, 4, 7, 200, 200, 'armor/shadow_full_plate.gif', 'Shadow Full Plate', 'Shadow Full Plate', 7, 0, 0, 0, 100, 100, 100, 3, 400, 0, 14, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (22, 1, 441, 2, 7, 200, 200, 'armor/ruby_full_plate.gif', 'Ruby Full Plate', 'Ruby Full Plate', 7, 0, 0, 0, 100, 100, 100, 3, 400, 0, 14, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (23, 1, 2310, 6, 6, 175, 175, 'armor/saphire_full_plate.gif', 'Saphire Full Plate', 'Saphire Full Plate', 7, 0, 0, 0, 100, 100, 100, 3, 400, 0, 12, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (24, 1, 2310, 6, 6, 175, 175, 'armor/emerald_full_plate.gif', 'Emerald Full Plate', 'Emerald Full Plate', 7, 0, 0, 0, 100, 100, 100, 3, 400, 0, 12, 0, 0, 0, 10, 0, 0, 0, '0');
INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_thief_karma, item_thief_karma_fail, item_zone, item_zone_name) VALUES (26, 1, 1981, 6, 5, 150, 150, 'armor/gold_chest_plate.gif', 'Gold Chest Plate', 'Gold Chest Plate', 7, 0, 0, 0, 100, 100, 100, 3, 300, 0, 10, 0, 0, 0, 10, 0, 0, 0, '0');

# Item Qualities
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (0, 0, 'Adr_dont_care');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (1, 20, 'Adr_items_quality_very_poor');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (2, 50, 'Adr_items_quality_poor');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (3, 100, 'Adr_items_quality_medium');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (4, 140, 'Adr_items_quality_good');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (5, 200, 'Adr_items_quality_very_good');
INSERT INTO phpbb_adr_shops_items_quality (item_quality_id, item_quality_modifier_price, item_quality_lang) VALUES (6, 300, 'Adr_items_quality_excellent');

# Item Types
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (0, 0, 'Adr_dont_care');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (1, 3, 'Adr_items_type_raw_materials');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (2, 5, 'Adr_items_type_rare_raw_materials');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (3, 100, 'Adr_items_type_tools_pickaxe');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (4, 100, 'Adr_items_type_tools_magictome');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (5, 100, 'Adr_items_type_weapon');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (6, 1000, 'Adr_items_type_enchanted_weapon');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (7, 200, 'Adr_items_type_armor');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (8, 100, 'Adr_items_type_buckler');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (9, 75, 'Adr_items_type_helm');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (29, 150, 'Adr_items_type_greave');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (30, 50, 'Adr_items_type_boot');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (10, 50, 'Adr_items_type_gloves');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (11, 50, 'Adr_items_type_magic_attack');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (12, 50, 'Adr_items_type_magic_defend');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (13, 7000, 'Adr_items_type_amulet');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (14, 6000, 'Adr_items_type_ring');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (15, 20, 'Adr_items_type_health_potion');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (16, 20, 'Adr_items_type_mana_potion');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (17, 1, 'Adr_items_type_misc');

# Skills
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (1, 'Adr_mining', 'Adr_skill_mining_desc', 'skill_mining.gif', 80, 1);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (2, 'Adr_stone', 'Adr_skill_stone_desc', 'skill_stone.gif', 90, 1);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (3, 'Adr_forge', 'Adr_skill_forge_desc', 'skill_forge.gif', 35, 1);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (4, 'Adr_enchantment', 'Adr_skill_enchantment_desc', 'skill_enchantment.gif', 40, 1);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (5, 'Adr_trading', 'Adr_skill_trading_desc', 'skill_trading.gif', 125, 1);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (6, 'Adr_thief', 'Adr_skill_thief_desc', 'skill_thief.gif', 25, 1);

# Stores
INSERT INTO phpbb_adr_stores (store_id, store_name, store_desc, store_img, store_status, store_sales_status, store_admin, store_owner_id, store_owner_img, store_owner_speech) VALUES (1, 'The Bards Shop', 'For all your Bards needs', 'Forum.gif', 1, 0, 0, 1, 'Forum.gif', 'Is there a particular instrument you prefer?');
INSERT INTO phpbb_adr_stores (store_id, store_name, store_desc, store_img, store_status, store_sales_status, store_admin, store_owner_id, store_owner_img, store_owner_speech) VALUES (2, 'Admin Only Store', 'Viewable only by the board admin', '', 1, 0, 1, 1, '', '');
INSERT INTO phpbb_adr_stores (store_id, store_name, store_desc, store_img, store_status, store_sales_status, store_admin, store_owner_id, store_owner_img, store_owner_speech) VALUES (3, 'The Grey Dwarf''s Armory', 'Get your quality armor here.', 'minning.gif', 1, 0, 0, 1, 'minning.gif', 'Armor made in the best Dwarven Forges around.');

# Zones
INSERT INTO `phpbb_adr_zones` (`zone_id`, `zone_name`, `zone_desc`, `zone_img`, `zone_element`, `zone_item`, `cost_goto1`, `cost_goto2`, `cost_goto3`, `cost_goto4`, `cost_return`, `goto1_id`, `goto2_id`, `goto3_id`, `goto4_id`, `return_id`, `zone_shops`, `zone_forge`, `zone_prison`, `zone_temple`, `zone_bank`, `zone_event1`, `zone_event2`, `zone_event3`, `zone_event4`, `zone_event5`, `zone_event6`, `zone_event7`, `zone_event8`, `zone_pointwin1`, `zone_pointwin2`, `zone_pointloss1`, `zone_pointloss2`, `zone_chance`, `zone_mine`, `zone_enchant`, `zone_monsters_list`, `zone_level`) VALUES
(1, 'World Map', 'Map of the World', 'World.gif', 'Earth', '0', 0, 0, 0, 0, 0, '', '', '', '', 'World Map', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0),
(2, 'Suzail', 'Suzail is the royal capital and richest city of the kingdom of Cormyr', 'cormyr', 'Feu', '0', 0, 0, 0, 0, 0, 0, 3, 5, 0, 'Kings Forest', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 10, 20, 10, 20, 20, 1, 1, '1338', 0),
(3, 'Marsember', 'Marsember is the second largest city in the kingdom of Cormyr', 'Marsember', 'Fire', '0', 10, 10, 10, 10, 10, 0, 0, 0, '', 2, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 5, 100, 2, 100, 500, 0, 0, '', 5),
(4, 'Kings Forest', 'This forest is owned by the crown and is rich in game and wildlife', 'Kings_Forest', 'Earth', '0', 0, 0, 0, 0, 0, 5, 2, '', 8, '', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 5, 50, 5, 50, 80, 0, 0, '', 0),
(5, 'Eastern Cormyr Crossroads', 'Eastern Cormyr crossroads', 'Cormyr_Crossroads', 'Earth', '0', 0, 0, 50, 0, 0, 4, '', 8, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 5, 100, 5, 100, 80, 0, 0, '', 0),
(6, 'Arabel', 'Arabel is a fortified city with though it has mant posts for tradeing', 'Arabel', 'Holy', '0', 0, 0, 0, 0, 0, 2, 1, '', 3, 7, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 5, 100, 5, 100, 80, 0, 0, '', 0),
(7, 'Tilverton', 'Tilverton is a small city and is in a strategic location for the kingdom of Cormyr', 'Tilverton', 'Unholy', '0', 0, 0, 0, 0, 0, 1, 2, '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 100, 5, 100, 50, 0, 0, '', 0),
(8, 'Hullack Forest', 'One of the large remaining shards of the great woods that was Cormanthor.', 'Hullack_Forest', 'Air', '0', 0, 0, 0, 0, 0, 1, '', '', 3, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 5, 50, 5, 50, 10, 0, 0, '', 0);

# Rabbitoshi pets
INSERT INTO phpbb_rabbitoshi_config (creature_id, creature_name, creature_prize, creature_power, creature_magicpower, creature_armor, creature_max_hunger, creature_max_thirst, creature_max_health, creature_mp_max, creature_max_hygiene, creature_food_id, creature_buyable, creature_evolution_of, creature_img, creature_experience_max, creature_max_attack, creature_max_magicattack) VALUES (3, 'Wolf', 500, 0, 0, 0, 15, 15, 15, 6, 15, 3, 1, 0, 'wolfpup.gif', 250, 2, 0);
INSERT INTO phpbb_rabbitoshi_config (creature_id, creature_name, creature_prize, creature_power, creature_magicpower, creature_armor, creature_max_hunger, creature_max_thirst, creature_max_health, creature_mp_max, creature_max_hygiene, creature_food_id, creature_buyable, creature_evolution_of, creature_img, creature_experience_max, creature_max_attack, creature_max_magicattack) VALUES (4, 'Rabbit', 100, 0, 0, 0, 15, 15, 15, 6, 15, 2, 1, 0, 'Rabbit.gif', 250, 2, 0);
INSERT INTO phpbb_rabbitoshi_config (creature_id, creature_name, creature_prize, creature_power, creature_magicpower, creature_armor, creature_max_hunger, creature_max_thirst, creature_max_health, creature_mp_max, creature_max_hygiene, creature_food_id, creature_buyable, creature_evolution_of, creature_img, creature_experience_max, creature_max_attack, creature_max_magicattack) VALUES (5, 'Fairy', 5000, 0, 1, 0, 20, 20, 20, 15, 25, 1, 1, 0, 'fairy38.gif', 250, 0, 2);
INSERT INTO phpbb_rabbitoshi_config (creature_id, creature_name, creature_prize, creature_power, creature_magicpower, creature_armor, creature_max_hunger, creature_max_thirst, creature_max_health, creature_mp_max, creature_max_hygiene, creature_food_id, creature_buyable, creature_evolution_of, creature_img, creature_experience_max, creature_max_attack, creature_max_magicattack) VALUES (6, 'Phoenix', 1000, 0, 0, 1, 20, 20, 20, 10, 20, 4, 1, 0, 'ph2.gif', 250, 1, 1);

# Rabbitoshi config
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('thirst_time', 43200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('thirst_value', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hunger_time', 43200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hunger_value', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hygiene_time', 43200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hygiene_value', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_time', 43200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_value', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('rebirth_enable', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('rebirth_price', 0);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('vet_enable', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('vet_price', 100);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hotel_enable', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hotel_cost', 10);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('evolution_enable', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('evolution_cost', 200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('evolution_time', 25);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('exp_lose', 5);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_price', 75);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hunger_price', 20);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('thirst_price', 20);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hygiene_price', 20);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('level_price', 1500);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('power_price', 330);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicpower_price', 280);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('armor_price', 750);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('attack_price', 225);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicattack_price', 200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mp_price', 30);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hunger_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('thirst_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hygiene_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('power_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicpower_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('armor_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('attack_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicattack_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mp_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('level_raise', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('experience_min', 5);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('experience_max', 20);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mp_min', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mp_max', 5);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('attack_reload', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magic_reload', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_level', 12);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_magicpower', 25);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_mp', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_mp_need', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_hp_give', 3);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('regeneration_price', 1500);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_transfert_level', 24);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_transfert_magicpower', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_transfert_health', 200);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_transfert_percent', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_transfert_price', 2500);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mana_transfert_level', 24);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mana_transfert_magicpower', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mana_transfert_mp', 100);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mana_transfert_percent', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mana_transfert_price', 2500);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('sacrifice_level', 48);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('sacrifice_power', 100);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('sacrifice_armor', 50);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('sacrifice_mp', 100);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('sacrifice_price', 5000);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('health_levelup', 5);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hunger_levelup', 2);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('thirst_levelup', 2);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('hygiene_levelup', 2);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('power_levelup', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicpower_levelup', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('armor_levelup', 0);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('mp_levelup', 3);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('attack_levelup', 1);
INSERT INTO phpbb_rabbitoshi_general (config_name, config_value) VALUES ('magicattack_levelup', 1);

# Adr general config
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_version', '0.4.5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_seasons', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_seasons_time', '86400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_seasons_last_time', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('zone_bonus_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('zone_bonus_att', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('zone_bonus_def', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('zone_dead_travel', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_use', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_time', '86400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_last_change', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_experience_for_new', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_experience_for_reply', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_experience_for_edit', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_topics_display', '1-1-0-0-0-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_profile_display', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_time_start', 'time()');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_character_age', '16');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_skill_sp_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_character_sp_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_thief_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_thief_points', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_warehouse_duration', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_shop_duration', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_warehouse_tax', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_shop_tax', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rabbitoshi_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rabbitoshi_name', 'Rabbistoshi');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rabbitoshi_enable_cron', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rabbitoshi_cron_time', '86400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rabbitoshi_cron_last_time', '0');

# ADR 0.4
UPDATE phpbb_adr_characters SET character_limit_update = 0; 

# ADR 0.4.1
UPDATE phpbb_adr_general SET `config_value` = '0' WHERE `config_name` = 'Adr_disable_rpg';
UPDATE phpbb_adr_stores SET store_status = 1;
UPDATE phpbb_adr_stores SET store_sales_status = 0;

# ADR 0.4.2
UPDATE phpbb_adr_general SET `config_value` = '0' WHERE `config_name` = 'Adr_disable_rpg';

UPDATE phpbb_adr_battle_list SET battle_text = '' WHERE battle_result != 0;
UPDATE phpbb_adr_battle_pvp SET battle_text = '' WHERE battle_result != 3;

# ADR 0.4.4
UPDATE phpbb_adr_shops_items SET item_element_str_dmg = 100, item_element_same_dmg = 100, item_element_weak_dmg = 100 WHERE item_element = 0; 

INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_sell', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_min_lvl', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_show', 0);

# ADR - Advanced NPC System Expansion
UPDATE `phpbb_adr_npc` SET `npc_class` = '0';
UPDATE `phpbb_adr_npc` SET `npc_race` = '0';
UPDATE `phpbb_adr_npc` SET `npc_character_level` = '0';
UPDATE `phpbb_adr_npc` SET `npc_element` = '0';
UPDATE `phpbb_adr_npc` SET `npc_alignment` = '0';
UPDATE `phpbb_adr_npc` SET `npc_visit_prerequisite` = '0';
UPDATE `phpbb_adr_npc` SET `npc_quest_prerequisite` = '0';
UPDATE `phpbb_adr_npc` SET `npc_view` = '0';
INSERT INTO `phpbb_adr_general` VALUES ('npc_image_size', 75);
INSERT INTO `phpbb_adr_general` VALUES ('npc_image_count', 10);
INSERT INTO `phpbb_adr_general` VALUES ('npc_display_enable', 1);
INSERT INTO `phpbb_config` VALUES ('zone_adr_moderators', '');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_member_pm', '2');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_ban_adr', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_ban_board', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_jail', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_time_day', '1');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_time_hour', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_time_minute', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_caution', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_freeable', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_cautionable', '0');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_punishment', '1');
INSERT INTO `phpbb_config` VALUES ('zone_cheat_auto_public', '0');
INSERT INTO `phpbb_adr_general` VALUES ('npc_display_text', 1);
INSERT INTO `phpbb_adr_general` VALUES ('npc_image_link', 1);
INSERT INTO `phpbb_adr_general` VALUES ('npc_button_link', 1);

# ADR - Brewing
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (7, 'Adr_brewing', 'Adr_skill_brewing_desc', 'skill_brewing.gif', 50, 5);

INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (18, 50, 'Adr_items_type_tools_brewing');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (19, 50, 'Adr_items_type_potion');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (20, 50, 'Adr_items_type_recipe');

# ADR - Cooking
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (55, 50, 'Adr_items_type_tools_cooking');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (94, 50, 'Adr_items_type_food');
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (12, 'Adr_cooking', 'Adr_skill_cooking_desc', 'skill_cooking.gif', 50, 5);

# ADR - Blacksmithing
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (13, 'Adr_blacksmithing', 'Adr_skill_blacksmithing_desc', 'skill_blacksmithing.gif', 50, 5);
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (95, 100, 'Adr_items_type_tools_blacksmithing');

# ADR - Skills
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (8, 'Adr_lumberjack', 'Adr_skill_lumberjack_desc', 'skill_lumberjack.gif', 100, 5);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (9, 'Adr_tailoring', 'Adr_skill_tailoring_desc', 'skill_tailoring.gif', 100, 5);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (10, 'Adr_herbalism', 'Adr_skill_herbalism_desc', 'skill_herbalism.gif', 100, 5);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (11, 'Adr_hunting', 'Adr_skill_hunting_desc', 'skill_hunting.gif', 100, 50);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (14, 'Adr_alchemy', 'Adr_skill_alchemy_desc', 'skill_alchemy.gif', 100, 5);
INSERT INTO phpbb_adr_skills (skill_id, skill_name, skill_desc, skill_img, skill_req, skill_chance) VALUES (15, 'Adr_fishing', 'Adr_skill_fishing_desc', 'skill_fishing.gif', 100, 5);

INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (22, 50, 'Adr_items_type_tools_needle');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (23, 50, 'Adr_items_type_clothes');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (24, 50, 'Adr_items_type_thread');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (25, 50, 'Adr_items_type_tools_seed');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (26, 50, 'Adr_items_type_plants');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (27, 50, 'Adr_items_type_water');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (28, 50, 'Adr_items_type_tools_hunting');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (31, 50, 'Adr_items_type_wood');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (32, 50, 'Adr_items_type_tools_pole');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (33, 50, 'Adr_items_type_fish');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (34, 17, 'Adr_items_type_tools_alchemy');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (35, 517, 'Adr_items_type_alchemy');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (36, 150, 'Adr_items_type_animals');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (37, 50, 'Adr_items_type_tools_woodworking');

# ADR - Advanced Spells
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (107, 1, 'Adr_items_type_spell_attack');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (108, 1, 'Adr_items_type_magic_heal');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (109, 1, 'Adr_items_type_spell_defend');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (110, 50, 'Adr_items_type_spell_recipe');


# ADR - Dynamic Town Map
#INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (297, 'TowerHill', '', 'zone 1', 0, '', 'zone 1', '', 101, 0);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (298, 'battlearena_1', '', 'Battle Arena', 0, '', 'adr_battle', '', 15, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (300, 'Battle2', '', 'Battle Arena 2', 0, '', 'adr_battle', '', 15, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (301, 'Cauldron', '', 'Magical Cauldron', 0, '', 'adr_cauldron', '', 2, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (302, 'compass', '', 'Compass1', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (303, 'compass2', '', 'Compass2', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (304, 'compass3', '', 'Compass3', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (305, 'dirt1', '', 'Dirt Patch', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (306, 'dragon', '', 'Dragon Image', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (307, 'Exit1', '', 'Exit Tower', 0, '', 'index', '', 25, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (308, 'Forge1', '', 'Forge', 0, '', 'adr_TownMap_forge', '', 20, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (309, 'Forge2', '', 'Forge 2', 0, '', 'adr_TownMap_forge', '', 20, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (310, 'hill1', '', 'Hill', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (313, 'Info1', '', 'Tower of Knowledge', 0, '', 'adr_library', '', 5, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (314, 'inn_1', '', 'Village Inn', 0, '', 'adr_guilds', '', 19, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (315, 'INN2', '', 'Village Inn 2', 0, '', 'adr_guilds', '', 19, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (316, 'jail1', '', 'Prison', 0, '', 'adr_courthouse', '', 14, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (317, 'jail2', '', 'Prison 2', 0, '', 'adr_courthouse', '', 14, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (318, 'magic1', '', 'Tower of Magic', 0, '', '', '', 12, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (319, 'magic2', '', 'Tower of Magic 2', 0, '', '', '', 10, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (320, 'mine1', '', 'Mines', 0, '', 'adr_mine', '', 11, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (321, 'mine2', '', 'Mines 2', 0, '', '', 'adr_mine', 11, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (322, 'mountain1_01', '', 'Mountain-Left Top', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (323, 'mountain1_02', '', 'Mountain-Right Top', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (324, 'mountain1_03', '', 'Mountain-Left Bottom', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (325, 'mountain1_04', '', 'Mountain-Right Bottom', 0, '', '', '', 999, 2);
-- INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (326, 'pond1', '', 'Pond', 0, '', '', '', 999, 2);
-- INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (328, 'SMpond', '', 'Pond', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (329, 'shop1', '', 'Shop', 0, '', 'adr_shops', '', 26, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (330, 'shop2', '', 'Shop 2', 0, '', 'adr_shops', '', 26, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (331, 'shop3', '', 'Shop 3', 0, '', 'adr_shops', '', 26, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (332, 'shrub', '', 'Shrubs', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (333, 'statue', '', 'Statue', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (335, 'Tavern2', '', 'Taverne des guildes #2', 0, '', 'adr_guilds', '', 0, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (336, 'Temple1', '', 'Temple', 0, '', 'adr_temple', '', 27, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (337, 'Temple2', '', 'Temple 2', 0, '', 'adr_temple', '', 27, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (338, 'Tower1', '', 'Tower', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (339, 'castle2', '', 'Castle', 0, '', '', '', 999, 0);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (342, 'Trees1', '', 'Trees 1', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (343, 'Trees2', '', 'Trees 2', 0, '', '', '', 999, 2);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (344, 'trees3', '', 'Trees 3', 0, '', '', '', 999, 2);

# V: let's get TownMap-y :D
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (299, 'bank_1', '', 'Town Bank', 0, '', 'adr_TownMap_Banque', '', 18, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (311, 'Home1', '', 'Character Home', 0, '', 'adr_TownMap_Maison', '', 4, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (312, 'Home2', '', 'Character Home 2', 0, '', 'adr_TownMap_Maison', '', 4, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (327, 'Rune1', '', 'Rune Stone', 0, '', 'adr_TownMap_pierrerunique', '', 12, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (334, 'Tavern1', '', 'Clans', 0, '', 'adr_clans', '', 59, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (340, 'Training1', '', 'Training Grounds', 0, '', 'adr_TownMap_Entrainement', '', 16, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (341, 'Training2', '', 'Training Grounds2', 0, '', 'adr_TownMap_Entrainement', '', 16, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (345, 'warehouse1', '', 'Character Warehouse', 0, '', 'adr_TownMap_Entrepot', '', 42, 1);
# V: and now, let's add other pages ...
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (346, 'alchemy', '', 'Alchemy', 0, '', 'adr_alchemy', '', 28, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (347, 'beggar', '', 'Beggar Donation', 0, '', 'adr_beggar', '', 29, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (348, 'smithy', '', 'Blacksmithing', 0, '', 'adr_blacksmithing', '', 30, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (349, 'brewing', '', 'Brewing', 0, '', 'adr_brewing', '', 31, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (350, 'farmhouse', '', 'Cooking', 0, '', 'adr_cooking', '', 32, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (351, 'enchant', '', 'Enchant', 0, '', 'adr_enchant', '', 33, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (352, 'fish', '', 'Fishing', 0, '', 'adr_fish', '', 34, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (353, 'herbal', '', 'Herbalism', 0, '', 'adr_herbal', '', 35, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (354, 'hunting', '', 'Hunting', 0, '', 'adr_hunting', '', 36, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (355, 'magic_lake', '', 'Magic Lake', 0, '', 'adr_lake', '', 37, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (356, 'jobs', '', 'Jobs', 0, '', 'adr_jobs', '', 38, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (357, 'lumberjack', '', 'Lumberjacking', 0, '', 'adr_lumberjack', '', 39, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (358, 'party', '', 'Party', 0, '', 'adr_party', '', 40, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (359, 'tailor', '', 'Tailoring', 0, '', 'adr_tailor', '', 41, 1);
INSERT INTO phpbb_adr_zone_buildings (id, name, shop, sdesc, record_id, type, zone_link, zone_name_tag, zone_building_tag_no, zone_building_type) VALUES (359, 'Headquarters', '', 'Headquarters', 0, '', 'adr_clans', '', 59, 1);

INSERT INTO phpbb_adr_zone_maps (zone_id, zonemap_type, zone_world, zonemap_buildings) VALUES (1, 1, 1, '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~zone 1~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Castle~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
INSERT INTO phpbb_adr_zone_maps (zone_id, zonemap_type, zone_world, zonemap_buildings) VALUES (2, 2, 0, '~~~~~~~~~~~~~~Temple~~~Mines~~~~~Town Bank~~~~~~~~~Trees 3~~~Shop~~Battle Arena 2~~~~~Character Warehouse~Trees 2~~Statue~Taverne~~~~~~~Forge~~~~Character Home~~~~~~~~~Pond~Mountain-Left Top~Mountain-Right Top~~~~Trees 1~Village Inn~~~~Mountain-Left Bottom~Mountain-Right Bottom~Magical Cauldron~~~~~~Exit Tower~~Tower of Knowledge~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');

INSERT INTO `phpbb_adr_zone_townmaps` (`zonemap_type`, `zonemap_name`, `zonemap_bg`, `zonemap_width`, `zonemap_cellwidth`, `zonemap_cellwidthnumber`, `zonemap_height`, `zonemap_cellheight`, `zonemap_cellheightnumber`, `zonemap_building`) VALUES
(1, 'World Map', 'World.gif', 900, 44, 20, 750, 45, 16, ',22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,242,246,247,248,249,250,251,252,253,254,255,256,257,258,259,262,266,267,268,269,270,271,272,273,274,275,276,283,284,292,293,294,295'),
(2, 'Small Town', 'ZoneMap_1.gif', 484, 48, 10, 470, 47, 10, ',12,13,14,15,16,17,18,22,23,24,25,26,27,28,29,32,33,34,35,36,37,38,39,42,43,44,45,46,47,48,49,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,72,73,74,75,76,77,78,79,85,87,88'),
(3, 'Champs avec pont', 'ZoneMap_2.gif', 484, 48, 10, 470, 47, 10, ',18,19,42,43,52,53,54,58,59,62,63,64,65,66,67,68,69,72,73,74,75,76,77,78,79,82,83,84,85,86,87,88'),
(4, 'Lopin de terre dans un précipice', 'ZoneMap_3.gif', 382, 42, 9, 476, 45, 11, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(5, 'Forêt dense', 'ZoneMap_4.gif', 484, 48, 10, 470, 47, 10, ',12,13,14,15,16,17,18,19,22,23,24,25,26,27,28,29,32,33,34,35,36,37,38,39,42,43,44,45,46,47,48,49,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,72,73,74,75,76,77,78,79,82,83,84,85,86,87,88,89'),
(6, 'Champs', 'ZoneMap_6.gif', 484, 48, 10, 470, 47, 10, ',12,13,14,15,16,17,18,19,22,23,24,25,26,27,28,29,32,33,34,35,36,37,38,39,42,43,44,45,46,47,48,49,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,72,73,74,75,76,77,78,79,82,83,84,85,86,87,88'),
(7, 'Vue du dessus avec haut droit/bas gauche gris', 'ZoneMap_6.gif', 484, 48, 10, 470, 47, 10, ',12,13,14,22,23,24,25,32,33,34,35,36,42,43,44,45,46,47,48,49,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,72,73,74,75,76,77,78,79,85,86,87,88'),
(8, 'Marecages', 'ZoneMap_7.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(9, 'Herbe avec routes', 'ZoneMap_8.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(10, 'Herbe avec une route verticale', 'ZoneMap_9.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(11, 'Herbe avec une route horizontale', 'ZoneMap_10.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(12, 'Vague', 'ZoneMap_11.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(13, 'Eau avec geyser', 'ZoneMap_12.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(14, 'Sol pourpre', 'ZoneMap_13.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(15, 'Barque dans la brume', 'ZoneMap_14.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(16, 'Neige', 'ZoneMap_15.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(17, 'Sol violet', 'ZoneMap_16.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(18, 'Tourbillon', 'ZoneMap_17.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80'),
(19, 'Foret de cote', 'ZoneMap_18.gif', 484, 48, 10, 470, 47, 10, ',11,12,13,14,15,16,17,20,21,22,23,24,25,26,29,30,31,32,33,34,35,38,39,40,41,42,43,44,47,48,49,50,51,52,53,56,57,58,59,60,61,62,65,66,67,68,69,70,71,74,75,76,77,78,79,80');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_zone_townmap_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_zone_townmap_name', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_zone_picture_link', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_zone_worldmap_zone', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_zone_townmap_display_required', '1');

INSERT INTO phpbb_adr_shops_items (item_id, item_owner_id, item_price, item_quality, item_power, item_duration, item_duration_max, item_icon, item_name, item_desc, item_type_use, item_in_shop, item_mp_use, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_store_id, item_weight, item_auth, item_max_skill, item_add_power, item_monster_thief, item_in_warehouse, item_sell_back_percentage, item_zone, item_zone_name) VALUES (6765, 1, 5000, 3, 1, 2, 3, 'scroll5.gif', 'Adr_items_scroll_5', 'Adr_items_scroll_5_desc', 4, 0, 0, 0, 0, 0, 0, 8, 1, 0, 0, 0, 0, 0, 75, 0, '');

# ADR - Spell advanced - upgrade
INSERT INTO `phpbb_adr_general` VALUES ('spell_enable_pm', '1');

# ADR - Day & Night
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_time', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_length_time', '10800');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_time_last_time', '0');

# ADR - Weapon Proficiency
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (40, 2000, 'Adr_items_type_staff');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (41, 2000, 'Adr_items_type_dirk');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (42, 2000, 'Adr_items_type_mace');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (43, 2000, 'Adr_items_type_ranged');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (44, 2000, 'Adr_items_type_fist');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (45, 2000, 'Adr_items_type_axe');
INSERT INTO phpbb_adr_shops_items_type (item_type_id, item_type_base_price, item_type_lang) VALUES (46, 2000, 'Adr_items_type_spear');

# ADR - Shield prof
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('weapon_prof', 100);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('shield_bonus', 10);

# ADR - Togglable World Map
INSERT INTO phpbb_config (config_name, config_value) VALUES ('adr_world_map', 0);

# Rabbitoshi - levelup penalty
INSERT INTO `phpbb_rabbitoshi_general` VALUES ('next_level_penalty', 10);

# ADR - Guild mod (Renlok)
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_overall_allow', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_allow', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_join_allow', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_posts', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_level', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_money', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_guild_exp_min', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('battle_guild_exp_max', 100);



COMMIT;
