<div class="maintitle">{L_GENERAL_NEWS_ADMIN}</div>
<br />
<p>{L_GENERAL_NEWS_ADMIN_EXP}</p>
<form action="" method="post">
<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_GENERAL_SETTINGS}</th>
</tr>
<tr> 
	<td class="row1" width="38%">{L_FORUMS_NEWS}
	</td>
	<td class="row2" width="62%"> 
		<select name="news_forums[]" multiple>
			{s_news_forums}
		</select>
	</td>
</tr>
<tr> 
	<td class="row1" width="38%">{L_NBRE_MOTS}<br /></td>
	<td class="row2" width="62%"> 
		<input type="text" name="news_nbre_mots" value="{s_news_nbre_mots}" />
	</td>
</tr>
<tr> 
	<td class="row1" width="38%">{L_NBRE_COMS}<br /></td>
	<td class="row2" width="62%"> 
		<input type="text" name="news_nbre_coms" value="{s_news_nbre_coms}" />
	</td>
</tr>
<tr> 
	<td class="row1" width="38%">{L_NBRE_NEWS}<br /></td>
	<td class="row2" width="62%">
		<input type="text" name="news_nbre_news" value="{s_news_nbre_news}" />
	</td>
</tr>
<tr> 
	<td class="row1" width="38%">{L_AFF_ICONE}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="news_aff_icone" value="1" {s_news_aff_icone_yes} {desactive_icon}>
		{L_NO}<input type="radio" name="news_aff_icone" value="0" {s_news_aff_icone_no} {desactive_icon}>
	</td>
</tr>
<tr>
	<td class="row1" width="38%">{L_AFF_COMS}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="news_aff_coms" value="1" {s_news_aff_coms_yes}>
		{L_NO}<input type="radio" name="news_aff_coms" value="0" {s_news_aff_coms_no}>
	</td>
</tr>
<tr>
	<td class="row1" width="38%">{L_AFF_ASV}<br /></td>
	<td class="row2" width="62%"> 
		{L_YES}<input type="radio" name="news_aff_asv" value="1" {s_news_aff_asv_yes}>
		{L_NO}<input type="radio" name="news_aff_asv" value="0" {s_news_aff_asv_no}>
	</td>
</tr>
<tr> 
<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" class="button" />
<input type="hidden" name="action" value="enregistrer" />
</td>
</tr>

</table>
</form>