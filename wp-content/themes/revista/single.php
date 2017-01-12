<?php get_header(); ?>

<figure class="Page-figure">
  <img class="img-responsive center-block hidden-xs" src="<?php echo IMAGES; ?>/archivosbg.jpg" alt="" />
  <h2 class="Title Title--white">Publicaciones</h2>
</figure><!-- end Page-figure -->

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $values = get_post_custom(get_the_id());
      $pdf = isset( $values['mb_pdf'] ) ? esc_attr($values['mb_pdf'][0]) : '';
      $publication = isset($values['mb_publication']) ? (int)esc_attr($values['mb_publication'][0]) : '';
      $author = isset($values['mb_author']) ? esc_attr($values['mb_author'][0]) : '';

      if (!empty($publication)) {
        $publication = get_post($publication);
      }
    ?>

    <section class="Page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="Breadcrumb">
              <li class="item-home">
                <a class="bread-link bread-home" href="<?php echo home_url(); ?>" title="Inicio">Inicio</a>
              </li>
              <li class="separator separator-home">/</li>
              <li class="item-cat item-custom-post-type-publications">
                <a class="bread-cat bread-custom-post-type-publications" href="<?php echo home_url('archivos'); ?>" title="Archivos">Archivos</a>
              </li>
              <li class="separator">/</li>
              <li class="item-single item-custom-post-type-publications">
                <a class="bread-single bread-custom-post-type-publications" href="<?php echo get_permalink($publication->ID); ?>"><?php echo $publication->post_title; ?></a>
              </li>
              <li class="separator">/</li>
              <li class="item-current item-<?php echo get_the_id(); ?>">
                <strong class="bread-current bread-<?php echo get_the_id(); ?>"><?php the_title(); ?></strong></li>
            </ul>
          </div>
          <div class="col-md-9 Page-bdr">
            <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>
            <?php if (!empty($author)) : ?>
              <h4 class="Subtitle"><?php echo $author; ?></h4>
            <?php endif; ?>

            <h4 class="helvMedium Subtitle">Resumen</h4>
            <?php the_content(); ?>
          </div><!-- end col-md-9 -->

          <div class="col-md-3">
            <aside class="Sidebar">
              <?php if (!empty($pdf)) : ?>
                <p class="Page-button">
                  <a href="<?php echo $pdf; ?>" class="Button Button--red">ver artículo completo PDF</a>
                </p>
              <?php endif; ?>

              <?php get_search_form(); ?>

              <?php get_sidebar(); ?>

            </aside><!-- end Sidebar -->
          </div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>

<?php
  $filepath = TEMPLATEPATH . '/includes/contribute.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
