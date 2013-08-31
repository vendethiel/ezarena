<script language="javascript" type="text/javascript">
<!--

function qp_switch(id) {
	if (document.getElementById) {
		if (document.getElementById(id).style.display == "none"){
			document.getElementById(id).style.display = 'block';
		} else {
			document.getElementById(id).style.display = 'none';
		}
	} else {
		if (document.layers) {
			if (document.id.display == "none"){
				document.id.display = 'block';
			} else {
				document.id.display = 'none';
			}
		} else {
			if (document.all.id.style.visibility == "none"){
				document.all.id.style.display = 'block';
			} else {
				document.all.id.style.display = 'none';
			}
		}
	}
}
//-->
</script>
<h1>{L_SQUELETTE}</h1>

<p>{L_EXPLAIN_SQUELETTE}</p>

<form action="" method="post">
<table width="60%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_AJOUT_SQUELETTE}</th>
</tr>
<tr>
	<td class="row1" width="250">{L_AJOUT_EXPLAIN_SQUELETTE}</td>
	<td class="row2"><input type="text" name="titre" size="40" value="" /></td>
</tr>
<tr>
	<td class="row1" width="250">{L_AJOUT_EXPLAIN_PAGE_PHP}</td>
	<td class="row2">
		<select name="pagephp" />
			{LISTING_SALLES}
		</select>
	</td>
</tr>
<tr>
	<td class="cat" height="28" align="center" valign="middle" colspan="2">
		<input type="submit" name="Ajouter" value="{AJOUTER}" />
		<input type="hidden" name="action" value="ajout">
		</form>
		</td>
</tr>
</table>


<!-- BEGIN type_salle -->
<h3>{type_salle.SALLE}</h3>
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<tr>
	<td class="catLeft" height="28"><span class="cattitle">{L_SALLES}</span></td>
	<td class="catLeft" height="28" align="center" width="100"><span class="cattitle">{L_ROOM_ID}</span></td>
	<td class="catLeft" height="28" align="center" width="100"><span class="cattitle">{L_DEFAULT}</span></td>
	<td class="catLeft" height="28" align="center" width="150"><span class="cattitle">{L_EDITION}</span></td>
	<td class="catLeft" height="28" align="center" width="100"><span class="cattitle">{L_GESTION}</span></td>
</tr>
<!-- BEGIN liste_squelettes -->
<form name="salle{type_salle.liste_squelettes.ID_SQUELETTE}" action="" method="post">
<tr>
	<td class="row1" nowrap="nowrap" width="40%">
		<div id="titre{type_salle.liste_squelettes.ID_SQUELETTE}" style="display:block;position:relative;">{type_salle.liste_squelettes.TITRE}</div>
		<div id="edit{type_salle.liste_squelettes.ID_SQUELETTE}" style="display:none;position:relative;">
		<input type="text" name="titre" size="40" value="{type_salle.liste_squelettes.TITRE}" onBlur="document.forms.salle{type_salle.liste_squelettes.ID_SQUELETTE}.submit();" /></div>
	</td>
	<td>
		<a href="{type_salle.liste_squelettes.U_HREF}">{type_salle.liste_squelettes.ID}</a>
	</td>
	<td class="row2" align="center" width="130">{type_salle.liste_squelettes.DEFAUT}</td>
	<td class="row2" align="center" nowrap="nowrap">
		<a href="{type_salle.liste_squelettes.EDITER}"><img src="{I_FEUILLES}" border="0"></a>&nbsp;&nbsp;
		<a href="{type_salle.liste_squelettes.BLOCS}"><img src="{I_BLOCS}" border="0"></a>&nbsp;&nbsp;
		<a href="javascript:qp_switch('droits{type_salle.liste_squelettes.ID_SQUELETTE}');"><img src="{I_ACCES}" border="0"></a>&nbsp;&nbsp;
	</td>
	<td class="row2" align="center" width="150">
		<a href="{type_salle.liste_squelettes.DOWN}"><img src="{I_DOWN}" border="0"></a>
		<a href="{type_salle.liste_squelettes.UP}"><img src="{I_UP}" border="0"></a>
		<a href="javascript:qp_switch('edit{type_salle.liste_squelettes.ID_SQUELETTE}');qp_switch('titre{type_salle.liste_squelettes.ID_SQUELETTE}');">
		<img src="{I_EDIT}" border="0"></a>&nbsp;&nbsp;
		<a href="{type_salle.liste_squelettes.SUPPRIMER}"><img src="{I_SUPP}" border="0"></a>
	</td>
</tr>
<input type="hidden" name="id_squelette" value="{type_salle.liste_squelettes.ID_SQUELETTE}">
<input type="hidden" name="action" value="edit">
</form>
<!-- END liste_squelettes -->
</table>
<!-- END type_salle -->
<br />
<!-- BEGIN salles -->
<div id="droits{salles.ID_SALLE}" style="display:none;position:absolute;top:50%;left:150px;z-index:2000;">
<form action="" method="post">
<table width="50%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="3" height="25" valign="middle" nowrap="nowrap"><a href="javascript:qp_switch('droits{salles.ID_SALLE}');"><img src="../../images/icon_close.gif" border="0" align="right"></a>{salles.TITRE_SALLE}</th>
</tr>
<tr>
	<td class="row1" align="center"><span class="genmed">{L_PRIS}:</span><br /><br />	
		<select name="pris[]" style="height:100px;width:250px;" multiple>{salles.PRIS}</select><br /><br />
	<input type="submit" name="envoyer" value="{L_ENREGISTRER}" />
	
	</td>
</tr>
<input type="hidden" name="id_squelette" value="{salles.ID_SALLE}" />
<input type="hidden" name="action" value="droits" />
</table>
</form>
</div>
<!-- END salles -->
<br /><br />