
<br clear="all" />

<!-- BEGIN main -->
<br />
<form method="post" action="{S_RECIPEBOOK_ACTION}">
<h1><center>Select Patterns to View</center></h1>
<table width="810" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td>{RECIPEBOOK_SKILL_LINKS}</td>
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

<!-- BEGIN view_recipes -->
<br />
<form method="post" name="list_recipes" action="{S_RECIPEBOOK_ACTION}">
<h1><center>Select Patterns to View</center></h1>
<table width="810" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td>{RECIPEBOOK_SKILL_LINKS}</td>
	</tr>
</table>
<table width="823" height="533" background="adr/images/misc/recipebook.gif" style="background-repeat:no-repeat;" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td valign="top">
			<table width="823" cellspacing="2" cellpadding="2" border="0" align="center">
				<tr>
					<td width="55"></td>
					<td width="320" valign="top">{RECIPE_LIST}<br />
						<!-- BEGIN recipe -->
						<table witdh="320" cellspacing="2" cellpadding="2" border="0">
							<tr>
								<td colspan="2" width="320">
									<table border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><img src="adr/images/items/{view_recipes.recipe.RECIPE_IMG}"></td>
											<td style="font-family:'serif'"><strong>{view_recipes.recipe.RECIPE_NAME}</strong></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:'serif'">
									<strong>Items Required:</strong>
									<br />
									{view_recipes.recipe.RECIPE_ITEMS_REQ}
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:'serif'">
									<br />
									<strong>{L_RECIPE_STATS}</strong>
									<br />
									<table border="0" width="320" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Recipe Level:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_LEVEL}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Description:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_DESC}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Price:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_PRICE}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" width="180" valign="top">Weight:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_WEIGHT}</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END recipe -->
					</td>
					<td width="50">&nbsp;</td>
					<td width="340" valign="top" style="font-family:'serif'">
						<!-- BEGIN recipe -->
						<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><img src="adr/images/items/{view_recipes.recipe.RESULT_IMG}"></td>
								<td style="font-family:'serif'"><strong>{view_recipes.recipe.RESULT_NAME}</strong></td>
							</tr>
						</table>
						<br />
							<strong>{L_PRODUCT_EFFECTS}</strong>
						<br />
						<table border="0" width="340" cellspacing="0" cellpadding="0">
							<tr>
								<td style="font-family:'serif';font-size:12px;" colspan="2">
									{view_recipes.recipe.RESULT_EFFECTS}
								</td>
							</tr>
						</table>
						<br />
							<strong>{L_PRODUCT_STATS}</strong>
						<br />
						<table border="0" width="340" cellspacing="0" cellpadding="0">
							<tr>
								<td style="font-family:'serif'" width="180">Level:</td>
								<td style="font-family:'serif'">{view_recipes.recipe.RESULT_LEVEL}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180">Description:</td>
								<td style="font-family:'serif'">{view_recipes.recipe.RESULT_DESC}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Price:</td>
								<td style="font-family:'serif'">{view_recipes.recipe.RESULT_PRICE}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Weight:</td>
								<td style="font-family:'serif'">{view_recipes.recipe.RESULT_WEIGHT}</td>
							</tr>
							<tr>
								<td style="font-family:'serif'" width="180" valign="top">Duration:</td>
								<td style="font-family:'serif'">{view_recipes.recipe.RESULT_DURATION} / {view_recipes.recipe.RESULT_DURATION_MAX}</td>
							</tr>
						</table>
						<!-- END recipe -->
					</td>
					<td width="60"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<!-- END view_recipes -->

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">ADR Recipebook written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />
