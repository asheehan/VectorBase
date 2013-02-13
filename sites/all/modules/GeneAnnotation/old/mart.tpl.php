<?php

?>

<html>
<head>
  <title>BioMart@VectorBase - MartView</title>

  <link rel="stylesheet" type="text/css" href="/biomart/mview/martview.css" />
  <link rel="stylesheet" type="text/css" href="/biomart/mview/vectorbase.css" />
  <link rel="stylesheet" type="text/css" href="http://www.vectorbase.org/includes/index_style.css?organism_id=all"/>

<script src="/biomart/mview/js/martview.js"  type="text/javascript" ></script>

</head>

<body style="margin: 0px;" onload="setVisibleStatus()">


<div id="mart_header" style=" width:100%; height:100%;"><script type="text/javascript" src="http://www.vectorbase.org/includes/js_cookie_functions.js"></script>
<script language="Javascript" type="text/javascript">

  var prefs = null;
  function Prefs() { }
  function Pref(key, value, persist) {
    this.key = key;
    this.value = value;
    this.persist = persist;
  }
  Prefs.prototype.toString = function prefsToString() {
    var str = "Prefs:\n";
    for (var key in this) {
      if (key == "toString") { continue; }
      str += "  " + key + " => " + this[key] + "\n";
    }
    return str;
  }
  Pref.prototype.toString = function prefToString() {
    var str = "[" + this.key + "=" + this.value + " (";
    if (this.persist) { str += "cookie"; } else { str += "session"; }
    str += ")]";
    return str;
  }
  function initPrefs() {
    prefs = new Prefs();
    
    prefs.putative_logged_in = new Pref('putative_logged_in', false, false);
    prefs.putative_domain = new Pref('putative_domain', '', false);
  }
  function setPref(pref, value, persist) {
    var pref = new Pref(pref, value, persist);
    if (pref.persist) {
      // Cookie
      var date = new Date();
      var days = 365;
      date.setTime(date.getTime() + (days * 24*3600*1000));
      var expires = "; expires=" + date.toGMTString();
      document.cookie = 'prefs[javascript][' + pref.key + ']=' + pref.value + expires + "; path=/";
    }
    var url = "/includes/setPref.php?key=" + pref.key + "&value=" + pref.value;
    var req = false;
    if (window.XMLHttpRequest) {
      try { req = new XMLHttpRequest(); } catch(e) { req = false; }
    } else  if (window.ActiveXObject) {
      try { req = new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) { try { req = new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) { req = false; } }
    }
    if (req) {
      // Note: no onreadystatechange handler; we're just firing this off and hoping it sticks
      req.open("GET", url, true);
      req.send("");
    }
    // Set the local preferences for this open page
    prefs[pref.key] = pref;
  }
</script>

  <script type="text/javascript" src="http://www.vectorbase.org/includes/browser_detect.js"></script>
  <script type="text/javascript" src="http://www.vectorbase.org/includes/behaviour.js"></script> 
  <script type="text/javascript" src="http://www.vectorbase.org/includes/vb_behaviours.js"></script>
  <script type="text/javascript" src="http://www.vectorbase.org/includes/help_floater.js"></script> 
  <script type="text/javascript" src="http://www.vectorbase.org/includes/helper_functions.js"></script> 
  <script type="text/javascript" src="http://www.vectorbase.org/includes/get_manual_model.js"></script>
  <script type="text/javascript" src="http://www.vectorbase.org/includes/soapclient.js"></script>
  <script type="text/javascript" src="http://www.vectorbase.org/includes/browser_detect.js"></script>
  <script type="text/javascript" language="javascript">
    function crossBrowserListen(obj, event, fcn) {
      if (obj.addEventListener) {
        obj.addEventListener(event, fcn, false);
        return true;
      } else if (obj.attachEvent) {
        var r = obj.attachEvent("on"+event, fcn);
        return r;
      } else {
        return false;
      }
    }
    function functionsAfterLoad() {
      if (window.doBodyOnLoad) { doBodyOnLoad(); }
      if (window.initScripts) { initScripts(); }
      if (window.blastInitScripts) { blastInitScripts(); }
      /*
      var email = document.getElementById('Web:email_help');
      if (email) {
        email.href = email.href.replace(/ aht /, '@');
        email.href = email.href.replace(/ dawt /, '.');
      }
      */
      for (var i = 0; i < document.getElementsByName('Web:email_help').length; i++) {
        var email = document.getElementsByName('Web:email_help')[i];
        if (email) {
          email.href = email.href.replace(/( |%20)aht( |%20)/, '@');
          email.href = email.href.replace(/( |%20)dawt( |%20)/, '.');
          email.innerHTML = email.innerHTML.replace(/ aht /, '@');
          email.innerHTML = email.innerHTML.replace(/ dawt /, '.');
        }
      }
    }
    function functionsAtUnload() {
      if (window.doBodyOnUnload) { doBodyOnUnload(); }
    }
    crossBrowserListen(window, 'load', functionsAfterLoad);
    crossBrowserListen(window, 'unload', functionsAtUnload);
    crossBrowserListen(window, 'mousedown', newHelpOff);
    
    
  </script>

