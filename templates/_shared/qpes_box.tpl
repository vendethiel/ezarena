<!-- $Id: qpes_box.tpl,v 1.2 14/06/2006 16:07 reddog Exp $ -->

<script language="javascript" type="text/javascript">
<!--

<!-- BEGIN qpm -->
var form_name = 'post';
var text_name = 'message';
<!-- END qpm -->

<!-- BEGIN qp_bbcode -->
// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

// Helpline messages
b_help = "{L_BBCODE_B_HELP}";
i_help = "{L_BBCODE_I_HELP}";
u_help = "{L_BBCODE_U_HELP}";
q_help = "{L_BBCODE_Q_HELP}";
c_help = "{L_BBCODE_C_HELP}";
l_help = "{L_BBCODE_L_HELP}";
o_help = "{L_BBCODE_O_HELP}";
p_help = "{L_BBCODE_P_HELP}";
w_help = "{L_BBCODE_W_HELP}";
a_help = "{L_BBCODE_A_HELP}";
e_help = "{L_BBCODE_E_HELP}";
s_help = "{L_BBCODE_S_HELP}";
f_help = "{L_BBCODE_F_HELP}";
e_help = "{L_BBCODE_E_HELP}";
<!-- END qp_bbcode -->

function checkForm()
{
	if (document.post.message.value.length < 2)
	{
		alert('{L_EMPTY_MESSAGE}');
		return false;
	}
	else
	{
		return true;
	}
}

<!-- BEGIN qp_more -->
function quoteSelection()
{
	var txt = '';

	if (window.getSelection)
	{
		txt = window.getSelection();
	}
	else if (document.getSelection)
	{
		txt = document.getSelection();
	}
	else if (document.selection)
	{
		txt = document.selection.createRange().text;
	}

	if (txt != '')
	{
		insert_text('[quote]' + txt + '[/quote]');
		document.post.message.focus();
		return;
	}
	else
	{
		alert('{L_NO_TEXT_SELECTED}');
	}
}
<!-- END qp_more -->

function qp_switch(id)
{
	if (document.getElementById)
	{
		if (document.getElementById(id).style.display == 'none')
		{
			document.getElementById(id).style.display = 'block';
		}
		else
		{
			document.getElementById(id).style.display = 'none';
		}
	}
	else
	{
		if (document.layers)
		{
			if (document.id.display == 'none')
			{
				document.id.display = 'block';
			}
			else
			{
				document.id.display = 'none';
			}
		}
		else
		{
			if (document.all.id.style.visibility == 'none')
			{
				document.all.id.style.display = 'block';
			}
			else
			{
				document.all.id.style.display = 'none';
			}
		}
	}
}
//-->
</script>
<!-- BEGIN qpm -->
<script language="javascript" src="templates/_shared/editor.js" type="text/javascript"></script>
<!-- END qpm -->

<div id="qp_box" style="display:{QP_DISPLAY};position:relative;">
  <form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">
	<table class="forumline" width="{QP_WIDTH}%" cellpadding="3" cellspacing="1" border="0">
	  <tr>
		<th class="thHead" colspan="2" height="25">{L_QP_TITLE}</th>
	  </tr>
	  <!-- BEGIN qpl_select -->
	  <tr> 
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b>&nbsp;</span>
			<span class="genmed"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" />
		</span></td>
	  </tr>
	  <!-- END qpl_select -->
	  <!-- BEGIN qpm_select -->
	  <tr>
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed">
			<input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" />
		</span></td>
	  </tr>
	  <!-- END qpm_select -->
	  <!-- BEGIN qp_subject -->
	  <tr> 
		<td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
		<td class="row2" width="78%"><input class="post" style="width:450px" type="text" name="subject" size="45" maxlength="{SUBJECT_LENGTH}" tabindex="2" value="{SUBJECT}" /></td>
	  </tr>
	  <!-- END qp_subject -->
	  <tr>
		<td class="row1" valign="middle">
		<!-- BEGIN qpl -->
		<table cellspacing="0" cellpadding="2" border="0">
		<!-- END qpl -->
		<!-- BEGIN qp_smilies -->
		<table width="100%" cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td valign="middle" align="center">
			<table width="100" border="0" cellspacing="0" cellpadding="5">
			  <tr align="center"> 
				<td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
			  </tr>
			  <!-- BEGIN smilies_row -->
			  <tr align="center" valign="middle"> 
				<!-- BEGIN smilies_col -->
				<td><img src="{qp_smilies.smilies_row.smilies_col.SMILEY_IMG}" border="0" onmouseover="this.style.cursor='pointer';" onclick="emoticon('{qp_smilies.smilies_row.smilies_col.SMILEY_CODE}');" alt="{qp_smilies.smilies_row.smilies_col.SMILEY_DESC}" title="{qp_smilies.smilies_row.smilies_col.SMILEY_DESC}" /></td>
				<!-- END smilies_col -->
			  </tr>
			  <!-- END smilies_row -->
			  <!-- BEGIN smilies_extra -->
			  <tr align="center"> 
				<td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
			  </tr>
			  <!-- END smilies_extra -->
			</table></td>
		  </tr>
		</table>
		<!-- END qp_smilies -->
		<!-- BEGIN qpm -->
		</td>
		<td class="row2"><table cellspacing="0" cellpadding="2" border="0">
		<!-- END qpm -->
		  <!-- BEGIN qp_bbcode -->
		  <tr align="center" valign="middle">
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td><input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onclick="bbstyle(0)" onmouseover="helpline('b')" /></td>
				<td><input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onclick="bbstyle(2)" onmouseover="helpline('i')" /></td>
				<td><input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onclick="bbstyle(4)" onmouseover="helpline('u')" /></td>
				<td><input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onclick="bbstyle(6)" onmouseover="helpline('q')" /></td>
				<td><input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onclick="bbstyle(8)" onmouseover="helpline('c')" /></td>
				<td><input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onclick="bbstyle(10)" onmouseover="helpline('l')" /></td>
				<td><input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onclick="bbstyle(12)" onmouseover="helpline('o')" /></td>
				<td><input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onclick="bbstyle(14)" onmouseover="helpline('p')" /></td>
				<td><input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" onmouseover="helpline('w')" /></td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td class="genmed">
					{L_FONT_SIZE}: {S_FONT_SIZE_TYPES}&nbsp;
					{L_FONT_COLOR}: {S_FONT_COLOR_TYPES}
				</td>
				<td class="gensmall" nowrap="nowrap" align="right"><a href="javascript:bbstyle(-1)" onmouseover="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td><script language="javascript" type="text/javascript"><!--
					colorPalette('h', 17, 5)
				//--></script></td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td><input class="helpline" type="text" name="helpbox" maxlength="100" style="width:450px; font-size:10px" value="{L_STYLES_TIP}" /></td>
		  </tr>
		  <!-- END qp_bbcode -->
		  <tr>
			<!-- BEGIN qpl -->
			<td><textarea name="message" rows="7" cols="35" wrap="virtual" style="width:425px" tabindex="3" class="post">{MESSAGE}</textarea></td>
			<!-- END qpl -->
			<!-- BEGIN qpm -->
			<td><textarea name="message" rows="15" cols="76" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" onfocus="initInsertions();">{MESSAGE}</textarea></td>
			<!-- END qpm -->
		  </tr>
		</table></td>
	  </tr>
	  <tr>
	  	<!-- BEGIN qpm -->
	  	<td class="row1"{QP_ROWSPAN} valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  	<td valign="top"><span class="gensmall"><b>{L_OPTIONS}</b></span><br />
		  	<span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
		  </tr>
		</table></td>
		<!-- END qpm -->
		<td class="row2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <!-- BEGIN html_checkbox -->
		  <tr>
			<td><input type="checkbox" name="disable_html"{S_HTML_CHECKED} /></td>
			<td width="100%"><span class="gensmall">{L_DISABLE_HTML}</span></td>
		  </tr>
		  <!-- END html_checkbox -->
		  <!-- BEGIN bbcode_checkbox -->
		  <tr>
			<td><input type="checkbox" name="disable_bbcode"{S_BBCODE_CHECKED} /></td>
			<td width="100%"><span class="gensmall">{L_DISABLE_BBCODE}</span></td>
		  </tr>
		  <!-- END bbcode_checkbox -->
		  <!-- BEGIN smilies_checkbox -->
		  <tr>
			<td><input type="checkbox" name="disable_smilies"{S_SMILIES_CHECKED} /></td>
			<td width="100%"><span class="gensmall">{L_DISABLE_SMILIES}</span></td>
		  </tr>
		  <!-- END smilies_checkbox -->
		</table></td>
	  </tr>
	  <!-- BEGIN qp_more -->
	  <!-- BEGIN logged -->
	  <tr>
	  	<td class="row2" valign="top"><span class="gensmall"><a href="javascript:qp_switch('qp_options');" />{L_QP_OPTIONS}</a></span><br />
	  	<div id="qp_options" style="display:none;position:relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><input type="checkbox" name="attach_sig"{qp_more.logged.ATTACH_SIGNATURE} /></td>
			<td width="100%"><span class="gensmall">{L_ATTACH_SIGNATURE}</span></td>
		  </tr>
		  <tr>
			<td><input type="checkbox" name="notify"{qp_more.logged.NOTIFY_ON_REPLY} /></td>
			<td width="100%"><span class="gensmall">{L_NOTIFY_ON_REPLY}</span></td>
		  </tr>
		</table></div>
		</td>
	  </tr>
	  <!-- END logged -->
	  <!-- END qp_more -->
	  <tr>
	  	<td class="catBottom" align="center" height="28" colspan="2">
	  		{S_HIDDEN_FIELDS}
			<!-- BEGIN qp_more -->
			<img class="gensmall" name="quoteselected" alt="{L_QUOTE_SELECTED}" src="{I_SELECT}" title="{L_QUOTE_SELECTED}" onmousedown="quoteSelection()" style="cursor:pointer;" border="0" />&nbsp;
			<!-- END qp_more -->
	  		<input type="image" src="{I_PREVIEW}" accesskey="v" tabindex="5" name="preview" value="{L_PREVIEW}" />&nbsp;
			<input type="image" src="{I_SUBMIT}" accesskey="s" tabindex="6" name="post" value="{L_SUBMIT}" />
		</td>
	  </tr>
	</table>
  </form>
</div>