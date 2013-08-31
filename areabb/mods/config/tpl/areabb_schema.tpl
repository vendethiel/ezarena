<script language="javascript" type="text/javascript">
<!--

function qp_switch(id) {
	/*
	if (id != 'nouveau'){
		document.getElementById('nouveau').style.display = 'none';
	}else{
		document.getElementById('nouveau').style.display = 'block';
	}
	*/
	if (document.getElementById) {
		if (document.getElementById(id).style.display == "none"){
			document.getElementById(id).style.display = 'block';
		} else {
			document.getElementById(id).style.display = 'none';
		}
	} else {
		if (document.layers) {
			if (document.id.display == "none"){
				document.id.display = 'block';
			} else {
				document.id.display = 'none';
			}
		} else {
			if (document.all.id.style.visibility == "none"){
				document.all.id.style.display = 'block';
			} else {
				document.all.id.style.display = 'none';
			}
		}
	}
}
//-->
</script>
<script language="javascript" type="text/javascript">
// Function getObj from : http://www.quirksmode.org
function getObj(name)
{
  if (document.getElementById)
  {
  	this.obj = document.getElementById(name);
	this.style = document.getElementById(name).style;
  }
  else if (document.all)
  {
	this.obj = document.all[name];
	this.style = document.all[name].style;
  }
  else if (document.layers)
  {
   	this.obj = document.layers[name];
   	this.style = document.layers[name];
  }
}

function sizeCtl(zone,val){
	var y = new getObj('squelette_'+zone);
	var hgt = parseInt(y.style.height.substr(0,y.style.height.length-2));
	hgt += val;
	if (hgt < 50) hgt=50;
	y.style.height = hgt + 'px';
}
</script>
<h1>{L_MODELE}</h1>

<p>{L_EXPLAIN}</p>
<center>{MESSAGE}</center>
<div id="nouveau" style="display:block;position:relative;">
<form action="" method="post">
<table width="80%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_AJOUT_MODELE}</th>
</tr>
<tr>
	<td class="row1">{L_DETAILS_EXPLAIN}</td>
	<td class="row2"><input type="text" name="details" size="60" value="" /></td>
</tr>
<tr>
	<td class="row1" width="150">{L_AJOUT_MODELE_EXPLAIN}</td>
	<td class="row2"><textarea id="squelette_nouveau" name="modele" style="height:100px; width:80%;"></textarea>
	<div align="right">
		<a href="javascript:sizeCtl('nouveau',100)"><img src="../../images/larger.gif" width="20" height="20" border="0"></a>
		<a href="javascript:sizeCtl('nouveau',-100)"><img src="../../images/smaller.gif" width="20" height="20" border="0"></a>
    </div></td>
</tr>
<tr>
	<td class="cat" height="28" align="center" valign="middle" colspan="2">
		<input type="submit" name="Ajouter" value="{AJOUTER}" />
		</td>
</tr>
</table>
<input type="hidden" name="action" value="ajouter_modele">
</form>
</div>

<!-- BEGIN liste_modeles -->
	<div id="edit{liste_modeles.ID_MODELE}" style="display:none;position:relative;">
	<form action="" method="post">
	<table width="80%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_EDITION_MODELE}</th>
	</tr>
	<tr>
		<td class="row1">{L_DETAILS_EXPLAIN}</td>
		<td class="row2"><input type="text" name="details" size="80" value="{liste_modeles.DETAILS}" /></td>
	</tr>
	<tr>
		<td class="row1" width="150">{L_AJOUT_MODELE_EXPLAIN}</td>
		<td class="row2"><textarea id="squelette_{liste_modeles.ID_MODELE}" name="modele" style="height:100px; width:80%;">{liste_modeles.MODELE}</textarea>
		<div align="right">
			<a href="javascript:sizeCtl({liste_modeles.ID_MODELE},100)"><img src="../../images/larger.gif" width="20" height="20" border="0"></a>
			<a href="javascript:sizeCtl({liste_modeles.ID_MODELE},-100)"><img src="../../images/smaller.gif" width="20" height="20" border="0"></a>
		</div></td>
	</tr>
	<tr>
		<td class="cat" height="28" align="center" valign="middle" colspan="2">
			<input type="submit" name="Modifier" value="{MODIFIER}" />
			<input type="hidden" name="action" value="modifier_modele">
			<input type="hidden" name="id_modele" value="{liste_modeles.ID_MODELE}">
			</form>
		</td>
	</tr>
	</table>
</div>
<!-- END liste_modeles -->

<table width="80%" cellpadding="6" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thTop" colspan="2" height="25" valign="middle" nowrap="nowrap">{L_LISTE}</th>
</tr>
<!-- BEGIN liste_modeles -->
<tr>
 <td class="row1">{liste_modeles.TITRE}</td>
 <td class="row2" width="100"><a href="javascript:qp_switch('edit{liste_modeles.ID_MODELE}');qp_switch('nouveau');"><img src="{I_EDIT}" border="0"></a>&nbsp;&nbsp;<a href="{liste_modeles.SUPPRIMER}"><img src="{I_SUPP}" border="0"></a></td>
</tr>
<!-- END liste_modeles -->
</table>
<br />