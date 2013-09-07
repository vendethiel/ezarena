<br /><br />
<form method="post" action="{S_TOWN_ACTION}">
<!-- BEGIN main -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='{U_LUMBERJACK}';" onmouseout="this.className='row1rt';"><span class="gen">{L_LUMBERJACK}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN lumberjacking -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >Lumberjacking</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<b>{L_LUMBERJACK}</b><br /><br />
		<br />{L_LUMBERJACK_EXPLAIN_AREA}<br /><br />
		<br /><img src="adr/images/items/wood/lumberjacker.gif " alt="lumber helper" border="0" /><br />
		<br />{L_GO_TO_LUMBER}:<br /><br />&nbsp;&nbsp;<a href="adr_character.php"><img src="adr/images/misc/Icon_Char.gif" alt="{L_GO_TO_LUMBER}" border="0" /></a><br />
		<br /></span>
		</td>
</form>
<form method="post" action="{S_LUMBERJACK_ACTION}">
		<td align="center" class="row1" >		
		<img src="adr/images/items/wood/lumberarea.jpg" alt="lumber area" border="0" /><hr />
		<br /><span class="gen">{L_SELECT_TOOL}:</span><br /><br />
		<span class="gen"><img src="adr/images/items/wood/minilumber.gif" border="0" />&nbsp;&nbsp;{TOOL_LIST}</span>
		<br /><br /<br /><img src="adr/images/skills/skill_lumberjack.gif" border="0" /><br /><br /><input type="hidden" name="mode" value="lumberjack_action"><input type="submit" value="{L_GO_LUMBERJACK}" class="mainoption" /><br />
		</td>
	</tr>
</table>
<!-- END lumberjacking -->
</form>
<br clear="all" />