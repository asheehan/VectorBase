//
// Definitions for schema: http://www.vectorbase.org
//  http://vanessa:8080/ols?xsd=1
//
//
// Constructor for XML Schema item {http://www.vectorbase.org}getCVTermAttributes
//
function getCVTermAttributes () {
    this.typeMarker = 'getCVTermAttributes';
    this._arg0 = 0;
    this._arg1 = 0;
}

//
// accessor is getCVTermAttributes.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getCVTermAttributes.prototype.setArg0
//
function getCVTermAttributes_getArg0() { return this._arg0;}

getCVTermAttributes.prototype.getArg0 = getCVTermAttributes_getArg0;

function getCVTermAttributes_setArg0(value) { this._arg0 = value;}

getCVTermAttributes.prototype.setArg0 = getCVTermAttributes_setArg0;
//
// accessor is getCVTermAttributes.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is getCVTermAttributes.prototype.setArg1
//
function getCVTermAttributes_getArg1() { return this._arg1;}

getCVTermAttributes.prototype.getArg1 = getCVTermAttributes_getArg1;

function getCVTermAttributes_setArg1(value) { this._arg1 = value;}

getCVTermAttributes.prototype.setArg1 = getCVTermAttributes_setArg1;
//
// Serialize {http://www.vectorbase.org}getCVTermAttributes
//
function getCVTermAttributes_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getCVTermAttributes.prototype.serialize = getCVTermAttributes_serialize;

function getCVTermAttributes_deserialize (cxfjsutils, element) {
    var newobject = new getCVTermAttributes();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}cvTermBean
//
function cvTermBean () {
    this.typeMarker = 'cvTermBean';
    this._cv = null;
    this._cvterm_id = null;
    this._dbxAccession = null;
    this._definition = null;
    this._name = null;
    this._parentCVTermID = null;
    this._relationship = [];
}

//
// accessor is cvTermBean.prototype.getCv
// element get for cv
// - element type is {http://www.vectorbase.org}cvBean
// - optional element
//
// element set for cv
// setter function is is cvTermBean.prototype.setCv
//
function cvTermBean_getCv() { return this._cv;}

cvTermBean.prototype.getCv = cvTermBean_getCv;

function cvTermBean_setCv(value) { this._cv = value;}

cvTermBean.prototype.setCv = cvTermBean_setCv;
//
// accessor is cvTermBean.prototype.getCvterm_id
// element get for cvterm_id
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - optional element
//
// element set for cvterm_id
// setter function is is cvTermBean.prototype.setCvterm_id
//
function cvTermBean_getCvterm_id() { return this._cvterm_id;}

cvTermBean.prototype.getCvterm_id = cvTermBean_getCvterm_id;

function cvTermBean_setCvterm_id(value) { this._cvterm_id = value;}

cvTermBean.prototype.setCvterm_id = cvTermBean_setCvterm_id;
//
// accessor is cvTermBean.prototype.getDbxAccession
// element get for dbxAccession
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for dbxAccession
// setter function is is cvTermBean.prototype.setDbxAccession
//
function cvTermBean_getDbxAccession() { return this._dbxAccession;}

cvTermBean.prototype.getDbxAccession = cvTermBean_getDbxAccession;

function cvTermBean_setDbxAccession(value) { this._dbxAccession = value;}

cvTermBean.prototype.setDbxAccession = cvTermBean_setDbxAccession;
//
// accessor is cvTermBean.prototype.getDefinition
// element get for definition
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for definition
// setter function is is cvTermBean.prototype.setDefinition
//
function cvTermBean_getDefinition() { return this._definition;}

cvTermBean.prototype.getDefinition = cvTermBean_getDefinition;

function cvTermBean_setDefinition(value) { this._definition = value;}

cvTermBean.prototype.setDefinition = cvTermBean_setDefinition;
//
// accessor is cvTermBean.prototype.getName
// element get for name
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for name
// setter function is is cvTermBean.prototype.setName
//
function cvTermBean_getName() { return this._name;}

cvTermBean.prototype.getName = cvTermBean_getName;

function cvTermBean_setName(value) { this._name = value;}

cvTermBean.prototype.setName = cvTermBean_setName;
//
// accessor is cvTermBean.prototype.getParentCVTermID
// element get for parentCVTermID
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - optional element
//
// element set for parentCVTermID
// setter function is is cvTermBean.prototype.setParentCVTermID
//
function cvTermBean_getParentCVTermID() { return this._parentCVTermID;}

cvTermBean.prototype.getParentCVTermID = cvTermBean_getParentCVTermID;

function cvTermBean_setParentCVTermID(value) { this._parentCVTermID = value;}

cvTermBean.prototype.setParentCVTermID = cvTermBean_setParentCVTermID;
//
// accessor is cvTermBean.prototype.getRelationship
// element get for relationship
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - required element
// - array
// - nillable
//
// element set for relationship
// setter function is is cvTermBean.prototype.setRelationship
//
function cvTermBean_getRelationship() { return this._relationship;}

cvTermBean.prototype.getRelationship = cvTermBean_getRelationship;

function cvTermBean_setRelationship(value) { this._relationship = value;}

cvTermBean.prototype.setRelationship = cvTermBean_setRelationship;
//
// Serialize {http://www.vectorbase.org}cvTermBean
//
function cvTermBean_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._cv != null) {
      xml = xml + this._cv.serialize(cxfjsutils, 'cv', null);
     }
    }
    // block for local variables
    {
     if (this._cvterm_id != null) {
      xml = xml + '<cvterm_id>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._cvterm_id);
      xml = xml + '</cvterm_id>';
     }
    }
    // block for local variables
    {
     if (this._dbxAccession != null) {
      xml = xml + '<dbxAccession>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._dbxAccession);
      xml = xml + '</dbxAccession>';
     }
    }
    // block for local variables
    {
     if (this._definition != null) {
      xml = xml + '<definition>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._definition);
      xml = xml + '</definition>';
     }
    }
    // block for local variables
    {
     if (this._name != null) {
      xml = xml + '<name>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._name);
      xml = xml + '</name>';
     }
    }
    // block for local variables
    {
     if (this._parentCVTermID != null) {
      xml = xml + '<parentCVTermID>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._parentCVTermID);
      xml = xml + '</parentCVTermID>';
     }
    }
    // block for local variables
    {
     if (this._relationship != null) {
      for (var ax = 0;ax < this._relationship.length;ax ++) {
       if (this._relationship[ax] == null) {
        xml = xml + '<relationship xsi:nil=\'true\'/>';
       } else {
        xml = xml + '<relationship>';
        xml = xml + cxfjsutils.escapeXmlEntities(this._relationship[ax]);
        xml = xml + '</relationship>';
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

cvTermBean.prototype.serialize = cvTermBean_serialize;

function cvTermBean_deserialize (cxfjsutils, element) {
    var newobject = new cvTermBean();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing cv');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'cv')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      item = cvBean_deserialize(cxfjsutils, curElement);
     }
     newobject.setCv(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing cvterm_id');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'cvterm_id')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = parseInt(value);
     }
     newobject.setCvterm_id(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing dbxAccession');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'dbxAccession')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setDbxAccession(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing definition');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'definition')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setDefinition(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing name');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'name')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setName(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing parentCVTermID');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'parentCVTermID')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = parseInt(value);
     }
     newobject.setParentCVTermID(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing relationship');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'relationship')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       value = cxfjsutils.getNodeText(curElement);
       arrayItem = value;
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'relationship'));
     newobject.setRelationship(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermInTreeResponse
//
function findCVTermInTreeResponse () {
    this.typeMarker = 'findCVTermInTreeResponse';
    this._return = [];
}

//
// accessor is findCVTermInTreeResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is findCVTermInTreeResponse.prototype.setReturn
//
function findCVTermInTreeResponse_getReturn() { return this._return;}

findCVTermInTreeResponse.prototype.getReturn = findCVTermInTreeResponse_getReturn;

function findCVTermInTreeResponse_setReturn(value) { this._return = value;}

findCVTermInTreeResponse.prototype.setReturn = findCVTermInTreeResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}findCVTermInTreeResponse
//
function findCVTermInTreeResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermInTreeResponse.prototype.serialize = findCVTermInTreeResponse_serialize;

