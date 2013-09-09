<h1>{L_LIBRARY_TITLE}</h1>

<p>{L_LIBRARY_TEXT}</p>

<form method="post" action="{S_LIBRARY_ACTION}">

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;:&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_LIBRARY_NAME}</th>
		<th class="thTop">{L_LIBRARY_ZONE}</th>
		<th class="thTop">{L_LIBRARY_DIFFICULTY}</th>
		<th class="thTop">{L_LIBRARY_FALSE}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN library -->
	<tr>
		<td class="{library.ROW_CLASS}" align="center">{library.NAME}</td>
		<td class="{library.ROW_CLASS}" align="center">{library.ZONE}</td>
		<td class="{library.ROW_CLASS}" align="center">{library.DIFFICULTY}</td>
		<td class="{library.ROW_CLASS}" align="center">{library.FALSE}</td>
		<td class="{library.ROW_CLASS}" align="center">{library.CRAFTING}</td>
		<td class="{library.ROW_CLASS}" align="center"><a href="{library.U_LIBRARY_EDIT}">{L_EDIT}</a></td>
		<td class="{library.ROW_CLASS}" align="center"><a href="{library.U_LIBRARY_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END library -->
	<tr>
		<td class="catBottom" colspan="12" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_LIBRARY_ADD}" class="mainoption" /></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
   <tr>
      <td><span class="nav">{PAGE_NUMBER}</span></td>
      <td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
   </tr>
</table>
</form>

<br clear="all" />