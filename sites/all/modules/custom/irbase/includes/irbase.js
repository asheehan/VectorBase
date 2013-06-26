function markAll( assays_count )	{
	if( document.getElementById("cbx_all").checked )
		for( n = 1; n <= assays_count; n++ )
			document.getElementById("cbx_"+n).checked = true;
	else
		for( n = 1; n <= assays_count; n++ )
			document.getElementById("cbx_"+n).checked = false;
}

function mapResults() {
	this.window.location="/content/ir-map?sid="+sid;
}

function exportResults( assays_count )	{
	/*ids = "";
	  for( n = 1; n <= assays_count; n++ )
	  if( document.getElementById("cbx_"+n).checked )		{
	  if( ids != "" )
	  ids = ids + ",";
	  ids = ids + document.getElementById("cbx_"+n).value;
	  }
	  */
	ids = document.getElementById("select-result").innerHTML;

	while( ids.indexOf( ", " ) >= 0 )	{
		ids = ids.replace( ", ", "," );
	}

	while( ids.indexOf( ",," ) >= 0 )	{
		ids = ids.replace( ",,", "," );
	}

	this.window.location="http://anobase.vectorbase.org/ir/export.php?ids="+ids;
}

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

try {
	var pageTracker = _gat._getTracker("UA-6417661-1");
	pageTracker._setDomainName(".vectorbase.org");
	pageTracker._trackPageview();
} catch(err) {}

