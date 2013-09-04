<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thTop" nowrap="nowrap">{L_MOD_METEO}</th>
  </tr>
  <tr>
	<td class="row1" align="center">
	<div id="MaMeteo"></div><br />
	<span class="gensmall"><a href="javascript:qp_switch('editMeteo');">{L_DEFINIR_VILLE}&nbsp;<img src="areabb/images/home.gif" alt="" border="0"></a></span>
	<div id="editMeteo" style="display:none;position:relative;">
	<form name="SearchVille" method="post" action="" />
		<span class="gensmall">{L_TA_VILLE}<input type="text" id="ville" size="15" />&nbsp;<input type="button" value="{L_GO}" onClick="recup_info_ville();" /></span>
	</form>
	<form name="resultatsville" method="post" action="" />
		<div id="resultats"></div>
	</form>
	</div>
	</td>
</tr>
</table>
<script language="Javascript" type="text/javascript" src="areabb/mods/meteo/js/meteo.js"></script>