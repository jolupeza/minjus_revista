'use strict';

var j = jQuery.noConflict();

(function($) {
  var $win = j(window),
      $doc = j(document),
      body = j('body');

  $win.on('resize', function(){
    if (map) {
      var $map = j('#map');
      if ($map.length) {
        var lat = parseFloat($map.data('lat')),
            long = parseFloat($map.data('long'));

        map.setCenter({lat: lat, lng: long});
      }
    }
  });

  $doc.on('ready', function() {
    body.on('click', '#js-nav-team ul li a', function(ev) {
      ev.preventDefault();

      var $this = j(this),
          page = $this.text();

      if ( page === '»' || page === '«' ) {
        j("#js-nav-team .page-numbers li").each( function(index, el) {
          if ( j(this).find('span.current').length ) {
            var current = parseInt(j(this).find('span.current').text());

            page = (page === '»') ? current + 1 : current - 1;
            return false;
          }
        });
      }

      var url = $this.attr("href");
      url = url.replace("http://", "");

      var loader = j('.Page-loader'),
          wrapper = j('.Page-team');

      loader.removeClass('hidden').find('.animated').addClass('infinite');

      j.post(RevistaAjax.url, {
        nonce: RevistaAjax.nonce,
        action: 'get_team',
        page: page
      }, function(data, textStatus, xhr) {
        loader.addClass('hidden').find('.animated').removeClass('infinite');

        if (data.result) {
          wrapper.html(data.data.content);
        } else if (data.error.length) {
          var text = '<div class="alert alert-danger text-center" role="alert">' + data.error + '</div>';
          wrapper.html(text);
        }
      }, 'json').fail(function(){
        loader.addClass('hidden').find('.animated').removeClass('infinite');

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });
  });
})(jQuery);
