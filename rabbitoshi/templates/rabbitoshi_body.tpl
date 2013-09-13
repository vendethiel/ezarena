<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; {L_PUBLIC_TITLE}</span></td>
	</tr>
</table>

<!-- BEGIN nopet -->
<form action="{S_CONFIG_ACTION}" method="post">
  <table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead" colspan="3">{L_NOPET_TITLE}</th>
	</tr>
	<!-- BEGIN pets -->
	<tr align="center">
		<td class="row1" width="20%"><span class="gen">{nopet.pets.RABBIT_NOPET_IMG}<br />{nopet.pets.RABBIT_NOPET_NAME}</span></td>
		<td class="row2" width="20%"><table align="center" border="0" cellpadding="3" cellspacing="1" class="bodyline" width="180">
			<tr><td class="row1"><span class="gen">{L_PET_HEALTH}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HEALTH}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HUNGER}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HUNGER}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_THIRST}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_THIRST}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HYGIENE}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HYGIENE}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_POWER}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_POWER}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_MAGICPOWER}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MAGICPOWER}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_ARMOR}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_ARMOR}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_RATIO_ATTACK}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_ATTACK}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_RATIO_MAGIC}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MAGICATTACK}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_MP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MP}</span></td></tr>
        </table></td>
		<td class="row2" width="20%"><table align="center" border="0" cellpadding="3" cellspacing="1" class="bodyline" width="180">
			<tr><td class="row1"><span class="gen">{L_PET_HEALTH_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HEALTH_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HUNGER_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HUNGER_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_THIRST_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_THIRST_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HYGIENE_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_HYGIENE_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_POWER_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_POWER_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_MAGICPOWER_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MAGICPOWER_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_ARMOR_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_ARMOR_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_ATTACK_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_ATTACK_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_MAGICATTACK_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MAGICATTACK_LEVELUP}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_MP_LEVELUP}</span></td><td align="right" class="row1"><span class="gen">{nopet.pets.RABBIT_NOPET_MP_LEVELUP}</span></td></tr>
        </table></td>
		<td class="row1" width="20%"><span class="gen"><br />{L_PET_PRIZE} {nopet.pets.RABBIT_NOPET_PRIZE}&nbsp;{L_POINTS}<br /><br />{L_PET_CHOOSE}{nopet.pets.RABBIT_NOPET_NAME}<br /><input type="radio" name="purchacing_pet" value="{nopet.pets.RABBIT_NOPET_ID}" ></span></td>
	</tr>
	<!-- END pets -->
	<tr>
		<td class="spaceRow" colspan="3" height="3"><img src="rabbitoshi/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<tr align="center">
	  <td class="row1"><span class="gensmall">{L_PET_NAME_SELECT}</span></td>
	  <td class="row2"><input type="text" class="post" maxlength="255" size="15" name="yourpet_name" /></td>
	  <td class="row1"><input type="submit" class="liteoption" value="{L_PET_BUY}" name="Buypet"></td>
	</tr>
  </table>
</form>
<!-- END nopet -->

<!-- BEGIN pet -->
<form action="{S_PET_ACTION}" method="post">
<table align="center" border="0" cellpadding="0" cellspacing="2" width="100%">
<tr><td width="200" valign="top">
<!-- BEGIN owner -->
<table cellpadding="4" cellspacing="1" border="0" class="forumline" width="200">
<tr>
	<th class="thHead">{L_PET_SERVICES}</th>
</tr>
<tr>
	<td height="25" class="row1">
		<span class="gensmall"><b>{L_OWNER_POINTS}: <b>{POINTS}</b> {L_POINTS}</b></span><hr />
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall" style="font-weight: bold;"><input type="submit" value="{L_OWNER_LIST}" name="Owner_list" class="liteoption" /></div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_PREFERENCES}" name="prefs" class="liteoption" /></div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="hidden" name="pet_value" value="{PET_VALUE}" ><input type="submit" value="{L_PET_SELL}" name="Sellpet" class="liteoption" /></div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_VET}" name="Vet" class="liteoption" /></div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_HOTEL}" name="Hotel" class="liteoption" /></div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_EVOLUTION}" name="Evolution" class="liteoption" /></div></td>
		</tr>
		</form>
		<form action="{U_PET_PROGRESS}" method="post">
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_PROGRESS}" class="liteoption" /></div></td>
		</tr>
		</form>
		<form action="{U_PET_SHOP}" method="post">
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_PET_SHOP}" class="liteoption" /></div></td>
		</tr>
		</form>
		<form action="{U_PET_INVENTORY}" method="post">
		<tr>
			<td width="10" align="right"><div class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap"><div class="gensmall"><input type="submit" value="{L_PET_INVENTORY}" class="liteoption" /></div></td>
		</tr>
		</form>
		</table>
	</td>
