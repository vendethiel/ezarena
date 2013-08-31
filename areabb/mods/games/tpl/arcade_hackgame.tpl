<div class="maintitle">{L_HACKGAME_TITLE}</div>
<br />
<p>{L_HACKGAME_TITLE_EXPLAIN}</p>
<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
	<th colspan="2">{L_JEU}</th>
	<th>{L_JOUEUR}</th>
	<th>{L_DATE_HACK}</th>
	<th>{L_TPS_SRV}</th>
	<th>{L_TPS_FSH}</th>
	<th>{L_SCORE}</th>
	<th>{L_TYPE}</th>
	<th>{L_ACTIONS_HACK}</th>
</tr>
<!-- BEGIN no_tricheurs -->
<tr>
	<td class="row1" colspan="9"><span class="genmed">{L_NO_TRICHEUR}</span></td>
</tr>
<!-- END no_tricheurs -->
<!-- BEGIN tricheurs -->
<form action="" method="post">
<tr>
	<td class="row1" align="center" width="30"><img src="{tricheurs.ICONE}" border="0" width="30" align="left" /></td>
	<td class="row1" align="center" width="120"><span class="genmed">{tricheurs.GAME}</span></td>
	<td class="row1" align="center" width="120"><span class="genmed">{tricheurs.USERNAME}</span></td>
	<td class="row1" align="right" width="120"><span class="genmed">{tricheurs.DATE}</span></td>
	<td class="row1" align="center" width="50"><span class="genmed">{tricheurs.TPS_SRV}</span></td>
	<td class="row1" align="center" width="50"><span class="genmed">{tricheurs.TPS_FSH}</span></td>
	<td class="row1" align="center" width="50"><span class="genmed">{tricheurs.SCORE}</span></td>
	<td class="row1" align="center" width="100">
	<!-- BEGIN robot -->
	<img src="{I_ROBOT}" alt="{L_TYPE_ROBOT}" title="{L_TYPE_ROBOT}" align="left" border="0" />
	<!-- END robot -->
	<!-- BEGIN modo -->
	<img src="{I_MODO}" alt="{L_TYPE_MODO}" title="{L_TYPE_MODO}" align="left"  border="0" />
	<!-- END modo -->
	<span class="genmed">{tricheurs.TYPE}</span></td>
	<td class="row2" align="center" width="200"><span class="genmed">
			<select name="action">
				<option value="supprimer">{L_SUPPRIMER_HACK}</option>
				<option value="retablir">{L_RETABLIR_SCORE}</option>
				<option value="bannir">{L_BANNIR}</option>
			</select>
			<input type="submit" name="reagir" value="OK" />
			</span>
	</td>
</tr>
<input type="hidden" name="id_hack" value="{tricheurs.ID_HACK}" />
</form>
<!-- END tricheurs -->
</table>
<br />
<table width="50%" cellpadding="3" cellspacing="1" border="0" align="right" class="forumline">
<tr> 
	<th colspan="2">{Information}</th>
</tr>
<tr>
	<td class="row1"><img src="{I_ROBOT}" border="0" /></td><td class="row2"><span class="gensmall">{L_TYPE_ROBOT}</span></td>
</tr>
<tr>
	<td class="row1"><img src="{I_MODO}" border="0" /></td><td class="row2"><span class="gensmall">{L_TYPE_MODO}</span></td>
</tr>
</table>
<br clear="all">
<br />