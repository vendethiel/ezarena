<script src="{ROOT_STYLE}adr/language/lang_{LANG}/lang_adr_buildings.js"></script>
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>

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
					<td align="center" class="row2" valign="top" ><span class="gen">{ZONE_SEASON_NAME}<br /><br /><img src="adr/images/zones/seasons/{ZONE_SEASON_IMG}.gif" border="0" ><br /><br /></span></td>
					<td align="center" class="row2" valign="top" ><span class="gen">{ZONE_WEATHER_NAME}<br /><br /><img src="adr/images/zones/weather/{ZONE_WEATHER_IMG}.gif" border="0" ><br /><br /></span></td>
				</tr>
			</table>
		</span></td>
	</tr>
</table>

<br clear="all" />
<!-- BEGIN switch_Adr_zone_building_picture_link_enable -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="10" ><u>{L_ZONE_BUILDINGS}</u></td>
	</tr>
	<tr>
		<td align="center" class="row2" ><span class="gen">{SHOPS_LINK}<img src="adr/images/zones/{ZONE_SEASON}/{SHOPS_IMG}.gif" border="0" onMouseOver="stm(Text[26],Style[0])" onMouseOut="htm()" /></a></span></td>
		<td align="center" class="row1" ><span class="gen">{TEMPLE_LINK}<img src="adr/images/zones/{ZONE_SEASON}/{TEMPLE_IMG}.gif" border="0" onMouseOver="stm(Text[24],Style[0])" onMouseOut="htm()" /></a></span></td>
		<td align="center" class="row2" ><span class="gen">{FORGE_LINK}<img src="adr/images/zones/{ZONE_SEASON}/{FORGE_IMG}.gif" border="0" onMouseOver="stm(Text[20],Style[0])" onMouseOut="htm()" /></a></span></td>
		<td align="center" class="row1" ><span class="gen">{BANK_LINK}<img src="adr/images/zones/{ZONE_SEASON}/{BANK_IMG}.gif" border="0" onMouseOver="stm(Text[18],Style[0])" onMouseOut="htm()" /></a></span></td>
		<td align="center" class="row2" ><span class="gen">{PRISON_LINK}<img src="adr/images/zones/{ZONE_SEASON}/{PRISON_IMG}.gif" border="0" onMouseOver="stm(Text[14],Style[0])" onMouseOut="htm()" /></a></span></td>
	</tr>
</table>
<!-- END switch_Adr_zone_building_picture_link_enable -->
<!-- BEGIN switch_Adr_zone_building_no_picture_link_enable -->
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
<!-- END switch_Adr_zone_building_no_picture_link_enable -->

