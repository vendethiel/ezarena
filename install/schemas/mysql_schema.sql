#
# phpBB2 - MySQL schema
#
# $Id: mysql_schema.sql,v 1.35.2.12 2006/02/06 21:32:42 grahamje Exp $
#

# --------------------------------------------------------
#
# Table structure for table 'phpbb_announcement_centre'
#
CREATE TABLE phpbb_announcement_centre (
  announcement_desc varchar(255) NOT NULL default '',
  announcement_value text NOT NULL,
  PRIMARY KEY  (announcement_desc)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_blocs'
#
CREATE TABLE phpbb_areabb_blocs (
	id_bloc int(11) NOT NULL auto_increment,
	id_feuille int(11) NOT NULL default '0',
	id_mod int(11) default '0',
	type_mod varchar(5) default NULL,
	PRIMARY KEY  (id_bloc)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_blocs_html'
#
CREATE TABLE phpbb_areabb_blocs_html (
	id_bloc tinyint(4) NOT NULL auto_increment,
	titre varchar(250) default NULL,
	message text,
	PRIMARY KEY  (id_bloc)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_categories'
#
CREATE TABLE phpbb_areabb_categories (
	arcade_catid smallint(6) NOT NULL auto_increment,
	arcade_parent int(11) NOT NULL default '0',
	arcade_cattitle varchar(100) NOT NULL default '',
	salle int(11) NOT NULL default '0',
	arcade_nbelmt mediumint(8) unsigned NOT NULL default '0',
	arcade_catorder mediumint(8) unsigned NOT NULL default '0',
	arcade_icone varchar(100) default NULL,
	KEY arcade_catid (arcade_catid)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_config'
#

CREATE TABLE phpbb_areabb_config (
	nom varchar(255) NOT NULL default '',
	valeur varchar(255) NOT NULL default '',
	PRIMARY KEY  (nom)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_feuille'
#
CREATE TABLE phpbb_areabb_feuille (
	id_feuille int(11) NOT NULL auto_increment,
	id_squelette int(11) NOT NULL default '0',
	id_modele int(11) NOT NULL default '0',
	position int(11) NOT NULL default '0',
	PRIMARY KEY  (id_feuille)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_games'
#
CREATE TABLE phpbb_areabb_games (
	game_id mediumint(8) NOT NULL auto_increment,
	game_pic varchar(50) NOT NULL default '',
	game_pic_large varchar(50) default NULL,
	game_desc varchar(255) NOT NULL default '',
	game_highscore int(11) NOT NULL default '0',
	game_highdate int(11) NOT NULL default '0',
	game_highuser mediumint(8) NOT NULL default '0',
	game_name varchar(50) NOT NULL default '',
	game_libelle varchar(50) NOT NULL default '',
	game_date int(11) NOT NULL default '0',
	game_swf varchar(50) NOT NULL default '',
	game_scorevar varchar(20) NOT NULL default '',
	game_type tinyint(4) NOT NULL default '0',
	game_width mediumint(5) NOT NULL default '550',
	game_height varchar(5) NOT NULL default '380',
	game_order mediumint(8) NOT NULL default '0',
	game_set mediumint(8) NOT NULL default '0',
	arcade_catid mediumint(8) unsigned NOT NULL default '0',
	game_cheat_control tinyint(1) NOT NULL default '0',
	note smallint(5) unsigned NOT NULL default '2',
	clics_pkg int(11) default '0',
	clics_zip int(11) default '0',
	KEY game_id (game_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_hackgame'
#
CREATE TABLE phpbb_areabb_hackgame (
	id_hack int(11) NOT NULL auto_increment,
	user_id mediumint(8) NOT NULL default '0',
	game_id mediumint(8) NOT NULL default '0',
	date_hack int(11) NOT NULL default '0',
	id_modo int(11) default NULL,
	flashtime int(11) default '0',
	realtime int(11) default '0',
	score float default '0',
	type int(11) NOT NULL default '0',
	PRIMARY KEY  (id_hack)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_liens'
#
CREATE TABLE phpbb_areabb_liens (
	id_lien smallint(6) NOT NULL auto_increment,
	titre varchar(255) NOT NULL,
	lien varchar(255) NOT NULL,
	ordre smallint(5) unsigned NOT NULL default '99',
	vignette varchar(255) default NULL,
	PRIMARY KEY  (id_lien)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_modeles'
#
CREATE TABLE phpbb_areabb_modeles (
	id_modele smallint(6) NOT NULL auto_increment,
	modele text NOT NULL,
	details varchar(200) default NULL,
	PRIMARY KEY  (id_modele)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_mods'
#
CREATE TABLE phpbb_areabb_mods (
	id_mod int(11) NOT NULL auto_increment,
	nom varchar(150) NOT NULL default '',
	affiche tinyint(1) NOT NULL default '0',
	page varchar(250) NOT NULL default '',
	PRIMARY KEY  (id_mod)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_note'
#
CREATE TABLE phpbb_areabb_note (
	game_id smallint(6) NOT NULL default '0',
	user_id smallint(6) NOT NULL default '0',
	note tinyint(4) NOT NULL default '0'
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_scores'
#
CREATE TABLE phpbb_areabb_scores (
	game_id mediumint(8) NOT NULL default '0',
	user_id mediumint(8) NOT NULL default '0',
	score_game int(11) unsigned NOT NULL default '0',
	score_date int(11) NOT NULL default '0',
	score_time int(11) NOT NULL default '0',
	score_set mediumint(8) NOT NULL default '0',
	KEY game_id (game_id),
	KEY user_id (user_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_areabb_squelette'
#
CREATE TABLE phpbb_areabb_squelette (
	id_squelette tinyint(4) NOT NULL auto_increment,
	titre varchar(250) default NULL,
	groupes varchar(250) default NULL,
	type smallint(6) NOT NULL default '0',
	position int(11) NOT NULL default '0',
	PRIMARY KEY  (id_squelette)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_auth_access'
#
CREATE TABLE phpbb_auth_access (
   group_id mediumint(8) DEFAULT '0' NOT NULL,
   forum_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   auth_view tinyint(1) DEFAULT '0' NOT NULL,
   auth_read tinyint(1) DEFAULT '0' NOT NULL,
   auth_post tinyint(1) DEFAULT '0' NOT NULL,
   auth_reply tinyint(1) DEFAULT '0' NOT NULL,
   auth_edit tinyint(1) DEFAULT '0' NOT NULL,
   auth_delete tinyint(1) DEFAULT '0' NOT NULL,
   auth_sticky tinyint(1) DEFAULT '0' NOT NULL,
   auth_announce tinyint(1) DEFAULT '0' NOT NULL,
   auth_vote tinyint(1) DEFAULT '0' NOT NULL,
   auth_pollcreate tinyint(1) DEFAULT '0' NOT NULL,
   auth_mod tinyint(1) DEFAULT '0' NOT NULL,
   auth_ban tinyint(1) NOT NULL default '0',
   auth_greencard tinyint(1) NOT NULL default '0',
   auth_bluecard tinyint(1) NOT NULL default '0',
   auth_download TINYINT(1) DEFAULT '0' NOT NULL,
   auth_attachments TINYINT(1) DEFAULT '0' NOT NULL,
   KEY group_id (group_id),
   KEY forum_id (forum_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_banlist'
#
CREATE TABLE phpbb_banlist (
   ban_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   ban_userid mediumint(8) NOT NULL,
   ban_ip char(8) NOT NULL,
   ban_email varchar(255),
   PRIMARY KEY (ban_id),
   KEY ban_ip_user_id (ban_ip, ban_userid)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_bbc_box'
#
CREATE TABLE phpbb_bbc_box (
	bbc_id smallint(5) unsigned NOT NULL auto_increment,
	bbc_name varchar(255) NOT NULL,
	bbc_value varchar(255) NOT NULL,
	bbc_auth varchar(255) NOT NULL,
	bbc_before varchar(255) NOT NULL,
	bbc_after varchar(255) NOT NULL,
	bbc_helpline varchar(255) NOT NULL,
	bbc_img varchar(255) NOT NULL,
	bbc_divider varchar(255) NOT NULL,
	bbc_order mediumint(8) DEFAULT '1' NOT NULL,
	PRIMARY KEY (bbc_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_categories'
#
CREATE TABLE phpbb_categories (
   cat_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   cat_title varchar(100),
   cat_order mediumint(8) UNSIGNED NOT NULL,
   PRIMARY KEY (cat_id),
   KEY cat_order (cat_order)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_clicks'
#
CREATE TABLE phpbb_clicks (
  id mediumint(6) unsigned NOT NULL auto_increment,
  url varchar(255) NOT NULL default '',
  clicks decimal(6,0) unsigned NOT NULL default '0',
  UNIQUE KEY id (id),
  KEY md5 (url)
)  ;


# --------------------------------------------------------
#
# Table structure for table 'phpbb_config'
#
CREATE TABLE phpbb_config (
    config_name varchar(255) NOT NULL,
    config_value varchar(255) NOT NULL,
    PRIMARY KEY (config_name)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_confirm'
#
CREATE TABLE phpbb_confirm (
  confirm_id char(32) DEFAULT '' NOT NULL,
  session_id char(32) DEFAULT '' NOT NULL,
  code char(6) DEFAULT '' NOT NULL, 
  PRIMARY KEY  (session_id,confirm_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_disallow'
#
CREATE TABLE phpbb_disallow (
   disallow_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   disallow_username varchar(25) DEFAULT '' NOT NULL,
   PRIMARY KEY (disallow_id)
);



# --------------------------------------------------------
#
# Table structure for table 'phpbb_forums'
#
CREATE TABLE phpbb_forums (
   forum_id smallint(5) UNSIGNED NOT NULL,
   cat_id mediumint(8) UNSIGNED NOT NULL,
   forum_name varchar(150),
   forum_desc text,
   forum_status tinyint(4) DEFAULT '0' NOT NULL,
   forum_order mediumint(8) UNSIGNED DEFAULT '1' NOT NULL,
   forum_posts mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   forum_topics mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   forum_last_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   prune_next int(11),
   prune_enable tinyint(1) DEFAULT '0' NOT NULL,
   auth_view tinyint(2) DEFAULT '0' NOT NULL,
   auth_read tinyint(2) DEFAULT '0' NOT NULL,
   auth_post tinyint(2) DEFAULT '0' NOT NULL,
   auth_reply tinyint(2) DEFAULT '0' NOT NULL,
   auth_edit tinyint(2) DEFAULT '0' NOT NULL,
   auth_delete tinyint(2) DEFAULT '0' NOT NULL,
   auth_sticky tinyint(2) DEFAULT '0' NOT NULL,
   auth_announce tinyint(2) DEFAULT '0' NOT NULL,
   auth_vote tinyint(2) DEFAULT '0' NOT NULL,
   auth_pollcreate tinyint(2) DEFAULT '0' NOT NULL,
   forum_parent mediumint(8) DEFAULT '0' NOT NULL,
   auth_ban tinyint(2) NOT NULL default '3',
   auth_greencard tinyint(2) NOT NULL default '5',
   auth_bluecard tinyint(2) NOT NULL default '1',
   forum_qpes tinyint(1) NOT NULL default '1',
   points_disabled TINYINT(1) NOT NULL,
   forum_external tinyint(1) NOT NULL default '0',
   forum_redirect_url text,
   forum_ext_newwin tinyint(1) NOT NULL default '0',
   forum_ext_image text,
   forum_redirects_user mediumint(8) UNSIGNED NOT NULL default '0',
   forum_redirects_guest mediumint(8) UNSIGNED NOT NULL default '0',
   forum_icon VARCHAR( 255 ) default NULL,
   forum_enter_limit MEDIUMINT(8) unsigned default '0',
   forum_password varchar(20) NOT NULL DEFAULT '',
   forum_display_sort TINYINT(1) NOT NULL,
   forum_display_order TINYINT(1) NOT NULL,
   forum_desc_long TEXT,
   auth_attachments TINYINT(2) DEFAULT '0' NOT NULL,
   auth_download TINYINT(2) DEFAULT '0' NOT NULL,
   PRIMARY KEY (forum_id),
   KEY forums_order (forum_order),
   KEY cat_id (cat_id),
   KEY forum_last_post_id (forum_last_post_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_forum_prune'
#
CREATE TABLE phpbb_forum_prune (
   prune_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   forum_id smallint(5) UNSIGNED NOT NULL,
   prune_days smallint(5) UNSIGNED NOT NULL,
   prune_freq smallint(5) UNSIGNED NOT NULL,
   PRIMARY KEY(prune_id),
   KEY forum_id (forum_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_ggs_config'
#
CREATE TABLE phpbb_ggs_config(
config_name varchar(255) NOT NULL,
config_value varchar(255) NOT NULL, 
PRIMARY KEY (config_name)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_groups'
#
CREATE TABLE phpbb_groups (
   group_id mediumint(8) NOT NULL auto_increment,
   group_type tinyint(4) DEFAULT '1' NOT NULL,
   group_name varchar(40) NOT NULL,
   group_description varchar(255) NOT NULL,
   group_moderator mediumint(8) DEFAULT '0' NOT NULL,
   group_single_user tinyint(1) DEFAULT '1' NOT NULL,
   group_color mediumint(8) DEFAULT '0' NOT NULL,
   PRIMARY KEY (group_id),
   KEY group_single_user (group_single_user)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_guests_visit'
#
CREATE TABLE phpbb_guests_visit (
  guest_time INT( 11 ) NOT NULL DEFAULT '0',
  guest_visit INT( 11 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  ( guest_time )
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_ip_tracking_config'
#
CREATE TABLE phpbb_ip_tracking_config (
	max INT(15) NOT NULL default '0'
	);

	
# --------------------------------------------------------
#
# Table structure for table 'phpbb_ip_tracking'
#	
CREATE TABLE phpbb_ip_tracking (
	ip varchar(15) NOT NULL default '',
	time int(11) NOT NULL default '0',
	located varchar(255) NOT NULL default '',
	referer varchar(255) NOT NULL,
	username varchar(50) NOT NULL default ''
	);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_logos'
#
CREATE TABLE phpbb_logos ( 
  logo_id int(10) unsigned NOT NULL auto_increment, 
  adresse varchar(100) default NULL, 
  proba float unsigned default '0', 
  selected tinyint(3) unsigned NOT NULL default '0', 
  date_select int(10) unsigned NOT NULL default '0', 
  PRIMARY KEY  (logo_id) 
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_posts'
#
CREATE TABLE phpbb_posts (
   post_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   topic_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   forum_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   poster_id mediumint(8) DEFAULT '0' NOT NULL,
   post_time int(11) DEFAULT '0' NOT NULL,
   post_created int(11) DEFAULT '0' NOT NULL,
   poster_ip char(8) NOT NULL,
   post_username varchar(25),
   enable_bbcode tinyint(1) DEFAULT '1' NOT NULL,
   enable_html tinyint(1) DEFAULT '0' NOT NULL,
   enable_smilies tinyint(1) DEFAULT '1' NOT NULL,
   enable_sig tinyint(1) DEFAULT '1' NOT NULL,
   post_edit_time int(11),
   post_edit_count smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   post_bluecard tinyint(1) default NULL,
   post_attachment TINYINT(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (post_id),
   KEY forum_id (forum_id),
   KEY topic_id (topic_id),
   KEY poster_id (poster_id),
   KEY post_time (post_time)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_posts_text'
#
CREATE TABLE phpbb_posts_text (
   post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   bbcode_uid char(10) DEFAULT '' NOT NULL,
   post_subject char(60),
   post_text text,
   post_sub_title VARCHAR(255) DEFAULT NULL,
   PRIMARY KEY (post_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_privmsgs'
#
CREATE TABLE phpbb_privmsgs (
   privmsgs_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   privmsgs_type tinyint(4) DEFAULT '0' NOT NULL,
   privmsgs_subject varchar(255) DEFAULT '0' NOT NULL,
   privmsgs_from_userid mediumint(8) DEFAULT '0' NOT NULL,
   privmsgs_to_userid mediumint(8) DEFAULT '0' NOT NULL,
   privmsgs_date int(11) DEFAULT '0' NOT NULL,
   privmsgs_ip char(8) NOT NULL,
   privmsgs_enable_bbcode tinyint(1) DEFAULT '1' NOT NULL,
   privmsgs_enable_html tinyint(1) DEFAULT '0' NOT NULL,
   privmsgs_enable_smilies tinyint(1) DEFAULT '1' NOT NULL,
   privmsgs_attach_sig tinyint(1) DEFAULT '1' NOT NULL,
   privmsgs_attachment TINYINT(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (privmsgs_id),
   KEY privmsgs_from_userid (privmsgs_from_userid),
   KEY privmsgs_to_userid (privmsgs_to_userid)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_privmsgs_text'
#
CREATE TABLE phpbb_privmsgs_text (
   privmsgs_text_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   privmsgs_bbcode_uid char(10) DEFAULT '0' NOT NULL,
   privmsgs_text text,
   PRIMARY KEY (privmsgs_text_id)
);

# --------------------------------------------------------
#
# Table structure for table 'phpbb_quicklinks'
#	
CREATE TABLE phpbb_quicklinks (
  word_id mediumint(8) unsigned NOT NULL auto_increment,
  word char(100) NOT NULL default '',
  replacement char(255) NOT NULL default '',
  PRIMARY KEY  (word_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_ranks'
#
CREATE TABLE phpbb_ranks (
   rank_id smallint(5) UNSIGNED NOT NULL auto_increment,
   rank_title varchar(50) NOT NULL,
   rank_min mediumint(8) DEFAULT '0' NOT NULL,
   rank_special tinyint(1) DEFAULT '0',
   rank_image varchar(255),
   rank_tags TEXT NOT NULL DEFAULT '',
   PRIMARY KEY (rank_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_rcs'
#
CREATE TABLE phpbb_rcs (
	rcs_id mediumint(8) UNSIGNED NOT NULL auto_increment,
	rcs_name varchar(50) DEFAULT '' NOT NULL,
	rcs_color varchar(6) DEFAULT '' NOT NULL,
	rcs_single tinyint(1) DEFAULT '0' NOT NULL,
	rcs_display tinyint(1) DEFAULT '0' NOT NULL,
	rcs_order mediumint(8) UNSIGNED NOT NULL,
	PRIMARY KEY (rcs_id)
);


# --------------------------------------------------------
#
# Table structure for table `phpbb_search_results`
#
CREATE TABLE phpbb_search_results (
  search_id int(11) UNSIGNED NOT NULL default '0',
  session_id char(32) NOT NULL default '',
  search_time int(11) DEFAULT '0' NOT NULL,
  search_array text NOT NULL,
  PRIMARY KEY  (search_id),
  KEY session_id (session_id)
);


# --------------------------------------------------------
#
# Table structure for table `phpbb_search_wordlist`
#
CREATE TABLE phpbb_search_wordlist (
  word_text varchar(50) binary NOT NULL default '',
  word_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  word_common tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY (word_text),
  KEY word_id (word_id)
);

# --------------------------------------------------------
#
# Table structure for table `phpbb_search_wordmatch`
#
CREATE TABLE phpbb_search_wordmatch (
  post_id mediumint(8) UNSIGNED NOT NULL default '0',
  word_id mediumint(8) UNSIGNED NOT NULL default '0',
  title_match tinyint(1) NOT NULL default '0',
  KEY post_id (post_id),
  KEY word_id (word_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_sessions'
#
# Note that if you're running 3.23.x you may want to make
# this table a type HEAP. This type of table is stored
# within system memory and therefore for big busy boards
# is likely to be noticeably faster than continually
# writing to disk ...
#
CREATE TABLE phpbb_sessions (
   session_id char(32) DEFAULT '' NOT NULL,
   session_user_id mediumint(8) DEFAULT '0' NOT NULL,
   session_start int(11) DEFAULT '0' NOT NULL,
   session_time int(11) DEFAULT '0' NOT NULL,
   session_ip char(8) DEFAULT '0' NOT NULL,
   session_page int(11) DEFAULT '0' NOT NULL,
   session_logged_in tinyint(1) DEFAULT '0' NOT NULL,
   session_admin tinyint(2) DEFAULT '0' NOT NULL,
   session_agent TEXT NOT NULL,
   areabb_tps_depart INT( 11 ),
   areabb_gid INT( 11 ),
   areabb_variable VARCHAR( 50 ),
   PRIMARY KEY (session_id),
   KEY session_user_id (session_user_id),
   KEY session_id_ip_user_id (session_id, session_ip, session_user_id)
);

# --------------------------------------------------------
#
# Table structure for table `phpbb_sessions_keys`
#
CREATE TABLE phpbb_sessions_keys (
  key_id varchar(32) DEFAULT '0' NOT NULL,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  last_ip varchar(8) DEFAULT '0' NOT NULL,
  last_login int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (key_id, user_id),
  KEY last_login (last_login)
);


# --------------------------------------------------------
#
# Table structure for table `phpbb_shout`
#
CREATE TABLE phpbb_shout (
	shout_id MEDIUMINT(8) UNSIGNED NOT NULL auto_increment, 
	shout_username VARCHAR(25) NOT NULL, 
	shout_user_id MEDIUMINT(8) NOT NULL, 
	shout_group_id MEDIUMINT(8) NOT NULL,
	shout_session_time INT(11) NOT NULL, 
	shout_ip CHAR(8) NOT NULL, 
	shout_text TEXT NOT NULL, 
	shout_active MEDIUMINT(8) NOT NULL, 
	enable_bbcode TINYINT (1) NOT NULL,
	enable_html TINYINT (1) NOT NULL,
	enable_smilies TINYINT (1) NOT NULL,
	enable_sig TINYINT (1) NOT NULL,
	shout_bbcode_uid VARCHAR(10) NOT NULL,
	INDEX (shout_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_smilies'
#
CREATE TABLE phpbb_smilies (
   smilies_id smallint(5) UNSIGNED NOT NULL auto_increment,
   code varchar(50),
   smile_url varchar(100),
   emoticon varchar(75),
   PRIMARY KEY (smilies_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_themes'
#
CREATE TABLE phpbb_themes (
   themes_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   template_name varchar(30) NOT NULL default '',
   style_name varchar(30) NOT NULL default '',
   head_stylesheet varchar(100) default NULL,
   body_background varchar(100) default NULL,
   body_bgcolor varchar(6) default NULL,
   body_text varchar(6) default NULL,
   body_link varchar(6) default NULL,
   body_vlink varchar(6) default NULL,
   body_alink varchar(6) default NULL,
   body_hlink varchar(6) default NULL,
   tr_color1 varchar(6) default NULL,
   tr_color2 varchar(6) default NULL,
   tr_color3 varchar(6) default NULL,
   tr_class1 varchar(25) default NULL,
   tr_class2 varchar(25) default NULL,
   tr_class3 varchar(25) default NULL,
   th_color1 varchar(6) default NULL,
   th_color2 varchar(6) default NULL,
   th_color3 varchar(6) default NULL,
   th_class1 varchar(25) default NULL,
   th_class2 varchar(25) default NULL,
   th_class3 varchar(25) default NULL,
   td_color1 varchar(6) default NULL,
   td_color2 varchar(6) default NULL,
   td_color3 varchar(6) default NULL,
   td_class1 varchar(25) default NULL,
   td_class2 varchar(25) default NULL,
   td_class3 varchar(25) default NULL,
   fontface1 varchar(50) default NULL,
   fontface2 varchar(50) default NULL,
   fontface3 varchar(50) default NULL,
   fontsize1 tinyint(4) default NULL,
   fontsize2 tinyint(4) default NULL,
   fontsize3 tinyint(4) default NULL,
   fontcolor1 varchar(6) default NULL,
   fontcolor2 varchar(6) default NULL,
   fontcolor3 varchar(6) default NULL,
   span_class1 varchar(25) default NULL,
   span_class2 varchar(25) default NULL,
   span_class3 varchar(25) default NULL,
   rcs_admincolor varchar(6) DEFAULT '' NOT NULL,
   rcs_modcolor varchar(6) DEFAULT '' NOT NULL,
   rcs_usercolor varchar(6) DEFAULT '' NOT NULL,
   img_size_poll smallint(5) UNSIGNED,
   img_size_privmsg smallint(5) UNSIGNED,
   PRIMARY KEY  (themes_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_themes_name'
#
CREATE TABLE phpbb_themes_name (
   themes_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   tr_color1_name char(50),
   tr_color2_name char(50),
   tr_color3_name char(50),
   tr_class1_name char(50),
   tr_class2_name char(50),
   tr_class3_name char(50),
   th_color1_name char(50),
   th_color2_name char(50),
   th_color3_name char(50),
   th_class1_name char(50),
   th_class2_name char(50),
   th_class3_name char(50),
   td_color1_name char(50),
   td_color2_name char(50),
   td_color3_name char(50),
   td_class1_name char(50),
   td_class2_name char(50),
   td_class3_name char(50),
   fontface1_name char(50),
   fontface2_name char(50),
   fontface3_name char(50),
   fontsize1_name char(50),
   fontsize2_name char(50),
   fontsize3_name char(50),
   fontcolor1_name char(50),
   fontcolor2_name char(50),
   fontcolor3_name char(50),
   span_class1_name char(50),
   span_class2_name char(50),
   span_class3_name char(50),
   PRIMARY KEY (themes_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_topics'
#
CREATE TABLE phpbb_topics (
   topic_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   forum_id smallint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_title char(60) NOT NULL,
   topic_poster mediumint(8) DEFAULT '0' NOT NULL,
   topic_time int(11) DEFAULT '0' NOT NULL,
   topic_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_replies mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_status tinyint(3) DEFAULT '0' NOT NULL,
   topic_vote tinyint(1) DEFAULT '0' NOT NULL,
   topic_type tinyint(3) DEFAULT '0' NOT NULL,
   topic_first_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_last_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_moved_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   topic_sub_title VARCHAR(255) DEFAULT NULL,
   topic_attachment TINYINT(1) DEFAULT '0' NOT NULL,
   topic_attribute VARCHAR(25),
   PRIMARY KEY (topic_id),
   KEY forum_id (forum_id),
   KEY topic_moved_id (topic_moved_id),
   KEY topic_status (topic_status),
   KEY topic_type (topic_type)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_topics_watch'
#
CREATE TABLE phpbb_topics_watch (
  topic_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  user_id mediumint(8) NOT NULL DEFAULT '0',
  notify_status tinyint(1) NOT NULL default '0',
  KEY topic_id (topic_id),
  KEY user_id (user_id),
  KEY notify_status (notify_status)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_users'
#
CREATE TABLE phpbb_users (
   user_id mediumint(8) NOT NULL,
   user_active tinyint(1) DEFAULT '1',
   username varchar(25) NOT NULL,
   reponse_conf VARCHAR(255),
   user_password varchar(32) NOT NULL,
   user_session_time int(11) DEFAULT '0' NOT NULL,
   user_session_page smallint(5) DEFAULT '0' NOT NULL,
   user_lastvisit int(11) DEFAULT '0' NOT NULL,
   user_regdate int(11) DEFAULT '0' NOT NULL,
   user_level tinyint(4) DEFAULT '0',
   user_posts mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
   user_timezone decimal(5,2) DEFAULT '0' NOT NULL,
   user_style tinyint(4),
   user_lang varchar(255),
   user_dateformat varchar(14) DEFAULT 'd M Y H:i' NOT NULL,
   user_new_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   user_unread_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   user_last_privmsg int(11) DEFAULT '0' NOT NULL,
   user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   user_last_login_try int(11) DEFAULT '0' NOT NULL,
   user_emailtime int(11),
   user_viewemail tinyint(1),
   user_attachsig tinyint(1),
   user_allowhtml tinyint(1) DEFAULT '1',
   user_allowbbcode tinyint(1) DEFAULT '1',
   user_allowsmile tinyint(1) DEFAULT '1',
   user_allowavatar tinyint(1) DEFAULT '1' NOT NULL,
   user_allow_pm tinyint(1) DEFAULT '1' NOT NULL,
   user_allow_viewonline tinyint(1) DEFAULT '1' NOT NULL,
   user_notify tinyint(1) DEFAULT '1' NOT NULL,
   user_notify_pm tinyint(1) DEFAULT '0' NOT NULL,
   user_popup_pm tinyint(1) DEFAULT '0' NOT NULL,
   user_rank int(11) DEFAULT '0',
   user_avatar varchar(100),
   user_avatar_type tinyint(4) DEFAULT '0' NOT NULL,
   user_email varchar(255),
   user_icq varchar(15),
   user_website varchar(100),
   user_from varchar(100),
   user_sig text,
   user_sig_bbcode_uid char(10),
   user_aim varchar(255),
   user_yim varchar(255),
   user_msnm varchar(255),
   user_occ varchar(100),
   user_interests varchar(255),
   user_actkey varchar(32),
   user_newpasswd varchar(32),
   user_color mediumint(8) DEFAULT '0' NOT NULL,
   user_group_id mediumint(8) DEFAULT '0' NOT NULL,
   user_qp_settings varchar(25) NOT NULL default '1-0-1-1-1-1',
   user_birthday VARCHAR(10) NOT NULL DEFAULT '',
   user_zodiac TINYINT(2) NOT NULL DEFAULT '0',
   user_warnings smallint(5) default '0',
   user_flag varchar(100) DEFAULT '' NOT NULL,
   user_notify_donation TINYINT(1) NOT NULL,
   user_points INT NOT NULL,
   admin_allow_points TINYINT(1) DEFAULT '1',
   user_inactive_emls TINYINT( 1 ) NOT NULL,
   user_inactive_last_eml INT( 11 ) NOT NULL,
   user_colortext VARCHAR(10),
   user_gender tinyint(4) NOT NULL default '0',
   user_allowdefaultavatar TINYINT(1) DEFAULT '1' NOT NULL,
   user_use_rel_date TINYINT(1) UNSIGNED DEFAULT '1' NOT NULL,
   user_use_rel_time TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
   user_unread_topics TEXT,
   PRIMARY KEY (user_id),
   INDEX user_birthday (user_birthday),
   KEY user_session_time (user_session_time)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_user_group'
#
CREATE TABLE phpbb_user_group (
   group_id mediumint(8) DEFAULT '0' NOT NULL,
   group_moderator TINYINT(1) NOT NULL,
   user_id mediumint(8) DEFAULT '0' NOT NULL,
   user_pending tinyint(1),
   KEY group_id (group_id),
   KEY user_id (user_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_vote_desc'
#
CREATE TABLE phpbb_vote_desc (
  vote_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  topic_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_text text NOT NULL,
  vote_start int(11) NOT NULL DEFAULT '0',
  vote_length int(11) NOT NULL DEFAULT '0',
  vote_max INT( 3 ) DEFAULT '1' NOT NULL,
  vote_voted INT( 7 ) DEFAULT '0' NOT NULL,
  vote_hide TINYINT( 1 ) DEFAULT '0' NOT NULL,
  vote_tothide TINYINT( 1 ) DEFAULT '0' NOT NULL,
  PRIMARY KEY  (vote_id),
  KEY topic_id (topic_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_vote_results'
#
CREATE TABLE phpbb_vote_results (
  vote_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_option_id tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  vote_option_text varchar(255) NOT NULL,
  vote_result int(11) NOT NULL DEFAULT '0',
  KEY vote_option_id (vote_option_id),
  KEY vote_id (vote_id)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_vote_voters'
#
CREATE TABLE phpbb_vote_voters (
  vote_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_user_id mediumint(8) NOT NULL DEFAULT '0',
  vote_user_ip char(8) NOT NULL,
  vote_option_id mediumint( 8 ) NULL, 
  KEY vote_id (vote_id),
  KEY vote_user_id (vote_user_id),
  KEY vote_user_ip (vote_user_ip)
);


# --------------------------------------------------------
#
# Table structure for table 'phpbb_words'
#
CREATE TABLE phpbb_words (
   word_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   word char(100) NOT NULL,
   replacement char(100) NOT NULL,
   PRIMARY KEY (word_id)
);


#
# !!! ATTACH MOD
#

CREATE TABLE phpbb_attachments_config (
  config_name varchar(255) NOT NULL,
  config_value varchar(255) NOT NULL,
  PRIMARY KEY (config_name)
);

CREATE TABLE phpbb_forbidden_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment, 
  extension varchar(100) NOT NULL, 
  PRIMARY KEY (ext_id)
);

CREATE TABLE phpbb_extension_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name char(20) NOT NULL,
  cat_id tinyint(2) DEFAULT '0' NOT NULL, 
  allow_group tinyint(1) DEFAULT '0' NOT NULL,
  download_mode tinyint(1) UNSIGNED DEFAULT '1' NOT NULL,
  upload_icon varchar(100) DEFAULT '',
  max_filesize int(20) DEFAULT '0' NOT NULL,
  forum_permissions varchar(255) default '' NOT NULL,
  PRIMARY KEY group_id (group_id)
);

CREATE TABLE phpbb_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  group_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  extension varchar(100) NOT NULL,
  comment varchar(100),
  PRIMARY KEY ext_id (ext_id)
);

CREATE TABLE phpbb_attachments_desc (
  attach_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  physical_filename varchar(255) NOT NULL,
  real_filename varchar(255) NOT NULL,
  download_count mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  comment varchar(255),
  extension varchar(100),
  mimetype varchar(100),
  filesize int(20) NOT NULL,
  filetime int(11) DEFAULT '0' NOT NULL,
  thumbnail tinyint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (attach_id),
  KEY filetime (filetime),
  KEY physical_filename (physical_filename(10)),
  KEY filesize (filesize)
);

CREATE TABLE phpbb_attachments (
  attach_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL, 
  post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL, 
  privmsgs_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  user_id_1 mediumint(8) NOT NULL,
  user_id_2 mediumint(8) NOT NULL,
  KEY attach_id_post_id (attach_id, post_id),
  KEY attach_id_privmsgs_id (attach_id, privmsgs_id),
  KEY post_id (post_id),
  KEY privmsgs_id (privmsgs_id)
); 

CREATE TABLE phpbb_quota_limits (
  quota_limit_id mediumint(8) unsigned NOT NULL auto_increment,
  quota_desc varchar(20) NOT NULL default '',
  quota_limit bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (quota_limit_id)
);

CREATE TABLE phpbb_attach_quota (
  user_id mediumint(8) unsigned NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '0',
  quota_type smallint(2) NOT NULL default '0',
  quota_limit_id mediumint(8) unsigned NOT NULL default '0',
  KEY quota_type (quota_type)
);

#
# QTE
#
CREATE TABLE phpbb_attributes (
  attribute_id INT(11) NOT NULL auto_increment,
  attribute_type SMALLINT(1) NOT NULL DEFAULT '0',
  attribute VARCHAR(255) NOT NULL DEFAULT '',
  attribute_image VARCHAR(255) NOT NULL DEFAULT '',
  attribute_color VARCHAR(6) NOT NULL DEFAULT '',
  attribute_date_format VARCHAR(25) DEFAULT NULL,
  attribute_position TINYINT(1) NOT NULL DEFAULT '0',
  attribute_administrator TINYINT(1) DEFAULT '0',
  attribute_moderator TINYINT(1) DEFAULT '0',
  attribute_author TINYINT(1) DEFAULT '0',
  attribute_order INT(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (attribute_id)
);

#
# ADR
#
CREATE TABLE phpbb_adr_alignments (
  alignment_id smallint(8) NOT NULL default '0',
  alignment_name varchar(255) NOT NULL default '',
  alignment_desc text NOT NULL,
  alignment_level tinyint(1) NOT NULL default '0',
  alignment_img varchar(255) NOT NULL default '',
  alignment_karma_min int(10) NOT NULL default '0',
  alignment_karma_type tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (alignment_id)
) ;

CREATE TABLE phpbb_adr_armour_sets (
  set_id int(8) NOT NULL auto_increment,
  set_name varchar(50) NOT NULL default '',
  set_desc text NOT NULL,
  set_img varchar(50) NOT NULL default '',
  set_helm varchar(255) NOT NULL default '',
  set_armour varchar(255) NOT NULL default '',
  set_gloves varchar(255) NOT NULL default '',
  set_greave varchar(255) NOT NULL default '',
  set_boot varchar(255) NOT NULL default '',
  set_shield varchar(255) NOT NULL default '',
  set_hp_max_bonus int(8) NOT NULL default '0',
  set_mp_max_bonus int(8) NOT NULL default '0',
  set_might_bonus int(8) NOT NULL default '0',
  set_constitution_bonus int(8) NOT NULL default '0',
  set_ac_bonus int(8) NOT NULL default '0',
  set_dexterity_bonus int(8) NOT NULL default '0',
  set_intelligence_bonus int(8) NOT NULL default '0',
  set_wisdom_bonus int(8) NOT NULL default '0',
  set_hp_max_penalty int(8) NOT NULL default '0',
  set_mp_max_penalty int(8) NOT NULL default '0',
  set_might_penalty int(8) NOT NULL default '0',
  set_constitution_penalty int(8) NOT NULL default '0',
  set_ac_penalty int(8) NOT NULL default '0',
  set_dexterity_penalty int(8) NOT NULL default '0',
  set_intelligence_penalty int(8) NOT NULL default '0',
  set_wisdom_penalty int(8) NOT NULL default '0',
  PRIMARY KEY  (set_id)
) ;

CREATE TABLE phpbb_adr_battle_list (
  battle_id int(8) NOT NULL auto_increment,
  battle_type tinyint(1) NOT NULL default '0',
  battle_turn tinyint(1) NOT NULL default '0',
  battle_result tinyint(1) NOT NULL default '0',
  battle_text text NOT NULL,
  battle_challenger_id int(8) NOT NULL default '0',
  battle_challenger_hp int(8) NOT NULL default '0',
  battle_challenger_mp int(8) NOT NULL default '0',
  battle_challenger_att int(8) NOT NULL default '0',
  battle_challenger_def int(8) NOT NULL default '0',
  battle_challenger_magic_attack int(8) NOT NULL default '0',
  battle_challenger_magic_resistance int(8) NOT NULL default '0',
  battle_challenger_dmg int(8) NOT NULL default '0',
  battle_challenger_element int(3) NOT NULL default '0',
  battle_opponent_id int(8) NOT NULL default '0',
  battle_opponent_hp int(8) NOT NULL default '0',
  battle_opponent_mp int(8) NOT NULL default '0',
  battle_opponent_att int(8) NOT NULL default '0',
  battle_opponent_def int(8) NOT NULL default '0',
  battle_opponent_magic_attack int(8) NOT NULL default '0',
  battle_opponent_magic_resistance int(8) NOT NULL default '0',
  battle_opponent_mp_power int(8) NOT NULL default '0',
  battle_opponent_mp_max int(8) NOT NULL default '0',
  battle_opponent_sp int(12) NOT NULL default '0',
  battle_opponent_dmg int(8) NOT NULL default '0',
  battle_opponent_hp_max int(8) NOT NULL default '0',
  battle_opponent_element int(3) NOT NULL default '0',
  battle_bkg text NOT NULL,
  battle_challenger_armour_set varchar(50) NOT NULL default '',
  battle_challenger_armour_id int(8) NOT NULL default '0',
  battle_challenger_buckler_id int(8) NOT NULL default '0',
  battle_challenger_gloves_id int(8) NOT NULL default '0',
  battle_challenger_greave_id int(8) NOT NULL default '0',
  battle_challenger_boot_id int(8) NOT NULL default '0',
  battle_challenger_helm_id int(8) NOT NULL default '0',
  battle_challenger_ring_id int(8) NOT NULL default '0',
  battle_challenger_ring_power int(8) NOT NULL default '0',
  battle_challenger_amulet_id int(8) NOT NULL default '0',
  battle_challenger_amulet_power int(8) NOT NULL default '0',
  battle_opponent_karma int(10) NOT NULL default '0',
  battle_challenger_intelligence int(8) NOT NULL default '0',
  battle_opponent_message_enable int(1) NOT NULL default '0',
  battle_opponent_message varchar(255) NOT NULL default '',
  battle_opponent_item varchar(255) NOT NULL default '0',
  PRIMARY KEY  (battle_id)
) ;

CREATE TABLE phpbb_adr_battle_monsters (
  monster_id int(8) NOT NULL auto_increment,
  monster_name varchar(255) NOT NULL default '',
  monster_img varchar(255) NOT NULL default '',
  monster_level int(8) NOT NULL default '0',
  monster_base_hp int(8) NOT NULL default '0',
  monster_base_att int(8) NOT NULL default '0',
  monster_base_def int(8) NOT NULL default '0',
  monster_base_mp int(8) NOT NULL default '0',
  monster_base_custom_spell varchar(255) NOT NULL default 'a magical spell',
  monster_base_magic_attack int(8) NOT NULL default '0',
  monster_base_magic_resistance int(8) NOT NULL default '0',
  monster_base_mp_power int(8) NOT NULL default '1',
  monster_base_sp int(8) NOT NULL default '0',
  monster_thief_skill int(3) NOT NULL default '0',
  monster_base_element int(3) NOT NULL default '1',
  monster_base_karma int(10) NOT NULL default '0',
  monster_area int(8) NOT NULL default '0',
  monster_season int(8) NOT NULL default '0',
  monster_weather int(8) NOT NULL default '0',
  monster_message_enable int(1) NOT NULL default '0',
  monster_message varchar(255) NOT NULL default '',
  monster_area_name varchar(255) NOT NULL default '0',
  PRIMARY KEY  (monster_id)
) ;

CREATE TABLE phpbb_adr_battle_pvp (
  battle_id int(8) NOT NULL auto_increment,
  battle_turn int(8) NOT NULL default '0',
  battle_result tinyint(1) NOT NULL default '0',
  battle_text text NOT NULL,
  battle_text_chat text NOT NULL,
  battle_challenger_id int(8) NOT NULL default '0',
  battle_challenger_att int(8) NOT NULL default '0',
  battle_challenger_def int(8) NOT NULL default '0',
  battle_challenger_hp int(8) NOT NULL default '0',
  battle_challenger_mp int(8) NOT NULL default '0',
  battle_challenger_hp_max int(8) NOT NULL default '0',
  battle_challenger_mp_max int(8) NOT NULL default '0',
  battle_challenger_hp_regen int(8) NOT NULL default '0',
  battle_challenger_mp_regen int(8) NOT NULL default '0',
  battle_opponent_id int(8) NOT NULL default '0',
  battle_opponent_att int(8) NOT NULL default '0',
  battle_opponent_def int(8) NOT NULL default '0',
  battle_opponent_hp int(8) NOT NULL default '0',
  battle_opponent_mp int(8) NOT NULL default '0',
  battle_opponent_hp_max int(8) NOT NULL default '0',
  battle_opponent_mp_max int(8) NOT NULL default '0',
  battle_opponent_hp_regen int(8) NOT NULL default '0',
  battle_opponent_mp_regen int(8) NOT NULL default '0',
  battle_bkg text NOT NULL,
  battle_challenger_magic_attack int(8) NOT NULL default '0',
  battle_challenger_magic_resistance int(8) NOT NULL default '0',
  battle_opponent_magic_attack int(8) NOT NULL default '0',
  battle_opponent_magic_resistance int(8) NOT NULL default '0',
  battle_challenger_dmg int(8) NOT NULL default '0',
  battle_opponent_dmg int(8) NOT NULL default '0',
  battle_challenger_element int(3) NOT NULL default '0',
  battle_opponent_element int(3) NOT NULL default '0',
  battle_challenger_armour_set varchar(50) NOT NULL default '',
  battle_opponent_armour_set varchar(50) NOT NULL default '',
  PRIMARY KEY  (battle_id)
) ;

CREATE TABLE phpbb_adr_beggar_donations (
  item_id int(8) NOT NULL default '0',
  item_chance tinyint(1) default NULL,
  item_owner_id tinyint(1) NOT NULL default '1',
  item_price int(8) NOT NULL default '0',
  item_quality int(8) NOT NULL default '0',
  item_power int(8) NOT NULL default '0',
  item_duration int(8) NOT NULL default '0',
  item_duration_max int(8) NOT NULL default '1',
  item_icon varchar(255) NOT NULL default '',
  item_name varchar(255) NOT NULL default '',
  item_desc varchar(255) NOT NULL default '',
  item_type_use int(8) NOT NULL default '16',
  item_weight int(12) NOT NULL default '25',
  item_max_skill int(8) NOT NULL default '25',
  item_add_power int(8) NOT NULL default '0',
  item_mp_use int(8) NOT NULL default '0',
  item_element int(4) NOT NULL default '0',
  item_element_str_dmg int(4) NOT NULL default '100',
  item_element_same_dmg int(4) NOT NULL default '100',
  item_element_weak_dmg int(4) NOT NULL default '100',
  item_sell_back_percentage int(3) NOT NULL default '10',
  KEY item_id (item_id)
) ;

CREATE TABLE phpbb_adr_beggar_tracker (
  track_id int(10) NOT NULL auto_increment,
  item_name varchar(100) default NULL,
  owner_name varchar(100) default NULL,
  donated int(12) default NULL,
  date int(12) default NULL,
  KEY track_id (track_id)
) ;

CREATE TABLE phpbb_adr_cauldron_pack (
  pack_id int(8) NOT NULL auto_increment,
  item1_name varchar(255) NOT NULL default '',
  item2_name varchar(255) NOT NULL default '',
  item3_name varchar(255) NOT NULL default '',
  itemwin_name varchar(255) NOT NULL default '',
  PRIMARY KEY  (pack_id)
) ;

CREATE TABLE phpbb_adr_characters (
  character_id int(8) NOT NULL default '0',
  character_name varchar(255) NOT NULL default '',
  character_desc text NOT NULL,
  character_race int(8) NOT NULL default '0',
  character_class int(8) NOT NULL default '0',
  character_alignment int(8) NOT NULL default '0',
  character_element int(8) NOT NULL default '0',
  character_hp int(8) NOT NULL default '0',
  character_hp_max int(8) NOT NULL default '0',
  character_mp int(8) NOT NULL default '0',
  character_mp_max int(8) NOT NULL default '0',
  character_ac int(8) NOT NULL default '0',
  character_xp int(11) NOT NULL default '0',
  character_level int(8) NOT NULL default '1',
  character_might int(8) NOT NULL default '0',
  character_dexterity int(8) NOT NULL default '0',
  character_constitution int(8) NOT NULL default '0',
  character_intelligence int(8) NOT NULL default '0',
  character_wisdom int(8) NOT NULL default '0',
  character_charisma int(8) NOT NULL default '0',
  character_skill_mining int(3) unsigned NOT NULL default '0',
  character_skill_stone int(3) unsigned NOT NULL default '0',
  character_skill_forge int(3) unsigned NOT NULL default '0',
  character_skill_enchantment int(3) unsigned NOT NULL default '0',
  character_skill_trading int(3) unsigned NOT NULL default '0',
  character_skill_thief int(3) unsigned NOT NULL default '0',
  character_skill_mining_uses int(3) unsigned NOT NULL default '0',
  character_skill_stone_uses int(3) unsigned NOT NULL default '0',
  character_skill_forge_uses int(3) unsigned NOT NULL default '0',
  character_skill_enchantment_uses int(3) unsigned NOT NULL default '0',
  character_skill_trading_uses int(3) unsigned NOT NULL default '0',
  character_skill_thief_uses int(3) unsigned NOT NULL default '0',
  character_victories int(8) NOT NULL default '0',
  character_defeats int(8) NOT NULL default '0',
  character_flees int(8) NOT NULL default '0',
  prefs_pvp_notif_pm tinyint(1) NOT NULL default '1',
  prefs_pvp_allow tinyint(1) NOT NULL default '1',
  equip_armor int(8) NOT NULL default '0',
  equip_buckler int(8) NOT NULL default '0',
  equip_helm int(8) NOT NULL default '0',
  equip_greave int(8) NOT NULL default '0',
  equip_boot int(8) NOT NULL default '0',
  equip_gloves int(8) NOT NULL default '0',
  equip_amulet int(8) NOT NULL default '0',
  equip_ring int(8) NOT NULL default '0',
  character_birth int(12) NOT NULL default '1093694853',
  character_battle_limit int(3) NOT NULL default '20',
  character_skill_limit int(3) NOT NULL default '30',
  character_trading_limit int(3) NOT NULL default '30',
  character_thief_limit int(3) NOT NULL default '10',
  character_sp int(12) NOT NULL default '0',
  character_warehouse tinyint(1) NOT NULL default '0',
  character_warehouse_update int(8) NOT NULL default '0',
  character_shop_update int(8) NOT NULL default '0',
  character_pref_give_pm int(1) NOT NULL default '1',
  character_pref_seller_pm int(1) NOT NULL default '1',
  character_double_ko int(8) NOT NULL default '0',
  character_limit_update int(8) NOT NULL default '0',
  character_job_pm tinyint(1) NOT NULL default '1',
  character_job_id int(5) NOT NULL default '0',
  character_job_start int(12) NOT NULL default '0',
  character_job_earned int(12) NOT NULL default '0',
  character_job_total_earned int(12) NOT NULL default '0',
  character_job_times_employed smallint(5) NOT NULL default '0',
  character_job_completed int(8) NOT NULL default '0',
  character_job_incomplete int(8) NOT NULL default '0',
  character_guild_id int(5) NOT NULL default '0',
  character_guild_auth_id tinyint(1) NOT NULL default '0',
  character_guild_approval int(8) NOT NULL default '0',
  character_guild_hops int(5) NOT NULL default '0',
  character_guild_join_date int(12) NOT NULL default '0',
  character_guild_prefs_notify tinyint(1) NOT NULL default '1',
  character_job_end int(12) NOT NULL default '0',
  character_job_last_paid int(12) NOT NULL default '0',
  character_event_limit int(3) NOT NULL default '30',
  character_karma_good int(10) NOT NULL default '0',
  character_karma_bad int(10) NOT NULL default '0',
  character_area int(8) NOT NULL default '1',
  character_weather int(8) NOT NULL default '1',
  PRIMARY KEY  (character_id)
) ;

CREATE TABLE phpbb_adr_classes (
  class_id smallint(8) NOT NULL default '0',
  class_name varchar(255) NOT NULL default '',
  class_desc text NOT NULL,
  class_level tinyint(1) NOT NULL default '0',
  class_img varchar(255) NOT NULL default '',
  class_might_req int(8) NOT NULL default '0',
  class_dexterity_req int(8) NOT NULL default '0',
  class_constitution_req int(8) NOT NULL default '0',
  class_intelligence_req int(8) NOT NULL default '0',
  class_wisdom_req int(8) NOT NULL default '0',
  class_charisma_req int(8) NOT NULL default '0',
  class_base_hp int(8) NOT NULL default '0',
  class_base_mp int(8) NOT NULL default '0',
  class_base_ac int(8) NOT NULL default '0',
  class_update_hp int(8) NOT NULL default '0',
  class_update_mp int(8) NOT NULL default '0',
  class_update_ac int(8) NOT NULL default '0',
  class_update_xp_req int(8) NOT NULL default '0',
  class_update_of int(8) NOT NULL default '0',
  class_update_of_req int(8) NOT NULL default '0',
  class_selectable int(8) NOT NULL default '0',
  class_magic_attack_req int(8) NOT NULL default '0',
  class_magic_resistance_req int(8) NOT NULL default '0',
  PRIMARY KEY  (class_id)
) ;

CREATE TABLE phpbb_adr_create_exploit_fix (
  user_id int(10) NOT NULL default '0',
  power int(8) NOT NULL default '0',
  agility int(8) NOT NULL default '0',
  endurance int(8) NOT NULL default '0',
  intelligence int(8) NOT NULL default '0',
  willpower int(8) NOT NULL default '0',
  charm int(8) NOT NULL default '0',
  magic_attack int(8) NOT NULL default '0',
  magic_resistance int(8) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ;

CREATE TABLE phpbb_adr_elements (
  element_id smallint(8) NOT NULL default '0',
  element_name varchar(255) NOT NULL default '',
  element_desc text NOT NULL,
  element_level tinyint(1) NOT NULL default '0',
  element_img varchar(255) NOT NULL default '',
  element_skill_mining_bonus int(8) NOT NULL default '0',
  element_skill_stone_bonus int(8) NOT NULL default '0',
  element_skill_forge_bonus int(8) NOT NULL default '0',
  element_skill_enchantment_bonus int(8) NOT NULL default '0',
  element_skill_trading_bonus int(8) NOT NULL default '0',
  element_skill_thief_bonus int(8) NOT NULL default '0',
  element_oppose_strong int(3) NOT NULL default '0',
  element_oppose_strong_dmg int(3) NOT NULL default '100',
  element_oppose_same_dmg int(3) NOT NULL default '100',
  element_oppose_weak int(3) NOT NULL default '0',
  element_oppose_weak_dmg int(3) NOT NULL default '100',
  PRIMARY KEY  (element_id)
) ;

CREATE TABLE phpbb_adr_general (
  config_name varchar(255) NOT NULL default '0',
  config_value int(15) NOT NULL default '0',
  PRIMARY KEY  (config_name)
) ;

CREATE TABLE phpbb_adr_guilds (
  guild_id int(5) NOT NULL auto_increment,
  guild_name varchar(32) NOT NULL default '',
  guild_leader varchar(32) NOT NULL default '',
  guild_leader_id int(5) NOT NULL default '0',
  guild_date_created int(12) NOT NULL default '0',
  guild_description varchar(100) NOT NULL default '',
  guild_history mediumtext NOT NULL,
  guild_logo varchar(255) NOT NULL default '',
  guild_level int(5) NOT NULL default '1',
  guild_exp int(10) NOT NULL default '0',
  guild_exp_max int(10) NOT NULL default '1000',
  guild_vault int(12) NOT NULL default '0',
  guild_accept_new tinyint(1) NOT NULL default '0',
  guild_approve tinyint(1) NOT NULL default '1',
  guild_join_min_level int(5) NOT NULL default '1',
  guild_join_min_money int(8) NOT NULL default '0',
  guild_rank_leader varchar(25) NOT NULL default 'Guild Leader',
  guild_rank_1 varchar(25) NOT NULL default 'Guild Co-Leader',
  guild_rank_1_id int(5) NOT NULL default '0',
  guild_rank_2 varchar(25) NOT NULL default 'Guild Co-Leader',
  guild_rank_2_id int(5) NOT NULL default '0',
  guild_rank_3 varchar(25) NOT NULL default 'Guild Rank 3',
  guild_rank_3_id int(5) NOT NULL default '0',
  guild_rank_4 varchar(25) NOT NULL default 'Guild Rank 4',
  guild_rank_4_id int(5) NOT NULL default '0',
  guild_rank_5 varchar(25) NOT NULL default 'Guild Rank 5',
  guild_rank_5_id int(5) NOT NULL default '0',
  guild_rank_member varchar(25) NOT NULL default 'Guild Member',
  PRIMARY KEY  (guild_id)
) ;

CREATE TABLE phpbb_adr_jail_users (
  celled_id int(8) NOT NULL default '0',
  user_id int(8) NOT NULL default '0',
  user_cell_date int(11) NOT NULL default '0',
  user_freed_by int(8) NOT NULL default '0',
  user_sentence text,
  user_caution int(8) NOT NULL default '0',
  user_time int(11) NOT NULL default '0',
  PRIMARY KEY  (celled_id)
) ;

CREATE TABLE phpbb_adr_jail_votes (
  vote_id mediumint(8) NOT NULL default '0',
  voter_id mediumint(8) NOT NULL default '0',
  vote_result mediumint(8) NOT NULL default '0',
  KEY vote_id (vote_id),
  KEY voter_id (voter_id)
) ;

CREATE TABLE phpbb_adr_jobs (
  job_id smallint(5) NOT NULL auto_increment,
  job_name varchar(255) NOT NULL default '',
  job_desc text NOT NULL,
  job_class_id smallint(3) NOT NULL default '0',
  job_race_id smallint(3) NOT NULL default '0',
  job_alignment_id smallint(3) NOT NULL default '0',
  job_level smallint(3) NOT NULL default '1',
  job_auth_level tinyint(1) NOT NULL default '0',
  job_img varchar(255) NOT NULL default '',
  job_salary int(12) NOT NULL default '100',
  job_exp int(12) NOT NULL default '100',
  job_item_reward_id int(5) NOT NULL default '0',
  job_slots_available int(12) NOT NULL default '1',
  job_slots_max int(12) NOT NULL default '1',
  job_duration smallint(3) NOT NULL default '7',
  job_sp_reward int(12) NOT NULL default '0',
  job_payment_intervals smallint(2) NOT NULL default '1',
  PRIMARY KEY  (job_id)
) ;


CREATE TABLE phpbb_adr_lake_donations (
  item_id int(8) NOT NULL default '0',
  item_chance tinyint(1) default NULL,
  item_owner_id tinyint(1) NOT NULL default '1',
  item_price int(8) NOT NULL default '0',
  item_quality int(8) NOT NULL default '0',
  item_power int(8) NOT NULL default '0',
  item_duration int(8) NOT NULL default '0',
  item_duration_max int(8) NOT NULL default '1',
  item_icon varchar(255) NOT NULL default '',
  item_name varchar(255) NOT NULL default '',
  item_desc varchar(255) NOT NULL default '',
  item_type_use int(8) NOT NULL default '16',
  item_weight int(12) NOT NULL default '25',
  item_max_skill int(8) NOT NULL default '25',
  item_add_power int(8) NOT NULL default '0',
  item_mp_use int(8) NOT NULL default '0',
  item_element int(4) NOT NULL default '0',
  item_element_str_dmg int(4) NOT NULL default '100',
  item_element_same_dmg int(4) NOT NULL default '100',
  item_element_weak_dmg int(4) NOT NULL default '100',
  item_sell_back_percentage int(3) NOT NULL default '10',
  KEY item_id (item_id)
);

CREATE TABLE phpbb_adr_lake_tracker (
  track_id int(10) NOT NULL auto_increment,
  item_name varchar(100) default NULL,
  owner_name varchar(100) default NULL,
  donated int(12) default NULL,
  date int(12) default NULL,
  KEY track_id (track_id)
);

CREATE TABLE phpbb_adr_races (
  race_id smallint(8) NOT NULL default '0',
  race_name varchar(255) NOT NULL default '',
  race_desc text NOT NULL,
  race_level tinyint(1) NOT NULL default '0',
  race_img varchar(255) NOT NULL default '',
  race_might_bonus int(8) NOT NULL default '0',
  race_dexterity_bonus int(8) NOT NULL default '0',
  race_constitution_bonus int(8) NOT NULL default '0',
  race_intelligence_bonus int(8) NOT NULL default '0',
  race_wisdom_bonus int(8) NOT NULL default '0',
  race_charisma_bonus int(8) NOT NULL default '0',
  race_skill_mining_bonus int(8) NOT NULL default '0',
  race_skill_stone_bonus int(8) NOT NULL default '0',
  race_skill_forge_bonus int(8) NOT NULL default '0',
  race_skill_enchantment_bonus int(8) NOT NULL default '0',
  race_skill_trading_bonus int(8) NOT NULL default '0',
  race_skill_thief_bonus int(8) NOT NULL default '0',
  race_might_malus int(8) NOT NULL default '0',
  race_dexterity_malus int(8) NOT NULL default '0',
  race_constitution_malus int(8) NOT NULL default '0',
  race_intelligence_malus int(8) NOT NULL default '0',
  race_wisdom_malus int(8) NOT NULL default '0',
  race_charisma_malus int(8) NOT NULL default '0',
  race_magic_attack_bonus int(8) NOT NULL default '0',
  race_magic_resistance_bonus int(8) NOT NULL default '0',
  race_magic_attack_malus int(8) NOT NULL default '0',
  race_magic_resistance_malus int(8) NOT NULL default '0',
  race_weight int(12) NOT NULL default '1000',
  race_weight_per_level int(3) NOT NULL default '5',
  race_zone_begin int(8) NOT NULL default '1',
  race_zone_name varchar(255) NOT NULL default '',
  PRIMARY KEY  (race_id)
);

CREATE TABLE phpbb_adr_shops (
  shop_id int(8) NOT NULL default '0',
  shop_owner_id int(8) NOT NULL default '0',
  shop_name varchar(255) NOT NULL default '',
  shop_desc varchar(255) NOT NULL default '',
  shop_logo varchar(100) NOT NULL default '',
  PRIMARY KEY  (shop_id)
) ;

CREATE TABLE phpbb_adr_shops_items (
  item_id int(8) NOT NULL auto_increment,
  item_owner_id int(8) NOT NULL default '0',
  item_price int(8) NOT NULL default '0',
  item_quality int(8) NOT NULL default '0',
  item_power int(8) NOT NULL default '0',
  item_duration int(8) NOT NULL default '0',
  item_duration_max int(8) NOT NULL default '1',
  item_icon varchar(255) NOT NULL default '',
  item_name varchar(255) NOT NULL default '',
  item_desc varchar(255) NOT NULL default '',
  item_type_use int(8) NOT NULL default '16',
  item_in_shop tinyint(1) NOT NULL default '0',
  item_mp_use int(8) NOT NULL default '0',
  item_element int(4) NOT NULL default '0',
  item_element_str_dmg int(4) NOT NULL default '100',
  item_element_same_dmg int(4) NOT NULL default '100',
  item_element_weak_dmg int(4) NOT NULL default '100',
  item_store_id int(8) NOT NULL default '1',
  item_weight int(12) NOT NULL default '25',
  item_auth int(1) NOT NULL default '0',
  item_max_skill int(8) NOT NULL default '25',
  item_add_power int(8) NOT NULL default '0',
  item_monster_thief tinyint(1) NOT NULL default '0',
  item_in_warehouse tinyint(1) NOT NULL default '0',
  item_sell_back_percentage int(3) NOT NULL default '75',
  item_thief_karma int(5) NOT NULL default '0',
  item_thief_karma_fail int(5) NOT NULL default '0',
  item_zone int(8) NOT NULL default '0',
  item_zone_name varchar(255) NOT NULL default '0',
  KEY item_id (item_id),
  KEY item_owner_id (item_owner_id)
) ;

CREATE TABLE phpbb_adr_shops_items_quality (
  item_quality_id int(8) NOT NULL default '0',
  item_quality_modifier_price int(8) NOT NULL default '0',
  item_quality_lang varchar(255) NOT NULL default '',
  PRIMARY KEY  (item_quality_id)
) ;

CREATE TABLE phpbb_adr_shops_items_type (
  item_type_id int(8) NOT NULL default '0',
  item_type_base_price int(8) NOT NULL default '0',
  item_type_lang varchar(255) NOT NULL default '',
  PRIMARY KEY  (item_type_id)
) ;

CREATE TABLE phpbb_adr_skills (
  skill_id tinyint(1) NOT NULL default '0',
  skill_name varchar(255) NOT NULL default '',
  skill_desc text NOT NULL,
  skill_img varchar(255) NOT NULL default '',
  skill_req int(8) NOT NULL default '0',
  skill_chance mediumint(3) NOT NULL default '5',
  PRIMARY KEY  (skill_id)
) ;

CREATE TABLE phpbb_adr_stores (
  store_id int(8) NOT NULL auto_increment,
  store_name varchar(100) NOT NULL default '',
  store_desc varchar(255) NOT NULL default '',
  store_img varchar(255) NOT NULL default '',
  store_status tinyint(1) NOT NULL default '1',
  store_sales_status tinyint(1) NOT NULL default '0',
  store_admin tinyint(1) NOT NULL default '0',
  store_owner_id int(1) NOT NULL default '1',
  store_owner_img varchar(255) default '',
  store_owner_speech varchar(255) default '',
  KEY store_id (store_id)
);

CREATE TABLE phpbb_adr_temple_donations (
  item_id int(8) NOT NULL default '0',
  item_chance tinyint(1) default NULL,
  item_owner_id tinyint(1) NOT NULL default '1',
  item_price int(8) NOT NULL default '0',
  item_quality int(8) NOT NULL default '0',
  item_power int(8) NOT NULL default '0',
  item_duration int(8) NOT NULL default '0',
  item_duration_max int(8) NOT NULL default '1',
  item_icon varchar(255) NOT NULL default '',
  item_name varchar(255) NOT NULL default '',
  item_desc varchar(255) NOT NULL default '',
  item_type_use int(8) NOT NULL default '16',
  item_weight int(12) NOT NULL default '25',
  item_max_skill int(8) NOT NULL default '25',
  item_add_power int(8) NOT NULL default '0',
  item_mp_use int(8) NOT NULL default '0',
  item_element int(4) NOT NULL default '0',
  item_element_str_dmg int(4) NOT NULL default '100',
  item_element_same_dmg int(4) NOT NULL default '100',
  item_element_weak_dmg int(4) NOT NULL default '100',
  item_sell_back_percentage int(3) NOT NULL default '10',
  KEY item_id (item_id)
) ;

CREATE TABLE phpbb_adr_temple_tracker (
  track_id int(10) NOT NULL auto_increment,
  item_name varchar(100) default NULL,
  owner_name varchar(100) default NULL,
  donated int(12) default NULL,
  date int(12) default NULL,
  KEY track_id (track_id)
) ;

CREATE TABLE phpbb_adr_townmap (
  townmap_id smallint(8) NOT NULL default '0',
  townmap_num tinyint(1) NOT NULL default '0',
  townmap_name varchar(255) NOT NULL default '',
  townmap_desc text NOT NULL,
  townmap_img varchar(255) NOT NULL default '',
  PRIMARY KEY  (townmap_id)
) ;

CREATE TABLE phpbb_adr_townmap_map (
  townmap_map tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (townmap_map)
) ;

CREATE TABLE phpbb_adr_townmap_music (
  music_spring varchar(255) NOT NULL default '',
  music_summer varchar(255) NOT NULL default '',
  music_automn varchar(255) NOT NULL default '',
  music_winter varchar(255) NOT NULL default '',
  PRIMARY KEY  (music_spring)
) ;

CREATE TABLE phpbb_adr_vault_blacklist (
  user_id int(8) NOT NULL default '0',
  user_due int(8) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ;

CREATE TABLE phpbb_adr_vault_exchange (
  stock_id int(8) NOT NULL default '0',
  stock_name varchar(40) NOT NULL default '',
  stock_desc varchar(255) NOT NULL default '',
  stock_price int(8) NOT NULL default '0',
  stock_previous_price int(8) NOT NULL default '0',
  stock_best_price int(8) NOT NULL default '0',
  stock_worst_price int(8) NOT NULL default '0',
  PRIMARY KEY  (stock_id)
) ;

CREATE TABLE phpbb_adr_vault_exchange_users (
  stock_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  stock_amount mediumint(8) NOT NULL default '0',
  price_transaction int(8) NOT NULL default '0',
  KEY stock_id (stock_id),
  KEY user_id (user_id)
) ;

CREATE TABLE phpbb_adr_vault_users (
  owner_id int(8) NOT NULL default '0',
  account_id int(8) NOT NULL default '0',
  account_sum int(8) NOT NULL default '0',
  account_time int(11) NOT NULL default '0',
  loan_sum int(8) NOT NULL default '0',
  loan_time int(11) NOT NULL default '0',
  account_protect tinyint(1) NOT NULL default '0',
  loan_protect tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (owner_id)
) ;

CREATE TABLE phpbb_adr_zones (
  zone_id int(8) NOT NULL default '0',
  zone_name varchar(255) NOT NULL default '',
  zone_desc varchar(255) NOT NULL default '',
  zone_img varchar(255) NOT NULL default '',
  zone_element varchar(255) NOT NULL default '',
  zone_item varchar(255) NOT NULL default '0',
  cost_goto1 int(8) NOT NULL default '0',
  cost_goto2 int(8) NOT NULL default '0',
  cost_goto3 int(8) NOT NULL default '0',
  cost_goto4 int(8) NOT NULL default '0',
  cost_return int(8) NOT NULL default '0',
  goto1_name varchar(255) NOT NULL default '',
  goto2_name varchar(255) NOT NULL default '',
  goto3_name varchar(255) NOT NULL default '',
  goto4_name varchar(255) NOT NULL default '',
  return_name varchar(255) NOT NULL default '',
  zone_shops int(1) NOT NULL default '0',
  zone_forge int(1) NOT NULL default '0',
  zone_prison int(1) NOT NULL default '0',
  zone_temple int(1) NOT NULL default '0',
  zone_bank int(1) NOT NULL default '0',
  zone_event1 int(1) NOT NULL default '0',
  zone_event2 int(1) NOT NULL default '0',
  zone_event3 int(1) NOT NULL default '0',
  zone_event4 int(1) NOT NULL default '0',
  zone_event5 int(1) NOT NULL default '0',
  zone_event6 int(1) NOT NULL default '0',
  zone_event7 int(1) NOT NULL default '0',
  zone_event8 int(1) NOT NULL default '0',
  zone_pointwin1 int(8) NOT NULL default '0',
  zone_pointwin2 int(8) NOT NULL default '0',
  zone_pointloss1 int(8) NOT NULL default '0',
  zone_pointloss2 int(8) NOT NULL default '0',
  zone_chance int(8) NOT NULL default '0',
  npc_price int(8) NOT NULL default '0',
  npc1_enable int(1) NOT NULL default '0',
  npc2_enable int(1) NOT NULL default '0',
  npc3_enable int(1) NOT NULL default '0',
  npc4_enable int(1) NOT NULL default '0',
  npc5_enable int(1) NOT NULL default '0',
  npc6_enable int(1) NOT NULL default '0',
  npc1_message varchar(255) NOT NULL default '',
  npc2_message varchar(255) NOT NULL default '',
  npc3_message varchar(255) NOT NULL default '',
  npc4_message varchar(255) NOT NULL default '',
  npc5_message varchar(255) NOT NULL default '',
  npc6_message varchar(255) NOT NULL default '',
  zone_mine int(1) NOT NULL default '0',
  zone_enchant int(1) NOT NULL default '0',
  PRIMARY KEY  (zone_id)
) ;

CREATE TABLE phpbb_rabbitoshi_config (
  creature_id smallint(2) NOT NULL default '0',
  creature_name varchar(255) NOT NULL default '',
  creature_prize int(8) NOT NULL default '0',
  creature_power int(8) NOT NULL default '0',
  creature_magicpower int(8) NOT NULL default '0',
  creature_armor int(8) NOT NULL default '0',
  creature_max_hunger int(8) NOT NULL default '0',
  creature_max_thirst int(8) NOT NULL default '0',
  creature_max_health int(8) NOT NULL default '0',
  creature_mp_max int(8) NOT NULL default '0',
  creature_max_hygiene int(8) NOT NULL default '0',
  creature_food_id smallint(2) NOT NULL default '0',
  creature_buyable tinyint(1) NOT NULL default '1',
  creature_evolution_of int(8) NOT NULL default '0',
  creature_img varchar(255) NOT NULL default '',
  creature_experience_max int(8) NOT NULL default '100',
  creature_max_attack int(8) NOT NULL default '1',
  creature_max_magicattack int(8) NOT NULL default '1',
  PRIMARY KEY  (creature_id)
) ;

CREATE TABLE phpbb_rabbitoshi_general (
  config_name varchar(255) NOT NULL default '0',
  config_value int(15) NOT NULL default '0',
  PRIMARY KEY  (config_name)
) ;

CREATE TABLE phpbb_rabbitoshi_shop (
  item_id smallint(1) NOT NULL default '0',
  item_name varchar(255) NOT NULL default '',
  item_prize int(8) NOT NULL default '0',
  item_desc varchar(255) NOT NULL default '',
  item_type smallint(1) NOT NULL default '0',
  item_power int(8) NOT NULL default '0',
  item_img varchar(255) NOT NULL default '',
  PRIMARY KEY  (item_id)
) ;

CREATE TABLE phpbb_rabbitoshi_shop_users (
  item_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  item_amount mediumint(8) NOT NULL default '0',
  KEY item_id (item_id),
  KEY user_id (user_id)
) ;

CREATE TABLE phpbb_rabbitoshi_users (
  owner_id int(8) NOT NULL default '0',
  owner_last_visit int(11) NOT NULL default '0',
  owner_creature_id smallint(2) NOT NULL default '0',
  owner_creature_name varchar(255) NOT NULL default '',
  creature_level int(8) NOT NULL default '1',
  creature_power int(8) NOT NULL default '0',
  creature_magicpower int(8) NOT NULL default '0',
  creature_armor int(8) NOT NULL default '0',
  creature_experience int(8) NOT NULL default '0',
  creature_hunger int(8) NOT NULL default '0',
  creature_hunger_max int(8) NOT NULL default '0',
  creature_thirst int(8) NOT NULL default '0',
  creature_thirst_max int(8) NOT NULL default '0',
  creature_health int(8) NOT NULL default '0',
  creature_health_max int(8) NOT NULL default '0',
  creature_mp int(8) NOT NULL default '0',
  creature_max_mp int(8) NOT NULL default '0',
  creature_hygiene int(8) NOT NULL default '0',
  creature_hygiene_max int(8) NOT NULL default '0',
  creature_attack int(8) NOT NULL default '1',
  creature_attack_max int(8) NOT NULL default '1',
  creature_magicattack int(8) NOT NULL default '1',
  creature_magicattack_max int(8) NOT NULL default '1',
  creature_age int(11) NOT NULL default '0',
  creature_hotel int(11) NOT NULL default '0',
  owner_notification tinyint(1) NOT NULL default '0',
  owner_hide tinyint(1) NOT NULL default '0',
  owner_feed_full tinyint(1) NOT NULL default '1',
  owner_drink_full tinyint(1) NOT NULL default '1',
  owner_clean_full tinyint(1) NOT NULL default '1',
  creature_statut int(8) NOT NULL default '0',
  creature_avatar varchar(255) NOT NULL default 'default_avatar.gif',
  creature_invoc int(8) NOT NULL default '0',
  creature_experience_level int(8) NOT NULL default '0',
  creature_experience_level_limit int(8) NOT NULL default '0',
  creature_ability int(8) NOT NULL default '0',
  PRIMARY KEY  (owner_id)
) ;

CREATE TABLE phpbb_adr_battle_community(
  chat_id int(10) NOT NULL auto_increment,
  chat_posts int(10) NOT NULL default '0',
  chat_text text,
  chat_date date default NULL,
  PRIMARY KEY (chat_id)
) ;

ALTER TABLE phpbb_adr_shops_items ADD item_stolen tinyint(1) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_steal_dc smallint(3) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops ADD shop_last_updated int(12) NOT NULL default '0';


ALTER TABLE phpbb_users ADD user_adr_ban tinyint(1) default '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_time INT(11) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_time_judgement INT(11) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_caution INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_sentence TEXT DEFAULT '';
ALTER TABLE phpbb_users ADD user_cell_enable_caution INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_enable_free INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_celleds INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_punishment TINYINT(1) DEFAULT '0' NOT NULL;

# ADR 0.4.2
ALTER TABLE phpbb_adr_characters ADD character_victories_pvp int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_characters ADD character_defeats_pvp int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_characters ADD character_flees_pvp int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_characters ADD character_fp int(12) NOT NULL default '0';

ALTER TABLE phpbb_adr_shops_items CHANGE `item_stolen` `item_stolen_id` INT(12) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_adr_shops_items CHANGE `item_steal_dc` `item_steal_dc` TINYINT(2) DEFAULT '2' NOT NULL;
ALTER TABLE phpbb_adr_shops_items ADD item_bought_timestamp int(12) NOT NULL default '0';

ALTER TABLE phpbb_adr_battle_list ADD battle_challenger_equipment_info varchar(255) NOT NULL default '';
ALTER TABLE phpbb_adr_battle_list ADD battle_round int(12) NOT NULL default '0';
ALTER TABLE phpbb_adr_battle_list ADD battle_start int(12) NOT NULL default '0';
ALTER TABLE phpbb_adr_battle_list ADD battle_finish int(12) NOT NULL default '0';

ALTER TABLE phpbb_adr_battle_pvp ADD battle_start int(12) NOT NULL default '0';
ALTER TABLE phpbb_adr_battle_pvp ADD battle_finish int(12) NOT NULL default '0';

ALTER TABLE phpbb_adr_elements ADD element_colour varchar(255) NOT NULL default '';

CREATE TABLE phpbb_adr_stores_stats(
  store_stats_character_id int(12) NOT NULL default '0',
  store_stats_store_id int(12) NOT NULL default '0',
  store_stats_buy_total int(12) NOT NULL default '0',
  store_stats_buy_last int(12) NOT NULL default '0',
  store_stats_sold_total int(12) NOT NULL default '0',
  store_stats_sold_last int(12) NOT NULL default '0',
  store_stats_stolen_item_total int(12) NOT NULL default '0',
  store_stats_stolen_item_fail_total int(12) NOT NULL default '0',
  store_stats_stolen_item_last int(12) NOT NULL default '0',
  store_stats_stolen_points_total int(12) NOT NULL default '0',
  store_stats_stolen_points_last int(12) NOT NULL default '0',
  PRIMARY KEY  (store_stats_character_id, store_stats_store_id)
);

# ADR 0.4.3
CREATE TABLE phpbb_adr_bug_fix(
  fix_id varchar(255) NOT NULL default '',
  fix_install_date int(12) NOT NULL default '0',
  fix_installed_by varchar(255) NOT NULL default '',
  PRIMARY KEY(fix_id)
);
ALTER TABLE phpbb_adr_characters ADD prefs_tax_pm_notify TINYINT(1) NOT NULL default '1';

# ADR 0.4.4
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_align_enable tinyint(1) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_align varchar(255) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_class_enable tinyint(1) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_class varchar(255) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_element_enable tinyint(1) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_element varchar(255) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_race_enable tinyint(1) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_race varchar(255) NOT NULL default '0';

ALTER TABLE phpbb_adr_shops_items ADD item_restrict_level int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_str int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_dex int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_int int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_wis int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_cha int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_restrict_con int(8) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_crit_hit smallint(3) NOT NULL default '20';
ALTER TABLE phpbb_adr_shops_items ADD item_crit_hit_mod smallint(3) NOT NULL default '2';
ALTER TABLE phpbb_adr_shops_items ADD item_stolen_timestamp int(12) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_stolen_by varchar(255) NOT NULL default '';
ALTER TABLE phpbb_adr_shops_items ADD item_donated_timestamp int(12) NOT NULL default '0';
ALTER TABLE phpbb_adr_shops_items ADD item_donated_by varchar(255) NOT NULL default '';

CREATE TABLE phpbb_adr_stores_user_history(
  user_store_trans_id int(12) NOT NULL default '0',
  user_store_owner_id int(8) NOT NULL default '0',
  user_store_info TEXT NOT NULL default '',
  user_store_total_price int(12) NOT NULL default '0',
  user_store_date int(12) NOT NULL default '0',
  user_store_buyer TEXT NOT NULL default '',
  PRIMARY KEY(user_store_trans_id, user_store_owner_id)
) ;

# ADR 0.4.5
ALTER TABLE phpbb_adr_shops_items_type ADD item_type_order MEDIUMINT( 8 ) NOT NULL DEFAULT '1';
ALTER TABLE `phpbb_adr_shops_items_type` ADD `item_type_category` VARCHAR( 50 ) NOT NULL DEFAULT '';

# ADR - Advanced NPC System
ALTER TABLE `phpbb_adr_zones` DROP `npc_price`, DROP `npc1_enable`, DROP `npc2_enable`, DROP `npc3_enable`, DROP `npc4_enable`, DROP `npc5_enable`, DROP `npc1_message`, DROP `npc2_message`, DROP `npc3_message`, DROP `npc4_message`, DROP `npc5_message`;
# drop shadowtek's event kruft too
ALTER TABLE `phpbb_adr_zones` DROP `npc6_message`, DROP `npc6_enable`;
ALTER TABLE `phpbb_adr_characters` ADD `character_npc_check` TEXT NOT NULL;

CREATE TABLE `phpbb_adr_npc` (
  `npc_id` INT( 8 ) NOT NULL AUTO_INCREMENT,
  `npc_zone` VARCHAR( 255 ) NOT NULL ,
  `npc_name` VARCHAR( 255 ) NOT NULL ,
  `npc_img` VARCHAR( 255 ) NOT NULL ,
  `npc_enable` INT( 8 ) DEFAULT '0' NOT NULL ,
  `npc_price` INT( 8 ) DEFAULT '0' NOT NULL ,
  `npc_message` TEXT NOT NULL ,
  `npc_item` VARCHAR( 255 ) NOT NULL ,
  `npc_message2` TEXT NOT NULL ,
  `npc_points` INT( 8 ) DEFAULT '0' NOT NULL ,
  `npc_exp` INT( 8 ) DEFAULT '0' NOT NULL ,
  `npc_sp` INT( 8 ) DEFAULT '0' NOT NULL ,
  `npc_item2` VARCHAR( 255 ) NOT NULL ,
  `npc_times` INT( 4 ) DEFAULT '0' NOT NULL ,
  PRIMARY KEY ( `npc_id` )
);

# ADR - Advanced NPC System Expansion
ALTER TABLE `phpbb_adr_characters` ADD `character_npc_visited` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_message3` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_random` int(1) NOT NULL default '0';
ALTER TABLE `phpbb_adr_npc` ADD `npc_random_chance` int(7) NOT NULL default '1';
ALTER TABLE `phpbb_adr_npc` ADD `npc_user_level` int(1) NOT NULL default '0';
ALTER TABLE `phpbb_adr_npc` ADD `npc_class` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_race` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_character_level` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_element` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_alignment` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_visit_prerequisite` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_quest_prerequisite` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_view` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` ADD `npc_quest_hide` int(1) NOT NULL default '0';
ALTER TABLE `phpbb_adr_npc` ADD `npc_quest_clue` int(1) NOT NULL default '0';
ALTER TABLE `phpbb_adr_npc` ADD `npc_quest_clue_price` int(8) NOT NULL default '0';
ALTER TABLE `phpbb_adr_npc` CHANGE `npc_zone` `npc_zone` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` CHANGE `npc_item` `npc_item` TEXT NOT NULL;
ALTER TABLE `phpbb_adr_npc` CHANGE `npc_item2` `npc_item2` TEXT NOT NULL;

CREATE TABLE `phpbb_adr_cheat_log` (
  `cheat_id` mediumint(8) NOT NULL auto_increment,
  `cheat_ip` varchar(15) NOT NULL default '',
  `cheat_reason` varchar(50) NOT NULL default '',
  `cheat_date` int(10) NOT NULL default '0',
  `cheat_user_id` mediumint(8) NOT NULL default '0',
  `cheat_punished` varchar(255) NOT NULL default '',
  `cheat_public` int(1) NOT NULL default '0',
  PRIMARY KEY  (`cheat_id`)
);

# ADR - Monsters in multiple zones
ALTER TABLE `phpbb_adr_battle_monsters` DROP `monster_area`;
ALTER TABLE `phpbb_adr_battle_monsters` DROP `monster_area_name`;
ALTER TABLE `phpbb_adr_zones` ADD `zone_monsters_list` TEXT NOT NULL;

# ADR - Questbook
ALTER TABLE `phpbb_adr_npc` ADD `npc_kill_monster` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `phpbb_adr_npc` ADD `npc_monster_amount` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;

CREATE TABLE `phpbb_adr_character_quest_log` (
`user_id` INT( 8 ) NOT NULL,
`quest_kill_monster` VARCHAR( 255 ) NULL,
`quest_kill_monster_amount` INT( 8 ) DEFAULT '0' NOT NULL,
`quest_kill_monster_current_amount` INT( 8 ) DEFAULT '0' NOT NULL,
`quest_item_have` VARCHAR( 255 ) NOT NULL,
`quest_item_need` VARCHAR( 255 ) NOT NULL,
`npc_id` INT( 8 ) NOT NULL
);

CREATE TABLE `phpbb_adr_character_quest_log_history` (
  `quest_id` int(15) NOT NULL auto_increment,
  `user_id` int(8) NOT NULL,
  `quest_killed_monster` varchar(255) NOT NULL,
  `quest_killed_monsters_amount` int(8) NOT NULL default '0',
  `quest_item_gave` varchar(255) NOT NULL,
  `npc_id` int(8) NOT NULL,
  PRIMARY KEY  (`quest_id`)
);

# ADR - Zones by level
ALTER TABLE `phpbb_adr_zones` ADD `zone_level` INT(8) DEFAULT '0' NOT NULL;

# ADR - Zones specific shops
ALTER TABLE `phpbb_adr_stores` ADD `store_zone` int(8) NOT NULL default '0'; 
ALTER TABLE `phpbb_adr_shops` ADD `shop_zone` int(8) NOT NULL default '0';

# ADR - Advanced Loot System
ALTER TABLE `phpbb_adr_shops_items` ADD `item_loottables` TEXT NULL AFTER `item_store_id`;

ALTER TABLE `phpbb_adr_battle_monsters` ADD `monster_loottables` TEXT NOT NULL AFTER `monster_base_element`;
ALTER TABLE `phpbb_adr_battle_monsters` ADD `monster_possible_drop` int(8) NOT NULL AFTER `monster_loottables`;
ALTER TABLE `phpbb_adr_battle_monsters` ADD `monster_guranteened_drop` int(8) NOT NULL AFTER `monster_possible_drop`;
ALTER TABLE `phpbb_adr_battle_monsters` ADD `monster_specific_drop` TEXT NOT NULL AFTER `monster_guranteened_drop`;

CREATE TABLE `phpbb_adr_loottables` (
  `loottable_id` int(8) NOT NULL auto_increment,
  `loottable_name` varchar(255) NOT NULL default '',
  `loottable_desc` varchar(255) NOT NULL default '',
  `loottable_dropchance` int(8) NOT NULL default '1',
  `loottable_status` tinyint(1) NOT NULL default '1',
  KEY `loottable_id` (`loottable_id`)
);

# ADR - Brewing
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_brewing_uses` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_brewing` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_pre_effects` TEXT DEFAULT '' NULL;
ALTER TABLE `phpbb_adr_battle_list` ADD `battle_effects` TEXT DEFAULT '' NULL;
ALTER TABLE `phpbb_adr_battle_pvp` ADD `battle_effects` TEXT DEFAULT '' NULL;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_brewing_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_brewing_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_brewing_recipe` INT( 1 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_recipe_linked_item` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_brewing_items_req` TEXT DEFAULT '' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_effect` TEXT DEFAULT '' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_original_recipe_id` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_shops_items` ADD `item_recipe_skill_id` INT( 8 ) DEFAULT '0' NOT NULL ;

CREATE TABLE `phpbb_adr_recipebook` (
  `recipe_id` int(8) NOT NULL auto_increment,
  `recipe_owner_id` int(8) DEFAULT '0' NOT NULL,
  `recipe_level` int(8) DEFAULT '0' NOT NULL,
  `recipe_linked_item` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL,
  `recipe_items_req` TEXT DEFAULT '' NOT NULL,
  `recipe_effect` TEXT DEFAULT '' NOT NULL,
  `recipe_original_id` int(8) DEFAULT '0' NOT NULL,
  `recipe_skill_id` int(8) DEFAULT '0' NOT NULL,
  KEY `recipe_id` (`recipe_id`)
);

# ADR - Cooking
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_cooking_uses` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_cooking` INT( 8 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_cooking_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_cooking_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;

# ADR - Blacksmithing
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_blacksmithing_uses` INT( 8 ) UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_blacksmithing` INT( 8 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_blacksmithing_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_blacksmithing_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;

# ADR - Skills
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_alchemy_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_alchemy` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_alchemy_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_alchemy_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_fishing_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_fishing` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_fishing_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_fishing_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_herbalism_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_herbalism` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_herbalism_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_herbalism_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_lumberjack_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_lumberjack` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_lumberjack_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_lumberjack_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_tailoring_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_tailoring` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_tailoring_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_tailoring_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_hunting_uses` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_characters` ADD `character_skill_hunting` INT( 3 ) UNSIGNED DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_elements` ADD `element_skill_hunting_bonus` INT( 8 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_adr_races` ADD `race_skill_hunting_bonus` INT( 8 ) DEFAULT '0' NOT NULL ;