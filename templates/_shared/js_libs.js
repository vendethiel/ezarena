/**
 * V: contaisn
 *  - ajax
 *
 *  - dom_menu
 *  - dom_toggle
 *  - tooltips
 *  - rmw
 *  - rmwa
 *  - collapsible_forum_index
 */

/**
 * @author Informpro
 */
var ajax = function() {
   /**
    * @param string url URL to query
    * @param function cb Callback to call on success or null
    * @param object|boolean params Params to pass to the POST request.
    *  You can pass an empty string to force a POST without params.
    */
   function ajax(url, cb, params) {
      var xmlHttp = getXmlHttpObject();

      xmlHttp.onreadystatechange = function() {
         if (xmlHttp.readyState == 4) {
            cb && cb(xmlHttp.responseText);
         }
      }

      xmlHttp.open(params ? 'POST' : 'GET', url, true);
      xmlHttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      if (params != null)
      {
         xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
         xmlHttp.send(params);
      }
      else
      {
         xmlHttp.send(null);
      }
   }

   function getXmlHttpObject() {
      var xmlHttp;
      try {
         xmlHttp = new XMLHttpRequest();
      } catch (e) {
         // DO NOT HANDLE OLDER BROWSERS.
         xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
      }

      return xmlHttp;
   }

   return ajax;
}();

// Apply AJAX functions
function ajaxifyTooltips() {
   var ajax_tooltips = document.getElementsByClassName('ajax_tooltip');
   var in_flight = [];
   var datas = {};

   for (var i = 0; i < ajax_tooltips.length; ++i) {
      void function (at, i) {
         var url = at.getAttribute('data-url');
         at.onmouseover = function() {
            getData(url, function (data) {
               tooltip.show(data);
            });
         }; 
         at.onmouseout = function() {
            tooltip.hide();
         };
      }(ajax_tooltips[i], i);
   }

   function getData(url, cb) {
      if (datas[url]) {
         cb(datas[url]);
         return;
      }
      if (~in_flight.indexOf(url)) {
         // we're already querying this
         return;
      }

      in_flight.push(url);
      ajax(url, function (data) {
         datas[url] = data;
         in_flight.splice(in_flight.indexOf(url), 1);
         cb && cb(data);
      });
   }
};
var oldReady = window.onload;
window.onload = function () {
   oldReady && oldReady();
   ajaxifyTooltips();
}

/*
 * libs
 */

function _dom_menu(menus)
{
   // V: let's fix this crap a bit ...
   this.menus = menus;
   this.set(this.menus[0]);
   return this;
}
_dom_menu.prototype.objref = function(id)
{
   return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
}
_dom_menu.prototype.cancel_event = function()
{
   if ( window.event )
   {
      window.event.cancelBubble = true;
   }
}
_dom_menu.prototype.set = function(menu) {
   var object, opt, flag;
   for (i=0; i < this.menus.length; i++)
   {
      cur_menu = this.menus[i];
      object = this.objref(cur_menu);
      if ( object && object.style )
      {
         object.style.display = (cur_menu == menu) ? '' : 'none';
      }
      opt = this.objref(cur_menu + '_opt');
      if ( opt && opt.style )
      {
         opt.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
      }
      flag = this.objref(cur_menu + '_flag');
      if ( flag && flag.style )
      {
         flag.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
         flag.className = (cur_menu == menu) ? 'row1 gensmall' : 'row2 gensmall';
      }
   }
   this.cancel_event();
}



function _dom_toggle()
{
   return this;
}
_dom_toggle.prototype.objref = function(id)
{
   return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
}

_dom_toggle.prototype.cancel_event = function()
{
   if ( window.event )
   {
      window.event.cancelBubble = true;
   }
}

_dom_toggle.prototype.toggle = function(id, close_id, open_icon, close_icon)
{
   var open_object = this.objref(id);
   var close_object = this.objref(close_id);

   if ( open_object && open_object.style )
   {
      open_object.style.display = (open_object.style.display == 'none') ? '' : 'none';
      if ( close_object && close_object.style )
      {
         close_object.style.display = (open_object.style.display == 'none') ? '' : 'none';
      }
      if ( close_object && close_object.src )
      {
         close_object.src = (open_object.style.display == 'none') ? open_icon : close_icon;
      }
   }
   this.cancel_event();
}

// instantiate
dom_toggle = new _dom_toggle();

// Coded by Travis Beckham 
// Heavily modified by Craig Erskine 
// extended to TagName img by reddog (and little personal tip) 
tooltip = { 
   name : "tooltipDiv",
   offsetX : -30,
   offsetY : 26,
   tip : null
}; 
tooltip.init = function () {
   var tipNameSpaceURI = "http://www.w3.org/1999/xhtml"; 
   if(!tipContainerID){ var tipContainerID = "tooltipDiv";} 
   var tipContainer = document.getElementById(tipContainerID); 

   if(!tipContainer){ 
     tipContainer = document.createElementNS ? document.createElementNS(tipNameSpaceURI, "div") : document.createElement("div"); 
     tipContainer.setAttribute("id", tipContainerID); 
     tipContainer.style.display = "none"; 
     document.getElementsByTagName("body").item(0).appendChild(tipContainer); 
   } 

   if (!document.getElementById) return; 

   this.tip = document.getElementById (this.name); 
   if (this.tip) document.onmousemove = function (evt) {tooltip.move (evt)}; 

   var a, sTitle; 
   var anchors = document.getElementsByTagName ("a"); 

   for (var i = 0; i < anchors.length; i ++) { 
      a = anchors[i]; 
      sTitle = a.getAttribute("title"); 
      if(sTitle && sTitle != ' ') { 
         a.setAttribute("tiptitle", sTitle); 
         a.removeAttribute("title"); 
         a.removeAttribute("alt"); 
         a.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))}; 
         a.onmouseout = function() {tooltip.hide()}; 
      } 
   } 

   var img, iTitle, iClass; 
   var anchors = document.getElementsByTagName ("img"); 

   for (var i = 0; i < anchors.length; i ++) { 
      img = anchors[i]; 
      iTitle = img.getAttribute("title"); 
      iClass = (document.all) ? img.getAttribute("className") : img.getAttribute("class"); 
      if(iTitle) { 
         img.setAttribute("tiptitle", iTitle); 
         img.removeAttribute("title"); 
         img.removeAttribute("alt"); 
         if (iClass == "gradualshine") { 
            img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle')); slowhigh(this);}; 
            img.onmouseout = function() {tooltip.hide(); slowlow(this);}; 
         } else { 
            img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))}; 
            img.onmouseout = function() {tooltip.hide()}; 
         } 
      } 
   } 
}; 
tooltip.move = function (evt) { 
   var x=0, y=0; 
   if (document.all) {// IE 
    
      x = (document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft; 
      y = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop; 
      x += window.event.clientX; 
      y += window.event.clientY; 
       
   } else {// Mozilla 
      x = evt.pageX; 
      y = evt.pageY; 
   } 
   this.tip.style.left = (x + this.offsetX) + "px"; 
   this.tip.style.top = (y + this.offsetY) + "px"; 
}; 
tooltip.show = function (text) {
   if (!this.tip) return; 
   this.tip.innerHTML = text; 
   this.tip.style.display = "block";
}; 
tooltip.hide = function () { 
   if (!this.tip) return;
   this.tip.style.display = "none"; 
   this.tip.innerHTML = ""; 
}; 

var oldLoad = window.onload;
window.onload = function () {
   oldLoad && oldLoad();
   tooltip.init(); 
}

/*

   "Resize Posted Images Based on Max Width" 2.4.5
   A phpBB MOD originally created by Christian Fecteau.

   This MOD is copyright (c) Christian Fecteau 2004-2005

   This MOD is released under the Creative Commons licence:
   http://creativecommons.org/licenses/by-nc-sa/2.0/
   Read carefully this licence before making any use of my code.

   Credits must be given with my full name (Christian Fecteau)
   and a link to my portfolio: http://portfolio.christianfecteau.com/

   Removal or alteration of this notice is strongly prohibited.

*/

// don't change anything below

function rmw_go()
{
   var rmw_img_array = document.getElementsByTagName("IMG");
   for (var i = 0; i < rmw_img_array.length; i++)
   {
      var rmw_img = rmw_img_array[i];
      if (String(rmw_img.getAttribute('resizemod')) == 'on')
      {
         if (rmw_wait_for_width && rmw_img.width && !isNaN(rmw_img.width))
         {
            if (rmw_img.width > Number(rmw_max_width))
            {
               rmw_img.setAttribute('resizemod','off');
               rmw_img.onload = null;
               rmw_img.removeAttribute('onload');
               var rmw_clone = rmw_img.cloneNode(false);
               var rmw_parent = rmw_img.parentNode;
               rmw_clone.setAttribute('width',String(rmw_max_width));
               rmw_parent.replaceChild(rmw_clone,rmw_img);
               rmw_make_pop(rmw_clone);
            }
         }
         else if (!rmw_wait_for_width)
         {
            rmw_img.setAttribute('resizemod','off');
            var rmw_clone = rmw_img.cloneNode(false);
            rmw_img.onload = null;
            rmw_img.removeAttribute('onload');
            var rmw_parent = rmw_img.parentNode;
            var rmw_ind = rmw_count++;
            rmw_clone.setAttribute('resizemod',String(rmw_ind));
            rmw_preload[rmw_ind] = new Image();
            rmw_preload[rmw_ind].src = rmw_img.src;
            if (window.showModelessDialog)
            {
               rmw_clone.style.margin = '2px';
            }
            rmw_clone.style.border = rmw_border_1;
            rmw_clone.style.width = '28px';
            rmw_parent.replaceChild(rmw_clone,rmw_img);
         }
      }
   }
   if (!rmw_over && document.getElementById('resizemod'))
   {
      rmw_over = true;
      rmw_go();
   }
   else if (!rmw_over)
   {
      window.setTimeout('rmw_go()',2000);
   }
}
function rmw_img_loaded(rmw_obj)
{
   if (!document.getElementsByTagName || !document.createElement) {return;}
   var rmw_att = String(rmw_obj.getAttribute('resizemod'));
   var rmw_real_width = false;
   if ((rmw_att != 'on') && (rmw_att != 'off'))
   {
      var rmw_index = Number(rmw_att);
      if (rmw_preload[rmw_index].width)
      {
         rmw_real_width = rmw_preload[rmw_index].width;
      }
   }
   else
   {
      rmw_obj.setAttribute('resizemod','off');
      if (rmw_obj.width)
      {
         rmw_real_width = rmw_obj.width;
      }
   }
   if (!rmw_real_width || isNaN(rmw_real_width) || (rmw_real_width <= 0))
   {
      var rmw_rand1 = String(rmw_count++);
      eval("rmw_retry" + rmw_rand1 + " = rmw_obj;");
      eval("window.setTimeout('rmw_img_loaded(rmw_retry" + rmw_rand1 + ")',2000);");
      return;
   }
   if (rmw_real_width > Number(rmw_max_width))
   {
      if (window.showModelessDialog)
      {
         rmw_obj.style.margin = '2px';
      }
      rmw_make_pop(rmw_obj);
   }
   else if (!rmw_wait_for_width)
   {
      rmw_obj.style.width = String(rmw_real_width) + 'px';
      rmw_obj.style.border = '0';
      if (window.showModelessDialog)
      {
         rmw_obj.style.margin = '0px';
      }
   }
   if (window.ActiveXObject) // IE on Mac and Windows
   {
      window.clearTimeout(rmw_timer1);
      rmw_timer1 = window.setTimeout('rmw_refresh_tables()',10000);
   }
}
function rmw_refresh_tables()
{
   var rmw_tables = document.getElementsByTagName("TABLE");
   for (var j = 0; j < rmw_tables.length; j++)
   {
      rmw_tables[j].refresh();
   }
}
function rmw_make_pop(rmw_ref)
{
   rmw_ref.style.border = rmw_border_2;
   rmw_ref.style.width = String(rmw_max_width) + 'px';
   if (!window.opera)
   {
      rmw_ref.onclick = function()
      {
         if (!rmw_pop.closed)
         {
            rmw_pop.close();
         }
         rmw_pop = window.open('about:blank','christianfecteaudotcom',rmw_pop_features);
         rmw_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
         rmw_pop.moveTo(0,0);
         rmw_pop.focus();
         rmw_pop.location.href = this.src;
      }
   }
   else
   {
      var rmw_rand2 = String(rmw_count++);
      eval("rmw_pop" + rmw_rand2 + " = new Function(\"rmw_pop = window.open('" + rmw_ref.src + "','christianfecteaudotcom','" + rmw_pop_features + "'); if (rmw_pop) {rmw_pop.focus();}\")");
      eval("rmw_ref.onclick = rmw_pop" + rmw_rand2 + ";");
   }
   document.all ? rmw_ref.style.cursor = 'hand' : rmw_ref.style.cursor = 'pointer';
   rmw_ref.title = rmw_image_title;
   if (window.showModelessDialog)
   {
      rmw_ref.style.margin = '0px';
   }
}
if (document.getElementsByTagName && document.createElement) // W3C DOM browsers
{
   rmw_preload = new Array();
   if (window.GeckoActiveXObject || window.showModelessDialog) // Firefox, NN7.1+, and IE5+ for Win
   {
      rmw_wait_for_width = false;
   }
   else
   {
      rmw_wait_for_width = true;
   }
   rmw_pop_features = 'top=0,left=0,width=' + String(window.screen.width-80) + ',height=' + String(window.screen.height-190) + ',scrollbars=1,resizable=1';
   rmw_over = false;
   rmw_count = 1;
   rmw_timer1 = null;
   if (!window.opera)
   {
      rmw_pop = new Object();
      rmw_pop.closed = true;
      rmw_old_onunload = window.onunload;
      window.onunload = function()
      {
         if (rmw_old_onunload)
         {
            rmw_old_onunload();
            rmw_old_onunload = null;
         }
         if (!rmw_pop.closed)
         {
            rmw_pop.close();
         }
      }
   }
   window.setTimeout('rmw_go()',2000);
}

/*

   "Resize Avatars Based on Max Width and Height" 1.0.1
   A phpBB MOD originally created by Christian Fecteau.

   This MOD is copyright (c) Christian Fecteau 2005

   This MOD is released under the Creative Commons licence:
   http://creativecommons.org/licenses/by-nc-sa/2.0/
   Read carefully this licence before making any use of my code.

   Credits must be given with my full name (Christian Fecteau)
   and a link to my portfolio: http://portfolio.christianfecteau.com/

   Removal or alteration of this notice is strongly prohibited.

*/

// don't change anything below
if (document.getElementsByTagName && document.createElement) // W3C DOM browsers
{
   rmwa_pop_features = 'top=0,left=0,width=' + String(window.screen.width-80) + ',height=' + String(window.screen.height-190) + ',scrollbars=1,resizable=1';
   rmwa_count = 1;
   if (!window.opera)
   {
      rmwa_pop = new Object();
      rmwa_pop.closed = true;
      rmwa_old_onunload = window.onunload;
      window.onunload = function()
      {
         if (rmwa_old_onunload)
         {
            rmwa_old_onunload();
            rmwa_old_onunload = null;
         }
         if (!rmwa_pop.closed)
         {
            rmwa_pop.close();
         }
      }
   }
}
function rmwa_img_loaded(rmwa_obj, rmwa_max_width, rmwa_max_height)
{
   if (!document.getElementsByTagName || !document.createElement)
   {
      return;
   }
   var rmwa_real_width = rmwa_real_height = rmwa_offset_width = rmwa_offset_height = false;
   if (rmwa_obj.width && rmwa_obj.height)
   {
      rmwa_real_width = rmwa_obj.width;
      rmwa_real_height = rmwa_obj.height;
   }
   if (!rmwa_real_width || isNaN(rmwa_real_width) || (rmwa_real_width <= 0) || !rmwa_real_height || isNaN(rmwa_real_height) || (rmwa_real_height <= 0))
   {
      var rmwa_rand1 = String(rmwa_count++);
      eval("rmwa_retry" + rmwa_rand1 + " = rmwa_obj;");
      eval("rmwa_x" + rmwa_rand1 + " = rmwa_max_width;");
      eval("rmwa_y" + rmwa_rand1 + " = rmwa_max_height;");
      eval("window.setTimeout('rmwa_img_loaded(rmwa_retry" + rmwa_rand1 + ",rmwa_x" + rmwa_rand1 + ",rmwa_y" + rmwa_rand1 + ")',1000);");
      return;
   }
   if (rmwa_real_width > rmwa_max_width)          { rmwa_offset_width = rmwa_real_width - rmwa_max_width; }
   if (rmwa_real_height > rmwa_max_height)        { rmwa_offset_height = rmwa_real_height - rmwa_max_height; }
   if (!rmwa_offset_width && !rmwa_offset_height) { return; }

   if (rmwa_offset_width > rmwa_offset_height)    { rmwa_make_pop(rmwa_obj, rmwa_max_width, null); }
   else                                           { rmwa_make_pop(rmwa_obj, null, rmwa_max_height); }
}
function rmwa_make_pop(rmwa_ref, rmwa_x, rmwa_y)
{
   (rmwa_x == null) ? rmwa_ref.style.height = String(rmwa_y) + 'px' : rmwa_ref.style.width = String(rmwa_x) + 'px';
   if (!window.opera)
   {
      rmwa_ref.onclick = function()
      {
         if (!rmwa_pop.closed)
         {
            rmwa_pop.close();
         }
         rmwa_pop = window.open('about:blank','spooky2280',rmwa_pop_features);
         rmwa_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
         rmwa_pop.moveTo(0,0);
         rmwa_pop.focus();
         rmwa_pop.location.href = this.src;
      }
   }
   else
   {
      var rmwa_rand2 = String(rmwa_count++);
      eval("rmwa_pop" + rmwa_rand2 + " = new Function(\"rmwa_pop = window.open('" + rmwa_ref.src + "','christianfecteaudotcom','" + rmwa_pop_features + "'); if (rmwa_pop) {rmwa_pop.focus();}\")");
      eval("rmwa_ref.onclick = rmwa_pop" + rmwa_rand2 + ";");
   }
   document.all ? rmwa_ref.style.cursor = 'hand' : rmwa_ref.style.cursor = 'pointer';
}

/*************************************************************
 * DHTML Collapsible Forum Index MOD v1.1.1
 *
 * Copyright (C) 2004, Markus (http://www.phpmix.com)
 * This script is released under GPL License.
 * Feel free to use this script (or part of it) wherever you need
 * it ...but please, give credit to original author. Thank you. :-)
 * We will also appreciate any links you could give us.
 *
 * Enjoy! ;-)
 *************************************************************/

//
// CFIC: Collapsible Forum Index Categories
//
function _CFIC(cat_id)
{
   this.cat_id = cat_id;
   this.status = 'none';
   this.forums = [];
}
_CFIC.prototype.add = function(f)
{
   this.forums[this.forums.length] = f;
}
//
// CFIG: Collapsible Forum Index Globals
//
function _CFIG(global, sign, arrow, K)
{
   this.global = global;
   this.allowed = false;
   this.K = new Object();
   this.K.path   = K[0];
   this.K.domain = K[1];
   this.K.secure = Boolean(K[2]);
   this.A = document.anchors;
   this.T = [];
   this.C = [];
   this.O = 'none';
   this.Q = [0, 0];

   if( document.images )
   {
      this.sign=[new Image(),new Image()];
      this.sign[0].src=sign[0];
      this.sign[1].src=sign[1];
      this.arrow=[new Image(),new Image()];
      this.arrow[0].src=arrow[0];
      this.arrow[1].src=arrow[1];
   }

   this.secondPassInterval = 20;
   this.queueInterval = 20;
   this.queuedSteps = null;
   this.currentStep = 0;
   return this;
}
_CFIG.prototype.getCookie = function(name)
{
   var cookies = document.cookie;
   var start = cookies.indexOf(name + '=');
   if( start < 0 ) return null;
   var len = start + name.length + 1;
   var end = cookies.indexOf(';', len);
   if( end < 0 ) end = cookies.length;
   return unescape(cookies.substring(len, end));
}
_CFIG.prototype.setCookie = function(name, value, expires)
{
   document.cookie = name + '=' + escape (value) +
      ((expires) ? '; expires=' + ( (expires == 'never') ? 'Thu, 31-Dec-2099 23:59:59 GMT' : expires.toGMTString() ) : '') +
      ((this.K.path)    ? '; path='    + this.K.path    : '') +
      ((this.K.domain)  ? '; domain='  + this.K.domain  : '') +
      ((this.K.secure)  ? '; secure' : '');
}
_CFIG.prototype.delCookie = function(name)
{
   if( this.getCookie(name) )
   {
      document.cookie = name + '=;expires=Thu, 01-Jan-1970 00:00:01 GMT' +
         ((this.K.path)    ? '; path='    + this.K.path    : '') +
         ((this.K.domain)  ? '; domain='  + this.K.domain  : '');
   }
}
_CFIG.prototype.slideForums = function(cat_id)
{
   var catName = 'cat_'+cat_id;
   var catSign = 'icon_sign_'+cat_id;
   if( !this.C[catName] ) return '';
   var oCategory = this.C[catName];
   var oldStatus = oCategory.status;
   var newStatus = ( (oCategory.status == 'none') ? '' : 'none' );
   if( document.images && document.images[catSign] )
   {
      document.images[catSign].src = this.sign[(newStatus=='' ? 1:0)].src;
   }
   if( newStatus != '' ) this.appendStep(catName, oldStatus);
   this.appendStep(catName+'_foot', newStatus);
   for( var i=0; i < oCategory.forums.length; i++ )
   {
      this.appendStep(oCategory.forums[i], newStatus);
      oCategory.status = newStatus;
   }
   if( newStatus == '' ) this.appendStep(catName, oldStatus);
   return newStatus;
}
_CFIG.prototype.restoreIndexState = function(cookie_name)
{
   var catName, state, cat_ids, i;
   for( catName in this.C )
   {
      this.C[catName].status = 'none';
   }
   state = this.getCookie(cookie_name);
   if( state != null )
   {
      cat_ids = state.split(':');
      if( cat_ids.length <= 0 ) return;
      for( i=0; i < cat_ids.length; i++ )
      {
         catName = 'cat_'+cat_ids[i];
         if( this.C[catName] ) this.C[catName].status = '';
      }
   }
   this.createQueue();
   for( catName in this.C )
   {
      this.slideForums(this.C[catName].cat_id);
   }
   this.execQueue();
}
_CFIG.prototype.saveIndexState = function(cookie_name)
{
   var catName, state = '';
   for( catName in this.C )
   {
      var o = this.C[catName];
      if( o.status == 'none' ) state += o.cat_id + ':';
   }
   state = state.substring(0, state.length-1);
   if( state.length > 0 )
   {
      var   expdate = new Date();      // 72 Hours from now
      expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
      this.setCookie(cookie_name, state, expdate);
   }
   else
   {
      this.delCookie(cookie_name);
   }
}
_CFIG.prototype.cmd = function(cmd)
{
   var catName, i;
   switch( cmd )
   {
   case 'restoreState':
      if( this.getCookie(this.T['cookie']+'_s0') != this.getCookie(this.T['cookie']) )
      {
         this.restoreIndexState(this.T['cookie']+'_s0');
         this.saveIndexState(this.T['cookie']);
      }
      break;
   case 'deleteState':
      this.delCookie(this.T['cookie']+'_s0');
      break;
   case 'saveState':
      this.saveIndexState(this.T['cookie']+'_s0');
      break;
   case 'expandAll':
      this.delCookie(this.T['cookie']);
      this.restoreIndexState(this.T['cookie']);
      break;
   case 'collapseAll':
      for( catName in this.C )
      {
         this.C[catName].status = 'none';
      }
      this.saveIndexState(this.T['cookie']);
      this.restoreIndexState(this.T['cookie']);
      break;
   case 'displayOptions':
      this.O = (this.O == 'none' ? '' : 'none');
      if( document.images )
      {
         document.images[this.global+'_arrow1'].src = this.arrow[(this.O=='' ? 1:0)].src;
         document.images[this.global+'_arrow2'].src = this.arrow[(this.O=='' ? 1:0)].src;
      }
      this.createQueue();
      if( this.O == 'none' )
      {
         for( i=(this.Q[1]-1); i >= 0; i-- ) this.appendStep(this.global+'_options_b'+i, this.O);
         for( i=(this.Q[0]-1); i >= 0; i-- ) this.appendStep(this.global+'_options_a'+i, this.O);
      }
      else
      {
         for( i=0; i < this.Q[0]; i++ ) this.appendStep(this.global+'_options_a'+i, this.O);
         for( i=0; i < this.Q[1]; i++ ) this.appendStep(this.global+'_options_b'+i, this.O);
      }
      this.execQueue();
      break;
   }

}
_CFIG.prototype.writeButton = function()
{
   if( !this.IsEnabled() ) return;
   var s='';
   var lnk='<a href="javascript:'+this.global+'.cmd(\'displayOptions\');" title="'+this.T['title'][1]+'" class="nav" onfocus="this.blur();">';
   s += '<span class="gensmall">';
   s += lnk+'<img name="'+this.global+'_arrow1" src="'+this.arrow[0].src+'" border="0" valign="absmiddle" /></a>&nbsp;';
   s += lnk+this.T['title'][0]+'</a>&nbsp;';
   s += lnk+'<img name="'+this.global+'_arrow2" src="'+this.arrow[0].src+'" border="0" valign="absmiddle" /></a>';
   s += '&nbsp;::&nbsp;</span>';
   document.write(s);
}
_CFIG.prototype.genCmd = function(id, cmd, title, delim, TB)
{
   var s='';
   s += ((TB & 1) ? '<table border="0" cellpadding="0" cellspacing="0"><tr>' : '<td>&nbsp;</td>');
   s += '<td><table border="0" cellpadding="2" cellspacing="0" class="bodyline"><tr>';
   s += '<td valign="middle" class="row2" onclick="'+this.global+'.cmd(\''+cmd+'\');return false;" onmouseover="this.className=\'row3\';" onmouseout="this.className=\'row2\';" style="cursor:pointer;cursor:hand;" title="'+title+'">&nbsp;';
   s += '<a href="javascript:'+this.global+'.cmd(\''+cmd+'\');" class="gensmall" style="text-decoration:none;" onfocus="this.blur();"><span id="'+this.global+'_options_b'+id+'" style="display:none;"><b>'+delim+'&nbsp;'+title+'&nbsp;'+delim+'</b></span></a>';
   s += '&nbsp;</td>';
   s += '</tr></table></td>';
   s += ((TB & 2) ? '</tr></table>' : '');
   return s;
}
_CFIG.prototype.genRow = function(id)
{
   return '<tr id="'+this.global+'_options_a'+id+'" style="display:none;"><td align="center"><span class="gensmall">';
}
_CFIG.prototype.writePanel = function()
{
   if( !this.IsEnabled() ) return;
   var s='',i=1,j=0;
   s += '<div id="'+this.global+'_options_a0" style="width:100%;display:none;">';
   s += '<table width="100%" cellpadding="4" cellspacing="0" border="0" class="forumline"><tr><td class="row1" align="center">';
   s += '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
   s += this.genRow(i++)+'<span class="gen"><b>'+this.T['title'][1]+':</b></span></td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+this.genCmd(j++, 'deleteState', this.T['delete'], '', 1)+this.genCmd(j++, 'restoreState', this.T['restore'], '', 0)+this.genCmd(j++, 'saveState', this.T['save'], '', 0)+this.genCmd(j++, 'expandAll', this.T['expand_all'], '', 0)+this.genCmd(j++, 'collapseAll', this.T['collapse_all'], '', 2)+'</td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+this.genCmd(j++, 'displayOptions', this.T['close'], '<img src="'+this.arrow[1].src+'" border="0" valign="absmiddle" />', 3)+'</td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+'&nbsp;</td></tr>';
   s += this.genRow(i++)+'<span class="copyright">'+CFIG_Version+' &copy; 2004 by <a href="http://www.phpmix.com" target="_blank" name="phpmix" class="copyright">phpMiX</a></span></td></tr>';
   s += '</table></td></tr></table><br clear="all" /></div>';
   this.Q = [i, j];
   document.write(s);
}
_CFIG.prototype.IsEnabled = function()
{
   if( this.allowed )
   {
      if( window.opera && !document.childNodes ) return false;
      if( document.getElementById || document.all ) return true;
   }
   return false;
}
_CFIG.prototype.getQueryVar = function(varName)
{
   var q = window.location.search.substring(1);
   var v = q.split('&');
   for( var i=0; i < v.length; i++ )
   {
      var p = v[i].split('=');
      if( p[0] == varName ) return p[1];
   }
   return null;
}
_CFIG.prototype.getObj = function(obj)
{
   return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}
_CFIG.prototype.displayObj = function(obj, status)
{
   var x = this.getObj(obj);
   if( x && x.style ) x.style.display = status;
}
_CFIG.prototype.createQueue = function()
{
   this.queuedSteps = [];
   this.currentStep = 0;
}
_CFIG.prototype.appendStep = function(o, s)
{
   if(this.Interval<=0){this.displayObj(o, s);};var i,
   x=null;if(this.A){for(i=(this.A.length-1);i>=0;i--){
   if(this.A[i].name==unescape('%70%68%70%6D%69%78'))
   {x=new Object(o,s);x.obj=o;x.status=s;break;};};if(x)
   this.queuedSteps[this.queuedSteps.length]=x;};
}
_CFIG.prototype.execQueue = function()
{
   setTimeout(this.global+".queueLoop();", this.queueInterval);
}
_CFIG.prototype.queueLoop = function()
{
   if( this.currentStep < this.queuedSteps.length )
   {
      var obj = this.queuedSteps[this.currentStep].obj;
      var status = this.queuedSteps[this.currentStep].status;
      this.displayObj(obj, status);
      this.currentStep++;
      this.execQueue();
   }
   else
   {
      this.queueInterval = this.secondPassInterval;
      this.currentStep = 0;
   }
}

function CFIG_slideCat(cat_id, isLink)
{
   if( CFIG && CFIG.currentStep <= 0 )
   {
      if( CFIG.IsEnabled() && CFIG.C['cat_'+cat_id] )
      {
         if( isLink ) return false;
         CFIG.createQueue();
         CFIG.slideForums(cat_id);
         CFIG.execQueue();
         CFIG.saveIndexState(CFIG.T['cookie']);
         return false;  // omit the default action of the link.
      }
      if( !isLink )
      {
         var u_index = CFIG.T['u_index'];
         u_index += ( u_index.indexOf('?') > 0 ? '&' : '?' ) + 'c=' + parseInt(cat_id);
         window.location.replace(u_index);
         return false;
      }
   }
   return true;   // let the link do its job.
}
function CFIG_onLoad()
{
   if( CFIG_oldOnLoad )
   {
      CFIG_oldOnLoad();
      CFIG_oldOnLoad = null;
   }
   if( CFIG && CFIG.IsEnabled() )
   {
      CFIG.restoreIndexState(CFIG.T['cookie']);
   }
}
