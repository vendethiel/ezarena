<!-- [ Copyright 2006, Olympus-Style Login Screen 3.0.0 ] -->
<form action="{S_LOGIN_ACTION}" method="post" target="_top">

<br />
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="bodyline">
	<tr>
		<td class="row1">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td width="50%" align="left"><span class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_LOGIN}" class="nav">{L_LOGIN}</a></span></td>
				<td width="50%" align="right"><span class="gensmall">&nbsp;{S_TIMEZONE}&nbsp;</span></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<br />

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th colspan="2">{L_LOGIN}</th>
	</tr>
	<tr>
		<td class="row3" colspan="2" align="center"><span class="gensmall">{L_ENTER_PASSWORD}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="50%">
		<div align="center"><span class="gensmall">
		<!-- BEGIN switch_user_logged_out -->
		{L_LOGIN_INFO}
		<!-- END switch_user_logged_out -->
		<!-- BEGIN switch_admin_reauth -->
		{L_LOGIN_ADMIN}
		<!-- END switch_admin_reauth -->
		</span><br /><br />
		<span class="genmed" align="center"><a href="{U_INDEX}">{L_LOGIN_INDEX}</a> | 
		<!-- BEGIN switch_admin_activation -->
		<a href="{U_LOGIN_ACTIVATE}">{L_LOGIN_ACTIVATE}</a> | 
		<!-- END switch_admin_activation -->
		<a href="{U_FAQ}">{L_LOGIN_FAQ}</a></span> 
		</div></td>
		<td class="row2">
			<table cellspacing="1" cellpadding="4" width="100%">
				<tr>
					<td class="row1" width="30%"><b class="gensmall">{L_USERNAME}:</b></td>
					<td width="70%" class="row1">
						<input class="post" type="text" name="username" size="25" maxlength="40" value="{USERNAME}" tabindex="1" /><br />
						<!-- BEGIN switch_user_logged_out -->
						<a class="gensmall" href="{U_REGISTER}">{L_LOGIN_REGISTER}</a>
						<!-- END switch_user_logged_out -->
					</td>
				</tr>
				<tr>
					<td width="30%" class="row1"><b class="gensmall">{L_PASSWORD}:</b></td>
					<td width="70%" class="row1">
					<input class="post" type="password" name="password" size="25" maxlength="25" tabindex="2" /><br />
					<!-- BEGIN switch_user_logged_out -->
					<a class="gensmall" href="{U_SEND_PASSWORD}">{L_SEND_PASSWORD}</a>
					<!-- END switch_user_logged_out -->
					</td>
				</tr>
				<!-- BEGIN switch_user_logged_out -->
				<tr>
					<td class="row1"><span class="gensmall"><b>{L_LOGIN_OPTIONS}:</b></span></td>
					<td width="100%" class="row1">
						<span class="gensmall">
						<!-- END switch_user_logged_out -->
						<!-- BEGIN switch_allow_autologin -->
						<input type="checkbox" name="autologin" tabindex="5"  checked="checked" /> {L_AUTO_LOGIN}
						<!-- END switch_allow_autologin -->
						<!-- BEGIN switch_user_logged_out -->
						<br />
						<input type="checkbox" name="hideonline" tabindex="5" />{L_LOGIN_HIDEME}
						</span>
					</td>
				</tr>
				<!-- END switch_user_logged_out -->
         	</table>
		</td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="login" class="mainoption" value="{L_LOGIN}" tabindex="3" /></td>
	</tr>
</table>
</form>
<br />
<br />
<!-- [ Copyright 2006, Olympus-Style Login Screen 3.0.0 ] -->