<form action="{S_PET_ACTION}" method="post">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_PUBLIC_TITLE}:</span></td>
	  <td align="right"><span class="nav"><a href="{S_PET_RETURN}" class="nav">  {L_RETURN}</a></span></td>
	</tr>
  </table>

<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<th class="thHead" align="center">{L_NAME}</th>
		<th class="thHead" align="center">{L_PIC}</th>
		<th class="thHead" align="center">{L_PRIZE}</th>
		<th class="thHead" align="center">{L_DESC}</th>
		<th class="thHead" align="center">{L_SUM}</th>
		<th class="thHead" align="center">{L_BUY}</th>
		<th class="thHead" align="center">{L_SELL}</th>
	</tr>
<!-- BEGIN items -->
	<tr>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.NAME}</span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall"><img src="images/Rabbitoshi/{items.IMG}" alt="{items.NAME}" /></span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.PRIZE}</span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.DESC}</span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.SUM}</span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.BUY}</a></span></td>
		<td class="{items.ROW_CLASS}" align="center"><span class="gensmall">{items.SELL}</a></span></td>
	</tr>
<!-- END items -->
	<tr>
	  <td class="row2" align="center" colspan="7" ><span class="gen">{L_OWNER_POINTS} : <b>{POINTS}</b> {L_POINTS}</td>
	</tr>
	<tr>
		<td class="row3" align="center" colspan="7"><input type="submit" value="{L_ACTION}" name="shop_action" class="liteoption" /></td>
	</tr>
</table>
</form>
<br clear="all" />

<table cellspacing="0" cellpadding="0" border="0" align="center" width="50%">
	<tr>
		<td align="center" ><span class="gensmall">{L_TRANSLATOR}</span></td>
	</tr>
</table>


