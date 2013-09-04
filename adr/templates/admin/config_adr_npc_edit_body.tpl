
<form method="post" action="{S_NPC_ACTION}">

<h1>{L_NPC_TITLE}</h1>

<p>{L_NPC_EXPLAIN}</p>

<script language="javascript" type="text/javascript">
<!--
function update_npc(newimage)
{
   document.npc_img.src = "{S_NPC_BASEDIR}/" + newimage;
}
//-->
</script>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_NPC_SETTINGS}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_ENABLE} :</b><br />{L_NPC_ENABLE_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><input type="checkbox" name="npc_enable" value="1" {NPC_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_NAME} :</b><br />{L_NPC_NAME_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><input type="text" name="npc_name" value="{NPC_NAME}" size="50" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_IMG} :</b><br />{L_NPC_IMG_EXPLAIN}</td>
	<!-- BEGIN npc_add -->
		<td class="row1" align="right" width="20%"><select name="npc_img" onchange="update_npc(this.options[selectedIndex].value);"><option value="{NPC_DEF}" selected="selected">{NPC_DEF}</option>{S_FILENAME_OPTIONS}</select>&nbsp;&nbsp;</td>
		<td class="row1" align="left" width="20%"><img name="npc_img" src="{NPC_IMG2}" border="0" alt="" /> &nbsp;</td>
	<!-- END npc_add -->
	<!-- BEGIN npc_edit -->
<!--		<td class="row2" align="center" ><input type="text" name="npc_img" value="{NPC_IMG}" size="50" maxlength="255" /></td> -->
		<td class="row1" align="right" width="20%"><select name="npc_img" onchange="update_npc(this.options[selectedIndex].value);"><option value="{NPC_IMG}" selected="selected">{NPC_IMG}</option>{S_FILENAME_OPTIONS}</select>&nbsp;&nbsp;</td>
		<td class="row1" align="left" width="20%"><img name="npc_img" src="{NPC_DEF}" border="0" alt="" /> &nbsp;</td>
	<!-- END npc_edit -->
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_NPC_ZONE_NAME} :</b><br \>{L_NPC_ZONE_NAME_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{NPC_ZONA}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_USER_LEVEL}</b><br \>{L_NPC_USER_LEVEL_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><span class="gen">{NPC_USER_LEVEL}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_NPC_CLASS}</b><br \>{L_NPC_CLASS_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{NPC_CLASS}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_RACE}</b><br \>{L_NPC_RACE_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><span class="gen">{NPC_RACE}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_NPC_CHARACTER_LEVEL}</b><br \>{L_NPC_CHARACTER_LEVEL_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{NPC_CHARACTER_LEVEL}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_ELEMENT}</b><br \>{L_NPC_ELEMENT_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><span class="gen">{NPC_ELEMENT}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_NPC_ALIGNMENT}</b><br \>{L_NPC_ALIGNMENT_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{NPC_ALIGNMENT}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_VISIT}</b><br \>{L_NPC_VISIT_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><span class="gen">{NPC_VISIT}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%" ><b>{L_NPC_QUEST}</b><br \>{L_NPC_QUEST_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{NPC_QUEST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_QUEST_HIDE} :</b><br />{L_NPC_QUEST_HIDE_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><input type="checkbox" name="npc_quest_hide" value="1" {NPC_QUEST_HIDE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_VIEW} :</b><br />{L_NPC_VIEW_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><input type="checkbox" name="npc_view" value="1" {NPC_VIEW} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_RANDOM} :</b><br />{L_NPC_RANDOM_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><input type="checkbox" name="npc_random" value="1" {NPC_RANDOM} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_RANDOM_CHANCE} :</b><br />{L_NPC_RANDOM_CHANCE_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2">1 / <input type="text" name="npc_random_chance" value="{NPC_RANDOM_CHANCE}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_COST} :</b><br />{L_NPC_COST_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><input type="text" name="npc_price" value="{NPC_COST}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_MESSAGE} :</b><br />{L_NPC_MESSAGE_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><textarea name="npc_message" cols="50" rows="5" class="post">{NPC_MSG}</textarea>
	<!-- BEGIN npc_add -->
        </td>
	<!-- END npc_add -->
	<!-- BEGIN npc_edit -->
 		<br /><span class="gensmall">{NPC_MSG_EXPLAIN}</span></td>
	<!-- END npc_edit -->
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<th align="center" colspan="10" ><u>{L_NPC_QUEST_TITLE}</u></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_QUEST_CLUE} :</b><br />{L_NPC_QUEST_CLUE_EXPLAIN}</td>
		<td class="row1" align="center" colspan="2"><input type="checkbox" name="npc_quest_clue" value="1" {NPC_QUEST_CLUE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_QUEST_CLUE_PRICE} :</b><br />{L_NPC_QUEST_CLUE_PRICE_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><input type="text" name="npc_quest_clue_price" value="{NPC_QUEST_CLUE_PRICE}" size="6" maxlength="6" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_ITEM_NAME}</b><br \>{L_NPC_ITEM_NAME_EXPLAIN}</td>
		<td class="row1" align="center" ><span class="gen">{NPC_ITEM}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_MESSAGE2} :</b><br />{L_NPC_MESSAGE2_EXPLAIN}</td>
		<td class="row2" align="center" ><textarea name="npc_message2" cols="50" rows="5" class="post">{NPC_MSG2}</textarea>
	<!-- BEGIN npc_add -->
        </td>
	<!-- END npc_add -->
	<!-- BEGIN npc_edit -->
		<br /><span class="gensmall">{NPC_MSG2_EXPLAIN}</span></td>
	<!-- END npc_edit -->
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_MESSAGE3} :</b><br />{L_NPC_MESSAGE3_EXPLAIN}</td>
		<td class="row1" align="center" ><textarea name="npc_message3" cols="50" rows="5" class="post">{NPC_MSG3}</textarea>
	<!-- BEGIN npc_add -->
        </td>
	<!-- END npc_add -->
	<!-- BEGIN npc_edit -->
		<br /><span class="gensmall">{NPC_MSG3_EXPLAIN}</span></td>
	<!-- END npc_edit -->
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_POINTS} :</b><br />{L_NPC_POINTS_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="npc_points" value="{NPC_POINTS}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><b>{L_NPC_EXP} :</b><br />{L_NPC_EXP_EXPLAIN}</td>
		<td class="row1" align="center" ><input type="text" name="npc_exp" value="{NPC_EXP}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_SP} :</b><br />{L_NPC_SP_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="npc_sp" value="{NPC_SP}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_ITEM2_NAME}</b><br \>{L_NPC_ITEM2_NAME_EXPLAIN}</td>
		<td class="row1" align="center" ><span class="gen">{NPC_ITEM2}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_TIMES} :</b><br />{L_NPC_TIMES_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="npc_times" value="{NPC_TIMES}" size="4" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%" ><b>{L_NPC_QUEST_MONSTERKILL_NAME}</b><br \>{L_NPC_QUEST_MONSTERKILL_EXPLAIN}</td>
		<td class="row1" align="center" ><span class="gen">{NPC_MONSTER}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><b>{L_NPC_QUEST_MONSTERKILL_AMOUNT} :</b><br />{L_NPC_QUEST_MONSTERAMOUNT_EXPLAIN}</td>
		<td class="row2" align="center" ><input type="text" name="npc_monster_amount" value="{NPC_MONSTER_AMOUNT}" size="4" maxlength="4" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="5" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="3">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>
