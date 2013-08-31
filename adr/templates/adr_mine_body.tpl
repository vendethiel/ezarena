<form method="post" action="{S_MINE_ACTION}">

<!-- BEGIN main -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='hand';" onClick="window.location.href='{U_MINING}';"><span class="gen">{L_MINING}</span></td>
	</tr>
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='hand';" onClick="window.location.href='{U_STONE}';"><span class="gen">{L_STONE}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN mining -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_MINING}</b></span><br /><img src="adr/images/store/Forge_mine.gif "/><br /><span class="genmed">{L_MINING_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/store/Forge_creuser.jpg "/><br /><br /><input type="hidden" name="mode" value="mining_action"><input type="submit" value="{L_GO_MINING}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END mining -->

<!-- BEGIN stone -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_STONE}</b></span><br /><img src="adr/images/store/Forge_matiere.jpg "/><br /><span class="genmed">{L_STONE_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_pierre.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/store/Forge_tailler.gif "/><br /><br /><input type="hidden" name="mode" value="stone_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END stone -->

</form>


<br clear="all" />