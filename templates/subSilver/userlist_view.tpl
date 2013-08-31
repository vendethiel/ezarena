<!-- $Id: userlist_view.tpl,v 0.2 28/11/2006 18:34 reddog Exp $ -->

{NAVIGATION_BOX}
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<td class="row1 abstop">
		<!-- BEGIN avatar --><div class="float_right_auto"><img src="{USER_AVATAR}" alt="" /></div><!-- END avatar -->
	<span class="maintitle">{USERNAME_STYLED}
	<!-- BEGIN rank -->
	</span><br /><span class="genmed">
		{L_USER_RANK}
		<!-- BEGIN img --><br /><img src="{I_USER_RANK}" alt="" title="{L_USER_RANK}" /><!-- END img -->
	<!-- END rank -->
		<br /><br class="both" />
	</span></td>
</tr>
</table>
<br class="both" />
<div class="float_left" style="width:39%;">
<table class="forumline cells" width="100%" cellspacing="1" cellpadding="3">
<tr>
	<th class="thHead">{L_PROFILE}</th>
</tr>
<tr>
	<td class="row1"><table class="subcells" cellspacing="1">
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_USERNAME}:</span></td>
		<td width="100%"><span class="gen">{USERNAME_STYLED}</span></td>
	</tr>
	<!-- BEGIN from -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_FROM}:</span></td>
		<td width="100%"><b class="gen">{USER_FROM}</b></td>
	</tr>
	<!-- END from -->
	<!-- BEGIN occupation -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_OCCUPATION}:</span></td>
		<td width="100%"><b class="gen">{USER_OCC}</b></td>
	</tr>
	<!-- END occupation -->
	<!-- BEGIN interests -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		<td width="100%"><b class="gen">{USER_INTERESTS}</b></td>
	</tr>
	<!-- END interests -->
	<!-- BEGIN birthday -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_BIRTHDATE}:</span></td>
		<td width="100%"><span class="gen">
			<strong>{USER_BIRTHDATE}</strong>&nbsp;({USER_AGE})
			<!-- BEGIN zodiac --><img src="{I_USER_ZODIAC}" alt="{L_USER_ZODIAC}" title="{L_USER_ZODIAC}" style="vertical-align:text-bottom;" /><!-- END zodiac -->
			<!-- BEGIN birthcake -->&nbsp;<img class="gensmall" src="{I_BIRTHCAKE}" alt="{L_BIRTHCAKE}" title="{L_BIRTHCAKE}" style="vertical-align:text-bottom;" /><!-- END birthcake -->
		</span></td>
	</tr>
	<!-- END birthday -->	
	<!-- BEGIN flag -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_FLAG}:</span></td>
		<td width="100%"><span class="gen">
			<strong>{L_USER_FLAG}</strong>&nbsp;<img src="{I_USER_FLAG}" alt="" title="{L_USER_FLAG}" class="absbottom" />
		</span></td>
	</tr>
	<!-- END flag -->	
	<!-- BEGIN www -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_WEBSITE}:</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_WWW}" class="gen"><img src="{I_USER_WWW}" alt="{L_USER_WWW}" title="{L_USER_WWW}" /></a>
		</span></td>
	</tr>
	<!-- END www -->
	<!-- BEGIN adr_profile -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">RPG :</span></td>
		<td width="100%"><span class="gen">
			<a href="{adr_profile.U_RPG_CHAR}" class="gen">{adr_profile.CHAR_NAME}</a>
		</span></td>
	</tr>
	<!-- END adr_profile -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">Rabbitoshi :</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_RABBITOSHI}" class="gen">Voir</a>
		</span></td>
	</tr>
	<!-- BEGIN switch_upload_limits -->
	<tr> 
		<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_UPLOAD_QUOTA}:</span></td>
		<td> 
			<table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
			<tr> 
				<td colspan="3" width="100%" class="row2">
					<table cellspacing="0" cellpadding="1" border="0">
					<tr> 
						<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{UPLOAD_LIMIT_IMG_WIDTH}" height="8" alt="{UPLOAD_LIMIT_PERCENT}" /></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td width="33%" class="row1"><span class="gensmall">0%</span></td>
				<td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
				<td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
			</tr>
			</table>
			<b><span class="genmed">[{UPLOADED} / {QUOTA} / {PERCENT_FULL}]</span> </b><br />
			<span class="genmed"><a href="{U_UACP}" class="genmed">{L_UACP}</a></span></td>
		</td>
	</tr>
	<!-- END switch_upload_limits -->
	<!-- BEGIN user_is_admin -->
	<form method="post" action="{S_PROFILE_ACTION}">
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_RANK_COLOR}:</span></td>
		<td width="100%"><span class="gen">
			{LIST_BOX}
			<input type="image" src="{I_MINI_SUBMIT}" name="change_individual" alt="{L_CHANGE_INDIVIDUAL}" title="{L_CHANGE_INDIVIDUAL}" class="absbottom" />
		</span></td>
	</tr>
	</form>
	<!-- END user_is_admin -->
	</table></td>
</tr>
</table>


<br style="clear:both;" />

<!-- IF HAS_GROUP -->
<br style="clear:both;" />
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead">{L_USERGROUPS}</th>
</tr>
<tr>
	<td class="row1">
	<table class="subcells" cellspacing="1">
	</tr>
	<!-- BEGIN groups -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen"><a href="{groups.U_GROUP}">{groups.GROUP_NAME}</a> :</span></td>
		<td width="100%"><span class="gen">{groups.GROUP_DESC}</span></td>
	</tr>
	<!-- END groups -->
	</table>
	</td>
