
<form method="post" action="{S_ZONES_ACTION}">

<h1>{L_ZONE_TITLE}</h1>

<p>{L_ZONE_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_SETTINGS}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NAME} :</b><br />{L_ZONE_NAME_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_name" value="{ZONE_NAME}" size="63" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_DESC} :</b><br />{L_ZONE_DESC_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="zone_desc" value="{ZONE_DESC}" size="63" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_IMG} :</b><br />{L_ZONE_IMG_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_img" value="{ZONE_IMG}" size="63" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_ELEMENT} :</b><br \>{L_ZONE_ELEMENT_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_ELEMENT}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_ZONE_ITEM} :</b><br \>{L_ZONE_ITEM_EXPLAIN}</td>
		<td class="row1" align="center" ><span class="gen">{ZONE_ITEM}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_CONFIG}</u></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_RETURN} :</b><br \>{L_ZONE_RETURN_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_RETURN}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_RETURN_COST} :</b><br />{L_ZONE_RETURN_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_costreturn" value="{ZONE_COSTRETURN}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_DESTINATION2} :</b><br \>{L_ZONE_DESTINATION2_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_DESTINATION2}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_DESTINATION2_COST} :</b><br />{L_ZONE_DESTINATION2_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_cost2" value="{ZONE_COSTDESTINATION2}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_DESTINATION3} :</b><br \>{L_ZONE_DESTINATION3_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_DESTINATION3}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_DESTINATION3_COST} :</b><br />{L_ZONE_DESTINATION3_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_cost3" value="{ZONE_COSTDESTINATION3}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_DESTINATION4} :</b><br \>{L_ZONE_DESTINATION4_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_DESTINATION4}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_DESTINATION4_COST} :</b><br />{L_ZONE_DESTINATION4_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_cost4" value="{ZONE_COSTDESTINATION4}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_ZONE_DESTINATION1} :</b><br \>{L_ZONE_DESTINATION1_EXPLAIN}</td>
		<td class="row2" align="center" ><span class="gen">{ZONE_DESTINATION1}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_DESTINATION1_COST} :</b><br />{L_ZONE_DESTINATION1_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_cost1" value="{ZONE_COSTDESTINATION1}" size="10" maxlength="255" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_BUILDINGS}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_TEMPLE} :</b><br />{L_ZONE_TEMPLE_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_temple" value="1" {ZONE_TEMPLE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_SHOPS} :</b><br />{L_ZONE_SHOPS_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_shops" value="1" {ZONE_SHOPS} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_BANK} :</b><br />{L_ZONE_BANK_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_bank" value="1" {ZONE_BANK} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_PRISON} :</b><br />{L_ZONE_PRISON_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_prison" value="1" {ZONE_PRISON} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_FORGE} :</b><br />{L_ZONE_FORGE_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_forge" value="1" {ZONE_FORGE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_MINE} :</b><br />{L_ZONE_MINE_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_mine" value="1" {ZONE_MINE} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_ENCHANT} :</b><br />{L_ZONE_ENCHANT_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_enchant" value="1" {ZONE_ENCHANT} /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_EVENTS}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_CHANCE} :</b><br />{L_ZONE_CHANCE_EXPLAIN}</td>
		<td class="row1" align="center" ><span class="gen">1 / <input type="text" name="zone_chance" value="{ZONE_CHANCE}" size="6" maxlength="255" /></span></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_POINTWIN1} :</b><br />{L_ZONE_POINTWIN1_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="zone_pointwin1" value="{ZONE_POINTWIN1}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_POINTWIN2} :</b><br />{L_ZONE_POINTWIN2_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_pointwin2" value="{ZONE_POINTWIN2}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_POINTLOSS1} :</b><br />{L_ZONE_POINTLOSS1_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="zone_pointloss1" value="{ZONE_POINTLOSS1}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_POINTLOSS2} :</b><br />{L_ZONE_POINTLOSS2_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_pointloss2" value="{ZONE_POINTLOSS2}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_EVENT1} :</b><br />{L_ZONE_EVENT1_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_event1" value="1" {ZONE_EVENT1} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_EVENT2} :</b><br />{L_ZONE_EVENT2_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_event2" value="1" {ZONE_EVENT2} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_EVENT3} :</b><br />{L_ZONE_EVENT3_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_event3" value="1" {ZONE_EVENT3} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_EVENT4} :</b><br />{L_ZONE_EVENT4_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_event4" value="1" {ZONE_EVENT4} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_EVENT5} :</b><br />{L_ZONE_EVENT5_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_event5" value="1" {ZONE_EVENT5} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_EVENT6} :</b><br />{L_ZONE_EVENT6_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_event6" value="1" {ZONE_EVENT6} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_EVENT7} :</b><br />{L_ZONE_EVENT7_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_event7" value="1" {ZONE_EVENT7} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_EVENT8} :</b><br />{L_ZONE_EVENT8_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_event8" value="1" {ZONE_EVENT8} /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_NPC}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC_COST} :</b><br />{L_ZONE_NPC_COST_EXLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="zone_costnpc" value="{ZONE_COSTNPC}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC1} :</b><br />{L_ZONE_NPC1_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_npc1" value="1" {ZONE_NPC1} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC1_MESSAGE} :</b><br />{L_ZONE_NPC1_MESSAGE_EXPLAIN}</td>
		<td class="row2" align="center" ><textarea name="npc1_msg" cols="60" rows="10" class="post">{NPC1_MSG}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC2} :</b><br />{L_ZONE_NPC2_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_npc2" value="1" {ZONE_NPC2} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC2_MESSAGE} :</b><br />{L_ZONE_NPC2_MESSAGE_EXPLAIN}</td>
		<td class="row1" align="center" ><textarea name="npc2_msg" cols="60" rows="10" class="post">{NPC2_MSG}</textarea></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC3} :</b><br />{L_ZONE_NPC3_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_npc3" value="1" {ZONE_NPC3} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC3_MESSAGE} :</b><br />{L_ZONE_NPC3_MESSAGE_EXPLAIN}</td>
		<td class="row2" align="center" ><textarea name="npc3_msg" cols="60" rows="10" class="post">{NPC3_MSG}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC4} :</b><br />{L_ZONE_NPC4_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_npc4" value="1" {ZONE_NPC4} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC4_MESSAGE} :</b><br />{L_ZONE_NPC4_MESSAGE_EXPLAIN}</td>
		<td class="row1" align="center" ><textarea name="npc4_msg" cols="60" rows="10" class="post">{NPC4_MSG}</textarea></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC5} :</b><br />{L_ZONE_NPC5_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="checkbox" name="zone_npc5" value="1" {ZONE_NPC5} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_ZONE_NPC5_MESSAGE} :</b><br />{L_ZONE_NPC5_MESSAGE_EXPLAIN}</td>
		<td class="row2" align="center" ><textarea name="npc5_msg" cols="60" rows="10" class="post">{NPC5_MSG}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC6} :</b><br />{L_ZONE_NPC6_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="checkbox" name="zone_npc6" value="1" {ZONE_NPC6} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_ZONE_NPC6_MESSAGE} :</b><br />{L_ZONE_NPC6_MESSAGE_EXPLAIN}</td>
		<td class="row1" align="center" ><textarea name="npc6_msg" cols="60" rows="10" class="post">{NPC6_MSG}</textarea></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="5" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="3">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>