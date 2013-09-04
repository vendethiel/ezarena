<!-- BEGIN birthdate -->
<tr>
	<td class="row1" width="35%">
		<span class="gen">{L_BIRTHDATE}{L_BIRTHDATE_REQUIRE}</span><br />
		<span class="gensmall">{L_BIRTHDATE_EXPLAIN}</span>
	</td>
	<td class="row2"><span class="genmed">
		<!-- BEGIN field -->
		<select name="{birthdate.field.NAME}"<!-- BEGIN readonly --> disabled="disabled"<!-- END readonly -->>
			<!-- BEGIN option --><option value="{birthdate.field.option.VALUE}"<!-- BEGIN selected --> selected="selected"<!-- END selected -->>{birthdate.field.option.DESCRIPTION}</option><!-- END option -->
		</select><!-- BEGIN readonly --><input type="hidden" name="{birthdate.field.NAME}" value="{birthdate.field.VALUE}" /><!-- END readonly --><!-- BEGIN sep -->&nbsp;<!-- END sep -->
		<!-- END field -->
	</span></td>
</tr>
<!-- END birthdate -->