</tr>
</table>
<!-- ENDIF -->
<br class="both" />

<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead">{L_CONTACT}</th>
</tr>
<tr>
	<td class="row1"><table class="subcells" cellspacing="1">
	<!-- BEGIN email -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_EMAIL}:</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_EMAIL}" class="gen"><img src="{I_USER_EMAIL}" alt="{L_USER_EMAIL}" title="{L_USER_EMAIL}" /></a>
		</span></td>
	</tr>
	<!-- END email -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_PM}:</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_PM}" class="gen"><img src="{I_USER_PM}" alt="{L_USER_PM}" title="{L_USER_PM}" /></a>
		</span></td>
	</tr>
	<!-- BEGIN msn -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_MSNM}:</span></td>
		<td width="100%"><span class="gen">{USER_MSN}</span></td>
	</tr>
	<!-- END msn -->
	<!-- BEGIN yim -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_YIM}:</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_YIM}" class="gen"><img src="{I_USER_YIM}" alt="{L_USER_YIM}" title="{L_USER_YIM}" /></a>
		</span></td>
	</tr>
	<!-- END yim -->
	<!-- BEGIN aim -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_AIM}:</span></td>
		<td width="100%"><span class="gen">
			<a href="{U_AIM}" class="gen"><img src="{I_USER_AIM}" alt="{L_USER_AIM}" title="{L_USER_AIM}" /></a>
		</span></td>
	</tr>
	<!-- END aim -->
	<!-- BEGIN icq -->
	<tr>
		<td class="absmiddle hright nowrap"><span class="gen">{L_ICQ}:</span></td>
		<td width="100%">
			<div style="position:relative;"><a href="{U_ICQ}" class="gen"><img src="{I_USER_ICQ}" alt="{L_USER_ICQ}" title="{L_USER_ICQ}" /></a><div id="icq_status_user" style="position:absolute; left:3px; top:-1px; display:none;"><a href="{U_ICQ_STATUS}"><img src="{I_ICQ_STATUS}" alt="" width="18" height="18" /></a></div></div>
		</td>
	</tr>
	<!-- END icq -->
	</table></td>
</tr>
</table>
</div>
<div class="float_right" style="width:59%;">
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead">{L_USER_STATS}</th>
</tr>
<tr>
	<td class="row1"><table class="subcells" cellspacing="1">
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_JOINED}:</span></td>
		<td width="100%"><b class="gen">{USER_JOINED}</b></td>
	</tr>
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_VISITED}:</span></td>
		<td width="100%"><b class="gen">{VISITED}</b></td>
	</tr>
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_TOTAL_POSTS}:</span></td>
		<td width="100%"><b class="gen">{USER_POSTS}</b><br />
		<!-- BEGIN load_statistics -->
		<span class="genmed">
			[{POSTS_PCT} / {POST_DAY}]<br />
			<a href="{U_SEARCH_AUTHOR}" class="genmed">{L_SEARCH_AUTHOR}</a>
		<!-- END load_statistics -->
		</span></td>
	</tr>
	<!-- BEGIN load_activity -->
	<!-- BEGIN f_most_active -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_ACTIVE_IN_FORUM}:</span></td>
		<td width="100%"><b class="gen"><a href="{U_ACTIVE_FORUM}" class="gen">{ACTIVE_FORUM}</a></b><br />
		<span class="genmed">
			[ {ACTIVE_FORUM_POSTS} / {ACTIVE_FORUM_PCT} ]
		</span></td>
	</tr>
	<!-- END f_most_active -->
	<!-- BEGIN t_most_active -->
	<tr>
		<td class="abstop hright nowrap"><span class="gen">{L_ACTIVE_IN_TOPIC}:</span></td>
		<td width="100%"><b class="gen"><a href="{U_ACTIVE_TOPIC}" class="gen">{ACTIVE_TOPIC}</a></b><br />
		<span class="genmed">
			[ {ACTIVE_TOPIC_POSTS} / {ACTIVE_TOPIC_PCT} ]
		</span></td>
	</tr>
	<!-- END t_most_active -->
	<!-- END load_activity -->
	</table></td>
</tr>
</table>
<!-- BEGIN signature -->
<br class="both" />
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead">{L_SIGNATURE}</th>
</tr>
<tr>
	<td class="row1"><span class="gen">{SIGNATURE}</span></td>
</tr>
</table>
<!-- END signature -->
</div>
<br class="both" />
<script type="text/javascript">
//<![CDATA[
<!--//
function _icq()
{
	this.ids = new Array();
	return this;
}
	_icq.prototype.objref = function(id)
	{
		return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
	}
	_icq.prototype.display_status = function()
	{
		if ( (navigator.userAgent.toLowerCase().indexOf('mozilla') == -1) || (navigator.userAgent.indexOf('5.') != -1) || (navigator.userAgent.indexOf('6.') != -1) )
		{
			for ( i = 1; i < this.ids.length; i++ )
			{
				icq_status = this.objref(this.ids[i]);
				if ( icq_status && icq_status.style )
				{
					icq_status.style.display = '';
				}
			}
		}
	}

icq_status = new _icq();
icq_status.ids = Array('', 'icq_status_user');
icq_status.display_status();
//-->
//]]>
</script>