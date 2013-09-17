<br />
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
   <tr> 
     <th class="thHead" width="100%">{NAME}</th> 
   </tr> 
   <tr>
	<td class="row1" width="100%"  height="100%"><span class="gen">
		<table width="100%"  height="100%" cellpadding="4" cellspacing="1" border="0" align="center"> 
		<tr>

		<td class="row1" width="65%" valign="top" height="100%" align="center"><span class="gen">
			<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center"> 
			<tr>
			<td width="100%" class="row1" align="center"><span class="gen">
				<img src="{LOGO}" alt="{NAME} {L_LOGO}" title="{NAME} {L_LOGO}">
			</span></td>
			</tr>
			</table>
			<br /><br />
			<table width="90%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
			<tr> 
				<th class="thHead" width="100%">{L_DESCRIPTION}</th> 
			</tr> 
			<tr>
			<td width="100%" class="row1" align="left"><span class="gen">
				{DESCRIPTION}
			</span></td>
			</tr>
			</table>
			<br />
			<!-- BEGIN newsposts -->
				<br /><br />
				<table width="90%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
				<tr> 
					<th class="thHead" width="100%">{newsposts.TITLE}</th> 
				</tr> 
				<tr>
				<td width="100%" class="row1" align="left"><span class="gensmall">
					<i>{newsposts.DATE} {newsposts.L_BY} {newsposts.POSTER}</i></span><br />
					<span class="gen"><br />
					{newsposts.TEXT}
				</span></td>
				</tr>
				</table>
			<!-- END newsposts -->
			<table width="90%" cellspacing="4" cellpadding="1" border="0" align="center"> 
			  <tr> 
			   <td class="row1" align="left"><span class="gensmall">{PAGE_NUMBER}</span></td> 
			   <td class="row1" align="right"><span class="gensmall">{PAGINATION}</span></td> 
			  </tr> 
			</table><br /><br />
		</span></td>

		<td class="row1" width="35%" valign="top" height="100%" align="center"><span class="gen">
			<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
			<tr> 
				<th class="thHead" width="100%" colspan="2">{L_DETAILS}</th> 
			</tr> 
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_NAME}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{NAME}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left" valign="top"><span class="gen">{L_FOUNDED}</span></td>
				<td width="50%" class="row1" align="left"><span class="gensmall">{FOUNDED} {L_FOUNDED_BY} <a href="profile.php?mode=viewprofile&u={FOUNDER_ID}" target="_blank">{FOUNDER}</a></span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_LEADER}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{LEADER}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_MEMBERS}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{MEMBERS}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_APPROVING}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{APPROVING}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_APPROVELIST}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{APPROVELIST}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_REQ_POSTS}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{REQ_POSTS}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_POINTS} {L_REQ_POINTS}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{REQ_POINTS}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_REQ_LEVEL}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{REQ_LEVEL}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row1" align="left"><span class="gen">{L_JOIN_FEE}</span></td>
				<td width="50%" class="row1" align="left"><span class="gen">{JOIN_FEE}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row2" align="left"><span class="gen">{L_STASH}</span></td>
				<td width="50%" class="row2" align="left"><span class="gen">{STASH} {L_POINTS}</span></td>
			</tr>
			<tr>
				<td width="50%" class="row2" align="left"><span class="gen">{L_ISTASH}</span></td>
				<td width="50%" class="row2" align="left"><span class="gen">{ISTASH}</span></td>
			</tr>
			</table>

			<br /><br />

			<table width="80%" height="220" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
			<tr> 
				<th class="thHead" width="100%">{L_SHOUTBOX}</th> 
			</tr> 
			<tr>
				<form action="{FILE}?action=addshout&clan={ID}" method="post" target="clan_shoutbox">
				<td width="100%" height="100%" class="row1" align="left"><span class="gen">
					<iframe src="{FILE}?action=shoutbox&clan={ID}" height="80%" width="100%" frameborder="0" scrolling="yes" marginwidth="0" marginheight="0" name="clan_shoutbox"></iframe><br />
					<input type="text" size="25" value="" name="shout">
					<input type="submit" class="liteoption" value="{L_SHOUT}">
				</span></td>
				</form>
			</tr>
			</table>
		</span></td>

		</tr>
		</table>
	<br />
	</span></td>
  </tr>
<!-- BEGIN clanleader -->
  <tr>
	<td class="row2" align="center"><span class="gensmall">
		<a href="{clanleader.FILE}?action=clp&clan={clanleader.CLAN}">{clanleader.L_GOTOPANEL}</a>
	</span></td>
  </tr>
<!-- END clanleader -->
  <tr>
	<td class="row2" align="center"><span class="gensmall">
		{L_BACKTOLIST}
	</span></td>
  </tr>

<!-- BEGIN infobar -->
	{infobar.TEXT}
<!-- END infobar -->

  </table>
