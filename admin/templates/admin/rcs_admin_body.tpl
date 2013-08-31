<!-- $Id: rcs_admin_body.tpl,v 0.6 24/11/2006 15:27 reddog Exp $ -->

<script type="text/javascript" src="./../templates/_shared/picker/picker.js"></script>

<h1>{L_RCS_SETTINGS_TITLE}</h1>

<p>{L_RCS_SETTINGS_TITLE_DESC}</p>

<form action="{S_RCS_ACTION}" method="post">
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead" colspan="2">{L_RCS_STYLE_SETTINGS}</th>
</tr>
<tr>
	<td class="row1" width="38%"><span class="genmed">{L_RCS_SELECT_STYLE}</span></td>
	<td class="row2"><span class="genmed">{LIST_BOX}</span></td>
</tr>
<!-- BEGIN style -->
<tr>
	<td class="row1"><span class="genmed">{style.L_OPTION_TITLE}:</span></td>
	<td class="row2"><span class="genmed">
		<input class="post" type="text" id="{style.OPTION_NAME}" name="{style.OPTION_NAME}" size="7" maxlength="6" value="{style.OPTION_VALUE}" onchange="previewColor('preview_{style.OPTION_NAME}', this.value);" />
		<input class="cp_preview" type="text" readonly="readonly" size="1" id="preview_{style.OPTION_NAME}" title="{L_PICK_COLOR}" onclick="showColorPicker(this, document.forms[0].{style.OPTION_NAME}, 'preview_{style.OPTION_NAME}'); return false;" />
	</span></td>
</tr>
<!-- END style -->
<tr>
	<td class="catBottom middle" colspan="2">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_SUBMIT}" name="updated_style" alt="{L_SUBMIT}" title="{L_SUBMIT}" />
	</span></td>
</tr>
</table>
<br class="both" />
<!-- BEGIN cache -->
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead" colspan="2">{L_RCS_CACHE_SETTINGS}</th>
</tr>
<tr>
	<td class="row1" width="38%"><span class="genmed">{cache.L_RCS_CACHE}</span></td>
	<td class="row2"><span class="genmed">
		<input class="absbottom" type="radio" id="cache_rcs_1" name="cache_rcs" value="1"{cache.CACHE_RCS_YES} /><label for="cache_rcs_1">{L_YES}</label>&nbsp;
		<input class="absbottom" type="radio" id="cache_rcs_0" name="cache_rcs" value="0"{cache.CACHE_RCS_NO} /><label for="cache_rcs_0">{L_NO}</label>&nbsp;
		<input type="image" src="{I_REGEN}" name="regen_cache_rcs" alt="{L_REGEN}" title="{L_REGEN}" class="absbottom" />
	</span><br class="both" /><span class="gensmall">
		<strong>{cache.L_LAST_REGEN}:</strong> {cache.L_RCS_REGEN_TIME}
	</span></td>
</tr>
</table>
<br class="both" />
<!-- END cache -->
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead" colspan="2">{L_RCS_MAIN_SETTINGS}</th>
</tr>
<!-- BEGIN config -->
<tr>
	<td class="row1" width="38%"><span class="genmed">
		{config.L_OPTION_TITLE}
	</span><br class="both" /><span class="gensmall">
		{config.L_OPTION_DESC}
	</span></td>
	<td class="row2"><span class="genmed">
		<input class="absbottom" type="radio" id="{config.OPTION_NAME}_1" name="{config.OPTION_NAME}" value="1"{config.OPTION_YES} /><label for="{config.OPTION_NAME}_1">{L_YES}</label>&nbsp;
		<input class="absbottom" type="radio" id="{config.OPTION_NAME}_0" name="{config.OPTION_NAME}" value="0"{config.OPTION_NO} /><label for="{config.OPTION_NAME}_0">{L_NO}</label>
	</span></td>
</tr>
<!-- END config -->
<tr>
	<td class="row1"><span class="genmed">
		{L_RCS_LEVEL_RANKS}
	</span><br class="both" /><span class="gensmall">
		{L_RCS_LEVEL_RANKS_DESC}
	</span></td>
	<td class="row2"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<!-- BEGIN level_ranks -->
	<tr>
		<td><span class="gensmall">{level_ranks.L_OPTION_TITLE}</span></td>
		<td width="100%"><span class="genmed">
			<input class="absbottom" type="radio" id="{level_ranks.OPTION_NAME}_1" name="{level_ranks.OPTION_NAME}" value="1"{level_ranks.OPTION_YES} /><label for="{level_ranks.OPTION_NAME}_1">{L_YES}</label>&nbsp;
			<input class="absbottom" type="radio" id="{level_ranks.OPTION_NAME}_0" name="{level_ranks.OPTION_NAME}" value="0"{level_ranks.OPTION_NO} /><label for="{level_ranks.OPTION_NAME}_0">{L_NO}</label>
		</span></td>
	</tr>
	<!-- END level_ranks -->
	</table></td>
</tr>
<tr>
	<td class="catBottom middle" colspan="2">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_SUBMIT}" name="submit_form" alt="{L_SUBMIT}" title="{L_SUBMIT}" />
	</span></td>
</tr>
</table>
</form>
<br class="both" />
<script type="text/javascript">
//<![CDATA[
<!--//
<!-- BEGIN style -->
previewColor('preview_{style.OPTION_NAME}', document.getElementById('{style.OPTION_NAME}').value);
<!-- END style -->
//-->
//]]>
</script>