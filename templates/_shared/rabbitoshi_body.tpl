 <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_PUBLIC_TITLE}</span></td>
		</span></td>
	</tr>
  </table>

<table cellpadding="1" cellspacing="1" border="5" width="100%">
<!-- BEGIN nopet -->
<form action="{S_CONFIG_ACTION}" method="post">
<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thSides" colspan="3" height="25" valign="middle" width="100%">{L_NOPET_TITLE}</th>
	</tr>
<!-- BEGIN pets -->
	<tr>
		<td class="row1" align="center" width="20%"><span class="gen"><img src="images/Rabbitoshi/{nopet.pets.RABBIT_NOPET_IMG}"><br />{nopet.pets.RABBIT_NOPET_NAME}</span></td>
		<td class="row2" align="center" width="20%"><span class="gen"><br />{L_PET_HEALTH} {nopet.pets.RABBIT_NOPET_HEALTH}<br />{L_PET_HUNGER} {nopet.pets.RABBIT_NOPET_HUNGER}<br />{L_PET_THIRST} {nopet.pets.RABBIT_NOPET_THIRST}<br />{L_PET_HYGIENE} {nopet.pets.RABBIT_NOPET_HYGIENE}<br />{L_POWER} {nopet.pets.RABBIT_NOPET_POWER}<br />{L_MAGICPOWER} {nopet.pets.RABBIT_NOPET_MAGICPOWER}<br />{L_ARMOR} {nopet.pets.RABBIT_NOPET_ARMOR}<br /><br /></span></td>
		<td class="row2" align="center" width="20%"><span class="gen"><br />{L_PET_PRIZE} {nopet.pets.RABBIT_NOPET_PRIZE}&nbsp;{L_POINTS}<br /><br />{L_PET_CHOOSE}{nopet.pets.RABBIT_NOPET_NAME}<br /><input type="radio" name="petbuyed" value="{nopet.pets.RABBIT_NOPET_ID}" ></span></td>
</tr>
<!-- END pets -->
	<tr> 
		<td class="spaceRow" colspan="5" height="3"><img src="templates/{T_TEMPLATE_NAME}/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<tr>
	  <td class="row1" width="20%" align="center"><span class="gensmall">{L_PET_NAME_SELECT}</span></td>
	  <td class="row2" align="center"><input class="post" type="text" maxlength="255" size="15" name="Creaturename" /></td>
	  <td class="row2" align="center"><input type="submit" value="{L_PET_BUY}" name="Buypet"></td>
	</tr>
</table>
</form>
<!-- END nopet -->