<body onload="setVisibleStatus();" id="ensembl-webpage">
        <table id="main_table" cellspacing="0" cellpadding="0" class="main_table_normal" align="center">
      <!-- Top Spacer -->
      <tr>
        <td>
          <br/>
        </td>
        <td>
        	<img src="http://www.vectorbase.org/imgs/blank.gif" alt="blank"/>
        </td>
      </tr>
      <!-- Top Bar -->
      <tr>
      	<td>
      	  <img src="http://www.vectorbase.org/imgs/blank.gif" alt="blank"/>
      	</td>
        <td>  
          <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="bottom">
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="site_title">
                      <a href="http://www.vectorbase.org" class="site_title" style="text-decoration:none;color:#003300;">VectorBase</a>                    </td>
                  </tr>
                  <tr>
                    <td height="1" bgcolor="#cbcbcb">
 
                    </td>
                  </tr>
                </table>
              </td>
              <td valign="bottom" align="right" style="width:250px">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  	<td align="right" valign="bottom"><a class="hashelp" name="Web:homepage" href="http://www.vectorbase.org">
<img border="0" alt="All organisms" src="http://www.vectorbase.org/imgs/all_on.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:agambiae_homepage" href="http://agambiae.vectorbase.org"">
<img border="0" alt="A. gambiae" src="http://www.vectorbase.org/imgs/agambiae_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:aaegypti_homepage" href="http://aaegypti.vectorbase.org"">
<img border="0" alt="A. aegypti" src="http://www.vectorbase.org/imgs/aaegypti_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:iscapularis_homepage" href="http://iscapularis.vectorbase.org"">
<img border="0" alt="I. scapularis" src="http://www.vectorbase.org/imgs/iscapularis_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:cpipiens_homepage" href="http://cpipiens.vectorbase.org"">
<img border="0" alt="C. pipiens" src="http://www.vectorbase.org/imgs/cpipiens_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:phumanus_homepage" href="http://phumanus.vectorbase.org"">
<img border="0" alt="P. humanus" src="http://www.vectorbase.org/imgs/phumanus_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:rprolixus_homepage" href="http://rprolixus.vectorbase.org"">
<img border="0" alt="R. prolixus" src="http://www.vectorbase.org/imgs/rprolixus_off.gif"/></a></td>
<td align="right" valign="bottom"><a class="hashelp" name="Web:gmorsitans_homepage" href="http://gmorsitans.vectorbase.org"">
<img border="0" alt="G. morsitans" src="http://www.vectorbase.org/imgs/gmorsitans_off.gif"/></a></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <!-- Help Bar -->
      <tr>
        <td>
			<img src="http://www.vectorbase.org/imgs/blank.gif" alt="blank"/>
        </td>
        <td bgcolor="#005500" >
          <table border="0" cellspacing="0" width="100%" cellpadding="0">
            <tr>
              <td width="10" class="status_bar">
                &nbsp;<b style="color:#ffffff;">&nbsp;</b>
              </td>
              <td id="help_cell" class="status_bar">
                
              </td>
              <td align="right" class="status_bar">
                <a class="contact hashelp" id="Web:Get_Help" href="http://www.vectorbase.org/Help/Web:Get_Help"><b style="color:#ffffff;">Get VectorBase Help</b></a>&nbsp;&nbsp;
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
      	<td>
      	</td>
        <td class="horz_seperator">
        </td>
      </tr>
      <!--Data Sections Items-->
      <tr>
        <td>
			<!-- Outside left table-->        
        </td>
        <td>
          <table border="0" cellspacing="0" width="100%" cellpadding="0">
            
            <tr>
              <td class="vert_seperator"><img src="http://www.vectorbase.org/imgs/blank.gif" alt="."/></td>
              <td id="Web:sequence_data" align="center" class="menu_bar hashelp" style="background-color: ;">
                <a class="menu_link" href="http://www.vectorbase.org/SequenceData/">
                  Sequence Data
                </a>
              </td>
              <td id="Web:expression_data" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/ExpressionData/">
                  Expression Data
                </a>
              </td>
              <td id="Web:images" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/Images/">
                  Images
                </a>
              </td>
              <td id="Web:population_data" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/PopulationData/">
                  Population Data
                </a>
              </td>
              <td id="Web:population_data" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/IRbase/">
                  IRbase
                </a>
              </td>
              <td id="Web:documentation" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/Docs/">
                  Documents
                </a>
              </td>
              <td id="Web:all_more" align="center" class="menu_bar hashelp">
                <a class="menu_link" href="http://www.vectorbase.org/Other/">
                  More...
                </a>
              </td>
              <td class="vert_seperator"><img src="http://www.vectorbase.org/imgs/blank.gif" alt="."/></td>
              <td id="Web:tools" align="center" class="common_menu_bar hashelp">
                <a class="common_menu_link" href="http://www.vectorbase.org/Tools/">
                  Tools
                </a>
              </td>
              <td id="Web:get_data" align="center" class="common_menu_bar hashelp">
                <a class="common_menu_link" href="http://www.vectorbase.org/GetData/">
                  Get Data
                </a>
              </td>
              <td id="Web:forum" align="center" class="common_menu_bar hashelp">
                <a class="common_menu_link" href="http://www.vectorbase.org/sections/Forum/">
                  Forum
                </a>
              </td>
              <td id="Web:search" align="center" class="common_menu_bar hashelp">
                <a class="common_menu_link" href="http://www.vectorbase.org/Search">
                  Search
                </a>
              </td>
              <td class="vert_seperator"><img src="http://www.vectorbase.org/imgs/blank.gif" alt="."/></td>
              <td id="Web:user" align="center" class="common_menu_bar hashelp">
                <a class="common_menu_link" href="http://www.vectorbase.org/User/">
                  User
                </a>
              </td>
              <td class="vert_seperator"><img src="http://www.vectorbase.org/imgs/blank.gif" alt="."/></td>
            </tr>
            
          </table>
        </td>
      </tr>
      <tr>
      	 <td>	 
      	 </td>
         <td class="horz_seperator">
         </td>
      </tr>
      <!-- Content Window -->
      <tr>
      	<td valign="top" align="right"> </td>
        <td class="content_window">
