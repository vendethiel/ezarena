
<form method="post" action="{S_ITEMS_ACTION}">

<h1>{L_ITEMS_TITLE}</h1>

<p>{L_ITEMS_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_name" value="{ITEM_NAME}" size="30" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{ITEM_NAME_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_desc" value="{ITEM_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{ITEM_DESC_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN add -->
		<td class="row2" align="center" ><input type="text" name="item_img" size="30" maxlength="255" /></td>
	<!-- END add -->
	<!-- BEGIN edit -->
		<td class="row2" align="center" ><input type="text" name="item_img" value="{ITEM_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/items/{ITEM_IMG}" alt="{ITEM_NAME}" /></td>
	<!-- END edit -->
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_TYPE}<br /><span class="gensmall"><i>{L_ITEM_TYPE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" >{ITEM_TYPE}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_LEVEL}<br /><span class="gensmall"><i>{L_ITEM_LEVEL_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="item_level" size="8" maxlength="8" value="{ITEM_LEVEL}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_POWER}</td>
		<td class="row2" align="center" ><input type="text" name="item_power" size="8" maxlength="8" value="{ITEM_POWER}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_RECIPE}</td><br /><span class="gensmall"><i>{L_ITEM_RECIPE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" >{ITEM_RECIPE}</td>
	</tr>
        <tr>
                <td class="row1" width="60%">{L_CLASS_LIMIT}<span class="gensmall"><br /><i>{L_CLASS_LIMIT_EXPLAIN}</i></span></td>
                <td class="row2" align="center" >{ITEM_CLASS_LIMIT}</td>
        </tr> 
        <tr>
                <td class="row1" width="60%">{L_ALIGNMENT_LIMIT}<span class="gensmall"><br /><i>{L_ALIGNMENT_LIMIT_EXPLAIN}</i></span></td>
                <td class="row2" align="center" >{ITEM_ALIGNMENT_LIMIT}</td>
        </tr> 
        <tr>
                <td class="row1" width="60%">{L_ELEMENT_LIMIT}<span class="gensmall"><br /><i>{L_ELEMENT_LIMIT_EXPLAIN}</i></span></td>
                <td class="row2" align="center" >{ITEM_ELEMENT_LIMIT}</td>
        </tr> 
	<tr>
		<td class="row1" width="60%">{L_ITEM_ADD_POWER}<br /><span class="gensmall"><i>{L_ITEM_ADD_POWER_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="item_add_power" size="5" maxlength="5" value="{ITEM_ADD_POWER}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_MP_USE}<br /><span class="gensmall"><i>{L_ITEM_MP_USE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="item_mp_use" size="5" maxlength="5" value="{ITEM_MP_USE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_AUTH}<br /><span class="gensmall"><i>{L_ITEM_AUTH_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="checkbox" name="item_auth" value="1" {ITEM_AUTH} /></td>
	</tr>
	<tr>
		<td class="row1" width="75%">{L_ITEM_BATTLE}<br><span class="gensmall"><i>{L_ITEM_BATTLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><span class="gensmall">{ITEM_BATTLE_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_XTREME}<br /><span class="gensmall"><i>{L_ITEM_XTREME_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><textarea name="spell_xtreme" cols="50" rows="5" class="post">{ITEM_XTREME}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_XTREME_BATTLE}<br /><span class="gensmall"><i>{L_ITEM_XTREME_BATTLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><textarea name="spell_xtreme_battle" cols="50" rows="5" class="post">{ITEM_XTREME_BATTLE}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_XTREME_PVP}<br /><span class="gensmall"><i>{L_ITEM_XTREME_PVP_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><textarea name="spell_xtreme_pvp" cols="50" rows="5" class="post">{ITEM_XTREME_PVP}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEMS_REQ}<br /><span class="gensmall"><i>{L_ITEMS_REQ_DESC}</i></span></td>					
		<td class="row2" align="center" >{ITEMS_REQ}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEMS_AMOUNT}<br /><span class="gensmall"><i>{L_ITEMS_AMOUNT_DESC}</i></span></td>					
		<td class="row2" align="center" ><input type="text" name="recipe_items_amount" value="{ITEMS_AMOUNT}" size="30" maxlength="255" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_ITEM_ELEMENT}</td>
		<td class="row2" align="center" ><span class="gensmall">{ITEM_ELEMENT_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_ELEMENT_STR}</td>
		<td class="row2" align="center" ><input type="text" name="item_element_str" size="4" maxlength="4" value="{ITEM_ELEMENT_STR}" />%</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_ELEMENT_SAME}</td>
		<td class="row2" align="center" ><input type="text" name="item_element_same" size="4" maxlength="4" value="{ITEM_ELEMENT_SAME}" />%</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_ELEMENT_WEAK}</td>
		<td class="row2" align="center" ><input type="text" name="item_element_weak" size="4" maxlength="4" value="{ITEM_ELEMENT_WEAK}" />%</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>