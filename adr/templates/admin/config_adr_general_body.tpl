<form action="{S_ADR_ACTION}" method="post">

<!-- BEGIN cell -->
<h1>{L_CELL_SETTINGS}</h1>
<p>{L_CELL_SETTINGS_EXPLAIN}</p>
<!-- END cell -->
<!-- BEGIN battle -->
<h1>{L_BATTLE_SETTINGS}</h1>
<p>{L_BATTLE_SETTINGS_EXPLAIN}</p>
<!-- END battle -->
<!-- BEGIN vault -->
<h1>{L_VAULT_SETTINGS}</h1>
<p>{L_VAULT_SETTINGS_EXPLAIN}</p>
<!-- END vault -->
<!-- BEGIN misc -->
<h1>{L_ADR_SETTINGS}</h1>
<p>{L_ADR_SETTINGS_EXPLAIN}</p>
<!-- END misc -->
<!-- BEGIN temple -->
<h1>{L_TEMPLE_SETTINGS}</h1>
<p>{L_TEMPLE_SETTINGS_EXPLAIN}</p>
<!-- END temple -->

<!-- BEGIN beggar -->
<h1>{L_BEGGAR_SETTINGS}</h1>
<p>{L_BEGGAR_SETTINGS_EXPLAIN}</p>
<!-- END beggar -->
<!-- BEGIN lake -->
<h1>{L_LAKE_SETTINGS}</h1>
<p>{L_LAKE_SETTINGS_EXPLAIN}</p>
<!-- END lake -->

<!-- BEGIN items -->
<h1>{L_ADR_ITEMS_MODIFIER_PRICE}</h1>
<!-- END items -->
<!-- BEGIN display -->
<h1>{L_ADR_DISPLAY}</h1>
<!-- END display -->
<!-- BEGIN skills -->
<h1>{L_ADR_SETTINGS}</h1>
<p>{L_ADR_SETTINGS_EXPLAIN}</p>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_SKILLS}</th>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_SKILL_PAY}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SP_SKILLS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="allow_sp_skills" value="0" {NO_SP_SKILLS_CHECKED} />{L_POINTS}&nbsp;<input type="radio" name="allow_sp_skills" value="1" {SP_SKILLS_CHECKED} />{L_SP}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SP_CHARACTER}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="allow_sp_character" value="0" {NO_SP_CHARACTER_CHECKED} />{L_POINTS}&nbsp;<input type="radio" name="allow_sp_character" value="1" {SP_CHARACTER_CHECKED} />{L_SP}</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_SKILL_TRADING}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SKILL_TRADING_POWER}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="skill_trading_power" value="{SKILL_TRADING_POWER}" /> %</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_SKILL_THIEF}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_ALLOW_STEAL_SHOPS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="allow_shop_steal" value="0" {NO_SHOP_STEAL_CHECKED} />{L_NO}&nbsp;<input type="radio" name="allow_shop_steal" value="1" {SHOP_STEAL_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SHOP_STEAL_SELL}</span><br /><span class="gensmall"><i>{L_SHOP_STEAL_SELL_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><input type="radio" name="Adr_shop_steal_sell" value="0" {NO_STEAL_SELL_CHECKED} />{L_NO}&nbsp;<input type="radio" name="Adr_shop_steal_sell" value="1" {STEAL_SELL_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SHOP_STEAL_MIN_LVL}</span><br /><span class="gensmall"><i>{L_SHOP_STEAL_MIN_LVL_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><input type="text" maxlength="3" size="3" name="Adr_shop_steal_min_lvl" value="{SHOP_STEAL_MIN_LVL}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SHOP_STEAL_SHOW}</span><br /><span class="gensmall"><i>{L_SHOP_STEAL_SHOW_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><input type="radio" name="Adr_shop_steal_show" value="0" {NO_SHOP_STEAL_SHOW_CHECKED} />{L_NO}&nbsp;<input type="radio" name="Adr_shop_steal_show" value="1" {SHOP_STEAL_SHOW_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_FAIL_STEAL_AMEND}</span><br /><span class="gensmall">{L_FAIL_STEAL_AMEND_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="skill_thief_failure_damage" value="{FAIL_STEAL_AMEND}" /><span class="genmed"> {L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_FAIL_STEAL_PUNISHMENT}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="skill_thief_failure_punishment" value="0" {FAIL_STEAL_PUNISHMENT0} />{L_FAIL_STEAL_PUNISHMENT0}<br />
			<input type="radio" name="skill_thief_failure_punishment" value="1" {FAIL_STEAL_PUNISHMENT1} />{L_FAIL_STEAL_PUNISHMENT1}<br />
			<input type="radio" name="skill_thief_failure_punishment" value="2" {FAIL_STEAL_PUNISHMENT2} />{L_FAIL_STEAL_PUNISHMENT2}
		</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_FAIL_STEAL_TYPE}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="skill_thief_failure_type" value="1" {FAIL_STEAL_TYPE0} />{L_FAIL_STEAL_TYPE0}<br />
			<input type="radio" name="skill_thief_failure_type" value="2" {FAIL_STEAL_TYPE1} />{L_FAIL_STEAL_TYPE1}<br />
			<input type="radio" name="skill_thief_failure_type" value="3" {FAIL_STEAL_TYPE2} />{L_FAIL_STEAL_TYPE2}
		</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_FAIL_STEAL_TIME}</td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="skill_thief_failure_time" value="{FAIL_STEAL_TIME}" /></td>
	</tr>
