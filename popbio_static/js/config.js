/* no trailing slashes (especially for REST url) */

configTxt = {
    'REST':'/popbio/REST/',
    'ROOT':'/popbio/',
    'ROOT_STATIC':'/popbio_static/',
    'linkouts' : {
	'MR4 accession' : 'http://www.mr4.org/MR4ReagentsSearch/Results.aspx?BEINum=####&Template=livingMosquitoes',
	'BioSamples accession' : 'http://www.ebi.ac.uk/biosamples/sample/####',
        'UCDavis ID' : 'https://grassi2.ucdavis.edu/PopulationData/DataViews/indiv.php?id=####'
    }
};

var config = eval(configTxt);
