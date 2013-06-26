var studyId=0;
var populationId=0;
var csId=0;
var assayId=0;
var assayResultTypeId=0;
var journalTitlesLoaded=0;
var journalTitles=new Array();
var alphabet='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
var xmlhttp=false;
var divBR=0;
var destDivId="";
var divAC=document.getElementById("divAutoComplete");
var resultsTypeId=0;
var resultsForm=new Array();


//***********************************
//
// Create HTTP object for global use
//
//***********************************

try {
	xmlhttp=new ActiveXObject('Msxml2.XMLHTTP');
}
catch(e) {
	try {
	    xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
	}
	catch(E) {
		xmlhttp=false;
	}
}

if(!xmlhttp && typeof XMLHttpRequest!='undefined')
  xmlhttp=new XMLHttpRequest();


function getDataFromServer(url) {
	var response="";
	xmlhttp.open("GET",url,false);
	xmlhttp.send(null);
    response=xmlhttp.responseText;
	return response;
}



//************************************
//
// AutoComplete functions
//
//************************************

function setupAutoCompDiv(tbxObj)	{
	divAC=document.getElementById("divAutoComplete");

	var posX=(getXpos(tbxObj)+372);
	var posY=(getYpos(tbxObj)+20);
	divAC.style.left=posX+ 'px';
	divAC.style.top=posY+ 'px';
	divAC.style.visibility="visible";
		
}

function autoComplete(tbxObj,event)	{
	divAC=document.getElementById("divAutoComplete");
	setupAutoCompDiv(tbxObj);

	var newChar=event.which;
	var tbxValue=tbxObj.value;
	var tbxId=tbxObj.id;

	if(newChar==undefined)
		newChar=event.keyCode;

	if(newChar==8)	{
		if(tbxValue.length<=1)
         	tbxValue="";
		else
			tbxValue=tbxValue.substr(0,(tbxValue.length-1));
    } else
		tbxValue=tbxValue+String.fromCharCode(newChar);

	if(tbxValue.length>=2) {
		//divAC.innerHTML=getDataFromServer("/irbase/autoComplete.php?oid="+tbxId+"&q="+tbxValue);
		<?php $theBaseUrl2 = 'https://' . $_SERVER['HTTP_HOST'] . "/$irPath"; ?>
		divAC.innerHTML=getDataFromServer("<?print $theBaseUrl2; ?>/autoComplete.php?oid="+tbxId+"&q="+tbxValue);

	}
	else
		divAC.style.visibility="hidden";
}

function setValue(tbxId,id,value)	{
  divAC.style.visibility="hidden";
  obj=document.getElementById(tbxId);
  obj.value=value;
  tbxId="ac_"+tbxId;
  obj=document.getElementById(tbxId);
  obj.value=id;
}

function getXpos(obj)	{
	//var curLeft=0;
	var curLeft=23;
	//if(obj.offsetParent)
	//	while(obj.offsetParent)	{
	//		curLeft+=obj.offsetLeft
	//		obj=obj.offsetParent;
    	//}
   // else
    //	if(obj.x)
    //		curLeft+=obj.x;
  return curLeft;
}

function getYpos(obj)	{
	var curTop=0;
	if(obj.offsetParent)
		while(obj.offsetParent)	{
			curTop +=obj.offsetTop
			obj=obj.offsetParent;
    	}
  	else
  		if(obj.y)
    		curTop +=obj.y;
  return curTop;
}

//**********************************************
//
// Checks if passed string contains letters only
//
//**********************************************

function isAlpha(testString)	{
	if(testString=="")
		return false;
	for(i=0;i<parm.length;i++)
		if(alphabet.indexOf(testString.charAt(i),0)==-1)
			return false;
	return true;
}



