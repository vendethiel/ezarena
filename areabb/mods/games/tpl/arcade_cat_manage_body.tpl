<h1>{L_TITLE}</h1>
<p>{L_EXPLAIN}</p>
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<!-- BEGIN salle -->
<tr>
	<th class="thTop" height="25" colspan="4" valign="middle" nowrap="nowrap">{salle.TITRE_SALLE}</th>
</tr>
<tr>
	<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_DESCRIPTION}</span></th>
	<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_NBRE_JEUX}</span></th>
	<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_DEPLACE}</span></th>
	<td class="cat" height="25" valign="middle" nowrap="nowrap" align="center"><span class="cattitle">{L_ACTION}</span></th>
</tr>
<!-- BEGIN arcade_catrow -->
<tr>
 <td class="row1" width="50%">{salle.arcade_catrow.ICONE}{salle.arcade_catrow.ARCADE_CATTITLE}</td>
 <td class="row2" width="20px" align="center">{salle.arcade_catrow.ARCADE_CAT_NBELMT}</td>
 <td class="row1" width="30px" align="center">
	 <a href="{salle.arcade_catrow.U_UP}"><img src="{I_UP}" alt="{L_UP}" title="{L_UP}" border="0"></a>
	 <a href="{salle.arcade_catrow.U_DOWN}"><img src="{I_DOWN}" alt="{L_DOWN}" title="{L_DOWN}" border="0"></a>
 </td>
 <td class="row1" align="center" width="150px">
	 <a href="{salle.arcade_catrow.U_EDIT}"><img src="{I_EDIT}" alt="{L_EDIT}" title="{L_EDIT}" border="0"></a>
	 <a href="{salle.arcade_catrow.U_MANAGE}"><img src="{I_GERER}" alt="{L_MANAGE}" title="{L_MANAGE}" border="0"></a>
	 <a href="{salle.arcade_catrow.U_DELETE}"><img src="{I_SUPP}" alt="{L_DELETE}" title="{L_DELETE}" border="0"></a>
	 
 </td>
</tr>
<!-- END arcade_catrow -->
<tr>
	<td colspan="4"></td>
</tr>
<!-- END salle -->
<tr>
	<td class="row1" colspan="3"><b>{ARCADE_CATTITLE}</b></td>
	<td class="row2" align="center"><a href="{U_MANAGE}"><img src="{I_GERER}" alt="{L_MANAGE}" title="{L_MANAGE}" border="0"></a>
	<a href="{U_SYNCHRO}"><img src="{I_SYNC}" alt="{L_SYNCHRO}" title="{L_SYNCHRO}" border="0"></a></td>
</tr>
<form action="{S_ACTION}" method="post">{S_HIDDEN_FIELDS} 
	<tr>
		<td class="cat" height="28" align="center" valign="middle" colspan="7">
		<input type="submit" name="{S_SUBMIT}" value="{L_NEWCAT}" class="mainoption" />
		</td>
	</tr>
</form>
</table>
<br />