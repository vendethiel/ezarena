<HEAD>
<META http-equiv="refresh" content="120;url={S_PVP_BATTLE}?auto_refresh=1">
</HEAD> 

<form method="post" action="{S_PVP_ACTION}">
<br><br>
<table width="90%" class="forumline" align="center" valign="middle">
	<tr>
		<th align="center" width="100%" valign="middle" colspan="3">
			{NAME} vs {OPPONENT_NAME}
		</th>
	</tr>
	<tr>
		<td class="row1" width ="33%">
			<p align="center">
			<span class="gen"><b>{NAME}</b></span></p>
            </td>
		<td class="row1" width ="33%" rowspan="3">
			<center>
			<DIV style="position:absolute;width:256px;height:96px;z-index:2;">{ATTACK_OVERLAY}</DIV>
			<DIV style="position:relative;width:256px;height:96px;z-index:1;">
				<table cellpadding="0" cellspacing="0" border="0" height="96" width="256"  background="adr/images/battle/backgrounds/{RANDOM_BKG}">
					<tr>
					           <td align="left" valign="bottom" width="128" bordercolor="#000000">
						            <img src="adr/images/battle/characters/{CHALLENGER_CLASS}_{CHALLENGER_ACTION}.gif" border="0" hspace="1">
					          </td>
					           <td align="right" valign="bottom" width="128">
						            <img src="adr/images/battle/characters/p_{OPPONENT_CLASS}_{OPPONENT_ACTION}.gif" border="0" hspace="1">
					           </td>
					</tr>
				</table>
			</DIV>
			</center>
		</td>
		<td class="row1" width ="33%">
			<span class="gen">
			<div align="center">
			<b>{OPPONENT_NAME}</b></div>
			</td>
	</tr>
	<tr>
		<td class="row1" width ="33%" align="center">
			<span class="gen">
			HP: {HP} / {HP_MAX} <br />
				<img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_red_middle.gif" width="{HP_WIDTH}" height="13" ><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" ><br />
			MP: {MP} / {MP_MAX} <br />
				<img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_blue_middle.gif" width="{MP_WIDTH}" height="13" ><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" ></span><p align="center">
			&nbsp;</td>
		<td class="row1" width ="33%" valign="top" align="center">
			<span class="gen">
			HP: {OPPONENT_HP} / {OPPONENT_HP_MAX} <br />
				<img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" ><img src="adr/images/misc/bar_red_middle.gif" width="{OPPONENT_HP_WIDTH}" height="13" ><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" ><br />
			MP: {OPPONENT_MP} / {OPPONENT_MP_MAX} <br />
				<img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" ><img src="adr/images/misc/bar_blue_middle.gif" width="{OPPONENT_MP_WIDTH}" height="13" ><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" ></td>
	</tr>
	<tr>
		<td class="row1" width ="33%">
		<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="forumline">
			<th width="100%" valign="top" colspan="2" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" bordercolor="#C0C0C0">
				<span class="gen">Stats personnage :</span>			
			</th>
              <tr>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Physical Att:</b> {ATT}</span><br />
			<span class="gensmall"><b>Physical Def:</b> {DEF}</span><br />
			<span class="gensmall"><b>Magic Att:</b> {M_ATT}</span><br />
			<span class="gensmall"><b>Magic Def:</b> {M_DEF}</span>
			</td>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Alignment:</b> {ALIGNMENT}</span><br />
			<span class="gensmall"><b>Element:</b> {ELEMENT}</span><br />
			<span class="gensmall"><b>Class:</b> {CHALLENGER_CLASS}</span><br />
			<span class="gensmall"><b>Armour Set:</b> {ARMOUR_SET}</span>
			</td>
              </tr>
            </table>
        </td>
		<td class="row1" width ="33%">
			<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" class="forumline">
			<th width="100%" valign="top" colspan="2" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" bordercolor="#C0C0C0">
				<span class="gen">Stats attaquant :</span>			
			</th>
              <tr>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Physical Att:</b> {OPPONENT_ATT}</span><br />
			<span class="gensmall"><b>Physical Def:</b> {OPPONENT_DEF}</span><br />
			<span class="gensmall"><b>Magic Att:</b> {OPPONENT_M_ATT}</span><br />
			<span class="gensmall"><b>Magic Def:</b> {OPPONENT_M_DEF}</span>
			</td>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Alignment:</b> {OPPONENT_ALIGNMENT}</span><br />
			<span class="gensmall"><b>Element:</b> {OPPONENT_ELEMENT}</span><br />
			<span class="gensmall"><b>Class:</b> {OPPONENT_CLASS}</span><br />
			<span class="gensmall"><b>Armour Set:</b> {OPPONENT_ARMOUR_SET}</span>
			</td>
              </tr>
              </table>
        </td>
	</tr>
	<tr>
		<td class="row1" width="40%" align="center" colspan="3">
			<span class="gen">
				{BATTLE_ACTION}
			</span>
		</td>
	</tr>
