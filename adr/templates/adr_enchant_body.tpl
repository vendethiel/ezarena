<form method="post" action="{S_ENCHANT_ACTION}">

<!-- BEGIN main -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='hand';" onClick="window.location.href='{U_RECHARGE_ITEM}';"><span class="gen">{L_RECHARGE_ITEM}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='hand';" onClick="window.location.href='{U_ENCHANT_ITEM}';"><span class="gen">{L_ENCHANT_ITEM}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN recharge -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_RECHARGE_ITEM}</b></span><br /><img src="adr/images/store/Forge_recharger.jpg "/><br /><span class="genmed">{L_RECHARGE_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_grimoire.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_anneau.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/store/Forge_enchanter.jpg "/><br /><br /><input type="hidden" name="mode" value="recharge_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END recharge -->

<!-- BEGIN enchant -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_ENCHANT_ITEM}</b></span><br /><img src="adr/images/store/Forge_enchanter.jpg "/><br /><span class="genmed">{L_ENCHANT_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_enchanter.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_anneau.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/store/Forge_recharger.jpg "/><br /><br /><input type="hidden" name="mode" value="enchant_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END enchant -->

</form>

<br clear="all" />