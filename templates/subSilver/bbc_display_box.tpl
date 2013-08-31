		<!-- BEGIN bbc -->
	  	<tr valign="middle">
	  		<td>
	  		  <!-- BEGIN def -->
	  		  <a href="javascript:void(0);" onmouseover="helpline('{bbc.def.HELPLINE}')" onclick="bbstyle({bbc.def.BBSTYLE})"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="{ROOT_STYLE}{bbc.def.IMG}" name="addbbcode{bbc.def.BBSTYLE}" /></a>{bbc.def.DIVIDER}
	  		  <!-- END def -->
	  		</td>
	  	</tr>
	  	<!-- BEGIN row -->
	  	<tr valign="middle">
	  		<td>
	  		  <!-- BEGIN box -->
	  		  <a href="javascript:void(0);" onmouseover="helpline('{bbc.row.box.HELPLINE}')" onclick="bbstyle({bbc.row.box.BBSTYLE})"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="{ROOT_STYLE}{bbc.row.box.IMG}" name="addbbcode{bbc.row.box.BBSTYLE}" /></a>{bbc.row.box.DIVIDER}
	  		  <!-- END box -->
	  		</td>
	  	</tr>
	  	<!-- END row -->
		<tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td><span class="genmed"> &nbsp;{L_FONT_SIZE}:</span> {S_FONT_SIZE_TYPES}</td>
				<td><span class="genmed"> &nbsp;{L_FONT_TYPE}:</span> {S_FONT_TYPES_LIST}</td>
				<td class="gensmall" nowrap="nowrap" align="right"><span class="genmed"><a href="javascript:colorSwitch('bbc_fontcolor', 'bbc_backcolor');" onmouseover="helpline('swc')" onfocus="this.blur();"><img src="{ROOT_STYLE}{I_SWITCHCOLOR}" alt="" border="0" /></a>
					<a href="javascript:bbfontstyle('[hr]', '')" onmouseover="helpline('hr')" onfocus="this.blur();"><img src="{ROOT_STYLE}{I_H_RULE}" alt="" border="0" /></a>
					<a href="{U_CHARMAP}" onmouseover="helpline('chr')" onclick="window.open('{U_CHARMAP}', '_charmap', 'height=300,resizable=yes,scrollbars=yes,width=600');return false;" onfocus="this.blur();" target="_charmap"><img src="{ROOT_STYLE}{I_CHARMAP}" alt="" border="0" /></a>
					<a href="javascript:bbstyle(-1)" onmouseover="helpline('a')"><img src="{ROOT_STYLE}{I_CLEANUP}" alt="" border="0" /></a>
				</span></td>
			  </tr>
			</table></td>
		</tr>
		<tr>
			<td><div id="bbc_fontcolor" style="display:block;"><script language="javascript" type="text/javascript"><!--
				colorPalette('color','h', 17, 5)
				//--></script></div>
				<div id="bbc_backcolor" style="display:none;"><script language="javascript" type="text/javascript"><!--
				colorPalette('bcolor','h', 17, 5)
				//--></script>
			</div></td>
		</tr>
		<tr>
			<td><input type="text" name="helpbox" style="width:450px" maxlength="100" class="helpline" value="{L_STYLES_TIP}" /></td>
		</tr>
		<!-- END bbc -->
		<!-- BEGIN bbc_else -->
		<tr align="center" valign="middle">
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<!-- BEGIN def_else -->
				<td><input type="button" class="button" accesskey="{bbc_else.def_else.ACCESSKEY}" name="addbbcode{bbc_else.def_else.BBSTYLE}" value="{bbc_else.def_else.VALUE}" style="{bbc_else.def_else.STYLE}" onclick="bbstyle({bbc_else.def_else.BBSTYLE})" onmouseover="helpline('{bbc_else.def_else.HELPLINE}')" /></td>
				<!-- END def_else -->
			  </tr>
			</table></td>
		</tr>
		<tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td><div id="bbc_fontcolor" style="display:block;"><span class="genmed"> &nbsp;{L_FONT_COLOR}:</span> {S_FONT_COLOR_TYPES}</div>
					<div id="bbc_backcolor" style="display:none;"><span class="genmed"> &nbsp;{L_FONT_COLOR}:</span> {S_BACK_COLOR_TYPES}</div>
				</td>
				<td><span class="genmed"> &nbsp;{L_FONT_SIZE}:</span> {S_FONT_SIZE_TYPES}</td>
				<td class="gensmall" nowrap="nowrap" align="right"><span class="genmed"><a href="javascript:colorSwitch('bbc_fontcolor', 'bbc_backcolor');" onmouseover="helpline('swc')" onfocus="this.blur();"><img src="{ROOT_STYLE}{I_SWITCHCOLOR}" alt="" border="0" /></a>
					<a href="{U_CHARMAP}" onmouseover="helpline('chr')" onclick="window.open('{U_CHARMAP}', '_charmap', 'height=300,resizable=yes,scrollbars=yes,width=600');return false;" onfocus="this.blur();" target="_charmap"><img src="{ROOT_STYLE}{I_CHARMAP}" alt="" border="0" /></a>
					<a href="javascript:bbstyle(-1)" onmouseover="helpline('a')"><img src="{ROOT_STYLE}{I_CLEANUP}" alt="" border="0" /></a>
				</span></td>
			  </tr>
			</table></td>
		</tr>
		<tr>
			<td><input type="text" name="helpbox" style="width:450px" maxlength="100" class="helpline" value="{L_STYLES_TIP}" /></td>
		</tr>
		<!-- END bbc_else -->