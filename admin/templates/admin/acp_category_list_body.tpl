<h1>{L_CATEGORIES_TITLE}</h1>

<p>{L_CATEGORIES_EXPLAIN}</p>
<style type="text/css">
	.order { color: red; font-weight: bold;}
</style>

<form method="post" action="{S_CATEGORIES_ACTION}">
	<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
		<tr>
			<th width="400">{L_CAT_DISPLAY}</th>
			<th>{L_REORDER}</th>
		</tr>
		<!-- BEGIN categories -->
		<tr>
			<td class="{categories.ROW_CLASS}" align="center">{categories.DISPLAY}</td>
			<td class="{categories.ROW_CLASS}" align="center">
				<a href="{categories.U_MOVE_UP}">{L_MOVE_UP}</a> :: 
				<a href="{categories.U_MOVE_DOWN}">{L_MOVE_DOWN}</a>
			</td>
		</tr>
		<!-- END categories -->			
	</table>
</form>
