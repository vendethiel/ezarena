<p width="315" align="center" style="line-height:100%; margin-top:0; margin-bottom:0;">
<form>
	<select id="style_selector" name="listepages1" size=1 onChange="selectStyle(this.form)"> 
	<option selected>STYLES</option>
	<!-- BEGIN style_list -->
	{style_list.NAME} !
	<option id="style_{style_list.NAME}" value="{style_list.NAME}">{style_list.NAME}</option>
	<!-- END style_list -->
	</select> 
</form>
<script language="javascript">
function selectStyle(formulaire) 
{
	if (formulaire.listepages1.selectedIndex != 0) 
	{
		var loc = location.href.replace(/\?s=[a-z]+/i, '');
		var sep = ~loc.indexOf('?') ? '&' : '?';
		location.href = loc + sep + 's=' + formulaire.listepages1.options[formulaire.listepages1.selectedIndex].value; 
	} 
}

// V: remove cur style
var currentStyle = gEBI('style_{T_STYLE_NAME}');
currentStyle.parentNode.removeChild(currentStyle);
</script>