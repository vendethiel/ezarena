<table border="0" cellspacing="0" cellpadding="0" align="center" width="1024" >
	<tr>
		<td align="center">
			<br />
			<table cellspacing="2" cellpadding="2" border="1" align="center" class="forumline" width="80%" >
				<tr>
					<td align="center" class="row1" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='adr_questbook.php';" onmouseout="this.className='row1';"><span class="gen"><br />{QUEST_BOOK_LINK}<br /><br /></span></td>
					<td align="center" class="row2" onmouseover="this.style.cursor='hand';this.className='row3';" onClick="window.location.href='adr_questbook_history.php';" onmouseout="this.className='row2';"><span class="gen"><br />{QUEST_BOOK_HISTORY_LINK}<br /><br /></span></td>
				</tr>
			</table>
			<br />
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<h1>{QUEST_BOOK_TITLE}</h1>
					</td>
				</tr>
				<tr>
					<td>
				<!-- BEGIN quest -->
						<table border="2" width="100%">
							<tr>
								<td>
									<table border="1" cellspacing="0" cellpadding="3" width="100%">
										<tr>
											<td align="center" colspan="2" width="150" algin="center" class="gen">
												{quest.NPC_NAME}
											</td>
											<td rowspan="2" valign="top" class="gen">
												{quest.NPC_MESSAGE}
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" class="gen">
												{quest.NPC_ZONE}
											</td>
										<tr>
											<td colspan="3" align="center" class="gen">
												{quest.QUEST_STATUS}
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table border="0">
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
						</table>
				<!-- END quest -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>