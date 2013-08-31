# MODIFS SCHEMA
# A CHANGER
ALTER TABLE phpbb_forums ADD forum_desc_long TEXT;
ALTER TABLE phpbb_forums ADD auth_download TINYINT(2) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_forums ADD auth_download TINYINT(2) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_user_group ADD group_moderator TINYINT(1) NOT NULL;
ALTER TABLE phpbb_privmsgs ADD privmsgs_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_privmsgs ADD privmsgs_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_posts ADD post_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_posts ADD post_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attribute VARCHAR(25);
ALTER TABLE phpbb_auth_access ADD auth_download TINYINT(1) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_auth_access ADD auth_download TINYINT(1) DEFAULT '0' NOT NULL;  

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
  PRIMARY KEY  (set_id),
  FULLTEXT KEY set_gloves (set_gloves)
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
  monster_item varchar(255) NOT NULL default '0',
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
