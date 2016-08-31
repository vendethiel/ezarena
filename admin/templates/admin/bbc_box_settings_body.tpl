
<h1>{L_BBC_SETTINGS_TITLE}</h1>

<p>{L_BBC_SETTINGS_EXPLAIN}</p>

<form action="{S_BBC_SETTINGS_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_BBC_SETTINGS_TITLE}</th>
	</tr>
	<tr>
		<td class="catSides" align="center" colspan="2"><span class="cattitle">{L_BBC_SETTINGS_ADJUST}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_BBC_SWITCH_SELECT}<br /><span class="gensmall">{L_BBC_SWITCH_SELECT_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="bbc_box_on" value="1" {BBC_SWITCH_ON} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="bbc_box_on" value="0" {BBC_SWITCH_OFF} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_BBC_MODE_SELECT}<br /><span class="gensmall">{L_BBC_MODE_SELECT_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="bbc_advanced" value="1" {BBC_MODE_SELECT_ADV} /> {L_BBC_ADVANCED}&nbsp;&nbsp;<input type="radio" name="bbc_advanced" value="0" {BBC_MODE_SELECT_BGN} /> {L_BBC_BEGINNER}</td>
	</tr>
	<tr>
		<td class="row1">{L_BBC_PER_ROW}<br /><span class="gensmall">{L_BBC_PER_ROW_EXPLAIN}</span></td>
		<td class="row2" width="40%"><input type="text" class="post" name="bbc_per_row" size="4" maxlength="4" value="{BBC_PER_ROW}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SKIN}</td>
		<td class="row2" width="40%">{S_CATEGORY_SELECT}&nbsp;<input type="submit" class="liteoption" value="{L_PREVIEW}" name="bbc_style_prev" /></td>
	</tr>
	<tr>
		<td class="row1" colspan="2"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		  <!-- BEGIN bbc_row -->
		  <tr>
			<!-- BEGIN bbc_column -->
			<td><img src="{bbc_row.bbc_column.BBC_IMAGE}" alt="{bbc_row.bbc_column.BBC_NAME}" title="{bbc_row.bbc_column.BBC_NAME}" /></td>
			<!-- END bbc_column -->
		  </tr>
		  <!-- END bbc_row -->
		</table></td>
	</tr>
	<tr>
		<td class="catSides" align="center" colspan="2"><span class="cattitle">{L_BBC_SETTINGS_CACHE}</span></td>
	</tr>
	<tr>
		<td class="row1" width="40%">{L_BBC_CACHE}</td>
		<td class="row2"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		  <tr>
			<td><input type="image" src="{I_REGEN}" name="regen_bbc_cache" value="regen_bbc_cache" title="{L_REGEN}" /></td>
			<td><span class="gensmall"><b>{L_LAST_REGEN}:</b> {L_BBC_TIME_REGEN}</span></td>
		  </tr>
		</table></td>
	</tr>
	<tr>
		<td class="catbottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<span class="gensmall">
			<input type="image" src="{I_SUBMIT}" name="submit" title="{L_SUBMIT}" />
		</span></td>
	</tr>
</table></form>

<br clear="all" />
