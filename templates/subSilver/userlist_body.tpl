<!-- $Id: userlist_body.tpl,v 0.2 29/11/2006 14:25 reddog Exp $ -->

<form method="post" action="{S_USERLIST_ACTION}">
<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead" colspan="2">{L_OPTIONS}</th>
</tr>
<tr>
	<td class="row1 nowrap"><span class="gen">{L_SEARCH_USERNAME}:</span><br /><span class="gensmall">{L_SEARCH_EXPLAIN}</span></td>
	<td class="row2" width="100%"><input type="text" class="post" name="username" value="{USERNAME}" size="25" /></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_SELECT_SORT_METHOD}:</span></td>
	<td class="row2"><span class="gen">
		<select name="sort">{S_SORT_SELECT}</select>&nbsp;<select name="order">{S_ORDER_SELECT}</select>
	</span></td>
</tr>
<tr>
	<td class="catBottom middle" colspan="2">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_SUBMIT}" name="submit_form" alt="{L_SUBMIT}" title="{L_SUBMIT}" />
	</span></td>
</tr>
</table>
</form>
{NAVIGATION_BOX}
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
	<th class="thCornerL nowrap" width="2%">#</th>
	<th class="thTop nowrap" width="25%"><a href="{U_SORT_USERNAME}">{L_USERNAME}</a></th>
	<th class="thTop nowrap"><a href="{U_SORT_FLAG}">{L_FLAG}</a></th>	
	<th class="thTop nowrap" width="15%"><a href="{U_SORT_JOINED}">{L_JOINED}</a></th>
	<th class="thTop nowrap" width="10%"><a href="{U_SORT_POSTS}">{L_POSTS}</a></th>
	<th class="thTop nowrap" width="15%">{L_RANK}</th>
	<th class="thTop nowrap" width="11%">{L_PM}</th>
	<th class="thTop nowrap" width="11%"><a href="{U_SORT_EMAIL}">{L_EMAIL}</a></th>
	<th class="thCornerR nowrap" width="11%"><a href="{U_SORT_WEBSITE}">{L_WEBSITE}</a></th>
</tr>
<!-- BEGIN usrlist -->
<tr>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gen">{usrlist.ROW_NUMBER}</span></td>
	<td class="{usrlist.ROW_CLASS}"><span class="gen">
		<a href="{usrlist.U_PROFILE}" title="{L_VIEWPROFILE}"{usrlist.USER_STYLE}>{usrlist.USERNAME}</a>
	</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN flag --><img src="{usrlist.I_USER_FLAG}" alt="{usrlist.L_USER_FLAG}" title="{usrlist.L_USER_FLAG}" /><!-- BEGINELSE flags -->&nbsp;<!-- END flag -->
	</span></td>	
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gensmall">{usrlist.USER_JOINED}</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gen">{usrlist.USER_POSTS}</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gensmall">
		<!-- BEGIN rank --><!-- BEGIN img --><img src="{usrlist.I_USER_RANK}" alt="{usrlist.L_USER_RANK}" title="{usrlist.L_USER_RANK}" /><!-- BEGINELSE img -->{usrlist.L_USER_RANK}<!-- END img --><!-- END rank -->
	</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gen">
		<a href="{usrlist.U_PM}" class="gen"><img src="{I_USER_PM}" alt="{L_USER_PM}" title="{L_USER_PM}" /></a>
	</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gen">
		<!-- BEGIN email --><a href="{usrlist.U_EMAIL}" class="gen"><img src="{I_USER_EMAIL}" alt="{L_USER_EMAIL}" title="{L_USER_EMAIL}" /></a><!-- BEGINELSE email -->&nbsp;<!-- END email -->
	</span></td>
	<td class="{usrlist.ROW_CLASS} hcenter"><span class="gen">
		<!-- BEGIN www --><a href="{usrlist.U_WWW}" class="gen"><img src="{I_USER_WWW}" alt="{L_USER_WWW}" title="{L_USER_WWW}" /></a><!-- BEGINELSE www -->&nbsp;<!-- END www -->
	</span></td>
</tr>
<!-- END usrlist -->
<!-- BEGIN empty -->
<tr>
	<td class="row1 middle" colspan="9"><span class="gen">{L_EMPTY}</span></td>
</tr>
<!-- END empty -->
<tr>
	<td class="catBottom hright" colspan="9"><span class="gensmall">&nbsp;</span></td>
</tr>
</table>
<div class="float_left margin_top gensmall">
	<strong>{PAGE_NUMBER}</strong>&nbsp;{L_COUNT}
</div>
<!-- BEGIN pagination -->
<div class="float_right margin_top gensmall">
	<strong>{pagination.L_GOTO_PAGE}&nbsp;{pagination.PAGINATION}</strong>
</div>
<!-- END pagination -->
<br class="both" />