<h1>{L_ITEM_TYPE}</h1>

<P>{L_ITEM_TYPE_TEXT}</p>

<form method="post" action="{S_ITEM_TYPE_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_ID}</th>
		<th class="thTop">{L_PRICE}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN items -->
	<!-- BEGIN categories -->
	<tr><td class="catHead" colspan="6">{categories.CATEGORY}</td></tr>
	<!-- END categories -->
	<tr>
		<td class="{items.ROW_CLASS}" align="center">{items.NAME}</td>
		<td class="{items.ROW_CLASS}" align="center">{items.ID}</td>
		<td class="{items.ROW_CLASS}" align="center">{items.PRICE}</td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall"><a href="{items.U_ITEM_TYPE_UP}">{L_MOVE_UP}</a><br /><a href="{items.U_ITEM_TYPE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="{items.ROW_CLASS}" align="center"><a href="{items.U_ITEM_TYPE_EDIT}">{L_EDIT}</a></td>
		<td class="{items.ROW_CLASS}" align="center"><a href="{items.U_ITEM_TYPE_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END items -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ITEMS_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />
