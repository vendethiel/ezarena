<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_CONFIRM_TITLE}</span></td>
	</tr>
</table>

<form action="{S_PET_ACTION}" method="post">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th colspan="2" class="thHead">{L_PREFERENCES}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_NOTIFY}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="notify" value="1" {RABBITOSHI_PREFERENCES_NOTIFY_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_RABBITOSHI_PREFERENCES_HIDE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="hide" value="1" {RABBITOSHI_PREFERENCES_HIDE_CHECKED} /></td>
	</tr>
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