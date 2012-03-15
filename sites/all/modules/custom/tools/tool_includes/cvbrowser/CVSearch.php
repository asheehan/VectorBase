<script type="text/javascript" src="yui/yahoo.js"></script>
<script type="text/javascript" src="yui/event.js"></script>
<script type="text/javascript" src="yui/dom.js"></script>
<script type="text/javascript" src="yui/treeview.js"></script>
<script type="text/javascript" src="yui/animation.js"></script>
<script type="text/javascript" src="yui/autocomplete.js"></script>
<script type="text/javascript" src="cxf-utils.js"></script>
<script type="text/javascript" src="OlsObjectService.js"></script>
<script type="text/javascript" src="cvConstants.js"></script>
<script type="text/javascript" src="organismConstants.js"></script>
<script type="text/javascript">

//Global Variables
var OLS_SOAP_CLIENT = new ols_olsPort(),
CV_ID,
tree,
lastClicked,
queryTerm,
wasSearched,
resNum = 0,
i = 0; 

/* Clears the History div */
function clearHistory() {
    var history = document.getElementById('ols_history');
    while(history.childNodes.length > 0){
        history.removeChild(history.childNodes[0]);
    }
}


/* Adds an entry to for recently looked at cv terms. */
function addNodeToHistory(node){
    if(moveToInHistory("hist" + node.data.id)){
        return;
    }
    var history = document.getElementById('ols_history');
    var tmp = document.createElement("div");
    tmp.innerHTML = wrapText(node.data.label, 25);
    tmp.id = "hist" + node.data.id;
    tmp.name = node.data.label;

    var cvListener = function(tmp) { 
        window.crossBrowserListen(tmp, "click", function() { tmp.style.color = "black"; FindCVTermInTree(tmp.name); }); 
        window.crossBrowserListen(tmp, "mouseover",  function() { tmp.style.color = "blue"; tmp.style.cursor = 'pointer'; });
        window.crossBrowserListen(tmp, "mouseout",  function() { tmp.style.color = "black"; tmp.style.cursor = 'default'; });
    }
    cvListener(tmp);

    if(history.childNodes.length == 0){
        history.appendChild(tmp);
    } else {
        history.insertBefore(tmp, history.childNodes[0]);
    }
    if(history.childNodes.length > 10){
        history.removeChild(history.childNodes[history.childNodes.length - 1]);
    }
}


/* Update history tab when change is made */
function updateCurrent(tmp){
    var history = document.getElementById('ols_history');
    var arrow;
    if(document.getElementById('ols_history_arrow')){
        arrow = document.getElementById('ols_history_arrow');
        history.removeChild(arrow);
    } else {
        arrow = document.createElement("div");
        arrow.innerHTML = ">";
        arrow.style.display = "inline";
        arrow.style.color = "red";
        arrow.id = "ols_history_arrow";
    }
    if(history.childNodes.length > 20) {
        history.removeChild(history.firstChild);
    }
    for(var i = 1; i < history.childNodes.length; i++){
        if(history.childNodes[i].id == tmp.id){
            var j;
            if(i < 6){
                j = 1;
            } else {
                j = (i-4);
            }
            for(; ((i+4) >= j) && (j >= (i-5)) && (j < history.childNodes.length); j++){
                history.childNodes[j].style.display = "block";
            }
            i = j;
        } else {
            history.childNodes[i].style.display = "none";
        }
    }
    tmp.style.display = "inline";
    history.insertBefore(arrow, tmp);
}


/* When a history item is selected */
function moveToInHistory(nodeID){
    var history = document.getElementById('ols_history');
    for(var i = 0; i < history.childNodes.length; i++){
        if(nodeID == history.childNodes[i].id){
            history.insertBefore(history.childNodes[i], history.childNodes[0]);
            return true;
        }
    }
    return false;
}


/* For last-clicked event. This does the updating of node classes to highlight 
 * most recently clicked node */
function updateClicked(node) {
    if(lastClicked){
        lastClicked.labelStyle = 'ygtvlabel';
        lastClicked.parent.refresh(); 
    }
    node.labelStyle = 'lastClicked';
    node.parent.refresh(); 
    lastClicked = node; 
}


/* Clears the serach box and disables it, as well as the search button. 
 * Then builds the tree based on the selected value from the dropdown. */
function cvSelected(sel, fn){

    // document.getElementById('ols_search_box').value = "";
    // document.getElementById('ols_search_box').disabled = true;
    // document.getElementById('ols_submit_button').disabled = true;
    for(var i = 0; i < sel.options.length; i++){
        if(sel.options[i].selected){
            var title = document.getElementById('ols_tree_title');
            title.innerHTML = "Browsing " + sel.options[i].text;
            document.getElementById('sidebarTitle').innerHTML = "Browsing " + sel.options[i].text;
            // Clear out old stuff
            tree = null;
            lastClicked = null;
            GetTopLevelCVTermsByCVID(sel.options[i].value, fn);
        }
    }
}