</div>
<!-- </table> -->

<div id="mart_containerpanel" style="width:860px; height:600px;">
  <form name="mainform" action="/biomart/martview/b2f147d05876f1c75a37fafee1d78f82" method="post" enctype="multipart/form-data">
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">


  
  

	<tr>	
	<td width="100%" height="30px" align="left">
	<div style=" width:100%; height:100%; overflow:hidden; position: relative;">

	<table class ="mart_main_menubar" width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td height="100%"  align="left" valign="top" >
					     
			<!--
			<img src="/martview/images/biomart-logo.gif" alt="" style="float: right; margin: 6px 4px 0px 0px"/></a> 				 
			-->
	
		
			<!--input type="submit" value="New" style="margin: 0px 0px 0px 6px" name="submit.newsession"--> 
			<a id="new_button_tag"
				style="margin-left:6px; 
        		"
				class="mart_btn_new"
	   			onmouseover="this.className='mart_btn_new mart_btnhov'" 
	   			onmouseout="this.className='mart_btn_new'"
				onclick="
				var currentPath = window.location.pathname; 
				currentPath = currentPath.replace('/b2f147d05876f1c75a37fafee1d78f82', '');							window.location = currentPath; 
	
	  			return false; 

	  			" 
	  			title="Start a new query">New
	  		</a>
	
	
			<!--input type="button" value="Count" name="get_count_button" -->
			<a id="count_button_tag"
				style="margin-left:4px;
				"
				class="mart_btn_count"
				onmouseover="this.className='mart_btn_count mart_btnhov'" 
				onmouseout="this.className='mart_btn_count'"

				onclick="
				if (datasetExists() > 0) {
					document.getElementById('summarypanel_filter_count_1').innerHTML = 'Loading... ';
					addLoadingImage('summarypanel_filter_count_1', 'biomart');
					
					if (document.getElementById('summarypanel_filter_count_2') != null)	{
						document.getElementById('summarypanel_filter_count_2').innerHTML = 'Loading... ';
						addLoadingImage('summarypanel_filter_count_2', 'biomart');
					}
					document.mainform.formatterMenu.value = 'preView';
					document.mainform.do_export.value = 0; 
					document.mainform.track_visible_section.value = document.mainform['mart_mainpanel__current_visible_section'].value;
					document.mainform.savequery.value = 0; 
					document.mainform.showquery.value = 0; 
					document.mainform.countButton.value = 5;
			
					document.mainform.target = 'count_hiddenIFrame';
					document.mainform.submit();
	
					document.mainform.countButton.value = 1;
				
					return false;
				}

				" title="Get result count for the query with any filters applied">Count
			</a>

	
			<!--input type="button" value="Results" name="get_results_button" -->
			<a id="results_button_tag"
				style="margin-left:4px;
				"
				class="mart_btn_results"
				onmouseover="this.className='mart_btn_results mart_btnhov';" 
				onmouseout="this.className='mart_btn_results';"
			
				onclick="
				if (datasetExists() > 0) {
					document.getElementById('resultsTableId').innerHTML = 'Loading... ';
					addLoadingImage('resultsTableId', 'biomart');
					document.mainform.formatterMenu.value = 'preView';
					document.mainform.do_export.value = 0; 
					document.mainform.savequery.value = 0;
					document.mainform.showquery.value = 0;  
		
					var summaryCountElt1 = document.getElementById('summarypanel_filter_count_1');
					if (summaryCountElt1)	{				
						document.mainform.summarypanel_filter_count_1_hidden.value = summaryCountElt1.innerHTML;
					}
					var summaryCountElt2 = document.getElementById('summarypanel_filter_count_2');
					if (summaryCountElt2)	{
						document.mainform.summarypanel_filter_count_2_hidden.value = summaryCountElt2.innerHTML;
					}
			
					showPanelHideSiblings('resultspanel');			
					setHighlightedSummaryPanelBranch('show_results');			
	
					document.mainform.track_visible_section.value = document.mainform['mart_mainpanel__current_visible_section'].value;
	
					document.mainform['mart_mainpanel__current_visible_section'].value = 'resultspanel'; 
					document.mainform['summarypanel__current_highlighted_branch'].value = 'show_results'; 

					document.mainform.resultsButton.value = 5;
		
					document.mainform.target = 'results_hiddenIFrame';
					document.mainform.submit();
			
					document.mainform.resultsButton.value = 1;			
				
					return false;
				}
				" title="Preview the results of the query">Results
			</a>
	
		</td>
		<td height="100%" align="right" valign="top" >

			<a id="url_button_tag"
				style="margin-right:4px;
				"
				class="mart_btn_url"
   			onmouseover="this.className='mart_btn_url mart_btnhov'" 
   			onmouseout="this.className='mart_btn_url'"
          	onclick="
				if (datasetExists() > 0) {          	
	          	document.mainform.showquery.value = 3; 
   	       	document.mainform.do_export.value = 0; 
					document.mainform.savequery.value = 0; 
					document.mainform.target = 'newwindow'; 
					document.mainform.submit();
				}
				" title ="Show query in URL Access Format - Bookmark">URL
			</a>
		
			<a id="xml_button_tag"
				style="margin-right:4px;
				"
				class="mart_btn_xml"
   			onmouseover="this.className='mart_btn_xml mart_btnhov'" 
   			onmouseout="this.className='mart_btn_xml'"
          	onclick="
				if (datasetExists() > 0) {          	
	          	document.mainform.showquery.value = 1; 
   	       	document.mainform.do_export.value = 0; 
					document.mainform.savequery.value = 0; 
					document.mainform.target = 'newwindow'; 
					document.mainform.submit();
				}
				" title ="Show query in XML Web Service Format">XML
			</a>

			<a id="perl_button_tag"
				style="margin-right:4px;
				"
				class="mart_btn_perl"
   			onmouseover="this.className='mart_btn_perl mart_btnhov'" 
   			onmouseout="this.className='mart_btn_perl'"
          	onclick="
				if (datasetExists() > 0) {          	
	          	document.mainform.showquery.value = 2; 
   	       	document.mainform.do_export.value = 0; 
					document.mainform.savequery.value = 0; 
					document.mainform.target = 'newwindow'; 
					document.mainform.submit();
				}
				" title ="Show query as Perl Script">Perl
			</a>
	        
			<a id="help_button_tag"
				style="margin-right: 6px;
				"
				class="mart_btn_help"
   			onmouseover="this.className='mart_btn_help mart_btnhov'" 
   			onmouseout="this.className='mart_btn_help'"
   			
          	onclick="
         	 	document.mainform.showquery.value = 0; 
        		  	document.mainform.do_export.value = 0; 
					document.mainform.savequery.value = 0;
					document.mainform.target = '_self'; 
					var summaryCountElt1 = document.getElementById('summarypanel_filter_count_1');
					if (summaryCountElt1)	{				
						document.mainform.summarypanel_filter_count_1_hidden.value = summaryCountElt1.innerHTML;
					}
					var summaryCountElt2 = document.getElementById('summarypanel_filter_count_2');
					if (summaryCountElt2)	{
						document.mainform.summarypanel_filter_count_2_hidden.value = summaryCountElt2.innerHTML;
					}
	         	javascript:void(window.open('/biomart/mview/help.html','martview','width=600,height=500,resizable,scrollbars'));	
				" title ="Get Help">Help
			</a>


		</td>
		</tr>
	</table>


	</div>
	</td>
	</tr>
	
	
	<!-- GAP betweeb buttonsBar and panels below-->	
	<tr>
		<td width="100%" height="1%" align="left">			
		</td>
	</tr>
	
	
	<tr>
	
	<td width="100%" height="95%" align="left">
	<div style="width:100%; height:100%; overflow:visible; align:top; background: white; position: relative;">
		<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
		<tr>
		<td class="mart_tableSummaryPanel" height="100%" width="25%" align="left" valign="top">
			<div id="summaryPanelDiv" class="mart_summarypanel_datasets" style="height:100%; overflow: auto; text-align: top; position:relative; display: none;">			

				<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
				<tr>
				<td width="100%" height="100%" valign="top" align="left">
				
