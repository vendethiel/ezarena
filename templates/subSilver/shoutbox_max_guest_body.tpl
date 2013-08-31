<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center"><tr> 
<td align="left" valign="bottom"><span class="gensmall"> 
<!-- BEGIN switch_user_logged_in -->
{LAST_VISIT_DATE}<br />
<!-- END switch_user_logged_in -->
{CURRENT_TIME}<br />
</span><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_SHOUTBOX}" class="nav">{L_SHOUTBOX}</a></span></td>
</tr>

</table>

<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
<form action="{U_SHOUTBOX}" method="post" name="post" onsubmit="return checkForm(this)">
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}
<input type="submit" tabindex="1" name="refresh" class="mainoption" value="{L_SHOUT_REFRESH}" />&nbsp;
</td>
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
				<td width="100%"><span class="postdetails">{L_POSTED}: {shoutrow.TIME}</span></td>
				<td valign="top" align="right" nowrap="nowrap">{shoutrow.QUOTE_IMG}{shoutrow.EDIT_IMG}{shoutrow.DELETE_IMG}{shoutrow.IP_IMG}</td></form>
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
		<td class="spaceRow" colspan="2" height="1"><img src="templates/pussycatblue/images/spacer.gif" alt="" width="1" height="1" /></td>
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