<br clear="all" />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="4" ><u>{L_ZONE_ACTION}</u></td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<form method="post" action="{S_ZONES_ACTION}">
		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="6" >{L_ZONE_GOTO}</td>
			</tr>
			<!-- IF HAS_GOTO_RETURN -->
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_RETURN}</b> : {ZONE_RETURN}
				<!-- IF ZONE_COST_RETURN != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST_RETURN}
				<!-- ENDIF -->
				<br />
				<!-- IF ZONE_LEVEL_RETURN > CHARACTER_LEVEL -->
				<b>{L_REQ_LEVEL}</b> {ZONE_LEVEL_RETURN}
				<!-- ELSE -->
				<br /><input type="submit" name="return" value="{L_GOTO}" class="mainoption" />
				<!-- ENDIF -->
				<br /><br /></span></td>
			</tr>
			<!-- ENDIF -->
		</table>
		<!-- IF HAS_GOTO_2 -->
		<table width="100%" align="center" border="1">
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{L_ZONE_GOTO2}</b> : {ZONE_GOTO2}
				<!-- IF ZONE_COST2 != 0 -->
				<br /><b>{L_ZONE_COST}</b> : {ZONE_COST2}
				<!-- ENDIF -->
				<br />
				<!-- IF ZONE_LEVEL2 > CHARACTER_LEVEL -->
				<b>{L_REQ_LEVEL}</b> {ZONE_LEVEL2}
				<!-- ELSE -->
				<br /><input type="submit" name="goto2" value="{L_GOTO}" class="mainoption" />
				<!-- ENDIF -->
				<br /><br /></span></td>
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
				<br />
				<!-- IF ZONE_LEVEL3 > CHARACTER_LEVEL -->
				<b>{L_REQ_LEVEL}</b> {ZONE_LEVEL3}
				<!-- ELSE -->
				<br /><input type="submit" name="goto3" value="{L_GOTO}" class="mainoption" />
				<!-- ENDIF -->
				<br /><br /></span></td>
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
				<br />
				<!-- IF ZONE_LEVEL4 > CHARACTER_LEVEL -->
				<b>{L_REQ_LEVEL}</b> {ZONE_LEVEL4}<br/>
				<!-- ELSE -->
				<br /><input type="submit" name="goto4" value="{L_GOTO}" class="mainoption" />
				<!-- ENDIF -->
				<br /><br /></span></td>
			</tr>
		</table>
		<!-- ENDIF -->
		<br clear="all" />

		<table width="100%" align="center" border="1">
			<tr>
			<th align="center" colspan="4">{L_POINTS}</td>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><b>{POINTS}</b><br /><br /></span></td>	
			</tr>
		</table>
		<br clear="all" />

		<table width="100%" align="center" border="1">
			<tr>
				<th align="center" colspan="4" >Cartographie</th>
			</tr>
			<tr>
				<td align="center" class="row2" ><span class="gen"><br /><b>{MAP_NAME}</b><br /><br /><a href="adr_maps.php"><img src="adr/images/zones/townmap/World_small.gif" border="0" onMouseOver="stm(Text[100],Style[0])" onMouseOut="htm()" /><br /><br /></a></span></td>
			</tr>
		</table>

		</form>
		</td>
	    <td align="center" valign="top" class="row1">
	    	<!-- V: Well, this is a pain to integrate with my own stuff, but I did it anyway :( -->
			<!-- BEGIN switch_Adr_zone_townmap_disable -->
			<!-- some settings are done because Carte4 (winter) sucks :( -->
			<style>
			.tile_Carte4_Haut {
				width: 818px;
			}
			.tile_Carte4_27 {
				width: 129px !important;
			}
			.tile_Carte4_35 {
				width: 133px;
				height: 121px;
			}
			.tile_Carte4_Milieu {
				width: 818px;
			}
			.tile_Carte4_Bas {
				width: 818px;
			}
			.tile_Carte4_39 {
				width: 63px;
				height: 121px;
			}
			</style>
        	<img src="adr/images/TownMap/{SAISON}/Tuile_Haut.gif" class="tile_{SAISON}_Haut" /><br />

        	<img src="adr/images/TownMap/{SAISON}/Tuile_1_1.gif" style="height: 103px;" /><!-- IF HAS_PRISON --><a href="{U_TOWNMAP_PRISON}"><img src="adr/images/TownMap/{SAISON}/Tuile_1_2.gif" border="0" alt="{L_TOWNMAP_PRISON}" title="Prison" /></a><!-- ELSE --><img class="greyed" src="adr/images/TownMap/{SAISON}/Tuile_empty_downwalled.png" style="width: 84px; height: 103px" title="Prison ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_1_3.gif" style="height: 103px; max-width: 242px;" /><!-- IF HAS_BANK --><a href="{U_TOWNMAP_BANQUE}"><img src="adr/images/TownMap/{SAISON}/Tuile_1_4.gif" border="0" alt="{L_TOWNMAP_BANQUE}" title="Banque" /></a><!-- ELSE --><img src="adr/images/TownMap/{SAISON}/Tuile_empty.png" style="width: 107px; height: 103px" border="0" alt="{L_TOWNMAP_BANQUE}" title="Banque ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_1_5.gif" style="height: 103px;" /><!-- IF HAS_MINE --><a href="{U_TOWNMAP_MINE}"><img src="adr/images/TownMap/{SAISON}/Tuile_1_6.gif" border="0" alt="{L_TOWNMAP_MINE}" title="Mine" /></a><!-- ELSE --><img class="greyed" src="adr/images/TownMap/{SAISON}/Tuile_empty.png" style="width: 92px; height: 103px" border="0" title="Mine ({L_BUILDING_UNAV})" alt="{L_TOWNMAP_MINE}" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_1_7.gif" style="height: 103px;" /><br />

        	<img src="adr/images/TownMap/{SAISON}/Tuile_Milieu.gif" class="tile_{SAISON}_milieu" /><br />

        	<img src="adr/images/TownMap/{SAISON}/Tuile_2_1.gif" style="height: 89px;" /><!-- IF HAS_ENCHANT --><a href="{U_TOWNMAP_ENCHANTEMENT}"><img src="adr/images/TownMap/{SAISON}/Tuile_2_2.gif" border="0" alt="{L_TOWNMAP_ENCHANTEMENT}" title="Pierre Runique" /></a><!-- ELSE --><img src="adr/images/TownMap/{SAISON}/Tuile_empty.png" style="width: 55px; height: 89px;" border="0" alt="{L_TOWNMAP_ENCHANTEMENT}" title="Pierre Runique ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_2_3.gif" style="height: 89px;" /><!-- IF HAS_TEMPLE --><a href="{U_TOWNMAP_TEMPLE}"><img title="Temple" src="adr/images/TownMap/{SAISON}/Tuile_2_4.gif" border="0" alt="{L_TOWNMAP_TEMPLE}" /></a><!-- ELSE --><img src="adr/images/TownMap/{SAISON}/Tuile_empty.png" style="width: 87px; height: 89px;" border="0" title="Temple ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_2_5.gif" style="height: 89px;" /><!-- IF HAS_SHOPS --><a href="{U_TOWNMAP_BOUTIQUE}"><img src="adr/images/TownMap/{SAISON}/Tuile_2_6.gif" border="0" title="Magasins" alt="{L_TOWNMAP_BOUTIQUE}" /></a><!-- ELSE --><img src="adr/images/TownMap/{SAISON}/Tuile_empty.png" style="width: 89px; height: 89px;" border="0" title="Magasins ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_2_7.gif" class="tile_{SAISON}_27" style="height: 89px;" /><a href="{U_TOWNMAP_MAISON}"><img title="Maison" src="adr/images/TownMap/{SAISON}/Tuile_2_8.gif" style="height: 89px;" border="0" alt="{L_TOWNMAP_MAISON}" /></a><img src="adr/images/TownMap/{SAISON}/Tuile_2_9.gif" style="height: 89px;" /><br />

        	<img src="adr/images/TownMap/{SAISON}/Tuile_Bas.gif" class="tile_{SAISON}_Bas" /><br />

        	<img src="adr/images/TownMap/{SAISON}/Tuile_3_1.gif"/><!-- IF HAS_FORGE --><a href="{U_TOWNMAP_FORGE}"><img src="adr/images/TownMap/{SAISON}/Tuile_3_2.gif" border="0" alt="{L_TOWNMAP_FORGE}" title="Forge" /></a><!-- ELSE --><img src="adr/images/TownMap/{SAISON}/Tuile_forge_empty.gif" border="0" alt="{L_TOWNMAP_FORGE}" title="Forge ({L_BUILDING_UNAV})" /><!-- ENDIF --><img src="adr/images/TownMap/{SAISON}/Tuile_3_3.gif"/><a href="{U_SHAME}"><img title="Tour de garde" src="adr/images/TownMap/{SAISON}/Tuile_3_4.gif" border="0" alt="{L_TOWNMAP_ENTRAINEMENT}" /></a><img src="adr/images/TownMap/{SAISON}/Tuile_3_5.gif" class="tile_{SAISON}_35" border="0" alt="{L_TOWNMAP_COMBAT}" /><!--<a href="{U_TOWNMAP_ENTREPOT}"><img title="Entrepôt" src="adr/images/TownMap/{SAISON}/Tuile_3_6.gif" border="0" alt="{L_TOWNMAP_ENTREPOT}" /></a>--><a href="{U_ZONE_BARRACK}"><img title="Tour" src="adr/images/TownMap/{SAISON}/Tuile_3_6.gif" border="0" /></a><img src="adr/images/TownMap/{SAISON}/Tuile_3_7.gif" /><a href="{U_TOWNMAP_CLAN}"><img title="Taverne des guildes" src="adr/images/TownMap/{SAISON}/Tuile_3_8.gif" border="0" alt="{L_TOWNMAP_CLAN}" /></a><img src="adr/images/TownMap/{SAISON}/Tuile_3_9.gif" class="tile_{SAISON}_39" /><br />
        	<!-- IF HAS_MONSTERS -->
        	<a href="{U_TOWNMAP_COMBAT}"><img src="adr/images/TownMap/{SAISON}/Tuile_Monstre.gif" border="0" alt="{L_TOWNMAP_MONSTRE}" /></a>
        	<!-- ENDIF -->
        	<!-- END switch_Adr_zone_townmap_disable -->
			<!-- BEGIN switch_Adr_zone_townmap_enable -->
			<!-- V: let's restore the old layout layout -->
			<table width="100%" height="100%" align="center" border="1">
				<tr>
					<th align="center" colspan="4" >{L_ZONE_TOWN}</td>
				</tr>
				{SHOWMAP}
			</table>
			<!-- END switch_Adr_zone_townmap_enable -->
        </td>
        <!-- BEGIN switch_Adr_zone_townmap_disable -->
		<td align="center" class="row2" width="20%" valign="top"><span class="gen">
			<form method="post" action="{S_CHARACTER_ACTION}">
			<table><tr>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Prison.gif" /><br /><input type="submit" name="InfoPrison" value="{L_TOWNBOUTONINFO1}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Banque.gif" /><br /><input type="submit" name="InfoBanque" value="{L_TOWNBOUTONINFO2}" class="mainoption" /></td>
			</tr>
			<tr>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Maison.gif" /><br /><input type="submit" name="InfoMaison" value="{L_TOWNBOUTONINFO3}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Forge.gif" /><br /><input type="submit" name="InfoForge" value="{L_TOWNBOUTONINFO4}" class="mainoption" /></td>
			</tr>
			<tr>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Temple.gif" /><br /><input type="submit" name="InfoTemple" value="{L_TOWNBOUTONINFO5}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Boutique.gif" /><br /><input type="submit" name="InfoBoutique" value="{L_TOWNBOUTONINFO6}" class="mainoption" /></td>
			</tr>
			<tr>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Combat.gif" /><br /><input type="submit" name="InfoCombat" value="{L_TOWNBOUTONINFO9}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Mine.gif" /><br /><input type="submit" name="InfoMine" value="{L_TOWNBOUTONINFO10}" class="mainoption" /></td>
			</tr>
			<tr>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Enchantement.gif" /><br /><input type="submit" name="InfoEnchantement" value="{L_TOWNBOUTONINFO11}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Clan.gif" /><br /><input type="submit" name="InfoClan" value="{L_TOWNBOUTONINFO12}" class="mainoption" /></td>
			</tr>
			<tr>
				<td align="center"><img src="adr/images/TownMap/{SAISON}/Icone_Entrainement.gif" /><br /><input type="submit" name="InfoEntrainement" value="{L_TOWNBOUTONINFO7}" class="mainoption" /></td>
				<td><img src="adr/images/TownMap/{SAISON}/Icone_Entrepot.gif" /><br /><input type="submit" name="InfoEntrepot" value="de garde" class="mainoption" /></td>
			</tr>
			</table>
			</form>
		</span></td>
		<!-- END switch_Adr_zone_townmap_disable -->
	</tr>
</table>
<br clear="all" />

<!-- BEGIN switch_Adr_zone_townmap_disable -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="10">Actions</td>
	</tr>
	<tr>
        <td align="center" class="row2"><a href="adr_blacksmithing.php">Forge</a></td>
        <td align="center" class="row1"><a href="adr_brewing.php">Brassage</a></td>
        <td align="center" class="row2" colspan="2"><a href="adr_cooking.php">Cuisine</a></td>
    </tr>
    <tr>
	    <td align="center" class="row1" colspan="1"><a href="adr_alchemy.php">Atelier d'alchimie</a></td>
        <td align="center" class="row1" colspan="3"><a href="adr_tailor.php">Tailleur</a></td>
    </td>
	<tr>
        <td align="center" class="row2"><a href="adr_fish.php">Pêche</a></td>
        <td align="center" class="row2"><a href="adr_herbal.php">Herboristerie</a></td>
        <td align="center" class="row1"><a href="adr_hunting.php">Chasse</a></td>
        <td align="center" class="row2"><a href="adr_lumberjack.php">Bûcheron</a></td>
    </tr>
    <tr>
    	<td align="center"><a href="adr_beggar.php">Parler à la mendiante</a></td>
    	<td align="center"><a href="adr_lake.php">Lac magique</a></td>
    	<td align="center" colspan="2"><a href="adr_party.php">Groupe</a></td>
    </tr>
</table>
<br clear="all" />
<!-- END switch_Adr_zone_townmap_disable -->

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

<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="2" ><u>{L_ZONE_CONNECTED}</u></td>
	</tr>
  	<tr> 
		<td width="100%" class="row1"><span class="gen"><br />{USERS_CONNECTED_LIST}<br /><br /></span></td>
  	</tr>
</table>

<iframe src="{U_SHOUTBOX_BODY}" width="100%" height="300"></iframe>