function findCVTermInTreeResponse_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermInTreeResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getImageResponse
//
function getImageResponse () {
    this.typeMarker = 'getImageResponse';
    this._return = [];
}

//
// accessor is getImageResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}imageBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is getImageResponse.prototype.setReturn
//
function getImageResponse_getReturn() { return this._return;}

getImageResponse.prototype.getReturn = getImageResponse_getReturn;

function getImageResponse_setReturn(value) { this._return = value;}

getImageResponse.prototype.setReturn = getImageResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getImageResponse
//
function getImageResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getImageResponse.prototype.serialize = getImageResponse_serialize;

function getImageResponse_deserialize (cxfjsutils, element) {
    var newobject = new getImageResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = imageBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getTopLevelCVTermsByCVID
//
function getTopLevelCVTermsByCVID () {
    this.typeMarker = 'getTopLevelCVTermsByCVID';
    this._arg0 = 0;
}

//
// accessor is getTopLevelCVTermsByCVID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getTopLevelCVTermsByCVID.prototype.setArg0
//
function getTopLevelCVTermsByCVID_getArg0() { return this._arg0;}

getTopLevelCVTermsByCVID.prototype.getArg0 = getTopLevelCVTermsByCVID_getArg0;

function getTopLevelCVTermsByCVID_setArg0(value) { this._arg0 = value;}

getTopLevelCVTermsByCVID.prototype.setArg0 = getTopLevelCVTermsByCVID_setArg0;
//
// Serialize {http://www.vectorbase.org}getTopLevelCVTermsByCVID
//
function getTopLevelCVTermsByCVID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getTopLevelCVTermsByCVID.prototype.serialize = getTopLevelCVTermsByCVID_serialize;

function getTopLevelCVTermsByCVID_deserialize (cxfjsutils, element) {
    var newobject = new getTopLevelCVTermsByCVID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse
//
function getChildCVTermsByCVTermIDResponse () {
    this.typeMarker = 'getChildCVTermsByCVTermIDResponse';
    this._return = [];
}

//
// accessor is getChildCVTermsByCVTermIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is getChildCVTermsByCVTermIDResponse.prototype.setReturn
//
function getChildCVTermsByCVTermIDResponse_getReturn() { return this._return;}

getChildCVTermsByCVTermIDResponse.prototype.getReturn = getChildCVTermsByCVTermIDResponse_getReturn;

function getChildCVTermsByCVTermIDResponse_setReturn(value) { this._return = value;}

getChildCVTermsByCVTermIDResponse.prototype.setReturn = getChildCVTermsByCVTermIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse
//
function getChildCVTermsByCVTermIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getChildCVTermsByCVTermIDResponse.prototype.serialize = getChildCVTermsByCVTermIDResponse_serialize;

function getChildCVTermsByCVTermIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new getChildCVTermsByCVTermIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermInTreeByCVTermID
//
function findCVTermInTreeByCVTermID () {
    this.typeMarker = 'findCVTermInTreeByCVTermID';
    this._arg0 = 0;
    this._arg1 = 0;
}

//
// accessor is findCVTermInTreeByCVTermID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is findCVTermInTreeByCVTermID.prototype.setArg0
//
function findCVTermInTreeByCVTermID_getArg0() { return this._arg0;}

findCVTermInTreeByCVTermID.prototype.getArg0 = findCVTermInTreeByCVTermID_getArg0;

function findCVTermInTreeByCVTermID_setArg0(value) { this._arg0 = value;}

findCVTermInTreeByCVTermID.prototype.setArg0 = findCVTermInTreeByCVTermID_setArg0;
//
// accessor is findCVTermInTreeByCVTermID.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is findCVTermInTreeByCVTermID.prototype.setArg1
//
function findCVTermInTreeByCVTermID_getArg1() { return this._arg1;}

findCVTermInTreeByCVTermID.prototype.getArg1 = findCVTermInTreeByCVTermID_getArg1;

function findCVTermInTreeByCVTermID_setArg1(value) { this._arg1 = value;}

findCVTermInTreeByCVTermID.prototype.setArg1 = findCVTermInTreeByCVTermID_setArg1;
//
// Serialize {http://www.vectorbase.org}findCVTermInTreeByCVTermID
//
function findCVTermInTreeByCVTermID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermInTreeByCVTermID.prototype.serialize = findCVTermInTreeByCVTermID_serialize;

function findCVTermInTreeByCVTermID_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermInTreeByCVTermID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getFeaturesWithCVTermID
//
function getFeaturesWithCVTermID () {
    this.typeMarker = 'getFeaturesWithCVTermID';
    this._arg0 = 0;
    this._arg1 = 0;
}

//
// accessor is getFeaturesWithCVTermID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getFeaturesWithCVTermID.prototype.setArg0
//
function getFeaturesWithCVTermID_getArg0() { return this._arg0;}

getFeaturesWithCVTermID.prototype.getArg0 = getFeaturesWithCVTermID_getArg0;

function getFeaturesWithCVTermID_setArg0(value) { this._arg0 = value;}

getFeaturesWithCVTermID.prototype.setArg0 = getFeaturesWithCVTermID_setArg0;
//
// accessor is getFeaturesWithCVTermID.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is getFeaturesWithCVTermID.prototype.setArg1
//
function getFeaturesWithCVTermID_getArg1() { return this._arg1;}

getFeaturesWithCVTermID.prototype.getArg1 = getFeaturesWithCVTermID_getArg1;

function getFeaturesWithCVTermID_setArg1(value) { this._arg1 = value;}

getFeaturesWithCVTermID.prototype.setArg1 = getFeaturesWithCVTermID_setArg1;
//
// Serialize {http://www.vectorbase.org}getFeaturesWithCVTermID
//
function getFeaturesWithCVTermID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getFeaturesWithCVTermID.prototype.serialize = getFeaturesWithCVTermID_serialize;

function getFeaturesWithCVTermID_deserialize (cxfjsutils, element) {
    var newobject = new getFeaturesWithCVTermID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}cvBean
//
function cvBean () {
    this.typeMarker = 'cvBean';
    this._cv_id = null;
    this._name = null;
}

//
// accessor is cvBean.prototype.getCv_id
// element get for cv_id
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - optional element
//
// element set for cv_id
// setter function is is cvBean.prototype.setCv_id
//
function cvBean_getCv_id() { return this._cv_id;}

cvBean.prototype.getCv_id = cvBean_getCv_id;

function cvBean_setCv_id(value) { this._cv_id = value;}

cvBean.prototype.setCv_id = cvBean_setCv_id;
//
// accessor is cvBean.prototype.getName
// element get for name
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for name
// setter function is is cvBean.prototype.setName
//
function cvBean_getName() { return this._name;}

cvBean.prototype.getName = cvBean_getName;

function cvBean_setName(value) { this._name = value;}

cvBean.prototype.setName = cvBean_setName;
//
// Serialize {http://www.vectorbase.org}cvBean
//
function cvBean_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._cv_id != null) {
      xml = xml + '<cv_id>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._cv_id);
      xml = xml + '</cv_id>';
     }
    }
    // block for local variables
    {
     if (this._name != null) {
      xml = xml + '<name>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._name);
      xml = xml + '</name>';
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

cvBean.prototype.serialize = cvBean_serialize;

function cvBean_deserialize (cxfjsutils, element) {
    var newobject = new cvBean();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing cv_id');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'cv_id')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = parseInt(value);
     }
     newobject.setCv_id(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing name');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'name')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setName(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse
//
function findCVTermInTreeByCVTermIDResponse () {
    this.typeMarker = 'findCVTermInTreeByCVTermIDResponse';
    this._return = [];
}

//
// accessor is findCVTermInTreeByCVTermIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is findCVTermInTreeByCVTermIDResponse.prototype.setReturn
//
function findCVTermInTreeByCVTermIDResponse_getReturn() { return this._return;}

findCVTermInTreeByCVTermIDResponse.prototype.getReturn = findCVTermInTreeByCVTermIDResponse_getReturn;

function findCVTermInTreeByCVTermIDResponse_setReturn(value) { this._return = value;}

findCVTermInTreeByCVTermIDResponse.prototype.setReturn = findCVTermInTreeByCVTermIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse
//
function findCVTermInTreeByCVTermIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermInTreeByCVTermIDResponse.prototype.serialize = findCVTermInTreeByCVTermIDResponse_serialize;

function findCVTermInTreeByCVTermIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermInTreeByCVTermIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse
//
function findCVTermsBySearchTermAndCVIDResponse () {
    this.typeMarker = 'findCVTermsBySearchTermAndCVIDResponse';
    this._return = [];
}

//
// accessor is findCVTermsBySearchTermAndCVIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is findCVTermsBySearchTermAndCVIDResponse.prototype.setReturn
//
function findCVTermsBySearchTermAndCVIDResponse_getReturn() { return this._return;}

findCVTermsBySearchTermAndCVIDResponse.prototype.getReturn = findCVTermsBySearchTermAndCVIDResponse_getReturn;

function findCVTermsBySearchTermAndCVIDResponse_setReturn(value) { this._return = value;}

findCVTermsBySearchTermAndCVIDResponse.prototype.setReturn = findCVTermsBySearchTermAndCVIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse
//
function findCVTermsBySearchTermAndCVIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermsBySearchTermAndCVIDResponse.prototype.serialize = findCVTermsBySearchTermAndCVIDResponse_serialize;

function findCVTermsBySearchTermAndCVIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermsBySearchTermAndCVIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse
//
function getTopLevelCVTermsByCVIDResponse () {
    this.typeMarker = 'getTopLevelCVTermsByCVIDResponse';
    this._return = [];
}

//
// accessor is getTopLevelCVTermsByCVIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is getTopLevelCVTermsByCVIDResponse.prototype.setReturn
//
function getTopLevelCVTermsByCVIDResponse_getReturn() { return this._return;}

getTopLevelCVTermsByCVIDResponse.prototype.getReturn = getTopLevelCVTermsByCVIDResponse_getReturn;

function getTopLevelCVTermsByCVIDResponse_setReturn(value) { this._return = value;}

getTopLevelCVTermsByCVIDResponse.prototype.setReturn = getTopLevelCVTermsByCVIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse
//
function getTopLevelCVTermsByCVIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getTopLevelCVTermsByCVIDResponse.prototype.serialize = getTopLevelCVTermsByCVIDResponse_serialize;

function getTopLevelCVTermsByCVIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new getTopLevelCVTermsByCVIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}searchCVTermNameAndDefinition
//
function searchCVTermNameAndDefinition () {
    this.typeMarker = 'searchCVTermNameAndDefinition';
    this._arg0 = null;
    this._arg1 = 0;
    this._arg2 = 0;
}

//
// accessor is searchCVTermNameAndDefinition.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for arg0
// setter function is is searchCVTermNameAndDefinition.prototype.setArg0
//
function searchCVTermNameAndDefinition_getArg0() { return this._arg0;}

searchCVTermNameAndDefinition.prototype.getArg0 = searchCVTermNameAndDefinition_getArg0;

function searchCVTermNameAndDefinition_setArg0(value) { this._arg0 = value;}

searchCVTermNameAndDefinition.prototype.setArg0 = searchCVTermNameAndDefinition_setArg0;
//
// accessor is searchCVTermNameAndDefinition.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is searchCVTermNameAndDefinition.prototype.setArg1
//
function searchCVTermNameAndDefinition_getArg1() { return this._arg1;}

searchCVTermNameAndDefinition.prototype.getArg1 = searchCVTermNameAndDefinition_getArg1;

function searchCVTermNameAndDefinition_setArg1(value) { this._arg1 = value;}

searchCVTermNameAndDefinition.prototype.setArg1 = searchCVTermNameAndDefinition_setArg1;
//
// accessor is searchCVTermNameAndDefinition.prototype.getArg2
// element get for arg2
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg2
// setter function is is searchCVTermNameAndDefinition.prototype.setArg2
//
function searchCVTermNameAndDefinition_getArg2() { return this._arg2;}

searchCVTermNameAndDefinition.prototype.getArg2 = searchCVTermNameAndDefinition_getArg2;

function searchCVTermNameAndDefinition_setArg2(value) { this._arg2 = value;}

searchCVTermNameAndDefinition.prototype.setArg2 = searchCVTermNameAndDefinition_setArg2;
//
// Serialize {http://www.vectorbase.org}searchCVTermNameAndDefinition
//
function searchCVTermNameAndDefinition_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._arg0 != null) {
      xml = xml + '<arg0>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
      xml = xml + '</arg0>';
     }
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    // block for local variables
    {
     xml = xml + '<arg2>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg2);
     xml = xml + '</arg2>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

searchCVTermNameAndDefinition.prototype.serialize = searchCVTermNameAndDefinition_serialize;

function searchCVTermNameAndDefinition_deserialize (cxfjsutils, element) {
    var newobject = new searchCVTermNameAndDefinition();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'arg0')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setArg0(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg2');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg2(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getImage
//
function getImage () {
    this.typeMarker = 'getImage';
    this._arg0 = 0;
}

//
// accessor is getImage.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getImage.prototype.setArg0
//
function getImage_getArg0() { return this._arg0;}

getImage.prototype.getArg0 = getImage_getArg0;

function getImage_setArg0(value) { this._arg0 = value;}

getImage.prototype.setArg0 = getImage_setArg0;
//
// Serialize {http://www.vectorbase.org}getImage
//
function getImage_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getImage.prototype.serialize = getImage_serialize;

function getImage_deserialize (cxfjsutils, element) {
    var newobject = new getImage();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}imageBean
//
function imageBean () {
    this.typeMarker = 'imageBean';
    this._filename = null;
    this._type = null;
}

//
// accessor is imageBean.prototype.getFilename
// element get for filename
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for filename
// setter function is is imageBean.prototype.setFilename
//
function imageBean_getFilename() { return this._filename;}

imageBean.prototype.getFilename = imageBean_getFilename;

function imageBean_setFilename(value) { this._filename = value;}

imageBean.prototype.setFilename = imageBean_setFilename;
//
// accessor is imageBean.prototype.getType
// element get for type
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for type
// setter function is is imageBean.prototype.setType
//
function imageBean_getType() { return this._type;}

imageBean.prototype.getType = imageBean_getType;

function imageBean_setType(value) { this._type = value;}

imageBean.prototype.setType = imageBean_setType;
//
// Serialize {http://www.vectorbase.org}imageBean
//
function imageBean_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._filename != null) {
      xml = xml + '<filename>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._filename);
      xml = xml + '</filename>';
     }
    }
    // block for local variables
    {
     if (this._type != null) {
      xml = xml + '<type>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._type);
      xml = xml + '</type>';
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

imageBean.prototype.serialize = imageBean_serialize;

function imageBean_deserialize (cxfjsutils, element) {
    var newobject = new imageBean();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing filename');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'filename')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setFilename(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing type');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'type')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setType(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getDasWithCVTermIDResponse
//
function getDasWithCVTermIDResponse () {
    this.typeMarker = 'getDasWithCVTermIDResponse';
    this._return = [];
}

//
// accessor is getDasWithCVTermIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}dasBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is getDasWithCVTermIDResponse.prototype.setReturn
//
function getDasWithCVTermIDResponse_getReturn() { return this._return;}

getDasWithCVTermIDResponse.prototype.getReturn = getDasWithCVTermIDResponse_getReturn;

function getDasWithCVTermIDResponse_setReturn(value) { this._return = value;}

getDasWithCVTermIDResponse.prototype.setReturn = getDasWithCVTermIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getDasWithCVTermIDResponse
//
function getDasWithCVTermIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getDasWithCVTermIDResponse.prototype.serialize = getDasWithCVTermIDResponse_serialize;

function getDasWithCVTermIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new getDasWithCVTermIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = dasBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getCVTermAttributesResponse
//
function getCVTermAttributesResponse () {
    this.typeMarker = 'getCVTermAttributesResponse';
    this._return = null;
}

//
// accessor is getCVTermAttributesResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - optional element
//
// element set for return
// setter function is is getCVTermAttributesResponse.prototype.setReturn
//
function getCVTermAttributesResponse_getReturn() { return this._return;}

getCVTermAttributesResponse.prototype.getReturn = getCVTermAttributesResponse_getReturn;

function getCVTermAttributesResponse_setReturn(value) { this._return = value;}

getCVTermAttributesResponse.prototype.setReturn = getCVTermAttributesResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getCVTermAttributesResponse
//
function getCVTermAttributesResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      xml = xml + this._return.serialize(cxfjsutils, 'return', null);
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getCVTermAttributesResponse.prototype.serialize = getCVTermAttributesResponse_serialize;

function getCVTermAttributesResponse_deserialize (cxfjsutils, element) {
    var newobject = new getCVTermAttributesResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      item = cvTermBean_deserialize(cxfjsutils, curElement);
     }
     newobject.setReturn(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermsBySearchTermAndCVID
//
function findCVTermsBySearchTermAndCVID () {
    this.typeMarker = 'findCVTermsBySearchTermAndCVID';
    this._arg0 = null;
    this._arg1 = 0;
}

//
// accessor is findCVTermsBySearchTermAndCVID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for arg0
// setter function is is findCVTermsBySearchTermAndCVID.prototype.setArg0
//
function findCVTermsBySearchTermAndCVID_getArg0() { return this._arg0;}

findCVTermsBySearchTermAndCVID.prototype.getArg0 = findCVTermsBySearchTermAndCVID_getArg0;

function findCVTermsBySearchTermAndCVID_setArg0(value) { this._arg0 = value;}

findCVTermsBySearchTermAndCVID.prototype.setArg0 = findCVTermsBySearchTermAndCVID_setArg0;
//
// accessor is findCVTermsBySearchTermAndCVID.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is findCVTermsBySearchTermAndCVID.prototype.setArg1
//
function findCVTermsBySearchTermAndCVID_getArg1() { return this._arg1;}

findCVTermsBySearchTermAndCVID.prototype.getArg1 = findCVTermsBySearchTermAndCVID_getArg1;

function findCVTermsBySearchTermAndCVID_setArg1(value) { this._arg1 = value;}

findCVTermsBySearchTermAndCVID.prototype.setArg1 = findCVTermsBySearchTermAndCVID_setArg1;
//
// Serialize {http://www.vectorbase.org}findCVTermsBySearchTermAndCVID
//
function findCVTermsBySearchTermAndCVID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._arg0 != null) {
      xml = xml + '<arg0>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
      xml = xml + '</arg0>';
     }
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermsBySearchTermAndCVID.prototype.serialize = findCVTermsBySearchTermAndCVID_serialize;

function findCVTermsBySearchTermAndCVID_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermsBySearchTermAndCVID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'arg0')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setArg0(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}dasBean
//
function dasBean () {
    this.typeMarker = 'dasBean';
    this._label = null;
    this._link = null;
    this._linkText = null;
    this._name = null;
    this._note = null;
    this._type = null;
}

//
// accessor is dasBean.prototype.getLabel
// element get for label
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for label
// setter function is is dasBean.prototype.setLabel
//
function dasBean_getLabel() { return this._label;}

dasBean.prototype.getLabel = dasBean_getLabel;

function dasBean_setLabel(value) { this._label = value;}

dasBean.prototype.setLabel = dasBean_setLabel;
//
// accessor is dasBean.prototype.getLink
// element get for link
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for link
// setter function is is dasBean.prototype.setLink
//
function dasBean_getLink() { return this._link;}

dasBean.prototype.getLink = dasBean_getLink;

function dasBean_setLink(value) { this._link = value;}

dasBean.prototype.setLink = dasBean_setLink;
//
// accessor is dasBean.prototype.getLinkText
// element get for linkText
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for linkText
// setter function is is dasBean.prototype.setLinkText
//
function dasBean_getLinkText() { return this._linkText;}

dasBean.prototype.getLinkText = dasBean_getLinkText;

function dasBean_setLinkText(value) { this._linkText = value;}

dasBean.prototype.setLinkText = dasBean_setLinkText;
//
// accessor is dasBean.prototype.getName
// element get for name
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for name
// setter function is is dasBean.prototype.setName
//
function dasBean_getName() { return this._name;}

dasBean.prototype.getName = dasBean_getName;

function dasBean_setName(value) { this._name = value;}

dasBean.prototype.setName = dasBean_setName;
//
// accessor is dasBean.prototype.getNote
// element get for note
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for note
// setter function is is dasBean.prototype.setNote
//
function dasBean_getNote() { return this._note;}

dasBean.prototype.getNote = dasBean_getNote;

function dasBean_setNote(value) { this._note = value;}

dasBean.prototype.setNote = dasBean_setNote;
//
// accessor is dasBean.prototype.getType
// element get for type
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for type
// setter function is is dasBean.prototype.setType
//
function dasBean_getType() { return this._type;}

dasBean.prototype.getType = dasBean_getType;

function dasBean_setType(value) { this._type = value;}

dasBean.prototype.setType = dasBean_setType;
//
// Serialize {http://www.vectorbase.org}dasBean
//
function dasBean_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._label != null) {
      xml = xml + '<label>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._label);
      xml = xml + '</label>';
     }
    }
    // block for local variables
    {
     if (this._link != null) {
      xml = xml + '<link>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._link);
      xml = xml + '</link>';
     }
    }
    // block for local variables
    {
     if (this._linkText != null) {
      xml = xml + '<linkText>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._linkText);
      xml = xml + '</linkText>';
     }
    }
    // block for local variables
    {
     if (this._name != null) {
      xml = xml + '<name>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._name);
      xml = xml + '</name>';
     }
    }
    // block for local variables
    {
     if (this._note != null) {
      xml = xml + '<note>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._note);
      xml = xml + '</note>';
     }
    }
    // block for local variables
    {
     if (this._type != null) {
      xml = xml + '<type>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._type);
      xml = xml + '</type>';
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

dasBean.prototype.serialize = dasBean_serialize;

function dasBean_deserialize (cxfjsutils, element) {
    var newobject = new dasBean();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing label');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'label')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setLabel(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing link');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'link')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setLink(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing linkText');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'linkText')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setLinkText(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing name');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'name')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setName(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing note');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'note')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setNote(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing type');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'type')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setType(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getChildCVTermsByCVTermID
//
function getChildCVTermsByCVTermID () {
    this.typeMarker = 'getChildCVTermsByCVTermID';
    this._arg0 = 0;
    this._arg1 = 0;
}

//
// accessor is getChildCVTermsByCVTermID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getChildCVTermsByCVTermID.prototype.setArg0
//
function getChildCVTermsByCVTermID_getArg0() { return this._arg0;}

getChildCVTermsByCVTermID.prototype.getArg0 = getChildCVTermsByCVTermID_getArg0;

function getChildCVTermsByCVTermID_setArg0(value) { this._arg0 = value;}

getChildCVTermsByCVTermID.prototype.setArg0 = getChildCVTermsByCVTermID_setArg0;
//
// accessor is getChildCVTermsByCVTermID.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is getChildCVTermsByCVTermID.prototype.setArg1
//
function getChildCVTermsByCVTermID_getArg1() { return this._arg1;}

getChildCVTermsByCVTermID.prototype.getArg1 = getChildCVTermsByCVTermID_getArg1;

function getChildCVTermsByCVTermID_setArg1(value) { this._arg1 = value;}

getChildCVTermsByCVTermID.prototype.setArg1 = getChildCVTermsByCVTermID_setArg1;
//
// Serialize {http://www.vectorbase.org}getChildCVTermsByCVTermID
//
function getChildCVTermsByCVTermID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getChildCVTermsByCVTermID.prototype.serialize = getChildCVTermsByCVTermID_serialize;

function getChildCVTermsByCVTermID_deserialize (cxfjsutils, element) {
    var newobject = new getChildCVTermsByCVTermID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getDasWithCVTermID
//
function getDasWithCVTermID () {
    this.typeMarker = 'getDasWithCVTermID';
    this._arg0 = 0;
}

//
// accessor is getDasWithCVTermID.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg0
// setter function is is getDasWithCVTermID.prototype.setArg0
//
function getDasWithCVTermID_getArg0() { return this._arg0;}

getDasWithCVTermID.prototype.getArg0 = getDasWithCVTermID_getArg0;

function getDasWithCVTermID_setArg0(value) { this._arg0 = value;}

getDasWithCVTermID.prototype.setArg0 = getDasWithCVTermID_setArg0;
//
// Serialize {http://www.vectorbase.org}getDasWithCVTermID
//
function getDasWithCVTermID_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<arg0>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
     xml = xml + '</arg0>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getDasWithCVTermID.prototype.serialize = getDasWithCVTermID_serialize;

function getDasWithCVTermID_deserialize (cxfjsutils, element) {
    var newobject = new getDasWithCVTermID();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg0(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}getFeaturesWithCVTermIDResponse
//
function getFeaturesWithCVTermIDResponse () {
    this.typeMarker = 'getFeaturesWithCVTermIDResponse';
    this._return = [];
}

//
// accessor is getFeaturesWithCVTermIDResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}featureBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is getFeaturesWithCVTermIDResponse.prototype.setReturn
//
function getFeaturesWithCVTermIDResponse_getReturn() { return this._return;}

getFeaturesWithCVTermIDResponse.prototype.getReturn = getFeaturesWithCVTermIDResponse_getReturn;

function getFeaturesWithCVTermIDResponse_setReturn(value) { this._return = value;}

getFeaturesWithCVTermIDResponse.prototype.setReturn = getFeaturesWithCVTermIDResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}getFeaturesWithCVTermIDResponse
//
function getFeaturesWithCVTermIDResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

getFeaturesWithCVTermIDResponse.prototype.serialize = getFeaturesWithCVTermIDResponse_serialize;

function getFeaturesWithCVTermIDResponse_deserialize (cxfjsutils, element) {
    var newobject = new getFeaturesWithCVTermIDResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = featureBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse
//
function searchCVTermNameAndDefinitionResponse () {
    this.typeMarker = 'searchCVTermNameAndDefinitionResponse';
    this._return = [];
}

//
// accessor is searchCVTermNameAndDefinitionResponse.prototype.getReturn
// element get for return
// - element type is {http://www.vectorbase.org}cvTermBean
// - required element
// - array
// - nillable
//
// element set for return
// setter function is is searchCVTermNameAndDefinitionResponse.prototype.setReturn
//
function searchCVTermNameAndDefinitionResponse_getReturn() { return this._return;}

searchCVTermNameAndDefinitionResponse.prototype.getReturn = searchCVTermNameAndDefinitionResponse_getReturn;

function searchCVTermNameAndDefinitionResponse_setReturn(value) { this._return = value;}

searchCVTermNameAndDefinitionResponse.prototype.setReturn = searchCVTermNameAndDefinitionResponse_setReturn;
//
// Serialize {http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse
//
function searchCVTermNameAndDefinitionResponse_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._return != null) {
      for (var ax = 0;ax < this._return.length;ax ++) {
       if (this._return[ax] == null) {
        xml = xml + '<return xsi:nil=\'true\'/>';
       } else {
        xml = xml + this._return[ax].serialize(cxfjsutils, 'return', null);
       }
      }
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

searchCVTermNameAndDefinitionResponse.prototype.serialize = searchCVTermNameAndDefinitionResponse_serialize;

function searchCVTermNameAndDefinitionResponse_deserialize (cxfjsutils, element) {
    var newobject = new searchCVTermNameAndDefinitionResponse();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing return');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return')) {
     item = [];
     do  {
      var arrayItem;
      var value = null;
      if (!cxfjsutils.isElementNil(curElement)) {
       arrayItem = cvTermBean_deserialize(cxfjsutils, curElement);
      }
      item.push(arrayItem);
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
       while(curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'return'));
     newobject.setReturn(item);
     var item = null;
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}findCVTermInTree
//
function findCVTermInTree () {
    this.typeMarker = 'findCVTermInTree';
    this._arg0 = null;
    this._arg1 = 0;
}

//
// accessor is findCVTermInTree.prototype.getArg0
// element get for arg0
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for arg0
// setter function is is findCVTermInTree.prototype.setArg0
//
function findCVTermInTree_getArg0() { return this._arg0;}

findCVTermInTree.prototype.getArg0 = findCVTermInTree_getArg0;

function findCVTermInTree_setArg0(value) { this._arg0 = value;}

findCVTermInTree.prototype.setArg0 = findCVTermInTree_setArg0;
//
// accessor is findCVTermInTree.prototype.getArg1
// element get for arg1
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for arg1
// setter function is is findCVTermInTree.prototype.setArg1
//
function findCVTermInTree_getArg1() { return this._arg1;}

findCVTermInTree.prototype.getArg1 = findCVTermInTree_getArg1;

function findCVTermInTree_setArg1(value) { this._arg1 = value;}

findCVTermInTree.prototype.setArg1 = findCVTermInTree_setArg1;
//
// Serialize {http://www.vectorbase.org}findCVTermInTree
//
function findCVTermInTree_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     if (this._arg0 != null) {
      xml = xml + '<arg0>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._arg0);
      xml = xml + '</arg0>';
     }
    }
    // block for local variables
    {
     xml = xml + '<arg1>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._arg1);
     xml = xml + '</arg1>';
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

findCVTermInTree.prototype.serialize = findCVTermInTree_serialize;

function findCVTermInTree_deserialize (cxfjsutils, element) {
    var newobject = new findCVTermInTree();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg0');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'arg0')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setArg0(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing arg1');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setArg1(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    return newobject;
}

//
// Constructor for XML Schema item {http://www.vectorbase.org}featureBean
//
function featureBean () {
    this.typeMarker = 'featureBean';
    this._feature_id = 0;
    this._name = null;
    this._organism_genus = null;
    this._organism_species = null;
    this._type = null;
}

//
// accessor is featureBean.prototype.getFeature_id
// element get for feature_id
// - element type is {http://www.w3.org/2001/XMLSchema}int
// - required element
//
// element set for feature_id
// setter function is is featureBean.prototype.setFeature_id
//
function featureBean_getFeature_id() { return this._feature_id;}

featureBean.prototype.getFeature_id = featureBean_getFeature_id;

function featureBean_setFeature_id(value) { this._feature_id = value;}

featureBean.prototype.setFeature_id = featureBean_setFeature_id;
//
// accessor is featureBean.prototype.getName
// element get for name
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for name
// setter function is is featureBean.prototype.setName
//
function featureBean_getName() { return this._name;}

featureBean.prototype.getName = featureBean_getName;

function featureBean_setName(value) { this._name = value;}

featureBean.prototype.setName = featureBean_setName;
//
// accessor is featureBean.prototype.getOrganism_genus
// element get for organism_genus
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for organism_genus
// setter function is is featureBean.prototype.setOrganism_genus
//
function featureBean_getOrganism_genus() { return this._organism_genus;}

featureBean.prototype.getOrganism_genus = featureBean_getOrganism_genus;

function featureBean_setOrganism_genus(value) { this._organism_genus = value;}

featureBean.prototype.setOrganism_genus = featureBean_setOrganism_genus;
//
// accessor is featureBean.prototype.getOrganism_species
// element get for organism_species
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for organism_species
// setter function is is featureBean.prototype.setOrganism_species
//
function featureBean_getOrganism_species() { return this._organism_species;}

featureBean.prototype.getOrganism_species = featureBean_getOrganism_species;

function featureBean_setOrganism_species(value) { this._organism_species = value;}

featureBean.prototype.setOrganism_species = featureBean_setOrganism_species;
//
// accessor is featureBean.prototype.getType
// element get for type
// - element type is {http://www.w3.org/2001/XMLSchema}string
// - optional element
//
// element set for type
// setter function is is featureBean.prototype.setType
//
function featureBean_getType() { return this._type;}

featureBean.prototype.getType = featureBean_getType;

function featureBean_setType(value) { this._type = value;}

featureBean.prototype.setType = featureBean_setType;
//
// Serialize {http://www.vectorbase.org}featureBean
//
function featureBean_serialize(cxfjsutils, elementName, extraNamespaces) {
    var xml = '';
    if (elementName != null) {
     xml = xml + '<';
     xml = xml + elementName;
     if (extraNamespaces) {
      xml = xml + ' ' + extraNamespaces;
     }
     xml = xml + '>';
    }
    // block for local variables
    {
     xml = xml + '<feature_id>';
     xml = xml + cxfjsutils.escapeXmlEntities(this._feature_id);
     xml = xml + '</feature_id>';
    }
    // block for local variables
    {
     if (this._name != null) {
      xml = xml + '<name>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._name);
      xml = xml + '</name>';
     }
    }
    // block for local variables
    {
     if (this._organism_genus != null) {
      xml = xml + '<organism_genus>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._organism_genus);
      xml = xml + '</organism_genus>';
     }
    }
    // block for local variables
    {
     if (this._organism_species != null) {
      xml = xml + '<organism_species>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._organism_species);
      xml = xml + '</organism_species>';
     }
    }
    // block for local variables
    {
     if (this._type != null) {
      xml = xml + '<type>';
      xml = xml + cxfjsutils.escapeXmlEntities(this._type);
      xml = xml + '</type>';
     }
    }
    if (elementName != null) {
     xml = xml + '</';
     xml = xml + elementName;
     xml = xml + '>';
    }
    return xml;
}

featureBean.prototype.serialize = featureBean_serialize;

function featureBean_deserialize (cxfjsutils, element) {
    var newobject = new featureBean();
    cxfjsutils.trace('element: ' + cxfjsutils.traceElementName(element));
    var curElement = cxfjsutils.getFirstElementChild(element);
    var item;
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing feature_id');
    var value = null;
    if (!cxfjsutils.isElementNil(curElement)) {
     value = cxfjsutils.getNodeText(curElement);
     item = parseInt(value);
    }
    newobject.setFeature_id(item);
    var item = null;
    if (curElement != null) {
     curElement = cxfjsutils.getNextElementSibling(curElement);
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing name');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'name')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setName(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing organism_genus');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'organism_genus')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setOrganism_genus(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing organism_species');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'organism_species')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setOrganism_species(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    cxfjsutils.trace('curElement: ' + cxfjsutils.traceElementName(curElement));
    cxfjsutils.trace('processing type');
    if (curElement != null && cxfjsutils.isNodeNamedNS(curElement, '', 'type')) {
     var value = null;
     if (!cxfjsutils.isElementNil(curElement)) {
      value = cxfjsutils.getNodeText(curElement);
      item = value;
     }
     newobject.setType(item);
     var item = null;
     if (curElement != null) {
      curElement = cxfjsutils.getNextElementSibling(curElement);
     }
    }
    return newobject;
}

//
// Definitions for schema: null
//  http://vanessa:8080/ols?wsdl#types1
//
//
// Definitions for service: {http://www.vectorbase.org}OlsObjectService
//

// Javascript for {http://www.vectorbase.org}ols

function ols () {
    this.jsutils = new CxfApacheOrgUtil();
    this.jsutils.interfaceObject = this;
    this.synchronous = false;
    this.url = null;
    this.client = null;
    this.response = null;
    this.globalElementSerializers = [];
    this.globalElementDeserializers = [];
    this.globalElementSerializers['{http://www.vectorbase.org}getDasWithCVTermIDResponse'] = getDasWithCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getDasWithCVTermIDResponse'] = getDasWithCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getCVTermAttributes'] = getCVTermAttributes_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getCVTermAttributes'] = getCVTermAttributes_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getCVTermAttributesResponse'] = getCVTermAttributesResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getCVTermAttributesResponse'] = getCVTermAttributesResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVID'] = findCVTermsBySearchTermAndCVID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVID'] = findCVTermsBySearchTermAndCVID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeResponse'] = findCVTermInTreeResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeResponse'] = findCVTermInTreeResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getImageResponse'] = getImageResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getImageResponse'] = getImageResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVID'] = getTopLevelCVTermsByCVID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVID'] = getTopLevelCVTermsByCVID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getChildCVTermsByCVTermID'] = getChildCVTermsByCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getChildCVTermsByCVTermID'] = getChildCVTermsByCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getDasWithCVTermID'] = getDasWithCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getDasWithCVTermID'] = getDasWithCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse'] = getChildCVTermsByCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse'] = getChildCVTermsByCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermID'] = findCVTermInTreeByCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermID'] = findCVTermInTreeByCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getFeaturesWithCVTermIDResponse'] = getFeaturesWithCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getFeaturesWithCVTermIDResponse'] = getFeaturesWithCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getFeaturesWithCVTermID'] = getFeaturesWithCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getFeaturesWithCVTermID'] = getFeaturesWithCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse'] = findCVTermInTreeByCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse'] = findCVTermInTreeByCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse'] = searchCVTermNameAndDefinitionResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse'] = searchCVTermNameAndDefinitionResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse'] = findCVTermsBySearchTermAndCVIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse'] = findCVTermsBySearchTermAndCVIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse'] = getTopLevelCVTermsByCVIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse'] = getTopLevelCVTermsByCVIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}searchCVTermNameAndDefinition'] = searchCVTermNameAndDefinition_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}searchCVTermNameAndDefinition'] = searchCVTermNameAndDefinition_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTree'] = findCVTermInTree_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTree'] = findCVTermInTree_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getImage'] = getImage_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getImage'] = getImage_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getCVTermAttributes'] = getCVTermAttributes_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getCVTermAttributes'] = getCVTermAttributes_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}cvTermBean'] = cvTermBean_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}cvTermBean'] = cvTermBean_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeResponse'] = findCVTermInTreeResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeResponse'] = findCVTermInTreeResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getImageResponse'] = getImageResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getImageResponse'] = getImageResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVID'] = getTopLevelCVTermsByCVID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVID'] = getTopLevelCVTermsByCVID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse'] = getChildCVTermsByCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getChildCVTermsByCVTermIDResponse'] = getChildCVTermsByCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermID'] = findCVTermInTreeByCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermID'] = findCVTermInTreeByCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getFeaturesWithCVTermID'] = getFeaturesWithCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getFeaturesWithCVTermID'] = getFeaturesWithCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}cvBean'] = cvBean_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}cvBean'] = cvBean_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse'] = findCVTermInTreeByCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTreeByCVTermIDResponse'] = findCVTermInTreeByCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse'] = findCVTermsBySearchTermAndCVIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVIDResponse'] = findCVTermsBySearchTermAndCVIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse'] = getTopLevelCVTermsByCVIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getTopLevelCVTermsByCVIDResponse'] = getTopLevelCVTermsByCVIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}searchCVTermNameAndDefinition'] = searchCVTermNameAndDefinition_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}searchCVTermNameAndDefinition'] = searchCVTermNameAndDefinition_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getImage'] = getImage_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getImage'] = getImage_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}imageBean'] = imageBean_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}imageBean'] = imageBean_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getDasWithCVTermIDResponse'] = getDasWithCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getDasWithCVTermIDResponse'] = getDasWithCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getCVTermAttributesResponse'] = getCVTermAttributesResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getCVTermAttributesResponse'] = getCVTermAttributesResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVID'] = findCVTermsBySearchTermAndCVID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermsBySearchTermAndCVID'] = findCVTermsBySearchTermAndCVID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}dasBean'] = dasBean_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}dasBean'] = dasBean_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getChildCVTermsByCVTermID'] = getChildCVTermsByCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getChildCVTermsByCVTermID'] = getChildCVTermsByCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getDasWithCVTermID'] = getDasWithCVTermID_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getDasWithCVTermID'] = getDasWithCVTermID_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}getFeaturesWithCVTermIDResponse'] = getFeaturesWithCVTermIDResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}getFeaturesWithCVTermIDResponse'] = getFeaturesWithCVTermIDResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse'] = searchCVTermNameAndDefinitionResponse_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}searchCVTermNameAndDefinitionResponse'] = searchCVTermNameAndDefinitionResponse_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}findCVTermInTree'] = findCVTermInTree_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}findCVTermInTree'] = findCVTermInTree_deserialize;
    this.globalElementSerializers['{http://www.vectorbase.org}featureBean'] = featureBean_serialize;
    this.globalElementDeserializers['{http://www.vectorbase.org}featureBean'] = featureBean_deserialize;
}

function getChildCVTermsByCVTermID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getChildCVTermsByCVTermIDResponse_deserializeResponse');
     responseObject = getChildCVTermsByCVTermIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getChildCVTermsByCVTermID_onsuccess = getChildCVTermsByCVTermID_op_onsuccess;

function getChildCVTermsByCVTermID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getChildCVTermsByCVTermID_onerror = getChildCVTermsByCVTermID_op_onerror;

//
// Operation {http://www.vectorbase.org}getChildCVTermsByCVTermID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getChildCVTermsByCVTermID_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.getChildCVTermsByCVTermID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getChildCVTermsByCVTermID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getChildCVTermsByCVTermID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getChildCVTermsByCVTermID = getChildCVTermsByCVTermID_op;

function getChildCVTermsByCVTermID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getChildCVTermsByCVTermID();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getChildCVTermsByCVTermID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getChildCVTermsByCVTermID_serializeInput = getChildCVTermsByCVTermID_serializeInput;

function getChildCVTermsByCVTermIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getChildCVTermsByCVTermIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function getTopLevelCVTermsByCVID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getTopLevelCVTermsByCVIDResponse_deserializeResponse');
     responseObject = getTopLevelCVTermsByCVIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getTopLevelCVTermsByCVID_onsuccess = getTopLevelCVTermsByCVID_op_onsuccess;

function getTopLevelCVTermsByCVID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getTopLevelCVTermsByCVID_onerror = getTopLevelCVTermsByCVID_op_onerror;

//
// Operation {http://www.vectorbase.org}getTopLevelCVTermsByCVID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getTopLevelCVTermsByCVID_op(successCallback, errorCallback, arg0) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(1);
    args[0] = arg0;
    xml = this.getTopLevelCVTermsByCVID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getTopLevelCVTermsByCVID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getTopLevelCVTermsByCVID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getTopLevelCVTermsByCVID = getTopLevelCVTermsByCVID_op;

function getTopLevelCVTermsByCVID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getTopLevelCVTermsByCVID();
    wrapperObj.setArg0(args[0]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getTopLevelCVTermsByCVID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getTopLevelCVTermsByCVID_serializeInput = getTopLevelCVTermsByCVID_serializeInput;

function getTopLevelCVTermsByCVIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getTopLevelCVTermsByCVIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function findCVTermInTree_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling findCVTermInTreeResponse_deserializeResponse');
     responseObject = findCVTermInTreeResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.findCVTermInTree_onsuccess = findCVTermInTree_op_onsuccess;

function findCVTermInTree_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.findCVTermInTree_onerror = findCVTermInTree_op_onerror;

//
// Operation {http://www.vectorbase.org}findCVTermInTree
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}string// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function findCVTermInTree_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.findCVTermInTree_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.findCVTermInTree_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.findCVTermInTree_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.findCVTermInTree = findCVTermInTree_op;

