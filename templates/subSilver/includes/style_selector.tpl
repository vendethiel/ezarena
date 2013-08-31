<p width="315" align="center" style="line-height:100%; margin-top:0; margin-bottom:0;">
<form>
	<select name="listepages1" size=1 onChange="selectStyle(this.form)"> 
	<option selected>STYLES</option>
	<option id="style_subSilver" value="subSilver">SubSilver</option>
	<option id="style_pussycatblue" value="pussycatblue">PussycatBlue</option>
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
var currentStyle = gEBI('style_{T_TEMPLATE_NAME}');
currentStyle.parentNode.removeChild(currentStyle);

</script>