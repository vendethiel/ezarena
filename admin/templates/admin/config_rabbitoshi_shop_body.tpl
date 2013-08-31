<h1>{L_RABBITOSHI_TITLE}</h1>

<P>{L_RABBITOSHI_TEXT}</p>

<!-- BEGIN list -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_PRICE}</th>
		<th class="thTop">{L_DESC}</th>
		<th class="thTop">{L_TYPE}</th>
		<th class="thTop">{L_POWER}</th>
		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN rabbitoshi_shop -->
	<tr>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center">{list.rabbitoshi_shop.NAME}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center"><img src="../images/Rabbitoshi/{list.rabbitoshi_shop.IMG}" alt="{list.rabbitoshi_shop.NAME}" /></td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center">{list.rabbitoshi_shop.PRICE}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center">{list.rabbitoshi_shop.DESC}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center">{list.rabbitoshi_shop.TYPE}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center">{list.rabbitoshi_shop.POWER}</td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center"><a href="{list.rabbitoshi_shop.U_RABBITOSHI_EDIT}">{L_EDIT}</a></td>
		<td class="{list.rabbitoshi_shop.ROW_CLASS}" align="center"><a href="{list.rabbitoshi_shop.U_RABBITOSHI_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END rabbitoshi_shop -->
	<tr>
		<td class="catBottom" colspan="8" align="center"><input class="mainoption" type="submit" value="{L_ADD}" name="add" /></td>
	</tr>
<!-- END list -->

<!-- BEGIN edit -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<td class="row2">{L_ITEM_NAME}<br /><span class="gensmall">{L_ITEM_NAME_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="item_name" value="{ITEM_NAME}" size="30" maxlength="255" /><br /><span class="gensmall">{ITEM_NAME_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_IMG}<br /><span class="gensmall">{L_ITEM_IMG_EXPLAIN}</span></td>
		<td class="row1"><input type="text" name="item_img"  value="{ITEM_IMG}" size="30" maxlength="255"/><br /><img src="../images/Rabbitoshi/{ITEM_IMG}" alt="{ITEM_NAME}" /></td>
	</tr>
	<tr>
		<td class="row2">{L_ITEM_PRIZE}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="item_prize"  value="{ITEM_PRIZE}" size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DESC}<br /><span class="gensmall">{L_ITEM_DESC_EXPLAIN}</span></td>
		<td class="row1" width="60%" align="left"><input type="text" name="item_desc"  value="{ITEM_DESC}" size="100" maxlength="255"/><br /><span class="gensmall">{ITEM_DESC_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row2">{L_ITEM_TYPE}</td>
		<td class="row2" width="60%" align="left"><span class="gensmall">{ITEM_TYPE}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_POWER}<br /><span class="gensmall">{L_ITEM_POWER_EXPLAIN}</span></td>
		<td class="row1" width="60%" align="left"><input type="text" name="item_power"  value="{ITEM_POWER}" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
<!-- END edit -->

<!-- BEGIN add -->
<form method="post" action="{S_RABBITOSHI_ACTION}">
<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="100%">
	<tr>
		<td class="row2">{L_ITEM_NAME}<br /><span class="gensmall">{L_ITEM_NAME_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="item_name" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_IMG}<br /><span class="gensmall">{L_ITEM_IMG_EXPLAIN}</span></td>
		<td class="row1"><input type="text" name="item_img" size="30" maxlength="255"/></td>
	</tr>
	<tr>
		<td class="row2">{L_ITEM_PRIZE}</td>
		<td class="row2" width="60%" align="left"><input type="text" name="item_prize"  size="10" maxlength="8"/>&nbsp;{L_POINTS}</td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_DESC}<br /><span class="gensmall">{L_ITEM_DESC_EXPLAIN}</span></td>
		<td class="row1" width="60%" align="left"><input type="text" name="item_desc"  size="100" maxlength="255"/></td>
	</tr>
	<tr>
		<td class="row2">{L_ITEM_TYPE}</td>
		<td class="row2" width="60%" align="left"><span class="gensmall">{ITEM_TYPE}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ITEM_POWER}<br /><span class="gensmall">{L_ITEM_POWER_EXPLAIN}</span></td>
		<td class="row1" width="60%" align="left"><input type="text" name="item_power" size="10" maxlength="8"/></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
<!-- END add -->

</table>
</form>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="95%">
	<tr>
		<td align="center">{L_TRANSLATOR}</td>
	</tr>
</table>

<br clear="all" />