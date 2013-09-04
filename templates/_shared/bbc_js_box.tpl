<style type="text/css">
<!--
.bbc_on {
	filter:alpha(opacity=30);
	-moz-opacity:0.3;
}
.bbc_off {
	background-image: url('{ROOT_STYLE}{BBC_BG_IMG}');
}
-->
</style>

<script language="javascript" type="text/javascript">
<!--

var bbc_url = "./";

function bbc_highlight(something, mode)
{
	something.style.backgroundImage = "url(" + ROOT_STYLE + bbc_url + (mode ? "{BBC_HOVERBG_IMG})" : "{BBC_BG_IMG})");
}

if (!window.form_name) {
	var form_name = 'post';
}
if (!window.text_name) {
	var text_name = 'message';
}
var stylePath = "{S_STYLE_PATH}";
var bbc_box_on = {S_BBC_BOX_ON};

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array(
	<!-- BEGIN bbc -->
	<!-- BEGIN def -->
	'{bbc.def.BEFORE}','{bbc.def.AFTER}'{bbc.def.SEP}
	<!-- END def -->
	<!-- BEGIN row -->
	<!-- BEGIN box -->
	,'{bbc.row.box.BEFORE}','{bbc.row.box.AFTER}'
	<!-- END box -->
	<!-- END row -->
	<!-- END bbc -->
	<!-- BEGIN bbc_else -->
	<!-- BEGIN def_else -->
	'{bbc_else.def_else.BEFORE}','{bbc_else.def_else.AFTER}'{bbc_else.def_else.SEP}
	<!-- END def_else -->
	<!-- END bbc_else -->
);
imageTag = false;

// Helpline messages
a_help = "{L_BBCODE_A_HELP}";
s_help = "{L_BBCODE_S_HELP}";
f_help = "{L_BBCODE_F_HELP}";
e_help = "{L_BBCBXR_E_HELP}";
t_help = "{L_BBCBXR_T_HELP}";
bs_help = "{L_BBCBXR_BS_HELP}";
swc_help = "{L_BBCBXR_SWC_HELP}";
hr_help = "{L_BBCBXR_HR_HELP}";
chr_help = "{L_BBCBXR_CHR_HELP}";
<!-- BEGIN bbc -->
<!-- BEGIN def -->
{bbc.def.HELPLINE}_help = "{bbc.def.LANG_HELP}";
<!-- END def -->
<!-- BEGIN row -->
<!-- BEGIN box -->
{bbc.row.box.HELPLINE}_help = "{bbc.row.box.LANG_HELP}";
<!-- END box -->
<!-- END row -->
<!-- END bbc -->
<!-- BEGIN bbc_else -->
b_help = "{L_BBCODE_B_HELP}";
i_help = "{L_BBCODE_I_HELP}";
u_help = "{L_BBCODE_U_HELP}";
q_help = "{L_BBCODE_Q_HELP}";
c_help = "{L_BBCODE_C_HELP}";
ulist_help = "{L_BBCODE_L_HELP}";
olist_help = "{L_BBCODE_O_HELP}";
p_help = "{L_BBCODE_P_HELP}";
w_help = "{L_BBCODE_W_HELP}";
<!-- END bbc_else -->

function checkForm()
{
	if (document.post.message.value.length < 2) {
		alert('{L_EMPTY_MESSAGE}');
		return false;
	} else {
//		document.post.post.disabled = true;
		return true;
	}
}

function colorSwitch(id1, id2) { 
	if (document.getElementById) { // DOM3 = IE5, NS6
		if (document.getElementById(id1).style.display == "none"){
			document.getElementById(id1).style.display = 'block';
			document.getElementById(id2).style.display = 'none';
		} else {
			document.getElementById(id1).style.display = 'none';
			document.getElementById(id2).style.display = 'block';
		}	
	} else { 
		if (document.layers) {	
			if (document.id1.display == "none"){
				document.id1.display = 'block';
				document.id2.display = 'none';
			} else {
				document.id1.display = 'none';
				document.id2.display = 'block';
			}
		} else {
			if (document.all.id1.style.visibility == "none"){
				document.all.id1.style.display = 'block';
				document.all.id2.style.display = 'none';
			} else {
				document.all.id1.style.display = 'none';
				document.all.id2.style.display = 'block';
			}
		}
	}
}

//-->
</script>
<script language="JavaScript" src="{ROOT_STYLE}templates/_shared/bbc_box/bbc_box.js" type="text/javascript"></script>