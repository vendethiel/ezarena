<form method="post" action="{S_LIST_ACTION}">
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>
<br />

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<!-- BEGIN sets -->
	<tr>
		<th class="catBottom" align="center" colspan="4"><b>{sets.SET_NAME}</b></td>
	</tr>
   	<tr> 
		<td width="5%" class="{sets.ROW_CLASS}" align="center">{sets.SET_IMG}</td> 
		<td width="25%" class="{sets.ROW_CLASS}" align="left">
			<span class="gen"><b>{sets.SET_NAME}</b></span><br />
			<span class="gensmall"><b>{L_SET_DESC}</b>&nbsp;<i>{sets.SET_DESC}</i></span><br /><br />
			<span class="gensmall"><b>{L_SET_HELM}</b>&nbsp;{sets.SET_HELM}</span><br />
			<span class="gensmall"><b>{L_SET_ARMOUR}</b>&nbsp;{sets.SET_ARMOUR}</span><br />
			<span class="gensmall"><b>{L_SET_GLOVES}</b>&nbsp;{sets.SET_GLOVES}</span><br />
			<span class="gensmall"><b>{L_SET_SHIELD}</b>&nbsp;{sets.SET_SHIELD}</span><br />
		</td>
		<td width="25%" class="{sets.ROW_CLASS}" align="left" valign="bottom">
			<span class="gensmall"><b>{L_SET_MIGHT_BONUS}</b>&nbsp;+{sets.SET_MIGHT_BONUS}</span><br />
			<span class="gensmall"><b>{L_SET_CON_BONUS}</b>&nbsp;+{sets.SET_CON_BONUS}</span><br />
			<span class="gensmall"><b>{L_SET_AC_BONUS}</b>&nbsp;+{sets.SET_AC_BONUS}</span><br />
			<span class="gensmall"><b>{L_SET_DEX_BONUS}</b>&nbsp;+{sets.SET_DEX_BONUS}</span><br />
			<span class="gensmall"><b>{L_SET_INT_BONUS}</b>&nbsp;+{sets.SET_INT_BONUS}</span><br />
			<span class="gensmall"><b>{L_SET_WIS_BONUS}</b>&nbsp;+{sets.SET_WIS_BONUS}</span>
		</td>
		<td width="25%" class="{sets.ROW_CLASS}" align="left" valign="bottom">
			<span class="gensmall"><b>{L_SET_MIGHT_PEN}</b>&nbsp;-{sets.SET_MIGHT_PEN}</span><br />
			<span class="gensmall"><b>{L_SET_CON_PEN}</b>&nbsp;-{sets.SET_CON_PEN}</span><br />
			<span class="gensmall"><b>{L_SET_AC_PEN}</b>&nbsp;-{sets.SET_AC_PEN}</span><br />
			<span class="gensmall"><b>{L_SET_DEX_PEN}</b>&nbsp;-{sets.SET_DEX_PEN}</span><br />
			<span class="gensmall"><b>{L_SET_INT_PEN}</b>&nbsp;-{sets.SET_INT_PEN}</span><br />
			<span class="gensmall"><b>{L_SET_WIS_PEN}</b>&nbsp;-{sets.SET_WIS_PEN}</span>
		</td>
  	 </tr> 
	<!-- END sets -->
	<tr> 
		<td class="catBottom" colspan="8" height="28">&nbsp;</td>
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

<table width="100%">
	<tr>
		<td align="center"><span class="gen"><a href="{U_COPYRIGHT}">{L_COPYRIGHT}</a></span></td>
	</tr>
</table>
<br clear="all" />