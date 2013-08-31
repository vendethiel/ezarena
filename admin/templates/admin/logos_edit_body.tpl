
<h1>{L_LOGO_TITLE}</h1>

<p>{L_LOGO_EXPLAIN}</p>

<form method="post" action="{S_LOGO_ACTION}"><table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th class="thHead" colspan="2">{L_LOGO_CONFIG}</th>
	</tr>
	<tr>
		<td class="row2">{L_LOGO_ADRESSE}</td>
		<td class="row2"><input class="post" type="text" name="logo_adresse" value="{ADRESSE}" size="50" /></td>
	</tr>
	<tr>
		<td class="row1">{L_LOGO_PROBA}<br /><span class="gensmall">{L_LOGO_PROBA_EXPLAIN}</span></td>
		<td class="row1"><input class="post" type="text" name="logo_proba" value="{PROBA}" size="10" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table></form>
