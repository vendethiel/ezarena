<form method="post" action="{S_LOOTTABLE_ACTION}">

<h1>{L_LOOTTABLE_TITLE}</h1>

<p>{L_LOOTTABLE_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_LOOTTABLE_NAME}<br /><span class="gensmall">{L_LOOTTABLE_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="loottable_name" value="{LOOTTABLE_NAME}" size="30" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LOOTTABLE_DESC}<br /><span class="gensmall">{L_LOOTTABLE_DESC_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="loottable_desc" value="{LOOTTABLE_DESC}" size="30" rowspan="2" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_LOOTTABLE_DROPCHANCE}<br /><span class="gensmall">{L_LOOTTABLE_DROPCHANCE_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="loottable_dropchance" value="{LOOTTABLE_DROPCHANCE}" size="30" rowspan="2" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_LOOTTABLE_STATUS}</span></td>
		<td class="row2" align="center" valign="top"><input type="radio" name="loottable_status" value="1" {LOOTTABLE_ACTIVATED_CHECKED} />{L_LOOTTABLE_ACTIVATED}&nbsp;<input type="radio" name="loottable_status" value="0" {LOOTTABLE_DEACTIVATED_CHECKED} />{L_LOOTTABLE_DEACTIVATED}</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_LOOTTABLE_SUBMIT}" /></td>
	</tr>
</table>

</form>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center"><span class="gen"><a href="http://www.nightcrawlers.be">Advanced Loot System written by: Himmelweiss</a></span></td>
	</tr>
</table>
<br clear="all" />