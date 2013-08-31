<h1>{L_TOWNMAP_TITLE}</h1>

<P>{L_TOWNMAP_TEXT}</p>

<form method="post" action="{S_TOWNMAP_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="row2" width="60%">{L_NUM_NAME}<br /><span class="gensmall">{L_NUM_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="carte" value="{TOWNMAP_MAP}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_TOWNMAP_CHANGE}" class="mainoption" /></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NUM}</th>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_DESC}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN alignments -->
	<tr>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.NUM}</td>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.NAME}</td>
		<td class="{alignments.ROW_CLASS}" align="center"><img src="../adr/images/TownMap/Admin_Carte/{alignments.IMG}" alt="{alignments.NAME}" /></td>
		<td class="{alignments.ROW_CLASS}" align="center">{alignments.DESC}</td>
		<td class="{alignments.ROW_CLASS}" align="center"><a href="{alignments.U_TOWNMAP_EDIT}">{L_EDIT}</a></td>
	</tr>
	<!-- END alignments -->
</table>
</form>

<br clear="all" />