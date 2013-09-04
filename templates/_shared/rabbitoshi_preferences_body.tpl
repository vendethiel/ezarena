<form action="{S_PET_ACTION}" method="post">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	      <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_CONFIRM_TITLE}</span></td>
	      <td align="right"><span class="nav"><a href="{S_PET_ACTION}" class="nav">{L_RETURN}</a></span></td>
	</tr>
 </table>

<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_PREFERENCES}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_NOTIFY}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="notify" value="1" {RABBITOSHI_PREFERENCES_NOTIFY_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_HIDE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="hide" value="1" {RABBITOSHI_PREFERENCES_HIDE_CHECKED} /></td>
	</tr>
</table>
<br clear="all" />
<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_FEED_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_FEED_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="feed_full" value="1" {RABBITOSHI_PREFERENCES_FEED_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_DRINK_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_DRINK_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="drink_full" value="1" {RABBITOSHI_PREFERENCES_DRINK_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_CLEAN_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_CLEAN_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="clean_full" value="1" {RABBITOSHI_PREFERENCES_CLEAN_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="prefs_exec" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>




