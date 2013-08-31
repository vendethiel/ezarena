
<style type="text/css">
	#footer{
		height:30px;
		vertical-align:middle;
		text-align:right;
		clear:both;
		padding-right:3px;
		background-color:#317082;
		margin-top:2px;
	}
	#footer form{
		margin:0px;
		margin-top:2px;
	}
	#dhtmlgoodies_dragDropContainer{	/* Main container for this script */
		width:100%;
		height:100%;
		-moz-user-select:none;
	}
	#dhtmlgoodies_dragDropContainer ul{	/* General rules for all <ul> */
		align:center;
		margin-top:0px;
		margin-left:0px;
		margin-bottom:0px;
		padding:2px;
	}
	
	#dhtmlgoodies_dragDropContainer li,#dragContent li,li#indicateDestination{	/* Movable items, i.e. <LI> */
		list-style-type:none;
		font-size: 10px;
		height:60px;
		width:90px;
		border:1px solid #000;
		padding:2px;
		margin-bottom:2px;
		cursor:pointer;
		font-size:0.9em;
	}

	li#indicateDestination{	/* Box indicating where content will be dropped - i.e. the one you use if you don't use arrow */
		border:1px solid #317082;	
	}
	#titre_listing{
		position:absolute;
		top:120px;
		left:10px;
		width:150px;
		height:400px;
	}
	
	#listing {
		position:relative;
		height:400px;
		overflow:auto;
	}

  
	/* LEFT COLUMN CSS */
	div#dhtmlgoodies_listOfItems{	/* Left column "Available students" */
		float:left;
		padding:0px;
		/* CSS HACK */
		width: 130px;	/* IE 5.x */
		width/* */:/**/140px;	/* Other browsers */
		width: /**/140px;
				
	}
	#dhtmlgoodies_listOfItems ul{	/* Left(Sources) column <ul> */
	}
	
	div#dhtmlgoodies_listOfItems div{
		border:1px solid #999;		
	}
	div#dhtmlgoodies_listOfItems div ul{	/* Left column <ul> */
		margin-left:0px;	/* Space at the left of list - the arrow will be positioned there */
	}
	
	#dhtmlgoodies_listOfItems div p{	/* Heading above left column */
		margin:0px;	
		font-weight:bold;
		padding-left:2px;
		color:#FFF;
		margin-bottom:5px;
	}
	
	/* END LEFT COLUMN CSS */
	
	#dhtmlgoodies_dragDropContainer .mouseover{	/* Mouse over effect DIV box in right column */
		background-color:#E2EBED;
		border:1px solid #317082;
	}
	
	/* Start main container CSS */
	
	div#dhtmlgoodies_mainContainer{	/* Right column DIV */
		position:relative;
		width:500px;
		float:left;	
	}
	#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
		float:left;
		margin-right:5px;
		margin-bottom:5px;
		margin-top:0px;
		border:10px solid #999;
		height:80px;
		/* CSS HACK */
		width: 102px;	/* IE 5.x */
		width/* */:/**/102px;	/* Other browsers */
		width: /**/102px;
	}
	#dhtmlgoodies_mainContainer div ul{
		margin-left:1px;
		
	}
	
	#dhtmlgoodies_mainContainer div p{	/* Heading above small boxes */
		margin:0px;
		padding:0px;
		font-weight:bold;
		background-color:#317082;	
		margin-bottom:5px;
	}
	
	#dhtmlgoodies_mainContainer ul{	/* Small box in right column ,i.e <ul> */
		border:1px solid #999;
		position:relative;
		float:left;
		top:0px;
		height:70px;
		width:100px;
		margin-bottom:0px;
		overflow:hidden;		
	
	}
	
	#dragContent{	/* Drag container */
		position:absolute;
		display:none;
		margin:0px;
		padding:0px;
		z-index:2000;
	}

	#dragDropIndicator{	/* DIV for the small arrow */
		position:absolute;
		width:7px;
		height:10px;
		display:none;
		z-index:1000;
		margin:0px;
		padding:0px;
	}
	</style>
	<style type="text/css" media="print">
	div#dhtmlgoodies_listOfItems{
		display:none;
	}
	img{
		display:none;
	}
	#dhtmlgoodies_dragDropContainer{
		border:0px;
		width:100%;
		height:100%;
	}
	</style>	
<h1>{L_BLOCS}</h1>

<p>{L_EXPLAIN_BLOCS}</p>
<center>{MESSAGE}</center>
<div id="dragDropIndicator"><img src="../../images/insert.gif"></div>
<div id="dhtmlgoodies_dragDropContainer">
	<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" >
	<tr><td width="200">
		<div id="dhtmlgoodies_listOfItems">
				<table width="100%" height="100%" cellpadding="2" cellspacing="1" border="0" class="forumline" id="titre_listing" >
					<tr>
						<th class="thTop" height="26" nowrap="nowrap">{L_MODS_DISPOS}</th>
					</tr>
					<tr>
					<td class="row1" valign="top" align="center">
						<div id="listing">
							<ul id="allItems">{MODS_DISPOS}	</ul>
						</div>
					</td>
					</tr>
				</table>
		</div>	
	</td><td valign="top">
		
		<table cellpadding="2" cellspacing="1" border="0" class="forumline">
		<tr>
			<th class="thTop" width="100%" height="26" nowrap="nowrap">{L_MODS_CASES}</th>
		</tr>
			<td class="row1" valign="top" align="center">
			<div id="dhtmlgoodies_mainContainer">		
					{SQUELETTE}
			</div>			
			</td>
		</tr>
		<tr>
			<td class="row1" align="center" valign="middle"><div id="saveContent"></div>
		</tr>
		<tr>
			<td class="cat" height="28" align="center" valign="middle">
				<form action="" method="post"><input type="button" onclick="saveDragDropNodes({ID_SQUELETTE})" value="{L_ENREGISTRER}"></form>
			</td>
		</tr>
		</table>
		
	</td></tr></table>	
			
</div>
<ul id="dragContent"></ul>
<br /><br /><br /><br />
{BLOC_HIDER}
<script src="../../fonctions/js/move_blocs.js" type="text/javascript"></script>