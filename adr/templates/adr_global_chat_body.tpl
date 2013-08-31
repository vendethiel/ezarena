<script language="JavaScript"><!--
if (parent.location.href == self.location.href)
  window.location.href = 'adr_battle_community.php';
//--></script>

<!-- BEGIN chat_body -->
<form method="post" action="{chat_body.FORM}">
<table width="100%" align="center" border="0">
	<tr>
		<td align="center" valign="top" width="100%" class="row3">
			<span class="genmed">{chat_body.MSG}
				<input type="text" value="" name="msg" size="60" maxsize="250">
				<input type="hidden" value="add" name="mode">
				<input type="submit" value="{chat_body.BUTTON}" class="mainoption">
			</span>
		</td>		
	</tr>
</table>
<br clear="all" /><span class="genmed">{chat_body.ERROR}</span>
<table class="forumline" width="100%" align="center" border="0" style="border:{T_TR_COLOR2} SOLID; border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;"  cellspacing="1" cellpadding="0">
	{chat_body.TXT}
</table>
</form>
<!-- END chat_body -->

<!-- BEGIN archives -->
<table class="forumline" width="100%" align="center" border="0" style="border:{T_TR_COLOR2} SOLID; border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;"  cellspacing="1" cellpadding="0">
	<tr>
		<th align="center" width="100%" valign="middle">
			{archives.MSG}
		</th>
	</tr>
</table>
<!-- END archives -->

<!-- BEGIN add -->
<table class="forumline" width="100%" align="center" border="0" style="border:{T_TR_COLOR2} SOLID; border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;"  cellspacing="1" cellpadding="0">
	<tr>
		<th align="center" width="100%" valign="middle">
			{add.MSG}
		</th>
	</tr>
</table>
<!-- END add -->
