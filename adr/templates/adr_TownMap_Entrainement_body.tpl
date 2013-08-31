<form method="post" action="{S_CHARACTER_ACTION}">
<form method="post" action="{S_TOWN_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_TOWNMAP_ENTRAINEMENT}</td>
	</tr>
	<tr>
		<td align="center" class="row1" width="20%" ><span class="gen"><br /><img src="adr/images/TownMap/{SAISON}/Icone_Entrainement.gif " alt="{L_TOWNMAP_ENTRAINEMENT}" /><br /><br />{L_ENTRAINEMENTENTREE}<br /><br /><img src="adr/images/TownMap/Soldat.gif" /><br /><br />{L_ENTRAINEMENTPRESENTATION} :<br /><br /><input type="submit" name="InfoEntrainement" value="{L_TOWNBOUTONINFO}" class="mainoption" /><br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br />{L_TOWN_TRAINING_SKILL}:<br /><br /><a href="{U_TOWN_TRAINING_SKILL}"><img src="adr/images/TownMap/EntrainerCompetence.gif " /></a><br /><br />{L_TOWN_TRAINING_CHARAC}:<br /><br /><a href="{U_TOWN_TRAINING_CHARAC}"><img src="adr/images/TownMap/EntrainerCaracteristique.gif " /></a><br /><br />{L_TOWN_TRAINING_UPGRADE}:<br /><br /><a href="{U_TOWN_TRAINING_UPGRADE}"><img src="adr/images/TownMap/PromotionClasse.gif " /></a><br /><br />{L_TOWN_TRAINING_CHANGE}:<br /><br /><a href="{U_TOWN_TRAINING_CHANGE}"><img src="adr/images/TownMap/ChangerClasse.gif " /></a><br /><br />{L_CHALLENGE}:<br /><br /><a href="{U_CHALLENGE}"><img src="adr/images/TownMap/Challenge.gif " /></a><br /><br /></span></td>
	</tr>

</table>

<!-- BEGIN training -->

<!-- BEGIN train_class -->
</form><form method="post" action="{S_TOWN_ACTION}">
<br />
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_SELECT_UPGRADE}</th>
	</tr>
	<tr>
		<td align="center" class="catHead">{L_SELECT_UPGRADE_COST}</td>
	</tr>
</table>
<br clear="all" />
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_NEW_CHARACTER_CLASS_DESC}</th>
		<th align="center">{L_NEW_CHARACTER_CLASS_CHOOSE}</th>
	</tr>
	<!-- BEGIN classes -->
	<tr>
		<td width="85%" align="center">
			<table cellspacing="1" cellpadding="2" border="0" align="center" width="100%">
				<tr>
					<td class="row1" width="60%"><span class="gensmall">{L_NAME}</span></td>
					<td class="row2" align="center"><span class="gensmall">{training.train_class.classes.CLASS_NAME}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_DESC}</span></td>
					<td class="row2" align="center"><span class="gensmall">{training.train_class.classes.CLASS_DESC}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_IMG}</span></td>
					<td class="row2" align="center"><img src="./adr/images/classes/{training.train_class.classes.CLASS_IMG}" alt="{classes.CLASS_NAME}" /></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_HP}</span></td>
					<td class="row2" align="center"><span class="gensmall">{training.train_class.classes.UPDATE_HP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_MP}</span></td>
					<td class="row2" align="center"><span class="gensmall">{training.train_class.classes.UPDATE_MP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_AC}</span></td>
					<td class="row2" align="center"><span class="gensmall">{training.train_class.classes.UPDATE_AC}</span></td>
				</tr>
			</table>

		</span></td>
		<td class="row1" align="center"><span class="gen"><input type="radio" name="new_class" value="{training.train_class.classes.CLASS_ID}" ></span></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" height="3" >&nbsp;</td>
	</tr>
	<!-- END classes -->
</table>
<br clear="all" />
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td align="center" class="catBottom">
			<input type="hidden" name="mode" value="training" />
			<input type="hidden" name="sub_mode" value="{S_HIDDEN}" />
			<input type="submit" value="{L_SELECT_UPGRADE_ACTION}" class="mainoption" />
		</td>
	</tr>
</table>
<br clear="all" />
</form><form method="post" action="{S_TOWN_ACTION}">
<!-- END train_class -->

