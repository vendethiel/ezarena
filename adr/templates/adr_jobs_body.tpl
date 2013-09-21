<form action="{S_JOB_ACTION}" method="post" name="post">
<br />

<table cellspacing="0" cellpadding="4" border="0" align="center" class="forumline" width="65%"> 
	<tr> 
		<th align="center" colspan="2">{L_PERSONAL_STATS}</th> 
	</tr> 

	<!-- BEGIN non_employed -->
	<tr>
		<td class="row1" width="50%" align="center" rowspan="4"><span class="gensmall"><i>{L_NON_EMPLOYED}</i></span></td> 
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_TIMES}&nbsp;<b>{EMPLOYED_TIMES}</b></span></td>  
	</tr>
	<tr>
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_TOTAL}&nbsp;<b>{EMPLOYED_TOTAL}</b>&nbsp;{POINTS}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_COMPLETED}&nbsp;<b>{EMPLOYED_COMPLETED}</b></span></td> 
	</tr>
	<tr>
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_INCOMPLETE}&nbsp;<b>{EMPLOYED_INCOMPLETE}</b></span></td> 
	</tr>
	<!-- END non_employed --> 

	<!-- BEGIN employed -->
	<tr>
		<td class="row1" width="100%" align="center" colspan="2">{employed.EMPLOYED_IMG}</td> 
	</tr>
	<tr>
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED}&nbsp;<b>{employed.EMPLOYED}</b></span></td> 
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_TIMES}&nbsp;<b>{EMPLOYED_TIMES}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_SALARY}&nbsp;<b>{employed.EMPLOYED_SALARY}</b>&nbsp;{POINTS}</span></td> 
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_TOTAL}&nbsp;<b>{EMPLOYED_TOTAL}</b>&nbsp;{POINTS}</span></td> 
	</tr>
	<tr>
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_EARNED}&nbsp;<b>{employed.EMPLOYED_EARNED}</b>&nbsp;{POINTS}</span></td> 
		<td class="row2" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_COMPLETED}&nbsp;<b>{EMPLOYED_COMPLETED}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_DAYS_LEFT}&nbsp;<b>{employed.EMPLOYED_DAYS_LEFT}</b></span></td> 
		<td class="row1" width="50%" align="left"><span class="gensmall">{L_EMPLOYED_INCOMPLETE}&nbsp;<b>{EMPLOYED_INCOMPLETE}</span></td> 
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2"><input type="hidden" name="quit" value="{employed.JOB_ID}" /><input type="submit" name="quit" value="Quitter le métier actuel" class="mainoption" /></td>
	</tr>
	<!-- END employed -->
</table>

<br /><br />

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;:&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<br />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%"> 
   <tr> 
      <th align="center" colspan="4">{L_JOB_TITLE}</th> 
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
	<td width="55%" class="{jobs.ROW_CLASS}" align="left" valign="bottom">
		<span class="gensmall"><b>{L_JOB_SALARY}</b>&nbsp;{jobs.JOB_SALARY}&nbsp;{POINTS}</span><br />
		<span class="gensmall"><b>{L_JOB_SALARY_INTERVALS}</b>&nbsp;{jobs.JOB_SALARY_INT}&nbsp;{jobs.L_JOB_INT_LANG}</span><br />
		<span class="gensmall"><b>{L_JOB_SP_REWARD}</b>&nbsp;{jobs.JOB_SP_REWARD}</span><br />
		<span class="gensmall"><b>{L_JOB_EXP}</b>&nbsp;{jobs.JOB_EXP}</span><br />
		<span class="gensmall"><b>{L_JOB_ITEM_REWARD}</b>&nbsp;{jobs.JOB_ITEM_REWARD}</span><br />
		<span class="gensmall"><b>{L_JOB_DURATION}</b>&nbsp;{jobs.JOB_DURATION}&nbsp;{jobs.L_JOB_DURA_LANG}</span><br />
		<span class="gensmall"><b>{L_JOB_SLOTS}</b>&nbsp;{jobs.JOB_SLOTS}&nbsp;/&nbsp;{jobs.JOB_SLOTS_MAX}</span>
	</td>
<!-- BEGIN not_employed -->
	<td width="25%" class="{jobs.ROW_CLASS}" align="center">
		<input type="radio" name="apply_select" value="{jobs.JOB_ID}">
	</td>
<!-- END not_employed -->
   </tr> 
<!-- END jobs -->
<!-- BEGIN apply -->
	<tr>
		<td class="catBottom" align="right" colspan="4">
			<input type="submit" name="apply" value="Postuler" class="mainoption" >&nbsp;&nbsp;
		</td>
	</tr>
<!-- END apply -->
</table> 

<br />

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br clear="all" />
</form>
