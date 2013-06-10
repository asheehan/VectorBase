<?php
/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 */
?>

<?php if ($search_results): ?>
  <?php

	$bundleSummary = $response->facet_counts->facet_fields->bundle_name;
	$speciesSummary = $response->facet_counts->facet_fields->species_category;
	$siteSummary = $response->facet_counts->facet_fields->site;
	$queryTerm = htmlspecialchars($response->responseHeader->params->q);
	$bundleTerm = urlencode($_GET['bundle_name']);
	$speciesTerm = urlencode($_GET['species_category']);
	$siteTerm = urlencode($_GET['site']);
	$baseQuery = "/search/site/" . $queryTerm . "?";
	$bundleResetURL = $baseQuery;
	$speciesResetURL = $baseQuery;
	$siteResetURL = $baseQuery;
        $filter_applied = false;

   	if (!empty($speciesTerm)){
		$bundleResetURL .= "&species_category=" . $speciesTerm;
		$siteResetURL .= "&species_category=" . $speciesTerm;
                $filter_applied = true;
	}
	if (!empty($bundleTerm)){
		$speciesResetURL .= "&bundle_name=" .$bundleTerm;

                $filter_applied = true;
	}
	if (!empty($siteTerm)){
		$bundleResetURL .= "&site=" . $siteTerm;
		$speciesResetURL .= "&site=" . $siteTerm;
                $filter_applied = true;
	}

	$bundleList = array();
	foreach ($bundleSummary as $key => $value) {
		if ($value > 0){
			$bundleList[$key] = $value;
		}
	}
	$speciesList = array();
	foreach ($speciesSummary as $key => $value) {
		if ($value > 0) {
			$speciesList[$key] = $value;
		}
	}	
	$siteList = array();
	foreach ($siteSummary as $key => $value) {
		if ($value > 0) {
			$siteList[$key] = $value;
		}
	}
	
	drupal_add_js('/sites/all/themes/acquia_marina/js/advanced-search.js');
	drupal_add_js('/sites/all/themes/acquia_marina/js/uri.js/src/URI.js');
	
	// initial values
	$initValues['adv_search'] = (isset($_GET['adv_search'])) ? $_GET['adv_search'] : FALSE;
	$initValues['site'] = (isset($_GET['site'])) ? $_GET['site'] : '';
	$initValues['bundle_name'] = (isset($_GET['bundle_name'])) ? $_GET['bundle_name'] : '';
	$initValues['title'] = (isset($_GET['title'])) ? $_GET['title'] : '';
	

  	$advancedSearchContent = '
  		<div class="search_advanced_box">
  			<form name="advanced_search_form" action="/search/site/%2a" method="get">
  			Domain: <select id="advanced_search_select_domain" name="site" value="Ontology"></select>&nbsp;&nbsp;
  			Sub-domain: <select id="advanced_search_select_subdomain" name="bundle_name"></select>&nbsp;&nbsp;
  			<input id="advanced_serach_input_submit" type="submit" value=" Search ">
  			<br />
  			<table class="advanced_search_table_inputs">
  			<tr><th colspan="2">Field</th><th>Exact</th></tr>
  			<tr>
  				<td>Title:</td><td><input id="advanced_search_input_title" type="text" name="title" value='.$initValues['title'].'></td>
  				<td><input id="advanced_search_input_title_exact" type="checkbox" name="title_exact" /></td>
  			</tr>
  				<td>Description:</td><td><input id="advanced_search_input_description" type="text" name="description"></td>
  				<td><input id="advanced_search_input_description_exact" type="checkbox" name="description_exact"></td>
  			</tr>
  			<tr>
  				<td colspan="2"><input id="advanced_serach_input_submit" type="submit" value=" Search "></td>
  			</tr>
  			</table>
  			<input type="hidden" name="adv_search" value="1">
			</form>
  		</div>
  	';
	
	print theme('ctools_collapsible',
		array(
			'handle'	=>	'<b>Advanced Search</b>',
			'content'	=>	$advancedSearchContent,
			'collapsed'	=>	!$initValues['adv_search']
		)
	);
  ?>
  <br />
	<div class="search_filter_box">
		<h2>Filter Results</h2>

		<table>
			<tr>
				<th class="search_filter_box_header">Domain
					<?php if (!empty($siteTerm)){ ?>
					(<a class="search_filter_reset" href="<?php print $siteResetURL;?>">Reset Filter</a>)
					<?php } ?>
				</th><th>Hits</th>
			</tr>
			<?php
				foreach ($siteList as $key => $value ){
					if ( $value > 0 ) {
						if (count($siteList) > 1) {
							print "<tr><td><a href=\"" . $siteResetURL . "&site=%22" . $key . "%22" . "\">$key</a></td><td>$value</td></tr>";
						}else {
							print "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
						}
					}
				}
			?>
		</table>
		<?php if ((!empty($siteTerm) || count($siteList) == 1) && count($bundleList) > 0 ) { ?>
		<table >
			<tr>
				<th class="search_filter_box_header">Sub-domain
					<?php if (!empty($bundleTerm)){ ?>
					(<a class="search_filter_reset" href="<?php print $bundleResetURL;?>">Reset Filter</a>)
					<?php } ?>
				</th><th>Hits</th>
			</tr>
			<?php
				foreach ($bundleList as $key => $value ){
					if ( $value > 0 ) {
						if (count($bundleList) > 1) {
							print "<tr><td><a href=\"" . $bundleResetURL . "&bundle_name=%22" . $key . "%22" . "\">$key</a></td><td>$value</td></tr>";
						}else {
							print "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
						}
					}
				}
			?>
		</table>
		<?php } ?>
			<?php if (count($speciesList) > 0){ ?>
				<table>
				<tr>
					<th class="search_filter_box_header">Species
						<?php if (!empty($speciesTerm)){ ?>
							(<a class="search_filter_reset" href="<?php print $speciesResetURL;?>">Reset Filter</a>)
						<?php } ?>
					</th><th>Hits</th>
				</tr>
			<?php  
				foreach ($speciesList as $key => $value ){
					if ( $value > 0 ) {
						if (empty($speciesTerm)){
							if (count($speciesList) > 1) {
								print "<tr><td><a href=\"" . $speciesResetURL . "&species_category=%22" . $key . "%22" . "\">$key</a></td><td>$value</td></tr>";
							} else {
								print "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
							}
						} else {
							if (strcmp('"'.$key.'"',urldecode($speciesTerm)) == 0) {	
								print "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
							}
						}
					}
				}
				print "</table>";
			}
			?>
		</table>
	</div>	