<!--
<div style="text-align: center;">
  <b>Query summary</b>
</div>
-->

None selected
<br />

					
				</td>
				</tr>
				</table>
			</div> <!-- summary box closes -->	
			<div id="summaryPanelDiv_empty" style="display: block;">			
				<table class="mart_summarypanel_listheaderTable" width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; margin: 16px 0px 0px 0px;">
				<tr> <td> <span class="mart_summarypanel_listheader_Empty" id=""> Dataset </span>	</td>	</tr>
				</table> 	<div  class="mart_summarypanel_listitem2">	[None selected]</div>
			</div>
		</td>
	
	<td class="mart_tableMainPanel" height="100%" width="85%" valign="top" align="left">

					
			<input type="hidden" name="menuNumber" value="0" />
			<input type="hidden" name="newsession" value="0" />
			<input type="hidden" name="do_export" value="0" />
			<input type="hidden" name="do_export2resultspage" />
			<input type="hidden" name="savequery" value="0" />
			<input type="hidden" name="showquery" value="0" />
			<input type="hidden" name="countButton" value="0" />
			<input type="hidden" name="resultsButton" value="0" />
			<input type="hidden" name="reverseName" value="0" />
			<input type="hidden" name="summarypanel_filter_count_1_hidden" value="" />
			<input type="hidden" name="summarypanel_filter_count_2_hidden" value="" />
			<input type="hidden" name="track_visible_section" value="0" />
			<input type="hidden" name="export_dataset" value="0" />
			<input type="hidden" name="formatterMenu" value="" />
			<input type="hidden" name="newQueryValue" value="1" />
			<input type="hidden" name="uniqueRowsPreView" value="" />
			<input type="hidden" name="uniqueRowsExportView" value="" />
			<input type="hidden" name="showAll" value="0" />
			<input type="hidden" name="schemaName" value="" />
			
			<input type="hidden" name="mart_mainpanel__current_visible_section" value=""/>
			<input type="hidden" name="summarypanel__current_highlighted_branch" value=""/>
			
			<div id="mart_mainpanel" style="height:100%; overflow:hidden; text-align: top; position: relative;">
			<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
			<tr>
			<td id="mart_mainpanel" width="100%" height="100%" valign="top" align="left">	
<div id="mart_datasetselectpanel" class="mart_datasetselectpanel" style="" >


<div id="schemaMenu" class="mart_schemamenu" style="">
	<select name="schemamenu" 
		class="mart_input"
		onchange="

			removeHiddenFormParam('schema');

			addHiddenFormParam('schema', document.mainform, this.options[this.selectedIndex].innerHTML);
			clearSummaryPanel();
			removeHiddenFormParam('dataBase');		
			removeHiddenFormParam('dataset');
			schemaMenuTriggered(this.options[this.selectedIndex].value);
		">
	</select>
</div>

<div id="dbMenu" class="mart_databasemenu" style="display:none;">
	<select  name="databasemenu" 
		class="mart_input"
		onchange="

			removeHiddenFormParam('schema');
			addHiddenFormParam_Schema('schema', document.mainform, this.options[this.selectedIndex].value);
									
			removeHiddenFormParam('dataBase');

			addHiddenFormParam('dataBase', document.mainform, this.options[this.selectedIndex].innerHTML);
			clearSummaryPanel();
			
			removeHiddenFormParam('dataset');

			dbMenuTriggered(this.options[this.selectedIndex].value);
		">
	</select>
</div>

<div id="dsMenu_1" class="mart_datasetmenu_compara" style="display:none;">
	<select name="datasetmenu_1"
		class="mart_input"	
		onchange="
			document.mainform.menuNumber.value = 1;
			clearSummaryPanel();
			removeHiddenFormParam('dataset');
			datasetmenu_1_Triggered(this.options[this.selectedIndex].value);
		">

	</select>