/* TODO Comment */
function cvFromGet(number, fn) {
    // document.getElementById('ols_search_box').value = "";
    // document.getElementById('ols_search_box').disabled = true;
    // document.getElementById('ols_submit_button').disabled = true;
    var sel = document.getElementById('ols_select_sel');
    for(var i = 0; i < sel.options.length; i++){
        if(sel.options[i].value  == number){
            sel.options[i].selected = true;
            cvSelected(sel, fn);
        }
    }
}


/* Dynamic node generation for our treeview */
function loadNode(node,fnLoadComplete){
    GetChildCVTermsByCVTermID(node.data.id, node, fnLoadComplete);
}


/* Retrieve nodes of the current cvterm */
function GetChildCVTermsByCVTermID(cvterm_id, node, fnLoadComplete){
    OLS_SOAP_CLIENT.getChildCVTermsByCVTermID(function (r, xml) { GetChildCVTermsByCVTermID_callBack(r, xml, node, fnLoadComplete); }, errorCallback, cvterm_id, CV_ID);
}


/* Update function for GetChildCVTermsByCVTermID */
function GetChildCVTermsByCVTermID_callBack(r, xml, node, fnLoadComplete){

    for(var i = 0; i < r._return.length; i++){
        var myobj = { label:r._return[i]._name, id:r._return[i]._cvterm_id };
        var newNode = new YAHOO.widget.TextNode(myobj, node, false); 
    }
    fnLoadComplete();
}


/* Does what it says. It gets the image(s) for the given node */
function GetImage(node){
    var cvterm_id = node.data.id;
    OLS_SOAP_CLIENT.getImage(function (r, xml) { GetImage_callBack(r, xml); }, errorCallback, cvterm_id);
}


/* Update function for GetImage */
function GetImage_callBack(r, xml){
    var image = document.getElementById('ols_imageTable');
    removeChildren(image);
    if(r._return.length == 1 && r._return[0] == null){
        document.getElementById('ols_images').style.display = "none";
        return;
    }
    document.getElementById('ols_images').style.display = "block";
    for(var i = 0; i < r._return.length; i++){
        var wrap = document.createElement("div");
        wrap.className = "ols_image_wrap";
        image.appendChild(wrap);
        var type = document.createElement("div");
        //type.innerHTML = r._return[i].typeMarker;
        type.style.backgroundColor = "#006633";
        type.style.padding="2px";
        wrap.appendChild(type);
        var img = document.createElement("div");
        img.innerHTML = "<a href='/Image/" + r._return[i]._filename + "' target='_blank'><img src='/Image/" + r._return[i]._filename + "?width=279' /></a>";
        img.style.backgroundColor = "#006633";
        img.style.padding="2px";
        wrap.appendChild(img);
    }
}


/* On selecting a node we get back a number of attributes */
function GetCVTermAttributes(node) {
    var cvterm_id = node.data.id;
    var parent_cvterm_id;
    if(node.parent.data) {
        parent_cvterm_id = node.parent.data.id;
    } else {
        parent_cvterm_id = 0;
    }
    OLS_SOAP_CLIENT.getCVTermAttributes(function(r, xml) { GetCVTermAttributes_callBack(r, xml); }, errorCallback, cvterm_id, parent_cvterm_id);
    OLS_SOAP_CLIENT.getFeaturesWithCVTermID(function(r, xml) { GetFeaturesWithCVTermID_callBack(r, xml); }, errorCallback, cvterm_id, 0);
//  TODO This service is currently down. EBI is working to fix this (funcgen)
    OLS_SOAP_CLIENT.getDasWithCVTermID(function(r, xml) { GetDasWithCVTermID_callBack(r, xml); }, errorCallback, cvterm_id);
//  SOAPClient.invoke(url, "GetDasWithCVTermID", pl3, true, GetDasWithCVTermID_callBack, false);
}


/* Subtracts second argument from the first. */
function sortNumber(a, b) {
    return a - b;
}


/* This highlights the search term within the definition at the right. We're 
 * trying to highlight definitions. We need array of terms and locations in 
 * the string, then we'll highlight them in the string with spans and return.*/
