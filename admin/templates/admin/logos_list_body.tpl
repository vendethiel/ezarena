
<h1>{L_LOGO_TITLE}</h1>

<P>{L_LOGO_TEXT}</p>

<form method="post" action="{S_LOGO_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_LOGO_IMAGE}</th>
		<th class="thTop">{L_LOGO_ADRESSE}</th>
		<th class="thTop">{L_LOGO_PROBA}</th>
		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN logo -->
	<tr align="center" valign="middle">
		<td class="{logo.ROW_CLASS}"><img src="{logo.ADRESSE}" border="0" vspace="1" /></td>
		<td class="{logo.ROW_CLASS}">{logo.ADRESSE}</td>
		<td class="{logo.ROW_CLASS}">{logo.PROBA}</td>
		<td class="{logo.ROW_CLASS}"><a href="{logo.U_LOGO_EDIT}">{L_EDIT}</a></td>
		<td class="{logo.ROW_CLASS}"><a href="{logo.U_LOGO_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END logo -->
	<tr>
		<td class="catBottom" colspan="5" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_LOGO_ADD}" class="mainoption" /></td>
	</tr>
</table></form>
