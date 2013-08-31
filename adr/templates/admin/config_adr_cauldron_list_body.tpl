<h1>{L_CAULDRON_TITLE}</h1>

<P>{L_CAULDRON_TEXT}</p>

<form method="post" action="{S_CAULDRON_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_ITEM_CREATED}</th>
		<th class="thTop">{L_ITEM_COMBINE1}</th>
		<th class="thTop">{L_ITEM_COMBINE2}</th>
		<th class="thTop">{L_ITEM_COMBINE3}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN cauldron -->
	<tr>
		<td class="{cauldron.ROW_CLASS}" align="center">{cauldron.ITEM_CREATED}</td>
		<td class="{cauldron.ROW_CLASS}" align="center">{cauldron.ITEM_COMBINE1}</td>
		<td class="{cauldron.ROW_CLASS}" align="center">{cauldron.ITEM_COMBINE2}</td>
		<td class="{cauldron.ROW_CLASS}" align="center">{cauldron.ITEM_COMBINE3}</td>
		<td class="{cauldron.ROW_CLASS}" align="center"><a href="{cauldron.U_CAULDRON_EDIT}">{L_EDIT}</a></td>
		<td class="{cauldron.ROW_CLASS}" align="center"><a href="{cauldron.U_CAULDRON_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END cauldron -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_CAULDRON_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />