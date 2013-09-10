<!-- INCLUDE ../../adr/templates/adr_header_body -->

<table align="center" border="0" cellpadding="3" cellspacing="1" width="100%">
	<tr>
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; <a href="{U_RABBITOSHI}" class="nav">{L_RABBITOSHI}</a> &raquo; {L_HOTEL_TITLE}</span></td>
	  <td align="right"><span class="gen">{L_OWNER_POINTS}: <b>{POINTS}</b> {L_POINTS}</span></td>
	</tr>
</table>

<form action="{S_MODE_ACTION}" method="post">
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
	<tr>
		<th class="thHead">{L_WELCOME_HOTEL}</th>
	</tr>
        <!-- BEGIN in_hotel -->
	<tr>
		<td class="row1" height="45" align="center"><span class="gen">{L_IS_IN_HOTEL}&nbsp;<i>{HOTEL_TIME}</i></span></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="7"><input type="submit" value="{L_OUT_OF_HOTEL}" name="Hotel_out" class="liteoption" /></td>
	</tr>
        <!-- END in_hotel -->
        <!-- BEGIN not_in_hotel -->
	<tr>
		<td class="row2" align="center"> <span class="gen">{L_WELCOME_HOTEL_SERVICES}</span><br /><span class="gensmall">{L_WELCOME_HOTEL_SERVICES_COST}:&nbsp;{HOTEL_SERVICES_COST}</span></td>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_WELCOME_HOTEL_SERVICES_SELECT}&nbsp;<select name="Hotel_time">{HOTEL_DAYS}</select></span></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="7"><input type="submit" value="{L_INTO_HOTEL}" name="Hotel_in" class="liteoption" /></td>
	</tr>
        <!-- END not_in_hotel -->
</table>
</form>

<br clear="all" />