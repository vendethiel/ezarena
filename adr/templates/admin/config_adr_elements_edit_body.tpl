
<form method="post" action="{S_RACES_ACTION}">

<h1>{L_ELEMENTS_TITLE}</h1>

<p>{L_ELEMENTS_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="element_name" value="{ELEMENT_NAME}" size="30" maxlength="255" />
	<!-- BEGIN elements_edit -->
		<br /><span class="gensmall">{ELEMENT_NAME_EXPLAIN}</span>
	<!-- END elements_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="element_desc" value="{ELEMENT_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN elements_edit -->
		<br /><span class="gensmall">{ELEMENT_DESC_EXPLAIN}</span>
	<!-- END elements_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN elements_add -->
		<td class="row2" align="center" ><input type="text" name="element_img" size="30" maxlength="255" /></td>
	<!-- END elements_add -->
	<!-- BEGIN elements_edit -->
		<td class="row2" align="center" ><input type="text" name="element_img" value="{ELEMENT_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/elements/{ELEMENT_IMG_EX}" alt="{ELEMENT_NAME}" /></td>
	<!-- END elements_edit -->
	</tr>
	<tr>
		<td class="row1">{L_LEVEL}<br /><span class="gensmall">{L_LEVEL_EXPLAIN}</span></td>
		<td class="row2" align="center" >{LEVEL_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_ELEMENT_COLOUR}:<br /><span class="gensmall"><i>{L_ELEMENT_COLOUR_EX}</i></span></td>
		<td class="row2" align="center"><input type="text" name="element_colour" value="{ELEMENT_COLOUR}" size="15" maxlength="100" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_MINING_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="mining_bonus" value="{MINING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_STONE_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="stone_bonus" value="{STONE_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FORGE_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="forge_bonus" value="{FORGE_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ENCHANT_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="enchant_bonus" value="{ENCHANT_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<!-- <tr>
		<td class="row1">{L_TRADING_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="trading_bonus" value="{TRADING_BONUS}" size="8" maxlength="8" /></td>
	</tr> -->
	<tr>
		<td class="row1">{L_THIEF_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="thief_bonus" value="{THIEF_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BREWING_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="brewing_bonus" value="{BREWING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_COOKING_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="cooking_bonus" value="{COOKING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BLACKSMITHING_BONUS}</td>
		<td class="row2" align="center" ><input type="text" name="blacksmithing_bonus" value="{BLACKSMITHING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FISHING_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="fishing_bonus" value="{FISHING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_HERBALISM_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="herbalism_bonus" value="{HERBALISM_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_LUMBERJACK_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="lumberjack_bonus" value="{LUMBERJACK_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_HUNTING_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="hunting_bonus" value="{HUNTING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_TAILORING_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="tailoring_bonus" value="{TAILORING_BONUS}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ALCHEMY_BONUS}</td>
		<td class="row2" align="center"  ><input type="text" name="alchemy_bonus" value="{ALCHEMY_BONUS}" size="8" maxlength="8" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_OPPOSE_STRONG}</td>
		<td class="row2" align="center" ><span class="gensmall">{ELEMENT_STR_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_OPPOSE_STRONG_DMG}</td>
		<td class="row2" align="center" ><input type="text" name="oppose_str_dmg" value="{OPPOSE_STR_DMG}" size="3" maxlength="3" />%</td>
	</tr>
	<tr>
		<td class="row1">{L_OPPOSE_SAME_DMG}</td>
		<td class="row2" align="center" ><input type="text" name="oppose_same_dmg" value="{OPPOSE_SAME_DMG}" size="3" maxlength="3" />%</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_OPPOSE_WEAK}</td>
		<td class="row2" align="center" ><span class="gensmall">{ELEMENT_WEAK_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_OPPOSE_WEAK_DMG}</td>
		<td class="row2" align="center" ><input type="text" name="oppose_weak_dmg" value="{OPPOSE_WEAK_DMG}" size="3" maxlength="3" />%</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>