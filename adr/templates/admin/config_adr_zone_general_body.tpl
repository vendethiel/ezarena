<h1>{L_ZONE_GENERAL_TITLE}</h1>

<P>{L_ZONE_GENERAL_EXPLAIN}</p>

<form method="post" action="{S_ZONE_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="row1" width="60%">{L_ZONE_DEAD_TRAVEL}</td>
		<td class="row1" align="center" ><input type="checkbox" name="dead_travel" value="1" {ZONE_DEAD_TRAVEL} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_BONUS_STAT}</td>
		<td class="row2" align="center" ><input type="checkbox" name="stat_bonus" value="1" {ZONE_BONUS_STAT} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_BONUS_ATT}</td>
		<td class="row1" align="center"><input type="post" name="att_bonus" maxlength="8" size="8" value="{ZONE_BONUS_ATT}" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_BONUS_DEF}</span></td>
		<td class="row2" align="center"><input type="post" name="def_bonus" maxlength="8" size="8" value="{ZONE_BONUS_DEF}" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="12" align="center"><input type="submit" name="submit" value="{L_ZONE_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />