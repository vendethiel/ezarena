<!-- $Id: group_select_body.tpl,v 0.2 22/11/2006 14:02 reddog Exp $ -->

<h1>{L_GROUP_TITLE}</h1>

<p>{L_GROUP_EXPLAIN}</p>

<form method="post" action="{S_GROUP_ACTION}">
<div class="hcenter">
<table class="forumline cells center" cellspacing="1">
<tr>
	<th class="thHead">{L_GROUP_SELECT}</th>
</tr>
<!-- BEGIN select_box -->
<tr>
	<td class="row1 middle"><span class="genmed">
		{S_GROUP_SELECT}
		<input type="image" src="{I_EDIT}" name="edit" alt="{L_LOOK_UP}" title="{L_LOOK_UP}" class="absbottom" />
	</span></td>
</tr>
<!-- END select_box -->
<tr>
	<td class="catBottom middle">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_CREATE}" name="new" alt="{L_CREATE_NEW_GROUP}" title="{L_CREATE_NEW_GROUP}" />
	</span></td>
</tr>
</table>
</div>
</form>
<br class="both" />