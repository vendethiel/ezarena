<br /><br />
<form method="post" action="{S_TOWN_ACTION}">
<!-- BEGIN main -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='{U_ALCHEMY}';" onmouseout="this.className='row1rt';"><span class="gen">{L_GO_ALCHEMY}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN alchemy -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >Alchemy</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<b>{L_ALCHEMY}</b><br /><br />
		<br />{L_ALCHEMY_EXPLAIN_AREA}<br /><br />
		<br /><img src="adr/images/items/alchemy/alchemyhelper.gif" alt="alchemy helper" border="0" /><br />
		<br />{L_GO_TO_ALCH}:<br /><br />&nbsp;&nbsp;<a href="adr_character.php"><img src="adr/images/misc/Icon_Char.gif" alt="{L_GO_TO_ALCH}" border="0" /></a><br />
		<br /></span>
		</td>
</form>
<form method="post" action="{S_ALCHEMY_ACTION}">
		<td align="center" class="row1" >		
		<img src="adr/images/items/alchemy/alchemyarea.jpg" alt="alchemy house" border="0" /><hr />
		<br /><span class="gen">{L_SELECT_TOOL}:</span><br /><br />
		<span class="gen"><img src="adr/images/items/alchemy/alchemy.gif" border="0" />&nbsp;&nbsp;{TOOL_LIST}</span>
		<br /><br /<br /><img src="adr/images/skills/skill_alchemy.gif.gif" border="0" /><br /><br /><input type="hidden" name="mode" value="alchemy_action"><input type="submit" value="{L_GO_ALCHEMY}" class="mainoption" /><br />
		</td>
	</tr>
</table>
<!-- END alchemy -->
</form>
<br clear="all" />