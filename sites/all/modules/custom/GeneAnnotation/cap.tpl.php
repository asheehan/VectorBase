<?php

?>

<div id='tabs'  style="margin-bottom:50px;">
	<ul id='sortable'>
		<li><a href='#tab1'>About</a></li>

		<li><a href='#tab2'>Download Models</a></li>
		<li><a href='#tab3'>Submit Models</a></li>
		<li><a href='#tab4'>Submit Gene Info</a></li>
		<li><a href='#tab5'>Blast Genome</a></li>
	</ul>
	<div id='tab1'>
		<div class='accordion'>
	<h3><a href="#">Introduction</a></h3>
	<div>

<!--
    <div class="ui-widget">
        <input id="species-filler">
    </div>
-->
        <p>Welcome to the GeneDB/VectorBase Community Annotation Portal.</p>

        <p>This portal is dedicated to communities involved in the manual annotation of a (preliminary) gene set.</p>

        <p>This site allows you to download genomic features (e.g. gene models, protein or EST alignments) from a selection of organisms. Files can then be opened with Apollo or Artemis and edited to modify the annotations. Files containing new or modified annotations can be uploaded via the portal and integrated in the main gene set.</p>

        <p>You will need to create an account to be able to download or submit files.</p>

        <br>

	<h5><i>Glossina morsitans</i></h5>
 	<p>Check out this <a href="http://vectorbase-cap.ensemblgenomes.org/?q=node/2">page</a> for more information and quick links to annotation resources.</p>
	

	</div>

	<h3><a href="#">Download Gene Models</a></h3>
	<div>
		<p>This section allows you to download a specific region from a selection of organisms.</p>

        <p>It's easy: select your organism, enter the chromosome or supercontig/scaffold name, the start and end positions, and chose the output type (webpage or file). Click on submit, and you're done!</p>

        <p>The output is in GFF3 format and can be opened in Apollo, Artemis, or any other software taking GFF as input.</p>

        <p>Bear in mind that there may be considerable supporting evidence included in downloaded gff files so don't select very large regions (We do impose a maximmum limit of 10Gb).</p>

        <p><b>Note:</b> You need to have an account to be able to download files.</p>


	</div>
	<h3><a href="#">Submit Gene Models</a></h3>
	<div>
		<p>This section allows you to upload files containing gene models to allow their integration into the main gene set.</p>

        <p>Select the organism you want to annotate, select the format, and add your name and a brief description of the file content. Press the submit button and that's it! If the upload was successful, you should receive an e-mail, else, you should receive an error message.</p>

        <p>Submitted models should be visible at VectorBase via a DAS track and will be integrated in the gene set at a later stage.</p>

        <p><b>Note:</b> You need to have an account to be able to download files.</p>

		<!-- <ul>
			<li>List item one</li>
			<li>List item two</li>
			<li>List item three</li>
		</ul> -->
	</div>

       <h3><a href="#">Submit Gene Info</a></h3>
        <div>

         <p>This section allows you to modify the gene status (delete, set as pseudogene, approve gene structure) and submit information on the gene name, gene symbol, or add a comment. </p>
         <p>Implementation on this site is still in progress.</p> 
         <p>For the <i>Glossina</i> Community Annotation effort: the functionality is available via the external <a href="https://docs.google.com/spreadsheet/viewform?formkey=dC1DODd1c2MyMzJObUZOOXZvZEV5YkE6MQ&theme=0AX42CRMsmRFbUy0wYjVlZjc1Mi00ZmQ1LTQ1YTktOWUyMC05M2IxMzljNTJkOTQ&ifq">Gene Information Capture Form</a></p>

        <p><b>NOTE:</b> Confirming a gene model as correct does <b>not</b> require uploading of gff for that gene model and is used to track which predictions have been appraised by curators. If you modify the gff for a gene model it will automatically be marked as appraised.</p>
        </div>

	<h3><a href="#">Contact</a></h3>
	<div>
		<p>Contact info@vectorbase.org if you have any questions.</p>

        <p>For bug reports, please contact cap_qc@vectorbase.org. Please detail what you were trying to do (download/submit), on which organism, and what the error message was.</p>
	</div>

		</div>
	</div>
	<div id='tab2'>

<?php

    $output = drupal_get_form('gff_download_ajax_form');
    print drupal_render($output);

?>

	</div>
	<div id='tab3'>

<?php

    //$output = drupal_get_form('download_my_form');
    $output = drupal_get_form('gff_submission_form');
    print drupal_render($output);
    //print '<PRE>' . print_r($output) . '</PRE>' . '<PRE>hello there</PRE>';
    
?>

	</div>
	<div id='tab4'>
        <p>This feature is still in planning stages and is currently available via the external <a href="https://docs.google.com/spreadsheet/viewform?formkey=dC1DODd1c2MyMzJObUZOOXZvZEV5YkE6MQ&theme=0AX42CRMsmRFbUy0wYjVlZjc1Mi00ZmQ1LTQ1YTktOWUyMC05M2IxMzljNTJkOTQ&ifq">Gene Information Capture Form</a></p>
<?php

    //$output = drupal_get_form('download_my_form');
    $output = drupal_get_form('gene_info_submission_form');
    print drupal_render($output);
    //print '<PRE>' . print_r($output) . '</PRE>' . '<PRE>hello there</PRE>';
    /*
<?php if ($messages): ?>
  <?php print render($messages); ?>
<?php endif; ?>
    <a href="<?php print $front_page; ?>" title="Return home"><img src="<?php print $logo; ?>"></a>
     */
    
?>
	</div>
	<div id='tab5'>

      <?php if($GLOBALS['user']->uid >= 1): ?>
<div id="external">
<div id="external-container">
  <div class="hide-toolbar">
  </div>
  <div class="logo" id="community-nav">
  </div>
</div>
<div id="external-site-container" height="100%">
  <!-- <iframe id="external-site" src="http://vectorbase-cap.ensemblgenomes.org/blast/blast.html" width="100%" scrolling="auto" frameBorder="0" height="100%" /> -->
  <iframe id="external-site" src="http://treason.ebi.ac.uk:43232/blast/blast.html" width="100%" scrolling="auto" frameBorder="0" height="100%" />
    <h3>Your Browser Does Not Support Iframes.</h3>
  </iframe>
</div>
</div>
<?php else : ?>
    <p>You must be logged in to use this.</p>
<?php endif; ?>


	</div>
</div>



