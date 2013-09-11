<h1>Don de sort à un personnage</h1>

<script>
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

<!-- BEGIN view_store -->
<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">
			{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
			{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
			{L_SELECT_CAT}&nbsp;:&nbsp;{SELECT_CAT}&nbsp;&nbsp;
			<input type="submit" value="{L_SORT}" class="liteoption"></span>
		</td>
		<td align="center" nowrap="nowrap">
			<span class="genmed">
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', true); return false;" class="gensmall"> {L_CHECK_ALL}</a>&nbsp;/&nbsp; 
			<a href="#" onclick="setCheckboxes('items_form', 'item_box[]', false); return false;" class="gensmall"> {L_UNCHECK_ALL}</a>
			</span>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center">{L_ITEM_IMG}</th>
		<th align="center">{L_ITEM_NAME}<br /><font size="1">{L_ITEM_DESC}</font></th>
		<th align="center">{L_ITEM_POWER}</th>
		<th align="center">{L_ITEM_TYPE}</th>
		<th align="center">{L_ACTION}</th>
	</tr>

<!-- BEGIN items -->
	<tr height="30"> 
		<td class="{view_store.items.ROW_CLASS}" align="center" onClick="window.location.href ='{view_store.items.U_ITEM_INFO}';"><img style="border:0" src="{view_store.items.ITEM_IMG}"></td>
		<td class="{view_store.items.ROW_CLASS}" align="center" onClick="window.location.href ='{view_store.items.U_ITEM_INFO}';"><span class="gen">{view_store.items.ITEM_NAME}</span><br /><span class="gensmall">{view_store.items.ITEM_DESC}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center" onClick="window.location.href ='{view_store.items.U_ITEM_INFO}';"><span class="gen">{view_store.items.ITEM_POWER}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center" onClick="window.location.href ='{view_store.items.U_ITEM_INFO}';"><span class="gen">{view_store.items.ITEM_TYPE}</span></td>
		<td class="{view_store.items.ROW_CLASS}" align="center">
			<input type="hidden" name="shop_owner_id" value="{SHOP_OWNER_ID}" />
			<input type="checkbox" name="item_box[]" value="{view_store.items.ITEM_ID}" />
		</td>
	</tr>
<!-- END items -->

	<tr> 
		<td class="catBottom" colspan="10" height="28" align="right">
		<span class="gen">{L_SELECT_QUANTITY}&nbsp;&nbsp;</span>{SELECT_QUANTITY}&nbsp;&nbsp;
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
<!-- END view_store -->
<br clear="all" />
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>
<br clear="all" />