function getchildren(objGroup,objId,objCount) {
	var termId=document.getElementById(objGroup+objId).value;
	var destObj=document.getElementById(objGroup+(objId+1));

	if(termId=="---------")	{
		for(t=objId+1;t<=objCount;t++)	{
			obj=document.getElementById(objGroup+t);
			obj.length=0;
			obj.options[0]=new Option("--------","---------");
			obj.disabled=1;
		}
		return;
	}
	<?php $theBaseUrl = 'https://' . $_SERVER['HTTP_HOST'] . "/$irPath"; ?>
	response=getDataFromServer("<?print $theBaseUrl; ?>/getChildren.php?id="+termId);
	listItems=response.split("\n");
	destObj.length=0;
	if(listItems.length>0)	{
		for(t=0;t<listItems.length;t++) {
			option=listItems[t].split (",");
			if(option[0]!="")
				destObj.options[t]=new Option(option[1],option[0]);
		}
		destObj.style.visibility='visible';
		destObj.disabled=0;
	}
	else {
		destObj.length=0;
		destObj.options[0]=new Option("---------","---------");
		destObj.disabled=1;
	}

	for(t=objId+2;t<=objCount;t++)	{
		obj=document.getElementById(objGroup+t);
		obj.length=1;
		obj.options[0]=new Option("--------","---------");
		obj.disabled=1;
	}
}

function setDivInnerHtml(url)	{
	var destDiv=document.getElementById(destDivId);
	destDiv.innerHTML="";
	destDiv.innerHTML=getDataFromServer(url)
   	if(destDivId!="divBR")	{
   		destDiv=document.getElementById("divBR");
   		destDiv.innerHTML="";
   	}
}

function getId(objId,objGrpCount)	{
	id="";
	for(t=1;t<=objGrpCount;t++)
		if(document.getElementById(objId+t).value.search(":")>=0)
			id=document.getElementById(objId+t).value;
	if(id!="")
		id=objId+"="+id+"&";
	return id;
}


function swapDivContent(div)	{
	if(document.getElementById("cbx"+div).checked)
		document.getElementById("div_"+div).innerHTML=document.getElementById("div_"+div).value;
    else
		document.getElementById("div_"+div).innerHTML="";
}



//*****************************
// If both the insecticide ddm and af are not blank and not equal show warning message and exit.
// Otherwise return the ddm or af value. If ddm is not set then returns af which maybe be blank.
//*****************************

function getInsecticideId()	{
	ddmInsecticideId=getId("i",6);
	afInsecticideId="i="+document.getElementById("ac_i").value+"&";
	if(ddmInsecticideId!="" && afInsecticideId!="i=&" && ddmInsecticideId!=afInsecticideId) {
		alert('The insecticide names in the drop down menu and the autofill box are different.');
		return -1;
	}
	if(ddmInsecticideId!="")
		return ddmInsecticideId;
	else
		return afInsecticideId;
}






//********************
//
// index.php - Search
//
//********************



function submitSearch()	{

	var dataInputError=0;
	var query="";

	if(document.getElementById("cbxs").checked)	{
		query=getId("s",7);
		ac_species=document.getElementById("s").value;
		ac_speciesId=document.getElementById("ac_s").value;
		if(query!="" && ac_species!="") {
			alert( "You may use either the drop down menus or the auto complete box.");
			return;
		}
		if(ac_species!="" && ac_speciesId=="") {
			alert( "Retype the species name and click on the value in the selection list.");
			return;
		}
		if(ac_speciesId!="")
			query=query+"s="+ac_speciesId+"&";
	}
	if(document.getElementById("cbxl").checked)
		query=query+getId("l",7);
	if(document.getElementById("cbxi").checked) {
		var insecticideId=getInsecticideId();

		if(insecticideId!=-1)
			query=query+getInsecticideId();
		else
			dataInputError=1;
	}
	if(document.getElementById("cbxrm").checked)
		query=query+getId("rm",6);
	if(document.getElementById("cbxa").checked)
		query=query+getId("a",6);
	if(document.getElementById("cbxmu").checked)
		query=query+getId("mu",5);
	if(document.getElementById("cbxcm").checked)
		query=query+getId("cm",5);
	if(document.getElementById("cbxy").checked)	{
		// Check if the value has changed from the default "----"
		if(document.getElementById("y").value.search("-")<0)
			query=query+"&y="+document.getElementById("y").value;
		if(document.getElementById("y_to").value.search("-")<0)
			query=query+"&y_to="+document.getElementById("y_to").value;
	}
	if(dataInputError==0 && query!="")	{
		query=query+"&sid="+sid;
		//this.window.location=" print 'https://' . $_SERVER['HTTP_HOST'] . "/$irPath/irSearch.php";?"+query;
		jQuery.ajax({

			url:'<?php print 'https://' . $_SERVER['HTTP_HOST'] . "/$irPath/irSearch.php";?>',
			type: "GET",
			data: query,
			success: function(response) {
				//console.log(response);
				jQuery(".irbase_results").html(response);
			}

		});
	}
}

