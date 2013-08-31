<form method="post" action="{S_ITEMS_ACTION}">
<br />
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catHead" align="center" colspan="2"><span class="gen">{L_ITEM_EDITION}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="40%"><span class="gen">{L_NAME}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_name" value="{ITEM_NAME}" size="50" maxlength="255" disabled="disabled" /></td>
	</tr>
	<tr>
		<td class="row1" width="40%"><span class="gen">{L_DESC}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_desc" value="{ITEM_DESC}" size="50" rowspan="2" maxlength="255" /></td>
	<tr>
		<td class="row1"><span class="gen">{L_ITEM_PRICE}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_price" size="8" maxlength="8" value="{ITEM_PRICE}" />&nbsp;<span class="gensmall">{L_POINTS}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>
