
<form method="post" action="{S_CLASSES_ACTION}">

<h1>{L_CLASSES_TITLE}</h1>

<p>{L_CLASSES_EXPLAIN}</p>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_NAME}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="class_name" value="{CLASS_NAME}" size="30" maxlength="255" />
	<!-- BEGIN classes_edit -->
		<br /><span class="gensmall">{CLASS_NAME_EXPLAIN}</span>
	<!-- END classes_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_DESC}<br /><span class="gensmall">{L_NAME_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input type="text" name="class_desc" value="{CLASS_DESC}" size="30" rowspan="2" maxlength="255" />
	<!-- BEGIN classes_edit -->
		<br /><span class="gensmall">{CLASS_DESC_EXPLAIN}</span>
	<!-- END classes_edit -->
		</td>
	</tr>
	<tr>
		<td class="row1">{L_IMG}<br /><span class="gensmall">{L_IMG_EXPLAIN}</span></td>
	<!-- BEGIN classes_add -->
		<td class="row2" align="center" ><input type="text" name="class_img" size="30" maxlength="255" /></td>
	<!-- END classes_add -->
	<!-- BEGIN classes_edit -->
		<td class="row2" align="center" ><input type="text" name="class_img" value="{CLASS_IMG}" size="30" maxlength="255" /><br /><img src="../adr/images/classes/{CLASS_IMG}" alt="{CLASS_NAME}" /></td>
	<!-- END classes_edit -->
	</tr>
	<tr>
		<td class="row1">{L_LEVEL}<br /><span class="gensmall">{L_LEVEL_EXPLAIN}</span></td>
		<td class="row2" align="center" >{LEVEL_LIST}</td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="60%">
	<tr>
		<td class="row1" width="60%">{L_MIGHT_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="might_req" value="{MIGHT_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_DEXT_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="dext_req" value="{DEXT_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CONST_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="const_req" value="{CONST_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_INT_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="int_req" value="{INT_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_WIS_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="wis_req" value="{WIS_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CHA_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="cha_req" value="{CHA_REQ}" size="8" maxlength="8" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1" width="60%">{L_BASE_HP}</td>
		<td class="row2" align="center" ><input type="text" name="base_hp" value="{BASE_HP}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BASE_MP}</td>
		<td class="row2" align="center" ><input type="text" name="base_mp" value="{BASE_MP}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BASE_AC}</td>
		<td class="row2" align="center" ><input type="text" name="base_ac" value="{BASE_AC}" size="8" maxlength="8" /></td>
	</tr>
</table>

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="90%">
	<tr>
		<td class="row1">{L_UPDATE_HP}</td>
		<td class="row2" align="center" ><input type="text" name="update_hp" value="{UPDATE_HP}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_UPDATE_MP}</td>
		<td class="row2" align="center" ><input type="text" name="update_mp" value="{UPDATE_MP}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_UPDATE_AC}</td>
		<td class="row2" align="center" ><input type="text" name="update_ac" value="{UPDATE_AC}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1" width="60%">{L_UPDATE_XP_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="update_xp_req" value="{UPDATE_XP_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_UPDATE_OF}</td>
		<td class="row2" align="center" >{EVOLUTION_LIST}</td>
	</tr>
	<tr>
		<td class="row1">{L_UPDATE_OF_REQ}</td>
		<td class="row2" align="center" ><input type="text" name="update_of_req" value="{UPDATE_OF_REQ}" size="8" maxlength="8" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SELECTABLE}</td>
		<td class="row2" align="center" ><input type="checkbox" name="selectable" value="1" {SELECTABLE_CHECKED} /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center" width="95%">
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>

</form>