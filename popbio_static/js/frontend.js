/*
 * Dependencies:
 *
 * prototype >1.7.0.0
 *
 * (pretty JSON for sandbox only) json2.js (https://github.com/douglascrockford/JSON-js/blob/master/json2.js)
 *
 * phenovis >0.01
 *
 *
 */

if (typeof console=="undefined") {
  console={log:function(message) { } }
}

/*
 * renders sample info "full page" info into the div provided
 *
 * arg1: json object
 * arg2: Prototype Element
 *
 *
 * note: the (code within the) following two functions could go in
 * the actual HTML page source callbacks (although updateExperimentFull() may
 * get quite large)
 *
 */

function updateSampleFull(stock, element) {
	fillInObjectValues(stock, element.down('#sample_info')).removeClassName('hide_on_load');
	summariseExperiments(stock.experiments, true);
	fillInListValues(stock.experiments, element.down('#sample_experiments')).removeClassName('hide_on_load');

	var sprojects = element.down('#sample_projects');
	var spinner = sprojects.down('.vbpg_progress');
	var url = 'stock/'+stock.id+'/projects';
	var limits = {
	  offset: 0,
	  limit: 20
	};

	getPagedObjects(url,
									limits,
									spinner,
									function(page) {
										fillInPagedListValues(page, sprojects, url, limits).down('.hide_on_load').removeClassName('hide_on_load');
									});


	return element;
}

/*
 * renders experiment info into the div provided
 *
 * arg1: json object
 * arg2: Prototype Element
 *
 *
 * 
 */

function updateExperimentFull(experiment, element) {
	var species_div = element.down('#species_results');
	var eprops_div = element.down('#experimentprops');

  if (experiment.type == 'species identification assay') {
		// special treatment for these experiment props
    fillInListValues(experiment.props, species_div, 'no_shading').removeClassName('hide_on_load');
  } else {
		// render the experimentprops normally
		// ensure start and end dates are in correct order
		experiment.props = reorganiseExperimentProps(experiment.props);


		experiment.props = experiment.props.sortBy(function(p){ return p.type.match(/start date/i) ? -2 : p.type.match(/end date/i) ? -1 : p.rank  });

    fillInListValues(experiment.props, eprops_div, 'no_shading').removeClassName('hide_on_load');
  }
	// deactivate nested magic divs
	deactivate(eprops_div);
	deactivate(species_div);

	// now fill in top level info
	fillInObjectValues(experiment, element.down('#experiment_info')).removeClassName('hide_on_load');

  if (experiment.type == 'field collection') {
    var geoloc_div = element.down('#experiment_geolocation_info');
		var geolocprops_div = geoloc_div.down('#experiment_geolocationprops');

		// tidy up props

		experiment.geolocation.props.each(function(prop){
				if (prop.type.match(/^GAZ:/)) {
					prop.value = displayCvterm(prop.type);
					prop.type = 'NULL:Gazetteer ontology term';
				}
			});


		// do nested one first
		fillInListValues(experiment.geolocation.props, geolocprops_div, 'no_shading').removeClassName('hide_on_load');
		deactivate(geolocprops_div);

    fillInObjectValues(experiment.geolocation, geoloc_div).removeClassName('hide_on_load');

		var map_panel = $('mini_map_panel');
		if (map_panel) {
			if (experiment.geolocation &&
					experiment.geolocation.latitude &&
					experiment.geolocation.longitude &&
					experiment.geolocation.description) {
				var vis = {
					"type": "geoplot",
					"x": "$.geolocation.latitude",
					"y": "$.geolocation.longitude",
					"z": "$.geolocation.description",
					"e": "$.geolocation"
				};
				renderVisualisation(experiment, vis, map_panel);
			} else {
				map_panel.hide();
			}
		}
  }

	// protocol
	if (experiment.protocols.size() > 1) console.log("warning, this experiment has more than one protocol");
	if (experiment.protocols.size()) {
		var protocol = experiment.protocols.first();
		fillInObjectValues(protocol, element.down('#experiment_protocol')).removeClassName('hide_on_load');
		
	}

	// phenotypes
	if (experiment.phenotypes.size()) {
		var pheno_div = element.down('#experiment_phenotypes');
		fillInListValues(experiment.phenotypes, pheno_div).removeClassName('hide_on_load');
	}

	// genotypes
	if (experiment.genotypes.size()) {
		var geno_div = element.down('#experiment_genotypes');
		fillInListValues(experiment.genotypes, geno_div).removeClassName('hide_on_load');
	}

  var estocks = element.down('#experiment_stocks');
  var spinner = estocks.down('.vbpg_progress');
  var url = 'experiment/'+experiment.id+'/stocks';

  var eprojects =  element.down('#experiment_projects');
  var spinner2 = eprojects.down('.vbpg_progress');
  var url2 = 'experiment/'+experiment.id+'/projects';

  var limits = {
  offset: 0,
  limit: 20
  };

  getPagedObjects(url2,
                  limits,
                  spinner2,
                  function(page) {
                    fillInPagedListValues(page, eprojects, url2, limits).down('.hide_on_load').removeClassName('hide_on_load');
                  });

  getPagedObjects(url,
                  limits,
                  spinner,
                  function(page) {
                    fillInPagedListValues(page, estocks, url, limits).down('.hide_on_load').removeClassName('hide_on_load');
                  });

  return element;
}