function highlightDefinition(definition) {
    var terms = queryTerm.split(/_/g);
    var termLocs = [];
    for(var i = 0; i < terms.length; i++){
        termLocs[i] = definition.indexOf(terms[i]);
        if(termLocs[i] == -1){
            return definition;
        }
    }
    var termLocsSorted = termLocs.slice();
    termLocsSorted.sort(sortNumber);
    var newDef = "";
    var lastLoc = 0;;
    for(var j = 0; j < terms.length; j++){
        var loc = termLocsSorted[j];
        var k = 0;
        for(; k < termLocs.length && termLocs[k] != loc; k++){
        }
        newDef += definition.substr(lastLoc, loc - lastLoc);
        newDef += "<span>" + terms[k] + "</span>";
        lastLoc = loc + terms[k].length;
    }
    newDef += definition.substr(lastLoc, definition.length - lastLoc);
    return newDef;
}


/* Update function CVTermAttributes */
function GetCVTermAttributes_callBack(r, xml) {

    if(r._return._cvterm_id == 0){
        document.getElementById('ols_information').style.display = 'none';
    } else {
        document.getElementById('ols_information').style.display = 'block';
        var id = document.getElementById('ols_info_id');
       
       for(var i = 0; i < cvConstantsJson.cvs.length; i++) {
         if(CV_ID == JSON.parse(cvConstantsJson.cvs[i].id)) {
           id.innerHTML = cvConstantsJson.cvs[i].prefix; 
         }
       }

        id.innerHTML += r._return._dbxAccession;
        var name = document.getElementById('ols_info_name');
        name.innerHTML = r._return._name;
        var definition = document.getElementById('ols_info_definition');
        if(r._return._definition == null){
            r._return._definition = "";
        }
        if(wasSearched == true){
            definition.innerHTML = highlightDefinition(r._return._definition);
        } else {
            definition.innerHTML = r._return._definition;
        }
        wasSearched = false;
        var rx = r._return._relationship;
        var relationship = document.getElementById('ols_info_relationship');
        removeChildren(relationship);
        var one = document.createElement("div");
        one.style.display = "inline";
        one.style.marginLeft = "2px";
        one.innerHTML = rx[0];
        relationship.appendChild(one);
        var two = document.createElement("div");
        two.style.display = "inline";
        two.style.textDecoration = "underline";
        two.style.marginLeft = "4px";
        two.innerHTML = rx[1];
        var cvListener = function(tmp) { 
            window.crossBrowserListen(tmp, "click", function() { FindCVTermInTree(tmp.innerHTML); }); 
            window.crossBrowserListen(tmp, "mouseover",  function() { tmp.style.color = "blue"; tmp.style.cursor = 'pointer'; });
            window.crossBrowserListen(tmp, "mouseout",  function() { tmp.style.color = "#777777"; tmp.style.cursor = 'default'; });
        }
        cvListener(two);
        relationship.appendChild(two);
    }
}


/* Search SOAP request. This populates our dropdown. */
function FindCVTermsBySearchTermAndCVID(query, cv_id, oCallbackFn, oParent, queryObject){
    if(query.length > 2){
        OLS_SOAP_CLIENT.findCVTermsBySearchTermAndCVID(
                function(r, xml) { 
                    FindCVTermsBySearchTermAndCVID_callBack(r, xml, oCallbackFn, oParent, query, queryObject); 
                    }, errorCallback, query, cv_id);
    }
}


/* Update function for FindCVTermsBySearchTermAndCVID */
function FindCVTermsBySearchTermAndCVID_callBack(r, xml, oCallbackFn, oParent, query, queryObject){
    var result = [];
    var j = 0;
    for(var i = 0; i < r._return.length; i++){
        var obj = [r._return[i]._name, r._return[i]._cvterm_id];
        result[j] = obj;
        j++;
    }
    queryObject.handleQuery(result, oCallbackFn, query, oParent);
}


/* If we can't find the exact cvterm, we return a list of CVTerms by matching 
 * the term in the description */
function SearchCVTermNameAndDefinition(query, num){
    resNum = num;
    query = query.replace(/[^A-Za-z]/g,'_');
    queryTerm = query;
    OLS_SOAP_CLIENT.searchCVTermNameAndDefinition(function(r, xml) { SearchCVTermNameAndDefinition_callBack(r, xml); }, errorCallback, query, CV_ID, resNum);
}


