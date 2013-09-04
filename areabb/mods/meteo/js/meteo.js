ville = "FRXX0072"; // Nantes est la ville par défaut
if (LireCookie("AreaMeteo") != null )
{
	// nom du cookie = AreaMeteo
	var ville = LireCookie("AreaMeteo");
}
function file(fichier)
 {
 if(window.XMLHttpRequest) // FIREFOX
	  xhr_object = new XMLHttpRequest();
 else if(window.ActiveXObject) // IE
	  xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
 else
	  return(false);
	 xhr_object.open("GET", fichier, false);
	 xhr_object.send(null);
	 if(xhr_object.readyState == 4) 
		return(xhr_object.responseText);
	 else 
		return(false);
 }
	 
function EcrireCookie(nom, valeur)
{
	date=new Date;
	date.setFullYear(date.getFullYear()+1);
   var argv=EcrireCookie.arguments;
   var argc=EcrireCookie.arguments.length;
   var expires=(argc > 2) ? argv[2] : null;
   var path=(argc > 3) ? argv[3] : null;
   var domain=(argc > 4) ? argv[4] : null;
   var secure=(argc > 5) ? argv[5] : false;
   document.cookie=nom+"="+escape(valeur)+
      "; expires=" + date +
      ((path==null) ? "" : ("; path="+path))+
      ((domain==null) ? "" : ("; domain="+domain))+
      ((secure==true) ? "; secure" : "");
}
function getCookieVal(offset)
{
   var endstr=document.cookie.indexOf (";", offset);
   if (endstr==-1) endstr=document.cookie.length;
   return unescape(document.cookie.substring(offset, endstr));
}
function LireCookie(nom)
{
   var arg=nom+"=";
   var alen=arg.length;
   var clen=document.cookie.length;
   var i=0;
   while (i<clen)
   {
      var j=i+alen;
      if (document.cookie.substring(i, j)==arg) return getCookieVal(j);
      i=document.cookie.indexOf(" ",i)+1;
      if (i==0) break;
   }
   return null;
}

function recup_info_ville()
{
	texte =  file('areabb/mods/meteo/xml_searchville.php?ville='+escape(document.getElementById("ville").value));
	document.getElementById("resultats").innerHTML = texte;
	return true;
}

function init_meteo()
{
	texte = file('areabb/mods/meteo/xml_meteo.php?ville='+ville);
	document.getElementById("MaMeteo").innerHTML = texte;
	return true;
}
window.onload = init_meteo();