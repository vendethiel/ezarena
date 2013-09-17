
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
		<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
			<table cellpadding="1" cellspacing="0" border="0" width="100%" class="bodyline">
			<tr><td nowrap="nowrap" class="row3" align="center">
			<a href="{FILE}?action=clp&t=members&clan={CLAN}" class="gensmall">{L_MEMBERS}</a>
			</td></tr></table>
		</td>
		<td class="row1" nowrap="nowrap" align="center" width="13%" 
			style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; ">
			<span class="gensmall"><b>{L_NEWS}</b></span>
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
				<td width="100%" class="row1" height="100%" valign="top" align="center"><span class="gen">
					<table width="60%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<form action="{FILE}?action=clp&t=news&clan={CLAN}&a={ACTION}" method="post">
					<tr>
						<th colspan="2" class="catHead">{L_POST_NEW}</th>
					</tr>
					<tr>
						<td width="25%" class="row2"><span class="gen"><b>{L_CLAN}</b></span></td><td width="75%" class="row2"><span class="gen"><a href="clans.php?action=clanpage&clan={CLAN}" target="_blank">{CLANNAME}</a></span></td>
					</tr>
					<tr>
						<td width="25%" class="row2"><span class="gen"><b>{L_POSTER}</b></span></td><td width="75%" class="row2"><span class="gen"><a href="profile.php?mode=viewprofile&u={POSTERID}" target="_blank">{POSTER}</a></span></td>
					</tr>
					<tr>
						<td width="25%" class="row2"><span class="gen"><b>{L_TITLE}</b></span></td><td width="75%" class="row2"><input type="text" name="title" value="{P_TITLE}"></td>
					</tr>
					<tr>
						<td width="25%" class="row2"><span class="gen"><b>{L_NEWSPOST}</b></span></td><td width="75%" class="row2"><textarea rows="10" cols="60" name="text">{P_TEXT}</textarea></td>
					</tr>
					<tr>
						<td class="catBottom" height="28" align="center" colspan="2"><input type="submit" value="{L_POST}"></td>
					</tr>
					</form>
					</table>
				</span></td>
				</tr>
				</table>
				<br />
				{CLICK_BACK}<br />
				<br />
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