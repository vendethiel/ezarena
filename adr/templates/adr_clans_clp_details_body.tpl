
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
		<td class="row1" nowrap="nowrap" align="center" width="13%" 
			style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; ">
			<span class="gensmall"><b>{L_DETAILS}</b></span>
		</td>
		<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
			<table cellpadding="1" cellspacing="0" border="0" width="100%" class="bodyline">
			<tr><td nowrap="nowrap" class="row3" align="center">
			<a href="{FILE}?action=clp&t=members&clan={CLAN}" class="gensmall">{L_MEMBERS}</a>
			</td></tr></table>
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
					<form action="{FILE}?action=clp&t=details&a=edit&clan={CLAN}" method="post">
					<table width="100%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<tr>
						<th colspan="2" class="catHead">{L_MANAGE}</th>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_NAME}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="name" value="{V_NAME}"></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_DESCRIPTION}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><textarea name="desc" rows="10" cols="60">{V_DESC}</textarea></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_LOGO}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><img src="{V_LOGO}"><br /><input type="text" size="60" name="logo" value="{V_LOGO}"></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_APPROVE}</span><br /><span class="gensmall">{L_APPROVE_EXP}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><select name="approve"><option value="0" {NO_CHECKED}>{L_NO}</option><option value="1" {YES_CHECKED}>{L_YES}</option></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_POSTS}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="posts" value="{V_POSTS}" size="4"></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_LEVEL}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="level" value="{V_LEVEL}" size="4"></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_POINTSNAME} {L_POINTS}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="points" value="{V_POINTS}" size="4"> {L_POINTSNAME}</span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_FEE}</span><br /><span class="gensmall">{L_FEE_EXP}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="fee" value="{V_FEE}" size="4"> {L_POINTSNAME}</span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_AMOUNT}</span><br /><span class="gensmall">{L_AMOUNT_EXP}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="text" name="amount" value="{V_AMOUNT}" size="4"></span></td>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_ORDER}</span><br /><span class="gensmall">{L_ORDER_EXP}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_ORDERBY} <select name="orderby"><option value="date" {DATE_SELECTED}>{L_DATE}</option><option value="poster" {POSTER_SELECTED}>{L_AUTHOR}</option><option value="title" {TITLE_SELECTED}>{L_TITLE}</option></select> <select name="order"><option value="0" {DESC_CHECKED}>{L_DESC}</option><option value="1" {ASC_CHECKED}>{L_ASC}</option></span></td>
					</tr>
					<tr>
						<th colspan="2" class="catBottom"><input type="hidden" name="oldname" value="{V_NAME}"><input type="submit" value="{L_SUBMIT}" class="mainoption"></th>
					</tr>
					</table>
					</form>
				</span></td>
				</tr>
				</table>

				<br />

				<table width="95%" cellpadding="0" cellspacing="0" border="0" align="center"> 
				<tr>
				<td width="100%" class="row1" height="100%" valign="top" align="right"><span class="gen">
					<form action="{FILE}?action=clp&t=details&a=gameover&clan={CLAN}" method="post">
					<table width="100%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<tr>
						<th colspan="2" class="catHead">{L_DELETE}</th>
					</tr>
					<tr>
						<td width="50%" class="row2" valign="top"><span class="gen">{L_DELETE}</span><br /><span class="gensmall">{L_DELETE_EXP}</span></td>
						<td width="50%" class="row2" valign="top"><span class="gen"><input type="checkbox" name="dodelete" value="killmenow"> {L_DODEL}</span></td>
					</tr>
					<tr>
						<th colspan="2" class="catBottom"><input type="submit" value="{L_SUBMIT}" class="mainoption"></th>
					</tr>
					</table>
					</form>
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