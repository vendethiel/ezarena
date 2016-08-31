<script language="javascript" type="text/javascript">
<!--

var bbc_url = "./../";

function bbc_highlight(something, mode)
{
	something.style.backgroundImage = "url(" + bbc_url + (mode ? "{BBC_HOVERBG_IMG})" : "{BBC_BG_IMG})");
}

//-->
</script>

<h1>{L_BBC_TITLE}</h1>

<p>{L_BBC_TEXT}</p>

<form method="post" action="{S_BBC_BOX_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_BBC_NAME}</th>
		<th class="thTop">{L_BBC_IMG_DISPLAY}</th>
        	<th class="thTop">{L_BBC_BEFORE}</th>
		<th class="thTop">{L_BBC_AFTER}</th>
		<th class="thTop">{L_BBC_HELPLINE}</th>
		<th class="thTop">{L_BBC_IMG}</th>
		<th class="thTop">{L_BBC_DIVIDER}</th>
		<th class="thTop">{L_EDIT}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN bbc -->
	<tr>
		<td class="{bbc.ROW_CLASS}" align="center">{bbc.BBC_NAME}</td>
        	<td class="{bbc.ROW_CLASS}" align="center"><img border="0" onmouseover="bbc_highlight(this, true);" onmouseout="if (window.bbc_highlight) bbc_highlight(this, false);" src="./../{bbc.BBC_IMG_DISPLAY}" style="background-image: url('./../{BBC_BG_IMG}');" alt="" title="" align="middle" /></td>
        	<td class="{bbc.ROW_CLASS}" align="center">[{bbc.BBC_BEFORE}]</td>
		<td class="{bbc.ROW_CLASS}" align="center">[/{bbc.BBC_AFTER}]</td>
		<td class="{bbc.ROW_CLASS}" align="center">{bbc.BBC_HELPLINE}</td>
		<td class="{bbc.ROW_CLASS}" align="center">{bbc.BBC_IMG}</td>
		<td class="{bbc.ROW_CLASS}" align="center">{bbc.BBC_DIVIDER}</td>
		<td class="{bbc.ROW_CLASS}" align="center"><a href="{bbc.U_BBC_EDIT}">{L_EDIT}</a></td>
		<td class="{bbc.ROW_CLASS}" align="center"><a href="{bbc.U_BBC_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END bbc -->			
	<tr>
		<td class="catBottom" align="center" colspan="9"><input type="submit" class="mainoption" name="add" value="{L_ADD_BBC}" /></td>
	</tr>
</table></form>
