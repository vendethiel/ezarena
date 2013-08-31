<form method="post" action="{S_JOBS_ACTION}">

<h1>{L_JOB_TITLE}</h1>

<p>{L_JOB_TEXT}</p>

<table cellspacing="1" cellpadding="5" border="0" align="center" class="forumline" width="100%"> 
   <tr> 
      <th align="center" colspan="5">{L_JOB_TITLE}</th> 
   </tr> 
<!-- BEGIN jobs -->
   <tr> 
	<td width="5%" class="{jobs.ROW_CLASS}" align="center">{jobs.JOB_IMG}</td> 
	<td width="40%" class="{jobs.ROW_CLASS}" align="left">
		<span class="gen"><b>{jobs.JOB_NAME}</b></span><br />
		<span class="gensmall"><b>{L_JOB_DESC}</b>&nbsp;<i>{jobs.JOB_DESC}</i></span><br /><br />
		<span class="gensmall"><b>{L_JOB_RACE}</b>&nbsp;{jobs.JOB_RACE}</span><br />
		<span class="gensmall"><b>{L_JOB_CLASS}</b>&nbsp;{jobs.JOB_CLASS}</span><br />
		<span class="gensmall"><b>{L_JOB_ALIGNMENT}</b>&nbsp;{jobs.JOB_ALIGNMENT}</span><br />
		<span class="gensmall"><b>{L_JOB_LEVEL}</b>&nbsp;{jobs.JOB_LEVEL}</span><br />
	</td>
	<td width="35%" class="{jobs.ROW_CLASS}" align="left" valign="bottom">
		<span class="gensmall"><b>{L_JOB_SALARY}</b>&nbsp;{jobs.JOB_SALARY}&nbsp;{POINTS}</span><br />
		<span class="gensmall"><b>{L_JOB_SALARY_INT}</b>&nbsp;{jobs.JOB_SALARY_INT}&nbsp;{jobs.L_JOB_INT_LANG}</span><br />
		<span class="gensmall"><b>{L_JOB_SP_REWARD}</b>&nbsp;{jobs.JOB_SP_REWARD}</span><br />
		<span class="gensmall"><b>{L_JOB_EXP}</b>&nbsp;{jobs.JOB_EXP}</span><br />
		<span class="gensmall"><b>{L_JOB_ITEM_REWARD}</b>&nbsp;{jobs.JOB_ITEM_REWARD}</span><br />
		<span class="gensmall"><b>{L_JOB_DURATION}</b>&nbsp;{jobs.JOB_DURATION}&nbsp;{jobs.L_JOB_DURA_LANG}</span><br />
		<span class="gensmall"><b>{L_JOB_SLOTS}</b>&nbsp;{jobs.JOB_SLOTS}&nbsp;/&nbsp;{jobs.JOB_SLOTS_MAX}</span>
	</td>
	<td width="10%" class="{jobs.ROW_CLASS}" align="center"><a href="{jobs.U_JOB_EDIT}">{L_EDIT}</a></td>
	<td width="10%" class="{jobs.ROW_CLASS}" align="center"><a href="{jobs.U_JOB_DELETE}">{L_DELETE}</a></td>
   </tr> 
<!-- END jobs -->
	</form>
	<form method="post" action="{S_JOBS_ACTION}">
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_ADD_JOB}" class="mainoption" /></td>
	</tr>
</table> 


<table width="100%" cellspacing="3" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

</form>

<br clear="all" />