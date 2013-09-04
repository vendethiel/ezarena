<form method="post" action="{S_CHARACTER_ACTION}">
<form method="post" action="{S_FORGE_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_TOWNMAP_ENCHANTEMENT}</td>
	</tr>
	<tr>
		<td align="center" class="row1" width="30%" ><span class="gen"><br /><img src="adr/images/TownMap/{SAISON}/Icone_Enchantement.gif " alt="{L_TOWNMAP_ENCHANTEMENT}" /><br /><br />{L_ENCHANTEMENTENTREE}<br /><br /><img src="adr/images/TownMap/Sorcier.gif" /><br /><br />{L_ENCHANTEMENTPRESENTATION} :<br /><br /><input type="submit" name="InfoEnchantement" value="{L_TOWNBOUTONINFO}" class="mainoption" /><br /><br /></span></td>
		<td align="center" width="70%" class="row2" valign="top">
			<span class="gen"><br /><br />{L_ENCHANT_ITEM}:<br /><br /><a href="{U_ENCHANT_ITEM}"><img src="adr/images/TownMap/Enchante.gif " /></a><br /><br /><br /><br />{L_RECHARGE_ITEM}:<br /><br /><a href="{U_RECHARGE_ITEM}"><img src="adr/images/TownMap/Recharge.gif " /></a></span>
		</td>
	</tr>

</table>

<!-- BEGIN recharge -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_RECHARGE_ITEM}</b></span><br /><img src="adr/images/TownMap_Environment/Forge_recharger.jpg "/><br /><span class="genmed">{L_RECHARGE_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_grimoire.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_anneau.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/TownMap_Environment/Forge_enchanter.jpg "/><br /><br /><input type="hidden" name="mode" value="recharge_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END recharge -->

<!-- BEGIN enchant -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
	<tr>
		<td align="center" class="row2" colspan="2"><span class="gen"><b>{L_ENCHANT_ITEM}</b></span><br /><img src="adr/images/TownMap_Environment/Forge_enchanter.jpg "/><br /><span class="genmed">{L_ENCHANT_ITEM_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_TOOL}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_enchanter.gif "/>&nbsp;&nbsp;{TOOL_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_SELECT_ITEMS}</span></td>
		<td align="center" class="row2" ><span class="gen"><img src="adr/images/TownMap_Environment/Forge_anneau.gif "/>&nbsp;&nbsp;{ITEMS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><br /><img src="adr/images/TownMap_Environment/Forge_recharger.jpg "/><br /><br /><input type="hidden" name="mode" value="enchant_action"><input type="submit" value="{L_GO_REPAIR}" class="mainoption" /><br /><br /></td>
	</tr>
</table>
<!-- END enchant -->

</form>
</form>
<br clear="all" />