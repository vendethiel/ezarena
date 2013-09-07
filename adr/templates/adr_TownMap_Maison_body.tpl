<form method="post" action="{S_CHARACTER_ACTION}">
<br />
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_TOWNMAP_MAISON}</td>
	</tr>
	<tr>
		<td align="center" class="row1" width="15%" >
			<span class="gen"><img src="adr/images/TownMap/{SAISON}/Icone_Maison.gif " alt="{L_TOWNMAP_MAISON}" /><br /><br />{L_MAISONENTREE}<br /><br /><img src="adr/images/TownMap/paladin.gif" /><br /><br />{L_MAISONPRESENTATION} :<br /><br /><input type="submit" name="InfoMaison" value="{L_TOWNBOUTONINFO}" class="mainoption" /><br /><br /></span>
		</td>
        <td align="center" class="row2" width="25%" valign="top"><span class="gen">
        	{L_MAISONFEUILLEPERSO}<br /><br/><a href="{U_MAISONFEUILLEPERSO}"><img src="adr/images/TownMap/FeuillePerso.gif " alt="{L_MAISONFEUILLEPERSO}" /></a><br /><br/><br />{L_MAISONINVENTAIRE}<br /><br/><a href="adr_character_inventory.php"><img src="adr/images/TownMap/PersoListe.gif" /></a><br /><br /><br/>{L_MAISONCOMPETENCE}<br /><br/>
            <a href="{U_MAISONCOMPETENCE}"><img src="adr/images/TownMap/Competence.gif" alt="{L_MAISONCOMPETENCE}" /></a><br/><br /><br/>{L_ADR_SPELL_LIST}<br/><br/>
        	<a href="adr_character_inventory_spells.php"><img src="adr/images/TownMap/Inventaire.gif" alt="{L_MAISONINVENTAIRE}" /></a><br /><br /><br />{L_MAISONEQUIPEMENT}<br /><br/><a href="{U_MAISONEQUIPEMENT}"><img src="adr/images/TownMap/Equipement.gif " alt="{L_MAISONEQUIPEMENT}" /></a></span></a>
        </td>
        <td align="center" class="row2" width="25%" valign="top">
        	<span class="gen">
            {L_QUESTBOOK}<br /><br/><a href="{U_QUESTBOOK}"><img src="adr/images/TownMap/PersoListe.gif " alt="{L_MAISONINVENTAIRE}" /></a><br /><br /><br/>{L_ADR_RECIPES_LIST}<br/><br/><a href="{U_RECIPES}"><img src="adr/images/TownMap/Inventaire.gif" alt="{L_MAISONPERSOLISTE}" /></a><br/><br/><br/>{L_ADR_DUEL_LIST}<br /><br /><a href="{U_DUELS}"><img src="adr/images/TownMap/PersoListe.gif " alt="{L_MAISONPERSOLISTE}" /></a><br /><br /><br />{L_MAISONPREFERENCE}<br /><br /><a href="{U_MAISONPREFERENCE}"><img src="adr/images/TownMap/Preference.gif " alt="{L_MAISONPREFERENCE}" /></a><br /><br /><br />{L_MAISONPERSOLISTE}<br /><br /><a href="{U_MAISONPERSOLISTE}"><img src="adr/images/TownMap/PersoListe.gif " alt="{L_MAISONPERSOLISTE}" /></a></span>
       	</td>
	</tr>
</table>

</form>

<br clear="all" />