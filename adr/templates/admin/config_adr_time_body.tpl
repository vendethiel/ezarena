<h1>{L_TIME_TITLE}</h1>

<p>{L_TIME_EXPLAIN}</p>

<form method="post" action="{S_TIME_ACTION}">

<table align="center" border="0" cellspacing="1" cellpadding="3" class="forumline" width="90%">
	<tr>
		<th class="thHead" colspan="2">{L_TIME_CONFIG}</th>
	</tr>
	<tr>
		<td class="row2" width="60%"><span class="gen">{L_TIME_CHOICE}</span></td>
		<td class="row2" align="center">{TIME_LIST}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_TIME_TIME}</span></td>
		<td class="row1" align="center"><input type="post" class="post" name="time_time" maxlength="8" size="8" value="{TIME_TIME}" /><span class="gen">&nbsp;{L_TIME_DAYS}</span></td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="center"><input type="submit" name="submit" value="{L_TIME_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

</form>

<br clear="all" />