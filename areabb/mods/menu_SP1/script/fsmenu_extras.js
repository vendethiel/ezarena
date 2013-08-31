/*

Here are some extras for the script that didn't make it into the standard .JS file.
I use some of these on my site, so feel free to add the effects to yours. Included are:

     Menu Floating: Scrolls the menu with the page.
     Title Display: Shows your menu link TITLE="" attributes in a separate display area.
 Select Box Hiding: Stops boxes covering over menus in Internet Explorer.

*/






// MENU FLOATING: This will scroll a menu with the page.
// To activate:
//  1) Wrap each menu with a tag like this: <div id="abcdef"> <MENU DATA GOES HERE> </div>
//     That should either be in a column by itself, or have POSITION:ABSOLUTE set in its CSS.
//  2) Add the ID of the DIVs wrapping each menu to the fsmScrollHandler() function below.
//  3) Paste the script below at the end of fsmenu.js

// If you have good CSS knowledge, consider implementing a position:fixed solution in supported
// browsers. This is a general, JS-only floating function designed to work with most layouts.

function fsmScrollHandler()
{
 floatElement('abcdef');
 // ADD OTHER PAGE ELEMENTS CONTAINING MENUS HERE.
};

function floatElement(containerID)
{
 var container = getRef(containerID);
 if (!container) return;
 container.style.paddingTop = (typeof window.pageYOffset == 'number' ? window.pageYOffset :
  (document.body ? document.body.scrollTop || document.documentElement.scrollTop : 0)) + 'px';
 window.status = container.style.paddingTop;
};
if (''+window.onscroll=='undefined') setInterval('fsmScrollHandler()', 500);
else addEvent(window, 'scroll', fsmScrollHandler);






// TITLE DISPLAY: Shows your link TITLE="" attributes in the page itself.
// To activate:
//  1) Include a target element like this in your page: <div id="listMenuTitles"></div>
//     This is the element that will contain the titles.
//  2) Add title display lines like this to the function below:
//     titleDisplay('id-of-menu-containing-links', 'target-element-id');
//  3) Paste this script into your document or the fsmenu.js file.

function titleDisplaySetup()
{
 titleDisplay('listMenuRoot', 'listMenuTitles');
 // ADD DIFFERENT TITLE AREAS HERE! Each must have a 'target' area in your page.
 //titleDisplay('otherMenuRoot', 'otherMenuTitles');
};
addEvent(window, 'load', titleDisplaySetup);

function titleDisplay(menuID, target)
{
 var nav = getRef(menuID);
 addEvent(nav, 'mouseover', new Function('e',
  'e=e||window.event; var lt=getRef("' + target + '"); if (lt) {' +
  'while (lt.firstChild) lt.removeChild(lt.firstChild);' +
   'e=e.target||e.srcElement; while(e && (!e.title&&!e.title_orig)) e=e.parentNode;' +
   'if (e && e.getAttribute) {' +
    'var t = e.getAttribute("title");' +
    'if (t) { e.title_orig = t; e.setAttribute("title", "") }' +
    'lt.appendChild(document.createTextNode(e.title_orig));' +
  '}}'));
 addEvent(nav, 'mouseout', new Function('e',
  'var lt=getRef("' + target + '"); if (lt) while (lt.firstChild) lt.removeChild(lt.firstChild)'));
}





// SELECT BOX / IFRAME HIDING: This will help mixing menus and forms/frames/Flash/etc.
// To activate, choose a method and paste one at the end of the fsmenu.js file.

FSMenu.prototype.toggleElements = function(show)
{
 // CONFIGURATION: Here's a list of tags that will be hidden by menus. Modify to fit your site.
 var tags = ['select', 'iframe'];

 if (!isDOM) return;
 for (var t in tags)
 {
  var elms = document.getElementsByTagName(tags[t]);
  for (var e = 0; e < elms.length; e++) elms[e].style.visibility = show ? 'visible' : 'hidden';
 }
};
FSMenu.prototype.onshow = function()
{
 this.toggleElements(0);
};
FSMenu.prototype.onhide = function()
{
 for (var m in this.menus) if (this.menus[m].visible) return;
 this.toggleElements(1);
};


// Here's a second method. This only works in IE 5.5+ on Windows, but it doesn't make
// select boxes appear and disappear (menus cleanly cover them).

FSMenu.prototype.onshow = function(mN) { with (this)
{
 var m = menus[mN];
 if (!isIE || !window.createPopup) return;
 // Create a new transparent IFRAME if needed, and insert under the menu.
 if (!m.ifr)
 {
  m.ifr = document.createElement('iframe');
  m.ifr.src = 'about:blank';
  with (m.ifr.style)
  {
   position = 'absolute';
   border = 'none';
   filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
  }
  m.lyr.ref.parentNode.insertBefore(m.ifr, m.lyr.ref);
 }
 // Position and show it on each call.
 with (m.ifr.style)
 {
  left = m.lyr.ref.offsetLeft + 'px';
  top = m.lyr.ref.offsetTop + 'px';
  width = m.lyr.ref.offsetWidth + 'px';
  height = m.lyr.ref.offsetHeight + 'px';
  visibility = 'visible';
 }
}};
FSMenu.prototype.onhide = function(mN) { with (this)
{
 if (!isIE || !window.createPopup) return;
 var m = menus[mN];
 if (m.ifr) m.ifr.style.visibility = 'hidden';
}};