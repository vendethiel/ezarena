 <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_HOTEL_TITLE}</span></td>
	  <td align="right"><span class="nav"><a href="rabbitoshi.php" class="nav">{L_RETURN}</a></span></td>
	</tr>
  </table>

<form action="{S_MODE_ACTION}" method="post">
<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr>
		<th class="thsides" align="center">{L_WELCOME_HOTEL}</th>
	</tr>
	<tr>
	  <td class="row2" align="center" colspan="7" ><span class="gen">{L_OWNER_POINTS} : <b>{POINTS}</b> {L_POINTS}</td>
	</tr>
<table>
<br clear="all" />

<table width="100%" border="1" cellspacing="1" cellpadding="3" align="center">
<!-- BEGIN in_hotel -->
	<tr>
		<td class="row1" align="center"><span class="gen">{L_IS_IN_HOTEL}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gen">{HOTEL_TIME}</span></td>
	</tr>
	<tr>
		<td class="row3" align="center" colspan="7"><input type="submit" value="{L_OUT_OF_HOTEL}" name="Hotel_out" class="liteoption" /></td>
	</tr>
<!-- END in_hotel -->
<!-- BEGIN not_in_hotel -->
	<tr>
		<td class="row1" align="center"> <span class="gen">{L_WELCOME_HOTEL_SERVICES}</span><br /><span class="gensmall">{L_WELCOME_HOTEL_SERVICES_COST}&nbsp;:&nbsp;{HOTEL_SERVICES_COST}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gen">{L_WELCOME_HOTEL_SERVICES_SELECT}&nbsp;<select name="Hotel_time">{HOTEL_DAYS}</select></span></td>
	</tr>
	<tr>
		<td class="row3" align="center" colspan="7"><input type="submit" value="{L_INTO_HOTEL}" name="Hotel_in" class="liteoption" /></td>
	</tr>
<!-- END not_in_hotel -->

</table>
</form>
<br clear="all" />

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>


