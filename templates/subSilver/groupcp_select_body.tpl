<!-- $Id: groupcp_select_body.tpl,v 0.2 22/11/2006 14:01 reddog Exp $ -->

{NAVIGATION_BOX}
<form method="post" action="{S_USERGROUP_ACTION}">
<table class="forumline cells" width="100%" cellspacing="1">
<thead>
<tr>
	<th class="thHead" colspan="2">{L_USERGROUPS}</th>
</tr>
</thead>
<tfoot>
<tr>
	<td class="catBottom middle" colspan="2">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_SUBMIT}" alt="{L_VIEW_INFORMATION}" title="{L_VIEW_INFORMATION}" />
	</span></td>
</tr>
</tfoot>
<tbody>
<tr>
	<td class="row1" width="38%"><span class="gen">
		{L_SELECT_USERGROUP}
	</span><br class="both" /><span class="gensmall">
		{L_SELECT_USERGROUP_DETAILS}
	</span></td>
	<td class="row2"><span class="gen">{LIST_BOX}</span></td>
</tr>
</tbody>
</table>
</form>
<br class="both" />