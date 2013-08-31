<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
<SCRIPT language="JavaScript1.2" src="adr/language/lang_{LANG}/lang_adr_buildings.js" type="text/javascript"></SCRIPT>
<form method="post" action="{S_ZONES_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{ZONE_NAME}</td>
	</tr>
	<tr>
		<td align="center" class="row1" width="40%" ><span class="gen"><img src="adr/images/zones/zones_img/{ZONE_IMG}.jpg" border="0" ></span></td>
		<td align="left" class="row2" width="60%" ><span class="gen"><br \><b><u>{L_ZONE_DESCRIPTION} :</u></b> {ZONE_DESCRIPTION}<br /><br /><b><u>{L_ZONE_ELEMENT} :</u></b> {ZONE_ELEMENT}<br /><br />
			<table width="100%" align="center" border="1">
				<tr>
					<th align="center" colspan="10" ><u>{L_ZONE_SEASON} & {L_ZONE_WEATHER}</u></td>
				</tr>
				<tr>
					<td align="center" class="row2" ><span class="gen">{ZONE_SEASON_NAME}<br /><br /><img src="adr/images/zones/seasons/{ZONE_SEASON_IMG}.gif" border="0" ><br /><br /></span></td>
					<td align="center" class="row2" ><span class="gen">{ZONE_WEATHER_NAME}<br /><br /><img src="adr/images/zones/weather/{ZONE_WEATHER_IMG}.gif" border="0" ><br /><br /></span></td>
				</tr>
			</table>
		</span></td>
	</tr>
</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_BUILDINGS}</u></td>
	</tr>
	<tr>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_SHOPS_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{SHOPS_IMG}.gif" border="0" ><br /><br />{SHOPS_LINK}<br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><b>{L_TEMPLE_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{TEMPLE_IMG}.gif" border="0" ><br /><br />{TEMPLE_LINK}<br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_FORGE_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{FORGE_IMG}.gif" border="0" ><br /><br />{FORGE_LINK}<br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><b>{L_BANK_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{BANK_IMG}.gif" border="0" ><br /><br />{BANK_LINK}<br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_PRISON_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{PRISON_IMG}.gif" border="0" ><br /><br />{PRISON_LINK}<br /><br /></span></td>
	</tr>
