<h1>{L_RABBITOSHI_TITLE}</h1>

<P>{L_RABBITOSHI_TEXT}</p>

<form method="post" action="{S_RABBITOSHI_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_PRICE}</th>
		<th class="thTop">{L_RHEALTH}</th>
		<th class="thTop">{L_RFOOD}</th>
		<th class="thTop">{L_RTHIRST}</th>
		<th class="thTop">{L_RDIRT}</th>
		<th class="thTop">{L_MP}</th>
		<th class="thTop">{L_POWER}</th>
		<th class="thTop">{L_MAGICPOWER}</th>
		<th class="thTop">{L_ARMOR}</th>
		<th class="thTop">{L_ATTACK}</th>
		<th class="thTop">{L_MAGICATTACK}</th>
		<th class="thTop">{L_EXPERIENCE}</th>
		<th class="thTop">{L_FOOD_TYPE}</th>
		<th class="thTop">{L_EVOLUTION}</th>
		<th class="thTop">{L_BUYABLE}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN rabbitoshi -->
	<tr>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.NAME}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center"><img src="../images/Rabbitoshi/{rabbitoshi.IMG}" alt="{rabbitoshi.NAME}" /></td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.PRICE}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.RHEALTH}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.RFOOD}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.RTHIRST}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.RDIRT}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.MP}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.POWER}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.MAGICPOWER}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.ARMOR}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.ATTACK}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.MAGICATTACK}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.EXPERIENCE}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.FOOD_TYPE}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.EVOLUTION}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center">{rabbitoshi.BUYABLE}</td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center"><a href="{rabbitoshi.U_RABBITOSHI_EDIT}">{L_EDIT}</a></td>
		<td class="{rabbitoshi.ROW_CLASS}" align="center"><a href="{rabbitoshi.U_RABBITOSHI_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END rabbitoshi -->
	<tr>
		<td class="catBottom" colspan="19" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_RABBITOSHI_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="95%">
	<tr>
		<td align="center">{L_TRANSLATOR}</td>
	</tr>
</table>

<br clear="all" />