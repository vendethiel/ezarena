<!-- BEGIN birthdays -->
<table class="forumline" width="100%" cellpadding="3" cellspacing="1">
<tr>
	<td class="catHead" colspan="2"><span class="cattitle">{L_WHICH_BIRTHDAY}</span></td>
</tr>
<tr>
	<td class="row1" style="vertical-align:middle;"<!-- BEGIN lookahead --> rowspan="2"<!-- END lookahead -->><img src="{I_BIRTHCAKE}" alt="{L_BIRTHDAYS}" /></td>
	<td class="row1" width="100%"><span class="gensmall">
		{L_CONGRATULATIONS}&nbsp;<!-- BEGIN today --><!-- BEGIN row --><!-- BEGIN sep -->, <!-- END sep --><a href="{birthdays.today.row.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" class="gensmall"{birthdays.today.row.STYLE}>{birthdays.today.row.USERNAME}</a><!-- BEGIN age -->&nbsp;<em>({birthdays.today.row.AGE})</em><!-- END age --><!-- BEGINELSE row -->{L_NO_BIRTHDAYS}<!-- END row --><!-- END today -->
	</span></td>
<!-- BEGIN lookahead -->
<tr>
	<td class="row1" width="100%"><span class="gensmall">
		{L_UPCOMING}&nbsp;<!-- BEGIN row --><!-- BEGIN sep -->, <!-- END sep --><a href="{birthdays.lookahead.row.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" class="gensmall"{birthdays.lookahead.row.STYLE}>{birthdays.lookahead.row.USERNAME}</a><!-- BEGIN age -->&nbsp;<em>({birthdays.lookahead.row.AGE})</em><!-- END age --><!-- BEGINELSE row -->{L_NO_UPCOMING}<!-- END row -->
	</span></td>
</tr>
<!-- END lookahead -->
</tr>
</table>
<br class="both" />
<!-- END birthdays -->