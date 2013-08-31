<link rel="stylesheet" id="cssRef" href="areabb/fonctions/js/floating_window_with_tabs-skin2.css" media="screen">
<script type="text/javascript" src="areabb/fonctions/js/floating_window_with_tabs.js"></script>
<div id="profile" style="overflow:hidden"></div><script type="text/javascript" src="areabb/mods/menu_SP1/script/fsmenu.js"></script>

<style type="text/css">
.menulist, .menulist ul {
	background-color:#EFEFEF;
}
.menulist ul {
	background-color:#EFEFEF;
	border: 2px solid #006699;
}
.menulist a {
	color: #006699;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11;
	font-weight:bold;
}
.menulist a:hover, .menulist a.highlighted:hover, .menulist a:focus {
	color: #006699;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11;
	font-weight:bold;
	text-decoration: none;
	background-color:#DEE3E7;
	border: 0px solid #006699;
	height:30px;
}
</style>
<link rel="stylesheet" type="text/css"  href="areabb/mods/menu_SP1/script/listmenu_o.css" id="listmenu-o" />
<noscript><link rel="stylesheet" type="text/css" href="areabb/mods/menu_SP1/script/listmenu_fallback.css" /></noscript>
<script type="text/javascript">
//<![CDATA[

var listMenu = new FSMenu('listMenu', true, 'visibility', 'visible', 'hidden');

listMenu.cssLitClass = 'highlighted';

function animClipDown(ref, counter)
{
 var cP = Math.pow(Math.sin(Math.PI*counter/200),0.75);
 ref.style.clip = (counter==100 ?
  ((window.opera || navigator.userAgent.indexOf('KHTML') > -1) ? '':
   'rect(auto, auto, auto, auto)') :
    'rect(0, ' + ref.offsetWidth + 'px, '+(ref.offsetHeight*cP)+'px, 0)');
};

function animFade(ref, counter)
{
 var f = ref.filters, done = (counter==100);
 if (f)
 {
  if (!done && ref.style.filter.indexOf("alpha") == -1)
   ref.style.filter += ' alpha(opacity=' + counter + ')';
  else if (f.length && f.alpha) with (f.alpha)
  {
   if (done) enabled = false;
   else { opacity = counter; enabled=true }
  }
 }
 else ref.style.opacity = ref.style.MozOpacity = counter/100.1;
};

listMenu.animations[listMenu.animations.length] = animFade;
listMenu.animations[listMenu.animations.length] = animClipDown;
listMenu.animSpeed = 30;

var arrow = null;
if (document.createElement && document.documentElement)
{
 arrow = document.createElement('span');
 arrow.appendChild(document.createTextNode('>'));
 // Feel free to replace the above two lines with these for a small arrow image...
 //arrow = document.createElement('img');
 //arrow.src = 'arrow.gif';
 //arrow.style.borderWidth = '0';

 arrow.className = 'subind';
}

addEvent(window, 'load', new Function('listMenu.activateMenu("listMenuRoot", arrow)'));

//]]>
</script><table width="100%" cellspacing="0" cellpadding="2" border="0" align="center" valign="top">
<tr>
    <td width="22%" align="center" valign="top">
         {login} 
         {recent_topics} 
         {welcome} 
         {whoisonline} 
         {statistiques} 
      </td>
      <td width="56%" align="center" valign="top">{menu_SP1}</td>
      <td width="22%" align="center" valign="top">
         {qui_joue} 
          
          
          
          
       </td>
</tr>
</table><br /><center><a href="http://www.areabb.com" target="_phpbb" class="copyright">Portail AreaBB</a></center>