		<!-- BEGIN post_row -->
		<!-- BEGIN saut -->
		<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="{SPACE_ROW}"></td></tr></table>	
		<!-- END saut -->
		<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		  <tr>
			<th>{post_row.TITLE}</th>
		  </tr>
		  <tr>
			<td class="row2" align="left" height="24">
			<span class="gensmall">{L_POSTED}: <b>{post_row.POSTER}</b> @ {post_row.TIME}</span>
			</td>
		  </tr>
		  <tr>
			<td class="row1" align="left">
			<span class="gensmall" style="line-height:150%">{post_row.TEXT}<br />
			<br />{post_row.OPEN}<a href="{post_row.U_READ_FULL}">{post_row.L_READ_FULL}</a>
			{post_row.CLOSE}
			</span>
			</td>
		  </tr>
		  <tr>
			<td class="row3" align="left" height="24"><span class="gensmall">
			{L_COMMENTS}: {post_row.REPLIES} :: <a href="{post_row.U_VIEW_COMMENTS}">{L_VIEW_COMMENTS}</a>
			(<a href="{post_row.U_POST_COMMENT}">{L_POST_COMMENT}</a>)</span>
			</td>
		  </tr>
		</table>
		<!-- END post_row -->
	