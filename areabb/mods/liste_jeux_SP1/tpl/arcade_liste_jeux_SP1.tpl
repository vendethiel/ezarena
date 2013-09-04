<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th class="thTop" colspan="6" nowrap="nowrap">&nbsp;{CATTITLE}&nbsp;</th>
  </tr>
<!-- BEGIN no_game -->
<tr> 
	<td class="row1" height="25" width="100%" align="center"><span class="gen">{NO_GAME}</span></td>
</tr>
</table>
<!-- END no_game --> 
<!-- BEGIN game -->
  <tr> 
	<td class="cat" height="28" align="center" colspan="2"><span class="cattitle">{L_GAME}</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">{L_NOTE}</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">{L_HIGHSCORE}</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">{L_YOURSCORE}</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">{L_PARTIES}</span></td>
  </tr>
  <!-- BEGIN gamerow -->
  <tr> 
	<td class="row1" height="25" width='35' align='center'>{game.gamerow.GAMEPIC}</td>
	<td class="row1" height="25" width="250">
	    <span class='genmed'>{game.gamerow.GAMELINK}</span><br />
		<span class="name">{game.gamerow.GAMEDESC}</span>
	</td>
	<td class="row1" align="center" valign="center" >
		 <span class='gen'>{game.gamerow.NOTE}</span>
	</td>
	<td class="row1" align="center" valign="center" >
		<span class='gen'>{game.gamerow.NORECORD}<b>{game.gamerow.HIGHSCORE}</b></span>
		<span class='gensmall'>&nbsp;{game.gamerow.HIGHUSER}<br />{game.gamerow.DATEHIGH}</span>
	</td>
	<td class="row1" align="center" valign="center" >
		<span class='gen'>{game.gamerow.NOSCORE}<b>{game.gamerow.YOURHIGHSCORE}{game.gamerow.IMGFIRST}</b></span><br />
		<span class='gensmall'>{game.gamerow.YOURDATEHIGH}</span>  
	</td>
	<td class="row1" align="center" valign="center">
		<span class='gen'>{game.gamerow.GAMESET}</span>
		<table width="100%">
		<tr>
			<td align="center"></td>
			<td width="25">{game.gamerow.URL_SCOREBOARD}</td>
	    </tr>
		</table>
	</td>
  </tr>
  <!-- END gamerow -->
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="middle"><span class="nav">{L_ALLER_A}{PAGINATION}</span></td>
	</tr>
</table>
<!-- END game -->