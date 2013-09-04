{BBC_JS_BOX}

<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center"><tr> 
<td align="left" valign="bottom"><span class="gensmall"> 
<!-- BEGIN switch_user_logged_in -->
{LAST_VISIT_DATE}<br />
<!-- END switch_user_logged_in -->
{CURRENT_TIME}<br />
</span><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>

</table>

{POST_PREVIEW_BOX}
{ERROR_BOX}
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
<form action="{U_SHOUTBOX}" method="post" name="post" onsubmit="return checkForm(this)">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>{L_SHOUT_TEXT}</b></th>
	</tr>
	<!-- BEGIN switch_username_select -->
	<tr> 
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" /></span></td>
	</tr>
	<!-- END switch_username_select -->

	<tr> 
	  <td class="row1" valign="top"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td valign="middle" align="center"> <br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle">
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
				</tr>
				<!-- END switch_smilies_extra -->
			  </table>
			</td>
		  </tr>
		</table>
	  </td>



	  <td class="row2" valign="top"><table cellspacing="0" cellpadding="2" border="0">
		{BBC_DISPLAY_BOX}
		<tr>
			<td><textarea name="message" rows="15" cols="76" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea></td>
		</tr>
	  </table></td>


	</tr>
	<tr> 
	  <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"><span class="gen"> </span> 
		<table cellspacing="0" cellpadding="1" border="0">
		  <!-- BEGIN switch_html_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_html" {S_HTML_CHECKED} />
			</td>
			<td><span class="gen">{L_DISABLE_HTML}</span></td>
		  </tr>
		  <!-- END switch_html_checkbox -->
		  <!-- BEGIN switch_bbcode_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_bbcode" {S_BBCODE_CHECKED} />
			</td>
			<td><span class="gen">{L_DISABLE_BBCODE}</span></td>
		  </tr>
		  <!-- END switch_bbcode_checkbox -->
		</table>
	  </td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}
<input type="submit" tabindex="5" name="refresh" class="mainoption" value="{L_SHOUT_REFRESH}" />&nbsp;
<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_SHOUT_PREVIEW}" />&nbsp;
<input type="submit" accesskey="s" tabindex="6" name="shout" class="mainoption" value="{L_SHOUT_SUBMIT}" /></td>
	</tr>
  </table>
</form>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	   <td align="right" valign="bottom" class="gensmall"> 
<span class="nav">
	{PAGINATION}</span>
</td>
	</tr>
</table>
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr align="right">
		<td class="catHead" colspan="2" height="28" align="center"><b>&nbsp;{L_SHOUTBOX}&nbsp;<b/></td>
	</tr>
	<tr>
		<th class="thLeft" width="160" height="26" nowrap="nowrap">{L_AUTHOR}</th>
		<th class="thRight" nowrap="nowrap">{L_MESSAGE}</th>
	</tr>

	<!-- BEGIN shoutrow -->
	<tr> 
		<td width="160" align="left" valign="top" class="{shoutrow.ROW_CLASS}">
			<span class="name"><b>{shoutrow.SHOUT_USERNAME}</b></span><br />
			<span class="postdetails">{shoutrow.USER_RANK}<br />
			{shoutrow.RANK_IMAGE}<br/>
			{shoutrow.USER_AVATAR}<br /><br/>{shoutrow.USER_JOINED}</span></td>
		<td class="{shoutrow.ROW_CLASS}" width="100%" height="28" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><a href="{shoutrow.U_MINI_POST}"><img src="{shoutrow.MINI_POST_IMG}" width="12" height="9" alt="{shoutrow.L_MINI_POST_ALT}" title="{shoutrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: {shoutrow.TIME}</span></td>
				<td valign="top" align="right" nowrap="nowrap">{shoutrow.QUOTE_IMG}{shoutrow.EDIT_IMG}{shoutrow.CENSOR_IMG}{shoutrow.DELETE_IMG}{shoutrow.IP_IMG}</td></form>
			</tr>
			<tr> 
				<td colspan="2"><hr/></td>
			</tr>
			<tr>
				<td colspan="2"><span class="postbody">{shoutrow.SHOUT}{shoutrow.SIGNATURE}</span></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1"><img src="templates/{T_TEMPLATE_NAME}/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END shoutrow -->

</table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="left" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	  <td align="right" valign="bottom" class="gensmall"> 
<span class="nav">
	{PAGINATION}</span>
</td>
	</tr>
</table>