<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_PUBLIC_TITLE}</span></td>
	  <td align="right"><span class="gen">{L_PET_EXPERIENCE}: <b>{POINTS}</b> {L_EXPERIENCE}</span></td>
	</tr>
</table>

<form action="{S_PET_ACTION}" method="post">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead">{L_NAME}</th>
		<th class="thHead">{L_EXPLAIN}</th>
		<th class="thHead">{L_NUMBER_RAISE}</th>
		<th class="thHead">{L_PRICE}</th>
		<th class="thHead">{L_SUBMIT_TITLE}</th>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_LEVEL}</span></td>
		<td class="row1"><span class="gensmall">{L_LEVEL_EXPLAIN} {ABILITY_POINTS}</span></td>
		<td class="row1"><span class="gensmall">{LEVEL_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{LEVEL_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="level_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_HEALTH}</span></td>
		<td class="row2"><span class="gensmall">{L_HEALTH_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{HEALTH_RAISE}</span></td>
		<td class="row2"><span class="gensmall">{HEALTH_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="health_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_HUNGER}</span></td>
		<td class="row1"><span class="gensmall">{L_HUNGER_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{HUNGER_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{HUNGER_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="hunger_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_THIRST}</span></td>
		<td class="row2"><span class="gensmall">{L_THIRST_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{THIRST_RAISE}</span></td>
		<td class="row2"><span class="gensmall">{THIRST_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="thirst_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_HYGIENE}</span></td>
		<td class="row1"><span class="gensmall">{L_HYGIENE_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{HYGIENE_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{HYGIENE_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="hygiene_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_MP}</span></td>
		<td class="row2"><span class="gensmall">{L_MP_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{MP_RAISE}</span></td>
		<td class="row2"><span class="gensmall">{MP_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="mp_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_POWER}</span></td>
		<td class="row1"><span class="gensmall">{L_POWER_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{POWER_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{POWER_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="power_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_MAGICPOWER}</span></td>
		<td class="row2"><span class="gensmall">{L_MAGICPOWER_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{MAGICPOWER_RAISE}</span></td>
		<td class="row2"><span class="gensmall">{MAGICPOWER_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="magicpower_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_ARMOR}</span></td>
		<td class="row1"><span class="gensmall">{L_ARMOR_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{ARMOR_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{ARMOR_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="armor_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_ATTACK}</span></td>
		<td class="row2"><span class="gensmall">{L_ATTACK_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{ATTACK_RAISE}</span></td>
		<td class="row2"><span class="gensmall">{ATTACK_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="attack_action" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_MAGICATTACK}</span></td>
		<td class="row1"><span class="gensmall">{L_MAGICATTACK_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{MAGICATTACK_RAISE}</span></td>
		<td class="row1"><span class="gensmall">{MAGICATTACK_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_SUBMIT}" name="magicattack_action" class="liteoption" /></span></td>
	</tr>
</table>

<br clear="all" />

<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead" colspan="4">{L_BATTLE}</th>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2"><span class="gensmall">{L_ATTACK_RELOAD}</span></td>
		<td class="row1"><span class="gensmall">{ATTACK_RELOAD_PRICE}</span></td>
		<td class="row1"><input type="submit" value="{L_RELOAD}" name="attack_reload" class="liteoption" /></td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2"><span class="gensmall">{L_MAGIC_RELOAD}</span></td>
		<td class="row1"><span class="gensmall">{MAGIC_RELOAD_PRICE}</span></td>
		<td class="row1"><input type="submit" value="{L_RELOAD}" name="magic_reload" class="liteoption" /></td>
	</tr>
	<tr align="center">
		<th class="thHead">{L_ABILITY_NAME}</th>
		<th class="thHead">{L_ABILITY_EXPLAIN}</th>
		<th class="thHead">{L_ABILITY_PRICE}</th>
		<th class="thHead">{L_ABILITY_SUBMIT_TITLE}</th>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_ABILITY_REGENERATION}</span></td>
		<td class="row1"><span class="gensmall">{L_ABILITY_REGENERATION_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{ABILITY_REGENERATION_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_ABILITY_SUBMIT}" name="regeneration_ability" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_ABILITY_HEALTH}</span></td>
		<td class="row2"><span class="gensmall">{L_ABILITY_HEALTH_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{ABILITY_HEALTH_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_ABILITY_SUBMIT}" name="health_ability" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row1"><span class="gensmall">{L_ABILITY_MANA}</span></td>
		<td class="row1"><span class="gensmall">{L_ABILITY_MANA_EXPLAIN}</span></td>
		<td class="row1"><span class="gensmall">{ABILITY_MANA_PRICE}</span></td>
		<td class="row1"><span class="gensmall"><input type="submit" value="{L_ABILITY_SUBMIT}" name="mana_ability" class="liteoption" /></span></td>
	</tr>
	<tr align="center">
		<td class="row2"><span class="gensmall">{L_ABILITY_SACRIFICE}</span></td>
		<td class="row2"><span class="gensmall">{L_ABILITY_SACRIFICE_EXPLAIN}</span></td>
		<td class="row2"><span class="gensmall">{ABILITY_SACRIFICE_PRICE}</span></td>
		<td class="row2"><span class="gensmall"><input type="submit" value="{L_ABILITY_SUBMIT}" name="sacrifice_ability" class="liteoption" /></span></td>
	</tr>
</table>
</form>

<br clear="all" />