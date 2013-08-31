<script language="Javascript">
function setCheckboxes(do_check)
{
    var elts      = document.forms['jeux'].elements['check[]'];
    var elts_cnt  = (typeof(elts.length) != 'undefined')? elts.length : 0;

    if (elts_cnt)
	{
        for (var i = 0; i < elts_cnt; i++)
		{
            elts[i].checked = do_check;
        }
    }
	else
	{
        elts.checked = do_check;
    }
    return true;
} 
</script>
<h1>{L_JEUX}</h1>

<p>{L_EXPLAIN_JEUX}</p>
<center>{MESSAGE}</center>
<form action="" method="post">
<table width="65%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="4" height="25" valign="middle" nowrap="nowrap">{L_AJOUT_JEUX}</th>
</tr>
<tr>
	<td class="cat" width="120" align="center"><span class="cattitle">{L_INSTALLES}</span></td>
	<td class="cat" width="120" align="center"><span class="cattitle">{L_STOCKS}</span></td>
	<td class="cat" width="120" align="center"><span class="cattitle">{L_AJOUT_EXPLAIN_JEUX}</span></td>
</tr>
<tr>
	<td class="row2" align="center">{J_INSTALLES}</td>
	<td class="row2" align="center">{J_STOCK}</td>
	<td class="row2" align="center" nowrap="nowrap">
		<input type="text" name="url" size="50" value="" />&nbsp;&nbsp;
		<input type="submit" name="Ajouter" value="{AJOUTER}" />
		<input type="hidden" name="action" value="ajout">
		</form>
	</td>
</tr>
</table>
<br />
<!-- BEGIN listing -->
<form name="jeux" action="" method="post">
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thTop" colspan="5" height="25" valign="middle" nowrap="nowrap">{L_JEUX}</th>
</tr>
<!-- BEGIN jeux -->
<tr>
	<td rowspan="2" class="row1" width="5"><input type="checkbox" name="check[]" value="{listing.jeux.CHECK}" /></td>
	<td rowspan="2" class="row1" width="30"><img src="{listing.jeux.IMAGE}" alt="" /></td>
	<td class="cattitle"><b>{listing.jeux.TITRE}</b></td>
	<td class="row1" width="300"><b>{L_ADAPTEUR}</b> {listing.jeux.ADAPTEUR}</td>
	<td rowspan="2" class="row2" width="70"><b><a href="{listing.jeux.INSTALLER}"><img src="{I_INSTALLER}" alt="" border="0"></a></b></td>
</tr>
<tr>
	<td class="row1" colspan="2">{listing.jeux.DESC}</td>
</tr>
<!-- END jeux -->
<tr>
	<td class="row2" colspan="5" height="25" valign="middle" nowrap="nowrap">
	<img src="../../images/arrow_ltr.gif" align="left" border="0">&nbsp;&nbsp;<span class="gensmall"><a href="#" onclick="setCheckboxes(true); return false;">
            {ALL_CHECKED}</a>
        &nbsp;/&nbsp;
        <a href="#" onclick="setCheckboxes(false); return false;">
            {NOTHING_CHECKED}</a></span>&nbsp;&nbsp;
	<input type="submit" name="Ajouter" value="{AJOUTER}" />
	</td>
</tr>
</table>
<input type="hidden" name="action" value="massinstall">
</form>
<!-- END listing -->
<!-- BEGIN no_jeux -->
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thTop" colspan="5" height="25" valign="middle" nowrap="nowrap">{L_JEUX}</th>
</tr>
<tr>
	<td colspan="5" class="row1" align="center"><b>{L_NO_JEU}</b></td>
</tr>
</table>
<!-- END no_jeux -->
<br />