<!-- BEGIN pet -->
<form action="{S_PET_ACTION}" method="post">
<table width="100%" border="1" cellspacing="1" cellpadding="0" align="center">
	<tr>
		<th class="thHead" colspan="6" align="center" width="100%">{L_PET_OF}{PET_OWNER}</th>
	</tr>
	<tr>
	  <td class="row1" width="50%" align="center" colspan="3" ><span class="gensmall"><b>{PET_NAME}</b><br /><br />
	<!-- BEGIN pet_hotel -->
	{IN_HOTEL}<br />{HOTEL_TIME}
	<!-- END pet_hotel -->
	<!-- BEGIN pet_no_hotel -->
	<img src="images/Rabbitoshi/{PET_PIC}"><br /><br />{L_HEALTH} {STATUT_HEALTH}
	<!-- END pet_no_hotel -->
	</span></td>
	  <td class="row2" width="50%" align="center" colspan="3" ><span class="gen"><b>{L_CARACS}</b></span><span class="gensmall"><br />
		{L_AGE}{PET_AGE}<br /><br />
		{L_HEALTH}{PET_HEALTH} / {CPET_HEALTH}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil.gif" width="{HEALTH_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{HEALTH_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right.gif" width="1" height="12" /></td>
		</table>
		<br />{L_HUNGER}{PET_HUNGER} / {CPET_HUNGER}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left1.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil1.gif" width="{HUNGER_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end1.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{HUNGER_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right1.gif" width="1" height="12" /></td>
		</table><br />
		{L_THIRST}{PET_THIRST} / {CPET_THIRST}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left2.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil2.gif" width="{THIRST_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end2.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{THIRST_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right2.gif" width="1" height="12" /></td>
		</table><br />
		{L_HYGIENE}{PET_HYGIENE} / {CPET_HYGIENE}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left4.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil4.gif" width="{HYGIENE_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end4.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{HYGIENE_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right4.gif" width="1" height="12" /></td>
		</table><br />
	  </span>
	</td>
	</tr>

	<tr>
	  <td class="row2" align="center" width="50%" colspan="3"><span class="gen"><b>{L_CHARACTERISTICS}</b></span><br /><span class="gensmall"><br />{L_LEVEL} {PET_LEVEL}<br /><br />{L_POWER} {PET_POWER}<br /><br />{L_MAGICPOWER} {PET_MAGICPOWER}<br /><br />{L_ARMOR} {PET_ARMOR}<br /><br />{L_EXPERIENCE} {PET_EXPERIENCE}<br /><br />{L_EXPERIENCE_LIMIT} {PET_EXPERIENCE_LIMIT}/{PET_EXPERIENCE_LIMIT_MAX}<br /><br /></span></td>
	  <td class="row1" align="center" width="50%" colspan="3"><span class="gen"><b>{L_ATTACKS}</b></span><br /><span class="gensmall"><br />
		{L_RATIO_ATTACK} {PET_ATTACK} / {CPET_ATTACK}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left5.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil5.gif" width="{ATTACK_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end5.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{ATTACK_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right5.gif" width="1" height="12" /></td>
		</table><br />
		{L_RATIO_MAGIC} {PET_MAGICATTACK} / {CPET_MAGICATTACK}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left6.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil6.gif" width="{MAGICATTACK_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end6.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{MAGICATTACK_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right6.gif" width="1" height="12" /></td>
		</table><br />
		{L_MP}{PET_MP} / {CPET_MP}<br />
		<table cellspacing="0" cellpadding="0" border="0">
			<td><img src="images/Rabbitoshi/bar_left3.gif" width="2" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil3.gif" width="{MP_PERCENT_WIDTH}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_fil_end3.gif" width="1" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_emp.gif" width="{MP_PERCENT_EMPTY}" height="12" /></td>
			<td><img src="images/Rabbitoshi/bar_right3.gif" width="1" height="12" /></td>
		</table><br /><br />{L_ABILITY} {ABILITY}<br /><br /></span></td>
	</tr>

	<tr>
	  <td class="row2" align="center" width="50%" colspan="3"><span class="gen"><b>{L_LAST_VISIT}</b></span><br /><span class="gensmall">{LAST_VISIT}</span></td>
	  <td class="row1" align="center" width="50%" colspan="3"><span class="gen"><b>{L_FAVORITE_FOOD}</b></span><br /><span class="gensmall">{FAVORITE_FOOD}</span></td>
	</tr>
<!-- BEGIN owner -->
	<tr>
	  <td class="row2" align="center" width="100%" colspan="6"><span class="gen"><b>{L_PET_GENERAL_MESSAGE}</b></span><br /><span class="gensmall">{PET_GENERAL_MESSAGE}<br /><br /></span></td>
	</tr>
	<tr>
	  <td class="row1" align="center" width="100%" colspan="6"><span class="gen"><b>{L_PET_MESSAGE}</b></span><br /><span class="gensmall">{PET_MESSAGE}<br /></span></td>
	</tr>
	<tr height="25" >
	  <td class="row2" align="center" colspan="6" >
		<input type="submit" value="{L_FEED}" name="Feed" class="liteoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" value="{L_DRINK}" name="Drink" class="liteoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" value="{L_CLEAN}" name="Clean" class="liteoption" />&nbsp;&nbsp;&nbsp;
	  </td>
	</tr>
</table>
<br clear="all" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<tr>
	  <th class="row2" align="center" colspan="6"><span class="thHead"><b>{L_PET_SERVICES}</b> -- {L_OWNER_POINTS} : <b>{POINTS}</b> {L_POINTS}</span></th>
	</tr>
	<tr height="25" >
	 <td class="row2" align="center" colspan="3"><input type="submit" value="{L_OWNER_LIST}" name="Owner_list" class="liteoption" /></td>
	 <td class="row1" align="center" colspan="3"><span class="gen"> {L_OWNER_LIST_EXPLAIN}</span></td>
	</tr>
	<tr height="25" >
	 <td class="row2" align="center" colspan="3"><input type="submit" value="{L_PREFERENCES}" name="prefs" class="liteoption" /></td>
	 <td class="row1" align="center" colspan="3"><span class="gen">{L_PREFERENCES_EXPLAIN}</span></td>
	</tr>
	<tr height="25" >
	 <td class="row2" align="center" colspan="3"><input type="hidden" name="pet_value" value="{PET_VALUE}" ><input type="submit" value="{L_PET_SELL}" name="Sellpet" class="liteoption" /></td>
	 <td class="row1" align="center" colspan="3"><span class="gen">{L_PET_VALUE} : <b>{PET_VALUE}</b> {L_POINTS}</span></td>
	</tr>
	<tr height="25" >
	  <td class="row2" align="center" colspan="3" ><input type="submit" value="{L_VET}" name="Vet" class="liteoption" /></td>
	  <td class="row1" align="center" colspan="3" ><span class="gen">{L_VET_EXPLAIN} {VET_PRICE} {L_POINTS}</span></td>
	</tr>
	<tr height="25" >
	  <td class="row2" align="center" colspan="3" ><input type="submit" value="{L_HOTEL}" name="Hotel" class="liteoption" /></td>
	  <td class="row1" align="center" colspan="3" ><span class="gen">{L_HOTEL_EXPLAIN}</span></td>
	</tr>
	<tr height="25" >
	  <td class="row2" align="center" colspan="3" ><input type="submit" value="{L_EVOLUTION}" name="Evolution" class="liteoption" /></td>
	  <td class="row1" align="center" colspan="3" ><span class="gen">{L_EVOLUTION_EXPLAIN}</span></td>
	</tr>
</form>
<form action="{U_PET_PROGRESS}" method="post">
	<tr height="25" >
	  <td class="row2" align="center" colspan="3" ><input type="submit" value="{L_PROGRESS}" class="liteoption" /></td>
	  <td class="row1" align="center" colspan="3" ><span class="gen">{L_PET_PROGRESS}</span></td>
	</tr>
</form>
<form action="{U_PET_SHOP}" method="post">
	<tr height="25" >
	  <td class="row2" align="center" colspan="3" ><input type="submit" value="{L_PET_SHOP}" class="liteoption" /></td>
	  <td class="row1" align="center" colspan="3" ><span class="gen">{L_SHOP}</span></td>
	</tr>
</form>
<!-- END owner -->
</table>
</form>
<br clear="all" />
<!-- END pet -->
<br clear="all" />

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>