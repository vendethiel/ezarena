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
<!-- BEGIN gamerow -->
  <tr>
  	<td colspan="2" class="cat" nowrap="nowrap" align="left"><span class="cattitle">{game.gamerow.GAMELINK}</span></td>
  </tr>
  <tr> 
	<td class="row1" height="130" width="200" align="center">{game.gamerow.GAMEPIC}</td>
	<td class="row1" valign="top">
		<span class="cattitle">{L_DESC}: </span><span class="name">{game.gamerow.GAMEDESC}</span><br /><br />
		<span class="cattitle">{L_NOTE}: </span><span class='gen'>{game.gamerow.NOTE}</span><br />
		<span class="cattitle">{L_HIGHSCORE}: </span><span class="gen">{game.gamerow.NORECORD}<b>{game.gamerow.HIGHSCORE}</b></span><span class="gensmall">&nbsp;{game.gamerow.HIGHUSER} {game.gamerow.DATEHIGH}</span><br />
		<span class="cattitle">{L_YOURSCORE}: </span><span class="gen">{game.gamerow.NOSCORE}<b>{game.gamerow.YOURHIGHSCORE}{game.gamerow.IMGFIRST}</b></span><span class='gensmall'>{game.gamerow.YOURDATEHIGH}</span><br />
		<span class="cattitle">{L_PARTIES}: </span><span class='gen'>{game.gamerow.GAMESET}</span>
	</td>
		<!-- <td width="25">{game.gamerow.URL_SCOREBOARD}</td> -->
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