/*
 * renders project info into the div provided
 *
 * arg1: json header object
 * arg2: Prototype Element
 *
 *
 * 
 */

function updateProjectFull(project, element, sandbox) {
	fillInObjectValues(project, element.down('#project_info')).removeClassName('hide_on_load');

	var index = 1;
	var vis_array = project.props.filter(function(prop){return prop.type=='VBcv:vis' && prop.value.isJSON()}).collect(function(prop){
			var vis = prop.value.evalJSON(); // TO DO: make this fail gracefully - the prior isJSON() doesn't seem to be enough
			return vis;
		});

	if (sandbox) {
		vis_array.push({
				"type": "geoplot",
					"title": "sandbox default (lat x long x species)",
					"x": "$.stocks.*.experiments[?(@.type == 'field collection' && @.geolocation.latitude)].geolocation.latitude",
					"y": "$.stocks.*.experiments[?(@.type == 'field collection' && @.geolocation.latitude)].geolocation.longitude",
					"z": "$.stocks.*.id",
					"e": "$.stocks.*.experiments[?(@.type == 'field collection' && @.geolocation.latitude)]",
					"filters" : { "zLabel": "bestSpeciesById" }
			});

	}

	fillInListValues(vis_array, element.down('#project_visualisations'), 'no_shading').removeClassName('hide_on_load');

	if (vis_array.size())	assembleProject(project, $('project_load_status'));

	if (sandbox) {
		var textAreas = element.down('#project_visualisations').select('.list_row_instance textarea');
		vis_array.each(function(vis){ textAreas.shift().update(JSON.stringify(vis, null, 2)); });
	}

	var pstocks = element.down('#project_stocks');
	var spinner = pstocks.down('.vbpg_progress');
	var url = 'project/'+project.id+'/stocks';
	var limits = {
	  offset: 0,
	  limit: 20,
		//return_full: true
	};

	getPagedObjects(url,
			limits,
			spinner,
			function(page) {
			    fillInPagedListValues(page, pstocks, url, limits).down('.hide_on_load').removeClassName('hide_on_load');
			});


	// now check every 2s for the full project to be loaded before loading the visualisations.

	if (vis_array.size()) {
		new PeriodicalExecuter(function(pe) {
  	 	if (project.complete) {
        pe.stop();
				vis_panels = $$('.list_row_instance .vis_panel');
				if (vis_panels.size() == vis_array.size()) {
					vis_array.each(function(vis) {
							var vis_panel = vis_panels.shift();
							renderVisualisation(project, vis, vis_panel);

							if (sandbox) {
								// add the 'render' button
								var textArea = vis_panel.up('.list_row_instance').down('textarea');
								var button = new Element('input', { style: 'margin-left: 10px;', type: 'button', value: 'render' });
								button.observe('click', function(event) {
										if (project.complete) {
											var textArea = event.element().previous('textarea');
											var vis = String.interpret(textArea.value).evalJSON();
											var vis_panel = textArea.up('.list_row_instance').down('.vis_panel');
											renderVisualisation(project, vis, vis_panel);
											if (vis.title) vis_panel.up('.list_row_instance').down('#title').update(vis.title);
										}
									} );
								textArea.insert({ after: button });
							}

						});
				} else {
					//console.log(vis_array);
					//console.log(vis_panels);
					console.log("different number of vis properties in project and vis_panels in page");
				}
      }
		}, 1);
	}

}

