
<h1>{L_VAULT_TITLE}</h1>

<p>{L_VAULT_TEXT}</p>

<form action="{S_VAULT_ACTION}" method="post">

<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="80%">
	<tr>
		<td class="row1" align="center">{L_SELECT_OWNER}</td>
		<td class="row2" align="center">{L_SELECT_OWNER_LIST} : {S_SELECT_OWNER}<br />
		{L_SELECT_OWNER_INPUT} : <input class="post" type="text" name="owner_name" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row3" align="center" colspan="2" ><input type="submit" class="mainoption" value="{L_SELECT}" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellpadding="2" cellspacing="1" border="0" align="center" width="90%">
	<tr>
		<th class="thHead" colspan="2" >{L_OWNER} : {OWNER}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center" height="30" ><span class="gen"><b>{L_ACCOUNT}</b></span></td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_ON_ACCOUNT}</span></td>
		<td class="row2" align="center" ><span class="gen" align="center" ><input class="post" type="text" name="on_account" size="8" maxlength="8" value="{ON_ACCOUNT}" />&nbsp;{L_POINTS}</span></td>
	</tr>
	<!-- BEGIN active_loan -->
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_LOAN}</span></td>
		<td class="row2" align="center" ><span class="gen" align="center" ><input class="post" type="text" name="loan_sum" size="8" maxlength="8" value="{LOAN}" />&nbsp;{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_LOAN_PAY_OFF}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="pay_off" value="1" /></td>
	</tr>
	<!-- END active_loan -->
	<!-- BEGIN no_loan -->
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_LOAN}</span></td>
		<td class="row2" align="center" ><span class="gen" align="center" >{LOAN}</span></td>
	</tr>
	<!-- END no_loan -->
	<tr>
		<td class="row2" colspan="2" align="center" height="30" ><span class="gen"><b>{L_PREFERENCES}</b></span></td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_PROTECT_ACCOUNT}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="protect_account" value="1" {PROTECT_ACCOUNT_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" ><span class="gen">{L_PROTECT_LOAN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="protect_loan" value="1" {PROTECT_LOAN_CHECKED} /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="hidden" name="user_id" value="{USER_ID}" /><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>

</table>
</form>
