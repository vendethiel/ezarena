<form action="{S_GUILDS_ACTION}" method="post">

<!-- BEGIN guilds_leader_page -->
<br />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" id="stripedTable1" align="center">
	<tr>
		<td class="row2" colspan="3" align="center"><b><font size="6">{U_GUILDS_LEADER}{L_GUILDS_LEADER_CP}</font></b></td>
	</tr>
	<tr>
		<td class="row2" colspan="3"><p class="gen" align="center"><i><font size="4">"{U_GUILDS_LEADER_GUILD_DESC}"</font></i></p></td>
	</tr>
  <tr>
		<td class="row2" colspan="3"><b>{L_GUILDS_INFO}</b></td>
	</tr>
	<tr>
		<td class="row1" width="40%"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_LEADER}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_LEADER}</span></td>
		<td class="row1" align="center" width="200px" height="150" rowspan="6" >{U_GUILDS_INFO_LOGO}</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_LEVEL}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_LEVEL}</span></td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_MEMBERS}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_MEMBERS}</span></td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_VAULT}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_VAULT} {L_GUILDS_INFO_POINTS}</span></td>
	</tr>
	<tr>
 		<td class="row1"><font SIZE="2"><span class="gen">Donate to Guild Fund:</span></td>
 		<td class="row1" align="center"><input class="post" type="text" value="{POINTS}" class="post" maxlength="8" size="8" name="deposit_sum" /><span class="gensmall"> {L_POINTS}</span><input type="submit" value="Donate" name="deposit" class="liteoption" /></td>
 	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_DATE}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_DATE}</span></td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_LENGTH}</span></td>
		<td class="row1" ><p align="center"><span class="gen">{U_GUILDS_INFO_DATE2}{L_GUILDS_INFO_DATE2}</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_COPPER_PEC}</span></td>
		<td class="row1"><p align="center"><span class="gen">{U_GUILDS_INFO_COPPER_PEC} %</span></td>
		<td class="row1" align="center" >{U_GUILDS_INFO_EXP}<br><span class="gensmall">{U_GUILDS_INFO_EXP_MIN}/{U_GUILDS_INFO_EXP_MAX}</span></td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_EXP_PEC}</span></td>
		<td class="row1"><p align="center"><span class="gen">{U_GUILDS_INFO_EXP_PEC} %</span></td>
		<td class="row1" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2"><span class="gen">{L_GUILDS_INFO_HEAL_PEC}</span></td>
		<td class="row1"><p align="center"><span class="gen">{U_GUILDS_INFO_HEAL_PEC} %</span></td>
		<td class="row1" colspan="2">&nbsp;</td>
	</tr>
    <tr>
		<td class="row2" colspan="3"><b>{L_GUILDS_MANAGEMENT}</b></td>
	</tr>
	<tr>
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_INFO_RANKS}';"><span class="gen"><b>{L_GUILDS_INFO_RANKS}</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_APPROVE}';"><span class="gen"><b>{L_GUILDS_LEADER_APPROVE} ({U_GUILDS_APPROVE_COUNT})</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_INCREASE_SIZE}';"><span class="gen"><b>{L_GUILDS_INCREASE_SIZE}</b></span></td> 	
	</tr>
    <tr>
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_USERS}';"><span class="gen"><b>{L_GUILDS_LEADER_USERS}</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_SET_RANKS}';"><span class="gen"><b>{L_GUILDS_LEADER_SET_RANKS}</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_VAULT}';"><span class="gen"><b>{L_GUILDS_VAULT}</b></span></td>	
	</tr>
	<tr>
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_NEW_LEADER}';"><span class="gen"><b>{L_GUILDS_LEADER_NEW_LEADER}</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_DELETE}';"><span class="gen"><b>{L_GUILDS_LEADER_DELETE}</b></span></td>	
		<td align="center" class="row3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_FORUMS}';"><span class="gen"><b>{L_GUILDS_FORUMS}</b></span></td>	
	</tr>
	<tr>
		<td class="row2"colspan="3"><b>{L_GUILDS_INFO_JOIN_REQS}</b></td>
	</tr>
	<tr>
		<td class="row1" ><font SIZE="2">{L_GUILDS_INFO_JOIN_ACCEPT_NEW}</font></td>
		<td class="row1" align="center"><span class="gen"><input type="radio" name="accept_new" value="1" {U_GUILDS_ACCEPT_NEW_CHECKED} />{L_YES}&nbsp;<input type="radio" name="accept_new" value="0" {U_NO_GUILDS_ACCEPT_NEW_CHECKED} />{L_NO}</span></td>
		<td class="row1" align="center" >&nbsp;</td>
	</tr>
      <tr>
		<td class="row1" ><font SIZE="2">{L_GUILDS_INFO_JOIN_APPROVE_NEW}</font></td>
		<td class="row1" align="center"><span class="gen"><input type="radio" name="approve_enable" value="1" {U_GUILDS_APPROVE_NEW_CHECKED} />{L_YES}&nbsp;<input type="radio" name="approve_enable" value="0" {U_NO_GUILDS_APPROVE_NEW_CHECKED} />{L_NO}</span></td>
		<td class="row1" align="center" >&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" ><font SIZE="2">{L_GUILDS_INFO_JOIN_LEVEL}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="3" size="5" name="min_join_level"  value="{U_GUILDS_INFO_JOIN_LEVEL}" tabindex="1" /></td>
		<td class="row1" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" ><font SIZE="2">{L_GUILDS_INFO_JOIN_MONEY}</font></td>
		<td class="row1" align="center">
        <input class="post" type="text" maxlength="3" size="5" name="min_join_money"  value="{U_GUILDS_INFO_JOIN_MONEY}" tabindex="2" /></td>
		<td class="row1" align="center" >&nbsp;</td>
	</tr>
	<tr> 
	  <td class="row2" colspan="3" height="28"><b>{L_GUILDS_LEADER_GENERAL}</b></td>
	</tr>
	<tr> 
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_DESC}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="100" size="37" name="desc"  value="{U_GUILDS_LEADER_GUILD_DESC}" tabindex="3" /></td>
	  <td class="row1" height="28">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" ><font SIZE="2">{L_GUILDS_LEADER_LOGO}</font></td>
		<td class="row1" align="center">
        <input class="post" type="text" maxlength="100" size="37" name="logo"  value="{U_GUILDS_LEADER_LOGO}" tabindex="4" /></td>
	  <td class="row1" height="28">&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK_LEADER}</font></td>
		<td class="row1" align="center">
        <input class="post" type="text" maxlength="30" size="37" name="rank_leader"  value="{U_GUILDS_LEADER_RANK_LEADER}" tabindex="5" /></td>
	  <td class="row1" height="28">&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK1}</font></td>
		<td class="row1" align="center">
        <input class="post" type="text" maxlength="25" size="37" name="rank1"  value="{U_GUILDS_LEADER_RANK1}" tabindex="6" /></td>
	  <td class="row1" height="28">&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK2}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="rank2"  value="{U_GUILDS_LEADER_RANK2}" tabindex="7" /></td>
	  <td class="row1" height="28">&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK3}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="rank3"  value="{U_GUILDS_LEADER_RANK3}" tabindex="8" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK4}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="rank4"  value="{U_GUILDS_LEADER_RANK4}" tabindex="9" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
    <tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK5}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="rank5"  value="{U_GUILDS_LEADER_RANK5}" tabindex="10" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_LEADER_RANK_MEMBER}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="rank_member"  value="{U_GUILDS_LEADER_RANK_MEMBER}" tabindex="11" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_INFO_EXP_PEC}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="exp_pec"  value="{U_GUILDS_INFO_EXP_PEC}" tabindex="11" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_INFO_COPPER_PEC}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="copper_pec"  value="{U_GUILDS_INFO_COPPER_PEC}" tabindex="11" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><font SIZE="2">{L_GUILDS_INFO_HEAL_PEC}</font></td>
		<td class="row1" align="center" >
        <input class="post" type="text" maxlength="25" size="37" name="heal_pec"  value="{U_GUILDS_INFO_HEAL_PEC}" tabindex="11" /></td>
	  <td class="row1" height="28" >&nbsp;</td>
	</tr>
