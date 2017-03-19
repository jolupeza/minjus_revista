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
      <button class="Header-navToggle js-toggle-slidebar">
        <i class="Icon"></i>
      </button>

      <aside class="Header-top hidden-xs">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <h2 class="Header-portal h5">
                <a href="https://www.minjus.gob.pe/" target="_blank" rel="noopener noreferrer">Minjus Portal</a>
              </h2>
            </div><!-- end col-sm-6 -->
            <div class="col-sm-6">
              <?php if (isset($options['display_social_link']) && $options['display_social_link']) : ?>
                <div class="Header-navTop text-right">
                  <?php
                    $args = [
                      'theme_location' => 'top-menu',
                      'container' => 'nav',
                      'container_class' => 'Header-navTop-wrapper',
                      'menu_class' => 'Header-navTop-list list-inline'
                    ];
                    wp_nav_menu($args);
                  ?>

                  <nav class="Header-navTop-wrapper">
                    <ul class="Header-navTop-list Header-navTop-list--noLastBorder list-inline">
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
                  </nav>
                </div><!-- end Header-navTop -->
              <?php endif; ?>
            </div><!-- end col-sm-6 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </aside><!-- end Haeder-rop -->

      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-7 col-xs-9">
            <?php
              $custom_logo_id = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
              $logoResponsive = (isset($options['logo_responsive']) && !empty($options['logo_responsive'])) ? $options['logo_responsive'] : IMAGES . '/logo-responsive.png';
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img class="img-responsive hidden-xs" src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>" />
                <img class="img-responsive visible-xs-block" src="<?php echo $logoResponsive; ?>" alt="">
              </a>
            </h1><!-- end Header-logo -->
          </div><!-- end col-md-8 -->
          <div class="col-md-4 col-sm-5 col-xs-3 hidden-xs">
            <?php /* if (!is_search() && !is_page('buscador')) : ?>
              <?php get_search_form(); ?>
            <?php endif; */?>
          </div><!-- end col-md-4 -->
        </div><!-- end row -->
      </div><!-- end container -->

      <?php
        $args = [
          'theme_location' => 'main-menu',
          'container' => 'nav',
          'container_class' => 'Header-mainMenu text-center hidden-xs',
          'menu_class' => 'Header-mainMenu-list list-inline'
        ];
        wp_nav_menu($args);
      ?>
    </header><!-- end Header -->

    <section class="Slidebar">
      <aside class="Slidebar-close js-toggle-slidebar">
        <i class="glyphicon glyphicon-remove"></i>
      </aside><!-- end Slidebar-close -->

      <?php
        $args = [
          'theme_location' => 'main-menu',
          'container' => 'nav',
          'container_class' => 'Slidebar-nav text-center',
          'menu_class' => 'Slidebar-list'
        ];
        wp_nav_menu($args);
      ?>

      <?php
        $args = [
          'theme_location' => 'top-menu',
          'container' => 'nav',
          'container_class' => 'Slidebar-navLogin text-center',
          'menu_class' => 'Slidebar-navLogin-list list-inline'
        ];
        wp_nav_menu($args);
      ?>

      <?php if (isset($options['display_social_link']) && $options['display_social_link']) : ?>
        <nav class="Slidebar-navSocial">
          <ul class="Slidebar-navSocial-list">
            <?php if (!empty($options['facebook'])) : ?>
              <li class="Social Social--fb">
                <a href="<?php echo $options['facebook']; ?>" title="Ir a Facebook" target="_blank" rel="noopener noreferrer"><i class="icon-facebook"></i></a>
              </li>
            <?php endif; ?>
            <?php if (!empty($options['twitter'])) : ?>
              <li class="Social Social--tw">
                <a href="<?php echo $options['twitter']; ?>" title="Ir a Twitter" target="_blank" rel="noopener noreferrer"><i class="icon-twitter"></i></a>
              </li>
            <?php endif; ?>
            <?php if (!empty($options['youtube'])) : ?>
              <li class="Social Social--you">
                <a href="<?php echo $options['youtube']; ?>" title="Ir a Youtube" target="_blank" rel="noopener noreferrer"><i class="icon-youtube"></i></a>
              </li>
            <?php endif; ?>
          </ul><!-- end Haeder-navTop-list -->
        </nav><!-- end Header-navTop -->
      <?php endif; ?>
    </section><!-- end Slidebar -->
