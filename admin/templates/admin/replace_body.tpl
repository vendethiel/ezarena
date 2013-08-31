
<h1>{L_REPLACE_TITLE}</h1>

<P>{L_REPLACE_TEXT}</p>

<!-- BEGIN switch_forum_sent -->
<p><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL" width="5%">#</th>
		<th class="thTop" width="25%">{L_FORUM}</th>
		<th class="thTop" width="30%">{L_TOPIC}</th>
		<th class="thTop" width="20%">{L_AUTHOR}</th>
		<th class="thCornerR" width="20%">{L_LINK}</th>
	</tr>
	<tr>
		<td class="catBottom" colspan="3" align="center">{L_STR_OLD}: {STR_OLD}</td>
		<td class="catBottom" colspan="2" align="center">{L_STR_NEW}: {STR_NEW}</td>
	</tr>
	<!-- BEGIN switch_no_results -->
	<tr>
		<td class="row1" colspan="5" align="center" style="padding:10px;">{L_NO_RESULTS}</td>
	</tr>
	<!-- END switch_no_results -->
	<!-- BEGIN replaced -->
	<tr>
		<td class="{switch_forum_sent.replaced.ROW_CLASS}" align="center">{switch_forum_sent.replaced.NUMBER}</td>
		<td class="{switch_forum_sent.replaced.ROW_CLASS}"><a href="{switch_forum_sent.replaced.U_FORUM}" target="_blank">{switch_forum_sent.replaced.FORUM_NAME}</a></td>
		<td class="{switch_forum_sent.replaced.ROW_CLASS}"><a href="{switch_forum_sent.replaced.U_TOPIC}" target="_blank">{switch_forum_sent.replaced.TOPIC_TITLE}</a></td>
		<td class="{switch_forum_sent.replaced.ROW_CLASS}"><a href="{switch_forum_sent.replaced.U_AUTHOR}" target="_blank">{switch_forum_sent.replaced.AUTHOR}</a></td>
		<td class="{switch_forum_sent.replaced.ROW_CLASS}" align="center"><a href="{switch_forum_sent.replaced.U_POST}" target="_blank"><img src="{POST_IMG}" alt="" title="" border="" /></a> {switch_forum_sent.replaced.POST}</td>
	</tr>
	<!-- END replaced -->
	<tr>
		<td class="catBottom" colspan="5" align="center" style="font-weight:bold;">{REPLACED_COUNT}</td>
	</tr>
</table></p>
<!-- END switch_forum_sent -->

<form method="post" action="{S_FORM_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thTop" colspan="2" width="25%">{L_REPLACE_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="50%" align="right">{L_STR_OLD}:</td>
		<td class="row1" width="50%"><input class="post" type="text" name="str_old" value="" style="width:99%;" /></td>
	</tr>
	<tr>
		<td class="row2" align="right">{L_STR_NEW}:</td>
		<td class="row2"><input class="post" type="text" name="str_new" value="" style="width:99%;" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>
