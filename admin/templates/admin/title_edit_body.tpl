<!-- $Id: title_edit_body.tpl,v 1.7.2 2007/11/21 12:00 OxyGen Powered Exp $ -->

<script type="text/javascript" src="./../templates/_shared/picker/picker.js"></script>
<script type="text/javascript">
<!--
	/**
	* Set display of page element
	* Borrowed from phpBB 3.0 (aka Olympus)
	* s[-1,0,1] = hide,toggle display,show
	*/
	function dE(n,s)
	{
		var e = document.getElementById(n);
		if (!s)
		{
			s = (e.style.display == '') ? -1 : 1;
		}
		e.style.display = (s == 1) ? '' : 'none';
	}
//-->
</script>

<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>

<form action="{S_ATTR_ACTION}" method="post"><table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th class="thTop" colspan="2">{L_TITLE}</th>
		</tr>
		<tr>
			<td class="row1 gen" width="42%">{L_ATTRIBUTE_TYPE}</td>
	  	<td class="row2">
				<select name="attribute_type" id="attribute_type" onchange="if (this.value=='1') { dE('image',1); } else { dE('image',-1); }">
				  <option value="0">{L_TEXT}</option>
				  <option value="1"{TYPE_IMAGE}>{L_IMAGE}</option>
				</select>
	  	</td>
		</tr>
		<tr>
			<td class="row1">
				<span class="gen">{L_ATTRIBUTE}</span><br />
				<span class="gensmall">{L_ATTRIBUTE_EXPLAIN}</span>
			</td>
			<td class="row2">
				<input class="post" type="text" name="attribute" size="35" maxlength="255" value="{ATTRIBUTE}" />
			</td>
		</tr>
		<tr id="image" style="{DISPLAY_IMAGE}">
			<td class="row1">
				<span class="gen">{L_ATTRIBUTE_IMAGE}</span><br />
				<span class="gensmall">{L_ATTRIBUTE_IMAGE_EXPLAIN}</span>
			</td>
			<td class="row2">
				<input type="text" name="attribute_image" id="attribute_image" value="{ATTRIBUTE_IMAGE}" size="35" maxlength="255" class="post" style="margin-top: 3px;" />
			</td>
		</tr>
		<tr>
			<td class="row1">
				<span class="gen">{L_PERMISSIONS}</span><br />
				<span class="gensmall">{L_PERMISSIONS_EXPLAIN}</span>
			</td>
			<td class="row2">
				<span class="post">
				<input type="checkbox" name="attribute_administrator" {ADMINISTRATOR_CHECKED} />&nbsp;{ADMINISTRATOR}&nbsp;&nbsp;
				<input type="checkbox" name="attribute_moderator" {MODERATOR_CHECKED} />&nbsp;{MODERATOR}&nbsp;&nbsp;
				<input type="checkbox" name="attribute_author" {AUTHOR_CHECKED} />&nbsp;{AUTHOR}</span>
			</td>
		</tr>
		<tr>
			<td class="row1">
				<span class="gen">{L_DATE_FORMAT}</span><br />
				<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span>
			</td>
			<td class="row2">
				<input class="post" type="text" name="attribute_date_format" size="15" maxlength="255" value="{DATE_FORMAT}" />
			</td>
		</tr>
		<tr>
			<td class="row1">
				<span class="gen">{L_POSITION}</span><br />
				<span class="gensmall">{L_POSITION_EXPLAIN}</span>
			</td>
			<td class="row2">
				<input type="radio" name="attribute_position" value="0" {LEFT} />&nbsp;{L_LEFT}&nbsp;
				<input type="radio" name="attribute_position" value="1" {RIGHT} />&nbsp;{L_RIGHT}
			</td>
		</tr>
		<tr>
			<td class="row1">
				<span class="gen">{L_COLOR}</span><br />
				<span class="gensmall">{L_COLOR_EXPLAIN}</span>
			</td>
			<td class="row2">
				<input class="post" type="text" id="attribute_color" name="attribute_color" size="15" maxlength="6" value="{COLOR}" onchange="previewColor('preview_attribute_color', this.value);" />
				<input class="cp_preview" type="text" readonly="readonly" size="1" id="preview_attribute_color" title="{L_PICK_COLOR}" onclick="showColorPicker(this, document.forms[0].attribute_color, 'preview_attribute_color'); return false;" />
			</td>
		</tr>
		<tr>
			<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<span class="gensmall">
				<input type="image" src="{I_SUBMIT}" name="submit_form" title="{L_SUBMIT}" />&nbsp;
				<input type="image" src="{I_CANCEL}" name="cancel_form" title="{L_CANCEL}" />
			</span></td>
		</tr>
</table></form>
<br clear="all" />

<script type="text/javascript">
//<![CDATA[
<!--//
previewColor('preview_attribute_color', document.getElementById('attribute_color').value);
//-->
//]]>
</script>

