//
// BBcode Control by subBlue design [ www.subBlue.com ]
// Includes unixsafe colour palette selector by SHS`
//
// 2005-06-08 - modified font size and font type insertion (reddog)
// 2005-07-01 - fixed scroll position after insertion with Mozilla/Firefox (reddog)
// 2005-08-05 - added background-color in the table for palette color (reddog)

// Startup Variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla') != -1) && (clientPC.indexOf('spoofer') == -1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera') == -1)
                && (clientPC.indexOf('webtv') == -1) && (clientPC.indexOf('hotjava') == -1));

var is_win = ((clientPC.indexOf("win") != -1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac") != -1);

// Fix a bug involving the TextRange object in IE. From
// http://www.frostjedi.com/terra/scripts/demo/caretBug.html
var baseHeight;
function initInsertions()
{
	if (is_ie && typeof(baseHeight) != 'number')
	{
		baseHeight = document.selection.createRange().duplicate().boundingHeight;
	}
}

// Shows the help messages in the helpline window
function helpline(help)
{
	document.forms[form_name].helpbox.value = eval(help + "_help");
}

// Replacement for arrayname.length property
function getarraysize(thearray)
{
	for (i = 0; i < thearray.length; i++)
	{
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
		{
			return i;
		}
	}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray, value)
{
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray)
{
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function emoticon(text)
{
	text = ' ' + text + ' ';
	if (document.forms[form_name].elements[text_name].createTextRange && document.forms[form_name].elements[text_name].caretPos)
	{
		if (baseHeight != document.forms[form_name].elements[text_name].caretPos.boundingHeight)
		{
			document.forms[form_name].elements[text_name].focus();
			storeCaret(document.forms[form_name].elements[text_name]);
		}

		var caretPos = document.forms[form_name].elements[text_name].caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		document.forms[form_name].elements[text_name].focus();
	}
	else
	{
		var selStart = document.forms[form_name].elements[text_name].selectionStart;
		var selEnd = document.forms[form_name].elements[text_name].selectionEnd;

		mozWrap(document.forms[form_name].elements[text_name], text, '')
		document.forms[form_name].elements[text_name].focus();
		document.forms[form_name].elements[text_name].selectionStart = selStart + text.length;
		document.forms[form_name].elements[text_name].selectionEnd = selEnd + text.length;
	}
}

function bbfontstyle(bbopen, bbclose)
{
	theSelection = false;

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text;

		if (!theSelection)
		{
			insert_text(bbopen + bbclose);
			document.forms[form_name].elements[text_name].focus();
			return;
		}

		document.selection.createRange().text = bbopen + theSelection + bbclose;
		document.forms[form_name].elements[text_name].focus();
		return;
	}
	else if (document.forms[form_name].elements[text_name].selectionEnd && (document.forms[form_name].elements[text_name].selectionEnd - document.forms[form_name].elements[text_name].selectionStart > 0))
	{
		mozWrap(document.forms[form_name].elements[text_name], bbopen, bbclose);
		document.forms[form_name].elements[text_name].focus();
		theSelection = '';
		return;
	}
	else
	{
		insert_text(bbopen + bbclose);
		document.forms[form_name].elements[text_name].focus();
		return;
	}

	storeCaret(document.forms[form_name].elements[text_name]);
}

function insert_text(text)
{
	if (document.forms[form_name].elements[text_name].createTextRange && document.forms[form_name].elements[text_name].caretPos)
	{
		if (baseHeight != document.forms[form_name].elements[text_name].caretPos.boundingHeight)
		{
			document.forms[form_name].elements[text_name].focus();
			storeCaret(document.forms[form_name].elements[text_name]);
		}

		var caretPos = document.forms[form_name].elements[text_name].caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
	}
	else
	{
		var selStart = document.forms[form_name].elements[text_name].selectionStart;
		var selEnd = document.forms[form_name].elements[text_name].selectionEnd;

		mozWrap(document.forms[form_name].elements[text_name], text, '')
		document.forms[form_name].elements[text_name].selectionStart = selStart + text.length;
		document.forms[form_name].elements[text_name].selectionEnd = selEnd + text.length;
	}
}

function attach_inline()
{
	insert_text('[attachment=' + document.forms[form_name].elements['attachments'].value + ']' + document.forms[form_name].elements['attachments'].options[document.forms[form_name].elements['attachments'].selectedIndex].text + '[/attachment]');
	document.forms[form_name].elements[text_name].focus();
}

function qp_show(qp_id)
{
	if (document.getElementById)
	{
		if (document.getElementById(qp_id).style.display == 'none')
		{
			document.getElementById(qp_id).style.display = 'block';
		}
	}
	else
	{
		if (document.layers)
		{
			if (document.qp_id.display == 'none')
			{
				document.qp_id.display = 'block';
			}
		}
		else
		{
			if (document.all.qp_id.style.visibility == 'none')
			{
				document.all.qp_id.style.display = 'block';
			}
		}
	}
}

function addquote(post_id, username)
{
	var message_name = 'message_' + post_id;
	var theSelection = '';

	// Get text selection - not only the post content :(
	if (window.getSelection)
	{
		theSelection = window.getSelection().toString();
	}
	else if (document.getSelection)
	{
		theSelection = document.getSelection();
	}
	else if (document.selection)
	{
		theSelection = document.selection.createRange().text;
	}
	
	if (theSelection)
	{
		qp_show('qp_box');
		insert_text('[quote="' + username + '"]' + theSelection + '[/quote]');
		return;
	}
}

function bbstyle(bbnumber)
{
	donotinsert = false;
	theSelection = false;
	bblast = 0;
	document.forms[form_name].elements[text_name].focus();

	// close all open tags & default button names
	if (bbnumber == -1)
	{
		while (bbcode[0])
		{
			butnumber = arraypop(bbcode) - 1;
			document.forms[form_name].elements[text_name].value += bbtags[butnumber + 1];
			buttext = eval('document.forms[form_name].addbbcode' + butnumber + '.value');
			if (buttext != "[*]")
			{
				eval('document.forms[form_name].addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
			}
		}

		document.forms[form_name].addbbcode10.value = "List";
		bbtags[10] = "[list]";

		document.forms[form_name].addbbcode12.value = "List=";
		bbtags[12] = "[list=]";

		// all tags are closed including image tags :D
		imageTag = false;

		document.forms[form_name].elements[text_name].focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection

		if (theSelection)
		{
			// add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			document.forms[form_name].elements[text_name].focus();
			theSelection = '';
			return;
		}
	}
	else if (document.forms[form_name].elements[text_name].selectionEnd && (document.forms[form_name].elements[text_name].selectionEnd - document.forms[form_name].elements[text_name].selectionStart > 0))
	{
		mozWrap(document.forms[form_name].elements[text_name], bbtags[bbnumber], bbtags[bbnumber+1]);
		document.forms[form_name].elements[text_name].focus();
		theSelection = '';
		return;
	}

	// find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++)
	{
		if (bbcode[i] == bbnumber+1)
		{
			bblast = i;
			donotinsert = true;
		}
	}

	if ((bbnumber == 10) && (bbtags[10] != "[*]"))
	{
		if (donotinsert)
		{
			document.forms[form_name].addbbcode12.value = "List=";
			tmp_help = o_help;
			o_help = e_help;
			e_help = tmp_help;
			bbtags[12] = "[list=]";
		}
		else
		{
			document.forms[form_name].addbbcode12.value = "[*]";
			tmp_help = o_help;
			o_help = e_help;
			e_help = tmp_help;
			bbtags[12] = "[*]";
		}
	}

	if ((bbnumber == 12) && (bbtags[12] != "[*]"))
	{
		if (donotinsert)
		{
			document.forms[form_name].addbbcode10.value = "List";
			tmp_help = l_help;
			l_help = e_help;
			e_help = tmp_help;
			bbtags[10] = "[list]";
		}
		else
		{
			document.forms[form_name].addbbcode10.value = "[*]";
			tmp_help = l_help;
			l_help = e_help;
			e_help = tmp_help;
			bbtags[10] = "[*]";
		}
	}

	// close all open tags up to the one just clicked & default button names
	if (donotinsert)
	{
		while (bbcode[bblast])
		{
			butnumber = arraypop(bbcode) - 1;

			if (bbtags[butnumber] != "[*]")
			{
				insert_text(bbtags[butnumber + 1]);
			}
			else
			{
				insert_text(bbtags[butnumber]);
			}

			buttext = eval('document.forms[form_name].addbbcode' + butnumber + '.value');

			if (bbtags[butnumber] != "[*]")
			{
				eval('document.forms[form_name].addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
			}

			imageTag = false;
		}

		document.forms[form_name].elements[text_name].focus();
		return;
	}
	else
	{
		// Close image tag before adding another
		if (imageTag && (bbnumber != 14))
		{
			insert_text(bbtags[15]);

			lastValue = arraypop(bbcode) - 1; // remove the close image tag from the list
			document.forms[form_name].addbbcode14.value = "Img"; // return button back to normal state
			imageTag = false;
		}

		// open tag
		insert_text(bbtags[bbnumber]);

		// check to stop additional tags after an unclosed image tag
		if ((bbnumber == 14) && (imageTag == false))
		{
			imageTag = 1;
		}

		if (bbtags[bbnumber] != "[*]")
		{
			arraypush(bbcode,bbnumber+1);
			eval('document.forms[form_name].addbbcode'+bbnumber+'.value += "*"');
		}

		document.forms[form_name].elements[text_name].focus();
		return;
	}

	storeCaret(document.forms[form_name].elements[text_name]);
}

// from http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var scrollTop = ( typeof(txtarea.scrollTop) == 'number' ? txtarea.scrollTop : -1 );

	if (txtarea.selectionEnd > txtarea.value.length)
	{
		txtarea.selectionEnd = txtarea.value.length;
	}

	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd + open.length;

	txtarea.value = txtarea.value.slice(0, selStart) + open + txtarea.value.slice(selStart); 
	txtarea.value = txtarea.value.slice(0, selEnd) + close + txtarea.value.slice(selEnd);

	txtarea.selectionStart = selStart + open.length;
	txtarea.selectionEnd = selEnd;
	txtarea.focus();

	if( scrollTop >= 0 )
	{
		txtarea.scrollTop = scrollTop;
	}
}

// insert at claret position. code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl)
{
	if (textEl.createTextRange)
	{
		textEl.caretPos = document.selection.createRange().duplicate();
	}
}

function colorPalette(dir, width, height)
{
	var r = 0, g = 0, b = 0;
	var numberList = new Array(6);

	numberList[0] = '00';
	numberList[1] = '40';
	numberList[2] = '80';
	numberList[3] = 'BF';
	numberList[4] = 'FF';

	document.writeln('<table cellspacing="1" cellpadding="0" border="0" style="background-color:#000000;">');

	for (r = 0; r < 5; r++)
	{
		if (dir == 'h')
		{
			document.writeln('<tr>');
		}

		for (g = 0; g < 5; g++)
		{
			if (dir == 'v')
			{
				document.writeln('<tr>');
			}

			for (b = 0; b < 5; b++)
			{
				color = String(numberList[r]) + String(numberList[g]) + String(numberList[b]);
				document.write('<td bgcolor="#' + color + '">');
				document.write('<a href="javascript:bbfontstyle(\'[color=#' + color + ']\', \'[/color]\');" onmouseover="helpline(\'s\');"><img src="./images/spacer.gif" width="' + width + '" height="' + height + '" border="0" alt="#' + color + '" title="#' + color + '" /></a>');
				document.writeln('</td>');
			}

			if (dir == 'v')
			{
				document.writeln('</tr>');
			}
		}

		if (dir == 'h')
		{
			document.writeln('</tr>');
		}
	}

	document.writeln('</table>');
}