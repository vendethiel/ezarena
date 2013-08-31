<!-- $Id: userlist_leaders.tpl,v 0.2 23/12/2006 11:32 reddog Exp $ -->

{NAVIGATION_BOX}
<table class="forumline cells" width="100%" cellspacing="1">
<!-- BEGIN leadership -->
<!-- BEGIN spacing -->
</table>
<br class="both" />
<table class="forumline cells" width="100%" cellspacing="1">
<!-- END spacing -->
<!-- BEGIN header -->
<tr>
	<th class="thHead" colspan="6">{leadership.header.L_HEADER}</th>
</tr>
<tr>
	<td class="row3 hcenter nowrap" width="20%"><b class="gensmall">{L_USERNAME}</b></td>
	<td class="row3 hcenter nowrap" width="25%"><b class="gensmall">{L_MODERATE_FORUMS}</b></td>
	<td class="row3 hcenter nowrap" width="20%"><b class="gensmall">{L_PRIMARY_GROUP}</b></td>
	<td class="row3 hcenter nowrap" width="15%"><b class="gensmall">{L_RANK}</b></td>
	<td class="row3 hcenter nowrap" width="10%"><b class="gensmall">{L_PM}</b></td>
	<td class="row3 hcenter nowrap" width="10%"><b class="gensmall">{L_EMAIL}</b></td>
</tr>
<!-- END header -->
<tr>
	<td class="{leadership.ROW_CLASS}"><span class="gen">
		<a href="{leadership.U_PROFILE}" title="{L_VIEWPROFILE}"{leadership.USER_STYLE}>{leadership.USERNAME}</a>
	</span></td>
	<td class="{leadership.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN moderate_forums -->{leadership.S_FORUM_SELECT}<!-- BEGINELSE moderate_forums -->&nbsp;<!-- END moderate_forums -->
	</span></td>
	<td class="{leadership.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN default_group --><a href="{leadership.default_group.U_GROUP}"{leadership.default_group.GROUP_STYLE}>{leadership.default_group.GROUP_NAME}</a><!-- BEGINELSE default_group -->{leadership.L_GROUP_UNDISCLOSED}<!-- END default_group -->
	</span></td>
	<td class="{leadership.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN rank --><!-- BEGIN img --><img src="{leadership.I_USER_RANK}" alt="{leadership.L_USER_RANK}" title="{leadership.L_USER_RANK}" /><!-- BEGINELSE img -->{leadership.L_USER_RANK}<!-- END img --><!-- END rank -->
	</span></td>
	<td class="{leadership.ROW_CLASS} hcenter"><span class="gen">
		<a href="{leadership.U_PM}" class="gen"><img src="{I_USER_PM}" alt="{L_USER_PM}" title="{L_USER_PM}" /></a>
	</span></td>
	<td class="{leadership.ROW_CLASS} hcenter"><span class="gen">
		<!-- BEGIN email --><a href="{leadership.U_EMAIL}" class="gen"><img src="{I_USER_EMAIL}" alt="{L_USER_EMAIL}" title="{L_USER_EMAIL}" /></a><!-- BEGINELSE email -->&nbsp;<!-- END email -->
	</span></td>
</tr>
<!-- END leadership -->
<!-- BEGIN empty -->
<tr>
	<td class="row1 middle"><span class="gen">{L_EMPTY}</span></td>
</tr>
<!-- END empty -->
</table>
<br class="both" />