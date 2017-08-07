
<br clear="all" />

<br />
<form method="post" name="list_spells" action="{S_SPELLBOOK_ACTION}">
<table class="forumline" height="" cellspacing="2" cellpadding="2" border="1" align="center" width="70%">
  <tr>
    <th colspan="{SPELLBOOK_SKILL_COUNT}">
      {L_ADR_SPELLBOOK}
    </th>
  </tr>
  <tr>
    {SPELLBOOK_SKILL_LINKS}
  </tr>
  <tr>
    <td valign="top" width="100%" class="row1" colspan="{SPELLBOOK_SKILL_COUNT}">{SPELL_LIST}</td>
  </tr>
</table>

<!-- BEGIN view_spells -->
<!-- BEGIN spell -->
<br />
<table width="823" height="533" class="forumline" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td valign="top" width="35%">
			<table cellspacing="2" cellpadding="2" border="0" align="center">
				<tr>
						<table width="100%" cellspacing="2" cellpadding="2" border="0">
							<tr>
								<td colspan="2" width="100%">
									<table border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><img src="adr/images/items/{view_spells.spell.RECIPE_IMG}"></td>
											<td style="font-family:'serif'"><strong>{view_spells.spell.RECIPE_NAME}</strong></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:'serif'">
									<strong>Composants :</strong>
									<br />
									{view_spells.spell.RECIPE_ITEMS_REQ}
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:'serif'">
									<br />
									<strong>Spell Stats</strong>
									<br />
									<table border="0" width="320" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Spell Level:</td>
											<td style="font-family:'serif'">{view_spells.spell.RECIPE_LEVEL}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Spell Skill</td>
											<td style="font-family:'serif'">{L_SPELL_SKILL}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Description:</td>
											<td style="font-family:'serif'">{view_spells.spell.RECIPE_DESC}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Cast:</td>
											<td style="font-family:'serif'">{view_spells.spell.CAST_SPELL}</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END spell -->
					</td>
					<td width="50">&nbsp;</td>
					<td width="340" valign="top" style="font-family:'serif'">
					</td>
					<td width="60"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END spell -->
</form>
<!-- END view_spells -->
