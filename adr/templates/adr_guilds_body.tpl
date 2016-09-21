<script type="text/javascript">
<!--
  function encode(s,k) {
    var sl=s.length;
    var kl=k.length;    
    for(encoded='',i=0; i<sl; i++) {
      var encodedChar=s.charCodeAt(i)^k.charCodeAt(i%kl);      
      encoded += String.fromCharCode((encodedChar & 0x0F) + 97) + String.fromCharCode((encodedChar >> 4) + 97);      
    }
    return encoded;
  }
//-->
</script>

<form action="{S_GUILDS_ACTION}" method="post">
<!-- BEGIN guilds_main -->
<br />
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th class="thTop" colspan="8" nowrap="nowrap">{L_LEAGUE_TABLE}</th>
	</tr>
	<tr> 
	  <th class="thTop" nowrap="nowrap">{L_ROW}</th>
	  <th class="thTop" nowrap="nowrap">{L_NAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_LEADER}</th>
	  <th class="thTop" nowrap="nowrap">{L_WINS}</th>
	  <th class="thTop" nowrap="nowrap">{L_DEFS}</th>
	  <th class="thTop" nowrap="nowrap">{L_ESCS}</th>
	  <th class="thTop" nowrap="nowrap">{L_DIFF}</th>
	  <th class="thTop" nowrap="nowrap">{L_LEVEL}</th>
	</tr>
<!-- BEGIN rows -->
	<tr> 
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_ROW}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen"><a href="{guilds_main.rows.U_GUILD_INFO_PAGE}" class="gen">{guilds_main.rows.GUILD_NAME}</a></span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_LEADER}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_WINS}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_DEFS}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_ESCS}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_DIFF}</span></td>
	  <td class="{guilds_main.rows.ROW_CLASS}" align="center" onMouseOver="this.style.backgroundColor='{guilds_main.rows.ROW_CLASS}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{guilds_main.rows.ROW_CLASS}" onClick="window.location.href='{guilds_main.rows.U_GUILD_INFO_PAGE}';"><span class="gen">{guilds_main.rows.GUILD_LEVEL}</span></td>
	</tr>
<!-- END rows -->
	<tr> 
	  <td class="catbottom" colspan="8" height="28">&nbsp;</td>
	</tr>
  </table>
<br />
<!-- END guilds_main -->

<!-- BEGIN create_allow -->
<table class="forumline" align="center" width="400" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_CREATE}';" width="449"><span class="gen"><b>{L_GUILDS_CREATE}</b></span></td>
	</tr>
</table>
<!-- END create_allow -->

<!-- BEGIN guilds_create_info -->
<br />
<table border="0" cellpadding="4" cellspacing="1" width="90%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="4">{L_GUILD_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_GUILD_NAME}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="30" size="25" name="guilds_name" value="" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_GUILD_DESCRIPTION}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="100" size="25" name="guilds_description" value="" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%"><span class="gen">{L_GUILD_LOGO}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="100" size="25" name="guilds_logo" value="" /></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2"><input type="hidden" name="mode" value="guilds_create" /><input type="hidden" name="sub_mode" value="guilds_create_success" /><input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>
<br /><br />
<table class="forumline" align="center" width="200" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_BACK}';" width="449"><span class="gen">{L_GUILDS_BACK}</span></td>	
	</tr>
</table>
<!-- END guilds_create_info -->

