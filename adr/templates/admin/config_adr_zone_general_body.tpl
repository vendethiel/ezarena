<h1>{L_ZONE_GENERAL_TITLE}</h1>

<P>{L_ZONE_GENERAL_EXPLAIN}</p>

<form method="post" action="{S_ZONE_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="row1" width="60%">{L_ZONE_DEAD_TRAVEL}</td>
		<td class="row1" align="center"><input type="checkbox" name="dead_travel" value="1" {ZONE_DEAD_TRAVEL} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_BONUS_STAT}</td>
		<td class="row2" align="center"><input type="checkbox" name="stat_bonus" value="1" {ZONE_BONUS_STAT} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_BONUS_ATT}</td>
		<td class="row1" align="center"><input type="post" name="att_bonus" maxlength="8" size="8" value="{ZONE_BONUS_ATT}" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_BONUS_DEF}</td>
		<td class="row2" align="center"><input type="post" name="def_bonus" maxlength="8" size="8" value="{ZONE_BONUS_DEF}" /></td>
	</tr>
	<tr>
		<th align="center" colspan="10" ><b>{L_ZONE_NPC_TITLE}</b></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_NPC_DISPLAY_ENABLE}</td>
		<td class="row2" align="center"><input type="checkbox" name="npc_display_enable" value="1" {ZONE_NPC_DISPLAY_ENABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_NPC_DISPLAY_TEXT}</td>
		<td class="row1" align="center"><input type="checkbox" name="npc_display_text" value="1" {ZONE_NPC_DISPLAY_TEXT} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_NPC_IMAGE_LINK}</td>
		<td class="row2" align="center"><input type="checkbox" name="npc_image_link" value="1" {ZONE_NPC_IMAGE_LINK} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_NPC_BUTTON_LINK}</td>
		<td class="row1" align="center"><input type="checkbox" name="npc_button_link" value="1" {ZONE_NPC_BUTTON_LINK} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_NPC_IMAGE_COUNT}</td>
		<td class="row2" align="center"><input type="post" name="npc_image_count" maxlength="8" size="8" value="{ZONE_NPC_IMAGE_COUNT}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_NPC_IMAGE_SIZE}</td>
		<td class="row1" align="center"><input type="post" name="npc_image_size" maxlength="8" size="8" value="{ZONE_NPC_IMAGE_SIZE}" /></td>
	</tr>
	<tr>
		<th align="center" colspan="10" ><b>{L_ZONE_CHEAT_TITLE}</b></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_CHEAT_MEMBER_PM_LIST}</td>
		<td class="row2" align="center"><span class="gen">{ZONE_CHEAT_MEMBER_PM_LIST}</span></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_MODERATORS_LIST}</td>
		<td class="row1" align="center"><span class="gen">{ZONE_MODERATORS_LIST}</span></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_CHEAT_AUTO_PUBLIC}</td>
		<td class="row2" align="center"><input type="checkbox" name="cheat_auto_public" value="1" {ZONE_CHEAT_AUTO_PUBLIC} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_CHEAT_BAN_ADR}</td>
		<td class="row1" align="center"><input type="checkbox" name="cheat_auto_ban_adr" value="1" {ZONE_CHEAT_AUTO_BAN_ADR} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_CHEAT_BAN_BOARD}</td>
		<td class="row2" align="center"><input type="checkbox" name="cheat_auto_ban_board" value="1" {ZONE_CHEAT_AUTO_BAN_BOARD} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_CHEAT_IMPRISONMENT}</td>
		<td class="row1" align="center"><input type="checkbox" name="cheat_auto_jail" value="1" {ZONE_CHEAT_AUTO_JAIL} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_CHEAT_IMPRISONMENT_TIME}</td>
		<td class="row2"  align="center">
			<span class="gen">
				<input class="post" type="text" name="cheat_auto_time_day" size="8" maxlength="8"  value="{ZONE_CHEAT_AUTO_TIME_DAY}" />{L_ZONE_CHEAT_IMPRISONMENT_DAY}&nbsp;&nbsp;&nbsp;<br />
				<input class="post" type="text" name="cheat_auto_time_hour" size="8" maxlength="8"  value="{ZONE_CHEAT_AUTO_TIME_HOUR}" />{L_ZONE_CHEAT_IMPRISONMENT_HOUR}&nbsp;<br />
				<input class="post" type="text" name="cheat_auto_time_minute" size="8" maxlength="8" value="{ZONE_CHEAT_AUTO_TIME_MINUTE}" />{L_ZONE_CHEAT_IMPRISONMENT_MINUTE}
			</span>
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_CHEAT_IMPRISONMENT_CAUTION}</td>
		<td class="row1" align="center"><input type="post" name="cheat_auto_caution" maxlength="8" size="8" value="{ZONE_CHEAT_AUTO_CAUTION}" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_CHEAT_IMPRISONMENT_FREEABLE}</td>
		<td class="row2" align="center"><input type="checkbox" name="cheat_auto_freeable" value="1" {ZONE_CHEAT_AUTO_FREEABLE} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_CHEAT_IMPRISONMENT_CAUTIONABLE}</td>
		<td class="row1" align="center"><input type="checkbox" name="cheat_auto_cautionable" value="1" {ZONE_CHEAT_AUTO_CAUTIONABLE} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%"><span class="gen">{L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT}</span></td>
		<td class="row2" align="center">
			<span class="gen">
				<input type="radio" name="cheat_auto_punishment" value="1" {ZONE_CHEAT_AUTO_PUNISHMENT_MAX_CHECKED} />{L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_GLOBAL}<br />
				<input type="radio" name="cheat_auto_punishment" value="2" {ZONE_CHEAT_AUTO_PUNISHMENT_MED_CHECKED} />{L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_POSTS}<br />
				<input type="radio" name="cheat_auto_punishment" value="3" {ZONE_CHEAT_AUTO_PUNISHMENT_MIN_CHECKED} />{L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_READ}
			</span>
		</td>
	</tr>
	<tr>
		<th align="center" colspan="10" ><b>Cartes de zone dynamiques</b></td>
	</tr>
	<tr>
		<td class="row1" width="60%">Afficher la "World Map" (Mapmonde) dans le RPG ? (sur la page des zones, onglet "Cartographie")</td>
		<td class="row1" align="center"><input type="checkbox" name="Adr_zone_world_map_enable" value="1" {ZONE_WORLD_MAP} /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS}</td>
		<td class="row2" align="center"><input type="checkbox" name="Adr_zone_townmap_enable" value="1" {ZONE_DYNAMIC_ZONE_MAPS} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS_NAME}</td>
		<td class="row1" align="center"><input type="post" name="Adr_zone_townmap_name" maxlength="20" size="20" value="{ZONE_DYNAMIC_ZONE_MAPS_NAME}" /></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS_PICTURE_LINK}</td>
		<td class="row2" align="center"><input type="checkbox" name="Adr_zone_picture_link_enable" value="1" {ZONE_DYNAMIC_ZONE_MAPS_PICTURE_LINK} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS_CURRENT_ZONE}</td>
		<td class="row1" align="center"><b>{ZONE_DYNAMIC_ZONE_MAPS_CURRENT_ZONE}</b></td>
	</tr>
	<tr>
		<td class="row2" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS_CONFIG_ZONE}</td>
		<td class="row2" align="center"><input type="post" name="Adr_zone_worldmap_zone" maxlength="8" size="8" value="{ZONE_DYNAMIC_ZONE_MAPS_CONFIG_ZONE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_ZONE_DYNAMIC_ZONE_MAPS_DISPLAY_REQUIRED}</td>
		<td class="row1" align="center"><input type="checkbox" name="Adr_zone_townmap_display_required" value="1" {ZONE_DYNAMIC_ZONE_MAPS_DISPLAY_REQUIRED} /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="12" align="center"><input type="submit" name="submit" value="{L_ZONE_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />