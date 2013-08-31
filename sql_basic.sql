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
# ADR
#

# Alignments
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (1, 'Adr_alignment_neutral', 'Adr_alignment_neutral_desc', 0, 'Neutral.gif', 0, 0);
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (2, 'Adr_alignment_evil', 'Adr_alignment_evil_desc', 0, 'Evil.gif', 1000, 2);
INSERT INTO phpbb_adr_alignments (alignment_id, alignment_name, alignment_desc, alignment_level, alignment_img, alignment_karma_min, alignment_karma_type) VALUES (3, 'Adr_alignment_good', 'Adr_alignment_good_desc', 0, 'Good.gif', 1000, 1);

# Monsters
INSERT INTO phpbb_adr_battle_monsters (monster_id, monster_name, monster_img, monster_level, monster_base_hp, monster_base_att, monster_base_def, monster_base_mp, monster_base_custom_spell, monster_base_magic_attack, monster_base_magic_resistance, monster_base_mp_power, monster_base_sp, monster_thief_skill, monster_base_element, monster_base_karma, monster_area, monster_season, monster_weather, monster_item, monster_message_enable, monster_message, monster_area_name) VALUES (1338, 'torch eye', 'torch eye.gif', 1, 12, 24, 25, 1, 'a magical spell', 7, 9, 1, 3, 21, 6, 0, 0, 0, 0, '0', 0, '', '0');

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
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_overall_allow', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_allow', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_join_allow', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_posts', 0);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_level', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_guild_create_min_money', 0);
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
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (1, 'Adr_race_human', 'Adr_race_human_desc', 0, 'Human.gif', 0, 0, 0, 0, 0, 0, 5, 5, 5, 5, 5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1000, 5, 1, 'Suzail');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (2, 'Adr_race_half-elf', 'Adr_race_half-elf_desc', 0, 'Half-elf.gif', 0, 1, 0, 0, 0, 1, 0, 5, 0, 10, 5, 10, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 900, 5, 1, '');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (3, 'Orc', 'Race Orc', 0, 'Half-orc.gif', 2, 0, 2, 0, 0, 0, 15, 0, 0, 0, 0, 15, 0, 0, 0, 2, 0, 2, 0, 2, 0, 0, 1500, 5, 1, '');
INSERT INTO phpbb_adr_races (race_id, race_name, race_desc, race_level, race_img, race_might_bonus, race_dexterity_bonus, race_constitution_bonus, race_intelligence_bonus, race_wisdom_bonus, race_charisma_bonus, race_skill_mining_bonus, race_skill_stone_bonus, race_skill_forge_bonus, race_skill_enchantment_bonus, race_skill_trading_bonus, race_skill_thief_bonus, race_might_malus, race_dexterity_malus, race_constitution_malus, race_intelligence_malus, race_wisdom_malus, race_charisma_malus, race_magic_attack_bonus, race_magic_resistance_bonus, race_magic_attack_malus, race_magic_resistance_malus, race_weight, race_weight_per_level, race_zone_begin, race_zone_name) VALUES (4, 'Adr_race_elf', 'Adr_race_elf_desc', 0, 'Elf.gif', 0, 2, 0, 2, 0, 0, 0, 0, 5, 15, 10, 0, 2, 0, 2, 0, 0, 0, 2, 0, 0, 0, 800, 5, 1, '');

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

# Townmaps
INSERT INTO phpbb_adr_townmap (townmap_id, townmap_num, townmap_name, townmap_desc, townmap_img) VALUES (1, 1, 'Adr_TownMap_name_1', 'Adr_TownMap_desc_1', 'Carte_1.gif');
INSERT INTO phpbb_adr_townmap (townmap_id, townmap_num, townmap_name, townmap_desc, townmap_img) VALUES (2, 2, 'Adr_TownMap_name_2', 'Adr_TownMap_desc_2', 'Carte_2.gif');
INSERT INTO phpbb_adr_townmap (townmap_id, townmap_num, townmap_name, townmap_desc, townmap_img) VALUES (3, 3, 'Adr_TownMap_name_3', 'Adr_TownMap_desc_3', 'Carte_3.gif');
INSERT INTO phpbb_adr_townmap (townmap_id, townmap_num, townmap_name, townmap_desc, townmap_img) VALUES (4, 4, 'Adr_TownMap_name_4', 'Adr_TownMap_desc_4', 'Carte_4.gif');

