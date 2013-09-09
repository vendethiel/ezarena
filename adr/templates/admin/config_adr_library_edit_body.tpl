<form method="post" action="{S_LIBRARY_ACTION}">

<h1>{L_LIBRARY_TITLE}</h1>

<p>{L_LIBRARY_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_NAME}<br /><span class="gensmall">{L_LIBRARY_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="book_name" value="{LIBRARY_NAME}" size="30" maxlength="255" />
	<!-- BEGIN library_edit -->
		<br /><span class="gensmall">{LIBRARY_NAME_EXPLAIN}</span>
	<!-- END library_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_DESC}<br /><span class="gensmall">{L_LIBRARY_DESC_EXPLAIN}</span></td>
		<td class="row2" align="center" ><textarea name="book_details" cols="50" rows="5" class="post">{LIBRARY_DESC}</textarea>
	<!-- BEGIN library_edit -->
		<br /><span class="gensmall">{LIBRARY_DESC_EXPLAIN}</span>
	<!-- END library_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_ZONE}<br /><span class="gensmall">{L_LIBRARY_ZONE_EXPLAIN}</span></td>
		<td class="row2" align="center" colspan="2">{LIBRARY_ZONA}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_DIFFICULTY}<br /><span class="gensmall">{L_LIBRARY_DIFFICULTY_EXPLAIN}</span></td>
		<td class="row2" align="center" >{DIFFICULTY_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_DIS}<br /><span class="gensmall">{L_LIBRARY_DIS_EXPLAIN}</span></td>
		<td class="row1" align="center" colspan="2"><input type="checkbox" name="book_false" value="1" {LIBRARY_FALSE} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LIBRARY_CRAFTING}<br /><span class="gensmall">{L_LIBRARY_CRAFTING_EXPLAIN}</span></td>
		<td class="row1" align="center" colspan="2">{LIBRARY_CRAFTING}</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>