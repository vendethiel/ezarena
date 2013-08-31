<div class="maintitle">{L_GENERAL_LIENS_ADMIN}</div>
<br />
<p>{L_GENERAL_LIENS_ADMIN_EXP}</p>
<table width="100%">
<tr><td width="40%" valign="top">
	<form action="" method="post">
	<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
	<tr> 
	<th colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr> 
		<td class="row1" width="38%">{L_NBRE_LIENS}</td>
		<td class="row2" width="62%"> 
			<input type="text" name="liens_nbre_liens" size="4" value="{NBRE_LIENS}" />
		</td>
	</tr>
	<tr> 
		<td class="row1" width="38%">{L_ALEATOIRE}</td>
		<td class="row2" width="62%"> 
			{L_YES}<input type="radio" name="liens_aleatoire" value="1" {ALEA_YES}>
			{L_NO}<input type="radio" name="liens_aleatoire" value="0" {ALEA_NO}>
		</td>
	</tr>
	<tr>
		<td class="row1" width="38%">{L_SCROLL}</td>
		<td class="row2" width="62%"> 
			{L_YES}<input type="radio" name="liens_scroll" value="1" {SCROLL_YES}>
			{L_NO}<input type="radio" name="liens_scroll" value="0" {SCROLL_NO}>
		</td>
	</tr>
	<tr>
		<td class="row1" width="38%">{L_CACHE}</td>
		<td class="row2" width="62%"> 
			{L_YES}<input type="radio" name="liens_cache" value="1" {CACHE_YES}>
			{L_NO}<input type="radio" name="liens_cache" value="0" {CACHE_NO}>
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
			<form action="" method="post">
			<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
		<tr> 
		<th colspan="2">{L_AJOUTER_LIEN}</th>
		</tr>
		<tr> 
			<td class="row1" width="38%">{L_TITRE}</td>
			<td class="row2" width="62%"> 
				<input type="text" name="titre" size="40" value="{TITRE}" />
			</td>
		</tr>
		<tr> 
			<td class="row1" width="38%">{L_URL_LIEN}</td>
			<td class="row2" width="62%"> 
				<input type="text" name="url" size="40" value="{LIEN}" />
			</td>
		</tr>
		<tr> 
			<td class="row1" width="38%">{L_IMG_LIEN}</td>
			<td class="row2" width="62%"> 
				<input type="text" name="image" size="40" value="{IMAGE}" />
				<center>{APERCU_IMAGE}</center>
			</td>
		</tr>
		<tr> 
		<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		{HIDDEN}
		</td>
		</tr>
		</table>
		</form>
</td><td width="60%" valign="top">
		<table width="100%" cellpadding="2" cellspacing="1" border="0" align="center" class="forumline">	
		<tr> 
			<th colspan="4">{L_LISTE_LIENS}</th>
		</tr>
		<tr>
			<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_T_TITRE}</span></td>
			<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_T_IMAGE}</span></td>
			<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_GERER}</span></td>
		</tr>
		<!-- BEGIN liens -->
		  <tr>
		  	<td class="row1"><span class="cattitle">{liens.TITRE}</span><br />{liens.LIEN}</td>
		  	<td class="row2" align="center"><span class="genmed">{liens.IMAGE}</span></td>
		  	<td class="row2" nowrap="nowrap"  width="140"><span class="genmed">
		  		<a href="{liens.DESCENDRE}" alt=""><img src="{I_DOWN}" alt="{L_DOWN}" title="{L_DOWN}" border="0"></a>
		  		<a href="{liens.MONTER}" alt=""><img src="{I_UP}" alt="{L_UP}" title="{L_UP}" border="0"></a>
				<a href="{liens.EDITER}" alt=""><img src="{I_EDIT}" alt="{L_EDIT}" title="{L_EDIT}" border="0"></a>
		  		<a href="{liens.SUPPR}" alt=""><img src="{I_SUPP}" alt="{L_DELETE}" title="{L_DELETE}" border="0"></a>
		  	</span></td>
		  </tr>
		  <!-- END liens -->
		</table>
</td></tr></table>
<br />