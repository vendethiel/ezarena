<form method="post" action="{S_RECIPES_ACTION}">

<h1>{L_RECIPES_TITLE}</h1>

<p>{L_RECIPES_EXPLAIN}</p>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_RECIPES_SELECT_SORT_METHOD}:&nbsp;{S_RECIPES_MODE_SELECT}&nbsp;&nbsp;{L_RECIPES_ORDER}&nbsp;{S_RECIPES_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" value="{L_RECIPES_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_RECIPES_IMG}</th>
		<th align="center">{L_RECIPES_NAME}</th>
		<th align="center">{L_RECIPES_LEVEL}</th>
		<th align="center">{L_RECIPES_DESC}</th>
		<th align="center">{L_RECIPES_EFFECT}</th>
		<th align="center">{L_RECIPES_ITEMS_REQ}</th>
		<th align="center">{L_RECIPES_ADMIN_ONLY}</th>
		<th align="center" colspan="2">{L_RECIPES_ACTION}</a></th>
	</tr>

	<!-- BEGIN recipes -->
	<tr class="gen">
		<td class="{recipes.ROW_CLASS}" align="center"><img src="../adr/images/items/{recipes.RECIPE_IMG}" alt="{recipes.RECIPE_NAME}" /></td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_NAME}</td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_LEVEL}</td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_DESC}</td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_EFFECT}</td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_ITEMS_REQ}</td>
		<td class="{recipes.ROW_CLASS}" align="center">{recipes.RECIPE_ADMIN_ONLY}</td>
		<td class="{recipes.ROW_CLASS}" align="center"><a href="{recipes.U_RECIPE_EDIT}">{L_RECIPES_EDIT}</a></td>
		<td class="{recipes.ROW_CLASS}" align="center"><a href="{recipes.U_RECIPE_DELETE}">{L_RECIPES_DELETE}</a></td>
	</tr>
	<!-- END recipes -->
	</form>
	<form method="post" action="{S_RECIPES_ACTION}">
	<tr>
		<td class="catBottom" colspan="9" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_RECIPES_ADD}" class="mainoption" /></td>
	</tr>
</table>


<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{RECIPES_PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{RECIPES_PAGINATION}</span></td>
	</tr>
</table>
</form>

<div align="center">
	{L_RECIPES_ATTENTION}
</div>

<br clear="all" />

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">ADR Brewing written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />
