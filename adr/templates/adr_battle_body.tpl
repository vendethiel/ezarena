
<form method="post" action="{S_CHARACTER_ACTION}"> 

<table cellspacing="0" cellpadding="3" border="0" align="center" class="forumline" width="90%" id="focusme">
	<tr>
		<th align="center" width="100%" valign="middle" colspan="3">
			{NAME} vs {MONSTER_NAME}
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
						            <img src="adr/images/battle/characters/{CLASS}_{USER_ACTION}.gif" border="0" hspace="1">
					          </td>
					           <td align="right" valign="bottom" width="128">
						            <img src="adr/images/battle/monsters/{MONSTER_NAME}_{MONSTER_ACTION}.gif" border="0" hspace="1">
					           </td>
					</tr>
				</table>
			</DIV>
			</center>
		</td>
		<td class="row1" width ="33%">
			<span class="gen">
			<div align="center">
			<b>{MONSTER_NAME}</b></div>
			</td>
	</tr>
	<tr>
		<td class="row1" width ="33%">
			<p align="center">
			<span class="gen">
			Vie: {HP} / {HP_MAX} <br />
				<img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_red_middle.gif" width="{HP_WIDTH}" height="13" ><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" ><br />
			Mana: {MP} / {MP_MAX} <br />
				<img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" /><img src="adr/images/misc/bar_blue_middle.gif" width="{MP_WIDTH}" height="13" ><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" ></span><p align="center">
			&nbsp;</td>
		<td class="row1" width ="33%" valign="top">
			<p align="center">
			<span class="gen">
			Vie: {MONSTER_HP} / {MONSTER_HP_MAX} <br />
				<img src="adr/images/misc/bar_red_begin.gif" width="6" height="13" ><img src="adr/images/misc/bar_red_middle.gif" width="{MONSTER_HP_WIDTH}" height="13" ><img src="adr/images/misc/bar_red_end.gif" width="6" height="13" ><br />
			Mana: {MONSTER_MP} / {MONSTER_MP_MAX} <br />
				<img src="adr/images/misc/bar_blue_begin.gif" width="6" height="13" ><img src="adr/images/misc/bar_blue_middle.gif" width="{MONSTER_MP_WIDTH}" height="13" ><img src="adr/images/misc/bar_blue_end.gif" width="6" height="13" ></td>
	</tr>
	<tr>
		<td class="row1" width ="33%">
		<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="forumline">
			<th width="100%" valign="top" colspan="2" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" bordercolor="#C0C0C0">
				<span class="gen">Stats personnage :</span>			
			</th>
              <tr>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Atk physique:</b> {ATT}</span><br />
			<span class="gensmall"><b>Def physique:</b> {DEF}</span><br />
			<span class="gensmall"><b>Atk magique:</b> {M_ATT}</span><br />
			<span class="gensmall"><b>Def magique:</b> {M_DEF}</span>
			</td>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Alignement:</b> {ALIGNMENT}</span><br />
			<span class="gensmall"><b>&Eacute;lément:</b> {ELEMENT}</span><br />
			<span class="gensmall"><b>Classe:</b> {CLASS}</span><br />
			<span class="gensmall"><b>Panoplie:</b> {ARMOUR_SET}</span>
			</td>
              </tr>
            </table>
        </td>
		<td class="row1" width ="33%">
			<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" class="forumline">
			<th width="100%" valign="top" colspan="2" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" bordercolor="#C0C0C0">
				<span class="gen">Stats monstre :</span>			
			</th>
              <tr>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Atk physique:</b> {MONSTER_ATT}</span><br />
			<span class="gensmall"><b>Def physique:</b> {MONSTER_DEF}</span><br /> 
			<span class="gensmall"><b>Atk magique:</b> {MONSTER_M_ATT}</span><br />
			<span class="gensmall"><b>Def magique:</b> {MONSTER_M_DEF}</span>
			</td>
                <td class="row1" width="50%" valign="top">
			<span class="gensmall"><b>Alignement:</b> {MONSTER_ALIGNMENT}</span><br />
			<span class="gensmall"><b>&Eacute;lément:</b> {MONSTER_ELEMENT}</span><br />
			<span class="gensmall"><b>Niveau:</b> {MONSTER_LEVEL}</span>
			</td>
              </tr>
              </table>
        </td>
	</tr>
</table>
<br clear="all" />

{PET_TABLE}

<br clear="all" /> 
<table cellspacing="0" cellpadding="3" border="1" align="center" class="forumline" width="100%"> 
   <tr> 
      <th align="center" colspan="2" >Journal</th> 
   </tr>
   <tr>
	   <td class="row2">
      	<div class="post" style="text-align:center;width:100%; overflow: scroll; height: 300px;" tabindex="3" >
      	<!-- IF BATTLE_TEXT -->
	  	{BATTLE_TEXT}
	  	<!-- ELSE -->
	  	{L_ADR_FIGHT_STARTS}
	  	<!-- ENDIF -->
      	</div>
      </td> 
   </tr> 

</table> 

<br clear="all" /> 

<table cellspacing="0" cellpadding="3" border="1" align="center" class="forumline" width="100%"> 
   </tr> 
      <th align="center" colspan="2" >{L_ACTIONS}</th> 
   </tr> 
   </tr> 
      <td align="right" class="row2" width="50%" >{ATTACK}&nbsp;&nbsp;&nbsp;</td> 
      <td align="left" class="row2" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 180" value="{L_ATTACK}" name="attack" class="mainoption" /></td> 
   </tr> 
   </tr> 
      <td align="right" class="row1" width="50%" >{SPELL}&nbsp;&nbsp;&nbsp;</td> 
      <td align="left" class="row1" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 180" value="{L_SPELL}" name="spell" class="mainoption" /></td> 
   </tr>
	</tr>
		<td align="right" class="row1" width="50%" >{SPELL2}&nbsp;&nbsp;&nbsp;</td>
		<td align="left" class="row1" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 180" value="{L_SPELL2}" onClick="return checksubmit(this)" name="spell2" class="mainoption" /></td>
	</tr>
   </tr> 
      <td align="right" class="row2" width="50%" >{POTION}&nbsp;&nbsp;&nbsp;</td> 
      <td align="left" class="row2" width="50%" >&nbsp;&nbsp;&nbsp;<input type="submit" style="width: 180" value="{L_POTION}" name="potion" class="mainoption" /></td> 
   </tr> 
   </tr> 
      <td align="center" class="row1" width="100%" colspan="2" ><input type="submit" style="width: 180" value="{L_DEFEND}" name="defend" class="mainoption" /></td> 
   </tr> 
   </tr> 
      <td align="center" class="row2" width="100%" colspan="2" ><input type="submit" style="width: 180" value="{L_FLEE}" name="flee" class="mainoption" /></td> 
   </tr>
	</tr>
		<td align="center" class="row2" width="100%" colspan="2" ><input type="submit" style="width: 180" value="Scanner l'ennemi" name="scan" class="mainoption" /></td>
	</tr> 

</table> 
<br clear="all" />

{INVOC_TABLE}
</form> 

<table width="100%"> 
   <tr> 
      <td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td> 
   </tr> 
</table> 

<script>
document.location.hash = 'focusme';
</script>