<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
	    <th class="thHead" align="left">{TITRE}</th>
	</tr>
	<tr>
		<td class="row1"><br />{ICONE}<span class="genmed">{NEWS}</span><br /><br /></td>
	</tr>

	<tr>
	<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gensmall">{L_PAR}{AUTEUR}&nbsp;{LE}{DATE}</div></span></td>
	</tr>

	<tr>
		<td class="catBottom" align="right">
			<!-- BEGIN ASV -->
			{ASV.PROFILE_IMG} {ASV.PM_IMG} {ASV.EMAIL_IMG} {ASV.WWW_IMG} {ASV.AIM_IMG} {ASV.YIM_IMG} {ASV.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {ASV.ICQ_IMG}');
	else
		document.write('<div style="position:relative"><div style="position:absolute">{ASV.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{ASV.ICQ_STATUS_IMG}</div></div>');
				
				//--></script><noscript>{ASV.ICQ_IMG}</noscript>
			<!-- END ASV -->
				</td>
	</tr>

</table><br />

<!-- BEGIN no_commentaires -->
<center><span class="genmed">{L_NO_COMMENTAIRE}</span></center>
<!-- END no_commentaires -->
<!-- BEGIN commentaires -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
	    <th colspan="2" class="thHead" align="left">{COMMENTAIRES}</th>
	</tr>
	<!-- BEGIN lignes -->
	<tr>
		<td colspan="2" class="row2" align="center"><span class="gensmall"><div align="left">{L_PAR}{commentaires.lignes.AUTEUR}&nbsp;{LE}{commentaires.lignes.DATE}</div>&nbsp;&nbsp;</span></td>
	</tr>
	<tr>
		<td width="100" class="row1" align="center"><span class="genmed">{commentaires.lignes.RANK}<br />{commentaires.lignes.IMG_RANK}{commentaires.lignes.AVATAR}</span></td>
		<td class="row1" valign="top"><br /><span class="genmed">{commentaires.lignes.NEWS}</span><br /><br /></td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="{TEMPLATE}images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
<!-- END lignes -->
</table>
<br />
<br />
<center><span class="gen">{L_PAGES}&nbsp;{PAGES}</span></center>
<!-- END commentaires -->
<br />
<br />
<!-- BEGIN saisir_commentaire -->
<center><span class="genmed"><a class="mainmenu" href="javascript:qp_switch('qp_box');"><img src="areabb/images/commentaire.gif" alt="Post a comment ?" border="0">&nbsp;{L_POST_COM}</a></span><br />

<div id="qp_box" style="display:none;position:relative;">
<form action="posting.php" method="post" name="post">
<textarea name="message" rows="15" cols="76" style="width:450px" tabindex="3" class="post"></textarea>
<input type="hidden" name="sid" value="{SID}">
<input type="hidden" name="mode" value="reply" /><input type="hidden" name="t" value="{TOPIC_ID}" /><br /><br />
<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="Envoyer" />
</form>
</div>
</center>
<!-- END saisir_commentaire -->