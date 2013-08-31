<!-- $Id: qpes_body.tpl,v 1.1 10/06/2006 17:51 reddog Exp $ -->

<h1>{L_QP_CONFIGURATION_TITLE}</h1>

<p>{L_QP_CONFIGURATION_DESC}</p>

<form action="{S_QPES_ACTION}" method="post">
  <table class="forumline" width="99%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
	  <th class="thHead" colspan="2">{L_QP_SETTINGS}</th>
	</tr>
	<!-- BEGIN qpes -->
	<tr>
	  <td class="row1">{qpes.L_QP_TITLE}<br /><span class="gensmall">{qpes.L_QP_DESC}</span></td>
	  <td class="row2" width="45%"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
		  <td><span class="gensmall">{L_QP_USER}</span></td>
		    <td width="100%">
			<input type="radio" name="{qpes.USER_QP_VAR}" value="1"{qpes.USER_QP_YES} /> {L_YES}&nbsp;
			<input type="radio" name="{qpes.USER_QP_VAR}" value="0"{qpes.USER_QP_NO} /> {L_NO}
		  </td>
		</tr>
		<tr>
		  <td><span class="gensmall">{L_QP_ANON}</span></td>
		  <td width="100%">
			<input type="radio" name="{qpes.ANON_QP_VAR}" value="1"{qpes.ANON_QP_YES} /> {L_YES}&nbsp;
			<input type="radio" name="{qpes.ANON_QP_VAR}" value="0"{qpes.ANON_QP_NO} /> {L_NO}
		  </td>
		</tr>
	  </table></td>
	</tr>
	<!-- END qpes -->
	<tr>
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" src="{I_SUBMIT}" name="submit_form" title="{L_SUBMIT}" />
	  </span></td>
	</tr>
  </table>
</form>