/* 
Forum Images Expand & Highlight control for Code Divs 
Version 1.1 re-coded by SamG 05-04-03
version 1.2 re-coded by reddog (2005-08-20)
*/ 

function selectAll(elementId)
{
	var element = document.getElementById(elementId);
	if ( document.selection )
	{ 
		var range = document.body.createTextRange();
		range.moveToElementText(element);
		range.select();
	}
	if ( window.getSelection )
	{
		var range = document.createRange();
		range.selectNodeContents(element);
		var blockSelection = window.getSelection();
		blockSelection.removeAllRanges();
		blockSelection.addRange(range);
	}
}

function resizeLayer(layerId, newHeight)
{
	var myLayer = document.getElementById(layerId);
	myLayer.style.height = newHeight + 'px';
}

function codeDivStart()
{
	var randomId = Math.floor(Math.random() * 2000);

	var imgSrc = 'templates/_shared/bbc_box/images/';
	var img_expand = '<img src="' + imgSrc + 'nav_expand.gif" width="14" height="10" title="' + expand + '" onclick="resizeLayer(' + randomId + ', 200)" onmouseover="this.style.cursor = \'pointer\'" />';
	var img_expand_more = '<img src="' + imgSrc + 'nav_expand_more.gif" width="14" height="10" title="' + expand_more + '" onclick="resizeLayer(' + randomId + ', 500)" onmouseover="this.style.cursor = \'pointer\'" />';
	var img_contract = '<img src="' + imgSrc + 'nav_contract.gif" width="14" height="10" title="' + contract + '" onclick="resizeLayer(' + randomId + ', 50)" onmouseover="this.style.cursor = \'pointer\'" />';
	var img_select_all = '<img src="' + imgSrc + 'nav_select_all.gif" width="14" height="10" title="' + select_all + '" onclick="selectAll(' + randomId + ')" onmouseover="this.style.cursor = \'pointer\'" />';
	var codeDivEnd = '<div class="codetitle">' + codetext + ':' + img_expand + img_expand_more + img_contract + img_select_all + '</div><div class="codediv" id="' + randomId + '">';

	document.write(codeDivEnd); 
}