</div>

<div id="dsMenu_2" class="mart_datasetmenu_compara" style="display:none;">
	<select name="datasetmenu_2"
		class="mart_input"	
		onchange="
			document.mainform.menuNumber.value = 2;
			clearSummaryPanel();
			removeHiddenFormParam('dataset');			
			datasetmenu_2_Triggered(this.options[this.selectedIndex].value);
		">

	</select>
</div>

<div id="dsMenu_3" class="mart_datasetmenu" style="display:none;">
	<select name="datasetmenu_3"
		class="mart_input"	
		onchange="
			document.mainform.do_export.value = 0;
			document.mainform.showquery.value = 0;
			removeHiddenFormParam('dataset');
			if(this.options[this.selectedIndex].value != '')	{
				if (document.getElementById('dsMenu_1').style.display == 'block')	{
					// or dsMenu_2, just to flag its multi menu system for Web.pm
					document.mainform.menuNumber.value = 3;
				}
				else {
					document.mainform.menuNumber.value = 0;
				}

				addDatasetParamToForm(this.options[this.selectedIndex].value);
				if (document.getElementById('summarypanel_filter_count_1') != null)	{
					document.getElementById('summarypanel_filter_count_1').innerHTML = '';
					document.mainform.summarypanel_filter_count_1_hidden.value = '';
				}
				if (document.getElementById('summarypanel_filter_count_2') != null)	{
					document.getElementById('summarypanel_filter_count_2').innerHTML = '';
					document.mainform.summarypanel_filter_count_2_hidden.value = '';
				}
				document.mainform.target = '_self';
				document.mainform.resultsButton.value = 0;				
				document.mainform.submit();
			}
			else{
				clearSummaryPanel();
				//alert('not submitting - SOME WEIRD ERROR');
			}
		">
	</select>
</div>

</div>
			</td>
			</tr>
			</table>
			</div>


		</td>
		</tr>
		</table>
		
	</div>
	</td>
	</tr>

	<tr>
		<td align="left" height="0%" valign="top">
		<div style="border-width: 0px 0px 1px 0px; border-style: solid; border-color: black;"> </div>
		</td>
	</tr>

        </table>

        <!-- following Iframes must be kept out of the above table otherwise FireFox starts moaning about auto scrolling -->
        <!-- we set display:none (for all browsers) and visibility:hiddden (for Safari & Konqueror) through JS -->
        <iframe id="countIFrameId" name="count_hiddenIFrame" src="about:blank" style="width:0px; height:0px;"
                                onload="getCountAjax();">
        </iframe>
        <iframe id="resultsIFrameId" name="results_hiddenIFrame" src="about:blank" style="width:0px; height:0px;"
                                onload="getResultsAjax();">
        </iframe>

  </form>
