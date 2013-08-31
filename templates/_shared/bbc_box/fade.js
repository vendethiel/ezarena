//Checking du navigateur
var uAgent=navigator.userAgent;
var ns4 = (document.layers)? true:false;   //NS 4 
var ie4 = (document.all)? true:false;   //IE 4 
var dom = (document.getElementById)? true:false;   //DOM 
var ope = uAgent.indexOf("Opera")>-1 && dom? true:false; // + OP5
var ie5 = (dom && ie4 && !ope)?true:false; // IE5
var ns6 = (dom && uAgent.indexOf("Netscape")>-1)? true:false; // + NS 6
var khtml = uAgent.indexOf("khtml")>-1? true:false; // + Konqueror
//alert("UserAgent: "+uAgent+"\nns4 :"+ns4+"\nie4 :"+ie4+"\ndom :"+dom+"\nie5 :"+ie5+"\nns6 :"+ns6+"\nope :"+ope+"\nkhtml :"+khtml);

//gestion des objets selon les navigateurs
function ob(id) {
if (dom) obj = document.getElementById(id);
else if (ie4) obj = document.all[id];
else if (ns4) obj = document.anchors[id];
else obj=false;
return obj;
}

// Fade
Array.prototype.inArray=function(str){//on modifie l'objet Array
for(i=0; i< this.length; i++)if(this[i].toString()==str)return i;
return -1;
}
//On modifie l'objet String
String.prototype.exist=function(){return (this=="undefined"?false:true);};
//Opacité
function setOpacity(id,alpha,isObj) {
	if(!dom)return;
	var object = isObj?id:ob(id); 
	if(String(typeof object.filters).exist())object.filters.alpha.opacity = alpha;
	else if(String(typeof object.style.opacity).exist()) object.style.opacity = (alpha/100);
	else if(String(typeof object.style.KhtmlOpacity).exist()) object.style.KhtmlOpacity = (alpha/100);
	else if(String(typeof object.style.MozOpacity).exist()) object.style.MozOpacity = (alpha/100);
}
function getOpacity(id,isObj){
	if(!dom)return;
	var object = isObj?id:ob(id), alpha=null; 
	if(String(typeof object.filters).exist()) alpha = object.filters.alpha.opacity;
	else if(String(typeof object.style.opacity).exist()) alpha = object.style.opacity*100;//css3 propertie
	else if(String(typeof object.style.KhtmlOpacity).exist()) alpha = object.style.KhtmlOpacity*100;
	else if(String(typeof object.style.MozOpacity).exist()) alpha = object.style.MozOpacity*100;
	return alpha;
}
// Fading
vit=5; //temps entre chaque addition d'opacité(+ petit -> + de qualité -> + dur pour le navigateur) 
add=4; //valeur à additionner (idem)
nObj=0;

fadeObjects=new Object();
fadeTimers=new Object();
fadeIds=new Array();
function fade2(object, destOp){
if (!dom) return;
if (object.toString().indexOf("[object")==-1){setTimeout("fade2("+object+","+destOp+")",0); return;}
alpha=getOpacity(object,true);
index=fadeIds.inArray(object.id);
if(index>-1)clearTimeout(fadeTimers[index]);
else {
index=nObj++;
fadeIds[index]=object.id;
}
diff = destOp-alpha;
direction=1;
if (alpha > destOp)direction=-1;//de - en - opaque
alpha+=direction * Math.min(direction*diff,add);//ajoute le + petit entre la diférence et add 
setOpacity(object,alpha,true);
alpha=getOpacity(object,true);
object.offsetLeft;
if (Math.round(alpha) != destOp){
fadeObjects[index]=object;
fadeTimers[index]=setTimeout("fade2(fadeObjects["+index+"],"+destOp+")",vit);
}
return;
}
