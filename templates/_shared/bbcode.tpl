<!-- BEGIN ulist_open --><ul><!-- END ulist_open -->
<!-- BEGIN ulist_close --></ul><!-- END ulist_close -->

<!-- BEGIN olist_open --><ol type="{LIST_TYPE}"><!-- END olist_open -->
<!-- BEGIN olist_close --></ol><!-- END olist_close -->

<!-- BEGIN listitem --><li><!-- END listitem -->

<!-- BEGIN quote_username_open --></span>
<div align="center">
	<div class="quotetitle"><nobr>&laquo; {USERNAME} &raquo; {L_WROTE}:</nobr></div>
	<div class="quotediv">
<!-- END quote_username_open -->
<!-- BEGIN quote_open --></span>
<div align="center">
	<div class="quotetitle">{L_QUOTE}:</div>
	<div class="quotediv">
<!-- END quote_open -->
<!-- BEGIN quote_close -->
	</div>
</div><span class="postbody"><!-- END quote_close -->

<!-- BEGIN code_open --></span>
<script type="text/javascript" src="templates/_shared/bbc_box/divexpand.js"></script> 
<div align="center">
	<script type="text/javascript">
	var codetext = '{L_CODE}';
	var expand = '{L_EXPAND}';
	var expand_more = '{L_EXPAND_MORE}';
	var contract = '{L_CONTRACT}';
	var select_all = '{L_SELECT_ALL}';
	codeDivStart()
	</script>
<!-- END code_open --> 
<!-- BEGIN code_close -->
	</div>
</div><span class="postbody"><!-- END code_close -->

<!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open -->
<!-- BEGIN b_close --></span><!-- END b_close -->

<!-- BEGIN u_open --><span style="text-decoration: underline"><!-- END u_open -->
<!-- BEGIN u_close --></span><!-- END u_close -->

<!-- BEGIN i_open --><span style="font-style: italic"><!-- END i_open -->
<!-- BEGIN i_close --></span><!-- END i_close -->

<!-- BEGIN color_open --><span style="color: {COLOR}"><!-- END color_open -->
<!-- BEGIN color_close --></span><!-- END color_close -->

<!-- BEGIN size_open --><span style="font-size: {SIZE}px; line-height: normal"><!-- END size_open -->
<!-- BEGIN size_close --></span><!-- END size_close -->

<!-- BEGIN img --><img resizemod="on" onload="rmw_img_loaded(this)" src="{URL}" border="0" alt="" title="" /><!-- END img -->

<!-- BEGIN url --><a href="{URL}" target="_blank" class="postlink">{DESCRIPTION}</a><!-- END url -->

<!-- BEGIN movie --><iframe src="{MOVIEURL}" height="310" width="340" frameborder="0" scrolling="no"></iframe> <!-- END movie -->

<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</a><!-- END email -->

<!-- BEGIN play -->
<embed TYPE='application/x-mplayer2' src="{URL}" width="600" height="400" autostart="yes" autoload="yes" bgcolor="#ECECEC" CONTROLS='yes'></embed>
<!-- END play -->

<!-- BEGIN dailymotion -->
<object width="425" height="350">
  <param name="movie" value="http://www.dailymotion.com/swf/{DAILYMOTIONID}"></param>
  <embed src="http://www.dailymotion.com/swf/{DAILYMOTIONID}" type="application/x-shockwave-flash" width="425" height="350"></embed>
</object><br />
<a href="http://dailymotion.com/swf/{DAILYMOTONID}" target="_blank">{DAILYMOTIONLINK}</a><br />
<!-- END dailymotion -->

<!-- BEGIN website -->
<div align=center>
<iframe name="cwindow" style="border:0" width=100% height=600 src="{URL}"></iframe>
</div>
<!-- END website -->

<!-- BEGIN GVideo -->
<object width="425" height="350">
        <param name="movie" value="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"></param>
