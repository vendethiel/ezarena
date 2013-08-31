<h1>{L_USER_TITLE}</h1>

<p>{L_USER_EXPLAIN}</p>

<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<br />
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="100%" >
	<tr>
		<td align="center" class="catHead"><span class="gen">{OWNER_NAME}{OWNER_S}{WAREHOUSE_NAME}</span></td>
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
		<td class="{items.ROW_CLASS}" align="center" ><img style="border:0" src="./adr/images/items/{items.ITEM_IMG}"></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_NAME}</font></span></a><br /><span class="gensmall">{items.ITEM_DESC}</ span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_PRICE}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_QUALITY}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_POWER}</span></td>
		<td class="{items.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">{items.ITEM_DURATION} / {items.ITEM_DURATION_MAX}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_TYPE}</span></td>
		<td class="{items.ROW_CLASS}" align="center">
			<input type="hidden" name="edit_owner_id" value="{edit_OWNER_ID}" />
			<input type="checkbox" name="item_box[]" value="{edit.ITEM_ID}" />
		</td>
	</tr>
<!-- END items -->

	<tr> 
		<td class="catBottom" colspan="10" height="28" align="right">	{ACTION_SELECT}&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

</form>
