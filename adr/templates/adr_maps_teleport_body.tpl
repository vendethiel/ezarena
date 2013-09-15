<form action="{S_TELEPORT_ACTION}" method="post">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
<!-- BEGIN switch_Adr_zone_teleport_welcome -->
		<th align="center" colspan="3" >{WELCOME}</th>
<!-- END switch_Adr_zone_teleport_welcome -->
<!-- BEGIN switch_Adr_zone_teleport_no_welcome -->
		<th align="center" colspan="3" >{ZONE_NAME}</th>
<!-- END switch_Adr_zone_teleport_no_welcome -->
	</tr>
	<tr>
		<td align="center" class="row1" width="40%" ><span class="gen"><img src="adr/images/zones/zones_img/{ZONE_IMG}.jpg" border="0" ></span></td>
		<td align="left" class="row2" width="60%" ><span class="gen"><br \><b><u>{L_ZONE_DESCRIPTION} :</u></b> {ZONE_DESCRIPTION}<br /><br /><b><u>{L_ZONE_ELEMENT} :</u></b> {ZONE_ELEMENT}<br /><br />
<!-- BEGIN switch_Adr_zone_townmap_display_required -->
		<!-- IF ZONE_REQUIRED_ITEM -->
		<b><u>{L_ZONE_REQUIRED_ITEM} :</u></b> {ZONE_REQUIRED_ITEM}<br /><br />
		<!-- ENDIF -->
		<!-- IF ZONE_COST_RETURN -->
		<b><u>{L_ZONE_COST} :</u></b> {ZONE_COST_RETURN} {POINTS}<br /><br />
		<!-- ENDIF -->
		<!-- IF ZONE_LEVEL && ZONE_LEVEL > 1 -->
		<b><u>Niveau requis :</u></b> {ZONE_LEVEL}<br /><br/>
		<!-- ENDIF -->
<!-- END switch_Adr_zone_townmap_display_required -->
		<b>{L_MAP_SHOPS}:</b> {MAP_SHOPS}<br />
		<b>{L_MAP_FORGE}:</b> {MAP_FORGE}<br />
		<b>{L_MAP_TEMPLE}:</b> {MAP_TEMPLE}<br />
		<b>{L_MAP_PRISON}:</b> {MAP_PRISON}<br />
		<b>{L_MAP_BANK}:</b> {MAP_BANK}<br />
	</tr>
</table>
<td><div align=center><br />
<!-- BEGIN switch_Adr_zone_teleport_enable -->
<input type="hidden" value="{ZONE_NAME}" name="zone"><input type="submit" class="liteoption" name="teleport" value="{L_MAP_TELEPORT}"><br /><br />
<!-- END switch_Adr_zone_teleport_enable -->
<input type="submit" class="liteoption" name="cancel" value="{L_MAP_CLOSE_WINDOW}" onClick="javascript:window.close()"></td>
<br clear="all" />
</form>