/*
 * renderVisualisation(project, vis, vis_panel)
 *
 *
 *
 */

function renderVisualisation(project, vis, vis_panel) {
	try {
		var hashJSP = getFilteredDataHash_jsp(project,vis);
		// console.log(vis);
		// console.log(hashJSP);
	

		vis_panel.identify();	// in case it has no id
		vis_panel.style.width = vis_panel.getWidth(); // in case the dimensions
		vis_panel.style.height = vis_panel.getHeight(); // are in stylesheet

		callPlot(vis.type, hashJSP, vis_panel, vis.args);
	} catch(err) {
		vis_panel.update("The visualisation config may be incorrect or not appropriate for this project.<br><pre>"+err+"</pre>");
	}
}

/*
 * getFilteredDataHash_jsp(project, vis)
 *
 * wrapper for getDataHash_jsp, applying front-end/VectorBase specific vis.filters to the results
 *
 */

function getFilteredDataHash_jsp(project, vis) {
	var hashJSP = getDataHash_jsp(project,vis.e,vis.x,vis.y,vis.z);

	if (vis.filters) {
		if (vis.filters.noFalseZ) {
			/*
			 * we don't want to encourage filtering away points from the dataset
			 * because we will probably have more dynamic z labelling (by experimental factor radio buttone)
			 */
			console.log("Advance warning: vis.filters.noFalseZ will be deprecated and is not recommended");
			hashJSP = hashJSP.filter(function(hash){ return hash.z !== false; });
		}

		if (vis.filters.zLabel) {
			var auto_object = vis.filters.zLabel;
			if (auto_object == 'bestSpeciesById') {
				var stocks_by_id = new Object();
				project.stocks.each(function(stock){ stocks_by_id[stock.id] = stock; });
				hashJSP.each(function(hash){ hash.z = getBestSpeciesForStock(stocks_by_id[hash.z]) });
			}
		}
	}

	// compulsory false -> "no data" filter on z
	hashJSP = hashJSP.each(function(hash){ if (hash.z === false) { hash.z = 'no data' } });

	return hashJSP;
}


/*
 * getBestSpeciesForStock(stock)
 *
 * returns a suitable label
 */

function getBestSpeciesForStock(stock) {
	var retval = '';
	// stock.species_id_assay.props.*.type
	if (retval = jsonPath(stock, "$.experiments[?(@.type == 'species identification assay')].props.*.type")) return retval.collect(function(s){return s.sub('MIRO:','')}).sort().join(', ');

	// stock.spp
 	if (stock.organism && stock.organism.spp) return stock.organism.spp;

	return 'unknown species';
}

