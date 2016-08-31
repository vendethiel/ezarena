<!-- BEGIN edit -->
<h1>{edit.L_BBC_EDIT_TITLE}</h1>

<p>{edit.L_BBC_EDIT_TEXT}</p>

<p>{edit.L_BBC_EDIT_RULES}</p>
<!-- END edit -->
<!-- BEGIN add -->
<h1>{add.L_BBC_ADD_TITLE}</h1>

<p>{add.L_BBC_ADD_TEXT}</p>

<p>{add.L_BBC_ADD_RULES}</p>
<!-- END add -->
<form action="{S_BBC_BOX_ACTION}" method="post"><table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<!-- BEGIN edit -->
		<th class="thTop" colspan="2">{edit.L_BBC_EDIT_TITLE}</th>
		<!-- END edit -->
		<!-- BEGIN add -->
		<th class="thTop" colspan="2">{add.L_BBC_ADD_TITLE}</th>
		<!-- END add -->
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_BBC_NAME}:</span><br /><span class="gensmall">{L_BBC_NAME_EXPLAIN}</span></td>
		<!-- BEGIN edit -->
		<td class="row2"><input type="hidden" name="bbc_name" value="{BBC_NAME}" /><span class="gen"><b>{BBC_NAME}</b></span></td>
		<!-- END edit -->
		<!-- BEGIN add -->
		<td class="row2"><input class="post" type="text" name="bbc_name" size="35" maxlength="40" value="{BBC_NAME}" /></td>
		<!-- END add -->
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_BBC_BEFORE}:</span>
			<br /><span class="gensmall">{L_BBC_BEFORE_EXPLAIN}
			<!-- BEGIN edit -->
			{edit.L_BBC_BEFORE_EDIT_EXPLAIN}
			<!-- END edit -->
		</span></td>
		<td class="row2"><input class="post" type="text" name="bbc_before" size="35" maxlength="40" value="{BBC_BEFORE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_BBC_AFTER}:</span>
			<br /><span class="gensmall">{L_BBC_AFTER_EXPLAIN}
			<!-- BEGIN edit -->
			{edit.L_BBC_AFTER_EDIT_EXPLAIN}
			<!-- END edit -->
		</span></td>
		<td class="row2"><input class="post" type="text" name="bbc_after" size="35" maxlength="40" value="{BBC_AFTER}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_BBC_HELPLINE}:</span><br /><span class="gensmall">{L_BBC_HELPLINE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="bbc_helpline" size="35" maxlength="40" value="{BBC_HELPLINE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_BBC_IMG}:</span><br /><span class="gensmall">{L_BBC_IMG_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="bbc_img" size="35" maxlength="40" value="{BBC_IMG}" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_BBC_DIVIDER}</span><br /><span class="gensmall">{L_BBC_DIVIDER_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="bbc_divider" value="1" {BBC_DIVIDER} />{L_YES} &nbsp;&nbsp;<input type="radio" name="bbc_divider" value="0" {BBC_NOT_DIVIDER} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_BBC_MOVE_AFTER}</span></td>
		<td class="row2">{S_BBC_LIST_ORDER}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