</div>

<div id="mart_footerStrip" class="mart_footer" style="width:100%; height:0px;">        </td>

      </tr>

      <tr>
	<td id="spacer"></td>

        <td class="footer_bio"> 
	<table border="0" align="center" width="100%" cellspacing="2" class="footer_bio">
	  <tr>
	    <td align="left" style="padding-left:10px;">
	  	 biomart version 0.7
	    </td>
	    <td align="right" style="padding-right:80px;">

	      <table border="0" cellspacing="0" cellpadding="0">
	        <tr>
	          <td align="center">
	            <img src="http://www.vectorbase.org/imgs/mail.gif" border="0" alt="mail"/>
	          </td>
	          <td align="center" class="hashelp" name="Web:email_help" style="color:#ffffff; font-size:10px;"> &nbsp;
	               <a href="mailto:webmaster@vectorbase.org" class="hashelp" name="Web:email_help" style="color:#ffffff; font-size:10px;">Contact Webmaster</a>
	          </td>
	        </tr>
	      </table>
	    </td>
	  </tr>
	</table>
     </td>
   </tr>

   <tr>
     <td>
       	<img src="http://www.vectorbase.org/imgs/blank.gif" alt="blank"/>
     </td>

     <td align="center">

          <table width="100%" height="50" cellspacing="0" cellpadding="4">
            <tr>
              <td valign="middle" align="center">
		        <img src="http://www.vectorbase.org/imgs/nd.png" border="0" alt="ND"/>
              </td>
              <td valign="middle" align="center">
		        <img src="http://www.vectorbase.org/imgs/ensembl.png" border="0" alt="Ensembl"/>
              </td>
              <td valign="middle" align="center">
		        <img src="http://www.vectorbase.org/imgs/imbb.png" border="0" alt="IMBB"/>
              </td>
              <td valign="middle" align="center">
		        <img src="http://www.vectorbase.org/imgs/harvard.png" border="0" alt="Harvard"/>
              </td>
              <td valign="middle" align="center">
		        <img src="http://www.vectorbase.org/imgs/imperial_logo_small.png" border="0" alt="Imperial College"/>
              </td>
            </tr>
          </table>
     </td>
  </tr>
</table>
  
	</td>
	</tr>
	</table>	
</div>

	<script language="JavaScript" type="text/javascript" >
		//<![CDATA[
			datasetpanel_pre_onload({'databasemenu':{'vectorbase_mart_13____VectorBase Variation 13':{'datasetmenu_3':[['agambiae_eg_snp','Anopheles gambiae variations (AgamP3)'],['','-------------------------------------']]},'vectorbase_mart_13____VectorBase Expression Mart':{'datasetmenu_3':[['vb','Gene Expression Data']]},'vectorbase_mart_13____VectorBase Genes':{'datasetmenu_3':[['aaegypti_eg_gene','Aedes aegypti genes (AaegL1)'],['agambiae_eg_gene','Anopheles gambiae genes (AgamP3)'],['cquinquefasciatus_eg_gene','Culex quinquefasciatus genes (CpipJ1)'],['iscapularis_eg_gene','Ixodes scapularis genes (IscaW1)'],['phumanus_eg_gene','Pediculus humanus genes (PhumU1)'],['','-------------------------------------']]}},'schema':{'vectorbase_mart_13':{'databasemenu':[['vectorbase_mart_13____VectorBase Genes','VectorBase Genes'],['vectorbase_mart_13____VectorBase Variation 13','VectorBase Variation 13'],['vectorbase_mart_13____VectorBase Expression Mart','VectorBase Expression Mart']]}}} , {'datasetmenu_1':'','datasetmenu_2':'','databasmenu':'','datasetmenu_3':'','schema':''} , 'CHOOSE SCHEMA', 'CHOOSE DATABASE', 'CHOOSE DATASET', '0');
		//]]>
	</script>


</body>
</html>