function summariseExperiments(experiments, autolink) {

	// automagic link to the experiment page
	var more_details = autolink ? ' <a class="object_id href" id="type" title="More details" href="https://drupal.vectorbase.org/popbio/experiment/?id=####">...</a>' : ' ...';

  experiments.each(function(experiment) {
			switch(experiment.type) {
					case 'field collection':
						var geo = experiment.geolocation;
						var gaz = experiment.geolocation.props.filter(function(prop){ prop.type.match(/^GAZ:/) }).first();
						if (gaz) {
							experiment.summary = displayCvterm(gaz.type);
						} else if (geo.description) {
							experiment.summary = geo.description;
						} else if (geo.longitude) {
							experiment.summary = geo.latitude+','+geo.longitude;
						} else {
							experiment.summary = '';
						}

						break;

					case 'species identification assay':
						if (experiment.props.size()) experiment.summary = '<i>'+displayCvterm(experiment.props[0].type)+'</i>';
						if (experiment.props.size()>1) experiment.summary = experiment.summary+more_details;
						break;

					case 'genotype assay':
						if (experiment.genotypes.size()) experiment.summary = jsonPath(experiment.genotypes, '$.*.description').uniq().join(';<wbr/>');
						break;

					case 'phenotype assay':
						if (experiment.phenotypes.size()) experiment.summary = displayExperimentProps(experiment.props)+" "+displayPhenotype(experiment.phenotypes[0]);
						if (experiment.phenotypes.size()>1) experiment.summary = experiment.summary+more_details;

						break;
					default:
						experiment.summary = '';
						break;
			}
		});
}



/*
 * automagically fills in data to a div
 *
 * elements with class==object_value and one of [scalar, cvterm] and id="xxx" will
 * have their content replaced with object.xxx
 * there's a further 'action' called 'clear_if_missing' - see code comments below for details
 *
 * elements with class=="object_id href" will do a s/####/object.id/e on the href
 * attribute of the element.
 *
 * // uncomment below if using:
 * // elements with class=="object_id id" will do a s/####/object.id/e on the id
 * // attribute of the element.
 *
 * elements with class=="auto_link" will have the element.href =~ s/####/element.innerHTML.stripTags/e
 *
 * elements with class==capitalize will capitalize the content after it has been injected (strips HTML tags!)
 *
 * ditto class=="nested_object_list" id=="xxxs" will populate a list template using the list returned by object.xxxs
 *
 * it's the caller's responsibility to manage spinners and make it visible afterwards
 *
 * note: call this on inner-most nested (in terms of DOM) elements FIRST
 *       as all elements are cleared of the object_value and object_id classes
 *       to avoid being overwritten
 */