<!--
    <tr>
		<td align="center" class="row3" colspan="3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_LEADER_BIO}';"><span class="gen"><b>{L_GUILDS_LEADER_BIO}</b></span></td>	
	</tr>
-->
	<tr>
		<td class="catBottom" align="center" colspan="3"><input type="hidden" name="mode" value="guilds_leader_page_update" />
        <input class="mainoption" type="submit" value="{L_SUBMIT}" tabindex="12" /></td>
	</tr>
</table>
<!-- END guilds_leader_page -->

<!-- BEGIN guilds_approve_list -->
<br />
  <table width="100%" align="center" cellpadding="3" cellspacing="1" border="0" class="forumline" id="stripedTable1">
	<tr> 
	  <th class="thTop" colspan="10" nowrap="nowrap" width="892">{L_APPROVE_LIST}</th>
	</tr>
	<tr> 
	  <th class="thTop" nowrap="nowrap" width="5%">{L_APPROVE_ROW}</th>
	  <th class="thTop" nowrap="nowrap" width="15%">{L_APPROVE_NAME}</th>
	  <th class="thTop" nowrap="nowrap" width="5%">{L_APPROVE_LEVEL}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_HP}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_MP}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_WINS}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_DEFEATS}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_FLEES}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_APPROVE_HOPS}</th>
	  <th class="thTop" nowrap="nowrap" width="15%">{L_APPROVE_SELECT}</th>
	</tr>
<!-- BEGIN rows -->
	<tr> 
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center" width="299"><span class="gen">{guilds_approve_list.rows.APPROVE_ROW}</span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_NAME}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_LEVEL}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_HP}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_MP}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_WINS}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_DEFEATS}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_FLEES}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_approve_list.rows.APPROVE_HOPS}</a></span></td>
	  <td class="{guilds_approve_list.rows.ROW_CLASS}" align="center"><span class="gen">
		<input type="hidden" name="guild_id" value="{GUILD_ID}" />
		<input type="checkbox" name="approve_box[]" value="{guilds_approve_list.rows.APPROVE_ID}" /></td>
	</tr>
