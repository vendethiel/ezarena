
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
				<td width="100%" class="row1" height="100%" valign="top" align="right"><span class="gen">
					<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr>
					<td width="30%" class="row1"><a href="{FILE}?action=clp&t=news&a=new&clan={CLAN}&order={U_ORDER}&asc={U_ASC}&start={U_START}"><img src="{NEWPOST_IMG}" border="0"></a></td>
					<td width="70%" class="row1" align="right"><span class="gen"> 
						<form style="margin: 1px 1px 1px 1px;" action="{FILE}?action=clp&t=news&clan={CLAN}" method="post">
						{L_SORT_BY} 
						<select name="order">
							<option value="date" {D_SELECTED}>{DATE}</option>
							<option value="poster" {A_SELECTED}>{AUTHOR}</option>
							<option value="title" {T_SELECTED}>{L_TITLE}</option>
						</select>
						<select name="asc">
							<option value="desc" {DESC_SELECTED}>{DESC}</option>
							<option value="asc" {ASC_SELECTED}>{ASC}</option>
						</select>
						<input type="submit" value="{GO}">
						</form>
					</td>
					</tr></table>

					<table width="100%" cellpadding="5" cellspacing="0" border="0" class="forumline">
					<tr>
					<th width="25%" class="catHead">{L_TITLE}</th>
					<th class="catHead">{L_NEWSPOST}</th>
					<th width="100" class="catHead">{L_EDIT}</th></span>
					</td>
					</tr>
					<!-- BEGIN news -->
						<tr>
						<td width="25%" class="row{news.ROW}" valign="top">
							<span class="gensmall"><a href="#{news.NID}" name="{news.NID}"><img src="{MINIPOST_IMG}" border="0"></a></span>
							<span class="gen">&nbsp;<b>{news.TITLE}</b></span><br />
							<span class="gensmall">{news.BY}: <a href="profile.php?mode=viewprofile&u={news.POSTERID}">{news.POSTER}</a><br />
							{news.DATE}<br />&nbsp;</span>
						</td>
						<td class="row{news.ROW}" valign="top">
							<span class="gen">{news.TEXT}</span>
						</td>
						<td width="100" class="row{news.ROW}" valign="top" align="center">
							<span class="gen">
								<a href="{news.FILE}?action=clp&t=news&a=edit&news={news.ID}&clan={news.CLAN}&order={news.ORDER}&asc={news.ASC}&start={news.START}"><img src="{EDIT_IMG}" border="0"></a>&nbsp;
								<a href="{news.FILE}?action=clp&t=news&a=delete&news={news.ID}&clan={news.CLAN}&order={news.ORDER}&asc={news.ASC}&start={news.START}"><img src="{DELETE_IMG}" border="0"></a>
							</span>
						</td>
						</tr>
					<!-- END news -->
					</table>
					<table width="100%" cellspacing="0" cellpadding="0" border="0"> 
					<tr>
						<td class="row1"><span class="gensmall">{PAGE_NUMBER}</span></td>
						<td class="row1" align="right"><span class="gensmall">{PAGINATION}</span></td> 
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