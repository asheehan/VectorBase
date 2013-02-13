(function ($) {
	$(document).ready(function () {
		$('#edit-jobid').bind('DOMNodeInserted DOMNodeRemoved DOMSubtreeModified', function(event) {
			// node insterted. there must have been a job sumbitted.
			// get the status and update status div
		    if (event.type == 'DOMNodeInserted') {
				$('#edit-status').load('/sites/all/modules/xgrid/status.php?id='+$('#edit-jobid').text());
//				if($('#edit-status').text() != "Finished"){
//				}else if($('#edit-status').text() == "Finished"){
//					$('#edit-result').load('/sites/all/modules/xgrid/results.php?id='+$('#edit-jobid').text());
//				}
		    }
		});

		$('#edit-status').bind('DOMNodeInserted DOMNodeRemoved DOMSubtreeModified', function(event) {
			if($('#edit-status').text() != "Finished"){
			    $('#edit-status').load('/sites/all/modules/xgrid/status.php?id='+$('#edit-jobid').text());
			}else if($('#edit-status').text() == "Finished"){
			    //$('#edit-result').load('/sites/all/modules/xgrid/results.php?id='+$('#edit-jobid').text());
			    $('#edit-result').html('<a href="/sites/all/modules/xgrid/results.php?id='+$('#edit-jobid').text()+'">View Raw Results</a>');
			}
		});

	});
})(jQuery);