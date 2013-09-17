<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
   <tr> 
     <th class="thHead" colspan="{TABLEROWS}">{L_JOINED}</th> 
   </tr> 
	<tr>
		<td class="row1" width="20%"><span class="gen">
			<b>{L_NAME}</b>
		</span></td>
		<td class="row1" width="20%"><span class="gen">
			<b>{L_LEADER}</b>
		</span></td>
		<td class="row1" width="40%"><span class="gen">
			<b>{L_MEMBERS}</b>
		</span></td>
		<td class="row1" width="20%"><span class="gen" align="center">
			<b>{L_LEAVE}</b>
		</span></td>
	</tr>

	<!-- BEGIN userclans -->
	<form action="{userclans.FILE}?action={userclans.ACTION}&clan={userclans.ID}" method="post">
	<tr>
		<td class="row1" width="20%"><span class="gen">
			<a href="{userclans.FILE}?action=clanpage&clan={userclans.ID}">{userclans.NAME}</a>
		</span></td>
		<td class="row1" width="20%"><span class="gen">
			{userclans.LEADER}
		</span></td>
		<td class="row1" width="40%"><span class="gen">
			{userclans.MEMBERS}
		</span></td>
		<td class="row1" width="20%"><span class="gen" align="center">
			<input type="submit" class="mainoption" value=" {userclans.L_LEAVE} ">
		</span></td>
	</tr>
	</form>
	<!-- END userclans -->
	<!-- BEGIN no_userclans -->
	<tr>
		<td class="row1" width="100%" colspan="4" align="center"><span class="gen">
			<i>{no_userclans.L_NONE}</i>
		</span></td>
	</tr>
	<!-- END no_userclans -->

  </table>
<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
   <tr> 
     <th class="thHead" colspan="{TABLEROWS}">{L_ALLCLANS}</th> 
   </tr> 
	<tr>
		<td class="row1" width="20%"><span class="gen">
			<b>{L_NAME}</b>
		</span></td>
		<td class="row1" width="20%"><span class="gen">
			<b>{L_LEADER}</b>
		</span></td>
		<td class="row1" width="40%"><span class="gen">
			<b>{L_MEMBERS}</b>
		</span></td>
		<td class="row1" width="20%"><span class="gen" align="center">
			<b>{L_JOIN}</b>
		</span></td>
	</tr>

	<!-- BEGIN allclans -->
	<form action="{allclans.FILE}?action=join&clan={allclans.ID}" method="post">
	<tr>
		<td class="row1" width="20%"><span class="gen">
			<a href="{allclans.FILE}?action=clanpage&clan={allclans.ID}">{allclans.NAME}</a>
		</span></td>
		<td class="row1" width="20%"><span class="gen">
			{allclans.LEADER}
		</span></td>
		<td class="row1" width="40%"><span class="gen">
			{allclans.MEMBERS}
		</span></td>
		<td class="row1" width="20%"><span class="gen" align="center">
			<input type="submit" class="mainoption" value=" {allclans.L_JOIN} ">
		</span></td>
	</tr>
	</form>
	<!-- END allclans -->
	<!-- BEGIN no_allclans -->
	<tr>
		<td class="row1" width="100%" colspan="4" align="center"><span class="gen">
			<i>{no_allclans.L_NONE}</i>
		</span></td>
	</tr>
	<!-- END no_allclans -->

  </table>

  <!-- BEGIN no_userclans -->
  <br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
	<form action="{FILE}?action=create" method="post">
	<tr>
		<td colspan="{TABLEROWS}" class="row1" width="100%" align="center"><span class="gen">
			<input type="submit" class="mainoption" value=" {L_CREATE_NEW} ">
		</span></td>
	</tr>
	</form>
  </table>
  <!-- END no_userclans -->
<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
<!-- BEGIN infobar -->
	{infobar.TEXT}
<!-- END infobar -->
  </table>
