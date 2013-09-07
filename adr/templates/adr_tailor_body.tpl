<br /><br />
<form method="post" action="{S_TOWN_ACTION}">
<!-- BEGIN main -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='{U_TAILORING}';" onmouseout="this.className='row1';"><span class="gen">{L_TAILORING}</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN tailoring -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >Tailoring</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<b>{L_TAILORING}</b><br /><br />
		<br />{L_TAILORING_EXPLAIN_AREA}<br /><br />
		<br /><img src="adr/images/items/clothes/tailorer.gif " alt="tailor helper" border="0" /><br />
		<br />{L_GO_TO_TAIL}:<br /><br />&nbsp;&nbsp;<a href="adr_character.php"><img src="adr/images/misc/Icon_Char.gif " alt="{L_GO_TO_TAIL}" border="0" /></a><br />
		<br /></span>
		</td>
</form>
<form method="post" action="{S_TAILOR_ACTION}">
		<td align="center" class="row1" >		
		<img src="adr/images/items/clothes/tailorhouse.gif " alt="tailor house" border="0" /><hr />
		<br /><span class="gen">{L_SELECT_TOOL}:</span><br /><br />
		<span class="gen"><img src="adr/images/items/clothes/tailor.gif" border="0" />&nbsp;&nbsp;{TOOL_LIST}</span>
		<br /><br /<br /><img src="adr/images/skills/skill_tailoring.gif" border="0" /><br /><br /><input type="hidden" name="mode" value="tailoring_action"><input type="submit" value="{L_GO_TAILORING}" class="mainoption" /><br />
		</td>
	</tr>
</table>
<!-- END tailoring -->
</form>
<br clear="all" />