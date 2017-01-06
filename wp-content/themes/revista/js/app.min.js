'use strict';

var j = jQuery.noConflict();

(function($){
  var $doc = j(document);

  $doc.on('ready', function(){
    j('#accordion-politics').on('show.bs.collapse', function(ev) {
      var panelCollapse = j(ev.target),
          panelHeading = panelCollapse.prev(),
          panelHeadings = panelCollapse.parent().parent().find('.panel-heading');

      panelHeadings.each(function(index, el) {
        j(el).removeClass('active');
      });
      panelHeading.addClass('active');
    });

    j('#accordion-politics').on('hide.bs.collapse', function(ev) {
      var panelCollapse = j(ev.target),
          panelHeading = panelCollapse.prev();

      if (panelCollapse.hasClass('in')) {
        panelHeading.removeClass('active');
      }
    });
  });
})(jQuery);
