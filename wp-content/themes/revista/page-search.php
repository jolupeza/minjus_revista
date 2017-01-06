<?php
  /*
   *  Template Name: Page Search
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
    <?php endif; ?>
  <?php endwhile; ?>

  <section class="Page">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php custom_breadcrumbs(); ?>

          <?php get_search_form(); ?>

        </div><!-- end col-md-12 -->
      </div><!-- end row -->
    </div><!-- end container -->
  </section><!-- end Welcome -->
<?php endif; ?>

<?php get_footer(); ?>
