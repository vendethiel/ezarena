<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"> 
	<tr> 
		<td align="center" class="catHead" height="28"><a name="login"></a><span class="cattitle">{MARQUEE_TOPIC}</span>&nbsp;
		<a id="recentTopicsReducer" href="javascript:void 0">[-]</a></td> 
	</tr> 
	<tr id="recentTopics" height="230px"> 
		<td class="row1" valign="top"><span class="gen"> 
			<marquee id="recent_topics" behavior="scroll" direction="up" height="200" scrolldelay="100" scrollamount="2"> 
			<table cellpadding="4" cellSpacing="1" width="100%"> 
			<!-- BEGIN marqueerow --> 
				<tr valign="top"> 
					<td class="row2" vAlign="center" align="middle" width="20"> 
						<img src="{marqueerow.FOLD_URL}"> 
					</td> 
					<td class="row2" width="352"> 
						<span class="forumlink"><a href="{marqueerow.TOPIC_URL}" onMouseOver="document.all.recent_topics.stop()" onMouseOut="document.all.recent_topics.start()">{marqueerow.TOPIC_TITLE}</a></span> 
						<span class="gensmall"><br /></span> 
					</td>
					<td class="row2" width="1%" nowrap> 
						<span class="gensmall"><a href="{marqueerow.POST_URL}"><img src="{I_ICON_LATEST_REPLY}" border="0" title="{L_GO_TO_LATEST_REPLY}" /></a></span> 
					</td>				
					<td class="row2" vAlign="center" align="middle" width="78"> 
						<span class="gensmall"><a href="{marqueerow.USER_PROF}" onMouseOver="document.all.recent_topics.stop()" onMouseOut="document.all.recent_topics.start()"{marqueerow.STYLE} >{marqueerow.USERNAME}</a></span> 
					</td> 
					<td class="row2" vAlign="center" noWrap align="middle" width="100"> 
						<span class="gensmall">{marqueerow.POST_DATE}</span> 
					</td> 
				</tr> 
			<!-- END marqueerow --> 
			</table> 
			</marquee> 
		</td> 
	</tr> 
</table>
<script>
createReducerFor('recentTopics');
</script>