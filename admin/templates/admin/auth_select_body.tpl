<!-- $Id: auth_select_body.tpl,v 0.2 22/11/2006 14:02 reddog Exp $ -->

<h1>{L_AUTH_TITLE}</h1>

<p>{L_AUTH_EXPLAIN}</p>

<form method="post" action="{S_AUTH_ACTION}">
<div class="hcenter">
<table class="forumline cells center" cellspacing="1">
<tr>
	<th class="thHead">{L_AUTH_SELECT}</th>
</tr>
<tr>
	<td class="row1 middle">{S_HIDDEN_FIELDS}<span class="genmed">
		{S_AUTH_SELECT}
		<input type="image" src="{I_SELECT}" alt="{L_LOOK_UP}" title="{L_LOOK_UP}" class="absbottom" />
	</span></td>
</tr>
</table>
</div>
</form>
<br class="both" />