function fillInObjectValues(object, element) {

	// first do any nested lists (only one level guaranteed to work)
  element.select('.nested_object_list').each(function(e){
			var items = jsonPath(object, '$.'+e.id).first();
			fillInListValues(items, e);
			deactivate(e);
		});

	// now dow the non-list expansions
  element.select('.object_value.scalar').each(function(e){
	  e.update(jsonPath(object, '$.'+e.id) || '');
      });

  element.select('.object_value.cvterm').each(function(e){
			e.update(displayCvterm(jsonPath(object, '$.'+e.id).first())); // displayCvterm can't handle a list of one
      });
  
  // this one only does s/####/object.id/e on the element's href attribute
  // the <a ...> element does not need an id attribute
  element.select('.object_id.href').each(function(e){
	  var href = e.readAttribute('href');
	  e.writeAttribute('href', href.sub(/####/, object.id));
      });

	/*
	 * not used at the moment
	 *
		element.select('.object_id.id').each(function(e){
	  var id = e.readAttribute('id');
	  e.writeAttribute('id', id.sub(/####/, object.id));
      });
	*/

  element.select('.auto_link').each(function(e){
	  var href = e.readAttribute('href');
	  e.writeAttribute('href', href.sub(/####/, e.innerHTML.stripTags()));
      });

  element.select('.object_value.capitalize').each(function(e){
			e.update(e.innerHTML.stripTags().capitalize());
      });

  // this one clears an element if the specified field is missing
  // initial use case: geo coords are displayed with a comma between spans for lat and long
  // however, when geo coords are missing you just see the comma
  // if you wrap those spans in a clear_if_missing element for, say, latitude, all is well
  element.select('.object_value.clear_if_missing').each(function(e){
	  var value = jsonPath(object, '$.'+e.id);
	  if (!value || Object.toHTML(value).blank()) e.update();
      });

	// now clear the element classes so that the updated content cannot be overwritten
  return element;
}

/*
 * removes auto-fill classes from element
 *
 *
 */

function deactivate(element) {
	element.select('.object_value').each(function(e){ e.removeClassName('object_value'); });
	element.select('.object_id').each(function(e){ e.removeClassName('object_id'); });
	element.select('.auto_link').each(function(e){ e.removeClassName('auto_link'); });
	return element;
}

/*
 * looks for list_row_template and duplicates it with
 * each item of list
 *
 *
 */

function fillInListValues(list, element, no_even_odd_shading) {
	// remove any existing list_row_instances
	element.select('.list_row_instance').each(function(row){ row.remove() });

	var list_row_template = element.select('.list_row_template').first();  // shouldn't be >1!
	var last_row = list_row_template;
	var row_num = 0;
	if (list && list.size()) {
		list.each(function(item) {
				var new_row = list_row_template.clone(true).removeClassName('list_row_template').addClassName('list_row_instance');
				if (!no_even_odd_shading) new_row.addClassName(row_num++ % 2 == 0 ? 'even_row' : 'odd_row');
				last_row.insert({ after: fillInObjectValues(item, new_row) });
				last_row = new_row;
			});
	} else {
		// blank out if no items
		element.update();
	}
	return element;
}

/*
 * processes the page object and updates the pager info
 * before populating the list as with fillInListValues()
 *
 */

function fillInPagedListValues(page, element, url, limits) {

	// update the pager div(s) (don't have to be divs)
	var pagers = element.select('.vbpg_pager');
	var spinner = element.down('.vbpg_progress');

	if (page.count > limits.limit) {
	    pagers.each(function(pager){ 
		    fillInObjectValues(page, pager);
		    pager.removeClassName('hide_unless_paging');
		    var next = pager.down('.vbpg_pager_next');
		    if (page.end == page.count) {
			next.purge(); // remove event handlers
			next.addClassName('vbpg_pager_inactive');
		    } else {
			var next_callback = function(event) {
			    element.down('.hide_on_update').addClassName('vbpg_pager_pending');
			    getPagedObjects(url,
			{
			offset: page.start+limits.limit-1,
				limit: limits.limit
				},
					    spinner && spinner.show(),
					    function(p) { // p is for page
						fillInPagedListValues(p, element, url, limits).down('.hide_on_update').removeClassName('vbpg_pager_pending');
					    });
			};
			next.purge();
			next.observe('click', next_callback);
			next.removeClassName('vbpg_pager_inactive');
		    }
		    var prev = pager.down('.vbpg_pager_prev');
		    if (page.start == 1) {
			prev.addClassName('vbpg_pager_inactive');
			prev.purge();
		    } else {
			var prev_callback = function(event) {
			    element.down('.hide_on_update').addClassName('vbpg_pager_pending');
			    getPagedObjects(url,
			{
			offset: page.start-limits.limit-1,
				limit: limits.limit
				},
					    spinner && spinner.show(),
					    function(p) { // p is for page
						fillInPagedListValues(p, element, url, limits).down('.hide_on_update').removeClassName('vbpg_pager_pending');
					    });
			};
			prev.purge();
			prev.observe('click', prev_callback);
			prev.removeClassName('vbpg_pager_inactive');
		    }
		    
		});
	}
	
	if (page.records && page.records.size()) {
	    fillInListValues(page.records, element);
	} else {
	    // blank out if no items
	    element.update();
	}
	return element;
}

/* formats a cv.name:cvterm.name string for display
 * or returns empty string on failure
 *
 * one day it will return a link or something!
 */

function displayCvterm(type) {
	if (type && Object.isString(type)) {
		var parts = type.split(":",2);
		if (parts.size() == 2) {
			return parts[1];
		}
	}
	return "";
}

/*
 * turn shared-rank props (where one prop is from VBcv (valueless) and another is from another ontology) into a single prop with
 * type=VBcv:term and value = displayCvterm(other_term)
 *
 * the shared-rank props are currently used for insecticides and concentrations
 *
 * returns the new props if they were successfully created
 */

function reorganiseExperimentProps(props) {
  var newprops = [];
	if (props && props.size()) {
		props.filter(function(prop){ return prop.type.match(/^VBcv:/) && prop.value.blank(); }).each(
			function(typeprop) {
				var valueprop = props.find(function(p) { return p.rank == typeprop.rank && p.type !== typeprop.type });
				if (valueprop) newprops.push( { type: typeprop.type,
							value: valueprop.value || displayCvterm(valueprop.type),
							rank: typeprop.rank
							});

			});
	}

	return newprops.size() ? newprops : props;
}


/*
 * single line text for experiment props
 *
 * e.g. for insecticide assays show the insecticide (concentration)
 */

function displayExperimentProps(props) {
	var parts = [];
	if (props && props.size()) {
  	var vbcv_i = props.find(function(prop){ return prop.type == "VBcv:insecticide" });
		if (vbcv_i) {
  		// find the next other prop with the same rank as the 'insecticide' VBcv term
  		var iprop = props.find(function(prop) { return prop.rank == vbcv_i.rank && prop.type !== vbcv_i.type });
  		if (iprop) {
  			parts.push(displayCvterm(iprop.type));
  			var vbcv_c = props.find(function(prop){ return prop.type == "VBcv:concentration" });
  			if (vbcv_c) {
  				var cprop = props.find(function(prop) { return prop.rank == vbcv_c.rank && prop.type !== vbcv_c.type });
  				if (cprop) {
  					parts.push("("+cprop.value+")");
  				}
  			}
  		}
  	}
	}
	return parts.join(" ");
}

/*
 * format phenotype for single <span> display
 *
 * TO DO: something more sophisticated!
 */

function displayPhenotype(phenotype) {
	var parts = [];
	if (phenotype.observable) parts.push(phenotype.observable.name);
	if (phenotype.attribute) parts.push(phenotype.attribute.name);
	if (phenotype.cvalue) parts.push(phenotype.cvalue.name); 
	if (phenotype.value !== null) parts.push(phenotype.value);
	return parts.join(" ");
}


/*
 * AJAX wrapper of a wrapper to get just one object by its url (NO app root; NO leading slash)
 *
 * e.g. project/123
 *
 */

function getObject(url, spinner, callback) {

	if (spinner) spinner.update(new Element('img', { src: config.ROOT_STATIC+'vbpg_images/bigrotation2.gif', width: 32, height: 32 }));

	new Ajax.Request(config.REST+url, {
		method:'get',
				requestHeaders: {Accept: 'application/json'},
				onSuccess: handleResponse,
				onFailure: function(t){alert('Sorry, an error occurred. '+url+' did not load.')},
				});
	
	function handleResponse(response) {

		// nasty hack to clean up eupathdb bug (IsolateByTaxon.json error message tacked on at the end of JSON)
		// response.responseText = response.responseText.sub(/]{.+/, ']}]}}}');
		
		var object = response.responseText.evalJSON();
		if (object) {
			if (spinner) spinner.hide();
			callback(object);
		} else {
			console.log("problem evalling json from "+url);
		}
	}

}

/*
 * fills in project object sequentially called object array
 * 
 * Nb: this will fire of a set of ajax requests to build the object
 * it is up to you to check it is complete & in memory
 * 
 * to do: put object in dom storage rather than passing in scope
 */
function assembleProject (project, progress_div) {
  project.complete = 0;
  console.log("assembling project " + project.id);

  var spinner = null;
  //  var i = 0;
  var maxStocks = 1000; //any large number
  var stocks = new Array();
  //  alert(stocks.length);
  var limits = { 'offset': 0, 'limit': 50, 'returnType': 'full'};
  getPagedObjects('project/'+project.id+'/stocks/', limits, null, addToProject);
	if (progress_div) progress_div.update("Loading samples...");

  function addToProject(response) {
    maxStocks = response.count;
    /*
    i++;
    console.log(i+" "+response.start+" ADDING: "+response.records.length+" stocks to "+stocks.length);
    console.log(i+" "+response.start+" "+response.records);
    console.log(i+" "+stocks.length+" + "+response.records.length);
    */
    //newStocks = new Array(response.records);   
    stocks = stocks.concat(response.records);
    //    console.log(" = "+stocks.length);
      //    console.log(Object.toJSON(response.records));

		if (progress_div) progress_div.update(stocks.size()+" of "+maxStocks+" samples loaded");

    if(stocks.length < maxStocks) {
      //      console.log("more!");
      limits.offset = limits.offset+limits.limit;
      getPagedObjects('project/'+project.id+'/stocks/', limits, spinner, addToProject);
    }
    if(stocks.length == maxStocks) {
      project.stocks = stocks;
      project.complete = 1;
			if (progress_div) {
				progress_div.update("All project data has loaded.");
				setTimeout(function(){ progress_div.hide() }, 1500);
			}
      console.log("project "+project.id+" all "+project.stocks.length+" stocks loaded");
    }
  }
}
/*
 * request objects that we know might come back in a pager wrapper
 *
 * bug: ignores spinner
 * to do: remove spinner arg or do something with it
 *
 */

function getPagedObjects(url, limits, spinner, callback) {

	if (spinner) spinner.update(new Element('img', { src: config.ROOT_STATIC+'vbpg_images/bigrotation2.gif', width: 32, height: 32 }));

	// should process limits into url params here:
	var params = '?o='+limits.offset+'&l='+limits.limit+'&return='+limits.returnType;
	if (limits.return_full) params = params + '&return=full';


	new Ajax.Request(config.REST+url+params, {
	    method:'get',
		    requestHeaders: {Accept: 'application/json'},
		    onSuccess: function(response) {
		    var page = response.responseText.evalJSON();
		    if (spinner) spinner.hide();
		    callback(page);
		},
		    onFailure: function(t){alert('Sorry, an error occurred. '+url+' did not load')},
		    });
}



/*
 * DEPRECATED
 * AJAX wrapper of a wrapper to get just one object by id and object type
 *
 */

function getObjectById(object_id, object_type, spinner, callback) {
  getObjectsByIds([ object_id ], object_type,  1, spinner, function(objects){ callback(objects[0]) } );
}

/*
 * DEPRECATED
 * AJAX wrapper to get an array of objects (given an array of ids) and apply the callback function on it
 *
 */

function getObjectsByIds(object_ids, object_type, max_concurrent, spinner, callback) {

	var objects = new Array();
	var objects_in_progress = 0;

	// start the spinner
	if (spinner) {
		spinner.update(new Element('img', { src: config.ROOT+'vbpg_images/bigrotation2.gif', width: 32, height: 32 }));
	}

	// get first of (possibly) many objects
	requestObject(0);

	function requestObject(index) {

		if (index < object_ids.size()) {
			if (objects_in_progress < max_concurrent) {
				// console.log('req '+index);
				var object_id = object_ids[index++];
				new Ajax.Request(config.REST+object_type+'/'+object_id, {
					method:'get',
							requestHeaders: {Accept: 'application/json'},
							onSuccess: handleObject,
							onFailure: function(t){alert('Sorry, an error occurred. '+object_type+'s did not all load')},
							});
				objects_in_progress++;
			} 

			// try sending another request a bit later
			if (index < object_ids.size()) setTimeout(function(){ requestObject(index)	}, 200);
		}
	}

	function handleObject(response) {
		var object = response.responseText.evalJSON();
    
		objects.push(object);
		objects_in_progress--;

//		console.log('handled '+objects.size() + ' of ' + object_ids.size());
    
		if (objects.size() == object_ids.size()) {
			if (spinner) {
				spinner.hide(); // clear it
			}
			callback(objects);
		}
	}

}

  