<!-- BEGIN train_skill -->
<br />
<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="100%" height="100%">
	<tr>
		<th align="center" colspan="5">{L_SKILLS}</th>
	</tr>
	<tr height="25">
		<td class="row2" align="center"><span class="gen"><b>{L_NAME}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_LEVEL}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_COST}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_SELECT}</b></span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_MINING}</span></td>
		<td class="row1" align="center"><span class="gen">{MINING}</span></td>
		<td class="row1" align="center"><span class="gen">{MINING_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_skill" value="1">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_STONE}</span></td>
		<td class="row2" align="center"><span class="gen">{STONE}</span></td>
		<td class="row2" align="center"><span class="gen">{STONE_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_skill" value="2">
		</td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_FORGE}</span></td>
		<td class="row1" align="center"><span class="gen">{FORGE}</span></td>
		<td class="row1" align="center"><span class="gen">{FORGE_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_skill" value="3">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_ENCHANTMENT}</span></td>
		<td class="row2" align="center"><span class="gen">{ENCHANTMENT}</span></td>
		<td class="row2" align="center"><span class="gen">{ENCHANTMENT_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_skill" value="4">
		</td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_TRADING}</span></td>
		<td class="row1" align="center"><span class="gen">{TRADING}</span></td>
		<td class="row1" align="center"><span class="gen">{TRADING_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_skill" value="5">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_THIEF}</span></td>
		<td class="row2" align="center"><span class="gen">{THIEF}</span></td>
		<td class="row2" align="center"><span class="gen">{THIEF_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_skill" value="6">
		</td>
	</tr>
</table>
<br clear="all" />
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td align="center" class="catBottom">
			<input type="hidden" name="mode" value="training" />
			<input type="hidden" name="sub_mode" value="train_skill_action" />
			<input type="submit" value="{L_SKILLS_ACTION}" class="mainoption" />
		</td>
	</tr>
</table>
</form><form method="post" action="{S_TOWN_ACTION}">
<!-- END train_skill -->

<!-- BEGIN train_charac -->
<br />
<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="100%" height="100%">
	<tr>
		<th align="center" colspan="5">{L_SKILLS}</th>
	</tr>
	<tr height="25">
		<td class="row2" align="center"><span class="gen"><b>{L_NAME}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_LEVEL}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_COST}</b></span></td>
		<td class="row2" align="center"><span class="gen"><b>{L_SELECT}</b></span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_MINING}</span></td>
		<td class="row1" align="center"><span class="gen">{MINING}</span></td>
		<td class="row1" align="center"><span class="gen">{MINING_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_charac" value="1">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_STONE}</span></td>
		<td class="row2" align="center"><span class="gen">{STONE}</span></td>
		<td class="row2" align="center"><span class="gen">{STONE_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_charac" value="2">
		</td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_FORGE}</span></td>
		<td class="row1" align="center"><span class="gen">{FORGE}</span></td>
		<td class="row1" align="center"><span class="gen">{FORGE_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_charac" value="3">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_ENCHANTMENT}</span></td>
		<td class="row2" align="center"><span class="gen">{ENCHANTMENT}</span></td>
		<td class="row2" align="center"><span class="gen">{ENCHANTMENT_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_charac" value="4">
		</td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gensmall">{L_TRADING}</span></td>
		<td class="row1" align="center"><span class="gen">{TRADING}</span></td>
		<td class="row1" align="center"><span class="gen">{TRADING_COST}</span></td>
		<td class="row1" align="center">
			<input type="radio" name="training_charac" value="5">
		</td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_THIEF}</span></td>
		<td class="row2" align="center"><span class="gen">{THIEF}</span></td>
		<td class="row2" align="center"><span class="gen">{THIEF_COST}</span></td>
		<td class="row2" align="center">
			<input type="radio" name="training_charac" value="6">
		</td>
	</tr>
</table>
<br clear="all" />
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td align="center" class="catBottom">
			<input type="hidden" name="mode" value="training" />
			<input type="hidden" name="sub_mode" value="train_charac_action" />
			<input type="submit" value="{L_SKILLS_ACTION}" class="mainoption" />
		</td>
	</tr>
</table>
</form>
<form method="post" action="{S_TOWN_ACTION}">
<!-- END train_charac -->
<br clear="all" />

<!-- END training -->

</form>
</form>
<br clear="all" />