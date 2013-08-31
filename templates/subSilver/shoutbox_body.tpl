{BBC_JS_BOX}
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
<link rel="stylesheet" href="{T_URL}/{T_HEAD_STYLESHEET}" type="text/css">
</HEAD>

<body bgcolor="{T_TR_COLOR3}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}"> 
<form method="post" name="post" action="{U_SHOUTBOX}" onsubmit="return checkForm(this)">
{ERROR_BOX}
<tr>
	  			
			<td class="row1" align="center" valign="middle" width="100%">
				<center><span class="gensmall">
 	<!-- Disable that crap
 	<!-- BEGIN switch_auth_post -->
 	<!-- BEGIN switch_bbcode -->				
<a href="javascript:void(0);" onmouseover="helpline('bold')" onclick="bbstyle(0)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/bold.gif" name="addbbcode0" /></a>
<a href="javascript:void(0);" onmouseover="helpline('italic')" onclick="bbstyle(2)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/italic.gif" name="addbbcode2" /></a>
<a href="javascript:void(0);" onmouseover="helpline('underline')" onclick="bbstyle(4)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/underline.gif" name="addbbcode4" /></a>
<a href="javascript:void(0);" onmouseover="helpline('quote')" onclick="bbstyle(6)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/quote.gif" name="addbbcode6" /></a>
<a href="javascript:void(0);" onmouseover="helpline('code')" onclick="bbstyle(8)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/code.gif" name="addbbcode8" /></a>
<a href="javascript:void(0);" onmouseover="helpline('ulist')" onclick="bbstyle(10)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/ulist.gif" name="addbbcode10" /></a>
<a href="javascript:void(0);" onmouseover="helpline('olist')" onclick="bbstyle(12)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/olist.gif" name="addbbcode12" /></a>
<a href="javascript:void(0);" onmouseover="helpline('picture')" onclick="bbstyle(14)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/picture.gif" name="addbbcode14" /></a>
<a href="javascript:void(0);" onmouseover="helpline('www')" onclick="bbstyle(16)"><img class="bbc_off" border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" onclick="if (window.bbc_highlight) bbc_highlight(this, false);" src="templates/bbc_box/styles/default/www.gif" name="addbbcode16" /></a></td>
	 	<!-- END switch_bbcode -->
</br>
-->
{L_SHOUT_TEXT}:&nbsp;
<input type="text" class="liteoption" name="message" value="{MESSAGE}" size="70%" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" style="background-color: #FFFFFF"/>
<center>

{L_FONT_COLOR} :&nbsp; 
					<select name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="{T_FONTCOLOR1}" class="genmed">{L_COLOR_DEFAULT}</option>
					  <option style="color:darkred; background-color: {T_TD_COLOR1}" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
					  <option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
					  <option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
					  <option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
					  <option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
					  <option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
					  <option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
					  <option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
					  <option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
					  <option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
					  <option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
					  <option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
					  <option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
					</select> &nbsp;{L_FONT_SIZE} :&nbsp;<select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="genmed">{L_FONT_TINY}</option>
					  <option value="9" class="genmed">{L_FONT_SMALL}</option>
					  <option value="12" selected class="genmed">{L_FONT_NORMAL}</option>
					  <option value="18" class="genmed">{L_FONT_LARGE}</option>
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>

<input type="submit" class="liteoption" style="width: 70px" value="Envoyer" name="shout" />&nbsp;&nbsp;


<input type="submit" class="liteoption" style="width: 70px" value="{L_SHOUT_REFRESH}" name="refresh" />&nbsp;&nbsp;

<input type="button" class="liteoption" value="Smilies" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=400,resizable=yes,scrollbars=yes,WIDTH=250');return false;" style="width: 70px" target="_phpbbsmilies"></a>

</center></span>
</span></br>
		 <iframe src="{U_SHOUTBOX_VIEW}" align="left" width="100%" height="270" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true">
		</iframe>
</td></td></tr></table></td></table></td></tr><tr>

	<!-- END switch_auth_post -->
	<!-- BEGIN switch_auth_no_post -->
				{L_SHOUTBOX_LOGIN}&nbsp;
	<!-- END switch_auth_no_post -->
				</span>		
				<center>
			</td>

</tr>
</table>

</form>
</body>