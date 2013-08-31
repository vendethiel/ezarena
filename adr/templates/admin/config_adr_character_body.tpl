<script language="Javascript" type="text/javascript">
<!--
function setCheckboxes(theForm, elementName, isChecked)
{
	var chkboxes = document.forms[theForm].elements[elementName];
	var count = chkboxes.length;

	if (count)
	{
		for (var i = 0; i < count; i++)
		{
			chkboxes[i].checked = isChecked;
	    	}
	}
	else
	{
    		chkboxes.checked = isChecked;
	}
	return true;
}

//-->
</script>

<!-- BEGIN edit -->
<h1>{L_USER_TITLE}</h1>

<p>{L_USER_EXPLAIN}</p>

<form method="post" action="{S_CHARACTER_ACTION}">

<table cellspacing="2" cellpadding="1" border="1" align="center" class="forumline" width="70%" >
	<tr>
		<th align="center" colspan="3">{L_CHARACTER_OF}</th>
	</tr>
	<tr>
		<td class="row1" align="center" width="70%" colspan="3"><b><span class="gen"><input type="post" name="character_name" value="{NAME}"></span></b>
		<br /><span class="gen"><b>{L_LEVEL}: <input type="post" name="character_level" value="{LEVEL}" size="3"></b></span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_CLASS}</span></td>
		<td class="row1" align="center"><span class="gensmall">{CLASSES_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_RACE}</span></td>
		<td class="row2" align="center"><span class="gensmall">{RACES_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_ELEMENT}</span></td>
		<td class="row2" align="center"><span class="gensmall">{ELEMENTS_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_ALIGNMENT}</span></td>
		<td class="row2" align="center"><span class="gensmall">{ALIGNMENTS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" colspan="2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_INVENTORY}';"><span class="gen">{L_INVENTORY}</span></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="70%" >
	<tr>
		<th align="center" colspan="2">{L_CHARACTERISTICS}</th>
	</tr>
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gensmall">{L_HEALTH} <input type="post" name="character_hp" value="{HP}" size="5"> / <input type="post" name="character_hp_max" value="{HP_MAX}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gensmall">{L_MAGIC} <input type="post" name="character_mp" value="{MP}" size="5"> / <input type="post" name="character_mp_max" value="{MP_MAX}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row2" colspan="2" ><span class="gensmall">{L_EXPERIENCE} <input type="post" name="character_xp" value="{EXP}" size="5"> / {EXP_MAX}</td>
	</tr>
	<tr>
		<td align="center" class="row2" colspan="2" ><span class="gensmall">{L_SP} <input type="post" name="character_sp" value="{SP}" size="8"></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_AC}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_ac" value="{AC}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_POWER}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_might" value="{POWER}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_AGILITY}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_dexterity" value="{AGILITY}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_CONSTIT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_constitution" value="{CONSTIT}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_INT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_intelligence" value="{INT}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_WIS}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_wisdom" value="{WIS}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_CHA}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_charisma" value="{CHA}" size="5"></span></td>
	</tr>
</table>


<br clear="all" />

