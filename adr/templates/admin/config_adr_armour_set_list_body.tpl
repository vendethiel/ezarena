<form method="post" action="{S_SETS_ACTION}">

<h1>{L_SET_TITLE}</h1>

<p>{L_SET_TEXT}</p>

<table cellspacing="1" cellpadding="5" border="0" align="center" class="forumline" width="100%"> 
   <tr> 
      <th align="center" colspan="6">{L_SET_TITLE}</th> 
   </tr> 
<!-- BEGIN sets -->
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
	<td width="10%" class="{sets.ROW_CLASS}" align="center"><a href="{sets.U_SET_EDIT}">{L_EDIT}</a></td>
	<td width="10%" class="{sets.ROW_CLASS}" align="center"><a href="{sets.U_SET_DELETE}">{L_DELETE}</a></td>
   </tr> 
<!-- END sets -->
	</form>
	<form method="post" action="{S_SETS_ACTION}">
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_ADD_SET}" class="mainoption" /></td>
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