<!-- BEGIN guilds_info_page -->
<br />
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<td class="row2" colspan="3" align="center">
			<b><h1>{U_GUILDS_INFO_NAME}</h1></b>
			<span class="gen"><i>"{U_GUILDS_INFO_DESC}"</i></span>
		</td>
	</tr>
    <tr>
		<td class="row2" colspan="2"><b class="contleft">{L_GUILDS_INFO}</b></td>
		<td class="row2"><span class="contright">{L_GUILD_MAX_SIZE}</span></td>
	</tr>
    <tr>
		<td class="row1" colspan="2">&nbsp;</td>
		<td class="row1" align="center" width="200px" height="150" rowspan="8" >{U_GUILDS_INFO_LOGO}</td>
	</tr>
	<tr>
		<td class="row1" width="40%"><span class="gen">{L_GUILDS_INFO_LEADER}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_LEADER}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_LEVEL}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_LEVEL}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_MEMBERS}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_MEMBERS}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_VAULT}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_VAULT} {L_GUILDS_INFO_POINTS}</span></td>
	</tr>
	<tr>
 		<td class="row1"><span class="gen">{L_ADR_DONATE_GUILD_FUND}</span></td>
 		<td class="row1" align="center"><input class="post" type="text" value="{POINTS}" class="post" maxlength="8" size="8" name="deposit_sum" /><span class="gensmall"> {L_POINTS}</span><input type="submit" value="Donate" name="deposit" class="liteoption" /></td>
 	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_DATE}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_DATE}</span></td>
	</tr>
    <tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_LENGTH}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_DATE2}{L_GUILDS_INFO_DATE2}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_COPPER_PEC}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_COPPER_PEC} %</span></td>
		<td class="row1" align="center">{U_GUILDS_INFO_EXP}<br><span class="gensmall">{U_GUILDS_INFO_EXP_MIN}/{U_GUILDS_INFO_EXP_MAX}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_EXP_PEC}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_EXP_PEC} %</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_HEAL_PEC}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_HEAL_PEC} %</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" class="row3" colspan="3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_INFO_RANKS}';"><span class="gen"><b>{L_GUILDS_INFO_RANKS}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row3" colspan="3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{U_GUILDS_INFO_BIO}';"><span class="gen"><b>{L_GUILDS_INFO_BIO}</b></span></td>
	</tr>
	<!-- BEGIN guild_forum -->
	<tr>
		<td align="center" class="row3" colspan="3" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR3}" onClick="window.location.href='{guild_forum.U_GUILDS_FORUM}';"><span class="gen"><b>{guild_forum.L_GUILDS_FORUM}</b></span></td>
	</tr>
	<!-- END guild_forum -->
{U_GUILDS_FORUMS}
	<tr>
		<td class="row2" colspan="3"><b>{L_GUILDS_INFO_JOIN_REQS}</b></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_JOIN_ACCEPT_NEW}</span></td>
		<td class="row1"align="center"><span class="gen">{L_GUILDS_INFO_JOIN_ACCEPT}</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
      <tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_JOIN_APPROVE_NEW}</span></td>
		<td class="row1" align="center"><span class="gen">{L_GUILDS_INFO_JOIN_APPROVE}</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GUILDS_INFO_JOIN_LEVEL}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_JOIN_LEVEL}</span></td>
		<td class="row1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" ><span class="gen">{L_GUILDS_INFO_JOIN_MONEY}</span></td>
		<td class="row1" align="center"><span class="gen">{U_GUILDS_INFO_JOIN_MONEY}</span></td>
		<td class="row1" width="223">&nbsp;</td>
	</tr>
	<tr> 
	  <td class="catbottom" colspan="3" height="28" width="801">&nbsp;</td>
	</tr>
</table>
<br />
<table class="forumline" align="center" width="200" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_BACK}';" width="449"><span class="gen">{L_GUILDS_BACK}</span></td>	
	</tr>
</table>
<!-- END guilds_info_page -->

<!-- BEGIN guilds_join_button -->
<br /><br />
<table class="forumline" align="center" width="400" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_JOIN_BUTTON}';" width="449"><span class="gen"><b>{L_GUILDS_JOIN_BUTTON}</b></span></td>	
	</tr>
</table>
<!-- END guilds_join_button -->


<!-- BEGIN guilds_retract_button -->
<br /><br />
<table class="forumline" align="center" width="400" cellspacing="1" cellpadding="3" border="0">

	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_RETRACT_BUTTON}';" width="449"><span class="gen"><b>{L_GUILDS_RETRACT_BUTTON}</b></span></td>	
	</tr>
</table>
<!-- END guilds_retract_button -->

<!-- BEGIN guilds_leader_button -->
<br /><br />
<table class="forumline" align="center" width="400" cellspacing="1" cellpadding="3" border="0">
	<tr>
 		<td class="row1" width="382"><span class="gen">{L_ACCOUNT_WITHDRAW}</span></td>
 		<td class="row1" width="205" align="center"><input class="post" type="text" value="{ACCOUNT_SUM}" class="post" maxlength="8" size="8" name="withdraw_sum" /> <span class="gensmall"> {L_POINTS}</span><input type="submit" value="Go" name="withdraw" class="liteoption" /></td>
 	</tr>
	<tr>
		<td align="center" class="row1" colspan="2" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_LEADER_BUTTON}';" width="449"><span class="gen"><b>{L_GUILDS_LEADER_BUTTON}</b></span></td>	
	</tr>
</table>
<!-- END guilds_leader_button -->


<!-- BEGIN guilds_leave_button -->
<br /><br />
<table class="forumline" align="center" width="400" cellspacing="1" cellpadding="3" border="0">

	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_LEAVE_BUTTON}';" width="449"><span class="gen"><b>{L_GUILDS_LEAVE_BUTTON}</b></span></td>	
	</tr>
</table>
<!-- END guilds_leave_button -->

