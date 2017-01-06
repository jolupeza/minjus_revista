<?php
  /*
   *  Template Name: Page Normas
   */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-figure">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
        <h2 class="Title Title--white"><?php the_title(); ?></h2>
      </figure><!-- end Page-figure -->

      <section class="Page Page--editor">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php custom_breadcrumbs(); ?>

              <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>

              <?php the_content(); ?>

              <?php
                $values = get_post_custom(get_the_id());
                $files = isset($values['mb_files']) ? $values['mb_files'][0] : '';

                if (!empty($files)) :
                  $files = unserialize($files);
                  $pdf = $files[0];
              ?>
                  <p class="Page-button">
                    <a href="<?php echo $pdf; ?>" class="Button Button--white Button--white--bd" target="_blank" rel="noopener noreferrer">descargar versión PDF ></a>
                  </p>
              <?php endif; ?>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Welcome -->
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
