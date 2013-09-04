<!--script language="javascript" type="text/javascript" src="{U_CFI_JSLIB}"></script-->
<script language="javascript" type="text/javascript">
<!--

var CFIG = new _CFIG('CFIG',
		['{IMG_PLUS}', '{IMG_MINUS}'],
		['{IMG_DW_ARROW}', '{IMG_UP_ARROW}'],
		['{COOKIE_PATH}', '{COOKIE_DOMAIN}', (('{COOKIE_SECURE}' == '0') ? false : true)]);
	CFIG.T['cookie'] = '{CFI_COOKIE_NAME}';
	CFIG.T['title'] = ['{L_CFI_OPTIONS}', '{L_CFI_OPTIONS_EX}'];
	CFIG.T['close'] = '{L_CFI_CLOSE}';
	CFIG.T['delete'] = '{L_CFI_DELETE}';
	CFIG.T['restore'] = '{L_CFI_RESTORE}';
	CFIG.T['save'] = '{L_CFI_SAVE}';
	CFIG.T['expand_all'] = '{L_CFI_EXPAND_ALL}';
	CFIG.T['collapse_all'] = '{L_CFI_COLLAPSE_ALL}';
	CFIG.T['u_index'] = '{U_INDEX}';
	CFIG.allowed = true;

	if( CFIG.IsEnabled() && parseInt(CFIG.getQueryVar('c')) > 0 )
	{
		window.location.replace('{U_INDEX}');
	}
// -->
</script>
	<!-- INCLUDE includes/recent_topics -->
<br/>

{BIRTHDAYS_BOX}

<!-- INCLUDE includes/announcement_center -->

<!-- BEGIN switch_user_logged_in -->
<!-- INCLUDE includes/shoutbox -->
<!-- END switch_user_logged_in -->

<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
  <tr>
<td align="left" valign="bottom"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	<td align="right" valign="bottom" class="gensmall">
		<!-- BEGIN toolbar -->
		{toolbar.S_TOOLBAR}
		<!-- END toolbar --><br/>
		{L_SEARCH_LATEST}:
		<!-- BEGIN search_latest -->
		<a href="{search_latest.U_SEARCH_LATEST_XXH}" class="gensmall">{search_latest.L_SEARCH_LATEST_XXH}</a>
		<!-- END search_latest -->
		<a href="{U_SEARCH_LATEST_XXH}" class="gensmall">{L_SEARCH_LATEST_XXH}</a><br />
		<!-- BEGIN switch_user_logged_out -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
		<!-- END switch_user_logged_out --></td>
  </tr>
</table>

<!-- BEGIN catrow -->


<!-- BEGINONLY -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="100%" colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{catrow.CAT_DESC}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th width="200" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  
  <!-- BEGIN cat -->
  <tr> 
	<td class="catLeft" colspan="3" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="rowpic" colspan="3" align="right">&nbsp;</td>
  </tr>
  <!-- END cat -->
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	
	<td class="row1" width="100%" height="50"><table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr><td><a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_ICON_IMG}</a></td>
			<td width="100%"><span {catrow.forumrow.FORUM_COLOR} class="forumlink"><a href="{catrow.forumrow.U_VIEWFORUM}" {catrow.forumrow.FORUM_COLOR} class="forumlink ">{catrow.forumrow.FORUM_NAME}</a>{catrow.forumrow.FORUM_EDIT_IMG}<br />
  				</span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
  				</span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span>
  			</td>
  		</tr>
  	</table>
	  <!-- BEGIN sub -->
	<span class="gensmall"><b>{L_SUBFORUMS}:</b>
	<!-- BEGIN item -->
	<a href="{catrow.forumrow.sub.item.U_LAST_POST}" title="{catrow.forumrow.sub.item.L_LAST_POST}"><img src="{catrow.forumrow.sub.item.FORUM_FOLDER_IMG}" style="max-width: 36px; max-height: 18px;" border="0" alt="{catrow.forumrow.sub.item.L_FORUM_FOLDER_ALT}" /></a>&nbsp;{catrow.forumrow.sub.item.FORUM_ICON_IMG}<a href="{catrow.forumrow.sub.item.U_VIEWFORUM}" {catrow.forumrow.sub.item.FORUM_COLOR} title="{catrow.forumrow.sub.item.FORUM_DESC_HTML}"><b>{catrow.forumrow.sub.item.FORUM_NAME}</b></a>{catrow.forumrow.sub.item.FORUM_EDIT_IMG}{catrow.forumrow.sub.item.L_SEP}
	<!-- END item -->
	</span>
	<!-- END sub -->
	</td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
  </tr>
  <!-- END forumrow -->
</table>
<br class="nav" /> 
<!-- END catrow -->

<!-- ENDONLY -->

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
 	<td align="left">
 		<span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span>
 	</td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<!-- INCLUDE includes/who_is_online -->

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>

<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <td class="catHead" height="28"><a name="login"></a><span class="cattitle">{L_LOGIN_LOGOUT}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="center" valign="middle" height="28"><span class="gensmall">{L_USERNAME}: 
		<input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;&nbsp;{L_PASSWORD}: 
		<input class="post" type="password" name="password" size="10" maxlength="32" />
		<!-- BEGIN switch_allow_autologin -->
		&nbsp;&nbsp; &nbsp;&nbsp;{L_AUTO_LOGIN} 
		<input class="text" type="checkbox" name="autologin" />
		<!-- END switch_allow_autologin -->
		&nbsp;&nbsp;&nbsp; 
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
		</span> </td>
	</tr>
  </table>
</form>
<!-- END switch_user_logged_out -->

<!-- BEGINONLY -->
<br clear="all" />
<!-- ENDONLY -->

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="{I_FOLDER_NEW_BIG}" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{I_FOLDER_BIG}" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{I_FOLDER_LOCKED_BIG}" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
	<td width="20" align="center"><img src="{I_FORUM_EXTERNAL}" alt="{L_FORUM_EXTERNAL}" /></td>
	<td><span class="gensmall">{L_FORUM_EXTERNAL}</span></td>
  </tr>
</table>