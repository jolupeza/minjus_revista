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

    // FormValidation Send Article
    j('#js-form-send-article').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv   = j(e.target).data('formValidation');

      var email = j('input[name="email"]').val(),
          post = j('input[name="post"]').val();

      var msg = j('#js-form-send-article-msg'),
          loader = j('#js-form-send-article-loader');

      loader.removeClass('hidden').find('span').addClass('infinite');
      msg.removeClass('alert-danger alert-success').text('');

      j.post(RevistaAjax.url, {
        nonce: RevistaAjax.nonce,
        action: 'send_article',
        email: email,
        post: post
      }, function(data) {
        $form.data('formValidation').resetForm(true);

        msg.removeClass('hidden')
        if(data.result) {
          msg.addClass('alert-success').text('Se envió correctamente el enlace al artículo seleccionado.');
        } else {
          msg.addClass('alert-danger').text(data.error);
        }

        loader.addClass('hidden').find('span').removeClass('infinite');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).addClass('hidden').text('');
          });
        }, 5000);
      }, 'json').fail(function(){
        loader.addClass('hidden').find('span').removeClass('infinite');
        $form.data('formValidation').resetForm(true);

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });
  });
})(jQuery);
