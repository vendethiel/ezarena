<form action="{S_POST_ACTION}" method="post" name="post">
  {ERROR_BOX} 
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
  </table>
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{L_POINTS_TITLE}</th>
	</tr>
	<!-- BEGIN switch_points_cp -->
	<tr> 
	  <td class="row1"><span class="gen">{L_USERNAME}:</span></td>
	  <td class="row2"><span class="genmed"> 
		<input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" />
		&nbsp; 
		<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
		</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_MASS_EDIT}:</span><br />
		<span class="gensmall">{L_MASS_EDIT_EXPLAIN}</span></td>
	  <td class="row2"><span class="genmed"><textarea name="mass_username" rows="5" cols="50"></textarea></span></td>
	</tr>
	<td class="row1"><span class="gen">{L_METHOD}:</span><br />
	  <span class="gensmall">{L_ADD_SUBTRACT}</span></td>
	<td class="row2"><span class="gensmall"> 
	  <input type="radio" name="method" value="1" checked />
	  {L_ADD}&nbsp;&nbsp; 
	  <input type="radio" name="method" value="0" />
	  {L_SUBTRACT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AMOUNT}:</span><br />
		<span class="gensmall">{L_AMOUNT_GIVE_TAKE}</span> </td>
	  <td class="row2"> 
		<input type="text" name="amount" maxlength="11" value="0" size="11">
	  </td>
	</tr>
	<!-- END switch_points_cp -->
	<!-- BEGIN switch_points_donate -->
	<tr> 
	  <td class="row1"><span class="gen">{L_USERNAME}:</span><br />
		<span class="gensmall">{L_DONATE_TO}</span></td>
	  <td class="row2"><span class="genmed"> 
		<input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" />
		&nbsp; 
		<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
		</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AMOUNT}:</span><br />
		<span class="gensmall">{L_AMOUNT_GIVE}</span> </td>
	  <td class="row2"> 
		<input type="text" name="amount" maxlength="11" value="0" size="11">
	  </td>
	</tr>
	<!-- END switch_points_donate -->
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" class="liteoption" />
	  </td>
	</tr>
  </table>
</form>
<br clear="all" />