
<h1>{L_VAULT_EXCHANGE_SETTINGS}</h1>

<p>{L_VAULT_EXCHANGE_SETTINGS_EXPLAIN}</p>

<form action="{S_VAULT_ACTION}" method="post">

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_EXCHANGE_USE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="use" value="1" {VAULT_EXCHANGE_USE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_EXCHANGE_MIN}</span><br /><span class="gensmall">{L_VAULT_EXCHANGE_MIN_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="min" value="{VAULT_EXCHANGE_MIN}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_EXCHANGE_MAX}</span><br /><span class="gensmall">{L_VAULT_EXCHANGE_MAX_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="max" value="{VAULT_EXCHANGE_MAX}" /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_EXCHANGE_TIME}</span><br /><span class="gensmall">{L_VAULT_EXCHANGE_TIME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="15" name="time" value="{VAULT_EXCHANGE_TIME}" /><br /><span class="gensmall">( {VAULT_EXCHANGE_TIME_EXPLAIN} )</span></td>
	</tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

<br clear="all" />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="80%">
	<tr>
		<td class="catHead" colspan="6" align="center">{L_STOCK_EXCHANGE_ACTIONS}</td>
	</tr>
	<tr>
		<th class="thCornerL">{L_STOCK_NAME}</th>
		<th class="thTop">{L_STOCK_DESC}</th>
		<th class="thTop">{L_STOCK_AMOUNT}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN exchange -->
	<tr>
		<td class="{exchange.ROW_CLASS}" align="center">{exchange.STOCK_NAME}</td>
		<td class="{exchange.ROW_CLASS}" align="center">{exchange.STOCK_DESC}</td>
		<td class="{exchange.ROW_CLASS}" align="center">{exchange.STOCK_AMOUNT}</td>
		<td class="{exchange.ROW_CLASS}" align="center" width="10%"><a href="{exchange.U_STOCK_EDIT}">{L_EDIT}</a></td>
		<td class="{exchange.ROW_CLASS}" align="center" width="10%"><a href="{exchange.U_STOCK_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END exchange -->
	<tr>
		<td class="catBottom" colspan="6" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_STOCK_ADD}" class="mainoption" /></td>
	</tr>
</table>

</form>

<br clear="all" />