/* Update function for SearchCVTermNameAndDefinition */
function SearchCVTermNameAndDefinition_callBack(r, xml){
    var searchRes = document.getElementById('results_div');
    if(r._return.length == 0 || (r._return.length == 1 && r._return[0] == null)){
        searchRes.style.color = 'red';
        searchRes.innerHTML = "Nothing matched your search term.";
        return;
    }
    searchRes.innerHTML = "";
    var noRes = document.createElement("div");
    noRes.style.color = 'red';
    noRes.innerHTML = "The following terms' definitions match your query:";
    searchRes.appendChild(noRes);
    if(!(r._return.length == 1 && r._return[0] == null)){
        var iterNum = 0;
        for(var i=0; i < r._return.length; i++){
            var tmp = document.createElement("div");
            if(i == 10 || (resNum != 0  && i == (r._return.length - 1))){
                if(resNum != 0){
                    var left = document.createElement("div");
                    left.className = "searchLeftNav";
                    left.innerHTML = "<- Back";
                    left.id = "search_back";
                    var cvListener = function(left) { 
                        window.crossBrowserListen(left, "click", function() { left.innerHTML = "<img src=\"yui/images/loading2.gif\" class=\"loading2\" />"; SearchCVTermNameAndDefinition(queryTerm, resNum - 10); }); 
                        window.crossBrowserListen(left, "mouseover",  function() { left.style.color = "blue"; left.style.cursor = 'pointer'; });
                        window.crossBrowserListen(left, "mouseout",  function() { left.style.color = "#777777"; left.style.cursor = 'default'; });
                    }
                    cvListener(left);
                    tmp.appendChild(left);
                }
                if(i == 10){
                    var right = document.createElement("div");
                    right.className = "searchRightNav";
                    right.innerHTML = "More ->";
                    right.id = "search_more";
                    var cvListener = function(right) { 
                        window.crossBrowserListen(right, "click", function() { right.innerHTML = "<img src=\"yui/images/loading2.gif\" class=\"loading2\" />"; SearchCVTermNameAndDefinition(queryTerm, resNum + 10); }); 
                        window.crossBrowserListen(right, "mouseover",  function() { right.style.color = "blue"; right.style.cursor = 'pointer'; });
                        window.crossBrowserListen(right, "mouseout",  function() { right.style.color = "#777777"; right.style.cursor = 'default'; });
                    }
                    cvListener(right);
                    tmp.appendChild(right);
                }
                searchRes.appendChild(tmp);
            } else {
                if(iterNum%2 == 1){
                    tmp.className = "search_result_odd";
                } else {
                    tmp.className = "search_result_even";
                }
                iterNum++;
                tmp.style.color =  "black";
                /* butler */
                tmp.innerHTML = wrapText(highlightDefinition(r._return[i]._name),25);
                tmp.id = r._return[i]._name;
                tmp.cvterm_id = r._return[i]._cvterm_id;
                var cvListener = function(tmp) { 
                    window.crossBrowserListen(tmp, "click", function() { wasSearched = true; FindCVTermInTreeByCVTermID(tmp.cvterm_id); }); 
                    window.crossBrowserListen(tmp, "mouseover",  function() { tmp.style.color = "blue"; tmp.style.cursor = 'pointer'; });
                    window.crossBrowserListen(tmp, "mouseout",  function() { tmp.style.color = "black"; tmp.style.cursor = 'default'; });
                }
                cvListener(tmp);
                searchRes.appendChild(tmp);
            }
        }
    }
}


/* Returns list of CVTerm objects, starting with the root and ending with the
 * term matching the given id */
function FindCVTermInTreeByCVTermID(cvterm_id) {
    OLS_SOAP_CLIENT.findCVTermInTreeByCVTermID(function(r, xml) { FindCVTermInTreeByCVTermID_callBack(r, xml, cvterm_id); }, errorCallback, cvterm_id, CV_ID);
}


/* Initial look for query in tree that gets called when search is entered */
function FindCVTermInTree(name){
    var isSearch = true;
    if(typeof(name) == 'object'){
        name = document.getElementById('ols_search_box').value;
        var searchRes = document.getElementById('results_div');
        searchRes.style.color = '#777777';
        searchRes.innerHTML = "Searching for " + name + "... <img src=\"yui/images/loading2.gif\" class=\"loading2\" />";
        isSearch = false;
    }
    OLS_SOAP_CLIENT.findCVTermInTree(function(r, xml) { FindCVTermInTree_callBack(r, xml, name, isSearch); }, errorCallback, name, CV_ID);
}


/* Recursively expands to wanted node */
function recursiveExpand(arr, node, checkExpand){
    if(!arr.length){ 
        tree.unsubscribe("expandComplete", checkExpand );
        return; 
    }
    var curElement = arr.shift();
    var cvterm_id = curElement._cvterm_id;
    for(var j = 0; j < node.children.length; j++){
        if(node.children[j].data.id == cvterm_id){
            // last node - select instead of expand
            if(!arr.length) {
                tree.fireEvent("labelClick", node.children[j]);
                updateClicked(node.children[j]);
            } else {
                node.children[j].expand();
            }
            break;
        }
    }
}