</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="4" ><u>{L_ZONE_ACTION}</u></td>
	</tr>
	<tr>
		<td align="center" class="row2" width="30%" ><span class="gen">
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="6" >{L_ZONE_GOTO}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_RETURN}</b> : {ZONE_RETURN}<br \><b>{L_ZONE_COST}</b> : {ZONE_COST_RETURN}<br /><input type="submit" name="return" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO2}</b> : {ZONE_GOTO2}<br /><b>{L_ZONE_COST}</b> : {ZONE_COST2}<br /><input type="submit" name="goto2" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO3}</b> : {ZONE_GOTO3}<br /><b>{L_ZONE_COST}</b> : {ZONE_COST3}<br /><input type="submit" name="goto3" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO4}</b> : {ZONE_GOTO4}<br /><b>{L_ZONE_COST}</b> : {ZONE_COST4}<br /><input type="submit" name="goto4" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO1}</b> : {ZONE_GOTO1}<br /><b>{L_ZONE_COST}</b> : {ZONE_COST1}<br /><input type="submit" name="goto1" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
			<th align="center" colspan="4" >{L_POINTS}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><br \><b>{L_POINTS}</b> : {POINTS}<br \><br \></span></td>	
			</tr>
		</table>
 		</span></td>

		<td align="center" class="row1" width="60%" ><span class="gen">
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="4" >{L_ZONE_TOWN}</td>
			</tr>
			<tr>
				<td align="center" class="row1" ><span class="gen"><a href="{U_ZONE_GUILD}"><img src="adr/images/zones/{ZONE_SEASON}/tile_1.jpg" border="0" onMouseOver="stm(Text[0],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_ANIMALERY}"><img src="adr/images/zones/{ZONE_SEASON}/tile_2.jpg" border="0" onMouseOver="stm(Text[1],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_AUTEL}"><img src="adr/images/zones/{ZONE_SEASON}/tile_3.jpg" border="0" onMouseOver="stm(Text[2],Style[0])" onMouseOut="htm()" /></a><br /><a href="{U_ZONE_BARRACK}"><img src="adr/images/zones/{ZONE_SEASON}/tile_4.jpg" border="0" onMouseOver="stm(Text[3],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_HOUSE}"><img src="adr/images/zones/{ZONE_SEASON}/tile_5.jpg" border="0" onMouseOver="stm(Text[4],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_LIBRARY}"><img src="adr/images/zones/{ZONE_SEASON}/tile_6.jpg" border="0" onMouseOver="stm(Text[5],Style[0])" onMouseOut="htm()" /></a><br /><a href="{U_ZONE_WORKSHOP}"><img src="adr/images/zones/{ZONE_SEASON}/tile_7.jpg" border="0" onMouseOver="stm(Text[6],Style[0])" onMouseOut="htm()" /></a><img src="adr/images/zones/{ZONE_SEASON}/tile_8.jpg" border="0" /><a href="{U_ZONE_TOWER}"><img src="adr/images/zones/{ZONE_SEASON}/tile_9.jpg" border="0" onMouseOver="stm(Text[7],Style[0])" onMouseOut="htm()" /></a></span></td>
			</tr>
		</table>
		</span></td>

		<td align="center" class="row2" width="10%" ><span class="gen">
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="4" >{L_ZONE_BATTLE}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_BATTLE} :</b><br /><a href="{U_ZONE_BATTLE}"><img src="adr/images/zones/monster_battle.gif " alt="{L_BATTLE}" border="0" /></a><br /><br /><b>{L_PVP_BATTLE} :</b><br /><a href="{U_ZONE_PVP_BATTLE}"><img src="adr/images/zones/pvp_battle.gif " alt="{L_PVP_BATTLE}" border="0" /></a><br /><br /></span></td>
			</tr>
		</table>
		</form>
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="4" >{L_ZONE_SHOUTBOX}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen">
				<div class="miniform">
					<form method="post">
						Pseudo : <br \><input name="pseudo" size="19"><br /><br \>Message :<br \>
						<textarea name="mess" cols="20" rows="3"></textarea><br /><br />
						<input name="submit" type="submit" value="GO"> <input name="submit" type="submit" value="REFRESH"><br /><br />
					</form>
				</div></span></td>
			</tr>
		</table>
		</span></td>
	</tr>
</table>
<br clear="all" />
<form method="post" action="{S_ZONES_ACTION}">
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="12" ><u>{L_ZONE_NPC}</u></td>
	</tr>
	<tr>
		<td align="center" class="row2" colspan ="6" ><span class="gen"><br />{ZONE_NPC_PRICE}<br /><br /></span></td>
	</tr>
	<tr>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_NPC1_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC1_IMG}.gif" border="0" ><br /><br />{NPC1_LINK}<br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><b>{L_NPC2_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC2_IMG}.gif" border="0" ><br /><br />{NPC2_LINK}<br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_NPC3_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC3_IMG}.gif" border="0" ><br /><br />{NPC3_LINK}<br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><b>{L_NPC4_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC4_IMG}.gif" border="0" ><br /><br />{NPC4_LINK}<br /><br /></span></td>
		<td align="center" class="row2" ><span class="gen"><br /><b>{L_NPC5_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC5_IMG}.gif" border="0" ><br /><br />{NPC5_LINK}<br /><br /></span></td>
		<td align="center" class="row1" ><span class="gen"><br /><b>{L_NPC6_NAME}</b><br /><br /><img src="adr/images/zones/npc/{NPC6_IMG}.gif" border="0" ><br /><br />{NPC6_LINK}<br /><br /></span></td>
	</tr>
</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="2" ><u>{L_ZONE_CONNECTED}</u></td>
	</tr>
  	<tr> 
		<td width="100%" class="row1"><span class="gen"><br \>{USERS_CONNECTED_LIST}<br \><br \></span></td>
  	</tr>
</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="2" ><u>CHAT</u></td>
	</tr>
</table>
</form>