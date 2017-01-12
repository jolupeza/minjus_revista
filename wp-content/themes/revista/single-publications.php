<?php get_header(); ?>

<figure class="Page-figure">
  <img class="img-responsive center-block hidden-xs" src="<?php echo IMAGES; ?>/archivosbg.jpg" alt="" />
  <h2 class="Title Title--white">Publicaciones</h2>
</figure><!-- end Page-figure -->

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <section class="Page Page--nopdbt">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php custom_breadcrumbs(); ?>

            <?php
              $values = get_post_custom(get_the_id());
              $pdf = isset( $values['mb_pdf'] ) ? esc_attr($values['mb_pdf'][0]) : '';
              $index = (isset($values['mb_index'])) ? $values['mb_index'][0] : '';
            ?>
            <section class="LastFile">
              <div class="row">
                <div class="col-sm-4">
                  <?php if (has_post_thumbnail()) : ?>
                    <figure>
                      <?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
                    </figure>
                  <?php endif; ?>
                </div>
                <div class="col-sm-8">
                  <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>
                  <?php the_content(); ?>

                  <?php if (!empty($pdf)) : ?>
                    <p class="Page-button">
                      <a href="<?php echo $pdf; ?>" class="Button Button--red" target="_blank" rel="noopener noreferrer">ver revista PDF ></a>
                    </p>
                  <?php endif; ?>
                </div>
              </div><!-- end row -->
            </section><!-- end LastFile -->

            <hr>

            <?php if (!empty($index)) : ?>
              <h3 class="Title Title--red Title--bdb Title--bdbGray">Índice de contenido</h3>

              <article class="Sections">
                <?php echo $index; ?>
              </article>
            <?php endif; ?>
          </div><!-- end col-md-12 -->
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