/* Update function for FindCVTermInTreeByCVTermID */
function FindCVTermInTreeByCVTermID_callBack(r, xml, name) {
    if(r._return.length == 0){
        return;
    }
    var arr = r._return.reverse();
    var node = tree.getRoot();
    node.collapseAll();
    tree.subscribe("expandComplete", function(node){ recursiveExpand(arr, node, recursiveExpand); } );
    recursiveExpand(arr, node, recursiveExpand);
}


/* If exact match, does a recursive expand on the response. Otherwise looks 
 * in description */
function FindCVTermInTree_callBack(r, xml, name, isSearch){
    if(r._return.length == 0){
        SearchCVTermNameAndDefinition(name, 0);
        return;
    }
    if(!isSearch){
        var searchRes = document.getElementById('results_div');
        searchRes.innerHTML = "Found " + name + ".";
    }
    var arr = r._return.reverse();
    var node = tree.getRoot();
    // If we wanted to change the "searching for x ..." to "found x ... " or
    // even "", here is where
    node.collapseAll();
    tree.subscribe("expandComplete", function(node){ recursiveExpand(arr, node, recursiveExpand); } );
    recursiveExpand(arr, node, recursiveExpand);
}


/* Update function for GetDasWithCVTermID */
function GetDasWithCVTermID_callBack(r, xml) {
    var das = document.getElementById('ols_dasTable');
    if(r._return.length == 1 && r._return[0] == null){
        document.getElementById('ols_das').style.display = "none";
        return;
    }
    document.getElementById('ols_das').style.display = "block";
    for(var i = 0; i < r._return.length; i++){
        var outlineDiv = document.createElement("div");
        var biggerOutline = document.createElement("div");
        biggerOutline.className = "ols_outline";
        biggerOutline.style.backgroundColor = "white";
        biggerOutline.style.padding = "2px";
        outlineDiv.className = "ols_outline";
        outlineDiv.style.border = "1px solid #9C9C9C";
        das.appendChild(biggerOutline);
        biggerOutline.appendChild(outlineDiv);
        var das_name = r._return[i]._name;
        var das_label = r._return[i]._label;
        var das_type = r._return[i]._type;
        var das_note = r._return[i]._note;
        var das_link = r._return[i]._link;
        var das_linkText = r._return[i]._linkText;

        var labelDiv = document.createElement("div");
        labelDiv.className = "ols_info";
        var labelLeft = document.createElement("span");
        labelLeft.className = "ols_info_left_white";
        labelLeft.innerHTML = "Title: ";
        labelDiv.appendChild(labelLeft);
        var labelRight = document.createElement("span");
        labelRight.className = "ols_info_right_white";
        labelRight.innerHTML = das_label;
        labelDiv.appendChild(labelRight);
        outlineDiv.appendChild(labelDiv);

        var typeDiv = document.createElement("div");
        typeDiv.className = "ols_info";
        var typeLeft = document.createElement("span");
        typeLeft.className = "ols_info_left_white";
        typeLeft.innerHTML = "Type: ";
        typeDiv.appendChild(typeLeft);
        var typeRight = document.createElement("span");
        typeRight.className = "ols_info_right_white";
        typeRight.innerHTML = das_type;
        typeDiv.appendChild(typeRight);
        outlineDiv.appendChild(typeDiv);

        var noteDiv = document.createElement("div");
        noteDiv.className = "ols_info";
        var noteLeft = document.createElement("span");
        noteLeft.className = "ols_info_left_white";
        noteLeft.innerHTML = "Summary: ";
        noteDiv.appendChild(noteLeft);
        var noteRight = document.createElement("span");
        noteRight.className = "ols_info_right_white";
        noteRight.innerHTML = das_note;
        noteDiv.appendChild(noteRight);
        outlineDiv.appendChild(noteDiv);

        var linkDiv = document.createElement("div");
        linkDiv.className = "ols_info";
        var linkLeft = document.createElement("span");
        linkLeft.className = "ols_info_left_white";
        linkLeft.innerHTML = "Link: ";
        linkDiv.appendChild(linkLeft);
        var linkRight = document.createElement("span");
        linkRight.className = "ols_info_right_white";
        linkRight.innerHTML = "<a href=\"" + das_link + "\">" + das_linkText + "</a>";
        linkDiv.appendChild(linkRight);
        outlineDiv.appendChild(linkDiv);
    }
}


