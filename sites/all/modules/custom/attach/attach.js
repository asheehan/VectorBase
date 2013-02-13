var EJS = EJS || {};
EJS.attach = EJS.attach || [];

(function ($) {

Drupal.behaviors.attach = {
  attach: function (context, settings) {
    $(".attach-node-poll:not(.attach-processed)", context).each(function() {
      $(this)
        .load(EJS.attach[$(this).attr('id')])
        .addClass('attach-processed');
    });
  }
};

})(jQuery);

