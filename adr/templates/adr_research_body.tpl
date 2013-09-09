<!-- BEGIN research -->
<table width="100%" align="center" border="1">
	<tr>
		<th align="center" colspan="3" >{L_RESEARCH_TITLE}</td>
	</tr>
	<tr>
		<td align="center" valign="top" class="row2" width="20%" ><span class="gen">
			<b>{L_RESEARCH}</b><br /><br />
			<br />{L_RESEARCH_EXPLAIN}<br /><br />
			<br /><br /><img src="adr/images/library/book.jpg" alt="{L_RESEARCH_HELPER}" border="0" /><br />
			<br /><br /><br /><br />Return to Zone:<br /><a href="adr_zones.php"><img src="adr/images/library/village.gif " alt= "Return to Zone" border="0" /></a>
			<br /></span>
		</td>
<form method="post" action="{S_FORGE_ACTION}">
		<td align="center" class="row1" valign="top">		
			<img src="adr/images/library/library.jpg" alt="{L_RESEARCH}" width="100%" border="0" /><hr />
			<span class="gen">You have {POINTS} {L_POINTS} for research.<br />
			<br /><br /<br /><img src="adr/images/library/researchbook.png" border="0" /><br /><br />
			<input type="hidden" name="mode" value="library_action" />
			<input type="submit" value="{L_PERFORM_RESEARCH}" class="mainoption" /><br /><br />
			{L_RESEARCH_KEEP}<br /><input type="checkbox" name="research_keep" value="1" /></span>
		</td>
	</tr>
</table>
<!-- END research -->
</form>
<br clear="all" />