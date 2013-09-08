
<form method="post" action="{S_ITEMS_ACTION}">

<h1>{L_ITEMS_TITLE}</h1>

<p>{L_ITEMS_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_name" value="{ITEM_NAME}" size="30" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{ITEM_NAME_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="item_desc" value="{ITEM_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{ITEM_DESC_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN add -->
		<td class="row2" align="center" ><input type="text" name="item_img" size="30" maxlength="255" /></td>
	<!-- END add -->
	<!-- BEGIN edit -->
		<td class="row2" align="center" ><input type="text" name="item_img" value="{ITEM_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/store/{ITEM_IMG}" alt="{ITEM_NAME}" /></td>
	<!-- END edit -->
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_ITEM_STATUS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="item_status" value="1" {ITEM_STATUS_CHECKED} />{L_OPEN}&nbsp;<input type="radio" name="item_status" value="0" {NO_ITEM_STATUS_CHECKED} />{L_CLOSED}</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_ITEM_SALES}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="item_sales" value="1" {ITEM_SALES_CHECKED} />{L_SALE}&nbsp;<input type="radio" name="item_sales" value="0" {NO_ITEM_SALES_CHECKED} />{L_NORMAL}</td>
	</tr>
	<tr>
		<td class="row1" width="60%" >{L_ZONE_STORE_LIST}<br \>{L_ZONE_STORE_LIST_EXPLAIN}</td>
		<td class="row2" align="center" colspan="2"><span class="gen">{ZONE_STORE_LIST}</span></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>