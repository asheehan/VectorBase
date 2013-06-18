<!doctype html>

<html>

  <head>
  
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                                      
    <title>VectorBase - Controlled Vocabulary Browser</title>
	<link type="text/css" rel="stylesheet" href="CVBrowser.css">
    
    <script type="text/javascript">
         var serverUrlPath = "https://drupal2.vectorbase.org/CVBrowser/";
         var infoPanelContent = "<div style=\"margin:10px 20px 15px 20px;\"><br></br><br></br><b>Currently available Ontologies and CVs</b></br></br>" + 
         	"Malaria Ontology - IDOMAL v1.2.4 <a href=\"download/IDOMAL-1.2.4.obo\">[download]</a></br>" +
			"Mosquito Insecticide Resistance Ontology - MIRO v2.0 <a href=\"download/MIRO-2.0.obo\">[download]</a></br>" +
			"Mosquito Anatomy - TGMA v1.10 <a href=\"download/TGMA-1.10.obo\">[download]</a></br>" +
			"Tick Anatomy - TADS v1.21 <a href=\"download/TADS-1.21.obo\">[download]</a></br></div>";
		 var treePanelContent = "<div style=\"margin:10px 20px 15px 20px;\"><br></br><br></br>" +
			"<b>Browsing</b><br><br>" +
			"<div style=\"text-align: justify;\">Please select a CV from the drop down list on the left panel. In a few seconds, " +
			"depending on the size of the ontology and network speed, the ontology tree should appear in the central panel. " +
			"To expand or collapse branches click on the + or - signs. To view more information about a" +
			"specific term click on the term's name. Detailed information (including expression data, if any) " +
			"for the selected term should appear in this panel.</div>" +
			"<br></br><br></br>" + 
			"<b>Searching</b><br><br>" +
			"<div style=\"text-align: justify;\">To search for a term start typing the term's name into the text box on the far left panel. " +
			"After having typed 3 or more characters a list of the first 10 matching terms should appear. You may click on the desired " +
			"term or use the up and down arrow keys to move up and down. " +
			"As soon as a term on the suggestion list is selected the CV tree should expand and the term will be highlighted. " +
			"At the bottom of the list synonym terms will appear. The matching term's name is printed first followed by the synonym in parenthesis.</div>";

<?php 
			require( "dbFunctions.php" );
			$db = connectToDb();

			$q = "SELECT * FROM cv WHERE state > 0 ORDER BY name ASC";
			$qr = mysql_query( $q );
			$row = mysql_fetch_array( $qr );

			$cvs = "";
			$n = 0;

			while( $row != FALSE )
			{
				if( $n > 0 )
				{
					$cvs = $cvs."÷";
				}
				
				$cvs = $cvs. $row['id']."¸".$row['name']."¸".$row['namespace']."¸".$row['browsing_mode']."¸".$row['terms']."¸".$row['relationships']."¸".$row['root_terms']."¸".$row['nodes'];
				$row = mysql_fetch_array( $qr );
				$n++;
			}
			
			print "var availableCVs = \"$cvs\";\n";

?>
	</script>
    <script type="text/javascript" src="CVBrowser/CVBrowser.nocache.js"></script>
                            
  </head>

  <body class="VBbody">

  <div id="divCVBrowser"></div>

  <script type="text/javascript">
         var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
         document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>

  <script type="text/javascript">
         try
         {
   	      	var pageTracker = _gat._getTracker("UA-6417661-1");
    	    pageTracker._setDomainName(".vectorbase.org");
        	pageTracker._trackPageview();
         }
         catch( err )
         {
         }
  </script>
 
 </body>

</html>