<!-- BEGIN guilds_ranks -->
<br />
  <table border="0" cellpadding="4" cellspacing="0" align="center" width="811" class="forumline" style="border-collapse: collapse" bordercolor="#111111">
	<tr>
		<td class="row2" width="801" colspan="8" align="center"><b><font size="6">{U_GUILDS_RANKS_NAME}</font></b></td>
	</tr>
  <tr>
		<td class="row2" width="792" colspan="8"><p align="center"><b>{L_GUILDS_RANKS}</b></td>
	</tr>
	<tr>
		<td class="row1" width="162">&nbsp;</td>
		<td class="row1" width="162" colspan="2" style="border-right-style: solid; border-right-width: 1">&nbsp;</td>
		<td class="row3" width="162" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><p align="center"><b>{L_GUILD_LEADER}</b></td>
		<td class="row1" width="162" colspan="2" style="border-left-style: solid; border-left-width: 1">&nbsp;</td>
		<td class="row1" width="162">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="162">&nbsp;</td>
		<td class="row1" width="162" colspan="2" style="border-right-style: solid; border-right-width: 1">&nbsp;</td>
		<td class="row2" width="162" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1"><p align="center">{U_GUILD_LEADER}</td>
		<td class="row1" width="162" colspan="2" style="border-left-style: solid; border-left-width: 1">&nbsp;</td>
		<td class="row1" width="162">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="162" align="center">&nbsp;</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-bottom-style: solid; border-bottom-width: 1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-bottom-style: solid; border-bottom-width: 1">&nbsp;</td>
		<td class="row1" width="162" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="162" align="center" style="border-right-style: solid; border-right-width: 1">&nbsp;</td>
		<td class="row3" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><b>{L_GUILD_RANK1}</b></td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-left-style:solid; border-left-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row3" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><b>{L_GUILD_RANK2}</b></td>
		<td class="row1" width="162" align="center" style="border-left-style: solid; border-left-width: 1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="162" align="center" style="border-right-style: solid; border-right-width: 1">&nbsp;</td>
		<td class="row2" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1">{U_GUILD_RANK1}</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-top-style: solid; border-top-width: 1; border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row2" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1">{U_GUILD_RANK2}</td>
		<td class="row1" width="162" align="center" style="border-left-style: solid; border-left-width: 1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="162" align="center" style="border-bottom-style: solid; border-bottom-width: 1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-bottom-style: solid; border-bottom-width: 1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-top-style:solid; border-top-width:1">&nbsp;</td>
		<td class="row1" width="162" align="center" style="border-bottom-style: solid; border-bottom-width: 1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row3" width="162" align="center" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><b>{L_GUILD_RANK3}</b></td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-left-style:solid; border-left-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row3" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><b>{L_GUILD_RANK4}</b></td>
		<td class="row1" width="81" align="center" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-left-style:solid; border-left-width:1">&nbsp;</td>
		<td class="row1" width="81" align="center" style="border-left-style: solid; border-left-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row3" width="162" align="center" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><b>{L_GUILD_RANK5}</b></td>
	</tr>
	<tr>
		<td class="row2" width="162" align="center" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1"><p align="center">{U_GUILD_RANK3}</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-top-style: solid; border-top-width: 1; border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row2" width="162" align="center" colspan="2" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1">{U_GUILD_RANK4}</td>
		<td class="row1" width="162" align="center" colspan="2" style="border-top-style: solid; border-top-width: 1; border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1">&nbsp;</td>
		<td class="row2" width="162" align="center" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1">{U_GUILD_RANK5}</td>
	</tr>
	<tr>
		<td class="row1" width="405" colspan="4" style="border-right-style: solid; border-right-width: 1; border-bottom-style:solid; border-bottom-width:1">&nbsp;</td>
		<td class="row1" width="405" colspan="4" style="border-left-style: solid; border-left-width: 1; border-bottom-style:solid; border-bottom-width:1">&nbsp;</td>
	</tr>
	<tr>
		<td class="row3" width="810" colspan="8" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1"><p align="center"><b><i>{L_GUILD_MEMBERS}</i></b></td>
	</tr>
	<tr>
		<td class="row2" width="810" colspan="8" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1"><p align="center"><i>{U_GUILD_MEMBERS}</i></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="8" height="28" width="801">&nbsp;</td>
	</tr>
	</table>
  </center>
<br />

<table class="forumline" align="center" width="200" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_BACK}';" width="449"><span class="gen">{L_GUILDS_BACK}</span></td>	
	</tr>
</table>
<!-- END guilds_ranks -->

<!-- BEGIN guilds_bio -->
<br />
<table border="0" cellpadding="4" cellspacing="1" width="90%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="3">{L_GUILDS_BIO_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="50%" colspan="3">&nbsp;</td>
		</tr>
    <tr>
		<td class="row1" width="15%">
        <p align="center">&nbsp;</td>
		<td class="row1" width="70%">
        <p align="center">{U_GUILDS_BIO}</td>
		<td class="row1" width="15%">&nbsp;</td>
		</tr>
	<tr>
		<td class="row1" width="50%" colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="3"><input type="hidden" name="mode" value="guilds_create" /><input type="hidden" name="sub_mode" value="guilds_create_success" />&nbsp;</td>
	</tr>
</table>
<br /><br />
<table class="forumline" align="center" width="200" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<td align="center" class="row1" onMouseOver="this.style.backgroundColor='{T_TD_COLOR2}'; this.style.cursor='pointer';" onMouseOut=this.style.backgroundColor="{T_TR_COLOR1}" onClick="window.location.href='{U_GUILDS_BACK}';" width="449"><span class="gen">{L_GUILDS_BACK}</span></td>	
	</tr>
</table>
<!-- END guilds_bio -->

</form>
