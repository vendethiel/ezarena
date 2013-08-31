

<h1>{L_CELL_TITLE}</h1>



<p>{L_CELL_TEXT}</p>



<form action="{S_SUBMIT_ACTION}" method="post">



<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="100%">

	<tr>
<!-- Changed by aUsTiN
		<th class="thHead" align="center" colspan="2">{L_SELECT_CELLED}  {S_SELECT_CELLED}  </th>
-->
		<th class="thHead" align="center" colspan="2">{L_SELECT_CELLED}  <input type="text" class="post" size="10" name="jailed_username" value="Username"> ? <input type="text" class="post" size="10" name="jailed_user_id" value="user_id"></th>
	</tr>

	<tr>

		<td class="row1" width="60%"><span class="gen">{L_CELL_TIME}</span><br /><span class="gensmall">{L_CELL_TIME_EXPLAIN}</span></td>

		<td class="row2"><input class="post" type="text" name="time_day" size="8" maxlength="8" /> {L_DAY}<br /><input class="post" type="text" name="time_hour" size="8" maxlength="8" /> {L_HOUR}<br /><input class="post" type="text" name="time_minute" size="8" maxlength="8" /> {L_MINUTE}</td>

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

		<td class="row2" align="center" ><span class="gen">

			<input type="radio" name="punishment" value="1" />{L_PUNISHMENT_GLOBAL}<br />

			<input type="radio" name="punishment" value="2" />{L_PUNISHMENT_POSTS}<br />

			<input type="radio" name="punishment" value="3" />{L_PUNISHMENT_READ}

		</span></td>

	</tr>

	<tr>

		<td class="catBottom" align="center" colspan="2" ><input type="submit" name="submit" class="mainoption" value="{L_SELECT}" /></td>

	</tr>

</table>



<br clear="all" />



<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="99%">

	<tr>

		<th colspan="5" >{L_CELLED_USERS}</th>

	</tr>

	<tr>

		<td colspan="5" align="center" ><span class="gensmall"><b>{L_CELLED_USERS_EXPLAIN}</b></span></td>

	</tr>

	<tr>

		<th width="20%" align="center" >{L_CELLED_NAME}</th>

		<th width="20%" align="center" >{L_CELLED_CAUTION}</th>

		<th width="30%" align="center" >{L_CELLED_TIME}</th>

		<th width="30%" align="center" >{L_CELLED_SENTENCE}</th>

		<th align="center" >{L_CELLED_FREE}</th>

	</tr>

	<!-- BEGIN celled -->

	<tr>

		<td class="row1" width="15%" align="center" ><span class="gen"><a href="{celled.U_EDIT}"><b>{celled.CELLED_NAME}</b></a></span></td>

		<td class="row1" width="15%" align="center" ><span class="gen">{celled.CELLED_CAUTION}</span></td>

		<td class="row1" width="15%" align="center" ><span class="gen">{celled.CELLED_TIME}</span></td>

		<td class="row1" width="35%" align="center" ><span class="gen">{celled.CELLED_SENTENCE}</span></td>

		<td class="row1" align="center" ><input type="checkbox" name="{celled.CELLED_ID}" value="1" /></td>

	</tr>

	<!-- END celled -->



	<tr>

		<td class="catBottom" colspan="5" align="center"><input type="submit" name="update" value="{L_SUBMIT}" class="mainoption" /></td>

	</tr>

</table>



<br clear="all" />



<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="95%">

	<tr>

		<td class="row2" align="center" colspan="2" ><span class="gen">{L_MANUAL_UPDATE_EXPLAIN}</span></td>

	</tr>

	<tr>

		<td class="catBottom" colspan="4" align="center"><input type="submit" name="manual_update" value="{L_MANUAL_UPDATE}" class="mainoption" /></td>

	</tr>

</table>



</form>

