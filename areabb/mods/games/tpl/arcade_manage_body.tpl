<script language="Javascript">
function setCheckboxes(do_check)
{
    var elts      = document.forms['gamebox'].elements['select_list[]'];
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

<h1>{L_MANAGE_GAME}</h1>
<p><span class="gensmall">{L_MANAGE_GAME_EXPLAIN}</span></p>
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	    <th class="thTop">#</th>
	    <th colspan="2" class="thTop"><nobr>{L_GAME}</nobr></th>
	    <th class="thTop"><nobr>{L_DEPLACE}</nobr></th>
	    <th class="thTop"><nobr>{L_SETS}</nobr></th>
	    <th class="thTop"><nobr>{L_SCORES}</nobr></th>
	    <th class="thTop"><nobr>{L_HIGHSCORE}</nobr></th>
	    <th class="thTop"><nobr>{L_ACTION}</nobr></th>
	</tr>
<form name="gamebox" action="{S_ACTION}" method="post">
<!-- BEGIN ligne_jeu -->
	<tr>
		<td class="row1"><input type=checkbox name="select_list[]" value="{ligne_jeu.CHECK}"></td>
		<td class="row1" width="40">{ligne_jeu.ICONE}</td>
		<td class="row1" width="100%"><span class="genmed">{ligne_jeu.TITRE_JEU}</span></td>
		<td class="row1" align="center">
 		<a href="{ligne_jeu.U_UP}" alt="{ligne_jeu.L_UP}" title="{ligne_jeu.L_UP}"><img src="{I_UP}" border="0"></a>
		<a href="{ligne_jeu.U_DOWN}" alt="{ligne_jeu.L_DOWN}" title="{ligne_jeu.L_DOWN}"><img src="{I_DOWN}" border="0"></a>
 		</td>
		<td class="row1" width="100%" align="center"><span class="genmed">{ligne_jeu.NB_SETS}</span></td>
		<td class="row1" width="100%" align="center"><span class="genmed">{ligne_jeu.NB_SCORES}</span></td>
		<td class="row1" width="100%" align="center"><span class="genmed">{ligne_jeu.RECORD_JEU}</span></td>
		<td class="row1" width="100%" align="center"><span class="genmed"><a href="{ligne_jeu.U_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" title="{L_EDIT}" ></a></span></td>
	</tr>
<!-- END ligne_jeu -->
<!-- BEGIN switch_liste_non_vide -->
	<tr>
		<td colspan="8" class="row2">
			<img src="../../images/arrow_ltr.gif">
	        &nbsp;&nbsp;<span class="gensmall"><a href="{S_ACTION}" onclick="setCheckboxes(true); return false;">
            {ALL_CHECKED}</a>
        &nbsp;/&nbsp;
        <a href="{S_ACTION}" onclick="setCheckboxes(false); return false;">
            {NOTHING_CHECKED}</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{L_FOR_GAME_SELECTION} :
			<select name='selection'>
			<option value='Z'>{INITIAL_SCORE}</option>
			<option value='S'>{DELETE_GAME}</option>
			<option value='Y'>{SYNCHRO_GAME_SET}</option>
			</select>&nbsp;
			{L_DEPLACER}<select name='deplacer'>{DEPLACER}</select>
			<input type=submit name="valid" value="Ok" class="liteoption">
		</td>
	</tr>
<!-- END switch_liste_non_vide -->
{HIDDEN_FIELDS}
</form>
</table>
<br clear="all" />
