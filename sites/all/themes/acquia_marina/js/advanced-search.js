(function ($) {
	$(document).ready(function() {	// on document load we will populate the domain/subdomain dropdowns
		
		/*
		 * Handle selection of domains and subdomains
		 */
		var domains = {
			'expression': "Expression",
			'ontology': "Ontology",
			'genome': "Genome",
			'popbio': "Population Biology"};
		var subDomains = {
			'expression' : ['Expression statistic', 'Probe/Reporter', 'Sample', 'Next-gen expression data', 'Experiment', 'Microarray'],
			'ontology' : ['GAZ term', 'GO term', 'IDODEN term', 'MIRO term', 'IDOMAL term', 'Mosquito anatomy term', 'VectorBase CV term', 'TADS term'],
			'genome' : ['Gene'],
			'popbio' : ['Sample', 'Project', 'Assay']
		};
		var domainSelect = $('#advanced_search_select_domain');
		var subDomainSelect = $('#advanced_search_select_subdomain');
				
		// empty the dropdowns and repopulate them
		domainSelect.html('');
		subDomainSelect.html('');
		$.each(domains, function(index, value) {
			domainSelect.append($("<option />").val(index).text(value));
		});
		$.each(subDomains['expression'], function(key, value) {	//initialize the subDomain array with the first group
			subDomainSelect.append($("<option />").val(value).text(value));
		});
		
		var urlQuery = getUrlVars();
		if (urlQuery['site']) {
			domainSelect.val(cleanUrl(urlQuery['site']));
			domainSelect.change();
		}
		if (urlQuery['bundle_name']) {
			subDomainSelect.val(cleanUrl(urlQuery['bundle_name']));
		}
		
		// change the subdomain select box and the available fields based on a change in the domain select
		domainSelect.change(function() {
			var sel = "";
			sel = domainSelect.find(':selected').val();
			subDomainSelect.html('');
			$.each(subDomains[sel], function(key, value) {
				subDomainSelect.append($("<option />").val(value).text(value));
			})
			$.each(domains, function(index,value) {	// hide all extra option divs
				$('#'+(index)).hide();
			});
			$('#'+sel).show();	// show the selected div
		});
	});
	
	/*
	 * Helper functions
	 */
	
	// Read a page's GET URL variables and return them as an associative array.
	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	
	// Clean up variables pulled from the URL
	function cleanUrl(str) {
		var newStr = str.replace(/\+/g, ' ');	// plus sign -> space
		newStr = newStr.replace(/%20/g, ' ');	// space sign -> space
		newStr = newStr.replace(/%22/g, '');	// double quotes -> nothing
		newStr = newStr.replace(/\"/g, '');		// double quotes -> nothing
		return newStr;
	}
	
// might need a helper method here to do index lookup by key.  There are plenty of examples on stack overflow

})(jQuery);

