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
		<td align="left" class="row2" width="60%" ><span class="gen"><br /><b><u>{L_ZONE_DESCRIPTION} :</u></b> {ZONE_DESCRIPTION}<br /><br /><b><u>{L_ZONE_ELEMENT} :</u></b> {ZONE_ELEMENT}<br /><br />
			<table width="100%" align="center" border="1">
				<tr>
					<th align="center" colspan="10" ><u>{L_ZONE_SEASON} &amp; {L_ZONE_WEATHER}</u></td>
				</tr>
				<tr>
					<td align="center" class="row2" ><span class="gen">{ZONE_SEASON_NAME}<br /><br /><img src="adr/images/zones/seasons/{ZONE_SEASON_IMG}.gif" border="0" ><br /><br /></span></td>
					<td align="center" class="row1" ><span class="gen"><br /><img src="adr/images/zones/weather/rose.gif" border="0" ><br /><br /></span></td>
					<td align="center" class="row2" ><span class="gen">{ZONE_WEATHER_NAME}<br /><br /><img src="adr/images/zones/weather/{ZONE_WEATHER_IMG}.gif" border="0" ><br /><br /></span></td>
				</tr>
			</table>
		</span></td>
	</tr>
</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="14" ><u>{L_ZONE_BUILDINGS}</u></td>
	</tr>
	<tr>
		<td width="12.5%" align="center" class="row2" ><span class="gen"><br /><b>{L_SHOPS_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{SHOPS_IMG}.gif" border="0" title="{L_SHOPS_NAME}" ><br /><br />{SHOPS_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row1" ><span class="gen"><br /><b>{L_TEMPLE_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{TEMPLE_IMG}.gif" border="0" title="{L_TEMPLE_NAME}" ><br /><br />{TEMPLE_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row2" ><span class="gen"><br /><b>{L_FORGE_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{FORGE_IMG}.gif" border="0" title="{L_FORGE_NAME}"><br /><br />{FORGE_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row1" ><span class="gen"><br /><b>{L_MINE_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{MINE_IMG}.gif" border="0" title="{L_MINE_NAME}"><br /><br />{MINE_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row2" ><span class="gen"><br /><b>{L_ENCHANT_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{ENCHANT_IMG}.gif" border="0" title="{L_ENCHANT_NAME}"><br /><br />{ENCHANT_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row1" ><span class="gen"><br /><b>{L_BANK_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{BANK_IMG}.gif" border="0" title="{L_BANK_NAME}"><br /><br />{BANK_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row2" ><span class="gen"><br /><b>{L_PRISON_NAME}</b><br /><br /><img src="adr/images/zones/{ZONE_SEASON}/{PRISON_IMG}.gif" border="0" title="{L_PRISON_NAME}"><br /><br />{PRISON_LINK}<br /><br /></span></td>
		<td width="12.5%" align="center" class="row1" ><span class="gen"><br /><b>Personnage</b><br /><br /><img src="adr/images/zones/character_sheet.gif" border="0" title="{L_PRISON_NAME}"><br /><br /><a href="adr_house.php">Personnage</a><br /><br /></span></td>
	</tr>

</table>
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="4" ><u>{L_ZONE_ACTION}</u></td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="6" >{L_ZONE_GOTO}</td>
			</tr>
			<tr>
				<!-- IF HAS_GOTO_RETURN -->
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_RETURN}</b> : {ZONE_RETURN}
				<!-- IF ZONE_COST_RETURN != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST_RETURN}
				<!-- ENDIF -->
				<br /><br /><input type="submit" name="return" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>
				<!-- ENDIF -->
			</tr>
		</table>
		<!-- IF HAS_GOTO_2 -->
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO2}</b> : {ZONE_GOTO2}
				<!-- IF ZONE_COST2 != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST2}
				<!-- ENDIF -->
				<br /><br /><input type="submit" name="goto2" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<!-- ENDIF -->
		<!-- IF HAS_GOTO_3 -->
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO3}</b> : {ZONE_GOTO3}
				<!-- IF ZONE_COST3 != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST3}
				<!-- ENDIF -->
				<br /><br /><input type="submit" name="goto3" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<!-- ENDIF -->
		<!-- IF HAS_GOTO_4 -->
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO4}</b> : {ZONE_GOTO4}
				<!-- IF ZONE_COST4 != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST4}
				<!-- ENDIF -->
				<br /><br /><input type="submit" name="goto4" value="{L_GOTO}" class="mainoption" /><br /><br /></span></td>	
			</tr>
		</table>
		<!-- ENDIF -->
		</form>
		
		</td>
		<td align="center" class="row1" width="70%" >
		<table width="100%" height="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="4" >{L_ZONE_TOWN}</td>
			</tr>
			<tr>
				<td align="center" class="row1" ><span class="gen"><a href="{U_ZONE_GUILD}"><img title="Guildes" src="adr/images/zones/{ZONE_SEASON}/tile_1.gif" border="0" onMouseOver="stm(Text[0],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_ANIMALERY}"><img title="Animalerie" src="adr/images/zones/{ZONE_SEASON}/tile_2.gif" border="0" onMouseOver="stm(Text[1],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_AUTEL}"><img title="Chaudron" src="adr/images/zones/{ZONE_SEASON}/tile_3.gif" border="0" onMouseOver="stm(Text[2],Style[0])" onMouseOut="htm()" /></a><br /><a href="{U_ZONE_BARRACK}"><img title="Ville" src="adr/images/zones/{ZONE_SEASON}/tile_4.gif" border="0" onMouseOver="stm(Text[3],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_HOUSE}"><img title="Votre maison" src="adr/images/zones/{ZONE_SEASON}/tile_5.gif" border="0" onMouseOver="stm(Text[4],Style[0])" onMouseOut="htm()" /></a><a href="{U_ZONE_LIBRARY}"><img title="Bibliothèque" src="adr/images/zones/{ZONE_SEASON}/tile_6.gif" border="0" onMouseOver="stm(Text[5],Style[0])" onMouseOut="htm()" /></a><br /><a href="{U_ZONE_WORKSHOP}"><img title="Métiers" src="adr/images/zones/{ZONE_SEASON}/tile_7.gif" border="0" onMouseOver="stm(Text[6],Style[0])" onMouseOut="htm()" /></a><img src="adr/images/zones/{ZONE_SEASON}/tile_8.gif" border="0" /><a href="{U_ZONE_TOWER}"><img title="Tour" src="adr/images/zones/{ZONE_SEASON}/tile_9.gif" border="0" onMouseOver="stm(Text[7],Style[0])" onMouseOut="htm()" /></a></span></td>
			</tr>
		</table>
		</td>
		<td align="center" class="row2" width="10%" valign="top"><span class="gen">
		<table width="100%" align="center" border="1" valign="top">
			<tr>
				<th align="center" colspan="4" >{L_ZONE_BATTLE}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen">
				<!-- IF HAS_MONSTERS -->
				<br /><b>{L_BATTLE} :</b><br /><a href="{U_ZONE_BATTLE}"><img src="adr/images/zones/monster_battle.gif " alt="{L_BATTLE}" border="0" /></a><br /><br />
				<!-- ENDIF -->
				<b>{L_PVP_BATTLE} :</b><br /><a href="{U_ZONE_PVP_BATTLE}"><img src="adr/images/zones/pvp_battle.gif " alt="{L_PVP_BATTLE}" border="0" /><br /><br /></a></span></td>
			</tr>
		</table>
		<table width="100%" align="center" border="1">
			<tr>
			<th align="center" colspan="4" >{L_POINTS}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><b>{POINTS}</b><br /><br /></span></td>	
			</tr>
		</table>
 		</span>
		</form>
		</span></td>
	</tr>