</tr>
</table>
<!-- END owner -->
<form action="{S_PET_ACTION}" method="post">
</td><td valign="top" width="100%">
  <table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead" colspan="3">{L_PET_OF} {PET_OWNER}</th>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" colspan="2">
		   <!-- BEGIN pet_hotel -->
			<span class="gensmall">{IN_HOTEL}&nbsp;<i>{HOTEL_TIME}</i></span>
		   <!-- END pet_hotel -->
		   <!-- BEGIN pet_no_hotel -->
			{PET_PIC}<br /><b class="genmed">{PET_NAME}</b><br /><br />
			<span class="gensmall">
		   <font color="#FF0000">{L_HEALTH}: {PET_HEALTH} / {CPET_HEALTH}</font>
		   <table cellspacing="0" cellpadding="0" border="0">
			<td><img src="rabbitoshi/images/stats/bar_left.gif" width="2" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil.gif" width="{HEALTH_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil_end.gif" width="1" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_emp.gif" width="{HEALTH_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_right.gif" width="1" height="12" /></td>
		   </table>
		   <br />
		   <font color="#00CC66">{L_MP}: {PET_MP} / {CPET_MP}</font>
		   <table cellspacing="0" cellpadding="0" border="0">
			<td><img src="rabbitoshi/images/stats/bar_left3.gif" width="2" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil3.gif" width="{MP_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil_end3.gif" width="1" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_emp.gif" width="{MP_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_right3.gif" width="1" height="12" /></td>
		   </table>
		   <!-- END pet_no_hotel -->
		</td>
		<td class="row2" width="50%" align="center" rowspan="6">
                <table align="center" border="0" cellpadding="3" cellspacing="1" class="bodyline" width="85%">
                <tr>
                <th class="thHead" colspan="2">{L_CARACS}</th>
                </tr>
                <tr>
                <td class="row1" width="40%"><span class="gen">{L_LEVEL}</span></td>
                <td class="row2" width="60%"><span class="gen">{PET_LEVEL}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_EXPERIENCE_LIMIT}</span></td>
                <td class="row2"><span class="gen">{PET_EXPERIENCE_LIMIT}/{PET_EXPERIENCE_LIMIT_MAX}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_COND}</span></td>
                <td class="row2"><span class="gen">{STATUT_HEALTH}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_AGE}</span></td>
                <td class="row2"><span class="gen">{PET_AGE}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_LAST_VISIT}</span></td>
                <td class="row2"><span class="gen">{LAST_VISIT}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_FAVORITE_FOOD}</span></td>
                <td class="row2"><span class="gen">{FAVORITE_FOOD}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_POWER}</span></td>
                <td class="row2"><span class="gen">{PET_POWER}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_MAGICPOWER}</span></td>
                <td class="row2"><span class="gen">{PET_MAGICPOWER}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_ARMOR}</span></td>
                <td class="row2"><span class="gen">{PET_ARMOR}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_EXPERIENCE}</span></td>
                <td class="row2"><span class="gen">{PET_EXPERIENCE}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_ABILITY}</span></td>
                <td class="row2"><span class="gen">{ABILITY}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_RATIO_ATTACK}</span></td>
                <td class="row2"><span class="gen">{PET_ATTACK} / {CPET_ATTACK}</span></td>
                </tr>
                <tr>
                <td class="row1"><span class="gen">{L_RATIO_MAGIC}</span></td>
                <td class="row2"><span class="gen">{PET_MAGICATTACK} / {CPET_MAGICATTACK}</span></td>
                </tr>
                </table>
		</td>
	</tr>
	<!-- BEGIN pet_no_hotel -->
	<tr>
		<td class="row1" align="center" colspan="2"><span class="gen"><b>{L_PET_GENERAL_MESSAGE}</b></span><br /><span class="gensmall">{PET_GENERAL_MESSAGE}<br /><br /></span></td>
	</tr>
	<tr>
		<td class="row1" align="center" colspan="2"><span class="gen"><b>{L_PET_MESSAGE}</b></span><br /><span class="gensmall">{PET_MESSAGE}<br /></span></td>
	</tr>
	<!-- END pet_no_hotel -->
	<tr>
		<td class="row1" align="center">
                <span class="gensmall">
		   {L_HUNGER}: {PET_HUNGER} / {CPET_HUNGER}<br />
		   <table cellspacing="0" cellpadding="0" border="0">
			<td><img src="rabbitoshi/images/stats/bar_left1.gif" width="2" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil1.gif" width="{HUNGER_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil_end1.gif" width="1" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_emp.gif" width="{HUNGER_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_right1.gif" width="1" height="12" /></td>
		   </table>
                   </span>
                </td>
                <!-- BEGIN owner -->
                <td class="row1" align="center"><input type="submit" value="{L_FEED}" name="Feed" class="liteoption" /></td>
                <!-- END owner -->
	</tr>
	<tr>
		<td class="row1" align="center">
                <span class="gensmall">
		   {L_THIRST}: {PET_THIRST} / {CPET_THIRST}<br />
		   <table cellspacing="0" cellpadding="0" border="0">
			<td><img src="rabbitoshi/images/stats/bar_left2.gif" width="2" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil2.gif" width="{THIRST_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil_end2.gif" width="1" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_emp.gif" width="{THIRST_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_right2.gif" width="1" height="12" /></td>
		   </table>
                   </span>
                </td>
                <!-- BEGIN owner -->
                <td class="row1" align="center"><input type="submit" value="{L_DRINK}" name="Drink" class="liteoption" /></td>
                <!-- END owner -->
	</tr>
	<tr>
		<td class="row1" align="center">
                <span class="gensmall">
		   {L_HYGIENE}: {PET_HYGIENE} / {CPET_HYGIENE}<br />
		   <table cellspacing="0" cellpadding="0" border="0">
			<td><img src="rabbitoshi/images/stats/bar_left4.gif" width="2" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil4.gif" width="{HYGIENE_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_fil_end4.gif" width="1" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_emp.gif" width="{HYGIENE_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="rabbitoshi/images/stats/bar_right4.gif" width="1" height="12" /></td>
		   </table>
                   </span>
                </td>
                <!-- BEGIN owner -->
                <td class="row1" align="center"><input type="submit" value="{L_CLEAN}" name="Clean" class="liteoption" /></td>
                <!-- END owner -->
	</tr>
</table>
</td></tr></table>

</form>

<!-- END pet -->
<br clear="all" />