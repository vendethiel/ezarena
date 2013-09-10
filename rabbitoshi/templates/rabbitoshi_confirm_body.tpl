<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_CONFIRM_TITLE}</span></td>
	</tr>
</table>

<form action="{S_PET_ACTION}" method="post">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<!-- BEGIN sellpet -->
        <tr>
		<th class="thHead">{L_PET_SOLD}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_SELL_PET_FOR}&nbsp;{SELL_PET_FOR}&nbsp;{L_POINTS}?</span></td>
	</tr>
		<td class="catBottom" align="center"><input type="hidden" value="{SELL_PET_FOR}" name="pet_value"><input type="submit" value="{L_YES}" name="confirm_sell" class="liteoption" />&nbsp;<input type="submit" value="{L_NO}" class="liteoption" /></td>
	</tr>
	<!-- END sellpet -->
	<!-- BEGIN gotovet -->
        <tr>
		<th class="thHead">{L_VET_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_VET_EXPLAIN}&nbsp;{VET_COST}&nbsp;{L_POINTS}?</span></td>
	</tr>
		<td class="catBottom" align="center"><input type="submit" value="{L_YES}" name="confirm_Vet" class="liteoption" />&nbsp;<input type="submit" value="{L_NO}" class="liteoption" /></td>
	</tr>
	<!-- END gotovet -->
        <!-- BEGIN resurrect -->
	<tr>
		<th class="thHead">{L_PET_IS_DEAD}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_PET_DEAD_COST}&nbsp;{PET_DEAD_COST}&nbsp;{L_POINTS}</span><br /><span class="gensmall">{L_PET_DEAD_COST_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="catBottom" align="center">
                	<input type="submit" name="resurrect_ok" value="{L_RESURRECT_OK}" class="liteoption" />&nbsp;
                	<input type="submit" name="resurrect_no" value="{L_RESURRECT_NO}" class="liteoption" />
                </td>
	</tr>
	<!-- END resurrect -->
</table>
</form>

<br clear="all" />