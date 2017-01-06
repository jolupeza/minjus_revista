<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Script required for extra functionality on the comment form -->
    <?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php $options = get_option('revista_custom_settings'); ?>

    <header class="Header">
      <aside class="Header-top">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <h2 class="Header-portal h5">
                <a href="https://www.minjus.gob.pe/" target="_blank" rel="noopener noreferrer">Minjus Portal</a>
              </h2>
            </div><!-- end col-sm-6 -->
            <div class="col-sm-6">
              <?php if (isset($options['display_social_link']) && $options['display_social_link']) : ?>
                <nav class="Header-navTop text-right">
                  <ul class="Header-navTop-list list-inline">
                    <li><a href="#">Mapa de Sitio</a></li>

                    <?php if (!empty($options['facebook'])) : ?>
                      <li class="Social Social--fb">
                        <a class="text-hide" href="<?php echo $options['facebook']; ?>" title="Ir a Facebook" target="_blank" rel="noopener noreferrer">Facebook</a>
                      </li>
                    <?php endif; ?>

                    <?php if (!empty($options['twitter'])) : ?>
                      <li class="Social Social--tw">
                        <a class="text-hide" href="<?php echo $options['twitter']; ?>" title="Ir a Twitter" target="_blank" rel="noopener noreferrer">Twitter</a>
                      </li>
                    <?php endif; ?>

                    <?php if (!empty($options['youtube'])) : ?>
                      <li class="Social Social--you">
                        <a class="text-hide" href="<?php echo $options['youtube']; ?>" title="Ir a Youtube" target="_blank" rel="noopener noreferrer">Youtube</a>
                      </li>
                    <?php endif; ?>
                  </ul><!-- end Haeder-navTop-list -->
                </nav><!-- end Header-navTop -->
              <?php endif; ?>
            </div><!-- end col-sm-6 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </aside><!-- end Haeder-rop -->

      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <?php
              $custom_logo_id = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img class="img-responsive" src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>" />
              </a>
            </h1><!-- end Header-logo -->
          </div><!-- end col-md-8 -->
          <div class="col-md-4">
            <?php if (!is_search() && !is_page('buscador')) : ?>
              <?php get_search_form(); ?>
            <?php endif; ?>
          </div><!-- end col-md-4 -->
        </div><!-- end row -->
      </div><!-- end container -->

      <?php
        $args = [
          'theme_location' => 'main-menu',
          'container' => 'nav',
          'container_class' => 'Header-mainMenu text-center',
          'menu_class' => 'Header-mainMenu-list list-inline'
        ];
        wp_nav_menu($args);
      ?>
    </header><!-- end Header -->
