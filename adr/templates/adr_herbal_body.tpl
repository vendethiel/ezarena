<br /><br />
<form method="post" action="{S_TOWN_ACTION}">
<!-- BEGIN main -->
<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="50%" >
	<tr>
		<td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='{U_HERBALISM}';" onmouseout="this.className='row1rt';"><span class="gen">Herbalisming</span></td>
	</tr>
</table>
<!-- END main -->

<!-- BEGIN herbalism -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >Herbalism</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
		<b>{L_HERBALISM}</b><br /><br />
		<br />{L_HERBALISM_EXPLAIN_AREA}<br /><br />
		<br /><img src="adr/images/items/plants/herbalhelper.gif" alt="herbal helper" border="0" /><br />
		<br />{L_GO_TO_HERB}:<br /><br />&nbsp;&nbsp;<a href="adr_character.php"><img src="adr/images/misc/Icon_Char.gif" alt="{L_GO_TO_HERB}" border="0" /></a><br />
		<br /></span>
		</td>
</form>
<form method="post" action="{S_HERBAL_ACTION}">
		<td align="center" class="row1" >		
		<img src="adr/images/items/plants/herbal.jpg" alt="herbal area" border="0" /><hr />
		<br /><span class="gen">{L_SELECT_TOOL}:</span><br /><br />
		<span class="gen"><img src="adr/images/items/medicimal/MedicalHerb.gif" border="0"/>&nbsp;&nbsp;{TOOL_LIST}</span>
		<br /><br /<br /><img src="adr/images/skills/skill_herbalism.gif" border="0"/><br /><br /><input type="hidden" name="mode" value="herbalism_action"><input type="submit" value="{L_GO_HERBALISM}" class="mainoption" /><br />
		</td>
	</tr>
</table>

<!-- END herbalism -->
</form>
<br clear="all" />