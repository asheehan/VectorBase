(function ($) {
	$(document).ready(function() {	// on document load we will populate the domain/subdomain dropdowns
		var domains = new Array("Expression", "Ontology", "Genome", "Population Biology");
		var subDomains = {
			'Expression' : ['Expression statistic', 'Probe/Reporter', 'Sample', 'Next-gen expression data', 'Experiment', 'Microarray'],
			'Ontology' : ['GAZ term', 'GO term', 'IDODEN term', 'MIRO term', 'IDOMAL term', 'Mosquito anatomy term', 'VectorBase CV term', 'TADS term'],
			'Genome' : ['Gene'],
			'Population Biology' : ['Sample', 'Project', 'Assay']
		};
		var domainSelect = $('#advanced_search_select_domain');
		var subDomainSelect = $('#advanced_search_select_subdomain');
		domainSelect.html('');	//empty the dropdown
		subDomainSelect.html('');
		$.each(domains, function(index, value) {
			domainSelect.append($("<option />").val(value).text(value));
		});
		$.each(subDomains[domains[0]], function(index, value) {	//initialize the subDomain array with the first group
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
		
		// change the subdomain select box based on a change in the domain select
		domainSelect.change(function() {
			var sel = "";
			sel = domainSelect.find(':selected').text();
			subDomainSelect.html('');
			$.each(subDomains[sel], function(index, value) {
				subDomainSelect.append($("<option />").val(value).text(value));
			})
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
	
	function cleanUrl(str) {
		var newStr = str.replace(/\+/g, ' ');
		newStr = newStr.replace(/%20/g, ' ');
		newStr = newStr.replace(/%22/g, '');
		newStr = newStr.replace(/\"/g, '');
		return newStr;
	}

})(jQuery);

