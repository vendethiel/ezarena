
<form method="post" action="{S_JOBS_ACTION}">

<h1>{L_JOB_TITLE}</h1>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_JOB_NAME}</td>
		<td class="row2" align="center" ><input type="text" name="job_name" value="{JOB_NAME}" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_JOB_DESC}<br /><span class="gensmall">{L_JOB_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="job_desc" value="{JOB_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN edit -->
		<br /><span class="gensmall">{JOB_DESC_EXPLAIN}</span>
	<!-- END edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_IMG}<br /><span class="gensmall">{L_JOB_IMG_EXPLAIN}</span></td>
	<!-- BEGIN add -->
		<td class="row2" align="center" ><input type="text" name="job_img" size="30" maxlength="255" /></td>
	<!-- END add -->
	<!-- BEGIN edit -->
		<td class="row2" align="center" ><input type="text" name="job_img" value="{JOB_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/jobs/{JOB_IMG}" alt="{JOB_NAME}" /></td>
	<!-- END edit -->
	</tr>
	<tr>
		<td class="row1">{L_JOB_AUTH_LEVEL}</td>
		<td class="row2" align="center" >{JOB_AUTH_LEVEL}</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_LEVEL}</td>
		<td class="row2" align="center" ><input type="text" name="job_level" size="5" maxlength="5" value="{JOB_LEVEL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_RACE}</td>
		<td class="row2" align="center" >{RACE_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_CLASS}</td>
		<td class="row2" align="center" >{CLASS_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_ALIGNMENT}</td>
		<td class="row2" align="center" >{ALIGNMENT_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_SALARY}<br /><span class="gensmall"><i>{L_JOB_SALARY_EXPLAIN}</i></span></td>
		<td class="row2" align="center" ><input type="text" name="job_salary" size="8" maxlength="8" value="{JOB_SALARY}" />&nbsp;<span class="gensmall">{L_POINTS}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_SALARY_INT}</span></td>
		<td class="row2" align="center" ><input type="text" name="job_salary_int" size="8" maxlength="8" value="{JOB_SALARY_INT}" /></span></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_ITEM}</td>
		<td class="row2" align="center" >{ITEM_REWARD_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_EXP}</td>
		<td class="row2" align="center" ><input type="text" name="job_exp" size="8" maxlength="8" value="{JOB_EXP}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_SP_REWARD}</td>
		<td class="row2" align="center" ><input type="text" name="job_sp_reward" size="8" maxlength="8" value="{JOB_SP_REWARD}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_DURATION}</td>
		<td class="row2" align="center" ><input type="text" name="job_duration" size="8" maxlength="8" value="{JOB_DURATION}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_SLOTS}</td>
		<td class="row2" align="center" ><input type="text" name="job_slots" size="8" maxlength="8" value="{JOB_SLOTS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_JOB_SLOTS_MAX}</td>
		<td class="row2" align="center" ><input type="text" name="job_slots_max" size="8" maxlength="8" value="{JOB_SLOTS_MAX}" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>