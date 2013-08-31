<!-- BEGIN list -->
<select id="{list.LIST_NAME}" name="{list.LIST_NAME}"<!-- BEGIN width --> style="width:{list.LIST_WIDTH}px;"<!-- END width -->{list.LIST_HTML}>
	<!-- BEGIN element -->
	<!-- BEGIN optgroup_close --></optgroup><!-- END optgroup_close -->
	<!-- BEGIN optgroup_open --><optgroup label="{list.element.optgroup_open.LABEL}"><!-- END optgroup_open -->
	<option value="{list.element.VALUE}"{list.element.STYLE}<!-- BEGIN selected --> selected="selected"<!-- END selected -->>{list.element.NAME}</option>
	<!-- END element -->
	<!-- BEGIN optgroup --></optgroup><!-- END optgroup -->
</select>
<!-- END list -->