/******************/
//
//	Study
//
/******************/

function setPubType()	{
	var isbn=document.getElementById("isbn");
	if(document.getElementById("dataSource").value=="2")
		isbn.disabled=0;
	else	{
		isbn.disabled=1;
		isbn.value="";
	}
}

function storeStudy(action)	{
	var ds=document.getElementById("dataSource").value;
	var medId=document.getElementById("medlineId").value;
	var name=document.getElementById("dsn").value;
	var ser=document.getElementById("series").value;
	var vol=document.getElementById("volume").value;
	var iss=document.getElementById("issue").value;
	var pages=document.getElementById("pages").value;
	var year=document.getElementById("year").value;
	var auth=document.getElementById("authors").value;
	var title=document.getElementById("title").value;
	var isbn=document.getElementById("isbn").value;
	var com=document.getElementById("comments").value;
	var comInt=document.getElementById("commentsInternal").value;

	query="ds="+ds+"&medId="+medId+"&name="+name+"&ser="+ser+"&vol="+vol+"&iss="+iss+"&pages="+pages;
	query=query+"&year="+year+"&auth="+auth+"&title="+title+"&isbn="+isbn+"&com="+com+"&comInt="+comInt;
	destDivId="divBR";
	if(action=="insert")
		setDivInnerHtml("addStudy.php?"+query);
	else {
		query=query+"&id="+document.getElementById("studyId").value;
		setDivInnerHtml("editStudy.php?"+query);
	}
}




//***************
//
// Specimen
//
//***************

function setEstablishedStrain()     {
	labstr=document.getElementById("ls");
	strid=document.getElementById("lsid");
	if (labstr.value == "yes")
		strid.disabled=0;
	else
		strid.disabled=1;
}

function setBankedCollection()	{
	bc=document.getElementById("bc");
	bcid=document.getElementById("bcid");
	if (bc.value == "yes")
		bcid.disabled=0;
	else
		bcidei.disabled=1;
}

function storePopulation(action)	{

	var errMsg=""
	var hid="";
	var simid=document.getElementById("simid").value;
	var n=document.getElementById("n").value;
	var sex=document.getElementById("sex").value;
	var fs=document.getElementById("fs").value;
	var lsid=document.getElementById("lsid").value;
	var bmid=document.getElementById("bcid").value;
	var com=document.getElementById("com").value;
	var comi=document.getElementById("comi").value;
	var cmid=getId("cm",5);
	var csid=document.getElementById("ac_cs").value;
	var s=getId("s",7);

	if(s=="" && document.getElementById("ac_s").value=="")
		errMsg="No species name entered.";
	else
		if(s=="")
			s="s="+document.getElementById("ac_s").value+"&";

	if(errMsg!="")	{
		alert(errMsg);
		return;
	}
	query="stid="+studyId+"&inv="+userName+"&"+s+"simid="+simid;
	query=query+"&l="+csid+"&hid="+hid+"&csd="+document.getElementById("csd").value;
	query=query+"&ced="+document.getElementById("ced").value+"&ct="+document.getElementById("ct").value;
	query=query+"&temp="+document.getElementById("temp").value+"&n="+n;
	query=query+"&sex="+sex+"&fs="+fs+"&lsid="+lsid+"&bmid="+bmid+"&com="+com+"&comi="+comi;
	destDivId="divBR";

	if(action=="insert")
		setDivInnerHtml("addPop.php?"+query);
	else {
		query=query+"&pid=0";
		setDivInnerHtml("editPop.php?"+query);
	}
}

function searchPopulation()	{
	var s=document.getElementById('qryStr').value;
	var f=document.getElementById('qryFld').value;

	if(f=="a" || f=="y")	{
		destDivId='divTR';
		setDivInnerHtml('viewPop.php?f='+f+'&s='+s);
	}
	else	{
		destDivId='divTR';
		setDivInnerHtml('viewPop.php?o='+f+'&s='+s);
	}
}


