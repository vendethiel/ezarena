<!-- BEGIN news -->
<link rel="stylesheet" type="text/css" href="areabb/mods/news/tpl/style.css" media="screen" />
<table width="100%" height="40" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
	    <th colspan="4" align="center">{L_NO_NEWS_TITRE}</th>
	</tr>
<!-- BEGIN lignes -->
	<tr>
		<!-- BEGIN news_icone -->
		<td rowspan="2" class="row1" align="center" valign="top" width="0"><a href="{news.lignes.SUITE}" title="{news.lignes.FORUM}">{news.lignes.ICONE}</a></td>
		<!-- END news_icone -->
		<td colspan="3" class="catBottom" align="left" width="100%"><a href="{news.lignes.SUITE}" title="{LE}{news.lignes.DATE}" class="info" >{news.lignes.TITRE}<span>{news.lignes.NEWS}</span></a>
	</tr>
	<tr>
		<td class="row1" width="100%">
			<span class="copyright">{LE}{news.lignes.DATE} </span>
		</td>
		<td class="row1" align="center" width="50" nowrap="nowrap">
			<span class="copyright"><img src="{I_VIEWS}" border="0" />{news.lignes.VIEWS}</span>
		</td>
		<td class="row1" align="center" width="50" nowrap="nowrap">
			<span class="copyright"><img src="{I_COMS}" border="0" />{news.lignes.COMS}</span>
		</td>
	</tr>
<!-- END lignes -->
</table>
<div style="text-align:right;"><span class="gen">{L_PAGINATION}&nbsp;{PAGINATION}</span></div>
<!-- END news -->
<!-- BEGIN no_news -->
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
	    <th align="center">{L_NO_NEWS_TITRE}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_NO_NEWS}</span></td>
	</tr>
</table>
<!-- END no_news -->