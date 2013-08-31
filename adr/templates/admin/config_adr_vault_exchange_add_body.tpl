<!-- BEGIN exchange_add -->
<h1>{L_VAULT_EXCHANGE_ADD_SETTINGS}</h1>
<p>{L_VAULT_EXCHANGE_ADD_SETTINGS_EXPLAIN}</p>
<!-- END exchange_add -->

<!-- BEGIN exchange_edit -->
<h1>{L_VAULT_EXCHANGE_EDIT_SETTINGS}</h1>
<p>{L_VAULT_EXCHANGE_EDIT_SETTINGS_EXPLAIN}</p>
<!-- END exchange_edit -->

<form action="{S_VAULT_ACTION}" method="post">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="80%">
	<tr>
		<!-- BEGIN exchange_add -->
		<td class="catHead" colspan="6" align="center">{L_STOCK_EXCHANGE_ACTIONS_ADD}</td>
		<!-- END exchange_add -->
		<!-- BEGIN exchange_edit -->
		<td class="catHead" colspan="6" align="center">{L_STOCK_EXCHANGE_ACTIONS_EDIT}</td>
		<!-- END exchange_edit -->
	</tr>
	<tr>
		<td class="row2">{L_STOCK_NAME}</td>
		<td class="row2"><input type="text" name="stock_name" value="{STOCK_NAME}" size="30" maxlength="40" /></td>
	</tr>
	<tr>
		<td class="row2">{L_STOCK_DESC}</td>
		<td class="row2"><input type="text" name="stock_desc" value="{STOCK_DESC}" size="100" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row2">{L_STOCK_AMOUNT}</td>
		<td class="row2"><input type="text" name="stock_price" value="{STOCK_AMOUNT}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="6" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

</form>

<br clear="all" />


