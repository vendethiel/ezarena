<script language="Javascript" type="text/javascript">
function setPreview(val){
  IMG = document.getElementById('preview');
  IMG.src = '../../images/menu/' + val;
}
</script>
<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>
<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
<tr> 
<th colspan="2">{L_SETTINGS}</th>
</tr>
<tr> 
<td class="row1" width="33%">{L_CAT_TITRE}</td>
<td class="row2" height="25"> 
<input type="text" size="50" maxlength="100" name="arcade_cattitle" value="{CAT_TITLE}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_CAT_PARENT}</td>
<td class="row2" height="25"> 
<select name="arcade_parent" class="post">
{S_CAT_PARENT}
</select>
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_SALLE}</td>
<td class="row2" height="25"> 
<select name="salle" class="post">
{S_SALLE}
</select>
</td>
</tr>
<tr>
<td class="row1" width="33%">{L_ICONE} </td>
<td class="row2" height="25"> 
<select name="icones" class="post" onchange="setPreview(this.value)">
{ICONE}
</select>
<img id="preview" src="../../images/menu/{ICONE_SELECT}" alt="" />
</td></tr>
<tr> 
<td colspan="2" align="center" class="cat">{S_HIDDEN_FIELDS} 
<input type="submit" name="{S_SUBMIT}" value="{L_SUBMIT}" class="mainoption" />
</td>
</tr>
</table>
</form>
		
<br clear="all" />