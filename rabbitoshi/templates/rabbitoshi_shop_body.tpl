<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_PUBLIC_TITLE}</span></td>
	  <td align="right"><span class="gen">{L_OWNER_POINTS}: <b>{POINTS}</b> {L_POINTS}</span></td>
	</tr>
</table>

<form action="{S_PET_ACTION}" method="post">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead">{L_NAME}</th>
		<th class="thHead">{L_PIC}</th>
		<th class="thHead">{L_DESC}</th>
		<th class="thHead">{L_PRIZE}</th>
		<th class="thHead">{L_BUY}</th>
		<th class="thHead">{L_SUM}</th>
		<th class="thHead">{L_SELL}</th>
	</tr>
        <!-- BEGIN items -->
	<tr align="center">
		<td class="{items.ROW_CLASS}"><span class="gensmall">{items.NAME}</span></td>
		<td class="{items.ROW_CLASS}">{items.IMG}</td>
		<td class="{items.ROW_CLASS}"><span class="gensmall">{items.DESC}</span></td>
		<td class="{items.ROW_CLASS}"><span class="gensmall">{items.PRIZE}</span></td>
		<td class="{items.ROW_CLASS}">{items.BUY}</td>
		<td class="{items.ROW_CLASS}"><span class="gensmall">{items.SUM}</span></td>
		<td class="{items.ROW_CLASS}">{items.SELL}</td>
	</tr>
        <!-- END items -->
	<tr>
		<td class="catBottom" align="center" colspan="7"><input type="submit" value="{L_ACTION}" name="shop_action" class="liteoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />