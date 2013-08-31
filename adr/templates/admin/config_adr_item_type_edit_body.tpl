<form method="post" action="{S_ITEM_TYPE_ACTION}">

<h1>{L_ITEM_TYPE_TITLE}</h1>

<p>{L_ITEM_TYPE_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_type_name" value="{ITEM_TYPE_NAME}" size="30" maxlength="255" />
	<!-- BEGIN item_type_edit -->
		<br /><span class="gensmall">{ITEM_TYPE_NAME_EXPLAIN}</span>
	<!-- END item_type_edit -->
		</td>
	</tr>
	<!-- BEGIN item_type_new -->
	<tr>
		<td class="row1" width="60%">{L_ID}<br /><span class="gensmall">{L_ID_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_type_id" value="" size="30" maxlength="255" />
		<br /><span class="gensmall">{ITEM_TYPE_ID_EXPLAIN}</span>
		</td>
	</tr>
	<!-- END item_type_new -->
	<!-- BEGIN item_type_edit -->
	<tr>
		<td class="row1" width="60%">{L_ID}<br /><span class="gensmall">{L_ID_EXPLAIN}</span></td>
		<td class="row2" align="center" >{ITEM_TYPE_ID}</td>
	</tr>
	<!-- END item_type_edit -->
	<tr>
		<td class="row1" width="60%">{L_PRICE}<br /><span class="gensmall">{L_PRICE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_type_price" value="{ITEM_TYPE_PRICE}" size="30" maxlength="255" />
	<!-- BEGIN item_type_edit -->
		<br /><span class="gensmall">{ITEM_TYPE_PRICE_EXPLAIN}</span>
	<!-- END item_type_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_CATEGORY}<br /><span class="gensmall">{L_CATEGORY_EXPLAIN}</span></td>
		<td class="row2" align="center" >{CATEGORY} <input type="text" name="new_category" size="30" maxlength="50" />
	<!-- BEGIN item_type_edit -->
		<br /><span class="gensmall">{ITEM_TYPE_CATEGORY_EXPLAIN}</span>
	<!-- END item_type_edit -->
		</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>
