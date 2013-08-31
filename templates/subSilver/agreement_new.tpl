<style type="text/css">
<!--
.fieldset
{
	margin-bottom:6px;
}
.panel
{
	color:#000;
	background-color:transparent;
	padding:10px;
	border:outset 2px;
}
.terms
{
	color:#000;
	background-color:#fff;
	height:200px;
	padding:6px;
	border:inset thin;
	overflow:auto;
	text-align:left;
}
.agree
{
	color:#000;
	background-color:transparent;
	padding:6px;
	border:thin inset;
}
.bold
{
	font-weight:bold;
}
//-->
</style>
<form action="{S_AGREE}" method="post">
<table width="100%" cellspacing="1" cellpadding="3" border="0" class="forumline">
	<tr>
		<th class="thHead" height="25" valign="middle">{SITENAME} - {REGISTRATION}</th>
	</tr>
	<tr> 
		<td class="row1" align="center">
			<div class="panel">
			<fieldset class="fieldset">
	   			<legend class="gensmall">{FORUM_RULES}</legend>
	   			<table width="100%" cellspacing="3" cellpadding="0" border="0">
		   			<tr align="left">
		   				<td class="gensmall">{TO_JOIN}</td>
		   			</tr>
		   			<tr>
						<td>
							<div class="terms gen">{AGREEMENT}</div>
							<div class="gensmall bold"><input type="checkbox" name="agreed" value="1" />{AGREE_CHECKBOX}</div>
						</td>
		   			</tr>
	   			</table>
			</fieldset>
			</div>
			<div style="margin-top:6px"><input type="hidden" name="not_agreed" value="false" /><input type="submit" value="{L_REGISTER}" class="mainoption" /></div>
		</td>
	</tr>
</table>
</form>