<form action="{S_LOGIN_ACTION}" method="post" target="_top">
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="1" style="border-collapse: collapse; border-style: solid; border-width: 1">
	<tr>
		<td width="80%" align="left" class="row1"><span class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>  <a href="{U_LOGIN}" class="nav">{L_LOGIN}</a></span></td>
		<td width="20%" align="right" class="row1"><span class="gensmall">&nbsp;{S_TIMEZONE}&nbsp;</span></td>
	</tr>
</table>
<br />
   <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
      <tr>
         <th colspan="2">{L_LOGIN}</th>
      </tr>
      <tr>
         <td class="row3" colspan="2" align="center"><span class="gensmall">
         <!-- BEGIN switch_forced_login -->
         {L_FORCED_LOGIN_EXPLAIN}
         <!-- END switch_forced_login -->
         {L_ENTER_PASSWORD}</span>
         </td> 
      </tr>
      <tr>
		<td class="row1" width="50%"><center><span class="gensmall">
		<!-- BEGIN switch_user_logged_out -->
		{L_OL_INFOLOGIN}
		<!-- END switch_user_logged_out -->
		<!-- BEGIN switch_admin_reauth -->
		{L_OL_INFOADMIN}
		<!-- END switch_admin_reauth -->
		</span><br /><br />
		<span class="genmed" align="center"><a href="{U_INDEX}">{L_OL_BINDEX}</a> | 
<!-- BEGIN switch_admin_activation -->
		<a href="{U_OL_ACTIVATION}">{L_OL_ACTIVATION}</a> | 
<!-- END switch_admin_activation -->
		<a href="{U_FAQ}">{L_OL_READFAQ}</a></span> 
		</center></td>
		<td class="row2">
			<table cellspacing="1" cellpadding="4">
				<tr>
					<td class="row1" width="40%"><b class="gensmall">{L_USERNAME}:</b></td>
					<td width="60%" class="row1">
						<input class="post" type="text" name="username" size="25" maxlength="40" value="{USERNAME}" tabindex="1" /><br />
<!-- BEGIN switch_user_logged_out -->
						<a class="gensmall" href="{U_REGISTER}">{L_OL_REGISTER}</a>
<!-- END switch_user_logged_out -->
					</td>
				</tr>
				<tr>
					<td class="row1" width="40%"><b class="gensmall">{L_PASSWORD}:</b></td>
					<td width="60%" class="row1">
					<input class="post" type="password" name="password" size="25" maxlength="25" tabindex="2" /><br />
<!-- BEGIN switch_user_logged_out -->
					<a class="gensmall" href="{U_SEND_PASSWORD}">{L_SEND_PASSWORD}</a>
<!-- END switch_user_logged_out -->
					</td>
				</tr>
<!-- BEGIN switch_user_logged_out -->
				<tr>
					<td class="row1"><span class="gensmall"><b>{L_OL_OPTIONS}:</b></span></td>
					<td width="100%" class="row1">
						<span class="gensmall">
						<input type="checkbox" name="autologin" tabindex="5" />{L_AUTO_LOGIN}
						<br />
						<input type="checkbox" name="hideonline" tabindex="5" />{L_OL_HIDEONLINESTATUS}
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
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="1" style="border-collapse: collapse; border-style: solid; border-width: 1">
	<tr>
		<td width="80%" align="left" class="row1"><span class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>  <a href="{U_LOGIN}" class="nav">{L_LOGIN}</a></span></td>
		<td width="20%" align="right" class="row1"><span class="gensmall">&nbsp;{S_TIMEZONE}&nbsp;</span></td>
	</tr>
</table>
<!-- [ 2005 © Olympus-Style Login Screen 2.0.0 ] -->
<br /></form>