<embed style="width:400px; height:326px;" id="VideoPlayback"
        align="middle" type="application/x-shockwave-flash"
        src="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"
        allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff"
        scale="noScale" salign="TL"  FlashVars="playerMode=embedded">
</embed>
</object><br />
<a href="http://video.google.com/googleplayer.swf?docId={GVIDEOID}" target="_blank">{GVIDEOLINK}</a><br />
<!-- END GVideo -->

<!-- BEGIN youtube -->
<iframe width="560" height="315" src="https://www.youtube.com/embed/{YOUTUBEID}" frameborder="0" allowfullscreen></iframe> 
<!-- END youtube -->

<!-- BEGIN titre1_open -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="titre1">&nbsp;<!-- END titre1_open -->
<!-- BEGIN titre1_close --></span><!-- END titre1_close -->

<!-- BEGIN titre2_open --><h4 class="titre2">&nbsp;&nbsp;<u><!-- END titre2_open -->
<!-- BEGIN titre2_close --></u></h4><!-- END titre2_close -->

<!-- BEGIN s_open --><span style="text-decoration: line-through"><!-- END s_open -->
<!-- BEGIN s_close --></span><!-- END s_close -->

<!-- BEGIN spoil_open --></span>
<div align="center">
<div class="spoiltitle"><b>{L_BBCBXR_SPOIL}:</b>&nbsp;
<input class="spoilbtn" type="button" value="{L_BBCBXR_SHOW}" onClick="javascript:if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = '{L_BBCBXR_HIDE}'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = '{L_BBCBXR_SHOW}'; }" onfocus="this.blur();">
</div>
<div class="spoildiv">
<div style="display: none;"><!-- END spoil_open -->
<!-- BEGIN spoil_close --></div>
</div>
</div>
<span class="postbody"><!-- END spoil_close -->

<!-- BEGIN fade_open -->
<span style="width:100%; -moz-opacity:0.3; opacity:0.3; -khtml-opacity:0.3; filter:alpha(opacity=30);" onmouseout="fade2(this,30);" onmouseover="fade2(this,100);">
<!-- END fade_open -->
<!-- BEGIN fade_close -->
</span>
<!-- END fade_close -->

<!-- BEGIN align_open --><div style="text-align:{ALIGN}"><!-- END align_open -->
<!-- BEGIN align_close --></div><!-- END align_close -->

<!-- BEGIN anchor_link --><a class="postlink" href="#{ANCHOR}">{DESCRIPTION}</a><!-- END anchor_link -->
<!-- BEGIN anchor_target --><a name="{ANCHOR}" id="{ANCHOR}">{DESCRIPTION}</a><!-- END anchor_target -->

<!-- BEGIN marq_open --><marquee direction="{MARQ}" scrolldelay="120"><!-- END marq_open -->
<!-- BEGIN marq_close --></marquee><!-- END marq_close -->

<!-- BEGIN flash -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="{WIDTH}" height="{HEIGHT}">
	<param name="allowScriptAccess" value="never" />
	<param name="movie" value="{URL}" />
	<param name="quality" value="high" />
	<param name="scale" value="noborder" />
	<param name="wmode" value="transparent" />
	<param name="bgcolor" value="#000000" />
	<embed type="application/x-shockwave-flash" src="{URL}" width="{WIDTH}" height="{HEIGHT}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" allowScriptAccess="never" quality="high" scale="noborder" wmode="transparent" bgcolor="#000000"></embed> 
</object><!-- END flash -->

<!-- BEGIN video -->
<object id="NSPlay" classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://www.microsoft.com/netshow/download/en/nsasfinf.cab#Version=2,0,0,912" viewastext="" width="{WIDTH}" height="{HEIGHT}">
	<param name="ControlType" value="1">
	<param name="filename" value="{URL}">
	<param name="AutoStart" value="0">
	<param name="ShowControls" value="1">
	<param name="ShowStatusBar" value="1">
	<param name="AnimationStart" value="1">
	<param name="TransparentAtStart" value="0">
	<embed type="video/x-ms-asf-plugin" src="{URL}" width="{WIDTH}" height="{HEIGHT}" filename="{URL}" pluginspage="http://www.microsoft.com/windows/mediaplayer/download/default.asp" showcontrols="1" controltype="1" autostart="0" transparentatstart="1" animationatstart="1" animationstart="1" showstatusbar="1" displaysize="4"></embed>