<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="70%" >
	<tr>
		<th align="center" colspan="2">{L_BATTLE_STATISTICS}</th>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_BATTLE_VICTORIES}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_victories" value="{BATTLE_VICTORIES}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_BATTLE_DEFEATS}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_defeats" value="{BATTLE_DEFEATS}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_BATTLE_FLEES}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_flees" value="{BATTLE_FLEES}" size="5"></span></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="70%" >
	<tr>
		<th align="center" colspan="2">{L_BATTLE_SKILLS}</th>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_BATTLE_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_battle_limit" value="{BATTLE_LIMIT}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_SKILL_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_skill_limit" value="{SKILL_LIMIT}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_TRADING_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_trading_limit" value="{TRADING_LIMIT}" size="5"></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_THIEF_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen"><input type="post" name="character_thief_limit" value="{THIEF_LIMIT}" size="5"></span></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="70%" >
	<tr>
		<th align="center" colspan="5">{L_SKILLS}</th>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gensmall">{L_MINING} : <input type="post" name="character_skill_mining_uses" value="{MINING_MIN}" size="5"> / {MINING_MAX}</td>
		<td align="center" class="row2"><span class="gensmall">{L_LEVEL} : <input type="post" name="character_skill_mining" value="{MINING}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gensmall">{L_STONE} : <input type="post" name="character_skill_stone_uses" value="{STONE_MIN}" size="5"> / {STONE_MAX}</td>
		<td align="center" class="row2"><span class="gensmall">{L_LEVEL} : <input type="post" name="character_skill_stone" value="{STONE}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gensmall">{L_FORGE} : <input type="post" name="character_skill_forge_uses" value="{FORGE_MIN}" size="5"> / {FORGE_MAX}</td>
		<td align="center" class="row2"><span class="gensmall">{L_LEVEL} : <input type="post" name="character_skill_forge" value="{FORGE}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gensmall">{L_ENCHANTMENT} : <input type="post" name="character_skill_enchantment_uses" value="{ENCHANTMENT_MIN}" size="5"> / {ENCHANTMENT_MAX}</td>
		<td align="center" class="row2"><span class="gensmall">{L_LEVEL} : <input type="post" name="character_skill_enchantment" value="{ENCHANTMENT}" size="5"></td>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gensmall">{L_THIEF} : <input type="post" name="character_skill_thief_uses" value="{THIEF_MIN}" size="5"> / {THIEF_MAX}</td>
		<td align="center" class="row2"><span class="gensmall">{L_LEVEL} : <input type="post" name="character_skill_thief" value="{THIEF}" size="5"></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="70%">
	<tr>
		<th align="center" width="50%">{L_BIO}</th>
	</tr>
	<tr>
		<td align="center" class="row1"><textarea name="new_bio" rows="10" cols="40" wrap="virtual" style="width:450px" tabindex="3" class="post" >{NEW_BIO}</textarea></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="100%" >
	<tr height="25">
		<td align="center" class="row2" >
			<input type="hidden" name="mode" value="validate" />
			<input type="submit" value="{L_EDIT_CHARACTER}" class="mainoption" />
		</td>
	</tr>
	</form><form method="post" action="{S_CHARACTER_ACTION}">
	<tr height="25">
		<td align="center" class="row2" >
			<input type="hidden" name="mode" value="delete" />
			<input type="submit" value="{L_DELETE_CHARACTER}" class="mainoption" />
		</td>
	</tr>
</table>

<br clear="all" />


</form>
<!-- END edit -->

<!-- BEGIN inventory -->
<h1>{L_USER_TITLE}</h1>
<p>{L_USER_EXPLAIN}</p>
</form>
<form method="post" action="{S_CHARACTER_ACTION_INVENTORY}" name="items_form" >
<br />
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catHead"><span class="gen">{OWNER_NAME}{OWNER_S}{INVENTORY_NAME}</span></td>
	</tr>
</table>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">
			{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
			{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
			{L_SELECT_CAT}&nbsp;:&nbsp;{SELECT_CAT}&nbsp;&nbsp;
			<input type="submit" value="{L_SORT}" class="liteoption" /></span>
		</td>
		<td align="center" nowrap="nowrap">
			<span class="genmed">
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', true); return false;" class="gensmall">{L_CHECK_ALL}</a>&nbsp;/&nbsp;
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', false); return false;" class="gensmall">{L_UNCHECK_ALL}</a>
			</span>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center">{L_ITEM_IMG}</th>
		<th align="center">{L_ITEM_NAME}<br /><font size="1">{L_ITEM_DESC}</font></th>
		<th align="center">{L_ITEM_PRICE}</th>
		<th align="center">{L_ITEM_QUALITY}</th>
		<th align="center">{L_ITEM_POWER}</th>
		<th align="center">{L_ITEM_DURATION}</th>
		<th align="center">{L_ITEM_TYPE}</th>
		<th align="center">{L_ACTION}</th>
	</tr>
	<!-- BEGIN items -->
	<tr height="30"> 
		<td class="{inventory.items.ROW_CLASS}" align="center" ><img style="border:0" src="./../adr/images/items/{inventory.items.ITEM_IMG}"></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" ><span class="gen">{inventory.items.ITEM_NAME}</font></span></a><br /><span class="gensmall">{inventory.items.ITEM_DESC}</ span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" ><span class="gen">{inventory.items.ITEM_PRICE}</span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" ><span class="gen">{inventory.items.ITEM_QUALITY}</span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" ><span class="gen">{inventory.items.ITEM_POWER}</span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">{inventory.items.ITEM_DURATION} / {inventory.items.ITEM_DURATION_MAX}</span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center" ><span class="gen">{inventory.items.ITEM_TYPE}</span></td>
		<td class="{inventory.items.ROW_CLASS}" align="center">
			<input type="hidden" name="edit_owner_id" value="{inventory.items.OWNER_ID}" />
			<input type="checkbox" name="item_box[]" value="{inventory.items.ITEM_ID}" />
		</td>
	</tr>
	<!-- END items -->
	<tr> 
		<td class="catBottom" colspan="10" height="28" align="right">	{ACTION_SELECT}&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

</form>
<!-- END inventory -->
