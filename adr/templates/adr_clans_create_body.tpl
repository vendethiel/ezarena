<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
   <tr> 
     <th class="thHead" colspan="2">{L_CREATENEW}</th> 
   </tr> 
	<tr>
		<td class="row1" align="left" width="100%"><span class="gen">

		<center>

		<br />
		{L_CREATE_TEXT}<br />
		<br />

		  <table width="80%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
		   <tr> 
		     <th class="thHead" colspan="2">&nbsp;</th> 
		   </tr> 
			<form action="{FILE}?action=docreate" method="post">
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_NAME}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" name="name" value="">
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_LEADER}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					{USERNAME}
				</span></td>
			</tr>
			<tr>
				<td class="row1" valign="top" width="50%"><span class="gen">
					<b>{L_DESCRIPTION}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<textarea cols="60" rows="5" name="description"></textarea>
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_LOGO}</b><br />
					</span><span class="gensmall">{L_URLLOGO}
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" size="60" name="logo" value="http://">
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_APPROVING}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<select name="approving"><option value="0">{L_NO}</option><option value="1">{L_YES}</option></select>
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_REQ_POSTS}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" name="req_posts" value="0">
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_POINTS} {L_REQ_POINTS}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" name="req_points" value="0">
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_REQ_LEVEL}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" name="req_level" value="0">
				</span></td>
			</tr>
			<tr>
				<td class="row1" width="50%"><span class="gen">
					<b>{L_JOIN_FEE}</b>
				</span></td>
				<td class="row1" width="50%"><span class="gen">
					<input type="text" name="join_fee" value="0"> {L_POINTS}
				</span></td>
			</tr>
			<tr>
				<td class="row1" colspan="2" align="center" width="100%"><span class="gen">
					<input type="submit" value="{L_CREATE}">
				</span></td>
			</tr>
			</form>
		  </table>

		<br />
		{L_BACKTOLIST}<br />
		<br />

		</center>

		</span></td>
	</tr>
  </table>
<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
<!-- BEGIN infobar -->
	{infobar.TEXT}
<!-- END infobar -->
  </table>
