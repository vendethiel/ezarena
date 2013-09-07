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

<form method="post" action="{S_SPELLS_ACTION}" name="spells_form" >

<!-- BEGIN main -->
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

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_ITEM_IMG}</th>
		<th align="center">{L_ITEM_NAME}<br /><font size="1">{L_ITEM_DESC}</font></th>
		<th align="center">{L_ITEM_POWER}</th>
		<th align="center">{L_ITEM_TYPE}</th>
		<!-- BEGIN owner -->
		<th align="center">{L_ACTION}</a></th>
		<!-- END owner -->
	</tr>
	<!-- BEGIN items -->
	<tr>
		<td class="{main.items.ROW_CLASS}" align="center" onClick="window.location.href='{main.items.U_ITEM_INFO}';"><img style="border:0" src="./adr/images/items/{main.items.ITEM_IMG}"></a></td>
		<td class="{main.items.ROW_CLASS}" align="center" onClick="window.location.href='{main.items.U_ITEM_INFO}';"><span class="gen">{main.items.ITEM_NAME}</span><br /><span class="gensmall">{main.items.ITEM_DESC}</span></td>
		<td class="{main.items.ROW_CLASS}" align="center" onClick="window.location.href='{main.items.U_ITEM_INFO}';"><span class="gen">{main.items.ITEM_POWER}</span></td>
		<td class="{main.items.ROW_CLASS}" align="center" onClick="window.location.href='{main.items.U_ITEM_INFO}';"><span class="gen">{main.items.ITEM_TYPE}</span></td>
		<!-- BEGIN owner -->
		<td class="{main.items.ROW_CLASS}" align="center" ><input type="checkbox" name="item_box[]" value="{main.items.ITEM_ID}" /></td>
		<!-- END owner -->
	</tr>
	<!-- END items -->
	<tr> 
		<td class="catBottom" colspan="{COLSPAN}" height="28" align="right">&nbsp;</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top">{ACTION_LIST}&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption"/></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<!-- END main -->

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
			<td class="catBottom" colspan="2" height="28" align="center">&nbsp;</td>
		</tr>
	</table>

</form>
<form method="post" action="{S_MODE_ACTION}">
<!-- END view_item -->

</form>

<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>
<br clear="all" />