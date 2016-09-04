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

<form method="post" action="{S_SHOPS_ACTION}">

<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row1" ><span class="gen"><br /><a href="{U_SHOPS}">{L_SHOPS}</a><br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><a href="{U_LIST_SHOPS}">{L_LIST_SHOPS}</a><br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><a href="{U_SEARCH_ITEM}">{L_SEARCH_ITEM}</a><br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><a href="{U_DECIDE}">{L_DECIDE}</a><br /><br /></span></td>
	</tr>
</table>
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="60%" >
	<tr>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_USER_MONEY} :</b> {MONEY}<br /><br /></span></td>
	</tr>
</table>

<!-- BEGIN main -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onClick="window.location.href='{U_FORUM_SHOPS}';"><span class="gen">{L_FORUM_SHOPS}</span></td>
	</tr>
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='pointer';" onClick="window.location.href='{U_LIST_SHOPS}';"><span class="gen">{L_LIST_SHOPS}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onClick="window.location.href='{U_SEARCH_ITEM}';"><span class="gen">{L_SEARCH_ITEM}</span></td>
	</tr>
<!-- BEGIN no_shop -->
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='pointer';" onClick="window.location.href='{U_CREATE_SHOP}';"><span class="gen">{L_CREATE_SHOP}</span></td>
	</tr>
<!-- END no_shop -->
<!-- BEGIN shop -->
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='pointer';" onClick="window.location.href='{U_MANAGE_SHOP}';"><span class="gen">{L_MANAGE_SHOP}</span></td>
	</tr>
<!-- END shop -->
</table>
<br clear="all" />
<!-- END main -->

<!-- BEGIN create_shop -->
<br />
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catHead"><span class="gen">{L_CREATE_NEW_SHOP}</span><br /><br /><span class="gensmall"><b>{L_CREATE_NEW_SHOP_PRICE}</b></span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="60%">
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_CREATE_NEW_SHOP_NAME}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="shop_name" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CREATE_NEW_SHOP_DESC}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="shop_desc" size="40" maxlength="255" /></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catBottom"><input type="hidden" name="mode" value="save_new_shop"><input type="submit" value="{L_SUBMIT}" class="liteoption" /></td>
	</tr>
</table>

<br clear="all" />
<!-- END create_shop -->

<!-- BEGIN edit_shop -->
<br />
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catHead"><span class="gen">{L_CREATE_NEW_SHOP}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="60%">
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_CREATE_NEW_SHOP_NAME}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="shop_name" value="{SHOP_NAME}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CREATE_NEW_SHOP_DESC}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="shop_desc" value="{SHOP_DESC}" size="40" maxlength="255" /></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catBottom"><input type="hidden" name="shop_id" value="{SHOP_ID}" /><input type="hidden" name="mode" value="save_shop" /><input type="submit" value="{L_SUBMIT}" class="liteoption" /></td>
	</tr>
</table>

<br clear="all" />
<!-- END edit_shop -->

<!-- BEGIN see_shop -->
</form>
<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<br />
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catHead"><span class="gen">{SHOP_NAME}</span><br /><span class="gensmall">{SHOP_DESC}</span><br /></td>
	</tr>
</table>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center" nowrap="nowrap">
			<span class="genmed">
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', true); return false;" class="gensmall">{L_CHECK_ALL}</a>&nbsp;/&nbsp;
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', false); return false;" class="gensmall">{L_UNCHECK_ALL}</a>
			</span>
		</td>
		<td align="center" nowrap="nowrap"><span class="genmed">
			{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
			{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
			{L_SELECT_CAT}&nbsp;:&nbsp;{SELECT_CAT}&nbsp;&nbsp;
			<input type="submit" value="{L_SORT}" class="liteoption" /></span>
		</td>
	</tr>
</table>
<br />
<!-- BEGIN my_points -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" nowrap="nowrap" width="50%"><span class="gensmall"><b>{L_POINTS}</b>: {POINTS}</span></td>
		<td align="right" nowrap="nowrap" width="50%"><span class="gensmall"><a href="{SHOW_LINK}">{L_SHOW_LINK}</a></span></td>
	</tr>
</table>
<!-- END my_points -->
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center">&nbsp;</th>
		<th align="center">{L_ITEM_NAME}:</th>
		<th align="left">{L_ITEM_DESC}:</th>
		<th align="center">{L_ITEM_PRICE}:</th>
		<th align="center">{L_ITEM_QUALITY}:</th>
		<th align="center">{L_ITEM_POWER}:</th>
		<th align="center">{L_ITEM_WEIGHT}:</th>
		<th align="center">{L_ITEM_DURATION}:</th>
		<th align="center">{L_ITEM_TYPE}:</th>
	</tr>

<!-- BEGIN items -->
	<tr height="30">
		<td class="{see_shop.items.ROW_CLASS}" align="center">
			<input type="hidden" name="shop_owner_id" value="{SHOP_OWNER_ID}" />
			<input type="checkbox" name="item_box[]" value="{see_shop.items.ITEM_ID}" />
		</td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><img style="border:0" src="./adr/images/items/{see_shop.items.ITEM_IMG}"><br /><a href="{see_shop.items.U_ITEM_INFO}"><span class="gen"><b>{see_shop.items.ITEM_NAME}</b></font></span></a></td>
		<td class="{see_shop.items.ROW_CLASS}" align="left">
			<br><span class="gensmall"><i>{see_shop.items.ITEM_DESC}</i><br>
        	<!-- BEGIN crit_hit -->
			<br><b>{see_shop.items.crit_hit.L_CRIT_HIT}:</b>&nbsp;{see_shop.items.crit_hit.CRIT_HIT}</b>
			<!-- END crit_hit -->
        	<!-- BEGIN resist_chars -->
			<br><b>{see_shop.items.resist_chars.L_CHAR_RESIST_LIST}:</b>&nbsp;{see_shop.items.resist_chars.CHAR_RESIST_LIST}
			<!-- END resist_chars -->
        	<!-- BEGIN align_restrict -->
			<br /><b>{see_shop.items.align_restrict.L_ALIGN_LIST}:</b>&nbsp;{see_shop.items.align_restrict.ALIGN_LIST}
			<!-- END align_restrict -->
        	<!-- BEGIN class_restrict -->
			<br /><b>{see_shop.items.class_restrict.L_CLASS_LIST}:</b>&nbsp;{see_shop.items.class_restrict.CLASS_LIST}
			<!-- END class_restrict -->
        	<!-- BEGIN element_restrict -->
			<br /><b>{see_shop.items.element_restrict.L_ELEMENT_LIST}:</b>&nbsp;{see_shop.items.element_restrict.ELEMENT_LIST}
			<!-- END element_restrict -->
        	<!-- BEGIN race_restrict -->
			<br /><b>{see_shop.items.race_restrict.L_RACE_LIST}:</b>&nbsp;{see_shop.items.race_restrict.RACE_LIST}
			<!-- END race_restrict -->
        	<!-- BEGIN stolen_info -->
			<br><br>*{see_shop.items.stolen_info.L_STOLEN_INFO}
			<!-- END stolen_info -->
		</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><span class="gensmall">{see_shop.items.ITEM_PRICE}</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><span class="gensmall">{see_shop.items.ITEM_QUALITY}</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><span class="gensmall">{see_shop.items.ITEM_POWER}</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><span class="gensmall">{see_shop.items.ITEM_WEIGHT}</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gensmall">{see_shop.items.ITEM_DURATION}/{see_shop.items.ITEM_DURATION_MAX}</span></td>
		<td class="{see_shop.items.ROW_CLASS}" align="center"><span class="gensmall">{see_shop.items.ITEM_TYPE}</span></td>
	</tr>
<!-- END items -->
	<tr>
		<td class="catBottom" colspan="10" height="28" align="left">
	   	<!-- BEGIN forum_shops -->
		<span class="gen">{L_SELECT_QUANTITY}&nbsp;:&nbsp;</span>{SELECT_QUANTITY}&nbsp;&nbsp;
		<!-- END forum_shops -->
		{ACTION_SELECT}&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<!-- BEGIN owner -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onClick="window.location.href='{U_SHOP_EDIT}';"><span class="gen">{L_SHOP_EDIT}</span></td>
	</tr>
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='pointer';" onClick="window.location.href='{U_SHOP_DELETE}';"><span class="gen">{L_SHOP_DELETE}</span></td>
	</tr>
</table>
<!-- END owner -->
</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END see_shop -->

<!-- BEGIN search_item -->
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="gen">{L_SEARCH_ITEM}</span></td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center" colspan="2">{L_SEARCH_ITEM_CRITERA}</th>
	</tr>
	<tr> 
		<td class="row1" align="center" width="40%"><span class="gen">{L_ITEM_TYPE}</span></td>
		<td class="row2" align="center"><span class="gen">{ITEM_TYPE}</span></td>
	</tr>
	<tr> 
		<td class="row1" align="center"><span class="gen">{L_ITEM_QUALITY_LEAST}</span></td>
		<td class="row2" align="center"><span class="gen">{ITEM_QUALITY}</span></td>
	</tr>
	<tr> 
		<td class="row1" align="center"><span class="gen">{L_ITEM_POWER_LEAST}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="item_power_least" size="8" maxlength="8" /></td>
	</tr>
	<tr> 
		<td class="row1" align="center"><span class="gen">{L_ITEM_DURATION_LEAST}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="item_duration_least" size="8" maxlength="8" /></td>
	</tr>
	<tr> 
		<td class="row1" align="center"><span class="gen">{L_ITEM_PRICE_MAX}</span></td>
		<td class="row2" align="center" ><input type="text" class="post" name="item_price_max" size="8" maxlength="8" /><span class="genmed">&nbsp;{L_POINTS}</span></td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><input type="hidden" name="mode" value="search_item_results"><input type="submit" value="{L_SUBMIT}" class="liteoption" /></span></td>
	</tr>
</table>
<!-- END search_item -->

<!-- BEGIN search_item_results -->
<br />
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center">{L_ITEM_NAME}</th>
		<th align="center">{L_SHOP_NAME}</th>
		<th align="center">{L_ITEM_PRICE}</th>
		<th align="center">{L_ITEM_QUALITY}</th>
		<th align="center">{L_ITEM_POWER}</th>
		<th align="center">{L_ITEM_WEIGHT}</th>
		<th align="center">{L_ITEM_DURATION}</th>
		<th align="center">{L_ITEM_TYPE}</th>
	</tr>

<!-- BEGIN items -->
	<tr height="30"> 
		<td class="{search_item_results.items.ROW_CLASS}" align="center" ><span class="gen">{search_item_results.items.ITEM_NAME}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center" ><a href="{search_item_results.items.U_SHOP_NAME}"><span class="nav">{search_item_results.items.SHOP_NAME}</span></a></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_PRICE}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_QUALITY}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_POWER}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_WEIGHT}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_DURATION} / {search_item_results.items.ITEM_DURATION_MAX}</span></td>
		<td class="{search_item_results.items.ROW_CLASS}" align="center"><span class="gen" onClick="window.location.href='{search_item_results.items.U_ITEM_INFO}';">{search_item_results.items.ITEM_TYPE}</span></td>
	</tr>
<!-- END items -->
</table>

<!-- END search_item_results -->

<!-- BEGIN shop_list -->
</form>

<form method="post" action="{S_MODE_ACTION}">
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="hidden" name="mode" value="shop_list" /><input type="submit" value="{L_SUBMIT}" class="liteoption" /></span></td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th align="center" width="80%" >{L_SHOP_NAME}</th>
		<!-- <th align="center" width="10%" >{L_SHOP_TOTAL}</th> -->
	</tr>
<!-- BEGIN shops -->
	<tr>
		<td class="row1" align="center" onClick="window.location.href='{shop_list.shops.U_SHOP_NAME}';">
			<a href="{shop_list.shops.U_SHOP_NAME}"><span class="nav">
			<font size="4">{shop_list.shops.SHOP_NAME}</font></span></a></td>
		<!-- <td class="{shop_list.shops.ROW_CLASS}" align="center" rowspan="2"><span class="gen">{shop_list.shops.SHOP_TOTAL}</span></td> -->
	</tr>
	<tr>
		<td class="row2" align="left" onClick="window.location.href='{shop_list.shops.U_SHOP_NAME}';">
			<i><span class="gen">{shop_list.shops.SHOP_DESC}</span></i><br><br>
			<span class="gensmall"><b>{L_OWNER}:</b> {shop_list.shops.OWNER_NAME}</span><br>
			<span class="gensmall"><b>{L_SHOP_LAST_UPDATED}:</b> {shop_list.shops.SHOP_LAST_UPDATED}</span><br>
			<span class="gensmall"><b>{L_SHOP_TOTAL}:</b> {shop_list.shops.SHOP_TOTAL}</span>
		</td>
	</tr>
<!-- END shops -->
	<tr>
		<td class="catBottom" colspan="3" height="28">&nbsp;</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END shop_list -->

<!-- BEGIN view_store_list -->
</form>
<form method="post" action="{S_MODE_ACTION}">
<br />
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center" width="10%" >{L_STORE_IMG}</th>
		<th align="center" width="20%" >{L_STORE_NAME}</th>
		<th align="left" width="50%" >{L_STORE_DESC}</th>
		<th align="center" width="20%" >{L_STORE_STATUS}</th>
	</tr>

<!-- BEGIN store -->
	<tr height="30"> 
		<td class="{view_store_list.store.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.store.U_STORE_NAME}';"><span class="nav">{view_store_list.store.STORE_IMG}</span></a></td>
		<td class="{view_store_list.store.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.store.U_STORE_NAME}';"><a href="{view_store_list.store.U_STORE_NAME}"><span class="nav">{view_store_list.store.STORE_NAME}</span></a></td>
		<td class="{view_store_list.store.ROW_CLASS}" align="left" onClick="window.location.href='{view_store_list.store.U_STORE_NAME}';"><span class="gen"><i>{view_store_list.store.STORE_DESC}</i></span></td>
		<td class="{view_store_list.store.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.store.U_STORE_NAME}';"><span class="gen">{view_store_list.store.STORE_STATUS}</span></td>
	</tr>
<!-- END store -->
<!-- BEGIN admin -->
	<tr> 
		<th align="center" colspan="4" cellpadding="3" cellspacing="1" border="0">{L_STORE_ADMIN}</th>
	</tr>
	<tr height="30"> 
		<td class="{view_store_list.admin.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.admin.U_STORE_NAME}';"><span class="nav">{view_store_list.admin.STORE_IMG}</span></a></td>
		<td class="{view_store_list.admin.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.admin.U_STORE_NAME}';"><a href="{view_store_list.admin.U_STORE_NAME}"><span class="nav"><span class="nav">{view_store_list.admin.STORE_NAME}</span></a></td>
		<td class="{view_store_list.admin.ROW_CLASS}" align="left" onClick="window.location.href='{view_store_list.admin.U_STORE_NAME}';"><span class="gen"><i>{view_store_list.admin.STORE_DESC}</i></span></td>
		<td class="{view_store_list.admin.ROW_CLASS}" align="center" onClick="window.location.href='{view_store_list.admin.U_STORE_NAME}';"><span class="gen">{view_store_list.admin.STORE_STATUS}</span></td>
	</tr>
<!-- END admin -->

	<tr> 
		<td class="catBottom" colspan="4" height="28">&nbsp;</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END view_store_list -->

<!-- BEGIN view_store -->
</form>
<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center" nowrap="nowrap">
			<span class="genmed">
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', true); return false;" class="gensmall"> {L_CHECK_ALL}</a>&nbsp;/&nbsp;
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', false); return false;" class="gensmall"> {L_UNCHECK_ALL}</a>
			</span>
		</td>
		<td align="center" nowrap="nowrap"><span class="genmed">
			{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
			{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
			{L_SELECT_CAT}&nbsp;:&nbsp;{SELECT_CAT}&nbsp;&nbsp;
			<input type="submit" value="{L_SORT}" class="liteoption" /></span>
		</td>
	</tr>
</table>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" nowrap="nowrap" width="50%"><span class="gensmall"><b>{L_POINTS}</b>: {POINTS}</span></td>
		<td align="right" nowrap="nowrap" width="50%"><span class="gensmall"><a href="{SHOW_LINK}">{L_SHOW_LINK}</a></span></td>
	</tr>
</table>
<br />

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th align="center">&nbsp;</th>
		<th align="center">{L_ITEM_NAME}:</th>
		<th align="left">{L_ITEM_DESC}:</th>
		<th align="center">{L_ITEM_PRICE}:</th>
		<th align="center">{L_ITEM_QUALITY}:</th>
		<th align="center">{L_ITEM_POWER}:</th>
		<th align="center">{L_ITEM_WEIGHT}:</th>
		<th align="center">{L_ITEM_DURATION}:</th>
		<th align="center">{L_ITEM_TYPE}:</th>
	</tr>
	<!-- BEGIN items -->
	<tr height="30">
		<td class="{view_store.items.ROW_CLASS}" align="center">
			<input type="hidden" name="shop_owner_id" value="{SHOP_OWNER_ID}" />
			<input type="hidden" name="store_id" value="{view_store.items.ITEM_STORE_ID}" />
			<input type="checkbox" name="item_box[]" value="{view_store.items.ITEM_ID}" />
		</td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><img style="border:0" src="./adr/images/items/{view_store.items.ITEM_IMG}"></a><br /><a href="{view_store.items.U_ITEM_INFO}"><span class="nav"><span class="gen"><b>{view_store.items.ITEM_NAME}</b></span></a></td>
		<td class="{view_store.items.ROW_CLASS}" align="left" valign="top">
			<br><span class="gensmall"><i>{view_store.items.ITEM_DESC}</i><br>
        	<!-- BEGIN crit_hit -->
			<br><b>{view_store.items.crit_hit.L_CRIT_HIT}:</b>&nbsp;{view_store.items.crit_hit.CRIT_HIT}</b>
			<!-- END crit_hit -->
			<!-- BEGIN resist_chars -->
			<br><b>{view_store.items.resist_chars.L_CHAR_RESIST_LIST}:</b>&nbsp;{view_store.items.resist_chars.CHAR_RESIST_LIST}
			<!-- END resist_chars -->
        	<!-- BEGIN align_restrict -->
			<br /><b>{view_store.items.align_restrict.L_ALIGN_LIST}:</b> {view_store.items.align_restrict.ALIGN_LIST}
			<!-- END align_restrict -->
        	<!-- BEGIN class_restrict -->
			<br /><b>{view_store.items.class_restrict.L_CLASS_LIST}:</b> {view_store.items.class_restrict.CLASS_LIST}
			<!-- END class_restrict -->
        	<!-- BEGIN element_restrict -->
			<br /><b>{view_store.items.element_restrict.L_ELEMENT_LIST}:</b> {view_store.items.element_restrict.ELEMENT_LIST}
			<!-- END element_restrict -->
        	<!-- BEGIN race_restrict -->
			<br /><b>{view_store.items.race_restrict.L_RACE_LIST}:</b> {view_store.items.race_restrict.RACE_LIST}
			<!-- END race_restrict -->
        	<!-- BEGIN steal_show -->
			<br /><b>{view_store.items.steal_show.L_STEAL_SHOW}</b>&nbsp;<i>{view_store.items.steal_show.STEAL_SHOW}</i></b>
			<!-- END steal_show -->
			</span>
		</td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><span class="gensmall">{view_store.items.ITEM_PRICE}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><span class="gensmall">{view_store.items.ITEM_QUALITY}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><span class="gensmall">{view_store.items.ITEM_POWER}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><span class="gensmall">{view_store.items.ITEM_WEIGHT}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gensmall">{view_store.items.ITEM_DURATION} / {view_store.items.ITEM_DURATION_MAX}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center"><span class="gensmall">{view_store.items.ITEM_TYPE}</span></td>
	</tr>
	<!-- END items -->
	<tr>
		<td class="catBottom" colspan="10" height="28" align="left">
	   	<!-- BEGIN forum_shops -->
		<span class="gen">{L_SELECT_QUANTITY}&nbsp;&nbsp;</span>{SELECT_QUANTITY}&nbsp;&nbsp;
		<!-- END forum_shops -->
		{ACTION_SELECT}&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END view_store -->

<!-- BEGIN view_item -->
</form>
<form method="post" action="{S_MODE_ACTION}">
<br />

<table width="50%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
		<tr height="30"> 
			<th align="center" colspan="2" width="20%" >{ITEM_NAME}{L_ITEM_INFO}</th>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS}" align="center" width="100%" colspan="2">&nbsp;<p>{ITEM_IMG}</p>
			<p><span class="gen">&nbsp;</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS_2}" align="center" width="40%"><span class="gen">{L_ITEM_DESC}</span></td>
			<td class="{ROW_CLASS_2}" align="center" width="60%"><span class="gen">{ITEM_DESC}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS}" align="center" width="40%"><span class="gen">{L_ITEM_ELEMENT}</span></td>
			<td class="{ROW_CLASS}" align="center" width="60%"><span class="gen">{ITEM_ELEMENT}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS_2}" align="center" width="40%"><span class="gen">{L_ITEM_POWER}</span></td>
			<td class="{ROW_CLASS_2}" align="center" width="60%"><span class="gen">{ITEM_POWER}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS}" align="center" width="40%"><span class="gen">{L_ITEM_ADD_POWER}</span></td>
			<td class="{ROW_CLASS}" align="center" width="60%"><span class="gen">{ITEM_ADD_POWER}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS_2}" align="center" width="40%"><span class="gen">{L_ITEM_MP}</span></td>
			<td class="{ROW_CLASS_2}" align="center" width="60%"><span class="gen">{ITEM_MP}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS}" align="center" width="40%"><span class="gen">{L_ITEM_WEIGHT}</span></td>
			<td class="{ROW_CLASS}" align="center" width="60%"><span class="gen">{ITEM_WEIGHT}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS_2}" align="center" width="40%"><span class="gen">{L_ITEM_DURA}</span></td>
			<td class="{ROW_CLASS_2}" align="center" width="60%"><span class="gen">{ITEM_DURA} / {ITEM_DURA_MAX}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS}" align="center" width="40%"><span class="gen">{L_ITEM_QUALITY}</span></td>
			<td class="{ROW_CLASS}" align="center" width="60%"><span class="gen">{ITEM_QUALITY}</span></td>
		</tr>
		<tr height="30">
			<td class="{ROW_CLASS_2}" align="center" width="40%"><span class="gen">{L_ITEM_PRICE}</span></td>
			<td class="{ROW_CLASS_2}" align="center" width="60%"><span class="gen">{ITEM_PRICE} {ITEM_POINTS}</span></td>
		</tr>
		<tr height="30"> 
			<td class="catBottom" colspan="2" height="28" align="center">
	   		<!-- BEGIN forum_shops -->
			<span class="gen">{L_SELECT_QUANTITY}&nbsp;:&nbsp;</span>{SELECT_QUANTITY}&nbsp;&nbsp;
			{ACTION_SELECT}&nbsp;</td>
		</tr>
		<tr height="30"> 
			<td class="catBottom" colspan="2" height="28" align="center">&nbsp;
			<input type="hidden" name="shop_owner_id" value="{SHOP_OWNER_ID}" />
			<input type="hidden" name="item_box[]" value="{ITEM_ID}" />
			<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
			<!-- END forum_shops -->
		</tr>
	</table>

</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END view_item -->

</form>
<br />
<br />
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_TOWNMAPCOPYRIGHT}">{L_TOWNMAPCOPYRIGHT}</a></span></td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>
<br clear="all" />