/* Update function for GetFeaturesWithCVTermID */
function GetFeaturesWithCVTermID_callBack(r, xml) {

    var features = document.getElementById('ols_featureTable');
    if(r._return.length){
        document.getElementById('ols_features').style.display = "block";
    } else {
        document.getElementById('ols_features').style.display = "none";
    }
    features.innerHTML = null;
    var tmpString = "";
    for(var i = 0; i < r._return.length; i++){
        var species = r._return[i]._organism_species;
        var genus = r._return[i]._organism_genus;
        // Need this to go to species type!
        tmpString += "<a href='http://" + genus.substring(0,1) + species + ".vectorbase.org/Genome/";
        var type = r._return[i]._type;
        if(type == 'gene'){
            tmpString += "GeneView/?gene";
        } else if(type == 'protein'){
            tmpString += "ProtView/?peptide";
        } else if(type == 'transcript' || type == 'mRNA'){
            tmpString += "TransView/?transcript";
        } else {
            alert(type);
        }
        tmpString += "=" + r._return[i]._name + ";db=core' target='_blank'>" + r._return[i]._name + "</a><br />";
    }
    features.innerHTML = tmpString;
}


/* Clears out all our extraneous information on a change */
function clearAll() {
    // document.getElementById('results_div').innerHTML = "";
    document.getElementById('ols_features').style.display='none';
    document.getElementById('ols_information').style.display='none';
    document.getElementById('ols_images').style.display='none';
    // document.getElementById('ols_search_box').value = "";
    clearHistory();
}


/* Initiation function. */
function loadStart(){
    document.getElementById('sidebarTitle').innerHTML = "";
    document.getElementById('ols_tree_title').innerHTML = "Browser for Ontologies and Controlled Vocabularies (CV)";
    var contentText = "Welcome to the Ontology/CV browser.";
    contentText += "<br /><br /><u>Start</u><br />  To begin, select an Ontology/CV to browse on the left. A navigable tree populated with Ontology/CV terms will be displayed where these instructions are now.";
    contentText += "<br /><br /><u>Navigating</u><br />  Clicking on an unexpanded node will display its children nodes, if it has any.  Selecting an expanded node will collapse it.  Selecting any node will also display information about that node to the right of the tree.  This may include associated features hosted on VectorBase, or images associated with that Ontology/CV term.";
    contentText += "<br /><br /><u>Searching</u><br />  Terms can be searched for to the left.  We will attempt to auto-complete a search based on known Ontology/CV term.  If an exact match is found, the tree will auto-navigate to that Controlled Vocabulary term.  If not, a set of matches will be listed below the search box.  Matches to the name will be highlighted in the result.  If there is no highlighting, the search matched the result's definition.  If the search matches more than 10 results, clicking 'More->' will display the next set of results.";
    contentText += "<br /><br /><u>History</u><br />  History will display the most recent terms selected.  Clicking on one of these items will navigate to the term in the tree.";
    document.getElementById('ols_tree_content_div').innerHTML = contentText;
    var sel = document.getElementById('ols_select_sel');
    var sF = document.getElementById('ols_search_form');
    window.crossBrowserListen(sF, 'submit', FindCVTermInTree);
}


/* This really BEGINS our browser. Populates our tree with top level cvterms
 * on selecting a starting cv */
function GetTopLevelCVTermsByCVID( cv_id, fn ) {
    if(cv_id == 0) {
        clearAll();
        loadStart();
        // document.getElementById('ols_search_box').disabled = true;
        // document.getElementById('ols_submit_button').disabled = true;
        return;
    }

    CV_ID = cv_id;
    clearAll();

    var callBack;

    if(fn) {
        callBack = function(r, xml) { GetTopLevelCVTermsByCVID_callBack(r, xml); fn();};
    } else {
        callBack = function(r, xml) { GetTopLevelCVTermsByCVID_callBack(r, xml);};
    }
    OLS_SOAP_CLIENT.getTopLevelCVTermsByCVID(callBack, errorCallback, cv_id);

}


/* Logging function when something goes wrong */
function errorCallback(httpStatus, httpStatusText)
{
    console.log('(errorCallback): HTTP Status Code: ' + httpStatus + ', HTTP Status Text: ' + httpStatusText);
}


/* Redefining the YAHOO library's doQuery function to make calls happen asynchronously */
YAHOO.widget.DS_JSFunction.prototype.doQuery = function(oCallbackFn, sQuery, oParent) {
    var oFunction = this.dataFunction;
    oFunction(sQuery, oCallbackFn, oParent, this);
}

/* Redefining the YAHOO library's handleQuery function to make calls happen asynchronously */
YAHOO.widget.DS_JSFunction.prototype.handleQuery = function(aResults, oCallbackFn, sQuery, oParent) {
    var resultObj = {};
    resultObj.query = decodeURIComponent(sQuery);
    resultObj.results = aResults;
    this._addCacheElem(resultObj);
    this.getResultsEvent.fire(this, oParent, sQuery, aResults);
    oCallbackFn(sQuery, aResults, oParent);
    return;
}


