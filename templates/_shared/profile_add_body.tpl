<script language="JavaScript" type="text/javascript">
<!--//
function writediv(texte)
{
document.getElementById('pseudobox').innerHTML = texte;
}

function verifPseudo(username)
{
if(username != '')
{
if(username.length<2)
writediv('<span class="gensmall" style="color:#cc0000"><strong>'+username+' :</strong> ce pseudo est trop court</span>');
else if(username.length>30)
writediv('<span class="gensmall" style="color:#cc0000"><strong>'+username+' :</strong> ce pseudo est trop long</span>');
else if(texte = file('verifpseudo.php?username='+escape(username)))
{
if(texte == 1)
writediv('<span class="gensmall" style="color:#cc0000"><strong>'+username+' :</strong> ce pseudo est deja pris</span>');
else if(texte == 2)
writediv('<span class="gensmall" style="color:#1A7917"><strong>'+username+' :</strong> ce pseudo est libre</span>');
else
writediv(texte);
}
}

}

function file(fichier)
{
if(window.XMLHttpRequest) // FIREFOX
xhr_object = new XMLHttpRequest();
else if(window.ActiveXObject) // IE
xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
else
return(false);
xhr_object.open("GET", fichier, false);
xhr_object.send(null);
if(xhr_object.readyState == 4) return(xhr_object.responseText);
else return(false);
}
</script>
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post" name="post">

{ERROR_BOX}

<table cellpadding="0" cellspacing="2" border="0" width="100%">
<tr><td width="100%" colspan="2" valign="top"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span><br /></td></tr>
<tr><td width="" valign="top">

<table cellpadding="4" cellspacing="1" border="0" class="forumline" width="200">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
<tr>
   <th class="thHead" colspan="2">{L_PROFILE}</th>
</tr>
<tr>
  <td id="reginfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('reginfo'); return false;"><div id="reginfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('reginfo'); return false;">{L_REGISTRATION_INFO}</a></div></td>
</tr>
<tr>
  <td id="profilinfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('profilinfo'); return false;"><div id="profilinfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('profilinfo'); return false;">{L_PROFILE_INFO}</a></div></td>
</tr>
<tr>
  <td id="messaginfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('messaginfo'); return false;"><div id="messaginfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('messaginfo'); return false;">Messagers</a></div></td>
</tr>
<tr>
  <td id="signatureinfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('signatureinfo'); return false;"><div id="signatureinfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('signatureinfo'); return false;">{L_SIGNATURE}</a></div></td>
</tr>
<tr>
  <td id="qpinfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('qpinfo'); return false;"><div id="qpinfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('qpinfo'); return false;">Réponse rapide</a></div></td>
</tr>
<tr>
  <td id="preifnfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('preifnfo'); return false;"><div id="preifnfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('preifnfo'); return false;">{L_PREFERENCES}</a></div></td>
</tr>
<tr>
  <td id="avatarinfo_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
  <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('avatarinfo'); return false;"><div id="avatarinfo_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('avatarinfo'); return false;">Options avatars</a></div></td>
</tr>
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
</table>
</td>
<td valign="top" width="100%">

<table id="reginfo" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="middle">{L_REGISTRATION_INFO}</th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<!-- BEGIN switch_namechange_disallowed -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="hidden" name="username" value="{USERNAME}" /><span class="gen"><b>{USERNAME}</b></span></td>
	</tr>
	<!-- END switch_namechange_disallowed -->
	<!-- BEGIN switch_namechange_allowed -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="username" size="25" maxlength="25" value="{USERNAME}" onKeyUp="verifPseudo(this.value)" /><div id="pseudobox"></div></td>
	</tr>
	<!-- END switch_namechange_allowed -->
	<tr> 
		<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="email" size="25" maxlength="255" value="{EMAIL}" /></td>
	</tr>
	<!-- BEGIN switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br />
		<span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" />
	  </td>
	</tr>
	<!-- END switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br />
		<span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br />
		<span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="password_confirm" size="25" maxlength="32" value="{PASSWORD_CONFIRM}" />
	  </td>
	</tr>
	<!-- BEGIN switch_reponse_conf -->
<tr> 
     <td class="row1"><span class="gen">{L_QUESTION_CONF}: *</span><br /><span class="gensmall">{L_QUESTION_CONF_EXPLAIN}</span></td>
     <td class="row2"><input type="text" name="reponse_conf" class="post" style="width: 100px"  size="10" maxlength="15" value="{REPONSE_CONF}" /></td>
</tr>
<!-- END switch_reponse_conf -->	
	<!-- Visual Confirmation -->
	<!-- BEGIN switch_confirm -->
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_CONFIRM_CODE_IMPAIRED}</span><br /><br />{CONFIRM_IMG}<br /><br /></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_CODE}: * </span><br /><span class="gensmall">{L_CONFIRM_CODE_EXPLAIN}</span></td>
	  <td class="row2"><input type="text" class="post" style="width: 200px" name="confirm_code" size="6" maxlength="6" value="" /></td>
	</tr>
	<!-- END switch_confirm -->
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>   
<table id="profilinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_PROFILE_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>
	  <!-- BEGIN account_delete_block -->
  <tr> 
    <td class="row1"><span class="gen">{L_ACCOUNT_DELETE}</span></td>
    <td class="row2"> 
    <input type="checkbox" name="deleteuser">
    <span class="gensmall">{L_DELETE_ACCOUNT_EXPLAIN}</span></td>
  </tr>
  <!-- END account_delete_block -->
	<!-- BEGIN switch_user_logged_in -->  
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>
	<!-- END switch_user_logged_in -->	
	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>
<!-- Start add - Gender MOD -->
<tr> 
      <td class="row1"><span class="gen">{L_GENDER}:{GENDER_REQUIRED}</span></td> 
      <td class="row2"> 
      <input type="radio" {LOCK_GENDER} name="gender" value="0" {GENDER_NO_SPECIFY_CHECKED}/> 
      <span class="gen">{L_GENDER_NOT_SPECIFY}</span>&nbsp;&nbsp; 
      <input type="radio" name="gender" value="1" {GENDER_MALE_CHECKED}/> 
      <span class="gen">{L_GENDER_MALE}</span>&nbsp;&nbsp; 
      <input type="radio" name="gender" value="2" {GENDER_FEMALE_CHECKED}/> 
      <span class="gen">{L_GENDER_FEMALE}</span></td> 
</tr>
<!-- End add - Gender MOD -->	
	<!-- BEGIN flags -->
	<tr>
	  <td class="row1"><span class="gen">{L_FLAG}:</span></td>
	  <td class="row2"><span class="genmed">{S_FLAGS_LIST}&nbsp;
		<img name="flag_img" src="{I_FLAG}" border="0" alt="" title="{L_FLAG_TITLE}" />
	  </span></td>
	</tr>
	<!-- END flags -->	
	{BIRTHDAY_SELECT_BOX}	
<!-- BEGIN switch_colortext -->
	<tr>
	  <td class="row1"><span class="gen">{L_COLORTEXT}:</span><br /><span class="gensmall">{L_COLORTEXT_EXPLAIN}</span></td>
	  <td class="row2">
		<input type="text" class="post" style="width: 100px"  name="colortext" size="35" maxlength="7" value="{COLORTEXT}" />
	  </td>
	</tr>
<!-- END switch_colortext -->
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
<table id="messaginfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">Messagers</th>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row2"> 
		<input type="text" name="icq" class="post" style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>	
<table id="signatureinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">Signature</th>
	</tr>
		<!-- BEGIN switch_user_logged_in -->
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
	<!-- END switch_user_logged_in -->	
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>   
<table id="qpinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr>
		<th class="thSides" colspan="2" height="25" valign="middle">{L_QP_SETTINGS}</th>
	</tr>
	<!-- BEGIN qpes -->
	<tr>
		<td class="row1" width="38%"><span class="gen">{qpes.L_QP_TITLE}</span><br /><span class="gensmall">{qpes.L_QP_DESC}</span></td>
		<td class="row2"><span class="gen">
			<input type="radio" name="{qpes.QP_VAR}" value="1"{qpes.QP_YES} /> {L_YES}&nbsp;
			<input type="radio" name="{qpes.QP_VAR}" value="0"{qpes.QP_NO} /> {L_NO}
		</span></td>
	</tr>
	<!-- END qpes -->
<tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>   
<table id="preifnfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>	
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_PREFERENCES}</th>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PUBLIC_VIEW_EMAIL}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewemail" value="0" {VIEW_EMAIL_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_DONATION}:</span><br />
		<span class="gensmall">{L_NOTIFY_DONATION_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifydonation" value="1" {NOTIFY_DONATION_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifydonation" value="0" {NOTIFY_DONATION_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
<!-- BEGIN switch_admin_logged_in -->	
	<tr> 
	  <td class="row1"><span class="gen">{L_HIDE_USER}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
<!-- END switch_admin_logged_in -->	
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_REPLY}:</span><br />
		<span class="gensmall">{L_NOTIFY_ON_REPLY_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifyreply" value="1" {NOTIFY_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifyreply" value="0" {NOTIFY_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_PRIVMSG}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}:</span><br /><span class="gensmall">{L_POPUP_ON_PRIVMSG_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="attachsig" value="1" {ALWAYS_ADD_SIGNATURE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="attachsig" value="0" {ALWAYS_ADD_SIGNATURE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_BBCODE}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowbbcode" value="1" {ALWAYS_ALLOW_BBCODE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowbbcode" value="0" {ALWAYS_ALLOW_BBCODE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_HTML}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowhtml" value="1" {ALWAYS_ALLOW_HTML_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowhtml" value="0" {ALWAYS_ALLOW_HTML_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
	  <td class="row2"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
	  <td class="row2"><span class="gensmall">{STYLE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}:</span></td>
	  <td class="row2"><span class="gensmall">{TIMEZONE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_USE_REL_DATE}:</span><br /><span class="gensmall">{L_USE_REL_DATE_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="use_rel_date" value="1" {USE_REL_DATE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="use_rel_date" value="0" {USE_REL_DATE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_USE_REL_TIME}:</span><br /><span class="gensmall">{L_USE_REL_TIME_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="use_rel_time" value="1" {USE_REL_TIME_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="use_rel_time" value="0" {USE_REL_TIME_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>	
	<tr> 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>  
<table id="avatarinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">	
	<!-- BEGIN switch_avatar_block -->
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_AVATAR_PANEL}</th>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><table width="70%" cellspacing="2" cellpadding="0" border="0" align="center">
			<tr> 
				<td width="65%"><span class="gensmall">{L_AVATAR_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br />{AVATAR}<br /><input type="checkbox" name="avatardel" />&nbsp;<span class="gensmall">{L_DELETE_AVATAR}</span></td>
			</tr>
		</table></td>
	</tr>
	<!-- BEGIN switch_avatar_local_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_FILE}:</span></td>
		<td class="row2"><input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}" /><input type="file" name="avatar" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_local_upload -->
	<!-- BEGIN switch_avatar_remote_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_URL}:</span><br /><span class="gensmall">{L_UPLOAD_AVATAR_URL_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_upload -->
	<!-- BEGIN switch_avatar_remote_link -->
	<tr> 
		<td class="row1"><span class="gen">{L_LINK_REMOTE_AVATAR}:</span><br /><span class="gensmall">{L_LINK_REMOTE_AVATAR_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarremoteurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_link -->
	<!-- BEGIN switch_avatar_local_gallery -->
	<tr> 
		<td class="row1"><span class="gen">{L_AVATAR_GALLERY}:</span></td>
		<td class="row2"><input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption" /></td>
	</tr>
	<!-- END switch_avatar_local_gallery -->
	<!-- BEGIN switch_default_avatar_choose -->
	<tr> 
	  <td class="row1"><span class="gen">{L_DEFAULT_AVATAR}:</span><br /><span class="gensmall">{L_DEFAULT_AVATAR_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowdefaultavatar" value="1" {DEFAULT_AVATAR_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowdefaultavatar" value="0" {DEFAULT_AVATAR_YES} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END switch_default_avatar_choose -->	
	<!-- END switch_avatar_block -->
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</td></tr></table>{S_HIDDEN_FIELDS}
</form>

<script>
// V: instantiate
dom_menu = new _dom_menu([
	'reginfo',
	'profilinfo',
	'messaginfo',			
	'signatureinfo',			
	'qpinfo',
	'preifnfo',
	'avatarinfo'
]);
</script>