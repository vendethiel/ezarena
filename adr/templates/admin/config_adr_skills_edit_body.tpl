
<form method="post" action="{S_SKILLS_ACTION}">

<h1>{L_SKILLS_TITLE}</h1>

<p>{L_SKILLS_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_NAME}</span></td>
		<td class="row2" align="center" ><span class="gen"><b>{SKILL_NAME}</b></span></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_DESC}</span><br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="skill_desc" value="{SKILL_DESC}" size="30" rowspan="2" maxlength="255" />
		<br /><span class="gensmall">{SKILL_DESC_EXPLAIN}</span>
		</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_IMG}</span><br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="skill_img" value="{SKILL_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/skills/{SKILL_IMG_EX}" alt="{SKILL_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_REQ}</span><br /><span class="gensmall">{L_REQ_EXPLAIN}</span></td>
		<td class="row2" align="center"><input type="text" name="skill_req" value="{REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CHANCE}</span><br /><span class="gensmall">{L_CHANCE_EXPLAIN}</span></td>
		<td class="row2" align="center"><input type="text" name="skill_chance" value="{CHANCE}" size="8" maxlength="8" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>