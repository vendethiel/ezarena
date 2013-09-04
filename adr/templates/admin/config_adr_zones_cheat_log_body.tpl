<script language="Javascript" type="text/javascript">
<!--
function setCheckboxes(theForm, elementName, isChecked)
{
	var chkboxes = document.forms[theForm].elements[elementName];
	var count = chkboxes.length;

	if (count)
	{
		for (var i = 0; i < count; i++)
		{
			chkboxes[i].checked = isChecked;
	    	}
	}
	else
	{
    		chkboxes.checked = isChecked;
	}
	return true;
}

//-->
</script>

<form method="post" action="{S_MODE_ACTION}" name="items_form" >
<h1>{L_PAGE_TITLE}</h1>

<p>{L_PAGE_TITLE_EXPLAIN}</p>

<br />
<!-- BEGIN punishment -->
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
				<input type="hidden" name="u" value="{JAILED_ID}">
				<input type="hidden" name="mode" value="{L_PUNISH}">
				<input type="hidden" name="cheat_id" value="{CHEAT_ID}">
				<input type="submit" name="submit" class="mainoption" value="{L_SELECT}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="ban_adr" class="mainoption" value="{L_SELECT3}" />
			</td>
		</tr>
	</table>
<!-- END punishment -->
<!-- BEGIN list -->
<table width="100%" align="center" valign="left">
	<tr>
		<th width="100%" align="center" valign="middle">{L_PAGE_TITLE}</th>
	</tr>
</table>
<table width="100%" align="top" class="forumline">
	<tr>
		<th width="5%" align="center" valign="middle">&nbsp;</th>
		<th width="15%" align="center" valign="middle">{L_CHEAT_IP}</th>
		<th width="15%" align="center" valign="middle">{L_CHEAT_USERNAME}</th>
		<th width="15%" align="center" valign="middle">{L_CHEAT_CHARACTER}</th>
		<th width="25%" align="center" valign="middle">{L_CHEAT_TYPE}</th>
		<th width="15%" align="center" valign="middle">{L_CHEAT_DATE}</th>
		<th valign="middle" align="center" colspan="2">{L_CHEAT_ACTION}</th>
	</tr>
<!-- BEGIN rows -->
	<tr>
		<td align="left" valign="middle" class="{list.rows.ROWS}"><span class="genmed">{list.rows.NUM}</span></td>
		<td align="center" valign="middle" class="{list.rows.ROWS}"><span class="genmed">{list.rows.CHEAT_IP}</span></td>
		<td align="left" valign="middle" class="{list.rows.ROWS}"><span class="genmed"><a href="{list.rows.U_CHEAT_USERNAME}" target="_profile" title="{L_PROFILE}">{list.rows.CHEAT_USERNAME}</a></span></td>
		<td align="left" valign="middle" class="{list.rows.ROWS}"><span class="genmed"><a href="{list.rows.U_CHEAT_CHARACTER}" target="_character" title="{L_CHARACTER}">{list.rows.CHEAT_CHARACTER}</a></span></td>
		<td align="left" valign="middle" class="{list.rows.ROWS}" onMouseOver="this.style.backgroundColor=''; this.style.cursor='arrow';" onMouseOut=this.style.backgroundColor="" title="{list.rows.CHEAT_PUNISHMENT}" ><span class="genmed">{list.rows.CHEAT_TYPE}</span></td>
		<td align="center" valign="middle" class="{list.rows.ROWS}"><span class="genmed">{list.rows.CHEAT_DATE}</span></td>
		<td align="center" valign="middle" class="{list.rows.ROWS}"><span class="genmed"><a href="{list.rows.U_CHEAT_PUNISH}" title="Punish the user for cheating">{list.rows.L_PUNISH}</a></span></td>
		<td align="center" valign="middle" class="{list.rows.ROWS}"><span class="genmed">
			<input type="checkbox" name="action_box[]" value="{list.rows.CHEAT_ID}" /></span>
		</td>
	</tr>
<!-- END rows -->
	<tr>
		<td class="catBottom" colspan="10" height="28" align="right" nowrap="nowrap">
			<span class="genmed">
				<a href="#" onclick="setCheckboxes('items_form', 'action_box[]', true); return false;" class="gensmall">{L_CHECK_ALL}</a>&nbsp;/&nbsp;
				<a href="#" onclick="setCheckboxes('items_form', 'action_box[]', false); return false;" class="gensmall">{L_UNCHECK_ALL}</a>
			</span>
		</td>
	</tr>
</table>
<table width="100%" align="middle" class="forumline">
	<tr>
		<th width="100%" colspan="10" align="right">{ACTION_SELECT}&nbsp;&nbsp;&nbsp;<input type="submit" value="{L_SUBMIT}" class="mainoption" /></th>
	</tr>
</table>
<table width="100%" align="middle">
	<tr>
		<td><span class="genmed">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="genmed">{PAGINATION}</span></td>
	</tr>
</table>
<table width="100%" align="center" valign="middle" border="0" >
	<tr>
		<td align="center"><span class="gensmall">Note:  Hover over the cheat attempted to see the punishment given for their actions.</span></td>
	</tr>
</table>
<br clear="all" />
<!-- END list -->
</form>
