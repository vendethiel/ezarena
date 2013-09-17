<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>{PAGE_TITLE}</title>
{META_TAG}{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- INCLUDE includes/stylesheets -->
<link rel="stylesheet" href="templates/{T_TEMPLATE_NAME}/{T_HEAD_STYLESHEET}" type="text/css">
<script language="Javascript" type="text/javascript">
<!--
function link_to_post(pid)
{
	temp = prompt( "{COPY}", "http://" + "{SERVER_NAME}" + "{SCRIPT_PATH}" + "viewtopic" + "." + "{PHPEX}" + "?" + "{POST_POST_URL}" + "=" + pid + "#" + pid );

	return false;
}

var rmw_max_width = 400; // you can change this number, this is the max width in pixels for posted images
var rmw_border_1 = '1px solid {T_BODY_LINK}';
var rmw_border_2 = '2px dotted {T_BODY_LINK}';
var rmw_image_title = '{L_RMW_IMAGE_TITLE}';

window.gEBI = function (it) {
	return document.getElementById(it);
}
window.ROOT_STYLE = '{ROOT_STYLE}';
</script>
<script src="templates/_shared/js_libs.js"></script>
<script src="adr/includes/functions_adr_buildings_popup.js"></script>
<!--V: added to js_libs.js
<script language="javascript" type="text/javascript" src="./includes/js_dom_toggle.js"></script>
<script language="javascript" type="text/javascript" src="templates/tooltips.js"></script>
<script type="text/javascript" src="{U_RMWA_JSLIB}"></script>-->
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
if ( {PRIVATE_MESSAGE_NEW_FLAG} )
{
	window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
}
</script>
<!-- END switch_enable_pm_popup -->
<script>
var win = null;
function Teleport_Popup(mypage,myname,w,h,scroll)
{
  var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
  var settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
  win = window.open(mypage,myname,settings);
}
</script>
<script language="javascript" src="templates/_shared/bbc_box/fade.js" type="text/javascript"></script>
<script language="Javascript" type="text/javascript">
//V
function createReducerFor(elId) {
	var el = gEBI(elId);
	if (!el) {
		return false;
	}
	var hiderId = elId + 'Reducer'
	  , hider = gEBI(hiderId)
	  , hidden = false
	  , expires = 'Thu, 31-Dec-2099 23:59:59 GMT'
	  , curVal;
	if (null == (curVal = CFIG.getCookie(hiderId))) {
		updateHiderCookie();
	} else if (curVal == '1') {
		hideEl();
	}
	hider.onclick = function () {
		hideEl();
		updateHiderCookie();
	};
	function hideEl() {
		hidden = !hidden;
		el.style.display = hidden ? 'none' : '';
		hider.innerHTML = hidden ? '[+]' : '[-]';
	}
	function updateHiderCookie() {
		document.cookie = hiderId + '=' + (+hidden) + '; expires=' + expires;
	}
};
</script>
<style>
.gradualfader {
	opacity: 0.6;

	transition-duration: 300ms;
}
.gradualfader:hover {
	opacity: 1;
}
td.disabled {
	opacity: 0;
}
</style>
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

	<a name="top"></a> 
	<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"></p>
		<td class="bodyline">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<div align="center"><a href="{U_INDEX}"><img src="{LOGO_IMG}" border="0" alt="{L_INDEX}" vspace="1" /></a> 
				</div>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span> 
					<table cellspacing="0" cellpadding="2" border="0">
					<!-- INCLUDE header_links -->
				</table>
				<!-- INCLUDE includes/style_selector -->
				</td>
			</tr>
		</table>
		<br/>
		<!-- BEGIN board_disable -->
		<div class="forumline" style="padding: 10px; margin: 5px 2px; text-align: center">
			<span class="gen">{board_disable.MSG}</span>
		</div>
		<!-- END board_disable -->		