</table>

<!-- BEGIN npc_display_enable -->
<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="{NPC_SPAN}" >{L_ZONE_NPC}</td>
	</tr>
	<!-- BEGIN npc -->
	{npc_display_enable.npc.TR_INIT}
		<form method="post" action="{S_ZONES_ACTION}">
			<td class="{npc_display_enable.npc.ROW_CLASS}" width="{NPC_WIDTH}%"><span class="gen">{npc_display_enable.npc.NPC_TITLE}{npc_display_enable.npc.NPC_LINK}{npc_display_enable.npc.NPC_BUTTON}</span></td>
		</form>
	{npc_display_enable.npc.TR_END}
	<!-- END npc -->
	<!-- BEGIN npc_end -->
	    <td class="{npc_display_enable.npc_end.ROW_CLASS}">&nbsp;</td>
	{npc_display_enable.npc_end.TR_END}
	<!-- END npc_end -->
</table>
<!-- END npc_display_enable -->

<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="2" ><u>{L_ZONE_CONNECTED}</u></td>
	</tr>
  	<tr> 
		<td width="100%" class="row1"><span class="gen"><br />{USERS_CONNECTED_LIST}<br /><br /></span></td>
  	</tr>
</table>

<iframe src="{U_SHOUTBOX_BODY}" width="100%" height="300"></iframe>