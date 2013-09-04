<!-- BEGIN afficher_inscription -->
<br />
<form action="{S_PROFILE_ACTION}"  method="post">

{ERROR_BOX}

<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
        <tr>
		<th colspan="2">{L_REGISTRATION_INFO}</th>
        </tr>
        <tr>
                <td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
        </tr>
        <tr>
                <td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
                <td class="row2"><input type="text" class="post" name="username" size="20" maxlength="40" value="{USERNAME}" /></td>
        </tr>
        <tr>
                <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
                <td class="row2"><input type="text" class="post" name="email" size="20" maxlength="255" value="{EMAIL}" /></td>
        </tr>
        <tr>
          <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br />
                <span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
          <td class="row2">
                <input type="password" class="post" name="new_password" size="25" maxlength="100" value="{PASSWORD}" />
          </td>
        </tr>
        <tr>
          <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br />
                <span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
          <td class="row2">
                <input type="password" class="post" name="password_confirm" size="25" maxlength="100" value="{PASSWORD_CONFIRM}" />
          </td>
        </tr>

        <tr>
                <td class="catBottom" colspan="2" align="center" height="28"><input type="hidden" name="mode" value="register" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="0" /><input type="submit" name="submit" value="Enregistrez-vous" class="liteoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
        </tr>
</table>

</form>
<!-- END afficher_inscription -->