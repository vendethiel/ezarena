
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline"> 
   <tr> 
     <th class="thHead" width="100%">{HEADER}</th> 
   </tr> 
   <tr>
	<td class="row1" width="100%" height="100%"><span class="gen">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center"> 
		<tr>

		<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
			<table cellpadding="1" cellspacing="0" border="0" width="100%" class="bodyline">
			<tr><td nowrap="nowrap" class="row3" align="center">
			<a href="{FILE}?action=clp&clan={CLAN}" class="gensmall">{L_INTRO}</a>
			</td></tr></table>
		</td>
		<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
			<table cellpadding="1" cellspacing="0" border="0" width="100%" class="bodyline">
			<tr><td nowrap="nowrap" class="row3" align="center">
			<a href="{FILE}?action=clp&t=details&clan={CLAN}" class="gensmall">{L_DETAILS}</a>
			</td></tr></table>
		</td>
		<td class="row1" nowrap="nowrap" align="center" width="13%" 
			style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; ">
			<span class="gensmall"><b>{L_MEMBERS}</b></span>
		</td>
		<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
			<table cellpadding="1" cellspacing="0" border="0" width="100%" class="bodyline">
			<tr><td nowrap="nowrap" class="row3" align="center">
			<a href="{FILE}?action=clp&t=news&clan={CLAN}" class="gensmall">{L_NEWS}</a>
			</td></tr></table>
		</td>
		<td nowrap="nowrap" align="right" width="48%" style="border-bottom : 1px solid Black;"><span class="gensmall">
			<!-- BEGIN nuladion -->
				{nuladion.NULADION}
			<!-- END nuladion -->
		</span></td>

		</tr>

		<tr>
			<td colspan="5" align="center" class="row1" style="border-left : 1px solid Black; border-bottom : 1px solid Black; border-right : 1px solid Black;"><span class="gen">
				<br />
				<table width="95%" cellpadding="0" cellspacing="0" border="0" align="center"> 
				<tr>
				<td width="100%" class="row1" height="100%" valign="top" align="right"><span class="gen">
					<table width="100%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<tr>
						<th colspan="3" class="catHead">{L_MANAGE}</th>
					</tr>
					<tr>
						<td width="30%" class="row2" valign="top"><span class="gen">{LEADER_NAME}</span></td>
						<td width="30%" class="row2" valign="top"><span class="gen">{LEADER_RANK}</span></td>
						<td width="40%" class="row2" valign="top"><span class="gen">&nbsp;</span></td>
					</tr>
					<!-- BEGIN memberlist -->
					<tr>
						<td width="30%" class="row2" valign="top"><span class="gen">{memberlist.NAME}</span></td>
						<td width="30%" class="row2" valign="top"><span class="gen">{memberlist.RANK}</span></td>
						<td width="40%" class="row2" valign="top" align="center"><span class="gensmall">
							[ <a href="{FILE}?action=clp&t=members&a=kick&member={memberlist.ID}&clan={CLAN}">{memberlist.L_KICK}</a> ] 
							[ <a href="{FILE}?action=clp&t=members&a=promote&member={memberlist.ID}&clan={CLAN}">{memberlist.L_PROMOTE}</a> ] 
						</span></td>
					</tr>
					<!-- END memberlist -->
					<tr>
						<th colspan="3" class="catBottom">&nbsp;</th>
					</tr>
					</table>

					<br /><br />

					<table width="100%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<tr>
						<th colspan="3" class="catHead">{L_MANAGE_APPROVE}</th>
					</tr>
					<!-- BEGIN approvelist -->
					<tr>
						<td width="30%" class="row2" valign="top"><span class="gen">{approvelist.NAME}</span></td>
						<td width="30%" class="row2" valign="top"><span class="gensmall">{approvelist.L_FEE}</span></td>
						<td width="40%" class="row2" valign="top" align="center"><span class="gensmall">
							[ <a href="{FILE}?action=clp&t=members&a=approve&member={approvelist.ID}&clan={CLAN}">{approvelist.L_APPROVE}</a> ] 
							[ <a href="{FILE}?action=clp&t=members&a=disapprove&member={approvelist.ID}&clan={CLAN}">{approvelist.L_DISAPPROVE}</a> ] 
						</span></td>
					</tr>
					<!-- END approvelist -->
					<!-- BEGIN no_approvelist -->
					<tr>
						<td width="100%" colspan="3" class="row2" align="center" valign="top"><span class="gen"><i>{no_approvelist.L_EMPTY}</i></span></td>
					</tr>
					<!-- END no_approvelist -->
					<tr>
						<th colspan="3" class="catBottom">&nbsp;</th>
					</tr>
					</table>
					<table width="100%" cellpadding="5" cellspacing="0" border="0">
					<tr>
						<td width="100%" class="row1" align="left"><span class="gensmall">{L_TRANSFER}</span></td>
					</tr>
					</table>
				</span></td>
				</tr>
				</table>
				<br /><br />
			</span></td>
		</tr>
		</table>
	</span></td>
  </tr>
<!-- BEGIN bars -->
  <tr>
	<td class="row2" align="center"><span class="gensmall">
		{bars.L_BACK_TO_CLANPAGE}
	</span></td>
  </tr>
  <tr>
	<td class="row2" align="center"><span class="gensmall">
		{bars.L_BACKTOLIST}
	</span></td>
  </tr>
<!-- END bars -->

  </table>