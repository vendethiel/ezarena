<form action="{S_VAULT_ACTION}" method="post">
<br/>
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
	<tr> 
	  <td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="list" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
  </table>

  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thCornerL" nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_PROFILE}</th>
	  <th class="thTop" nowrap="nowrap">{L_ON_ACCOUNT}</th>
	  <th class="thTop" nowrap="nowrap">{L_ON_LOAN}</th>
	</tr>
	<!-- BEGIN vault_users -->
	<tr> 
	  <td class="{vault_users.ROW_CLASS}" align="center"><span class="gen">&nbsp;{vault_users.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{vault_users.ROW_CLASS}" align="center"><span class="gen">{vault_users.USERNAME}</span></td>
	  <td class="{vault_users.ROW_CLASS}" align="center"><span class="gen"><a href="{vault_users.U_VIEWPROFILE}" class="gen">{vault_users.PROFILE_IMG}</a></span></td>
	  <td class="{vault_users.ROW_CLASS}" align="center"><span class="gen">{vault_users.ACCOUNT}</span></td>
	  <td class="{vault_users.ROW_CLASS}" align="center"><span class="gen">{vault_users.LOAN}</span></td>
	</tr>
	<!-- END vault_users -->
	<tr> 

	  <td class="catbottom" colspan="9" height="28">&nbsp;</td>

	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"></td>
	</tr>
  </table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table></form>

</form>

<br />
<br />
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_TOWNMAPCOPYRIGHT}">{L_TOWNMAPCOPYRIGHT}</a></span></td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>



<br clear="all" />


