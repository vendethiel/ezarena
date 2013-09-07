<form method="post" action="{S_SHOPS_ACTION}">

<h1>{L_ITEM_TITLE}</h1>

<p>{L_ITEM_TEXT}</p>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;{L_SELECT_CAT}&nbsp;:&nbsp;{SELECT_CAT}&nbsp;&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_ITEM_NAME}</th>
		<th align="center">{L_ITEM_DESC}</th>
		<th align="center" colspan="3">&nbsp;</th>
		<th align="center">{L_ITEM_TYPE}</th>
		<th align="center">{L_ITEM_LOOTTABLES}</th>
		<th align="center">{L_ACTION}</a></th>
	</tr>

	<!-- BEGIN items -->
	<tr>
		<td class="{items.ROW_CLASS}" align="center" width="10%" rowspan="2"><br /><img src="../adr/images/items/{items.ITEM_IMG}" alt="{items.ITEM_NAME}"><br /><b>{items.ITEM_NAME}</b><br /><br />
			<a href="{items.U_ITEM_EDIT}">{L_EDIT}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{items.U_ITEM_COPY}">{L_COPY}</a><br></span>
		</td>
		<td class="{items.ROW_CLASS}" align="left" width="20%" rowspan="2"><span class="gensmall">&nbsp;&nbsp;<i>{items.ITEM_DESC}</i></td>
		<td class="{items.ROW_CLASS}" align="left" width="20%" rowspan="2" valign="top"><span class="gensmall">
			<b>{L_ITEM_PRICE}</b>: {items.ITEM_PRICE}<br />
			<b>{L_ITEM_SELL_BACK}</b>: {items.ITEM_SELL_BACK}%<br />
			<b>{L_ITEM_QUALITY}</b>: {items.ITEM_QUALITY}<br />
			<b>{L_ITEM_POWER}</b>: {items.ITEM_POWER}<br />
			<b>{L_ITEM_WEIGHT}</b>: {items.ITEM_WEIGHT}<br />
			<b>{L_ITEM_ZONE}</b>: {items.ITEM_ZONE}<br/>
			<b>{L_ITEM_DURATION}</b>: {items.ITEM_DURATION}/{items.ITEM_MAX_DURATION}<br />
		</span></td>
		<td class="{items.ROW_CLASS}" align="left" width="25%" valign="top"><span class="gensmall">
			<b>{L_STR}</b>: [{items.ITEM_STR}]<br />
			<b>{L_DEX}</b>: [{items.ITEM_DEX}]<br />
			<b>{L_CON}</b>: [{items.ITEM_CON}]<br />
		</span></td>
		<td class="{items.ROW_CLASS}" align="left" width="25%" valign="top"><span class="gensmall">
			<b>{L_INT}</b>: [{items.ITEM_INT}]<br />
			<b>{L_WIS}</b>: [{items.ITEM_WIS}]<br />
			<b>{L_CHA}</b>: [{items.ITEM_CHA}]<br />
			<b>{L_LVL}</b>: [{items.ITEM_LVL}]<br />
		</span></td>
		<td class="{items.ROW_CLASS}" align="center" width="15%" rowspan="2"><span class="gensmall">{items.ITEM_TYPE}</span></td>
		<td class="{items.ROW_CLASS}" align="center" rowspan="2">{items.ITEM_LOOTTABLES}</td>
		<td class="{items.ROW_CLASS}" align="center" width="5%" rowspan="2"><a href="{items.U_ITEM_DELETE}">{L_DELETE}</a></td>
	</tr>
	<tr>
		<td class="{items.ROW_CLASS}" align="left" width="20%" valign="top" colspan="2"><span class="gensmall">
			 <!-- BEGIN align_restrict -->
			{items.align_restrict.ALIGN_LIST}.<br />
			 <!-- END align_restrict -->
			 <!-- BEGIN class_restrict -->
			{items.class_restrict.CLASS_LIST}.<br />
			 <!-- END class_restrict -->
			 <!-- BEGIN element_restrict -->
			{items.element_restrict.ELEMENT_LIST}.<br />
			 <!-- END element_restrict -->
			 <!-- BEGIN race_restrict -->
			{items.race_restrict.RACE_LIST}.<br />
			 <!-- END race_restrict -->
		</span></td>
	</tr>
	<!-- END items -->
	</form>
	<form method="post" action="{S_SHOPS_ACTION}">
	<tr>
		<td class="catBottom" colspan="14" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_ADD_ITEM}" class="mainoption" /></td>
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

<br clear="all" />