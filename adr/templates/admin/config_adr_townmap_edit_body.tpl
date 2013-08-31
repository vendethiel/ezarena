
<form method="post" action="{S_TOWNMAP_ACTION}">

<h1>{L_TOWNMAP_TITLE}</h1>

<p>{L_TOWNMAP_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="townmap_name" value="{TOWNMAP_NAME}" size="30" maxlength="255" />
	<!-- BEGIN alignments_edit -->
		<br /><span class="gensmall">{TOWNMAP_NAME_EXPLAIN}</span>
	<!-- END alignments_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="townmap_desc" value="{TOWNMAP_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN alignments_edit -->
		<br /><span class="gensmall">{TOWNMAP_DESC_EXPLAIN}</span>
	<!-- END alignments_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN alignments_add -->
		<td class="row2" align="center" ><input type="text" name="townmap_img" size="30" maxlength="255" /></td>
	<!-- END alignments_add -->
	<!-- BEGIN alignments_edit -->
		<td class="row2" align="center" ><input type="text" name="townmap_img" value="{TOWNMAP_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/TownMap/Admin_Carte/{TOWNMAP_IMG_EX}" alt="{TOWNMAP_NAME}" /></td>
	<!-- END alignments_edit -->
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>