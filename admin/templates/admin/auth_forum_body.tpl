
<h1>{L_AUTH_TITLE}</h1>

<p>{L_AUTH_EXPLAIN}</p>

<h2>{L_FORUM}: {FORUM_NAME}</h2>

<form method="post" action="{S_FORUMAUTH_ACTION}">
  <table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline">
	<tr> 
		<td>
			<table border="0" cellspacing="1" cellpadding="0" align="center">
				<!-- BEGIN forum_auth_titles -->
				<tr> 
					<th class="thTop" style="height:28px;padding: 0px 4px;">{forum_auth_titles.CELL_TITLE}</th>
				</tr>
				<!-- END forum_auth_titles -->
			</table>
		</td>
		<td>
			<table border="0" cellspacing="1" cellpadding="0" align="center">
				<!-- BEGIN forum_auth_data -->
				<tr>
					<td class="row1" align="center" style="height:28px;">{forum_auth_data.S_AUTH_LEVELS_SELECT}</td>
				</tr>
				<!-- END forum_auth_data -->
		</table>
		</td>
	</tr>
	<tr> 
	  <td colspan="2" align="center" class="row1" style="padding: 6px 0px;"> <span class="gensmall">{U_SWITCH_MODE}</span></td>
	</tr>
	<tr>
	  <td colspan="2" class="catBottom" align="center">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	  </td>
	</tr>
  </table>
</form>