</table>
<!-- END skills -->

<!-- BEGIN battle -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BATTLE_USE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="battle_enable" value="0" {NO_BATTLE_USE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="battle_enable" value="1" {BATTLE_USE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BATTLE_PVP_USE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="battle_pvp_enable" value="0" {NO_BATTLE_PVP_USE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="battle_pvp_enable" value="1" {BATTLE_PVP_USE_CHECKED} />{L_YES}</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_BATTLE_MONSTERS}</th>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_MODIFIER_TYPE}</span><br /><span class="gensmall">{L_MONSTERS_MODIFIER_TYPE_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="monster_modifier_type" value="0" {MONSTERS_MODIFIER_TYPE_1} />{L_MONSTERS_MODIFIER_TYPE_1}&nbsp;<input type="radio" name="monster_modifier_type" value="1" {MONSTERS_MODIFIER_TYPE_2} />{L_MONSTERS_MODIFIER_TYPE_2}</td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_STATS_MODIFIER}</span><br /><span class="gensmall">{L_MONSTERS_STATS_MODIFIER_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_monster_stats_modifier" value="{MONSTERS_STATS_MODIFIER}" /> %</td>
	</tr>

	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_BASE_EXP_MIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_exp_min" value="{MONSTERS_BASE_EXP_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_BASE_EXP_MAX}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_exp_max" value="{MONSTERS_BASE_EXP_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_EXP_MODIFIER}</span><br /><span class="gensmall">{L_MONSTERS_EXP_MODIFIER_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_exp_modifier" value="{MONSTERS_EXP_MODIFIER}" /> %</td>
	</tr>

	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_BASE_REWARD_MIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_reward_min" value="{MONSTERS_BASE_REWARD_MIN}" /><span class="genmed"> {L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_BASE_REWARD_MAX}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_reward_max" value="{MONSTERS_BASE_REWARD_MAX}" /><span class="genmed"> {L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_MONSTERS_REWARD_MODIFIER}</span><br /><span class="gensmall">{L_MONSTERS_REWARD_MODIFIER_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="battle_base_reward_modifier" value="{MONSTERS_REWARD_MODIFIER}" /> %</td>
	</tr>

</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">Réglages compétences</th>
	</tr>

	<tr>
		<td class="row1" width="65%"><span class="gen">Utilisation d'un type d'arme avant de changer de niveau de compétence</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="weapon_prof" value="{WEAPON_PROF}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">Bonus au blocage</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="shield_bonus" value="{SHIELD_BONUS}" /></td>  
	</tr>

</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_BATTLE_THIEF}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BATTLE_THIEF_ENABLE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="thief_enable" value="0" {NO_THIEF_ENABLE} />{L_NO}&nbsp;<input type="radio" name="thief_enable" value="1" {THIEF_ENABLE} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_BATTLE_THIEF_POINTS}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="3" size="8" name="thief_points" value="{THIEF_POINTS}" /></td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_BATTLE_PLAYERS}</th>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_BASE_EXP_MIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_exp_min" value="{PLAYERS_BASE_EXP_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_BASE_EXP_MAX}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_exp_max" value="{PLAYERS_BASE_EXP_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_EXP_MODIFIER}</span><br /><span class="gensmall">{L_PLAYERS_EXP_MODIFIER_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_exp_modifier" value="{PLAYERS_EXP_MODIFIER}" /> %</td>
	</tr>

	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_BASE_REWARD_MIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_reward_min" value="{PLAYERS_BASE_REWARD_MIN}" /><span class="genmed"> {L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_BASE_REWARD_MAX}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_reward_max" value="{PLAYERS_BASE_REWARD_MAX}" /><span class="genmed"> {L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_PLAYERS_REWARD_MODIFIER}</span><br /><span class="gensmall">{L_PLAYERS_REWARD_MODIFIER_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="pvp_base_reward_modifier" value="{PLAYERS_REWARD_MODIFIER}" /> %</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_PVP_DEFIES}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="4" size="4" name="battle_pvp_defies_max" value="{PVP_DEFIES}" /></td>
	</tr>
</table>
<!-- END battle -->

<!-- BEGIN vault -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_USE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="vault_enable" value="0" {NO_VAULT_USE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="vault_enable" value="1" {VAULT_USE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_INTERESTS_RATE}</span><br /><span class="gensmall">{L_VAULT_INTERESTS_RATE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="interests_rate" value="{VAULT_INTERESTS_RATE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_INTERESTS_TIME}</span><br /><span class="gensmall">{L_VAULT_INTERESTS_TIME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="interests_time" value="{VAULT_INTERESTS_TIME}" /><br /><span class="gensmall">( {VAULT_INTERESTS_TIME_EXPLAIN} )</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_USE_LOAN}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="vault_loan_enable" value="0" {NO_VAULT_USE_LOAN_CHECKED} />{L_NO}&nbsp;<input type="radio" name="vault_loan_enable" value="1" {VAULT_USE_LOAN_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_LOAN_INTERESTS}</span><br /><span class="gensmall">{L_VAULT_LOAN_INTERESTS_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="loan_interests" value="{VAULT_LOAN_INTERESTS}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_LOAN_INTERESTS_TIME}</span><br /><span class="gensmall">{L_VAULT_LOAN_INTERESTS_TIME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="loan_interests_time" value="{VAULT_LOAN_INTERESTS_TIME}" /><br /><span class="gensmall">( {VAULT_LOAN_INTERESTS_TIME_EXPLAIN} )</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_LOAN_MAX_SUM}</span><br /><span class="gensmall">{L_VAULT_LOAN_MAX_SUM_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="loan_max_sum" value="{VAULT_LOAN_MAX_SUM}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_LOAN_REQUIREMENTS}</span><br /><span class="gensmall">{L_VAULT_LOAN_REQUIREMENTS_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="loan_requirements" value="{VAULT_LOAN_REQUIREMENTS}" /></td>
	</tr>
</table>
<!-- END vault -->


<!-- BEGIN misc -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_ENABLE_RPG_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_ENABLE_RPG}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="enable_rpg" value="0" {NO_ENABLE_RPG_CHECKED} />{L_OFF}&nbsp;<input type="radio" name="enable_rpg" value="1" {ENABLE_RPG_CHECKED} />{L_ON}</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_WEIGHT_ENABLE_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_WEIGHT_ENABLE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="weight_enable" value="0" {NO_WEIGHT_ENABLE_CHECKED}  />{L_OFF}&nbsp;<input type="radio" name="weight_enable" value="1" {WEIGHT_ENABLE_CHECKED} />{L_ON}</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_JOB_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_JOB_ENABLE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="job_enable" value="0" {NO_JOB_ENABLE} />{L_NO}&nbsp;<input type="radio" name="job_enable" value="1" {JOB_ENABLE} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_JOB_CRON_TIME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="12" size="5" name="job_cron_time" value="{JOB_CRON_TIME}" />&nbsp;days</td>  
	</tr>
</table>

<br clear="all" />


<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_EXPERIENCE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_EXPERIENCE_NEW}</span></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="exp_new" value="{EXPERIENCE_NEW}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_EXPERIENCE_REPLY}</span></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="exp_reply" value="{EXPERIENCE_REPLY}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_EXPERIENCE_EDIT}</span></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="exp_edit" value="{EXPERIENCE_EDIT}" /></td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_ADR_CHARACTER_CREATION}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_AGE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="character_age" value="{CHARACTER_AGE}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_POSTS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="posts_enable" value="0" {NO_POSTS_CHECKED} />{L_NO}&nbsp;<input type="radio" name="posts_enable" value="1" {POSTS_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_POSTS_MIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="posts_min" value="{POSTS_MIN}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_REROLL}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="allow_reroll" value="0" {NO_CHARACTER_REROLL_CHECKED} />{L_NO}&nbsp;<input type="radio" name="allow_reroll" value="1" {CHARACTER_REROLL_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_DELETE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="allow_character_delete" value="0" {NO_CHARACTER_DELETE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="allow_character_delete" value="1" {CHARACTER_DELETE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_STATS_MIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="min_characteristic" value="{CHARACTER_STATS_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CHARACTER_STATS_MAX}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="max_characteristic" value="{CHARACTER_STATS_MAX}" /></td>  
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_CHARACTER_TAX}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SHOP_TAX}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="shop_tax" value="{SHOP_TAX}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SHOP_DURA}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="shop_dura" value="{SHOP_DURA}" /><span class="gensmall">&nbsp;{L_DAYS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_WH_TAX}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="wh_tax" value="{WH_TAX}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_WH_DURA}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="8" name="wh_dura" value="{WH_DURA}" /><span class="gensmall">&nbsp;{L_DAYS}</span></td>  
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_ADR_SHOP_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_NEW_SHOP_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="new_shop_price" value="{NEW_SHOP_PRICE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_REGEN_PERIOD_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LIMIT_ENABLE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="limit_enable" value="0" {NO_LIMIT_ENABLE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="limit_enable" value="1" {LIMIT_ENABLE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_REGEN_PERIOD}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="5" name="regen_period" value="{REGEN_PERIOD}" /><span class="gensmall">&nbsp;{L_DAYS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BATTLE_LIMIT}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="5" name="battle_limit" value="{BATTLE_LIMIT}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_SKILL_LIMIT}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="5" name="skill_limit" value="{SKILL_LIMIT}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRADING_LIMIT}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="5" name="trading_limit" value="{TRADING_LIMIT}" /></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_THIEF_LIMIT}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="3" size="5" name="thief_limit" value="{THIEF_LIMIT}" /></td>  
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_TRAINING}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRAINING_ALLOW_CHANGE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="training_allow_change" value="0" {NO_TRAINING_ALLOW_CHANGE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="training_allow_change" value="1" {TRAINING_ALLOW_CHANGE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRAINING_CHANGE_COST}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="training_change_cost" value="{TRAINING_CHANGE_COST}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRAINING_SKILL_COST}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="training_skill_cost" value="{TRAINING_SKILL_COST}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRAINING_CHARAC_COST}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="training_charac_cost" value="{TRAINING_CHARAC_COST}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TRAINING_UPGRADE_COST}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="training_upgrade_cost" value="{TRAINING_UPGRADE_COST}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>   
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_LEVEL_UP_PENALTY}</th>
	</tr>
	<tr>
		<td class="row1" width="75%"><span class="gen">{L_LEVEL_UP_PENALTY}</span><br /><span class="gensmall">{L_LEVEL_UP_PENALTY_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="text" maxlength="8" size="8" name="next_level_penalty" value="{LEVEL_UP_PENALTY}" /> %</td>
	</tr>
</table>

<!-- END misc -->

<!-- BEGIN temple -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_HEAL}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_heal_cost" value="{TEMPLE_HEAL}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_RESURRECT}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_resurrect_cost" value="{TEMPLE_RESURRECT}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>  
	</tr>
