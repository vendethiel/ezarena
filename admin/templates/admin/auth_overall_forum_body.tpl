<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script type="text/javascript" language="JavaScript" src="../admin/auth_overall_forum/overlib.js"></script>
<script type="text/javascript" language="JavaScript" src="../admin/auth_overall_forum/admin_overall_forumauth.js"></script>
<h1>{L_FORUM_TITLE}</h1>
	  		<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
				<tr>
<td class="row1">
<p>{L_FORUM_EXPLAIN}</p>

				</tr>
			</table>

<form method="post" action="{S_FORUM_ACTION}"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="16">{L_FORUM_TITLE}</th>
	</tr>
	<tr>
	  <td class="row1" align="center" valign="middle" colspan="16">
	  		<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
				<tr>
					<td class="row1">
						<!-- BEGIN authedit -->
						<a href="javascript:void(0);" onClick="return start_edit('{authedit.VALUE}', '{authedit.NAME}');" class="gen"><img src="../admin/auth_overall_forum/{authedit.NAME}.gif">&nbsp;{authedit.NAME}</a><br />
						<!-- END authedit -->
					</td><td class="row2">
						<a href="javascript:void(0);" onClick="return start_restore();" class="gen">{L_FORUM_OVERALL_RESTORE}</a><br /><br />
						<a href="javascript:void(0);" onClick="return stop_edit();" class="gen">{L_FORUM_OVERALL_STOP}</a>
					</td>
				</tr>
				<tr>
					<td class="row3" colspan="2"><span class="gensmall">{L_FORUM_EXPLAIN_EDIT}</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<td class="catLeft" width="50%"><span class="cattitle"><b><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></b></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_VOIR}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_LIRE}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_POSTER}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_REP}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_EDIT}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_SUPP}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_POST_IT}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_ANNONCE}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_VOTE}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_SONDAGE}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_BAN}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_BLUECARD}</span></td>		
		<td class="cat" align="center" valign="middle"><span class="gen">{L_GREENCARD}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_ATTACHMENTS}</span></td>
		<td class="cat" align="center" valign="middle"><span class="gen">{L_DOWNLOAD}</span></td>
	</tr>
	<!-- BEGIN forumrow -->
	<tr> 
		<td class="row1"><span class="gen">{catrow.forumrow.FORUM_NAME}</span></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_VIEW_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_VIEW_IMG}',{catrow.forumrow.FORUM_ID},'VIEW');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_VIEW" name="auth[{catrow.forumrow.FORUM_ID}][VIEW]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_READ_IMG}.gif"  onClick="return change_auth(this,'{catrow.forumrow.AUTH_READ_IMG}',{catrow.forumrow.FORUM_ID},'READ');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_READ" name="auth[{catrow.forumrow.FORUM_ID}][READ]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_POST_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_POST_IMG}',{catrow.forumrow.FORUM_ID},'POST');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_POST" name="auth[{catrow.forumrow.FORUM_ID}][POST]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_REPLY_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_REPLY_IMG}',{catrow.forumrow.FORUM_ID},'REPLY');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_REPLY" name="auth[{catrow.forumrow.FORUM_ID}][REPLY]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_EDIT_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_EDIT_IMG}',{catrow.forumrow.FORUM_ID},'EDIT');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_EDIT" name="auth[{catrow.forumrow.FORUM_ID}][EDIT]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_DELETE_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_DELETE_IMG}',{catrow.forumrow.FORUM_ID},'DELETE');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_DELETE" name="auth[{catrow.forumrow.FORUM_ID}][DELETE]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_STICKY_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_STICKY_IMG}',{catrow.forumrow.FORUM_ID},'STICKY');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_STICKY" name="auth[{catrow.forumrow.FORUM_ID}][STICKY]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_ANNOUNCE_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_ANNOUNCE_IMG}',{catrow.forumrow.FORUM_ID},'ANNOUNCE');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_ANNOUNCE" name="auth[{catrow.forumrow.FORUM_ID}][ANNOUNCE]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_VOTE_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_VOTE_IMG}',{catrow.forumrow.FORUM_ID},'VOTE');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_VOTE" name="auth[{catrow.forumrow.FORUM_ID}][VOTE]"></td>
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_POLLCREATE_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_POLLCREATE_IMG}',{catrow.forumrow.FORUM_ID},'POLLCREATE');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_POLLCREATE" name="auth[{catrow.forumrow.FORUM_ID}][POLLCREATE]"></td>
    	<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_BAN_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_BAN_IMG}',{catrow.forumrow.FORUM_ID},'AUTH_BAN');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_AUTH_BAN" name="auth[{catrow.forumrow.FORUM_ID}][AUTH_BAN]"></td>
    	<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_BLUECARD_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_BLUECARD_IMG}',{catrow.forumrow.FORUM_ID},'AUTH_BLUECARD');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_AUTH_BLUECARD" name="auth[{catrow.forumrow.FORUM_ID}][AUTH_BLUECARD]"></td>	 
    	<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_GREENCARD_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_GREENCARD_IMG}',{catrow.forumrow.FORUM_ID},'AUTH_GREENCARD');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_AUTH_GREENCARD" name="auth[{catrow.forumrow.FORUM_ID}][AUTH_GREENCARD]"></td>	  
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_ATTACHMENTS_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_ATTACHMENTS_IMG}',{catrow.forumrow.FORUM_ID},'AUTH_ATTACHMENTS');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_AUTH_ATTACHMENTS" name="auth[{catrow.forumrow.FORUM_ID}][AUTH_ATTACHMENTS]"></td>	  
		<td class="row2"><img src="../admin/auth_overall_forum/{catrow.forumrow.AUTH_DOWNLOAD_IMG}.gif" onClick="return change_auth(this,'{catrow.forumrow.AUTH_DOWNLOAD_IMG}',{catrow.forumrow.FORUM_ID},'AUTH_DOWNLOAD');"><input type="hidden" id="auth_{catrow.forumrow.FORUM_ID}_AUTH_DOWNLOAD" name="auth[{catrow.forumrow.FORUM_ID}][AUTH_DOWNLOAD]"></td>	  
	</tr>
	<!-- END forumrow -->
	<!-- END catrow -->
	<tr>
		<td colspan="16" class="catBottom" align="center"><input type="submit" class="liteoption" name="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table></form>