# Townmap Maps
INSERT INTO phpbb_adr_townmap_map (townmap_map) VALUES (4);

# Townmap Musics
INSERT INTO phpbb_adr_townmap_music (music_spring, music_summer, music_automn, music_winter) VALUES ('spring', 'summer', 'automn', 'winter');

# Zones
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (1, 'Suzail', 'Suzail is the royal capital and richest city of the kingdom of Cormyr', 'cormyr', 'Fire', '0', 0, 0, 0, 0, 0, 'Suzail', 'Marsember', 'Eastern Cormyr Crossroads', '', 'Kings Forest', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 10, 20, 10, 20, 20, 0, 1, 1, 1, 1, 1, 1, 'this is a test message', 'test 1', 'test 2', 'test 3', 'test 4', 'test 5', 1, 1);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (2, 'Marsember', 'Marsember is the second largest city in the kingdom of Cormyr', 'Marsember', 'Fire', '0', 10, 10, 10, 10, 10, 'Marsember', '', '', '', 'Suzail', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 5, 100, 2, 100, 500, 0, 1, 1, 1, 1, 1, 1, 'test 1', 'test 2', 'test 3', 'test 4', 'test 5', 'event', 0, 0);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (3, 'Kings Forest', 'This forest is owned by the crown and is rich in game and wildlife', 'Kings_Forest', 'Earth', '0', 0, 0, 0, 0, 0, 'Kings Forest', 'Suzail', '', '', 'Western Cormyr Crossroads', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 5, 50, 5, 50, 80, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (4, 'Eastern Cormyr Crossroads', 'Eastern Cormyr crossroads', 'Cormyr_Crossroads', 'Earth', '0', 0, 0, 50, 0, 0, 'Eastern Cormyr Crossroads', '', 'The Vast Swamp', 'Suzail', 'Arabel', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 5, 100, 5, 100, 80, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (5, 'Arabel', 'Arabel is a fortified city with though it has mant posts for tradeing', 'Arabel', 'Holy', '0', 0, 0, 0, 0, 0, 'Arabel', 'Eastern Cormyr Crossroads', 'Hullack Forest', 'Western Cormyr Crossroads', 'Tilverton', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 5, 100, 5, 100, 80, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (6, 'Tilverton', 'Tilverton is a small city and is in a strategic location for the kingdom of Cormyr', 'Tilverton', 'Unholy', '0', 0, 0, 0, 0, 0, 'Suzail', 'Arabel', 'Cormanthor Forest (A4)', '', 'Shadow Gap, South', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 100, 5, 100, 50, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0);
INSERT INTO phpbb_adr_zones (zone_id, zone_name, zone_desc, zone_img, zone_element, zone_item, cost_goto1, cost_goto2, cost_goto3, cost_goto4, cost_return, goto1_name, goto2_name, goto3_name, goto4_name, return_name, zone_shops, zone_forge, zone_prison, zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, npc_price, npc1_enable, npc2_enable, npc3_enable, npc4_enable, npc5_enable, npc6_enable, npc1_message, npc2_message, npc3_message, npc4_message, npc5_message, npc6_message, zone_mine, zone_enchant) VALUES (7, 'Hullack Forest', 'One of the large remaining shards of the great woods that was Cormanthor.', 'Hullack_Forest', 'Air', '0', 0, 0, 0, 0, 0, 'Suzail', '', 'Highmoon', 'Arabel', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 5, 50, 5, 50, 10, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0);

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
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_use_cache_system', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_topics_display', '1-1-0-0-0-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_profile_display', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_time_start', 'time()');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_character_age', '16');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_skill_sp_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_character_sp_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('Adr_thief_enable', '1');
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

INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_cache_interval', 15);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_cache_last_updated', 0);
UPDATE phpbb_config SET `config_value` = '0-0-0-0-0-0-0-0-0' WHERE `config_name` = 'Adr_use_cache_system';

UPDATE phpbb_adr_battle_list SET battle_text = '' WHERE battle_result != 0;
UPDATE phpbb_adr_battle_pvp SET battle_text = '' WHERE battle_result != 3;

# ADR 0.4.4
UPDATE phpbb_adr_shops_items SET item_element_str_dmg = 100, item_element_same_dmg = 100, item_element_weak_dmg = 100 WHERE item_element = 0; 

INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_sell', 1);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_min_lvl', 5);
INSERT INTO phpbb_adr_general (config_name, config_value) VALUES ('Adr_shop_steal_show', 0);