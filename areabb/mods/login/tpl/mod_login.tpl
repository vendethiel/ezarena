<!-- BEGIN logged_out -->
<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<form method="post" action="{S_LOGIN_ACTION}">		  
   <tr>
	<th colspan="2">{L_LOGIN}</th>
   </tr>
   <tr> 
	<td class="row1" align="right">
	<span class="gensmall" style="line-height=150%">
	<input type="hidden" name="redirect" value="{REDIRECT}" />
	{L_USERNAME}:
	</span>
	</td>
	<td class="row1" align="left">
	&nbsp;<input class="post" type="text" name="username" size="15" />
	</td>
   </tr>
   <tr>	
	 <td class="row1" align="right">
	<span class="gensmall" style="line-height=150%">
	{L_PASSWORD}:
	</span>
	 </td>
	 <td class="row1" align="left">
		&nbsp;<input class="post" type="password" name="password" size="15" />
	 </td>	
	</tr>
	<tr>
	  <td colspan="2" class="row1" align="center" valign="middle" ><span class="gensmall">			
	<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />&nbsp;&nbsp;<input class="text" type="checkbox" name="autologin" title="{L_REMEMBER_ME}" /><br />
	<br /><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a><br />{L_REGISTER_NEW_ACCOUNT}</span>
	   </td>
   </tr>
</form>		   
  </table>
<!-- END logged_out -->