<form method="post" action="{S_BATTLE_ACTION}">
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" value="{L_SUBMIT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th align="center">{L_MONSTER_NAME}</th>
		<th align="center">{L_MONSTER_LEVEL}</th>
		<th align="center">{L_RESULT}</th>
	</tr>
	<!-- BEGIN battle -->
	<tr>
		<td class="{battle.ROW_CLASS}" align="center"><span class="gen">{battle.MONSTER_NAME}</span></td>
		<td class="{battle.ROW_CLASS}" align="center"><span class="gen">{battle.MONSTER_LEVEL}</span></td>
		<td class="{battle.ROW_CLASS}" align="center"><span class="gen">{battle.RESULT}</span></td>
	</tr>
	<!-- END battle -->
	<tr> 
		<td class="catBottom" colspan="3" height="28">&nbsp;</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
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