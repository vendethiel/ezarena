<script>
window.form_name = 'forum';
window.text_name = 'forumdesc_long';
</script>
{BBC_JS_BOX}
<script>
// disable color palette
window.colorPalette = function () { };
</script>

<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>
<script language="javascript" type="text/javascript">
<!--
function update_forum_icon(newimage)
{
	document.forum_icon.src = "{ICON_BASEDIR}/" + newimage;
}
//-->
</script>

<form action="{S_FORUM_ACTION}" method="post" name="forum">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_FORUM_SETTINGS}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_NAME}</td>
	  <td class="row2"><input class="post" type="text" size="25" name="forumname" value="{FORUM_NAME}" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_ICON}</td>
	  <td class="row2"><select name="forumicon" onchange="update_forum_icon(this.options[selectedIndex].value);">{ICON_LIST}</select> &nbsp; <img name="forum_icon" src="{ICON_IMG}" border="0" alt="" /> &nbsp;</td>
	</tr>	
	<tr> 
	  <td class="row1">{L_FORUM_DESCRIPTION}<br /><span class="gensmall">{L_FORUM_DESC_EXPLAIN}<span></td>
	  <td class="row2">
	  	<textarea rows="5" cols="45" wrap="virtual" name="forumdesc" class="post">{DESCRIPTION}</textarea>
	  </td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_DESC_LONG}<br /><span class="gensmall">{L_DESC_LONG_EXPLAIN}</span></td>
	  <td class="row2"><table cellspacing="0" cellpadding="2" border="0">
	  	{BBC_DISPLAY_BOX}
		<tr>
	  	<td><textarea name="forumdesc_long" rows="15" cols="76" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{DESCRIPTION_LONG}</textarea>
		</td></tr>
		</table>
	  </td>
	</tr>
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><select name="c">{S_CAT_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
		<tr> 
	  <td class="row1">{L_PASSWORD}</td>
	  <td class="row2"><input type="text" name="password" value="{FORUM_PASSWORD}" size="30" maxlength="20" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_ENTER_LIMIT}</td>
	  <td class="row2"><input type="text" name="forum_enter_limit" value="{FORUM_ENTER_LIMIT}" size="10" maxlength="8" /></td>
	</tr>	
	<tr> 
	  <td class="row1">{L_FORUM_EXTERNAL}</td>
	  <td class="row2"> 
		<input type="radio" name="forum_external" value="1" {FORUM_EXTERNAL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="forum_external" value="0" {FORUM_EXTERNAL_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_REDIRECT_URL}</td>
	  <td class="row2"><input class="post" type="text" name="forum_redirect_url" value="{FORUM_REDIRECT_URL}" size="60" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_EXT_NEWWIN}</td>
	  <td class="row2"> 
		<input type="radio" name="forum_ext_newwin" value="1" {FORUM_EXT_NEWWIN_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="forum_ext_newwin" value="0" {FORUM_EXT_NEWWIN_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_EXT_IMAGE}</td>
	  <td class="row2"><input class="post" type="text" name="forum_ext_image" value="{FORUM_EXT_IMAGE}" size="60" class="post" /></td>
	</tr>	
	<tr> 
	  <td class="row1">{L_POINTS_DISABLED}</td>
	  <td class="row2"><select name="points_disabled">{S_POINTS_LIST}</select></td>
	</tr>	
	<tr>
	  <td class="row1">{L_QP_TITLE}</td>
	  <td class="row2">
	  	<input type="radio" name="forum_qpes" value="1" {FORUM_QP_YES} /> {L_YES}&nbsp;
	  	<input type="radio" name="forum_qpes" value="0" {FORUM_QP_NO} /> {L_NO}
	  </td>
	</tr>	
	<tr> 
	  <td class="row1">{L_AUTO_PRUNE}</td>
	  <td class="row2"><table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td align="right" valign="middle">{L_ENABLED}</td>
			<td align="left" valign="middle"><input type="checkbox" name="prune_enable" value="1" {S_PRUNE_ENABLED} /></td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_DAYS}</td>
			<td align="left" valign="middle">&nbsp;<input class="post" type="text" name="prune_days" value="{PRUNE_DAYS}" size="5" />&nbsp;{L_DAYS}</td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_FREQ}</td>
			<td align="left" valign="middle">&nbsp;<input class="post" type="text" name="prune_freq" value="{PRUNE_FREQ}" size="5" />&nbsp;{L_DAYS}</td>
		  </tr>
	  </table></td>
	</tr>
	<tr>
		<td class="row1">{L_FORUM_DISPLAY_SORT}</td>
		<td class="row2">
			<select name="forum_display_sort">{S_FORUM_DISPLAY_SORT_LIST}</select>&nbsp;
			<select name="forum_display_order">{S_FORUM_DISPLAY_ORDER_LIST}</select>&nbsp;
		</td>
	</tr>	
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />
