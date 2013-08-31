
{JS_SCRIPT}

<h1>{L_USERS_INACTIVE}</h1>

<p>
	{L_USERS_INACTIVE_EXPLAIN}<br /><br/><u>{L_CHECK_ENABLE_ACCOUNT_ACTIVATION}</u> {L_RECOM_ACC_ACTIV}<br />&nbsp;<br />
	{L_REMOVED_USERS}: <b>{REMOVED_USERS}</b>
</p>

<form method="post" name="tablesForm">

<table cellspacing="2" cellpadding="4" border="0">
 <tr>
 	<td colspan="6">{L_ALERT_EVERY} <input type="text" name="alert_days" value="{S_ALERT_DAYS}" size="3"> {L_ALERT_DAYS} {L_WITH_ZERO_MESSAGES} <input type="checkbox" name="zero_messages" {S_ZERO_MESSAGES}> <input type="submit" name="alert_days_check" value="{L_POST}" class="mainoption" onClick="document.tablesForm.action='{S_INACTIVE_ACTION}'" /></td>
 </tr>
 <tr>
 	<td bgcolor="{ALERT_COLOR}">{L_ALERT_UPTO} {ALERT_DAYS} {L_ALERT_DAYS}</td>
 	<td bgcolor="{ALERT_COLOR2}">{L_ALERT_UPTO} {ALERT_DAYS2} {L_ALERT_DAYS}</td>
 	<td bgcolor="{ALERT_COLOR3}">{L_ALERT_UPTO} {ALERT_DAYS3} {L_ALERT_DAYS}</td>
 	<td bgcolor="{ALERT_COLOR4}">{L_ALERT_UPTO} {ALERT_DAYS4} {L_ALERT_DAYS}</td>
 	<td bgcolor="{ALERT_COLOR5}">{L_ALERT_UPTO} {ALERT_DAYS5} {L_ALERT_DAYS}</td>
 	<td bgcolor="{ALERT_COLOR_OVER}">{L_ALERT_OVER} {ALERT_DAYS_OVER} {L_ALERT_DAYS}</td>
 </tr>
 </table><br /><br />
  
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">

<tr>
	<th class="thCornerL">N.</th>
	<th class="thTop">{L_USER}</th>
	<th class="thTop">{L_EMAIL}</th>
	<th class="thTop">{L_REGISTRATION_DATE}</th>
	<th class="thTop">{L_LAST_VISIT}</th>
	<th class="thTop">{L_ACTIVE}</th>
	<th class="thTop">{L_POSTS}</th>
	<th class="thTop">{L_EMAIL_SENTS}</th>
	<th class="thTop">{L_LAST_EMAIL_SENTS}</th>
	<th class="thCornerR">&nbsp;</th>
</tr>	

<!-- BEGIN Table_InactiveUsers -->
<tr>
	<td class="{Table_InactiveUsers.ROW_CLASS}">{Table_InactiveUsers.NUMBER}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}"><a href="{Table_InactiveUsers.U_USERNAME}">{Table_InactiveUsers.USERNAME}</a></td>
	<td class="{Table_InactiveUsers.ROW_CLASS}">{Table_InactiveUsers.EMAIL_IMG}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="center">{Table_InactiveUsers.USER_REGDATE}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="center">{Table_InactiveUsers.USER_LASTVISIT}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="center">{Table_InactiveUsers.USER_ACTIVE}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="center">{Table_InactiveUsers.USER_POSTS}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="right">{Table_InactiveUsers.USER_EMAIL_SENTS}</td>
	<td class="{Table_InactiveUsers.ROW_CLASS}" align="center">{Table_InactiveUsers.USER_LAST_EMAIL_SENTS}</td>
	<td bgcolor="{Table_InactiveUsers.ROW_CLASS_ALERT}" align="center">{Table_InactiveUsers.S_SELECT_TABLE}</td>
</tr>
<!-- END Table_InactiveUsers -->

<tr>
	<td class="row3" colspan="10" align="center">
		<nobr><a href="#" onclick="setCheckboxes('tablesForm', true); return false;">{L_CHECKALL}</a>&nbsp;/&nbsp;<a href="#" onclick="setCheckboxes('tablesForm', false); return false;">{L_UNCHECKALL}</a>&nbsp;/&nbsp;<a href="#" onclick="setCheckboxes('tablesForm', 'invert'); return false;">{L_INVERTCHECKED}</a></nobr>
	</td>
</tr>

<tr>
	<td class="row3" colspan="10" align="center">
		<nobr><span style="background-color:{ALERT_COLOR_OVER}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert_over');">{L_CHECKCOLOR}</a></span>&nbsp;<span style="background-color:{ALERT_COLOR5}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert5');">{L_CHECKCOLOR}</a></span>&nbsp;<span style="background-color:{ALERT_COLOR4}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert4');">{L_CHECKCOLOR}</a></span>&nbsp;<span style="background-color:{ALERT_COLOR3}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert3');">{L_CHECKCOLOR}</a></span>&nbsp;<span style="background-color:{ALERT_COLOR2}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert2');">{L_CHECKCOLOR}</a></span>&nbsp;<span style="background-color:{ALERT_COLOR}; padding:4px;"><a href="javascript:selColor('tablesForm', 'alert');">{L_CHECKCOLOR}</a></span></nobr>
	</td>
</tr>

<tr>
	<td class="cat" colspan="10" align="center">
	<input type="submit" name="inactive_users_do" value="{L_CONTACT_USERS}" class="mainoption" onClick="document.tablesForm.action='{S_INACTIVE_ACTION}&mode=contact'" />
	<input type="submit" name="inactive_users_do" value="{L_ACTIVATE_USERS}" class="mainoption" onClick="document.tablesForm.action='{S_INACTIVE_ACTION}&mode=activate'" />
	<input type="submit" name="inactive_users_do" value="{L_DELETE_USERS}" class="mainoption" onClick="document.tablesForm.action='{S_INACTIVE_ACTION}&mode=delete'" />
	</td>
</tr>

</table>

</form>