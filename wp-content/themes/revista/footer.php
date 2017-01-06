    <?php $options = get_option('revista_custom_settings'); ?>

    <section class="Prefooter">
      <div class="container">
        <div class="row">
          <?php $locations = get_nav_menu_locations(); ?>
          <div class="col-md-4">
            <?php
              $menuLeft = 'footer-left-menu';

              if (array_key_exists($menuLeft, $locations)) :
                $menuId = $locations[$menuLeft];
                $menuObject = wp_get_nav_menu_object($menuId);

                if (is_object($menuObject)) :
            ?>
                <h3 class="h4 Subtitle white text-uppercase"><?php echo $menuObject->name; ?></h3>

                <?php
                  $args = [
                    'theme_location' => $menuLeft,
                    'menu_class' => 'Prefooter-list'
                  ];
                  wp_nav_menu($args);
                ?>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <div class="col-md-4">
            <h3 class="h4 Subtitle white text-uppercase">Contacto e información</h3>
            <h5 class="white text-uppercase">Ministerio de Justicia y Derechos Humanos</h5>
            <ul class="Prefooter-list Prefooter-list--icons">
              <?php if (!empty($options['address'])) : ?>
                <li><i class="Icon glyphicon glyphicon-pushpin"></i>Dirección: <?php echo $options['address']; ?></li>
              <?php endif; ?>
              <?php if (!empty($options['reception'])) : ?>
                <li><i class="Icon glyphicon glyphicon-duplicate"></i>Mesa de partes: <?php echo $options['reception']; ?></li>
              <?php endif; ?>
              <?php if (!empty($options['phone'])) : ?>
                <li><i class="Icon glyphicon glyphicon-earphone"></i>Central telefónica: <?php echo $options['phone']; ?></li>
              <?php endif; ?>
              <?php if (!empty($options['email_contact'])) : ?>
                <li><i class="Icon glyphicon glyphicon-envelope"></i> <?php echo $options['email_contact']; ?></li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="col-md-4">
            <?php
              $menuName = 'footer-links-menu';

              if (array_key_exists($menuName, $locations)) :
                $menuId = $locations[$menuName];
                $menuObject = wp_get_nav_menu_object($menuId);

                if (is_object($menuObject)) :
            ?>
                <h3 class="h4 Subtitle white text-uppercase"><?php echo $menuObject->name; ?></h3>

                <?php
                  $args = [
                    'theme_location' => $menuName,
                    'menu_class' => 'Prefooter-list'
                  ];
                  wp_nav_menu($args);
                ?>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <footer class="Footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <p class="white">Copyright &copy; Ministerio de Justicia y Derechos Humanos del Perú. Todos los derechos reservados.</p>
          </div>
          <div class="col-md-4">
            <?php $logoFooter = (isset($options['logo_footer']) && !empty($options['logo_footer'])) ? $options['logo_footer'] : IMAGES . '/logo-footer.jpg'; ?>
            <p class="text-center">
              <a href="https://www.minjus.gob.pe/" target="_blank" rel="noopener noreferrer">
                <img class="img-responsive center-block" src="<?php echo $logoFooter; ?>" alt="" />
              </a>
            </p>
          </div>
          <div class="col-md-4">

          </div>
        </div>
      </div>
    </footer>

    <script>
      var _root_ = '<?php echo home_url(); ?>';
    </script>

    <script>
      var map, marker, infowindow;
    </script>

    <?php wp_footer(); ?>

    <?php
      if (is_page_template('page-contact.php')) :
        $lat = $options['latitud'];
        $long = $options['longitud'];
    ?>

      <?php
        if (!empty($lat) && !empty($long)) :
      ?>
        <script>
          var lat = <?php echo $lat; ?>,
              lon = <?php echo $long; ?>;
          var contentString = '<div id="content" class="Marker">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading Marker-title text-center">MINJUS</h1>'+
                '<div id="bodyContent" class="Marker-body">'+
                '<ul class="Marker-list">'+
                '<li><strong>Dirección: </strong><?php echo $options['address'] ?></li>'+
                '<li><strong>Central Telefónica: </strong><?php echo $options['phone'] ?></li>'+
                '<li><strong>Correo: </strong><?php echo $options['email_contact'] ?></li>'+
                '</ul>'+
                '</div>'+
                '</div>';

          function initMap() {
            var mapCoord = new google.maps.LatLng(lat, lon);

            var opciones = {
              zoom: 16,
              center: mapCoord,
              zoomControl: false,
              mapTypeControl: false,
              streetViewControl: false,
              scrollwheel: false,
            }

            infowindow = new google.maps.InfoWindow({
              content: contentString,
              maxWidth: 300
            });

            map = new google.maps.Map(document.getElementById('map'), opciones);

            marker = new google.maps.Marker({
              position: mapCoord,
              map: map,
              title: 'MINJUS'
            });

            marker.addListener('click', function() {
              infowindow.open(map, marker);
            });
          }
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key= AIzaSyD0D8R7QMdVcU3xEJepn-GzQXYxSR4yQrY&callback=initMap">
        </script>
      <?php endif; ?>
    <?php endif; ?>
  </body>
</html>
