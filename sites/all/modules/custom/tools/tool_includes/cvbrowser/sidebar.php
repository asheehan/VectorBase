<div id="ols_left_column" class="search1" style="width: 150px; min-height: 400px;">
  <div class="search1" style="width: 148px;" id="sidebarTitle" name="sidebarTitle">
  </div>
  <div class="search1" style="width: 148px;">
    <form id="ols_select_form" name="ols_select_form" onsubmit="return false;" style="width: 100%">
	Please choose an ontology:<br>
      <select id="ols_select_sel" name="ols_select_sel" class="small" style="width: 150px; max-width: 150px;" onchange="cvSelected(this);">
        <?php
            include("CvIdConstants.php");
            printForSidebar();
        ?>
      </select>
    </form>
  </div>
<!--  <div class="search1" style="width: 148px;">
    <div id="ols_autocomplete" style="width: 100%;">
      <div id="ols_search" class="yui-b">
        <form id="ols_search_form" name="ols_search_form" onsubmit="return false;" autocomplete="off" style="max-width: 100%;">
2) Browse the tree directly or type in a term to search within this ontology<br>
          <input maxlength=64 id="ols_search_box" name="ols_search_box" class="small" type="text" disabled="true" style="display:inline;"></input>
          <input id="ols_submit_button" class="small" style="max-width: 50px;" type="submit" disabled="true" value="Go" style="display:inline"></input>
        </form>
        <div id="ols_search_div"></div>
        <div id="results_div" style="font-weight: bold; min-height: 150px; border: 1px;"></div>
      </div>
    </div>
  </div> --> 
    <div id="ols_history_box" name="ols_history" class="search1" style="width: 148px; padding-top: 30px;">
        <div id="ols_history_name" name="ols_history_name"class="search1" style="width: 100%">
            History:
        </div>
        <div id="ols_history" name="ols_history" class="search1" style="width:100%"></div>
</div>
