<form action="{S_PET_ACTION}" method="post">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	      <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_CONFIRM_TITLE}</span></td>
	      <td align="right"><span class="nav"><a href="{S_PET_ACTION}" class="nav">{L_RETURN}</a></span></td>
	</tr>
 </table>

<!-- BEGIN sellpet -->
<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thHead" align="center" >{L_PET_SOLD}</td>
	</tr>
	<tr>
		<td class="row1" align="center" ><span class="gen">{L_SELL_PET_FOR}&nbsp;{SELL_PET_FOR}&nbsp;{L_POINTS}&nbsp;?</span></td>
	</tr>
		<td class="row2" align="center" >
			<input type="hidden" value="{SELL_PET_FOR}" name="pet_value"><input type="submit" value="{L_YES}" name="confirm_sell" class="liteoption" />
			<input type="submit" value="{L_NO}" class="liteoption" />
		</td>
	</tr>
</table>
<!-- END sellpet -->

<!-- BEGIN resurrect -->
<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thHead" align="center" >{L_PET_IS_DEAD}</td>
	</tr>
	<tr>
		<td class="row1" align="center" ><span class="gen">{L_PET_DEAD_COST}&nbsp;{PET_DEAD_COST}&nbsp;{L_POINTS}</span>
		<br /><span class="gensmall">{L_PET_DEAD_COST_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center" >
			<input type="submit" name="resurrect_ok" value="{L_RESURRECT_OK}" class="liteoption" />
			<input type="submit" name="resurrect_no" value="{L_RESURRECT_NO}" class="liteoption" />
		</td>
	</tr>
</table>
<!-- END resurrect -->
</form>

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>




