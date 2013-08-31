<h1>{L_SKILLS_TITLE}</h1>

<P>{L_SKILLS_TEXT}</p>

<form method="post" action="{S_SKILLS_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_DESC}</th>
		<th class="thTop">{L_REQ}</th>
		<th class="thTop">{L_CHANCE}</th>
		<th class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN skills -->
	<tr>
		<td class="{skills.ROW_CLASS}" align="center">{skills.NAME}</td>
		<td class="{skills.ROW_CLASS}" align="center"><img src="../adr/images/skills/{skills.IMG}" alt="{skills.NAME}" /></td>
		<td class="{skills.ROW_CLASS}" align="center">{skills.DESC}</td>
		<td class="{skills.ROW_CLASS}" align="center">{skills.REQ}</td>
		<td class="{skills.ROW_CLASS}" align="center">{skills.CHANCE}</td>
		<td class="{skills.ROW_CLASS}" align="center"><a href="{skills.U_SKILLS_EDIT}">{L_EDIT}</a></td>
	</tr>
	<!-- END skills -->
</table>
</form>

<br clear="all" />