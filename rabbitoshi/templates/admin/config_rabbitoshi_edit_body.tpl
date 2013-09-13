<h1>{L_RABBITOSHI_TITLE}</h1>

<p>{L_RABBITOSHI_EXPLAIN}</p>

<form method="post" action="{S_RABBITOSHI_ACTION}">

<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="95%">
	<tr>
		<th colspan="2">{L_RABBITOSHI_CONFIG}</th>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_RABBITOSHI_NAME}</span>&nbsp;<span class="gen">{RABBITOSHI_NAME_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="text" class="post" name="creature_name" value="{RABBITOSHI_NAME}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_IMG}</span><br /><span class="gensmall">{L_RABBITOSHI_IMG_EXPLAIN}</span></td>
                <!-- BEGIN rabbitoshi_add -->
		<td class="row2"><input type="text" class="post" name="creature_img" size="30" maxlength="255" /></td>
                <!-- END rabbitoshi_add -->
                <!-- BEGIN rabbitoshi_edit -->
		<td class="row2"><input type="text" class="post" name="creature_img" value="{RABBITOSHI_IMG}" size="30" maxlength="255" /><br /><img src="../rabbitoshi/images/pets/{RABBITOSHI_IMG_EX}" alt="{RABBITOSHI_NAME}" /></td>
                <!-- END rabbitoshi_edit -->
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_PRIZE}</span></td>
		<td class="row2"><input type="text" class="post" name="prize" value="{RABBITOSHI_PRIZE}" size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_RHEALTH}</span></td>
		<td class="row2"><input type="text" class="post" name="rhealth" value="{RABBITOSHI_RHEALTH}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_RFOOD}</span></td>
		<td class="row2"><input type="text" class="post" name="rfood" value="{RABBITOSHI_RFOOD}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_RTHIRST}</span></td>
		<td class="row2"><input type="text" class="post" name="rthirst" value="{RABBITOSHI_RTHIRST}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_RDIRT}</span></td>
		<td class="row2"><input type="text" class="post" name="rdirt" value="{RABBITOSHI_RDIRT}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MP}</span></td>
		<td class="row2"><input type="text" class="post" name="mp" value="{RABBITOSHI_MP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_POWER}</span></td>
		<td class="row2"><input type="text" class="post" name="power" value="{RABBITOSHI_POWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MAGICPOWER}</span></td>
		<td class="row2"><input type="text" class="post" name="magicpower" value="{RABBITOSHI_MAGICPOWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_ARMOR}</span></td>
		<td class="row2"><input type="text" class="post" name="armor" value="{RABBITOSHI_ARMOR}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_ATTACK}</span></td>
		<td class="row2"><input type="text" class="post" name="attack" value="{RABBITOSHI_ATTACK}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MAGICATTACK}</span></td>
		<td class="row2"><input type="text" class="post" name="magicattack" value="{RABBITOSHI_MAGICATTACK}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_EXPERIENCE}</span></td>
		<td class="row2"><input type="text" class="post" name="experience" value="{RABBITOSHI_EXPERIENCE}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_HEALTH_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_HEALTH_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="health_levelup" value="{RABBITOSHI_HEALTH_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_HUNGER_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_HUNGER_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="hunger_levelup" value="{RABBITOSHI_HUNGER_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_THIRST_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_THIRST_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="thirst_levelup" value="{RABBITOSHI_THIRST_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_HYGIENE_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_HYGIENE_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="hygiene_levelup" value="{RABBITOSHI_HYGIENE_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_POWER_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_POWER_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="power_levelup" value="{RABBITOSHI_POWER_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MAGICPOWER_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_MAGICPOWER_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="magicpower_levelup" value="{RABBITOSHI_MAGICPOWER_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_ARMOR_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_ARMOR_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="armor_levelup" value="{RABBITOSHI_ARMOR_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MP_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_MP_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="mp_levelup" value="{RABBITOSHI_MP_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_ATTACK_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_ATTACK_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="attack_levelup" value="{RABBITOSHI_ATTACK_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_MAGICATTACK_LEVELUP}</span><br /><span class="gensmall">{L_RABBITOSHI_MAGICATTACK_LEVELUP_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="magicattack_levelup" value="{RABBITOSHI_MAGICATTACK_LEVELUP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RABBITOSHI_FOOD_TYPE}</span></td>
		<td class="row2"><select name="food_type">{RABBITOSHI_FOOD_TYPE}</select></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_BUYABLE}</span><br /><span class="gensmall">{L_RABBITOSHI_BUYABLE_EXPLAIN}</span></td>
		<td class="row2"><input type="checkbox" name="buyable" value="1" {RABBITOSHI_BUYABLE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_EVOLUTION}</span><br /><span class="gensmall">{L_RABBITOSHI_EVOLUTION_OF_EXPLAIN}</span></td>
		<td class="row2"><select name="evolution_of">{RABBITOSHI_EVOLUTION_OF}</select></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>