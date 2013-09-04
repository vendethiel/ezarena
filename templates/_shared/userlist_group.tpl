<!-- $Id: userlist_group.tpl,v 0.2 22/12/2006 16:39 reddog Exp $ -->

<script type="text/javascript">
//<![CDATA[
<!--//
function select_switch(status)
{
	for (i = 0; i < document.group_list.length; i++)
	{
		document.group_list.elements[i].checked = status;
	}
}
//-->
//]]>
</script>

{NAVIGATION_BOX}
<form method="post" name="group_list" action="{S_GROUP_ACTION}">
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead" colspan="2">{L_GROUP_INFORMATION}</th>
</tr>
<tr>
	<td class="row1" width="20%"><b class="genmed">{L_GROUP_NAME}:</b></td>
	<td class="row2"><span class="gen">{GROUP_NAME}</span></td>
</tr>
<tr>
	<td class="row1" width="20%"><b class="genmed">{L_GROUP_DESC}:</b></td>
	<td class="row2"><span class="gen">{GROUP_DESC}</span><br /><span class="gensmall">{GROUP_TYPE}</span></td>
</tr>
</table>
<br class="both" />
<div class="float_left margin_btm gensmall">
	<strong>{PAGE_NUMBER}</strong>&nbsp;{L_COUNT}
</div>
<!-- BEGIN pagination -->
<div class="float_right margin_btm gensmall">
	<strong>{pagination.L_GOTO_PAGE}&nbsp;{pagination.PAGINATION}</strong>
</div>
<!-- END pagination -->
<br class="both" />
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thCornerL nowrap" width="25%">{L_USERNAME}</th>
	<th class="thTop nowrap" width="15%">{L_JOINED}</th>
	<th class="thTop nowrap" width="10%">{L_POSTS}</th>
	<th class="thTop nowrap" width="15%">{L_RANK}</th>
	<th class="thTop nowrap" width="11%">{L_PM}</th>
	<th class="thTop nowrap" width="11%">{L_EMAIL}</th>
	<th class="<!-- BEGIN select -->thTop<!-- BEGINELSE select -->thCornerR<!-- END select --> nowrap" width="11%">{L_WEBSITE}</th>
	<!-- BEGIN select --><th class="thCornerR nowrap" width="5%">{L_SELECT}</th><!-- END select -->
</tr>
<!-- BEGIN membership -->
<!-- BEGIN header -->
<tr>
	<td class="row3" colspan="<!-- BEGIN select -->8<!-- BEGINELSE select -->7<!-- END select -->"><b class="gensmall">{membership.header.L_HEADER}</b></td>
</tr>
<!-- END header -->
<tr>
	<td class="{membership.ROW_CLASS}"><span class="gen">
		<a href="{membership.U_PROFILE}" title="{L_VIEWPROFILE}"{membership.USER_STYLE}>{membership.USERNAME}</a>
	</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gensmall">{membership.USER_JOINED}</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gen">{membership.USER_POSTS}</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN rank --><!-- BEGIN img --><img src="{membership.I_USER_RANK}" alt="{membership.L_USER_RANK}" title="{membership.L_USER_RANK}" /><!-- BEGINELSE img -->{membership.L_USER_RANK}<!-- END img --><!-- END rank -->
	</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gen">
		<a href="{membership.U_PM}" class="gen"><img src="{I_USER_PM}" alt="{L_USER_PM}" title="{L_USER_PM}" /></a>
	</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gen">
		<!-- BEGIN email --><a href="{membership.U_EMAIL}" class="gen"><img src="{I_USER_EMAIL}" alt="{L_USER_EMAIL}" title="{L_USER_EMAIL}" /></a><!-- BEGINELSE email -->&nbsp;<!-- END email -->
	</span></td>
	<td class="{membership.ROW_CLASS} hcenter"><span class="gen">
		<!-- BEGIN www --><a href="{membership.U_WWW}" class="gen"><img src="{I_USER_WWW}" alt="{L_USER_WWW}" title="{L_USER_WWW}" /></a><!-- BEGINELSE www -->&nbsp;<!-- END www -->
	</span></td>
	<!-- BEGIN select -->
	<td class="{membership.ROW_CLASS} hcenter"><span class="gen">
		<input type="checkbox" name="members[]" value="{membership.USER_ID}" />
	</span></td>
	<!-- END select -->
</tr>
<!-- END membership -->
<!-- BEGIN no_membership -->
<tr>
	<td class="row3" colspan="<!-- BEGIN select -->8<!-- BEGINELSE select -->7<!-- END select -->"><b class="gensmall">{L_GROUP_MEMBERSHIP}</b></td>
</tr>
<tr>
	<td class="row1 middle" colspan="<!-- BEGIN select -->8<!-- BEGINELSE select -->7<!-- END select -->"><span class="gen">{L_NO_MEMBERS}</span></td>
</tr>
<!-- END no_membership -->
<!-- BEGIN select -->
<tr>
	<td class="catBottom hright" colspan="8"><span class="gensmall">
		<input type="image" src="{I_SUBMIT}" name="change_default" alt="{L_CHANGE_DEFAULT}" title="{L_CHANGE_DEFAULT}" />
	</span></td>
</tr>
<!-- END select -->
</table>
<div class="float_left margin_top gensmall">
	<strong>{PAGE_NUMBER}</strong>&nbsp;{L_COUNT}
</div>
<!-- BEGIN pagination -->
<div class="float_right margin_top gensmall">
	<strong>{pagination.L_GOTO_PAGE}&nbsp;{pagination.PAGINATION}</strong>
</div>
<!-- END pagination -->
<!-- BEGIN select -->
<br class="both" />
<div class="gensmall hright">
	<strong><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></strong>
</div>
<!-- END select -->
</form>
<br class="both" />