
<br clear="all" />

<!-- BEGIN main -->
<br />
<form method="post" action="{S_RECIPEBOOK_ACTION}">
<h1><center>Select Spells to View</center></h1>
<table width="810" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center">{RECIPEBOOK_SKILL_LINKS}</td>
	</tr>
</table>
<table width="810" height="528" background="adr/images/misc/recipebook.gif" style="background-repeat:no-repeat;" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td>
		</td>
	</tr>
</table>
</form>
<!-- END main -->

<!-- BEGIN view_spells -->
<br />
<form method="post" name="list_spells" action="{S_RECIPEBOOK_ACTION}">
<h1><center>Select Spells to View</center></h1>
<table width="810" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center">{RECIPEBOOK_SKILL_LINKS}</td>
	</tr>
</table>
<table width="823" height="533" background="adr/images/misc/recipebook.gif" style="background-repeat:no-repeat;" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td valign="top">
			<table width="823" cellspacing="2" cellpadding="2" border="0" align="center">
				<tr>
					<td width="55"></td>
					<td width="320" valign="top">{RECIPE_LIST}<br />
						<!-- BEGIN spell -->
						<table witdh="320" cellspacing="2" cellpadding="2" border="0">
							<tr>
								<td colspan="2" width="320">
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
									<strong>Spell Components Required:</strong>
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
<!--
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Price:</td>
											<td style="font-family:'serif'">{view_spells.spell.RECIPE_PRICE}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Weight:</td>
											<td style="font-family:'serif'">{view_spells.spell.RECIPE_WEIGHT}</td>
										</tr>
-->
									</table>
								</td>
							</tr>
						</table>
						<!-- END spell -->
					</td>
					<td width="50">&nbsp;</td>
					<td width="340" valign="top" style="font-family:'serif'">
						<!-- BEGIN spell -->
<!--
						<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><img src="adr/images/items/{view_spells.spell.RESULT_IMG}"></td>
								<td style="font-family:'serif'"><strong>{view_spells.spell.RESULT_NAME}</strong></td>
							</tr>
						</table>

						<br />
							<strong>Spell Effects</strong>
						<br />
						<table border="0" width="340" cellspacing="0" cellpadding="0">
							<tr>
								<td style="font-family:'serif';font-size:12px;" colspan="2">
									{view_spells.spell.RESULT_EFFECTS}
								</td>
							</tr>
						</table>
						<br />
							<strong>Spell Stats</strong>
						<br />
						<table border="0" width="340" cellspacing="0" cellpadding="0">
							<tr>
								<td style="font-family:'serif'" width="180">Level:</td>
								<td style="font-family:'serif'">{view_spells.spell.RESULT_LEVEL}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180">Description:</td>
								<td style="font-family:'serif'">{view_spells.spell.RESULT_DESC}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" align="center" colspan="2">{view_spells.spell.CAST_SPELL}</td>
							</tr>

							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Price:</td>
								<td style="font-family:'serif'">{view_spells.spell.RESULT_PRICE}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Weight:</td>
								<td style="font-family:'serif'">{view_spells.spell.RESULT_WEIGHT}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Duration:</td>
								<td style="font-family:'serif'">{view_spells.spell.RESULT_DURATION} / {view_spells.spell.RESULT_DURATION_MAX}</td>
							</tr>
						</table>
-->
						<!-- END spell -->
					</td>
					<td width="60"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<!-- END view_spells -->

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">ADR Spellbook written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />
