(function ($) {
	$(document).ready(function () {

		// Capture the click event on a data file (download) to keep track of how many times it is downloaded.	
		$("disable.data-file-download-link").live("click", function (event) {
	 	
			/*var hrefVar = '#';	
			$.ajaxSetup({
				beforeSend: function() {
					hrefVar = $(".data-file-download-link").attr("href");
					$(".data-file-download-link").attr("href", "#");
				},

				complete: function() {
					$(".data-file-download-link").attr("href", hrefVar);
				}

			});*/
	
			// POST the Data file's node id and version id to the one-up script on the server. 
			$.ajax({
				type: "POST",
				data: 'nodeId=' + $(this).attr("nid") + '&versionId=' + $(this).attr("vid"),
				url: "/sites/all/modules/custom/downloadable_file/include/incrementFileDownloadCount.php",
				error: function() {
 					console.log(arguments);
				},
				success: function() {
					console.log(arguments);
				}
			});


		 });
	});

})(jQuery);

