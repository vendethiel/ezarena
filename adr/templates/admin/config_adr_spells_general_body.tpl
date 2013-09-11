<h1>{L_SPELLS_GENERAL_TITLE}</h1>

<P>{L_SPELLS_GENERAL_EXPLAIN}</p>

<form method="post" action="{S_SPELLS_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" colspan="10" ><b>{L_SPELLS_}</b></th>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_SPELLS_PM}<br /><span class="gensmall">{L_SPELLS_PM_EXPLAIN}</span></td>
		<td class="row2" align="center" colspan="2">
			<span class="gen">
				<input type="radio" name="pm" value="1" {SPELLS_PM_SEND} />{L_YES}<br />
				<input type="radio" name="pm" value="0" {SPELLS_NO_PM_SEND} />{L_NO}
			</span>
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="12" align="center"><input type="submit" name="submit" value="{L_SPELLS_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />