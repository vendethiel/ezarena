
<h1>{L_EXT_TITLE}</h1>

<p>{L_EXT_EXPLAIN}</p>

<table width="99%" cellpadding="1" cellspacing="1" border="0" align="center">
	<tr>
		<td>
			<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
				<tr>
				  <th class="thHead" colspan="6">{L_EXT_CHG_HOSTER}</th>
				</tr>
				<tr>
					<td class="row2" width="3%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_ENABLE}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_NAME}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_URL}</strong></span></td>
					<td class="row2" width="20%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_UB}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_UBC}</strong></span></td>
					<td class="row2" width="14%"></td>
				</tr>
				<!-- BEGIN hoster_row -->
				<form name="{hoster_row.EXT_FORM_NAME}" method="post" action="{hoster_row.S_EXT_HOST_ACT}">
				<tr>
					<td align="center" class="{hoster_row.EXT_ROW_CLASS}"><input type="hidden" name="ext_id" value="{hoster_row.EXT_ID}"><input type="checkbox" name="ext_enabled" {hoster_row.EXT_ENA}></td>
					<td class="{hoster_row.EXT_ROW_CLASS}"><input class="post" type="text" maxlength="50" size="30" name="ext_name" value="{hoster_row.EXT_NAME}" /></td>
					<td class="{hoster_row.EXT_ROW_CLASS}"><input class="post" type="text" maxlength="150" size="30" name="ext_url" value="{hoster_row.EXT_URL}" /></td>
					<td align="center" class="{hoster_row.EXT_ROW_CLASS}"><input type="checkbox" name="ext_ub" {hoster_row.EXT_UB}></td>
					<td class="{hoster_row.EXT_ROW_CLASS}"><input class="post" type="text" maxlength="255" size="25" name="ext_ubc" value="{hoster_row.EXT_UBC}" /></td>
					<td class="{hoster_row.EXT_ROW_CLASS}">
						<input type="submit" name="change" value="{L_EXT_CHG}" class="mainoption">
						<input type="submit" name="delete" value="{L_EXT_DEL}" class="liteoption">
					</td>
				</tr>
				</form>
				<!-- END hoster_row -->
			</table>
			
			<br />
			
			<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
				<tr>
				  <th class="thHead" colspan="6">{L_EXT_NEW_HOSTER}</th>
				</tr>
				<tr>
					<td class="row2" width="3%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_ENABLE}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_NAME}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_URL}</strong></span></td>
					<td class="row2" width="20%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_UB}</strong></span></td>
					<td class="row2" width="14%" align="center" valign="middle"><span class="genmed"><strong>{L_EXT_UBC}</strong></span></td>
					<td class="row2" width="14%"></td>
				</tr>
				<form name="new_hoster" method="post" action="{S_EXT_NEW_HOSTER}">
				<tr>
					<td align="center" class="row1"><input type="checkbox" name="ext_enabled"></td>
					<td class="row1"><input class="post" type="text" maxlength="50" size="30" name="ext_name" value="" /></td>
					<td class="row1"><input class="post" type="text" maxlength="150" size="30" name="ext_url" value="" /></td>
					<td align="center" class="row1"><input type="checkbox" name="ext_ub"></td>
					<td class="row1"><input class="post" type="text" maxlength="255" size="25" name="ext_ubc" value="" /></td>
					<td class="row1">
					<input type="submit" name="new" value="{L_EXT_NEW}" class="mainoption">
						<input type="reset" name="reset" value="{L_EXT_RESET}" class="liteoption">
					</td>
				</tr>
				</form>
				<tr>
					<td class="row2">&nbsp;</td>
					<td class="row2" valign="top">{L_EXT_NAME_EXPLAIN}</td>
					<td class="row2" valign="top">{L_EXT_URL_EXPLAIN}</td>
					<td class="row2">&nbsp;</td>
					<td class="row2" valign="top">{L_EXT_UBC_EXPLAIN}</td>
					<td class="row2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