<!-- BEGIN pvp -->
	</table>
<br />

<div align="center">
	<table class="forumline" width="90%" colspan="2" align="left">
		<th align="center" width="100%" valign="middle" colspan="3">
			{L_ACTIONS}
		</th>
		<tr>
			<td class="row1" width="50%" align="right">{ATTACK}&nbsp;&nbsp; </td>
			<td class="row1" align="left">&nbsp;&nbsp; <input type="submit" style="width: 125" value="{L_ATTACK}" name="attack" class="mainoption"></td>
		</tr>
		<tr>
			<td class="row2" align="right">{SPELL}&nbsp;&nbsp; </td>
			<td class="row2" align="left">&nbsp;&nbsp; <input type="submit" style="width: 125" value="{L_SPELL}" name="spell" class="mainoption"></td>
		</tr>
		</tr>
			<td align="right" class="row1" width="50%" >{SPELL2}&nbsp;&nbsp;&nbsp;</td>
			<td align="left" class="row1" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 125" value="{L_SPELL2}" onClick="return checksubmit(this)" name="spell2" class="mainoption" /></td>
		</tr>
		<tr>
			<td class="row1" align="right">{POTION}&nbsp;&nbsp; </td>
			<td class="row1" align="left">&nbsp;&nbsp; <input type="submit" style="width: 125" value="{L_POTION}" name="potion" class="mainoption"></td>
		</tr>
		<tr>
			<td class="row2" align="center" colspan="2"><span class="gen"><a href="{S_PVP_ACTION}">{L_BATTLE_REFRESH}</a></span></td>
		</tr>
		<tr>
			<td class="row2" colspan="2" align="center">
			<input type="submit" style="width: 125" value="{L_FLEE}" name="flee1" class="mainoption"></td>
		</tr>
	</table>
</div>
<!-- END pvp -->
<br>
<table width="80%" class="forumline" align="center">
	<tr>
		<th align="center" width="100%" valign="middle">
			{L_COMMS}
		</th>
	</tr>
	<tr>
		<td align="left" class="row1" valign="top" width="100%">
			<span class="genmed">{L_TYPE_HERE}</span>
				<input type="text" value="" name="custom_taunt" length="80"><span class="genmed"> {L_CUSTOM_SENTANCE}</span><br>
					<select name="taunt">
						<option value="">{L_NO_TAUNT}</option>
						<option value="{L_TAUNT_1}">{L_TAUNT_1}</option>
						<option value="{L_TAUNT_2}">{L_TAUNT_2}</option>
						<option value="{L_TAUNT_3}">{L_TAUNT_3}</option>
						<option value="{L_TAUNT_4}">{L_TAUNT_4}</option>
						<option value="{L_TAUNT_5}">{L_TAUNT_5}</option>
						<option value="{L_TAUNT_6}">{L_TAUNT_6}</option>
						<option value="{L_TAUNT_7}">{L_TAUNT_7}</option>
						<option value="{L_TAUNT_8}">{L_TAUNT_8}</option>
						<option value="{L_TAUNT_9}">{L_TAUNT_9}</option>
						<option value="{L_TAUNT_10}">{L_TAUNT_10}</option>
					</select>
				<input type="submit" value="Chat" class="mainoption"><br>
			</span>
		</td>		
	</tr>	
	{LOG}
</table>
</form>
