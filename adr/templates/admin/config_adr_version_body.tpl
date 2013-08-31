<form action="{S_ADR_ACTION}" method="post">
<br><br>
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center">{L_ADR_VERSION_INFORMATION}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{ADR_VERSION_INFO}</span></td>
	</tr>
</table>
<br><br>
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center">{L_ADR_BUGS}</th>
	</tr>
	<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center" width="7%">{L_CODE}:</th>
		<th align="left" width="55%">&nbsp;&nbsp;{L_REPORT}</th>
		<th align="center" width="11%">{L_STATUS}:</th>
		<th align="center" width="11%">{L_SEVERITY}:</th>
		<th align="center" width="15%">{L_DATE}:</th>
	</tr>
	{ADR_BUG_TABLE}
	<tr>
		<td class="row3" align="center" colspan="5"><span class="gensmall"><a href="{BUG_SHOW_LINK}">{BUG_SHOW_TYPE}</a></td>
	</tr>
	</table>
</table>
</form>
