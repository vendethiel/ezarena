
<form method="post" action="{S_SETS_ACTION}">

<h1>{L_SET_TITLE}</h1>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_SET_NAME}</td>
		<td class="row2" align="center" ><input type="text" name="set_name" value="{SET_NAME}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_SET_DESC}<br /><span class="gensmall">{L_SET_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="set_desc" value="{SET_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{SET_DESC_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_SET_IMG}<br /><span class="gensmall">{L_SET_IMG_EXPLAIN}</span></td>
	<!-- BEGIN add -->
		<td class="row2" align="center" ><input type="text" name="set_img" size="30" maxlength="50" /></td>
	<!-- END add -->
	<!-- BEGIN edit -->
		<td class="row2" align="center" ><input type="text" name="set_img" value="{SET_IMG}" size="30" maxlength="50" /><br /><img src="../adr/images/sets/{SET_IMG}" alt="{SET_NAME}" /></td>
	<!-- END edit -->
	</tr>
	<tr>
		<td class="row1">{L_SET_HELM}</td>
		<td class="row2" align="center" >{HELM_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_SET_ARMOUR}</td>
		<td class="row2" align="center" >{ARMOUR_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_SET_GLOVES}</td>
		<td class="row2" align="center" >{GLOVES_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_SET_SHIELD}</td>
		<td class="row2" align="center" >{SHIELD_LIST}</td>
	</tr>

	<tr>
		<td class="row1">{L_SET_MIGHT_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_might_bonus" size="8" maxlength="8" value="{MIGHT_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_MIGHT_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_might_penalty" size="8" maxlength="8" value="{MIGHT_PEN}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_CON_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_con_bonus" size="8" maxlength="8" value="{CON_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_CON_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_con_penalty" size="8" maxlength="8" value="{CON_PEN}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_AC_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_ac_bonus" size="8" maxlength="8" value="{AC_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_AC_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_ac_penalty" size="8" maxlength="8" value="{AC_PEN}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_DEX_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_dex_bonus" size="8" maxlength="8" value="{DEX_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_DEX_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_dex_penalty" size="8" maxlength="8" value="{DEX_PEN}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_INT_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_int_bonus" size="8" maxlength="8" value="{INT_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_INT_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_int_penalty" size="8" maxlength="8" value="{INT_PEN}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_WIS_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="set_wis_bonus" size="8" maxlength="8" value="{WIS_BONUS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SET_WIS_PEN}</td>
		<td class="row2" align="center" ><input type="text" name="set_wis_penalty" size="8" maxlength="8" value="{WIS_PEN}" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>