<!-- $Id: title_list_body.tpl,v 1.7.1 2007/10/01 14:11 OxyGen Powered Exp $ -->

<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>

<form method="post" action="{S_ATTR_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop">{L_ATTRIBUTE}</th>
		<th class="thTop">{L_COLOR}</th>
		<th class="thTop">{L_PERMISSIONS}</th>
		<th class="thTop">{L_DATE_FORMAT}</th>
		<th class="thTop">{L_POSITION}</th>
		<th class="thTop">{L_ACTION}</th>
	</tr>
	<!-- BEGIN attribute -->
	<tr>
		<td class="{attribute.ROW_CLASS}" align="center">{attribute.ATTRIBUTE}</td>
		<td class="{attribute.ROW_CLASS}" align="center">{attribute.COLOR}</td>
		<td class="{attribute.ROW_CLASS}" align="center">{attribute.PERMISSIONS}</td>
		<td class="{attribute.ROW_CLASS}" align="center">{attribute.DATE_FORMAT}</td>
		<td class="{attribute.ROW_CLASS}" align="center">{attribute.POSITION}</td>
		<td class="{attribute.ROW_CLASS}" align="center" nowrap="nowrap"><table cellpadding="0" cellspacing="1" border="0">
		  <tr>
			<td><a href="{attribute.U_MOVEUP}" title="{L_MOVEUP}"><img src="{I_MOVEUP}" alt="{L_MOVEUP}" border="0" /></a></td>
			<td><a href="{attribute.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" alt="{L_EDIT}" border="0" /></a></td>
		  </tr>
		  <tr>
			<td><a href="{attribute.U_MOVEDW}" title="{L_MOVEDW}"><img src="{I_MOVEDW}" alt="{L_MOVEDW}" border="0" /></a></td>
			<td><a href="{attribute.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" alt="{L_DELETE}" border="0" /></a></td>
		  </tr>
		</table></td>
	</tr>
	<!-- END attribute -->
	<tr>
		<td class="catBottom" align="center" colspan="6">{S_HIDDEN_FIELDS}<span class="gensmall">
		<a href="{U_CREATE}" title="{L_CREATE}"><img src="{I_CREATE}" alt="{L_CREATE}" border="0" /></a>
		</span></td>
	</tr>
</table></form>
<br clear="all" />
