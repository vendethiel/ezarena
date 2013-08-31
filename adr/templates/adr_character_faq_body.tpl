<script language="javascript" type="text/javascript" src="{U_CFAQ_JSLIB}"></script>
<noscript>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr>
		<td class="row1" align="center"><span class="gen"><br />{L_CFAQ_NOSCRIPT}<br />&nbsp;</span></td>
	</tr>
</table>
</noscript>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr>
		<th class="thHead">{L_FAQ_TITLE}</th>
	</tr>
</table>

<br clear="all" />

<!-- BEGIN faq_block -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="2" border="0" align="center">
	<tr> 
		<td class="catHead" height="28" align="center"><span class="cattitle">{faq_block.BLOCK_TITLE}</span></td>
	</tr>
	<!-- BEGIN faq_row -->  
	<tr> 
 		<td class="{faq_block.faq_row.ROW_CLASS}" align="left" valign="top">
 			<div onclick="return CFAQ.display('faq_a_{faq_block.faq_row.U_FAQ_ID}', false);" style="width:100%;cursor:pointer;cursor:hand;">
				<span class="gen"><a class="postlink" href="javascript:void(0)" onclick="return CFAQ.display('faq_a_{faq_block.faq_row.U_FAQ_ID}', true);" onfocus="this.blur();"><b>{faq_block.faq_row.FAQ_QUESTION}</b></span></a>
 			</div>
 			<div id="faq_a_{faq_block.faq_row.U_FAQ_ID}" style="display:none;">
				<table class="bodyline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
					<tr>
						<td class="spaceRow"><img src="adr/images/misc/spacer.gif" alt="" width="0" height="0" /></td>
					</tr>
					<tr><td align="left" valign="top"><span class="postbody">{faq_block.faq_row.FAQ_ANSWER}<br /></span></td></tr>
					<tr>
						<td class="spaceRow"><img src="adr/images/misc/spacer.gif" alt="" width="0" height="0" /></td>
					</tr>
				</table>
			</div>
 		</td>
	</tr>
	<!-- END faq_row -->
</table>
<br clear="all" />
<!-- END faq_block -->