 <!-- BEGIN sell_item -->
<form action="{S_SELL_CONFIRM_ACTION}" method="post">
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<th class="thHead" height="25" valign="middle" colspan="2" ><span class="tableTitle">{MESSAGE_TITLE}</span></th>
	</tr>
	<tr>
		<td class="row1" align="center" colspan="2" ><span class="gen">{MESSAGE_TEXT}</span>
	</tr>
	<tr>
		<td class="row2" align="center">{HIDDEN_FIELDS}<input type="submit" value="{L_YES}" class="mainoption" /></td>
		</form><form action="{S_SELL_CONFIRM_ACTION}" method="post">
		<td class="row2" align="center"><input type="submit" value="{L_NO}" class="liteoption" /></td>
	</tr>
</table>
</form>
<!-- END sell_item -->

 <!-- BEGIN delete_character -->
<form action="{S_CHARACTER_ACTION}" method="post">
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td class="row1" align="center" colspan="2" ><span class="gen">{MESSAGE_TEXT}</span>
	</tr>
	<tr>
		<td class="row2" align="center"><input type="submit" value="{L_YES}" name="delete_confirm" class="mainoption" /></td>
		<td class="row2" align="center"><input type="submit" value="{L_NO}" class="liteoption" /></td>
	</tr>
</table>
</form>
<!-- END delete_character -->
