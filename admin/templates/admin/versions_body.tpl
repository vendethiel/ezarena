<!-- $Id: versions_body.tpl,v 1.0 06/12/2006 17:46 reddog Exp $ -->

<h1>{L_VERSIONS_CHECK}</h1>

<p>{L_VERSIONS_CHECK_EXPLAIN}</p>

<table class="forumline cells" width="100%" cellspacing="1">
<tr>
	<th class="thHead">{L_VERSION_INFORMATION}</th>
</tr>
<!-- BEGIN author -->
<tr>
	<td class="row1"><span class="genmed">
		<!-- BEGIN link --><a href="{author.U_AUTHOR}" title="{L_AUTHOR}" target="_blank"><!-- END link --><strong>{author.AUTHOR}</strong><!-- BEGIN link --></a><!-- END link --><br class="both" /><br class="both" />
		<!-- BEGIN error_msg -->{author.error_msg.ERROR_MSG}<br class="both" /><!-- END error_msg -->
		<!-- BEGIN mod -->
		&bull;&nbsp;<!-- BEGIN page --><a href="{author.mod.U_PAGE}" class="genmed" target="_blank"><!-- END page --><strong>{author.mod.NAME}</strong><!-- BEGIN page --></a><!-- END page -->
		<!-- BEGIN success -->:&nbsp;<span style="color:#1F5B13; font-weight:bold;">{L_VERSION_UP_TO_DATE}</span><!-- END success -->
		<!-- BEGIN error -->:&nbsp;<span style="color:#990000; font-weight:bold;">{L_VERSION_NOT_UP_TO_DATE}</span><!-- END error -->
		</span><blockquote class="genmed">
		<!-- BEGIN desc --><span style="font-style:italic;">{author.mod.DESC}</span><br class="both" /><br class="both" /><!-- END desc -->
		&#150;&nbsp;{L_CURRENT_VERSION}:&nbsp;<span style="color:<!-- BEGIN success -->#1F5B13<!-- END success --><!-- BEGIN error -->#990000<!-- END error --><!-- BEGIN unchecked -->#0000FF<!-- END unchecked -->; font-weight:bold;">{author.mod.CURRENT_VERSION}</span><br class="both" />
		<!-- BEGIN latest -->&#150;&nbsp;{L_LATEST_VERSION}:&nbsp;<span style="color:<!-- BEGIN success -->#1F5B13<!-- BEGINELSE success -->#990000<!-- END success -->; font-weight:bold;">{author.mod.LATEST_VERSION}</span><br class="both" /><!-- END latest -->
		<!-- BEGIN announcement --><br class="both" />{author.mod.ANNOUNCEMENT}<!-- END announcement -->
		</blockquote><span class="genmed">
		<!-- END mod -->
		<!-- BEGIN info -->{author.AUTHOR_INFO}<br class="both" /><!-- END info -->
	</span></td>
</tr>
<tr>
	<td class="spacerow"><img src="./../templates/{T_TEMPLATE_NAME}/images/spacer.gif" alt="" height="1" width="1" /></td>
</tr>
<!-- END author -->
<tr>
	<td class="catBottom middle"><span class="gensmall">
		<a href="{U_CHECK}" title="{L_CHECK}" class="gensmall"><img src="{I_CHECK}" alt="{L_CHECK}" title="{L_CHECK}" /></a>
	</span></td>
</tr>
</table>
<br class="both" />