 
<tr> 
  <td class="row2" colspan="2"><br clear="all" />
	<table cellspacing="0" cellpadding="4" border="0" align="center">
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{POLL_QUESTION}</b></span></td>
	  </tr>
	  <tr> 
		<td align="center"> 
		  <table cellspacing="0" cellpadding="2" border="0">
			<!-- BEGIN poll_option -->
			<tr> 
			  <td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
			  <td> 
				<table cellspacing="0" cellpadding="0" border="0">
				  <tr> 
					<td width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" bgcolor="{poll_option.POLL_OPTION_COLOR}"><IMG src="images/spacer.gif" height="12"></td>
				  </tr>
				</table>
			  </td>
			  <td align="center"><b><span class="gen">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;</span></b></td>
			  <td align="center"><span class="gen">[ {poll_option.POLL_OPTION_RESULT} ]</span></td>
			</tr>
			<!-- END poll_option -->
		  </table>
		</td>
	  </tr>
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{VOTED_SHOW}{voted_vote}</b></span></td>
	  </tr>
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{L_TOTAL_VOTES}{TOTAL_VOTES}</b></span></td>
	  </tr>
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{L_RESULTS_AFTER}</span></td>
	  </tr>
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{L_POLL_EXPIRES}{POLL_EXPIRES}</span></td>
	  </tr>
	</table>
	<br clear="all" />
  </td>
</tr>
