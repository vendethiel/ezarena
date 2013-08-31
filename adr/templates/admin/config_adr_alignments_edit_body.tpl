
<form method="post" action="{S_ALIGNMENTS_ACTION}">

<h1>{L_ALIGNMENTS_TITLE}</h1>

<p>{L_ALIGNMENTS_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="alignment_name" value="{ALIGNMENT_NAME}" size="30" maxlength="255" />
	<!-- BEGIN alignments_edit -->
		<br /><span class="gensmall">{ALIGNMENT_NAME_EXPLAIN}</span>
	<!-- END alignments_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="alignment_desc" value="{ALIGNMENT_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN alignments_edit -->
		<br /><span class="gensmall">{ALIGNMENT_DESC_EXPLAIN}</span>
	<!-- END alignments_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN alignments_add -->
		<td class="row2" align="center" ><input type="text" name="alignment_img" size="30" maxlength="255" /></td>
	<!-- END alignments_add -->
	<!-- BEGIN alignments_edit -->
		<td class="row2" align="center" ><input type="text" name="alignment_img" value="{ALIGNMENT_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/alignments/{ALIGNMENT_IMG_EX}" alt="{ALIGNMENT_NAME}" /></td>
	<!-- END alignments_edit -->
	</tr>
	<tr>
		<td class="row1">{L_LEVEL}<br /><span class="gensmall">{L_LEVEL_EXPLAIN}</span></td>
		<td class="row2" align="center" >{LEVEL_LIST}</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>