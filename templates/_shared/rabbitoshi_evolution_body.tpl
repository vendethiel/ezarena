<form action="{S_MODE_ACTION}" method="post"> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_EVOLUTION_TITLE}</span></td>
	  <td align="right"><span class="nav"><a href="rabbitoshi.php" class="nav">{L_RETURN}</a></span></td>
	</tr>
 </table>

<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thsides" align="center">{L_WELCOME_EVOLUTION}</th>
	</tr>
	<tr>
	  <td class="row2" align="center" colspan="7" ><span class="gen">{L_OWNER_POINTS} : <b>{POINTS}</b> {L_POINTS}</td>
	</tr>
<table>
<br clear="all" />

<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
<!-- BEGIN available_pets -->
	<tr>
		<td class="row1" align="center" width="20%"><span class="gen"><img src="images/Rabbitoshi/{available_pets.PET_NAME}.gif"><br />{available_pets.PET_NAME}</span></td>
		<td class="row2" align="center" width="20%"><span class="gen"><br />{L_PET_HEALTH} {available_pets.PET_HEALTH}<br />{L_PET_HUNGER} {available_pets.PET_HUNGER}<br />{L_PET_THIRST} {available_pets.PET_THIRST}<br />{L_PET_HYGIENE} {available_pets.PET_HYGIENE}</span></td>
		<td class="row2" align="center" width="20%"><span class="gen"><br />{L_PET_PRIZE} {available_pets.PET_PRIZE}&nbsp;{L_POINTS}<br /><br />{L_PET_CHOOSE}{available_pets.PET_NAME}<br /><input type="radio" name="evolution_pet" value="{available_pets.PET_ID}" ></span></td>
	</tr>
<!-- END available_pets -->
	<tr>
	     <td class="row2" align="center" colspan="5" ><input type="submit" value="{L_EVOLUTION_EXEC}" name="Evolution_exec" class="liteoption" /></td>
	</tr>

</table>
</form>
<br clear="all" />

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>


