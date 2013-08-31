
<h1>{L_CELL_TITLE}</h1>

<p>{L_CELL_TEXT}</p>

<form action="{S_SUBMIT_ACTION}" method="post">

<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="100%">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_SELECTED_CELLED}&nbsp;&nbsp;{SELECTED_CELLED}</th>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_CELL_TIME}</span><br /><span class="gensmall">{L_CELL_TIME_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="time_day" size="8" maxlength="8" value="{DAY}" />&nbsp;{L_DAY}<br /><input class="post" type="text" name="time_hour" size="8" maxlength="8" value="{HOUR}" />&nbsp;{L_HOUR}<br /><input class="post" type="text" name="time_minute" size="8" maxlength="8" value="{MINUTE}" />&nbsp;{L_MINUTE}</td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_CELL_CAUTION}</span><br /><span class="gensmall">{L_CELL_CAUTION_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="caution" size="8" maxlength="8" value="{CELLED_CAUTION}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_CELLED_SENTENCE}</span><br /><span class="gensmall">{L_CELLED_SENTENCE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="sentence" size="60" maxlength="255" value="{CELLED_SENTENCE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="80%"><span class="gen">{L_CELLED_FREEABLE}</span><br /><span class="gensmall">{L_CELLED_FREEABLE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="checkbox" name="freeable" {FREEABLE} value="1" /></td>
	</tr>
	<tr>
		<td class="row1" width="80%"><span class="gen">{L_CELLED_CAUTIONNABLE}</span><br /><span class="gensmall">{L_CELLED_CAUTIONNABLE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="checkbox" name="cautionable" {CAUTIONNABLE} value="1" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_PUNISHMENT}</span></td>
		<td class="row2" align="center" ><span class="gen">
			<input type="radio" name="punishment" value="1" {PUNISHMENT_GLOBAL} />{L_PUNISHMENT_GLOBAL}<br />
			<input type="radio" name="punishment" value="2" {PUNISHMENT_POSTS} />{L_PUNISHMENT_POSTS}<br />
			<input type="radio" name="punishment" value="3" {PUNISHMENT_READ} />{L_PUNISHMENT_READ}
		</span></td>
	</tr>
</table>
<br clear="all" />
<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="100%">
	<tr>
		<td class="row1" width="80%"><span class="gen">{L_CELLED_BLANK}</span><br /><span class="gensmall">{L_CELLED_BLANK_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="checkbox" name="blank" value="1" /></td>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2" ><input type="hidden" name="id" value="{SELECTED_CELLED_ID}" /><input type="submit" name="user_update" class="mainoption" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>
