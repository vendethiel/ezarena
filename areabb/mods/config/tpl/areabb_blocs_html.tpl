<script type="text/javascript" src="../../lib/FCKeditor/fckeditor.js"></script>
<script type="text/javascript">

window.onload = function()
{
	// Automatically calculates the editor base path based on the _samples directory.
	// This is usefull only for these samples. A real application should use something like this:
	// oFCKeditor.BasePath = 'arcade/FCKeditor/' ;	// '/fckeditor/' is the default value.
	//var sBasePath = document.location.pathname.substring(0,document.location.pathname.lastIndexOf('admin')) ;

	var oFCKeditor = new FCKeditor('message') ;
	oFCKeditor.BasePath	= '../../lib/FCKeditor/' ;
	oFCKeditor.Height = "400" ;
	oFCKeditor.Width = "100%" ;
	oFCKeditor.DisplayErrors = false ; // on va masquer les erreurs
	oFCKeditor.ReplaceTextarea() ;
}

</script>
<h1>{L_BLOCS_HTML}</h1>
<p><span class="gensmall">{L_EXPLAIN_BLOCS_HTML}</span></p>
<form action="" method="post">
	<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
	    <th class="thHead" colspan="2">{L_BLOCS_HTML}</th>
	</tr>
	<tr>
		<td class="row1" width="100"><span class="genmed">{L_TITLE}</span></td>
		<td class="row2"><span class="genmed"><input type="text" name="titre" value="{TITRE}" size="60" /></span></td>
	</tr>
	<tr>
		<td class="row1"><span class="genmed">{L_MESSAGE}</span></td>
		<td class="row2"><span class="genmed"><textarea name="message" style="width:70%; height: 300px;">{MESSAGE}</textarea></span></td>
	</tr>
	<tr>
		<td  class="cat" colspan="2" align="center"><span class="genmed"><input type="submit" name="envoyer" value="{L_ENVOYER}" /></span></td>
	</tr>
	</table>
	{HIDDEN}
</form>
<br />
<br />
<!-- BEGIN html -->
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
<tr> 
	<th colspan="2">{LISTE_BLOCS_HTML}</th>
</tr>
<!-- BEGIN lignes -->
<tr>
	<td class="row1"><span class="genmed"><b>{html.lignes.TITRE}</b><br /><i>{html.lignes.MESSAGE}</i></span></td>
	<td class="row2" width="100"><span class="genmed">
		<a href="{html.lignes.EDITER}" alt=""><img src="{I_EDIT}" alt="" border="0"></a>
		<a href="{html.lignes.SUPPRIMER}" alt=""><img src="{I_SUPP}" alt="" border="0"></a>
	</span></td>
</tr>
<!-- END lignes -->
</table>
<!-- END html -->
<br /><br />