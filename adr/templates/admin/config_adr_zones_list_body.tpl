<h1>{L_ZONE_TITLE}</h1>

<p>{L_ZONE_EXPLAIN}</p>

<form method="post" action="{S_ZONES_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_ZONE_NAME}</th>
		<th class="thTop">{L_ZONE_ELEMENT}</th>
		<th class="thTop">{L_ZONE_LEVEL}</th>
		<th class="thTop">{L_ZONE_ITEM}</th>
		<th class="thTop">{L_ZONE_RETURN}</th>
		<th class="thTop">{L_ZONE_DESTINATION2}</th>
		<th class="thTop">{L_ZONE_DESTINATION3}</th>
		<th class="thTop">{L_ZONE_DESTINATION4}</th>
		<th colspan="3" class="thCornerR">{L_ZONE_ACTION}</th>
	</tr>

	<!-- BEGIN zones -->
	<tr>
		<td class="{zones.ROW_CLASS}" align="center">{zones.NAME}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.ELEMENT}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.LEVEL}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.ITEM}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.RETURN}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.DESTINATION2}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.DESTINATION3}</td>
		<td class="{zones.ROW_CLASS}" align="center">{zones.DESTINATION4}</td>
		<td class="{zones.ROW_CLASS}" align="center"><a href="{zones.U_ZONES_EDIT}">{L_EDIT}</a></td>
		<td class="{zones.ROW_CLASS}" align="center"><a href="{zones.U_ZONES_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END zones -->
	<tr>
		<td class="catBottom" colspan="13" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ZONE_ADD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />