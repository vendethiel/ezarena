<h1>{L_TOWNMAP_SEASONS_TITLE}</h1>

<p>{L_TOWNMAP_SEASONS_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_GENERAL}</th>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CRON_SEASONS}</span></td>
		<td class="row2" align="center"><input type="checkbox" value="1" name="cron_enable" {CRON_SEASONS_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CRON_SEASONS_TIME}</span></td>
		<td class="row2" align="center"><input type="post" name="cron_time" maxlength="8" size="8" value="{CRON_SEASONS_TIME}" />&nbsp;{L_DAYS}</td>
	</tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="row2" colspan="2" align="center"><input type="submit" value="{L_SUBMIT}" name="update" class="liteoption" /></td>
	</tr>
</table>

<br clear="all" />

</form>
<br clear="all" />