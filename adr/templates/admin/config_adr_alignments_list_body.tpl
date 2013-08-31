<h1>{L_ALIGNMENTS_TITLE}</h1>

<P>{L_ALIGNMENTS_TEXT}</p>

<form method="post" action="{S_ALIGNMENTS_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_DESC}</th>
		<th class="thTop">{L_LEVEL}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN alignments -->
	<tr>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.NAME}</td>
		<td class="{alignments.ROW_CLASS}" align="center"><img src="../adr/images/alignments/{alignments.IMG}" alt="{alignments.NAME}" /></td>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.DESC}</td>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.LEVEL}</td>
		<td class="{alignments.ROW_CLASS}" align="center"><a href="{alignments.U_ALIGNMENTS_EDIT}">{L_EDIT}</a></td>
		<td class="{alignments.ROW_CLASS}" align="center"><a href="{alignments.U_ALIGNMENTS_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END alignments -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ALIGNMENTS_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />