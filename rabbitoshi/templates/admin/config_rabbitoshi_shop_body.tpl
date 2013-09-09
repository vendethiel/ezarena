<h1>{L_RABBITOSHI_TITLE}</h1>

<p>{L_RABBITOSHI_TEXT}</p>

<!-- BEGIN list -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th>{L_NAME}</th>
		<th>{L_IMG}</th>
		<th>{L_PRICE}</th>
		<th>{L_DESC}</th>
		<th>{L_TYPE}</th>
		<th>{L_POWER}</th>
		<th colspan="2">{L_ACTION}</th>
	</tr>
	<!-- BEGIN rabbitoshi_shop -->
	<tr align="center">
		<td class="{list.rabbitoshi_shop.ROW_CLASS}">{list.rabbitoshi_shop.NAME}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}"><img src="../rabbitoshi/images/items/{list.rabbitoshi_shop.IMG}" alt="{list.rabbitoshi_shop.NAME}" /></td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}">{list.rabbitoshi_shop.PRICE}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}">{list.rabbitoshi_shop.DESC}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}">{list.rabbitoshi_shop.TYPE}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}">{list.rabbitoshi_shop.POWER}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}"><a href="{list.rabbitoshi_shop.U_RABBITOSHI_EDIT}">{L_EDIT}</a></td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}"><a href="{list.rabbitoshi_shop.U_RABBITOSHI_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END rabbitoshi_shop -->
	<tr>
		<td class="catBottom" colspan="8" align="center"><input class="mainoption" type="submit" value="{L_ADD}" name="add" /></td>
	</tr>
<!-- END list -->

<!-- BEGIN edit -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<td class="row1" width="50%">{L_ITEM_NAME}<br /><span class="gensmall">{L_ITEM_NAME_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_name" value="{ITEM_NAME}" size="30" maxlength="255" /><br /><span class="gensmall">{ITEM_NAME_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_IMG}<br /><span class="gensmall">{L_ITEM_IMG_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_img" value="{ITEM_IMG}" size="30" maxlength="255"/><br /><img src="../rabbitoshi/images/items/{ITEM_IMG}" alt="{ITEM_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_PRIZE}</td>
		<td class="row2"><input type="text" class="post" name="item_prize" value="{ITEM_PRIZE}" size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DESC}<br /><span class="gensmall">{L_ITEM_DESC_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_desc"  value="{ITEM_DESC}" size="30" maxlength="255"/><br /><span class="gensmall">{ITEM_DESC_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_TYPE}</td>
		<td class="row2"><span class="gensmall">{ITEM_TYPE}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_POWER}<br /><span class="gensmall">{L_ITEM_POWER_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_power"  value="{ITEM_POWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
<!-- END edit -->

<!-- BEGIN add -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<td class="row1" width="50%">{L_ITEM_NAME}<br /><span class="gensmall">{L_ITEM_NAME_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_name" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_IMG}<br /><span class="gensmall">{L_ITEM_IMG_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_img" size="30" maxlength="255"/></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_PRIZE}</td>
		<td class="row2"><input type="text" class="post" name="item_prize" size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DESC}<br /><span class="gensmall">{L_ITEM_DESC_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_desc" size="30" maxlength="255"/></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_TYPE}</td>
		<td class="row2"><span class="gensmall">{ITEM_TYPE}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_POWER}<br /><span class="gensmall">{L_ITEM_POWER_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" name="item_power" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
<!-- END add -->

</table>
</form>

<br clear="all" />