/* TODO Add comment. */
function inspect(obj, maxLevels, level)
{
    var str = '', type, msg;

    // Start Input Validations
    // Don't touch, we start iterating at level zero
    if(level == null)  level = 0;

    // At least you want to show the first level
    if(maxLevels == null) maxLevels = 1;
    if(maxLevels < 1)     
        return '<font color="red">Error: Levels number must be > 0</font>';

    // We start with a non null object
    if(obj == null)
        return '<font color="red">Error: Object <b>NULL</b></font>';
    // End Input Validations

    // Each Iteration must be indented
    str += '<ul>';

    // Start iterations for all objects in obj
    for(property in obj)
    {
        try
        {
            // Show "property" and "type property"
            type =  typeof(obj[property]);
            str += '<li>(' + type + ') ' + property + 
            ( (obj[property]==null)?(': <b>null</b>'):('')) + '</li>';

            // We keep iterating if this property is an Object, non null
            // and we are inside the required number of levels
            if((type == 'object') && (obj[property] != null) && (level+1 < maxLevels))
                str += inspect(obj[property], maxLevels, level+1);
        }
        catch(err)
        {
            // Is there some properties in obj we can't access? Print it red.
            if(typeof(err) == 'string') msg = err;
            else if(err.message)        msg = err.message;
            else if(err.description)    msg = err.description;
            else                        msg = 'Unknown';

            str += '<li><font color="red">(Error) ' + property + ': ' + msg +'</font></li>';
        }
    }

    // Close indent
    str += '</ul>';

    return str;
}


/* Update function for GetTopLevelCVTermsByCVID */
function GetTopLevelCVTermsByCVID_callBack(r, xml) {
    // document.getElementById('ols_search_box').disabled = false;
    // document.getElementById('ols_submit_button').disabled = false;

    // Redraw main and make a new tree div
    var main = document.getElementById('ols_tree_content_div');

    if(r._return.length == 0){
        main.innerHTML = "This CV contains no information";
        return;
    }
    // Initiate the tree
    tree = new YAHOO.widget.TreeView('ols_tree_content_div');
    // var root = tree.getRoot();

    tree.setDynamicLoad(this.loadNode, 1); 
    var root = tree.getRoot();

    // Declaring some functions for the tree
    tree.subscribe("labelClick", 
            function(node) { 
        GetCVTermAttributes(node); 
        GetImage(node);
        addNodeToHistory(node); 
    }
    ); 
    tree.subscribe("expandComplete", 
            function(node) { 
        updateClicked(node);
    }
    );
    tree.subscribe("collapseComplete", 
            function(node) { 
        updateClicked(node);
    }
    );

    for(var i = 0; i < r._return.length; i++){
        var myobj = { label:r._return[i]._name, id:r._return[i]._cvterm_id };
        var tmp = new YAHOO.widget.TextNode(myobj, root, false);
        window.crossBrowserListen(tmp, "click", function() { FindCVTermInTree(tmp.innerHTML); }); 
    }
    tree.draw();
    CV_ID = r._return[0]._cv._cv_id;
    // Preparing Search
    var searchTerm = function (query, oCallbackFn, oParent, queryObject) {
        // Start request for Search Terms
        FindCVTermsBySearchTermAndCVID(query, CV_ID, oCallbackFn, oParent, queryObject);
    }

    /*ols_search_acjs = function(){
        var datasource;
        var autoComp;

        return {
            init: function(){
                dataSource = new YAHOO.widget.DS_JSFunction(searchTerm);
                autoComp = new YAHOO.widget.AutoComplete("ols_search_box", "ols_search_div", dataSource);
                autoComp.queryDelay = 0;
                autoComp.minQueryLength = 0;
                autoComp.maxResultsDisplayed = 10;
                autoComp.delimChar = ""
                    autoComp.formatResult = function(res, query) {
                    return (res[0]);
                };
                autoComp.dataReturnEvent.subscribe(ols_search_acjs.myOnDataReturn);
            },
            myOnDataReturn: function(type, args) {
                var autoComp = args[0];
                var query = args[1];
                var res = args[2];
            },

            validateForm: function() {
            }

        };
    }();
    ols_search_acjs.init();*/
}


/* Self made dumper function */
function dump(o, level){
    var indent = "";
    for(var i = 0; i < level; i++){
        indent += "  ";
    }
    var str = "";
    for (var property in o) {
        if (typeof(o[property]) == 'object') {
            str += indent + property + ":\n" + dump(o[property], level + 1) + "\n";

        } else {
            str += indent + property + ": " + o[property] + "\n";
        }
    }
    return str;
}


