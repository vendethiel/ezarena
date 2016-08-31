<script language="javascript" type="text/javascript">
<!--

var bbc_url = "./../";

function bbc_highlight(something, mode)
{
	something.style.backgroundImage = "url(" + bbc_url + (mode ? "{BBC_HOVERBG_IMG})" : "{BBC_BG_IMG})");
}

function select_all()
{
	for (i = 0; i < (document.bbcbox_list.length/2); i++)
	{
		var id = (i*2);
		document.bbcbox_list.elements[id].checked = true;
	}
}
		
function select_none()
{		
	var j = 1;
	for (i = 0; i < (document.bbcbox_list.length/2); i++)
	{
		var id = i+j;
		document.bbcbox_list.elements[id].checked = true;
		j++;
	}
}

function switch_radio(id)
{
	if (document.bbcbox_list.elements[id].checked == true)
	{
		document.bbcbox_list.elements[id+1].checked = true
	}
	else if (document.bbcbox_list.elements[id+1].checked == true)
	{
		document.bbcbox_list.elements[id].checked = true
	}
}

//-->
</script>

<h1>{L_BBC_BOX_TITLE}</h1>

<p>{L_BBC_BOX_EXPLAIN}</p>

<form name="bbcbox_list" action="{S_BBC_BOX_ACTION}" method="post">
  <table width="80%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
	  <td align="right" valign="top" nowrap="nowrap"><span class="gensmall"><strong>
	  	<a href="{U_BBC_BOX_LIST}">{L_BBC_BOX_LIST}</a> &raquo; {U_SWITCH_MODE}
	  </strong></span></td>
	</tr>
  </table>
  <table width="80%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead">{L_BBC_BOX_LIST}</th>
	</tr>
	<!-- BEGIN bbc_list -->
	<tr>
		<td class="{bbc_list.ROW_CLASS}"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		  <tr>
			<td width="5%"><span class="gen">{bbc_list.BBC_ID}</span></td>
			<td><span class="gen">
				<!-- BEGIN perms -->
				<img border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" src="./../{bbc_list.BBC_IMG}" style="background-image: url('./../{BBC_BG_IMG}');" alt="" align="middle" />
				<!-- END perms -->
				<!-- BEGIN act -->
				<a href="javascript:switch_radio({bbc_list.ROW_ID});"><img border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" src="./../{bbc_list.BBC_IMG}" style="background-image: url('./../{BBC_BG_IMG}');" alt="" title="{L_BUTTON_SWITCH}" align="middle" /></a>
				<!-- END act -->
				{bbc_list.BBC_LANG}
			</span></td>
			<!-- BEGIN perms -->
			<td width="20%">&nbsp;{bbc_list.perms.BBC_S_AUTHS}&nbsp;</td>
			<!-- END perms -->
			<!-- BEGIN act -->
			<td width="25%"><input type="radio" name="{bbc_list.BBC_NAME}" value="1" {bbc_list.act.BBC_BOX_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="{bbc_list.BBC_NAME}" value="0" {bbc_list.act.BBC_BOX_NO} /> {L_NO}</td>
			<!-- END act -->
		  </tr>
		</table></td>
	</tr>
	<!-- END bbc_list -->
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
  </table>
  <!-- BEGIN act_options -->
  <table width="80%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
	  <td align="right" valign="top" nowrap="nowrap"><b><span class="gensmall"><a href="javascript:select_all();" class="gensmall">{L_ENABLE_ALL}</a> :: <a href="javascript:select_none();" class="gensmall">{L_DISABLE_ALL}</a></span></b></td>
	</tr>
  </table>
  <!-- END act_options -->
</form>

<br clear="all" />
