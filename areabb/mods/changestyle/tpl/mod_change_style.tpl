<!-- BEGIN logged_in -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline" >
	<tr>
		<th>{L_STYLE}</th>
	</tr>
	<tr>
		<td class="row1" align="center">
		<form method="post" name="chgstyle">	
		<br />	   
		<select name="cstyle" class="option" onchange="document.chgstyle.submit()">
		{S_STYLES}
		</select>
		<br /><br />
		<input type="submit" name="change" value="{L_ENREGISTRER}" class="liteoption" />
		</form>
		<br />
	</td>
	</tr>
</table>
<!-- END logged_in -->