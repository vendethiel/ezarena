<h1>{L_NPC_TITLE}</h1>

<P>{L_NPC_EXPLAIN}</p>

<form method="post" action="{S_NPC_ACTION}">

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;:&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NPC_ENABLE}</th>
		<th class="thTop">{L_NPC_NAME}</th>
		<th class="thTop">{L_NPC_IMG}</th>
		<th class="thTop">{L_NPC_COST}</th>
		<th class="thTop">{L_NPC_ZONE_NAME}</th>
		<th class="thTop">{L_NPC_QUEST}</th>
		<th class="thTop">{L_NPC_QUEST}</th>
		<th class="thTop">{L_NPC_RANDOM}</th>
		<th colspan="2" class="thCornerR">{L_NPC_ACTION}</th>
	</tr>
	<!-- BEGIN npc -->
	<tr>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_ENABLE}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%" onMouseOver="this.style.backgroundColor=''; this.style.cursor='arrow';" onMouseOut=this.style.backgroundColor='' title='{npc.NPC_USER_LEVEL}' ><span class="gen">{npc.NPC_NAME}</span></td>
		<td class="{npc.ROW_CLASS}" align="center" width="20%"><img src="../adr/images/zones/npc/{npc.NPC_IMG}" alt="{npc.NPC_TITLE}" /></td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_PRICE}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_ZONE}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_QUEST}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_MONSTER}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%">{npc.NPC_RANDOM}</td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%"><a href="{npc.U_NPC_EDIT}">{L_EDIT}</a></td>
		<td class="{npc.ROW_CLASS}" align="center" width="10%"><a href="{npc.U_NPC_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END npc -->
	<tr>
		<td class="catBottom" colspan="10" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_NPC_ADD}" class="mainoption" /></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
   <tr>
      <td><span class="nav">{PAGE_NUMBER}</span></td>
      <td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
   </tr>
</table>
</form>

<br clear="all" />
