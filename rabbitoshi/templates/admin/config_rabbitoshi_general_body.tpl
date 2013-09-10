<h1>{L_RABBITOSHI_SETTINGS}</h1>

<p>{L_RABBITOSHI_SETTINGS_EXPLAIN}</p>

<form action="{S_RABBITOSHI_ACTION}" method="post">

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th colspan="2">{L_RABBITOSHI_SETTINGS}</th>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_USE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="use" value="1" {RABBITOSHI_USE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_NAME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="name" value="{RABBITOSHI_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_USE_CRON}</span><br /><span class="gensmall">{L_RABBITOSHI_USE_CRON_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="use_cron" value="1" {RABBITOSHI_USE_CRON_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_CRON_TIME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="cron_time" value="{RABBITOSHI_CRON_TIME}" /> &nbsp;<span class="gen">{L_SECONDS}</span><br /><span class="gensmall">( {RABBITOSHI_CRON_TIME_EXPLAIN} )</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_REBIRTH}</span><br /><span class="gensmall">{L_RABBITOSHI_REBIRTH_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="rebirth" value="1" {RABBITOSHI_REBIRTH_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_REBIRTH_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="rebirth_price" value="{RABBITOSHI_REBIRTH_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_VET}</span><br /><span class="gensmall">{L_RABBITOSHI_VET_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="vet" value="1" {RABBITOSHI_VET_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_VET_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="vet_price" value="{RABBITOSHI_VET_PRICE}" /></td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HOTEL_USE}</span><br /><span class="gensmall">{L_RABBITOSHI_HOTEL_USE_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="hotel" value="1" {RABBITOSHI_HOTEL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HOTEL_PRICE}</span><br /><span class="gensmall">{L_RABBITOSHI_HOTEL_PRICE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="hotel_price" value="{RABBITOSHI_HOTEL_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HOTEL_EXP}</span><br /><span class="gensmall">{L_RABBITOSHI_HOTEL_EXP_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="exp_lose" value="{RABBITOSHI_HOTEL_EXP}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_EVOLUTION_USE}</span><br /><span class="gensmall">{L_RABBITOSHI_EVOLUTION_USE_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="evolution" value="1" {RABBITOSHI_EVOLUTION_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_EVOLUTION_PRICE}</span><br /><span class="gensmall">{L_RABBITOSHI_EVOLUTION_PRICE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="evolution_price" value="{RABBITOSHI_EVOLUTION_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_EVOLUTION_TIME}</span><br /><span class="gensmall">{L_RABBITOSHI_EVOLUTION_TIME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="evolution_time" value="{RABBITOSHI_EVOLUTION_TIME}" /></td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HUNGER_TIME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="11" size="11" name="hunger_time" value="{RABBITOSHI_HUNGER_TIME}" /> &nbsp;<span class="gen">{L_SECONDS}</span><br /><span class="gensmall">( {RABBITOSHI_HUNGER_TIME_EXPLAIN} )</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HUNGER_VALUE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hunger_value" value="{RABBITOSHI_HUNGER_VALUE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_THIRST_TIME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="11" size="11" name="thirst_time" value="{RABBITOSHI_THIRST_TIME}" /> &nbsp;<span class="gen">{L_SECONDS}</span><br /><span class="gensmall">( {RABBITOSHI_THIRST_TIME_EXPLAIN} )</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_THIRST_VALUE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="thirst_value" value="{RABBITOSHI_THIRST_VALUE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HEALTH_TIME}</span><br /><span class="gensmall">{L_RABBITOSHI_HEALTH_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="11" size="11" name="health_time" value="{RABBITOSHI_HEALTH_TIME}" /> &nbsp;<span class="gen">{L_SECONDS}</span><br /><span class="gensmall">( {RABBITOSHI_HEALTH_TIME_EXPLAIN} )</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HEALTH_VALUE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="health_value" value="{RABBITOSHI_HEALTH_VALUE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HYGIENE_TIME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="11" size="11" name="hygiene_time" value="{RABBITOSHI_HYGIENE_TIME}" /> &nbsp;<span class="gen">{L_SECONDS}</span><br /><span class="gensmall">( {RABBITOSHI_HYGIENE_TIME_EXPLAIN} )</span></td>  
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HYGIENE_VALUE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hygiene_value" value="{RABBITOSHI_HYGIENE_VALUE}" /></td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_LEVEL_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="level_price" value="{RABBITOSHI_LEVEL_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_ATTACK_RELOAD_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="attack_reload" value="{RABBITOSHI_ATTACK_RELOAD_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MAGIC_RELOAD_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="magic_reload" value="{RABBITOSHI_MAGIC_RELOAD_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HEALTH_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="health_price" value="{RABBITOSHI_HEALTH_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HEALTH_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="health_raise" value="{RABBITOSHI_HEALTH_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HUNGER_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hunger_price" value="{RABBITOSHI_HUNGER_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HUNGER_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hunger_raise" value="{RABBITOSHI_HUNGER_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_THIRST_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="thirst_price" value="{RABBITOSHI_THIRST_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_THIRST_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="thirst_raise" value="{RABBITOSHI_THIRST_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HYGIENE_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hygiene_price" value="{RABBITOSHI_HYGIENE_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_HYGIENE_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="hygiene_raise" value="{RABBITOSHI_HYGIENE_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_POWER_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="power_price" value="{RABBITOSHI_POWER_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_POWER_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="power_raise" value="{RABBITOSHI_POWER_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MAGICPOWER_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="magicpower_price" value="{RABBITOSHI_MAGICPOWER_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MAGICPOWER_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="magicpower_raise" value="{RABBITOSHI_MAGICPOWER_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_ARMOR_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="armor_price" value="{RABBITOSHI_ARMOR_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_ARMOR_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="armor_raise" value="{RABBITOSHI_ARMOR_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_ATTACK_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="attack_price" value="{RABBITOSHI_ATTACK_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_ATTACK_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="attack_raise" value="{RABBITOSHI_ATTACK_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MAGICATTACK_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="magicattack_price" value="{RABBITOSHI_MAGICATTACK_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MAGICATTACK_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="magicattack_raise" value="{RABBITOSHI_MAGICATTACK_RAISE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MP_PRICE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="mp_price" value="{RABBITOSHI_MP_PRICE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MP_RAISE}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="mp_raise" value="{RABBITOSHI_MP_RAISE}" /></td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_EXPERIENCE_MIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="experience_min" value="{RABBITOSHI_EXPERIENCE_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_EXPERIENCE_MAX}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="experience_max" value="{RABBITOSHI_EXPERIENCE_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MP_MIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="mp_min" value="{RABBITOSHI_MP_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_MP_MAX}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="mp_max" value="{RABBITOSHI_MP_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_LEVEL_UP_PENALTY}</span><br /><span class="gensmall">{L_RABBITOSHI_LEVEL_UP_PENALTY_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="255" size="15" name="level_up_penalty" value="{RABBITOSHI_LEVEL_UP_PENALTY}" />%</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />