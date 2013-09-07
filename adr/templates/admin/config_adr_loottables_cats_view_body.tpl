<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">
			{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
			{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
			{L_SELECT_CAT}&nbsp;{SELECT_CAT}&nbsp;&nbsp;
			<input type="submit" value="{L_SORT}" class="liteoption" /></span>
		</td>
		<td align="center" nowrap="nowrap">

		</td>
	</tr>
</table>
<br />

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
		<th align="center">{L_ITEM_IMG}</th>
		<th align="center">{L_ITEM_NAME}<br /><font size="1">{L_ITEM_DESC}</font></th>
		<th align="center">{L_ITEM_PRICE}</th>
		<th align="center">{L_ITEM_QUALITY}</th>
		<th align="center">{L_ITEM_POWER}</th>
		<th align="center">{L_ITEM_WEIGHT}</th>
		<th align="center">{L_ITEM_DURATION}</th>
		<th align="center">{L_ITEM_TYPE}</th>
		<th align="center">{L_ACTION}</th>
	</tr>

<!-- BEGIN items -->
	<tr height="30"> 
		<td class="{items.ROW_CLASS}" align="center" ><img style="border:0" src="../adr/images/items/{items.ITEM_IMG}"></a></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_NAME}</span><br /><span class="gensmall">{items.ITEM_DESC}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_PRICE}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_QUALITY}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_POWER}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_WEIGHT}</span></td>
		<td class="{items.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">{items.ITEM_DURATION} / {items.ITEM_DURATION_MAX}</span></td>
		<td class="{items.ROW_CLASS}" align="center" ><span class="gen">{items.ITEM_TYPE}</span></td>
		<td class="{items.ROW_CLASS}" align="center"><a href="{items.U_ITEM_DELETE}">{L_ITEM_DELETE}</a></td>

		</td>
	</tr>
<!-- END items -->
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

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">Advanced Loot System written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />