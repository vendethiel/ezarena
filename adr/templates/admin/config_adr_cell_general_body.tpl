
<h1>{L_CELL_SETTINGS}</h1>

<p>{L_CELL_SETTINGS_EXPLAIN}</p>

<form action="{S_CELL_ACTION}" method="post">

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_BARS}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="allow_display_bars" value="1" {CELL_BARS_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_CELLEDS}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="allow_display_celleds" value="1" {CELL_CELLEDS_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_CAUTION}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="allow_user_caution" value="1" {CELL_CAUTION_CHECKED} /></td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_JUDGE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="allow_user_judge" value="1" {CELL_JUDGE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_VOTERS}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="voters" value="{CELL_VOTERS}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_POSTS}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="posts" value="{CELL_POSTS}" /></td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_BLANK}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="allow_user_blank" value="1" {CELL_BLANK_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_CELL_BLANK_SUM}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="amount_user_blank" value="{CELL_BLANK}" /></td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />

