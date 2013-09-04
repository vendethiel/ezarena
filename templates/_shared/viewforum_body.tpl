<script language="Javascript" type="text/javascript">
<!--
var oldLoad = window.onload;
window.onload = function ()
{
    var elements = document.getElementsByTagName('span');
    for ( var i = 0 ; i < elements.length ; i++ )
    {
        if ( elements[i].className == 'topicmod' )
        {
            elements[i].style.display = 'none';
        }
    }

    oldLoad && oldLoad();
}
 
function show_topicmod(id)
{
    gEBI(id).style.display = ( gEBI(id).style.display == 'none' ) ? 'block' : 'none';
}
//-->
</script>
<!-- mod : topic display order -->
<form method="post" action="{S_POST_DAYS_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_FORUM}">{FORUM_NAME}</a><br /><span class="gensmall"><b>{L_MODERATOR}: {MODERATORS}<br /><br />{LOGGED_IN_USER_LIST}</b></span></td>
	  <td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b>{PAGINATION}</b></span></td>
	</tr>
	<tr> 
	  <td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	  <td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>
	  <!-- BEGIN nav -->
		-&gt; <a class="nav" href="{nav.U_NAV}" title="{nav.L_NAV_DESC_HTML}">{nav.L_NAV}</a>
		<!-- END nav -->
	  </span></td>
	  <!-- BEGIN toolbar -->
	  <td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">{toolbar.S_TOOLBAR}</span></td>
	  <!-- END toolbar -->
	</tr>
  </table>
  {SUBFORUMS}
  <!-- IF FORUM_DESC_LONG -->
  <table border="0" width="100%">
  	<tr>
  		<th nowrap="nowrap">Description</th>
  	</tr>
  	<tr>
  		<td class="row1">{FORUM_DESC_LONG}</td>
  	</tr>
  </table><br/>
  <!-- ENDIF -->
  <table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <th colspan="2" align="center" height="25" class="thCornerL" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	  <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	  <th width="100" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	  <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	  <th align="center" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN topicrow -->
	<!-- BEGIN divider -->
	<tr> 
	   <td class="catHead" colspan="7" height="28"><span class="cattitle">{topicrow.divider.L_DIV_HEADERS}</span></td>
	</tr>
	<!-- END divider -->
	<tr onmouseover="show_topicmod('tmod_{topicrow.TOPIC_ID}');" onmouseout="show_topicmod('tmod_{topicrow.TOPIC_ID}');"> 
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="{topicrow.HYPERCELL_CLASS}" width="100%"><span class="topictitle">{topicrow.TOPIC_MOD}{topicrow.TOPIC_ATTACHMENT_IMG}
{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle" >{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />&nbsp;
		<!-- BEGIN sub_title -->
		{topicrow.sub_title.SUB_TITLE}<br />
		<!-- END sub_title -->
		{topicrow.GOTO_PAGE}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row3" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
	  <td class="{topicrow.HYPERCELL_CLASS}-right" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- IF !HAS_TOPICS -->
	<tr> 
	  <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- ENDIF -->
	<tr> 
	  <td class="catBottom" align="center" valign="middle" colspan="7" height="28"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;{S_DISPLAY_ORDER} 
		<input type="submit" class="liteoption" value="{L_GO}" name="submit" />
		</span></td>
	</tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	  <td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	</tr>
  </table>
</form>
<br class="nav" />
<div id="info_display" style="display:none;">
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr>
	<td class="catHead" colspan="2" height="28"><span class="cattitle">{L_BT_TITLE}</span></td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap">{PAGE_NUMBER}</td>
	<td class="row1 gensmall" width="100%">{PAGINATION}</td>
  </tr>
  <tr>
	<td class="row2 gensmall" colspan="2"><b>{LOGGED_IN_USER_LIST}</b></td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap"><b>{L_MODERATOR}:</b></td>
	<td class="row1 gensmall" width="100%">{MODERATORS}</td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap" valign="top"><b>{L_BT_PERMS}:</b></td>
	<td class="row1 gensmall" width="100%">{S_AUTH_LIST}</td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap" valign="top"><b>{L_BT_ICONS}:</b></td>
	<td class="row1 gensmall" width="100%"><table cellspacing="3" cellpadding="0" border="0">
	  <tr>
		<td align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="19" height="18" /></td>
		<td class="gensmall">{L_NEW_POSTS}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="19" height="18" /></td>
		<td class="gensmall">{L_NO_NEW_POSTS}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" width="19" height="18" /></td>
		<td class="gensmall">{L_ANNOUNCEMENT}</td>
	  </tr>
	  <tr> 
		<td align="left"><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" width="19" height="18" /></td>
		<td class="gensmall">{L_NEW_POSTS_HOT}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" width="19" height="18" /></td>
		<td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" width="19" height="18" /></td>
		<td class="gensmall">{L_STICKY}</td>
	  </tr>
	  <tr>
		<td align="left"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_LOCKED}" width="19" height="18" /></td>
		<td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_LOCKED}" width="19" height="18" /></td>
		<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
	  </tr>
	</table></td>
  </tr>
</table>
</div>

<div id="info_close" style="display:visible;">
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr>
	<td class="catHead" colspan="2" height="28"><span class="cattitle">{L_BT_TITLE}</span></td>
  </tr>
  <!-- IF HAS_TOPICS -->
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap">{PAGE_NUMBER}</td>
	<td class="row1 gensmall" width="100%">{PAGINATION}</td>
  </tr>
  <!-- ENDIF -->
  <tr>
	<td class="row2 gensmall" colspan="2"><b>{LOGGED_IN_USER_LIST}</b></td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap" valign="top"><b>{L_BT_ICONS}:</b></td>
	<td class="row1 gensmall" width="100%"><table cellspacing="3" cellpadding="0" border="0">
	  <tr>
		<td align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="19" height="18" /></td>
		<td class="gensmall">{L_NEW_POSTS}</td>
		<td>&nbsp;&nbsp;</td>
		<td align="left"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="19" height="18" /></td>
		<td class="gensmall">{L_NO_NEW_POSTS}</td>
	  </tr>
	</table></td>
  </tr>
</table>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
	<td align="right" valign="top"><span class="gensmall">
		<a href="javascript:dom_toggle.toggle('info_display','info_close');"><img alt="{L_BT_SHOWHIDE_ALT}" src="{I_BT_SHOWHIDE}" title="{L_BT_SHOWHIDE_ALT}" width="22" height="12" border="0" /></a>
	</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="left">{JUMPBOX}</td>
  </tr>
</table>