<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_OWNER_LIST}</span></td>
	  <td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
		<input type="submit" name="Owner_list" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
</table>

<form method="post" action="{S_MODE_ACTION}">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr> 
	  <th class="thHead">#</th>
	  <th class="thHead">{L_USERNAME}</th>
	  <th class="thHead">{L_PET_NAME}</th>
	  <th class="thHead">{L_PET_TYPE}</th>
	  <th class="thHead">{L_PET_AGE}</th>
	</tr>
	<!-- BEGIN owner_list -->
	<tr> 
	  <td class="{owner_list.ROW_CLASS}" align="center"><span class="gen">&nbsp;{owner_list.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{owner_list.ROW_CLASS}" align="center"><span class="gen"><a href="{owner_list.U_VIEWPROFILE}" class="gen">{owner_list.USERNAME}</a></span></td>
	  <td class="{owner_list.ROW_CLASS}" align="center" valign="middle"><span class="gen"><a href="{owner_list.U_RABBITOSHI}" class="gen">{owner_list.PET_NAME}</a><br />{owner_list.PET_IMG}</span></td>
	  <td class="{owner_list.ROW_CLASS}" align="center" valign="middle"><span class="gen">{owner_list.PET_TYPE}</span></td>
	  <td class="{owner_list.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{owner_list.PET_AGE}</span></td>
	</tr>
	<!-- END owner_list -->
	<tr> 
		<td class="catBottom" colspan="5">&nbsp;</td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
</form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>