</table>
<br /><br />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_TEMPLE_DONATION_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_MIN_AMOUNT}</span><br /><span class="gensmall"><i>{L_TEMPLE_MIN_AMOUNT_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_min_donation" value="{TEMPLE_MIN_AMOUNT}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_WIN_CHANCE}</span><br /><span class="gensmall"><i>{L_TEMPLE_WIN_CHANCE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_win_chance" value="{TEMPLE_WIN_CHANCE}" /><span class="gensmall">&nbsp;%</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_CHANCE_INCREASE}</span><br /><span class="gensmall"><i>{L_TEMPLE_CHANCE_INCREASE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_chance_increase" value="{TEMPLE_CHANCE_INCREASE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_TEMPLE_SUPER_RARE}</span><br /><span class="gensmall"><i>{L_TEMPLE_SUPER_RARE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="temple_super_rare_amount" value="{TEMPLE_SUPER_RARE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
</table>
<!-- END temple -->

<!-- BEGIN beggar -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_BEGGAR_DONATION_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BEGGAR_MIN_AMOUNT}</span><br /><span class="gensmall"><i>{L_BEGGAR_MIN_AMOUNT_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="beggar_min_donation" value="{BEGGAR_MIN_AMOUNT}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BEGGAR_WIN_CHANCE}</span><br /><span class="gensmall"><i>{L_BEGGAR_WIN_CHANCE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="beggar_win_chance" value="{BEGGAR_WIN_CHANCE}" /><span class="gensmall">&nbsp;%</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BEGGAR_CHANCE_INCREASE}</span><br /><span class="gensmall"><i>{L_BEGGAR_CHANCE_INCREASE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="beggar_chance_increase" value="{BEGGAR_CHANCE_INCREASE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BEGGAR_SUPER_RARE}</span><br /><span class="gensmall"><i>{L_BEGGAR_SUPER_RARE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="beggar_super_rare_amount" value="{BEGGAR_SUPER_RARE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
</table>
<!-- END beggar -->

<!-- BEGIN lake -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_LAKE_DONATION_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LAKE_MIN_AMOUNT}</span><br /><span class="gensmall"><i>{L_LAKE_MIN_AMOUNT_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="lake_min_donation" value="{LAKE_MIN_AMOUNT}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LAKE_WIN_CHANCE}</span><br /><span class="gensmall"><i>{L_LAKE_WIN_CHANCE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="lake_win_chance" value="{LAKE_WIN_CHANCE}" /><span class="gensmall">&nbsp;%</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LAKE_CHANCE_INCREASE}</span><br /><span class="gensmall"><i>{L_LAKE_CHANCE_INCREASE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="lake_chance_increase" value="{LAKE_CHANCE_INCREASE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LAKE_SUPER_RARE}</span><br /><span class="gensmall"><i>{L_LAKE_SUPER_RARE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="lake_super_rare_amount" value="{LAKE_SUPER_RARE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>
	</tr>
</table>
<!-- END lake -->


<!-- BEGIN items -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_ADR_ITEMS_MODIFIER_PRICE_POWER}<br /><font size="1">{L_ADR_ITEMS_MODIFIER_PRICE_POWER_EXPLAIN}</font></th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gensmall"><b>{L_ADR_MODIFIER_POWER}</b></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="item_modifier_power" value="{ITEMS_MODIFIER_POWER}" /> %</td>  
	</tr>
	<tr>
		<td align="center" class="row3" colspan="2" height="1" >&nbsp;</td>
	</tr>
	<tr>
		<th align="center" colspan="2">{L_ADR_ITEMS_MODIFIER_PRICE_TYPE}<br /><font size="1">{L_ADR_ITEMS_MODIFIER_PRICE_TYPE_EXPLAIN}</font></th>
	</tr>
	<!-- BEGIN type_items -->
	<tr>
		<td class="row1" width="65%"><span class="gen">{items.type_items.L_ITEMS_MODIFIER_PRICE_TYPE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="item_type[{items.type_items.ITEMS_TYPE_ID}]" value="{items.type_items.ADR_ITEMS_MODIFIER_PRICE_TYPE}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td>   
	</tr>
	<!-- END type_items -->
	<tr>
		<td align="center" class="row3" colspan="2" height="1" >&nbsp;</td>
	</tr>
	<tr>
		<th align="center" colspan="2">{L_ADR_ITEMS_MODIFIER_PRICE_QUALITY}<br /><font size="1">{L_ADR_ITEMS_MODIFIER_PRICE_QUALITY_EXPLAIN}</font></th>
	</tr>
	<!-- BEGIN quality_items -->
	<tr>
		<td class="row1" width="65%"><span class="gen">{items.quality_items.L_ITEMS_MODIFIER_PRICE_QUALITY}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="item_quality[{items.quality_items.ITEMS_QUALITY_ID}]" value="{items.quality_items.ADR_ITEMS_MODIFIER_PRICE_QUALITY}" /> %</td>  
	</tr>
	<!-- END quality_items -->
	<tr>
		<td align="center" class="row3" colspan="2" height="1" >&nbsp;</td>
	</tr>

</table>
<!-- END items -->

<!-- BEGIN cell -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_CAUTION}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="cell_allow_user_caution" value="0" {NO_CELL_CAUTION_CHECKED} />{L_NO}&nbsp;<input type="radio" name="cell_allow_user_caution" value="1" {CELL_CAUTION_CHECKED} />{L_YES}</td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_JUDGE}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="cell_allow_user_judge" value="0" {NO_CELL_JUDGE_CHECKED} />{L_NO}&nbsp;<input type="radio" name="cell_allow_user_judge" value="1" {CELL_JUDGE_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_VOTERS}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="cell_user_judge_voters" value="{CELL_VOTERS}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_POSTS}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="cell_user_judge_posts" value="{CELL_POSTS}" /></td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_BLANK}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="cell_allow_user_blank" value="0" {NO_CELL_BLANK_CHECKED} />{L_NO}&nbsp;<input type="radio" name="cell_allow_user_blank" value="1" {CELL_BLANK_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_BLANK_SUM}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="cell_amount_user_blank" value="{CELL_BLANK}" /></td>
	</tr>
</table>
<!-- END cell -->

<!-- BEGIN display -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_DISPLAY_PROFILE}</th>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_PROFILE_ALLOW}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="Adr_profile_display" value="0" {NO_DISPLAY_PROFILE_ALLOW_CHECKED} />{L_NO}&nbsp;<input type="radio" name="Adr_profile_display" value="1" {DISPLAY_PROFILE_ALLOW_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<th align="center" colspan="2">{L_DISPLAY_TOPICS}</th>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_RANK}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="display7" value="0" {NO_DISPLAY_TOPICS_RANK_CHECKED} />{L_NO}&nbsp;<input type="radio" name="display7" value="1" {DISPLAY_TOPICS_RANK_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_LEVEL}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="display0" value="0" {NO_DISPLAY_TOPICS_LEVEL_CHECKED} />{L_NO}&nbsp;<input type="radio" name="display0" value="1" {DISPLAY_TOPICS_LEVEL_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_BATTLE_STATS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="display8" value="0" {NO_DISPLAY_TOPICS_BATTLE_STATS_CHECKED} />{L_NO}&nbsp;<input type="radio" name="display8" value="1" {DISPLAY_TOPICS_BATTLE_STATS_CHECKED} />{L_YES}</td>
	</tr>	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_CLASS}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="display1" value="0" {NO_DISPLAY_TOPICS_CLASS_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="display1" value="1" {TEXT_DISPLAY_TOPICS_CLASS_CHECKED} />{L_TEXT}&nbsp;
			<input type="radio" name="display1" value="2" {PIC_DISPLAY_TOPICS_CLASS_CHECKED} />{L_PIC}&nbsp;
		</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_RACE}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="display2" value="0" {NO_DISPLAY_TOPICS_RACE_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="display2" value="1" {TEXT_DISPLAY_TOPICS_RACE_CHECKED} />{L_TEXT}&nbsp;
			<input type="radio" name="display2" value="2" {PIC_DISPLAY_TOPICS_RACE_CHECKED} />{L_PIC}&nbsp;
		</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_ELEMENT}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="display3" value="0" {NO_DISPLAY_TOPICS_ELEMENT_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="display3" value="1" {TEXT_DISPLAY_TOPICS_ELEMENT_CHECKED} />{L_TEXT}&nbsp;
			<input type="radio" name="display3" value="2" {PIC_DISPLAY_TOPICS_ELEMENT_CHECKED} />{L_PIC}&nbsp;
		</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_ALIGNMENT}</span></td>
		<td class="row2" align="center" valign="top">
			<input type="radio" name="display4" value="0" {NO_DISPLAY_TOPICS_ALIGNMENT_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="display4" value="1" {TEXT_DISPLAY_TOPICS_ALIGNMENT_CHECKED} />{L_TEXT}&nbsp;
			<input type="radio" name="display4" value="2" {PIC_DISPLAY_TOPICS_ALIGNMENT_CHECKED} />{L_PIC}&nbsp;
		</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_PVP}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="display6" value="0" {NO_DISPLAY_TOPICS_PVP_CHECKED} />{L_NO}&nbsp;<input type="radio" name="display6" value="1" {DISPLAY_TOPICS_PVP_CHECKED} />{L_YES}</td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_DISPLAY_TOPICS_LINK}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="display5" value="0" {NO_DISPLAY_TOPICS_LINK_CHECKED} />{L_NO}&nbsp;<input type="radio" name="display5" value="1" {DISPLAY_TOPICS_LINK_CHECKED} />{L_YES}</td>
	</tr>
