<h1>{L_RABBITOSHI_TITLE}</h1>

<p>{L_RABBITOSHI_TEXT}</p>

<form method="post" action="{S_RABBITOSHI_ACTION}">

<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_PRICE}</th>
		<th class="thTop">{L_RHEALTH}</th>
		<th class="thTop">{L_MP}</th>
		<th class="thTop">{L_EXPERIENCE}</th>
		<th class="thTop">{L_FOOD_TYPE}</th>
		<th class="thTop">{L_EVOLUTION}</th>
		<th class="thTop">{L_BUYABLE}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN rabbitoshi -->
	<tr align="center">
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.NAME}</td>
		<td class="{rabbitoshi.ROW_CLASS}"><img src="../rabbitoshi/images/pets/{rabbitoshi.IMG}" alt="{rabbitoshi.NAME}" /></td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.PRICE}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.RHEALTH}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.MP}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.EXPERIENCE}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.FOOD_TYPE}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.EVOLUTION}</td>
		<td class="{rabbitoshi.ROW_CLASS}">{rabbitoshi.BUYABLE}</td>
		<td class="{rabbitoshi.ROW_CLASS}"><a href="{rabbitoshi.U_RABBITOSHI_EDIT}">{L_EDIT}</a></td>
		<td class="{rabbitoshi.ROW_CLASS}"><a href="{rabbitoshi.U_RABBITOSHI_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END rabbitoshi -->
	<tr>
		<td class="catBottom" colspan="11" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_RABBITOSHI_ADD}" class="mainoption" /></td>
	</tr>
</table>

</form>

<br clear="all" />