//************************
//
// Collection site
//
//************************


var hhForm='<table width="100%"><tr><td class="cell_key">Household Id:</td><td class="cell_value"><input type="text" size="10" id="hid"></td></tr>';
hhForm=hhForm+'<tr><td class="cell_key">Householder:</td><td class="cell_value"><input type="text" size="20" id="hh"></td></tr>';
hhForm=hhForm+'<tr><td class="cell_key">Structure type:</td><td class="cell_value"><input type="text" size="10" id="str"></td></tr>';
hhForm=hhForm+'<tr><td class="cell_key">Ownerhip:</td><td class="cell_value"><input type="text" size="10" id="owp"></td></tr>';
hhForm=hhForm+'<tr><td class="cell_key">No. of occupants:</td><td class="cell_value"><input type="text" size="2" id="ocn"></td></tr>';
//hhForm=hhForm+'<tr><td class="cell_key">IRS date:</td><td class="cell_value"><input type="text" size="2" maxlength="2" id="irsd">/<input type="text" size="2" maxlength="2" id="irsm">/<input type="text" size="4" maxlength="4" id="irsy"></td></tr>';
//hhForm=hhForm+'<tr><td class="cell_key">IRS insecticide:</td><input type="text" id="irsi" size="40" value="" onkeypress="autoComplete(this,this.id,this.value,event,'+"'insecticide','id,name','name')"+'">';
//hhForm=hhForm+'<input type="hidden" id="irsi_id" value=""><td class="cell_value"></td></tr>';
//hhForm=hhForm+'<tr><td class="cell_key">ITN date:</td><td class="cell_value"><input type="text" size="2" maxlength="2" id="itnd">/<input type="text" size="2" maxlength="2" id="itnm">/<input type="text" size="4" maxlength="4" id="itny"></td></tr>';
//hhForm=hhForm+'<tr><td class="cell_key">ITN insecticide:</td><td class="cell_value"><input type="text" size="10" id="itni" onkeypress="autoComplete(this,this.id,this.value,event,'+"'insecticide','id,name','name')"+'">';
//hhForm=hhForm+'<input type="hidden" id="itni_id" value="">';
//hhForm=hhForm+'</td></tr></table>';

var coordFormat="";

var latNmeaHtml='<b><input type="text" size="2" id="latDeg"><b>,</b><input type="text" size="2" maxlength="2" id="latMin"><b>.</b><input type="text" size="4" id="latMinTh"><select id="latHs"><option value="">&nbsp;</option><option value="N">N</option><option value="S">S</option></select></b>';
var latFloatHtml='<b><input type="text" size="2" id="latDeg"><b>.</b><input type="text" size="4" maxlength="4" id="latDegTh"><select id="latHs"><option value="">&nbsp;</option><option value="N">N</option><option value="S">S</option></select></b>';
var lonNmeaHtml='<b><input type="text" size="3" id="lonDeg"><b>,</b><input type="text" size="2" maxlength="2" id="lonMin"><b>.</b><input type="text" size="4" id="lonMinTh"><select id="lonHs"><option value="">&nbsp;</option><option value="E">E</option><option value="W">W</option></select></b>';
var lonFloatHtml='<b><input type="text" size="3" id="lonDeg"><b>.</b><input type="text" size="4" maxlength="4" id="lonDegTh"><select id="lonHs"><option value="">&nbsp;</option><option value="E">E</option><option value="W">W</option></select></b>';



function setupNewLocDiv()	{
	divNewLocation=document.getElementById("divNewLocation");
	divNewLocation.value=divNewLocation.innerHTML;
	divNewLocation.innerHTML="";
}

function setCoordFormat(format)	{
	var tbxAlias=document.getElementById("alias");
	var cbxNmea=document.getElementById("cbxNmea");
	var cbxFloat=document.getElementById("cbxFloat");
	var divLat=document.getElementById("divLat");
	var divLon=document.getElementById("divLon");

	if(format=="nmea")	{
		if(!cbxNmea.checked)	{
			divLat.innerHTML="";
			divLon.innerHTML="";
		}
		else	{
			cbxNmea.checked=1;
			cbxFloat.checked=0;
			divLat.innerHTML=latNmeaHtml;
			divLon.innerHTML=lonNmeaHtml;
		}
	}
	else	{
		if(!cbxFloat.checked)	{
			divLat.innerHTML="";
			divLon.innerHTML="";
		}
		else	{
			cbxNmea.checked=0;
			cbxFloat.checked=1;
			divLat.innerHTML=latFloatHtml;
			divLon.innerHTML=lonFloatHtml;
		}
	}
}

function defineNewLocation() {
	var cbxNewLocation=document.getElementById("cbxNewLocation");
	var divNewLocation=document.getElementById("divNewLocation");

	if(cbxNewLocation.checked)
		divNewLocation.innerHTML=divNewLocation.value;
	else
		divNewLocation.innerHTML="";
}

function addColSite() {
	var query="username="+userName;
	var ontLoc=getId("l",7);
	var cbxNewLocation=document.getElementById("cbxNewLocation");
	var tbxAlias=document.getElementById("alias");
	var cbxNmea=document.getElementById("cbxNmea");
	var cbxFloat=document.getElementById("cbxFloat");
	var divLat=document.getElementById("divLat");
	var divLon=document.getElementById("divLon");

	if(ontLoc=="" && !cbxNewLocation.checked)	{
		alert("The location of the collection site needs to be defined using either the ontology based drop down menus or by adding a new location.");
		return;
	}

	if(ontLoc=="" && cbxNewLocation.checked)
		if(document.getElementById("country").value=="")	{
			alert("You need to fill at least a country name.");
			return;
		}

	if(ontLoc!="" && cbxNewLocation.checked)	{
			alert("Use either the ontology based drop down menus or add a new site using the text boxes.");
			return;
	}

	if(cbxFloat.checked)
		if(document.getElementById("latDeg").value=="" ||
				document.getElementById("latDegTh").value=="" ||
				document.getElementById("latHs").value=="" ||
				document.getElementById("lonDeg").value=="" ||
				document.getElementById("lonDegTh").value=="" ||
				document.getElementById("lonHs").value=="" ) {
			alert("Site coordinates missing.");
			return;
		}


	if(cbxNmea.checked)
		if(document.getElementById("latDeg").value=="" ||
				document.getElementById("latMin").value=="" ||
				document.getElementById("latMinTh").value=="" ||
				document.getElementById("latHs").value=="" ||
				document.getElementById("lonDeg").value=="" ||
				document.getElementById("lonMin").value=="" ||
				document.getElementById("lonMinTh").value=="" ||
				document.getElementById("lonHs").value=="" ) {
			alert("Site coordinates missing.");
			return;
		}

	if(tbxAlias.value!="")
		query=query+"&alias="+tbxAlias.value;

	if(ontLoc=="" && cbxNewLocation.checked)	{
		query=query+"&site=new&c="+document.getElementById("country").value+"&p="+document.getElementById("province").value;
		query=query+"&d="+document.getElementById("district").value+"&ltn="+document.getElementById("location").value+"&lly="+document.getElementById("locality").value;
	}
	else
		query=query+"&site=ont&"+ontLoc;

	if(cbxFloat.checked)	{
		lat=document.getElementById("latDeg").value+"."+document.getElementById("latDegTh").value;
		if(document.getElementById("latHs").value=="S")
			lat=lat*(-1);
		lon=document.getElementById("lonDeg").value+"."+document.getElementById("lonDegTh").value;
		if(document.getElementById("lonHs").value=="W")
			lon=lon*(-1);
		query=query+"&lat="+lat+"&lon="+lon;
	}
	if(cbxNmea.checked)	{
		tmpStr=+document.getElementById("latMin").value+"."+document.getElementById("latMinTh").value;
		lat=tmpStr/60+document.getElementById("latDeg").value/1;
		if(document.getElementById("latHs").value=="S")
			lat=lat*(-1);
		tmpStr=+document.getElementById("lonMin").value+"."+document.getElementById("lonMinTh").value;
		lon=tmpStr/60+document.getElementById("lonDeg").value/1;
		if(document.getElementById("lonHs").value=="W")
			lon=lon*(-1);
		query=query+"&lat="+lat+"&lon="+lon;
	}
/*	if(document.getElementById('hyes').checked);	{
		if(document.getElementById('hid').value=="")	{
			alert("A household ID must be set.");
			return;
		}
		query=query+"&hid="+document.getElementById('hid').value+"&hh="+document.getElementById('hh').value+"&str="+document.getElementById('str').value;
		query=query+"&owp="+document.getElementById('owp').value+"&ocn="+document.getElementById('ocn').value;
		query=query+"&irsd="+document.getElementById('irsy').value+document.getElementById('irsm').value+document.getElementById('irsd').value;
		query=query+"&irsi="+document.getElementById('irsi_id').value;
		query=query+"&itnd="+document.getElementById('itny').value+document.getElementById('itnm').value;
		query=query+document.getElementById('itnd').value+"&itni="+document.getElementById('itni_id').value;
	}
*/
	destDivId="divBR";
	setDivInnerHtml("addColSite.php?"+query);
}