</object><!-- END video -->

<!-- BEGIN stream -->
<object id="wmp" classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject" width="300" height="70"> 
	<param name="FileName" value="{URL}"> 
	<param name="ShowControls" value="1"> 
	<param name="ShowDisplay" value="0"> 
	<param name="ShowStatusBar" value="1"> 
	<param name="AutoSize" value="1"> 
        <embed type="application/x-mplayer2" src="{URL}" width="300" height="70" pluginspage="http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp" name="MediaPlayer2" showcontrols="1" autostart="0" showdisplay="0" showstatusbar="1" autosize="1" visible="1" animationatstart="0" transparentatstart="1" loop="0"></embed>
</object><!-- END stream -->

<!-- BEGIN ram -->
	<embed src="{URL}" width="{WIDTH}" height="{HEIGHT}" nojava="1" controls="ImageWindow" console="one"></embed>
	<embed src="{URL}" width="{WIDTH}" height="36" nojava="1" controls="ControlPanel" console="one" autostart="0"></embed>
<!-- END ram -->

<!-- BEGIN quick -->
<object classid=clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" align="center" width="{WIDTH}" height="{HEIGHT}">
	<param name="controller" value="1">
	<param name="type" value="video/quicktime">
	<param name="autoplay" value="0">
	<param name="target" value="myself">
	<param name="src" value="{URL}">
	<param name="pluginspage" value="http://www.apple.com/quicktime/download/indext.html">
	<param name="kioskmode" value="true">
	<embed type="video/quicktime" src="{URL}" width="{WIDTH}" height="{HEIGHT}" pluginspage="http://www.apple.com/quicktime/download/indext.html" align="center" border="0" kioskmode="1" controller="1" target="myself"></embed>
</object><!-- END quick -->

<!-- BEGIN sup_open --><sup><!-- END sup_open -->
<!-- BEGIN sup_close --></sup><!-- END sup_close -->

<!-- BEGIN sub_open --><sub><!-- END sub_open -->
<!-- BEGIN sub_close --></sub><!-- END sub_close -->

<!-- BEGIN hr --><hr width="80%" size="1" /><!-- END hr -->

<!-- BEGIN bcolor_open --><span style="background-color: {COLOR}"><!-- END bcolor_open -->
<!-- BEGIN bcolor_close --></span><!-- END bcolor_close -->

<!-- BEGIN font_open --><span style="font-family:{FONT}"><!-- END font_open --> 
<!-- BEGIN font_close --></span><!-- END font_close -->

<!-- BEGIN show --></span>
<div align="center">
	<div class="hidetitle">{L_HIDE}:</div>
	<div class="hidediv">{HTEXTE}</div>
</div>
<span class="postbody"><!-- END show --> 

<!-- BEGIN hide --></span>
<div align="center">
	<div class="hidetitle">{L_HIDE}:</div>
	<div class="hidediv" style="text-align: center;">{L_HIDE_TEXT}</div>
</div>
<span class="postbody"><!-- END hide -->

<!-- BEGIN thumbnails --></span>
<table cellspacing="0" cellpadding="0" align="center" style="background-color:#000000; border:1px #000000 solid; color:#ffffff; font-size:11px;">
  <tr>
	<td align="center"><a href="{URL}" target="_new"><img src="{URL}" border="0" alt="{L_THUMBNAILS_ALT}" title="{L_THUMBNAILS_TITLE}" width="300" /></a><br />{L_THUMBNAILS_TITLE}</td>
  </tr>
</table>
<span class="postbody"><!-- END thumbnails -->
