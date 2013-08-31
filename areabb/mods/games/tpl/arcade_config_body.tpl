<script src="tpl/dhtmlgoodies_slider.js"></script>
<div class="maintitle">{L_CONFIGURATION_TITLE_ARCADE}</div>
<br />
<p>{L_CONFIGURATION_EXPLAIN_ARCADE}</p>
<form action="" method="post">
<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_GENERAL_SETTINGS}</th>
</tr>
<!-- games_par_page -->
<tr> 
<td class="row1" width="38%">{L_GAMES_PAR_PAGE}<br />
<span class="gensmall">{L_GAMES_PAR_PAGE_EXPLAIN}</span>
</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="100" size="5" name="games_par_page" value="{S_GAMES_PAR_PAGE}" class="post" />
</td>
</tr>
<!-- game_order -->
<tr> 
<td class="row1" width="38%">{L_GAME_ORDER}<br />
<span class="gensmall">{L_GAME_ORDER_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<select name="game_order" class="post" >
{S_GAME_ORDER}
</select>
</td>
</tr>
<!-- mode d'ouverture  -->
<tr> 
	<td class="row1" width="38%">{l_mod_ouvert}<br /></td>
	<td class="row2" width="62%"> 
	<select name="game_popup">
		<option value="0" {ouv_portail}>{l_portail}
		<option value="1" {ouv_popup}>{l_popup}
	</select>
	</td>
</tr>
<!-- pagination  -->
<tr> 
	<td class="row1" width="38%">{l_format_pag}<br /></td>
	<td class="row2" width="62%"> 
	<select name="format_pag">
		<option value="0" {pag_norm}>{l_normal}
		<option value="1" {pag_google}>{l_google}
		<option value="2" {pag_phpbb}>{l_phpbb}
	</select>
	</td>
</tr>
<!-- download ?  -->
<tr> 
	<td class="row1" width="38%">{l_aut_dwld}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="auth_dwld" value="1" {aut_dwld_yes}>
		{L_NO}<input type="radio" name="auth_dwld" value="0" {aut_dwld_no}>
	</td>
</tr>
<!-- chemin sauvegarde jeux -->
<tr> 
	<td class="row1" width="38%">{L_CHEMIN_JEUX}<br /></td>
	<td class="row2" width="62%"> 
		<input type="text" name="chemin_pkg_jeux" value="{chemin_pkg_jeux}">
	</td>
</tr>
<!-- affichage de l'icone de la cat -->
<tr> 
	<td class="row1" width="38%">{l_icone_cat}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="affichage_icone" value="1" {affichage_icone_yes}>
		{L_NO}<input type="radio" name="affichage_icone" value="0" {affichage_icone_no}>
	</td>
</tr>
<!-- affichage du nombre de jeux de la cat -->
<tr> 
	<td class="row1" width="38%">{l_nbre_jeu_cat}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="affichage_nbre_jeux" value="1" {affichage_nbre_jeux_yes}>
		{L_NO}<input type="radio" name="affichage_nbre_jeux" value="0" {affichage_nbre_jeux_no}>
	</td>
</tr>




<tr> 
<th colspan="2">{l_securite}</th>
</tr>
<!-- tolerence de triche  -->
<tr> 
	<td class="row1" width="38%">{l_time_tolerence}</td>
	<td class="row2" width="62%">
	<table><tr><td>
	<div style="width:200px; background-color:white;" id="slider_target"></div>
	</td><td><input type="text" name="games_time_tolerance" value="{time_tolerence}" size="4" align="left" />%
	</td></tr></table>
	</td>
</tr>
</tr>
<!-- groupe VIP actif ?  -->
<tr> 
	<td class="row1" width="38%">{l_group_vip}</td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="group_vip" value="1" {group_vip_yes}>
		{L_NO}<input type="radio" name="group_vip" value="0" {group_vip_no}>
	</td>
</tr>
<!-- nom du groupe VIP   -->
<tr> 
	<td class="row1" width="38%">{l_nom_group_vip}<br /></td>
	<td class="row2" width="62%"> 
			<select name="nom_group_vip">
				{nom_group_vip}
			</select>
	</td>
</tr>
<!-- Faut-il avoir posté ?  -->
<tr> 
	<td class="row1" width="38%">{l_avoir_poste_joue}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="avoir_poste_joue" value="1" {avoir_poste_joue_yes}>
		{L_NO}<input type="radio" name="avoir_poste_joue" value="0" {avoir_poste_joue_no}>
	</td>
</tr>
<!-- nbre de topics -->
<tr> 
	<td class="row1" width="38%">{l_nbre_topics_min}<br /></td>
	<td class="row2" width="62%"> 
		<input type="text" name="nbre_topics_min" value="{nbre_topics_min}">
	</td>
</tr>
<!-- Faut-il s'être présenté -->
<tr> 
	<td class="row1" width="38%">{l_presente}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="presente" value="1" {presente_yes}>
		{L_NO}<input type="radio" name="presente" value="0" {presente_no}>
	</td>
</tr>
<!-- Forum de présentation -->
<tr> 
	<td class="row1" width="38%">{l_forum_presente}<br /></td>
	<td class="row2" width="62%"> 
	<select name="forum_presente">
		{forum_presente}
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
<script type="text/javascript">
form_widget_amount_slider('slider_target',document.forms[0].games_time_tolerance,200,0,100,"");
</script>