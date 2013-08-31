<form method="post" action="{S_CHARACTER_ACTION}">
<form method="post" action="{S_FORGE_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_TOWNMAP_MINE}</td>
	</tr>
	<tr>
		<td align="center" class="row2" width="20%" ><span class="gen"><br /><img src="adr/images/TownMap/{SAISON}/Icone_Mine.gif " alt="{L_TOWNMAP_MINE}" /><br /><br />{L_MINEENTREE}<br /><br /><img src="adr/images/TownMap/Mineur.gif" /><br /><br />{L_MINEPRESENTATION} :<br /><br /><input type="submit" name="InfoMine" value="{L_TOWNBOUTONINFO}" class="mainoption" /><br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><img src="adr/images/TownMap/Mine_carte.gif " alt="{L_TOWNMAP_MINE}" /><br />{L_MINING}:<br /><br /><a href="{U_MINING}"><img src="adr/images/TownMap/Mine.gif " /></a><br /><br /></span></td>
	</tr>

</table>

<!-- BEGIN mining -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_MINING}</b></span><br /><img src="adr/images/TownMap_Environment/Forge_mine.gif "/><br /><span class="genmed">{L_MINING_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/TownMap_Environment/Forge_creuser.jpg "/><br /><br /><input type="hidden" name="mode" value="mining_action"><input type="submit" value="{L_GO_MINING}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END mining -->
</form>
</form>

<br clear="all" />