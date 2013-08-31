<h1>{L_FEUILLE}</h1>
<p>{L_EXPLAIN_FEUILLE}</p><br />
<center>{MESSAGE}</center>
<form action="" method="post">
<table width="60%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_AJOUT_FEUILLE}</th>
</tr>
<tr>
	<td class="row2" colspan="2" align="center">{SELECT}&nbsp;<input type="submit" name="Ajouter" value="{AJOUTER}" />
		<input type="hidden" name="action" value="ajout">
		<input type="hidden" name="id_squelette" value="{ID_SQUELETTE}">
		</form>
	</td>
</tr>
<tr>
	<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_LISTE}</th>
</tr>
<!-- BEGIN liste_feuilles -->
<tr>
 <td class="row1">{liste_feuilles.TITRE}</td>
 <td class="row2" width="100" align="center" valign="middle">
	 <a href="{liste_feuilles.MONTER}"><img src="{I_UP}" border="0"></a>&nbsp;
	 <a href="{liste_feuilles.DESCENDRE}"><img src="{I_DOWN}" border="0"></a>&nbsp;
	 <a href="{liste_feuilles.SUPPRIMER}"><img src="{I_SUPP}" border="0"></a>
 </td>
</tr>
<!-- END liste_feuilles -->
</table>
<br />