function findCVTermInTree_serializeInput(cxfjsutils, args) {
    var wrapperObj = new findCVTermInTree();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:findCVTermInTree', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.findCVTermInTree_serializeInput = findCVTermInTree_serializeInput;

function findCVTermInTreeResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = findCVTermInTreeResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function findCVTermsBySearchTermAndCVID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling findCVTermsBySearchTermAndCVIDResponse_deserializeResponse');
     responseObject = findCVTermsBySearchTermAndCVIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.findCVTermsBySearchTermAndCVID_onsuccess = findCVTermsBySearchTermAndCVID_op_onsuccess;

function findCVTermsBySearchTermAndCVID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.findCVTermsBySearchTermAndCVID_onerror = findCVTermsBySearchTermAndCVID_op_onerror;

//
// Operation {http://www.vectorbase.org}findCVTermsBySearchTermAndCVID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}string// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function findCVTermsBySearchTermAndCVID_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.findCVTermsBySearchTermAndCVID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.findCVTermsBySearchTermAndCVID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.findCVTermsBySearchTermAndCVID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.findCVTermsBySearchTermAndCVID = findCVTermsBySearchTermAndCVID_op;

function findCVTermsBySearchTermAndCVID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new findCVTermsBySearchTermAndCVID();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:findCVTermsBySearchTermAndCVID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.findCVTermsBySearchTermAndCVID_serializeInput = findCVTermsBySearchTermAndCVID_serializeInput;

function findCVTermsBySearchTermAndCVIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = findCVTermsBySearchTermAndCVIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function getImage_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getImageResponse_deserializeResponse');
     responseObject = getImageResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getImage_onsuccess = getImage_op_onsuccess;

function getImage_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getImage_onerror = getImage_op_onerror;

//
// Operation {http://www.vectorbase.org}getImage
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getImage_op(successCallback, errorCallback, arg0) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(1);
    args[0] = arg0;
    xml = this.getImage_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getImage_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getImage_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getImage = getImage_op;

function getImage_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getImage();
    wrapperObj.setArg0(args[0]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getImage', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getImage_serializeInput = getImage_serializeInput;

function getImageResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getImageResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function getCVTermAttributes_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getCVTermAttributesResponse_deserializeResponse');
     responseObject = getCVTermAttributesResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getCVTermAttributes_onsuccess = getCVTermAttributes_op_onsuccess;

function getCVTermAttributes_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getCVTermAttributes_onerror = getCVTermAttributes_op_onerror;

//
// Operation {http://www.vectorbase.org}getCVTermAttributes
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getCVTermAttributes_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.getCVTermAttributes_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getCVTermAttributes_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getCVTermAttributes_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getCVTermAttributes = getCVTermAttributes_op;

function getCVTermAttributes_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getCVTermAttributes();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getCVTermAttributes', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getCVTermAttributes_serializeInput = getCVTermAttributes_serializeInput;

function getCVTermAttributesResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getCVTermAttributesResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function getFeaturesWithCVTermID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getFeaturesWithCVTermIDResponse_deserializeResponse');
     responseObject = getFeaturesWithCVTermIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getFeaturesWithCVTermID_onsuccess = getFeaturesWithCVTermID_op_onsuccess;

function getFeaturesWithCVTermID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getFeaturesWithCVTermID_onerror = getFeaturesWithCVTermID_op_onerror;

//
// Operation {http://www.vectorbase.org}getFeaturesWithCVTermID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getFeaturesWithCVTermID_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.getFeaturesWithCVTermID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getFeaturesWithCVTermID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getFeaturesWithCVTermID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getFeaturesWithCVTermID = getFeaturesWithCVTermID_op;

function getFeaturesWithCVTermID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getFeaturesWithCVTermID();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getFeaturesWithCVTermID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getFeaturesWithCVTermID_serializeInput = getFeaturesWithCVTermID_serializeInput;

function getFeaturesWithCVTermIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getFeaturesWithCVTermIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function getDasWithCVTermID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling getDasWithCVTermIDResponse_deserializeResponse');
     responseObject = getDasWithCVTermIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.getDasWithCVTermID_onsuccess = getDasWithCVTermID_op_onsuccess;

function getDasWithCVTermID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.getDasWithCVTermID_onerror = getDasWithCVTermID_op_onerror;

//
// Operation {http://www.vectorbase.org}getDasWithCVTermID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function getDasWithCVTermID_op(successCallback, errorCallback, arg0) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(1);
    args[0] = arg0;
    xml = this.getDasWithCVTermID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.getDasWithCVTermID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.getDasWithCVTermID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.getDasWithCVTermID = getDasWithCVTermID_op;

function getDasWithCVTermID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new getDasWithCVTermID();
    wrapperObj.setArg0(args[0]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:getDasWithCVTermID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.getDasWithCVTermID_serializeInput = getDasWithCVTermID_serializeInput;

function getDasWithCVTermIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = getDasWithCVTermIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function searchCVTermNameAndDefinition_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling searchCVTermNameAndDefinitionResponse_deserializeResponse');
     responseObject = searchCVTermNameAndDefinitionResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.searchCVTermNameAndDefinition_onsuccess = searchCVTermNameAndDefinition_op_onsuccess;

function searchCVTermNameAndDefinition_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.searchCVTermNameAndDefinition_onerror = searchCVTermNameAndDefinition_op_onerror;

//
// Operation {http://www.vectorbase.org}searchCVTermNameAndDefinition
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}string// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int// parameter arg2
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function searchCVTermNameAndDefinition_op(successCallback, errorCallback, arg0, arg1, arg2) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(3);
    args[0] = arg0;
    args[1] = arg1;
    args[2] = arg2;
    xml = this.searchCVTermNameAndDefinition_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.searchCVTermNameAndDefinition_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.searchCVTermNameAndDefinition_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.searchCVTermNameAndDefinition = searchCVTermNameAndDefinition_op;

function searchCVTermNameAndDefinition_serializeInput(cxfjsutils, args) {
    var wrapperObj = new searchCVTermNameAndDefinition();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    wrapperObj.setArg2(args[2]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:searchCVTermNameAndDefinition', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.searchCVTermNameAndDefinition_serializeInput = searchCVTermNameAndDefinition_serializeInput;

function searchCVTermNameAndDefinitionResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = searchCVTermNameAndDefinitionResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function findCVTermInTreeByCVTermID_op_onsuccess(client, responseXml) {
    if (client.user_onsuccess) {
     var responseObject = null;
     var element = responseXml.documentElement;
     this.jsutils.trace('responseXml: ' + this.jsutils.traceElementName(element));
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('first element child: ' + this.jsutils.traceElementName(element));
     while (!this.jsutils.isNodeNamedNS(element, 'http://schemas.xmlsoap.org/soap/envelope/', 'Body')) {
      element = this.jsutils.getNextElementSibling(element);
      if (element == null) {
       throw 'No env:Body in message.'
      }
     }
     element = this.jsutils.getFirstElementChild(element);
     this.jsutils.trace('part element: ' + this.jsutils.traceElementName(element));
     this.jsutils.trace('calling findCVTermInTreeByCVTermIDResponse_deserializeResponse');
     responseObject = findCVTermInTreeByCVTermIDResponse_deserializeResponse(this.jsutils, element);
     client.user_onsuccess(responseObject);
    }
}

ols.prototype.findCVTermInTreeByCVTermID_onsuccess = findCVTermInTreeByCVTermID_op_onsuccess;

function findCVTermInTreeByCVTermID_op_onerror(client) {
    if (client.user_onerror) {
     var httpStatus;
     var httpStatusText;
     try {
      httpStatus = client.req.status;
      httpStatusText = client.req.statusText;
     } catch(e) {
      httpStatus = -1;
      httpStatusText = 'Error opening connection to server';
     }
     client.user_onerror(httpStatus, httpStatusText);
    }
}

ols.prototype.findCVTermInTreeByCVTermID_onerror = findCVTermInTreeByCVTermID_op_onerror;

//
// Operation {http://www.vectorbase.org}findCVTermInTreeByCVTermID
// Wrapped operation.
// parameter arg0
// - simple type {http://www.w3.org/2001/XMLSchema}int// parameter arg1
// - simple type {http://www.w3.org/2001/XMLSchema}int//
function findCVTermInTreeByCVTermID_op(successCallback, errorCallback, arg0, arg1) {
    this.client = new CxfApacheOrgClient(this.jsutils);
    var xml = null;
    var args = new Array(2);
    args[0] = arg0;
    args[1] = arg1;
    xml = this.findCVTermInTreeByCVTermID_serializeInput(this.jsutils, args);
    this.client.user_onsuccess = successCallback;
    this.client.user_onerror = errorCallback;
    var closureThis = this;
    this.client.onsuccess = function(client, responseXml) { closureThis.findCVTermInTreeByCVTermID_onsuccess(client, responseXml); };
    this.client.onerror = function(client) { closureThis.findCVTermInTreeByCVTermID_onerror(client); };
    var requestHeaders = [];
    requestHeaders['SOAPAction'] = '';
    this.jsutils.trace('synchronous = ' + this.synchronous);
    this.client.request(this.url, xml, null, this.synchronous, requestHeaders);
}

ols.prototype.findCVTermInTreeByCVTermID = findCVTermInTreeByCVTermID_op;

function findCVTermInTreeByCVTermID_serializeInput(cxfjsutils, args) {
    var wrapperObj = new findCVTermInTreeByCVTermID();
    wrapperObj.setArg0(args[0]);
    wrapperObj.setArg1(args[1]);
    var xml;
    xml = cxfjsutils.beginSoap11Message("xmlns:jns0='http://www.vectorbase.org' ");
    // block for local variables
    {
     xml = xml + wrapperObj.serialize(cxfjsutils, 'jns0:findCVTermInTreeByCVTermID', null);
    }
    xml = xml + cxfjsutils.endSoap11Message();
    return xml;
}

ols.prototype.findCVTermInTreeByCVTermID_serializeInput = findCVTermInTreeByCVTermID_serializeInput;

function findCVTermInTreeByCVTermIDResponse_deserializeResponse(cxfjsutils, partElement) {
    var returnObject = findCVTermInTreeByCVTermIDResponse_deserialize (cxfjsutils, partElement);

    return returnObject;
}
function ols_olsPort () {
  this.url = 'http://www.vectorbase.org/ols';
}
ols_olsPort.prototype = new ols;
