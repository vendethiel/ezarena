<div class="maintitle">{L_CONFIGURATION_TITLE}</div>
<br />
<p>{L_CONFIGURATION_EXPLAIN}</p>
<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_GENERAL_SETTINGS}</th>
</tr>
<!-- RCS ? -->
<tr> 
	<td class="row1" width="38%">{l_mod_rcs}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="mod_rcs" value="1" {mod_rcs_yes} {desactive_rcs}>
		{L_NO}<input type="radio" name="mod_rcs" value="0" {mod_rcs_no} {desactive_rcs}>
	</td>
</tr>
<!-- Gender ? -->
<tr> 
	<td class="row1" width="38%">{l_mod_gender}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="mod_gender" value="1" {mod_gender_yes} {desactive_gender}>
		{L_NO}<input type="radio" name="mod_gender" value="0" {mod_gender_no}  {desactive_gender}>
	</td>
</tr>
<!-- point system ?  -->
<tr> 
	<td class="row1" width="38%">{l_mod_point_system}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="mod_point_system" value="1" {mod_point_system_yes} {desactive_point}>
		{L_NO}<input type="radio" name="mod_point_system" value="0" {mod_point_system_no} {desactive_point}>
	</td>
</tr>
<!-- Utiliser les popup pour le profile ? -->
<tr> 
	<td class="row1" width="38%">{l_popup_prodile}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="mod_profile" value="1" {mod_profile_yes}>
		{L_NO}<input type="radio" name="mod_profile" value="0" {mod_profile_no}>
	</td>
</tr>
<!-- Faire défiler les topics récents?  -->
<tr> 
	<td class="row1" width="38%">{defiler_topics_recents}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="defiler_topics_recents" value="1" {defiler_topics_recents_yes}>
		{L_NO}<input type="radio" name="defiler_topics_recents" value="0" {defiler_topics_recents_no}>
	</td>
</tr>
<!-- nombre de topics recents  -->
<tr> 
	<td class="row1" width="38%">{l_nbre_topics_recents}<br /></td>
	<td class="row2" width="62%"><input type="text" name="nbre_topics_recents" value="{nbre_topics_recents}" />
	</td>
</tr>
<!-- sondage à afficher sur le portail ?  -->
<tr> 
	<td class="row1" width="38%">{l_sondage}<br /></td>
	<td class="row2" width="62%"> 
		<select name="id_sondage">
			{liste_poll}
		</select>
	</td>
</tr>

<tr> 
<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" class="button" />
<input type="hidden" name="action" value="enregistrer" />
</td>
</tr>

</table>
</form>
<br clear="all" />