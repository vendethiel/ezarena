
<h1>{L_RABBITOSHI_TITLE}</h1>

<p>{L_RABBITOSHI_EXPLAIN}</p>


<form method="post" action="{S_RABBITOSHI_ACTION}"><table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<th class="thHead" colspan="2">{L_RABBITOSHI_CONFIG}</th>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_NAME}<br /><span class="gensmall">{L_RABBITOSHI_NAME_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="creature_name" value="{RABBITOSHI_NAME}" size="30" maxlength="255" /><br /><span class="gensmall">{RABBITOSHI_NAME_EXPLAIN}</span><td>
	</tr>
	<tr>
		<td class="row1">{L_RABBITOSHI_IMG}<br /><span class="gensmall">{L_RABBITOSHI_IMG_EXPLAIN}</span></td>
	<!-- BEGIN rabbitoshi_add -->
		<td class="row1"><input type="text" name="creature_img" size="30" maxlength="255" /></td>
	<!-- END rabbitoshi_add -->
	<!-- BEGIN rabbitoshi_edit -->
		<td class="row1"><input type="text" name="creature_img" value="{RABBITOSHI_IMG}" size="30" maxlength="255" /><br /><img src="../images/Rabbitoshi/{RABBITOSHI_IMG_EX}" alt="{RABBITOSHI_NAME}" /></td>
	<!-- END rabbitoshi_edit -->
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_PRIZE}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="prize"  value="{RABBITOSHI_PRIZE}" size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_RHEALTH}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="rhealth"  value="{RABBITOSHI_RHEALTH}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_RFOOD}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="rfood"  value="{RABBITOSHI_RFOOD}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_RTHIRST}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="rthirst" value="{RABBITOSHI_RTHIRST}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_RDIRT}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="rdirt"  value="{RABBITOSHI_RDIRT}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_MP}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="mp"  value="{RABBITOSHI_MP}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_POWER}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="power"  value="{RABBITOSHI_POWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_MAGICPOWER}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="magicpower"  value="{RABBITOSHI_MAGICPOWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_ARMOR}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="armor"  value="{RABBITOSHI_ARMOR}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_ATTACK}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="attack"  value="{RABBITOSHI_ATTACK}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_MAGICATTACK}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="magicattack"  value="{RABBITOSHI_MAGICATTACK}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_EXPERIENCE}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="experience"  value="{RABBITOSHI_EXPERIENCE}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="row2">{L_RABBITOSHI_FOOD_TYPE}</td>
		<td class="row2" width="60%" align="left"><select name="food_type">{RABBITOSHI_FOOD_TYPE}</select></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_BUYABLE}</span><br /><span class="gensmall">{L_RABBITOSHI_BUYABLE_EXPLAIN}</span></td>
		<td class="row2" width="60%" align="left"><input type="checkbox" name="buyable" value="1" {RABBITOSHI_BUYABLE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_EVOLUTION}</span><br /><span class="gensmall">{L_RABBITOSHI_EVOLUTION_OF_EXPLAIN}</span></td>
		<td class="row2" width="60%" align="left"><select name="evolution_of">{RABBITOSHI_EVOLUTION_OF}</select></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table></form>