/* Get those kids outta the house */
function removeChildren(node) {
    while (node.hasChildNodes()) {
        node.removeChild(node.firstChild);
    }
}


/* TODO Comment */
function wrapText(s, l) {
    var newS = "";
    var firstSpan = s.indexOf("<span");
    var secondSpan = s.indexOf("</span>");
    if(firstSpan != -1){
        var newS = "";
        var spanText = s.substring(firstSpan, secondSpan + 7);
        var tmp = s.substring(0, firstSpan) + "<hl>" + s.substring(secondSpan+7, s.length);
        s = tmp;
        var arr = new Array();
        arr = s.split(' ');
        for(var i = 0; i < arr.length; i++){
            while(arr[i].length > 0){
                var hl = arr[i].indexOf("<hl>");
                if(hl > -1 && hl < l){
                    newS += arr[i].substring(0, hl) + spanText + arr[i].substring(hl+4, l + 4);
                    arr[i] = arr[i].substring(l+4);
                } else {
                    newS += arr[i].substring(0, l);
                    arr[i] = arr[i].substring(l);
                }
                if(arr[i].length >= l){
                    newS += "<br />";
                } else {
                    newS += " ";
                }
            }
        }
        return newS;
    }

    var arr = new Array();
    arr = s.split(' ');
    s = "";
    for(var i = 0; i < arr.length; i++){
        if(arr[i].length > l){
            var newS = "";
            while(arr[i].length){
                newS += arr[i].substring(0, l) + "<br />";
                arr[i] = arr[i].substring(l);
            }
            arr[i] = newS;
        }
        s += arr[i] + " ";
    }
    return s;
}

</script>
<?php
  include("drupal_header.php")
?>
<table id="ols_big_div">
<tr>
<td>
<!-- Left/Tree Box -->
<div class="ols_div1">
<div class="ols_div2">
<div class="ols_div3">
<div class="ols_div4">
<div id="ols_tree" class="treemenu">
<div id="ols_tree_title" class="ols_div3"></div>
<div class="ols_content_div" id="ols_tree_content_div"></div>
</div>
</div>
</div>
</div>
</div>
</td>
<td>
<div class="ols_right_wrap">
<!-- Right/Info Box -->
<div class="ols_div1" id="ols_information">
<div class="ols_div2">
<div class="ols_div3">
<div class="ols_div4">
<div class="ols_div3">Information</div>
<div id="ols_infoTable" class="ols_content_div">
<div class="ols_info"><span class="ols_info_left">ID:</span><span id="ols_info_id" class="ols_info_right"></span></div>
<div class="ols_info"><span class="ols_info_left">Name:</span><span id="ols_info_name" class="ols_info_right"></span></div>
<div class="ols_info"><span class="ols_info_left">Definition:</span><span id="ols_info_definition" class="ols_info_right"></span></div>
<div class="ols_info"><span class="ols_info_left">Relationship:</span><span id="ols_info_relationship" class="ols_info_right"></span></div>
</div>
</div>
</div>
</div>
</div>
<!-- Right/XML Box -->
<div class="ols_div1" id="ols_das">
<div class="ols_div2">
<div class="ols_div3">
<div class="ols_div4">
<div class="ols_div3">Gene Expression Data</div>
<div id="ols_dasTable" class="ols_content_div" class="yui-b">
</div>
</div>
</div>
</div>
</div>
<!-- Right/Features Box -->
<div class="ols_div1" id="ols_features">
<div class="ols_div2">
<div class="ols_div3">
<div class="ols_div4">
<div class="ols_div3">Associated Features</div>
<div id="ols_featureTable" class="ols_content_div" class="yui-b">
</div>
</div>
</div>
</div>
</div>
<!-- Right/Images Box -->
<div class="ols_div1" id="ols_images">
<div class="ols_div2">
<div class="ols_div3">
<div class="ols_div4">
<div class="ols_div3">Images</div>
<div id="ols_imageTable" class="ols_content_div" class="yui-b">
</div>
</div>
</div>
</div>
</div>
</div>
</td></tr></table>

<table id="ols_big_div"/td></tr></table>
<?php
  include("drupal_footer.php")
?>

<script type="text/javascript">
<?
if(isset($_GET['cv'])){
    phpGetToJS($_GET['cv'], "getCV");
    phpGettoJS($_GET['cv'], "CV_ID");
    if(isset($_GET['cvterm'])){
        phpGetToJS($_GET['cvterm'], "getCVTerm");
        print("cvFromGet(getCV, function() {FindCVTermInTreeByCVTermID(getCVTerm)});\n");
    } else {
        print("cvFromGet(getCV);\n");
    }
} else {
    print("window.crossBrowserListen(window, 'load', loadStart);");
}
?>
</script>
