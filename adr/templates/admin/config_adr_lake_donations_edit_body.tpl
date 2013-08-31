
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
		<td class="row1">{L_ITEM_CHANCE}<br /><span class="gensmall"><i>{L_ITEM_CHANCE_EXPLAIN}</i></span></td>
		<td class="row2" align="center" >{ITEM_CHANCE}</td>
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