function searchColSite()	{
	var qs=document.getElementById('qs').value;
	var t=document.getElementById('st1').checked;
	if(t)
		t="e";
	else
		t="s";
	if(qs!="")	{
		destDivId="divTR";
		setDivInnerHtml('viewColSite.php?t=l'+t+'&q='+qs);
	}
}

function printHouseholdAddForm(csid)	{
	csId=csid;
	destDivId="divTR";
	setDivInnerHtml("addHousehold.php");
}

function addHousehold()	{
	var qs="csid="+csId+"&hid="+document.getElementById('hid').value+"&hh="+document.getElementById('hh').value;
	qs=qs+"&str="+document.getElementById('str').value+"&owp="+document.getElementById('owp').value;
	qs=qs+"&ocn="+document.getElementById('ocn').value;
	destDivId="divTR";
	setDivInnerHtml("addHousehold.php?"+qs);

}

//
// Assay
//

function searchAssay()	{
	var str=document.getElementById('qryStr').value;
	var fld=document.getElementById('qryFld').value;
	if(str!='' && fld!='') {
		destDivId='divTR';
		setDivInnerHtml('viewAssay.php?f='+fld+'&s='+str);
	}
}

function showResultsForm()	{
	var assayMethod=getId("a",6);
	var destDiv=document.getElementById("divResults");
	resultsTypeId=getDataFromServer("getResultsType.php?id="+assayMethod);
	destDiv.innerHTML="";
	destDiv.innerHTML=resultsForm[resultsTypeId];
}

function addAssay()	{
	query="pid="+populationId+"&"+getId("a",6)+getId("mu",5)+getId("i",6)+"ic="+document.getElementById("ic").value;
	query=query+"&n="+document.getElementById("sample_size").value+"&"+getId("rm",6)+"genef="+document.getElementById("genef").value;
	query=query+"&com="+document.getElementById("com").value+"&comi="+document.getElementById("comp").value;
	query=query+"&age="+document.getElementById("age").value;
	switch(resultsTypeId)	{
		case "1":
			query=query+"&result=Mortality percentage:"+document.getElementById("pm").value;
			break;
		case "2":
			query=query+"&result=LC50:"+document.getElementById("lc50").value+";LC90:"+document.getElementById("lc90").value+";LC95:"+document.getElementById("lc95").value+";LC99:"+document.getElementById("lc99").value;
			query=query+";LD50:"+document.getElementById("ld50").value+";LD90:"+document.getElementById("ld90").value+";LD95:"+document.getElementById("ld95").value+";LD99:"+document.getElementById("ld99").value;
			break;
		case "3":
			query=query+"&result=KDT50:"+document.getElementById("kdt50").value+";KDT90:"+document.getElementById("kdt90").value+";KDT95:"+document.getElementById("kdt95").value+";KDT99:"+document.getElementById("kdt99").value;
			query=query+";LT50:"+document.getElementById("lt50").value+";LT90:"+document.getElementById("lt90").value+";LT95:"+document.getElementById("lt95").value+";LT99:"+document.getElementById("lt99").value;
			break;
		case "4":
			query=query+"&result=Mortality percentage:"+document.getElementById("pm").value;
			break;
		default:
			alert('No assay method has been specified or the selected method is not implemented yet.');
			return;
	}
	destDivId="divBR";
	setDivInnerHtml("addAssay.php?"+query);
}