<div style="width:70%;float:right;padding:10px;">		
  <h2><?php print t('Search results');?></h2>
	<?
	global $pager_page_array, $pager_total_items;
	$pager_amount = 20;
	$count = variable_get('apachesolr_rows', $pager_amount);
	$start = $pager_page_array[0] * $count + 1;
	$end = $start + $count - 1;
	if( $end > $pager_total_items[0] ){
	  $end = $pager_total_items[0];
	}
	print t('Showing %start to %end of %total results found.', 
	  array(
	    '%start' => $start,
	    '%end' => $end,
	    '%total' => $pager_total_items[0]
	  )
	);
	?>

      
      <?php if ($pager_total_items[0] == 1) { 
        $link_start = strpos($search_results, 'href="')+6;
	$link_end = strpos($search_results, '"', $link_start);
	$list = substr($search_results, $link_start, $link_end-$link_start);
	?>
	<script>
	    window.location = "<?php print $list; ?>";
	</script>
      <? } ?>


  <!--<table>
    <tr><th>Result</th><th>Page Type</th><th>Domain</th><th>Species</th></tr>
  -->  <?php print $search_results; ?>
  <!--</table>-->
  <?php print $pager; ?>
</div>

<?php else : ?>
  <h2><?php print t('Your search yielded no results');?></h2>
  <?php print search_help('search#noresults', drupal_help_arg()); ?>
<?php endif; ?>
