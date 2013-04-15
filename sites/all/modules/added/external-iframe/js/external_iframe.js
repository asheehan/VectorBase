/* $Id$ */
(function ($) {

  Drupal.behaviors.externanaliFrame = {
    attach: function(context, settings) {
      // Set iframe height 
        function resizeframe() { 
        var buffer = $('#external-container').height();
        var newHeight = $(window).height();
        var newFrameHeight = newHeight - buffer;
        $('#external-site-container').css('height', newFrameHeight);
      }
      $(window).resize(function() {
        resizeframe();
      });
      $(window).load(function() {
        resizeframe();  
      });

    // Rewrite external links
      var appendUrl = Drupal.settings.basePath + 'external?url=';
      var http_host = location.hostname.split('.');
      if (http_host.length == 3) {
        var host = http_host[1] + '.' + http_host[2];
      } else if (http_host.length == 2) {
        var host = http_host[0] + '.' + http_host[1];
      } else if (http_host.length == 1) {
        var host = http_host[0];
      } 
      $('a[href^=http:]:not(.external-nofollow)').each(
        function(){
          if(this.href.indexOf(host) == -1 && location.pathname.indexOf('external') == -1) { 
            $(this).attr('href', function() {
              var currentUrl = $(this).attr('href');
              var newUrl = appendUrl + currentUrl;
              $(this).attr('href', newUrl);
            });
          }
        });
       // End of module code
    }
  };

})(jQuery);
