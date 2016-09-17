<?php
/***************************************************************************
 *                                 adr_constants.php
 *                            -------------------
 *   begin                : 31/01/2004
 *   copyright            : Dr DLP / Malicious Rabbit
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('ADR_VERSION', '0.3.4');


// Let's define the tables . Erf ... There are many ...
define('ADR_GENERAL_TABLE', $table_prefix.'adr_general'); // General table : contains all the mod infos
define('ADR_ZONES_TABLE', $table_prefix.'adr_zones'); // Contains all the zones

// Table of the exchanges : needs to be defined all the time , because of price updates
define('ADR_VAULT_EXCHANGE_TABLE',$table_prefix.'adr_vault_exchange');
define('ADR_VAULT_USERS_TABLE',$table_prefix.'adr_vault_users');
define('ADR_CAULDRON_TABLE', $table_prefix.'adr_cauldron_pack');

define('ADR_JOB_TABLE',$table_prefix.'adr_jobs');
define('ADR_ARMOUR_SET_TABLE',$table_prefix.'adr_armour_sets');
define('ADR_EXPLOIT_FIX', $table_prefix .'adr_create_exploit_fix');
define('ADR_BUG_FIX', $table_prefix .'adr_bug_fix');

// Characters
define('ADR_ALIGNMENTS_TABLE', $table_prefix.'adr_alignments');
define('ADR_CHARACTERS_TABLE', $table_prefix.'adr_characters');
define('ADR_CLASSES_TABLE', $table_prefix.'adr_classes');
define('ADR_ELEMENTS_TABLE', $table_prefix.'adr_elements');
define('ADR_RACES_TABLE', $table_prefix.'adr_races');
define('ADR_SKILLS_TABLE', $table_prefix.'adr_skills');

// Shops
define('ADR_SHOPS_TABLE', $table_prefix.'adr_shops');
define('ADR_SHOPS_GENERAL_TABLE', $table_prefix.'adr_shops_general');
define('ADR_SHOPS_ITEMS_TABLE', $table_prefix.'adr_shops_items');
define('ADR_SHOPS_ITEMS_TYPE_TABLE', $table_prefix.'adr_shops_items_type');
define('ADR_SHOPS_ITEMS_QUALITY_TABLE', $table_prefix.'adr_shops_items_quality');
define('ADR_STORES_TABLE', $table_prefix.'adr_stores');
define('ADR_STORES_STATS_TABLE', $table_prefix.'adr_stores_stats');
define('ADR_STORES_USER_HISTORY', $table_prefix.'adr_stores_user_history');
// Advanced Spells
define('ADR_SHOPS_SPELLS_TABLE', $table_prefix.'adr_shops_spells');

// Vault
define('ADR_VAULT_BLACKLIST_TABLE',$table_prefix.'adr_vault_blacklist');
define('ADR_VAULT_EXCHANGE_USERS_TABLE',$table_prefix.'adr_vault_exchange_users');
define('ADR_VAULT_GENERAL_TABLE',$table_prefix.'adr_vault_general');

// Battle
define('ADR_BATTLE_MONSTERS_TABLE',$table_prefix.'adr_battle_monsters');
define('ADR_BATTLE_LIST_TABLE',$table_prefix.'adr_battle_list');
define('ADR_BATTLE_PVP_TABLE',$table_prefix.'adr_battle_pvp');
define('ADR_BATTLE_COMMUNITY',$table_prefix.'adr_battle_community');

// Cell
define('ADR_JAIL_USERS_TABLE', $table_prefix.'adr_jail_users');
define('ADR_JAIL_VOTES_TABLE', $table_prefix.'adr_jail_votes');

// Temple
define('ADR_TEMPLE_DONATIONS', $table_prefix.'adr_temple_donations');
define('ADR_TEMPLE_TRACKER', $table_prefix.'adr_temple_tracker');

// Beggar
define('ADR_BEGGAR_DONATIONS', $table_prefix.'adr_beggar_donations');
define('ADR_BEGGAR_TRACKER', $table_prefix.'adr_beggar_tracker');

// Lake
define('ADR_LAKE_DONATIONS', $table_prefix.'adr_lake_donations');
define('ADR_LAKE_TRACKER', $table_prefix.'adr_lake_tracker');

// Advanced NPC System
define('ADR_NPC_TABLE', $table_prefix.'adr_npc'); // NPC table

// ditto Expansion
define('ADR_CHEAT_LOG_TABLE', $table_prefix .'adr_cheat_log');

// Quest book 
define('ADR_QUEST_LOG_TABLE', $table_prefix.'adr_character_quest_log'); // Character Quest log table
define('ADR_QUEST_LOG_HISTORY_TABLE', $table_prefix.'adr_character_quest_log_history'); // Character Quest log history table

// Loot tables
define('ADR_LOOTTABLES_TABLE', $table_prefix.'adr_loottables'); // Table for the loottables/categories

// Brewing
define('ADR_BREWING_RECIPES_TABLE', $table_prefix.'adr_brewing_recipes');
define('ADR_RECIPEBOOK_TABLE', $table_prefix.'adr_recipebook');

// Dynamic Town Map
define('ADR_ZONE_TOWNMAP_TABLE', $table_prefix.'adr_zone_townmaps');
define('ADR_ZONE_MAPS_TABLE', $table_prefix.'adr_zone_maps');
define('ADR_ZONE_BUILDINGS_TABLE', $table_prefix.'adr_zone_buildings');

// Research
define('ADR_LIBRARY_TABLE', $table_prefix.'adr_library');
define('ADR_LIBRARY_LEARN_TABLE', $table_prefix.'adr_library_learned');

// Guilds
define('ADR_GUILDS_TABLE', $table_prefix.'adr_guilds');
define('ADR_GUILD_MEMBER_TABLE', $table_prefix.'adr_guilds_members');
