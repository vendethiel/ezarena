<h1>{L_MODS}</h1>
<p>{L_EXPLAIN_MODS}</p>
<center>{MESSAGE}</center>

<form action="" method="post">
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thTop" width="75%" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_AJOUT_MOD}</th>
		<th class="thTop" width="25%" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_VERSION_AREABB}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2" align="center">{L_AJOUT_EXPLAIN_MOD}</td>
		<td class="row1" width="12%" align="center"><span class="forumlink">{L_VERSION_ACTUELLE}</span></td>
		<td class="row1" width="12%" align="center"><span class="forumlink">{L_VERSION_SERVEUR}</span></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center">
			<input type="text" name="url" size="60" value="" />&nbsp;&nbsp;<input type="submit" name="Ajouter" value="{AJOUTER}" />
			<input type="hidden" name="action" value="ajout"></form></td>
		<td class="row2" align="center">{VERSION_ACTUELLE}</td>
		<td class="row2" align="center">{VERSION_SERVEUR}</td>
	</tr>
</table>


<br />
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thTop" colspan="6" height="25" valign="middle" nowrap="nowrap">{L_MODS}</th>
</tr>
<!-- BEGIN mods -->
<tr id="mod-{mods.ID}">
	<td rowspan="2" class="row1" width="40"><img src="{mods.IMAGE}" alt=""></td>
	<td class="cattitle"><b>{mods.TITRE}</b></td>
	<td class="row1" width="30" nowrap="nowrap"><b>{L_AUTEUR}:</b></td>
	<td class="row1" width="100" nowrap="nowrap">{mods.AUTEUR}</td>
	<td rowspan="2" class="row2" width="70">
		<!-- BEGIN supprimer -->
		<b><a href="{mods.SUPPRIMER}"><img src="{I_SUPPRIMER}" alt="" border="0"></a></b>
		<!-- END supprimer -->
		<!-- BEGIN installer -->
		<b><a href="{mods.INSTALLER}"><img src="{I_INSTALLER}" alt="" border="0"></a></b>
		<!-- END installer -->
	</td>
</tr>
<tr>
	<td class="row1">{mods.DESC}</td>
	<td class="row1"><b>{L_VERSION}:</b></td>
	<td class="row1">{mods.VERSION}</td>
</tr>
<!-- END mods -->
</table>
<br />