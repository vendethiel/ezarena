
<br clear="all" />


<!-- BEGIN view_recipes -->
<br />
<form method="post" name="list_recipes" action="{S_RECIPEBOOK_ACTION}">
<table class="forumline" height="" cellspacing="2" cellpadding="2" border="1" align="center" width="70%">
  <tr>
    <th colspan="{RECIPEBOOK_SKILL_COUNT}">
      {L_ADR_RECIPEBOOK}
    </th>
  </tr>
  <tr>
    {RECIPEBOOK_SKILL_LINKS}
  </tr>
  <tr>
    <td valign="top" width="100%" class="row1" colspan="{RECIPEBOOK_SKILL_COUNT}">{RECIPE_LIST}</td>
  </tr>
</table>
<table class="forumline" height="" cellspacing="2" cellpadding="2" border="1" align="center" width="70%">
  <!-- BEGIN recipe -->
	<tr>
		<td valign="top" width="35%">
			<table cellspacing="2" cellpadding="2" border="0" align="center">
				<tr>
						<table width="100%" cellspacing="2" cellpadding="2" border="0">
							<tr>
								<td colspan="2" width="100%">
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
									<strong>Objets :</strong>
									<br />
									{view_recipes.recipe.RECIPE_ITEMS_REQ}
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:'serif'">
									<br />
									<strong>{L_RECIPE_STATS}</strong>
									<br />
									<table border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td style="font-family:'serif'" valign="top">Recipe Level:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_LEVEL}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" valign="top">Description:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_DESC}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" valign="top">Price:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_PRICE}</td>
										</tr>
										<tr>
											<td style="font-family:'serif'" valign="top">Weight:</td>
											<td style="font-family:'serif'">{view_recipes.recipe.RECIPE_WEIGHT}</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td width="35%" valign="top" style="font-family:'serif'">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><img src="adr/images/items/{view_recipes.recipe.RESULT_IMG}"></td>
								<td style="font-family:'serif'"><strong>{view_recipes.recipe.RESULT_NAME}</strong></td>
							</tr>
						</table>
						<br />
							<strong>{L_PRODUCT_EFFECTS}</strong>
						<br />
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
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
					</td>
				</tr>
			</table>
		</td>
	</tr>
  <!-- END recipe -->
</table>
</form>
<!-- END view_recipes -->
