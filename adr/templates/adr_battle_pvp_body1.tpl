<form method="post" action="{S_PVP_ACTION}">
<br />
<table cellspacing="0" cellpadding="3" border="1" align="center" class="forumline" width="100%" >
	<tr>
		<td class="row2" align="center" width="40%" valign="top">
			<table width="300">
				<tr>
					<td colspan="3" align="center" valign="top" height="25"><b><span class="gen">{NAME}</span></b></td>
				</tr>
				<tr>
					<td align="center"><span class="gensmall">{L_HP} {HP} / {HP_MAX}</td>
					<td align="center" rowspan="4" colspan="2" height="75%">{AVATAR_IMG}&nbsp;</td>
				</tr>
				<tr>
					<td align="center"><img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_red_middle.gif" width="{HP_WIDTH}" height="13" /><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" /></td>
				</tr>
				<tr>
					<td align="center"><span class="gensmall">{L_MP} {MP} / {MP_MAX}</td>
				</tr>
				<tr>
					<td align="center"><img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_blue_middle.gif" width="{MP_WIDTH}" height="13" /><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" /></td>
				</tr>
				<tr>
					<td align="center" width="225" rowspan="2">&nbsp;</td>
					<td align="left" nowrap><span class="gensmall">
						{L_ATT} :&nbsp; </span></td>
					<td align="left" width="26" nowrap><span class="gensmall">
						{ATT}</span></td>
				</tr>

				<tr>
					<td align="left" nowrap><span class="gensmall">
						{L_DEF} :&nbsp; </span>&nbsp;&nbsp;</td>
					<td align="left" width="26" nowrap><span class="gensmall">
						{DEF}</span></td>
				</tr>

			</table></td>
		<td class="row1" align="center" width="20%"><img src="./adr/images/misc/vs.gif" /></td>
		<td class="row2" align="center" width="40%" valign="top">
			<table width="300">
				<tr>
					<td colspan="3" align="center" height="25" valign="top"><b><span class="gen">{OPPONENT_NAME}</span></b></td>
				</tr>
				<tr>
					<td align="center" rowspan="4" colspan="2" height="75%">{OPPONENT_IMG}</td>
					<td align="center"><span class="gensmall">{L_HP} {OPPONENT_HP} / {OPPONENT_HP_MAX}</td>
				</tr>
				<tr>
					<td align="center"><img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_red_middle.gif" width="{OPPONENT_HP_WIDTH}" height="13" /><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" /></td>
				</tr>
				<tr>
					<td align="center"><span class="gensmall">{L_MP} {OPPONENT_MP} / {OPPONENT_MP_MAX}</td>
				</tr>
				<tr>
					<td align="center"><img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_blue_middle.gif" width="{OPPONENT_MP_WIDTH}" height="13" /><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" /></td>
				</tr>
				<tr>
					<td align="left"><span class="gensmall">{L_ATT}: </span></td>
					<td align="left"><span class="gensmall">
						{OPPONENT_ATT}</span></td>
					<td align="center" rowspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left"><span class="gensmall">
						{L_DEF}:</span></td>
					<td align="left"><span class="gensmall">
						{OPPONENT_DEF}</span></td>
				</tr>

			</table></td>
	</tr>
</table>
<br clear="all" />

<table width="100%">
	</tr>
		<td align="center"><textarea rows="4" cols="10" style="text-align:center;width:100%" tabindex="3" >{BATTLE_TEXT}</textarea></td>
	</tr>

</table>

<br clear="all" />

<table width="100%">
	</tr>
		<th align="center">{L_BATTLE_CHAT}</th>
	</tr>
	</tr>
		<td align="center"><textarea name="battle_text_chat" rows="4" cols="10" style="text-align:center;width:100%" tabindex="3" >{BATTLE_CHAT}</textarea></td>
	</tr>

</table>

<!-- BEGIN pvp -->
<br clear="all" />

<table cellspacing="0" cellpadding="3" border="1" align="center" class="forumline" width="100%">
	</tr>
		<th align="center" colspan="2" >{L_ACTIONS}</th>
	</tr>
	</tr>
		<td align="right" class="row2" width="50%" >{ATTACK}&nbsp;&nbsp;&nbsp;</td>
		<td align="left" class="row2" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 125" value="{L_ATTACK}" name="attack" class="mainoption" /></td>
	</tr>
	</tr>
		<td align="right" class="row1" width="50%" >{SPELL}&nbsp;&nbsp;&nbsp;</td>
		<td align="left" class="row1" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 125" value="{L_SPELL}" name="spell" class="mainoption" /></td>
	</tr>
	</tr>
		<td align="right" class="row2" width="50%" >{POTION}&nbsp;&nbsp;&nbsp;</td>
		<td align="left" class="row2" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 125" value="{L_POTION}" name="potion" class="mainoption" /></td>
	</tr>
	</tr>
		<td align="center" class="row2" width="100%" colspan="2" ><input type="submit" style="width: 125" value="{L_FLEE}" name="flee" class="mainoption" /></td>
	</tr>

</table>
<!-- END pvp -->
</form>

