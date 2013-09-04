<script type="text/javascript" src="areabb/mods/recherche/js/tabber.js"></script>
<link rel="stylesheet" href="areabb/mods/recherche/tpl/example.css" TYPE="text/css" MEDIA="screen">
<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */
function RechercheArea(tab)
{
		switch (tab)
		{
				case 1:
						var recherche = document.getElementById("rechercheGoogle").value;
						window.open("http://www.google.fr/search?q="+recherche);
						break;
				case 2:
						var recherche = document.getElementById("rechercheExalead").value;
						window.open("http://www.exalead.fr/search/?q="+recherche);
						break;
				case 3:
						var recherche = document.getElementById("rechercheWiki").value;
						window.open("http://fr.wikipedia.org/wiki/"+recherche);
						break;
				case 4:
						var recherche = document.getElementById("rechercheHome").value;
						window.open("search.php?search_keywords="+recherche);
						break;
		}
}
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<tr>
	<th colspan="2">{L_RECHERCHER}</th>
</tr>
<tr> 
	<td class="row1" align="center">
<div class="tabber">

     <div class="tabbertab">
	  <h2>Google</h2>
	  <p><input type="text" name="rechercheGoogle" id="rechercheGoogle" style="width:80%;" value ="" /><br /><br />
	  <img src="areabb/mods/recherche/images/google.png" border="0" />&nbsp;&nbsp;<input type="submit" value="Recherche" onClick="RechercheArea(1);" /></p>
	 </div>

     <div class="tabbertab">
	  <h2>Exalead</h2>
	  <p><input type="text" name="rechercheExalead" id="rechercheExalead" style="width:80%;" value ="" /><br /><br />
	  <img src="areabb/mods/recherche/images/exalead.png" border="0" />&nbsp;&nbsp;<input type="submit" value="Recherche" onClick="RechercheArea(2);" /></p>
     </div>
	 
	<div class="tabbertab">
	  <h2>Wikipedia</h2>
	  <p><input type="text" name="rechercheWiki" id="rechercheWiki" style="width:80%;" value ="" /><br /><br />
	  <img src="areabb/mods/recherche/images/wikipedia.png" border="0" />&nbsp;&nbsp;<input type="submit" value="Recherche" onClick="RechercheArea(3);" /></p>
     </div>
	 
	 <div class="tabbertab">
	  <h2>{SITENAME}</h2>
	  <p><input type="text" name="rechercheHome" id="rechercheHome" style="width:80%;" value ="" /><br /><br />
	  <img src="areabb/mods/recherche/images/home.png" border="0" />&nbsp;&nbsp;<input type="submit" value="Recherche" onClick="RechercheArea(4);" /></p>
	  </div>
</div>
</td>
</tr>
</table>