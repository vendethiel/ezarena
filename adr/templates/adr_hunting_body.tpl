<br /><br />
<form method="post" action="{S_TOWN_ACTION}">
<!-- BEGIN main -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
   <tr>
      <td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='{U_HUNTING}';" onmouseout="this.className='row1rt';"><span class="gen">{L_HUNTING}</span></td>
   </tr>
</table>
<!-- END main -->

<!-- BEGIN hunting -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >Hunting</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<b>{L_HUNTING}</b><br /><br />
		<br />{L_HUNTING_EXPLAIN_AREA}<br /><br />
		<br /><img src="adr/images/items/hunting/hunter.gif " alt="hunter helper" border="0" /><br />
		<br />{L_GO_TO_HUNT}:<br /><br />&nbsp;&nbsp;<a href="adr_character.php"><img src="adr/images/misc/Icon_Char.gif" alt="{L_GO_TO_HUNT}" border="0" /></a><br />
		<br /></span>
		</td>
</form>
<form method="post" action="{S_HUNTING_ACTION}">
		<td align="center" class="row1" >		
		<img src="adr/images/items/hunting/huntingarea.jpg" alt="tailor house" border="0" /><hr />
		<br /><span class="gen">{L_SELECT_TOOL}:</span><br /><br />
		<span class="gen"><img src="adr/images/items/animals/smallknife.gif" border="0" />&nbsp;&nbsp;{TOOL_LIST}</span>
		<br /><br /<br /><img src="adr/images/skills/skill_hunting.gif" border="0" /><br /><br /><input type="hidden" name="mode" value="hunting_action"><input type="submit" value="{L_GO_HUNTING}" class="mainoption" /><br />
		</td>
	</tr>
</table>
<!-- END hunting -->
</form>
<br clear="all" />