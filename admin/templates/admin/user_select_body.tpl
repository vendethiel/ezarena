<!-- $Id: user_select_body.tpl,v 0.2 22/11/2006 14:02 reddog Exp $ -->

<h1>{L_USER_TITLE}</h1>

<p>{L_USER_EXPLAIN}</p>

<form method="post" name="post" action="{S_USER_ACTION}">
<div class="hcenter">
<table class="forumline cells center" cellspacing="1">
<tr>
	<th class="thHead">{L_USER_SELECT}</th>
</tr>
<tr>
	<td class="row1 middle"><input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS}<span class="genmed">
		<input type="text" class="post" name="username" maxlength="50" size="20" />
		<input type="image" src="{I_SELECT}" name="submituser" alt="{L_LOOK_UP}" title="{L_LOOK_UP}" class="absbottom" />
		<input type="image" src="{I_SEARCH}" name="usersubmit" alt="{L_FIND_USERNAME}" title="{L_FIND_USERNAME}" class="absbottom" onclick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'height=250,resizable=yes,width=400'); return false;" />
	</span></td>
</tr>
</table>
</div>
</form>
<br class="both" />