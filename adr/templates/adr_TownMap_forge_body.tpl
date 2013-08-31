<form method="post" action="{S_CHARACTER_ACTION}">
<form method="post" action="{S_FORGE_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_TOWNMAP_FORGE}</td>
	</tr>
	<tr>
		<td align="center" class="row1" width="20%" ><span class="gen"><br /><img src="adr/images/TownMap/{SAISON}/Icone_Forge.gif " alt="{L_TOWNMAP_FORGE}" /><br /><br />{L_FORGEENTREE}<br /><br /><img src="adr/images/TownMap/Forgeron.gif" /><br /><br />{L_FORGEPRESENTATION} :<br /><br /><input type="submit" name="InfoForge" value="{L_TOWNBOUTONINFO}" class="mainoption" /><br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><br />{L_REPAIR_ITEM}:<br /><br /><a href="{U_REPAIR_ITEM}"><img src="adr/images/TownMap/Forge.gif " /></a><br /><br /><br /><br />{L_STONE}:<br /><br /><a href="{U_STONE}"><img src="adr/images/TownMap/Pierre.gif " /></a><br /><br /></span></td>
	</tr>

</table>

<!-- BEGIN repair -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_REPAIR_ITEM}</b></span><br /><img src="adr/images/TownMap_Environment/Forge_reparer.gif "/><br /><span class="genmed">{L_REPAIR_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_objet.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/TownMap_Environment/Forge_forge.gif "/><br /><br /><input type="hidden" name="mode" value="repair_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END repair -->

<!-- BEGIN stone -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_STONE}</b></span><br /><img src="adr/images/TownMap_Environment/Forge_matiere.jpg "/><br /><span class="genmed">{L_STONE_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_outil.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_pierre.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/TownMap_Environment/Forge_tailler.gif "/><br /><br /><input type="hidden" name="mode" value="stone_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END stone -->

</form>
</form>

<br clear="all" />