</table>
<!-- END display -->

<!-- BEGIN guilds -->

<table border="0" cellpadding="4" cellspacing="1" width="90%" class="forumline" align="center">
  <tr>
    <th align="center" colspan="2">{L_GUILDS_TITLE}</th>
  </tr>
  <tr>
    <td class="row1" width="65%"><span class="gen">{L_GUILDS_OVERALL_ALLOW}</span></td>
    <td class="row2" align="center" valign="top"><input type="radio" name="guild_overall_allow" value="1" {GUILDS_OVERALL_ALLOW_CHECKED} />{L_ON}&nbsp;<input type="radio" name="guild_overall_allow" value="0" {NO_GUILDS_OVERALL_ALLOW_CHECKED} />{L_OFF}</td>
  </tr>
  <tr>
    <td class="row1" width="65%"><span class="gen">{L_GUILDS_CREATE_ALLOW}</span></td>
    <td class="row2" align="center" valign="top"><input type="radio" name="guild_create_allow" value="1" {GUILDS_CREATE_ALLOW_CHECKED} />{L_ON}&nbsp;<input type="radio" name="guild_create_allow" value="0" {NO_GUILDS_CREATE_ALLOW_CHECKED} />{L_OFF}</td>
  </tr>
  <tr>
    <td class="row1" width="65%"><span class="gen">{L_GUILDS_JOIN_ALLOW}</span></td>
    <td class="row2" align="center" valign="top"><input type="radio" name="guild_join_allow" value="1" {GUILDS_JOIN_ALLOW_CHECKED} />{L_ON}&nbsp;<input type="radio" name="guild_join_allow" value="0" {NO_GUILDS_JOIN_ALLOW_CHECKED} />{L_OFF}</td>
  </tr>

  <tr>
    <td class="row1" width="65%"><span class="gen">{L_GUILDS_CREATE_LEVEL}</span></td>
    <td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="guild_create_level"  value="{GUILDS_CREATE_LEVEL}" /></td>
  </tr>
  <tr>
    <td class="row1" width="65%"><span class="gen">{L_GUILDS_CREATE_MONEY}</span></td>
    <td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="guild_create_money"  value="{GUILDS_CREATE_MONEY}" /></td>
  </tr>
</table>

<!-- END guilds -->


<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="catBottom" align="center"><input class="mainoption" type="submit" value="{L_SUBMIT}" name="submit" /></td>
	</tr>
</table>

</form>
