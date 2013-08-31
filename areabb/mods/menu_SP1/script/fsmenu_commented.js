/*

FREESTYLE MENUS v1.0 RC (c) 2001-2005 Angus Turnbull, http://www.twinhelix.com
Altering this notice or redistributing this file is prohibited.

*/



// This is the full, commented script file, to use for reference purposes or if you feel
// like tweaking anything. I used the "CodeTrimmer" utility availble from my site
// (under 'Miscellaneous' scripts) to trim the comments out of this JS file.



// *** COMMON CROSS-BROWSER COMPATIBILITY CODE ***


// This is taken from the "Modular Layer API" available on my site.
// See that for the readme if you are extending this part of the script.

var isDOM=document.getElementById?1:0,
 isIE=document.all?1:0,
 isNS4=navigator.appName=='Netscape'&&!isDOM?1:0,
 isOp=self.opera?1:0,
 isDyn=isDOM||isIE||isNS4;

function getRef(i, p)
{
 p=!p?document:p.navigator?p.document:p;
 return isIE ? p.all[i] :
  isDOM ? (p.getElementById?p:p.ownerDocument).getElementById(i) :
  isNS4 ? p.layers[i] : null;
};

function getSty(i, p)
{
 var r=getRef(i, p);
 return r?isNS4?r:r.style:null;
};

if (!self.LayerObj) var LayerObj = new Function('i', 'p',
 'this.ref=getRef(i, p); this.sty=getSty(i, p); return this');
function getLyr(i, p) { return new LayerObj(i, p) };

function LyrFn(n, f)
{
 LayerObj.prototype[n] = new Function('var a=arguments,p=a[0],px=isNS4||isOp?0:"px"; ' +
  'with (this) { '+f+' }');
};
LyrFn('x','if (!isNaN(p)) sty.left=p+px; else return parseInt(sty.left)');
LyrFn('y','if (!isNaN(p)) sty.top=p+px; else return parseInt(sty.top)');

var aeOL = [];
function addEvent(o, n, f, l)
{
 var a = 'addEventListener', h = 'on'+n, b = '', s = '';
 if (o[a] && !l) return o[a](n, f, false);
 o._c |= 0;
 if (o[h])
 {
  b = '_f' + o._c++;
  o[b] = o[h];
 }
 s = '_f' + o._c++;
 o[s] = f;
 o[h] = function(e)
 {
  e = e || window.event;
  var r = true;
  if (b) r = o[b](e) != false && r;
  r = o[s](e) != false && r;
  return r;
 };
 aeOL[aeOL.length] = { o: o, h: h };
};
addEvent(window, 'unload', function() {
 for (var i = 0; i < aeOL.length; i++) with (aeOL[i])
 {
  o[h] = null;
  for (var c = 0; o['_f' + c]; c++) o['_f' + c] = null;
 }
});




// *** CORE MENU OBJECT AND FUNCTIONS ***


function FSMenu(myName, nested, cssProp, cssVis, cssHid)
{
 // This is the base object that users create.
 // It stores menu properties, and has a 'menus' associative array to store a list of menu nodes,
 // and allow timeouts to refer to nodes by name (e.g. menuObject.menus.nodeName).

 this.myName = myName;
 this.nested = nested;
 // Some CSS settings users can specify.
 this.cssProp = cssProp;
 this.cssVis = cssVis;
 this.cssHid = cssHid;
 this.cssLitClass = '';
 // The 'root' menu only exists for list menus, and is created in the activation function.
 // For non-nested menus, here's an imaginary node that acts as a parent to other nodes.
 this.menus = { root: new FSMenuNode('root', true, this) };
 this.menuToShow = [];
 this.mtsTimer = null;
 // Other configurable defaults.
 this.showDelay = 0;
 this.switchDelay = 125;
 this.hideDelay = 500;
 this.showOnClick = 0;
 this.animations = [];
 this.animSpeed = 100;

 // Free memory onunload in IE.
 if (isIE && !isOp) addEvent(window, 'unload', new Function(myName + ' = null'));
};




FSMenu.prototype.show = function(mN) { with (this)
{
 // Set menuToShow to the function parameters. Use a loop to copy values so we don't leak memory.
 menuToShow.length = arguments.length;
 for (var i = 0; i < arguments.length; i++) menuToShow[i] = arguments[i];
 // Use a timer to call a virtual 'root' menu over() function for non-nested menus.
 // For nested/list menus event bubbling will call the real root menu node over() function.
 clearTimeout(mtsTimer);
 if (!nested) mtsTimer = setTimeout(myName + '.menus.root.over()', 10);
}};


FSMenu.prototype.hide = function(mN) { with (this)
{
 // Clear the above timer and route the hide event to the appropriate menu node.
 clearTimeout(mtsTimer);
 if (menus[mN]) menus[mN].out();
}};




function FSMenuNode(id, isRoot, obj)
{
 // Each menu is represented by a FSMenuNode object.
 // This is the node constructor function, with the properties and functions needed by that node.
 // It's passed its own name in the menus[] array, whether this is a root level menu (boolean),
 // and a reference to the parent FSMenu object.

 this.id = id;
 this.isRoot = isRoot;
 this.obj = obj;
 this.lyr = this.child = this.par = this.timer = this.visible = null;
 this.args = [];
 var node = this;


 // These next per-node over/out functions are an example of closures in JavaScript.
 // Since they're instantiated here, they can use the node's variables as if they were their own.

 this.over = function(evt) { with (node) with (obj)
 {
  // Basically, over() gets called when the onmouseover event reaches the menu container,
  // which might be a DIV or UL tag in the document. The event source is a tag inside
  // that container that calls FSMenu.show() and sets the menuToShow array (see above).
  // Browsers will then 'bubble' the event upwards, reaching this function which is set
  // as the onmouseoover/focus/click handler on a menu container. This picks up the
  // properties in menuToShow and shows the given menu as a child of this one.
  // Note that for non-nested menus there is a default timer (mtsTimer) that will mimic
  // an outermost 'root' menu that picks up the event if no other menus intercept it first.

  // Ensure NS4 calls the show/hide function within this layer first.
  if (isNS4 && evt && lyr.ref) lyr.ref.routeEvent(evt);
  // Stop this menu hiding itself and intercept the default root show handler (if any).
  clearTimeout(timer);
  clearTimeout(mtsTimer);

  // A quick check; if this menu isn't visible, show it (i.e. cancel any animation).
  if (!isRoot && !visible) node.show();

  if (menuToShow.length)
  {
   // Pull information out of menuToShow[].
   var a = menuToShow, m = a[0];
   if (!menus[m] || !menus[m].lyr.ref) menus[m] = new FSMenuNode(m, false, obj);
   // c = reference to new child menu that will be shown.
   var c = menus[m];
   // Just clear the menuToShow array and return if we're "showing" the current menu...!
   if (c == node)
   {
    menuToShow.length = 0;
    return;
   }
   // Otherwise, stop any impending show/hide of the child menu, and check if it's a new child.
   clearTimeout(c.timer);
   if (c != child && c.lyr.ref)
   {
    // We have a genuinely new child menu to show. Give it some properties, set a timer to show it.
    // Again, try and avoid memory leaks, but copy over the a/menuToShow arguments.
    c.args.length = a.length;
    for (var i = 0; i < a.length; i++) c.args[i] = a[i];
    // Decide which delay to use -- switchDelay if we already have a child menu, showDelay otherwise.
    var delay = child ? switchDelay : showDelay;
    c.timer = setTimeout('with(' + myName + ') { menus["' + c.id + '"].par = menus["' +
     node.id + '"]; menus["' + c.id + '"].show() }', delay ? delay : 1);
   }
   // Try, try, try to avoid leaking memory... :).
   menuToShow.length = 0;
  }

  // For non-nested menus, mimic event bubbling.
  if (!nested && par) par.over();
 }};


 this.out = function(evt) { with (node) with (obj)
 {
  // Basically the same as over(), this cancels impending events and sets a hide timer.
  if (isNS4 && evt && lyr && lyr.ref) lyr.ref.routeEvent(evt);
  clearTimeout(timer);
  // We never hide the root menu. Otherwise, mimic event-bubbling for non-nested menus.
  if (!isRoot)
  {
   timer = setTimeout(myName + '.menus["' + id + '"].hide()', hideDelay);
   if (!nested && par) par.out();
  }
 }};


 // Finally, now we have created our menu node, get a layer object for the right ID'd element
 // in the page, and assign it onmouseout/onmouseover events. Don't do for virtual root node.
 if (this.id != 'root') with (this) with (lyr = getLyr(id)) if (ref)
 {
  if (isNS4) ref.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
  addEvent(ref, 'mouseover', this.over);
  addEvent(ref, 'mouseout', this.out);
  // For nested UL/LI menus, assign focus/blur events for accessibility.
  if (obj.nested)
  {
   addEvent(ref, 'focus', this.over);
   addEvent(ref, 'click', this.over);
   addEvent(ref, 'blur', this.out);
  }
 }
};




FSMenuNode.prototype.show = function() { with (this) with (obj)
{
 // This is called to show the menu node of which it's a method.
 // It sets the parent's child to this, and hides any existing children of the parent node.
 if (!lyr || !lyr.ref) return;

 if (par)
 {
  if (par.child && par.child != this) par.child.hide();
  par.child = this;
 }

 // This is the positioning routine, it can be deleted if you're not using it.
 // It pulls values out of the stored args[] array, and uses the page.elmPos function in the
 // cross-browser code to find the pixel position of the parent item + menu.
 var offR = args[1], offX = args[2], offY = args[3], lX = 0, lY = 0,
  doX = ''+offX!='undefined', doY = ''+offY!='undefined';
 if (self.page && offR && (doX||doY))
 {
  with (page.elmPos(offR, par.lyr ? par.lyr.ref : 0)) lX = x, lY = y;
  if (doX) lyr.x(lX + eval(offX));
  if (doY) lyr.y(lY + eval(offY));
 }

 // Highlight the triggering element, if any.
 if (offR) lightParent(offR, 1);

 // Show the menu and trigger any 'onshow' events.
 visible = 1;
 if (obj.onshow) obj.onshow(id);
 setVis(1);
}};


FSMenuNode.prototype.hide = function() { with (this) with (obj)
{
 // Same as show() above, but this clears the child/parent settings and hides the menu.
 if (!lyr || !lyr.ref) return;

 // This is an NS4 hack as its mouse events are notoriously unreliable. Remove as needed.
 if (isNS4 && self.isMouseIn && isMouseIn(lyr.ref)) return show();
 // Dim the triggering element.
 if (args[1]) lightParent(args[1], 0);

 // Route the hide call through any child nodes, and clear the par/child references.
 if (child) child.hide();
 if (par && par.child == this) par.child = null;

 // Hide the menu node element, and trigger an 'onhide' event if set.
 if (lyr)
 {
  visible = 0;
  if (obj.onhide) obj.onhide(id);
  setVis(0);
 }
}};


FSMenuNode.prototype.lightParent = function(elm, lit) { with (this) with (obj)
{
 // This is passed a reference to the parent triggering element, and whether it is lit or not.

 if (!cssLitClass || isNS4) return;
 // By default the cssLitClass value is appended/removed to any existing class.
 // Otherwise, if hiding, remove all trailing instances of it (in case of script errors).
 if (lit) elm.className += (elm.className?' ':'') + cssLitClass;
 else elm.className = elm.className.replace(new RegExp('(\\s*' + cssLitClass + ')+$'), '');
}};


FSMenuNode.prototype.setVis = function(sh) { with (this) with (obj)
{
 // This is passed one parameter by the core script, whether its menu is shown (boolean).
 // It sets the chosen CSS property of the menu element, and repeatedly calls itself if
 // one or more animations have been specified in the animations property.

 lyr.timer |= 0;
 lyr.counter |= 0;
 with (lyr)
 {
  clearTimeout(timer);
  if (sh && !counter) sty[cssProp] = cssVis;

  if (isDOM && animSpeed < 100)
   for (var a = 0; a < animations.length; a++) animations[a](ref, counter);

  counter += animSpeed*(sh?1:-1);
  if (counter>100) { counter = 100 }
  else if (counter<=0) { counter = 0; sty[cssProp] = cssHid }
  else if (isDOM)
   timer = setTimeout(myName + '.menus["' + id + '"].setVis(' + sh + ')', 50);
 }
}};







// *** LIST MENU ACTIVATION ***


// This is only required for activating list-type menus.
// You can delete it if you're using div-menus only.

FSMenu.prototype.activateMenu = function(id, subInd) { with (this)
{
 if (!isDOM || !document.documentElement) return;
 var a, ul, li, parUL, mRoot = getRef(id), nodes, count = 1;

 // Because IE sucks, we emulate onfocus/blur event bubbling for accessibility.
 if (isIE)
 {
  var aNodes = mRoot.getElementsByTagName('a');
  for (var i = 0; i < aNodes.length; i++)
  {
   addEvent(aNodes[i], 'focus', new Function('e', 'var node = this.parentNode; while(node) { ' +
    'if (node.onfocus) setTimeout(node.onfocus, 1, e); node = node.parentNode }'));
   addEvent(aNodes[i], 'blur', new Function('e', 'var node = this.parentNode; while(node) { ' +
    'if (node.onblur) node.onblur(e); node = node.parentNode }'));
  }
 }

 // Loop through all sub-lists under the given menu.
 var lists = mRoot.getElementsByTagName('ul');
 for (var i = 0; i < lists.length; i++)
 {
  // Find a parent LI node, if any, by recursing upwards from the UL. Quit if not found.
  li = ul = lists[i];
  while (li)
  {
   if (li.nodeName.toLowerCase() == 'li') break;
   li = li.parentNode;
  }
  if (!li) continue;
  // Next, find the parent UL to that LI node.
  parUL = li;
  while (parUL)
  {
   if (parUL.nodeName.toLowerCase() == 'ul') break;
   parUL = parUL.parentNode;
  }

  // Now, find the anchor tag that triggers this menu; it should be a child of the LI.
  a = null;
  for (var j = 0; j < li.childNodes.length; j++)
   if (li.childNodes[j].nodeName.toLowerCase() == 'a') a = li.childNodes[j];
  if (!a) continue;

  // We've found a menu node by now, so give it an ID and event handlers.
  var menuID = myName + '-id-' + count++;
  // Only assign a new ID if it doesn't have one already.
  if (ul.id) menuID = ul.id;
  else ul.setAttribute('id', menuID);

  // Attach focus/mouse events to the triggering anchor tag.
  // Check if this link will be triggered onclick instead of onmouseover.
  // If so, we only respect mouseovers/focuses when the menu is visible from a click.
  var sOC = (showOnClick == 1 && li.parentNode == mRoot) || (showOnClick == 2);
  var eShow = new Function('with (' + myName + ') { ' +
   'var m = menus["'+menuID+'"], pM = menus["' + parUL.id + '"];' +
   (sOC ? 'if ((pM && pM.child) || (m && m.visible))' : '') +
   ' show("' + menuID + '", this) }');
  var eHide = new Function(myName + '.hide("' + menuID + '")');
  addEvent(a, 'mouseover', eShow);
  addEvent(a, 'focus', eShow);
  addEvent(a, 'mouseout', eHide);
  addEvent(a, 'blur', eHide);
  if (sOC) addEvent(a, 'click', new Function('e', myName + '.show("' + menuID +
   '", this); if (e.cancelable && e.preventDefault) e.preventDefault(); ' +
   'e.returnValue = false; return false'));

  // Prepend an arrow indicator to the anchor tag content if given.
  if (subInd) a.insertBefore(subInd.cloneNode(true), a.firstChild);
 }

 // Finally, create/activate the root node.
 menus[id] = new FSMenuNode(id, true, this);
}};




// *** DIV MENU & v4 BROWSER COMPATIBILITY ***


// You may freely delete this section if you're only using "list" type menus.
// This script will "run" in NS4, but I recommend you use my "Cascading Popup Menus" script if you
// want NS4 users to have an experience comparable to users of modern browsers.
// You can download it from my site, http://www.twinhelix.com if you're interested.

// 'page' object from layer API code, detects positions of page elements.
if (!self.page) var page = { win:self, minW:0, minH:0, MS:isIE&&!isOp };
page.elmPos=function(e,p)
{
 var x=0,y=0,w=p?p:this.win;
 e=e?(e.substr?(isNS4?w.document.anchors[e]:getRef(e,w)):e):p;
 if(isNS4){if(e&&(e!=p)){x=e.x;y=e.y};if(p){x+=p.pageX;y+=p.pageY}}
 if (e && this.MS && navigator.platform.indexOf('Mac')>-1 && e.tagName=='A')
 {
  e.onfocus = new Function('with(event){self.tmpX=clientX-offsetX;' +
   'self.tmpY=clientY-offsetY}');
  e.focus();x=tmpX;y=tmpY;e.blur()
 }
 else while(e){x+=e.offsetLeft;y+=e.offsetTop;e=e.offsetParent}
 return{x:x,y:y};
};


if (isNS4)
{
 // Various NS4 hacks and tweaks. You can delete this if you don't care about NS4 support.

 var fsmMouseX, fsmMouseY, fsmOR=self.onresize, nsWinW=innerWidth, nsWinH=innerHeight;
 document.fsmMM=document.onmousemove;

 self.onresize = function()
 {
  if (fsmOR) fsmOR();
  if (nsWinW!=innerWidth || nsWinH!=innerHeight) location.reload();
 };

 document.captureEvents(Event.MOUSEMOVE);
 document.onmousemove = function(e)
 {
  fsmMouseX = e.pageX;
  fsmMouseY = e.pageY;
  return document.fsmMM?document.fsmMM(e):document.routeEvent(e);
 };

 function isMouseIn(sty)
 {
  with (sty) return ((fsmMouseX>left) && (fsmMouseX<left+clip.width) &&
   (fsmMouseY>top) && (fsmMouseY<top+clip.height));
 };
}