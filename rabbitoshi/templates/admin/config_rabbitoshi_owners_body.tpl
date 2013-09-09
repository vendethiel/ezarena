<h1>{L_RABBITOSHI_TITLE}</h1>

<p>{L_RABBITOSHI_TEXT}</p>

<form action="{S_RABBITOSHI_ACTION}" method="post">

<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="80%">
	<tr>
		<td class="row2" align="center">{L_SELECT_OWNER}&nbsp;&nbsp;{S_SELECT_OWNER}&nbsp;&nbsp;<input type="submit" class="mainoption" value="{L_SELECT}" /></td>
	</tr>
</table>

<br clear="all" />

<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="90%">
	<tr>
		<th colspan="2">{L_RABBITOSHI_TITLE}</th>
	</tr>
	<tr>
		<td colspan="2" class="cat" align="center"><span class="cattitle">{OWNER}</span></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER}</span></td>
		<td class="row2"><span class="gen">{OWNER}</span></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET}</span></td>
		<td class="row2"><input class="post" type="text" name="pet_name" size="30" maxlength="255" value="{OWNER_PET}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_PET_TYPE}</span></td>
		<td class="row2"><span class="gen">{PET_TYPE}</span></td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_LEVEL}</span></td>
		<td class="row2"><input class="post" type="text" name="level" size="8" maxlength="8" value="{OWNER_PET_LEVEL}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_POWER}</span></td>
		<td class="row2"><input class="post" type="text" name="power" size="8" maxlength="8" value="{OWNER_PET_POWER}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_MAGICPOWER}</span></td>
		<td class="row2"><input class="post" type="text" name="magicpower" size="8" maxlength="8" value="{OWNER_PET_MAGICPOWER}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_ARMOR}</span></td>
		<td class="row2"><input class="post" type="text" name="armor" size="8" maxlength="8" value="{OWNER_PET_ARMOR}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_EXPERIENCE}</span></td>
		<td class="row2"><input class="post" type="text" name="experience" size="8" maxlength="8" value="{OWNER_PET_EXPERIENCE}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_HEALTH}</span></td>
		<td class="row2"><input class="post" type="text" name="health" size="8" maxlength="8" value="{OWNER_PET_HEALTH}" /> / <input class="post" type="text" name="healthmax" size="8" maxlength="8" value="{OWNER_PET_HEALTHMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_HUNGER}</span></td>
		<td class="row2"><input class="post" type="text" name="hunger" size="8" maxlength="8" value="{OWNER_PET_HUNGER}" /> / <input class="post" type="text" name="hungermax" size="8" maxlength="8" value="{OWNER_PET_HUNGERMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_THIRST}</span></td>
		<td class="row2"><input class="post" type="text" name="thirst" size="8" maxlength="8" value="{OWNER_PET_THIRST}" /> / <input class="post" type="text" name="thirstmax" size="8" maxlength="8" value="{OWNER_PET_THIRSTMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_HYGIENE}</span></td>
		<td class="row2"><input class="post" type="text" name="hygiene" size="8" maxlength="8" value="{OWNER_PET_HYGIENE}" /> / <input class="post" type="text" name="hygienemax" size="8" maxlength="8" value="{OWNER_PET_HYGIENEMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_MP}</span></td>
		<td class="row2"><input class="post" type="text" name="mp" size="8" maxlength="8" value="{OWNER_PET_MP}" /> / <input class="post" type="text" name="mpmax" size="8" maxlength="8" value="{OWNER_PET_MPMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_ATTACK}</span></td>
		<td class="row2"><input class="post" type="text" name="attack" size="8" maxlength="8" value="{OWNER_PET_ATTACK}" /> / <input class="post" type="text" name="attackmax" size="8" maxlength="8" value="{OWNER_PET_ATTACKMAX}" /> max</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_OWNER_PET_MAGICATTACK}</span></td>
		<td class="row2"><input class="post" type="text" name="magicattack" size="8" maxlength="8" value="{OWNER_PET_MAGICATTACK}" /> / <input class="post" type="text" name="magicattackmax" size="8" maxlength="8" value="{OWNER_PET_MAGICATTACKMAX}" /> max</td>
	</tr>
	<tr>
		<td colspan="2" class="cat">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_RABBITOSHI_PREFERENCES_NOTIFY}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="notify" value="1" {RABBITOSHI_PREFERENCES_NOTIFY_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_RABBITOSHI_PREFERENCES_HIDE}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="hide" value="1" {RABBITOSHI_PREFERENCES_HIDE_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_RABBITOSHI_PREFERENCES_FEED_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_FEED_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="feed_full" value="1" {RABBITOSHI_PREFERENCES_FEED_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_RABBITOSHI_PREFERENCES_DRINK_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_DRINK_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="drink_full" value="1" {RABBITOSHI_PREFERENCES_DRINK_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="60%"><span class="gen">{L_RABBITOSHI_PREFERENCES_CLEAN_FULL}</span><br /><span class="gensmall">{L_RABBITOSHI_PREFERENCES_CLEAN_FULL_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="clean_full" value="1" {RABBITOSHI_PREFERENCES_CLEAN_FULL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>

</table>

<br clear="all" />

<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center" width="90%">
	<tr>
		<td class="row1" align="center"><span class="gen">{L_MANUAL_UPDATE_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="catBottom" align="center"><input type="submit" name="update" value="{L_MANUAL_UPDATE}" class="mainoption" /></td>
	</tr>
</table>

</form>