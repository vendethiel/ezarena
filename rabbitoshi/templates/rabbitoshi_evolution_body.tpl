<!-- INCLUDE ../../adr/templates/adr_header_body -->

<form action="{S_MODE_ACTION}" method="post">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_EVOLUTION_TITLE}</span></td>
	  <td align="right"><span class="gen">{L_OWNER_POINTS}: <b>{POINTS}</b> {L_POINTS}</span></td>
	</tr>
 </table>

<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead" colspan="3">{L_WELCOME_EVOLUTION}</th>
	</tr>
	<!-- BEGIN available_pets -->
	<tr align="center">
		<td class="row1" width="30%"><span class="gen">{available_pets.PET_IMG}<br />{available_pets.PET_NAME}</span></td>
		<td class="row2" width="30%"><table align="center" border="0" cellpadding="3" cellspacing="1" class="bodyline" width="180">
			<tr><td class="row1"><span class="gen">{L_PET_HEALTH}</span></td><td align="right" class="row1"><span class="gen">{available_pets.PET_HEALTH}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HUNGER}</span></td><td align="right" class="row1"><span class="gen">{available_pets.PET_HUNGER}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_THIRST}</span></td><td align="right" class="row1"><span class="gen">{available_pets.PET_THIRST}</span></td></tr>
			<tr><td class="row1"><span class="gen">{L_PET_HYGIENE}</span></td><td align="right" class="row1"><span class="gen">{available_pets.PET_HYGIENE}</span></td></tr>
                </table></td>
		<td class="row1" width="30%"><span class="gen"><br />{L_PET_PRIZE} {available_pets.PET_PRIZE}&nbsp;{L_POINTS}<br /><br />{L_PET_CHOOSE}{available_pets.PET_NAME}<br /><input type="radio" name="evolution_pet" value="{available_pets.PET_ID}" ></span></td>
	</tr>
        <!-- END available_pets -->
	<tr>
	     <td class="catBottom" align="center" colspan="3"><input type="submit" value="{L_EVOLUTION_EXEC}" name="Evolution_exec" class="liteoption" /></td>
	</tr>

</table>
</form>
<br clear="all" />