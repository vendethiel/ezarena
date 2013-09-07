<form method="post" action="{S_LOOTTABLE_ACTION}">

<h1>{L_LOOTTABLE_TITLE}</h1>

<p>{L_LOOTTABLE_EXPLAIN}</p>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_LOOTTABLE_SELECT_SORT_METHOD}:&nbsp;{S_LOOTTABLE_MODE_SELECT}&nbsp;&nbsp;{L_LOOTTABLE_ORDER}&nbsp;{S_LOOTTABLE_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" value="{L_LOOTTABLE_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_LOOTTABLE_NAME}</th>
		<th align="center">{L_LOOTTABLE_DESC}</th>
		<th align="center">{L_LOOTTABLE_ITEMS}</th>
		<th align="center">{L_LOOTTABLE_DROPCHANCE}</th>
		<th align="center">{L_LOOTTABLE_STATUS}</th>
		<th align="center" colspan="3">{L_LOOTTABLE_ACTION}</a></th>
	</tr>

	<!-- BEGIN loottables -->
	<tr class="gen">
		<td class="{loottables.ROW_CLASS}" align="center">{loottables.LOOTTABLE_NAME}</td>
		<td class="{loottables.ROW_CLASS}" align="center">{loottables.LOOTTABLE_DESC}</td>
		<td class="{loottables.ROW_CLASS}" align="center">{loottables.LOOTTABLE_ITEMS}</td>
		<td class="{loottables.ROW_CLASS}" align="center">{loottables.LOOTTABLE_DROPCHANCE}</td>
		<td class="{loottables.ROW_CLASS}" align="center">{loottables.LOOTTABLE_STATUS}</td>
		<td class="{loottables.ROW_CLASS}" align="center"><a href="{loottables.U_LOOTTABLE_VIEW}">{L_LOOTTABLE_VIEW}</a></td>
		<td class="{loottables.ROW_CLASS}" align="center"><a href="{loottables.U_LOOTTABLE_EDIT}">{L_LOOTTABLE_EDIT}</a></td>
		<td class="{loottables.ROW_CLASS}" align="center"><a href="{loottables.U_LOOTTABLE_DELETE}">{L_LOOTTABLE_DELETE}</a></td>
	</tr>
	<!-- END loottables -->
	</form>
	<form method="post" action="{S_LOOTTABLE_ACTION}">
	<tr>
		<td class="catBottom" colspan="10" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_LOOTTABLE_ADD}" class="mainoption" /></td>
	</tr>
</table>


<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{LOOTTABLE_PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{LOOTTABLE_PAGINATION}</span></td>
	</tr>
</table>

</form>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">Advanced Loot System written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />