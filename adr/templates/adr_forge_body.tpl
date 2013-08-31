<form method="post" action="{S_FORGE_ACTION}">

<!-- BEGIN main -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onClick="window.location.href='{U_REPAIR_ITEM}';"><span class="gen">{L_REPAIR_ITEM}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN repair -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_REPAIR_ITEM}</b></span><br /><img src="adr/images/store/Forge_reparer.gif "/><br /><span class="genmed">{L_REPAIR_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/store/Forge_objet.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/store/Forge_forge.gif "/><br /><br /><input type="hidden" name="mode" value="repair_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END repair -->

</form>


<br clear="all" />