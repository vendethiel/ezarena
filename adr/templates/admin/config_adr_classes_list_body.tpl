<h1>{L_CLASSES_TITLE}</h1>

<P>{L_CLASSES_TEXT}</p>

<form method="post" action="{S_CLASSES_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_DESC}</th>
		<th class="thTop">{L_LEVEL}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN classes -->
	<tr>
		<td class="{classes.ROW_CLASS}" align="center">{classes.NAME}</td>
		<td class="{classes.ROW_CLASS}" align="center"><img src="../adr/images/classes/{classes.IMG}" alt="{classes.NAME}" /></td>
		<td class="{classes.ROW_CLASS}" align="center">{classes.DESC}</td>
		<td class="{classes.ROW_CLASS}" align="center">{classes.LEVEL}</td>
		<td class="{classes.ROW_CLASS}" align="center"><a href="{classes.U_CLASSES_EDIT}">{L_EDIT}</a></td>
		<td class="{classes.ROW_CLASS}" align="center"><a href="{classes.U_CLASSES_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END classes -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_CLASSES_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />