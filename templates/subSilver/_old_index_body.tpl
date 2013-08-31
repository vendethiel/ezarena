

<script language="javascript" type="text/javascript">
<!--
	CFIG.writeButton();
// -->
</script>  

!!! MOAR STUFF !!!

<script language="javascript" type="text/javascript">
<!--
	CFIG.writePanel();

<!-- BEGIN catrow -->
CFIG.C['cat_{catrow.CAT_ID}'] = new _CFIC('{catrow.CAT_ID}', '{catrow.DISPLAY}');
<!-- BEGIN forumrow -->
if( CFIG.C['cat_{catrow.CAT_ID}'] ) CFIG.C['cat_{catrow.CAT_ID}'].add('forum_{catrow.CAT_ID}_{catrow.forumrow.FORUM_ID}');
<!-- END forumrow -->
<!-- END catrow -->

var CFIG_oldOnLoad = window.onload;
window.onload = CFIG_onLoad;
// -->
</script>

!!! MOAR STUFF !!!

<!-- BEGIN catrow -->
<!-- BEGINONLY -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="100%" colspan="3" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{catrow.CAT_DESC}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th width="200" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  <tr onclick="CFIG_slideCat('{catrow.CAT_ID}', false);" style="cursor:pointer;cursor:hand;"  title="{catrow.CAT_DESC_NOHTML}"> 
	<td class="catLeft" colspan="3" height="28">&nbsp;&nbsp;<img name="icon_sign_{catrow.CAT_ID}" src="{SPACER}" border="0" />&nbsp;&nbsp;<span class="cattitle"><a href="{catrow.U_VIEWCAT}" onclick="return CFIG_slideCat('{catrow.CAT_ID}', true);" onfocus="this.blur();" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="rowpic" colspan="3" align="right">&nbsp;</td>
  </tr>
  <!-- BEGIN forumrow -->
  <tr id="forum_{catrow.CAT_ID}_{catrow.forumrow.FORUM_ID}" style="display:{catrow.forumrow.DISPLAY};"> 
	<td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" align="center" valign="middle" height="50">{catrow.forumrow.FORUM_ICON_IMG}</td>	
	<td class="{catrow.forumrow.HYPERCELL_CLASS}" width="100%" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}"  class="forumlink" {catrow.forumrow.TARGET}>{catrow.forumrow.FORUM_NAME}</a>{catrow.forumrow.FORUM_EDIT_IMG}<br />
	  </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  <span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
	  <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	  <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	  <td class="{catrow.forumrow.HYPERCELL_CLASS}-right" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
  </tr>
  <!-- END forumrow -->
</table>
<br class="nav" /> 
<!-- END catrow -->
