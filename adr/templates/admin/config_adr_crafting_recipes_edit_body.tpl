<form method="post" action="{S_ITEMS_ACTION}">

<h1>{L_RECIPES_TITLE}</h1>

<p>{L_RECIPES_EXPLAIN}</p>


<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1"><h3>Settings for the Recipe</h3></td>
		<td class="row2"></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_NAME}<br /><span class="gensmall">{L_RECIPE_NAME_DESC}</span></td>					
		<td class="row2" align="center" ><input type="text" name="recipe_name" value="{RECIPE_NAME}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_DESC}<br /><span class="gensmall">{L_RECIPE_DESC_DESC}</span></td>					
		<td class="row2" align="center" ><input type="text" name="recipe_desc" value="{RECIPE_DESC}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_IMG}<br /><span class="gensmall">{L_RECIPE_IMG_DESC}</span></td>					
	<!-- BEGIN add -->
		<td class="row2" align="center" ><input type="text" name="recipe_img" size="30" maxlength="255" /></td>
	<!-- END add -->
	<!-- BEGIN edit -->
		<td class="row2" align="center" ><input type="text" name="recipe_img" value="{RECIPE_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/items/{RECIPE_IMG}" alt="{RECIPE_NAME}" /></td>
	<!-- END edit -->
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_QUALITY}</td>
		<td class="row2" align="center" >{RECIPE_QUALITY}</td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_TYPE}</td>
		<td class="row2" align="center" >{RECIPE_TYPE}</td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_SKILL}<br /><span class="gensmall">{L_RECIPE_SKILL_EXPLAIN}</span></td>
		<td class="row2" align="center" >{RECIPE_SKILL_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_LEVEL}<br /><span class="gensmall">{L_RECIPE_LEVEL_DESC}</span></td>					
		<td class="row2" align="center" ><input type="text" name="recipe_level" value="{RECIPE_LEVEL}" size="5" maxlength="5" /></td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_DURATION}</td>
		<td class="row2" align="center" ><input type="text" name="recipe_duration" size="8" maxlength="8" value="{RECIPE_DURATION}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_DURATION_MAX}</td>
		<td class="row2" align="center" ><input type="text" name="recipe_duration_max" size="8" maxlength="8" value="{RECIPE_DURATION_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_PRICE}<br /><span class="gensmall">{L_RECIPE_PRICE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="recipe_price" size="8" maxlength="8" value="{RECIPE_PRICE}" />&nbsp;<span class="gensmall">{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_SELL_BACK_PERCENT}<br /><span class="gensmall">{L_RECIPE_SELL_BACK_PERCENT_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="recipe_sell_back_percent" size="8" maxlength="3" value="{RECIPE_SELL_BACK_PERCENT}" />&nbsp;%</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_ADMIN_ONLY}<br /><span class="gensmall">{L_RECIPE_ADMIN_ONLY_DESC}</span></td>					
		<td class="row2" align="center" ><input type="checkbox" name="recipe_admin_only" value="1" {RECIPE_ADMIN_ONLY} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_WEIGHT}</td>
		<td class="row2" align="center" ><input type="text" name="recipe_weight" size="8" maxlength="8" value="{RECIPE_WEIGHT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_RECIPE_STORE}</td>
		<td class="row2" align="center" ><span class="gensmall">{RECIPE_STORE_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%">{L_RECIPE_STEAL}<br><span class="gensmall"><i>{L_RECIPE_STEAL_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><span class="gensmall">{RECIPE_STEAL_LIST}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<th align="center" colspan="3">{L_RESTRICT_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top"><b>{L_RESTRICT_LEVEL}</b>:<br><span class="gensmall"><i>{L_RESTRICT_LEVEL_EXPLAIN}</i></span></td>
		<td class="row2" align="center" colspan="2">
            <input type="text" name="recipe_restrict_level" size="5" maxlength="5" value="{RECIPE_RESTRICT_LEVEL}" />
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top" rowspan="3"><b>{L_RESTRICT_CHARS}</b>:<br><span class="gensmall"><i>{L_RESTRICT_CHARS_EXPLAIN}</i></span></td>
		<td class="row2" align="center" width="12%"><span class="gensmall"><b>{L_RESTRICT_STR}</b></span><br>
            <input type="text" name="recipe_restrict_str" size="5" maxlength="5" value="{RECIPE_RESTRICT_STR}" /></td>
		<td class="row2" align="center" width="13%"><span class="gensmall"><b>{L_RESTRICT_DEX}</b></span><br>
            <input type="text" name="recipe_restrict_dex" size="5" maxlength="5" value="{RECIPE_RESTRICT_DEX}" /></td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall"><b>{L_RESTRICT_INT}</b></span><br>
            <input type="text" name="recipe_restrict_int" size="5" maxlength="5" value="{RECIPE_RESTRICT_INT}" /></td>
		<td class="row2" align="center"><span class="gensmall"><b>{L_RESTRICT_WIS}</b></span><br>
            <input type="text" name="recipe_restrict_wis" size="5" maxlength="5" value="{RECIPE_RESTRICT_WIS}" /></td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall"><b>{L_RESTRICT_CHA}</b></span><br>
            <input type="text" name="recipe_restrict_cha" size="5" maxlength="5" value="{RECIPE_RESTRICT_CHA}" /></td>
		<td class="row2" align="center"><span class="gensmall"><b>{L_RESTRICT_CON}</b></span><br>
            <input type="text" name="recipe_restrict_con" size="5" maxlength="5" value="{RECIPE_RESTRICT_CON}" /></td>
	</tr>
	<tr>
		<td class="row1" width="75%"><b>{L_RESTRICT_ALIGNMENT_ENABLE}</b>:<br><span class="gensmall"><i>{L_RESTRICT_ALIGNMENT_ENABLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" colspan="2"><input type="checkbox" name="recipe_alignment_enable" value="1" {RECIPE_ALIGNMENT_TYPE_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top"><b>{L_RESTRICT_ALIGNMENT}</b>:</td>
		<td class="row2" align="center" colspan="2">{RECIPE_ALIGNMENT_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="75%"><b>{L_RESTRICT_CLASS_ENABLE}</b>:<br><span class="gensmall"><i>{L_RESTRICT_CLASS_ENABLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" colspan="2"><input type="checkbox" name="recipe_class_enable" value="1" {RECIPE_CLASS_TYPE_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top"><b>{L_RESTRICT_CLASS}</b>:</td>
		<td class="row2" align="center" colspan="2">{RECIPE_CLASS_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="75%"><b>{L_RESTRICT_ELEMENT_ENABLE}</b>:<br><span class="gensmall"><i>{L_RESTRICT_ELEMENT_ENABLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" colspan="2"><input type="checkbox" name="recipe_element_enable" value="1" {RECIPE_ELEMENT_TYPE_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top"><b>{L_RESTRICT_ELEMENT}</b>:</td>
		<td class="row2" align="center" colspan="2">{RECIPE_ELEMENT_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="75%"><b>{L_RESTRICT_RACE_ENABLE}</b>:<br><span class="gensmall"><i>{L_RESTRICT_RACE_ENABLE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" colspan="2"><input type="checkbox" name="recipe_race_enable" value="1" {RECIPE_RACE_TYPE_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="75%" valign="top"><b>{L_RESTRICT_RACE}</b>:</td>
		<td class="row2" align="center" colspan="2">{RECIPE_RACE_LIST}</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1"><h3>Settings for the product (just create a normal item now)</h3></td>
		<td class="row2"></td>
	</tr>
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
		<td class="row1">{L_ITEM_QUALITY}</td>
		<td class="row2" align="center" >{ITEM_QUALITY}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_TYPE}</td>
		<td class="row2" align="center" >{ITEM_TYPE}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_POWER}</td>
		<td class="row2" align="center" ><input type="text" name="item_power" size="8" maxlength="8" value="{ITEM_POWER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_ADD_POWER}<br /><span class="gensmall"><i>{L_ITEM_ADD_POWER_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="item_add_power" size="5" maxlength="5" value="{ITEM_ADD_POWER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_MP_USE}<br /><span class="gensmall"><i>{L_ITEM_MP_USE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="item_mp_use" size="5" maxlength="5" value="{ITEM_MP_USE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DURATION}</td>
		<td class="row2" align="center" ><input type="text" name="item_duration" size="8" maxlength="8" value="{ITEM_DURATION}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DURATION_MAX}</td>
		<td class="row2" align="center" ><input type="text" name="item_duration_max" size="8" maxlength="8" value="{ITEM_DURATION_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_PRICE}<br /><span class="gensmall">{L_ITEM_PRICE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_price" size="8" maxlength="8" value="{ITEM_PRICE}" />&nbsp;<span class="gensmall">{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_SELL_BACK_PERCENT}<br /><span class="gensmall">{L_ITEM_SELL_BACK_PERCENT_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_sell_back_percent" size="8" maxlength="3" value="{ITEM_SELL_BACK_PERCENT}" />&nbsp;%</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_ITEMS_REQ}<br /><span class="gensmall">{L_RECIPE_ITEMS_REQ_DESC}</span></td>					
		<td class="row2" align="center" >{RECIPE_ITEMS_REQ}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_ITEMS_AMOUNT}<br /><span class="gensmall">{L_RECIPE_ITEMS_AMOUNT_DESC}</span></td>					
		<td class="row2" align="center" ><input type="text" name="recipe_items_amount" value="{RECIPE_ITEMS_AMOUNT}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_RECIPE_EFFECT}<br /><span class="gensmall">{L_RECIPE_EFFECT_DESC}</span></td>					
		<td class="row2" align="center" >
			<table border="0" cellspacing="1" cellpadding="4" align="left" width="100%">
				<tr>
					<td colspan="4" align="center"><b>{L_RECIPE_TEMP_AND_PERM}</b></td>
				</tr>
				<tr>
					<td></td>
					<td align="center">{L_RECIPE_PERM_EFFECT}</td>
					<td align="center">{L_RECIPE_HIT_MONSTER}</td>
					<td></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_MA}</td>
					<td align="center"><input type="checkbox" name="recipe_effect_ma_perm" value="1" {RECIPE_EFFECT_MA_PERM} /></td>
					<td align="center"><input type="checkbox" name="recipe_effect_ma_m" value="1" {RECIPE_EFFECT_MA_M} /></td>
					<td><input type="text" name="recipe_effect_ma" value="{RECIPE_EFFECT_MA}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_MD}</td>
					<td align="center"><input type="checkbox" name="recipe_effect_md_perm" value="1" {RECIPE_EFFECT_MD_PERM} /></td>
					<td align="center"><input type="checkbox" name="recipe_effect_md_m" value="1" {RECIPE_EFFECT_MD_M} /></td>
					<td><input type="text" name="recipe_effect_md" value="{RECIPE_EFFECT_MD}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_ATT}</td>
					<td align="center"></td>
					<td align="center"><input type="checkbox" name="recipe_effect_att_m" value="1" {RECIPE_EFFECT_ATT_M} /></td>
					<td><input type="text" name="recipe_effect_att" value="{RECIPE_EFFECT_ATT}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_DEF}</td>
					<td align="center"></td>
					<td align="center"><input type="checkbox" name="recipe_effect_def_m" value="1" {RECIPE_EFFECT_DEF_M} /></td>
					<td><input type="text" name="recipe_effect_def" value="{RECIPE_EFFECT_DEF}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><b>{L_RECIPE_PERM_ONLY}</b></td>
				</tr>
				<tr>
					<td colspan="2">{L_RECIPE_EFFECT_HP}</td>
					<td align="center"><input type="checkbox" name="recipe_effect_hp_m" value="1" {RECIPE_EFFECT_HP_M} /></td>
					<td><input type="text" name="recipe_effect_hp" value="{RECIPE_EFFECT_HP}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="2">{L_RECIPE_EFFECT_MP}</td>
					<td align="center"><input type="checkbox" name="recipe_effect_mp_m" value="1" {RECIPE_EFFECT_MP_M} /></td>
					<td><input type="text" name="recipe_effect_mp" value="{RECIPE_EFFECT_MP}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_AC}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_ac" value="{RECIPE_EFFECT_AC}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_STR}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_str" value="{RECIPE_EFFECT_STR}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_DEX}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_dex" value="{RECIPE_EFFECT_DEX}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_CON}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_con" value="{RECIPE_EFFECT_CON}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_INT}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_int" value="{RECIPE_EFFECT_INT}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_WIS}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_wis" value="{RECIPE_EFFECT_WIS}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td>{L_RECIPE_EFFECT_CHA}</td>
					<td align="center"></td>
					<td align="center"></td>
					<td><input type="text" name="recipe_effect_cha" value="{RECIPE_EFFECT_CHA}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_EXP}</td>
					<td><input type="text" name="recipe_effect_exp" value="{RECIPE_EFFECT_EXP}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_SP}</td>
					<td><input type="text" name="recipe_effect_sp" value="{RECIPE_EFFECT_SP}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_GOLD}</td>
					<td><input type="text" name="recipe_effect_gold" value="{RECIPE_EFFECT_GOLD}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_BATTLES_REM}</td>
					<td><input type="text" name="recipe_effect_battles_rem" value="{RECIPE_EFFECT_BATTLES_REM}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_SKILLUSE_REM}</td>
					<td><input type="text" name="recipe_effect_skilluse_rem" value="{RECIPE_EFFECT_SKILLUSE_REM}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_TRADINGSKILL_REM}</td>
					<td><input type="text" name="recipe_effect_tradingskill_rem" value="{RECIPE_EFFECT_TRADINGSKILL_REM}" size="5" maxlength="5" /></td>
				</tr>
				<tr>
					<td colspan="3">{L_RECIPE_EFFECT_THEFTSKILL_REM}</td>
					<td><input type="text" name="recipe_effect_theftskill_rem" value="{RECIPE_EFFECT_THEFTSKILL_REM}" size="5" maxlength="5" /></td>
				</tr>				
			</table>
		</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_ITEM_WEIGHT}</td>
		<td class="row2" align="center" ><input type="text" name="item_weight" size="8" maxlength="8" value="{ITEM_WEIGHT}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ITEM_MAX_SKILL}</td>
		<td class="row2" align="center" ><input type="text" name="item_max_skill" size="8" maxlength="8" value="{ITEM_MAX_SKILL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_AUTH}</td>
		<td class="row2" align="center" ><input type="checkbox" name="item_auth" value="1" {ITEM_AUTH} /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_STORE}</td>
		<td class="row2" align="center" ><span class="gensmall">{ITEM_STORE_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="75%">{L_ITEM_STEAL}<br><span class="gensmall"><i>{L_ITEM_STEAL_EXPLAIN}</i></span></td>
		<td class="row2" align="center"><span class="gensmall">{ITEM_STEAL_LIST}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1">{L_ITEM_ELEMENT}</td>
		<td class="row2" align="center" ><span class="gensmall">{ITEM_ELEMENT_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_ELEMENT_STR}</td>
		<td class="row2" align="center" ><input type="text" name="item_element_str" size="4" maxlength="4" value="{ITEM_ELEMENT_STR}" />%</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_ELEMENT_SAME}</td>
		<td class="row2" align="center" ><input type="text" name="item_element_same" size="4" maxlength="4" value="{ITEM_ELEMENT_SAME}" />%</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_ELEMENT_WEAK}</td>
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
