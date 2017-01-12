'use strict';

var j = jQuery.noConflict();

(function($){
  var $doc = j(document),
      $win = j(window),
      body = j('body');

  function checkHeaderResponsive () {
    var slider = j('.Carousel--home'),
        header = j('.Header');

    if (slider.length && $win.width() < 768) {
      header.addClass('Header--transparent');
    }
  }

  function headerResponsive () {
    var slider = j('.Carousel--home'),
        header = j('.Header');

    if (slider.length && $win.width() < 768) {
      var limit = slider.outerHeight(true) - header.outerHeight(true);

      if ($win.scrollTop() > limit) {
        header.removeClass('Header--transparent');
      } else {
        header.addClass('Header--transparent');
      }
    }
  }

  $win.on('scroll', function () {
    headerResponsive();
  });

  $win.on('resize', function(){
    headerResponsive();
  });

  $doc.on('ready', function(){
    checkHeaderResponsive();

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

    j('.js-toggle-slidebar').on('click', function(ev) {
      ev.preventDefault();
      var slidebar = j('.Slidebar');

      if (slidebar.hasClass('active')) {
        slidebar.removeClass('active');
      } else {
        slidebar.addClass('active');
      }
    });

    j('.Slidebar-list li').each(function(index, el) {
      var $this = j(this);

      if ($this.hasClass('js-more')) {
        $this.append('<i class="glyphicon glyphicon-triangle-bottom js-slidebar-nav-more"></i>');
      }
    });

    body.on('click', '.js-slidebar-nav-more', function(){
      var $this = j(this);

      if ($this.hasClass('active')) {
        $this.removeClass('glyphicon-triangle-top active').addClass('glyphicon-triangle-bottom').prev().removeClass('active');
      } else {
        $this.removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active').prev().addClass('active');
      }
    });

    // Swipe carousel bootstrap
    j(".carousel").swipe({
      swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
        if (direction == 'left') $(this).carousel('next');
        if (direction == 'right') $(this).carousel('prev');
      },
      allowPageScroll:"vertical"
    });
  });
})(jQuery);