<!-- END rows -->
	<tr>
		<td class="catBottom" align="center" colspan="10">{ACTION_SELECT}&nbsp;<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
  </table>
<br />
<!-- END guilds_approve_list -->

<!-- BEGIN guilds_leader_bio -->
<br />
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" id="stripedTable1" width="100%">
	<tr>
		<td align="center" class="row2" width="50%"><span class="gen">{L_GUILDS_BIO_TITLE}</span><p>
        <i><span class="gen">{L_GUILDS_BIO_TEXT}</span></i></p>
        <p><br />&nbsp;</td>
		<td align="center" class="row1">
        <textarea name="guilds_bio" rows="10" cols="40" wrap="virtual" style="width:450px" tabindex="3" class="post" >{U_GUILDS_BIO}</textarea></td>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2"><input type="hidden" name="mode" value="guilds_leader_bio_update" />
        <input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>
<!-- END guilds_leader_bio -->

<!-- BEGIN guilds_users -->
<br />
  <table width="100%" align="center" cellpadding="3" cellspacing="1" border="0" class="forumline" id="stripedTable1">
	<tr> 
	  <th class="thTop" colspan="10" nowrap="nowrap">{L_USERS_LIST}</th>
	</tr>
	<tr> 
	  <th class="thTop" nowrap="nowrap" width="5%">{L_USERS_ROW}</th>
	  <th class="thTop" nowrap="nowrap" width="15%">{L_USERS_NAME}</th>
	  <th class="thTop" nowrap="nowrap" width="5%">{L_USERS_LEVEL}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_HP}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_MP}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_WINS}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_DEFEATS}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_FLEES}</th>
	  <th class="thTop" nowrap="nowrap" width="10%">{L_USERS_HOPS}</th>
	  <th class="thTop" nowrap="nowrap" width="15%">{L_USERS_SELECT}</th>
	</tr>
<!-- BEGIN rows -->
	<tr> 
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center" ><span class="gen">{guilds_users.rows.USERS_ROW}</span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_NAME}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_LEVEL}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_HP}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_MP}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_WINS}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_DEFEATS}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_FLEES}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">{guilds_users.rows.USERS_HOPS}</a></span></td>
	  <td class="{guilds_users.rows.ROW_CLASS}" align="center"><span class="gen">
		<input type="hidden" name="guild_id" value="{GUILD_ID}" />
		<input type="checkbox" name="users_box[]" value="{guilds_users.rows.USERS_ID}" /></td>
	</tr>
<!-- END rows -->
	<tr>
		<td class="catBottom" align="center" colspan="10">{ACTION_SELECT}&nbsp;<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
  </table>
<br />
<!-- END guilds_users -->

<!-- BEGIN guilds_leader_new_leader -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>{L_NEW_LEADER}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_CURRENT_LEADER}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_CURRENT_LEADER}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_MEMBERS_LIST}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><input type="hidden" name="mode" value="guilds_leader_new_leader_update"><input type="submit" name="action" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
<!-- END guilds_leader_new_leader -->

<!-- BEGIN guilds_leader_set_ranks -->
<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>{L_RANK_SET_1}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_RANK_1}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_RANK_1}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{RANK_1}</span></td>
	</tr>
	</table>
	
	<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>
        {L_RANK_SET_2}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_RANK_2}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_RANK_2}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{RANK_2}</span></td>
	</tr>
	</table>
	
	<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>
        {L_RANK_SET_3}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_RANK_3}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_RANK_3}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{RANK_3}</span></td>
	</tr>
	</table>
	
	<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>
        {L_RANK_SET_4}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_RANK_4}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_RANK_4}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{RANK_4}</span></td>
	</tr>
	</table>
	
	<br />
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>{L_RANK_SET_5}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_RANK_5}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_RANK_5}</span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_MEMBERS_LIST}</span></td>
		<td align="center" class="row2" ><span class="gen">{RANK_5}</span></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row2" ><input type="hidden" name="mode" value="guilds_leader_set_ranks_update"><input type="submit" name="action" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
	</table>
<!-- END guilds_leader_set_ranks -->

<!-- BEGIN guild_vault -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" id="stripedTable1" width="80%" >
	<tr>
		<td align="center" class="CatHead" colspan="2"><span class="gen"><b>{L_GUILD_VAULT}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" ><span class="gen">{L_VAULT_TOTAL}</span></td>
		<td align="center" class="row2" ><span class="gen">{U_VAULT_TOTAL}</span></td>
	</tr>
</table>
<!-- END guild_vault -->

<br />
<table class="forumline" id="stripedTable1" align="center" width="200" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_BACK}';" width="449"><span class="gen">{L_GUILDS_BACK}</span></td>	
	</tr>
</table>
</form>
