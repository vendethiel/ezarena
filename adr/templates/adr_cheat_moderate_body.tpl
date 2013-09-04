<form action="{S_SUBMIT_ACTION}" method="post">
<br />
<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" >{L_CHEAT_TITLE2}</th>
	</tr>
</table>
<table class="forumline" cellpadding="4" cellspacing="1" border="3" align="center" width="100%">
	<tr>
		<th align="center" >{USERNAME}</th>
	</tr>
	<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="100%">
		<tr>
			<td class="row1" width="60%" colspan="2" align="center" valign="middle"><span class="gen"><b>{CURRENT_PUNISHMENTS}</b></span></td>
		</tr>
		<tr>
			<td class="row1" width="60%"><span class="gen">{L_CELL_TIME}</span><br /><span class="gensmall">{L_CELL_TIME_EXPLAIN}</span></td>
			<td class="row2"><span class="gen"><input class="post" type="text" name="time_day" size="8" maxlength="8" /> {L_ZONE_DAY}<br /><input class="post" type="text" name="time_hour" size="8" maxlength="8" /> {L_ZONE_HOUR}<br /><input class="post" type="text" name="time_minute" size="8" maxlength="8" /> {L_ZONE_MINUTE}</span></td>
		</tr>
		<tr>
			<td class="row1" width="60%"><span class="gen">{L_CELL_CAUTION}</span><br /><span class="gensmall">{L_CELL_CAUTION_EXPLAIN}</span></td>
			<td class="row2"><input class="post" type="text" name="caution" size="8" maxlength="8" /></td>
		</tr>
		<tr>
			<td class="row1" width="60%"><span class="gen">{L_CELLED_SENTENCE}</span><br /><span class="gensmall">{L_CELLED_SENTENCE_EXPLAIN}</span></td>
			<td class="row2"><input class="post" type="text" name="sentence" size="60" maxlength="255" value="{L_SENTENCE}" /></td>
		</tr>
	</table>
	<br clear="all" />
	<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="100%">
		<tr>
			<td class="row1" width="60%"><span class="gen">{L_CELLED_FREEABLE}</span><br /><span class="gensmall">{L_CELLED_FREEABLE_EXPLAIN}</span></td>
			<td class="row2" align="center" ><input type="checkbox" name="freeable" value="1" /></td>
		</tr>
		<tr>
			<td class="row1" width="60%"><span class="gen">{L_CELLED_CAUTIONNABLE}</span><br /><span class="gensmall">{L_CELLED_CAUTIONNABLE_EXPLAIN}</span></td>
			<td class="row2" align="center" ><input type="checkbox" name="cautionable" value="1" /></td>
		</tr>
		<tr>
			<td class="row1" width="50%"><span class="gen">{L_PUNISHMENT}</span></td>
			<td class="row2" align="center" >
				<span class="gen">
					<input type="radio" name="punishment" value="1" />{L_PUNISHMENT_GLOBAL}<br />
					<input type="radio" name="punishment" value="2" />{L_PUNISHMENT_POSTS}<br />
					<input type="radio" name="punishment" value="3" />{L_PUNISHMENT_READ}
				</span>
			</td>
		</tr>
		<tr>
			<td class="catBottom" align="center" colspan="2" >
				<input type="submit" name="ban_board" class="mainoption" value="{L_SELECT2}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="cheat_id" value="{CHEAT_ID}">
				<input type="hidden" name="u" value="{JAILED_ID}">
				<input type="submit" name="submit" class="mainoption" value="{L_SELECT}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="ban_adr" class="mainoption" value="{L_SELECT3}" />
			</td>
		</tr>
	</table>
</form>
