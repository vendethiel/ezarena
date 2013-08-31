<script type="text/javascript" src="areabb/mods/menu_SP1/script/fsmenu.js"></script>
<link rel="stylesheet" type="text/css"  href="areabb/mods/menu_SP1/script/listmenu_o.css" id="listmenu-o" />
<noscript><link rel="stylesheet" type="text/css" href="areabb/mods/menu_SP1/script/listmenu_fallback.css" /></noscript>
{ENTETE}
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
</script>
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th>{L_TITRE}</th>
  </tr>
  <tr>
	<td>
	{CAT}
	</td>
   </tr>
   </table>