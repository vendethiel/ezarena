<h1>{L_ELEMENTS_TITLE}</h1>

<P>{L_ELEMENTS_TEXT}</p>

<form method="post" action="{S_ELEMENTS_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_DESC}</th>
		<th class="thTop">{L_LEVEL}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN elements -->
	<tr>
		<td class="{elements.ROW_CLASS}" align="center">{elements.NAME}</td>
		<td class="{elements.ROW_CLASS}" align="center"><img src="../adr/images/elements/{elements.IMG}" alt="{elements.NAME}" /></td>
		<td class="{elements.ROW_CLASS}" align="center">{elements.DESC}</td>
		<td class="{elements.ROW_CLASS}" align="center">{elements.LEVEL}</td>
		<td class="{elements.ROW_CLASS}" align="center"><a href="{elements.U_ELEMENTS_EDIT}">{L_EDIT}</a></td>
		<td class="{elements.ROW_CLASS}" align="center"><a href="{elements.U_ELEMENTS_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END elements -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ELEMENTS_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />