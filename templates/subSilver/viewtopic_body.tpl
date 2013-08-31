
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}"><img src="{I_ICON_NAV}" border="0" align="absmiddle">{TOPIC_TITLE}</a><br />
	  <span class="gensmall"><b>{PAGINATION}</b><br />
	  &nbsp; </span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>  
	<!-- BEGIN nav -->
	-&gt; <a class="nav" href="{nav.U_NAV}" title="{nav.L_NAV_DESC_HTML}">{nav.L_NAV}</a>
	<!-- END nav -->
	</span></td>
	<!-- BEGIN toolbar -->
	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">{toolbar.S_TOOLBAR}</span></td>
	<!-- END toolbar -->	  
  </tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	{POLL_DISPLAY}
	<!-- BEGIN postrow -->
	<tr align="right">
		<td class="catHead" colspan="2" height="28">
			<span class="name"><a name="{postrow.S_NUM_ROW}" id="{postrow.S_NUM_ROW}"></a></span>
			<span class="nav">{postrow.S_NAV_BUTTONS}</span>
		</td>
	</tr> 
	<tr>
		<th class="thLeft" width="150" height="26" nowrap="nowrap">{L_AUTHOR}</th>
		<th class="thRight" nowrap="nowrap">{L_MESSAGE}</th>
	</tr>
	<tr> 
		<td class="row1" width="150" align="middle" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><a href="{postrow.U_VIEW_POSTER_PROFILE}" class="name" {postrow.POSTER_STYLE}><b>{postrow.POSTER_NAME}</b></a>{postrow.I_QP_QUOTE}</span><br />{postrow.CARD_IMG}<br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}<br />{postrow.POSTER_AVATAR}<br /><br />{postrow.PAGERANK}<br />{postrow.POSTER_GENDER}<br />{postrow.POSTER_FROM}
			<!-- BEGIN birthday -->
			<br />{L_AGE}:&nbsp;{postrow.birthday.AGE}
			<!-- BEGIN zodiac --><img class="gensmall" src="{postrow.birthday.I_ZODIAC}" alt="{postrow.birthday.L_ZODIAC}" title="{postrow.birthday.L_ZODIAC}" style="vertical-align:text-bottom;" /><!-- END zodiac -->
			<!-- BEGIN birthcake -->&nbsp;<img class="gensmall" src="{I_BIRTHCAKE}" alt="{L_BIRTHCAKE}" title="{L_BIRTHCAKE}" style="vertical-align:text-bottom;" /><!-- END birthcake -->
			<!-- END birthday -->
			<!-- BEGIN flag -->
			<br />{L_FLAG}:&nbsp;<img class="gensmall" src="{postrow.flag.FLAG_IMG}" alt="{postrow.flag.FLAG_NAME}" title="{postrow.flag.FLAG_NAME}" style="vertical-align:text-bottom;" border="0" />
			<!-- END flag --><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br/><br/>{postrow.POINTS}{postrow.DONATE_POINTS}<br />{postrow.ADR_TOPIC_BOX}<br /><a href="{postrow.RABBITOSHI_LINK}" >{L_RABBITOSHI_POSTS}</a><br /> </span><br /></td>
		<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
<!-- Start add - Yellow card admin MOD -->
<form method="post" action="{postrow.S_CARD}">
<!-- End add - Yellow card admin MOD -->			
				<td width="100%"><span class="postdetails"><b>{postrow.L_POST}: <a onclick="link_to_post({postrow.POST_ID}); return false;" href="#">#{postrow.POST_NUMBER}</a></b></span>&nbsp; &nbsp;<img src="{postrow.I_MINITIME}" width="12" height="9" alt="" title="{L_POSTED}" /><span class="postdetails">{L_POSTED}: {postrow.POST_DATE}<br /><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="" title="{L_POST_SUBJECT}" border="0" />{L_POST_SUBJECT}: {postrow.POST_SUBJECT}
					<!-- BEGIN sub_title -->
					<br /><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="" title="{L_SUB_TITLE}" border="0" />{L_SUB_TITLE}: {postrow.sub_title.SUB_TITLE}
					<!-- END sub_title -->
				</span></td>				
				<td valign="top" nowrap="nowrap">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} {postrow.DELETE_IMG} {postrow.KEEP_UNREAD_IMG} {postrow.IP_IMG}{postrow.U_R_CARD}{postrow.U_Y_CARD}{postrow.U_G_CARD}{postrow.U_B_CARD}{postrow.CARD_EXTRA_SPACE}{postrow.CARD_HIDDEN_FIELDS}</td>
<!-- Start add - Yellow card admin MOD -->
</form>
<!-- End add - Yellow card admin MOD -->				
			</tr>
			<tr> 
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><div id="message_{postrow.U_POST_ID}"><span class="postbody">{postrow.MESSAGE}</span></div><span class="postbody"></span>{postrow.ATTACHMENTS}<span class="postbody"><div align="center">{postrow.SIGNATURE}</div></span><span class="gensmall">{postrow.EDITED_MESSAGE}</span></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" colspan="2"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
			<tr> 
				<td valign="middle" nowrap="nowrap">{postrow.POSTER_ONLINE} {postrow.PROFILE_IMG}{postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{postrow.ICQ_STATUS_IMG}</div></div></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1"><img src="templates/{T_TEMPLATE_NAME}/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- BEGIN spacing -->
	</table>
	<br class="nav" />
	<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<!-- END spacing -->
	<!-- END postrow -->
	<tr align="center"> 
		<td class="catBottom" colspan="2" height="28"><table cellspacing="0" cellpadding="0" border="0">
			<tr><form method="post" action="{S_POST_DAYS_ACTION}">
				<td align="center"><span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span></td>
			</form></tr>
		</table></td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a>
		<!-- BEGIN qp_form -->
		<!-- BEGIN qp_button -->
		&nbsp;&nbsp;<a href="{qp_form.qp_button.U_QPES}" onclick="gEBI('qp_box').getElementsByTagName('textarea')[0].focus();"><img src="{qp_form.qp_button.I_QPES}" border="0" alt="{qp_form.qp_button.L_QPES_ALT}" align="middle" /></a>
		<!-- END qp_button -->
		<!-- END qp_form -->
	</span></td>	
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
	<!-- BEGIN nav -->
	-&gt; <a class="nav" href="{nav.U_NAV}" title="{nav.L_NAV_DESC_HTML}">{nav.L_NAV}</a>
	<!-- END nav -->
	</span></td>
	</tr>
</table>

<!-- BEGIN qp_form -->
{QP_BOX}
<!-- END qp_form -->

{RELATED_TOPICS}
<br class="nav" />

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr>
	<td class="catHead" colspan="2" height="28"><span class="cattitle" valign="top"><b>{L_BT_TITLE}</b></span></td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap">{PAGE_NUMBER}</td>
	<td class="row1 gensmall" width="100%">{PAGINATION}</td>
  </tr>
  <!-- BEGIN switch_attribute -->
  <tr>
  	<td class="row2 gensmall" width="150" nowrap="nowrap">{L_ATTRIBUTE}</td>
    <td class="row1 gensmall" width="100%"><form action="{F_ATTRIBUTE_URL}" method="POST">
      {S_ATTRIBUTE_SELECTOR}
      <input type="image" src="{I_MINI_SUBMIT}" name="attribute" title="{L_ATTRIBUTE_APPLY}" />
      <input type="hidden" name="{S_TOPIC_LINK}" value="{TOPIC_ID}" />
	</form></td>
  </tr>
  <!-- END switch_attribute -->
  <!-- BEGIN switch_user_logged_in -->
  <tr>
	<td class="row2 gensmall" colspan="2">{S_WATCH_TOPIC}</td>
  </tr>
  <!-- END switch_user_logged_in -->
  <tbody id="info_display" style="display:none;">
	<tr>
		<td class="row2 gensmall" valign="top" width="150" nowrap="nowrap" valign="top"><b>{L_BT_PERMS}:</b></td>
		<td class="row1 gensmall" width="100%">{S_AUTH_LIST}</td>
	</tr>
  </tbody>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
	<td align="right" valign="top"><span class="gensmall">{S_WATCH_TOPIC_IMG}<a href="javascript:dom_toggle.toggle('info_display','info_close');"><img alt="{L_BT_SHOWHIDE_ALT}" src="{I_BT_SHOWHIDE}" title="{L_BT_SHOWHIDE_ALT}" width="22" height="12" border="0" /></a></span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
  <td width="100%" align="left" valign="top" nowrap="nowrap">{S_TOPIC_ADMIN}</td>
	<td valign="top" align="right"><br class="nav" />{JUMPBOX}</td>
  </tr>
</table>
