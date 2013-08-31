<h1>{L_SEASONS_TITLE}</h1>

<P>{L_SEASONS_EXPLAIN}</p>

<form method="post" action="{S_SEASONS_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_SEASONS_CONFIG}</u></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><span class="gen">{L_SEASON_CHOICE}</span></td>
		<td class="row2" align="center" >{SEASON_LIST}</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_SEASON_TIME}</span></td>
		<td class="row1" align="center"><input type="post" name="season_time" maxlength="8" size="8" value="{SEASON_TIME}" />&nbsp;{L_SEASON_DAYS}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="12" align="center"><input type="submit" name="submit" value="{L_SEASON_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />