<SCRIPT LANGUAGE="JavaScript">
<!-- 
function getraceid(race)
{ 
   	this.raceid = document.charform.race.options[document.charform.race.selectedIndex].value;
	window.open('adr_mini_faq.php?mode=race&raceid=' + this.raceid , "FAQ" , 'scrollbars=yes'); 
} 

function getelementid(element) 
{ 
   	this.elementid = document.charform.element.options[document.charform.element.selectedIndex].value; 
	window.open('adr_mini_faq.php?mode=element&elementid=' + this.elementid , 'FAQ' , 'scrollbars=yes'); 
} 
function getalignmentid(alignment) 
{ 
  	this.alignmentid = document.charform.alignment.options[document.charform.alignment.selectedIndex].value; 
	window.open('adr_mini_faq.php?mode=alignment&alignmentid=' + this.alignmentid , 'FAQ' , 'scrollbars=yes'); 
} 

//--> 
</SCRIPT>

<form method="post" name="charform" action="{S_CHARACTER_ACTION}" >

<!-- BEGIN nocharacter -->
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" colspan="2">{L_NEW_CHARACTER}</th>
	</tr>
</table>
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td align="center" class="row2" width="50%"><span class="gen">{L_NEW_CHARACTER_NAME}</span></td>
		<td align="center" class="row1"><input type="post" name="name" size="30" maxlength="40" value="{NAME}"></td>

	</tr>
	<tr>
		<td align="center" class="row2" width="50%"><span class="gen">{L_NEW_CHARACTER_BIOGRAPHY}</span><br /><span class="gensmall">{L_NEW_CHARACTER_BIOGRAPHY_EXPLAIN}</span></td>
		<td align="center" class="row1"><textarea name="bio" rows="5" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" >{BIO}</textarea></td>

	</tr>
</table>
<br clear="all" />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="row1" width="50%" align="center"><span class="gen"><b>{L_CHARACTERISTICS}</b></span><br /><br />
			<table cellspacing="1" cellpadding="1" border="0" align="center"width="100%">
				<tr>
					<td class="row1" width="100%" align="center" ><span class="gensmall">
						{L_POWER} : {POWER} / {MAX}
						<br />{L_AGILITY} : {AGILITY} / {MAX}
						<br />{L_ENDURANCE} : {ENDURANCE} / {MAX}
						<br />{L_INTELLIGENCE} : {INTELLIGENCE} / {MAX}
						<br />{L_WILLPOWER} : {WILLPOWER} / {MAX}
						<br />{L_CHARM} : {CHARM} / {MAX}
					<br /><br /></span></td>
				</tr>
				<tr>
					<input type="hidden" name="power" value="{POWER}" />
					<input type="hidden" name="agility" value="{AGILITY}" />
					<input type="hidden" name="endurance" value="{ENDURANCE}" />
					<input type="hidden" name="intelligence" value="{INTELLIGENCE}" />
					<input type="hidden" name="willpower" value="{WILLPOWER}" />
					<input type="hidden" name="charm" value="{CHARM}" />
					<td class="row1" align="center">{HIDDEN_FIELDS}
					<!-- BEGIN reroll -->
					<input type="submit" value="{L_REROLL}" class="liteoption" />
					<!-- END reroll -->
					</td>
				</tr>
			</table>
		</td>

	  <td class="row2" width="50%" align="center"><span class="gen">
		<table cellspacing="2" cellpadding="2" border="0" align="center" width="100%">
			<tr>
				<td width="50%" align="center"><span class="gen">{L_RACES_SELECT}</span></td>
				<td width="50%" align="center">
					<table>
						<tr>
							<td width="100%" align="center">{RACES_LIST}</td>
						</tr>
						<tr>
							<td width="100%" align="center" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='hand';" onClick="getraceid(document.charform.race);"><span class="gensmall" style="cursor: pointer;">{L_RACES_MINI_FAQ}</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="50%" align="center"><span class="gen">{L_ELEMENTS_SELECT}</span></td>
				<td width="50%" align="center">
					<table>
						<tr>
							<td width="100%" align="center">{ELEMENTS_LIST}</td>
						</tr>
						<tr>
							<td width="100%" align="center" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='hand';" onClick="getelementid(document.charform.element);"><span class="gensmall" style="cursor: pointer;">{L_ELEMENTS_MINI_FAQ}</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="50%" align="center"><span class="gen">{L_ALIGNMENTS_SELECT}</span></td>
				<td width="50%" align="center">
					<table>
						<tr>
							<td width="100%" align="center">{ALIGNMENTS_LIST}</td>
						</tr>
						<tr>
							<td width="100%" align="center" onMouseOver="this.style.backgroundColor='{T_TD_COLOR1}'; this.style.cursor='hand';" onClick="getalignmentid(document.charform.alignment.SelectedIndex);"><span class="gensmall" style="cursor: pointer;">{L_ALIGNMENTS_MINI_FAQ}</span></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	  </span></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<input type="hidden" name="power" value="{POWER}" />
		<input type="hidden" name="agility" value="{AGILITY}" />
		<input type="hidden" name="endurance" value="{ENDURANCE}" />
		<input type="hidden" name="intelligence" value="{INTELLIGENCE}" />
		<input type="hidden" name="willpower" value="{WILLPOWER}" />
		<input type="hidden" name="charm" value="{CHARM}" />
		<td class="row3" align="center" >{HIDDEN_FIELDS}<input type="submit" value="{L_STEP2}" name="Step2" class="liteoption" /></td>
	</tr>
</table>
<!-- END nocharacter -->

<!-- BEGIN nocharacterclass -->
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" colspan="2">{L_NEW_CHARACTER_CLASS}</th>
	</tr>
</table>

<br clear="all" />

<!-- BEGIN classes -->
<table cellspacing="1" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_NEW_CHARACTER_CLASS_DESC}</th>
		<th align="center">{L_NEW_CHARACTER_CLASS_CHOOSE}</th>
	</tr>
	<tr>
		<td width="85%" align="center">

			<table cellspacing="1" cellpadding="2" border="0" align="center" width="100%">
				<tr>
					<td class="row1" width="60%"><span class="gensmall">{L_NAME}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.CLASS_NAME}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_DESC}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.CLASS_DESC}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_IMG}</span></td>
					<td class="row2" align="center"><img src="./adr/images/classes/{nocharacterclass.classes.CLASS_IMG}" alt="{classes.CLASS_NAME}" /></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_BASE_HP}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.BASE_HP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_BASE_MP}</span></td>
					<td class="row2" align="center" ><span class="gensmall">{nocharacterclass.classes.BASE_MP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_BASE_AC}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.BASE_AC}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_HP}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.UPDATE_HP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_MP}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.UPDATE_MP}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_UPDATE_AC}</span></td>
					<td class="row2" align="center"><span class="gensmall">{nocharacterclass.classes.UPDATE_AC}</span></td>
				</tr>
			</table>

		</span></td>
		<td class="row1" align="center"><span class="gen"><input type="radio" name="class" value="{nocharacterclass.classes.CLASS_ID}" ></span></td>
	</tr>

</table>

<br clear="all" />
<!-- END classes -->


<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="row3" align="center"><input type="submit" value="{L_STEP4}" name="Step4" class="liteoption" /></td>
	</tr>
</table>
<!-- END nocharacterclass -->

<!-- BEGIN character_level_up -->
<table cellspacing="2" cellpadding="2" border="2" align="center" class="forumline" width="90%" >
	<tr>
		<td align="center" class="catHead" colspan="2">{L_CHARACTER_LEVEL_UP}</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" border="2" align="center" class="forumline" width="50%" >
	<tr>
		<th align="center" colspan="2">{L_CHARACTER_LEVEL_UP_SELECT}</th>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_POWER}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="1" checked /></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_AGILITY}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="2" /></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_CONSTIT}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="3" /></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_INT}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="4" /></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_WIS}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="5" /></td>
	</tr>
	<tr>
		<td align="center" class="row2"><span class="gensmall">{L_CHA}</span></td>
		<td class="row1" align="center"><input type="radio" name="carac_up" value="6" /></td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" border="2" align="center" class="forumline" width="90%" >
	<tr>
		<td class="catBottom" align="center"><input type="submit" name="level_up" value="{L_LEVEL_UP}" class="liteoption" /></td>
	</tr>
</table>

<br clear="all" />
<!-- END character_level_up -->

<!-- BEGIN character -->
<table cellspacing="0" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" width="100%" colspan="2" >{L_CHARACTER_OF}</th>
	</tr>
	<tr>
		<td align="center" width="30%">

			<table cellspacing="2" cellpadding="0" border="2" align="center" width="100%">
				<tr>
					<td class="row1" align="center" width="60%" colspan="2"><b><span class="gen">{NAME}</span></b>
					<br /><span class="gen"><b>{L_LEVEL}: {LEVEL}; {CHAR_YEAR}</b></span></td>
				</tr>
				<tr>
					<td class="row2" align="center" colspan="2">{AVATAR_IMG}</td>
				</tr>
				<tr>
					<td class="row1" align="center" width="40%"><span class="gen">{L_CLASS}:</td>
					<td class="row2" align="center"><span class="gensmall"><img src="adr/images/classes/{CLASS_IMG}" alt="{CLASS}"><br />{CLASS}</span></td>
				</tr>
				<tr>
					<td class="row1" align="center" width="40%"><span class="gen">{L_RACE}:</td>
					<td class="row2" align="center"><span class="gensmall"><img src="adr/images/races/{RACE_IMG}" alt="{RACE}"><br />{RACE}</span></td>
				</tr>
				<tr>
					<td class="row1" align="center" width="40%"><span class="gen">{L_ELEMENT}:</td>
					<td class="row2" align="center"><span class="gensmall"><img src="adr/images/elements/{ELEMENT_IMG}" alt="{ELEMENT}"><br />{ELEMENT}</span></td>
				</tr>
				<tr>
					<td class="row1" align="center" width="40%"><span class="gen">{L_ALIGNMENT}:</td>
					<td class="row2" align="center"><span class="gensmall"><img src="adr/images/alignments/{ALIGNMENT_IMG}" alt="{ALIGNMENT}"><br />{ALIGNMENT}</span></td>
				</tr>
			</table>

			<!-- BEGIN owner -->
			<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="100%">
				<tr>
					<td align="center" class="row2" ><input type="submit" name="bio_edit" value="{L_EDIT_CHARACTER}" class="liteoption" /></td>
				</tr>
				<!-- BEGIN delete -->
				<tr>
					<td align="center" class="row2" ><input type="submit" name="delete" value="{L_DELETE_CHARACTER}" class="liteoption" /></td>
				</tr>
				<!-- END delete -->
			</table>
			<!-- END owner -->

		</span></td>
		<td width="70%" height="100%" valign="top">
			<table class="subcells" height="100%" cellspacing="4px">
			<tr>
				<th align="center" width="100%" colspan="6" >Stats</th>
			</tr>
			<tr>
					<td align="center" colspan="6" class="row2">
						<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
						<tr>
							<td align="center"><span class="gensmall">Vie: {HP} / {HP_MAX}<br/><br/></td>
						</tr>
						<tr>
							<td align="center">&nbsp;<img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_red_middle.gif" width="{HP_PERCENT_WIDTH}" height="13" border="0" /><img src="adr/images/misc/bar_emp.gif" width="{HP_PERCENT_EMPTY}" height="13" border="0" /><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6" class="row2">
						<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
						<tr>
							<td align="center"><span class="gensmall">Mana: {MP} / {MP_MAX}<br/><br/></td>
						</tr>
						<tr>
							<td align="center">&nbsp;<img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_blue_middle.gif" width="{MP_PERCENT_WIDTH}" height="13" border="0" /><img src="adr/images/misc/bar_emp.gif" width="{MP_PERCENT_EMPTY}" height="13" border="0" /><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6" class="row2">
						<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
						<tr>
							<td align="center"><span class="gensmall">{L_WEIGHT}: {WEIGHT} / {WEIGHT_MAX}<br/><br/></td>
						</tr>
						<tr>
							<td align="center">&nbsp;<img src="adr/images/misc/bar_orange_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_orange_middle.gif" width="{WEIGHT_PERCENT_WIDTH}" height="13" border="0" /><img src="adr/images/misc/bar_emp.gif" width="{WEIGHT_PERCENT_EMPTY}" height="13" border="0" /><img src="adr/images/misc/bar_orange_end.gif" width="6" height="13" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6" class="row2">
						<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
						<tr>
							<td align="center"><span class="gensmall">{L_EXPERIENCE} {EXP} / {EXP_MAX}<br/><br/></td>
						</tr>
						<tr>
							<td align="center">&nbsp;<img src="adr/images/misc/bar_green_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_green_middle.gif" width="{EXP_PERCENT_WIDTH}" height="13" border="0" /><img src="adr/images/misc/bar_emp.gif" width="{EXP_PERCENT_EMPTY}" height="13" border="0" /><img src="adr/images/misc/bar_green_end.gif" width="6" height="13" /></td>
						</tr>
						</table>
					</td>
				</tr>
                <tr>
					<th align="center" width="100%" colspan="6" >Caractéristiques</th>
                </tr>
                <tr>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/au.gif" alt="{L_POINTS}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_POINTS}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{POINTS}</span></td>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/dex.gif" alt="{L_AGILITY}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_AGILITY}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{AGILITY}</span></td>
                </tr>
                <tr>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/sp.gif" alt="{L_SP}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_SP}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{SP}</span></td>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/const.gif" alt="{L_CONSTIT}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_CONSTIT}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{CONSTIT}</span></td>
                </tr>
                <tr>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/sp.gif" alt="{L_FP}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_FP}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{FP}</span></td>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/int.gif" alt="{L_INT}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_INT}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{INT}</span></td>
                </tr>
                <tr>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/ac.gif" alt="{L_AC}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_AC}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{AC}</span></td>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/look.gif" alt="{L_WIS}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_WIS}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{WIS}</span></td>
                </tr>
                <tr>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/str.gif" alt="{L_POWER}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_POWER}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{POWER}</span></td>
                    <td align="center" class="row2" width="5%"><img src="adr/images/misc/cha.gif" alt="{L_CHA}"></td>
                    <td align="center" class="row2" width="35%"><span class="gensmall">{L_CHA}</span></td>
                    <td align="center" class="row2" width="10%"><span class="gensmall">{CHA}</span></td>
                </tr>
                <tr>
					<th align="center" colspan="6">{L_BATTLE_STATISTICS}</th>
				</tr>
				<tr>
					<td align="center" class="row1" width="20%" colspan="2">&nbsp;</td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall"><b>{L_STATS_MONSTER}</b>:</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall"><b>{L_STATS_PVP}</b>:</span></td>
				</tr>
				<tr>
					<td align="center" class="row1" width="20%" colspan="2"><span class="gen">&nbsp;&nbsp;{L_BATTLE_VICTORIES}:</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_VICTORIES}</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_VICTORIES_PVP}</span></td>
				</tr>
				<tr>
					<td align="center" class="row1" width="20%" colspan="2"><span class="gen">&nbsp;&nbsp;{L_BATTLE_DEFEATS}:</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_DEFEATS}</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_DEFEATS_PVP}</span></td>
				</tr>
				<tr>
					<td align="center" class="row1" width="20%" colspan="2"><span class="gen">&nbsp;&nbsp;{L_BATTLE_FLEES}:</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_FLEES}</span></td>
					<td align="center" class="row2" width="20%" colspan="2"><span class="gensmall">{BATTLE_FLEES_PVP}</span></td>
				</tr>
				<tr>
					<td align="center" class="catBottom" colspan="6">
						<input type="submit" name="battle_monsters" value="{L_BATTLE_SEE_MONSTERS}" class="liteoption" />
						&nbsp;&nbsp;
						<input type="submit" name="battle_players" value="{L_BATTLE_SEE_PLAYERS}" class="liteoption" />
					</td>
				</tr>
			</table>
		</span></td>
	</tr>
</table>

<!-- BEGIN limit -->
<br clear="all" />
<table cellspacing="1" cellpadding="1" border="1" align="center" class="forumline" width="90%">
	<tr>
		<th align="center" colspan="2">{L_BATTLE_SKILLS}</th>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_BATTLE_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen">{BATTLE_LIMIT}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_SKILL_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen">{SKILL_LIMIT}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_TRADING_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen">{TRADING_LIMIT}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" width="60%"><span class="gen">{L_THIEF_LIMIT}</span></td>
		<td align="center" class="row2"><span class="gen">{THIEF_LIMIT}</span></td>
	</tr>
	<!--
	   	<tr>
	      	<td align="center" class="row1" width="60%"><span class="gen">{L_QUOTA_TIMER}:</span></td>
	      	<td align="center" class="row2"><span class="gen">{QUOTA_TIMER}</span></td>
	   	</tr>
	-->
	<tr>
		<td align="center" class="catBottom" colspan="2">&nbsp;</td>
	</tr>
</table>
<!-- END limit -->

<!-- BEGIN bio -->
<br clear="all" />
<table cellspacing="0" cellpadding="0" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_BIO}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{BIO}</span></td>
	</tr>
</table>
<!-- END bio -->
<br clear="all" />
<!-- END character -->

</form>


<br />
<br />
<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_TOWNMAPCOPYRIGHT}">{L_TOWNMAPCOPYRIGHT}</a></span></td>
	</tr>
</table>


<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>

<br clear="all" />